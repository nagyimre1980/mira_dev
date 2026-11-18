<?php



if (tcpdf_v7()) {
			if (!defined('K_TCPDF_EXTERNAL_CONFIG')) {
				define('K_TCPDF_EXTERNAL_CONFIG', true);
			}

			if (!defined('IMAGETYPE_SWC')) {
				define('IMAGETYPE_SWC', 13);
			}

			$gyoker = realpath(__DIR__ . '/..');

			if (!defined('K_ALLOWED_PATHS')) {
				define('K_ALLOWED_PATHS', [
					$gyoker . '/',
				]);
			}

			if (!defined('K_PATH_IMAGES')) {
				define('K_PATH_IMAGES', $gyoker . '/');
			}

			
			if (!defined('K_PATH_FONTS')) {
				define(
					'K_PATH_FONTS',
					__DIR__ . '/'.$pdf_mappa_ver.'/tecnickcom/tc-lib-pdf-font/target/fonts/'
				);
			}



			if (!defined('PDF_FONT_NAME_MAIN')) {
				define('PDF_FONT_NAME_MAIN', 'freeserif');//helvetica freeserif
			}
			if (!defined('PDF_FONT_NAME_DATA')) {
				define('PDF_FONT_NAME_DATA', 'freeserif');
			}
			

			if (!defined('K_THAI_TOPCHARS')) {
				define('K_THAI_TOPCHARS', false);
			}

			//Sajna ettől nem lett kisebb :(
			if (!defined('K_PDF_SUBSET_FONT')) {
				define('K_PDF_SUBSET_FONT', true);
			}
			if (!defined('K_FORCE_FONT_SUBSETTING')) {
				define('K_FORCE_FONT_SUBSETTING', true);
			}
}

function tcpdf_v7(){
    global $pdf_mappa_ver_file;
    return $pdf_mappa_ver_file === 'autoload.php';
}

/** 6.x: px (ahogy eddig), 7.x: mm */
function width_67($px){
	if (tcpdf_v7()) {
        return 'width="'.round($px * 1.35).'px"';
    }
    return 'width="'.$px.'px"';
}

/*
function height_67($px){
    if (tcpdf_v7()) {
        return 'height="'.round($px * 1.35).'px"';
    }
    return 'height="'.$px.'px"';
}
*/

function hgap($px = 22){
    if (!tcpdf_v7()) return '';
    return '<span style="font-size:'.$px.'px;"><br /></span>';
}

function html_tcpdf7_br($html){
    $mentett = array();
    $vedd = function ($m) use (&$mentett) {
        $k = '%%BR'.count($mentett).'%%';
        $mentett[$k] = $m[0];
        return $k;
    };

    $html = preg_replace_callback(
        '/<span[^>]*font-size\s*:\s*\d+\s*px[^>]*>\s*<br\s*\/?>\s*<\/span>/i',
        $vedd,
        $html
    );
    $html = preg_replace_callback(
        '/<br\s+[^>]*font-size\s*:\s*\d+\s*px[^>]*\/?>/i',
        $vedd,
        $html
    );

    $html = preg_replace(
        '/<br\s*\/?>/i',
        '<span style="font-size:10px;"><br /></span>',
        $html
    );

    $html = strtr($html, $mentett);

    // csak a Tárgy 24px-es hézag — az 18px-es Tisztelt Cím marad
    $html = str_replace('font-size:24px', 'font-size:36px', $html);
    $html = str_replace('font-size:18px', 'font-size:24px', $html);

$html = preg_replace(
    '/Tisztelt Cím!(?:<span style="font-size:10px;"><br\s*\/?><\/span>\s*){2}/i',
    'Tisztelt Cím!<span style="font-size:16px;"><br /></span><span style="font-size:16px;"><br /></span>',
    $html
);

    return $html;
}

function html_tcpdf7_width($html){
    // width="180px"  width='180px'  width="180 px"
    $html = preg_replace_callback(
        '/\bwidth\s*=\s*(["\'])(\d+(?:\.\d+)?)\s*px\1/i',
        function ($m) {
            return 'width='.$m[1].round($m[2] * 1.35).'px'.$m[1];
        },
        $html
    );

    // width=180px  (idézőjel nélkül)
    $html = preg_replace_callback(
        '/\bwidth\s*=\s*(\d+(?:\.\d+)?)\s*px\b/i',
        function ($m) {
            return 'width="'.round($m[1] * 1.35).'px"';
        },
        $html
    );

    // width="750"  — nálad van ilyen, px nélkül, de nem %
    $html = preg_replace_callback(
        '/\bwidth\s*=\s*(["\'])(\d+(?:\.\d+)?)\1(?!\s*%)/i',
        function ($m) {
            return 'width='.$m[1].round($m[2] * 1.35).$m[1];
        },
        $html
    );

$html = preg_replace_callback(
    '/style\s*=\s*(["\'])([^"\']*)\1/i',
    function ($m) {
        $st = preg_replace_callback(
            '/\bwidth\s*:\s*(\d+(?:\.\d+)?)\s*px\b/i',
            function ($w) {
                return 'width:'.round($w[1] * 1.05).'px';
            },
            $m[2]
        );
        return 'style='.$m[1].$st.$m[1];
    },
    $html
);
    return $html;
}
?>