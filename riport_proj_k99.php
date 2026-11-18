<?php

function riport_ful_ki_proj_k99(){
echo '<div id="riport_div_proj_k99"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['proj_k99']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

echo '<input style="margin-top:10px;" onclick="riport_proj_k99_leker()" id="riport_leker_proj_k99_submit" value="KK99 tevékenységek excel letöltése" class="submit2" type="submit" >';

//echo '<div>';
//echo '</div>';

echo '</div>';
}

?>