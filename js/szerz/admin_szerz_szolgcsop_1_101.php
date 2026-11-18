<?php

?>

function admin_ujszolgcsop(){
var csopnev=encodeURIComponent($("#admin_ujszolgcsop_csopnev").val());

if(csopnev==""){
 diaglog_open("Hiba!<br><br>Szolgáltatás csoport név kitöltése kötelező!","Hiba","del_behajtani16.png");
}
admin_ujszolgcsop_ment(csopnev);
}

var ajax_keres_admin_ujszolgcsop_ment=null;
function admin_ujszolgcsop_ment(csopnev){
if(ajax_keres_admin_ujszolgcsop_ment!=null){
 ajax_keres_admin_ujszolgcsop_ment.abort();
}

ajax_keres_admin_ujszolgcsop_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujszolgcsop_ment&csopnev="+csopnev,
	function(d){
	ajax_keres_admin_ujszolgcsop_ment=null;
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

var admin_modszolgcsop_ment_fo_wait="";
function admin_modszolgcsop_ment(szerz_csop_id){
  clearTimeout(admin_modszolgcsop_ment_fo_wait);
  admin_modszolgcsop_ment_fo_wait = setTimeout(function(){admin_modszolgcsop_ment_proc(szerz_csop_id);},100);
}

var ajax_keres_admin_modszolgcsop_ment_proc=null;
function admin_modszolgcsop_ment_proc(szerz_csop_id){

var csopnev=encodeURIComponent($("#admin_modszolgcsop_csopnev_"+szerz_csop_id).val());
var kpi_szolg_kod=encodeURIComponent($("#admin_modszolgcsop_kpiszolgkod_"+szerz_csop_id).val());
var kpi_szolg_kod_kozszolg =encodeURIComponent($("#admin_modszolgcsop_kpiszolgkodkozszolg_"+szerz_csop_id).val());

if(ajax_keres_admin_modszolgcsop_ment_proc!=null){
 ajax_keres_admin_modszolgcsop_ment_proc.abort();
}

ajax_keres_admin_modszolgcsop_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszolgcsop_ment&szerz_csop_id="+encodeURIComponent(szerz_csop_id)+"&csopnev="+csopnev+"&kpi_szolg_kod="+kpi_szolg_kod+"&kpi_szolg_kod_kozszolg="+kpi_szolg_kod_kozszolg,
	function(d){
	ajax_keres_admin_modszolgcsop_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_szolgcsoplist_keres_par(){
var csop_nev=encodeURIComponent($("#admin_szolgcsoplist_keres_csopnev").val());
var par="&csop_nev="+csop_nev;
return par;
}

var admin_szolgcsoplist_keres_fo_wait="";
function admin_szolgcsoplist_keres(id_honnan,hol_lep){
 clearTimeout(admin_szolgcsoplist_keres_fo_wait);
 admin_szolgcsoplist_keres_fo_wait = setTimeout(function(){admin_szolgcsoplist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_szolgcsoplist_keres_proc=null;
function admin_szolgcsoplist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_szolgcsoplist_keres_tal_oldalholvagyok","admin_szolgcsoplist_keres_tal_oldalmax","admin_szolgcsoplist_keres_talszam","admin_szolgcsoplist_keres_proc");
var par=admin_szolgcsoplist_keres_par();

if(ajax_admin_szolgcsoplist_keres_proc!=null){
 ajax_admin_szolgcsoplist_keres_proc.abort();
}

ajax_admin_szolgcsoplist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szolgcsoplist_keres"+ker_par+par,
	function(d){
	ajax_admin_szolgcsoplist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_szolgcsop_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_admin_modszolgcsop_szolgkod_katt=null;
function admin_modszolgcsopszolgkod_szolgkod_katt(szerz_csop_id,szerz_csop_nev){

if(ajax_admin_modszolgcsop_szolgkod_katt!=null){
 ajax_admin_modszolgcsop_szolgkod_katt.abort();
}

ajax_admin_modszolgcsop_szolgkod_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszolgcsopszolgkod_szolgkod_katt&csakvan=0&szerz_csop_id="+encodeURIComponent(szerz_csop_id)+"&szerz_csop_nev="+encodeURIComponent(szerz_csop_nev),
	function(d){
	ajax_admin_modszolgcsop_szolgkod_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Szolgáltatás kódok");
	}else{
	 diaglog_open(d,"Rendszerhiba","hiba");	
	}
	});
}

function admin_szolgcsopszolgkodlist_keres_par(){
var szerz_csop_id=$("#szolgcsopszolgkod_hozzid_keress").attr("szerz_csop_id");
var szolg_kod=$("#szolgcsopszolgkod_hozzidkod_keress").val();
var szolg_kod_nev=$("#szolgcsopszolgkod_hozzid_keress").val();
if($("#szolgcsopszolgkod_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var par="&csakvan="+csakvan+"&szerz_csop_id="+szerz_csop_id+"&szolg_kod_nev="+szolg_kod_nev+"&szolg_kod="+szolg_kod;
return par;
}

var admin_modszolgcsopszolgkod_hozz_keress_fo_wait="";
function admin_modszolgcsopszolgkod_hozz_keress(id_honnan,hol_lep){
 clearTimeout(admin_modszolgcsopszolgkod_hozz_keress_fo_wait);
 admin_modszolgcsopszolgkod_hozz_keress_fo_wait = setTimeout(function(){admin_modszolgcsopszolgkod_hozz_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_modszolgcsopszolgkod_hozz_keress_proc=null;
function admin_modszolgcsopszolgkod_hozz_keress_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_szolgcsophozszolgkodlist");
var par=admin_szolgcsopszolgkodlist_keres_par();

if(ajax_admin_modszolgcsopszolgkod_hozz_keress_proc!=null){
 ajax_admin_modszolgcsopszolgkod_hozz_keress_proc.abort();
}

ajax_admin_modszolgcsopszolgkod_hozz_keress_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszolgcsopszolgkod_hozz_keress"+ker_par+par,
	function(d){
	ajax_admin_modszolgcsopszolgkod_hozz_keress_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#szolgcsopszolgkod_hozzid_tal_div").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_modszolgcsopszolgkod_hozz_change=null;
function admin_modszolgcsopszolgkod_hozz_change(szolg_kod,szerz_csop_id){
if($("#szolgcsopszolgkod_hozzid_"+szolg_kod).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_modszolgcsopszolgkod_hozz_change!=null){
 ajax_keres_admin_modszolgcsopszolgkod_hozz_change.abort();
}

ajax_keres_admin_moduserprojekt_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszolgcsopszolgkod_hozz_change&mit="+mit+"&szolg_kod="+szolg_kod+"&szerz_csop_id="+szerz_csop_id,
	function(d){
	ajax_keres_admin_moduserprojekt_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_modszolgcsopszolgkod_hozz_keress("","");
	 admin_szolgcsoplist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}
