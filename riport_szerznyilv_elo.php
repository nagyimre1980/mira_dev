<?php

function riport_ful_ki_szerznyilv_elo(){

echo '<div id="riport_div_szerznyilv_elo"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['szerznyilv_elo']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

echo '<input style="margin-top:10px;" onclick="riport_szerznyilv_elo_leker()" id="riport_leker_szerznyilv_elo_submit" value="Szerződésnyilvántartó élő szerződések excel letöltése" class="submit2" type="submit" >';

//echo '<div>';
//echo '</div>';

echo '</div>';
}

function riport_ful_ki_szerznyilv_elo_html(){
//echo 'Szerződésnyilvántartó elő találati lista<br>';
//include_once('riport_szerznyilv.php');
//riport_ful_ki_szerznyilv_html_fo('elo');
}
?>