<?php

function riport_ful_ki_admin_user(){
echo '<div id="riport_div_admin_user"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['admin_user']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

echo '<input style="margin-top:10px;" onclick="riport_admin_user_leker()" id="riport_leker_admin_user_submit" value="Jogosultság excel letöltése" class="submit2" type="submit">';

echo '</div>';
}

?>