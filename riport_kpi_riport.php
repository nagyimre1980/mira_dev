<?php

function riport_ful_ki_kpi_riport(){
echo '<div id="riport_div_kpi_riport"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['kpi_riport']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

echo '<input style="margin-top:10px;" onclick="riport_kpi_riport_leker()" id="riport_leker_kpi_riport_submit" value="KPI riport excel letöltése" class="submit2" type="submit">';

echo '</div>';
}

?>