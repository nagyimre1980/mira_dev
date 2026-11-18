<?php

function admin_honapzaras_mod(){
echo "ok$;$";

echo "<b>Hónap végleges lezárása</b> (Véglegleges lezárás esetén lezárt hónap nem küldhető vissza, de meglévő nyitott hónap lezárható!<br>";
echo "Ezért célszerű ezt akkor beállítani, amikor már minden felhasználó lezárta a hónapját!<br>";

echo '<div style="font-weight:bold;margin:20px 0px">';
echo 'Év szűrés ';

$tomb_alap=keres_mit1("mira_tagv","tagv",$GLOBALS[$GLOBALS['sessionname']]['tagv']);

$ev_most=date("Y",time());
$ho_most=date("n",time());

if(isset($_POST['honapzar_ev_szures'])){
 $_SESSION[$GLOBALS['sessionname']]['honapzar_ev_szures']=$_POST['honapzar_ev_szures'];
}elseif(!isset($_SESSION[$GLOBALS['sessionname']]['honapzar_ev_szures'])){
  $_SESSION[$GLOBALS['sessionname']]['honapzar_ev_szures']=$ev_most;
}

if(is_array($tomb_alap)){
echo '<select onchange="admin_honapzaras_evszures_change()" id="admin_honapzaras_evszures_ev">';

for($ki_ev=$ev_most;$ki_ev>=$tomb_alap[0]['ev_kezdo_ev'];$ki_ev--){
 echo '<option value="'.$ki_ev.'"';
 if($ki_ev==$_SESSION[$GLOBALS['sessionname']]['honapzar_ev_szures']) echo ' selected';
 echo '>'.$ki_ev;
}
echo '</select>';

}

echo '</div>';

echo "<table border=0 class='table_emre'>";
echo "<thead>";
echo "<tr>";
echo "<th>Év-Hónap";
echo "<th>Lezárás";

echo "<th>Áttöltés";
echo "<th>Riport alapértelmezett DB";

echo "</tr>";
echo "</thead>";

$tomb_adat=keres_admin_lezathonapok();
if(is_array($tomb_alap)){
	


echo "<tbody>";
include_once('ajax_ful_admin_backup_func.php');
//for($ki_ev=$tomb_alap[0]['ev_kezdo_ev'];$ki_ev<=$ev_most;$ki_ev++){
if($_SESSION[$GLOBALS['sessionname']]['honapzar_ev_szures']!=''){
 $ki_ev=$_SESSION[$GLOBALS['sessionname']]['honapzar_ev_szures'];
 
 if($ki_ev==$tomb_alap[0]['ev_kezdo_ev'])
  $ho_kezdo=$tomb_alap[0]['ev_kezdo_ho'];
 else
  $ho_kezdo=1;
 
 if($ki_ev==$ev_most)
	 $ho_veg=$ho_most;
 else
	 $ho_veg=12;
 
 for($ho_ki=$ho_kezdo;$ho_ki<=$ho_veg;$ho_ki++){
  echo "<tr style='height:34px'>";
  echo "<td>";
  echo $ki_ev."-".ho_ki($ho_ki);
  echo "<td align=center>";
  
  if($ho_ki<10)$ho_ki0="0".$ho_ki;
  else $ho_ki0=$ho_ki;
  
  if(isset($tomb_adat[$ki_ev."-".$ho_ki0]))
	  $ck=" checked";
  else $ck="";

  echo "<input".$ck." id='admin_honapzaras_ck_".$ki_ev."-".$ho_ki0."' onchange='admin_honapzaras_change(\"".$ki_ev."-".$ho_ki0."\")' type='checkbox' class='link' title='".$ki_ev."-".ho_ki($ho_ki)." végleges lezárása'>";
  
  //Hónap lezárása - eleje
  echo '<td>';
  if(!isset($tomb_adat[$ki_ev."-".$ho_ki0])){//Ha nincs lezárva, akkor nem látható
   $mas_lat=' style="display:none"';
  }else $mas_lat='';
  admin_backup_masol($ki_ev,$ho_ki,$ho_ki0,$mas_lat);
  //Hónap lezárása - vége
  
  //Riport alapértelmezett DB - eleje
  echo '<td>';
  if(isset($tomb_adat[$ki_ev."-".$ho_ki0]))
   admin_backup_default_db($ki_ev,$ho_ki0);
  //Riport alapértelmezett DB - vége
  
  echo "</tr>";
 }
}

}
echo "</tbody>";
echo "</table>";
}

function admin_honapzaras_evszures_change(){
if(
 (isset($_POST['honapzar_ev_szures']))and
 ($_POST['honapzar_ev_szures']!='')
){
 $_SESSION[$GLOBALS['sessionname']]['honapzar_ev_szures']=$_POST['honapzar_ev_szures'];
 echo 'ok$;$';
}else{
 echo 'adathiány';
}
}

function admin_honapzaras_change(){
if(
(isset($_POST['lezar']))and
(isset($_POST['ev_ho']))and
(
 ($_POST['lezar']==0)or
 ($_POST['lezar']==1)
)and
(mb_strlen($_POST['ev_ho'])==7)
){

 if($_POST['lezar']==1){
  $tmp_bk_ker_def[0]['tagv']=$GLOBALS[$GLOBALS['sessionname']]['tagv'];
  $tmp_bk_ker_def[0]['tagv_lezart_honap']=$_POST['ev_ho'];
  be_visz_replace("mira_tagv_lezart_honap",$tmp_bk_ker_def);
 }else{//törlés
	  torles2("mira_tagv_lezart_honap","tagv",$GLOBALS[$GLOBALS['sessionname']]['tagv'],"tagv_lezart_honap",$_POST['ev_ho']);
 }
 echo "ok$;$";
}else{
 echo "Adathiány!";
}
}

?>