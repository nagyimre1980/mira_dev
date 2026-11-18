<?php

?>

function duplatagvadmin_list_scrool_bar(){
    $("#scroll1 div").width($("#admin_tagvkodlist_table").outerWidth(true));
    var ignoreScroll_tagv = false; // Zászló a végtelen ciklus ellen
	$("#scroll1").on("scroll", function(){
		 if (!ignoreScroll_tagv) {
         ignoreScroll_tagv = true;
         $("#scroll2").scrollLeft($(this).scrollLeft());
        
         // Hagyunk egy pici időt, majd levesszük a zászlót
         requestAnimationFrame(function(){
            ignoreScroll_tagv = false;
         });
		}
    });
    $("#scroll2").on("scroll", function(){
		 if (!ignoreScroll_tagv) {
         ignoreScroll_tagv = true;
         $("#scroll1").scrollLeft($(this).scrollLeft());
        
         requestAnimationFrame(function() {
            ignoreScroll_tagv = false;
         });
		}
    });
}

/*
function duplatagvadmin_list_scrool_bar_old(){
    $("#scroll1 div").width($("#admin_tagvkodlist_table").width());	
    $("#scroll1").on("scroll", function(){
        $("#scroll2").scrollLeft($(this).scrollLeft()); 
    });
    $("#scroll2").on("scroll", function(){
        $("#scroll1").scrollLeft($(this).scrollLeft()); 
    });
}
*/

function admin_ujtagvkod(){
var tagvkod=encodeURIComponent($("#admin_ujtagvkod_tagvkod").val());
var nev=encodeURIComponent($("#admin_ujtagvkod_nev").val());

if(tagvkod==""){
 diaglog_open("Társasági SAP kód kitöltése kötelező!","Hiba");
}else if(nev==""){
 diaglog_open("Társaság nevének kitöltése kötelező!","Hiba");
}else{
 admin_ujtagvkod_ment(tagvkod,nev);
}

}

var ajax_keres_admin_ujtagvkod_ment=null;
function admin_ujtagvkod_ment(tagvkod,nev){
$("#admin_ujtagvkod_submit").prop("disabled",true);

if(ajax_keres_admin_ujtagvkod_ment!=null){
 ajax_keres_admin_ujtagvkod_ment.abort();
}

ajax_keres_admin_ujtagvkod_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujtagvkod_ment&tagvkod="+tagvkod+"&nev="+nev,
	function(d){
	ajax_keres_admin_ujtagvkod_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_tagvkodlist_keres_tagv_kod").val(tagvkod).trigger('keyup');
	 $("#admin_ujtagvkod_tagvkod,#admin_ujtagvkod_nev").val('');
	 $("#admin_ujtagvkod_submit").prop("disabled",false);
	 //admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_tagvkodlist_keres_par(){
var tagv_kod=encodeURIComponent($("#admin_tagvkodlist_keres_tagv_kod").val());
var nev=encodeURIComponent($("#admin_tagvkodlist_keres_nev").val());
var inaktiv=encodeURIComponent($("#admin_tagvkodlist_keres_inaktiv").val());
var par="&tagv_kod="+tagv_kod+"&nev="+nev+"&inaktiv="+inaktiv;
return par;
}

var admin_tagvkodlist_keres_fo_wait="";
function admin_tagvkodlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_tagvkodlist_keres_fo_wait);
  admin_tagvkodlist_keres_fo_wait = setTimeout(function(){admin_tagvkodlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_admin_tagvkodlist_keres_proc=null;
function admin_tagvkodlist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_tagvkodlist_keres_tal_oldalholvagyok","admin_tagvkodlist_keres_tal_oldalmax","admin_tagvkodlist_keres_talszam","admin_tagvkodlist_keres_proc");
var par=admin_tagvkodlist_keres_par();

var scroll_poz=$("#scroll2").scrollLeft();

if(ajax_keres_admin_tagvkodlist_keres_proc!=null){
 ajax_keres_admin_tagvkodlist_keres_proc.abort();
}

ajax_keres_admin_tagvkodlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tagvkodlist_keres"+ker_par+par,
	function(d){
	ajax_keres_admin_tagvkodlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_tagv_kod_list_keres_tal").html(d1[1]);
	 $("#scroll2").scrollLeft(scroll_poz);
	 alap_input_select_most();
	 duplatagvadmin_list_scrool_bar();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modtagvkod_ment_fo_wait="";
function admin_modtagvkod_ment(tagv_kod){
  clearTimeout(admin_modtagvkod_ment_fo_wait);
  admin_modtagvkod_ment_fo_wait = setTimeout(function(){admin_modtagvkod_ment_proc(tagv_kod);},100);
}

var ajax_keres_admin_modtagvkod_ment_proc=null;
function admin_modtagvkod_ment_proc(tagv_kod){

if(ajax_keres_admin_modtagvkod_ment_proc!=null){
 ajax_keres_admin_modtagvkod_ment_proc.abort();
}

var nev=encodeURIComponent($("#admin_ujtagvkodmod_nev_"+tagv_kod).val());
var kapcstulaj=encodeURIComponent($("#admin_ujtagvkodmod_kapcstulaj_"+tagv_kod).val());
var cim=encodeURIComponent($("#admin_ujtagvkodmod_cim_"+tagv_kod).val());
var adoszam=encodeURIComponent($("#admin_ujtagvkodmod_adoszam_"+tagv_kod).val());
var vezeto_1=encodeURIComponent($("#admin_ujtagvkodmod_vezeto_1_"+tagv_kod).val());
var vezeto_1_t=encodeURIComponent($("#admin_ujtagvkodmod_vezeto_1_t_"+tagv_kod).val());
var vezeto_2=encodeURIComponent($("#admin_ujtagvkodmod_vezeto_2_"+tagv_kod).val());
var kapcst=encodeURIComponent($("#admin_ujtagvkodmod_kapcst_"+tagv_kod).val());

var par="&tagv_kod="+encodeURIComponent(tagv_kod)+"&nev="+nev+"&kapcstulaj="+kapcstulaj+"&cim="+cim+"&adoszam="+adoszam+"&vezeto_1="+vezeto_1+"&vezeto_1_t="+vezeto_1_t+"&vezeto_2="+vezeto_2+"&kapcst="+kapcst;
ajax_keres_admin_modtagvkod_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modtagvkod_ment"+par,
	function(d){
	ajax_keres_admin_modtagvkod_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_keres_admin_modtagvkod_inaktiv=null;
function admin_modtagvkod_inaktiv(tagv_kod){
if($("#admin_ujtagvkodmod_inaktiv_"+tagv_kod).prop("checked")){
 var inaktiv=1;
}else{
 var inaktiv=0;
}

if(ajax_keres_admin_modtagvkod_inaktiv!=null){
 ajax_keres_admin_modtagvkod_inaktiv.abort();
}

ajax_keres_admin_modtagvkod_inaktiv=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modtagvkod_inaktiv&tagv_kod="+encodeURIComponent(tagv_kod)+"&inaktiv="+inaktiv,
	function(d){
	ajax_keres_admin_modtagvkod_inaktiv=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_tagvkodlist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
