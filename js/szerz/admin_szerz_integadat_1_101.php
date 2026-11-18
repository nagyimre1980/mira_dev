<?php


?>

function admin_integadatlist_keres_par(){
var mire1=encodeURIComponent($("#admin_integadatlist_keres_mire1").val());
var mit1=encodeURIComponent($("#admin_integadatlist_keres_mit1").val());
var mit1_value=encodeURIComponent($("#admin_integadatlist_keres_mit1 option:selected").text());

var mire2=encodeURIComponent($("#admin_integadatlist_keres_mire2").val());
var mit2=encodeURIComponent($("#admin_integadatlist_keres_mit2").val());
var mit2_value=encodeURIComponent($("#admin_integadatlist_keres_mit2 option:selected").text());

var mire3=encodeURIComponent($("#admin_integadatlist_keres_mire3").val());
var mit3=encodeURIComponent($("#admin_integadatlist_keres_mit3").val());
var mit3_value=encodeURIComponent($("#admin_integadatlist_keres_mit3 option:selected").text());

var szerz_tetel_id=encodeURIComponent($("#admin_integadatlist_keres_szerztetelid").val());
var sapszam=encodeURIComponent($("#admin_integadatlist_keres_szerzsapszam").val());

if($("#admin_integadatlist_keres_akt").prop('checked')){
 var akt='1';
}else{
 var akt='0';
}

var par="&mire1="+mire1+"&mit1="+mit1+"&mire2="+mire2+"&mit2="+mit2+"&mire3="+mire3+"&mit3="+mit3+"&szerz_tetel_id="+szerz_tetel_id+"&sapszam="+sapszam+"&akt="+akt;
par+="&mit1_value="+mit1_value+"&mit2_value="+mit2_value+"&mit3_value="+mit3_value;
return par;
}

var admin_integadatlist_keres_fo_wait="";
function admin_integadatlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_integadatlist_keres_fo_wait);
  admin_integadatlist_keres_fo_wait = setTimeout(function(){admin_integadatlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_integadatlist_keres_proc=null;
function admin_integadatlist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_integadatlist");
var par=admin_integadatlist_keres_par();

if(ajax_admin_integadatlist_keres_proc!=null){
 ajax_admin_integadatlist_keres_proc.abort();
}

ajax_admin_integadatlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_integadatlist_keres"+ker_par+par,
	function(d){
	ajax_admin_integadatlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_integadat_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 number_only();
	 number_only_tizedes();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_integadattobblet_mod_fo_wait="";
function admin_integadattobblet_mod(szerz_tetel_adat_id){
  clearTimeout(admin_integadattobblet_mod_fo_wait);
  admin_integadattobblet_mod_fo_wait = setTimeout(function(){admin_integadattobblet_mod_proc(szerz_tetel_adat_id);},100);
}

var ajax_admin_integadattobblet_mod_proc=null;
function admin_integadattobblet_mod_proc(szerz_tetel_adat_id){

if(ajax_admin_integadattobblet_mod_proc!=null){
 ajax_admin_integadattobblet_mod_proc.abort();
}

var tobblet=encodeURIComponent($("#admin_integadattobblet_mod_tobblet_"+szerz_tetel_adat_id).val());
var tobblet_ho=encodeURIComponent($("#admin_integadattobblet_mod_tobblet_ho_"+szerz_tetel_adat_id).val());
var megj=encodeURIComponent($("#admin_integadattobblet_mod_megj_"+szerz_tetel_adat_id).val());

ajax_admin_integadattobblet_mod_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_integadattobblet_mod&szerz_tetel_adat_id="+encodeURIComponent(szerz_tetel_adat_id)+"&tobblet="+tobblet+"&tobblet_ho="+tobblet_ho+"&megj="+megj,
	function(d){
	ajax_admin_integadattobblet_mod_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
