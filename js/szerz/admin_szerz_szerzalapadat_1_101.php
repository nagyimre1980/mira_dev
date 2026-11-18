<?php

?>

function admin_ujszerzalapadat(){
var tagv_kod=encodeURIComponent($("#admin_ujszerzalapadat_tagvkod").val());
var szerz_keret=encodeURIComponent($("#admin_ujszerzalapadat_szerzkeret").val());
var szerz_tipus_id=encodeURIComponent($("#admin_ujszerzalapadat_szerztipusid").val());
var szerz_date_hatalybelep=encodeURIComponent($("#admin_ujszerzalapadat_datehatalybelep").val());
var megj=encodeURIComponent($("#admin_ujszerzalapadat_megj").val());

if(tagv_kod=="keremv" || szerz_keret=="keremv" || szerz_tipus_id=="keremv" || szerz_date_hatalybelep==''){
 diaglog_open("Hiba!<br><br>Nincs minden kötelező mező kitöltve!","Hiba","del_behajtani16.png");
}else{
 admin_ujszerzalapadat_ment(tagv_kod,szerz_keret,szerz_tipus_id,szerz_date_hatalybelep,megj);
}
}

var ajax_keres_admin_ujszerzalapadat_ment=null;
function admin_ujszerzalapadat_ment(tagv_kod,szerz_keret,szerz_tipus_id,szerz_date_hatalybelep,megj){
if(ajax_keres_admin_ujszerzalapadat_ment!=null){
 ajax_keres_admin_ujszerzalapadat_ment.abort();
}

ajax_keres_admin_ujszerzalapadat_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujszerzalapadat_ment&tagv_kod="+tagv_kod+"&szerz_keret="+szerz_keret+"&szerz_tipus_id="+szerz_tipus_id+"&szerz_date_hatalybelep="+szerz_date_hatalybelep+"&megj="+megj,
	function(d){
	ajax_keres_admin_ujszerzalapadat_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba",'hiba');	
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_szerzalapadatlist_keres_par(){
var tagv_kod=encodeURIComponent($("#admin_szerzalapadatlist_keres_tagv").val());
var szerz_keret=encodeURIComponent($("#admin_szerzalapadatlist_keres_szerzkeret").val());
var szerztipusid=encodeURIComponent($("#admin_szerzalapadatlist_keres_szerztipusid").val());
var sapszam=encodeURIComponent($("#admin_szerzalapadatlist_keres_sapszam").val());
var par="&tagv_kod="+tagv_kod+"&szerz_keret="+szerz_keret+"&szerztipusid="+szerztipusid+"&sapszam="+sapszam;
return par;
}

var admin_szerzalapadatlist_keres_fo_wait="";
function admin_szerzalapadatlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_szerzalapadatlist_keres_fo_wait);
  admin_szerzalapadatlist_keres_fo_wait = setTimeout(function(){admin_szerzalapadatlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_szerzalapadatlist_keres_proc=null;
function admin_szerzalapadatlist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_szerzalapadatlist_keres_tal_oldalholvagyok","admin_szerzalapadatlist_keres_tal_oldalmax","admin_szerzalapadatlist_keres_talszam","admin_szerzalapadatlist_keres_proc");
var par=admin_szerzalapadatlist_keres_par();

if(ajax_admin_szerzalapadatlist_keres_proc!=null){
 ajax_admin_szerzalapadatlist_keres_proc.abort();
}

ajax_admin_szerzalapadatlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szerzalapadatlist_keres"+ker_par+par,
	function(d){
	ajax_admin_szerzalapadatlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_szerzalapadat_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modszerzalapadat_ment_fo_wait="";
function admin_modszerzalapadat_ment(szerz_id){
  clearTimeout(admin_modszerzalapadat_ment_fo_wait);
  admin_modszerzalapadat_ment_fo_wait = setTimeout(function(){admin_modszerzalapadat_ment_proc(szerz_id);},100);
}

var ajax_keres_admin_modszerzalapadat_ment_proc=null;
function admin_modszerzalapadat_ment_proc(szerz_id){

if(ajax_keres_admin_modszerzalapadat_ment_proc!=null){
 ajax_keres_admin_modszerzalapadat_ment_proc.abort();
}

var szerz_keret=encodeURIComponent($("#admin_modszerzalapadat_szerzkeret_"+szerz_id).val());
var szerz_tipus_id=encodeURIComponent($("#admin_modszerzalapadat_tipusid_"+szerz_id).val());
var szerz_date_hatalybelep=encodeURIComponent($("#admin_modszerzalapadat_datehatalybelep_"+szerz_id).val());
var megj=encodeURIComponent($("#admin_modszerzalapadat_megj_"+szerz_id).val());

ajax_keres_admin_modszerzalapadat_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszerzalapadat_ment&szerz_id="+encodeURIComponent(szerz_id)+"&szerz_keret="+szerz_keret+"&szerz_tipus_id="+szerz_tipus_id+"&szerz_date_hatalybelep="+szerz_date_hatalybelep+"&megj="+megj,
	function(d){
	ajax_keres_admin_modszerzalapadat_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

