<?php

?>

function admin_ujcsopnev(){
var csopnev=encodeURIComponent($("#admin_ujcsopnev_csopnev").val());

if(csopnev==""){
 diaglog_open("Csoportosítási név kitöltése kötelező!","Hiba");
}else{
 admin_ujcsopnev_ment(csopnev);
}
}

var ajax_keres_admin_ujcsopnev_ment=null;
function admin_ujcsopnev_ment(csopnev){
$("#admin_ujcsopnev_submit").prop("disabled",true);

if(ajax_keres_admin_ujcsopnev_ment!=null){
 ajax_keres_admin_ujcsopnev_ment.abort();
}

ajax_keres_admin_ujcsopnev_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujcsopnev_ment&csopnev="+csopnev,
	function(d){
	ajax_keres_admin_ujcsopnev_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_csopnevlist_keres_par(){
var nev=encodeURIComponent($("#admin_csopnevlist_keres_nev").val());
var inaktiv=encodeURIComponent($("#admin_csopnevlist_keres_inaktiv").val());
var par="&nev="+nev+"&inaktiv="+inaktiv;
return par;
}

var admin_csopnevlist_keres_fo_wait="";
function admin_csopnevlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_csopnevlist_keres_fo_wait);
  admin_csopnevlist_keres_fo_wait = setTimeout(function(){admin_csopnevlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_admin_csopnevlist_keres_proc=null;
function admin_csopnevlist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_csopnevlist_keres_tal_oldalholvagyok","admin_csopnevlist_keres_tal_oldalmax","admin_csopnevlist_keres_talszam","admin_csopnevlist_keres_proc");
var par=admin_csopnevlist_keres_par();

if(ajax_keres_admin_csopnevlist_keres_proc!=null){
 ajax_keres_admin_csopnevlist_keres_proc.abort();
}

ajax_keres_admin_csopnevlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_csopnevlist_keres"+ker_par+par,
	function(d){
	ajax_keres_admin_csopnevlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_csop_nev_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modcsopnev_ment_fo_wait="";
function admin_modcsopnev_ment(csoport_id){
  clearTimeout(admin_modcsopnev_ment_fo_wait);
  admin_modcsopnev_ment_fo_wait = setTimeout(function(){admin_modcsopnev_ment_proc(csoport_id);},100);
}

var ajax_keres_admin_modcsopnev_ment_proc=null;
function admin_modcsopnev_ment_proc(csoport_id){

if(ajax_keres_admin_modcsopnev_ment_proc!=null){
 ajax_keres_admin_modcsopnev_ment_proc.abort();
}

var nev=encodeURIComponent($("#admin_ujcsopnevmod_nev_"+csoport_id).val());

ajax_keres_admin_modcsopnev_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modcsopnev_ment&csoport_id="+encodeURIComponent(csoport_id)+"&nev="+nev,
	function(d){
	ajax_keres_admin_modcsopnev_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_keres_admin_modcsopnev_inaktiv=null;
function admin_modcsopnev_inaktiv(csoport_id){
if($("#admin_ujcsopnevmod_inaktiv_"+csoport_id).prop("checked")){
 var inaktiv=1;
}else{
 var inaktiv=0;
}

if(ajax_keres_admin_modcsopnev_inaktiv!=null){
 ajax_keres_admin_modcsopnev_inaktiv.abort();
}

ajax_keres_admin_modcsopnev_inaktiv=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modcsopnev_inaktiv&csoport_id="+encodeURIComponent(csoport_id)+"&inaktiv="+inaktiv,
	function(d){
	ajax_keres_admin_modcsopnev_inaktiv=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_csopnevlist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
