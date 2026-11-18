<?php

?>


function admin_tigadatsapszamlist_keres_par(){
var tagv_kod=encodeURIComponent($("#admin_tigadatsapszamlist_keres_tagv").val());
var szerz_keret=encodeURIComponent($("#admin_tigadatsapszamlist_keres_szerzkeret").val());
var szerztipusid=encodeURIComponent($("#admin_tigadatsapszamlist_keres_szerztipusid").val());
var sapszam=encodeURIComponent($("#admin_tigadatsapszamlist_keres_sapszam").val());
var par="&tagv_kod="+tagv_kod+"&szerz_keret="+szerz_keret+"&szerztipusid="+szerztipusid+"&sapszam="+sapszam;
return par;
}

var admin_tigadatsapszamlist_keres_fo_wait="";
function admin_tigadatsapszamlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_tigadatsapszamlist_keres_fo_wait);
  admin_tigadatsapszamlist_keres_fo_wait = setTimeout(function(){admin_tigadatsapszamlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_tigadatsapszamlist_keres_proc=null;
function admin_tigadatsapszamlist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_tigadatsapszamlist");
var par=admin_tigadatsapszamlist_keres_par();

if(ajax_admin_tigadatsapszamlist_keres_proc!=null){
 ajax_admin_tigadatsapszamlist_keres_proc.abort();
}

ajax_admin_tigadatsapszamlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tigadatsapszamlist_keres"+ker_par+par,
	function(d){
	ajax_admin_tigadatsapszamlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_tigadatsapszam_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modtigadatsapszam_ment_fo_wait="";
function admin_modtigadatsapszam_ment(szerz_id){
  clearTimeout(admin_modtigadatsapszam_ment_fo_wait);
  admin_modtigadatsapszam_ment_fo_wait = setTimeout(function(){admin_modtigadatsapszam_ment_proc(szerz_id);},100);
}

var ajax_keres_admin_modtigadatsapszam_ment_proc=null;
function admin_modtigadatsapszam_ment_proc(szerz_id){

if(ajax_keres_admin_modtigadatsapszam_ment_proc!=null){
 ajax_keres_admin_modtigadatsapszam_ment_proc.abort();
}

var sapszam=encodeURIComponent($("#admin_modtigadatsapszam_sapszam_"+szerz_id).val());

ajax_keres_admin_modtigadatsapszam_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modtigadatsapszam_ment&szerz_id="+encodeURIComponent(szerz_id)+"&sapszam="+sapszam,
	function(d){
	ajax_keres_admin_modtigadatsapszam_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){

	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
