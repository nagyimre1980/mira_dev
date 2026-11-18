<?php

?>

function admin_ujkpiszolgkod(){
var szolgkod=encodeURIComponent($("#admin_ujkpiszolgkod_szolgkod").val());

if(szolgkod==""){
 diaglog_open("Hiba!<br><br>Szolgáltatás kód kitöltése kötelező!","Hiba","del_behajtani16.png");
}
admin_ujkpiszolgkod_ment(szolgkod);
}

var ajax_keres_admin_ujkpiszolgkod_ment=null;
function admin_ujkpiszolgkod_ment(szolgkod){

if(ajax_keres_admin_ujkpiszolgkod_ment!=null){
 ajax_keres_admin_ujkpiszolgkod_ment.abort();
}

ajax_keres_admin_ujkpiszolgkod_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujkpiszolgkod_ment&szolgkod="+szolgkod,
	function(d){
	ajax_keres_admin_ujkpiszolgkod_ment=null;
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

function admin_kpiszolgkod_keres_par(){
var kpi_szolg_kod=encodeURIComponent($("#admin_kpiszolgkodlist_keres_kpiszolgkod").val());
var par="&kpi_szolg_kod="+kpi_szolg_kod;
return par;
}

var admin_kpiszolgkodlist_keres_fo_wait="";
function admin_kpiszolgkodlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_kpiszolgkodlist_keres_fo_wait);
  admin_kpiszolgkodlist_keres_fo_wait = setTimeout(function(){admin_kpiszolgkodlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_kpiszolgkod_keres_proc=null;
function admin_kpiszolgkodlist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_kpiszolgkodlist");
var par=admin_kpiszolgkod_keres_par();

if(ajax_admin_kpiszolgkod_keres_proc!=null){
 ajax_admin_kpiszolgkod_keres_proc.abort();
}

ajax_admin_kpiszolgkod_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_kpiszolgkodlist_keres"+ker_par+par,
	function(d){
	ajax_admin_kpiszolgkod_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_kpiszolgkod_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
