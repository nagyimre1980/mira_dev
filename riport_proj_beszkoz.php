<?php

function riport_ful_ki_proj_beszkoz(){
echo '<div id="riport_div_proj_beszkoz"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['proj_beszkoz']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

echo '<input style="margin-top:10px;" onclick="riport_proj_beszkoz_leker()" id="riport_leker_proj_beszkoz_submit" value="Beszerzési és közbeszerzési tevékenységek excel letöltése" class="submit2" type="submit" >';

//echo '<div>';
//echo '</div>';

echo '</div>';
}

?>