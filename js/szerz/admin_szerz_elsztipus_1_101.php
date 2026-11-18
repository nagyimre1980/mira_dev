<?php

?>

function admin_ujelsztipus(){
var tipusnev=encodeURIComponent($("#admin_ujelsztipus_tipusnev").val());

if(tipusnev==""){
 diaglog_open("Hiba!<br><br>Elszámolás típusa kitöltése kötelező!","Hiba","del_behajtani16.png");
}
admin_ujelsztipus_ment(tipusnev);
}

var ajax_keres_admin_ujelsztipus_ment=null;
function admin_ujelsztipus_ment(tipusnev){

if(ajax_keres_admin_ujelsztipus_ment!=null){
 ajax_keres_admin_ujelsztipus_ment.abort();
}

ajax_keres_admin_ujelsztipus_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujelsztipus_ment&tipusnev="+tipusnev,
	function(d){
	ajax_keres_admin_ujelsztipus_ment=null;
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

function admin_elsztipuslist_keres_par(){
var tipus_nev=encodeURIComponent($("#admin_elsztipuslist_keres_tipusnev").val());
var par="&tipus_nev="+tipus_nev;
return par;
}

var admin_elsztipuslist_keres_fo_wait="";
function admin_elsztipuslist_keres(id_honnan,hol_lep){
  clearTimeout(admin_elsztipuslist_keres_fo_wait);
  admin_elsztipuslist_keres_fo_wait = setTimeout(function(){admin_elsztipuslist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_elsztipuslist_keres_proc=null;
function admin_elsztipuslist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_elsztipuslist");
var par=admin_elsztipuslist_keres_par();

if(ajax_admin_elsztipuslist_keres_proc!=null){
 ajax_admin_elsztipuslist_keres_proc.abort();
}

ajax_admin_elsztipuslist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_elsztipuslist_keres"+ker_par+par,
	function(d){
	ajax_admin_elsztipuslist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_elsztipus_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modelsztipus_ment_fo_wait="";
function admin_modelsztipus_ment(szerz_elsz_tipus_id){
  clearTimeout(admin_modelsztipus_ment_fo_wait);
  admin_modelsztipus_ment_fo_wait = setTimeout(function(){admin_modelsztipus_ment_proc(szerz_elsz_tipus_id);},100);
}

var ajax_keres_admin_modelsztipus_ment_proc=null;
function admin_modelsztipus_ment_proc(szerz_elsz_tipus_id){
var tipusnev=encodeURIComponent($("#admin_modelsztipus_tipusnev_"+szerz_elsz_tipus_id).val());

if(ajax_keres_admin_modelsztipus_ment_proc!=null){
 ajax_keres_admin_modelsztipus_ment_proc.abort();
}

ajax_keres_admin_modelsztipus_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modelsztipus_ment&szerz_elsz_tipus_id="+encodeURIComponent(szerz_elsz_tipus_id)+"&tipusnev="+tipusnev,
	function(d){
	ajax_keres_admin_modelsztipus_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

