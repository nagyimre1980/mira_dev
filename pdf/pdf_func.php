<?php

function fejlec_str($pdf){
		$pdf->SetY(12);
		$pdf->SetFont('freeserif', 'B', 20);
		$pdf->Cell(0,15,$GLOBALS['rend_nev'].$GLOBALS['tesztdevmod'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$pdf->SetY(24);
		$pdf->SetFont('freeserif', '', 14);
		//$pdf->Cell(0,15,"munkaidő nyilvántartó alkalmazás", 0, false, 'C', 0, '', 0, false, 'M', 'M');
		//$pdf->Cell(0,15,$GLOBALS['mira']['pdf_login_nev'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$ki_str="Tevékenység rögzítés: ".$GLOBALS['mira']['pdf_login_nev']." ".$GLOBALS['mira']['pdf_ev'].". ".ho_ki($GLOBALS['mira']['pdf_ho']);
		$pdf->Cell(0,15,$ki_str, 0, false, 'C', 0, '', 0, false, 'M', 'M');

		//$pdf->SetY(12);
		//$pdf->SetFont('freeserif', 'B',12);
		//$pdf->Cell(0,15,"Jegyzék azonosító: ".$GLOBALS['jegyzek_az'], 0, false, 'R', 0, '', 0, false, 'M', 'M');
}


function fo_pdf_honap_kirajzol_sor_ki($tomb_mentve,$ev,$ho,$nap_akt,$nap_tipus_egyedi,$jovahagyva_ho){
global $ho_sor_munkanapszam,$ora_all,$perc_all,$ora_globall,$perc_globall;
$html_ret="";
if($ho<10)$ho_ketto="0".$ho;
else $ho_ketto=$ho;

$naptime=mktime("0","0","1",$ho,$nap_akt,$ev);
$het_sorszam=date('w',$naptime);
//$naptipus=naptipus($ev,$ho,$nap_akt);

if($nap_tipus_egyedi=="PN"){
 $nap_dis="1";
}elseif($nap_tipus_egyedi=="MN"){
 $nap_dis="0";/*
}elseif(($het_sorszam!="6")and($het_sorszam!="0")and($naptipus=="PN")){
 $nap_dis="1";
}elseif((($het_sorszam=="6")or($het_sorszam=="0"))and($naptipus!="MN")){
 $nap_dis="1";*/
}elseif(($het_sorszam=="6")or($het_sorszam=="0")){
 $nap_dis="1";
}else{
 $nap_dis="0";	
}

$ma=date("Ymj",time());//d(01) helyett j(1)

if($nap_dis=="1"){//Tiltott nap színe
 $dis_style=' class="table_emre_bejovo_dis_nap"';
}elseif($ma==$ev.$ho_ketto.$nap_akt){//Akt nap színe
$dis_style=' orig_class="" class="table_emre_bejovo_akt_nap"';//alap
}else{
 //$dis_style='';//Régen nem kellett, páros-parlatlan miatt kell
 $ho_sor_munkanapszam++;
 
 if($ho_sor_munkanapszam % 2 == 0) $dis_style=' orig_class="paros" class="table_emre_bejovo_akt_nap_paros"';//Páros
 else $dis_style=' orig_class="paratlan" class="table_emre_bejovo_akt_nap_paratlan"';//Páratlan
 //$dis_style='';
}

if($nap_dis==0){
$html_ret.='<tr'.$dis_style.'>';
$html_ret.='<td style="width:70px">';
if($nap_akt<10)$nap_akt_ki="0".$nap_akt;
else $nap_akt_ki=$nap_akt;
$html_ret.=$ev.'.'.$ho_ketto.'.'.$nap_akt_ki;

$html_ret.='</td>';

$html_ret.='<td style="width:60px">';
$html_ret.=napkod($het_sorszam);
$html_ret.='</td>';

if($nap_akt<10){
 $ido=$ev."-".$ho_ketto."-0".$nap_akt;
}else{
 $ido=$ev."-".$ho_ketto."-".$nap_akt;
}

//Időráfordítás - eleje
$ora_all="0";
$perc_all="0";
$html_ret.='<td style="width:360px">';
if(
(isset($tomb_mentve['tavollet']))and
(is_array($tomb_mentve['tavollet']))and
(isset($tomb_mentve['tavollet'][$ido]))
and($tomb_mentve['tavollet'][$ido]=="1")
){
 $tavollet_ck="1";// checked
 $html_ret.="Távollét";
 $nap_jovahagyva="";
}else{
 $tavollet_ck="";
 
 if((isset($tomb_mentve['adat']))and(is_array($tomb_mentve['adat'])))
  $tomb_kuld=$tomb_mentve['adat'];
 else $tomb_kuld="";
 
  if(
 /*( 
 (isset($tomb_mentve['nap_foadat'][$ido]))
  and(isset($tomb_mentve['nap_foadat'][$ido]))
  and($tomb_mentve['nap_foadat'][$ido]['rogzit_jovahagyva']=="1")
 )or*/
 ($jovahagyva_ho==1)
 ){
	$nap_jovahagyva=1; 
 }else{
	$nap_jovahagyva=0;
 }

 $html_ret.=fo_pdf_honap_kirajzol_raford_ki($tomb_kuld,$ev,$ho_ketto,$nap_akt,$nap_tipus_egyedi,$nap_dis);
}
$html_ret.='</td>';
//Időráfordítás - vége

//Szabadság - eleje
//Távollét oszlop idő elrejtése
if(tavollet_lathato_e($ev,$ho)){
 $html_ret.='<td align="center" style="width:70px">';
 //if(($nap_dis=="0")and($nap_jovahagyva==1)){
 if($tavollet_ck=="1"){
  $html_ret.="Igen";
 }
 $html_ret.='</td>';
}
//Szabadság - vége

//Összesítés - eleje
$html_ret.='<td style="width:90px;text-align:center">';

$tomb_all_oraperc_ki=ora_perc_osszead($ora_all,$perc_all);
if($tomb_all_oraperc_ki['rogzit_perc']<10)$tomb_all_oraperc_ki_ert="0".$tomb_all_oraperc_ki['rogzit_perc'];
else $tomb_all_oraperc_ki_ert=$tomb_all_oraperc_ki['rogzit_perc'];

$ora_globall+=$tomb_all_oraperc_ki['rogzit_ora'];
$perc_globall+=$tomb_all_oraperc_ki['rogzit_perc'];

$html_ret.=$tomb_all_oraperc_ki['rogzit_ora'];
$html_ret.=":";
$html_ret.=$tomb_all_oraperc_ki_ert;
$html_ret.='</td>';

//Összesítés - vége

$html_ret.='</tr>';
}
return $html_ret;
}

function fo_pdf_honap_kirajzol_raford_ki($tomb_mentve,$ev,$ho,$nap_akt,$nap_tipus_egyedi,$nap_dis){
global $ora_all,$perc_all;
$html_ret="";

if($nap_akt<10){
 $ido=$ev."-".$ho."-0".$nap_akt;
}else{
 $ido=$ev."-".$ho."-".$nap_akt;
}

$sorsz=0;
if(
(is_array($tomb_mentve))
and
(isset($tomb_mentve[$ido])
)
){//Ekkor üres

foreach($tomb_mentve[$ido] as $tomb_mentve_ido){

	if($nap_dis=="0"){
	$sorsz++;
	if($sorsz>1)
	 $html_ret.="<br>";
	 //Idő ki - eleje
	  if(is_array($tomb_mentve_ido)){
		  
		  $ora_all+=$tomb_mentve_ido['rogzit_ora'];
		  $perc_all+=$tomb_mentve_ido['rogzit_perc'];
		  
		 if($tomb_mentve_ido['rogzit_perc']<10)$tomb_mentve_ido['rogzit_perc']="0".$tomb_mentve_ido['rogzit_perc'];
		 $val=$tomb_mentve_ido['rogzit_ora'].":".$tomb_mentve_ido['rogzit_perc'];
		}else{
		 $val="0:00";
	  }
	  $html_ret.=$val;
	 //Idő ki - vége

	 //Projekt neve - eleje
	 $html_ret.=" - ";
	  if(is_array($tomb_mentve_ido)){
			$projekt_nev=$tomb_mentve_ido['projekt_nev'];
		}else{
			$projekt_nev="";
	  }
	 $html_ret.=$projekt_nev;
	 //Projekt neve - vége 
	}
}

}
return $html_ret;
}
?>