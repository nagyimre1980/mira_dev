<?php

function riport_ful_ki_kapcs_ossze(){

echo '<div id="riport_div_kapcs_ossze"';
if($_SESSION[$GLOBALS['sessionname']]['riport']['kapcs_ossze']['keres_lathato']==0){
	echo ' style="display:none"';
}else{
	echo ' style="display:flex"';
}
echo '>';

echo '<input style="margin-top:10px;" onclick="riport_kapcs_ossze_leker()" id="riport_leker_kapcs_ossze_submit" value="Kapcsolattartó adatok excel letöltése" class="submit2" type="submit" >';

//echo '<div>';
//echo '</div>';

echo '</div>';
}


function riport_ful_ki_kapcs_ossze_html(){
if(!isset($_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']))
 $_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']=$_POST['tagv']='keremv';
riport_ful_ki_kapcs_ossze_html_kereses();
echo "<div id='admin_uj_kapcstulaj_list_keres_tal' style='overflow-x:auto'>";
riport_ful_ki_kapcs_ossze_html_list();
echo "</div>";
}

function riport_ful_ki_kapcs_ossze_html_keres(){
if(isset($_POST['tagv']))$_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']=$_POST['tagv'];
echo "ok$;$";
riport_ful_ki_kapcs_ossze_html_list();
}

function riport_ful_ki_kapcs_ossze_html_kereses(){
echo '<div style="overflow-x:auto">';

if((isset($_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']!=""))
 $ker_tagv=$_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv'];
else $ker_tagv="";

echo "<br><b>Társasági kapcsolattartók</b>";
echo "<table id='admin_kapcsosszelist_table' class='table_emre'>";

echo "<tr>";
echo "<td>Társaság";
 $tomb_tagvkod_nev=keres_tagvkod_nev_tomb();
 echo '<td><select onchange="riport_kapcsosszelist_keres()" id="riport_kapcsosszelist_keres_tagv" class="select2_csonkolt" style="width:311px">';
 //echo '<option value="all">Összes';
 echo '<option value="keremv">Kérem válassz';
 if(is_array($tomb_tagvkod_nev)){
  foreach($tomb_tagvkod_nev as $tagv_kod => $nev){
   echo '<option value="'.$tagv_kod.'"';
   if($_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']==$tagv_kod) echo ' selected';
   echo '>'.$tagv_kod.' - '.$nev;	 
  }
 }
 echo '</select>';

echo '</tr>';
echo '</table></div>';
}

function riport_ful_ki_kapcs_ossze_html_list(){
if(!isset($_POST['oldalholvagyok']))$_POST['oldalholvagyok']=0;

if((isset($_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']!='')and($_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']!='keremv')){
 $tomb=keres_riport_kapcsossze_uj();
}else $tomb='';
/*
$th=0;
if((is_array($tomb))and(isset($tomb[0]['tal']))){
$th=$tomb[0]['tal'];
}
*/

//echo "<br><b>Kapcsolattartók</b>";

if(
(is_array($tomb))and
 (
  (isset($tomb[1]))or
  (isset($tomb[2]))or
  (isset($tomb[3]))
 )
){

echo '<div id="scroll1" style="overflow-x:auto;margin-top:20px">';
echo '<div></div>';
echo '</div>';
echo '<div id="scroll2" style="overflow-x:auto;">';

echo "<table id='riport_kapcstulajlist_table' class='table_emre'>";
echo "<thead><tr>";

echo "<th>Társaság";
echo "<th>Tulajdonosi joggyakorló".'</b>';
echo "<th>Adószám".'</b>';
echo "<th>Cím".'</b>';
echo "<th>Kapcsolattartó szerepe".'</b>';
echo "<th>Szolgáltatás".'</b>';
echo "<th>Kapcsolattartó neve".'</b>';
echo "<th>Kapcsolattartó 1. számú munkáltatója".'</b>';
echo "<th>Kapcsolattartó beosztása".'</b>';
echo "<th>Kapcsolattartó telefonszáma".'</b>';
echo "<th>Kapcsolattartó emailcíme".'</b>';
echo "</tr></thead><tbody>";

riport_kapcsossze_list_tal($tomb);

echo "</tbody></table>";

echo '</div>';

}elseif((isset($_POST['tagv']))and($_POST['tagv']!='')and($_POST['tagv']!='keremv')){
 echo '<br>Nincs beállított kapcsolattartó!';
}
}

function mailto_ki($email){
$ret='<a href="mailto:'.$email.'">'.$email.'</a>';
return $ret;
}

function riport_kapcsossze_list_tal($tomb){

/*if(
(is_array($tomb))and
(isset($tomb[0]['tal']))and
($tomb[0]['tal']>0)
){
	*/
	/*echo '<pre>';
	print_r($tomb);
	echo '</pre>';*/
if(
(is_array($tomb))and
 (
  (isset($tomb[1]))or
  (isset($tomb[2]))or
  (isset($tomb[3]))
 )
){
foreach($tomb[1] as $tagv_kod => $ert){

  if((isset($ert['adat']['vezeto_1']))and(is_array($ert['adat']['vezeto_1']))){
	echo '<tr>';
	echo '<td>'.$tagv_kod.' - '.$ert['tagv_kod_nev'];
	echo '<td>'.$ert['kapcs_tulaj_nev'];
	echo '<td>'.$ert['adoszam'];
	echo '<td>'.$ert['cim'];
	
	echo '<td>'.'1. számú vezető';
	echo '<td>'.'Általános';
	echo '<td>'.$ert['adat']['vezeto_1']['nev'];
	echo '<td>'.$ert['adat']['vezeto_1']['tagv_kod'].' - '.$ert['adat']['vezeto_1']['tagv_kod_nev'];;
	echo '<td>'.$ert['adat']['vezeto_1']['beosztas'];
	echo '<td>'.$ert['adat']['vezeto_1']['tel'];
	echo '<td>'.mailto_ki($ert['adat']['vezeto_1']['email']);
	echo '</tr>';
  }

  if((isset($ert['adat']['vezeto_1_t']))and(is_array($ert['adat']['vezeto_1_t']))){
	echo '<tr>';
	echo '<td>'.$tagv_kod.' - '.$ert['tagv_kod_nev'];
	echo '<td>'.$ert['kapcs_tulaj_nev'];
	echo '<td>'.$ert['adoszam'];
	echo '<td>'.$ert['cim'];
	
	echo '<td>'.'1. számú vezető';
	echo '<td>'.'Általános';
	echo '<td>'.$ert['adat']['vezeto_1_t']['nev'];
	echo '<td>'.$ert['adat']['vezeto_1_t']['tagv_kod'].' - '.$ert['adat']['vezeto_1_t']['tagv_kod_nev'];
	echo '<td>'.$ert['adat']['vezeto_1_t']['beosztas'];
	echo '<td>'.$ert['adat']['vezeto_1_t']['tel'];
	echo '<td>'.mailto_ki($ert['adat']['vezeto_1_t']['email']);
	echo '</tr>';
  }

  if((isset($ert['adat']['vezeto_2']))and(is_array($ert['adat']['vezeto_2']))){
	echo '<tr>';
	echo '<td>'.$tagv_kod.' - '.$ert['tagv_kod_nev'];
	echo '<td>'.$ert['kapcs_tulaj_nev'];
	echo '<td>'.$ert['adoszam'];
	echo '<td>'.$ert['cim'];
	
	echo '<td>'.'2. számú vezető/gazdasági vezető';
	echo '<td>'.'Általános';
	echo '<td>'.$ert['adat']['vezeto_2']['nev'];
	echo '<td>'.$ert['adat']['vezeto_2']['tagv_kod'].' - '.$ert['adat']['vezeto_2']['tagv_kod_nev'];;
	echo '<td>'.$ert['adat']['vezeto_2']['beosztas'];
	echo '<td>'.$ert['adat']['vezeto_2']['tel'];
	echo '<td>'.mailto_ki($ert['adat']['vezeto_2']['email']);
	echo '</tr>';
  }

  if((isset($ert['adat']['kapcstarto']))and(is_array($ert['adat']['kapcstarto']))){
	echo '<tr>';
	echo '<td>'.$tagv_kod.' - '.$ert['tagv_kod_nev'];
	echo '<td>'.$ert['kapcs_tulaj_nev'];
	echo '<td>'.$ert['adoszam'];
	echo '<td>'.$ert['cim'];
	
	echo '<td>'.'Kapcsolattartó (gazdasági ügyekben)';
	echo '<td>'.'Általános';
	echo '<td>'.$ert['adat']['kapcstarto']['nev'];
	echo '<td>'.$ert['adat']['kapcstarto']['tagv_kod'].' - '.$ert['adat']['kapcstarto']['tagv_kod_nev'];;
	echo '<td>'.$ert['adat']['kapcstarto']['beosztas'];
	echo '<td>'.$ert['adat']['kapcstarto']['tel'];
	echo '<td>'.mailto_ki($ert['adat']['kapcstarto']['email']);
	echo '</tr>';
  }

	if((isset($tomb[2][$tagv_kod]))and(is_array($tomb[2][$tagv_kod]))){
	 foreach($tomb[2][$tagv_kod] as $szolg_kod => $ert2){
		foreach($ert2 as $ert2_1){
		 echo '<tr>';
		 echo '<td>'.$tagv_kod.' - '.$ert['tagv_kod_nev'];
		 echo '<td>'.$ert['kapcs_tulaj_nev'];
		 echo '<td>'.$ert['adoszam'];
		 echo '<td>'.$ert['cim'];
		 
		 if($ert2_1['tipus']=='kapcs1'){
		  echo '<td>'.'Kapcsolattartó általános ügyekben';
		 }else{
		  echo '<td>'.'Kapcsolattartó szolgáltatás specifikus ügyekben';
		 }
		 
		 echo '<td>'.$szolg_kod.' - '.$ert2_1['szolg_kod_nev'];
		 
		 echo '<td>'.$ert2_1['nev'];
		 echo '<td>'.$ert2_1['tagv_kod_torzs'].' - '.$ert2_1['tagv_kod_torzs_nev'];
		 echo '<td>'.$ert2_1['beosztas'];
		 echo '<td>'.$ert2_1['tel'];
		 echo '<td>'.mailto_ki($ert2_1['email']);
		echo '</tr>';
		}
		
	 }
	}

	if((isset($tomb[3][$tagv_kod]))and(is_array($tomb[3][$tagv_kod]))){
	 foreach($tomb[3][$tagv_kod] as $szolg_kod => $ert3){
	   
	   if((isset($ert3['mvms']))and($ert3['mvms'])){
		echo '<tr>';
		echo '<td>'.$tagv_kod.' - '.$ert['tagv_kod_nev'];
		echo '<td>'.$ert['kapcs_tulaj_nev'];
		echo '<td>'.$ert['adoszam'];
		echo '<td>'.$ert['cim'];
		
		echo '<td>'.'MVMS kapcsolattartó szolgáltatás specifikus ügyekben';
		echo '<td>'.$szolg_kod.' - '.$ert3['mvms']['szolg_kod_nev'];
		echo '<td>'.$ert3['mvms']['nev'];
		echo '<td>'.$ert3['mvms']['tagv_kod'].' - '.$ert3['mvms']['tagv_kod_nev'];
		echo '<td>'.$ert3['mvms']['beosztas'];
		echo '<td>'.$ert3['mvms']['tel'];
		echo '<td>'.mailto_ki($ert3['mvms']['email']);
	   }

	   if((isset($ert3['sla']))and($ert3['sla'])){
		echo '<tr>';
		echo '<td>'.$tagv_kod.' - '.$ert['tagv_kod_nev'];
		echo '<td>'.$ert['kapcs_tulaj_nev'];
		echo '<td>'.$ert['adoszam'];
		echo '<td>'.$ert['cim'];
		
		echo '<td>'.'MVMS kapcsolattartó SLA/KPI';
		echo '<td>'.$szolg_kod.' - '.$ert3['sla']['szolg_kod_nev'];
		echo '<td>'.$ert3['sla']['nev'];
		echo '<td>'.$ert3['sla']['tagv_kod'].' - '.$ert3['sla']['tagv_kod_nev'];
		echo '<td>'.$ert3['sla']['beosztas'];
		echo '<td>'.$ert3['sla']['tel'];
		echo '<td>'.mailto_ki($ert3['sla']['email']);
		echo '</tr>';
	   }
	   
	 }
	}



}
}
}

function keres_riport_kapcsossze_uj(){
$eredmeny_keres="";
$where="";

$tagv=$_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv'];
//Talszám - eleje
///$talszam=keres_talszam('riport_kapcsosszelist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
//$sql_order=keres_order('riport_kapcsosszelist_keres_order','riport_kapcsosszelist_keres_order_mod');
//Rendezés - vége

$where.="
 mira_tagv_kod.tagv_kod='".$tagv."' and 
(
 mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1 is not null or
 mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1_t is not null or
 mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_2 is not null or
 mira_tagv_kod.tagv_kod_kapcs_torzs_id_kapcstarto is not null
)
";
/*
 if((isset($_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']!="all")){
  if($where!="") $where.=" and ";
  $where.="kapcs_ossze.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['riport_kapcsosszelist_keres']['tagv']."'";
 }
*/
$sql1="SELECT SUM(tal) as tal FROM (
(
SELECT count(mira_tagv_kod.tagv_kod) as tal
FROM `mira_tagv_kod`
where ".$where.")";

$sql1.="union(
SELECT count(kapcs_ossze.kapcs_ossze_id ) as tal
FROM `mira_tagv_kod` 
inner join kapcs_ossze ON kapcs_ossze.tagv_kod = mira_tagv_kod.tagv_kod
inner join kapcs_ossze_kapcs ON kapcs_ossze_kapcs.kapcs_ossze_id = kapcs_ossze.kapcs_ossze_id
where mira_tagv_kod.tagv_kod='".$tagv."' 
)";

$sql1.="union(
SELECT count(kapcs_ossze.kapcs_ossze_id) as tal
FROM `mira_tagv_kod`
inner join kapcs_ossze ON kapcs_ossze.tagv_kod = mira_tagv_kod.tagv_kod
where 
mira_tagv_kod.tagv_kod='".$tagv."' and
(
 kapcs_ossze.kapcs_ossze_kapcs_torzs_id_mvms is not null
 or
 kapcs_ossze.kapcs_ossze_kapcs_torzs_id_sla is not null
)
)
) t";


$sql="SELECT 
mira_tagv_kod.tagv_kod,
mira_tagv_kod.tagv_kod_nev,
mira_tagv_kod.tagv_kod_adoszam,
mira_tagv_kod.tagv_kod_cim,
mira_tagv_kod.kapcs_tulaj_kod,
kapcs_tulaj.kapcs_tulaj_nev,

kapcs_torzs_vezeto_1.kapcs_torzs_nev as kapcs_torzs_vezeto_1_nev,
kapcs_torzs_vezeto_1.tagv_kod as kapcs_torzs_vezeto_1_tagv_kod,
kapcs_torzs_vezeto_1.kapcs_torzs_beosztas as kapcs_torzs_vezeto_1_beosztas,
kapcs_torzs_vezeto_1.kapcs_torzs_tel as kapcs_torzs_vezeto_1_tel,
kapcs_torzs_vezeto_1.kapcs_torzs_email as kapcs_torzs_vezeto_1_email,

kapcs_torzs_vezeto_1_t.kapcs_torzs_nev as kapcs_torzs_vezeto_1_t_nev,
kapcs_torzs_vezeto_1_t.tagv_kod as kapcs_torzs_vezeto_1_t_tagv_kod,
kapcs_torzs_vezeto_1_t.kapcs_torzs_beosztas as kapcs_torzs_vezeto_1_t_beosztas,
kapcs_torzs_vezeto_1_t.kapcs_torzs_tel as kapcs_torzs_vezeto_1_t_tel,
kapcs_torzs_vezeto_1_t.kapcs_torzs_email as kapcs_torzs_vezeto_1_t_email,

kapcs_torzs_vezeto_2.kapcs_torzs_nev as kapcs_torzs_vezeto_2_nev,
kapcs_torzs_vezeto_2.tagv_kod as kapcs_torzs_vezeto_2_tagv_kod,
kapcs_torzs_vezeto_2.kapcs_torzs_beosztas as kapcs_torzs_vezeto_2_beosztas,
kapcs_torzs_vezeto_2.kapcs_torzs_tel as kapcs_torzs_vezeto_2_tel,
kapcs_torzs_vezeto_2.kapcs_torzs_email as kapcs_torzs_vezeto_2_email,

kapcs_torzs_kapcstarto.kapcs_torzs_nev as kapcs_torzs_kapcstarto_nev,
kapcs_torzs_kapcstarto.tagv_kod as kapcs_torzs_kapcstarto_tagv_kod,
kapcs_torzs_kapcstarto.kapcs_torzs_beosztas as kapcs_torzs_kapcstarto_beosztas,
kapcs_torzs_kapcstarto.kapcs_torzs_tel as kapcs_torzs_kapcstarto_tel,
kapcs_torzs_kapcstarto.kapcs_torzs_email as kapcs_torzs_kapcstarto_email,

mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1,
mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1_t,
mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_2,
mira_tagv_kod.tagv_kod_kapcs_torzs_id_kapcstarto,

mira_tagv_kod_vezeto_1.tagv_kod_nev as tagv_kod_nev_vezeto_1,
mira_tagv_kod_vezeto_1_t.tagv_kod_nev as tagv_kod_nev_vezeto_1_t,
mira_tagv_kod_vezeto_2.tagv_kod_nev as tagv_kod_nev_vezeto_2,
mira_tagv_kod_kapcstarto.tagv_kod_nev as tagv_kod_nev_kapcstarto

FROM `mira_tagv_kod`

left join kapcs_tulaj ON kapcs_tulaj.kapcs_tulaj_kod = mira_tagv_kod.kapcs_tulaj_kod

left join kapcs_torzs as kapcs_torzs_vezeto_1 ON kapcs_torzs_vezeto_1.kapcs_torzs_id = mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1
left join kapcs_torzs as kapcs_torzs_vezeto_1_t ON kapcs_torzs_vezeto_1_t.kapcs_torzs_id = mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1_t
left join kapcs_torzs as kapcs_torzs_vezeto_2 ON kapcs_torzs_vezeto_2.kapcs_torzs_id = mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_2
left join kapcs_torzs as kapcs_torzs_kapcstarto ON kapcs_torzs_kapcstarto.kapcs_torzs_id = mira_tagv_kod.tagv_kod_kapcs_torzs_id_kapcstarto

left join mira_tagv_kod as mira_tagv_kod_vezeto_1 ON mira_tagv_kod_vezeto_1.tagv_kod = kapcs_torzs_vezeto_1.tagv_kod
left join mira_tagv_kod as mira_tagv_kod_vezeto_1_t ON mira_tagv_kod_vezeto_1_t.tagv_kod = kapcs_torzs_vezeto_1_t.tagv_kod
left join mira_tagv_kod as mira_tagv_kod_vezeto_2 ON mira_tagv_kod_vezeto_2.tagv_kod = kapcs_torzs_vezeto_2.tagv_kod
left join mira_tagv_kod as mira_tagv_kod_kapcstarto ON mira_tagv_kod_kapcstarto.tagv_kod = kapcs_torzs_kapcstarto.tagv_kod

where ".$where.' order by mira_tagv_kod.tagv_kod ASC';

$sql_2="SELECT 
mira_tagv_kod.tagv_kod,
kapcs_ossze.szolg_kod,
mira_szolg_kod.szolg_kod_nev,

kapcs_ossze_kapcs.kapcs_ossze_kapcs_tipus,

kapcs_torzs.kapcs_torzs_nev,
kapcs_torzs.tagv_kod as tagv_kod_torzs,
kapcs_torzs.kapcs_torzs_beosztas,
kapcs_torzs.kapcs_torzs_tel,
kapcs_torzs.kapcs_torzs_email,

mira_tagv_kod_ossze.tagv_kod_nev as tagv_kod_torzs_nev

FROM `mira_tagv_kod`
inner join kapcs_ossze ON kapcs_ossze.tagv_kod = mira_tagv_kod.tagv_kod
left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = kapcs_ossze.szolg_kod
inner join kapcs_ossze_kapcs ON kapcs_ossze_kapcs.kapcs_ossze_id = kapcs_ossze.kapcs_ossze_id
left join kapcs_torzs ON kapcs_torzs.kapcs_torzs_id = kapcs_ossze_kapcs.kapcs_torzs_id 

left join mira_tagv_kod as mira_tagv_kod_ossze ON mira_tagv_kod_ossze.tagv_kod = kapcs_torzs.tagv_kod
where mira_tagv_kod.tagv_kod='".$tagv."' 
order by mira_tagv_kod.tagv_kod asc,kapcs_ossze.szolg_kod asc, kapcs_torzs.kapcs_torzs_nev asc 

";

$sql_3="SELECT 
mira_tagv_kod.tagv_kod,
kapcs_ossze.szolg_kod,
mira_szolg_kod.szolg_kod_nev,

kapcs_torzs_mvms.kapcs_torzs_nev as kapcs_torzs_nev_mvms,
kapcs_torzs_mvms.tagv_kod as tagv_kod_mvms,
kapcs_torzs_mvms.kapcs_torzs_beosztas as kapcs_torzs_beosztas_mvms,
kapcs_torzs_mvms.kapcs_torzs_tel as kapcs_torzs_tel_mvms,
kapcs_torzs_mvms.kapcs_torzs_email as kapcs_torzs_email_mvms,

kapcs_torzs_sla.kapcs_torzs_nev as kapcs_torzs_nev_sla,
kapcs_torzs_sla.tagv_kod as tagv_kod_sla,
kapcs_torzs_sla.kapcs_torzs_beosztas as kapcs_torzs_beosztas_sla,
kapcs_torzs_sla.kapcs_torzs_tel as kapcs_torzs_tel_sla,
kapcs_torzs_sla.kapcs_torzs_email as kapcs_torzs_email_sla,

kapcs_ossze.kapcs_ossze_kapcs_torzs_id_mvms,
kapcs_ossze.kapcs_ossze_kapcs_torzs_id_sla,

mira_tagv_kod_mvms.tagv_kod_nev as tagv_kod_nev_mvms,
mira_tagv_kod_sla.tagv_kod_nev as tagv_kod_nev_sla

FROM `mira_tagv_kod`
inner join kapcs_ossze ON kapcs_ossze.tagv_kod = mira_tagv_kod.tagv_kod
left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = kapcs_ossze.szolg_kod
left join kapcs_torzs as kapcs_torzs_mvms ON kapcs_torzs_mvms.kapcs_torzs_id = kapcs_ossze.kapcs_ossze_kapcs_torzs_id_mvms
left join kapcs_torzs as kapcs_torzs_sla ON kapcs_torzs_sla.kapcs_torzs_id = kapcs_ossze.kapcs_ossze_kapcs_torzs_id_sla
left join mira_tagv_kod as mira_tagv_kod_mvms ON mira_tagv_kod_mvms.tagv_kod = kapcs_torzs_mvms.tagv_kod
left join mira_tagv_kod as mira_tagv_kod_sla ON mira_tagv_kod_sla.tagv_kod = kapcs_torzs_sla.tagv_kod
where mira_tagv_kod.tagv_kod='".$tagv."' 
";

/*
 //print $sql1."<br>";exit;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[0]=$adatom1;
 }
 */
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 $i=0;
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();

  if(!isset($eredmeny_keres[$adatom['tagv_kod']])){
   $eredmeny_keres[1][$adatom['tagv_kod']]['tagv_kod_nev']=$adatom['tagv_kod_nev'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['kapcs_tulaj_nev']=$adatom['kapcs_tulaj_kod'].' - '.$adatom['kapcs_tulaj_nev'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adoszam']=$adatom['tagv_kod_adoszam'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['cim']=$adatom['tagv_kod_cim'];
  }
  
  if($adatom['tagv_kod_kapcs_torzs_id_vezeto_1']!=''){
   $i++;
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1']['szerep']='vezeto_1';
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1']['szolg_kod_nev']='Általános';
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1']['nev']=$adatom['kapcs_torzs_vezeto_1_nev'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1']['tagv_kod']=$adatom['kapcs_torzs_vezeto_1_tagv_kod'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1']['tagv_kod_nev']=$adatom['tagv_kod_nev_vezeto_1'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1']['beosztas']=$adatom['kapcs_torzs_vezeto_1_beosztas'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1']['tel']=$adatom['kapcs_torzs_vezeto_1_tel'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1']['email']=$adatom['kapcs_torzs_vezeto_1_email'];
  }
  
  if($adatom['tagv_kod_kapcs_torzs_id_vezeto_1_t']!=''){
   $i++;
   //$eredmeny_keres[$adatom['tagv_kod']]['adat'][$i]['szerep']='vezeto_1_t';
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_1_t']['szolg_kod_nev']='Általános';
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1_t']['nev']=$adatom['kapcs_torzs_vezeto_1_t_nev'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1_t']['tagv_kod']=$adatom['kapcs_torzs_vezeto_1_t_tagv_kod'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1_t']['tagv_kod_nev']=$adatom['tagv_kod_nev_vezeto_1_t'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1_t']['beosztas']=$adatom['kapcs_torzs_vezeto_1_t_beosztas'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1_t']['tel']=$adatom['kapcs_torzs_vezeto_1_t_tel'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_1_t']['email']=$adatom['kapcs_torzs_vezeto_1_t_email'];
  }
  
  if($adatom['tagv_kod_kapcs_torzs_id_vezeto_2']!=''){
   $i++;
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_2']['szerep']='vezeto_2';
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['vezeto_2']['szolg_kod_nev']='Általános';
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_2']['nev']=$adatom['kapcs_torzs_vezeto_2_nev'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_2']['tagv_kod']=$adatom['kapcs_torzs_vezeto_2_tagv_kod'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_2']['tagv_kod_nev']=$adatom['tagv_kod_nev_vezeto_2'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_2']['beosztas']=$adatom['kapcs_torzs_vezeto_2_beosztas'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_2']['tel']=$adatom['kapcs_torzs_vezeto_2_tel'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['vezeto_2']['email']=$adatom['kapcs_torzs_vezeto_2_email'];
  }
  
  if($adatom['tagv_kod_kapcs_torzs_id_kapcstarto']!=''){
   $i++;
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['kapcstarto']['szerep']='kapcstarto';
   //$eredmeny_keres[$adatom['tagv_kod']]['adat']['kapcstarto']['szolg_kod_nev']='Általános';
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['kapcstarto']['nev']=$adatom['kapcs_torzs_kapcstarto_nev'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['kapcstarto']['tagv_kod']=$adatom['kapcs_torzs_kapcstarto_tagv_kod'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['kapcstarto']['tagv_kod_nev']=$adatom['tagv_kod_nev_kapcstarto'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['kapcstarto']['beosztas']=$adatom['kapcs_torzs_kapcstarto_beosztas'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['kapcstarto']['tel']=$adatom['kapcs_torzs_kapcstarto_tel'];
   $eredmeny_keres[1][$adatom['tagv_kod']]['adat']['kapcstarto']['email']=$adatom['kapcs_torzs_kapcstarto_email'];
  }
 }

 $adat=mysqli_query($GLOBALS['mysqli'],$sql_2);
 $i=0;
 while($adatom=mysqli_fetch_assoc($adat)){
 if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $i++;
  //$eredmeny_keres[$adatom['tagv_kod']][$i]['szolg_kod']=$adatom['szolg_kod'];
  $eredmeny_keres[2][$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['szolg_kod']=$adatom['szolg_kod'];
  $eredmeny_keres[2][$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['szolg_kod_nev']=$adatom['szolg_kod_nev'];
  $eredmeny_keres[2][$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['tipus']=$adatom['kapcs_ossze_kapcs_tipus'];
  $eredmeny_keres[2][$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['nev']=$adatom['kapcs_torzs_nev'];
  $eredmeny_keres[2][$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['tagv_kod_torzs']=$adatom['tagv_kod_torzs'];
  $eredmeny_keres[2][$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['tagv_kod_torzs_nev']=$adatom['tagv_kod_torzs_nev'];
  $eredmeny_keres[2][$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['beosztas']=$adatom['kapcs_torzs_beosztas'];
  $eredmeny_keres[2][$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['tel']=$adatom['kapcs_torzs_tel'];
  $eredmeny_keres[2][$adatom['tagv_kod']][$adatom['szolg_kod']][$i]['email']=$adatom['kapcs_torzs_email'];
 }

 $adat=mysqli_query($GLOBALS['mysqli'],$sql_3);
 $i=0;
 while($adatom=mysqli_fetch_assoc($adat)){  
  
  if($adatom['kapcs_ossze_kapcs_torzs_id_mvms']!=''){
   if(!is_array($eredmeny_keres))$eredmeny_keres=array();
   $i++;
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['szolg_kod_nev']=$adatom['szolg_kod_nev'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['nev']=$adatom['kapcs_torzs_nev_mvms'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['tagv_kod']=$adatom['tagv_kod_mvms'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['tagv_kod_nev']=$adatom['tagv_kod_nev_mvms'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['beosztas']=$adatom['kapcs_torzs_beosztas_mvms'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['tel']=$adatom['kapcs_torzs_tel_mvms'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['mvms']['email']=$adatom['kapcs_torzs_email_mvms'];
  }
  
  if($adatom['kapcs_ossze_kapcs_torzs_id_sla']!=''){
   if(!is_array($eredmeny_keres))$eredmeny_keres=array();
   $i++;
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['szolg_kod_nev']=$adatom['szolg_kod_nev'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['nev']=$adatom['kapcs_torzs_nev_sla'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['tagv_kod']=$adatom['tagv_kod_sla'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['tagv_kod_nev']=$adatom['tagv_kod_nev_sla'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['beosztas']=$adatom['kapcs_torzs_beosztas_sla'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['tel']=$adatom['kapcs_torzs_tel_sla'];
   $eredmeny_keres[3][$adatom['tagv_kod']][$adatom['szolg_kod']]['sla']['email']=$adatom['kapcs_torzs_email_sla'];
  }
  
 }

 return $eredmeny_keres;
}

?>