<?php

?>

function admin_ujpenznem(){
var penznem=encodeURIComponent($("#admin_ujpenznem_penznem").val());
var penznem_nev=encodeURIComponent($("#admin_ujpenznem_penznem_nev").val());

if(penznem==""){
 diaglog_open("Hiba!<br><br>Devizanem kódja kitöltése kötelező!","Hiba","hiba");
}else if(penznem_nev==""){
 diaglog_open("Hiba!<br><br>Devizanem neve kitöltése kötelező!","Hiba","hiba");
}else{
 admin_ujpenznem_ment(penznem,penznem_nev);
}
}

var ajax_keres_admin_ujpenznem_ment=null;
function admin_ujpenznem_ment(penznem,penznem_nev){

if(ajax_keres_admin_ujpenznem_ment!=null){
 ajax_keres_admin_ujpenznem_ment.abort();
}

ajax_keres_admin_ujpenznem_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujpenznem_ment&penznem="+penznem+"&penznem_nev="+penznem_nev,
	function(d){
	ajax_keres_admin_ujpenznem_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba");	
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_penznemlist_keres_par(){
var penznem=encodeURIComponent($("#admin_tigadatpenznemlist_keres_penznem").val());
var ev=encodeURIComponent($("#admin_tigadatpenznemlist_keres_ev").val());
var par="&penznem="+penznem+"&ev="+ev;
return par;
}

var admin_penznemlist_keres_fo_wait="";
function admin_tigadatpenznemlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_penznemlist_keres_fo_wait);
  admin_penznemlist_keres_fo_wait = setTimeout(function(){admin_tigadatpenznemlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_penznemlist_keres_proc=null;
function admin_tigadatpenznemlist_keres_proc(id_honnan,hol_lep){
//var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_penznemlist");
var par=admin_penznemlist_keres_par();

if(ajax_admin_penznemlist_keres_proc!=null){
 ajax_admin_penznemlist_keres_proc.abort();
}

ajax_admin_penznemlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_penznemlist_keres"+par,
	function(d){
	ajax_admin_penznemlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_tigadatpenznem_list_keres_tal").html(d1[1]);
	 //alap_input_select_most();
	 number_only();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}


var admin_modpenznem_nevment_fo_wait="";
function admin_modpenznem_nevment(penznem){
  clearTimeout(admin_modpenznem_nevment_fo_wait);
  admin_modpenznem_nevment_fo_wait = setTimeout(function(){admin_modpenznem_nevment_proc(penznem);},100);
}

var ajax_keres_admin_modpenznem_nevment_proc=null;
function admin_modpenznem_nevment_proc(penznem){

var penznem_nev=encodeURIComponent($("#admin_modelsztipus_tipusnev_"+penznem).val());

if(ajax_keres_admin_modpenznem_nevment_proc!=null){
 ajax_keres_admin_modpenznem_nevment_proc.abort();
}

ajax_keres_admin_modpenznem_nevment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modpenznem_nevment&penznem="+encodeURIComponent(penznem)+"&penznem_nev="+penznem_nev,
	function(d){
	ajax_keres_admin_modpenznem_nevment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modpenznem_arfolyamment_fo_wait="";
function admin_modpenznem_arfolyamment(penznem,ev,ho){
  clearTimeout(admin_modpenznem_arfolyamment_fo_wait);
  admin_modpenznem_arfolyamment_fo_wait = setTimeout(function(){admin_modpenznem_arfolyamment_proc(penznem,ev,ho);},100);
}

var ajax_keres_admin_modpenznem_nevment_proc=null;
function admin_modpenznem_arfolyamment_proc(penznem,ev,ho){
if(ho<10){
 var arfolyam_date=ev+'-0'+ho+'_01';
}else{
 var arfolyam_date=ev+'-'+ho+'_01';
}

var arfolyam_ert=encodeURIComponent($("#admin_modpenznem_arfolyam_"+penznem+"_"+ev+"-"+ho).val());

if(ajax_keres_admin_modpenznem_nevment_proc!=null){
 ajax_keres_admin_modpenznem_nevment_proc.abort();
}

ajax_keres_admin_modpenznem_nevment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modpenznem_arfolyamment&penznem="+encodeURIComponent(penznem)+"&arfolyam_date="+arfolyam_date+"&arfolyam_ert="+arfolyam_ert,
	function(d){
	ajax_keres_admin_modpenznem_nevment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
