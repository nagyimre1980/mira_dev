<?php

?>

function admin_ujnattipus(){
var naturalianev=encodeURIComponent($("#admin_ujnattipus_naturalianev").val());

if(naturalianev==""){
 diaglog_open("Hiba!<br><br>Naturália típus kitöltése kötelező!","Hiba","del_behajtani16.png");
}
admin_ujnattipus_ment(naturalianev);
}

var ajax_keres_admin_ujnattipus_ment=null;
function admin_ujnattipus_ment(naturalianev){

if(ajax_keres_admin_ujnattipus_ment!=null){
 ajax_keres_admin_ujnattipus_ment.abort();
}

ajax_keres_admin_ujnattipus_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujnattipus_ment&naturalianev="+naturalianev,
	function(d){
	ajax_keres_admin_ujnattipus_ment=null;
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

function admin_nattipuslist_keres_par(){
var naturalia_nev=encodeURIComponent($("#admin_nattipuslist_keres_naturalianev").val());
var par="&naturalia_nev="+naturalia_nev;
return par;
}

var admin_nattipuslist_keres_fo_wait="";
function admin_nattipuslist_keres(id_honnan,hol_lep){
  clearTimeout(admin_nattipuslist_keres_fo_wait);
  admin_nattipuslist_keres_fo_wait = setTimeout(function(){admin_nattipus_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_nattipuslist_keres_proc=null;
function admin_nattipus_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_nattipuslist");
var par=admin_nattipuslist_keres_par();

if(ajax_admin_nattipuslist_keres_proc!=null){
 ajax_admin_nattipuslist_keres_proc.abort();
}

ajax_admin_nattipuslist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_nattipuslist_keres"+ker_par+par,
	function(d){
	ajax_admin_nattipuslist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_nattipus_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modnattipus_ment_fo_wait="";
function admin_modnattipus_ment(szerz_naturalia_id){
  clearTimeout(admin_modnattipus_ment_fo_wait);
  admin_modnattipus_ment_fo_wait = setTimeout(function(){admin_modnattipus_ment_proc(szerz_naturalia_id);},100);
}

var ajax_keres_admin_modnattipus_ment_proc=null;
function admin_modnattipus_ment_proc(szerz_naturalia_id){
var naturalianev=encodeURIComponent($("#admin_modnattipus_naturalianev_"+szerz_naturalia_id).val());

if(ajax_keres_admin_modnattipus_ment_proc!=null){
 ajax_keres_admin_modnattipus_ment_proc.abort();
}

ajax_keres_admin_modnattipus_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modnattipus_ment&szerz_naturalia_id="+encodeURIComponent(szerz_naturalia_id)+"&naturalianev="+naturalianev,
	function(d){
	ajax_keres_admin_modnattipus_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_integadattobblet_uj_mod_fo_wait="";
function admin_integadattobblet_uj_mod(szerz_tetel_integ_id){
  clearTimeout(admin_integadattobblet_uj_mod_fo_wait);
  admin_integadattobblet_uj_mod_fo_wait = setTimeout(function(){admin_integadattobblet_uj_mod_proc(szerz_tetel_integ_id);},100);
}

var ajax_keres_admin_integadattobblet_uj_mod_proc=null;
function admin_integadattobblet_uj_mod_proc(szerz_tetel_integ_id){

var integ_tobblet=encodeURIComponent($("#admin_integadattobblet_mod_tobblet_"+szerz_tetel_integ_id).val());
var integ_tobblet_ho=encodeURIComponent($("#admin_integadattobblet_mod_tobblet_ho_"+szerz_tetel_integ_id).val());
var integ_megj=encodeURIComponent($("#admin_integadattobblet_mod_megj_"+szerz_tetel_integ_id).val());

if(ajax_keres_admin_integadattobblet_uj_mod_proc!=null){
 ajax_keres_admin_integadattobblet_uj_mod_proc.abort();
}

ajax_keres_admin_modszerzalapadat_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_integadattobblet_uj_mod&szerz_tetel_integ_id="+encodeURIComponent(szerz_tetel_integ_id)+"&integ_tobblet="+integ_tobblet+"&integ_tobblet_ho="+integ_tobblet_ho+"&integ_megj="+integ_megj,
	function(d){
	ajax_keres_admin_modszerzalapadat_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
