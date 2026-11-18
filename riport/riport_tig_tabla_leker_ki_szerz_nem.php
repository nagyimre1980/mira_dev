<?php

if(is_array($GLOBALS['tigtabla_tomb_nemszerz'])){

foreach($GLOBALS['tigtabla_tomb_nemszerz'] as $id => $ert){
$i++;	
$adat[$i][]='';
//$adat[$i][]=$ert['id'];
$adat[$i][]=$ert['ev'];
$adat[$i][]=$ert['ho'];

//Megrendelő
$adat[$i][]=$ert['tagv_kod_nev'];

//Vevő azonosító
$adat[$i][]=$ert['tagv_kod_vevoazon'];

//Partner kód
$adat[$i][]='MC'.$ert['tagv_kod'];

//Szerződés típusa
$adat[$i][]=$ert['szerz_tipus_nev'];//G oszlop számla alapján

//Szerződés MVMS / BSZK
$adat[$i][]='';//Üres marad

//Szolgáltatás
$adat[$i][]=$ert['szolg_kod_nev'];//I oszlop

//Szerződés
$adat[$i][]=szerz_tigadatnemszerz_szerzodes_ki($ert['szerz_tig_nemszerz_szerzodes']);

//elszámolás módja
$adat[$i][]=$ert['szerz_elsz_tipus_nev'];

//Megjegyzés
$adat[$i][]='';//Üres marad

//Óra / fő / napi díj
$adat[$i][]='';//Üres marad

//MIRA óraszám
$adat[$i][]='';//Üres marad

//egyéb naturália db, nap, fő, nm, dm3, stb 
$adat[$i][]='';//Üres marad

//db -új oszlop fizigényhez
$adat[$i][]='';//Üres marad

//szerződéses összeg EUR-ban
$adat[$i][]=$ert['szerz_tig_nemszerz_szerzosszeg'];

//Hó végi árfolyam
//Akkor ha a $ert['szerz_tig_nemszerz_szerzosszeg'] van összeg, és mindig az EUR-s árfolyam
if(
($ert['szerz_tig_nemszerz_szerzosszeg']!='')and
(isset($GLOBALS['tigtabla_tomb_nemszerz_arfolyam'][$ert['szerz_tig_nemszerz_penznem']][$ert['ev'].$ert['ho']]))
){
 $adat[$i][]=$GLOBALS['tigtabla_tomb_nemszerz_arfolyam'][$ert['szerz_tig_nemszerz_penznem']][$ert['ev'].$ert['ho']];
}else{
 $adat[$i][]='';//Üres marad
}

//Havi Összeg Forintban 2025
$adat[$i][]=$ert['szerz_tig_nemszerz_haviosszeg'];

//Havi Összeg Forintban 2026 1. módosítás
$adat[$i][]=$ert['szerz_tig_nemszerz_haviosszeg_mod1'];

//Havi Összeg Forintban 2026 2. módosítás
$adat[$i][]=$ert['szerz_tig_nemszerz_haviosszeg_mod2'];

//Aktuális havi összeg
if($ert['szerz_tig_nemszerz_haviosszeg_mod2']!=''){
 $adat[$i][]=$ert['szerz_tig_nemszerz_haviosszeg_mod2'];
}elseif($ert['szerz_tig_nemszerz_haviosszeg_mod1']!=''){
 $adat[$i][]=$ert['szerz_tig_nemszerz_haviosszeg_mod1'];
}else{
 $adat[$i][]=$ert['szerz_tig_nemszerz_haviosszeg'];
}

//HUF/EUR
$adat[$i][]=$ert['szerz_tig_nemszerz_penznem'];

//Közbeszerzés éves keretösszeg
$adat[$i][]='';//Üres marad

//CO objektum
$adat[$i][]=$ert['szerz_tig_nemszerz_co'];

}
}

function szerz_tigadatnemszerz_szerzodes_ki($a){
switch($a){
 case'van':$ret='Van';break;
 case'nincs':$ret='Nincs';break;
 case'megszunt':$ret='Megszünt';break;
 default:$ret=$a;break;
}
return $ret;
}
?>