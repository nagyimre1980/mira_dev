<?php

function riport_ful_ki_admin_szerv(){
echo '<div id="riport_div_admin_szerv"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['admin_szerv']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

echo '<input style="margin-top:10px;" onclick="riport_admin_szerv_leker()" id="riport_leker_admin_szerv_submit" value="Szervezet excel letöltése" class="submit2" type="submit">';

echo '</div>';
}

?>