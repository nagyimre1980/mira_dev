<?php

function admin_szerz_tigadat_nemszerz(){
echo 'ok$;$';
admin_szerz_tigadat_nemszerz_urlap();
admin_szerz_tigadatnemszerz_kereses();
echo '<div id="admin_uj_tigadatnemszerz_list_keres_tal" style="overflow-x:auto">';
admin_tigadatnemszerz_user_list();
echo '</div>';
}

function admin_szerz_tigadat_nemszerz_urlap(){
echo '<div class="div_kereshez">';
echo '<b>Új nem szerződés alapján TIG-elendő tétel:</b>';

echo '<table class="table_emre_kek">';
echo '<tbody>';

//ÉV
echo '<tr>';
echo '<td>Év';
echo '<td>';
echo '<select id="admin_ujtigadatnemszerz_ev" class="select3" style="width:60px">';
$ev_most=date('Y',time());
for($i='2026';$i<=$ev_most;$i++){
 echo '<option value="'.$i.'"';
 if($i==$ev_most) echo ' selected';
 echo '>'.$i;
}
echo '</select>';

//Szerződéses összeg EUR-ban
echo '<td>Szerződéses összeg EUR-ban';
echo '<td>';
echo '<input id="admin_ujtigadatnemszerz_szerzosszeg" class="number_penz_2tizedes" style="width:130px" value="" maxlength="15" type="text">';

echo '</tr>';

//HÓ
echo '<tr>';
echo '<td>Hó *';
echo '<td>';
echo '<select id="admin_ujtigadatnemszerz_ho" class="select3" style="width:110px">';
echo '<option value="keremv">Kérem válassz';
for($i='1';$i<='12';$i++){
 echo '<option value="'.$i.'"';
 if($i==$ev_most) echo ' selected';
 echo '>'.$i;
}
echo '</select>';

//Havi Összeg Forintban
echo '<td>Havi összeg forintban (nettó)';
echo '<td>';
echo '<input id="admin_ujtigadatnemszerz_haviosszeg" class="number_penz" style="width:130px" value="" maxlength="13" type="text">';

echo '</tr>';

//Megrendelő
echo '<tr>';
echo '<td>Megrendelő *';
echo '<td>';
 echo '<select id="admin_ujtigadatnemszerz_tagvkod" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';

//Havi Összeg Forintban 1. módosítás
echo '<td>Havi összeg forintban 1. módosítás (nettó)';
echo '<td>';
echo '<input id="admin_ujtigadatnemszerz_haviosszegmod1" class="number_penz" style="width:130px" value="" maxlength="13" type="text">';

echo '</tr>';

//Szerződés típus
echo '<tr>';
echo '<td>Szerződés típus *';
echo '<td>';
 echo '<select id="admin_ujtigadatnemszerz_szerztipusid" class="select2_ajax" csonkolt=1 mod="admin_szerztipus_ujall" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';

//Havi Összeg Forintban 2. módosítás
echo '<td>Havi Összeg Forintban 2. módosítás (nettó)';
echo '<td>';
echo '<input id="admin_ujtigadatnemszerz_haviosszegmod2" class="number_penz" style="width:130px" value="" maxlength="13" type="text">';

echo '</tr>';

//Szolgáltatás
echo '<tr>';
echo '<td>Szolgáltatás *';
echo '<td>';
 echo '<select id="admin_ujtigadatnemszerz_szolgkod" class="select2_ajax" csonkolt=1 mod="admin_szolgkod_uj" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';

echo '<td>Devizanem';
echo '<td>';
 echo '<select id="admin_ujtigadatnemszerz_devizanem" class="select2_ajax" csonkolt=1 mod="admin_devizanem_uj" style="width:70px">';
 echo '<option value="HUF" selected>HUF';
 echo '</select>';

echo '</tr>';

echo '<tr>';
echo '<td>Szerződés *';
echo '<td>';
 echo '<select id="admin_ujtigadatnemszerz_szerzodes" class="select3" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '<option value="van">'.szerz_tigadatnemszerz_szerzodes_ki('van');
 echo '<option value="nincs">'.szerz_tigadatnemszerz_szerzodes_ki('nincs');
 echo '<option value="megszunt">'.szerz_tigadatnemszerz_szerzodes_ki('megszunt');
 echo '</select>';

echo '<td>CO objektum';
echo '<td>';
echo '<input id="admin_ujtigadatnemszerz_co" style="width:130px" value="" maxlength="14" type="text">';

echo '</tr>';

//Elszámolás módja
echo '<tr>';
echo '<td>Elszámolás módja *';
echo '<td>';
 echo '<select id="admin_ujtigadatnemszerz_elsztipus" class="select2_ajax" csonkolt=1 mod="admin_elsztipus_uj" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';

echo '<td colspan=2 align=center>';
echo '<input id="admin_ujtigadatnemszerz_submit" onclick="admin_ujtigadatnemszerz()" value="Új adat felvitele" class="submit2" type=submit>';
echo '</tr>';

echo '</tbody>';
echo '</table>';
echo '</div>';
}

function admin_tigadatnemszerzlist_keres(){
if(isset($_POST['ev']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ev']=$_POST['ev'];
if(isset($_POST['ho']))$_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ho']=$_POST['ho'];
echo "ok$;$";
admin_tigadatnemszerz_user_list();
}

function admin_szerz_tigadatnemszerz_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ev']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ev']!=""))
 $ker_ev=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ev'];
else $ker_ev="";
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ho']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ho']!=""))
 $ker_ho=$_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ho'];
else $ker_ho="";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_tigadatsapszamlist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Év';
echo '<td>';
echo '<select onchange="admin_tigadatnemszerzlist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatnemszerzlist_keres_ev" class="select3" style="width:60px">';
$startYear = (int) date('Y');
$endYear = 2024;
for ($ev = $startYear; $ev >= $endYear; $ev--) {
    echo "<option value='".$ev."'";
	if($ker_ev==$ev) echo ' selected';
	echo ">".$ev;
}
echo '</select>';

echo '<td>Hó';
echo '<td>';
echo '<select onchange="admin_tigadatnemszerzlist_keres_proc(\'tallep_elso\',\'\')" id="admin_tigadatnemszerzlist_keres_ho" class="select3" style="width:80px">';
echo "<option value='all'>Összes";
for ($ho = 1; $ho <= 12; $ho++) {
    echo "<option value='".$ho."'";
	if($ker_ho==$ho) echo ' selected';
	echo ">".$ho;
}
echo '</select>';

echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_tigadatnemszerz_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_tigadatnemszerz_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<div id="scroll1" style="overflow-x:auto;">';
echo '<div></div>';
echo '</div>';
echo '<div id="scroll2" style="overflow-x:auto;">';
echo '<table id="admin_tigadatnemszerzlist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz_tig_nemszerz.szerz_tig_nemszerz_id";
echo "<th style='width:40px' class='link' onclick='admin_tigadatnemszerzlist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_tigadatnemszerzlist_keres_order','admin_tigadatnemszerzlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tig_nemszerz.szerz_tig_nemszerz_evho";
echo "<th style='width:40px' class='link' onclick='admin_tigadatnemszerzlist_keres_proc(\"order\",\"".$order_mezo."\")'>Év-Hó ";
echo tabl_nyilak('admin_tigadatnemszerzlist_keres_order','admin_tigadatnemszerzlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tig_nemszerz.szerz_tig_nemszerz_tagv_kod";
echo "<th style='width:40px' class='link' onclick='admin_tigadatnemszerzlist_keres_proc(\"order\",\"".$order_mezo."\")'>Megrendelő ";
echo tabl_nyilak('admin_tigadatnemszerzlist_keres_order','admin_tigadatnemszerzlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tipus.szerz_tipus_nev";
echo "<th style='width:40px' class='link' onclick='admin_tigadatnemszerzlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés típus ";
echo tabl_nyilak('admin_tigadatnemszerzlist_keres_order','admin_tigadatnemszerzlist_keres_order_mod',$order_mezo);

$order_mezo="mira_szolg_kod.szolg_kod_nev";
echo "<th style='width:40px' class='link' onclick='admin_tigadatnemszerzlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szolgáltatás ";
echo tabl_nyilak('admin_tigadatnemszerzlist_keres_order','admin_tigadatnemszerzlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tig_nemszerz.szerz_tig_nemszerz_szerzodes";
echo "<th style='width:40px' class='link' onclick='admin_tigadatnemszerzlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés ";
echo tabl_nyilak('admin_tigadatnemszerzlist_keres_order','admin_tigadatnemszerzlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_elsz_tipus.szerz_elsz_tipus_nev";
echo "<th style='width:40px' class='link' onclick='admin_tigadatnemszerzlist_keres_proc(\"order\",\"".$order_mezo."\")'>Elszámolás módja ";
echo tabl_nyilak('admin_tigadatnemszerzlist_keres_order','admin_tigadatnemszerzlist_keres_order_mod',$order_mezo);

echo '<th>Szerződéses összeg<br>EUR-ban';
echo '<th>Havi összeg<br>forintban (nettó)';
echo '<th>Havi összeg forintban<br>1. módosítás (nettó)';
echo '<th>Havi összeg forintban<br>2. módosítás (nettó)';
echo '<th>Devizanem';
echo '<th>CO objektum';

echo '</tr></thead><tbody>';

admin_tigadatnemszerz_user_list_tal($tomb);

echo '</tbody></table></div>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_tigadatnemszerz','admin_tigadatnemszerzlist_keres_talszam','admin_tigadatnemszerzlist_keres_proc');

}

function admin_tigadatnemszerz_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr id="tr_tigadatnemszerz_'.$ert['id'].'">';
 
 echo '<td>';
 echo $ert['id'];
 
 echo '<td>';
 echo '<img onclick="admin_modtigadatnemszerz_del(\''.$ert['id'].'\')" src="image/del.png" title="Törlés" class="linkimg_tooltip" style="margin-right:5px">';
 echo $ert['evho'];
 
 echo '<td>';
 echo '<select onchange="admin_modtigadatnemszerz_ment(\''.$ert['id'].'\')" id="admin_modtigadatnemszerz_tagvkod_'.$ert['id'].'" class="select2_ajax" csonkolt="1" mod="admin_tagvkod_all" style="width:240px">';
 echo '<option value="'.$ert['tagv_kod'].'" selected>'.$ert['tagv_kod'].' - '.$ert['tagv_kod_nev'];
 echo '</select>';
 
 echo '<td>';
 echo '<select onchange="admin_modtigadatnemszerz_ment(\''.$ert['id'].'\')" id="admin_modtigadatnemszerz_szerztipusid_'.$ert['id'].'" class="select2_ajax" csonkolt="1" mod="admin_szerztipus_mod" style="width:160px">';
 echo '<option value="'.$ert['szerz_tipus_id'].'" selected>'.$ert['szerz_tipus_nev'];
 echo '</select>';
 
 //Szolgáltatás
 echo '<td>';
 echo '<select onchange="admin_modtigadatnemszerz_ment(\''.$ert['id'].'\')" id="admin_modtigadatnemszerz_szolgkod_'.$ert['id'].'" class="select2_ajax" csonkolt="1" mod="admin_szolgkod" style="width:240px">';
 echo '<option value="'.$ert['szolg_kod'].'" selected>'.$ert['szolg_kod'].' - '.$ert['szolg_kod_nev'];
 echo '</select>';
 
 //Szerződés 
 echo '<td>';
 echo '<select onchange="admin_modtigadatnemszerz_ment(\''.$ert['id'].'\')" id="admin_modtigadatnemszerz_szerzodes_'.$ert['id'].'" class="select3" style="width:90px">';
 echo '<option value="van"';
 if($ert['szerz_tig_nemszerz_szerzodes']=='van') echo ' selected';
 echo '>'.szerz_tigadatnemszerz_szerzodes_ki('van');
 
 echo '<option value="nincs"';
 if($ert['szerz_tig_nemszerz_szerzodes']=='nincs') echo ' selected';
 echo '>'.szerz_tigadatnemszerz_szerzodes_ki('nincs');
 
 echo '<option value="megszunt"';
 if($ert['szerz_tig_nemszerz_szerzodes']=='megszunt') echo ' selected';
 echo '>'.szerz_tigadatnemszerz_szerzodes_ki('megszunt');
 
 echo '</select>';
 
 //Elszámolás módja
 echo '<td>';
 echo '<select onchange="admin_modtigadatnemszerz_ment_proc(\''.$ert['id'].'\')" id="admin_modtigadatnemszerz_elsztipus_'.$ert['id'].'" class="select2_ajax" csonkolt="1" mod="admin_elsztipus_mod" style="width:130px">';
 echo '<option value="'.$ert['elsz_tipus_id'].'" selected>'.$ert['szerz_elsz_tipus_nev'];
 echo '</select>';
 
 //Szerződéses összeg EUR-ban
 echo '<td>';
 echo '<input onkeyup="admin_modtigadatnemszerz_ment(\''.$ert['id'].'\')" id="admin_modtigadatnemszerz_szerzosszeg_'.$ert['id'].'" value="'.str_replace('.',',',$ert['szerzosszeg']).'" class="number_penz_2tizedes" style="width:153px" maxlength="15" type="text">';
 
 //Havi összeg forintban
 echo '<td>';
 echo '<input onkeyup="admin_modtigadatnemszerz_ment(\''.$ert['id'].'\')" id="admin_modtigadatnemszerz_haviosszeg_'.$ert['id'].'" value="'.$ert['haviosszeg'].'" class="number_penz" style="width:125px" maxlength="15" type="text">';
 
 //Havi összeg forintban 1.
 echo '<td>';
 echo '<input onkeyup="admin_modtigadatnemszerz_ment(\''.$ert['id'].'\')" id="admin_modtigadatnemszerz_haviosszeg_mod1_'.$ert['id'].'" value="'.$ert['haviosszeg_mod1'].'" class="number_penz" style="width:125px" maxlength="15" type="text">';

 //Havi összeg forintban 2.
 echo '<td>';
 echo '<input onkeyup="admin_modtigadatnemszerz_ment(\''.$ert['id'].'\')" id="admin_modtigadatnemszerz_haviosszeg_mod2_'.$ert['id'].'" value="'.$ert['haviosszeg_mod2'].'" class="number_penz" style="width:125px" maxlength="15" type="text">';

 //Devizanem
 echo '<td>';
 echo '<select onchange="admin_modtigadatnemszerz_ment_proc(\''.$ert['id'].'\')" id="admin_modtigadatnemszerz_penznem_'.$ert['id'].'" class="select2_ajax" csonkolt=1 mod="admin_devizanem_uj" style="width:70px">';
 echo '<option value="'.$ert['penznem'].'" selected>'.$ert['penznem'];
 echo '</select>';

 //CO
 echo '<td>';
 echo '<input onkeyup="admin_modtigadatnemszerz_ment(\''.$ert['id'].'\')" id="admin_modtigadatnemszerz_co_'.$ert['id'].'" value="'.$ert['co'].'" style="width:130px" maxlength="14" type="text">';

 echo '</tr>';
}
}
}
}

function admin_ujtigadatnemszerz(){
if((!isset($_POST['ev']))or(
(isset($_POST['ev'])and
($_POST['ev']==""))
)){
 echo "nook$;$"."Év megadása kötelező!";
 exit;
}
if((!isset($_POST['ho']))or(

(isset($_POST['ho'])and
($_POST['ho']==""))
)){
 echo "nook$;$"."Hó megadása kötelező!";
 exit;
}

//2: Van-e Ilyen Elszámolás típusa
//$penznem=keres_mit1_mit1('szerz_tig_nemszerz','penznem',$_POST['penznem'],'penznem');
//if(is_array($penznem)){
// echo 'nook$;$Hiba! Van már ilyen Devizanem kódja!';
// exit;
//}else{
 $tmp_bk=array();
 if($_POST['ho']<9)$_POST['ho']='0'.$_POST['ho'];
 $tmp_bk[0]['szerz_tig_nemszerz_evho']=$_POST['ev'].'-'.$_POST['ho'].'-01';
 $tmp_bk[0]['szerz_tig_nemszerz_tagv_kod']=$_POST['tagvkod'];
 $tmp_bk[0]['szerz_tig_nemszerz_szerz_tipus_id']=$_POST['szerztipusid'];
 $tmp_bk[0]['szerz_tig_nemszerz_szolg_kod']=$_POST['szolgkod'];
 $tmp_bk[0]['szerz_tig_nemszerz_szerzodes']=$_POST['szerzodes'];
 $tmp_bk[0]['szerz_tig_nemszerz_szerzodes']=$_POST['szerzodes'];
 $tmp_bk[0]['szerz_tig_nemszerz_elsz_tipus_id']=$_POST['elsztipus'];
 $tmp_bk[0]['szerz_tig_nemszerz_szerzosszeg']=$_POST['szerzosszeg'];
 $tmp_bk[0]['szerz_tig_nemszerz_haviosszeg']=$_POST['haviosszeg'];
 $tmp_bk[0]['szerz_tig_nemszerz_haviosszeg_mod1']=$_POST['haviosszegmod1'];
 $tmp_bk[0]['szerz_tig_nemszerz_haviosszeg_mod2']=$_POST['haviosszegmod2'];
 $tmp_bk[0]['szerz_tig_nemszerz_penznem']=$_POST['devizanem'];
 $tmp_bk[0]['szerz_tig_nemszerz_co']=$_POST['co'];
 be_visz_insert('szerz_tig_nemszerz',$tmp_bk);

 echo 'ok$;$';
//}
}

function admin_modtigadatnemszerz_del(){
if((isset($_POST['id']))and($_POST['id']!='')){
 torles('szerz_tig_nemszerz','szerz_tig_nemszerz_id',$_POST['id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_modtigadatnemszerz_ment(){
if(
 (isset($_POST['id']))and
 ($_POST['id']!='')
){

 $tmp_mod=array();
 if((isset($_POST['tagvkod']))and($_POST['tagvkod']!='')){
  $tmp_mod[0]['szerz_tig_nemszerz_tagv_kod']=$_POST['tagvkod'];
 }
 
 if((isset($_POST['szerztipusid']))and($_POST['szerztipusid']!='')){
  $tmp_mod[0]['szerz_tig_nemszerz_szerz_tipus_id']=$_POST['szerztipusid'];
 }

 if((isset($_POST['szolgkod']))and($_POST['szolgkod']!='')){
  $tmp_mod[0]['szerz_tig_nemszerz_szolg_kod']=$_POST['szolgkod'];
 }

 if((isset($_POST['szerzodes']))and($_POST['szerzodes']!='')){
  $tmp_mod[0]['szerz_tig_nemszerz_szerzodes']=$_POST['szerzodes'];
 }

 if((isset($_POST['elsztipus']))and($_POST['elsztipus']!='')){
  $tmp_mod[0]['szerz_tig_nemszerz_elsz_tipus_id']=$_POST['elsztipus'];
 }

 if((isset($_POST['szerzosszeg']))and($_POST['szerzosszeg']!='')){
  //$tmp_mod[0]['szerz_tig_nemszerz_szerzosszeg']=str_replace('.',',',$_POST['szerzosszeg']);
  $tmp_mod[0]['szerz_tig_nemszerz_szerzosszeg']=$_POST['szerzosszeg'];
 }

 if((isset($_POST['haviosszeg']))and($_POST['haviosszeg']!='')){
  $tmp_mod[0]['szerz_tig_nemszerz_haviosszeg']=$_POST['haviosszeg'];
 }

 if((isset($_POST['haviosszeg_mod1']))and($_POST['haviosszeg_mod1']!='')){
  $tmp_mod[0]['szerz_tig_nemszerz_haviosszeg_mod1']=$_POST['haviosszeg_mod1'];
 }

 if((isset($_POST['haviosszeg_mod2']))and($_POST['haviosszeg_mod2']!='')){
  $tmp_mod[0]['szerz_tig_nemszerz_haviosszeg_mod2']=$_POST['haviosszeg_mod2'];
 }

 if((isset($_POST['haviosszeg_mod2']))and($_POST['penznem']!='')){
  $tmp_mod[0]['szerz_tig_nemszerz_penznem']=$_POST['penznem'];
 }

 if((isset($_POST['co']))and($_POST['co']!='')){
  $tmp_mod[0]['szerz_tig_nemszerz_co']=$_POST['co'];
 }

 mod_egy_fel_tom('szerz_tig_nemszerz',$tmp_mod[0],'szerz_tig_nemszerz_id',$_POST['id']);
 echo 'ok$;$';

}else{
 echo 'adathiány';
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