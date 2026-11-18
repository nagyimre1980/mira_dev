<?php

?>

function admin_loglist_keres_par(){
var user_nev=encodeURIComponent($("#admin_kereslog_user_nev").val());
var mikor=encodeURIComponent($("#admin_kereslog_mikor").val());
var adat_elozmeny=encodeURIComponent($("#admin_kereslog_adat_elozmeny").val());
var adat=encodeURIComponent($("#admin_kereslog_adat").val());
var log_mod=encodeURIComponent($("#admin_kereslog_mod").val());
var log_muvelet=encodeURIComponent($("#admin_kereslog_muvelet").val());
var hol=encodeURIComponent($("#admin_kereslog_hol").val());

var par="&user_nev="+user_nev+"&mikor="+mikor+"&adat_elozmeny="+adat_elozmeny+"&adat="+adat+"&log_mod="+log_mod+"&log_muvelet="+log_muvelet+"&hol="+hol;
return par;
}

var admin_loglist_keres_fo_wait="";
function admin_loglist_keres(id_honnan,hol_lep){
  clearTimeout(admin_loglist_keres_fo_wait);
  admin_loglist_keres_fo_wait = setTimeout(function(){admin_loglist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_admin_loglist_keres=null;
function admin_loglist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_loglist_keres_tal_oldalholvagyok","admin_loglist_keres_tal_oldalmax","admin_loglist_keres_talszam","admin_loglist_keres_proc");
var par=admin_loglist_keres_par();

if(ajax_keres_admin_loglist_keres!=null){
 ajax_keres_admin_loglist_keres.abort();
}

ajax_keres_admin_loglist_keres=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_loglist_keres"+ker_par+par,
	function(d){
	ajax_keres_admin_loglist_keres=null;
	if(d.slice(0,2)=="ok"){
	 gi("admin_uj_log_list_keres_tal").innerHTML=d.slice(5);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba",'del_behajtani16.png');	
	}
	},"text");
}

function admin_loglist_archivalas(){
var gomb_igen='Archiválás';
var str='Biztos, hogy kiarchiválod a teljes log adatbázist Excel és SQL formában?';
dialog_kerdes(gomb_igen,'Archiválás',str,function(){admin_loglist_archivalas_proc()});
}

var ajax_keres_admin_loglist_archivalas=null;
function admin_loglist_archivalas_proc(){
$("#admin_loglist_archivalas_submit").prop("disabled",true);

if(ajax_keres_admin_loglist_archivalas!=null){
 ajax_keres_admin_loglist_archivalas.abort();
}

ajax_keres_admin_loglist_keres=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_loglist_archivalas",
	function(d){
	ajax_keres_admin_loglist_keres=null;
	$("#dialog_egyeni_close").dialog("close");
	if(d.slice(0,2)=="ok"){
	 ful_betolt(akt_ful);
	}else{
	 diaglog_open(d,"Rendszerhiba",'del_behajtani16.png');	
	}
	},"text");
}
