<?php

function keres_admin_user_szam_adminjog($tomb){//Adott usereknek fulre van joga
$eredmeny_keres='';

$where_user='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_user!='')$where_user.=' or ';
 $where_user.='mira_user_admin_jog.admin_jog_user_ad="'.$ert['user_ad'].'"';
}
}
if($where_user!='')$where_user='where '.$where_user.'';

$sql='SELECT 
*
FROM `mira_user_admin_jog` 
'.$where_user.'
';
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
   if(!is_array($eredmeny_keres))$eredmeny_keres=array();
   foreach($adatom as $amezo => $aert){
	 if(($amezo!='admin_jog_user_ad')and($aert=='1')){
	  $admin_muv_jog=explode("admin_jog_",$amezo);
	  if(isset($admin_muv_jog[1])){
		////if(!is_array($GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']))$GLOBALS[$GLOBALS['sessionname']]['jog_admin_ful']=array();
	    if(!isset($eredmeny_keres[$adatom['admin_jog_user_ad']]))
			$eredmeny_keres[$adatom['admin_jog_user_ad']]=1;
		else
			$eredmeny_keres[$adatom['admin_jog_user_ad']]++;
	  }
	 }
	}
  
 }
 return $eredmeny_keres;
}

//Adott userhez hány projekt van hozzárendelve, csak szám
function keres_user_hozzarend_projektszam($tomb){
 $eredmeny_keres="";
 
 $where_user='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_user!='')$where_user.=' or ';
 $where_user.='projekt_user.user_ad="'.$ert['user_ad'].'"';
}
}
if($where_user!='')$where_user='where '.$where_user.'';

//	and projekt.projekt_tagv = '".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(projekt_user.projekt_user_id) as szam,projekt_user.user_ad
 FROM `projekt_user` 
 inner join projekt ON projekt.projekt_id = projekt_user.projekt_id
	and projekt.projekt_inaktiv = '0'
	".$where_user."
 GROUP BY projekt_user.user_ad";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}

//Adott userhez hány projekt jóváhagyás van hozzárendelve, csak szám
function keres_user_hozzarend_projektjovahagyoszam($tomb){
 $eredmeny_keres="";
 
 $where_user='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_user!='')$where_user.=' or ';
 $where_user.='projekt_jovahagyo.user_ad="'.$ert['user_ad'].'"';
}
}
if($where_user!='')$where_user='where '.$where_user.'';
//	and projekt.projekt_tagv = '".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(projekt_jovahagyo.projekt_jovahagyo_id) as szam,projekt_jovahagyo.user_ad
 FROM `projekt_jovahagyo` 
 inner join projekt ON projekt.projekt_id = projekt_jovahagyo.projekt_id

	".$where_user."
 GROUP BY projekt_jovahagyo.user_ad";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}

//Adott userhez hány jóváhagyás van hozzárendelve, csak szám
function keres_user_hozzarend_jovahagyoszam($tomb){
 $eredmeny_keres="";
 
 $where_user='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_user!='')$where_user.=' or ';
 $where_user.='mira_szerv_jovahagyo.user_ad="'.$ert['user_ad'].'"';
}
}
if($where_user!='')$where_user='where '.$where_user.'';
//	and mira_szerv.szerv_tagv ='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(mira_szerv_jovahagyo.szerv_jovahagyo_id) as szam,mira_szerv_jovahagyo.user_ad
 FROM `mira_szerv_jovahagyo` 
 inner join mira_szerv ON mira_szerv.szerv_id = mira_szerv_jovahagyo.szerv_id

	and mira_szerv.szerv_inaktiv ='0'
	".$where_user."
 GROUP BY mira_szerv_jovahagyo.user_ad";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}

//Adott userhez hány felettes jóváhagyás van hozzárendelve, csak szám
function keres_user_hozzarend_felettes_jovahagyoszam($tomb){
 $eredmeny_keres="";
 
 $where_user='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_user!='')$where_user.=' or ';
 $where_user.='mira_user_felettes_jovahagyo.user_ad="'.$ert['user_ad'].'"';
}
}
if($where_user!='')$where_user='where '.$where_user.'';
//	and mira_user.user_tagv ='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo) as szam,mira_user_felettes_jovahagyo.user_ad
 FROM `mira_user_felettes_jovahagyo` 
 inner join mira_user ON mira_user.user_ad = mira_user_felettes_jovahagyo.user_ad

 inner join mira_user AS mira_user_felettesjovahagyo ON mira_user_felettesjovahagyo.user_ad = mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo
	and mira_user_felettesjovahagyo.user_inaktiv='0'
	".$where_user."
 GROUP BY mira_user_felettes_jovahagyo.user_ad";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}


//Adott userhez hány helyettes van hozzárendelve, csak szám
function keres_user_hozzarend_helyettesszam($tomb){
 $eredmeny_keres="";

$where_user='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_user!='')$where_user.=' or ';
 $where_user.='mira_user_helyettes.user_ad="'.$ert['user_ad'].'"';
}
}
if($where_user!='')$where_user='where '.$where_user.'';
//	and mira_user.user_tagv ='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(mira_user_helyettes.user_ad) as szam,
 mira_user_helyettes.user_ad
 FROM `mira_user_helyettes` 
 inner join mira_user ON mira_user.user_ad = mira_user_helyettes.user_ad_helyettes

 inner join mira_user AS mira_user_helyettesem ON mira_user_helyettesem.user_ad = mira_user_helyettes.user_ad_helyettes
	and mira_user_helyettesem.user_inaktiv='0'
	".$where_user."
 GROUP BY mira_user_helyettes.user_ad";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}

//Adott userhez hány statisztika szervezet van hozzárendelve, csak szám
function keres_user_hozzarend_statszervszam($tomb){
 $eredmeny_keres="";
 
 $where_user='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_user!='')$where_user.=' or ';
 $where_user.='mira_user_stat.user_ad="'.$ert['user_ad'].'"';
}
}
if($where_user!='')$where_user='where '.$where_user.'';
//	and mira_szerv.szerv_tagv ='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(mira_user_stat.mira_user_stat_id) as szam,mira_user_stat.user_ad
 FROM `mira_user_stat` 
 inner join mira_szerv ON mira_szerv.szerv_id = mira_user_stat.szerv_id

	and mira_szerv.szerv_inaktiv ='0'
	".$where_user."
 GROUP BY mira_user_stat.user_ad";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}

//Adott userhez hány statisztika projekt van hozzárendelve, csak szám
function keres_user_hozzarend_statprojektszam($tomb){
 $eredmeny_keres="";
 
 $where_user='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_user!='')$where_user.=' or ';
 $where_user.='mira_user_stat_proj.user_ad="'.$ert['user_ad'].'"';
}
}
if($where_user!='')$where_user='where '.$where_user.'';
//	and projekt.projekt_tagv ='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(mira_user_stat_proj.mira_user_stat_proj_id) as szam,mira_user_stat_proj.user_ad
 FROM `mira_user_stat_proj` 
 inner join projekt ON projekt.projekt_id = mira_user_stat_proj.projekt_id

	".$where_user."
 GROUP BY mira_user_stat_proj.user_ad";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}


//Adott userhez hány riport tipus van hozzárendelve, csak szám
function keres_user_hozzarend_statriportszam($tomb){
 $eredmeny_keres="";
 
  $where_user='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_user!='')$where_user.=' or ';
 $where_user.='mira_user_riport.user_ad="'.$ert['user_ad'].'"';
}
}
if($where_user!='')$where_user='where '.$where_user.'';

 $sql="SELECT COUNT(mira_user_riport.mira_user_riport_id) as szam,mira_user_riport.user_ad
 FROM `mira_user_riport` 
 ".$where_user."
 GROUP BY mira_user_riport.user_ad";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}

function keres_admin_user_uj(){
$eredmeny_keres="";
$where="";
//$where=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'";

//Talszám - eleje
$talszam=keres_talszam('user_userlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('user_userlist_keres_order','user_userlist_keres_order_mod');
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['ad']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['ad']!="")){
  if($where!="") $where.=" and ";
  $where.="mira_user.user_ad like '".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['ad'])."%'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="mira_user.user_nev like '%".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['nev'])."%'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['tsz']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['tsz']!="")){
  if($where!="") $where.=" and ";
  $where.="mira_user.user_tsz like '".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['tsz'])."%'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['inaktiv']!="all")){
  if($where!="") $where.=" and ";
  $where.="mira_user.user_inaktiv = '".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['inaktiv'])."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['szerv_id']))
	 and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['szerv_id']!="all")){
  if($where!="") $where.=" and ";
  $where.=" mira_user.szerv_id='".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['szerv_id'])."'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido']))
	 and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido']!="all")
	 and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido']!="global")
	 and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido']!="0")
  )
 {
  if($where!="") $where.=" and ";
  $where.=" mira_user_ker_jog.user_napi_ido_max_ora='".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido'])."'";
 }elseif((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido']))
	 and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido']!="all")
	 and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido']=="global")
  )
 {
  if($where!="") $where.=" and ";
  $where.=" mira_user_ker_jog.user_napi_ido_max_ora='0' and mira_user_ker_jog.user_napi_ido_max_perc='0'"; 
 }else if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido']))
	 and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido']!="all")
	 and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['maxido']=="0")
  )
 {
	  if($where!="") $where.=" and ";
  $where.=" mira_user_ker_jog.user_napi_ido_max_ora='0' and mira_user_ker_jog.user_napi_ido_max_perc!='0'"; 
 
 }
 
 //Rögzítés kezdete
  if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date']))
	 and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date']!="")){
  if($where!="") $where.=" and ";
  if($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date_mod']=="k")
   $where.=" mira_user.user_kezd_date<='".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date'])."'";
  else 
   $where.=" mira_user.user_kezd_date>='".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['kezd_date'])."'";
  $where.=" and mira_user.user_kezd_date!='0000-00-00' ";
 }
 
  //Rögzítés vége
  if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date']))
	 and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date']!="")){
  if($where!="") $where.=" and ";
  if($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date_mod']=="k")
   $where.=" mira_user.user_veg_date<='".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date'])."'";
  else 
   $where.=" mira_user.user_veg_date>='".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['veg_date'])."'";
 $where.=" and mira_user.user_veg_date!='0000-00-00' ";
 }
 
 $join="";
 $join1="";
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']))
	 and($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']!="all")){
  if(
  ($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']!="felettes_jo_van")
  and
  ($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']!="szerv_jovahagyo")
  and
  ($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']!="felettes_jovahagyo")
  and
  ($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']!="szerv_vagy_felettes_jovahagyo")
  and
  ($where!="")
	  )
	  $where.=" and ";
  
  if($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="jovahagy"){
   $where.=" mira_user.ful_jovahagy='1'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="stat"){
   $where.=" mira_user.ful_stat='1'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="riport"){
   $where.=" mira_user.ful_riport='1'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="admin"){
   $where.=" mira_user.ful_admin='1'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="rogzites_igen"){
	$where.=" mira_user.ful_rogzit='1'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="rogzites_nem"){
	$where.=" mira_user.ful_rogzit='0'";  
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="felettes_jo_van"){
	  $join.=" inner join mira_user_felettes_jovahagyo on mira_user_felettes_jovahagyo.user_ad = mira_user.user_ad ";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="felettes_jovahagyo"){
	  $join.=" inner join mira_user_felettes_jovahagyo on mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo = mira_user.user_ad ";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="szerv_jovahagyo"){
	$join.=" inner join mira_szerv_jovahagyo on mira_szerv_jovahagyo.user_ad = mira_user.user_ad ";
	$join1.=" left join mira_szerv ON mira_szerv.szerv_id = mira_user.szerv_id ";
	if($where!="") $where.=" and ";
	$where.=" mira_szerv.szerv_inaktiv='0' ";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_userlist_keres']['jog']=="szerv_vagy_felettes_jovahagyo"){
	  $join.=" left join mira_user_felettes_jovahagyo on mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo = mira_user.user_ad ";
	  $join.=" left join mira_szerv_jovahagyo on mira_szerv_jovahagyo.user_ad = mira_user.user_ad ";
	  $join.=" left join mira_szerv as mira_szerv_s ON mira_szerv_s.szerv_id = mira_szerv_jovahagyo.szerv_id ";
		if($where!="") $where.=" and ";
		 $where.=" (
		 (mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo is not null)
		 or
		 (
		  (mira_szerv_jovahagyo.user_ad is not null)
		  and
		  (mira_szerv_s.szerv_inaktiv='0')
		 )
		 
		 ) ";
  }else{
	  echo "Rendszerhiba!";
	  exit;
  }
 }

 //riport esetén teljes lista kell:
 if((isset($_POST['riport_lekeres'])) and ($_POST['riport_lekeres']=='1')){
	 $where=$join=$join1='';
 }
 
 $sql1="SELECT count(tal1) as tal FROM (SELECT count(mira_user.user_ad) as tal1 FROM `mira_user` 
 left join mira_user_ker_jog ON mira_user_ker_jog.user_ad = mira_user.user_ad
 ".$join.$join1;
 if($where!="") 
  $sql1.="where ".$where;
 $sql1.=" GROUP BY mira_user.user_ad ";
 $sql1.=") t";
 
 if($sql1=="SELECT count(tal1) as tal FROM (SELECT count(mira_user.user_ad) as tal1 FROM `mira_user` 
 left join mira_user_ker_jog ON mira_user_ker_jog.user_ad = mira_user.user_ad
  GROUP BY mira_user.user_ad ) t"){
	 $sql1='SELECT COUNT(*) as tal FROM mira_user;';
 }
	 
 $sql="SELECT mira_user.*, mira_szerv.szerv_nev,mira_szerv.szerv_inaktiv
 ,mira_user_ker_jog.user_napi_ido_max_ora
 ,IF(rogzit.rogzit_id IS NULL,0,1) AS rogziztett
 FROM `mira_user` 
  left join mira_szerv ON mira_szerv.szerv_id = mira_user.szerv_id
  left join mira_user_ker_jog ON mira_user_ker_jog.user_ad = mira_user.user_ad
  left join rogzit ON rogzit.user_ad = mira_user.user_ad
 ".$join;
 if($where!="") 
  $sql.="where ".$where;
 $sql.=" GROUP BY mira_user.user_ad ";
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 $sql="SELECT 
    mira_user.*, 
    mira_szerv.szerv_nev, 
    mira_szerv.szerv_inaktiv, 
    mira_user_ker_jog.user_napi_ido_max_ora,
    mira_user_ker_jog.user_napi_ido_max_perc,
    IF(
        (SELECT 1 FROM rogzit WHERE rogzit.user_ad = mira_user.user_ad LIMIT 1), 
        1, 
        0
    ) AS rogziztett
FROM `mira_user`
LEFT JOIN mira_szerv ON mira_szerv.szerv_id = mira_user.szerv_id 
LEFT JOIN mira_user_ker_jog ON mira_user_ker_jog.user_ad = mira_user.user_ad 
 ".$join;
  if($where!="") 
  $sql.="where ".$where;
 $sql.=" GROUP BY mira_user.user_ad ";
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_veghoutan_vane_lezathonap($ad,$ho){
 $eredmeny_keres="";
 $ad=mysqli_real_escape_string($GLOBALS['mysqli'],$ad);
 $ho=mysqli_real_escape_string($GLOBALS['mysqli'],$ho);
 $sql="SELECT rogzit_ho_id 
 FROM `rogzit_ho`
WHERE `user_ad` = '".$ad."' AND `rogzit_ho` >= '".$ho."'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom;
 }
 return $eredmeny_keres;
}

function torles_admin_user_veg_date_utanni_all($ad,$user_veg_date){
$ad=mysqli_real_escape_string($GLOBALS['mysqli'],$ad);
$user_veg_date=mysqli_real_escape_string($GLOBALS['mysqli'],$user_veg_date);
$sql="Delete from `rogzit` WHERE `user_ad`='".$ad."' and `rogzit_nap`>'".$user_veg_date."'";
//echo $sql;
if(mysqli_query($GLOBALS['mysqli'],$sql))
{
echo "";
}else{
echo "hiba";
echo"<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
echo("<br>MySQL error: ".mysqli_errno($GLOBALS['mysqli']).", ".mysqli_error($GLOBALS['mysqli'])."<br>in sql: ".$sql);
exit;
}
}

function keres_user_vane_rogzitve($user_ad){
$eredmeny_keres='0';
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 $sql='SELECT IF(rogzit.rogzit_id IS NULL,0,1) AS rogziztett
 FROM `rogzit` 
 where rogzit.user_ad="'.$user_ad.'"';
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  $eredmeny_keres=$adatom['rogziztett'];
 }
 return $eredmeny_keres;
}


function keres_user_utolso_szerv_jovhagyo_e($user_ad){
 $eredmeny_keres='';
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 //print $sql."<br>";
 //mira_szerv.szerv_id,
  $sql="SELECT 
	mira_szerv.szerv_nev,
	count(mira_user.user_ad) as szam
	FROM `mira_szerv_jovahagyo`
	INNER JOIN mira_szerv ON 
	mira_szerv.szerv_id = mira_szerv_jovahagyo.szerv_id
	AND mira_szerv.szerv_inaktiv = '0'
	
	left join mira_szerv_jovahagyo as mira_szerv_jovahagyo_t ON 
		mira_szerv_jovahagyo_t.szerv_id=mira_szerv.szerv_id

	inner join mira_user ON
		mira_user.user_ad=mira_szerv_jovahagyo_t.user_ad
		and mira_user.user_inaktiv='0'

WHERE mira_szerv_jovahagyo.user_ad = '".$user_ad."'
group by mira_szerv.szerv_id
ORDER BY mira_szerv.szerv_nev ASC";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if($adatom['szam']=='1'){
   if(!is_array($eredmeny_keres))$eredmeny_keres=array();
    $eredmeny_keres[]=$adatom['szerv_nev'];
  }
 }
 return $eredmeny_keres; 
}

function keres_user_projekt_jovhagyo_e($user_ad){
$eredmeny_keres='';
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);

$sql="SELECT 
projekt.projekt_nev
FROM `projekt_jovahagyo`
inner join projekt ON projekt.projekt_id = projekt_jovahagyo.projekt_id
WHERE projekt_jovahagyo.user_ad='".$user_ad."'
";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
   if(!is_array($eredmeny_keres))$eredmeny_keres=array();
    $eredmeny_keres[]=$adatom['projekt_nev'];
 }
 return $eredmeny_keres;  
}


function keres_user_van_nyitott_ho($user_ad){
$eredmeny_keres="";
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
/*
 $sql="SELECT rogzit.rogzit_ho
,rogzit_ho.ellenorzesre_lezarva
,rogzit_ho.ellenorzesre_ok
 FROM `rogzit` 
 left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id
 left join rogzit_ho ON rogzit_ho.user_ad='".$user_ad."' 
	and rogzit_ho.rogzit_ho = rogzit.rogzit_ho	
 where rogzit.user_ad='".$user_ad."'
 and
 (
  (rogzit.tavollet='1')or
  (
   (rogzit.tavollet='0')and
   (rogzit_sor.rogzit_id is not null)and
   (
    (rogzit_sor.rogzit_ora!='0')or
    (rogzit_sor.rogzit_perc!='0')
   )
  )
 )
 and
 (
 (rogzit_ho.rogzit_ho_id is NULL)
 or
 (
  (rogzit_ho.rogzit_ho_id is not NULL)
  and
  (
  (rogzit_ho.ellenorzesre_lezarva='0')or
  (rogzit_ho.ellenorzesre_ok='0')
  )
 )
 )
 group by rogzit.rogzit_ho
 order by rogzit.rogzit_ho ASC
 ";
 */
  $sql="SELECT rogzit.rogzit_ho
,rogzit_ho.ellenorzesre_lezarva
,rogzit_ho.ellenorzesre_ok
 FROM `rogzit` 
 
 left join rogzit_ho ON rogzit_ho.user_ad='".$user_ad."' 
	and rogzit_ho.rogzit_ho = rogzit.rogzit_ho	
 where rogzit.user_ad='".$user_ad."'

 and
 (
 (rogzit_ho.rogzit_ho_id is NULL)
 or
 (
  (rogzit_ho.rogzit_ho_id is not NULL)
  and
  (
  (rogzit_ho.ellenorzesre_lezarva='0')or
  (rogzit_ho.ellenorzesre_ok='0')
  )
 )
 )
 group by rogzit.rogzit_ho
 order by rogzit.rogzit_ho ASC
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}


function keres_fellettesjovahagyo_user($user_ad,$keress_user_nev,$csakvan){
$eredmeny_keres="";
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$keress_user_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_user_nev));
$csakvan=mysqli_real_escape_string($GLOBALS['mysqli'],$csakvan);

//Talszám - eleje
if((isset($_POST['user_felettesjovahagyo_keres_talszam']))and($_POST['user_felettesjovahagyo_keres_talszam']!="")){
 $user_felettesjovahagyo_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['user_felettesjovahagyo_keres_talszam']);
 
 if($_POST['user_felettesjovahagyo_keres_talszam']<999999){//Excel export miatt
 if($GLOBALS['mira']['user_jog']['user_felettesjovahagyo_keres_talszam']!=$user_felettesjovahagyo_keres_talszam){
   $tmp_mod[0]['user_felettesjovahagyo_keres_talszam']=$user_felettesjovahagyo_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
  //be is kell állítani.
 $GLOBALS['mira']['user_jog']['user_felettesjovahagyo_keres_talszam']=$user_felettesjovahagyo_keres_talszam;
 }
 
 }else{
 $user_felettesjovahagyo_keres_talszam=$GLOBALS['mira']['user_jog']['user_felettesjovahagyo_keres_talszam'];
}
//Talszám - vége

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$limit_tol=$_POST['oldalholvagyok'];

$limit_ig=$user_felettesjovahagyo_keres_talszam;

//Talszám - eleje
$sql1="SELECT count(mira_user.user_ad) as tal
 FROM `mira_user` ";
 if($csakvan==1)
  $sql1.=" inner join mira_user_felettes_jovahagyo ON mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo = mira_user.user_ad 
  and mira_user_felettes_jovahagyo.user_ad='".$user_ad."'";
 
 $sql1.=" where ";
 //$sql1.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 $sql1.="mira_user.user_inaktiv='0' ";
 
 if($keress_user_nev!="")//Csak ha rákerestek bármire
  $sql1.=" and mira_user.user_nev like '".$keress_user_nev."%'";
//Talszám - vége

//Teljes keresés
$sql="SELECT mira_user.user_ad,mira_user.user_nev
 FROM `mira_user` ";
 
 if($csakvan==1)
  $sql.=" inner join mira_user_felettes_jovahagyo ON mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo = mira_user.user_ad 
  and mira_user_felettes_jovahagyo.user_ad='".$user_ad."'";
 
 $sql.=" where ";
 //$sql.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 $sql.="mira_user.user_inaktiv='0' ";
 //$sql.=" and mira_user.user_ad !='".$_SESSION[$GLOBALS['sessionname']]['login_ad']."' ";
 
 if($keress_user_nev!="")//Csak ha rákerestek bármire
  $sql.=" and mira_user.user_nev like '".$keress_user_nev."%'";

 $sql.=" order by mira_user.user_nev ASC
 limit ".$limit_tol.", ".$limit_ig;
 
 //print $sql."<br>";exit;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

//Adott userhez hány felettes jóváhagyó van hozzárendelve! Adat is
function keres_felettesjovahagyo_hozzarend_adat($user_ad){
 $eredmeny_keres="";
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 $sql="SELECT mira_user.user_ad
 FROM `mira_user_felettes_jovahagyo` 
 left join mira_user ON mira_user.user_ad = mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo
 where
 mira_user_felettes_jovahagyo.user_ad='".$user_ad."' and 
 mira_user.user_inaktiv='0'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=1;
 }
 return $eredmeny_keres;
}


function keres_admin_userhez_stat_szerv($user_ad,$keress_szerv_nev,$csakvan){
$eredmeny_keres="";
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$keress_szerv_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_szerv_nev));
$csakvan=mysqli_real_escape_string($GLOBALS['mysqli'],$csakvan);

//Teljes keresés
$sql="SELECT mira_szerv.szerv_id,mira_szerv.szerv_nev,mira_szerv.szerv_inaktiv
 FROM `mira_szerv` ";
 
 if($csakvan==1)
  $sql.=" inner join mira_user_stat ON mira_user_stat.szerv_id = mira_szerv.szerv_id 
  and mira_user_stat.user_ad='".$user_ad."'";
 
 $sql.=" ";
 
 if($keress_szerv_nev!="")//Csak ha rákerestek bármire
  $sql.=" where mira_szerv.szerv_nev like '".$keress_szerv_nev."%'";//and

 $sql.=" order by mira_szerv.szerv_nev ASC";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_userhez_stat_projekt($user_ad,$keress_projekt_nev,$csakvan){
$eredmeny_keres="";
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$keress_projekt_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_projekt_nev));
$csakvan=mysqli_real_escape_string($GLOBALS['mysqli'],$csakvan);

//Talszám - eleje
if((isset($_POST['user_stat_projekthozza_keres_talszam']))and($_POST['user_stat_projekthozza_keres_talszam']!="")){
 $user_stat_projekthozza_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['user_stat_projekthozza_keres_talszam']);
 
 if($_POST['user_stat_projekthozza_keres_talszam']<999999){//Excel export miatt
 if($GLOBALS['mira']['user_jog']['user_stat_projekthozza_keres_talszam']!=$user_stat_projekthozza_keres_talszam){
   $tmp_mod[0]['user_stat_projekthozza_keres_talszam']=$user_stat_projekthozza_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
  //be is kell állítani.
 $GLOBALS['mira']['user_jog']['user_stat_projekthozza_keres_talszam']=$user_stat_projekthozza_keres_talszam;
 }
 
 }else{
 $user_stat_projekthozza_keres_talszam=$GLOBALS['mira']['user_jog']['user_stat_projekthozza_keres_talszam'];
}
//Talszám - vége

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$limit_tol=$_POST['oldalholvagyok'];

$limit_ig=$user_stat_projekthozza_keres_talszam;

//Talszám - eleje
$sql1="SELECT count(projekt.projekt_id) as tal
 FROM `projekt` ";
 if($csakvan==1)
  $sql1.=" inner join mira_user_stat_proj  ON mira_user_stat_proj.projekt_id = projekt.projekt_id 
  and mira_user_stat_proj.user_ad='".$user_ad."'";
 
 $sql1.="  ";//where
 //$sql1.=" projekt.projekt_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' ";//and projekt.projekt_inaktiv='0'
 
 if($keress_projekt_nev!="")//Csak ha rákerestek bármire
  $sql1.=" where projekt.projekt_nev like '".$keress_projekt_nev."%'";//and
//Talszám - vége

//Teljes keresés
$sql="SELECT projekt.projekt_id,projekt.projekt_nev,projekt.projekt_inaktiv
 FROM `projekt` ";
 
 if($csakvan==1)
  $sql.=" inner join mira_user_stat_proj  ON mira_user_stat_proj .projekt_id = projekt.projekt_id 
  and mira_user_stat_proj.user_ad='".$user_ad."'";
 
 $sql.=" ";//where
 //$sql.=" projekt.projekt_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' ";//and projekt.projekt_inaktiv='0'
 
 if($keress_projekt_nev!="")//Csak ha rákerestek bármire
  $sql.=" where projekt.projekt_nev like '".$keress_projekt_nev."%'";//and

 $sql.=" order by projekt.projekt_nev ASC
 limit ".$limit_tol.", ".$limit_ig;
 
 //print $sql."<br>";exit;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_user_stat_projekt_user_hozzarend_adat($user_ad){
 $eredmeny_keres="";
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 $sql="SELECT mira_user_stat_proj.projekt_id
 FROM `mira_user_stat_proj` 
 where
 mira_user_stat_proj.user_ad='".$user_ad."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=1;
 }
 return $eredmeny_keres;
}

//Adott userhez hány szervezeti statisztika jog van hozzárendelve! Adat is
function keres_userstat_szervjogspan_user_hozzarend_adat($user_ad){
 $eredmeny_keres="";
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 $sql="SELECT mira_user_stat.szerv_id
 FROM `mira_user_stat` 
 where
 mira_user_stat.user_ad='".$user_ad."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerv_id']]=1;
 }
 return $eredmeny_keres;
}

//Adott userhez hány szervezeti jóváhagyás van hozzárendelve! Adat is
function keres_userjovahagyas_user_hozzarend_adat($user_ad){
 $eredmeny_keres="";
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 $sql="SELECT mira_szerv_jovahagyo.szerv_id
 FROM `mira_szerv_jovahagyo` 
 where
 mira_szerv_jovahagyo.user_ad='".$user_ad."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerv_id']]=1;
 }
 return $eredmeny_keres;
}

function keres_szerv_akt_nevlike($szerv_nev){
 $eredmeny_keres="";
 $szerv_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_nev));
 // and `szerv_tagv` ='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT szerv_id 
 FROM `mira_szerv`
 where `szerv_nev` like '".$szerv_nev."%' 

 and `szerv_inaktiv`='0'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerv_id']]=1;
 }
 return $eredmeny_keres;
}

function keres_user_utolso_szerv_jovhagyo_e_egyszervnel($szerv_id){
 $eredmeny_keres='';
 $szerv_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_id);
 //print $sql."<br>";
 //mira_szerv.szerv_id,
  $sql="SELECT 
count(mira_user.user_ad) as szam,
mira_user.user_nev,
mira_szerv.szerv_nev
FROM `mira_szerv_jovahagyo`
inner join mira_user ON
	mira_user.user_ad=mira_szerv_jovahagyo.user_ad
	and mira_user.user_inaktiv='0'
left join mira_szerv ON mira_szerv.szerv_id=mira_szerv_jovahagyo.szerv_id
WHERE
mira_szerv_jovahagyo.szerv_id='".$szerv_id."'";
//echo $sql;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if($adatom['szam']=='1'){
   if(!is_array($eredmeny_keres))$eredmeny_keres=array();
    $eredmeny_keres[]=$adatom;
  }
 }
 return $eredmeny_keres; 
}

function keres_admin_userhezprojektjovahagyo($user_ad,$keress_projekt_nev,$csakvan){
$eredmeny_keres="";
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$keress_projekt_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_projekt_nev));
$csakvan=mysqli_real_escape_string($GLOBALS['mysqli'],$csakvan);

//Talszám - eleje
if((isset($_POST['user_projektjovahagyohozza_keres_talszam']))and($_POST['user_projektjovahagyohozza_keres_talszam']!="")){
 $user_projektjovahagyohozza_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['user_projektjovahagyohozza_keres_talszam']);
 
 if($_POST['user_projektjovahagyohozza_keres_talszam']<999999){//Excel export miatt
 if($GLOBALS['mira']['user_jog']['user_projektjovahagyohozza_keres_talszam']!=$user_projektjovahagyohozza_keres_talszam){
   $tmp_mod[0]['user_projektjovahagyohozza_keres_talszam']=$user_projektjovahagyohozza_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
  //be is kell állítani.
 $GLOBALS['mira']['user_jog']['user_projektjovahagyohozza_keres_talszam']=$user_projektjovahagyohozza_keres_talszam;
 }
 
 }else{
 $user_projektjovahagyohozza_keres_talszam=$GLOBALS['mira']['user_jog']['user_projektjovahagyohozza_keres_talszam'];
}
//Talszám - vége

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$limit_tol=$_POST['oldalholvagyok'];

$limit_ig=$user_projektjovahagyohozza_keres_talszam;

//Talszám - eleje
$sql1="SELECT count(projekt.projekt_id) as tal
 FROM `projekt` ";
 if($csakvan==1)
  $sql1.=" inner join projekt_jovahagyo ON projekt_jovahagyo.projekt_id = projekt.projekt_id 
  and projekt_jovahagyo.user_ad='".$user_ad."'";
 
 //$sql1.=" where ";
 //$sql1.=" projekt.projekt_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 //$sql1.="projekt.projekt_inaktiv='0' ";
 
 if($keress_projekt_nev!="")//Csak ha rákerestek bármire
  $sql1.=" where projekt.projekt_nev like '".$keress_projekt_nev."%'";//and
//Talszám - vége

//Teljes keresés
$sql="SELECT projekt.projekt_id,projekt.projekt_nev,projekt.projekt_inaktiv
 FROM `projekt` ";
 
 if($csakvan==1)
  $sql.=" inner join projekt_jovahagyo ON projekt_jovahagyo.projekt_id = projekt.projekt_id 
  and projekt_jovahagyo.user_ad='".$user_ad."'";
 
 //$sql.=" where ";
 //$sql.=" projekt.projekt_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'";
//and projekt.projekt_inaktiv='0'
 
 if($keress_projekt_nev!="")//Csak ha rákerestek bármire
  $sql.=" where projekt.projekt_nev like '".$keress_projekt_nev."%'";//and

 $sql.=" order by projekt.projekt_nev ASC
 limit ".$limit_tol.", ".$limit_ig;
 
 //print $sql."<br>";exit;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

//Adott userhez hány projekt van hozzárendelve! Adat is
function keres_userprojekt_user_hozzarend_adat($user_ad){
 $eredmeny_keres="";
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 $sql="SELECT projekt_user.projekt_id
 FROM `projekt_user` 
 where
 projekt_user.user_ad='".$user_ad."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=1;
 }
 return $eredmeny_keres;
}

//Adott userhez hány projekt jóváhagyás van hozzárendelve! Adat is
function keres_userprojektjovahagyo_user_hozzarend_adat($user_ad){
 $eredmeny_keres="";
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 $sql="SELECT projekt_jovahagyo.projekt_id
 FROM `projekt_jovahagyo` 
 where
 projekt_jovahagyo.user_ad='".$user_ad."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=1;
 }
 return $eredmeny_keres;
}

function keres_szerv_akt_nevlike_inaktivis($szerv_nev){
 $eredmeny_keres="";
 $szerv_nev=mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_nev);
 // and `szerv_tagv` ='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT szerv_id 
 FROM `mira_szerv`
 where `szerv_nev` like '".$szerv_nev."%'

 ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerv_id']]=1;
 }
 return $eredmeny_keres;
}

function keres_admin_tarskat_mod($tagv_kod){
$eredmeny_keres="";
$tagv_kod=mysqli_real_escape_string($GLOBALS['mysqli'],$tagv_kod);

$sql="SELECT 
szerz_tagvkat.szerz_tagvkat_id,
szerz_tagvkat.szerz_tagvkat_akt,
szerz_tagvkat.szerz_tagvkat_kat,
szerz_tagvkat.szerz_tagvkat_date_kezd,
szerz_tagvkat.szerz_tagvkat_date_veg
 FROM `szerz_tagvkat` 
 where szerz_tagvkat.tagv_kod = '".$tagv_kod."'
 order by szerz_tagvkat.szerz_tagvkat_id asc
";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_kpiosszekap_uj_where($sorsz,$where,$join1){

 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='tagv_kat'){
   if($where!="") $where.=" and ";
   if($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]=='123'){
	$where.=" (";
	$where.="(szerz_tagvkat.szerz_tagvkat_kat = '1')or";
	$where.="(szerz_tagvkat.szerz_tagvkat_kat = '2')or";
	$where.="(szerz_tagvkat.szerz_tagvkat_kat = '3')";
	$where.=") ";
   }else{
    $where.=" szerz_tagvkat.szerz_tagvkat_kat = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
   }
   
   if($GLOBALS['kpi_sql1_join']['mira_tagv_kod']=='0')
    $join1.=" left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod";
   if($GLOBALS['kpi_sql1_join']['szerz_tagvkat']=='0')
    $join1.=" left join szerz_tagvkat ON szerz_tagvkat.tagv_kod = mira_tagv_kod.tagv_kod and szerz_tagvkat.szerz_tagvkat_akt = '1' ";
   
   $GLOBALS['kpi_sql1_join']['mira_tagv_kod']='1';
   $GLOBALS['kpi_sql1_join']['szerz_tagvkat']='1';
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='szolg_csop'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_csop_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='kpi_szolg_kod'){
   if($where!="") $where.=" and ";
   //$where.=" kpi_tipus.kpi_szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
   $where.="
    EXISTS (
      SELECT 1 
      FROM szerz_kpi sub_sk
      INNER JOIN szerz_kpi_osszekapcs sub_sko ON sub_sko.szerz_kpi_id = sub_sk.szerz_kpi_id
      INNER JOIN kpi_tipus sub_kt ON sub_kt.kpi_tipus_id = sub_sko.kpi_tipus_id
      WHERE sub_sk.szerz_id = szerz_tetel_adat.szerz_id
        AND sub_sk.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
        AND sub_sk.szerz_tetel_modszam_kezi = szerz_tetel_adat.szerz_tetel_modszam_kezi
        AND sub_kt.kpi_szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."' 
  )
   ";
   
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  
  //Szolgáltatás megszünés dátuma - eleje
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='szolg_erv'){
   if($where!="") $where.=" and ";
   //$where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  
    //AB: szerz_tetel.szerz_tetel_vege_date (Szolgáltatás megszünése - vége dátum)
	$ab='szerz_tetel.szerz_tetel_vege_date';
	//AC: szerz_tetel.szerz_tetel_szolg_origveg_date (Szerződés időtartam eredeti (határozott esetén))
	$ac='szerz_tetel.szerz_tetel_szolg_origveg_date';
	//AD: szerz_tetel_adat.szerz_tetel_szolg_aktveg_date (Szerződés időtartam aktuális (határozott esetén))
	$ad='szerz_tetel_adat.szerz_tetel_szolg_aktveg_date';
	$ma=date('Y-m-d');
   if($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]=='0'){
   //Nincs vagy Jövőbeli
    //1: Ha mind a három mező üres
    //2: Ha csak AC van kitöltve, és jövőbéli
    //3: Ha AB üres AC és AD ki van töltve, akkor csak AD az érdekes! Ha ez jövőbéli
    //4: Ha mind a három ki van töltve, akkor AB és AD közül a kisebb dönti el: Ha AB kisebb, és ez jövőbéli
    //5: Ha mind a három ki van töltve, akkor AB és AD közül a kisebb dönti el: Ha AD kisebb, és ez jövőbéli
    //6: AB és AC ki van töltve és AD pedig üres, akkor AB és AC közül a kisebb dönti el: Ha AB kisebb, és ez jövőbéli
    //7: AB és AC ki van töltve és AD pedig üres, akkor AB és AC közül a kisebb dönti el: Ha AC kisebb, és ez ez jövőbéli
	$where= " (
        /* 1: Ha mind a három mező üres */
        (".$ab." IS NULL AND ".$ac." IS NULL AND ".$ad." IS NULL)
        
        OR 
        
        /* 2: Ha csak AC van kitöltve, és jövőbéli */
        (".$ab." IS NULL AND ".$ad." IS NULL AND ".$ac." IS NOT NULL AND ".$ac." > '".$ma."')
        
        OR 
        
        /* 3: Ha AB üres AC és AD ki van töltve, akkor csak AD az érdekes! Ha ez jövőbéli */
        (".$ab." IS NULL AND ".$ac." IS NOT NULL AND ".$ad." IS NOT NULL AND ".$ad." > '".$ma."')
        
        OR 
        
        /* 4 és 5 összevonva: Ha mind a három ki van töltve, akkor AB és AD közül a kisebb dönti el, és ez jövőbéli */
        (".$ab." IS NOT NULL AND ".$ac." IS NOT NULL AND ".$ad." IS NOT NULL AND LEAST(".$ab.", ".$ad.") > '".$ma."')
        
        OR 
        
        /* 6 és 7 összevonva: AB és AC ki van töltve és AD pedig üres, akkor AB és AC közül a kisebb dönti el, és ez jövőbéli */
        (".$ab." IS NOT NULL AND ".$ac." IS NOT NULL AND ".$ad." IS NULL AND LEAST(".$ab.", ".$ac.") > '".$ma."')
    ) ";
	//1
	 $where.="";
   }else{
   //Múltbeli
	//1: Ha csak AC van kitöltve és ez mai nap vagy korábbi
	//2: Ha mind a három ki van töltve, akkor AB és AD közül a kisebb dönti el: Ha AB kisebb, és ez mai nap vagy korábbi
    //3: Ha mind a három ki van töltve, akkor AB és AD közül a kisebb dönti el: Ha AD kisebb, és ez mai nap vagy korábbi
	//4: AB és AC ki van töltve és AD pedig üres, akkor AB és AC közül a kisebb dönti el: Ha AB kisebb, és ez mai nap vagy korábbi
    //5: AB és AC ki van töltve és AD pedig üres, akkor AB és AC közül a kisebb dönti el: Ha AC kisebb, és ez mai nap vagy korábbi
	
	$where = " (
        /* 1: Ha csak AC van kitöltve és ez mai nap vagy korábbi */
        (".$ab." IS NULL AND ".$ad." IS NULL AND ".$ac." IS NOT NULL AND ".$ac." <= '".$ma."')
        
        OR 
        
        /* 2 és 3: Ha mind a három ki van töltve, akkor AB és AD közül a kisebb dönti el, és ez mai nap vagy korábbi */
        (".$ab." IS NOT NULL AND ".$ac." IS NOT NULL AND ".$ad." IS NOT NULL AND LEAST(".$ab.", ".$ad.") <= '".$ma."')
        
        OR 
        
        /* 4 és 5: AB és AC ki van töltve és AD pedig üres, akkor AB és AC közül a kisebb dönti el, és ez mai nap vagy korábbi */
        (".$ab." IS NOT NULL AND ".$ac." IS NOT NULL AND ".$ad." IS NULL AND LEAST(".$ab.", ".$ac.") <= '".$ma."')
    ) ";
   }
  //Szolgáltatás megszünés dátuma - vége
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='integ_erintett'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_integ_erintett = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mire'.$sorsz]=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['mit'.$sorsz]."'";
  }
 }
$tomb_tmp=array();
$tomb_tmp['where']=$where;
$tomb_tmp['join1']=$join1;
return $tomb_tmp;
}
	
function keres_admin_kpiosszekap_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_kpiosszekaplist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_kpiosszekaplist_keres_order','admin_kpiosszekaplist_keres_order_mod');
//Rendezés - vége

$where="";
$join1="";

//kpitipus_allapot KPI típus állapot
 $join_c_kpi=$join_c_kpi2='';
 
$GLOBALS['kpi_sql1_join']['mira_tagv_kod']="0";
$GLOBALS['kpi_sql1_join']['szerz_tagvkat']="0";
$GLOBALS['kpi_sql1_join']['kpi_osszekapcs']="0";
$GLOBALS['kpi_sql1_join']['kpi_tipus']="0";

//if($where!="") $where.=" and ";
$where.=" szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='0' ";

//akt
 if(
 (!isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['akt']))
 or
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['akt']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['akt']=="1"))
 ){
  if($where!="") $where.=" and ";
    $where.=" szerz_tetel_adat.szerz_tetel_akt = '1' ";
 }
 
//KER1 - eleje
$tomb_tmp=keres_admin_kpiosszekap_uj_where('1',$where,$join1);
$where=$tomb_tmp['where'];
$join1=$tomb_tmp['join1'];
//KER1 - vége

//KER2 - eleje
$tomb_tmp=keres_admin_kpiosszekap_uj_where('2',$where,$join1);
$where=$tomb_tmp['where'];
$join1=$tomb_tmp['join1'];
//KER2 - vége

//KER3 - eleje
$tomb_tmp=keres_admin_kpiosszekap_uj_where('3',$where,$join1);
$where=$tomb_tmp['where'];
$join1=$tomb_tmp['join1'];
//KER3 - vége

//KER4 - eleje
$tomb_tmp=keres_admin_kpiosszekap_uj_where('4',$where,$join1);
$where=$tomb_tmp['where'];
$join1=$tomb_tmp['join1'];
//KER4 - vége

//KER5 - eleje
$tomb_tmp=keres_admin_kpiosszekap_uj_where('5',$where,$join1);
$where=$tomb_tmp['where'];
$join1=$tomb_tmp['join1'];
//KER5 - vége


//szerz_tetel_id
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_id']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel.szerz_tetel_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_id']."'";
 }

//szerzmodszam
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerzmodszam']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerzmodszam']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel_adat.szerz_tetel_modszam_kezi = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerzmodszam']."'";
 }


 
 //Csk ha van kpi
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpitipus_allapot']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpitipus_allapot']=="1")){
  
  if($GLOBALS['kpi_sql1_join']['kpi_osszekapcs']==0){
   $join_c_kpi=" left join szerz_kpi ON 
		szerz_kpi.szerz_id = szerz_tetel_adat.szerz_id
	and szerz_kpi.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
	and szerz_kpi.szerz_tetel_modszam_kezi = szerz_tetel_adat.szerz_tetel_modszam_kezi ";
  $join_c_kpi2=' left join szerz_kpi_osszekapcs ON szerz_kpi_osszekapcs.szerz_kpi_id = szerz_kpi.szerz_kpi_id ';
  }
  
  if($where!="") $where.=" and ";
  $where.=" szerz_kpi_osszekapcs.szerz_kpi_id is not null ";
 }elseif((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpitipus_allapot']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpitipus_allapot']=="0")){
  //Ha nincs kpi
  
  if($GLOBALS['kpi_sql1_join']['kpi_osszekapcs']==0){
  $join_c_kpi=" left join szerz_kpi ON 
		szerz_kpi.szerz_id = szerz_tetel_adat.szerz_id
	and szerz_kpi.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
	and szerz_kpi.szerz_tetel_modszam_kezi = szerz_tetel_adat.szerz_tetel_modszam_kezi ";
  $join_c_kpi2=' left join szerz_kpi_osszekapcs ON szerz_kpi_osszekapcs.szerz_kpi_id = szerz_kpi.szerz_kpi_id ';
  }
  
  if($where!="") $where.=" and ";
  $where.=" szerz_kpi_osszekapcs.szerz_kpi_id is null ";
 }

//kpi_nemrelevans
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_nemrelevans']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_nemrelevans']!="all")){
  
  if($GLOBALS['kpi_sql1_join']['kpi_osszekapcs']==0){
  $join_c_kpi=" left join szerz_kpi ON 
		szerz_kpi.szerz_id = szerz_tetel_adat.szerz_id
	and szerz_kpi.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
	and szerz_kpi.szerz_tetel_modszam_kezi = szerz_tetel_adat.szerz_tetel_modszam_kezi ";
  }
  
  if($where!="") $where.=" and ";
  if($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_nemrelevans']=='0')
   $where.=" szerz_kpi.kpi_nemrelevans is null ";
  else
	$where.=" szerz_kpi.kpi_nemrelevans = '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_nemrelevans']."'";
 }

//kpi_tipus
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_tipus']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_tipus']!="")and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_tipus']!="all")){
   if($where!="") $where.=" and ";
   
   
   $tomb_k=explode(',',$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['kpi_tipus']);
   if(is_array($tomb_k)){
   $where_t='';
   foreach($tomb_k as $kpi_tipus_kpi){
   if($kpi_tipus_kpi!=''){
     if($where_t!='')$where_t.='or';
	 $where_t.="(kpi_tipus.kpi_tipus_kpi = '".$kpi_tipus_kpi."')";
   }
   }
   $where.="(".$where_t.")";
   
   /*
   if($GLOBALS['kpi_sql1_join']['kpi_osszekapcs']=='0')
    $join1.=" left join kpi_osszekapcs ON kpi_osszekapcs.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id";
   if($GLOBALS['kpi_sql1_join']['kpi_tipus']=='0')
    $join1.=" left join kpi_tipus ON kpi_tipus.kpi_tipus_id = kpi_osszekapcs.kpi_tipus_id ";
	*/

  if($GLOBALS['kpi_sql1_join']['kpi_osszekapcs']==0){
  $join_c_kpi='';
  $join_c_kpi2='';
  $join1.=" left join szerz_kpi ON 
		szerz_kpi.szerz_id = szerz_tetel_adat.szerz_id
	and szerz_kpi.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
	and szerz_kpi.szerz_tetel_modszam_kezi = szerz_tetel_adat.szerz_tetel_modszam_kezi ";
  $join1.=' left join szerz_kpi_osszekapcs ON szerz_kpi_osszekapcs.szerz_kpi_id = szerz_kpi.szerz_kpi_id ';
  
  $join1.=" left join kpi_tipus ON kpi_tipus.kpi_tipus_id = szerz_kpi_osszekapcs.kpi_tipus_id ";
   
   $GLOBALS['kpi_sql1_join']['kpi_osszekapcs']='1';
   $GLOBALS['kpi_sql1_join']['kpi_tipus']='1';
   }
   
   }
 }
//Ellenőrizendő
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['ellenorizendo']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['ellenorizendo']=="1")){
  if($where!="") $where.=" and ";
  $where.=" szerz_kpi.kpi_osszekapcs_ck = '1' ";
  $join_c_kpi.=" left join szerz_kpi ON 
		szerz_kpi.szerz_id = szerz_tetel_adat.szerz_id
	and szerz_kpi.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
	and szerz_kpi.szerz_tetel_modszam_kezi = szerz_tetel_adat.szerz_tetel_modszam_kezi ";
 }

//szerz_tetel_szerz_date_hatalybelep_tol
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_tol']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_tol']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz.szerz_date_hatalybelep >= '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_tol']."'";
 }

//szerz_tetel_szerz_date_hatalybelep_ig
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_ig']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_ig']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz.szerz_date_hatalybelep <= '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_date_hatalybelep_ig']."'";
 }

//szerz_tetel_szolg_kezd_date_tol 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_tol']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_tol']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel.szerz_tetel_szolg_kezd_date >= '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_tol']."'";
 }
 
//szerz_tetel_szolg_kezd_date_ig
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_ig']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_ig']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel.szerz_tetel_szolg_kezd_date <= '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_kezd_date_ig']."'";
 }
 
//szerz_tetel_szerz_tetel_alair_date_tol
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_tol']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_tol']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel_adat.szerz_tetel_alair_date >= '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_tol']."'";
 }

//szerz_tetel_szerz_tetel_alair_date_ig
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_ig']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_ig']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel_adat.szerz_tetel_alair_date <= '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szerz_tetel_alair_date_ig']."'";
 }
 
//szerz_tetel_szolg_mod_date_tol
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_tol']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_tol']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel_adat.szerz_tetel_szolg_mod_date <= '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_tol']."'";
 }

//szerz_tetel_szolg_mod_date_ig
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_ig']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_ig']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel_adat.szerz_tetel_szolg_mod_date <= '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiosszekaplist_keres']['szerz_tetel_szolg_mod_date_ig']."'";
 }
 
if($where!='')$where=' where '.$where;

 $sql1="SELECT count(tal1) as tal FROM(";
 $sql1.="SELECT szerz_tetel.szerz_tetel_id as tal1 FROM `szerz_tetel` ";
 //$sql1="SELECT count(szerz_tetel.szerz_tetel_id) as tal FROM `szerz_tetel` ";
 $sql1.="
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id 
 ".$join1.$join_c_kpi.$join_c_kpi2;
 
 if($where!="") 
  $sql1.="".$where;//where

 $group_kozos_tal=" GROUP BY szerz_tetel_adat.szerz_id, szerz_tetel_adat.szerz_csop_id, szerz_tetel_adat.szerz_tetel_modszam_kezi ";//GROUP_CONCAT miatt kell ez is
 $group_kozos=" GROUP BY szerz_tetel_adat.szerz_id, szerz_tetel_adat.szerz_csop_id, szerz_tetel_adat.szerz_tetel_modszam_kezi ";//GROUP_CONCAT miatt kell ez is
 $sql1.=$group_kozos_tal;
 $sql1.=") t";
 
 //,szerz_tetel.*
 //,szerz.*
 $sql="SELECT 
 
   GROUP_CONCAT(
		DISTINCT CONCAT_WS('-', szerz_tetel.szerz_tetel_id, szerz_tetel_adat.szerz_tetel_adat_id,szerz_tetel_adat.szerz_tetel_modszam)
        ORDER BY szerz_tetel.szerz_tetel_id asc,szerz_tetel_adat.szerz_tetel_adat_id asc
        SEPARATOR ','
    ) AS szerz_tetel_id_tomeges
 
 
 ,szerz_tetel_adat.szerz_csop_id
 ,szerz_tetel_adat.szerz_tetel_modszam_kezi
 ,szerz.szerz_id
 ,szerz.szerz_megj
 ,szerz.tagv_kod
 ,szerz.szerz_date_hatalybelep
 ,szerz_csop.szerz_csop_nev 
 ,szerz_tipus.szerz_tipus_nev 
 ,mira_tagv_kod.tagv_kod_nev 
 ,szerz_tagvkat.szerz_tagvkat_kat

,SUBSTRING_INDEX(GROUP_CONCAT(szerz_tetel.szerz_tetel_vege_date ORDER BY szerz_tetel_adat.szerz_tetel_adat_id DESC), ',', 1) AS szerz_tetel_vege_date_uj
,SUBSTRING_INDEX(GROUP_CONCAT(szerz_tetel.szerz_tetel_szolg_origveg_date ORDER BY szerz_tetel_adat.szerz_tetel_adat_id DESC), ',', 1) AS szerz_tetel_szolg_origveg_date_uj

,SUBSTRING_INDEX(GROUP_CONCAT(szerz_tetel.szerz_tetel_szolg_kezd_date ORDER BY szerz_tetel_adat.szerz_tetel_adat_id DESC), ',', 1) AS szerz_tetel_szolg_kezd_date_uj

,SUBSTRING_INDEX(GROUP_CONCAT(szerz_tetel_adat.szerz_tetel_alair_date ORDER BY szerz_tetel_adat.szerz_tetel_adat_id DESC), ',', 1) AS szerz_tetel_alair_date_uj
,SUBSTRING_INDEX(GROUP_CONCAT(szerz_tetel_adat.szerz_tetel_szolg_mod_date ORDER BY szerz_tetel_adat.szerz_tetel_adat_id DESC), ',', 1) AS szerz_tetel_szolg_mod_date_uj
,SUBSTRING_INDEX(GROUP_CONCAT(szerz_tetel_adat.szerz_tetel_szolg_aktveg_date ORDER BY szerz_tetel_adat.szerz_tetel_adat_id DESC), ',', 1) AS szerz_tetel_szolg_aktveg_date_uj

 ,GROUP_CONCAT(
        DISTINCT kpi_tipus.kpi_tipus_kpi
        ORDER BY kpi_tipus.kpi_tipus_kpi asc 
        SEPARATOR '; '
    ) AS kpi_tipus_str

 ,szerz_kpi.kpi_nemrelevans
 ,szerz_kpi.kpi_osszekapcs_ck
 ,szerz_kpi.kpi_megj
 ";
 
 if($talszam=='999999'){//excel export
 $sql.="
 ,szerz_elsz_tipus.szerz_elsz_tipus_nev
 ,szerz_naturalia.szerz_naturalia_nev
 ,szerz_usergazda.szerz_usergazda_nev
 ,szerz_usergazda.szerz_usergazda_inaktiv
 ,mira_user_mod.user_nev
 ,szerz_file.szerz_file_id
 ,szerz_file.szerz_file_szerz_vane
 ,szerz_file.szerz_file_szerz_name
 ,szerz_file.szerz_file_ar_vane
 ,szerz_file.szerz_file_ar_name
 ,szerz_tetel.szerz_tetel_id
 ,kpi_tipus.kpi_szolg_kod
 ";
 }
 
 $sql.=" FROM `szerz_tetel` ";
 $sql.="inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
 left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod 
 left join szerz_tagvkat ON szerz_tagvkat.tagv_kod = mira_tagv_kod.tagv_kod and szerz_tagvkat.szerz_tagvkat_akt = '1'
 
 left join szerz_kpi ON 
		szerz_kpi.szerz_id = szerz_tetel_adat.szerz_id
	and szerz_kpi.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
	and szerz_kpi.szerz_tetel_modszam_kezi = szerz_tetel_adat.szerz_tetel_modszam_kezi
 left join szerz_kpi_osszekapcs ON szerz_kpi_osszekapcs.szerz_kpi_id = szerz_kpi.szerz_kpi_id
 left join kpi_tipus ON kpi_tipus.kpi_tipus_id = szerz_kpi_osszekapcs.kpi_tipus_id
 ";
 
 if($talszam=='999999'){//excel export
 $sql.=" 
 left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tetel_adat.szerz_elsz_tipus_id
 left join szerz_naturalia ON szerz_naturalia.szerz_naturalia_id = szerz_tetel_adat.szerz_naturalia_id
 left join szerz_usergazda ON szerz_usergazda.szerz_usergazda_ad = szerz_tetel_adat.szerz_usergazda_ad
 left join mira_user as mira_user_mod ON mira_user_mod.user_ad = szerz_tetel_adat.szerz_tetel_mod_user_ad 
  left join szerz_file ON szerz_file.szerz_id=szerz_tetel_adat.szerz_id 
	and szerz_file.szerz_tetel_modszam_kezi=szerz_tetel_adat.szerz_tetel_modszam_kezi
 ";
 }
 
 if($where!="") 
  $sql.="".$where;//where
 
 //$sql.=" GROUP BY szerz_tetel_adat.szerz_tetel_adat_id ";//GROUP_CONCAT miatt kell ez is
 //$sql.=" GROUP BY szerz_tetel.szerz_tetel_id ";//GROUP_CONCAT miatt kell ez is
 //$sql.=" GROUP BY szerz_tetel_adat.szerz_id, szerz_tetel_adat.szerz_csop_id, szerz_tetel_adat.szerz_tetel_modszam_kezi ";//GROUP_CONCAT miatt kell ez is
 $sql.=$group_kozos;
 
 //szerz_tetel_adat.szerz_csop_id asc,
 //szerz.szerz_keret asc,
 //szerz.szerz_tipus_id asc,
 //szerz.szerz_date_hatalybelep asc
 $sql_order.=",
 szerz_csop.szerz_csop_nev asc,
 szerz_tetel_adat.szerz_tetel_id desc,
 szerz_tetel_adat.szerz_tetel_adat_id desc

 
 ";
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $where."<br>";
 //echo $sql1."<br>";
 //echo $sql."<br>";
 /*
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
 */
 return array_merge(mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql1),MYSQLI_ASSOC),mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql),MYSQLI_ASSOC));

}

function keres_admin_szolgmodadat_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_szolgmodadatlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_szolgmodadatlist_keres_order','admin_szolgmodadatlist_keres_order_mod');
//Rendezés - vége

$where="";
 
//KER1 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='integ_erintett'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_integ_erintett = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='folyamatban'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit1']."'";
  } 
 }
//KER1 - vége

//KER2 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='integ_erintett'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_integ_erintett = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='folyamatban'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire2']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit2']."'";
  } 
 }
//KER2 - vége

//KER3 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='integ_erintett'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_integ_erintett = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='folyamatban'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mire3']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['mit3']."'";
  } 
 }
//KER3 - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['szerz_tetel_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['szerz_tetel_id']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel.szerz_tetel_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['szerz_tetel_id']."'";
 }

 //if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['akt']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['akt']=="1")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='0' ";
 //}

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['sapszam']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['sapszam']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz.szerz_sapszam = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgmodadatlist_keres']['sapszam']."'";
 }

if($where!='')$where=' where '.$where;

 $sql1="SELECT count(szerz_tetel.szerz_tetel_id) as tal FROM `szerz_tetel` ";
 $sql1.="
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
	and szerz_tetel_adat.szerz_tetel_akt = '1' 
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id 
 ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT szerz_tetel.*
 ,szerz_tetel_adat.*
 ,szerz.*
 ,szerz_csop.szerz_csop_nev 
 ,szerz_tipus.szerz_tipus_nev 
 ,mira_tagv_kod.tagv_kod_nev ";
 
 if($talszam=='999999'){//excel export
 $sql.=" ,mira_szolg_kod.szolg_kod_nev
 ,szerz_elsz_tipus.szerz_elsz_tipus_nev
 ,szerz_naturalia.szerz_naturalia_nev
 ,szerz_usergazda.szerz_usergazda_nev
 ,szerz_usergazda.szerz_usergazda_inaktiv
 ,mira_user_mod.user_nev
 ,szerz_file.szerz_file_id
 ,szerz_file.szerz_file_szerz_vane
 ,szerz_file.szerz_file_szerz_name
 ,szerz_file.szerz_file_ar_vane
 ,szerz_file.szerz_file_ar_name
 
    /* === ÚJ OSZLOP: projektek nevei vesszővel elválasztva === */
        ,(SELECT GROUP_CONCAT(DISTINCT p.projekt_nev SEPARATOR ', ')
         FROM szerz_tetel_adat_projekt stp 
         JOIN projekt p ON p.projekt_id = stp.projekt_id
         WHERE stp.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id) AS projekt_nevek
 ";
 }
 
 $sql.=" FROM `szerz_tetel` ";
 $sql.="inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
	and szerz_tetel_adat.szerz_tetel_akt = '1' 
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
 left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod 
 ";
 
 if($talszam=='999999'){//excel export
 $sql.=" left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_tetel_adat.szolg_kod
 left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tetel_adat.szerz_elsz_tipus_id
 left join szerz_naturalia ON szerz_naturalia.szerz_naturalia_id = szerz_tetel_adat.szerz_naturalia_id
 left join szerz_usergazda ON szerz_usergazda.szerz_usergazda_ad = szerz_tetel_adat.szerz_usergazda_ad
 left join mira_user as mira_user_mod ON mira_user_mod.user_ad = szerz_tetel_adat.szerz_tetel_mod_user_ad 
  left join szerz_file ON szerz_file.szerz_id=szerz_tetel_adat.szerz_id 
	and szerz_file.szerz_tetel_modszam_kezi=szerz_tetel_adat.szerz_tetel_modszam_kezi
 ";
 }
 
 if($where!="") 
  $sql.="".$where;//where
 $sql_order.=",szerz_tetel_adat.szerz_tetel_id asc,szerz_tetel_adat.szerz_tetel_modszam asc,szerz_tetel_adat.szerz_tetel_adat_id asc,szerz.szerz_keret asc, szerz.szerz_tipus_id asc, szerz_tetel_adat.szerz_csop_id asc, szerz.szerz_date_hatalybelep asc";
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql."<br>";
 /*
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
 */
 return array_merge(mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql1),MYSQLI_ASSOC),mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql),MYSQLI_ASSOC));
}

function keres_admin_tigadatco_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_tigadatcolist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_tigadatcolist_keres_order','admin_tigadatcolist_keres_order_mod');
//Rendezés - vége

$where="";


//KER1 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='integ_erintett'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_integ_erintett = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit1']."'";
  } 
 }
//KER1 - vége

//KER2 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=='integ_erintett'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_integ_erintett = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire2']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit2']."'";
  } 
 }
//KER2 - vége

//KER3 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=='integ_erintett'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_integ_erintett = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mire3']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['mit3']."'";
  } 
 }
//KER3 - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['szerz_tetel_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['szerz_tetel_id']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel.szerz_tetel_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['szerz_tetel_id']."'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['co']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['co']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel.szerz_tetel_co = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatcolist_keres']['co']."'";
 }

 //if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['akt']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['akt']=="1")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel.szerz_tetel_vege='0' and szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='0' and szerz_tetel_adat.szerz_tetel_akt = '1' ";
 //}

//$ma=date("Y-m-d",time());
//Csak aktív - eleje
/*
if($where!="") $where.=" and ";
$where.="(";
$where.=" (szerz_tetel.szerz_tetel_szolg_origveg_date is null)or";
$where.="(szerz_tetel.szerz_tetel_szolg_origveg_date >= '".$ma."')";
$where.=")and szerz_tetel.szerz_tetel_vege='0' ";
*/
//Csak aktív - eleje

//Csak inaktív - eleje

/*
if($where!="") $where.=" and ";
$where.=" (";
 $where.="(";
 $where.="(szerz_tetel.szerz_tetel_szolg_origveg_date is not null)and";
 $where.="(szerz_tetel.szerz_tetel_szolg_origveg_date < '".$ma."')";
 $where.=")";
$where.="or(szerz_tetel.szerz_tetel_vege='1')";
$where.=") ";
*/
//Csak inaktív - eleje

if($where!='')$where=' where '.$where;

 $sql1="SELECT count(szerz_tetel.szerz_tetel_id) as tal FROM `szerz_tetel` ";
 $sql1.="
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id 
 ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT szerz_tetel.*
 ,szerz_tetel_adat.*
 ,szerz.*
 ,szerz_csop.szerz_csop_nev 
 ,szerz_tipus.szerz_tipus_nev 
 ,mira_tagv_kod.tagv_kod_nev ";
 
 if($talszam=='999999'){//excel export
 $sql.=" ,mira_szolg_kod.szolg_kod_nev
 ,szerz_elsz_tipus.szerz_elsz_tipus_nev
 ,szerz_naturalia.szerz_naturalia_nev
 ,szerz_usergazda.szerz_usergazda_nev
 ,mira_user_mod.user_nev
 ";
 }
 
 $sql.=" FROM `szerz_tetel` ";
 $sql.="inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
 left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id 
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod
 ";
 
 if($talszam=='999999'){//excel export
 $sql.=" left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_tetel_adat.szolg_kod
 left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tetel_adat.szerz_elsz_tipus_id
 left join szerz_naturalia ON szerz_naturalia.szerz_naturalia_id = szerz_tetel_adat.szerz_naturalia_id
 left join szerz_usergazda ON szerz_usergazda.szerz_usergazda_ad = szerz_tetel_adat.szerz_usergazda_ad
 left join mira_user as mira_user_mod ON mira_user_mod.user_ad = szerz_tetel_adat.szerz_tetel_mod_user_ad 
 ";
 }
 
 if($where!="") 
  $sql.="".$where;//where
 $sql_order.=",szerz_tetel_adat.szerz_tetel_id asc,szerz_tetel_adat.szerz_tetel_modszam asc,szerz_tetel_adat.szerz_tetel_adat_id asc,szerz.szerz_keret asc, szerz.szerz_tipus_id asc, szerz_tetel_adat.szerz_csop_id asc, szerz.szerz_date_hatalybelep asc";
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql."<br>";
 /*
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 */
 //return $eredmeny_keres; 
 return array_merge(mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql1),MYSQLI_ASSOC),mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql),MYSQLI_ASSOC));
}

function keres_admin_szolgkapadat_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_szolgkapadatlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_szolgkapadatlist_keres_order','admin_szolgkapadatlist_keres_order_mod');
//Rendezés - vége

$where="";
 
//KER1 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='integ_erintett'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_integ_erintett = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='folyamatban'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit1']."'";
  } 
 }
//KER1 - vége

//KER2 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='integ_erintett'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_integ_erintett = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='folyamatban'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire2']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit2']."'";
  } 
 }
//KER2 - vége

//KER3 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='integ_erintett'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_integ_erintett = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='folyamatban'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mire3']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['mit3']."'";

  } 
 }
//KER3 - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_tetel_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_tetel_id']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel.szerz_tetel_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['szerz_tetel_id']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['akt']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['akt']=="1")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel_adat.szerz_tetel_akt = '1' and szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='0' ";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['sapszam']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['sapszam']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz.szerz_sapszam = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkapadatlist_keres']['sapszam']."'";
 }
 
if($where!='')$where=' where '.$where;

 $sql1="SELECT count(szerz_tetel.szerz_tetel_id) as tal FROM `szerz_tetel` ";
 $sql1.="
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id 
 ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT szerz_tetel.*
 ,szerz_tetel_adat.*
 ,szerz.*
 ,szerz_csop.szerz_csop_nev 
 ,szerz_tipus.szerz_tipus_nev 
 ,mira_tagv_kod.tagv_kod_nev ";
 
 if($talszam=='999999'){//excel export
 $sql.=" ,mira_szolg_kod.szolg_kod_nev
 ,szerz_elsz_tipus.szerz_elsz_tipus_nev
 ,szerz_naturalia.szerz_naturalia_nev
 ,szerz_usergazda.szerz_usergazda_nev
 ,szerz_usergazda.szerz_usergazda_inaktiv
 ,mira_user_mod.user_nev
 ,szerz_file.szerz_file_id
 ,szerz_file.szerz_file_szerz_vane
 ,szerz_file.szerz_file_szerz_name
 ,szerz_file.szerz_file_ar_vane
 ,szerz_file.szerz_file_ar_name
 
    /* === ÚJ OSZLOP: projektek nevei vesszővel elválasztva === */
        ,(SELECT GROUP_CONCAT(DISTINCT p.projekt_nev SEPARATOR ', ')
         FROM szerz_tetel_adat_projekt stp 
         JOIN projekt p ON p.projekt_id = stp.projekt_id
         WHERE stp.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id) AS projekt_nevek
 ";
 }
 
 $sql.=" FROM `szerz_tetel` ";
 $sql.="inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
 left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod
 ";
 
 if($talszam=='999999'){//excel export
 $sql.=" left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_tetel_adat.szolg_kod
 left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tetel_adat.szerz_elsz_tipus_id
 left join szerz_naturalia ON szerz_naturalia.szerz_naturalia_id = szerz_tetel_adat.szerz_naturalia_id
 left join szerz_usergazda ON szerz_usergazda.szerz_usergazda_ad = szerz_tetel_adat.szerz_usergazda_ad
 left join mira_user as mira_user_mod ON mira_user_mod.user_ad = szerz_tetel_adat.szerz_tetel_mod_user_ad 
 left join szerz_file ON szerz_file.szerz_id=szerz_tetel_adat.szerz_id 
	and szerz_file.szerz_tetel_modszam_kezi=szerz_tetel_adat.szerz_tetel_modszam_kezi
 ";
 }
 
 if($where!="") 
  $sql.="".$where;//where
 $sql_order.=",szerz_tetel_adat.szerz_tetel_id asc,szerz_tetel_adat.szerz_tetel_modszam asc,szerz_tetel_adat.szerz_tetel_adat_id asc,szerz.szerz_keret asc, szerz.szerz_tipus_id asc, szerz_tetel_adat.szerz_csop_id asc, szerz.szerz_date_hatalybelep asc";
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 /*
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 */
 //return $eredmeny_keres; 
 return array_merge(mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql1),MYSQLI_ASSOC),mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql),MYSQLI_ASSOC));
}

function keres_admin_elsztipus_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_elsztipuslist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_elsztipuslist_keres_order','admin_elsztipuslist_keres_order_mod');
//Rendezés - vége

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_elsztipuslist_keres']['tipus_nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_elsztipuslist_keres']['tipus_nev']!="")){
  if($where!="") $where.=" and ";
  $where.="szerz_elsz_tipus.szerz_elsz_tipus_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_elsztipuslist_keres']['tipus_nev']."%'";
 }
if($where!='')$where=' where '.$where;

 $sql1="SELECT count(szerz_elsz_tipus.szerz_elsz_tipus_id) as tal FROM `szerz_elsz_tipus` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT *
 FROM `szerz_elsz_tipus` ";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_szerzusergazda_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_szerzusergazdalist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_szerzusergazdalist_keres_order','admin_szerzusergazdalist_keres_order_mod');
//Rendezés - vége

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="szerz_usergazda.szerz_naturalia_nev like '%".$_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['nev']."%'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['ad']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['ad']!="")){
  if($where!="") $where.=" and ";
  $where.="szerz_usergazda.szerz_usergazda_ad like '".$_SESSION[$GLOBALS['sessionname']]['admin_szerzusergazdalist_keres']['ad']."%'";
 }
if($where!='')$where=' where '.$where;

 $sql1="SELECT count(szerz_usergazda.szerz_usergazda_ad) as tal FROM `szerz_usergazda` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT *
 FROM `szerz_usergazda` ";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_kpitipus_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_kpitipuslist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_kpitipuslist_keres_order','admin_kpitipuslist_keres_order_mod');
//Rendezés - vége

/*
if($sql_order==" order by kpi asc "){
 $sql_order="order by kpi_szolg_kod asc, kpi_tipus_sorszam asc ";
}elseif($sql_order==" order by kpi desc "){
 $sql_order=" order by kpi_szolg_kod desc, kpi_tipus_sorszam desc ";
}
*/
//echo '-'.$sql_order.'-';
$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpitipuslist_keres']['kpi_szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpitipuslist_keres']['kpi_szolg_kod']!="")){
  if($where!="") $where.=" and ";
  $where.="kpi_tipus.kpi_szolg_kod like '".$_SESSION[$GLOBALS['sessionname']]['admin_kpitipuslist_keres']['kpi_szolg_kod']."%'";
 }
if($where!='')$where=' where '.$where;

 $sql1="SELECT count(kpi_tipus.kpi_tipus_id) as tal FROM `kpi_tipus` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT *
 FROM `kpi_tipus` ";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_kpiszolgkod_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_kpiszolgkodlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_kpiszolgkodlist_keres_order','admin_kpiszolgkodlist_keres_order_mod');
//Rendezés - vége

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kpiszolgkodlist_keres']['kpi_szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_kpiszolgkodlist_keres']['kpi_szolg_kod']!="")){
  if($where!="") $where.=" and ";
  $where.="kpi_szolg_kod.kpi_szolg_kod like '".$_SESSION[$GLOBALS['sessionname']]['admin_kpiszolgkodlist_keres']['kpi_szolg_kod']."%'";
 }
if($where!='')$where=' where '.$where;

 $sql1="SELECT count(kpi_szolg_kod.kpi_szolg_kod) as tal FROM `kpi_szolg_kod` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT *
 FROM `kpi_szolg_kod` ";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_nattipus_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_nattipuslist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_nattipuslist_keres_order','admin_nattipuslist_keres_order_mod');
//Rendezés - vége

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_nattipuslist_keres']['naturalia_nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_nattipuslist_keres']['naturalia_nev']!="")){
  if($where!="") $where.=" and ";
  $where.="szerz_naturalia.szerz_naturalia_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_nattipuslist_keres']['naturalia_nev']."%'";
 }
if($where!='')$where=' where '.$where;

 $sql1="SELECT count(szerz_naturalia.szerz_naturalia_id) as tal FROM `szerz_naturalia` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT *
 FROM `szerz_naturalia` ";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

//Adott csoporthoz hány szolgáltatáskód van hozzárendelve! Adat is
function keres_szolgcsophoz_szolgkod_user_hozzarend_adat($szerz_csop_id){
 $eredmeny_keres="";
 $szerz_csop_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_csop_id);
 $sql="SELECT szerz_csop_szolgkod.szolg_kod
 FROM `szerz_csop_szolgkod` 
 where
 szerz_csop_szolgkod.szerz_csop_id='".$szerz_csop_id."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szolg_kod']]=1;
 }
 return $eredmeny_keres;
}

function keres_admin_ujszolgkapadat_projekt($szerz_tetel_id,$keress_projekt_nev,$csakvan,$tomb_projek_van){
$eredmeny_keres="";
$szerz_tetel_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_tetel_id);
$keress_projekt_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_projekt_nev));
$csakvan=mysqli_real_escape_string($GLOBALS['mysqli'],$csakvan);

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$talszam=keres_talszam('admin_ujszolgkapadatprojektlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_ujszolgkapadatprojektlist_keres_order','admin_ujszolgkapadatprojektlist_keres_order_mod');
//Rendezés - vége

//Talszám - eleje
if($szerz_tetel_id==''){//Ekkor új van, vagy a teljes kell
$sql1="SELECT count(projekt.projekt_id) as tal
 FROM `projekt` ";
 
 if($keress_projekt_nev!="")//Csak ha rákerestek bármire 
  $sql1.=" where projekt.projekt_nev like '".$keress_projekt_nev."%'";

 if($csakvan=='1'){
  if((is_array($tomb_projek_van))and(sizeof($tomb_projek_van)>0)){
  $sql1_tmp="";
  foreach($tomb_projek_van as $id =>$ert){
   if($sql1_tmp!='')$sql1_tmp.='or';
   $sql1_tmp.="(projekt.projekt_id='".$id."')";
  }
  
  if($sql1_tmp!=''){
   if($keress_projekt_nev!="") $sql1.=' and ';
   else $sql1.=' where ';
   $sql1.='('.$sql1_tmp.')';
  }
  
 }else{//Ekkor nincs találat!
	 $eredmeny_keres=array();
	 $eredmeny_keres[0]['tal']=0;
	 return $eredmeny_keres;
 }
 }
 
}else{//Ekkor a meglévő

}
//Talszám - vége

//Teljes keresés - eleje
if($szerz_tetel_id==''){//Ekkor új van, vagy a teljes kell
 $sql="SELECT projekt.projekt_id,projekt.projekt_nev,projekt.projekt_inaktiv
 FROM `projekt` ";
 
  if($keress_projekt_nev!="")//Csak ha rákerestek bármire 
  $sql.=" where projekt.projekt_nev like '".$keress_projekt_nev."%'";
  
   if($csakvan=='1'){
  if(is_array($tomb_projek_van)){
  $sql_tmp="";
  foreach($tomb_projek_van as $id =>$ert){
   if($sql_tmp!='')$sql_tmp.='or';
   $sql_tmp.="(projekt.projekt_id='".$id."')";
  }
  
  if($sql_tmp!=''){
   if($keress_projekt_nev!="") $sql.=' and ';
   else $sql.=' where ';
   $sql.='('.$sql_tmp.')';
  }
  
 }
 }
 
}else{
	
}
$sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
//Teljes keresés - vége

 //print $sql."<br>";
 //exit;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_szolgcsophoz_szolgkod($szerz_csop_id,$keress_szolg_kod_nev,$keress_szolg_kod,$csakvan){
$eredmeny_keres="";
$szerz_csop_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_csop_id);
$keress_szolg_kod_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_szolg_kod_nev));
$keress_szolg_kod=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_szolg_kod));
$csakvan=mysqli_real_escape_string($GLOBALS['mysqli'],$csakvan);

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$talszam=keres_talszam('admin_szolgcsophozszolgkodlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_szolgcsophozszolgkodlist_keres_order','admin_szolgcsophozszolgkodlist_keres_order_mod');
//Rendezés - vége

//Talszám - eleje
$sql1="SELECT count(mira_szolg_kod.szolg_kod) as tal
 FROM `mira_szolg_kod` ";
 if($csakvan==1)
  $sql1.=" inner join szerz_csop_szolgkod ON szerz_csop_szolgkod.szolg_kod = mira_szolg_kod.szolg_kod 
  and szerz_csop_szolgkod.szerz_csop_id='".$szerz_csop_id."'";
 
 $sql1.=" where ";
 $sql1.="mira_szolg_kod.szolg_kod_inaktiv='0'";
 
 if($keress_szolg_kod_nev!="")//Csak ha rákerestek bármire
  $sql1.=" and mira_szolg_kod.szolg_kod_nev like '".$keress_szolg_kod_nev."%'";
 if($keress_szolg_kod!="")//Csak ha rákerestek bármire
  $sql1.=" and mira_szolg_kod.szolg_kod like '".$keress_szolg_kod."%'";
//Talszám - vége

//Teljes keresés
$sql="SELECT mira_szolg_kod.szolg_kod,mira_szolg_kod.szolg_kod_nev
 FROM `mira_szolg_kod` ";

 if($csakvan==1)
  $sql.=" inner join szerz_csop_szolgkod ON szerz_csop_szolgkod.szolg_kod = mira_szolg_kod.szolg_kod 
  and szerz_csop_szolgkod.szerz_csop_id='".$szerz_csop_id."'";
 
 $sql.=" where ";
 //$sql.=" projekt.projekt_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 $sql.="mira_szolg_kod.szolg_kod_inaktiv='0'";
 
 if($keress_szolg_kod_nev!="")//Csak ha rákerestek bármire
  $sql.=" and mira_szolg_kod.szolg_kod_nev like '".$keress_szolg_kod_nev."%'";
 if($keress_szolg_kod!="")//Csak ha rákerestek bármire
  $sql.=" and mira_szolg_kod.szolg_kod like '".$keress_szolg_kod."%'";

 //$sql.=" order by mira_szolg_kod.szolg_kod_nev ASC
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql."<br>";
 //exit;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_szolgcsop_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_szolgcsoplist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_szolgcsoplist_keres_order','admin_szolgcsoplist_keres_order_mod');
//Rendezés - vége

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgcsoplist_keres']['csop_nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgcsoplist_keres']['csop_nev']!="")){
  if($where!="") $where.=" and ";
  $where.="szerz_csop.szerz_csop_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgcsoplist_keres']['csop_nev']."%'";
 }
if($where!='')$where=' where '.$where;

 $sql1="SELECT count(szerz_csop.szerz_csop_id) as tal FROM `szerz_csop` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT szerz_csop.*
 ,count(szerz_csop_szolgkod.szerz_csop_szolgkod_id) as szolg_kod_szam
 FROM `szerz_csop` 
 left join szerz_csop_szolgkod ON szerz_csop_szolgkod.szerz_csop_id = szerz_csop.szerz_csop_id";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" group by szerz_csop.szerz_csop_id ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_integadat_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_integadatlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_integadatlist_keres_order','admin_integadatlist_keres_order_mod');
//Rendezés - vége

$where="";
 
//KER1 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']))and($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit1']."'";
  } 
 }
//KER1 - vége

//KER2 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire2']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']))and($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire2']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire2']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire2']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire2']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire2']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire2']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire2']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire2']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire2']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire2']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit2']."'";

  } 
 }
//KER2 - vége

//KER3 - eleje
 if(
  (isset($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire3']))and
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']))and($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']!="all"))
 ){
  if($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire3']=='tagv_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire3']=='szerz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire1']=='szerz_keret'){
   if($where!="") $where.=" and ";
   $where.=" szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire3']=='szerz'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire3']=='szolg_kod'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire3']=='uto_kalk'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_utok = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire3']=='elsz_tipus'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_elsz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire3']=='naturalia'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_naturalia_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire3']=='usergazda'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_usergazda_ad = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire3']=='szolg_erv'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel.szerz_tetel_vege = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']."'";
  }elseif($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mire3']=='penznem'){
   if($where!="") $where.=" and ";
   $where.=" szerz_tetel_adat.szerz_tetel_netto_havidij_penznem = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['mit3']."'";

  } 
 }
//KER3 - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['szerz_tetel_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['szerz_tetel_id']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel.szerz_tetel_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['szerz_tetel_id']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['akt']))and($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['akt']=="1")){
  if($where!="") $where.=" and ";
  $where.=" szerz_tetel_adat.szerz_tetel_akt = '1' ";
 }
 
 if($where!="") $where.=" and ";
 $where.=" szerz_tetel.szerz_tetel_szolg_kezd_date_folyamatban='0' and szerz_tetel_adat.szerz_tetel_integ_erintett='1' ";
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['sapszam']))and($_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['sapszam']!="")){
  if($where!="") $where.=" and ";
  $where.=" szerz.szerz_sapszam = '".$_SESSION[$GLOBALS['sessionname']]['admin_integadatlist_keres']['sapszam']."'";
 }

if($where!='')$where=' where '.$where;

 $sql1="SELECT count(szerz_tetel.szerz_tetel_id) as tal FROM `szerz_tetel` ";
 $sql1.="
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id 
 ";
 
 if($where!="") 
  $sql1.="".$where;//where

//count(szerz_tetel_integ.szerz_tetel_integ_tobblet) as integ_tobblet_szam, 
 $sql="SELECT 
 szerz_tetel_integ.szerz_tetel_integ_tobblet
 ,szerz_tetel_integ.szerz_tetel_integ_tobblet_ho
 ,szerz_tetel_integ.szerz_tetel_integ_megj
 ,szerz_tetel.*
 ,szerz_tetel_adat.*
 ,szerz.*
 ,szerz_csop.szerz_csop_nev 
 ,szerz_tipus.szerz_tipus_nev
 ,mira_tagv_kod.tagv_kod_nev ";
 
 if($talszam=='999999'){//excel export
 $sql.=" ,mira_szolg_kod.szolg_kod_nev
 ,szerz_elsz_tipus.szerz_elsz_tipus_nev
 ,szerz_naturalia.szerz_naturalia_nev
 ,szerz_usergazda.szerz_usergazda_nev
 ,mira_user_mod.user_nev
 ";
 }
 
 $sql.=" FROM `szerz_tetel` ";
 $sql.="inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tetel.szerz_tetel_id
 inner join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
 left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_tetel_adat.szerz_csop_id
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id
 left join szerz_tetel_integ ON szerz_tetel_integ.szerz_tetel_adat_id = szerz_tetel_adat.szerz_tetel_adat_id 
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod ";
 //
 if($talszam=='999999'){//excel export
 $sql.=" left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_tetel_adat.szolg_kod
 left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tetel_adat.szerz_elsz_tipus_id
 left join szerz_naturalia ON szerz_naturalia.szerz_naturalia_id = szerz_tetel_adat.szerz_naturalia_id
 left join szerz_usergazda ON szerz_usergazda.szerz_usergazda_ad = szerz_tetel_adat.szerz_usergazda_ad
 left join mira_user as mira_user_mod ON mira_user_mod.user_ad = szerz_tetel_adat.szerz_tetel_mod_user_ad 
 ";
 }
 
 if($where!="") 
  $sql.="".$where;//where
 //$sql.=" group by szerz_tetel.szerz_tetel_id ";
 $sql_order.=",szerz_tetel_adat.szerz_tetel_id asc,szerz_tetel_adat.szerz_tetel_modszam asc,szerz_tetel_adat.szerz_tetel_adat_id asc,szerz.szerz_keret asc, szerz.szerz_tipus_id asc, szerz_tetel_adat.szerz_csop_id asc, szerz.szerz_date_hatalybelep asc";
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql."<br>";
 /*
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
 */
 return array_merge(mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql1),MYSQLI_ASSOC),mysqli_fetch_all(mysqli_query($GLOBALS['mysqli'],$sql),MYSQLI_ASSOC));

}

function keres_admin_tigadatnemszerz_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_tigadatnemszerzlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_tigadatnemszerzlist_keres_order','admin_tigadatnemszerzlist_keres_order_mod');
//Rendezés - vége

//if(
//($sql_order=='order by szerz_tig_nemszerz.szerz_tig_nemszerz_evho asc')or
//($sql_order=='order by szerz_tig_nemszerz.szerz_tig_nemszerz_evho desc')
//){
 $sql_order.=',szerz_tig_nemszerz.szerz_tig_nemszerz_tagv_kod asc, szerz_tig_nemszerz.szerz_tig_nemszerz_szerz_tipus_id asc, szerz_tig_nemszerz.szerz_tig_nemszerz_szolg_kod asc';
//}

$where="";

//Összes hónap esetén
 if(
 (isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ev']))and
 (isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ho']))and
 ($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ev']!="")and
 ($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ho']=="all")
 ){
  if($where!="") $where.=" and ";
  $where.="szerz_tig_nemszerz.szerz_tig_nemszerz_evho BETWEEN '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ev']."-01-01' AND '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ev']."-12-01'";
 }elseif(
 (isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ev']))and
 (isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ho']))and
 ($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ev']!="")and
 ($_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ho']!="all")
 ){
  if($where!="") $where.=" and ";
  $where.="szerz_tig_nemszerz.szerz_tig_nemszerz_evho = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ev']."-".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatnemszerzlist_keres']['ho']."-01'";
 }

if($where!='')$where=' where '.$where;

 $sql1="SELECT count(szerz_tig_nemszerz.szerz_tig_nemszerz_id) as tal FROM `szerz_tig_nemszerz` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT szerz_tig_nemszerz.szerz_tig_nemszerz_id as id,
  DATE_FORMAT(szerz_tig_nemszerz.szerz_tig_nemszerz_evho, '%Y.%m') AS evho,
  szerz_tig_nemszerz.szerz_tig_nemszerz_tagv_kod as tagv_kod,
  mira_tagv_kod.tagv_kod_nev,
  
  szerz_tig_nemszerz.szerz_tig_nemszerz_szerz_tipus_id as szerz_tipus_id,
  szerz_tipus.szerz_tipus_nev,
  
  szerz_tig_nemszerz.szerz_tig_nemszerz_szolg_kod as szolg_kod,
  mira_szolg_kod.szolg_kod_nev,
  
  szerz_tig_nemszerz.szerz_tig_nemszerz_szerzodes,
  
  szerz_tig_nemszerz.szerz_tig_nemszerz_elsz_tipus_id as elsz_tipus_id,
  szerz_elsz_tipus.szerz_elsz_tipus_nev,
  
  szerz_tig_nemszerz.szerz_tig_nemszerz_szerzosszeg as szerzosszeg,
  szerz_tig_nemszerz.szerz_tig_nemszerz_haviosszeg as haviosszeg,
  szerz_tig_nemszerz.szerz_tig_nemszerz_haviosszeg_mod1 as haviosszeg_mod1,
  szerz_tig_nemszerz.szerz_tig_nemszerz_haviosszeg_mod2 as haviosszeg_mod2,
  szerz_tig_nemszerz.szerz_tig_nemszerz_penznem as penznem,
  szerz_tig_nemszerz.szerz_tig_nemszerz_co as co
 FROM `szerz_tig_nemszerz` 
 left join mira_tagv_kod ON szerz_tig_nemszerz_tagv_kod = mira_tagv_kod.tagv_kod 
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz_tig_nemszerz.szerz_tig_nemszerz_szerz_tipus_id 
 left join mira_szolg_kod ON mira_szolg_kod.szolg_kod = szerz_tig_nemszerz.szerz_tig_nemszerz_szolg_kod
 left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tig_nemszerz.szerz_tig_nemszerz_elsz_tipus_id
 ";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_tigadatpenznem_uj(){
$eredmeny_keres="";

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['penznem']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['penznem']!="")){
  if($where!="") $where.=" and ";
  $where.="p.penznem like '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['penznem']."%'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['ev']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['ev']!="")){
  $join=" and YEAR(a.arfolyam_date) = ".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatpenznemlist_keres']['ev'];
 }else{
	 $join="";
 }

if($where!='')$where=' where '.$where;
//%Y-%m
//m a nullás hónap
//c a nulla nélküli hónap
$sql="SELECT 
    p.penznem,
    p.penznem_nev,
    DATE_FORMAT(a.arfolyam_date, '%Y-%c') AS evho,
    a.arfolyam_ert
FROM 
    szerz_penznem p
LEFT JOIN 
    szerz_penznem_arfolyam a ON p.penznem = a.penznem
".$join.$where."
ORDER BY 
    CASE WHEN p.penznem = 'HUF' THEN 0 ELSE 1 END,
    p.penznem ASC,                                   
    DATE_FORMAT(a.arfolyam_date, '%Y-%c') DESC;      
";
   /*
   -- HUF legyen első
   -- utána ABC szerint
   -- árfolyamoknál évhó csökkenő
   */
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['penznem']]['arfolyam'][$adatom['evho']]=$adatom['arfolyam_ert'];
  $eredmeny_keres[$adatom['penznem']]['nev']=$adatom['penznem_nev'];
 }
 return $eredmeny_keres;
 
}

function keres_admin_tigadatvevoazon_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_tigadatvevoazonlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_tigadatvevoazonlist_keres_order','admin_tigadatvevoazonlist_keres_order_mod');
//Rendezés - vége

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatvevoazonlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatvevoazonlist_keres']['tagv_kod']!="all")){
  if($where!="") $where.=" and ";
  $where.="mira_tagv_kod.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatvevoazonlist_keres']['tagv_kod']."'";
 }

if($where!='')$where=' where '.$where;

 $sql1="SELECT count(mira_tagv_kod.tagv_kod) as tal FROM `mira_tagv_kod` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT mira_tagv_kod.tagv_kod,
 mira_tagv_kod.tagv_kod_nev,
 mira_tagv_kod.tagv_kod_vevoazon
 FROM `mira_tagv_kod`";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_tigadatsapszam_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_tigadatsapszamlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_tigadatsapszamlist_keres_order','admin_tigadatsapszamlist_keres_order_mod');
//Rendezés - vége

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['tagv_kod']!="all")){
  if($where!="") $where.=" and ";
  $where.="szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['tagv_kod']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerz_keret']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerz_keret']!="all")){
  if($where!="") $where.=" and ";
  $where.="szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerz_keret']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerztipusid']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerztipusid']!="all")){
  if($where!="") $where.=" and ";
  $where.="szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['szerztipusid']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['sapszam']))and($_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['sapszam']!="")){
  if($where!="") $where.=" and ";
  $where.="szerz.szerz_sapszam = '".$_SESSION[$GLOBALS['sessionname']]['admin_tigadatsapszamlist_keres']['sapszam']."'";
 }

if($where!='')$where=' where '.$where;

 $sql1="SELECT count(szerz.szerz_id) as tal FROM `szerz` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT szerz.*,szerz_tipus.szerz_tipus_nev
 ,szerz_tagvkat.szerz_tagvkat_kat
 ,szerz_tagvkat.szerz_tagvkat_date_kezd
 ,szerz_tagvkat.szerz_tagvkat_date_veg
 ,mira_tagv_kod.tagv_kod_nev
 FROM `szerz` 
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id
 left join szerz_tagvkat ON szerz_tagvkat.tagv_kod = szerz.tagv_kod and szerz_tagvkat.szerz_tagvkat_akt = '1'
 left join mira_tagv_kod ON mira_tagv_kod.tagv_kod = szerz.tagv_kod ";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_tarskat_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_tarskatlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_tarskatlist_keres_order','admin_tarskatlist_keres_order_mod');
//Rendezés - vége

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tarskatlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_tarskatlist_keres']['tagv_kod']!="all")){
  if($where!="") $where.=" and ";
  $where.="mira_tagv_kod.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_tarskatlist_keres']['tagv_kod']."'";
 }

if($where!='')$where=' where '.$where;

 $sql1="SELECT count(mira_tagv_kod.tagv_kod) as tal FROM `mira_tagv_kod` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT mira_tagv_kod.tagv_kod
 ,mira_tagv_kod.tagv_kod_nev
 ,szerz_tagvkat.szerz_tagvkat_kat
 ,szerz_tagvkat.szerz_tagvkat_date_kezd
 ,szerz_tagvkat.szerz_tagvkat_date_veg
 FROM `mira_tagv_kod` 
 left join szerz_tagvkat ON szerz_tagvkat.tagv_kod = mira_tagv_kod.tagv_kod and szerz_tagvkat.szerz_tagvkat_akt = '1'";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_szerzfeltolt_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_szerzfeltoltlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_szerzfeltoltlist_keres_order','admin_szerzfeltoltlist_keres_order_mod');
//Rendezés - vége

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerz_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerz_id']!="")){
  if($where!="") $where.=" and ";
  $where.="szerz.szerz_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerz_id']."'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['tagv_kod']!="all")){
  if($where!="") $where.=" and ";
  $where.="szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['tagv_kod']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerztipusid']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerztipusid']!="all")){
  if($where!="") $where.=" and ";
  $where.="szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerztipusid']."'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerzvane']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerzvane']!="all")){
  if($where!="") $where.=" and ";
  if($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerzvane']=='1')
   $where.="szerz_file.szerz_file_szerz_vane = '".$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerzvane']."'";
  else $where.="szerz_file.szerz_file_szerz_vane is null";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['arvane']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['arvane']!="all")){
  if($where!="") $where.=" and ";
  if($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['arvane']=='1')
   $where.="szerz_file.szerz_file_ar_vane = '".$_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['arvane']."'";
  else $where.="szerz_file.szerz_file_ar_vane is null";
 }
 
if($where!='')$where=' where '.$where;

 $sql1="
 SELECT COUNT(*) as tal
FROM
(
 SELECT count(szerz.szerz_id) as tal 
 FROM `szerz` 
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_id = szerz.szerz_id ";
 if(
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerzvane']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['szerzvane']!="all"))
	 or
 ((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['arvane']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzfeltoltlist_keres']['arvane']!="all"))
 ){
  $sql1.=" left join szerz_file ON szerz_file.szerz_id = szerz.szerz_id 
  and szerz_file.szerz_tetel_modszam_kezi = szerz_tetel_adat.szerz_tetel_modszam_kezi ";
 }
 if($where!="") 
  $sql1.="".$where;//where
 $sql1.=" group by szerz_tetel_adat.szerz_id,szerz_tetel_adat.szerz_tetel_modszam_kezi
 ) t";

	 
 $sql="SELECT szerz.szerz_id,szerz.tagv_kod
 ,szerz.szerz_megj
 ,szerz_tipus.szerz_tipus_nev,szerz_tetel_adat.szerz_tetel_modszam_kezi
 ,szerz_file.szerz_file_id
 ,szerz_file.szerz_file_szerz_vane
 ,szerz_file.szerz_file_szerz_name
 ,szerz_file.szerz_file_ar_vane
 ,szerz_file.szerz_file_ar_name
 FROM `szerz` 
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id
 inner join szerz_tetel_adat ON szerz_tetel_adat.szerz_id = szerz.szerz_id
 left join szerz_file ON szerz_file.szerz_id = szerz.szerz_id
	and szerz_file.szerz_tetel_modszam_kezi = szerz_tetel_adat.szerz_tetel_modszam_kezi ";
 
  if($where!="") 
  $sql.="".$where;//where
 $sql.=" group by szerz_tetel_adat.szerz_id,szerz_tetel_adat.szerz_tetel_modszam_kezi ";
 
 $sql.=" ".$sql_order.",szerz_tipus.szerz_tipus_nev asc,szerz_tetel_adat.szerz_tetel_modszam_kezi asc,szerz.szerz_id asc limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_szerzalapadat_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_szerzalapadatlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_szerzalapadatlist_keres_order','admin_szerzalapadatlist_keres_order_mod');
//Rendezés - vége

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['tagv_kod']!="all")){
  if($where!="") $where.=" and ";
  $where.="szerz.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['tagv_kod']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerz_keret']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerz_keret']!="all")){
  if($where!="") $where.=" and ";
  $where.="szerz.szerz_keret = '".$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerz_keret']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerztipusid']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerztipusid']!="all")){
  if($where!="") $where.=" and ";
  $where.="szerz.szerz_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['szerztipusid']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['sapszam']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['sapszam']!="")){
  if($where!="") $where.=" and ";
  $where.="szerz.szerz_sapszam = '".$_SESSION[$GLOBALS['sessionname']]['admin_szerzalapadatlist_keres']['sapszam']."'";
 }

if($where!='')$where=' where '.$where;

 $sql1="SELECT count(szerz.szerz_id) as tal FROM `szerz` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT szerz.*,szerz_tipus.szerz_tipus_nev
 FROM `szerz` 
 left join szerz_tipus ON szerz_tipus.szerz_tipus_id = szerz.szerz_tipus_id";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_tenypotlastig_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_tenypotlastiglist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_tenypotlastiglist_keres_order','admin_tenypotlastiglist_keres_order_mod');
//Rendezés - vége

if($sql_order!='order by szerz_tenybe_egyebnat.tenybe_egyebnat_evho desc')
	$sql_order.=',szerz_tenybe_egyebnat.szerz_tetel_id desc';

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['id']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['id']!="")){
  if($where!="") $where.=" and ";
  $where.="szerz_tenybe_egyebnat.szerz_tetel_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['id']."'";
 }

 if(
 (isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ev']))and
 (isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ho']))and
 ($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ev']!="all")and
 ($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ho']=="all")
 ){
  if($where!="") $where.=" and ";
  $where.="szerz_tenybe_egyebnat.tenybe_egyebnat_evho BETWEEN '".$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ev']."-01-01' AND '".$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ev']."-12-01'";
 }elseif(
 (isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ev']))and
 (isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ho']))and
 ($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ev']!="all")and
 ($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ho']!="all")
 ){
  if($where!="") $where.=" and ";
  $where.="szerz_tenybe_egyebnat.tenybe_egyebnat_evho = '".$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ev']."-".$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlastiglist_keres']['ho']."-01'";
 }
 
if($where!='')$where='where '.$where;

 $sql1="SELECT count(szerz_tenybe_egyebnat.szerz_tetel_id) as tal FROM `szerz_tenybe_egyebnat` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT szerz_tenybe_egyebnat.szerz_tetel_id
 ,szerz_tenybe_egyebnat.tenybe_egyebnat_evho as evho_orig
 ,DATE_FORMAT(szerz_tenybe_egyebnat.tenybe_egyebnat_evho, '%Y.%m') AS evho
 ,DATE_FORMAT(szerz_tenybe_egyebnat.tenybe_egyebnat_evho, '%Y') AS ev
 ,DATE_FORMAT(szerz_tenybe_egyebnat.tenybe_egyebnat_evho, '%m') AS ho
 ,szerz_tenybe_egyebnat.egyebnat
 ,szerz_tetel_adat.szerz_tetel_adat_id
 ,szerz.tagv_kod
 ,szerz_csop.szerz_csop_nev 
 ,szerz_tetel_adat.szolg_kod
 ,szerz_elsz_tipus.szerz_elsz_tipus_nev
 FROM `szerz_tenybe_egyebnat`
 left join szerz_tetel_adat ON szerz_tetel_adat.szerz_tetel_id = szerz_tenybe_egyebnat.szerz_tetel_id 
  and szerz_tetel_adat.szerz_tetel_akt='1'
 left join szerz ON szerz.szerz_id = szerz_tetel_adat.szerz_id
 left join szerz_csop ON szerz_csop.szerz_csop_id = szerz_tetel_adat.szerz_csop_id 
 left join szerz_elsz_tipus ON szerz_elsz_tipus.szerz_elsz_tipus_id = szerz_tetel_adat.szerz_elsz_tipus_id
 ";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //echo $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_szerztipus_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_szerztipuslist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_szerztipuslist_keres_order','admin_szerztipuslist_keres_order_mod');
//Rendezés - vége

$where="";

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szerztipuslist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_szerztipuslist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="szerz_tipus.szerz_tipus_nev like '%".$_SESSION[$GLOBALS['sessionname']]['admin_szerztipuslist_keres']['nev']."%'";
 }

if($where!='')$where='where '.$where;

 $sql1="SELECT count(szerz_tipus.szerz_tipus_id) as tal FROM `szerz_tipus` ";
 
 if($where!="") 
  $sql1.="".$where;//where
	 
 $sql="SELECT *
 FROM `szerz_tipus` ";
 
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_szerv_uj(){
$eredmeny_keres="";
//$where=" mira_szerv.szerv_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'";
$where="";

//Talszám - eleje
if((isset($_POST['szervlist_keres_talszam']))and($_POST['szervlist_keres_talszam']!="")){
 $szervlist_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['szervlist_keres_talszam']);
 
 if($_POST['szervlist_keres_talszam']<999999){//Excel export miatt
 //Ha változik, akkor le is kell menteni
 if($GLOBALS['mira']['user_jog']['szervlist_keres_talszam']!=$szervlist_keres_talszam){
   $tmp_mod[0]['szerv_szervlist_keres_talszam']=$szervlist_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
 //be is kell állítani.
 $GLOBALS['mira']['user_jog']['szervlist_keres_talszam']=$szervlist_keres_talszam;
 }
}else{
 $szervlist_keres_talszam=$GLOBALS['mira']['user_jog']['szervlist_keres_talszam'];
}
//Talszám - vége

//Rendezés - eleje
if((isset($_POST['order']))and($_POST['order']!="")){
 if($_POST['order']==$GLOBALS['mira']['user_jog']['szervlist_keres_order']){
  //Ekkor mező marad, és desc->asc vagy fordítva
  if($GLOBALS['mira']['user_jog']['szervlist_keres_order_mod']=="desc")
	  $GLOBALS['mira']['user_jog']['szervlist_keres_order_mod']="asc";
  else
	  $GLOBALS['mira']['user_jog']['szervlist_keres_order_mod']="desc";
  
  //Ekkor order_mod kell lemeteni
   $tmp_mod[0]['szerv_szervlist_keres_order_mod']=$GLOBALS['mira']['user_jog']['szervlist_keres_order_mod'];
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);

 }else{//Ekkor a mező változott, rendezési mód marad
	$GLOBALS['mira']['user_jog']['szervlist_keres_order']=$_POST['order'];
   
   //Le is kell menteni.
   $tmp_mod[0]['szerv_szervlist_keres_order']=$_POST['order'];
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
}
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="mira_szerv.szerv_nev like '%".$_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['nev']."%'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['csoport_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['csoport_id']!="all")){
  if($where!="") $where.=" and ";
  $where.="mira_szerv.szerv_csoport_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['csoport_id']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['inaktiv']!="all")){
  if($where!="") $where.=" and ";
  $where.="mira_szerv.szerv_inaktiv = '".$_SESSION[$GLOBALS['sessionname']]['admin_szervlist_keres']['inaktiv']."'";
 }

 //riport esetén teljes lista kell:
 if((isset($_POST['riport_lekeres'])) and ($_POST['riport_lekeres']=='1')){
	 $where='';
 }


if($where!='')$where='where '.$where;

 $sql1="SELECT count(tal1) as tal FROM (SELECT count(mira_szerv.szerv_id) as tal1 FROM `mira_szerv` 
 
 ";
 if($where!="") 
  $sql1.="".$where;//where
 $sql1.=" GROUP BY mira_szerv.szerv_id ";
 $sql1.=") t";
	 
 $sql="SELECT mira_szerv.*,mira_szerv_csoport.mira_szerv_csoport_nev 
 FROM `mira_szerv` 
  left join mira_szerv_csoport ON mira_szerv_csoport.mira_szerv_csoport_id = mira_szerv.szerv_csoport_id
 ";
 if($where!="") 
  $sql.="".$where;//where
 $sql.=" GROUP BY mira_szerv.szerv_id 
 order by ".$GLOBALS['mira']['user_jog']['szervlist_keres_order']." ".$GLOBALS['mira']['user_jog']['szervlist_keres_order_mod']." 
 limit ".$_POST['oldalholvagyok'].", ".$szervlist_keres_talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

//Adott szervezethez hány user van hozzárendelve! csak szám
function keres_user_hozzarend_szam($tomb){
 $eredmeny_keres="";

$where_mira_szerv='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_mira_szerv!='')$where_mira_szerv.=' or ';
 $where_mira_szerv.='(mira_szerv.szerv_id="'.$ert['szerv_id'].'")';
}
}
if($where_mira_szerv!='')$where_mira_szerv=' and ('.$where_mira_szerv.') ';
// and mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(mira_user.user_ad) as szam,mira_szerv.szerv_id
 FROM `mira_szerv` 
 left join mira_user ON mira_user.szerv_id = mira_szerv.szerv_id
 where mira_user.user_inaktiv='0'

 ".$where_mira_szerv."
 GROUP BY mira_szerv.szerv_id";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerv_id']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}

//Adott szervezethez hány projekt van hozzárendelve! csak szám
function keres_projekt_hozzarend_szam($tomb){
 $eredmeny_keres="";

$where_mira_szerv='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_mira_szerv!='')$where_mira_szerv.=' or ';
 $where_mira_szerv.='(mira_szerv.szerv_id="'.$ert['szerv_id'].'")';
}
}
if($where_mira_szerv!='')$where_mira_szerv=' and ('.$where_mira_szerv.') ';
// and projekt.projekt_tagv = '".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(projekt_szerv.projekt_szerv_id) as szam,mira_szerv.szerv_id
 FROM `mira_szerv` 
 left join projekt_szerv ON projekt_szerv.szerv_id = mira_szerv.szerv_id
 left join projekt ON projekt.projekt_id = projekt_szerv.projekt_id
 where
 projekt.projekt_inaktiv='0'

 ".$where_mira_szerv."
 GROUP BY mira_szerv.szerv_id";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerv_id']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}

//Adott szervezethez hány jóváhagyója van! csak szám
function keres_szerv_jovahagyok_hozzarend_szam($tomb){
 $eredmeny_keres="";
 
$where_mira_szerv='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_mira_szerv!='')$where_mira_szerv.=' or ';
 $where_mira_szerv.='(mira_szerv.szerv_id="'.$ert['szerv_id'].'")';
}
}
if($where_mira_szerv!='')$where_mira_szerv=' and ('.$where_mira_szerv.') ';
 // and mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(mira_szerv_jovahagyo.szerv_jovahagyo_id) as szam,mira_szerv.szerv_id
 FROM `mira_szerv` 
 left join mira_szerv_jovahagyo ON mira_szerv_jovahagyo.szerv_id = mira_szerv.szerv_id
 left join mira_user ON mira_user.user_ad = mira_szerv_jovahagyo.user_ad
 where
 mira_user.user_inaktiv='0'

 ".$where_mira_szerv." 
 GROUP BY mira_szerv.szerv_id";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerv_id']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}


function keres_proj_akt_nevlike($projekt_nev){
 $eredmeny_keres="";
 $projekt_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_nev));
 //and `projekt_tagv` ='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT projekt_id 
 FROM `projekt`
 where `projekt_nev` like '".$projekt_nev."%' 
 and `projekt_inaktiv`='0'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=1;
 }
 return $eredmeny_keres;
}

function keres_user_ujtevekenyseghez($user_nev){
$eredmeny_keres="";
$user_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$user_nev));

//Talszám - eleje
if((isset($_POST['user_ujtevekuserhozza_keres_talszam']))and($_POST['user_ujtevekuserhozza_keres_talszam']!="")){
 $user_ujtevekuserhozza_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['user_ujtevekuserhozza_keres_talszam']);
 
 if($_POST['user_ujtevekuserhozza_keres_talszam']<999999){//Excel export miatt
 if($GLOBALS['mira']['user_jog']['user_ujtevekuserhozza_keres_talszam']!=$user_ujtevekuserhozza_keres_talszam){
   $tmp_mod[0]['user_ujtevekuserhozza_keres_talszam']=$user_ujtevekuserhozza_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
  //be is kell állítani.
 $GLOBALS['mira']['user_jog']['user_ujtevekuserhozza_keres_talszam']=$user_ujtevekuserhozza_keres_talszam;
 }
 
 }else{
 $user_ujtevekuserhozza_keres_talszam=$GLOBALS['mira']['user_jog']['user_ujtevekuserhozza_keres_talszam'];
}
//Talszám - vége

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$limit_tol=$_POST['oldalholvagyok'];

$limit_ig=$user_ujtevekuserhozza_keres_talszam;

//Talszám - eleje
$sql1="SELECT count(mira_user.user_ad) as tal
 FROM `mira_user` ";
  
 $sql1.=" where ";
 //$sql1.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 
  $sql1.=" mira_user.user_inaktiv = '0'";
 if($user_nev!="")//Csak ha rákerestek bármire
  $sql1.=" and mira_user.user_nev like '".$user_nev."%'";

//Talszám - vége

//Teljes keresés
$sql="SELECT mira_user.user_ad,mira_user.user_nev
 FROM `mira_user` ";
 
 $sql.=" where ";
 //$sql.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";

 $sql.=" mira_user.user_inaktiv = '0'";
 
 if($user_nev!="")//Csak ha rákerestek bármire
  $sql.=" and mira_user.user_nev like '".$user_nev."%'";

 $sql.=" order by mira_user.user_nev ASC
 limit ".$limit_tol.", ".$limit_ig;
 
 //print $sql."<br>";exit;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

//$csakvan=1 esetén csak a jóváhagyók kellene,amugy mindenki!
function keres_szervjovahagyo_user($szerv_id,$keress_user_nev,$csakvan){
$eredmeny_keres="";
$szerv_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_id);
$keress_user_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_user_nev));
$csakvan=mysqli_real_escape_string($GLOBALS['mysqli'],$csakvan);

//Talszám - eleje
if((isset($_POST['user_szervjovahagyo_keres_talszam']))and($_POST['user_szervjovahagyo_keres_talszam']!="")){
 $user_szervjovahagyo_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['user_szervjovahagyo_keres_talszam']);
 
 if($_POST['user_szervjovahagyo_keres_talszam']<999999){//Excel export miatt
 if($GLOBALS['mira']['user_jog']['user_szervjovahagyo_keres_talszam']!=$user_szervjovahagyo_keres_talszam){
   $tmp_mod[0]['user_szervjovahagyo_keres_talszam']=$user_szervjovahagyo_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
  //be is kell állítani.
 $GLOBALS['mira']['user_jog']['user_szervjovahagyo_keres_talszam']=$user_szervjovahagyo_keres_talszam;
 }
 
 }else{
 $user_szervjovahagyo_keres_talszam=$GLOBALS['mira']['user_jog']['user_szervjovahagyo_keres_talszam'];
}
//Talszám - vége
 
 

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$limit_tol=$_POST['oldalholvagyok'];

$limit_ig=$user_szervjovahagyo_keres_talszam;

//Talszám - eleje
$sql1="SELECT count(mira_user.user_ad) as tal
 FROM `mira_user` ";
 if($csakvan==1)
  $sql1.=" inner join mira_szerv_jovahagyo ON mira_szerv_jovahagyo.user_ad = mira_user.user_ad 
  and mira_szerv_jovahagyo.szerv_id='".$szerv_id."'";
 
 $sql1.=" ";//where
 //$sql1.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and mira_user.user_inaktiv='0'";
 
 if($keress_user_nev!="")//Csak ha rákerestek bármire
  $sql1.=" where mira_user.user_nev like '".$keress_user_nev."%'";//and
//Talszám - vége

//Teljes keresés
$sql="SELECT mira_user.user_ad,mira_user.user_nev
 FROM `mira_user` ";
 
 if($csakvan==1)
  $sql.=" inner join mira_szerv_jovahagyo ON mira_szerv_jovahagyo.user_ad = mira_user.user_ad 
  and mira_szerv_jovahagyo.szerv_id='".$szerv_id."'";
 
 $sql.=" ";//where
 //$sql.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and mira_user.user_inaktiv='0'";
 
 if($keress_user_nev!="")//Csak ha rákerestek bármire
  $sql.=" where mira_user.user_nev like '".$keress_user_nev."%'";//and

 $sql.=" order by mira_user.user_nev ASC
 limit ".$limit_tol.", ".$limit_ig;
 
 //print $sql."<br>";exit;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

//Adott szervezethez hány aktív jóváhagyó van hozzárendelve! Adat is
function keres_szervjovahagyo_hozzarend_adat($szerv_id){
 $eredmeny_keres="";
 $szerv_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_id);
 $sql="SELECT mira_user.user_ad
 FROM `mira_szerv_jovahagyo` 
 left join mira_user ON mira_user.user_ad = mira_szerv_jovahagyo.user_ad
 where
 mira_szerv_jovahagyo.szerv_id='".$szerv_id."' and 
 mira_user.user_inaktiv='0'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=1;
 }
 return $eredmeny_keres;
}

//Adott szervezethez hány aktív projekt van hozzárendelve! Adat is
function keres_projekt_hozzarend_adat($szerv_id){
 $eredmeny_keres="";
 $szerv_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_id);
 $sql="SELECT projekt.projekt_id
 FROM `projekt_szerv` 
 left join projekt ON projekt.projekt_id = projekt_szerv.projekt_id
 where
 projekt_szerv.szerv_id='".$szerv_id."' and 
 projekt.projekt_inaktiv='0'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=1;
 }
 return $eredmeny_keres;
}

//Adott szervezethez hány aktív user van hozzárendelve! Adat is
function keres_user_hozzarend_adat($szerv_id){
 $eredmeny_keres="";
 $szerv_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_id);
 $sql="SELECT mira_user.user_ad,mira_user.user_nev,mira_user.user_tsz,mira_user.user_email
 FROM `mira_user` 
 where
 mira_user.szerv_id='".$szerv_id."' and 
 mira_user.user_inaktiv='0'
 order by mira_user.user_nev asc";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_arazasref_uj(){
$eredmeny_keres="";

$talszam=keres_talszam('admin_arazasreflist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_arazasreflist_keres_order','admin_arazasreflist_keres_order_mod');
//Rendezés - vége

$where="";

if((isset($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['id']))and($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['id']!="")){
  if($where!="") $where.=" and ";
  $where.="projekt.projekt_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['id']."'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="projekt.projekt_nev like '%".$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['nev']."%'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['arazasref']))and($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['arazasref']!="all")){
  if($where!="") $where.=" and ";
  if($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['arazasref']=='keremv')
   $where.="projekt.projekt_arazasref is null ";
  else
   $where.="projekt.projekt_arazasref = '".$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['arazasref']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['inaktiv']!="all")){
  if($where!="") $where.=" and ";
  $where.="projekt.projekt_inaktiv = '".$_SESSION[$GLOBALS['sessionname']]['admin_arazasreflist_keres']['inaktiv']."'";
 }

 $sql1="SELECT count(projekt.projekt_id) as tal
 FROM `projekt` 
 
 ";
 if($where!="") 
  $sql1.="where ".$where;
	 
 $sql="SELECT projekt.projekt_id,projekt.projekt_nev,projekt.projekt_arazasref,projekt.projekt_inaktiv
 FROM `projekt` 
 ";
 if($where!="") 
  $sql.="where ".$where;
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_projekt_uj(){
$eredmeny_keres="";
//$where=" projekt.projekt_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'";
$where="";

//Talszám - eleje
if((isset($_POST['projektlist_keres_talszam']))and($_POST['projektlist_keres_talszam']!="")){
 $projektlist_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['projektlist_keres_talszam']);
 
 if($_POST['projektlist_keres_talszam']<999999){//Excel export miatt
 //Ha változik, akkor le is kell menteni
 if($GLOBALS['mira']['user_jog']['projektlist_keres_talszam']!=$projektlist_keres_talszam){
   $tmp_mod[0]['projekt_projektlist_keres_talszam']=$projektlist_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
 //be is kell állítani.
 $GLOBALS['mira']['user_jog']['projektlist_keres_talszam']=$projektlist_keres_talszam;
 }
}else{
 $projektlist_keres_talszam=$GLOBALS['mira']['user_jog']['projektlist_keres_talszam'];
}
//Talszám - vége

//Rendezés - eleje
if((isset($_POST['order']))and($_POST['order']!="")){
 if($_POST['order']==$GLOBALS['mira']['user_jog']['projektlist_keres_order']){
  //Ekkor mező marad, és desc->asc vagy fordítva
  if($GLOBALS['mira']['user_jog']['projektlist_keres_order_mod']=="desc")
	  $GLOBALS['mira']['user_jog']['projektlist_keres_order_mod']="asc";
  else
	  $GLOBALS['mira']['user_jog']['projektlist_keres_order_mod']="desc";
  
  //Ekkor order_mod kell lemeteni
   $tmp_mod[0]['projekt_projektlist_keres_order_mod']=$GLOBALS['mira']['user_jog']['projektlist_keres_order_mod'];
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);

 }else{//Ekkor a mező változott, rendezési mód marad
	$GLOBALS['mira']['user_jog']['projektlist_keres_order']=$_POST['order'];
   
   //Le is kell menteni.
   $tmp_mod[0]['projekt_projektlist_keres_order']=$_POST['order'];
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
}
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['id']))and($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['id']!="")){
  if($where!="") $where.=" and ";
  $where.="projekt.projekt_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['id']."'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="projekt.projekt_nev like '%".$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['nev']."%'";
 }

 /*if((isset($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['kat_id']))and($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['kat_id']!="all")){
  if($where!="") $where.=" and ";
  $where.="projekt.projekt_kat_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['kat_id']."'";
 }*/
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['inaktiv']!="all")){
  if($where!="") $where.=" and ";
  $where.="projekt.projekt_inaktiv = '".$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['inaktiv']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['tipus']))and($_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['tipus']!="all")){
  if($where!="") $where.=" and ";
  $where.="projekt.projekt_tipus = '".$_SESSION[$GLOBALS['sessionname']]['admin_projektlist_keres']['tipus']."'";
 }

 //riport esetén teljes lista kell:
 if((isset($_POST['riport_lekeres'])) and ($_POST['riport_lekeres']=='1')){
	 $where='';
 }

 $sql1="SELECT count(tal1) as tal FROM (SELECT count(projekt.projekt_id) as tal1 
 FROM `projekt` 
 
 ";
 if($where!="") 
  $sql1.="where ".$where;
 $sql1.=" GROUP BY projekt.projekt_id ";
 $sql1.=") t";
	 
 $sql="SELECT projekt.*,projekt_kat.projekt_kat_nev,projekt_kat.projekt_kat_nev_h
 FROM `projekt` 
  left join projekt_kat ON projekt_kat.projekt_kat_id = projekt.projekt_kat_id
 ";
 if($where!="") 
  $sql.="where ".$where;
 $sql.=" GROUP BY projekt.projekt_id 
 order by ".$GLOBALS['mira']['user_jog']['projektlist_keres_order']." ".$GLOBALS['mira']['user_jog']['projektlist_keres_order_mod']." 
 limit ".$_POST['oldalholvagyok'].", ".$projektlist_keres_talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

//Adott projekthez hány szervezet van hozzárendelve, csak szám
function keres_projekt_hozzarend_szervszam($tomb){
 $eredmeny_keres="";
 
$where_proj='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_proj!='')$where_proj.=' or ';
 $where_proj.='(projekt_szerv.projekt_id="'.$ert['projekt_id'].'")';
}
}
if($where_proj!='')$where_proj=' and ('.$where_proj.') ';
 // and mira_szerv.szerv_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(projekt_szerv.projekt_szerv_id) as szam,projekt_szerv.projekt_id
 FROM `projekt_szerv` 
 inner join mira_szerv ON mira_szerv.szerv_id = projekt_szerv.szerv_id
 where 
 mira_szerv.szerv_inaktiv='0'
 
 ".$where_proj." 
 GROUP BY projekt_szerv.projekt_id";
 //print $sql."<br>";//exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}

//Adott projekthez hány user van hozzárendelve, csak szám
function keres_projekt_hozzarend_userszam($tomb){
 $eredmeny_keres="";
 
$where_proj_user='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_proj_user!='')$where_proj_user.=' or ';
 $where_proj_user.='(projekt_user.projekt_id="'.$ert['projekt_id'].'")';
}
}
if($where_proj_user!='')$where_proj_user=' and ('.$where_proj_user.') ';
 // and mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(projekt_user.projekt_user_id) as szam,projekt_user.projekt_id
 FROM `projekt_user` 
 inner join mira_user ON mira_user.user_ad = projekt_user.user_ad
 where
 mira_user.user_inaktiv='0' and mira_user.ful_rogzit='1' 

 ".$where_proj_user." 
 GROUP BY projekt_user.projekt_id";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}

//Adott projekthez hány jóváhagyó user van hozzárendelve, csak szám
function keres_projekt_jovahagyo_hozzarend_userszam($tomb){
 $eredmeny_keres="";

$where_proj_jova='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_proj_jova!='')$where_proj_jova.=' or ';
 $where_proj_jova.='(projekt_jovahagyo.projekt_id="'.$ert['projekt_id'].'")';
}
}
if($where_proj_jova!='')$where_proj_jova=' and ('.$where_proj_jova.') ';
// and mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT COUNT(projekt_jovahagyo.projekt_jovahagyo_id) as szam,projekt_jovahagyo.projekt_id
 FROM `projekt_jovahagyo` 
 inner join mira_user ON mira_user.user_ad = projekt_jovahagyo.user_ad
 where
 mira_user.user_inaktiv='0'

 ".$where_proj_jova." 
 GROUP BY projekt_jovahagyo.projekt_id";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=$adatom['szam'];
 }
 return $eredmeny_keres;
}

//Adott projekthez van-e időkorlát beállítva
function keres_projekt_ido_vane($tomb){
 $eredmeny_keres="";
 
$where_proj='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_proj!='')$where_proj.=' or ';
 $where_proj.='(projekt.projekt_id="'.$ert['projekt_id'].'")';
}
}
if($where_proj!='')$where_proj=' and ('.$where_proj.') ';
 
 $sql="SELECT 
 projekt.projekt_id
 FROM `projekt` 
 left join projekt_ido ON projekt_ido.projekt_id = projekt.projekt_id 
 where
 (
 (projekt.projekt_id_max_all_igen='1')
 or
 (projekt_ido.projekt_id is not null)
 )".$where_proj;
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]=1;
 }
 return $eredmeny_keres;
}

function keres_szolgkod_nev_tomb(){
$eredmeny_keres="";
 $sql="SELECT
 mira_szolg_kod.szolg_kod,
 mira_szolg_kod.szolg_kod_nev
 FROM `mira_szolg_kod`
 ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szolg_kod']]=$adatom['szolg_kod_nev'];
 }
 return $eredmeny_keres;
}

function keres_szervkod_nev_tomb(){
$eredmeny_keres="";
 $sql="SELECT
 mira_szolg_kod.szolg_kod,
 mira_szolg_kod.szolg_kod_nev
 FROM `mira_szolg_kod`";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szolg_kod']]=$adatom['szolg_kod_nev'];
 }
 return $eredmeny_keres;
}

function keres_user_ujtevekenyseghez2($user_nev){
$eredmeny_keres="";
$user_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$user_nev));

//Talszám - eleje
if((isset($_POST['user_ujtevekenyseguserhozza_keres_talszam']))and($_POST['user_ujtevekenyseguserhozza_keres_talszam']!="")){
 $user_ujtevekenyseguserhozza_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['user_ujtevekenyseguserhozza_keres_talszam']);
 
 if($_POST['user_ujtevekenyseguserhozza_keres_talszam']<999999){//Excel export miatt
 if($GLOBALS['mira']['user_jog']['user_ujtevekenyseguserhozza_keres_talszam']!=$user_ujtevekenyseguserhozza_keres_talszam){
   $tmp_mod[0]['user_ujtevekenyseguserhozza_keres_talszam']=$user_ujtevekenyseguserhozza_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
  //be is kell állítani.
 $GLOBALS['mira']['user_jog']['user_ujtevekenyseguserhozza_keres_talszam']=$user_ujtevekenyseguserhozza_keres_talszam;
 }
 
 }else{
 $user_ujtevekenyseguserhozza_keres_talszam=$GLOBALS['mira']['user_jog']['user_ujtevekenyseguserhozza_keres_talszam'];
}
//Talszám - vége

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$limit_tol=$_POST['oldalholvagyok'];

$limit_ig=$user_ujtevekenyseguserhozza_keres_talszam;

//Talszám - eleje
$sql1="SELECT count(mira_user.user_ad) as tal
 FROM `mira_user` ";
  
 $sql1.=" where ";
 //$sql1.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 $sql1.=" mira_user.user_inaktiv = '0'";
 
 if($user_nev!="")//Csak ha rákerestek bármire
  $sql1.=" and mira_user.user_nev like '".$user_nev."%'";

//Talszám - vége

//Teljes keresés
$sql="SELECT mira_user.user_ad,mira_user.user_nev
 FROM `mira_user` ";
 
 $sql.=" where ";
 //$sql.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 $sql.=" mira_user.user_inaktiv = '0'";
  
 if($user_nev!="")//Csak ha rákerestek bármire
  $sql.=" and mira_user.user_nev like '".$user_nev."%'";

 $sql.=" order by mira_user.user_nev ASC
 limit ".$limit_tol.", ".$limit_ig;
 
 //print $sql."<br>";exit;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

//Adott projekthez hány szervezet van hozzárendelve! Adat is
function keres_projekt_szerv_hozzarend_adat($projekt_id){
 $eredmeny_keres="";
 $projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_id);
 $sql="SELECT projekt_szerv.szerv_id
 FROM `projekt_szerv` 
 where
 projekt_szerv.projekt_id='".$projekt_id."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerv_id']]=1;
 }
 return $eredmeny_keres;
}

//Adott userhez milyen kategória kivétel van hozzárendelve. projekt
function keres_user_projekt_katkivetel_hozzarend_adat($user_ad){
 $eredmeny_keres="";
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 $sql="SELECT projekt_user_katkivetel.projekt_id,projekt_user_katkivetel.projekt_user_kat_id_kivetel,projekt_kat.projekt_kat_nev,projekt_kat.projekt_kat_nev_h
 FROM `projekt_user_katkivetel` 
 inner join projekt_kat ON projekt_kat.projekt_kat_id = projekt_user_katkivetel.projekt_user_kat_id_kivetel
 where
 projekt_user_katkivetel.user_ad='".$user_ad."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['projekt_id']]['id']=$adatom['projekt_user_kat_id_kivetel'];
  $eredmeny_keres[$adatom['projekt_id']]['nev']=$adatom['projekt_kat_nev'];
  $eredmeny_keres[$adatom['projekt_id']]['nev_h']=$adatom['projekt_kat_nev_h'];
 }
 return $eredmeny_keres;
}

//Adott projekthez milyen kategória kivétel van hozzárendelve. user
function keres_projekt_user_katkivetel_hozzarend_adat($projekt_id){
 $eredmeny_keres="";
 $projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_id);
 $sql="SELECT projekt_user_katkivetel.user_ad,projekt_user_katkivetel.projekt_user_kat_id_kivetel,projekt_kat.projekt_kat_nev,projekt_kat.projekt_kat_nev_h
 FROM `projekt_user_katkivetel` 
 inner join projekt_kat ON projekt_kat.projekt_kat_id = projekt_user_katkivetel.projekt_user_kat_id_kivetel
 where
 projekt_user_katkivetel.projekt_id='".$projekt_id."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]['id']=$adatom['projekt_user_kat_id_kivetel'];
  $eredmeny_keres[$adatom['user_ad']]['nev']=$adatom['projekt_kat_nev'];
  $eredmeny_keres[$adatom['user_ad']]['nev_h']=$adatom['projekt_kat_nev_h'];
 }
 return $eredmeny_keres;
}

//Adott projekthez milyen kategória kivétel van hozzárendelve.
function keres_projekt_szerv_katkivetel_hozzarend_adat($projekt_id){
 $eredmeny_keres="";
 $projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_id);
 $sql="SELECT projekt_szerv_katkivetel.szerv_id,projekt_szerv_katkivetel.projekt_kat_id_kivetel,projekt_kat.projekt_kat_nev,projekt_kat.projekt_kat_nev_h
 FROM `projekt_szerv_katkivetel` 
 inner join projekt_kat ON projekt_kat.projekt_kat_id = projekt_szerv_katkivetel.projekt_kat_id_kivetel
 where
 projekt_szerv_katkivetel.projekt_id='".$projekt_id."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['szerv_id']]['id']=$adatom['projekt_kat_id_kivetel'];
  $eredmeny_keres[$adatom['szerv_id']]['nev']=$adatom['projekt_kat_nev'];
  $eredmeny_keres[$adatom['szerv_id']]['nev_h']=$adatom['projekt_kat_nev_h'];
 }
 return $eredmeny_keres;
}

function keres_projekt_idok($projekt_id){
 $eredmeny_keres="";
 $projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_id);
 $sql="SELECT projekt_ho_ido,projekt_id_max_ora  
 FROM `projekt_ido` 
 where `projekt_id`='".$projekt_id."'
 order by projekt_ho_ido asc";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_tagv_kezdeti_date(){
 $eredmeny_keres="";
 // where `tagv`='".$tagv."'
 $sql="SELECT ev_kezdo_ev,ev_kezdo_ho 
 FROM `mira_tagv` 

 ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom;
 }
 return $eredmeny_keres;
}

function keres_projekt_bellithoz_user($projekt_id,$keress_user_nev,$csakvan){
$eredmeny_keres="";
$projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_id);
$keress_user_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_user_nev));
$csakvan=mysqli_real_escape_string($GLOBALS['mysqli'],$csakvan);

//Talszám - eleje
if((isset($_POST['user_projuserhozza_keres_talszam']))and($_POST['user_projuserhozza_keres_talszam']!="")){
 $user_projuserhozza_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['user_projuserhozza_keres_talszam']);
 
 if($_POST['user_projuserhozza_keres_talszam']<999999){//Excel export miatt
 if($GLOBALS['mira']['user_jog']['user_projuserhozza_keres_talszam']!=$user_projuserhozza_keres_talszam){
   $tmp_mod[0]['user_projuserhozza_keres_talszam']=$user_projuserhozza_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
  //be is kell állítani.
 $GLOBALS['mira']['user_jog']['user_projuserhozza_keres_talszam']=$user_projuserhozza_keres_talszam;
 }
 }else{
 $user_projuserhozza_keres_talszam=$GLOBALS['mira']['user_jog']['user_projuserhozza_keres_talszam'];
}
//Talszám - vége

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$limit_tol=$_POST['oldalholvagyok'];

$limit_ig=$user_projuserhozza_keres_talszam;


//Talszám - eleje
$sql1="SELECT count(mira_user.user_ad) as tal
 FROM `mira_user` ";
 if($csakvan==1)
  $sql1.=" inner join projekt_user ON projekt_user.user_ad = mira_user.user_ad 
  and projekt_user.projekt_id='".$projekt_id."'";
 
 $sql1.=" where ";
 //$sql1.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 $sql1.="mira_user.user_inaktiv='0'";
 $sql1.=" and mira_user.ful_rogzit='1'";
 
 if($keress_user_nev!="")//Csak ha rákerestek bármire
  $sql1.=" and mira_user.user_nev like '".$keress_user_nev."%'";
//Talszám - vége

//Teljes keresés
$sql="SELECT mira_user.user_ad,mira_user.user_nev,mira_szerv.szerv_nev,mira_szerv.szerv_adkod
 FROM `mira_user` 
 left join mira_szerv ON mira_szerv.szerv_id = mira_user.szerv_id
 ";
 
 if($csakvan==1)
  $sql.=" inner join projekt_user ON projekt_user.user_ad = mira_user.user_ad 
  and projekt_user.projekt_id='".$projekt_id."'";
 
 $sql.=" where ";
 //$sql.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 $sql.="mira_user.user_inaktiv='0'";
 $sql.=" and mira_user.ful_rogzit='1'";
 
 if($keress_user_nev!="")//Csak ha rákerestek bármire
  $sql.=" and mira_user.user_nev like '".$keress_user_nev."%'";

 $sql.=" order by mira_user.user_nev ASC
 limit ".$limit_tol.", ".$limit_ig;
 
 //print $sql."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

//Adott projekthez hány felhasználó van hozzárendelve! Adat is
function keres_projekt_user_hozzarend_adat($projekt_id){
 $eredmeny_keres="";
 $projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_id);
 $sql="SELECT projekt_user.user_ad
 FROM `projekt_user` 
 where
 projekt_user.projekt_id='".$projekt_id."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=1;
 }
 return $eredmeny_keres;
}

function keres_projektjovahagyo_bellithoz_user($projekt_id,$keress_user_nev,$csakvan){
$eredmeny_keres="";
$projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_id);
$keress_user_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_user_nev));
$csakvan=mysqli_real_escape_string($GLOBALS['mysqli'],$csakvan);

//Talszám - eleje
if((isset($_POST['user_projuserjovahagyohozza_keres_talszam']))and($_POST['user_projuserjovahagyohozza_keres_talszam']!="")){
 $user_projuserjovahagyohozza_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['user_projuserjovahagyohozza_keres_talszam']);
 
 if($_POST['user_projuserjovahagyohozza_keres_talszam']<999999){//Excel export miatt
 if($GLOBALS['mira']['user_jog']['user_projuserjovahagyohozza_keres_talszam']!=$user_projuserjovahagyohozza_keres_talszam){
   $tmp_mod[0]['user_projuserjovahagyohozza_keres_talszam']=$user_projuserjovahagyohozza_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
  //be is kell állítani.
 $GLOBALS['mira']['user_jog']['user_projuserjovahagyohozza_keres_talszam']=$user_projuserjovahagyohozza_keres_talszam;
 }
 }else{
 $user_projuserjovahagyohozza_keres_talszam=$GLOBALS['mira']['user_jog']['user_projuserjovahagyohozza_keres_talszam'];
}
//Talszám - vége

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$limit_tol=$_POST['oldalholvagyok'];

$limit_ig=$user_projuserjovahagyohozza_keres_talszam;

//Talszám - eleje
$sql1="SELECT count(mira_user.user_ad) as tal
 FROM `mira_user` ";
 if($csakvan==1)
  $sql1.=" inner join projekt_jovahagyo ON projekt_jovahagyo.user_ad = mira_user.user_ad 
  and projekt_jovahagyo.projekt_id='".$projekt_id."'";
 
 $sql1.=" ";//where
 //$sql1.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and mira_user.user_inaktiv='0'";
 
 if($keress_user_nev!="")//Csak ha rákerestek bármire
  $sql1.=" where mira_user.user_nev like '".$keress_user_nev."%'";//and
//Talszám - vége

//Teljes keresés
$sql="SELECT mira_user.user_ad,mira_user.user_nev
 FROM `mira_user` ";
 
 if($csakvan==1)
  $sql.=" inner join projekt_jovahagyo ON projekt_jovahagyo.user_ad = mira_user.user_ad 
  and projekt_jovahagyo.projekt_id='".$projekt_id."'";
 
 $sql.=" ";//where
 //$sql.=" mira_user.user_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and mira_user.user_inaktiv='0'";
 
 if($keress_user_nev!="")//Csak ha rákerestek bármire
  $sql.=" where mira_user.user_nev like '".$keress_user_nev."%'";//and

 $sql.=" order by mira_user.user_nev ASC
 limit ".$limit_tol.", ".$limit_ig;
 
 //print $sql."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

//Adott projekthez hány jóváhagyó felhasználó van hozzárendelve! Adat is
function keres_projekt_userjovahagyo_hozzarend_adat($projekt_id){
 $eredmeny_keres="";
 $projekt_id=mysqli_real_escape_string($GLOBALS['mysqli'],$projekt_id);
 $sql="SELECT projekt_jovahagyo.user_ad
 FROM `projekt_jovahagyo` 
 where
 projekt_jovahagyo.projekt_id='".$projekt_id."' ";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=1;
 }
 return $eredmeny_keres;
}

function keres_kapiadd_kpi_tipusok_meglevok($szerz_id,$szerz_csop_id,$szerz_tetel_modszam_kezi){
$eredmeny_keres="";
$szerz_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_id);
$szerz_csop_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_csop_id);
$szerz_tetel_modszam_kezi=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_tetel_modszam_kezi);

$sql="SELECT szerz_kpi_osszekapcs.kpi_tipus_id
FROM `szerz_kpi` 
left join szerz_kpi_osszekapcs ON szerz_kpi_osszekapcs.szerz_kpi_id = szerz_kpi.szerz_kpi_id
where 
szerz_kpi.szerz_id='".$szerz_id."' and 
szerz_kpi.szerz_csop_id='".$szerz_csop_id."' and 
szerz_kpi.szerz_tetel_modszam_kezi='".$szerz_tetel_modszam_kezi."'";
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['kpi_tipus_id']]='1';
 }
 return $eredmeny_keres;
}

function keres_kapiadd_kpi_tipusok($szerz_csop_id){
$eredmeny_keres="";
$szerz_csop_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_csop_id);
$sql="SELECT kpi_tipus.kpi_tipus_id
,kpi_tipus.kpi_tipus_kpi
,kpi_tipus.kpi_tipus_mutmegn
,kpi_tipus.kpi_tipus_mutszmod
FROM `szerz_csop` 
inner join kpi_tipus ON kpi_tipus.kpi_szolg_kod = szerz_csop.kpi_szolg_kod
	OR kpi_tipus.kpi_szolg_kod = szerz_csop.kpi_szolg_kod_kozszolg
where szerz_csop.szerz_csop_id='".$szerz_csop_id."'
order by kpi_tipus.kpi_tipus_kpi asc
";
 //echo $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_tagv_kapcsossze_kapcs($tomb){
$eredmeny_keres="";
$where_ossze_id='';
foreach($tomb as $i => $ert){
if($i>0){
 if($where_ossze_id!='')$where_ossze_id.=' or ';
 $where_ossze_id.='kapcs_ossze_kapcs.kapcs_ossze_id="'.$ert['kapcs_ossze_id'].'"';
}
}
if($where_ossze_id!='')$where_ossze_id='where '.$where_ossze_id.'';

 $sql="SELECT kapcs_ossze_kapcs.*
 ,kapcs_torzs.kapcs_torzs_nev
 ,kapcs_torzs.tagv_kod
 FROM `kapcs_ossze_kapcs`
 left join kapcs_torzs ON kapcs_torzs.kapcs_torzs_id = kapcs_ossze_kapcs.kapcs_torzs_id
 ".$where_ossze_id;
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['kapcs_ossze_id']][$adatom['kapcs_ossze_kapcs_tipus']][$adatom['kapcs_ossze_kapcs_id']]['kapcs_torzs_id']=$adatom['kapcs_torzs_id'];
  $eredmeny_keres[$adatom['kapcs_ossze_id']][$adatom['kapcs_ossze_kapcs_tipus']][$adatom['kapcs_ossze_kapcs_id']]['kapcs_torzs_nev']=$adatom['kapcs_torzs_nev'];
  $eredmeny_keres[$adatom['kapcs_ossze_id']][$adatom['kapcs_ossze_kapcs_tipus']][$adatom['kapcs_ossze_kapcs_id']]['tagv_kod']=$adatom['tagv_kod'];
 }
 return $eredmeny_keres;
}

function keres_admin_log_uj(){
$eredmeny_keres="";

//Talszám - eleje
$talszam=keres_talszam('admin_loglist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_loglist_keres_order','admin_loglist_keres_order_mod');
//Rendezés - vége

$where='';
$join1='';
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['user_nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['user_nev']!='')){
  if($where!="") $where.=" and ";
  $join1='left join mira_user ON mira_user.user_ad = mira_log.ment_ki_log_user_ad ';
  $where.="mira_user.user_nev like '".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['user_nev'])."%'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['mikor']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['mikor']!='')){
  if($where!="") $where.=" and ";
  $where.="mira_log.mikor = '".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['mikor'])."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat_elozmeny']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat_elozmeny']!='')){
  if($where!="") $where.=" and ";
  $where.="mira_log.log_adat_elozmeny like '%".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat_elozmeny'])."%'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat']!='')){
  if($where!="") $where.=" and ";
  $where.="mira_log.log_adat like '%".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['adat'])."%'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_mod']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_mod']!='all')){
  if($where!="") $where.=" and ";
  $where.="mira_log.log_mod = '".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_mod'])."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_muvelet']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_muvelet']!='')){
  if($where!="") $where.=" and ";
  $where.="mira_log.log_muvelet like '%".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['log_muvelet'])."%'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol']))and($_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol']!='')){
  if($where!="") $where.=" and ";
  $where.="(";
  $where.="(mira_log.log_hol like '%".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol'])."%')";
  $where.="or(mira_log.log_hol2 like '%".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol'])."%')";
  $where.="or(mira_log.log_hol3 like '%".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol'])."%')";
  $where.="or(mira_log.log_ertek like '%".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol'])."%')";
  $where.="or(mira_log.log_ertek2 like '%".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol'])."%')";
  $where.="or(mira_log.log_ertek3 like '%".mysqli_real_escape_string($GLOBALS['mysqli'],$_SESSION[$GLOBALS['sessionname']]['admin_log_keres']['hol'])."%')";
  $where.=")";
 }

if($where!="")$where=" where ".$where;

$sql1='SELECT
count(mira_log.log_id) as tal
from `mira_log`
'.$join1.$where.'';

 //print $sql."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }

$sql='SELECT mira_log.*, mira_user.user_nev
from `mira_log` 
left join mira_user ON mira_user.user_ad = mira_log.ment_ki_log_user_ad
'.$where.$sql_order.' limit '.$_POST['oldalholvagyok'].', '.$talszam;

 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}


function keres_admin_kapcsossze_uj(){
$eredmeny_keres="";
$where="";

//Talszám - eleje
$talszam=keres_talszam('admin_kapcsosszelist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_kapcsosszelist_keres_order','admin_kapcsosszelist_keres_order_mod');
$sql_order.=', kapcs_ossze.szolg_kod asc ';
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']!="all")){
  if($where!="") $where.=" and ";
  $where.="kapcs_ossze.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['tagv']."'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']!="all")){
  if($where!="") $where.=" and ";
  $where.="kapcs_ossze.szolg_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['szolg_kod']."'";
 }
 
 $join="";
 $group="";
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="(";
  $where.="(kapcs_torzs_mvms.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')or";
  $where.="(kapcs_torzs_sla.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')or";
  $where.="(kapcs_torzs_kapcs.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')or";
  $where.="(kapcs_torzs_kapcs.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcsosszelist_keres']['nev']."%')";
  $where.=")";
  
  $join="
  left join kapcs_torzs as kapcs_torzs_mvms ON kapcs_torzs_mvms.kapcs_torzs_id = kapcs_ossze.kapcs_ossze_kapcs_torzs_id_mvms 
  left join kapcs_torzs as kapcs_torzs_sla ON kapcs_torzs_sla.kapcs_torzs_id = kapcs_ossze.kapcs_ossze_kapcs_torzs_id_sla  
  left join kapcs_ossze_kapcs ON kapcs_ossze_kapcs.kapcs_ossze_id = kapcs_ossze.kapcs_ossze_id
  left join kapcs_torzs as kapcs_torzs_kapcs ON kapcs_torzs_kapcs.kapcs_torzs_id = kapcs_ossze_kapcs.kapcs_torzs_id
  ";
  $group=' group by kapcs_ossze.kapcs_ossze_id';
 }

 $sql1="";
 
 if($group!=''){
  $sql1.="SELECT COUNT(*) as tal FROM (";
  $sql1.="SELECT kapcs_ossze.kapcs_ossze_id ";
 }else{
  $sql1.="SELECT count(kapcs_ossze.kapcs_ossze_id) as tal ";
 }
 
 $sql1.="FROM `kapcs_ossze` 
 inner join mira_tagv_kod ON mira_tagv_kod.tagv_kod = kapcs_ossze.tagv_kod and mira_tagv_kod.tagv_kod_inaktiv='0'
 inner join mira_szolg_kod ON mira_szolg_kod.szolg_kod = kapcs_ossze.szolg_kod and mira_szolg_kod.szolg_kod_inaktiv='0' 
 ".$join;
 if($where!="") 
  $sql1.=" where ".$where;
 
 $sql1.=$group;
 if($group!=''){
  $sql1.=") t";
 }
 
 $sql="SELECT kapcs_ossze.*
 ,mira_tagv_kod.tagv_kod_adoszam
 ,mira_tagv_kod.tagv_kod_cim
 ,mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1
 ,mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_2
 ,mira_tagv_kod.tagv_kod_kapcs_torzs_id_kapcstarto
 FROM `kapcs_ossze` 
 inner join mira_tagv_kod ON mira_tagv_kod.tagv_kod = kapcs_ossze.tagv_kod and mira_tagv_kod.tagv_kod_inaktiv='0'
 inner join mira_szolg_kod ON mira_szolg_kod.szolg_kod = kapcs_ossze.szolg_kod and mira_szolg_kod.szolg_kod_inaktiv='0' 
 ".$join;
 if($where!="") 
  $sql.=" where ".$where;
 $sql.=$group;
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_tenypotlas_uj(){
$eredmeny_keres="";
$where="";

//Talszám - eleje
$talszam=keres_talszam('admin_tenypotlaslist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_tenypotlaslist_keres_order','admin_tenypotlaslist_keres_order_mod');
//Rendezés - vége

if($sql_order=='order by backup_tenypotlas.backup_tenypotlas_tagv asc'){
 $sql_order.=',backup_tenypotlas.backup_tenypotlas_szolg_kod asc';
 $sql_order.=',backup_tenypotlas_ev.backup_tenypotlas_ho asc';
}elseif($sql_order=='order by backup_tenypotlas.backup_tenypotlas_tagv desc'){
 $sql_order.=',backup_tenypotlas.backup_tenypotlas_szolg_kod desc';
 $sql_order.=',backup_tenypotlas_ev.backup_tenypotlas_ho desc';
}

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['tagv']!="")){
  if($where!="") $where.=" and ";
  $where.="backup_tenypotlas.backup_tenypotlas_tagv='".$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['tagv']."'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['szolg_kod']!="")){
  if($where!="") $where.=" and ";
  $where.="backup_tenypotlas.backup_tenypotlas_szolg_kod='".$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['szolg_kod']."'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ev']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ev']!="")){
  if($where!="") $where.=" and ";
  $where.="backup_tenypotlas.backup_tenypotlas_ev='".$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ev']."'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ev']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ev']!="")){
  if($where!="") $where.=" and ";
  $where.="backup_tenypotlas.backup_tenypotlas_ev='".$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ev']."'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ho']))and($_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ho']!="")){
  if($where!="") $where.=" and ";
  $where.="backup_tenypotlas.backup_tenypotlas_ho='".$_SESSION[$GLOBALS['sessionname']]['admin_tenypotlaslist_keres']['ho']."'";
 }

 $sql1="SELECT count(*) as tal
 FROM `backup_tenypotlas` 
 
 ";
 if($where!="") 
  $sql1.="where ".$where;
	 
 $sql="SELECT *
 FROM `backup_tenypotlas` ";
 if($where!="") 
  $sql.="where ".$where;
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_tervezes_uj(){
$eredmeny_keres="";
$where="";

//Talszám - eleje
$talszam=keres_talszam('admin_tervezeslist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_tervezeslist_keres_order','admin_tervezeslist_keres_order_mod');
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['tipus']))and($_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['tipus']!="all")){
  if($where!="") $where.=" and ";
  $where.="backup_terv_tipus.backup_terv_fo_tipus_id = '".$_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['tipus']."'";
 }

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['ev']))and($_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['ev']!="")){
  if($where!="") $where.=" and ";
  $where.="backup_terv_tipus.backup_terv_tipus_ev = '".$_SESSION[$GLOBALS['sessionname']]['admin_tervezeslist_keres']['ev']."'";
 }

 $sql1="SELECT count(backup_terv_tipus.backup_terv_tipus_id) as tal
 FROM `backup_terv_tipus` 
 
 ";
 if($where!="") 
  $sql1.="where ".$where;
	 
 $sql="SELECT 
 backup_terv_tipus.*
 ,backup_terv_fo_tipus_nev.backup_terv_fo_tipus
 ,backup_terv.backup_terv_id
 FROM `backup_terv_tipus` 
  left join backup_terv_fo_tipus_nev ON backup_terv_fo_tipus_nev.backup_terv_fo_tipus_id = backup_terv_tipus.backup_terv_fo_tipus_id
  left join backup_terv ON backup_terv.backup_terv_tipus_id = backup_terv_tipus.backup_terv_tipus_id
 ";
 if($where!="") 
  $sql.="where ".$where;
 $sql.=" group by backup_terv_tipus.backup_terv_tipus_id ";
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_kapcstorzs_uj(){
$eredmeny_keres="";
$where="";

//Talszám - eleje
$talszam=keres_talszam('admin_kapcstorzslist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_kapcstorzslist_keres_order','admin_kapcstorzslist_keres_order_mod');
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="kapcs_torzs.kapcs_torzs_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['nev']."%'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['tagv']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['tagv']!="all")){
  if($where!="") $where.=" and ";
  $where.="kapcs_torzs.tagv_kod = '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['tagv']."'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['beosztas']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['beosztas']!="")){
  if($where!="") $where.=" and ";
  $where.="kapcs_torzs.kapcs_torzs_beosztas like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['beosztas']."%'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['inaktiv']!="all")){
  if($where!="") $where.=" and ";
  $where.="kapcs_torzs.kapcs_torzs_inaktiv = '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcstorzslist_keres']['inaktiv']."'";
 }

 $sql1="SELECT count(kapcs_torzs.kapcs_torzs_id) as tal
 FROM `kapcs_torzs` 
 
 ";
 if($where!="") 
  $sql1.="where ".$where;
	 
 $sql="SELECT *
 FROM `kapcs_torzs` 
  
 ";
 if($where!="") 
  $sql.="where ".$where;
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_kapcstulaj_uj(){
$eredmeny_keres="";
$where="";

//Talszám - eleje
$talszam=keres_talszam('admin_kapcstulajlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_kapcstulajlist_keres_order','admin_kapcstulajlist_keres_order_mod');
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['kod']!="")){
  if($where!="") $where.=" and ";
  $where.="kapcs_tulaj.kapcs_tulaj_kod like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['kod']."%'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="kapcs_tulaj.kapcs_tulaj_nev like '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['nev']."%'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['inaktiv']!="all")){
  if($where!="") $where.=" and ";
  $where.="kapcs_tulaj.kapcs_tulaj_inaktiv = '".$_SESSION[$GLOBALS['sessionname']]['admin_kapcstulajlist_keres']['inaktiv']."'";
 }

 $sql1="SELECT count(kapcs_tulaj.kapcs_tulaj_kod) as tal
 FROM `kapcs_tulaj` 
 
 ";
 if($where!="") 
  $sql1.="where ".$where;
	 
 $sql="SELECT *
 FROM `kapcs_tulaj` 
  
 ";
 if($where!="") 
  $sql.="where ".$where;
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_tagvkod_uj(){
$eredmeny_keres="";
$where="";

//Talszám - eleje
$talszam=keres_talszam('admin_tagvkodlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_tagvkodlist_keres_order','admin_tagvkodlist_keres_order_mod');
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['tagv_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['tagv_kod']!="")){
  if($where!="") $where.=" and ";
  $where.="mira_tagv_kod.tagv_kod like '%".$_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['tagv_kod']."%'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="mira_tagv_kod.tagv_kod_nev like '%".$_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['nev']."%'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['inaktiv']!="all")){
  if($where!="") $where.=" and ";
  $where.="mira_tagv_kod.tagv_kod_inaktiv = '".$_SESSION[$GLOBALS['sessionname']]['admin_tagvkodlist_keres']['inaktiv']."'";
 }

 $join="
  left join kapcs_torzs as kapcs_torzs_vezeto_1 ON kapcs_torzs_vezeto_1.kapcs_torzs_id=mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1 
  left join kapcs_torzs as kapcs_torzs_vezeto_1_t ON kapcs_torzs_vezeto_1_t.kapcs_torzs_id=mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_1_t 
  left join kapcs_torzs as kapcs_torzs_vezeto_2 ON kapcs_torzs_vezeto_2.kapcs_torzs_id=mira_tagv_kod.tagv_kod_kapcs_torzs_id_vezeto_2
  left join kapcs_torzs as kapcs_torzs_kapcst ON kapcs_torzs_kapcst.kapcs_torzs_id=mira_tagv_kod.tagv_kod_kapcs_torzs_id_kapcstarto
  left join kapcs_tulaj ON kapcs_tulaj.kapcs_tulaj_kod = mira_tagv_kod.kapcs_tulaj_kod
 ";
 $mezo_sel="
 ,kapcs_torzs_vezeto_1.kapcs_torzs_nev as kapcs_torzs_vezeto_1_nev
 ,kapcs_torzs_vezeto_1_t.kapcs_torzs_nev as kapcs_torzs_vezeto_1_t_nev
 ,kapcs_torzs_vezeto_2.kapcs_torzs_nev as kapcs_torzs_vezeto_2_nev
 ,kapcs_torzs_kapcst.kapcs_torzs_nev as kapcs_torzs_kapcst_nev
 
 ,kapcs_torzs_vezeto_1.tagv_kod as kapcs_torzs_vezeto_1_tagv_kod
 ,kapcs_torzs_vezeto_1_t.tagv_kod as kapcs_torzs_vezeto_1_t_tagv_kod
 ,kapcs_torzs_vezeto_2.tagv_kod as kapcs_torzs_vezeto_2_tagv_kod 
 ,kapcs_torzs_kapcst.tagv_kod as kapcs_torzs_kapcst_tagv_kod 
 ,kapcs_tulaj.kapcs_tulaj_nev
";


 $sql1="SELECT count(mira_tagv_kod.tagv_kod) as tal
 FROM `mira_tagv_kod` 
 
 ";
 if($where!="") 
  $sql1.="where ".$where;
	 
 $sql="SELECT mira_tagv_kod.* ".$mezo_sel."
 FROM `mira_tagv_kod` 
 ".$join;
 if($where!="") 
  $sql.="where ".$where;
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_szolgkod_uj(){
$eredmeny_keres="";
$where="";

//Talszám - eleje
if((isset($_POST['admin_szolgkodlist_keres_talszam']))and($_POST['admin_szolgkodlist_keres_talszam']!="")){
 $admin_szolgkodlist_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['admin_szolgkodlist_keres_talszam']);
 
 if($_POST['admin_szolgkodlist_keres_talszam']<999999){//Excel export miatt
 //Ha változik, akkor le is kell menteni
 if($GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_talszam']!=$admin_szolgkodlist_keres_talszam){
   $tmp_mod[0]['projekt_projektlist_keres_talszam']=$admin_szolgkodlist_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
 //be is kell állítani.
 $GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_talszam']=$admin_szolgkodlist_keres_talszam;
 }
}else{
 $admin_szolgkodlist_keres_talszam=$GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_talszam'];
}
//Talszám - vége

//Rendezés - eleje
if((isset($_POST['order']))and($_POST['order']!="")){
 if($_POST['order']==$GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order']){
  //Ekkor mező marad, és desc->asc vagy fordítva
  if($GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order_mod']=="desc")
	  $GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order_mod']="asc";
  else
	  $GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order_mod']="desc";
  
  //Ekkor order_mod kell lemeteni
   $tmp_mod[0]['admin_szolgkodlist_keres_order_mod']=$GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order_mod'];
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);

 }else{//Ekkor a mező változott, rendezési mód marad
	$GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order']=$_POST['order'];
   
   //Le is kell menteni.
   $tmp_mod[0]['admin_szolgkodlist_keres_order']=$_POST['order'];
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
}
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['szolg_kod']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['szolg_kod']!="")){
  if($where!="") $where.=" and ";
  $where.="mira_szolg_kod.szolg_kod like '%".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['szolg_kod']."%'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="mira_szolg_kod.szolg_kod_nev like '%".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['nev']."%'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['inaktiv']!="all")){
  if($where!="") $where.=" and ";
  $where.="mira_szolg_kod.szolg_kod_inaktiv = '".$_SESSION[$GLOBALS['sessionname']]['admin_szolgkodlist_keres']['inaktiv']."'";
 }


 $sql1="SELECT count(mira_szolg_kod.szolg_kod) as tal
 FROM `mira_szolg_kod` 
 
 ";
 if($where!="") 
  $sql1.="where ".$where;
	 
 $sql="SELECT *
 FROM `mira_szolg_kod` 
  
 ";
 if($where!="") 
  $sql.="where ".$where;
 $sql.=" order by ".$GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order']." ".$GLOBALS['mira']['user_jog']['admin_szolgkodlist_keres_order_mod']." 
 limit ".$_POST['oldalholvagyok'].", ".$admin_szolgkodlist_keres_talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_munkanapuser(){
 $eredmeny_keres="";
 if(
 (!isset($_POST['limit']))
 or
 ($_POST['limit']=="10")
 ){
	$limit="10";
	if(
	(isset($_SESSION[$GLOBALS['sessionname']]['admin_munkanap_tal']))and
	($_SESSION[$GLOBALS['sessionname']]['admin_munkanap_tal']!=$limit)
	){
	 $_SESSION[$GLOBALS['sessionname']]['admin_munkanap_tal']=$limit;
	}
 }else{
	$limit=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['limit']);
	$_SESSION[$GLOBALS['sessionname']]['admin_munkanap_tal']=$limit;
 }
 $sql="SELECT munkanap_user.*,munkanap_user.user_ad,mira_user.user_nev
 FROM `munkanap_user` 
 inner join mira_user ON mira_user.user_ad = munkanap_user.user_ad 
 order by munkanap_user.munkanap DESC
  limit 0, ".$limit;
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_user_vane_rogzitve_napra($user_ad,$nap){
$eredmeny_keres="";
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$nap=mysqli_real_escape_string($GLOBALS['mysqli'],$nap);
 $sql="SELECT rogzit.rogzit_id
 FROM `rogzit` 
 left join rogzit_sor ON rogzit_sor.rogzit_id = rogzit.rogzit_id
 where rogzit.user_ad='".$user_ad."'
 and rogzit.rogzit_nap='".$nap."'
 and
 (
  (rogzit.tavollet='1')or
  (
   (rogzit.tavollet='0')and
   (rogzit_sor.rogzit_id is not null)
  )
 )
 ";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_katnev_uj(){
$eredmeny_keres="";
$where="";

//Talszám - eleje
$talszam=keres_talszam('admin_katnevlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_katnevlist_keres_order','admin_katnevlist_keres_order_mod');
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="projekt_kat.projekt_kat_nev like '%".$_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev']."%'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev_h']))and($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev_h']!="")){
  if($where!="") $where.=" and ";
  $where.="projekt_kat.projekt_kat_nev_h like '%".$_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['nev_h']."%'";
 }
 
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['inaktiv']!="all")){
  if($where!="") $where.=" and ";
  $where.="projekt_kat.projekt_kat_inaktiv = '".$_SESSION[$GLOBALS['sessionname']]['admin_katnevlist_keres']['inaktiv']."'";
 }

 $sql1="SELECT count(projekt_kat.projekt_kat_id) as tal
 FROM `projekt_kat` 
 
 ";
 if($where!="") 
  $sql1.="where ".$where;
	 
 $sql="SELECT *
 FROM `projekt_kat` 
  
 ";
 if($where!="") 
  $sql.="where ".$where;
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_lezathonapok(){
 $eredmeny_keres="";
 //WHERE `tagv` = '".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 $sql="SELECT tagv_lezart_honap 
 FROM `mira_tagv_lezart_honap`
";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['tagv_lezart_honap']]=1;
 }
 return $eredmeny_keres;
}

function keres_admin_csopnev_uj(){
$eredmeny_keres="";
$where="";

//Talszám - eleje
$talszam=keres_talszam('admin_csopnevlist_keres_talszam');
//Talszám - vége

//Rendezés - eleje
$sql_order=keres_order('admin_csopnevlist_keres_order','admin_csopnevlist_keres_order_mod');
//Rendezés - vége

 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['nev']))and($_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['nev']!="")){
  if($where!="") $where.=" and ";
  $where.="mira_szerv_csoport.mira_szerv_csoport_nev like '%".$_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['nev']."%'";
 }
 if((isset($_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['inaktiv']))and($_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['inaktiv']!="all")){
  if($where!="") $where.=" and ";
  $where.="mira_szerv_csoport.mira_szerv_csoport_inaktiv = '".$_SESSION[$GLOBALS['sessionname']]['admin_csopnevlist_keres']['inaktiv']."'";
 }

 $sql1="SELECT count(mira_szerv_csoport.mira_szerv_csoport_id) as tal
 FROM `mira_szerv_csoport` 
 
 ";
 if($where!="") 
  $sql1.="where ".$where;
	 
 $sql="SELECT *
 FROM `mira_szerv_csoport` 
  
 ";
 if($where!="") 
  $sql.="where ".$where;
 $sql.=" ".$sql_order." limit ".$_POST['oldalholvagyok'].", ".$talszam;
 
 //print $sql1."<br>";
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_admin_userhezprojekt($user_ad,$keress_projekt_nev,$csakvan){
$eredmeny_keres="";
$user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
$keress_projekt_nev=str_replace("*","%",mysqli_real_escape_string($GLOBALS['mysqli'],$keress_projekt_nev));
$csakvan=mysqli_real_escape_string($GLOBALS['mysqli'],$csakvan);

//Talszám - eleje
if((isset($_POST['user_projekthozza_keres_talszam']))and($_POST['user_projekthozza_keres_talszam']!="")){
 $user_projekthozza_keres_talszam=mysqli_real_escape_string($GLOBALS['mysqli'],$_POST['user_projekthozza_keres_talszam']);
 
 if($_POST['user_projekthozza_keres_talszam']<999999){//Excel export miatt
 if($GLOBALS['mira']['user_jog']['user_projekthozza_keres_talszam']!=$user_projekthozza_keres_talszam){
   $tmp_mod[0]['user_projekthozza_keres_talszam']=$user_projekthozza_keres_talszam;
   mod_egy_fel_tom('mira_user_ker_jog_admin',$tmp_mod[0],'user_ad',$_SESSION[$GLOBALS['sessionname']]['login_ad']);
 }
 
  //be is kell állítani.
 $GLOBALS['mira']['user_jog']['user_projekthozza_keres_talszam']=$user_projekthozza_keres_talszam;
 }
 
 }else{
 $user_projekthozza_keres_talszam=$GLOBALS['mira']['user_jog']['user_projekthozza_keres_talszam'];
}
//Talszám - vége

if(!isset($_POST['oldalholvagyok']))
 $_POST['oldalholvagyok']="0";

$limit_tol=$_POST['oldalholvagyok'];

$limit_ig=$user_projekthozza_keres_talszam;

//Talszám - eleje
$sql1="SELECT count(projekt.projekt_id) as tal
 FROM `projekt` ";
 if($csakvan==1)
  $sql1.=" inner join projekt_user ON projekt_user.projekt_id = projekt.projekt_id 
  and projekt_user.user_ad='".$user_ad."'";
 
 $sql1.=" where ";
 //$sql1.=" projekt.projekt_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 $sql1.="projekt.projekt_inaktiv='0'";
 
 if($keress_projekt_nev!="")//Csak ha rákerestek bármire
  $sql1.=" and projekt.projekt_nev like '".$keress_projekt_nev."%'";
//Talszám - vége

//Teljes keresés
$sql="SELECT projekt.projekt_id,projekt.projekt_nev
 FROM `projekt` ";
 
 if($csakvan==1)
  $sql.=" inner join projekt_user ON projekt_user.projekt_id = projekt.projekt_id 
  and projekt_user.user_ad='".$user_ad."'";
 
 $sql.=" where ";
 //$sql.=" projekt.projekt_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and ";
 $sql.="projekt.projekt_inaktiv='0'";
 
 if($keress_projekt_nev!="")//Csak ha rákerestek bármire
  $sql.=" and projekt.projekt_nev like '".$keress_projekt_nev."%'";

 $sql.=" order by projekt.projekt_nev ASC
 limit ".$limit_tol.", ".$limit_ig;
 
 //print $sql."<br>";exit;
 $adat1=mysqli_query($GLOBALS['mysqli'],$sql1);
 while($adatom1=mysqli_fetch_assoc($adat1)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom1;
 }
 
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_userprojekt_user_osszes_tevekenyseg($user_ad,$szerv_id){
 $eredmeny_keres="";
 $szerv_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerv_id);
 $user_ad=mysqli_real_escape_string($GLOBALS['mysqli'],$user_ad);
 //projekt.projekt_tagv='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and 
 $sql="SELECT projekt.projekt_nev
FROM `projekt`
left join projekt_szerv on projekt_szerv.projekt_id = projekt.projekt_id 
left join projekt_user on projekt_user.projekt_id = projekt.projekt_id 
WHERE 

projekt.projekt_inaktiv='0' and
(
 (projekt_szerv.szerv_id='".$szerv_id."')or
 (projekt_user.user_ad='".$user_ad."')
)
group by projekt.projekt_id 
order by projekt.projekt_nev asc";
 //print $sql."<br>";exit;
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

/*
function keres_user_akt_nevlike($user_nev){
 $eredmeny_keres="";
 $user_nev=mysqli_real_escape_string($GLOBALS['mysqli'],$user_nev);
 $sql="SELECT user_ad 
 FROM `mira_user`
 where `user_nev` like '".$user_nev."%' 
 and `user_tagv` ='".$_SESSION[$GLOBALS['sessionname']]['tagv']."'
 and `user_inaktiv`='0'";
 //print $sql."<br>";
 $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['user_ad']]=1;
 }
 return $eredmeny_keres;
}
*/

function keres_akt_szerv_abc_uj_userhez(){
 $eredmeny_keres="";
 // `szerv_tagv`='".$_SESSION[$GLOBALS['sessionname']]['tagv']."' and 
 $sql="SELECT szerv_id,szerv_nev 
 FROM `mira_szerv` 
 where 

 `szerv_inaktiv`='0'
 order by szerv_nev asc";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_szerv_jovahagyok_adat(){
 $eredmeny_keres="";
$sql="
SELECT mira_szerv.szerv_nev, mira_user.user_nev, mira_user.user_ad
,mira_user.ful_jovahagy
FROM `mira_szerv_jovahagyo`
LEFT JOIN mira_user ON mira_user.user_ad = mira_szerv_jovahagyo.user_ad
LEFT JOIN mira_szerv ON mira_szerv.szerv_id = mira_szerv_jovahagyo.szerv_id
WHERE mira_user.user_inaktiv = '0'
AND mira_szerv.szerv_inaktiv = '0'
order by mira_szerv.szerv_nev ASC
";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}


function keres_szerv_user_felettes_adat(){
 $eredmeny_keres="";
$sql="
SELECT 
mira_user_kinek.user_nev,
mira_user_kinek.user_ad,
mira_user_ki.user_nev as user_nev_ki,
mira_user_ki.user_ad as user_ad_ki,
mira_user_ki.ful_jovahagy
FROM `mira_user_felettes_jovahagyo`
left join mira_user AS mira_user_kinek ON mira_user_felettes_jovahagyo.user_ad = mira_user_kinek.user_ad

left join mira_user AS mira_user_ki ON mira_user_felettes_jovahagyo.user_ad_felettes_jovahagyo = mira_user_ki.user_ad
WHERE mira_user_kinek.user_inaktiv = '0'
order by mira_user_kinek.user_nev ASC
";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

/*
function keres_tagv_kapcsolattartok_nev($tagv_kod){
 $eredmeny_keres="";
 $tagv_kod=mysqli_real_escape_string($GLOBALS['mysqli'],$tagv_kod);
 $sql="SELECT kapcs_torzs.kapcs_torzs_id,kapcs_torzs.kapcs_torzs_nev
 FROM `kapcs_torzs` 
 where 
 kapcs_torzs.tagv_kod='".$tagv_kod."' 
 order by kapcs_torzs.kapcs_torzs_nev asc";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}
*/

function keres_tagv_kapcsolattartok_nev_all(){
 $eredmeny_keres="";
 $sql="SELECT 
 kapcs_torzs.kapcs_torzs_id,kapcs_torzs.kapcs_torzs_nev
 ,kapcs_torzs.tagv_kod
 FROM `kapcs_torzs` 
 where 
 kapcs_torzs.kapcs_torzs_inaktiv='0' 
 order by kapcs_torzs.kapcs_torzs_nev asc";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[$adatom['kapcs_torzs_id']]['kapcs_torzs_nev']=$adatom['kapcs_torzs_nev'];
  $eredmeny_keres[$adatom['kapcs_torzs_id']]['tagv_kod']=$adatom['tagv_kod'];
 }
 return $eredmeny_keres;
}


function keres_ment_vane_dupla_szolgkod_nincsvege($szerz_id,$szerz_csop_id,$szolg_kod){
 $eredmeny_keres="";
 $szerz_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_id);
 $szerz_csop_id=mysqli_real_escape_string($GLOBALS['mysqli'],$szerz_csop_id);
 $szolg_kod=mysqli_real_escape_string($GLOBALS['mysqli'],$szolg_kod);
 $sql="SELECT szerz_tetel_adat.szerz_tetel_adat_id 
 FROM `szerz_tetel_adat` 
 inner join szerz_tetel ON szerz_tetel.szerz_tetel_id = szerz_tetel_adat.szerz_tetel_id
 where 
 szerz_tetel_adat.szerz_tetel_akt='1' and 
 szerz_tetel_adat.szerz_id='".$szerz_id."' and 
 szerz_tetel_adat.szerz_csop_id='".$szerz_csop_id."' and 
 szerz_tetel_adat.szolg_kod='".$szolg_kod."' and 
 szerz_tetel.szerz_tetel_vege='0'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom['szerz_tetel_adat_id'];
 }
 return $eredmeny_keres;
}

function keres_mit3($tabla_nev,$hol,$mire,$hol2,$mire2,$hol3,$mire3){
 $eredmeny_keres="";
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $mire2=mysqli_real_escape_string($GLOBALS['mysqli'],$mire2);
 $mire3=mysqli_real_escape_string($GLOBALS['mysqli'],$mire3);
 $sql="SELECT * FROM `$tabla_nev` where `$hol`='$mire' and `$hol2`='$mire2' and `$hol3`='$mire3'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 return $eredmeny_keres;
}

function keres_mit3_mit1_csak_ertek($tabla_nev,$hol,$mire,$hol2,$mire2,$hol3,$mire3,$mit){
 $eredmeny_keres="";
 $mit=mysqli_real_escape_string($GLOBALS['mysqli'],$mit);
 $mire=mysqli_real_escape_string($GLOBALS['mysqli'],$mire);
 $mire2=mysqli_real_escape_string($GLOBALS['mysqli'],$mire2);
 $mire3=mysqli_real_escape_string($GLOBALS['mysqli'],$mire3);
 $sql="SELECT $mit FROM `$tabla_nev` where `$hol`='$mire' and `$hol2`='$mire2' and `$hol3`='$mire3'";
 //print $sql."<br>";
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres=$adatom[$mit];
 }
 return $eredmeny_keres;
}

function mod_egy_fel_tom3($tabla,$tomb,$where_hol,$where_mi,$where_hol2,$where_mi2,$where_hol3,$where_mi3){

log_ment('mod',$tabla,$tomb,$where_hol,$where_mi,$where_hol2,$where_mi2,$where_hol3,$where_mi3);

$where_mi=mysqli_real_escape_string($GLOBALS['mysqli'],$where_mi);
$where_mi2=mysqli_real_escape_string($GLOBALS['mysqli'],$where_mi2);
$where_mi3=mysqli_real_escape_string($GLOBALS['mysqli'],$where_mi3);
$sql="UPDATE `".$tabla."` SET ";
$i=0;
foreach($tomb as $a => $b)
{
if($i>0)
 $sql.=", ";
$i++;
$a=mysqli_real_escape_string($GLOBALS['mysqli'],$a);
if($b!==null)
 $sql.="`".$a."` ='".mysqli_real_escape_string($GLOBALS['mysqli'],strip_tags(str_replace('`'," ",str_replace('"'," ",str_replace("'"," ",$b)))))."' ";
else
 $sql.="`".$a."` = null ";	
}
$sql.="WHERE `".$where_hol."`='".$where_mi."' and `".$where_hol2."`='".$where_mi2."' and `".$where_hol3."`='".$where_mi3."'";
//echo $sql."<br>";
//exit;
	if(mysqli_query($GLOBALS['mysqli'],$sql))
	{
	 //print "<br>Módosítás sikeres";
	} else {
	echo"<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
	echo("<br>MySQL error: ".mysqli_errno($GLOBALS['mysqli']).", ".mysqli_error($GLOBALS['mysqli'])."<br>in sql: ".$sql);
	exit;
	}

}
?>