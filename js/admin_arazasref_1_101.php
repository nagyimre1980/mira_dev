<?php

?>

function admin_arazasreflist_keres_par(){
var id=encodeURIComponent($("#admin_arazasreflist_keres_id").val());
var nev=encodeURIComponent($("#admin_arazasreflist_keres_nev").val());
var arazasref=encodeURIComponent($("#admin_arazasreflist_keres_arazasref").val());
var inaktiv=encodeURIComponent($("#admin_arazasreflist_keres_inaktiv").val());
var par="&id="+id+"&nev="+nev+"&arazasref="+arazasref+"&inaktiv="+inaktiv;
return par;
}

var admin_arazasreflist_keres_fo_wait="";
function admin_arazasreflist_keres(id_honnan,hol_lep){
  clearTimeout(admin_arazasreflist_keres_fo_wait);
  admin_arazasreflist_keres_fo_wait = setTimeout(function(){admin_arazasreflist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_arazasreflist_keres_proc=null;
function admin_arazasreflist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_arazasreflist_keres_tal_oldalholvagyok","admin_arazasreflist_keres_tal_oldalmax","admin_arazasreflist_keres_talszam","admin_arazasreflist_keres_proc");

var par=admin_arazasreflist_keres_par();

if(ajax_admin_arazasreflist_keres_proc!=null){
 ajax_admin_arazasreflist_keres_proc.abort();
}

ajax_admin_arazasreflist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_arazasreflist_keres"+ker_par+par,
	function(d){
	ajax_admin_arazasreflist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_arazasref_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 //date_tol_ig();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_admin_modarazasref_ment_arazasref=null;
function admin_modarazasref_ment_arazasref(projekt_id){
var arazasref=encodeURIComponent($("#admin_arazasrefmod_arazasref_"+projekt_id).val());

if(ajax_admin_modarazasref_ment_arazasref!=null){
 ajax_admin_modarazasref_ment_arazasref.abort();
}

ajax_admin_modarazasref_ment_arazasref=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modarazasref_ment_arazasref&arazasref="+arazasref+"&projekt_id="+encodeURIComponent(projekt_id),
	function(d){
	ajax_admin_modarazasref_ment_arazasref=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){

	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}
