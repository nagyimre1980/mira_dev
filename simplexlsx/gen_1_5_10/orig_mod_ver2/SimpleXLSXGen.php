<?php

namespace Shuchkin;

/**
 * Class SimpleXLSXGen
 * Full Streaming Version - AUTO COLUMN WIDTH BASED ON FIRST ROW
 * Author: sergey.shuchkin@gmail.com
 */
class SimpleXLSXGen
{
    public $curSheet;
    protected $defaultFont = 'Calibri';
    protected $defaultFontSize = 10;
    protected $rtl = false;
    protected $sheets = [];
    protected $template = [];
    protected $NF = []; 
    protected $NF_KEYS = [];
    protected $XF = []; 
    protected $XF_KEYS = [];
    protected $SI = []; 
    protected $SI_KEYS = [];

    protected $title, $subject, $author, $company, $manager, $description, $application, $keywords, $category, $language, $lastModifiedBy;

    const N_NORMAL = 0, N_INT = 1, N_DEC = 2, N_PERCENT_INT = 9, N_PRECENT_DEC = 10, N_DATE = 14, N_TIME = 20, N_RUB = 164, N_DOLLAR = 165, N_EURO = 166, N_DATETIME = 22;
    const F_NORMAL = 0, F_HYPERLINK = 1, F_BOLD = 2, F_ITALIC = 4, F_UNDERLINE = 8, F_COLOR = 32;
    const FL_NONE = 0, FL_SOLID = 1, FL_MEDIUM_GRAY = 2, FL_GRAY_125 = 16, FL_COLOR = 32;
    const A_DEFAULT = 0, A_LEFT = 1, A_RIGHT = 2, A_CENTER = 4, A_TOP = 8, A_MIDDLE = 16, A_BOTTOM = 32, A_WRAPTEXT = 64;

    public function __construct()
    {
        $this->title = $this->subject = $this->author = $this->company = $this->manager = $this->description = $this->keywords = $this->category = $this->lastModifiedBy = '';
        $this->language = 'en-US';
        $this->application = __CLASS__;
        $this->curSheet = -1;

        $this->NF = [164 => '#,##0.00\ "₽"', self::N_DOLLAR => '#,##0\ "Ft"', 166 => '#,##0.00\ [$€-1]'];
        $this->NF_KEYS = array_flip($this->NF);

        $this->XF = [
            [self::N_NORMAL, self::A_DEFAULT, self::F_NORMAL, self::FL_NONE, 0, 0, '', 0],
            [self::N_NORMAL, self::A_DEFAULT, self::F_NORMAL, self::FL_GRAY_125, 0, 0, '', 0],
        ];
        $this->XF_KEYS[implode('-', $this->XF[0])] = 0;
        $this->XF_KEYS[implode('-', $this->XF[1])] = 1;

        $this->_initTemplate();
    }

    public static function create($title = null) {
        $xlsx = new static();
        if ($title) $xlsx->setTitle($title);
        return $xlsx;
    }

    public static function fromArray(array $rows, $sheetName = null) {
        $xlsx = new static();
        $xlsx->addSheet($rows, $sheetName);
        if ($sheetName) $xlsx->setTitle($sheetName);
        return $xlsx;
    }

    public function addSheet(array $rows = [], $name = null)
    {
        $this->curSheet++;
        $name = $name ? mb_substr($name, 0, 31) : 'Sheet' . ($this->curSheet + 1);
        $stream = fopen('php://temp', 'r+b');

        $this->sheets[$this->curSheet] = [
            'name' => $name, 'stream' => $stream, 'row_cnt' => 0, 'col_max' => 0,
            'mergecells' => [], 'autofilter' => '', 'frozen' => '', 'colwidth' => []
        ];

        if (!empty($rows)) {
            foreach ($rows as $row) $this->addRowToCurrentSheet($row);
        }
        return $this;
    }

    public function addRowToCurrentSheet(array $row)
    {
        if ($this->curSheet < 0) $this->addSheet();
        $sheet = &$this->sheets[$this->curSheet];
        $sheet['row_cnt']++;
        
        // AUTOMATIKUS SZÉLESSÉG SZÁMÍTÁS AZ ELSŐ SOR ALAPJÁN
        if ($sheet['row_cnt'] === 1) {
            foreach ($row as $col_idx => $v) {
                if (!isset($sheet['colwidth'][$col_idx])) {
                    $clean_text = strip_tags((string)$v);
                    // Egyszerű kalkuláció: karakterek száma + egy kis padding (min 10)
                    $width = max(10, mb_strlen($clean_text) * 1.2 + 2);
                    $this->setColWidth($col_idx, $width);
                }
            }
        }

        $row_xml = '<row r="' . $sheet['row_cnt'] . '">';
        foreach ($row as $col_idx => $v) {
            $sheet['col_max'] = max($sheet['col_max'], $col_idx + 1);
            $cname = self::coord2cell($col_idx) . $sheet['row_cnt'];
            
            if ($v === null || $v === '') {
                $row_xml .= '<c r="' . $cname . '"/>'; continue;
            }

            $ct = $cv = null; $N = $A = $F = $FL = $C = $BG = $FS = 0; $BR = '';
            
            if (is_string($v)) {
                if (strpos($v, '<b>') !== false) $F |= self::F_BOLD;
                if (strpos($v, '<center>') !== false) $A |= self::A_CENTER;
                
                $v = strip_tags($v);
                $ct = 's';
                $skey = '~' . $v;
                if (!isset($this->SI_KEYS[$skey])) {
                    $this->SI[] = self::esc($v);
                    $this->SI_KEYS[$skey] = count($this->SI) - 1;
                }
                $cv = $this->SI_KEYS[$skey];
            } else {
                $cv = $v;
            }

            $xf_key = "$N-$A-$F-$FL-$C-$BG-$BR-$FS";
            if (!isset($this->XF_KEYS[$xf_key])) {
                $this->XF_KEYS[$xf_key] = count($this->XF);
                $this->XF[] = [$N, $A, $F, $FL, $C, $BG, $BR, $FS];
            }
            
            $row_xml .= '<c r="'.$cname.'"'.($ct ? ' t="'.$ct.'"' : '').' s="'.$this->XF_KEYS[$xf_key].'"><v>'.$cv.'</v></c>';
        }
        $row_xml .= '</row>';
        fwrite($sheet['stream'], $row_xml);
        return $this;
    }

    public function setColWidth($col, $width) {
        $this->sheets[$this->curSheet]['colwidth'][(int)$col] = (float)$width;
        return $this;
    }

    public function downloadAs($filename) {
        $fh = fopen('php://memory', 'wb');
        $this->_write($fh);
        $size = ftell($fh);
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . str_replace(["\0","\r","\n","\t",'"'], '', $filename) . '"');
        header('Content-Length: ' . $size);
        while (ob_get_level()) ob_end_clean();
        fseek($fh, 0);
        fpassthru($fh);
        fclose($fh);
        return true;
    }

    protected function _write($fh) {
        $cdrec = ''; $entries = 0;
        foreach ($this->template as $cfilename => $template) {
            if ($cfilename === 'xl/worksheets/sheet1.xml') {
                foreach ($this->sheets as $k => $v) {
                    $fname = 'xl/worksheets/sheet' . ($k + 1) . '.xml';
                    
                    $header = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">';
                    $header .= '<dimension ref="A1:'.self::coord2cell($v['col_max']-1).$v['row_cnt'].'"/>';
                    
                    if ($v['frozen']) {
                        $header .= '<sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="'.$v['frozen'].'" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>';
                    }

                    // FONTOS: A <cols> szekciónak pontosan itt kell lennie!
                    if (!empty($v['colwidth'])) {
                        ksort($v['colwidth']);
                        $header .= '<cols>';
                        foreach ($v['colwidth'] as $col_idx => $width) {
                            $idx = $col_idx + 1;
                            $header .= '<col min="'.$idx.'" max="'.$idx.'" width="'.$width.'" customWidth="1"/>';
                        }
                        $header .= '</cols>';
                    }
                    
                    $header .= '<sheetData>';
                    
                    fseek($v['stream'], 0);
                    $body = stream_get_contents($v['stream']);
                    
                    $footer = '</sheetData>';
                    if ($v['mergecells']) {
                        $footer .= '<mergeCells count="'.count($v['mergecells']).'">';
                        foreach($v['mergecells'] as $m) $footer .= '<mergeCell ref="'.$m.'"/>';
                        $footer .= '</mergeCells>';
                    }
                    $footer .= '</worksheet>';
                    
                    $this->_writeEntry($fh, $cdrec, $fname, $header . $body . $footer);
                    $entries++;
                }
                continue;
            }
            $data = $this->_substitute($cfilename, $template);
            if ($data !== null) { $this->_writeEntry($fh, $cdrec, $cfilename, $data); $entries++; }
        }
        $before_cd = ftell($fh);
        fwrite($fh, $cdrec);
        fwrite($fh, "\x50\x4b\x05\x06" . pack('vvvvVVv', 0, 0, $entries, $entries, strlen($cdrec), $before_cd, 0));
    }

    protected function _substitute($filename, $template) {
        if ($filename === 'xl/sharedStrings.xml') {
            if (!count($this->SI)) return null;
            return str_replace(['{CNT}', '{STRINGS}'], [count($this->SI), '<si><t>'.implode('</t></si><si><t>', $this->SI).'</t></si>'], $template);
        }
        if ($filename === 'xl/workbook.xml') {
            $s = ''; foreach ($this->sheets as $k => $v) $s .= '<sheet name="'.self::esc($v['name']).'" sheetId="'.($k+1).'" r:id="rId'.($k+1).'"/>';
            return str_replace('{SHEETS}', $s, $template);
        }
        if ($filename === 'xl/styles.xml') return $this->_buildStyles($template);
        return $template;
    }

    protected function _buildStyles($template) {
        $fonts = []; $xf_xml = '';
        foreach ($this->XF as $xf) {
            $font_key = ($xf[2] & self::F_BOLD ? 'bold' : 'normal');
            if (!isset($fonts[$font_key])) $fonts[$font_key] = count($fonts);
            $xf_xml .= '<xf numFmtId="'.$xf[0].'" fontId="'.$fonts[$font_key].'" fillId="0" borderId="0" applyFont="1" applyAlignment="1"><alignment horizontal="'.($xf[1] & self::A_CENTER ? 'center' : 'left').'"/></xf>';
        }
        $font_xml = '';
        foreach (array_keys($fonts) as $type) {
            $font_xml .= '<font><name val="'.$this->defaultFont.'"/><sz val="'.$this->defaultFontSize.'"/>'.($type === 'bold' ? '<b/>' : '').'</font>';
        }
        $template = str_replace('{FONTS}', '<fonts count="'.count($fonts).'">'.$font_xml.'</fonts>', $template);
        return str_replace('{XF}', '<cellXfs count="'.count($this->XF).'">'.$xf_xml.'</cellXfs>', $template);
    }

    protected function _writeEntry($fh, &$cdrec, $cfilename, $data) {
        $crc = crc32($data);
        $zdata = zlib_encode($data, ZLIB_ENCODING_RAW, 1);
        $off = ftell($fh);
        $f_len = strlen($cfilename);
        $z_len = strlen($zdata);
        $u_len = strlen($data);
        
        // ZIP Local Header: 11 argumentum (1 signature + 10 params)
        fwrite($fh, pack('VvvvvvVVVvv', 0x04034b50, 20, 0, 8, 0, 0, $crc, $z_len, $u_len, $f_len, 0) . $cfilename . $zdata);
        
        // ZIP Central Directory Header: 17 argumentum (1 signature + 16 params)
        $cdrec .= pack('VvvvvvvVVVvvvvvVV', 0x02014b50, 20, 20, 0, 8, 0, 0, $crc, $z_len, $u_len, $f_len, 0, 0, 0, 0, 32, $off) . $cfilename;
    }

    public static function esc($str) { return str_replace(['&', '<', '>', "\x00"], ['&amp;', '&lt;', '&gt;', ''], $str); }
    public static function coord2cell($x, $y = null) {
        $c = ''; for ($i = $x; $i >= 0; $i = ((int)($i / 26)) - 1) $c = chr(65 + $i % 26) . $c;
        return $c . ($y === null ? '' : ($y + 1));
    }

    protected function _initTemplate() {
        $this->template = [
            '_rels/.rels' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>',
            'xl/workbook.xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets>{SHEETS}</sheets></workbook>',
            'xl/styles.xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">{FONTS}<fills count="1"><fill><patternFill patternType="none"/></fill></fills><borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>{XF}</styleSheet>',
            'xl/worksheets/sheet1.xml' => '',
            'xl/sharedStrings.xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="{CNT}" uniqueCount="{CNT}">{STRINGS}</sst>',
            'xl/_rels/workbook.xml.rels' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/><Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>',
            '[Content_Types].xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="xml" ContentType="application/xml"/><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/><Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/></Types>'
        ];
    }
    public function setTitle($t) { $this->title = $t; return $this; }
}