<?php

function admin_szolgkapadat_reszlet(){
if(
 (isset($_POST['szerz_tetel_id']))and($_POST['szerz_tetel_id']!='')
){
$tomb=keres_admin_szolgkapadat_egyreszlet($_POST['szerz_tetel_id'],$_POST['szerz_tetel_adat_id']);
echo 'ok$;$';

if(is_array($tomb)){
 admin_szolgkapadat_reszlet_kirajzol($tomb[0]);
}else{
 echo 'Nincs találat';
}
}else{
 echo 'adathiány';
}
}

function admin_szolgkapadat_reszlet_kirajzol($ert){
echo '<div style="margin-bottom:10px">';
echo '<b>Szerződés módosítás előzmények:</b> ';

//$_POST['admin_szolgkapadatatlist_keres_talszam']="999999";//999.999
//$_POST['oldalholvagyok']=0;
//$orig_id=$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_tetel_id'];
//$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_tetel_id']=$_POST['szerz_tetel_id'];
//$tomb=keres_admin_szolgkapadat_uj();
//$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_tetel_id']=$orig_id;
$tomb=keres_admin_szolgkapadat_elozmenyek($_POST['szerz_tetel_id']);

//echo '<input type="hidden" value="">';//focus hiba miatt
//echo '<img src="image\">';//focus hiba miatt

echo '<select onchange="admin_szolgkapadat_reszlet_valt(\''.$_POST['szerz_tetel_id'].'\')" id="admin_szolgkapadat_reszlet_eloz_sel" class="select3" style="width:500px">';
foreach($tomb as $e_ert){
 echo '<option value="'.$e_ert['szerz_tetel_adat_id'].'"';
 if($e_ert['szerz_tetel_adat_id']==$ert['szerz_tetel_adat_id']) echo ' selected';
 
 if($e_ert['szerz_tetel_modszam']=='0'){
	 //echo '>Módosítás száma: '.$e_ert['szerz_tetel_modszam'].' - '.kidate_format($e_ert['update_time']);
	 //echo '>Szerz. mód. szám: '.$e_ert['szerz_tetel_modszam_kezi'].' - dátum - Módosítás ID: '.$e_ert['szerz_tetel_modszam'];
	 echo '>Szerződés módosítás száma: '.$e_ert['szerz_tetel_modszam_kezi'].' - '.kidate_format($e_ert['szerz_date_hatalybelep']).' - Módosítás ID: '.$e_ert['szerz_tetel_modszam'];
 }else{
	 //echo '>Módosítás száma: '.$e_ert['szerz_tetel_modszam'].' - '.kidate_format($e_ert['update_time']);
	 echo '>Szerződés módosítás száma: '.$e_ert['szerz_tetel_modszam_kezi'].' - '.kidate_format($e_ert['szerz_tetel_szolg_mod_date']).' - Módosítás ID: '.$e_ert['szerz_tetel_modszam'];
 }

}
echo '</select>';

echo '</div>';

echo 'Szolgáltatás ID: '.$ert['szerz_tetel_id'];

//echo '<br>Szerződésmódosítás száma: '.$ert['szerz_tetel_modszam'];
//if($ert['szerz_tetel_akt']=='1') echo ' - aktuális';
 $statusz_str=szerz_statusz($ert['szerz_tetel_modszam'],$ert['szerz_tetel_szolg_kezd_date_folyamatban'],$ert['szerz_tetel_akt'],$ert['szerz_tetel_akt_folyamatban'],$ert['szerz_tetel_vege']);
 //echo '<br>Szerződésmódosítás száma: '.$statusz_str;
 echo '<br>Módosítás ID: '.$statusz_str;

echo '<table class="table_emre_kek" id="admin_szolgkapadat_reszlet_kirajzol">';

//echo '<thead>';
echo '<tbody>';

//Sor-1 - eleje
echo '<tr>';
 echo '<td>Alapdat ID';
 echo '<td>';
 echo $ert['szerz_id'];
 
 echo '<td>Társaság';
 echo '<td colspan=5>';

 if($ert['szerz_megj']!='') $title_megj=str_replace("\n","<br>",$ert['szerz_megj']);
 else $title_megj='';
 $tilte='<b>Szerződéses alapadat megjegyzés:</b><br>'.$title_megj;
 echo '<span class="linkm_tooltip" title="'.$tilte.'">'.$ert['tagv_kod'].' - '.$ert['tagv_kod_nev'].'</span>';
echo '</tr>';
//Sor-1 - vége
 
//Sor-2 - eleje
echo '<tr>';
 echo '<td>Keretszerződés';
 echo '<td>';
 echo igennem_kod_ki_0nalis($ert['szerz_keret']);
 
 echo '<td>Szerződés típus';
 echo '<td>';
 echo $ert['szerz_tipus_nev'];
 
 echo '<td>Szerződés hatályba lépésének<br>időpontja';
 echo '<td>';
 echo kidate_format_ev($ert['szerz_date_hatalybelep']);

 echo '<td>Szerződés módosítás száma';
 echo '<td>';
 echo $ert['szerz_tetel_modszam_kezi'];

echo '</tr>';
//Sor-2 - vége

//Sor-3 - eleje
echo '<tr>';
 echo '<td>Szolgáltatás csoport';
 echo '<td>';
 echo $ert['szerz_csop_nev'];

 echo '<td>Szolgáltatás kód';
 echo '<td>';
 echo $ert['szolg_kod'].' - '.$ert['szolg_kod_nev'];

 echo '<td>Utókalkuláció';
 echo '<td>';
 echo igennem_kod_ki_0nalis($ert['szerz_tetel_utok']);
 
 echo '<td>Nettó szerződés díj<br>(eseti/maximális keret)';
 echo '<td>';
 echo kiosszeg_format($ert['szerz_tetel_netto_szerzdij']);
 if($ert['szerz_tetel_netto_szerzdij_nemrelevans']=='1')
	 echo 'Nem releváns';

echo '</tr>';
//Sor-3 - vége

//Sor-4 - eleje
echo '<tr>';

 echo '<td>Szolgáltásnyújtás megkezdésének<br>időpontja - eredeti';
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_szolg_kezd_date']);
 if($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='1'){
	 echo ' <b>Folyamatban:</b> Igen';
 }
 
 echo '<td>Nettó szerződéses havidíj';
 echo '<td>';
 echo kiosszeg_format($ert['szerz_tetel_netto_havidij']);
 echo ' '.$ert['szerz_tetel_netto_havidij_penznem'];
 
 echo '<td>Elszámolás típusa';
 echo '<td>';
 echo $ert['szerz_elsz_tipus_nev']; 
 
 echo '<td>Óradíj';
 echo '<td>';
 echo kiosszeg_format($ert['szerz_tetel_oradij']);
  if($ert['szerz_tetel_oradij_nemrelevans']=='1')
	 echo 'Nem releváns';
 
echo '</tr>';
//Sor-4 - vége

//Sor-5.0 - eleje
echo '<tr>';

 echo '<td>Árajánlat aláírás dátuma';
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_arajanlat_alair_date']);
 
 echo '<td>Idei naptári évi éves díj';
 echo '<td>';
 echo kiosszeg_format($ert['szerz_tetel_netto_evesdij']);
 
 echo '<td>Naturália típus';
 echo '<td>';
 echo $ert['szerz_naturalia_nev'];
 
 echo '<td>Naturália mennyiség (HAVI)';
 echo '<td>';
 //$ert['szerz_tetel_naturalia_darab']++;
 //$ert['szerz_tetel_naturalia_darab']--;
 echo kiosszeg_format_eur($ert['szerz_tetel_naturalia_darab']);
echo '</tr>';
//Sor-5.0 - vége

//Sor-5.1 - eleje
echo '<tr>';

 echo '<td>Szerződés aláírás dátuma';
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_alair_date']);

 echo '<td>Szerződés időtartam vége<br>eredeti (határozott esetén)';
 if(($ert['szerz_tetel_modszam']<='0')or($ert['szerz_tetel_szolg_aktveg_date']==''))echo '<td colspan=5>';
 else echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_szolg_origveg_date']);

 if(($ert['szerz_tetel_modszam']>'0')and($ert['szerz_tetel_szolg_aktveg_date']!='')){
  echo '<td>Szerződés időtartam vége<br>aktuális (határozott esetén)';
  echo '<td colspan=3>';
  echo kidate_format_ev($ert['szerz_tetel_szolg_aktveg_date']);
 }

echo '</tr>';
//Sor-5.1 - vége

//Sor-5 - eleje
if(($ert['szerz_tetel_szolg_mod_date']!='')or($ert['szerz_tetel_szolg_modveg_date']!='')){
 echo '<tr>';
}

if($ert['szerz_tetel_szolg_mod_date']!=''){
 $colspan_2='5';
 echo '<td>Szerződésmódosítás<br>hatályba lépésének dátuma';
 echo '<td';
 if($ert['szerz_tetel_szolg_modveg_date']=='')echo ' colspan=7';
 echo '>';
 echo kidate_format_ev($ert['szerz_tetel_szolg_mod_date']);
}elseif($ert['szerz_tetel_akt_folyamatban']=='1'){
 $colspan_2='5';
 echo '<td>Szerződésmódosítás<br>hatályba lépésének dátuma';
 echo '<td';
 if($ert['szerz_tetel_szolg_modveg_date']=='')echo ' colspan=7';
 echo '>';
 echo 'Folyamatban';
}else{
 $colspan_2='7';	
}

if($ert['szerz_tetel_szolg_modveg_date']!=''){
 echo '<td>Szerződésmódosítás vége<br>(határozott esetén dátum)';
 echo '<td colspan='.$colspan_2.'>';
 echo kidate_format_ev($ert['szerz_tetel_szolg_modveg_date']);
}

if(($ert['szerz_tetel_szolg_mod_date']!='')or($ert['szerz_tetel_szolg_modveg_date']!='')){
 echo '</tr>';
}

//Sor-5 - vége

//Sor-5 - eleje
if($ert['szerz_tetel_vege']=='1'){
echo '<tr>';
 echo '<td>Szolgáltatás megszünése - vége dátum';
 echo '<td colspan=7>';
 echo kidate_format_ev($ert['szerz_tetel_vege_date']);
echo '</tr>';
}
//Sor-5 - vége

//Sor-6 - eleje
echo '<tr>';

 echo '<td>Tevékenység';
 echo '<td colspan=3>';
 //echo str_replace(',','<br>',$ert['projekt_nevek']);
 //echo $ert['projekt_nevek'];
 echo '<span title="'.$ert['projekt_nevek'].'" class="linkm_tooltip">';
 echo str_hosz_vag($ert['projekt_nevek'],250,'<br>');
 echo '</span>';
 
 echo '<td>Szerződésgazda';
 echo '<td>';
 echo $ert['szerz_usergazda_nev'];
 if($ert['szerz_usergazda_inaktiv']=='1')echo ' - Inaktív';
 
 echo '<td>Integrációban érintett';
 echo '<td colspan=2>';
 echo igennem_kod_ki_0nalis($ert['szerz_tetel_integ_erintett']);

echo '</tr>';
//Sor-6 - vége

//Sor-7 - eleje
echo '<tr>';
 echo '<td>Általános megjegyzés';
 echo '<td colspan=7>';
 echo $ert['szerz_tetel_megj'];
echo '</tr>';
//Sor-7 - vége

//Sor-8 - eleje
echo '<tr>';
 echo '<td>TT megjegyzés';
 echo '<td colspan=7>';
 echo $ert['szerz_tetel_tt_megj'];
echo '</tr>';
//Sor-8 - vége

//Sor-8 - eleje
echo '<tr>';
 echo '<td>Szerződés';
 echo '<td colspan=7>';
 if($ert['szerz_file_szerz_vane']=='1'){
  echo '<span onclick="szerz_file_open(\''.$ert['szerz_file_id'].'\',\'szerz\')" class="link">'.$ert['szerz_file_szerz_name'].'</span>';
 }
echo '</tr>';
//Sor-8 - vége

//Sor-8.1 - eleje
echo '<tr>';
 echo '<td>Árajánlat';
 echo '<td colspan=7>';
 if($ert['szerz_file_ar_vane']=='1'){
  echo '<span onclick="szerz_file_open(\''.$ert['szerz_file_id'].'\',\'ar\')" class="link">'.$ert['szerz_file_ar_name'].'</span>';
 }
echo '</tr>';
//Sor-8.1 - vége

//Sor-9 - eleje
echo '<tr>';
 echo '<td>CO objektum';
 echo '<td>';
 echo $ert['szerz_tetel_co'];
 
 echo '<td>SAP szerződésszám';
 echo '<td colspan=5>';
 echo $ert['szerz_sapszam'];
//Sor-9 - vége

//Sor-10 - eleje
echo '<tr>';
 //echo '<td>Hatályos<br>szerződésmódosítás száma';
 echo '<td>Módosítás ID';
 echo '<td>';
 
 $statusz_str=szerz_statusz($ert['szerz_tetel_modszam'],$ert['szerz_tetel_szolg_kezd_date_folyamatban'],$ert['szerz_tetel_akt'],$ert['szerz_tetel_akt_folyamatban'],$ert['szerz_tetel_vege']);
 echo $statusz_str;
 
 if($ert['szerz_tetel_modszam']!='0'){
  //echo $ert['szerz_tetel_modszam'];
 
  echo '<td>Módosító';
  echo '<td colspan=3>';
  echo $ert['user_nev'];

  echo '<td>Módosítás ideje';
  echo '<td colspan=3>';
  echo kidate_format($ert['update_time']);
 }else{
  //echo $ert['szerz_tetel_modszam'];
  echo '<td>Rögzítő';
  echo '<td colspan=3>';
  echo $ert['user_nev'];

  echo '<td>Rögzítés ideje';
  echo '<td colspan=3>';
  echo kidate_format($ert['update_time']);
 }
echo '</tr>';
//Sor-10 - vége

//echo '</thead>';
echo '</tbody>';
echo '</table>';

/*
if(($ert['szerz_file_szerz_vane']=='1')or($ert['szerz_file_ar_vane']=='1')){
echo '<div style="margin-top:5px">';
if($ert['szerz_file_szerz_vane']=='1')
 echo '<span style="font-weight:bold">Szerződés: </span><span onclick="szerz_file_open(\''.$ert['szerz_file_id'].'\',\'szerz\')" class="link">'.$ert['szerz_file_szerz_name'].'</span>';
if($ert['szerz_file_ar_vane']=='1'){
 echo '<br>';
 echo '<span style="font-weight:bold">Árajánlat: </span><span onclick="szerz_file_open(\''.$ert['szerz_file_id'].'\',\'ar\')" class="link">'.$ert['szerz_file_ar_name'].'</span>';
}
echo '</div>';
}
*/

}

function keres_admin_szolgkapadat_elozmenyek($szerz_tetel_id){
$eredmeny_keres="";
// ,szerz_tetel_adat.update_time
 $sql="SELECT szerz_tetel_adat.szerz_tetel_adat_id
 ,szerz_tetel_adat.szerz_tetel_modszam
 ,szerz_tetel_adat.szerz_tetel_modszam_kezi

 ,szerz.szerz_date_hatalybelep
 ,szerz_tetel_adat.szerz_tetel_szolg_mod_date
  FROM `szerz_tetel_adat` 
  left join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
  where
  szerz_tetel_adat.szerz_tetel_id='".mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_tetel_id)."'
  order by szerz_tetel_adat.szerz_tetel_modszam desc";
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_szolgkapadat_egyreszlet($szerz_tetel_id,$szerz_tetel_adat_id){
$eredmeny_keres="";

 $sql="SELECT szerz_tetel.*
 ,szerz_tetel_adat.*
 ,szerz.*
 ,szerz_csop.szerz_csop_nev 
 ,szerz_tipus.szerz_tipus_nev
 ,mira_tagv_kod.tagv_kod_nev
 ,mira_szolg_kod.szolg_kod_nev
 ,szerz_elsz_tipus.szerz_elsz_tipus_nev
 ,szerz_naturalia.szerz_naturalia_nev
 ,szerz_usergazda.szerz_usergazda_nev
 ,szerz_usergazda.	szerz_usergazda_inaktiv
 ,mira_user_mod.user_nev
 ,szerz_file.szerz_file_id
 ,szerz_file.szerz_file_szerz_vane
 ,szerz_file.szerz_file_szerz_name
 ,szerz_file.szerz_file_ar_vane
 ,szerz_file.szerz_file_ar_name,
 
 /* === ÚJ OSZLOP: projektek nevei vesszővel elválasztva === */
        (SELECT GROUP_CONCAT(DISTINCT p.projekt_nev SEPARATOR '<br>')
         FROM szerz_tetel_adat_projekt stp 
         JOIN projekt p ON p.projekt_id = stp.projekt_id
         WHERE stp.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id) AS projekt_nevek
 
 FROM `szerz_tetel` 
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
 left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod
 left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_tetel_adat.szolg_kod
 left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tetel_adat.szerz_elsz_tipus_id
 left join szerz_naturalia ON szerz_naturalia.szerz_naturalia_id = szerz_tetel_adat.szerz_naturalia_id
 left join szerz_usergazda ON szerz_usergazda.szerz_usergazda_ad = szerz_tetel_adat.szerz_usergazda_ad
 left join mira_user as mira_user_mod ON mira_user_mod.user_ad = szerz_tetel_adat.szerz_tetel_mod_user_ad 
 left join szerz_file ON szerz_file.szerz_id=szerz_tetel_adat.szerz_id 
	and szerz_file.szerz_tetel_modszam_kezi=szerz_tetel_adat.szerz_tetel_modszam_kezi

 where
 szerz_tetel.szerz_tetel_id='".mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_tetel_id)."' and
 szerz_tetel_adat.szerz_tetel_adat_id='".mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_tetel_adat_id)."' 
 ";
 /*
  left join szerz_tetel_adat_projekt ON szerz_tetel_adat_projekt.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id
 left join projekt ON projekt.projekt_id = szerz_tetel_adat_projekt.projekt_id
 */
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

?>