<?php

function admin_munkanapglobal_mod(){
echo "ok$;$";

echo "<b>Globális munkanap áthelyezések:</b><br>";
//$tomb=keres_all_order("munkanap","munkanap","DESC");
//$tomb=keres_mit1_order("munkanap","munkanap_tagv",$_SESSION[$GLOBALS['sessionname']]['tagv'],"munkanap","DESC");
$tomb=keres_all_order("munkanap","munkanap","DESC");

if(is_array($tomb)){

echo "<table border=0 class='table_emre'>";
echo "<thead>";
echo "<tr>";
echo "<th>Dátum";
echo "<th>Típus";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
foreach($tomb as $ert){
 echo "<tr>";
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
 echo "</tr>";
}
echo "</tbody>";
echo "</table>";

}

}


?>