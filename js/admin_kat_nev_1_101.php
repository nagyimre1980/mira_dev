<?php

?>

function admin_ujkatnev(){
var katnev=encodeURIComponent($("#admin_ujkatnev_katnev").val());
var katnev_h=encodeURIComponent($("#admin_ujkatnev_katnev_h").val());

if(katnev==""){
 diaglog_open("Önköltség kategória kód kitöltése kötelező!","Hiba");
}else if(katnev_h==""){
 diaglog_open("Önköltség kategória név kitöltése kötelező!","Hiba");
}else{
 admin_ujkatnev_ment(katnev,katnev_h);
}
}

var ajax_keres_admin_ujkatnev_ment=null;
function admin_ujkatnev_ment(katnev,katnev_h){
$("#admin_ujkatnev_submit").prop("disabled",true);

if(ajax_keres_admin_ujkatnev_ment!=null){
 ajax_keres_admin_ujkatnev_ment.abort();
}

ajax_keres_admin_ujkatnev_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujkatnev_ment&katnev="+katnev+"&katnev_h="+katnev_h,
	function(d){
	ajax_keres_admin_ujkatnev_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_katnevlist_keres_par(){
var nev=encodeURIComponent($("#admin_katnevlist_keres_nev").val());
var nev_h=encodeURIComponent($("#admin_katnevlist_keres_nev_h").val());
var inaktiv=encodeURIComponent($("#admin_katnevlist_keres_inaktiv").val());
var par="&nev="+nev+"&nev_h="+nev_h+"&inaktiv="+inaktiv;
return par;
}

var admin_katnevlist_keres_fo_wait="";
function admin_katnevlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_katnevlist_keres_fo_wait);
  admin_katnevlist_keres_fo_wait = setTimeout(function(){admin_katnevlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_admin_katnevlist_keres_proc=null;
function admin_katnevlist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_katnevlist_keres_tal_oldalholvagyok","admin_katnevlist_keres_tal_oldalmax","admin_katnevlist_keres_talszam","admin_katnevlist_keres_proc");
var par=admin_katnevlist_keres_par();

if(ajax_keres_admin_katnevlist_keres_proc!=null){
 ajax_keres_admin_katnevlist_keres_proc.abort();
}

ajax_keres_admin_katnevlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_katnevlist_keres"+ker_par+par,
	function(d){
	ajax_keres_admin_katnevlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_kat_nev_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modkatnev_ment_fo_wait="";
function admin_modkatnev_ment(kat_id){
  clearTimeout(admin_modkatnev_ment_fo_wait);
  admin_modkatnev_ment_fo_wait = setTimeout(function(){admin_modkatnev_ment_proc(kat_id);},100);
}

var ajax_keres_admin_modkatnev_ment_proc=null;
function admin_modkatnev_ment_proc(kat_id){

if(ajax_keres_admin_modkatnev_ment_proc!=null){
 ajax_keres_admin_modkatnev_ment_proc.abort();
}

var nev=encodeURIComponent($("#admin_ujkatnevmod_nev_"+kat_id).val());
var nev_h=encodeURIComponent($("#admin_ujkatnevmod_nevh_"+kat_id).val());

ajax_keres_admin_modkatnev_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkatnev_ment&kat_id="+encodeURIComponent(kat_id)+"&nev="+nev+"&nev_h="+nev_h,
	function(d){
	ajax_keres_admin_modkatnev_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_keres_admin_modkatnev_inaktiv=null;
function admin_modkatnev_inaktiv(kat_id){
if($("#admin_ujkatnevmod_inaktiv_"+kat_id).prop("checked")){
 var inaktiv=1;
}else{
 var inaktiv=0;
}

if(ajax_keres_admin_modkatnev_inaktiv!=null){
 ajax_keres_admin_modkatnev_inaktiv.abort();
}

ajax_keres_admin_modkatnev_inaktiv=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkatnev_inaktiv&kat_id="+encodeURIComponent(kat_id)+"&inaktiv="+inaktiv,
	function(d){
	ajax_keres_admin_modkatnev_inaktiv=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_katnevlist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
