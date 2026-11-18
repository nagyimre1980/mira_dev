<?php

function admin_munkanapuser_mod(){
echo "ok$;$";

echo "<b>Új áthelyezés</b><br>";
echo "<table border=0 class='table_emre'>";
echo "<tr>";

//$tomb_user=keres_mit2_order("mira_user","user_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"user_inaktiv","0","user_nev","ASC");

echo "<td>Felhasználó:";
echo "<td style='height:28px'>";
echo "<select style='width:400px' id='munkanapuser_uj_user'>";
/*
echo "<option value='keremv'>Kérem válassz";
foreach($tomb_user as $ert){
 echo "<option value='".$ert['user_ad']."'>".$ert['user_nev']." (".$ert['user_ad'].")";
}
*/
echo "</select>";
echo "</tr>";

echo "<tr>";
echo "<td>Dátum:";
echo "<td>";
echo "<input readonly id='munkanapuser_uj_munkanap' class='date_tol' style='width:100px' type=text>";
echo "</tr>";

echo "<tr>";
echo "<td>Típus:";
echo "<td>";
echo "<select id='munkanapuser_uj_tipus'>";
echo "<option value='keremv'>Kérem válassz";
echo "<option value='mn'>Munkanap";
echo "<option value='pn'>Pihenőnap";
echo "</select>";
echo "</tr>";

echo "<tr>";
echo "<td colspan='2'>";
echo "<input onclick='admin_munkanapuser_uj_ment()' value='Mentés' type='submit' class='submit2'>";
echo "</tr>";

echo "</table>";

$tomb=keres_munkanapuser();

echo "<br><b>Felhasználókra vonatkozó munkanap áthelyezések:</b><br>";
echo "Max találatok: ";
echo "<select onchange='admin_munkanapuser_keress()' id='munkanapuser_keress_max_tal'>";

if(!isset($_SESSION[$GLOBALS['sessionname']]['admin_munkanap_tal']))
 $limit_sel="10";
else
 $limit_sel=$_SESSION[$GLOBALS['sessionname']]['admin_munkanap_tal'];

echo "<option value='5'";
if($limit_sel=="5") echo " selected"; 
echo ">5 darab";

echo "<option value='10'";
if($limit_sel=="10") echo " selected"; 
echo ">10 darab";

echo "<option value='20'";
if($limit_sel=="20") echo " selected"; 
echo ">20 darab";

echo "<option value='50'";
if($limit_sel=="50") echo " selected"; 
echo ">50 darab";

echo "<option value='100'";
if($limit_sel=="100") echo " selected"; 
echo ">100 darab";

echo "<option value='500'";
if($limit_sel=="500") echo " selected"; 
echo ">500 darab";

echo "</select>";



if(is_array($tomb)){

echo "<table border=0 class='table_emre'>";
echo "<thead>";
echo "<tr>";
echo "<th>AD azonosító";
echo "<th>Felhasználó";
echo "<th>Dátum";

echo "<th>Típus";
echo "<th>Törlés";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
foreach($tomb as $ert){
 echo "<tr>";
 echo "<td>";
 echo $ert['user_ad'];
 echo "<td>";
 echo $ert['user_nev'];
 echo "<td>";
echo str_replace("-",".",$ert['munkanap']);
 
 $tombdatum=explode("-",$ert['munkanap']);
 $ho=$tombdatum[1];
 $nap_akt=$tombdatum[2];
 $ev=$tombdatum[0];
 $naptime=mktime("0","0","1",$ho,$nap_akt,$ev);
 $het_sorszam=date('w',$naptime);
 echo " - ";
 echo napkod($het_sorszam);
 
 echo "<td>";
 echo munkanap_tipus_ki($ert['munkanap_tipus']);
 
 echo "<td align=center>";
 echo "<img onclick='admin_munkanapuser_del(\"".$ert['user_ad']."\",\"".$ert['munkanap']."\")' src='image\del.png' class='linkm_tooltip' title='Törlés'>";
 echo "</tr>";
}
echo "</tbody>";
echo "</table>";

}
}

function munkanapuser_uj_ment(){
if(
(isset($_POST['user_ad']))and
(isset($_POST['munkanap']))and
(isset($_POST['tipus']))and
($_POST['user_ad']!="")and
($_POST['munkanap']!="")and
($_POST['tipus']!="")and
(
(mb_strtolower($_POST['tipus'])=="pn")or
(mb_strtolower($_POST['tipus'])=="mn")
)and
(
 (
  (mb_strtolower($_POST['tipus'])=="pn")and
  (!is_array(keres_user_vane_rogzitve_napra($_POST['user_ad'],$_POST['munkanap'])))
 )or
 (
  (mb_strtolower($_POST['tipus'])=="mn")
 )
)

){
 $tmp_bk_ker_def[0]=array();
 $tmp_bk_ker_def[0]['user_ad']=$_POST['user_ad'];
 $tmp_bk_ker_def[0]['munkanap']=str_replace(".","-",$_POST['munkanap']);
 $tmp_bk_ker_def[0]['munkanap_tipus']=mb_strtoupper($_POST['tipus']);
 be_visz_replace("munkanap_user",$tmp_bk_ker_def);
 echo "ok$;$";
}elseif(
(mb_strtolower($_POST['tipus'])=="pn")and
(is_array(keres_user_vane_rogzitve_napra($_POST['user_ad'],$_POST['munkanap'])))
){
 echo "nook$;$";
 echo "Hiba!<br><br>Nem menthető a pihenőnap, mert van rögzítve adat erre a munkanapra!";
}else{
 echo "adathiány!";
}
}

function munkanapuser_del(){
if(
(isset($_POST['user_ad']))and
(isset($_POST['munkanap']))and
($_POST['user_ad']!="")and
($_POST['munkanap']!="")
){

if(!is_array(keres_user_vane_rogzitve_napra($_POST['user_ad'],$_POST['munkanap']))){

 torles2("munkanap_user",'user_ad',$_POST['user_ad'],'munkanap',$_POST['munkanap']);
 echo "ok$;$";
}else{
 echo "nook$;$";
 echo "Hiba!<br><br>Nem törölhető, mert van rögzítve adat erre a munkanapra!";
}
}
}



?>