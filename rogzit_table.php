<?php

function rogzitheto_ho_e_hanem_reload(){

//Ho ellenőrzés
if(
 (isset($_POST['ev']))and
 (isset($_POST['ho']))and
 ($_POST['ev']!='')and
 ($_POST['ho']!='')and
 (
  ($_POST['ev']!=$_SESSION[$GLOBALS['sessionname']]['ev_ki'])
 or
  ($_POST['ho']!=$_SESSION[$GLOBALS['sessionname']]['ho_ki'])
 )
){
 echo "nookreload";
 exit;
}

//User_ad ellenőrzés
if((isset($_POST['user_ad']))and($_POST['user_ad']!='')){
 if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
else
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];
if(mb_strtolower($_POST['user_ad'])!=$user_ad){
 echo "nookreload";
 exit;
}
}
}

function rogzitheto_e_hanem_reload(){
//Ha le van zárva a hónap, akkor ne lehessen menteni - eleje
if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
else
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];
$rogzit_ho=ho_aktevforma_ki();
$tomb_ker_lezart=keres_mit2("rogzit_ho","user_ad",$user_ad,"rogzit_ho",$rogzit_ho);
if(
(is_array($tomb_ker_lezart))
and(isset($tomb_ker_lezart[0]['ellenorzesre_lezarva']))
and($tomb_ker_lezart[0]['ellenorzesre_lezarva']==1)
){
 echo "nookreload";
 exit;
}
//Ha le van zárva a hónap, akkor ne lehessen menteni - vége
}

function tavollet_rogzit_del(){
rogzitheto_e_hanem_reload();
$ido=nap_aktevforma_ki($_POST['nap']);
//rogzit törlése

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
else
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];

//Csak akkor törlés, ha nincs megjegyzés mező!
$tomb_megj=keres_mit2_mit1("rogzit",'user_ad',$user_ad,"rogzit_nap",$ido,"rogzit_megj");
if(
(is_array($tomb_megj))
and($tomb_megj[0]!="")
){
 $tmp_mod[0]['tavollet']=0;
 mod_egy_fel_tom2('rogzit',$tmp_mod[0],'user_ad',$user_ad,"rogzit_nap",$ido);
}else{
 torles2("rogzit",'user_ad',$user_ad,"rogzit_nap",$ido);
}

echo "ok$;$";
}

function rogzit_megj_ment(){

rogzitheto_ho_e_hanem_reload();
rogzitheto_e_hanem_reload();

if(isset($_POST['megj'])){
$nap=nap_aktevforma_ki($_POST['nap']);

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
else
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];

//Van-e mentett rogzit adat
$tomb_ker_rogzit=keres_mit2_mit1("rogzit","user_ad",$user_ad,"rogzit_nap",$nap,"rogzit_id");
if(is_array($tomb_ker_rogzit)){
 $tmp_mod[0]['rogzit_megj']=$_POST['megj'];
 mod_egy_fel_tom('rogzit',$tmp_mod[0],'rogzit_id',$tomb_ker_rogzit[0]);
 
 //Csak ha ürest vittük be, nézzük meg, hogy lehet a teljes felesleges - eleje
 if($_POST['megj']==""){
 $rogzit_id=$tomb_ker_rogzit[0];
 //Meg kell nézni,hogy van-e rá rögzítve sor, ha nincs kuka a rogizt sor is 
 $tomb_vanemeg=keres_mit1_mit1("rogzit_sor","rogzit_id",$rogzit_id,"rogzit_id");
 //Ha van megjegyzés, akkor azt ne töröljük ki.
 $tomb_vanemeg_megj=keres_mit1_mit1("rogzit","rogzit_id",$rogzit_id,"rogzit_megj");
 if(
 (!is_array($tomb_vanemeg))
 and(!is_array($tomb_vanemeg_megj))
 or
 (
 (!is_array($tomb_vanemeg))and
 (is_array($tomb_vanemeg_megj))and
 (isset($tomb_vanemeg_megj[0]))and
 ($tomb_vanemeg_megj[0]=="")
 )
 ){
  torles2("rogzit",'rogzit_id',$rogzit_id,"user_ad",$user_ad);
 }
 }
 //Csak ha ürest vittük be, nézzük meg, hogy lehet a teljes felesleges - vége
 
 echo "ok$;$";
}elseif($_POST['megj']!=""){
 //echo "Hiba, nincs rogzitett adat!";
 //Csináljuk V.006
  $tomb_rogzit[0]=array();
  $tomb_rogzit[0]['user_ad']=$user_ad;
  $tomb_rogzit[0]['szerv_id']=$GLOBALS['mira']['szerv_id'];
  $tomb_rogzit[0]['rogzit_ho']=ho_aktevforma_ki();
  $tomb_rogzit[0]['rogzit_nap']=$nap;
  $tomb_rogzit[0]['tavollet']="0";
  $tmp_mod[0]['rogzit_megj']=$_POST['megj'];
  be_visz_insert("rogzit",$tomb_rogzit);
  echo "ok$;$";
}else{
 echo "ok$;$";
}

}
}

function tavollet_rogzit_ment(){
rogzitheto_e_hanem_reload();
mysqli_autocommit($GLOBALS['mysqli'],FALSE);

$ido=nap_aktevforma_ki($_POST['nap']);

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
else
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];

//rogzit törlése
torles2("rogzit",'user_ad',$user_ad,"rogzit_nap",$ido);
 
//Majd rögzítése
 $tomb_rogzit[0]=array();
 $tomb_rogzit[0]['user_ad']=$user_ad;
 $tomb_rogzit[0]['szerv_id']=$GLOBALS['mira']['szerv_id'];
 $tomb_rogzit[0]['rogzit_ho']=ho_aktevforma_ki();
 $tomb_rogzit[0]['rogzit_nap']=$ido;
 $tomb_rogzit[0]['tavollet']="1";
 $tomb_rogzit[0]['rogzit_megj']=$_POST['megj'];
 be_visz_insert("rogzit",$tomb_rogzit);
 
echo "ok$;$";

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);
}

function rogzit_ment($all_ment){

if($all_ment==''){
 rogzitheto_ho_e_hanem_reload();
 mysqli_autocommit($GLOBALS['mysqli'],FALSE);
}

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']==""){
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
 $szerv_id=$GLOBALS['mira']['szerv_id'];
}else{
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];
 $szerv_id=keres_mit1_mit1_csak_ertek('mira_user','user_ad',$user_ad,'szerv_id');
}

$nap=nap_aktevforma_ki($_POST['nap']);

//Ha le van zárva a hónap, akkor ne lehessen menteni - eleje
if($all_ment==''){
 rogzitheto_e_hanem_reload();
}
//Ha le van zárva a hónap, akkor ne lehessen menteni - vége

//Van-e mentett rogzit adat
$tomb_ker_rogzit=keres_mit2("rogzit","user_ad",$user_ad,"rogzit_nap",$nap);

/*
if(
(!is_array($tomb_ker_rogzit))
or(
(is_array($tomb_ker_rogzit))
and
($tomb_ker_rogzit[0]['szerv_id']!=$GLOBALS['mira']['szerv_id'])
and($tomb_ker_rogzit[0]['rogzit_jovahagyva']==0)
)
){//Ekkor menteni kell, mert még nincs, vagy szerv változás történt
*/
if(!is_array($tomb_ker_rogzit)){
 $tomb_rogzit[0]=array();
 $tomb_rogzit[0]['user_ad']=$user_ad;
 $tomb_rogzit[0]['szerv_id']=$szerv_id;
 
 $tomb_rogzit[0]['rogzit_ho']=ho_aktevforma_ki();
 
 $tomb_rogzit[0]['rogzit_nap']=$nap;
 be_visz_insert("rogzit",$tomb_rogzit);
 $rogzit_id = mysqli_insert_id($GLOBALS['mysqli']);
/*}elseif($tomb_ker_rogzit[0]['rogzit_jovahagyva']==1){
 echo "Rendszerhiba";
 exit;*/
}else{
 $rogzit_id=$tomb_ker_rogzit[0]['rogzit_id'];
}

$tomb_ido=explode(":",$_POST['ido']);
$ora=$tomb_ido[0];
if(isset($tomb_ido[1])){
 $perc=$tomb_ido[1];
 if($perc=="00")$perc="0";
}else
 $perc="0";

if(
($_POST['projekt_id']!="")
and($_POST['projekt_id']!="keremv")
){
//rogzit_sor mentése
 $tombsor_rogzit[0]=array();
 //$tombsor_rogzit[0]['user_ad']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
 $tombsor_rogzit[0]["rogzit_id"]=$rogzit_id;
 $tombsor_rogzit[0]["projekt_id"]=$_POST['projekt_id'];
 //$tombsor_rogzit[0]["rogzit_nap"]=$nap;
 $tombsor_rogzit[0]["rogzit_ora"]=$ora;
 $tombsor_rogzit[0]["rogzit_perc"]=$perc;
 $tombsor_rogzit[0]["sorsz"]=$_POST['sorsz'];
 
 if(
 (isset($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']))and
 ($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']!="")
 ){
	 $tombsor_rogzit[0]["helyettes_rogzito"]=1;
	 $tombsor_rogzit[0]["helyettes_rogzito_ki"]=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
 }
 
 //print_r($tomb_rogzit);
 
 /*
 if(!is_array($tomb_ker_rogzit)){
  echo 'Most új bevitel';
 }
 */

 if(
 //(is_array($tomb_ker_rogzit))
 //and
 ($_POST['projekt_id_last']=="")
 //and
 //(keres_mit2_mit1_csak_ertek('rogzit_sor','rogzit_id',$rogzit_id,'projekt_id',$_POST['projekt_id'],'rogzit_id')!='')
 ){
  //Ekkor módosítás
  //echo 'Ekkor módosítás';
   /*echo '<pre>';
   print_r($tombsor_rogzit[0]);
   echo '</pre>';*/
  unset($tombsor_rogzit[0]["rogzit_id"]);
  unset($tombsor_rogzit[0]["projekt_id"]);
  unset($tombsor_rogzit[0]["sorsz"]);
  mod_egy_fel_tom2('rogzit_sor',$tombsor_rogzit[0],'rogzit_id',$rogzit_id,"projekt_id",$_POST['projekt_id']);
 }else{
  
  $tomb_sor=keres_mit2('rogzit_sor','rogzit_id',$rogzit_id,"projekt_id",$tombsor_rogzit[0]["projekt_id"]);
  
  if(is_array($tomb_sor)){
  
  if($tomb_sor[0]['rogzit_sor_megj']!=''){
	$tombsor_rogzit[0]["rogzit_sor_megj"]=$tomb_sor[0]['rogzit_sor_megj'];  
  }
  
  if($tomb_sor[0]['rogzit_sor_update_time']!=''){
	$tombsor_rogzit[0]["rogzit_sor_update_time"]=$tomb_sor[0]['rogzit_sor_update_time'];  
  }
  
  if($tomb_sor[0]['helyettes_rogzito']!=''){
   $tombsor_rogzit[0]["helyettes_rogzito"]=$tomb_sor[0]['helyettes_rogzito']; 
  }
  
  if($tomb_sor[0]['helyettes_rogzito_ki']!=''){
   $tombsor_rogzit[0]["helyettes_rogzito_ki"]=$tomb_sor[0]['helyettes_rogzito_ki']; 
  }
  
  }
  
  be_visz_insert("rogzit_sor",$tombsor_rogzit);
 }
}//else{

if(
($_POST['projekt_id_last']!="")
and($_POST['projekt_id_last']!="keremv")
){
	
$rogzit_id=keres_rogzit_id_egy($_POST['projekt_id_last'],$nap);
if($rogzit_id!=""){
 torles2("rogzit_sor",'rogzit_id',$rogzit_id,"projekt_id",$_POST['projekt_id_last']);

//Meg kell nézni,hogy van-e rá rögzítve sor, ha nincs kuka a rogizt sor is 
$tomb_vanemeg=keres_mit1_mit1("rogzit_sor","rogzit_id",$rogzit_id,"rogzit_id");
//Ha van megjegyzés, akkor azt ne töröljük ki.
$tomb_vanemeg_megj=keres_mit1_mit1("rogzit","rogzit_id",$rogzit_id,"rogzit_megj");
if(
(!is_array($tomb_vanemeg))
and(!is_array($tomb_vanemeg_megj))
or
(
(!is_array($tomb_vanemeg))and
(is_array($tomb_vanemeg_megj))and
(isset($tomb_vanemeg_megj[0]))and
($tomb_vanemeg_megj[0]=="")
)
){
  torles2("rogzit",'rogzit_id',$rogzit_id,"user_ad",$user_ad);
}

}

}

if($all_ment==''){
echo "ok$;$";


mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);

}
}

function fo_bevitel_honap_kirajzol($ev,$ho){

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $tomb_mentve=keres_rogzit_egyho($_SESSION[$GLOBALS['sessionname']]['login_ad'],$ev,$ho);
else
  $tomb_mentve=keres_rogzit_egyho($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'],$ev,$ho);

if($ho<10)$ho_ketto="0".$ho;
else $ho_ketto=$ho;

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $tomb_jovahagyva_ho=keres_mit2("rogzit_ho","user_ad",$_SESSION[$GLOBALS['sessionname']]['login_ad'],"rogzit_ho",$ev."-".$ho_ketto);
else
 $tomb_jovahagyva_ho=keres_mit2("rogzit_ho","user_ad",$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'],"rogzit_ho",$ev."-".$ho_ketto);

$naptimes=mktime("0","0","1",$ho,'1',$ev);
$ho_ut_nap=date('t',$naptimes);

if(
(!is_array($tomb_jovahagyva_ho))
or
(
(is_array($tomb_jovahagyva_ho))and
($tomb_jovahagyva_ho[0]['ellenorzesre_lezarva']=="0")
)
){
 $jovahagyva_ho=0;
}else{
 $jovahagyva_ho=1;
}

echo '<div id="scroll1" style="overflow-x:auto;">';
echo '<div></div>';
echo '</div>';
echo '<div id="scroll2" style="overflow-x:auto;">';

echo '<table style="display:none" cellpadding=0 cellspacing=0 border=0 id="table_emre_bejovo" class="table_emre_bejovo">';

echo '<thead>';

echo '<tr>';
//Távollét oszlop idő elrejtése
if(tavollet_lathato_e($ev,$ho)){
 echo '<th style="font-size:18px" colspan=6>';
}else{
 echo '<th style="font-size:18px" colspan=5>';
}

echo '<div style="display:inline-block;max-width:868px">';//style="" max-width:868px;container-type: inline-size;font-size:calc(0.9cqw - 1px);"
//f1ont-size: clamp(18px, 1vw, 100px);
//white-space:nowrap;
echo '<div style="display:inline">';//;justify-content:center; align-items:center;
echo 'Tevékenység rögzítés: ';

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 echo $GLOBALS[$GLOBALS['sessionname']]['login_nev'].", ".$GLOBALS[$GLOBALS['sessionname']]['szerv_nev'].", ";
else
 echo "<span class='fo_table_ki_nev_sarga'>".$GLOBALS[$GLOBALS['sessionname']]['helyettes_login_nev'].", ".$GLOBALS[$GLOBALS['sessionname']]['helyettes_szerv_nev']."</span> ";

echo "<span style='white-space:nowrap'>";
echo " ".$ev.". ".ho_ki($ho);
echo "</span>";
echo '</div>';

echo '<div style="display:inline">';
echo "<img onclick='pdf_export_akt_user()' class='pdf_ikon_rogz' title='PDF exportálás' src='image/pdf2.png'>";

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']==""){
 echo "<img onclick='xlsx_export_akt_user(\"".$_SESSION[$GLOBALS['sessionname']]['login_ad']."\",\"".$ev."\",\"".$ho."\")' class='xlsx_ikon_rogz' title='Excel exportálás' src='image/excel_e1_k20.png'>";
}else{
 echo "<img onclick='xlsx_export_akt_user(\"".$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']."\",\"".$ev."\",\"".$ho."\")' class='xlsx_ikon_rogz' title='Excel exportálás' src='image/excel_e1_k20.png'>";
}
echo '</div>';

echo '</div>';//Teljes

echo '</tr>';

echo '<tr>';

echo '<th colspan=2>';
//echo 'Dátum';
echo '<span onclick="rogzit_adatok_masol()" style="cursor:pointer">Dátum</span>';

if($jovahagyva_ho==1){
 if(tavollet_lathato_e($ev,$ho))
  echo '<th style="width:395px">';
 else
  echo '<th style="width:460px">';
}else
 echo '<th title="Maximum rögzíthető idő: '.$GLOBALS['mira']['napi_ido_max'].'" style="width:360px">';
//echo '<th style="width:360px">';
echo 'Tevékenység rögzítése';

//Távollét oszlop idő elrejtése
if(tavollet_lathato_e($ev,$ho)){
 echo '<th>';
 echo 'Távollét';
}

echo '<th>';
//echo 'Összesítés';
echo '<span onclick="ess_ido_konv()" style="cursor:pointer">Összesítés</span>';
echo '<div id="ess_ido_konv_div" style="display:none">';
echo '<table border=0 cellpadding=0 cellspacing=0 class="table_emre" style="background-color:#000">';
echo '<tr><td align=left>Óra:<td><input onkeyup="ess_ido_konv_ess()" id="ess_ido_konv_ess_in" type="text" style="width:40px" maxlength=6 autocomplete="off"></tr>';
echo '<tr><td align=left>Óra:perc<td align=left id="ess_ido_konv_ered"></tr>';
echo '</table>';
echo '</div>';

/*
echo '<th>';
echo 'Jóváhagyás';
*/

if($jovahagyva_ho==1)
 echo '<th style="width:265px">';
else
 echo '<th style="width:242px">';/*300 volt*/
echo 'Megjegyzés';

echo '</thead>';

echo '<tbody>';

$tomb_munkanap=keres_mit_munkanap($ev,$ho);

if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $tomb_munkanap_user=keres_mit_munkanap_user($ev,$ho,$_SESSION[$GLOBALS['sessionname']]['login_ad']);
else
 $tomb_munkanap_user=keres_mit_munkanap_user($ev,$ho,$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']);

$elso_nap=1;
//Csak 1 nap lekezelése - eleje
if($_SESSION[$GLOBALS['sessionname']]['nap_ki']=="ma"){
 $elso_nap=$ho_ut_nap=date("j",time());//j 1 karakteres nap
}elseif(
($ev==$GLOBALS['mira']['rogzit_ev_kezdo_ev'])and
($ho==$GLOBALS['mira']['rogzit_ev_kezdo_ho'])and
($_SESSION[$GLOBALS['sessionname']]['nap_ki']=="all")and
($GLOBALS['mira']['rogzit_ev_kezdo_nap']!="")
){
 $elso_nap=$GLOBALS['mira']['rogzit_ev_kezdo_nap'];
}elseif(
($_SESSION[$GLOBALS['sessionname']]['nap_ki']>=1)and
($_SESSION[$GLOBALS['sessionname']]['nap_ki']<=31)
){
 $elso_nap=$ho_ut_nap=$_SESSION[$GLOBALS['sessionname']]['nap_ki'];
}//Máskülönben az egész hónap!

//Vége rögzítés nap lekezelése - eleje
if(
($GLOBALS['mira']['rogzit_ev_veg_ev']!="")and
($GLOBALS['mira']['rogzit_ev_veg_ho']!="")and
($GLOBALS['mira']['rogzit_ev_veg_nap']!="")and
($ev==$GLOBALS['mira']['rogzit_ev_veg_ev'])and
($ho==$GLOBALS['mira']['rogzit_ev_veg_ho'])
){
 $ho_ut_nap=$GLOBALS['mira']['rogzit_ev_veg_nap'];
}
//Vége rögzítés nap lekezelése - vége

//Csak 1 nap lekezelése - vége

$ho_sor_munkanapszam=0;
for($nap_akt=$elso_nap;$nap_akt<=$ho_ut_nap;$nap_akt++){
 if(isset($tomb_munkanap_user[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap_user[$nap_akt];
 elseif(isset($tomb_munkanap[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap[$nap_akt];
 else
  $nap_tipus_egyedi="";
 fo_bevitel_honap_kirajzol_sor_ki($tomb_mentve,$ev,$ho,$nap_akt,$nap_tipus_egyedi,$jovahagyva_ho);
}

//Összesen
if($_SESSION[$GLOBALS['sessionname']]['nap_ki']=="ma"){
 echo "<tr style='display:none'>";
}else{
 echo "<tr>";	
}

echo "<td><b>Összesen</b>";

//Távollét oszlop idő elrejtése
if(tavollet_lathato_e($ev,$ho)){
 echo "<td colspan=3>";
}else{
 echo "<td colspan=2>";
}

echo "<td>";
echo "<span id='rogzit_ho_all_td' title=\"<div id='title_rogzit_ho_all_td'></div>\" class='linkm_tooltip'></span>";
echo "<td>";
echo "</tr>";

echo '</tbody>';

echo '</table>';
echo '</div>';

}

function fo_bevitel_honap_kirajzol_sor_ki($tomb_mentve,$ev,$ho,$nap_akt,$nap_tipus_egyedi,$jovahagyva_ho){
global $ho_sor_munkanapszam;

if($ho<10)$ho_ketto="0".$ho;
else $ho_ketto=$ho;

$naptime=mktime("0","0","1",$ho,$nap_akt,$ev);
$het_sorszam=date('w',$naptime);
//$naptipus=naptipus($ev,$ho,$nap_akt);

if($nap_tipus_egyedi=="PN"){
 $nap_dis="1";
}elseif($nap_tipus_egyedi=="MN"){
 $nap_dis="0";/*
}elseif(($het_sorszam!="6")and($het_sorszam!="0")and($naptipus=="PN")){
 $nap_dis="1";
}elseif((($het_sorszam=="6")or($het_sorszam=="0"))and($naptipus!="MN")){
 $nap_dis="1";*/
}elseif(($het_sorszam=="6")or($het_sorszam=="0")){
 $nap_dis="1";
}else{
 $nap_dis="0";	
}

$ma=date("Ymj",time());//d(01) helyett j(1)

if($nap_dis=="1"){//Tiltott nap színe
 $dis_style=' class="table_emre_bejovo_dis_nap"';
}elseif($ma==$ev.$ho_ketto.$nap_akt){//Akt nap színe
$dis_style=' orig_class="" class="table_emre_bejovo_akt_nap"';//alap
}else{
 //$dis_style='';//Régen nem kellett, páros-parlatlan miatt kell
 $ho_sor_munkanapszam++;
 
 if($ho_sor_munkanapszam % 2 == 0) $dis_style=' orig_class="paros" class="table_emre_bejovo_akt_nap_paros"';//Páros
 else $dis_style=' orig_class="paratlan" class="table_emre_bejovo_akt_nap_paratlan"';//Páratlan
 //$dis_style='';
}

echo "<tr".$dis_style.">";

echo "<td>";
if($nap_akt<10)$nap_akt_ki="0".$nap_akt;
else $nap_akt_ki=$nap_akt;
echo "<span nap='".$nap_akt."' class='span_nap'>".$ev.".".$ho_ketto.".".$nap_akt_ki."</span>";

echo "<td>";
echo napkod($het_sorszam);

//Időráfordítás - eleje
echo "<td id='td_proj_".$nap_akt."'>";

if($nap_akt<10){
 $ido=$ev."-".$ho_ketto."-0".$nap_akt;
}else{
 $ido=$ev."-".$ho_ketto."-".$nap_akt;
}

if(
(isset($tomb_mentve['tavollet']))and
(is_array($tomb_mentve['tavollet']))and
(isset($tomb_mentve['tavollet'][$ido]))
and($tomb_mentve['tavollet'][$ido]=="1")
){
 $tavollet_ck=" checked";
 echo "<div class='div_szabi'>Távollét</div>";
 $nap_jovahagyva="";
}else{
 $tavollet_ck="";
 
 if((isset($tomb_mentve['adat']))and(is_array($tomb_mentve['adat'])))
  $tomb_kuld=$tomb_mentve['adat'];
 else $tomb_kuld="";
 
 //print_r($tomb_mentve['nap_foadat'][$ido]);
 if(
 /*( 
 (isset($tomb_mentve['nap_foadat'][$ido]))
  and(isset($tomb_mentve['nap_foadat'][$ido]))
  and($tomb_mentve['nap_foadat'][$ido]['rogzit_jovahagyva']=="1")
 )or*/
 ($jovahagyva_ho==1)
 ){
  $nap_jovahagyva=1;
  //echo "<div style='width:50%;word-wrap: break-word; overflow-wrap: break-word;'>";
  fo_bevitel_honap_kirajzol_sor_ki_jovahagyva($tomb_kuld,$ev,$ho_ketto,$nap_akt,$nap_tipus_egyedi,$nap_dis);
  //echo "</div>";
 }else{
  $nap_jovahagyva=0;
  fo_bevitel_honap_kirajzol_sor_ki_idoraforditas($tomb_kuld,$ev,$ho_ketto,$nap_akt,$nap_tipus_egyedi,$nap_dis);
 }
 
}
//Időráfordítás - vége

//Szabadság - eleje

//Távollét oszlop idő elrejtése
if(tavollet_lathato_e($ev,$ho)){
echo "<td align=center>";
//if(($nap_dis=="0")and($nap_jovahagyva!=1)){
 if(
 (
 /*( 
 (isset($tomb_mentve['nap_foadat'][$ido]))
  and(isset($tomb_mentve['nap_foadat'][$ido]))
  and($tomb_mentve['nap_foadat'][$ido]['rogzit_jovahagyva']=="1")
 )or*/
 ($jovahagyva_ho==1)
 )and
  ($tavollet_ck!="")
 ){
   echo "Igen";
 }elseif(
 ($nap_dis==1)or
 (
 /*( 
 (isset($tomb_mentve['nap_foadat'][$ido]))
  and(isset($tomb_mentve['nap_foadat'][$ido]))
  and($tomb_mentve['nap_foadat'][$ido]['rogzit_jovahagyva']=="1")
 )or*/
 ($jovahagyva_ho==1)
 )and
  ($tavollet_ck=="")
 ){
  echo "";
 }else{//Akkor sima hónap
 echo '<input'.$tavollet_ck.' class="link_cktavollet" type=checkbox onchange="proj_szabi_change(\''.$ev.'\',\''.$nap_akt.'\')" id="proj_szabi_'.$nap_akt.'">';
}
}////Távollét oszlop idő elrejtése
//Szabadság - vége

//Összesítés - eleje
echo '<td id="all_nap_'.$nap_akt.'">';

//Összesítés - vége

//Jóváhagyás - eleje
/*
if($nap_jovahagyva==1){//Ha jóvá van hagyva
$title="";
 $title.='<b>Jóváhagyó</b>: ';
  $title.=$tomb_mentve['nap_foadat'][$ido]['rogzit_jovahagyva_ki_nev'].'<br>';
 $title.='<b>Jóváhagyás ideje</b>: ';
  $title.=$tomb_mentve['nap_foadat'][$ido]['rogzit_jovahagyva_mikor'].'<br>';
 if($tomb_mentve['nap_foadat'][$ido]['rogzit_jovahagyva_megj']!=""){
	 $title.="<b>Jóváhagyó megjegyzése</b>: ".$tomb_mentve['nap_foadat'][$ido]['rogzit_jovahagyva_megj'];
 }
 $title.='<br><b>Szervezet</b>: ';
  $title.=$tomb_mentve['nap_foadat'][$ido]['szerv_nev'].'<br>';
}else{
 $title='';
}

echo '<td title="'.$title.'">';
if($nap_jovahagyva==1){//Ha jóvá van hagyva
 echo '<b>Jóváhagyva</b>';
}else{//Ha nincs jóváhagyva

}
*/
//Jóváhagyás - vége

//Megjegyzés - eleje
echo '<td>';
if(($nap_dis=="0")and($nap_jovahagyva==0)and($jovahagyva_ho==0)){

/*
 if(
 (isset($tomb_mentve['nap_foadat'][$ido]))
 ){
 $texta_dis="";
}else{
 $texta_dis=" disabled";
}
'.$texta_dis.'
*/

 echo '<textarea nap_akt="'.$nap_akt.'" onblur="rogzit_megj_ment_wait(\''.$nap_akt.'\')" onkeyup="rogzit_megj_ment_wait(\''.$nap_akt.'\')" id="td_textarea_'.$nap_akt.'" class="rogzit_megj_textarea">';
 if(isset($tomb_mentve['nap_foadat'][$ido]['rogzit_megj']))
  echo $tomb_mentve['nap_foadat'][$ido]['rogzit_megj'];
 echo '</textarea>';
}else{
 if(isset($tomb_mentve['nap_foadat'][$ido]['rogzit_megj']))
  echo $tomb_mentve['nap_foadat'][$ido]['rogzit_megj'];
}
//Megjegyzés - vége

echo "</tr>";	
}

function fo_bevitel_honap_kirajzol_sor_ki_jovahagyva($tomb_mentve,$ev,$ho,$nap_akt,$nap_tipus_egyedi,$nap_dis){

if($nap_akt<10){
 $ido=$ev."-".$ho."-0".$nap_akt;
}else{
 $ido=$ev."-".$ho."-".$nap_akt;
}


$sorsz=0;

if(
(is_array($tomb_mentve))
and
(isset($tomb_mentve[$ido])
)
){//Ekkor üres
 
 foreach($tomb_mentve[$ido] as $tomb_mentve_ido){
	 
	 $sorsz++;
	 if($nap_dis=="0"){
	 echo '<span class="proj_span_kit" id="span_proj_'.$nap_akt.'_'.$sorsz.'">';
	 
	 //Idő ki - eleje
	  if(is_array($tomb_mentve_ido)){
		 if($tomb_mentve_ido['rogzit_perc']<10)$tomb_mentve_ido['rogzit_perc']="0".$tomb_mentve_ido['rogzit_perc'];
		 $val=$tomb_mentve_ido['rogzit_ora'].":".$tomb_mentve_ido['rogzit_perc'];
		}else{
		 $val="0:00";
	  }
	  echo '<span id="spanido_proj_'.$nap_akt.'_'.$sorsz.'">'.$val.'</span>';
	 //Idő ki - vége
	 
	 //Projekt neve - eleje
	 echo " - ";
	  if(is_array($tomb_mentve_ido)){
			$projekt_nev=$tomb_mentve_ido['projekt_nev'];
		}else{
			$projekt_nev="";
	  }
	 echo '<span id="proj_spanido_proj_'.$nap_akt.'_'.$sorsz.'">'.$projekt_nev.'</span>';
	 //Projekt neve - vége 
	  
	  //Comment - eleje
	  if(
	   (isset($tomb_mentve_ido['rogzit_sor_megj']))and
	   ($tomb_mentve_ido['rogzit_sor_megj']=='1')
	  ){
		  echo ' <img title="<b>Megjegyzés</b>: '.$tomb_mentve_ido['rogzit_sor_megj_adat'].'" src="image/comment_2_pir.png" class="link">';
	  }
	  //Comment - vége
	  
	 echo '<br>';
	 echo '</span>';
	 }
 
 }
}
}

function fo_bevitel_honap_kirajzol_sor_ki_idoraforditas($tomb_mentve,$ev,$ho,$nap_akt,$nap_tipus_egyedi,$nap_dis){

if($nap_akt<10){
 $ido=$ev."-".$ho."-0".$nap_akt;
}else{
 $ido=$ev."-".$ho."-".$nap_akt;
}

$sorsz=0;

if(
(is_array($tomb_mentve))
and
(isset($tomb_mentve[$ido])
)
){//Ekkor üres
 
 foreach($tomb_mentve[$ido] as $tomb_mentve_ido){
	 
	 $sorsz++;
	 if($nap_dis=="0"){
	 echo '<span class="proj_span" id="span_proj_'.$nap_akt.'_'.$sorsz.'">';
	 echo '<div class="proj_span_b">';
	 raford_time_ki($nap_akt,$sorsz,$tomb_mentve_ido);
	 //Projekt neve
	 echo " - ";
	 echo '</div>';
	 echo '<div class="proj_span_b">';
	 $rogzit_sor_megj="d";
	  raford_projekt_ki($ev,$nap_akt,$sorsz,$tomb_mentve_ido);
	 //echo '<br>';
	 echo '</div>';
	 echo '</span>';
	 }
 
 }
}

//Plusz üres sor mindenképpen kell!
$sorsz++;
 if($nap_dis=="0"){
 echo '<span class="proj_span" id="span_proj_'.$nap_akt.'_'.$sorsz.'">';
 echo '<div class="proj_span_b">';
 raford_time_ki($nap_akt,$sorsz,"");
 //Projekt neve
 echo " - ";
 echo '</div>';
 echo '<div class="proj_span_b">';
  raford_projekt_ki($ev,$nap_akt,$sorsz,"");
 echo '</div>';
 echo '</span>';
}

}

function rogzit_elkuld_ell(){
global $ho_sor_munkanapszam,$hibas_nap;
$ok="0";
$ret_str="";

$ev=$_POST['ev'];
$ho=$_POST['ho'];
if($ho<10)$ho_ketto="0".$ho;
else $ho_ketto=$ho;

$naptimes=mktime("0","0","1",$ho_ketto,'1',$ev);
$ho_ut_nap=date('t',$naptimes);


//Vége rögzítés nap lekezelése - eleje
if(
($GLOBALS['mira']['rogzit_ev_veg_ev']!="")and
($GLOBALS['mira']['rogzit_ev_veg_ho']!="")and
($GLOBALS['mira']['rogzit_ev_veg_nap']!="")and
($ev==$GLOBALS['mira']['rogzit_ev_veg_ev'])and
($ho==$GLOBALS['mira']['rogzit_ev_veg_ho'])
){
 $ho_ut_nap=$GLOBALS['mira']['rogzit_ev_veg_nap'];
}
//Vége rögzítés nap lekezelése - vége


if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $tomb_mentve=keres_rogzit_egyho($_SESSION[$GLOBALS['sessionname']]['login_ad'],$ev,$ho);
else
 $tomb_mentve=keres_rogzit_egyho($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'],$ev,$ho);
 
$tomb_munkanap=keres_mit_munkanap($ev,$ho);
//print_r($tomb_munkanap);exit;
if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $tomb_munkanap_user=keres_mit_munkanap_user($ev,$ho,$_SESSION[$GLOBALS['sessionname']]['login_ad']);
else
 $tomb_munkanap_user=keres_mit_munkanap_user($ev,$ho,$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']);

//if($_POST['ho']==$GLOBALS['mira']['rogzit_ev_kezdo_ho']){
if(($ev==$GLOBALS['mira']['rogzit_ev_kezdo_ev'])and($_POST['ho']==$GLOBALS['mira']['rogzit_ev_kezdo_ho'])){
 $nap_kezd_vizs=$GLOBALS['mira']['rogzit_ev_kezdo_nap'];
}else{
 $nap_kezd_vizs=1;
}

//Ellenörzések
//1: Minden nap ki van-e töltve
$ho_sor_munkanapszam=0;
$hibas_nap="";
//for($nap_akt=1;$nap_akt<=$ho_ut_nap;$nap_akt++){
for($nap_akt=$nap_kezd_vizs;$nap_akt<=$ho_ut_nap;$nap_akt++){//Rögzíthető helyettes
 if(isset($tomb_munkanap_user[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap_user[$nap_akt];
 elseif(isset($tomb_munkanap[$nap_akt]))
  $nap_tipus_egyedi=$tomb_munkanap[$nap_akt];
 else
  $nap_tipus_egyedi="";
  rogzit_elkuld_ell_nap_kivan_e_toltve($tomb_mentve,$ev,$ho_ketto,$nap_akt,$nap_tipus_egyedi);
}

if($ho_sor_munkanapszam==0){
 echo "nook$;$";
 echo "<b>Hiba!</b><br><br>".$ev.". ".ho_ki($ho)." hónap lezárása nem lehetséges!";
}else if(!is_array($hibas_nap)){
echo "ok$;$";
}else{
echo "nook$;$";

echo "<b>Hiba! ".ho_ki($ho)." hónap lezárása nem lehetséges!</b>";
echo "<br><br>Alábbi hibák javítása szükséges:";
//echo "<ul>";
 echo "<table border=0 cellpadding=0 cellspacing=2 class='table_emre_bejovo'>";
 echo "<thead>";
 echo "<tr style='height:1px;'>";
 echo "<th colspan=2>Nap";
 echo "<th>Hiba oka";
 echo "<th>Rögzített idő";
 echo "</tr></thead><tbody>";
foreach($hibas_nap as $ido => $hiba){
 echo "<tr style='height:1px;'>";
 $ido_tomb=explode("-",$ido);
 $hiba_nap=$ido_tomb[2];
 $hiba_nap++;$hiba_nap--;
 $naptime=mktime("0","0","1",$ho,$hiba_nap,$ev);
 $het_sorszam=date('w',$naptime);
 $hiba_nap_str=napkod($het_sorszam);

 echo "<td>".$hiba_nap."<td>".$hiba_nap_str;
 switch($hiba['hiba_ok']){
	 case'vanuresproj':
	  //echo "<td>Van olyan tevékenységed, amihez 0:00 van rögzítve.";
	  echo "<td><span class='spanlezar_ures_tev' title='".$hiba['hiba_nev']."'>Van olyan tevékenységed, amihez a rögzített munkaidő 0:00</span>";
	  echo "<td>";
	 break;
	 case'ures':
	  echo "<td>Nincs kitöltve!";
	  echo "<td>";
	 break;
	 case'min':
	  echo "<td>Minimum rögzíthető idő: ".$GLOBALS['mira']['napi_osszes_ido_min'];
	  if($hiba['rogzit_perc']<10)$hiba['rogzit_perc']="0".$hiba['rogzit_perc'];
	  echo "<td>Rögzített: ".$hiba['rogzit_ora'].":".$hiba['rogzit_perc'];
	 break;
	 case'max':
	  echo "<td>Maximum rögzíthető idő: ".$GLOBALS['mira']['napi_ido_max'];
	  if($hiba['rogzit_perc']<10)$hiba['rogzit_perc']="0".$hiba['rogzit_perc'];
	  echo "<td>Rögzített: ".$hiba['rogzit_ora'].":".$hiba['rogzit_perc'];
	 break;
 }
 echo "</tr>";
}
//echo "</ul>";
echo "</tbody></table>";
}

}

function rogzit_elkuld_ell_nap_kivan_e_toltve($tomb_mentve,$ev,$ho,$nap_akt,$nap_tipus_egyedi){
global $ho_sor_munkanapszam,$hibas_nap;
$naptime=mktime("0","0","1",$ho,$nap_akt,$ev);
$het_sorszam=date('w',$naptime);
//$naptipus=naptipus($ev,$ho,$nap_akt);

if($nap_tipus_egyedi=="PN"){
 $nap_dis="1";
}elseif($nap_tipus_egyedi=="MN"){
 $nap_dis="0";/*
}elseif(($het_sorszam!="6")and($het_sorszam!="0")and($naptipus=="PN")){
 $nap_dis="1";
}elseif((($het_sorszam=="6")or($het_sorszam=="0"))and($naptipus!="MN")){
 $nap_dis="1";*/
}elseif(($het_sorszam=="6")or($het_sorszam=="0")){
 $nap_dis="1";
}else{
 $nap_dis="0";	
}

if($nap_dis==0){
 $ho_sor_munkanapszam++;
}

if($nap_akt<10){
 $ido=$ev."-".$ho."-0".$nap_akt;
}else{
 $ido=$ev."-".$ho."-".$nap_akt;
}

$tavvolet=0;
if(
(isset($tomb_mentve['tavollet']))and
(is_array($tomb_mentve['tavollet']))and
(isset($tomb_mentve['tavollet'][$ido]))
and($tomb_mentve['tavollet'][$ido]=="1")
){
 $tavvolet=1;//Ekkor  van szabi!
}

$napvan_ures=0;
$napvan_ures_nev="";
$tomb_all_oraperc=array();
$tomb_all_oraperc['rogzit_ora']=0;
$tomb_all_oraperc['rogzit_perc']=0;
if(isset($tomb_mentve['adat'][$ido])){
foreach($tomb_mentve['adat'][$ido] as $ert){
 $tomb_all_oraperc['rogzit_ora']+=$ert['rogzit_ora'];
 $tomb_all_oraperc['rogzit_perc']+=$ert['rogzit_perc'];
 
 if(($tavvolet==0)and($ert['rogzit_ora']==0)and($ert['rogzit_perc']==0)){
  $napvan_ures=1;//Nincs, szabi és 0:00, akkor nem jó!
  if($napvan_ures_nev!="")$napvan_ures_nev.="<br>";
  $napvan_ures_nev.=$ert['projekt_nev'];
 }
 
}
}

$tomb_all_oraperc_ki=ora_perc_osszead($tomb_all_oraperc['rogzit_ora'],$tomb_all_oraperc['rogzit_perc']);
//echo $tomb_all_oraperc_ki['rogzit_ora'];
//echo $tomb_all_oraperc_ki['rogzit_perc'];
//exit;

//echo $nap_akt." Tiltva: :".$nap_dis." - Távvolét: ".$tavvolet." Óra: ".$tomb_all_oraperc_ki['rogzit_ora']." Perc: ".$tomb_all_oraperc_ki['rogzit_perc']."<br>";

if($napvan_ures==1){
 if(!is_array($hibas_nap))$hibas_nap=array();
 $hibas_nap[$ido]['hiba_ok']="vanuresproj";
 $hibas_nap[$ido]['hiba_nev']="<b>Érintett tevékenység(ek)</b>:<br>".$napvan_ures_nev;
}elseif(
($nap_dis==0)and
($tavvolet==0)and
($tomb_all_oraperc_ki['rogzit_ora']==0)and
($tomb_all_oraperc_ki['rogzit_perc']==0)
){
 if(!is_array($hibas_nap))$hibas_nap=array();
 $hibas_nap[$ido]['hiba_ok']="ures";
}elseif(
($nap_dis==0)and
($tavvolet==0)and
($tomb_all_oraperc_ki['rogzit_ora']<$GLOBALS['mira']['napi_osszes_ido_min_ora'])
){
 if(!is_array($hibas_nap))$hibas_nap=array();
 $hibas_nap[$ido]['hiba_ok']="min";
 $hibas_nap[$ido]['rogzit_ora']=$tomb_all_oraperc_ki['rogzit_ora'];
 $hibas_nap[$ido]['rogzit_perc']=$tomb_all_oraperc_ki['rogzit_perc'];
}elseif(
($nap_dis==0)and
($tavvolet==0)and
($tomb_all_oraperc_ki['rogzit_ora']>$GLOBALS['mira']['napi_ido_max_ora'])
){
 if(!is_array($hibas_nap))$hibas_nap=array();
 $hibas_nap[$ido]['hiba_ok']="max";
 $hibas_nap[$ido]['rogzit_ora']=$tomb_all_oraperc_ki['rogzit_ora'];
 $hibas_nap[$ido]['rogzit_perc']=$tomb_all_oraperc_ki['rogzit_perc'];
}elseif(
($nap_dis==0)and
($tavvolet==0)and
($tomb_all_oraperc_ki['rogzit_ora']==$GLOBALS['mira']['napi_ido_max_ora'])
and($tomb_all_oraperc_ki['rogzit_perc']>0)
and($tomb_all_oraperc_ki['rogzit_perc']>$GLOBALS['mira']['napi_ido_max_perc'])
){
 if(!is_array($hibas_nap))$hibas_nap=array();
 $hibas_nap[$ido]['hiba_ok']="max";
  $hibas_nap[$ido]['rogzit_ora']=$tomb_all_oraperc_ki['rogzit_ora'];
 $hibas_nap[$ido]['rogzit_perc']=$tomb_all_oraperc_ki['rogzit_perc'];
}

}

function rogzit_elkuld_ell_proc_kerd_utan($jovahagyos){
//Hónap lezárása

if(
(isset($_POST['ev']))and
(isset($_POST['ho']))and
($_POST['ev']!="")and
($_POST['ho']!="")and

(
($jovahagyos=="1")
or
(
($_POST['ev']==$_SESSION[$GLOBALS['sessionname']]['ev_ki'])and
($_POST['ho']==$_SESSION[$GLOBALS['sessionname']]['ho_ki'])
)

)

){
mysqli_autocommit($GLOBALS['mysqli'],FALSE);
$tmp_bk_rogzit_ho[0]=array();

if($_POST['ho']<10)$ho="0".$_POST['ho'];
else $ho=$_POST['ho'];

//Nézzük meg, hogy ez hányadik lezárás
if(($jovahagyos=="1")and(isset($_POST['user_ad'])))
 $user_ad=$_POST['user_ad'];
else{
if($_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad']=="")
 $user_ad=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
else
  $user_ad=$_SESSION[$GLOBALS['sessionname']]['helyettes_login_ad'];
}

//Nézzük meg jóváhagyói lezárás esetén hogy van-e adat... - eleje
if($jovahagyos=="1"){
$tomb_lezarvaneadat=keres_mit2_mit1("rogzit","user_ad",$user_ad,"rogzit_ho",$_POST['ev']."-".$ho,"rogzit_id");
 if(!is_array($tomb_lezarvaneadat)){
  echo "noadat$;$";
  echo "Hiba!<br><br>Jóváhagyói lezárás nem lehetséges, mert erre a hónapra semmilyen adat nincs rögzítve!";
  echo "<br><br>Lezáráshoz legalább egy napra szükséges adatot rögzíteni!";
  exit;
 }
}
//Nézzük meg jóváhagyói lezárás esetén hogy van-e adat... - vége

$tomb_lezarhany=keres_mit2_mit1("rogzit_ho","user_ad",$user_ad,"rogzit_ho",$_POST['ev']."-".$ho,"ellenorzesre_lezarva_hanyadik");
if(!is_array($tomb_lezarhany)){//Ez az első!
 $tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_hanyadik']="1";
}else{
 $tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_hanyadik']=$tomb_lezarhany[0]+1;
}
  
  $tmp_bk_rogzit_ho[0]['user_ad']=$user_ad;

  if($jovahagyos=="1"){
   $tmp_bk_rogzit_ho[0]['rogzit_ho']=$_POST['ev']."-".$ho;
  }else{
   $tmp_bk_rogzit_ho[0]['rogzit_ho']=$_SESSION[$GLOBALS['sessionname']]['ev_ki']."-".$ho;
  }
  
  $tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva']="1";
  $tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_mikor']=date("Y-m-d H:i:s",time());
  
  if($jovahagyos=="1"){
   $tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_jovahagyo']="1";
   //$tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_jovahagyo_ki']=$user_ad;
   $tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_jovahagyo_ki']=$_SESSION[$GLOBALS['sessionname']]['login_ad'];
  }
  
  be_visz_replace("rogzit_ho",$tmp_bk_rogzit_ho);
  be_visz_replace("rogzit_ho_stat",$tmp_bk_rogzit_ho);
  
  //Ha projekt visszaküldés, akkor azt vegyük ki! Töröljük ki az egészet!
  torles2('rogzit_ho_projekt','user_ad',$user_ad,"rogzit_ho",$_SESSION[$GLOBALS['sessionname']]['ev_ki']."-".$ho);
  
  //Ez volt a régi cucc
  //if($tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_hanyadik']>1)
  // rogzit_elkuld_ell_proc_kerd_utan_jovahagyoknak_2tobb($tmp_bk_rogzit_ho);

//Email küldés szakterületi vezetőnek - eleje
if(keres_user_rogzites_vane_tovabbi_projet_jovahagyo($user_ad,$_SESSION[$GLOBALS['sessionname']]['ev_ki']."-".$ho)=="0"){
 
 //Szakterületi jóváhagyók megállapítása, csak azok akinek kell email küldés
 $tomb_cimzett=keres_emailerthez_jovahagyok_csakszervezet($user_ad,$tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_hanyadik']);//user,alkalom
 
 if(is_array($tomb_cimzett))
  email_szak_jovahagyas($tomb_cimzett,$user_ad,$_SESSION[$GLOBALS['sessionname']]['ev_ki'],$ho,$tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_hanyadik']);

}else{//Projektnek kell küldeni
 $tomb_email_jova_cimzett=keres_emailerthez_jovahagyok_csak_projekt($user_ad,$_SESSION[$GLOBALS['sessionname']]['ev_ki']."-".$ho);
 if(is_array($tomb_email_jova_cimzett))
  email_projekt_jovahagyas($tomb_email_jova_cimzett,$user_ad,$_SESSION[$GLOBALS['sessionname']]['ev_ki'],$ho,$tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_hanyadik']);
}
//Email küldés szakterületi vezetőnek - vége

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);

  echo "ok$;$";
}else{
 echo "Adathiba";
}

}

function rogzit_elkuld_ell_proc_kerd_utan_jovahagyoknak_2tobb($tmp_bk_rogzit_ho){

$hanyadik=$tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_hanyadik'];
$user_ad=$tmp_bk_rogzit_ho[0]['user_ad'];
$rogzit_ho=$tmp_bk_rogzit_ho[0]['rogzit_ho'];

$tomb_jovahagyok=keres_aktuser_ad_szervezethez_jovahagyok($user_ad);
$tomb_jovahagyok_felettes=keres_aktuser_ad_szervezethez_jovahagyok_felettes($user_ad);

if(
(is_array($tomb_jovahagyok))or
(is_array($tomb_jovahagyok_felettes))
){
$i=0;
if(is_array($tomb_jovahagyok_felettes)){//Ekkor csak felettes jóváhagyó van.
	foreach($tomb_jovahagyok_felettes as $ert){
	 $i++;
	 $cimzes[$i]['nev']=$ert['user_nev'];
	 $cimzes[$i]['email']=$ert['user_email'];
	}	
}else{
foreach($tomb_jovahagyok as $ert){
 $i++;
 $cimzes[$i]['nev']=$ert['user_nev'];
 $cimzes[$i]['email']=$ert['user_email'];
}
}

$rog_ho_ki=str_replace("-",".",$tmp_bk_rogzit_ho[0]['rogzit_ho']);

$user_nev=keres_mit1_mit1_csak_ertek("mira_user","user_ad",$user_ad,"user_nev");

//$cimtargy=$_SESSION[$GLOBALS['sessionname']]['login_nev'];
$cimtargy=$user_nev;
$cimtargy.=" ".$rog_ho_ki." jóváhagyásra újraküldve";
$level_html="Kedves Jóváhagyó!";
//$level_html.="<br><br>".$_SESSION[$GLOBALS['sessionname']]['login_nev']." ".$rog_ho_ki.". havi";
$level_html.="<br><br>".$user_nev." ".$rog_ho_ki.". havi";
$level_html.=" tevékenység rögzítése ".$tmp_bk_rogzit_ho[0]['ellenorzesre_lezarva_hanyadik'].". alkalommal újra lezárásra került!";
$level_html.=" <br><br>Kérem végezd el a tevékenység rögzítés ellenőrzését, jóváhagyását!";
mail_passrec_uj($cimtargy,$cimzes,$level_html,"");
}
}
?>