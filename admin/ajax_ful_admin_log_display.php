<?php

//CCS javaslat
/*
.json-simple { background: #f8f9fa; padding: 12px; border-radius: 6px; }
.table-sm td, .table-sm th { font-size: 0.9rem; }
*/

//egyszerűbb megoldás
function format_log_json_simple($json_string)
{
    if (empty($json_string)) return '<em>nincs adat</em>';
    
    $pretty = json_encode(json_decode($json_string), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return '<pre class="bg-light p-3 border rounded">' . htmlspecialchars($pretty) . '</pre>';
}
/**
 * Szépen formázza a log JSON mezőt – a te saját CSS-edhez igazítva
 */
function format_log_json($json_string, $title = '')
{
    if (empty($json_string)) {
        //return '<em class="text-muted">nincs adat</em>';
        return '';
    }

    $data = json_decode($json_string, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        //return '<pre style="background:#f8f8f8; padding:0px; border:1px solid #ccc; border-radius:4px;">'. htmlspecialchars($json_string) . '</pre>';
        return '<pre">'. htmlspecialchars($json_string) . '</pre>';
    }

    $html = '';

    if ($title) {
        $html .= '<strong>' . htmlspecialchars($title) . '</strong><br>';
    }

    // Tömb (több soros adat) esetén táblázat
    if (is_array($data) && isset($data[0]) && is_array($data[0])) {
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table_emre" style="margin:0px;box-shadow: none !important">';   // a te saját táblázat osztályod
        $html .= '<thead><tr>';

        foreach (array_keys($data[0]) as $key) {
            $html .= '<th style="background:#fff2d0; padding:4px 6px;">' . htmlspecialchars($key) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $value) {
				//padding:4px 6px; 
                $html .= '<td style="height:16px;border:1px solid #81a1ef;">' 
                         . htmlspecialchars((string)$value) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table></div>';
    } 
    // Egyszerű objektum esetén ilyen nem lehet pl: {"zarolo": "1"}
    else {
        //$html .= '<div class="json-simple" style="background:#f8f9fa; padding:10px; border-radius:6px; border:1px solid #b6d0f9; margin-top:4px;">';
        //////////$html .= '<div class="json-simple" style="background:#f8f9fa; padding:0px;margin-top:4px;">';
        foreach ($data as $key => $value) {
            $html .= '<div style="display:flex; margin-bottom:3px;">';
            //$html .= '<div style="width:140px; font-weight:bold; color:#003af3;">' . htmlspecialchars($key) . ':</div>';
            $html .= '<div style="color:#003af3;">' . htmlspecialchars($key) . ':</div>';
            $html .= '<div>' . htmlspecialchars((string)$value) . '</div>';
            $html .= '</div>';
        }
        //$html .= '</div>';
    }

    return $html;
}
/**
 * Két soros vízszintes táblázat a log_hol / log_ertek párokhoz
 * Első sor: mezőnevek (log_hol, log_hol2, log_hol3)
 * Második sor: értékek (log_ertek, log_ertek2, log_ertek3)
 */
function format_log_conditions($ert)
{
    $headers = [];
    $values  = [];

    // 1. pár
    if (!empty($ert['log_hol'])) {
        $headers[] = htmlspecialchars($ert['log_hol']);
        $values[]  = htmlspecialchars((string)($ert['log_ertek'] ?? ''));
    }

    // 2. pár
    if (!empty($ert['log_hol2'])) {
        $headers[] = htmlspecialchars($ert['log_hol2']);
        $values[]  = htmlspecialchars((string)($ert['log_ertek2'] ?? ''));
    }

    // 3. pár
    if (!empty($ert['log_hol3'])) {
        $headers[] = htmlspecialchars($ert['log_hol3']);
        $values[]  = htmlspecialchars((string)($ert['log_ertek3'] ?? ''));
    }

    if (empty($headers)) {
        //return '<em class="text-muted">nincs feltétel</em>';
        return '';
    }

    $html = '<div class="table-responsive">';
    $html .= '<table class="table_emre" style="margin:0px;box-shadow: none !important">';
    
    // Fejléc sor (mezőnevek)
    $html .= '<thead><tr>';
    foreach ($headers as $h) {
        $html .= '<th style="background:#fff2d0; padding:4px 6px;">' 
                 . $h . '</th>';
    }
    $html .= '</tr></thead><tbody>';

    // Érték sor
    $html .= '<tr>';
    foreach ($values as $v) {
		//padding:4px 6px; 
        $html .= '<td style="border:1px solid #81a1ef;">' 
                 . ($v === '' ? '&nbsp;' : $v) . '</td>';
    }
    $html .= '</tr>';

    $html .= '</tbody></table></div>';

    return $html;
} 
?>