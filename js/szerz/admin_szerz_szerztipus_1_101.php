<?php

?>

function admin_ujszerztipus(){
var nev=encodeURIComponent($("#admin_ujszerztipus_nev").val());

if($("#admin_ujszerztipus_szerzkeret").prop('checked'))
 var szerz_keret="1";
else var szerz_keret="0";

if($("#admin_ujszerztipus_dupla").prop('checked'))
 var dupla="1";
else var dupla="0";

if(nev==""){
 diaglog_open("Hiba!<br><br>Szerződés típus kitöltése kötelező!","Hiba",'hiba');
}else{
 admin_ujszerztipus_ment(nev,szerz_keret,dupla);
}
}

var ajax_keres_admin_ujszerztipus_ment=null;
function admin_ujszerztipus_ment(nev,szerz_keret,dupla){
if(ajax_keres_admin_ujszerztipus_ment!=null){
 ajax_keres_admin_ujszerztipus_ment.abort();
}

ajax_keres_admin_ujszerztipus_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujszerztipus_ment&nev="+nev+"&szerz_keret="+szerz_keret+"&dupla="+dupla,
	function(d){
	ajax_keres_admin_ujszerztipus_ment=null;
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

function admin_szerztipuslist_keres_par(){
var nev=encodeURIComponent($("#admin_szerztipuslist_keres_nev").val());
var par="&nev="+nev;
return par;
}

var admin_szerztipuslist_keres_fo_wait="";
function admin_szerztipuslist_keres(id_honnan,hol_lep){
  clearTimeout(admin_szerztipuslist_keres_fo_wait);
  admin_szerztipuslist_keres_fo_wait = setTimeout(function(){admin_szerztipuslist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_szerztipuslist_keres_proc=null;
function admin_szerztipuslist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_szerztipuslist_keres_tal_oldalholvagyok","admin_szerztipuslist_keres_tal_oldalmax","admin_szerztipuslist_keres_talszam","admin_szerztipuslist_keres_proc");
var par=admin_szerztipuslist_keres_par();

if(ajax_admin_szerztipuslist_keres_proc!=null){
 ajax_admin_szerztipuslist_keres_proc.abort();
}

ajax_admin_szerztipuslist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szerztipuslist_keres"+ker_par+par,
	function(d){
	ajax_admin_szerztipuslist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_szerztipus_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modszerztipus_ment_fo_wait="";
function admin_modszerztipus_ment(szerz_tipus_id){
  clearTimeout(admin_modszerztipus_ment_fo_wait);
  admin_modszerztipus_ment_fo_wait = setTimeout(function(){admin_modszerztipus_ment_proc(szerz_tipus_id);},100);
}

var ajax_keres_admin_modszerztipus_ment_proc=null;
function admin_modszerztipus_ment_proc(szerz_tipus_id){

if(ajax_keres_admin_modszerztipus_ment_proc!=null){
 ajax_keres_admin_modszerztipus_ment_proc.abort();
}

var szerz_tipus_nev=encodeURIComponent($("#admin_modszerztipus_nev_"+szerz_tipus_id).val());

if($("#admin_modszerztipus_szerzkeret_"+szerz_tipus_id).prop('checked')){
 var szerz_keret='1';
}else{
 var szerz_keret='0';
}

if($("#admin_modszerztipus_dupla_"+szerz_tipus_id).prop('checked')){
 var dupla='1';
}else{
 var dupla='0';
}

ajax_keres_admin_modkatnev_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszerztipus_ment&szerz_tipus_id="+encodeURIComponent(szerz_tipus_id)+"&szerz_tipus_nev="+szerz_tipus_nev+"&szerz_keret="+szerz_keret+"&dupla="+dupla,
	function(d){
	ajax_keres_admin_modkatnev_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
