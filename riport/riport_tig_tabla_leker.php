<?php

/*
AB	Szerződésmódosítás hatályba lépésének dátuma			szerz_tetel_szolg_mod_date		(régen AA volt)
AC	Szerződésmódosítás vége (határozott esetén dátum)		szerz_tetel_szolg_modveg_date	(régen AB volt)	
AD	Szolgáltatás megszünése - vége dátum					szerz_tetel_vege				(régen AC volt)
AE	Szerződés időtartam eredeti (határozott esetén)			szerz_tetel_szolg_origveg_date	(régen AD volt)
U	Szolgáltásnyújtás megkezdésének időpontja				szerz_tetel_szolg_kezd_date		(régen U volt)

Eleje	AA oszlop az eleje, ha az üres, akkor az U. Első módosítás  kell figyelmbe venni
Vége	AB-AC-AD ilyen sorrendben. Utolsó módosítást kell figyelembe venni
AD-AC-AE

*/

/*
Piros egy sor ID ha: $kezd>$veg
Zöld  egy sor ID ha: U oszlop értéke üres!
*/

function riport_tig_tabla(){

$date=date("Y_m_d-H_i_s",time());
$filename="TIG tábla excel export ".$date.".xlsx";
$xlsx = new Shuchkin\SimpleXLSXGen();

$ev=$_POST['date1_ev'];
$ho_ig=$_POST['date1_ho'];

$GLOBALS['tigtabla_tomb']=keres_riport_tig_tabla();
$GLOBALS['tigtabla_tomb_nemszerz']=keres_riport_tig_tabla_nemszerz_alapjan($ev,$ho_ig);
$GLOBALS['tigtabla_tomb_nemszerz_arfolyam']=keres_riport_tig_tabla_nemszerz_alapjan_arfolyam($ev,$ho_ig);

$xlsx->addSheet(riport_tig_tabla_fo(),'TIG tábla');
$xlsx->addSheet(riport_tig_tabla_dev(),'DEV tábla sor azonosításhoz');

$xlsx->downloadAs(rawurlencode($filename));
}

function riport_tig_tabla_fo(){
$ev=$_POST['date1_ev'];
$ho_ig=$_POST['date1_ho'];

//$style_zar='</style>';
$style_szin1='<style bgcolor="#FFFFCC">';
$style_szin2='<style bgcolor="#F2CEEF">';
$style_szin3='<style bgcolor="#FFFF00">';
$style_szin4='<style bgcolor="#FFCCCC">';
$style_szin5='<style bgcolor="#83CCEB">';
$style_szin6='<style bgcolor="#AEA7E3">';
$style_szin7='<style bgcolor="#F1A983">';
$style_szin8='<style bgcolor="#F1A983" color="#FF0034">';
$style_szin9='<style bgcolor="#156082">';
$style_szin10='<style bgcolor="#FF66FF">';
$style_szin11='<style bgcolor="#C0E6F5" color="#0070D2">';
$style_szin12='<style bgcolor="#B5E6A2">';
$style_szin13='<style bgcolor="#FF99FF">';

$i=0;
$adat[$i][]=$style_szin1."<center><middle><b>Szolgáltatás ID</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>ÉV</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>Hónap</b></middle></center>";

$adat[$i][]=$style_szin1."<center><middle><b>Megrendelő</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>Vevő azonosító</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>Partner kód</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>Szerződés típusa</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>Szerződés MVMS / BSZK</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>Szolgáltatás</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>Szerződés</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>Elszámolás módja</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>Megjegyzés</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>Óra / fő / napi díj</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>MIRA óraszám</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>egyéb naturália db, nap, fő, nm, dm3, stb</b></middle></center>";
$adat[$i][]=$style_szin2."<center><middle><b>db -új oszlop fizigényhez</b></middle></center>";
$adat[$i][]=$style_szin2."<center><middle><b>szerződéses összeg EUR-ban</b></middle></center>";
$adat[$i][]=$style_szin2."<center><middle><b>Hó végi árfolyam</b></middle></center>";
$adat[$i][]=$style_szin1."<center><middle><b>Havi Összeg Forintban\n".($ev-1)."</b></middle></center>";//Előző év
$adat[$i][]=$style_szin2."<center><middle><b>Havi Összeg Forintban\n".$ev."\n1. módosítás</b></middle></center>";//Előző év
$adat[$i][]=$style_szin1."<center><middle><b>Havi Összeg Forintban\n".$ev."\n2. módosítás</b></middle></center>";//Előző év
$adat[$i][]=$style_szin3."<center><middle><b>Aktuális havi összeg</b></middle></center>";//Előző év
$adat[$i][]=$style_szin2."<center><middle><b>HUF/EUR</b></middle></center>";//Előző év
$adat[$i][]=$style_szin1."<center><middle><b>Közbeszerzés éves keretösszeg</b></middle></center>";//Előző év
$adat[$i][]=$style_szin1."<center><middle><b>CO objektum</b></middle></center>";//Előző év
$adat[$i][]=$style_szin4."<center><middle><b>TIG</b></middle></center>";//Előző év
$adat[$i][]=$style_szin4."<center><middle><b>Beérkezés dátum</b></middle></center>";//Előző év
$adat[$i][]=$style_szin4."<center><middle><b>Partner oldali küldő</b></middle></center>";//Előző év
$adat[$i][]=$style_szin4."<center><middle><b>TIG sorszám</b></middle></center>";//Előző év
$adat[$i][]=$style_szin4."<center><middle><b>TIG típusa</b></middle></center>";//Előző év
$adat[$i][]=$style_szin4."<center><middle><b>TIG db</b></middle></center>";//Előző év
$adat[$i][]=$style_szin5."<center><middle><b>Számlázásnak átadva</b></middle></center>";//Előző év
$adat[$i][]=$style_szin5."<center><middle><b>Hiánypólás</b></middle></center>";//Előző év
$adat[$i][]=$style_szin5."<center><middle><b>Számla nettó</b></middle></center>";//Előző év
$adat[$i][]=$style_szin5."<center><middle><b>Számlázás dátuma</b></middle></center>";//Előző év
$adat[$i][]=$style_szin5."<center><middle><b>Fizetési határidő</b></middle></center>";//Előző év
$adat[$i][]=$style_szin5."<center><middle><b>Bizonylatszám</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>1. módosítás-eredeti összeg különbözet</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>1. Módosító TIG összeg</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>Módosító TIG beérkezés dátuma</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>Módosító TIG sorszáma</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>ismétlődők</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>Módosító TIG db</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>Számla nettó\n1.módosító TIG összeg</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>Számla bruttó\n1.módosító TIG összeg</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>1.Módosító Bizonylatszám</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>1.Módosító Számlázás dátuma</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>1.Módosító Fizetési határidő</b></middle></center>";//Előző év
$adat[$i][]=$style_szin6."<center><middle><b>Számla nettó+\n1 módosító számla nettó</b></middle></center>";//Előző év
$adat[$i][]=$style_szin7."<center><middle><b>2. módosítás-\n1. módosítás különbözet</b></middle></center>";//Előző év
$adat[$i][]=$style_szin7."<center><middle><b>2. Módosító\nTIG összeg</b></middle></center>";//Előző év
$adat[$i][]=$style_szin7."<center><middle><b>2. Módosító\nTIG beérkezés dátuma</b></middle></center>";//Előző év
$adat[$i][]=$style_szin7."<center><middle><b>2. Módosító\nTIG sorszáma</b></middle></center>";//Előző év
$adat[$i][]=$style_szin7."<center><middle><b>2. módosító\nTIG db</b></middle></center>";//Előző év
$adat[$i][]=$style_szin8."<center><middle><b>2. Módosító\nSzámla\nnettó</b></middle></center>";//Előző év
$adat[$i][]=$style_szin8."<center><middle><b>2. Módosító\nSzámla\nbruttó</b></middle></center>";//Előző év
$adat[$i][]=$style_szin8."<center><middle><b>2. Módosító\nBizonylatszám</b></middle></center>";//Előző év
$adat[$i][]=$style_szin8."<center><middle><b>2. Módosító\nSzámlázás\ndátuma</b></middle></center>";//Előző év
$adat[$i][]=$style_szin8."<center><middle><b>2. Módosító\nFizetési\nhatáridő</b></middle></center>";//Előző év
$adat[$i][]=$style_szin9."<center><middle><b>TIG összes\nösszeg</b></middle></center>";//Előző év
$adat[$i][]=$style_szin9."<center><middle><b>Aktuális havi\nösszeg - TIG\nösszes összeg</b></middle></center>";//Előző év
$adat[$i][]=$style_szin9."<center><middle><b>TIG összes\nösszeg =\nAktuális havi összeg</b></middle></center>";//Előző év
$adat[$i][]=$style_szin9."<center><middle><b>Számla nettó\nösszeg</b></middle></center>";//Előző év
$adat[$i][]=$style_szin9."<center><middle><b>TIG összeg-\nszámla nettó</b></middle></center>";//Előző év
$adat[$i][]=$style_szin9."<center><middle><b>Aktuális havi\nösszeg=számla\nnettó összes</b></middle></center>";//Előző év
$adat[$i][]=$style_szin9."<center><middle><b>Aktuális havi\nösszeg-számla\nnettó</b></middle></center>";//Előző év
$adat[$i][]=$style_szin9."<center><middle><b>Összes TIG db\nszám</b></middle></center>";//Előző év
$adat[$i][]=$style_szin10."<center><middle>TIG bekérőt\nküldeni</middle></center>";//Előző év
$adat[$i][]=$style_szin10."<center><middle>TIG-et küldeni</middle></center>";//Előző év
$adat[$i][]=$style_szin10."<center><middle>1. TIG bekérő\n/ TIG kiküldés\ndátuma</middle></center>";//Előző év
$adat[$i][]=$style_szin10."<center><middle>2. TIG bekérő\n/ TIG kiküldés\ndátuma</middle></center>";//Előző év
$adat[$i][]=$style_szin10."<center><middle>Számlázás értesítő\nkiküldés dátuma</middle></center>";//Előző év
$adat[$i][]=$style_szin10."<center><middle>TIG bekérő\ncímzett</middle></center>";//Előző év
$adat[$i][]=$style_szin10."<center><middle>link</middle></center>";//Előző év
$adat[$i][]=$style_szin10."<center><middle>szakterületi\nkimutatás bekérve</middle></center>";//Előző év
$adat[$i][]=$style_szin1."<center><middle><b>elhatárolásba tenni</b></middle></center>";//Előző év
$adat[$i][]=$style_szin11."<center><middle><b>Partner kód</b></middle></center>";//Előző év
$adat[$i][]=$style_szin11."<center><middle><b>Vevő\nazonosító</b></middle></center>";//Előző év
$adat[$i][]=$style_szin11."<center><middle><b>Konszolidációba\nteljeskörűen\nbevont</b></middle></center>";//Előző év
$adat[$i][]=$style_szin11."<center><middle><b>SLA szolgáltatás fajtája</b></middle></center>";//Előző év
$adat[$i][]=$style_szin11."<center><middle><b>Főkönyvi\nszámla</b></middle></center>";//Előző év
$adat[$i][]=$style_szin11."<center><middle><b>Főkönyvi\nszámla</b></middle></center>";//Előző év
$adat[$i][]=$style_szin11."<center><middle><b>Ellenszámla</b></middle></center>";//Előző év
$adat[$i][]=$style_szin11."<center><middle><b>PC\nfőkönyvi számla</b></middle></center>";//Előző év
$adat[$i][]=$style_szin11."<center><middle><b>PC\nellenszámla</b></middle></center>";//Előző év
$adat[$i][]=$style_szin11."<center><middle><b>Adatszolgáltató</b></middle></center>";//Előző év
$adat[$i][]=$style_szin12."<center><middle><b>Státusz</b></middle></center>";//Előző év
$adat[$i][]=$style_szin4."<center><middle><b>TIG beérkezés státusza</b></middle></center>";//Előző év
$adat[$i][]=$style_szin13."<center><middle>Szerződés sorszáma</middle></center>";//Előző év
$adat[$i][]=$style_szin13."<center><middle>TIG besorolás</middle></center>";//Előző év


include_once('riport_tig_tabla_leker_ki_szerz.php');
include_once('riport_tig_tabla_leker_ki_szerz_nem.php');

return $adat;
}

function riport_tig_tabla_dev(){

$ev=$_POST['date1_ev'];
$ho_ig=$_POST['date1_ho'];

$i=0;
$style='<style bgcolor="#FFE699">';
//$adat[$i][]=$style."<center><b>BUKRS</b></center></style>";
$adat[$i][]="<center><b>Szolgáltatás ID</b></center>";
$adat[$i][]="<center><b>Nem szerződés alapján tábla ID</b></center>";
$adat[$i][]="<center><b>ÉV</b></center>";
$adat[$i][]="<center><b>Hónap</b></center>";

$adat[$i][]="<center><b>AB - Szerződésmódosítás hatályba lépésének dátuma</b></center>";
$adat[$i][]="<center><b>U - Szolgáltásnyújtás megkezdésének időpontja</b></center>";
$adat[$i][]="<center><b>AC - Szerződésmódosítás vége (határozott esetén dátum)</b></center>";
$adat[$i][]="<center><b>AD - Szolgáltatás megszünése - vége dátum</b></center>";
$adat[$i][]="<center><b>AE - Szerződés időtartam eredeti (határozott esetén)</b></center>";

include_once('riport_tig_tabla_leker_dev.php');

//(string)(new Shuchkin\SimpleXLSXGen)->addSheet($adat,$GLOBALS['rend_nev'].' export')->downloadAs(rawurlencode($filename));

return $adat;
}

?>