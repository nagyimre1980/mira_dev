<?php

//require_once('SimpleXLSXGen.php');
//require_once('function_mysql.php');
require_once('excel_export_reszletes_uj_mysql.php');

use Shuchkin\SimpleXLSXGen;

function excel_export_reszletes($ev, $ho, $tipus)
{
    if (($ho != "all") and ($ho < 10)) {
        $ho_ki = "0" . $ho;
    } else {
        $ho_ki = $ho;
    }

    $date = date("Y_m_d-H_i_s", time());

    if ($tipus == "reszletes") {
        $filename_str = "részletes";
    } else {
        $filename_str = "részletesebb";
    }

    $filename = $GLOBALS['rend_nev'] . " statisztika " . $filename_str . " " . $date . ".xlsx";

    $csv_uft8 = "\xEF\xBB\xBF";
    $elv_oszlop = ';';
    $elv_sor = PHP_EOL;
    $csv_adat = $csv_uft8;

    if ($ho == 'all') {
        $csv = 1;
    } else {
        $csv = 0;
    }

    if ($csv == 1) {
        $filename_csv = $GLOBALS['rend_nev'] . " statisztika " . $filename_str . " " . $date . ".csv";
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . $filename_csv . "\";");
        header("Content-Transfer-Encoding: binary");
        $f = fopen('php://output', 'w');
        fwrite($f, $csv_uft8);
    }

    // A meglévő adatbetöltést lecseréljük a generátorra, de csak az XLSX útvonalon.
    // A CSV útvonal marad az eredeti tömb alapú logikával, ha szükséges.
    // Ha a CSV exportálást is módosítani kell, a $tomb használatát kell felülírni.
    $tomb = keress_stat_rogzitett($ev, $ho, $tipus, "1");

    //mysqli_close($GLOBALS['mysqli']);

    $i = 0;
    $header_row = [];
    if ($csv == 1) {
        // CSV Fejléc
        $header_row[] = 'Név';
        $header_row[] = 'AD azonosító';
        $header_row[] = 'Törzsszám';
        if ($tipus == "reszletes2") {
            $header_row[] = 'Email cím';
        }
        $header_row[] = 'Szervezet';
        $header_row[] = 'Statisztika költséghely';
        $header_row[] = 'AD költséghely';
        $header_row[] = 'Tevékenység neve';
        if ($tipus == "reszletes2") {
            $header_row[] = 'Társasági SAP kód';
            $header_row[] = 'Szervezeti szolgáltatás kód';
            $header_row[] = 'Tevékenységek szolgáltatás kód';
            $header_row[] = 'Aktuális szolgáltatás kód';
            $header_row[] = 'SM SAP kód';
            $header_row[] = 'CO Objektum';
        }
        $header_row[] = 'Dátum';
        if ($tipus == "reszletes2") {
            $header_row[] = 'Hónap';
        }
        $header_row[] = 'Rögzített munkaidő';
        if ($tipus == "reszletes2") {
            $header_row[] = 'Rögzített munkaidő - egészszám';
            $header_row[] = 'Rögzített munkaidő - óra';
            $header_row[] = 'Rögzített munkaidő - perc';
        }
        if (tavollet_lathato_e($ev, $ho)) {
            $header_row[] = 'Távollét';
        }
        if ($tipus == "reszletes2") {
            $header_row[] = 'Rögzítés ideje';
            $header_row[] = 'Rögzítő megjegyzése';
            $header_row[] = 'Rögzítő tevékenység megjegyzése';
            $header_row[] = 'Rögzítő helyettes-e';
            $header_row[] = 'Rögzítő helyettes neve';
            $header_row[] = 'Lezárva';
            $header_row[] = 'Lezárás ideje';
            $header_row[] = 'Lezáró jóváhagyó-e';
            $header_row[] = 'Lezáró jóváhagyó neve';
            $header_row[] = 'Projekt jóváhagyó által visszaküldve';
            $header_row[] = 'Projekt jóváhagyó visszaküldő';
            $header_row[] = 'Projekt jóváhagyó visszaküldés ideje';
            $header_row[] = 'Projekt jóváhagyás';
            $header_row[] = 'Projekt jóváhagyó';
            $header_row[] = 'Projekt jóváhagyás ideje';
            $header_row[] = 'Szervezet által visszaküldve';
            $header_row[] = 'Szervezeti visszaküldő';
            $header_row[] = 'Szervezet visszaküldés ideje';
            $header_row[] = 'Szervezeti jóváhagyás';
            $header_row[] = 'Szervezeti jóváhagyó';
            $header_row[] = 'Szervezeti jóváhagyás ideje';
        }

        foreach ($header_row as $s_adat) {
            fwrite($f, $s_adat . $elv_oszlop);
        }
        fwrite($f, $elv_sor);
        unset($header_row);

    } else {
        // XLSX fejléc
        $header_row[] = '<b>Név</b>';
        $header_row[] = '<b>AD azonosító</b>';
        $header_row[] = '<b>Törzsszám</b>';
        if ($tipus == "reszletes2") {
            $header_row[] = '<b>Email cím</b>';
        }
        $header_row[] = '<b>Szervezet</b>';
        $header_row[] = '<b>Statisztika költséghely</b>';
        $header_row[] = '<b>AD költséghely</b>';
        $header_row[] = '<b>Tevékenység neve</b>';
        if ($tipus == "reszletes2") {
            $header_row[] = '<b>Társasági SAP kód</b>';
            $header_row[] = '<b>Szervezeti szolgáltatás kód</b>';
            $header_row[] = '<b>Tevékenységek szolgáltatás kód</b>';
            $header_row[] = '<b>Aktuális szolgáltatás kód</b>';
            $header_row[] = '<b>SM SAP kód</b>';
            $header_row[] = '<b>CO Objektum</b>';
        }
        $header_row[] = '<b>Dátum</b>';
        if ($tipus == "reszletes2") {
            $header_row[] = '<b>Hónap</b>';
        }
        $header_row[] = "<b>Rögzített munkaidő</b>";
        if ($tipus == "reszletes2") {
            $header_row[] = '<b>Rögzített munkaidő - egészszám</b>';
            $header_row[] = '<b>Rögzített munkaidő - óra</b>';
            $header_row[] = '<b>Rögzített munkaidő - perc</b>';
        }
        if (tavollet_lathato_e($ev, $ho)) {
            $header_row[] = '<b>Távollét</b>';
        }
        if ($tipus == "reszletes2") {
            $header_row[] = '<b>Rögzítés ideje</b>';
            $header_row[] = '<b>Rögzítő megjegyzése</b>';
            $header_row[] = '<b>Rögzítő tevékenység megjegyzése</b>';
            $header_row[] = '<b>Rögzítő helyettes-e</b>';
            $header_row[] = '<b>Rögzítő helyettes neve</b>';
            $header_row[] = '<b>Lezárva</b>';
            $header_row[] = '<b>Lezárás ideje</b>';
            $header_row[] = '<b>Lezáró jóváhagyó-e</b>';
            $header_row[] = '<b>Lezáró jóváhagyó neve</b>';
            $header_row[] = '<b>Projekt jóváhagyó által visszaküldve</b>';
            $header_row[] = '<b>Projekt jóváhagyó visszaküldő</b>';
            $header_row[] = '<b>Projekt jóváhagyó visszaküldés ideje</b>';
            $header_row[] = '<b>Projekt jóváhagyás</b>';
            $header_row[] = '<b>Projekt jóváhagyó</b>';
            $header_row[] = '<b>Projekt jóváhagyás ideje</b>';
            $header_row[] = '<b>Szervezet által visszaküldve</b>';
            $header_row[] = '<b>Szervezeti visszaküldő</b>';
            $header_row[] = '<b>Szervezet visszaküldés ideje</b>';
            $header_row[] = '<b>Szervezeti jóváhagyás</b>';
            $header_row[] = '<b>Szervezeti jóváhagyó</b>';
            $header_row[] = '<b>Szervezeti jóváhagyás ideje</b>';
        }

        // Itt inicializáljuk az XLSX generátort és hozzáadjuk a fejlécet
        $xlsx = SimpleXLSXGen::fromArray([]);
        $xlsx->addRowToCurrentSheet($header_row);

        // A meglévő adat-tömb ciklust lecseréljük a generátorra
        try {
            // A 'generate_rows_from_query' függvénynek a 'function_mysql.php' fájlban kell lennie.
            $rows_generator = gen_keress_stat_rogzitett($ev, $ho, $tipus, "1");
            foreach ($rows_generator as $ert) {
                $row = [];
                $row[] = $ert['user_nev'];
                $row[] = $ert['user_ad'];
                $row[] = $ert['user_tsz'];
                if ($tipus == 'reszletes2') {
                    $row[] = $ert['user_email'];
                }
                $row[] = $ert['szerv_nev'];
                $row[] = $ert['szerv_koltsegkod'];
                $row[] = $ert['szerv_adkod'];
                $row[] = $ert['projekt_nev'];

                if ($tipus == 'reszletes2') {
                    $row[] = $ert['projekt_tagv_kod'];
                    $row[] = $ert['szerv_szolg_kod'];
                    $row[] = $ert['projekt_szolg_kod'];
                    if ($ert['projekt_szolg_kod'] != "") {
                        $row[] = $ert['projekt_szolg_kod'];
                    } else {
                        $row[] = $ert['szerv_szolg_kod'];
                    }
                    $row[] = $ert['szerv_sm_kod'];
                    $row[] = $ert['projekt_co'];
                }

                if ($ert['rogzit_nap'] < 10) {
                    $nap_ki = '0' . $ert['rogzit_nap'];
                } else {
                    $nap_ki = $ert['rogzit_nap'];
                }
                if ($ho_ki == 'all') {
                    $rog_ido_ki = $ev . '-' . $ert['rogzit_ho'] . '-' . $nap_ki;
                } else {
                    $rog_ido_ki = $ev . '-' . $ho_ki . '-' . $nap_ki;
                }
                $row[] = $rog_ido_ki;

                if ($tipus == "reszletes2") {
                    if ($ho_ki == 'all') {
                        $row[] = $ert['rogzit_ho'];
                    } else {
                        $row[] = $ho;
                    }
                }

                if ($ert['projekt_nev'] != '') {
                    $ora = $ert['rogzit_ora'];
                    if ($ert['rogzit_perc'] < 10) {
                        $perc = '0' . $ert['rogzit_perc'];
                    } else {
                        $perc = $ert['rogzit_perc'];
                    }
                    if (($ora == '0') and ($perc == '00')) {
                        $row[] = '0:00';
                    } else {
                        $row[] = $ora . ':' . $perc;
                    }
                } else {
                    $row[] = '';
                }

                if ($tipus == "reszletes2") {
                    $egeszzam_ora = $ert['rogzit_ora'];
                    $egeszzam_ora += $ert['rogzit_perc'] / 60;
                    $row[] = round($egeszzam_ora, 2);
                    $row[] = $ert['rogzit_ora'];
                    $row[] = $ert['rogzit_perc'];
                }

                if (tavollet_lathato_e($ev, $ho)) {
                    if ($ert['tavollet'] == '1') {
                        $row[] = 'Igen';
                    } else {
                        $row[] = '';
                    }
                }

                if ($tipus == 'reszletes2') {
                    if ($ert['tavollet'] == '1') {
                        $row[] = $ert['rogzit_update_time'];
                    } else {
                        $row[] = $ert['rogzit_sor_update_time'];
                    }
                    if (($ert['rogzit_megj'] != '')) {
                        $ert['rogzit_megj'] = str_replace(["\r\n", "\r", "\n"], ' ', $ert['rogzit_megj']);
                    }
                    $row[] = $ert['rogzit_megj'];

                    if (($ert['rogzit_sor_megj'] != '')) {
                        $ert['rogzit_sor_megj'] = str_replace(["\r\n", "\r", "\n"], ' ', $ert['rogzit_sor_megj']);
                    }
                    $row[] = $ert['rogzit_sor_megj'];

                    if ($ert['helyettes_rogzito'] == '1') {
                        $row[] = 'Igen';
                        $row[] = $ert['helyettes_rogzito_ki_nev'];
                    } else {
                        $row[] = '';
                        $row[] = '';
                    }

                    if ($ert['ellenorzesre_lezarva'] == '1') {
                        $row[] = 'Igen';
                        $row[] = $ert['ellenorzesre_lezarva_mikor'];
                    } else {
                        $row[] = '';
                        $row[] = '';
                    }

                    if ($ert['ellenorzesre_lezarva_jovahagyo'] == '1') {
                        $row[] = 'Igen';
                        $row[] = $ert['ellenorzesre_lezarva_jovahagyo_ki_nev'];
                    } else {
                        $row[] = '';
                        $row[] = '';
                    }

                    if ($ert['projekt_jovahagyo_elutasitva'] == '1') {
                        $row[] = 'Igen';
                        $row[] = $ert['projekt_jovahagyo_elutasitva_nev'];
                        $row[] = $ert['projekt_jovahagyo_elutasitva_mikor'];
                    } else {
                        $row[] = '';
                        $row[] = '';
                        $row[] = '';
                    }

                    if ($ert['projekt_jovahagyo_jovahagyva'] == '1') {
                        $row[] = 'Igen';
                        $row[] = $ert['projekt_jovahagyo_jovahagyva_nev'];
                        $row[] = $ert['projekt_jovahagyo_jovahagyva_mikor'];
                    } else {
                        $row[] = '';
                        $row[] = '';
                        $row[] = '';
                    }

                    if ($ert['ellenorzesre_visszakuldve'] == '1') {
                        $row[] = 'Igen';
                        $row[] = $ert['ellenorzesre_visszakuldve_ki_nev'];
                        $row[] = $ert['ellenorzesre_visszakuldve_mikor'];
                    } else {
                        $row[] = '';
                        $row[] = '';
                        $row[] = '';
                    }

                    if ($ert['ellenorzesre_ok'] == '1') {
                        $row[] = 'Igen';
                        $row[] = $ert['ellenorzesre_ok_ki_nev'];
                        $row[] = $ert['ellenorzesre_ok_mikor'];
                    } else {
                        $row[] = '';
                        $row[] = '';
                        $row[] = '';
                    }
                }
                $xlsx->addRowToCurrentSheet($row);
            }
        } catch (Exception $e) {
            die('Hiba történt a lekérdezés során: ' . $e->getMessage());
        }

        $xlsx->downloadAs(rawurlencode($filename));
        //exit();
    }
}
?>