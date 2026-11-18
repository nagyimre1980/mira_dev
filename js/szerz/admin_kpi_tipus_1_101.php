<?php

?>

function admin_ujkpitipus_szolgkog_change(){
var _this=$("#admin_ujkpitipus_szolgkod");
//$("#admin_ujkpitipus_sorszam").prop("disabled",false);
//select2_torles_def('admin_ujkpitipus_sorszam','keremv');

if(_this.val()=='keremv'){
 $("#admin_ujkpitipus_sorszam").trigger("mouseenter");
}else{
 $('#admin_ujkpitipus_sorszam option').remove();
 $("#admin_ujkpitipus_sorszam").trigger("mouseenter");//.trigger('change')
 
 /*
 setTimeout(function(){
     //$('.ui-tooltip').remove();
	 $("#admin_ujkpitipus_sorszam").trigger("change");
},10);
*/
  //$("#admin_ujkpitipus_sorszam").trigger("change");
 //admin_ujkpitipus_sorszam_change();
}
}

function admin_ujkpitipus_sorszam_change(){
var szolgkod=$("#admin_ujkpitipus_szolgkod").val();
if(szolgkod=='keremv'){
 var kpi='';
}else{
var sorszam=$("#admin_ujkpitipus_sorszam").val();

if(sorszam<10){
 var kpi_s="0"+sorszam;
}else var kpi_s=sorszam;

var kpi=szolgkod+"_KPI"+kpi_s;
}
$("#admin_ujkpitipus_kpispan").html(kpi);
}

function admin_ujkpitipus(){
var szolgkod=encodeURIComponent($("#admin_ujkpitipus_szolgkod").val());
var sorszam=encodeURIComponent($("#admin_ujkpitipus_sorszam").val());
var tipus=encodeURIComponent($("#admin_ujkpitipus_tipus").val());

if(szolgkod=="" || szolgkod=="keremv"){
 diaglog_open("Hiba!<br><br>Szolgáltatás kód kiválasztása kötelező!","Hiba","del_behajtani16.png");
}

if(sorszam=="" || sorszam=="keremv"){
 diaglog_open("Hiba!<br><br>Sorszám kiválasztása kötelező!","Hiba","del_behajtani16.png");
}

if(tipus=="" || tipus=="keremv"){
 diaglog_open("Hiba!<br><br>Típus kiválasztása kötelező!","Hiba","del_behajtani16.png");
}
admin_ujkpitipus_ment(szolgkod,sorszam,tipus);
}

var ajax_keres_admin_ujkpitipus_ment=null;
function admin_ujkpitipus_ment(szolgkod,sorszam,tipus){

if(ajax_keres_admin_ujkpitipus_ment!=null){
 ajax_keres_admin_ujkpitipus_ment.abort();
}

ajax_keres_admin_ujkpitipus_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujkpitipus_ment&szolgkod="+szolgkod+"&sorszam="+sorszam+"&tipus="+tipus,
	function(d){
	ajax_keres_admin_ujkpitipus_ment=null;
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

function admin_kpitipus_keres_par(){
var kpi_szolg_kod=encodeURIComponent($("#admin_kpitipuslist_keres_kpiszolgkod").val());
var par="&kpi_szolg_kod="+kpi_szolg_kod;
return par;
}

var admin_kpitipuslist_keres_fo_wait="";
function admin_kpitipuslist_keres(id_honnan,hol_lep){
  clearTimeout(admin_kpitipuslist_keres_fo_wait);
  admin_kpitipuslist_keres_fo_wait = setTimeout(function(){admin_kpitipuslist_keres_proc(id_honnan,hol_lep);},100);
}


var ajax_admin_kpitipuslist_keres_proc=null;
function admin_kpitipuslist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_kpitipuslist");
var par=admin_kpitipus_keres_par();

if(ajax_admin_kpitipuslist_keres_proc!=null){
 ajax_admin_kpitipuslist_keres_proc.abort();
}

ajax_admin_kpitipuslist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_kpitipuslist_keres"+ker_par+par,
	function(d){
	ajax_admin_kpitipuslist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_kpitipus_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modkpitipus_ment_fo_wait="";
function admin_modkpitipus_ment(tagv_kod){
  clearTimeout(admin_modkpitipus_ment_fo_wait);
  admin_modkpitipus_ment_fo_wait = setTimeout(function(){admin_modkpitipus_ment_proc(tagv_kod);},100);
}

var ajax_keres_admin_modkpitipus_ment_proc=null;
function admin_modkpitipus_ment_proc(kpi_tipus_id){

var tipus=encodeURIComponent($("#admin_modkpitipus_tipus_"+kpi_tipus_id).val());
var mutmegn=encodeURIComponent($("#admin_modkpitipus_mutmegn_"+kpi_tipus_id).val());
var mutszmod=encodeURIComponent($("#admin_modkpitipus_mutszmod_"+kpi_tipus_id).val());
var ck1=encodeURIComponent($("#admin_modkpitipus_ck1_"+kpi_tipus_id).val());
var ck2=encodeURIComponent($("#admin_modkpitipus_ck2_"+kpi_tipus_id).val());
var ck3=encodeURIComponent($("#admin_modkpitipus_ck3_"+kpi_tipus_id).val());
var ck4=encodeURIComponent($("#admin_modkpitipus_ck4_"+kpi_tipus_id).val());
var szm4=encodeURIComponent($("#admin_modkpitipus_szm4_"+kpi_tipus_id).val());

if(ajax_keres_admin_modkpitipus_ment_proc!=null){
 ajax_keres_admin_modkpitipus_ment_proc.abort();
}

var par="&kpi_tipus_id="+encodeURIComponent(kpi_tipus_id)+"&tipus="+tipus+"&mutmegn="+mutmegn+"&mutszmod="+mutszmod+"&ck1="+ck1+"&ck2="+ck2+"&ck3="+ck3+"&ck4="+ck4+"&szm4="+szm4;
ajax_keres_admin_modkpitipus_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkpitipus_ment"+par,
	function(d){
	ajax_keres_admin_modkpitipus_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_modkpitipus_del(kpi_tipus_id,kpi){
dialog_kerdes('Törlés','Törlés','<b>Biztos, hogy kitörlöd az alábbi KPI-t?</b><br><br>'+kpi,function(){admin_modkpitipus_del_proc(kpi_tipus_id)});
}

var ajax_admin_modkpitipus_del_proc=null;
function admin_modkpitipus_del_proc(kpi_tipus_id){

if(ajax_admin_modkpitipus_del_proc!=null){
 ajax_admin_modkpitipus_del_proc.abort();
}

ajax_admin_modkpitipus_del_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkpitipus_del_proc&kpi_tipus_id="+encodeURIComponent(kpi_tipus_id),
	function(d){
	ajax_admin_modkpitipus_del_proc=null;
	 $("#dialog_egyeni_close").dialog('widget').find('button').prop('disabled',false);
	 $("#dialog_egyeni_close").dialog("close");
	if(d=="ok$;$"){
	 admin_kpitipuslist_keres_proc("","");
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

