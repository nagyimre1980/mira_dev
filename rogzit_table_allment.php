<?php
//nap=n
//sorsz=s
//ido=i
//projekt_it=p
//projekt_id_last nem küldjük át, mindog üres!

function rogzit_ment_allment(){

mysqli_autocommit($GLOBALS['mysqli'],FALSE);
 
//Ha le van zárva a hónap, akkor ne lehessen menteni - eleje
rogzitheto_e_hanem_reload();
//Ha le van zárva a hónap, akkor ne lehessen menteni - vége

if((isset($_POST['par_ment']))and($_POST['par_ment']!='')){
 $tomb_1=explode("$",$_POST['par_ment']);
 if(is_array($tomb_1)){
  foreach($tomb_1 as $ert_1){
   $tomb_2=explode("_",$ert_1);//echo '<pre>';print_r($ert_1);echo '</pre>';
   if(is_array($tomb_2)){
		   //$nap=$tomb_3['n'];
		   //$sorsz=$tomb_3['s'];
		   //$ido=$tomb_3['i'];
		   //$projekt_it=$tomb_3['projekt_it'];
		   //sscanf($ert_1, "n-%d_s-%d_i-%[^_]_p-%d", $nap, $sorsz, $ido, $projekt_it);
		   sscanf($ert_1, "n-%[^_]_s-%[^_]_i-%[^_]_p-%[^_]_l-%s",$nap,$sorsz,$ido,$projekt_it,$projekt_last);
		   //echo $projekt_it.'<br>';
		   //echo $projekt_last.'<br>';
		   
		   if(($nap!='')and($projekt_it!='')and($sorsz!='')and($ido!='')){
		     $_POST['nap']=$nap;
			 $_POST['projekt_id']=$projekt_it;
			 $_POST['sorsz']=$sorsz;
			 $_POST['ido']=$ido;
			 if(($projekt_last!='')and($projekt_last!=$_POST['projekt_id'])){
			  $_POST['projekt_id_last']=$projekt_last;
			 }else{
			  $_POST['projekt_id_last']='keremv';//keremv
			 }
			 rogzit_ment('all');
			}

	}
   }
 }

mysqli_commit($GLOBALS['mysqli']);
mysqli_autocommit($GLOBALS['mysqli'],true);
echo "ok$;$";
}else{
 echo 'Hiba';
}
}

?>