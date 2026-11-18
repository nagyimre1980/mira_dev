<?php

?>

function admin_ujszolgkod(){
var szolgkod=encodeURIComponent($("#admin_ujszolgkod_szolgkod").val());
var nev=encodeURIComponent($("#admin_ujszolgkod_nev").val());

if(szolgkod==""){
 diaglog_open("Szolgáltatási kód kitöltése kötelező!","Hiba");
}else if(nev==""){
 diaglog_open("Szolgáltatási nevének kitöltése kötelező!","Hiba");
}else{
 admin_ujszolgkod_ment(szolgkod,nev);
}
}

var ajax_keres_admin_ujszolgkod_ment=null;
function admin_ujszolgkod_ment(szolgkod,nev){
$("#admin_ujszolgkod_submit").prop("disabled",true);

if(ajax_keres_admin_ujszolgkod_ment!=null){
 ajax_keres_admin_ujszolgkod_ment.abort();
}

ajax_keres_admin_ujszolgkod_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujszolgkod_ment&szolgkod="+szolgkod+"&nev="+nev,
	function(d){
	ajax_keres_admin_ujszolgkod_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_szolgkodlist_keres_par(){
var szolg_kod=encodeURIComponent($("#admin_szolgkodlist_keres_szolg_kod").val());
var nev=encodeURIComponent($("#admin_szolgkodlist_keres_nev").val());
var inaktiv=encodeURIComponent($("#admin_szolgkodlist_keres_inaktiv").val());
var par="&szolg_kod="+szolg_kod+"&nev="+nev+"&inaktiv="+inaktiv;
return par;
}

var admin_szolgkodlist_keres_fo_wait="";
function admin_szolgkodlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_szolgkodlist_keres_fo_wait);
  admin_szolgkodlist_keres_fo_wait = setTimeout(function(){admin_szolgkodlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_admin_szolgkodlist_keres_proc=null;
function admin_szolgkodlist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_szolgkodlist_keres_tal_oldalholvagyok","admin_szolgkodlist_keres_tal_oldalmax","admin_szolgkodlist_keres_talszam","admin_szolgkodlist_keres_proc");
var par=admin_szolgkodlist_keres_par();

if(ajax_keres_admin_szolgkodlist_keres_proc!=null){
 ajax_keres_admin_szolgkodlist_keres_proc.abort();
}

ajax_keres_admin_szolgkodlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szolgkodlist_keres"+ker_par+par,
	function(d){
	ajax_keres_admin_szolgkodlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_szolg_kod_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modszolgkod_ment_fo_wait="";
function admin_modszolgkod_ment(szolg_kod){
  clearTimeout(admin_modszolgkod_ment_fo_wait);
  admin_modszolgkod_ment_fo_wait = setTimeout(function(){admin_modszolgkod_ment_proc(szolg_kod);},100);
}

var ajax_keres_admin_modszolgkod_ment_proc=null;
function admin_modszolgkod_ment_proc(szolg_kod){

var nev=encodeURIComponent($("#admin_ujszolgkodmod_nev_"+szolg_kod).val());

if(ajax_keres_admin_modszolgkod_ment_proc!=null){
 ajax_keres_admin_modszolgkod_ment_proc.abort();
}

ajax_keres_admin_modszolgkod_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszolgkod_ment&szolg_kod="+encodeURIComponent(szolg_kod)+"&nev="+nev,
	function(d){
	ajax_keres_admin_modszolgkod_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_keres_admin_modszolgkod_inaktiv=null;
function admin_modszolgkod_inaktiv(szolg_kod){
if($("#admin_ujszolgkodmod_inaktiv_"+szolg_kod).prop("checked")){
 var inaktiv=1;
}else{
 var inaktiv=0;
}

if(ajax_keres_admin_modszolgkod_inaktiv!=null){
 ajax_keres_admin_modszolgkod_inaktiv.abort();
}

ajax_keres_admin_modszolgkod_inaktiv=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszolgkod_inaktiv&szolg_kod="+encodeURIComponent(szolg_kod)+"&inaktiv="+inaktiv,
	function(d){
	ajax_keres_admin_modszolgkod_inaktiv=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_szolgkodlist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
