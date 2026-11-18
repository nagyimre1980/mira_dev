<?php

function admin_szerz_szerzalapadat(){
echo 'ok$;$';
admin_szerz_szerzalapadat_urlap();
admin_szerz_szerzalapadat_kereses();
echo '<div id="admin_uj_szerzalapadat_list_keres_tal" style="overflow-x:auto">';
admin_szerzalapadat_user_list();
echo '</div>';
}

function admin_szerz_szerzalapadat_urlap(){
echo '<div class="div_kereshez">';
echo '<b>Új szerződéses alapadat:</b>';

echo '<table class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Társaság *';
echo '<td>';
 echo '<select id="admin_ujszerzalapadat_tagvkod" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<td>Keretszerződés *';
echo '<td>';
echo '<select onchange="select2_torles_def(\'admin_ujszerzalapadat_szerztipusid\',\'keremv\')" id="admin_ujszerzalapadat_szerzkeret" class="select3" style="width:120px">';
 echo '<option value="keremv">Kérem válassz';
 echo '<option value="0">Nem';
 echo '<option value="1">Igen';
echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<td>Szerződés típus *';
echo '<td>';
 echo '<select id="admin_ujszerzalapadat_szerztipusid" class="select2_ajax" csonkolt=1 mit_id="admin_ujszerzalapadat_szerzkeret" mod="admin_szerztipus_uj" style="width:411px">';
 echo '<option value="keremv">Kérem válassz';
 echo '</select>';
echo '</tr>';

echo '<tr>';
echo '<td>Szerződés hatályba<br>lépésének időpontja *';
echo '<td>';
echo '<input id="admin_ujszerzalapadat_datehatalybelep" class="date_tol" style="width:100px" type="text">';
echo '</tr>';

echo '<tr>';
echo '<td>Megjegyzés';
echo '<td>';
echo '<textarea id="admin_ujszerzalapadat_megj" rows="2" style="width:98%">';
echo '</textarea>';

echo '</tr>';

echo '<tr><td colspan=2 align=left><input id="admin_ujszerzalapadat_submit" onclick="admin_ujszerzalapadat()" value="Új szerződéses alapadat felvitele" class="submit2" type=submit></tr>';
echo '</tbody>';
echo '</table>';
echo '</div>';
}

function admin_szerzalapadatlist_keres(){
if(isset($_POST['tagv_kod']))$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['tagv_kod']=$_POST['tagv_kod'];
if(isset($_POST['szerz_keret']))$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerz_keret']=$_POST['szerz_keret'];
if(isset($_POST['szerztipusid']))$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerztipusid']=$_POST['szerztipusid'];
if(isset($_POST['sapszam']))$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['sapszam']=$_POST['sapszam'];
echo 'ok$;$';
admin_szerzalapadat_user_list();
}

function admin_szerz_szerzalapadat_kereses(){
if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['tagv_kod']!="all"))
 $ker_tagv_kod=$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['tagv_kod'];
else $ker_tagv_kod="all";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerz_keret']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerz_keret']!="all"))
 $ker_szerzkeret=$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerz_keret'];
else $ker_szerzkeret="all";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerztipusid']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerztipusid']!="all"))
 $ker_szerztipusid=$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerztipusid'];
else $ker_szerztipusid="all";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['sapszam']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['sapszam']!=""))
 $ker_sapszam=$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['sapszam'];
else $ker_sapszam="";

echo '<div class="div_kereshez"><b>Keresés</b>';
echo '<table id="admin_szerzalapadatlist_table" class="table_emre_kek">';
echo '<tbody>';
echo '<tr>';
echo '<td>Társaság';
echo '<td>';
echo '<select onchange="admin_szerzalapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szerzalapadatlist_keres_tagv" class="select2_ajax" csonkolt=1 mod="admin_tagvkod_uj_all" style="width:311px">';
if($ker_tagv_kod!='all'){
 $ker_tagv_kod_nev=keres_mit1_mit1_csak_ertek('mira_tagv_kod','tagv_kod',$ker_tagv_kod,'tagv_kod_nev');
 echo '<option value="'.$ker_tagv_kod.'">'.$ker_tagv_kod.' - '.$ker_tagv_kod_nev;
}else{
 echo '<option value="all">Összes';
}
echo '</select>';

echo '<td>Keretszerződés';
echo '<td>';
echo '<select onchange="admin_szerzalapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szerzalapadatlist_keres_szerzkeret" class="select3" style="width:80px">';
 echo '<option value="all"';
 if($ker_szerzkeret=='all')echo ' selected';
 echo '>Összes';
 
 echo '<option value="0"';
 if($ker_szerzkeret=='0')echo ' selected';
 echo '>Nem';
 
 echo '<option value="1"';
 if($ker_szerzkeret=='1')echo ' selected';
 echo '>Igen';
echo '</select>';

echo '<td>Szerződés típus';
echo '<td>';
echo '<select onchange="admin_szerzalapadatlist_keres_proc(\'tallep_elso\',\'\')" id="admin_szerzalapadatlist_keres_szerztipusid" class="select2_ajax" csonkolt=1 mod="admin_szerztipus_keres" style="width:311px">';
if($ker_szerztipusid!='all'){
 $ker_szerztipusid_nev=keres_mit1_mit1_csak_ertek('szerz_tipus','szerz_tipus_id',$ker_szerztipusid,'szerz_tipus_nev');
 echo '<option value="'.$ker_szerztipusid.'">'.$ker_szerztipusid_nev;
}else{
 echo '<option value="all">Összes';
}
echo '</select>';

echo '<td>SAP szerződésszám';
echo '<td>';
echo '<input onkeyup="admin_szerzalapadatlist_keres_proc(\'tallep_elso\',\'\')" value="'.$ker_sapszam.'" id="admin_szerzalapadatlist_keres_sapszam" style="width:110px" type="text">';


echo '</tr>';
echo '</tbody>';
echo '</table></div>';
}

function admin_szerzalapadat_user_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

$tomb=keres_admin_szerzalapadat_uj();
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}

echo '<div class="div_kereshez">';
echo '<b>Meglévő adatok módosítása</b>';
echo '<table id="admin_szerzalapadatlist_table" class="table_emre_kek">';
echo '<thead><tr>';

$order_mezo="szerz.szerz_id";
echo "<th style='width:40px' class='link' onclick='admin_szerzalapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>ID ";
echo tabl_nyilak('admin_szerzalapadatlist_keres_order','admin_szerzalapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.tagv_kod";
echo "<th style='width:40px' class='link' onclick='admin_szerzalapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Társaság ";
echo tabl_nyilak('admin_szerzalapadatlist_keres_order','admin_szerzalapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_keret";
echo "<th style='width:40px' class='link' onclick='admin_szerzalapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Keretszerződés ";
echo tabl_nyilak('admin_szerzalapadatlist_keres_order','admin_szerzalapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz_tipus.szerz_tipus_nev";
echo "<th style='width:40px' class='link' onclick='admin_szerzalapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés típus ";
echo tabl_nyilak('admin_szerzalapadatlist_keres_order','admin_szerzalapadatlist_keres_order_mod',$order_mezo);

$order_mezo="szerz.szerz_date_hatalybelep";
echo "<th style='width:40px' class='link' onclick='admin_szerzalapadatlist_keres_proc(\"order\",\"".$order_mezo."\")'>Szerződés hatályba lépésének időpontja ";
echo tabl_nyilak('admin_szerzalapadatlist_keres_order','admin_szerzalapadatlist_keres_order_mod',$order_mezo);

echo '<th>SAP szerződésszám';
echo '<th>Megjegyzés';

echo '</tr></thead><tbody>';

admin_szerzalapadat_user_list_tal($tomb);

echo '</tbody></table>';
echo '</div>';
table_alja_lepeget('0',$th,'admin_szerzalapadat','admin_szerzalapadatlist_keres_talszam','admin_szerzalapadatlist_keres_proc');

}

function admin_szerzalapadat_user_list_tal($tomb){
if(is_array($tomb)){
foreach($tomb as $i => $ert){
if($i>0){
 echo '<tr>';
 
 echo '<td>';
 echo $ert['szerz_id'];
 
 echo '<td>';
 echo $ert['tagv_kod'];
 
 echo '<td>';
 //echo igennem_kod_ki($ert['szerz_keret']);
 
 echo '<select onchange="select2_torles_noselected(\'admin_modszerzalapadat_tipusid_'.$ert['szerz_id'].'\');admin_modszerzalapadat_ment(\''.$ert['szerz_id'].'\')" id="admin_modszerzalapadat_szerzkeret_'.$ert['szerz_id'].'" class="select3">';
 
 echo '<option value="0"';
 if($ert['szerz_keret']=='0') echo ' selected';
 echo '>Nem';
 
 echo '<option value="1"';
 if($ert['szerz_keret']=='1') echo ' selected';
 echo '>Igen';
 
 echo '</select>';
 
 //Szerződés típus - eleje
 echo '<td>';
 echo '<select onchange="admin_modszerzalapadat_ment(\''.$ert['szerz_id'].'\')" id="admin_modszerzalapadat_tipusid_'.$ert['szerz_id'].'" class="select2_ajax" csonkolt=0 mit_id="admin_modszerzalapadat_szerzkeret_'.$ert['szerz_id'].'" mod="admin_szerztipus_mod" style="width:211px">';
 if($ert['szerz_tipus_id']!=''){
  echo '<option value="'.$ert['szerz_tipus_id'].'" selected>'.$ert['szerz_tipus_nev'];
 }else{//Elvileg ilyen nem lehet
  echo '<option value="keremv">Kérem válassz';
 }
 echo '</select>';
 //Szerződés típus - vége
 
 //Szerződés hatályba lépésének időpontja - eleje
 echo '<td>';
 echo '<input onchange="admin_modszerzalapadat_ment(\''.$ert['szerz_id'].'\')" id="admin_modszerzalapadat_datehatalybelep_'.$ert['szerz_id'].'" value="'.$ert['szerz_date_hatalybelep'].'" class="date_tol" style="width:100px" type="text">';
 //Szerződés típus - vége
 
 //SAP szerződés szám
 echo '<td>';
 echo $ert['szerz_sapszam'];
 
 //Megjegyzés
 echo '<td>';
 echo '<textarea onkeyup="admin_modszerzalapadat_ment(\''.$ert['szerz_id'].'\')" id="admin_modszerzalapadat_megj_'.$ert['szerz_id'].'" rows="2" style="width:350px">';
 echo $ert['szerz_megj'];
 echo '</textarea>';
 
 echo '</tr>';
}
}
}
}

function admin_ujszerzalapadat_ment(){
//1.1 Társaság:
if((!isset($_POST['tagv_kod']))or(
(isset($_POST['tagv_kod'])and
(
  ($_POST['tagv_kod']=="")or($_POST['tagv_kod']=="keremv")
)
)
)){
 echo "nook$;$"."Társaság megadása kötelező!";
 exit;
}

//1.2 Keretszerződés:
if((!isset($_POST['szerz_keret']))or(
(isset($_POST['szerz_keret'])and
(
  ($_POST['szerz_keret']=="")or($_POST['szerz_keret']=="keremv")
)
)
)){
 echo "nook$;$"."Keretszerződés megadása kötelező!";
 exit;
}

//1.3 Szerződés típus:
if((!isset($_POST['szerz_tipus_id']))or(
(isset($_POST['szerz_tipus_id'])and
(
  ($_POST['szerz_tipus_id']=="")or($_POST['szerz_tipus_id']=="keremv")
)
)
)){
 echo "nook$;$"."Szerződés típus megadása kötelező!";
 exit;
}

//1.4 Szerződés hatályba lépésének időpontja:
if((!isset($_POST['szerz_date_hatalybelep']))or(
(isset($_POST['szerz_date_hatalybelep'])and
(
  ($_POST['szerz_date_hatalybelep']=="")or($_POST['szerz_date_hatalybelep']=="keremv")
)
)
)){
 echo "nook$;$"."Szerződés hatályba lépésének időpontja!";
 exit;
}

//1 Szerződés típus duppliklható-e? Ha nem, akkor az első 3 mezőt kell figyelembe benni
 $duplae=keres_mit1_mit1_csak_ertek('szerz_tipus','szerz_tipus_id',$_POST['szerz_tipus_id'],'szerz_tipus_dupla');

if($duplae=='0'){
 //2: Van-e Ilyen Szerződés típus
 $szeralapalapvane=keres_mit3_mit1('szerz','tagv_kod',$_POST['tagv_kod'],'szerz_keret',$_POST['szerz_keret'],'szerz_tipus_id',$_POST['szerz_tipus_id'],'szerz_id');
 if(is_array($szeralapalapvane)){
  echo 'nook$;$Hiba!<br><br>Van már ilyen szerződéses alapadat!';
  exit;
 }
}

 $tmp_bk=array();
 $tmp_bk[0]['tagv_kod']=$_POST['tagv_kod'];
 $tmp_bk[0]['szerz_keret']=$_POST['szerz_keret'];
 $tmp_bk[0]['szerz_tipus_id']=$_POST['szerz_tipus_id'];
 $tmp_bk[0]['szerz_date_hatalybelep']=str_replace(".","-",$_POST['szerz_date_hatalybelep']);
 if($_POST['megj']!='')
  $tmp_bk[0]['szerz_megj']=$_POST['megj'];
 be_visz_insert('szerz',$tmp_bk);

echo "ok$;$";

}

function admin_modszerzalapadat_ment(){
if(
(isset($_POST['szerz_id']))and
(isset($_POST['szerz_keret']))and
(isset($_POST['szerz_tipus_id']))and
(isset($_POST['szerz_date_hatalybelep']))and
(isset($_POST['megj']))and
($_POST['szerz_id']!="")and
($_POST['szerz_keret']!="")and
($_POST['szerz_tipus_id']!="")and
($_POST['szerz_date_hatalybelep']!="")
){
 $tmp_mod=array();
 $tmp_mod[0]['szerz_keret']=$_POST['szerz_keret'];
 $tmp_mod[0]['szerz_tipus_id']=$_POST['szerz_tipus_id'];
 if(strlen($_POST['szerz_date_hatalybelep'])==10)
  $tmp_mod[0]['szerz_date_hatalybelep']=str_replace(".","-",$_POST['szerz_date_hatalybelep']);
  
 if($_POST['megj']!='')
  $tmp_mod[0]['szerz_megj']=$_POST['megj'];
 else $tmp_mod[0]['szerz_megj']=null;
 mod_egy_fel_tom('szerz',$tmp_mod[0],'szerz_id',$_POST['szerz_id']);
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

?>