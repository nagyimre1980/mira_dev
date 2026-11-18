<?php

function riport_ful_ki_tig_tabla(){
echo '<div id="riport_div_tig_tabla"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['tig_tabla']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

echo "<table id='riport_table_nonp' cellpadding=1 cellspacing=1 style='margin-top:10px;display:block' class='table_emre'>";

$ev_elso='2026';
$ev_utolso=date("Y",time());
echo '<tr>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Időszak</span>';
echo '<td>';
echo '<span class="jovahagy_szur_str">Év</span>';
echo '<td>';
echo '<select id="riport_tig_tabla_ev1" class="select3" style="width:60px">';
//for($i=$ev_elso;$i<=$ev_utolso;$i++){
for($i=$ev_elso;$i<=$ev_utolso;$i++){
 echo '<option value="'.$i.'"';
 if($i==$ev_utolso) echo ' selected';
 echo '>'.$i;
}
echo '</select>';

echo '<td>';
echo '<span class="jovahagy_szur_str">Hó</span>';
echo '<td>';
echo '<select id="riport_tig_tabla_ho1" class="select3" style="width:100px">';
$ho_most=date("n",time());
for($i=1;$i<=12;$i++){//Most legyen egész évbe!!
 echo '<option value="'.$i.'"';
 if($i==$ho_most) echo ' selected';
 echo '>'.ho_ki($i);
}
echo '</select>';

echo '</table>';

echo '</div>';

echo '<div id="riport_div_tig_tabla_gomb" style="margin-top:5px';
if($_SESSION[$GLOBALS['sessionname']]['riport']['tig_tabla']['keres_lathato']==0){
	echo ';display:none"';
}
echo '">';
echo '<input style="margin-top:10px;" onclick="riport_tig_tabla_leker()" id="riport_leker_tig_tabla_submit" value="TIG tábla excel letöltése" class="submit2" type="submit">';

echo '</div>';
}

?>