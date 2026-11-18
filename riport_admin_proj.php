<?php

function riport_ful_ki_admin_proj(){
echo '<div id="riport_div_admin_proj"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['admin_proj']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

echo '<input style="margin-top:10px;" onclick="riport_admin_proj_leker()" id="riport_leker_admin_proj_submit" value="Tevékenység excel letöltése" class="submit2" type="submit">';

echo '</div>';
}

?>