<?php

?>

function duplatigadatnemszerzadmin_list_scrool_bar(){
    $("#scroll1 div").width($("#admin_tigadatnemszerzlist_table").outerWidth(true));
    var ignoreScroll_user = false; // Zászló a végtelen ciklus ellen
	$("#scroll1").on("scroll", function(){
		 if (!ignoreScroll_user) {
         ignoreScroll_user = true;
         $("#scroll2").scrollLeft($(this).scrollLeft());
        
         // Hagyunk egy pici időt, majd levesszük a zászlót
         requestAnimationFrame(function(){
            ignoreScroll_user = false;
         });
		}
    });
    $("#scroll2").on("scroll", function(){
		 if (!ignoreScroll_user) {
         ignoreScroll_user = true;
         $("#scroll1").scrollLeft($(this).scrollLeft());
        
         requestAnimationFrame(function() {
            ignoreScroll_user = false;
         });
		}
    });
}

function admin_ujtigadatnemszerz(){
var ev=encodeURIComponent($("#admin_ujtigadatnemszerz_ev").val());
var ho=encodeURIComponent($("#admin_ujtigadatnemszerz_ho").val());
var tagvkod=encodeURIComponent($("#admin_ujtigadatnemszerz_tagvkod").val());
var szerztipusid=encodeURIComponent($("#admin_ujtigadatnemszerz_szerztipusid").val());
var szolgkod=encodeURIComponent($("#admin_ujtigadatnemszerz_szolgkod").val());
var szerzodes=encodeURIComponent($("#admin_ujtigadatnemszerz_szerzodes").val());
var elsztipus=encodeURIComponent($("#admin_ujtigadatnemszerz_elsztipus").val());
var szerzosszeg=encodeURIComponent($("#admin_ujtigadatnemszerz_szerzosszeg").val());
var haviosszeg=encodeURIComponent($("#admin_ujtigadatnemszerz_haviosszeg").val());
var haviosszegmod1=encodeURIComponent($("#admin_ujtigadatnemszerz_haviosszegmod1").val());
var haviosszegmod2=encodeURIComponent($("#admin_ujtigadatnemszerz_haviosszegmod2").val());
var devizanem=encodeURIComponent($("#admin_ujtigadatnemszerz_devizanem").val());
var co=encodeURIComponent($("#admin_ujtigadatnemszerz_co").val());

if(ho=='keremv'){
 diaglog_open("Hiba!<br><br>Hónap kiválasztása kötelező!","Hiba","hiba");	
}else if(tagvkod=='keremv'){
 diaglog_open("Hiba!<br><br>Megrendelő kiválasztása kötelező!","Hiba","hiba");	
}else if(szerztipusid=='keremv'){
 diaglog_open("Hiba!<br><br>Szerződés típus kiválasztása kötelező!","Hiba","hiba");	
}else if(szolgkod=='keremv'){
 diaglog_open("Hiba!<br><br>Szolgáltatás kiválasztása kötelező!","Hiba","hiba");	
}else if(szerzodes=='keremv'){
 diaglog_open("Hiba!<br><br>Szerződés kiválasztása kötelező!","Hiba","hiba");	
}else if(elsztipus=='keremv'){
 diaglog_open("Hiba!<br><br>Elszámolás módja kiválasztása kötelező!","Hiba","hiba");	
}else{
 var par="&ev="+ev+"&ho="+ho+"&tagvkod="+tagvkod+"&szerztipusid="+szerztipusid+"&szolgkod="+szolgkod+"&szerzodes="+szerzodes+"&elsztipus="+elsztipus+"&szerzosszeg="+szerzosszeg+"&haviosszeg="+haviosszeg+"&haviosszegmod1="+haviosszegmod1+"&haviosszegmod2="+haviosszegmod2+"&devizanem="+devizanem+"&co="+co;
 admin_ujtigadatnemszerz_ment(par);
}
}

var ajax_keres_admin_ujtigadatnemszerz_ment=null;
function admin_ujtigadatnemszerz_ment(par){

if(ajax_keres_admin_ujtigadatnemszerz_ment!=null){
 ajax_keres_admin_ujtigadatnemszerz_ment.abort();
}

ajax_keres_admin_ujtigadatnemszerz_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujtigadatnemszerz"+par,
	function(d){
	ajax_keres_admin_ujtigadatnemszerz_ment=null;
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

function admin_modtigadatnemszerz_del(id){
//$("#tr_tigadatnemszerz_"+id).css({"background-color": "red","color": "#fff"});
$("#tr_tigadatnemszerz_"+id+" td").addClass('pir_hat_red');
dialog_kerdes('Törlés','Törlés','Biztos, hogy kitörlöd ezt a rekordot?',
function(){admin_modtigadatnemszerz_del_proc(id)},
function(){$("#tr_tigadatnemszerz_"+id+" td").removeClass('pir_hat_red');}
);
}

var ajax_keres_admin_modtigadatnemszerz_del_proc=null;
function admin_modtigadatnemszerz_del_proc(id){

if(ajax_keres_admin_modtigadatnemszerz_del_proc!=null){
 ajax_keres_admin_modtigadatnemszerz_del_proc.abort();
}

ajax_keres_admin_modtigadatnemszerz_del_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modtigadatnemszerz_del&id="+encodeURIComponent(id),
	function(d){
	ajax_keres_admin_modtigadatnemszerz_del_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	 $("#dialog_egyeni_close").dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_tigadatnemszerzlist_keres_par(){
var ev=encodeURIComponent($("#admin_tigadatnemszerzlist_keres_ev").val());
var ho=encodeURIComponent($("#admin_tigadatnemszerzlist_keres_ho").val());
var par="&ev="+ev+"&ho="+ho;
return par;
}

/*
var admin_tigadatnemszerzlist_keres_fo_wait="";
function admin_tigadatnemszerzlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_tigadatnemszerzlist_keres_fo_wait);
  admin_tigadatnemszerzlist_keres_fo_wait = setTimeout(function(){admin_tigadatnemszerzlist_keres_proc(id_honnan,hol_lep);},100);
}
*/

var ajax_admin_tigadatnemszerzlist_keres_proc=null;
function admin_tigadatnemszerzlist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_tigadatnemszerzlist");
var par=admin_tigadatnemszerzlist_keres_par();

if(ajax_admin_tigadatnemszerzlist_keres_proc!=null){
 ajax_admin_tigadatnemszerzlist_keres_proc.abort();
}

ajax_admin_tigadatnemszerzlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tigadatnemszerzlist_keres"+ker_par+par,
	function(d){
	ajax_admin_tigadatnemszerzlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_tigadatnemszerz_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 number_only();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modtigadatnemszerz_ment_fo_wait="";
function admin_modtigadatnemszerz_ment(szerz_tetel_id){
  clearTimeout(admin_modtigadatnemszerz_ment_fo_wait);
  admin_modtigadatnemszerz_ment_fo_wait = setTimeout(function(){admin_modtigadatnemszerz_ment_proc(szerz_tetel_id);},100);
}

var ajax_keres_admin_modtigadatnemszerz_ment_proc=null;
function admin_modtigadatnemszerz_ment_proc(id){

var tagvkod=encodeURIComponent($("#admin_modtigadatnemszerz_tagvkod_"+id).val());
var szerztipusid=encodeURIComponent($("#admin_modtigadatnemszerz_szerztipusid_"+id).val());
var szolgkod=encodeURIComponent($("#admin_modtigadatnemszerz_szolgkod_"+id).val());
var szerzodes=encodeURIComponent($("#admin_modtigadatnemszerz_szerzodes_"+id).val());
var elsztipus=encodeURIComponent($("#admin_modtigadatnemszerz_elsztipus_"+id).val());
var szerzosszeg=encodeURIComponent($("#admin_modtigadatnemszerz_szerzosszeg_"+id).val());
var haviosszeg=encodeURIComponent($("#admin_modtigadatnemszerz_haviosszeg_"+id).val());
var haviosszeg_mod1=encodeURIComponent($("#admin_modtigadatnemszerz_haviosszeg_mod1_"+id).val());
var haviosszeg_mod2=encodeURIComponent($("#admin_modtigadatnemszerz_haviosszeg_mod2_"+id).val());
var penznem=encodeURIComponent($("#admin_modtigadatnemszerz_penznem_"+id).val());
var co=encodeURIComponent($("#admin_modtigadatnemszerz_co_"+id).val());

var par="&id="+encodeURIComponent(id)+"&tagvkod="+tagvkod+"&szerztipusid="+szerztipusid+"&szolgkod="+szolgkod+"&szerzodes="+szerzodes+"&elsztipus="+elsztipus+"&szerzosszeg="+szerzosszeg+"&haviosszeg="+haviosszeg+"&haviosszeg_mod1="+haviosszeg_mod1+"&haviosszeg_mod2="+haviosszeg_mod2+"&penznem="+penznem+"&co="+co;

if(ajax_keres_admin_modtigadatnemszerz_ment_proc!=null){
 ajax_keres_admin_modtigadatnemszerz_ment_proc.abort();
}

ajax_keres_admin_modtigadatco_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modtigadatnemszerz_ment"+par,
	function(d){
	ajax_keres_admin_modtigadatco_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){

	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
