<?php

function admin_szolgmodadat_vege(){
if(
 (isset($_POST['szerz_tetel_id']))and($_POST['szerz_tetel_id']!='')
){
$tomb=keres_admin_szolgkapadat_egyvege($_POST['szerz_tetel_id'],$_POST['szerz_tetel_adat_id']);
echo 'ok$;$';

if(is_array($tomb)){
 admin_szolgmodadat_vege_kirajzol($tomb[0]);
}else{
 echo 'Nincs találat';
}
}else{
 echo 'adathiány';
}
}


function admin_szolgmodadat_vege_kirajzol($ert){
echo '<b>Szolgáltatás megszüntetése</b><br>';
echo 'Szolgáltatás ID: '.$ert['szerz_tetel_id'];
//echo '<br>Aktuális szerződésmódosítás száma: '.$ert['szerz_tetel_modszam'];
echo '<br>Aktuális módosítás ID: '.$ert['szerz_tetel_modszam'];
echo '<table class="table_emre_kek" id="admin_szolgkapadat_reszlet_kirajzol">';

echo '<tbody>';

//Sor-1 - eleje
echo '<tr>';
 echo '<td>Alapdat ID';
 echo '<td>';
 echo $ert['szerz_id'];
 
 if($ert['szerz_megj']!='') $title_megj=str_replace("\n","<br>",$ert['szerz_megj']);
 else $title_megj='';
 $tilte='<b>Szerződéses alapadat megjegyzés:</b><br>'.$title_megj;
 echo '<td>Társaság';
 echo '<td colspan=5>';
 //echo $ert['tagv_kod'].' - '.$ert['tagv_kod_nev'];
 echo '<span class="linkm_tooltip" title="'.$tilte.'">'.$ert['tagv_kod'].' - '.$ert['tagv_kod_nev'].'</span>';
echo '</tr>';
//Sor-1 - vége
 
//Sor-2 - eleje
echo '<tr>';
 echo '<td>Keretszerződés';
 echo '<td>';
 echo igennem_kod_ki($ert['szerz_keret']);
 
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
 echo igennem_kod_ki($ert['szerz_tetel_utok']);
 
 echo '<td>Nettó szerződés díj<br>(eseti/maximális keret)';
 echo '<td>';
 echo $ert['szerz_tetel_netto_szerzdij'];

echo '</tr>';
//Sor-3 - vége

//Sor-4 - eleje
echo '<tr>';
 echo '<td>Szolgáltásnyújtás megkezdésének<br>időpontja - eredeti';
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_szolg_kezd_date']);
 
 echo '<td>Nettó szerződéses havidíj';
 echo '<td>';
 echo $ert['szerz_tetel_netto_havidij'];
 echo ' '.$ert['szerz_tetel_netto_havidij_penznem'];
 
 echo '<td>Elszámolás típusa';
 echo '<td>';
 echo $ert['szerz_elsz_tipus_nev']; 
 
 echo '<td>Óradíj';
 echo '<td>';
 echo $ert['szerz_tetel_oradij'];
 
echo '</tr>';
//Sor-4 - vége

//Sor-5 - eleje
echo '<tr>';
 echo '<td>Árajánlat aláírás dátuma';
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_arajanlat_alair_date']);
 
 echo '<td>Idei naptári évi éves díj';
 echo '<td>';
 echo $ert['szerz_tetel_netto_evesdij'];
 
 echo '<td>Naturália típus';
 echo '<td>';
 echo $ert['szerz_naturalia_nev'];
 
 echo '<td>Naturália mennyiség (HAVI)';
 echo '<td>';
 //$ert['szerz_tetel_naturalia_darab']++;
 //$ert['szerz_tetel_naturalia_darab']--;
 echo kiosszeg_format_eur($ert['szerz_tetel_naturalia_darab']);
echo '</tr>';
//Sor-5 - vége

//Sor-5.0 - eleje
echo '<tr>';

 echo '<td>Szerződés aláírás dátuma';
 echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_alair_date']);
 
 echo '<td>Szerződés időtartam vége<br>eredeti (határozott esetén)';
 if($ert['szerz_tetel_modszam']=='0')echo '<td colspan=5>';
 else echo '<td>';
 echo kidate_format_ev($ert['szerz_tetel_szolg_origveg_date']);

 if($ert['szerz_tetel_modszam']!='0'){
  echo '<td>Szerződés időtartam vége<br>aktuális (határozott esetén)';
  echo '<td colspan=3>';
  echo kidate_format_ev($ert['szerz_tetel_szolg_aktveg_date']);
 }

echo '</tr>';
//Sor-5.0 - vége

//Sor-5.1 - eleje
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

//Sor-5.1 - vége

//Sor-5 - eleje
echo '<tr>';
 echo '<td>Szolgáltatás megszünése - vége dátum';//<br>Aktuális (határozott esetén )
 echo '<td colspan=7>';
 echo '<input value="" id="admin_modszolgmodadat_vegedate" class="date_tol" style="width:100px" type="text">';
echo '</tr>';
//Sor-5 - vége

//Sor-6 - eleje
echo '<tr>';

 echo '<td>Tevékenység';
 echo '<td>';
 //echo $ert['projekt_nevek'];
 echo '<span title="'.$ert['projekt_nevek'].'" class="linkm_tooltip">';
 echo str_hosz_vag($ert['projekt_nevek'],250,'<br>');
 echo '</span>';
 
 echo '<td>Szerződésgazda';
 echo '<td colspan=3>';
 echo $ert['szerz_usergazda_nev'];
 
 echo '<td>Integrációban érintett';
 echo '<td>';
 echo igennem_kod_ki($ert['szerz_tetel_integ_erintett']);

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
  echo '<td>Rögzítő';
  echo '<td colspan=3>';
  echo $ert['user_nev'];

  echo '<td>Rögzítés ideje';
  echo '<td colspan=3>';
  echo kidate_format($ert['update_time']);
 }
echo '</tr>';
//Sor-10 - vége

echo '</tbody>';
echo '</table>';
}

function keres_admin_szolgkapadat_egyvege($szerz_tetel_id,$szerz_tetel_adat_id){
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
 ,szerz_usergazda.szerz_usergazda_ad
 ,szerz_usergazda.szerz_usergazda_tsz
 ,mira_user.user_nev
 ,szerz_file.szerz_file_id
 ,szerz_file.szerz_file_szerz_vane
 ,szerz_file.szerz_file_szerz_name
 ,szerz_file.szerz_file_ar_vane
 ,szerz_file.szerz_file_ar_name
 
   /* === ÚJ OSZLOP: projektek nevei vesszővel elválasztva === */
        ,(SELECT GROUP_CONCAT(DISTINCT p.projekt_nev SEPARATOR '<br>')
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
 left join mira_user ON mira_user.user_ad = szerz_tetel_adat.szerz_tetel_mod_user_ad 
  left join szerz_file ON szerz_file.szerz_id=szerz_tetel_adat.szerz_id 
	and szerz_file.szerz_tetel_modszam_kezi=szerz_tetel_adat.szerz_tetel_modszam_kezi
 where
 szerz_tetel.szerz_tetel_id='".mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_tetel_id)."' and 
 szerz_tetel_adat.szerz_tetel_adat_id='".mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_tetel_adat_id)."'";
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function admin_szolgmodadat_vege_proc_ment(){
if(
 (isset($_POST['szerz_tetel_id']))and
 (isset($_POST['szerz_tetel_adat_id']))and
 (isset($_POST['szerz_tetel_vege_date']))and
 ($_POST['szerz_tetel_id']!='')and
 ($_POST['szerz_tetel_adat_id']!='')and
 ($_POST['szerz_tetel_vege_date']!='')
){

if(!checkmydate($_POST['szerz_tetel_vege_date'])){
 echo "nook$;$"."Szolgáltatás megszünése - vége dátum hibás!";
 exit;
}	

//Megszüntetéskor a vége dátum nem lehet korábbi mint az utolsó módosítás dátuma
//convert_dateszam()

$szerz_tetel_szolg_kezd_date=keres_mit1_mit1_csak_ertek('szerz_tetel','szerz_tetel_id',$_POST['szerz_tetel_id'],'szerz_tetel_szolg_kezd_date');
if($szerz_tetel_szolg_kezd_date==''){
 echo "nook$;$"."Szolgáltatás eredeti kezdeti dátuma nem található!";
 exit;
}

if(convert_dateszam($_POST['szerz_tetel_vege_date'])<convert_dateszam($szerz_tetel_szolg_kezd_date)){
 echo "nook$;$"."Hiba!<br><br>Szolgáltatás vége dátuma hibás! Kisebb mint az eredeti szerződés kezdeti dátuma";
 exit;
}

$szerz_tetel_szolg_mod_date=keres_mit1_mit1_csak_ertek('szerz_tetel_adat','szerz_tetel_adat_id',$_POST['szerz_tetel_adat_id'],'szerz_tetel_szolg_mod_date');
if($szerz_tetel_szolg_mod_date!=''){
if(convert_dateszam($_POST['szerz_tetel_vege_date'])<convert_dateszam($szerz_tetel_szolg_mod_date)){
 echo "nook$;$"."Hiba!<br><br>Szolgáltatás vége dátuma hibás! Kisebb mint az utolsó szerződésmódosítás dátuma";
 exit;
}
}

  $tmp_moda=array();

  $tmp_moda[0]['szerz_tetel_vege_date']=str_replace(".","-",$_POST['szerz_tetel_vege_date']);
  $tmp_moda[0]['szerz_tetel_vege']='1';
  $tmp_moda[0]['szerz_tetel_vege_ki']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
  $tmp_moda[0]['szerz_tetel_vege_mikor']=date("Y_m_d-H_i_s",time());
  mod_egy_fel_tom('szerz_tetel',$tmp_moda[0],"szerz_tetel_id",$_POST['szerz_tetel_id']);
  echo 'ok$;$';
}else{
 echo 'adathiány';
}
}
?>