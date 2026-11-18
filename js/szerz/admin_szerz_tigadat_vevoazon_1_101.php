<?php

?>

function admin_tigadatvevoazonlist_keres_par(){
var tagv_kod=encodeURIComponent($("#admin_tigadatvevoazonlist_keres_tagv").val());
var par="&tagv_kod="+tagv_kod;
return par;
}

var ajax_admin_tigadatvevoazonlist_keres_proc=null;
function admin_tigadatvevoazonlist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_tigadatvevoazonlist");
var par=admin_tigadatvevoazonlist_keres_par();

if(ajax_admin_tigadatvevoazonlist_keres_proc!=null){
 ajax_admin_tigadatvevoazonlist_keres_proc.abort();
}

ajax_admin_tigadatvevoazonlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tigadatvevoazonlist_keres"+ker_par+par,
	function(d){
	ajax_admin_tigadatvevoazonlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_tigadatvevoazon_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modtigadatvevoazon_ment_fo_wait="";
function admin_modtigadatvevoazon_ment(tagv_kod){
  clearTimeout(admin_modtigadatvevoazon_ment_fo_wait);
  admin_modtigadatsapszamadmin_modtigadatvevoazon_ment_fo_wait_ment_fo_wait = setTimeout(function(){admin_modtigadatvevoazon_ment_proc(tagv_kod);},100);
}

var ajax_keres_admin_modtigadatvevoazon_ment_proc=null;
function admin_modtigadatvevoazon_ment_proc(tagv_kod){
	
if(ajax_keres_admin_modtigadatvevoazon_ment_proc!=null){
 ajax_keres_admin_modtigadatvevoazon_ment_proc.abort();
}

var vevoazon=encodeURIComponent($("#admin_modtigadatvevoazon_vevoazon_"+tagv_kod).val());

ajax_keres_admin_modtigadatvevoazon_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modtigadatvevoazon_ment&tagv_kod="+encodeURIComponent(tagv_kod)+"&vevoazon="+vevoazon,
	function(d){
	ajax_keres_admin_modtigadatvevoazon_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){

	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

