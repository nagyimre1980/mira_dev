<?php

function admin_szolgkapadat_mod(){
if(
 (isset($_POST['szerz_tetel_id']))and($_POST['szerz_tetel_id']!='')
){
$tomb=keres_admin_szolgkapadat_egymodhoz($_POST['szerz_tetel_id'],$_POST['szerz_tetel_adat_id']);
echo 'ok$;$';

if(is_array($tomb)){
 admin_szolgkapadat_mod_kirajzol($tomb[0]);
}else{
 echo 'Nincs találat';
}
}else{
 echo 'adathiány';
}
}

function admin_szolgkapadat_mod_kirajzol($ert){

echo 'Szolgáltatás ID: '.$ert['szerz_tetel_id'];

 if($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='1'){
  $ert['szerz_tetel_modszam']='-1';
  $ert['szerz_tetel_akt']='0';
 }

//echo '<br>Szerződésmódosítás száma: '.$ert['szerz_tetel_modszam'];
//if($ert['szerz_tetel_akt']=='1') echo ' - aktuális';
 $statusz_str=szerz_statusz($ert['szerz_tetel_modszam'],$ert['szerz_tetel_szolg_kezd_date_folyamatban'],$ert['szerz_tetel_akt'],$ert['szerz_tetel_akt_folyamatban'],$ert['szerz_tetel_vege']);
 //echo '<br>Szerződésmódosítás száma: '.$statusz_str;
 echo '<br>Módosítás ID: '.$statusz_str;

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
 echo '<select orig_value="'.$ert['szerz_tetel_modszam_kezi'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_modszamkezi" class="select2_sima" style="width:45px">';
 for($i=0;$i<=20;$i++){
	 echo '<option value="'.$i.'"';
	 if($i==$ert['szerz_tetel_modszam_kezi'])echo ' selected';
	 echo '>'.$i;
 }
 echo '</select>';

echo '</tr>';
//Sor-2 - vége

//Sor-3 - eleje
echo '<tr>';
 echo '<td>Szolgáltatás csoport';
 echo '<td>';
 echo '<select orig_value="'.$ert['szerz_csop_id'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_szerzcsopid" class="select2_ajax" csonkolt=0 mod="admin_szolgcsop_mod" style="width:181px">';
 echo '<option value="'.$ert['szerz_csop_id'].'" selected>'.$ert['szerz_csop_nev'];
 echo '</select>';
 
 echo '<td>Szolgáltatás kód';
 echo '<td>';
 //echo $ert['szolg_kod'].' - '.$ert['szolg_kod_nev'];
 //echo '<select orig_value="'.$ert['szolg_kod'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_szolgkod" class="select2_ajax" csonkolt=0 mod="admin_szolgkod" style="width:200px">';
 echo '<select orig_value="'.$ert['szolg_kod'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_szolgkod" class="select2_ajax" csonkolt=0 mit_id="admin_modszolgkapadat_szerzcsopid" mod="admin_szolgkod_csopid" style="width:200px">';
 echo '<option value="'.$ert['szolg_kod'].'">'.$ert['szolg_kod'].' - '.$ert['szolg_kod_nev'];
 echo '</select>';

 echo '<td>Utókalkuláció';
 echo '<td>';
 //echo igennem_kod_ki($ert['szerz_tetel_utok']);
 echo '<select orig_value="'.$ert['szerz_tetel_utok'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_tetelutok" class="select3" style="width:120px">';
 echo '<option value="0"';
 if($ert['szerz_tetel_utok']=='0') echo ' selected';
 echo '>Nem';
 
 echo '<option value="1"';
 if($ert['szerz_tetel_utok']=='1') echo ' selected';
 echo '>Igen';
 echo '</select>';
 
 echo '<td>Nettó szerződés díj<br>(eseti/maximális keret)';
 echo '<td>';
 //echo $ert['szerz_tetel_netto_szerzdij'];
 
 if($ert['szerz_tetel_netto_szerzdij_nemrelevans']=='1'){
	 $cknettoszerzdij_inp=' disabled';
	 $cknettoszerzdij_nemrelevans=' checked';
 }else{
	 $cknettoszerzdij_inp='';
	 $cknettoszerzdij_nemrelevans='';
 }
 
 echo '<input'.$cknettoszerzdij_inp.' orig_value="'.$ert['szerz_tetel_netto_szerzdij'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_netto_szerzdij'].'" id="admin_modszolgkapadat_nettoszerzdij" style="width:100px" class="number_penz" maxlength="13" type="text">';
 echo '<label>';
 echo '<input'.$cknettoszerzdij_nemrelevans.' onchange="admin_szolgkapadat_mod_nettoszerzdij_nemrelevans_change()" orig_value="'.$ert['szerz_tetel_netto_szerzdij_nemrelevans'].'" id="admin_modszolgkapadat_nettoszerzdij_nemrelevans" type="checkbox">';
 echo ' Nem releváns';
 echo '</label>';

echo '</tr>';
//Sor-3 - vége

//Sor-4 - eleje
echo '<tr>';

 echo '<td>Szolgáltásnyújtás megkezdésének<br>időpontja - eredeti';
 echo '<td>';
 //echo $ert['szerz_tetel_szolg_kezd_date'];
 echo '<input orig_value="'.kidate_format_ev($ert['szerz_tetel_szolg_kezd_date']).'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_szolg_kezd_date'].'" id="admin_modszolgkapadat_szolgkezddate" class="date_tol" style="width:100px" type="text">';
 //echo ' *';
 
 if(
 ($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='1')
 or
 (
  ($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='0')and($ert['szerz_tetel_modszam']=='0')
 )
 ){
  
  if($ert['szerz_tetel_szolg_kezd_date_folyamatban']=='1')$ck_foly=' checked';
  else $ck_foly=' disabled';
	  
  echo ' <label>Folyamatban';
  echo '<input'.$ck_foly.' orig_value="'.$ert['szerz_tetel_szolg_kezd_date_folyamatban'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_folyamatban" style="vertical-align:bottom" type="checkbox">';
  echo '</label>';
 }
 
 echo '<td>Nettó szerződéses havidíj';
 echo '<td>';
 //echo $ert['szerz_tetel_netto_havidij'];
 echo '<input orig_value="'.$ert['szerz_tetel_netto_havidij'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_netto_havidij'].'" id="admin_modszolgkapadat_nettohavidij" style="width:127px;margin-right:5px;vertical-align:top" class="number_penz" maxlength="12" type="text">';
 
  echo '<select orig_value="'.$ert['szerz_tetel_netto_havidij_penznem'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_nettohavidij_penznem" class="select2_ajax" csonkolt=0 mod="admin_penznem_uj" style="width:55px">';
  echo '<option value="'.$ert['szerz_tetel_netto_havidij_penznem'].'">'.$ert['szerz_tetel_netto_havidij_penznem'];
  echo '</select>';
 
 echo '<td>Elszámolás típusa';
 echo '<td>';
 //echo $ert['szerz_elsz_tipus_nev'];
 echo '<select orig_value="'.$ert['szerz_elsz_tipus_id'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_elsztipusid" class="select2_ajax" csonkolt=1 mod="admin_elsztipus_mod" style="width:120px">';
 echo '<option value="'.$ert['szerz_elsz_tipus_id'].'">'.$ert['szerz_elsz_tipus_nev'];
 echo '</select>'; 
 
 echo '<td>Óradíj';
 echo '<td>';
 //echo $ert['szerz_tetel_oradij'];

 if($ert['szerz_tetel_oradij_nemrelevans']=='1'){
	 $ckoradij_inp=' disabled';
	 $ckoradij_nemrelevans=' checked';
 }else{
	 $ckoradij_inp='';
	 $ckoradij_nemrelevans='';
 }

 echo '<input'.$ckoradij_inp.'  orig_value="'.$ert['szerz_tetel_oradij'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_oradij'].'" id="admin_modszolgkapadat_oradij" style="width:100px" class="number_penz" maxlength="6" type="text">';
 echo '<label>';
 echo '<input'.$ckoradij_nemrelevans.' onchange="admin_szolgkapadat_mod_oradij_nemrelevans_change()" orig_value="'.$ert['szerz_tetel_oradij_nemrelevans'].'" id="admin_modszolgkapadat_oradij_nemrelevans" type="checkbox">';
 echo ' Nem releváns';
 echo '</label>';

echo '</tr>';
//Sor-4 - vége

//Sor-5 - eleje
echo '<tr>';

 echo '<td>Árajánlat aláírás dátuma';
 echo '<td>';
 echo '<input orig_value="'.kidate_format_ev($ert['szerz_tetel_arajanlat_alair_date']).'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_arajanlat_alair_date'].'" id="admin_modszolgkapadat_arajanlatalair" class="date_tol" style="width:100px" type="text">';

 echo '<td>Idei naptári évi éves díj';
 echo '<td>';
 echo '<input orig_value="'.$ert['szerz_tetel_netto_evesdij'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_netto_evesdij'].'" id="admin_modszolgkapadat_nettoevesdij" style="width:127px" class="number_penz" maxlength="12" type="text">';

 echo '<td>Naturália típus';
 echo '<td>';
 //echo $ert['szerz_naturalia_nev'];
 echo '<select orig_value="'.$ert['szerz_naturalia_id'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_naturaliaid" class="select2_ajax" csonkolt=1 mod="admin_nattipus_mod" style="width:120px">';
 echo '<option value="'.$ert['szerz_naturalia_id'].'">'.$ert['szerz_naturalia_nev'];
 echo '</select>';
 
 echo '<td>Naturália mennyiség (HAVI)';
 echo '<td>';
 //$ert['szerz_tetel_naturalia_darab']++;
 //$ert['szerz_tetel_naturalia_darab']--;
 //echo $ert['szerz_tetel_naturalia_darab'];
 echo '<input orig_value="'.$ert['szerz_tetel_naturalia_darab'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.kiosszeg_format_eur($ert['szerz_tetel_naturalia_darab']).'" id="admin_modszolgkapadat_naturaliadarab" class="number_penz_2tizedes" style="width:100px" maxlength="11" type="text">';

echo '</tr>';
//Sor-5 - vége

//Sor-5.1 - eleje
echo '<tr>';

 echo '<td>Szerződés aláírás dátuma';
 echo '<td>';
 echo '<input orig_value="'.kidate_format_ev($ert['szerz_tetel_alair_date']).'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_alair_date'].'" id="admin_modszolgkapadat_alairdate" class="date_tol" style="width:100px" type="text">';

 echo '<td>Szerződés időtartam vége<br>eredeti (határozott esetén)';
 if($ert['szerz_tetel_modszam']<='0')echo '<td colspan=5>';
 else echo '<td>';
 echo '<input orig_value="'.kidate_format_ev($ert['szerz_tetel_szolg_origveg_date']).'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.kidate_format_ev($ert['szerz_tetel_szolg_origveg_date']).'" id="admin_modszolgkapadat_szolgorigvegdate" class="date_tol25" style="width:100px" type="text">';

 if($ert['szerz_tetel_modszam']>'0'){
  echo '<td>Szerződés időtartam vége<br>aktuális (határozott esetén)';
  echo '<td colspan=3>';
  echo '<input orig_value="'.kidate_format_ev($ert['szerz_tetel_szolg_aktveg_date']).'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.kidate_format_ev($ert['szerz_tetel_szolg_aktveg_date']).'" id="admin_modszolgkapadat_szolgaktvegdate" class="date_tol25" style="width:100px" type="text">';

 }
 
echo '</tr>';
//Sor-5.1 - vége

//Sor-5 - eleje
if($ert['szerz_tetel_szolg_mod_date']!=''){
echo '<tr>';
 $colspan_2='5';
 echo '<td>Szerződésmódosítás<br>hatályba lépésének dátuma';
 echo '<td colspan=7>';
 //echo kidate_format_ev($ert['szerz_tetel_szolg_mod_date']);
 echo '<input orig_value="'.kidate_format_ev($ert['szerz_tetel_szolg_mod_date']).'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_szolg_mod_date'].'" id="admin_modszolgkapadat_szolgmoddate" class="date_tol" style="width:100px" type="text">';
echo '</tr>';
}elseif($ert['szerz_tetel_akt_folyamatban']=='1'){
 echo '<tr>';
 $colspan_2='5';
 echo '<td>Szerződésmódosítás<br>hatályba lépésének dátuma';
 echo '<td colspan=7>';
 echo 'Folyamatban';
 echo '</tr>';
}
//Sor-5 - vége

//Sor-6 - eleje
echo '<tr>';
 echo '<td>Tevékenység';
 echo '<td>';
 //admin_modszolgkapadat_projektid_szam
 echo '<span title="'.$ert['projekt_nevek'].'" id="admin_ujszolgkapadat_projektid_szam_hibajavitas" onclick="admin_ujszolgkapadat_porjekt_add(\'hibajavitas\')" class="link">';
 if($ert['projekt_nevek']!=''){
  //echo $ert['projekt_nevek'];
  echo str_hosz_vag($ert['projekt_nevek'],250,'<br>');
 }else{
  echo 'Tevékenységek hozzáadása';
 }
 echo '</span>';
 //admin_modszolgkapadat_projektid
 echo '<input type=hidden onchange="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_ujszolgkapadat_projektid_hibajavitas" value="'.$ert['projekt_idek'].'" '.$ert['projekt_id_nevek'].' orig_value="'.$ert['projekt_idek'].'">';
 
 echo '<td>Szerződésgazda';
 echo '<td colspan=3>';
 //echo $ert['szerz_usergazda_nev'];
 echo '<select orig_value="'.$ert['szerz_usergazda_ad'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_usergazdaad" class="select2_ajax" csonkolt=1 mod="admin_usergazda_mod" style="width:513px">';
 echo '<option value="'.$ert['szerz_usergazda_ad'].'">'.$ert['szerz_usergazda_nev'].' ('.$ert['szerz_usergazda_tsz'].', '.$ert['szerz_usergazda_ad'].')';
 if($ert['szerz_usergazda_inaktiv']=='1')echo ' - Inaktív';
 echo '</select>';
 
 echo '<td>Integrációban érintett';
 echo '<td>';
 //echo $ert['szerz_tetel_integ_erint_date'];
 //echo '<input orig_value="'.kidate_format_ev($ert['szerz_tetel_integ_erint_date']).'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" value="'.$ert['szerz_tetel_integ_erint_date'].'" id="admin_modszolgkapadat_integerintdate" class="date_tol" style="width:100px" type="text">';
 
 echo '<select orig_value="'.$ert['szerz_tetel_integ_erintett'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_integerintett" class="select3" style="width:120px">';
 echo '<option value="0"';
 if($ert['szerz_tetel_integ_erintett']=='0') echo ' selected';
 echo '>Nem';
 
 echo '<option value="1"';
 if($ert['szerz_tetel_integ_erintett']=='1') echo ' selected';
 echo '>Igen';
 echo '</select>';
 
echo '</tr>';
//Sor-6 - vége

//Sor-7 - eleje
echo '<tr>';
 echo '<td>Általános megjegyzés';
 echo '<td colspan=7>';
 echo '<textarea orig_value="'.$ert['szerz_tetel_megj'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_megj" rows="2" style="width:98%">';
 echo $ert['szerz_tetel_megj'];
 echo '</textarea>';
echo '</tr>';
//Sor-7 - vége

//Sor-8 - eleje
echo '<tr>';
 echo '<td>TT megjegyzés';
 echo '<td colspan=7>';
 echo '<textarea orig_value="'.$ert['szerz_tetel_tt_megj'].'" onchange="admin_szolgkapadat_mod_proc_urlap_valt()" onkeyup="admin_szolgkapadat_mod_proc_urlap_valt()" id="admin_modszolgkapadat_ttmegj" rows="2" style="width:98%">';
 echo $ert['szerz_tetel_tt_megj'];
 echo '</textarea>';
echo '</tr>';
//Sor-8 - vége

//Sor-8 - eleje
echo '<tr>';
 echo '<td>Szerződés elérése a hálózaton';
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

echo '</tbody>';
echo '</table>';

//echo '<span style="margin-top:10px;display:none;padding:3px;background-color:#6069ff;color:#fff" id="admin_szolgkapadat_mod_mezok">';
//echo '<span style="margin-top:10px;display:none;padding:3px;b1ackground-color:#C52A10;c1olor:#fff;border-radius:5px" id="admin_szolgkapadat_mod_mezok">';
echo '<span style="margin-top:10px;display:none;padding:5px;background-color:#D6D6D6;c1olor:#fff;border-radius:5px" id="admin_szolgkapadat_mod_mezok">';
echo 'Módosított mezők:';
echo '<ul style="margin:0px;cursor:pointer" id="admin_szolgkapadat_mod_proc_urlap_valt">';
echo '<li style="display:none" title="'.$ert['szerz_tetel_modszam_kezi'].'" id="lihiba_admin_modszolgkapadat_modszamkezi">Szerződés módosítás száma';
echo '<li style="display:none" title="'.$ert['szerz_csop_nev'].'" id="lihiba_admin_modszolgkapadat_szerzcsopid">Szolgáltatás csoport';
echo '<li style="display:none" title="'.$ert['szolg_kod'].' - '.$ert['szolg_kod_nev'].'" id="lihiba_admin_modszolgkapadat_szolgkod">Szolgáltatás kód';
echo '<li style="display:none" title="'.igennem_kod_ki_0nalis($ert['szerz_tetel_utok']).'" id="lihiba_admin_modszolgkapadat_tetelutok">Utókalkuláció';
echo '<li style="display:none" title="'.$ert['szerz_tetel_netto_szerzdij'].'" id="lihiba_admin_modszolgkapadat_nettoszerzdij">Nettó szerződés díj (eseti/maximális keret)';
echo '<li style="display:none" title="'.igennem_kod_ki_0nalis($ert['szerz_tetel_netto_szerzdij_nemrelevans']).'" id="lihiba_admin_modszolgkapadat_nettoszerzdij_nemrelevans">Nettó szerződés díj (eseti/maximális keret) - Nem releváns';

echo '<li style="display:none" title="'.kidate_format_ev($ert['szerz_tetel_arajanlat_alair_date']).'" id="lihiba_admin_modszolgkapadat_arajanlatalair">Árajánlat aláírás dátuma';
echo '<li style="display:none" title="'.kidate_format_ev($ert['szerz_tetel_alair_date']).'" id="lihiba_admin_modszolgkapadat_alairdate">Szerződés aláírás dátuma';

echo '<li style="display:none" title="'.kidate_format_ev($ert['szerz_tetel_szolg_kezd_date']).'" id="lihiba_admin_modszolgkapadat_szolgkezddate">Szolgáltásnyújtás megkezdésének időpontja';

echo '<li style="display:none" title="'.$ert['szerz_tetel_szolg_kezd_date_folyamatban'].'" id="lihiba_admin_modszolgkapadat_folyamatban">Folyamatban';

echo '<li style="display:none" title="'.$ert['szerz_tetel_netto_havidij'].'" id="lihiba_admin_modszolgkapadat_nettohavidij">Nettó szerződéses havidíj';
echo '<li style="display:none" title="'.$ert['szerz_tetel_netto_havidij_penznem'].'" id="lihiba_admin_modszolgkapadat_nettohavidij_penznem">Nettó szerződéses havidíj - Pénznem';
echo '<li style="display:none" title="'.$ert['szerz_elsz_tipus_nev'].'" id="lihiba_admin_modszolgkapadat_elsztipusid">Elszámolás típusa';
echo '<li style="display:none" title="'.$ert['szerz_tetel_oradij'].'" id="lihiba_admin_modszolgkapadat_oradij">Óradíj';
echo '<li style="display:none" title="'.igennem_kod_ki_0nalis($ert['szerz_tetel_oradij_nemrelevans']).'" id="lihiba_admin_modszolgkapadat_oradij_nemrelevans">Óradíj - Nem releváns';
echo '<li style="display:none" title="'.kidate_format_ev($ert['szerz_tetel_szolg_origveg_date']).'" id="lihiba_admin_modszolgkapadat_szolgorigvegdate">Szerződés időtartam eredeti (határozott esetén)';
echo '<li style="display:none" title="'.kidate_format_ev($ert['szerz_tetel_szolg_aktveg_date']).'" id="lihiba_admin_modszolgkapadat_szolgaktvegdate">Szerződés időtartam aktuális (határozott esetén)';
echo '<li style="display:none" title="'.$ert['szerz_tetel_netto_evesdij'].'" id="lihiba_admin_modszolgkapadat_nettoevesdij">Idei naptári évi éves díj';
echo '<li style="display:none" title="'.$ert['szerz_tetel_netto_evesdij_penznem'].'" id="lihiba_admin_modszolgkapadat_nettoevesdij_penznem">Idei naptári évi éves díj - Pénznem';
echo '<li style="display:none" title="'.$ert['szerz_naturalia_nev'].'" id="lihiba_admin_modszolgkapadat_naturaliaid">Naturália típus';
echo '<li style="display:none" title="'.kiosszeg_format_eur($ert['szerz_tetel_naturalia_darab']).'" id="lihiba_admin_modszolgkapadat_naturaliadarab">Naturália mennyiség (HAVI)';

echo '<li style="display:none" title="'.kidate_format_ev($ert['szerz_tetel_szolg_mod_date']).'" id="lihiba_admin_modszolgkapadat_szolgmoddate">Szerződésmódosítás hatályba lépésének dátuma';

echo '<li style="display:none" title="'.$ert['projekt_nevek'].'" id="lihiba_admin_ujszolgkapadat_projektid_hibajavitas">Tevékenységek';

echo '<li style="display:none" title="'.$ert['szerz_usergazda_nev'].' ('.$ert['szerz_usergazda_tsz'].', '.$ert['szerz_usergazda_ad'].')'.'" id="lihiba_admin_modszolgkapadat_usergazdaad">Szerződésgazda';
echo '<li style="display:none" title="'.igennem_kod_ki_0nalis($ert['szerz_tetel_integ_erintett']).'" id="lihiba_admin_modszolgkapadat_integerintett">Integrációban érintett';
echo '<li style="display:none" title="'.$ert['szerz_tetel_megj'].'" id="lihiba_admin_modszolgkapadat_megj">Általános megjegyzés';
echo '<li style="display:none" title="'.$ert['szerz_tetel_tt_megj'].'" id="lihiba_admin_modszolgkapadat_ttmegj">TT megjegyzés';
//echo '<li style="display:none" title="'.$ert['szerz_tetel_link'].'" id="lihiba_admin_modszolgkapadat_tetellink">Szerződés elérése a hálózaton';
echo '</ul>';
echo '</span>';
}

function keres_admin_szolgkapadat_egymodhoz($szerz_tetel_id,$szerz_tetel_adat_id){
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
 ,szerz_usergazda.szerz_usergazda_inaktiv 
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
		 
        ,(SELECT GROUP_CONCAT(szerz_tetel_adat_projekt.projekt_id SEPARATOR ',')
         FROM szerz_tetel_adat_projekt 
         WHERE szerz_tetel_adat_projekt.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id) AS projekt_idek
		 
		 /* === ÚJ OSZLOP: egyedi formázás, szóközökkel elválasztva === */
        ,(SELECT GROUP_CONCAT(CONCAT('projekt_id_', stp.projekt_id, '=\"', p.projekt_nev, '\"') SEPARATOR ' ')
          FROM szerz_tetel_adat_projekt stp 
          JOIN projekt p ON p.projekt_id = stp.projekt_id
          WHERE stp.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id) AS projekt_id_nevek
		 
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

function admin_szolgkapadat_mod_proc_urlap_mentes_proc(){
if(
 (isset($_POST['szerz_tetel_id']))and
 (isset($_POST['szerz_tetel_adat_id']))
){

mysqli_autocommit($GLOBALS['mysqli'],false);

//Ellenőrzés - eleje
$ret='';

if((isset($_POST['szerz_tetel_arajanlat_alair']))and($_POST['szerz_tetel_arajanlat_alair']!='')and(!checkmydate($_POST['szerz_tetel_arajanlat_alair']))){
 $ret.='<li>Árajánlat aláírás dátuma hibás!';
}

if((isset($_POST['szerz_tetel_alair_date']))and($_POST['szerz_tetel_alair_date']!='')and(!checkmydate($_POST['szerz_tetel_alair_date']))){
 $ret.='<li>Szerződés aláírás dátuma hibás!';
}

if((isset($_POST['szerz_tetel_szolg_kezd_date']))and($_POST['szerz_tetel_szolg_kezd_date']!='')and(!checkmydate($_POST['szerz_tetel_szolg_kezd_date']))){
 $ret.='<li>Szolgáltásnyújtás megkezdésének időpontja - eredeti dátum hibás!';
}
if((isset($_POST['szerz_tetel_szolg_origveg_date']))and($_POST['szerz_tetel_szolg_origveg_date']!='')and(!checkmydate($_POST['szerz_tetel_szolg_origveg_date']))){
 $ret.='<li>Szerződés időtartam vége eredeti (határozott esetén) dátum hibás!';
}
if((isset($_POST['szerz_tetel_szolg_aktveg_date']))and($_POST['szerz_tetel_szolg_aktveg_date']!='')and(!checkmydate($_POST['szerz_tetel_szolg_aktveg_date']))){
 $ret.='<li>Szerződés időtartam vége aktuális (határozott esetén) dátum hibás!';
}
if((isset($_POST['szerz_tetel_szolg_mod_date']))and($_POST['szerz_tetel_szolg_mod_date']!='')and(!checkmydate($_POST['szerz_tetel_szolg_mod_date']))){
 $ret.='<li>Szerződésmódosítás hatályba lépésének dátuma hibás!';
}

if($ret!=''){
 echo 'nook$;$';
 echo '<b>Hibajavítás mentése sikertelen!</b><br>';
 echo '<ul>';
 echo $ret;
 echo '</ul>';
 exit;
}
//Ellenőrzés - vége


 if(
 (isset($_POST['szerz_tetel_szolg_kezd_date']))or
 (isset($_POST['szerz_tetel_szolg_kezd_date_folyamatban']))or
 (isset($_POST['szerz_tetel_szolg_origveg_date']))
 ){
  $tmp_moda=array();
  if((isset($_POST['szerz_tetel_szolg_kezd_date']))and($_POST['szerz_tetel_szolg_kezd_date']!=''))
   $tmp_moda[0]['szerz_tetel_szolg_kezd_date']=str_replace(".","-",$_POST['szerz_tetel_szolg_kezd_date']);
  else $tmp_moda[0]['szerz_tetel_szolg_kezd_date']=null;
  
  if((isset($_POST['szerz_tetel_szolg_origveg_date']))and($_POST['szerz_tetel_szolg_origveg_date']!=''))
   $tmp_moda[0]['szerz_tetel_szolg_origveg_date']=str_replace(".","-",$_POST['szerz_tetel_szolg_origveg_date']);
  else $tmp_moda[0]['szerz_tetel_szolg_origveg_date']=null;

  if(isset($_POST['szerz_tetel_szolg_kezd_date_folyamatban']))
   $tmp_moda[0]['szerz_tetel_szolg_kezd_date_folyamatban']=$_POST['szerz_tetel_szolg_kezd_date_folyamatban'];
  mod_egy_fel_tom('szerz_tetel',$tmp_moda[0],"szerz_tetel_id",$_POST['szerz_tetel_id']);
 }
 
 
 
 $tmp_mod=array();
 if(isset($_POST['szerz_tetel_modszam_kezi']))$tmp_mod[0]['szerz_tetel_modszam_kezi']=$_POST['szerz_tetel_modszam_kezi'];
 if(isset($_POST['szerz_csop_id']))$tmp_mod[0]['szerz_csop_id']=$_POST['szerz_csop_id'];
 if(isset($_POST['szolg_kod']))$tmp_mod[0]['szolg_kod']=$_POST['szolg_kod'];
 if(isset($_POST['szerz_tetel_utok']))$tmp_mod[0]['szerz_tetel_utok']=$_POST['szerz_tetel_utok'];
 
 if(isset($_POST['szerz_tetel_netto_szerzdij'])){
  if($_POST['szerz_tetel_netto_szerzdij']!=''){
	 $tmp_mod[0]['szerz_tetel_netto_szerzdij']=$_POST['szerz_tetel_netto_szerzdij'];
  }else{
	 $tmp_mod[0]['szerz_tetel_netto_szerzdij']=null;
  }
 }
 
 if(isset($_POST['nettoszerzdij_nemrelevans'])){
	if($_POST['nettoszerzdij_nemrelevans']=='1'){
	  $tmp_mod[0]['szerz_tetel_netto_szerzdij_nemrelevans']='1';
	  $tmp_mod[0]['szerz_tetel_netto_szerzdij']=null;
	}else{
		$tmp_mod[0]['szerz_tetel_netto_szerzdij_nemrelevans']=null;
	}
 }
 
 if(isset($_POST['szerz_tetel_netto_havidij'])){
	if($_POST['szerz_tetel_netto_havidij']!=''){
	 $tmp_mod[0]['szerz_tetel_netto_havidij']=$_POST['szerz_tetel_netto_havidij'];
	}else{
	 $tmp_mod[0]['szerz_tetel_netto_havidij']=null;
	}
 }
 
 if(isset($_POST['szerz_tetel_netto_havidij_penznem']))$tmp_mod[0]['szerz_tetel_netto_havidij_penznem']=$_POST['szerz_tetel_netto_havidij_penznem'];

 if(isset($_POST['szerz_elsz_tipus_id']))$tmp_mod[0]['szerz_elsz_tipus_id']=$_POST['szerz_elsz_tipus_id'];
 
 if(isset($_POST['szerz_tetel_oradij'])){
	if($_POST['szerz_tetel_oradij']!=''){ 
	 $tmp_mod[0]['szerz_tetel_oradij']=$_POST['szerz_tetel_oradij'];
	}else{
	 $tmp_mod[0]['szerz_tetel_oradij']=null;
	}
 }

 if(isset($_POST['oradij_nemrelevans'])){
	if($_POST['oradij_nemrelevans']=='1'){
	 $tmp_mod[0]['szerz_tetel_oradij_nemrelevans']='1';
	 $tmp_mod[0]['szerz_tetel_oradij']=null;
	}else{
	 $tmp_mod[0]['szerz_tetel_oradij_nemrelevans']=null;
	}
 }
 
 if(isset($_POST['szerz_tetel_netto_evesdij'])){
	if($_POST['szerz_tetel_netto_evesdij']!=''){
	 $tmp_mod[0]['szerz_tetel_netto_evesdij']=$_POST['szerz_tetel_netto_evesdij'];
	}else{
	 $tmp_mod[0]['szerz_tetel_netto_evesdij']=null;
	}
 }
 
 if(isset($_POST['szerz_naturalia_id']))$tmp_mod[0]['szerz_naturalia_id']=$_POST['szerz_naturalia_id'];
 
 if(isset($_POST['szerz_tetel_naturalia_darab'])){
	if($_POST['szerz_tetel_naturalia_darab']!=''){
	 $tmp_mod[0]['szerz_tetel_naturalia_darab']=$_POST['szerz_tetel_naturalia_darab'];
	}else{
	 $tmp_mod[0]['szerz_tetel_naturalia_darab']=null;	
	}
 }

 if(isset($_POST['szerz_tetel_arajanlat_alair'])){
  if($_POST['szerz_tetel_arajanlat_alair']==''){
   $tmp_mod[0]['szerz_tetel_arajanlat_alair']=null;
  }else{
	  $tmp_mod[0]['szerz_tetel_arajanlat_alair_date']=str_replace(".","-",$_POST['szerz_tetel_arajanlat_alair']);
  }
 }

 if(isset($_POST['szerz_tetel_alair_date'])){
  if($_POST['szerz_tetel_alair_date']==''){
   $tmp_mod[0]['szerz_tetel_alair_date']=null;
  }else{
	  $tmp_mod[0]['szerz_tetel_alair_date']=str_replace(".","-",$_POST['szerz_tetel_alair_date']);
  }
 }

 if(isset($_POST['szerz_tetel_szolg_aktveg_date'])){
  if($_POST['szerz_tetel_szolg_aktveg_date']==''){
   $tmp_mod[0]['szerz_tetel_szolg_aktveg_date']=null;
  }else{
	  $tmp_mod[0]['szerz_tetel_szolg_aktveg_date']=str_replace(".","-",$_POST['szerz_tetel_szolg_aktveg_date']);
  }
 }
 
 if(isset($_POST['szerz_tetel_szolg_mod_date'])){
  if($_POST['szerz_tetel_szolg_mod_date']==''){
   $tmp_mod[0]['szerz_tetel_szolg_mod_date']=null;
  }else{
	  $tmp_mod[0]['szerz_tetel_szolg_mod_date']=str_replace(".","-",$_POST['szerz_tetel_szolg_mod_date']);
  }
 }

 if(isset($_POST['szerz_usergazda_ad']))$tmp_mod[0]['szerz_usergazda_ad']=$_POST['szerz_usergazda_ad'];
 
 if(isset($_POST['szerz_tetel_integ_erintett'])){
  if($_POST['szerz_tetel_integ_erintett']!='') 
   $tmp_mod[0]['szerz_tetel_integ_erintett']=$_POST['szerz_tetel_integ_erintett'];
  else $tmp_mod[0]['szerz_tetel_integ_erintett']=null;
 }
 
 if(isset($_POST['szerz_tetel_megj']))$tmp_mod[0]['szerz_tetel_megj']=$_POST['szerz_tetel_megj'];
 if(isset($_POST['szerz_tetel_tt_megj']))$tmp_mod[0]['szerz_tetel_tt_megj']=$_POST['szerz_tetel_tt_megj'];
 //if(isset($_POST['szerz_tetel_link']))$tmp_mod[0]['szerz_tetel_link']=$_POST['szerz_tetel_link'];
 
 
 //$_POST['szerz_tetel_adat_id']
 //projekt_id módosítása
  if(isset($_POST['projektid'])){
 //if(!empty($_POST['projektid'])) {	 
  torles('szerz_tetel_adat_projekt','szerz_tetel_adat_id',$_POST['szerz_tetel_adat_id']);
  if($_POST['projektid']!=''){
  $projekt_id_tomb = explode(',',$_POST['projektid']);
  if(is_array($projekt_id_tomb)){
  foreach($projekt_id_tomb as $id){
   $tiszta_id = trim($id);
   if($tiszta_id!==''){
	$tmp_projekt[] = [
                'projekt_id' => $tiszta_id,
                'szerz_tetel_adat_id' => $_POST['szerz_tetel_adat_id']
            ];   
   }
  }
  be_visz_replace('szerz_tetel_adat_projekt',$tmp_projekt);
  }
  }
 }
 
 if((isset($tmp_mod))and(sizeof($tmp_mod)!='0')){
  mod_egy_fel_tom2('szerz_tetel_adat',$tmp_mod[0],'szerz_tetel_adat_id',$_POST['szerz_tetel_adat_id'],"szerz_tetel_id",$_POST['szerz_tetel_id']);
  echo 'ok$;$';
 }elseif((isset($tmp_moda))and(sizeof($tmp_moda)!='0')){
	echo 'ok$;$'; 
 }else{//Ekkor elvileg cska projektid módosítás történt
	echo 'ok$;$';  
 }

 mysqli_commit($GLOBALS['mysqli']);
 mysqli_autocommit($GLOBALS['mysqli'],true);

}else{
 echo 'adathiány';
}
}

?>