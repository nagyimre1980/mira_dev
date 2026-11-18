<?php

//Szerz - eleje
if(is_array($GLOBALS['tigtabla_tomb'])){
foreach($GLOBALS['tigtabla_tomb'] as $szerz_tetel_id => $ert){
 
 $elso_modositas=min(array_keys($ert));
 $utolso_modositas=max(array_keys($ert));
 
 //Ki találjuk hogy mi a kezdő és vég hónap
 $tomb_ho=tig_kezdveg_hokitalal($ev,$ho_ig,$ert,$elso_modositas,$utolso_modositas);
 if(
 ($tomb_ho['kezd']!='')and($tomb_ho['veg']!='')and
 ($tomb_ho['kezd']<=$tomb_ho['veg'])
 
 ){
  for($ho=$tomb_ho['kezd'];$ho<=$tomb_ho['veg'];$ho++){
   $i++;
   
   //Szolgáltatás ID
   if($tomb_ho['tulfutas']=='1'){
    $adat[$i][]='<style bgcolor="#FF0000">'.$szerz_tetel_id;
   }else{
    $adat[$i][]=$szerz_tetel_id;
   }
   
   //Nem szerződés alapján tábla ID
   $adat[$i][]='';
   
   $adat[$i][]=$ev;
   $adat[$i][]=$ho;
   $adat[$i][]=$tomb_ho['adat']['ab'];
   $adat[$i][]=$tomb_ho['adat']['u'];
   $adat[$i][]=$tomb_ho['adat']['ac'];
   $adat[$i][]=$tomb_ho['adat']['ad'];
   $adat[$i][]=$tomb_ho['adat']['ae'];
  }

 
 }
}
}
//Szerz - vége

//Nem szerz - eleje
if(is_array($GLOBALS['tigtabla_tomb_nemszerz'])){

foreach($GLOBALS['tigtabla_tomb_nemszerz'] as $id => $ert){
$i++;	
$adat[$i][]='';
$adat[$i][]=$ert['id'];
$adat[$i][]=$ert['ev'];
$adat[$i][]=$ert['ho'];
}

}
//Nem szerz  - vége

?>