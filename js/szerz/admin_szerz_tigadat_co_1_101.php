<?php

?>

function admin_tigadatcolist_keres_par(){
//var szerz_id=encodeURIComponent($("#admin_szolgkapadatlist_keres_szerzid").val());
//var par="&szerz_id="+szerz_id;
var mire1=encodeURIComponent($("#admin_tigadatcolist_keres_mire1").val());
var mit1=encodeURIComponent($("#admin_tigadatcolist_keres_mit1").val());
var mit1_value=encodeURIComponent($("#admin_tigadatcolist_keres_mit1 option:selected").text());

var mire2=encodeURIComponent($("#admin_tigadatcolist_keres_mire2").val());
var mit2=encodeURIComponent($("#admin_tigadatcolist_keres_mit2").val());
var mit2_value=encodeURIComponent($("#admin_tigadatcolist_keres_mit2 option:selected").text());

var mire3=encodeURIComponent($("#admin_tigadatcolist_keres_mire3").val());
var mit3=encodeURIComponent($("#admin_tigadatcolist_keres_mit3").val());
var mit3_value=encodeURIComponent($("#admin_tigadatcolist_keres_mit3 option:selected").text());

var szerz_tetel_id=encodeURIComponent($("#admin_szolgkapadatlist_keres_szerztetelid").val());
var co=encodeURIComponent($("#admin_szolgkapadatlist_keres_co").val());

/*if($("#admin_szolgkapadatlist_keres_akt").prop('checked')){
 var akt='1';
}else{
 var akt='0';
}*/

var par="&mire1="+mire1+"&mit1="+mit1+"&mire2="+mire2+"&mit2="+mit2+"&mire3="+mire3+"&mit3="+mit3+"&szerz_tetel_id="+szerz_tetel_id+"&co="+co;//+"&akt="+akt
par+="&mit1_value="+mit1_value+"&mit2_value="+mit2_value+"&mit3_value="+mit3_value;
return par;
}

var admin_tigadatcolist_keres_fo_wait="";
function admin_tigadatcolist_keres(id_honnan,hol_lep){
  clearTimeout(admin_tigadatcolist_keres_fo_wait);
  admin_tigadatcolist_keres_fo_wait = setTimeout(function(){admin_tigadatcolist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_tigadatcolist_keres_proc=null;
function admin_tigadatcolist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_tigadatcolist");
var par=admin_tigadatcolist_keres_par();

if(ajax_admin_tigadatcolist_keres_proc!=null){
 ajax_admin_tigadatcolist_keres_proc.abort();
}

ajax_admin_tigadatcolist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tigadatcolist_keres"+ker_par+par,
	function(d){
	ajax_admin_tigadatcolist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_tigadatco_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modtigadatco_ment_fo_wait="";
function admin_modtigadatco_ment(szerz_tetel_id){
  clearTimeout(admin_modtigadatco_ment_fo_wait);
  admin_modtigadatco_ment_fo_wait = setTimeout(function(){admin_modtigadatco_ment_proc(szerz_tetel_id);},100);
}

var ajax_keres_admin_modtigadatco_ment_proc=null;
function admin_modtigadatco_ment_proc(szerz_tetel_id){

if(ajax_keres_admin_modtigadatco_ment_proc!=null){
 ajax_keres_admin_modtigadatco_ment_proc.abort();
}

var co=encodeURIComponent($("#admin_modtigadatco_sapszam_"+szerz_tetel_id).val());

ajax_keres_admin_modtigadatco_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modtigadatco_ment&szerz_tetel_id="+encodeURIComponent(szerz_tetel_id)+"&co="+co,
	function(d){
	ajax_keres_admin_modtigadatco_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){

	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

