<?php

?>

function ad_leker_usergazda_enter(e){
var c=e.keyCode;
if(c==13){//13 enter 9 tab
 ad_leker_usergazda();
}else if(c!=9){
 $("#admin_ujszerzusergazda_nev").val("");
 $("#admin_ujszerzusergazda_email").val("");
 $("#admin_ujszerzusergazda_tsz").val("");
}
}

var ajax_keres_ad_leker_usergazda=null;
function ad_leker_usergazda(){
var ad=encodeURIComponent($("#admin_ujszerzusergazda_ad").val());
if(ad!=""){

if(ajax_keres_ad_leker_usergazda!=null){
 ajax_keres_ad_leker_usergazda.abort();
}

ajax_keres_ad_leker_usergazda=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=ad_leker&ad="+ad,
	function(d){
	ajax_keres_ad_leker_usergazda=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_ujszerzusergazda_nev").val(d1[1]);
	 $("#admin_ujszerzusergazda_email").val(d1[2]);
	 $("#admin_ujszerzusergazda_tsz").val(d1[3]);
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	});	
}else{
	diaglog_open("AD adatok lekérdezéséhez add meg az AD azonosítót!","Rendszerhiba");
}
}


function admin_ujszerzusergazda(){
var ad=encodeURIComponent($("#admin_ujszerzusergazda_ad").val());
var nev=encodeURIComponent($("#admin_ujszerzusergazda_nev").val());
var email=encodeURIComponent($("#admin_ujszerzusergazda_email").val());
var tsz=encodeURIComponent($("#admin_ujszerzusergazda_tsz").val());

if(nev=="" || ad=="" || email==""){
 diaglog_open("Hiba!<br><br>Minden adat kitöltése kötelező!","Hiba","del_behajtani16.png");
}
admin_ujszerzusergazda_ment(nev,ad,email,tsz);
}

var ajax_keres_admin_ujszerzusergazda_ment=null;
function admin_ujszerzusergazda_ment(nev,ad,email,tsz){

if(ajax_keres_admin_ujszerzusergazda_ment!=null){
 ajax_keres_admin_ujszerzusergazda_ment.abort();
}

ajax_keres_admin_ujszerzusergazda_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujszerzusergazda_ment&nev="+nev+"&ad="+ad+"&email="+email+"&tsz="+tsz,
	function(d){
	ajax_keres_admin_ujszerzusergazda_ment=null;
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

function admin_szerzusergazdalist_keres_par(){
var nev=encodeURIComponent($("#admin_szerzusergazdalist_keres_nev").val());
var ad=encodeURIComponent($("#admin_szerzusergazdalist_keres_ad").val());
var par="&nev="+nev+"&ad="+ad;
return par;
}

var admin_szerzusergazdalist_keres_fo_wait="";
function admin_szerzusergazdalist_keres(id_honnan,hol_lep){
  clearTimeout(admin_szerzusergazdalist_keres_fo_wait);
  admin_szerzusergazdalist_keres_fo_wait = setTimeout(function(){admin_szerzusergazdalist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_szerzusergazdalist_keres_proc=null;
function admin_szerzusergazdalist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_szerzusergazdalist");
var par=admin_szerzusergazdalist_keres_par();

if(ajax_admin_szerzusergazdalist_keres_proc!=null){
 ajax_admin_szerzusergazdalist_keres_proc.abort();
}

ajax_admin_szerzusergazdalist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szerzusergazdalist_keres"+ker_par+par,
	function(d){
	ajax_admin_szerzusergazdalist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_szerzusergazda_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modszerzusergazda_ment_fo_wait="";
function admin_modszerzusergazda_ment(ad){
  clearTimeout(admin_modszerzusergazda_ment_fo_wait);
  admin_modszerzusergazda_ment_fo_wait = setTimeout(function(){admin_modszerzusergazda_ment_proc(ad);},100);
}

var ajax_keres_admin_modszerzusergazda_ment_proc=null;
function admin_modszerzusergazda_ment_proc(ad){
var nev=encodeURIComponent($("#admin_modszerzusergazda_nev_"+ad).val());
var email=encodeURIComponent($("#admin_modszerzusergazda_email_"+ad).val());
var tsz=encodeURIComponent($("#admin_modszerzusergazda_tsz_"+ad).val());

if(ajax_keres_admin_modszerzusergazda_ment_proc!=null){
 ajax_keres_admin_modszerzusergazda_ment_proc.abort();
}

ajax_keres_admin_modszerzusergazda_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszerzusergazda_ment&ad="+encodeURIComponent(ad)+"&nev="+nev+"&email="+email+"&tsz="+tsz,
	function(d){
	ajax_keres_admin_modszerzusergazda_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");

}

var ajax_keres_admin_modszerzusergazda_inaktiv=null;
function admin_modszerzusergazda_inaktiv(ad){
if($("#admin_modszerzusergazda_inaktiv_ck_"+ad).prop('checked'))
 var usergazda_inaktiv=1;
else var usergazda_inaktiv=0;

if(ajax_keres_admin_modszerzusergazda_inaktiv!=null){
 ajax_keres_admin_modszerzusergazda_inaktiv.abort();
}

ajax_keres_admin_modszerzusergazda_inaktiv=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszerzusergazda_inaktiv&ad="+encodeURIComponent(ad)+"&usergazda_inaktiv="+usergazda_inaktiv,
	function(d){
	ajax_keres_admin_modszerzusergazda_inaktiv=null;
	if(d=="ok$;$"){
	 admin_szerzusergazdalist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba",'del_behajtani16.png');	
	}
	},"text");
}
