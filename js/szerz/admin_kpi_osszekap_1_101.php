<?php

?>

function admin_kpi_osszekap_indit(){
// var newOptions = {"all": "Összes"};
// ajax4_multiselect_update_array('admin_kpiosszekaplist_keres_kpitipus',newOptions,'all');
 
 $('#admin_kpiosszekaplist_keres_kpitipus').multiSelect({
    noneText: 'Összes',
    'menuMinHeight': '50',
	'searchinp':true
});

}

/*
function duplakpiosszekapcsadmin_list_scrool_bar(){
    $("#scroll1 div").width($("#admin_kpiosszekaplist_table").width());	
    $("#scroll1").on("scroll", function(){
        $("#scroll2").scrollLeft($(this).scrollLeft()); 
    });
    $("#scroll2").on("scroll", function(){
        $("#scroll1").scrollLeft($(this).scrollLeft()); 
    });
}
*/

function duplakpiosszekapcsadmin_list_scrool_bar(){
    $("#scroll1 div").width($("#admin_kpiosszekaplist_table").outerWidth(true));
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

function admin_kpiosszekap_nemrelevans(szerz_id,szerz_csop_id,szerz_tetel_modszam_kezi,i){
var _this=$("#admin_modkpiosszekap_nemrelevans_"+i)
var orig_ck=_this.prop('checked');

if(orig_ck){//Ekkor be akarják pipálni
 var str="<b>Biztos, hogy beállítod a KPI nem releváns státusz?</b><br><br>Ezzel törlésre kerül minden beállított KPI típust!";
 var gomb_str="KPI nem releváns státusz mentése";
}else{
 var str="Biztos, hogy törlöd a KPI nem releváns státusz?";
 var gomb_str="KPI nem releváns státusz törlése";
}

dialog_kerdes(gomb_str,'KPI nem releváns',str,function(){admin_kpiosszekap_nemrelevans_proc(szerz_id,szerz_csop_id,szerz_tetel_modszam_kezi,i)},function(){_this.prop('checked',!orig_ck)});
}

var ajax_admin_kpiosszekap_nemrelevans_proc=null;
function admin_kpiosszekap_nemrelevans_proc(szerz_id,szerz_csop_id,szerz_tetel_modszam_kezi,i){
if($("#admin_modkpiosszekap_nemrelevans_"+i).prop('checked'))
 var kpi_nemrelevans=1;
else var kpi_nemrelevans=0;

if(ajax_admin_kpiosszekap_nemrelevans_proc!=null){
 ajax_admin_kpiosszekap_nemrelevans_proc.abort();
}

ajax_admin_kpiosszekap_nemrelevans_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_kpiosszekap_nemrelevans&szerz_id="+encodeURIComponent(szerz_id)+"&szerz_csop_id="+encodeURIComponent(szerz_csop_id)+"&szerz_tetel_modszam_kezi="+encodeURIComponent(szerz_tetel_modszam_kezi)+"&kpi_nemrelevans="+kpi_nemrelevans,
	function(d){
	ajax_admin_kpiosszekap_nemrelevans_proc=null;
	if(d=="ok$;$"){
	 $("#dialog_egyeni_close").dialog("close");
	 admin_kpiosszekaplist_keres("","");
	}else{
	 diaglog_open(d,"Rendszerhiba",'del_behajtani16.png');	
	}
	},"text");
}

var ajax_admin_kpiosszekap_kpiadd=null;
function admin_kpiosszekap_kpiadd(szerz_id,szerz_csop_id,szerz_tetel_modszam_kezi,i,darab){
$("#tr_admin_kpiosszekap_user_list_tal_"+i).addClass("kijelolve");

var reszl_html=$("#admin_modkpiosszekap_tdsor_"+i).html();

if(ajax_admin_kpiosszekap_kpiadd!=null){
 ajax_admin_kpiosszekap_kpiadd.abort();
}

ajax_admin_kpiosszekap_kpiadd=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_kpiosszekap_kpiadd&szerz_id="+encodeURIComponent(szerz_id)+"&szerz_csop_id="+encodeURIComponent(szerz_csop_id)+"&szerz_tetel_modszam_kezi="+encodeURIComponent(szerz_tetel_modszam_kezi)+"&reszl_html="+encodeURIComponent(reszl_html)+"&darab="+encodeURIComponent(darab),
	function(d){
	ajax_admin_kpiosszekap_kpiadd=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //diaglog_open(d1[1],"KPI típusok");	
	 dialog_kerdes('','KPI típusok',d1[1],'',function(){$("#tr_admin_kpiosszekap_user_list_tal_"+i).removeClass("kijelolve");});
	}else{
	 diaglog_open(d,"Rendszerhiba",'del_behajtani16.png');	
	}
	},"text");
}

function admin_kpiosszekaplist_keres_par(){
var mire1=encodeURIComponent($("#admin_kpiosszekaplist_keres_mire1").val());
var mit1=encodeURIComponent($("#admin_kpiosszekaplist_keres_mit1").val());
var mit1_value=encodeURIComponent($("#admin_kpiosszekaplist_keres_mit1 option:selected").text());

var mire2=encodeURIComponent($("#admin_kpiosszekaplist_keres_mire2").val());
var mit2=encodeURIComponent($("#admin_kpiosszekaplist_keres_mit2").val());
var mit2_value=encodeURIComponent($("#admin_kpiosszekaplist_keres_mit2 option:selected").text());

var mire3=encodeURIComponent($("#admin_kpiosszekaplist_keres_mire3").val());
var mit3=encodeURIComponent($("#admin_kpiosszekaplist_keres_mit3").val());
var mit3_value=encodeURIComponent($("#admin_kpiosszekaplist_keres_mit3 option:selected").text());

//új
var mire4=encodeURIComponent($("#admin_kpiosszekaplist_keres_mire4").val());
var mit4=encodeURIComponent($("#admin_kpiosszekaplist_keres_mit4").val());
var mit4_value=encodeURIComponent($("#admin_kpiosszekaplist_keres_mit4 option:selected").text());

//új
var mire5=encodeURIComponent($("#admin_kpiosszekaplist_keres_mire5").val());
var mit5=encodeURIComponent($("#admin_kpiosszekaplist_keres_mit5").val());
var mit5_value=encodeURIComponent($("#admin_kpiosszekaplist_keres_mit5 option:selected").text());

var szerz_tetel_id=encodeURIComponent($("#admin_kpiosszekaplist_keres_szerztetelid").val());

//új
var szerzmodszam=encodeURIComponent($("#admin_kpiosszekaplist_keres_szerzmodszam").val());

//új
var kpitipus_allapot=encodeURIComponent($("#admin_kpiosszekaplist_keres_kpitipus_allapot").val());

//új
var kpi_nemrelevans=encodeURIComponent($("#admin_kpiosszekaplist_keres_nemrelevans").val());

var kpi_tipus=encodeURIComponent($("#admin_kpiosszekaplist_keres_kpitipus").val());

//új minden dátum
var szerz_tetel_szerz_date_hatalybelep_tol=encodeURIComponent($("#admin_kpiosszekaplist_keres_szerz_tetel_szerz_date_hatalybelep_tol").val());
var szerz_tetel_szerz_date_hatalybelep_ig=encodeURIComponent($("#admin_kpiosszekaplist_keres_szerz_tetel_szerz_date_hatalybelep_ig").val());
var szerz_tetel_szolg_kezd_date_tol=encodeURIComponent($("#admin_kpiosszekaplist_keres_szerz_tetel_szolg_kezd_date_tol").val());
var szerz_tetel_szolg_kezd_date_ig=encodeURIComponent($("#admin_kpiosszekaplist_keres_szerz_tetel_szolg_kezd_date_ig").val());
var szerz_tetel_szerz_tetel_alair_date_tol=encodeURIComponent($("#admin_kpiosszekaplist_keres_szerz_tetel_szerz_tetel_alair_date_tol").val());
var szerz_tetel_szerz_tetel_alair_date_ig=encodeURIComponent($("#admin_kpiosszekaplist_keres_szerz_tetel_szerz_tetel_alair_date_ig").val());
var szerz_tetel_szolg_mod_date_tol=encodeURIComponent($("#admin_kpiosszekaplist_keres_szerz_tetel_szolg_mod_date_tol").val());
var szerz_tetel_szolg_mod_date_ig=encodeURIComponent($("#admin_kpiosszekaplist_keres_szerz_tetel_szolg_mod_date_ig").val());

if($("#admin_kpiosszekaplist_keres_ck").prop('checked')){
 var ellenorizendo=1;
}else{
 var ellenorizendo=0;
}

if($("#admin_kpiosszekaplist_keres_akt").prop('checked')){
 var akt='1';
}else{
 var akt='0';
}

var par="&mire1="+mire1+"&mit1="+mit1+"&mire2="+mire2+"&mit2="+mit2+"&mire3="+mire3+"&mit3="+mit3+"&mire4="+mire4+"&mit4="+mit4+"&mire5="+mire5+"&mit5="+mit5;
par+="&szerz_tetel_id="+szerz_tetel_id+"&szerzmodszam="+szerzmodszam;

par+="&mit1_value="+mit1_value+"&mit2_value="+mit2_value+"&mit3_value="+mit3_value+"&mit4_value="+mit4_value+"&mit5_value="+mit5_value;
par+="&ellenorizendo="+ellenorizendo+"&kpitipus_allapot="+kpitipus_allapot+"&kpi_nemrelevans="+kpi_nemrelevans+"&kpi_tipus="+kpi_tipus+"&akt="+akt;
par+="&szerz_tetel_szerz_date_hatalybelep_tol="+szerz_tetel_szerz_date_hatalybelep_tol;
par+="&szerz_tetel_szerz_date_hatalybelep_ig="+szerz_tetel_szerz_date_hatalybelep_ig;
par+="&szerz_tetel_szolg_kezd_date_tol="+szerz_tetel_szolg_kezd_date_tol;
par+="&szerz_tetel_szolg_kezd_date_ig="+szerz_tetel_szolg_kezd_date_ig;
par+="&szerz_tetel_szerz_tetel_alair_date_tol="+szerz_tetel_szerz_tetel_alair_date_tol;
par+="&szerz_tetel_szerz_tetel_alair_date_ig="+szerz_tetel_szerz_tetel_alair_date_ig;
par+="&szerz_tetel_szolg_mod_date_tol="+szerz_tetel_szolg_mod_date_tol;
par+="&szerz_tetel_szolg_mod_date_ig="+szerz_tetel_szolg_mod_date_ig;

return par;
}


var admin_kpiosszekaplist_keres_fo_wait="";
function admin_kpiosszekaplist_keres(id_honnan,hol_lep){
  clearTimeout(admin_kpiosszekaplist_keres_fo_wait);
  admin_kpiosszekaplist_keres_fo_wait = setTimeout(function(){admin_kpiosszekaplist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_kpiosszekaplist_keres_proc=null;
function admin_kpiosszekaplist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_kpiosszekaplist");
var par=admin_kpiosszekaplist_keres_par();

var scroll_poz=$("#scroll2").scrollLeft();

if(ajax_admin_kpiosszekaplist_keres_proc!=null){
 ajax_admin_kpiosszekaplist_keres_proc.abort();
}

ajax_admin_kpiosszekaplist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_kpiosszekaplist_keres"+ker_par+par,
	function(d){
	ajax_admin_kpiosszekaplist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_kpiosszekap_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 $("#scroll2").scrollLeft(scroll_poz);
	 duplakpiosszekapcsadmin_list_scrool_bar();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_admin_kpiosszekaplist_kpiadd_change=null;
function admin_kpiosszekaplist_kpiadd_change(szerz_id,szerz_csop_id,szerz_tetel_modszam_kezi,kpi_tipus_id){

if($("#admin_kpiosszekaplist_kpiadd_ck_"+kpi_tipus_id).prop('checked')){
 var mit='1';
}else{
 var mit='0';
}

if(ajax_admin_kpiosszekaplist_kpiadd_change!=null){
 ajax_admin_kpiosszekaplist_kpiadd_change.abort();
}

ajax_admin_kpiosszekaplist_kpiadd_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_kpiosszekaplist_kpiadd_change&szerz_id="+encodeURIComponent(szerz_id)+"&szerz_csop_id="+encodeURIComponent(szerz_csop_id)+"&szerz_tetel_modszam_kezi="+encodeURIComponent(szerz_tetel_modszam_kezi)+"&kpi_tipus_id="+encodeURIComponent(kpi_tipus_id)+"&mit="+mit,
	function(d){
	ajax_admin_kpiosszekap_kpiadd=null;
	if(d=="ok$;$"){
	 admin_kpiosszekaplist_keres("","");
	}else{
	 diaglog_open(d,"Rendszerhiba",'del_behajtani16.png');	
	}
	},"text");
}

var ajax_admin_kpiosszekaplist_kpiadd_ck=null;
function admin_kpiosszekaplist_kpiadd_ck(szerz_id,szerz_csop_id,szerz_tetel_modszam_kezi){

if(ajax_admin_kpiosszekaplist_kpiadd_ck!=null){
 ajax_admin_kpiosszekaplist_kpiadd_ck.abort();
}

ajax_admin_kpiosszekaplist_kpiadd_ck=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_kpiosszekaplist_kpiadd_ck&szerz_id="+encodeURIComponent(szerz_id)+"&szerz_csop_id="+encodeURIComponent(szerz_csop_id)+"&szerz_tetel_modszam_kezi="+encodeURIComponent(szerz_tetel_modszam_kezi),
	function(d){
	ajax_admin_kpiosszekaplist_kpiadd_ck=null;
	if(d=="ok$;$"){
	 $("#admin_kpiosszekap_kpiadd_ell_submit").css("display","none");
	 admin_kpiosszekaplist_keres("","");
	}else{
	 diaglog_open(d,"Rendszerhiba",'del_behajtani16.png');	
	}
	},"text");
}

var admin_modkpiosszekap_ment_fo_wait="";
function admin_modkpiosszekap_ment(szerz_id,szerz_csop_id,szerz_tetel_modszam_kezi,i){
  clearTimeout(admin_modkpiosszekap_ment_fo_wait);
  admin_modkpiosszekap_ment_fo_wait = setTimeout(function(){admin_modkpiosszekap_ment_proc(szerz_id,szerz_csop_id,szerz_tetel_modszam_kezi,i);},100);
}

var ajax_keres_admin_modkpiosszekap_ment_proc_proc=null;
function admin_modkpiosszekap_ment_proc(szerz_id,szerz_csop_id,szerz_tetel_modszam_kezi,i){

var megj=encodeURIComponent($("#admin_modkpiosszekap_megj_"+i).val());

if(ajax_keres_admin_modkpiosszekap_ment_proc_proc!=null){
 ajax_keres_admin_modkpiosszekap_ment_proc_proc.abort();
}

var par="&szerz_id="+encodeURIComponent(szerz_id)+"&szerz_csop_id="+encodeURIComponent(szerz_csop_id)+"&szerz_tetel_modszam_kezi="+encodeURIComponent(szerz_tetel_modszam_kezi)+"&megj="+megj;
ajax_keres_admin_modkpiosszekap_ment_proc_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkpiosszekap_ment_proc"+par,
	function(d){
	ajax_keres_admin_modkpiosszekap_ment_proc_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
