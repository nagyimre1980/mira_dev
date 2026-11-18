<?php

?>

function admin_szervlist_keres_par(){
var nev=encodeURIComponent($("#admin_szervlist_keres_nev").val());
var csoport_id=encodeURIComponent($("#admin_szervlist_keres_csopnev").val());
var inaktiv=encodeURIComponent($("#admin_szervlist_keres_inaktiv").val());
var par="&nev="+nev+"&csoport_id="+csoport_id+"&inaktiv="+inaktiv;
return par;
}

var admin_szervlist_keres_fo_wait="";
function admin_szervlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_szervlist_keres_fo_wait);
  admin_szervlist_keres_fo_wait = setTimeout(function(){admin_szervlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_szervlist_keres=null;
function admin_szervlist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_szervlist_keres_tal_oldalholvagyok","admin_szervlist_keres_tal_oldalmax","szervlist_keres_talszam","admin_szervlist_keres_proc");

var par=admin_szervlist_keres_par();

if(ajax_keres_szervlist_keres!=null){
 ajax_keres_szervlist_keres.abort();
}

ajax_keres_szervlist_keres=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szervlist_keres"+ker_par+par,
	function(d){
	ajax_keres_szervlist_keres=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_szerv_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	 duplaszervadmin_list_scrool_bar();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function duplaszervadmin_list_scrool_bar(){
    $("#scroll1 div").width($("#admin_szervlist_table").outerWidth(true));
    var ignoreScroll_szerv = false; // Zászló a végtelen ciklus ellen
	$("#scroll1").on("scroll", function(){
		 if (!ignoreScroll_szerv) {
         ignoreScroll_szerv = true;
         $("#scroll2").scrollLeft($(this).scrollLeft());
        
         // Hagyunk egy pici időt, majd levesszük a zászlót
         requestAnimationFrame(function(){
            ignoreScroll_szerv = false;
         });
		}
    });
    $("#scroll2").on("scroll", function(){
		 if (!ignoreScroll_szerv) {
         ignoreScroll_szerv = true;
         $("#scroll1").scrollLeft($(this).scrollLeft());
        
         requestAnimationFrame(function() {
            ignoreScroll_szerv = false;
         });
		}
    });
}

function admin_ujszerv(){
var nev=encodeURIComponent($("#admin_ujszerv_nev").val());
var koltsegkod=encodeURIComponent($("#admin_uj_szerv_koltsegkod").val());
var adkod=encodeURIComponent($("#admin_uj_szerv_adkod").val());
var szolgkod=encodeURIComponent($("#admin_uj_szerv_szolgkod").val());
var csoport_id=encodeURIComponent($("#admin_uj_szerv_csopid").val());
var smkod=encodeURIComponent($("#admin_uj_szerv_smkod").val());
var projekt_id=encodeURIComponent($("#admin_uj_szerv_proj_id").val());
var jovahagyo_id=$("#admin_uj_szerv_jovahagyo_id").val();

if(nev=="" || projekt_id=="" || jovahagyo_id=="" || koltsegkod=="" || adkod=="" || szolgkod=="keremv" || csoport_id=='keremv' ||smkod==''){
 diaglog_open("Minden mező kitöltése kötelező!","Hiba");
}else{
 admin_ujszerv_ment(nev,koltsegkod,adkod,projekt_id,jovahagyo_id,szolgkod,csoport_id,smkod);
}
}

var ajax_keres_admin_ujszerv_ment=null;
function admin_ujszerv_ment(nev,koltsegkod,adkod,projekt_id,jovahagyo_id,szolgkod,csoport_id,smkod){

if(ajax_keres_admin_ujszerv_ment!=null){
 ajax_keres_admin_ujszerv_ment.abort();
}

ajax_keres_admin_ujszerv_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujszerv_ment&nev="+nev+"&koltsegkod="+koltsegkod+"&adkod="+adkod+"&projekt_id="+projekt_id+"&jovahagyo_id="+jovahagyo_id+"&szolgkod="+szolgkod+"&csoport_id="+csoport_id+"&smkod="+smkod,
	function(d){
	ajax_keres_admin_ujszerv_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}



var ajax_keres_admin_uj_szerv_proj_katt=null;
function admin_uj_szerv_proj_katt(){
var projekt_id=$("#admin_uj_szerv_proj_id").val();

if(ajax_keres_admin_uj_szerv_proj_katt!=null){
 ajax_keres_admin_uj_szerv_proj_katt.abort();
}

ajax_keres_admin_uj_szerv_proj_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_uj_szerv_proj_katt&projekt_id="+projekt_id,
	function(d){
	ajax_keres_admin_uj_szerv_proj_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Tevékenységek");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_ujproj_hozz_keress=null;
function admin_ujproj_hozz_keress(){
var projekt_id=$("#admin_uj_szerv_proj_id").val();
var projekt_nev=encodeURIComponent($("#proj_hozzid_keress").val());

if(ajax_keres_ujproj_hozz_keress!=null){
 ajax_keres_ujproj_hozz_keress.abort();
}

ajax_keres_ujproj_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujproj_hozz_keress&projekt_id="+projekt_id+"&projekt_nev="+projekt_nev,
	function(d){
	ajax_keres_ujproj_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#proj_hozzid_tal_div").html(d1[1]);
	 admin_ujproj_hozz_change();
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	});
}

function admin_ujproj_hozzall_change(){

$("input[type=checkbox][id^=proj_hozzid_]").each(function(){
 var _this=$(this);
 if(_this.css("display")!='none')
  _this.trigger("click");
})
}

function admin_ujproj_hozz_change(){

var v="";
var projekt_nev="";
var projekt_szam=0;
var allbepip=1;
$("input[type=checkbox][id^=proj_hozzid_]").each(function(){
var _this=$(this);
if(_this.prop("checked")){
 if(v!="")v+=",";
 v+=_this.attr("projekt_id");
 
 /*if(projekt_nev!="")projekt_nev+="<br>";
 projekt_nev+=$(this).attr("projekt_nev");*/
 projekt_szam++;
 
}else if(_this.css("display")!='none') allbepip=0;
});

if(allbepip==1)
 $("#proj_hozzidall").prop("checked",true);
else
 $("#proj_hozzidall").prop("checked",false);

//if(projekt_nev=="")projekt_nev="Projekt hozzáadása";
if(projekt_szam==0)
 $("#admin_uj_szerv_proj_span").html("Tevékenység hozzáadása");
else
 $("#admin_uj_szerv_proj_span").html(projekt_szam);

$("#admin_uj_szerv_proj_id").val(v);
//$("#admin_uj_szerv_proj_span").html(projekt_nev);

}

var ajax_keres_admin_uj_szerv_jovahagyo_katt=null;
function admin_uj_szerv_jovahagyo_katt(){
var user_ad=$("#admin_uj_szerv_jovahagyo_id").val();

if(ajax_keres_admin_uj_szerv_jovahagyo_katt!=null){
 ajax_keres_admin_uj_szerv_jovahagyo_katt.abort();
}

ajax_keres_admin_uj_szerv_jovahagyo_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_uj_szerv_jovahagyo_katt&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_uj_szerv_jovahagyo_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Jóváhagyók");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var admin_ujproj_jovahagyo_keress_fo_wait="";
function admin_ujproj_jovahagyo_keress(id_honnan,hol_lep){
  clearTimeout(admin_ujproj_jovahagyo_keress_fo_wait);
  admin_ujproj_jovahagyo_keress_fo_wait = setTimeout(function(){admin_ujproj_jovahagyo_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_ujproj_jovahagyo_keress=null;
function admin_ujproj_jovahagyo_keress_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"user_ujtevekuserhozza_keres_tal_oldalholvagyok","user_ujtevekuserhozza_keres_tal_oldalmax","user_ujtevekuserhozza_keres_talszam","user_ujtevekuserhozza_keres_talszam");

var user_ad=$("#admin_uj_szerv_jovahagyo_id").val();
var user_nev=encodeURIComponent($("#proj_jovahagyoid_keress").val());

if(ajax_keres_ujproj_jovahagyo_keress!=null){
 ajax_keres_ujproj_jovahagyo_keress.abort();
}

ajax_keres_ujproj_jovahagyo_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujproj_jovahagyo_keress&user_ad="+user_ad+"&user_nev="+user_nev+ker_par,
	function(d){
	ajax_keres_ujproj_jovahagyo_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#proj_jovahagyoid_tal_div").html(d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

//var tomeg_ujprojujjovahagyo=new Array();
function admin_ujprojujjovahagyo_hozz_change(){
var v="";
var user_nev="";

$("input[type=checkbox][id^=projujjovahagyo_hozzid_]").each(function(){
if(!$(this).prop("checked")){
	var user_ad=$(this).attr("user_ad");
	//$("#admin_uj_szerv_jovahagyo_id").attr("user_ad_nev_"+user_ad,"");
	$("#admin_uj_szerv_jovahagyo_id").removeAttr("user_ad_nev_"+user_ad,"");
}
});

//korábbiak - eleje
var korabbi_user_ad_tomb=new Array();
var korabbi_ad_tomb=$("#admin_uj_szerv_jovahagyo_id").val();
if(korabbi_ad_tomb!=""){
var korabbi_user_ad=korabbi_ad_tomb.split(",");
for (var i = 0; i < korabbi_user_ad.length; i++) {
	
 var tmp_user_ad=korabbi_user_ad[i];
 korabbi_user_ad_tomb[tmp_user_ad]=korabbi_user_ad[i];
 
 var korabbi_user_nev=$("#admin_uj_szerv_jovahagyo_id").attr("user_ad_nev_"+korabbi_user_ad[i]);
 if(korabbi_user_nev!=""){
  if(v!="")v+=",";
  v+=korabbi_user_ad[i];
  
  if(user_nev!="")user_nev+="<br>";
  user_nev+=korabbi_user_nev;
 }
}
}
//korábbiak - vége

$("input[type=checkbox][id^=projujjovahagyo_hozzid_]").each(function(){
if($(this).prop("checked")){
 
 var user_ad=$(this).attr("user_ad");
 
 if(korabbi_user_ad_tomb[user_ad]===undefined){//korábbiak
 if(v!="")v+=",";
 v+=user_ad;
 
 if(user_nev!="")user_nev+="<br>";
 var user_nev_most=$(this).attr("user_nev");
 user_nev+=user_nev_most;
  
  $("#admin_uj_szerv_jovahagyo_id").attr("user_ad_nev_"+user_ad,user_nev_most);
 }
}
});

if(user_nev=="")user_nev="Jóváhagyók hozzáadása";

$("#admin_uj_szerv_jovahagyo_id").val(v);
$("#admin_uj_szerv_jovahagyo_span").html(user_nev);
}


var ajax_keres_admin_mod_szerv_jovahagyok_katt=null;
function admin_mod_szerv_jovahagyok_katt(szerv_id,szerv_nev){
var szerv_nev=encodeURIComponent(szerv_nev);

if(ajax_keres_admin_mod_szerv_jovahagyok_katt!=null){
 ajax_keres_admin_mod_szerv_jovahagyok_katt.abort();
}

ajax_keres_admin_mod_szerv_jovahagyok_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_szerv_jovahagyok_katt&csakvan=0&szerv_id="+szerv_id+"&szerv_nev="+szerv_nev,
	function(d){
	ajax_keres_admin_mod_szerv_jovahagyok_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Jóváhagyók");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_modszervjovahagyo_hozz_keress_par(){
var keress_nev=encodeURIComponent($("#szervjovahagyo_hozzid_keress").val());
var szerv_id=$("#szervjovahagyo_hozzid_keress").attr("szerv_id");
if($("#szervjovahagyo_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var par="&keress_nev="+keress_nev+"&szerv_id="+szerv_id+"&csakvan="+csakvan;
return par;
}

var admin_modszervjovahagyo_hozz_keress_fo_wait="";
function admin_modszervjovahagyo_hozz_keress(id_honnan,hol_lep){
  clearTimeout(admin_modszervjovahagyo_hozz_keress_fo_wait);
  admin_modszervjovahagyo_hozz_keress_fo_wait = setTimeout(function(){admin_modszervjovahagyo_hozz_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_modszervjovahagyo_hozz_keress=null;
function admin_modszervjovahagyo_hozz_keress_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"user_szervjovahagyo_keres_tal_oldalholvagyok","user_szervjovahagyo_keres_tal_oldalmax","user_szervjovahagyo_keres_talszam","admin_modszervjovahagyo_hozz_keress_proc");

var par=admin_modszervjovahagyo_hozz_keress_par();


if(ajax_keres_modszervjovahagyo_hozz_keress!=null){
 ajax_keres_modszervjovahagyo_hozz_keress.abort();
}

ajax_keres_modszervjovahagyo_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszervjovahagyo_hozz_keress"+ker_par+par,
	function(d){
	ajax_keres_modszervjovahagyo_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#szervjovahagyo_hozzid_tal_div").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_modszervjovahagyo_hozz_change=null;
function admin_modszervjovahagyo_hozz_change(user_ad,szerv_id){
if($("#szervjovahagyo_hozzid_"+user_ad).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_modszervjovahagyo_hozz_change!=null){
 ajax_keres_admin_modszervjovahagyo_hozz_change.abort();
}

ajax_keres_admin_modszervjovahagyo_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszervjovahagyo_hozz_change&mit="+mit+"&user_ad="+user_ad+"&szerv_id="+szerv_id,
	function(d){
	ajax_keres_admin_modszervjovahagyo_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#szervjovahagyo_hozzid_csakhozz_szur").prop("checked",false);
	 admin_modszervjovahagyo_hozz_keress("","");
	 //admin_muv_sel();
	 admin_szervlist_keres("","");
	}else if(d1[0]=="okutolso"){
		 $("#szervjovahagyo_hozzid_"+user_ad).prop("checked",true);
		 diaglog2_open(d1[1],"Hiba");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}


var ajax_keres_admin_mod_szerv_proj_katt=null;
function admin_mod_szerv_proj_katt(szerv_id,szerv_nev){
var szerv_nev=encodeURIComponent(szerv_nev);

if(ajax_keres_admin_mod_szerv_proj_katt!=null){
 ajax_keres_admin_mod_szerv_proj_katt.abort();
}

ajax_keres_admin_mod_szerv_proj_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_szerv_proj_katt&csakvan=0&szerv_id="+szerv_id+"&szerv_nev="+szerv_nev,
	function(d){
	ajax_keres_admin_mod_szerv_proj_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Tevékenységek");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_modproj_hozz_keress_par(){
var szerv_id=$("#proj_hozzid_keress").attr('szerv_id');
var projekt_nev=$("#proj_hozzid_keress").val();

if($("#proj_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var par="&csakvan="+csakvan+"&szerv_id="+szerv_id+"&projekt_nev="+projekt_nev;
return par;
}

var ajax_keres_modproj_hozz_keress=null;
function admin_modproj_hozz_keress(){

var par=admin_modproj_hozz_keress_par();

if(ajax_keres_modproj_hozz_keress!=null){
 ajax_keres_modproj_hozz_keress.abort();
}

ajax_keres_modproj_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modproj_hozz_keress"+par,
	function(d){
	ajax_keres_modproj_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#proj_hozzid_tal_div").html(d1[1]);
	
	var all_k=1;
	$('input[id^=proj_hozzid_').each(function(){
	var _this=$(this);
	if(this.id!="proj_hozzid_csakhozz_szur" && this.id!="proj_hozzid_keress" && _this.css("display")!='none' && !_this.prop("checked")){
	 all_k=0;
	}
	});
	if(all_k==1)$("#proj_allhozzid").prop("checked",true);
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_modproj_hozzall_change(szerv_id){
if($("#proj_allhozzid").prop("checked")){
	var title_ki="Összes tevékenység hozzárendelése";
	var d="Biztos, hogy hozzárendeled az összes tevékenységet?";
}else{
	var title_ki="Összes tevékenység hozzárendelés törlése";
	var d="Biztos, hogy törlöd az összes tevékenység hozzárendelését?";
}
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Igen": function() {
		 admin_modproj_hozzall_change_proc(szerv_id);
        },
        "Mégse": function() {
		  $("#proj_allhozzid").prop("checked",false);
          $(this).dialog("close");
        }
      },
	  open: function (event, ui){
        $("#ui-widget-overlay").fadeIn();
		$("#admin_moduser_admod_ad").trigger("focus");
      },
	  close: function (event, ui){
		$("#dialog_egyeni_close").dialog('widget').find('button').prop('disabled',false).css('color',"");
		$('#dialog_egyeni_close').html("");
		$('.ui-tooltip').remove();
		if(
		(!$('#dialog').dialog('isOpen'))&&
		(!$('#dialog2').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
      }
	}).dialog( "open" );
}

var ajax_keres_admin_modproj_hozzall_change=null;
function admin_modproj_hozzall_change_proc(szerv_id){
if($("#proj_allhozzid").prop("checked")){
 var mit=true;	
 var mit_tom=1;	
}else{
 var mit=false;
 var mit_tom=0;
}

var projekt_id_tom="";
$('input[id^=proj_hozzid_').each(function(){
var _this=$(this);
if(this.id!="proj_hozzid_csakhozz_szur" && this.id!="proj_hozzid_keress" && _this.css("display")!='none'){
 _this.prop("checked",mit);
 var d1=this.id.split("_");
 if(projekt_id_tom!="")projekt_id_tom+="-";
 projekt_id_tom+=d1[2];
}
});

if(ajax_keres_admin_modproj_hozzall_change!=null){
 ajax_keres_admin_modproj_hozzall_change.abort();
}

ajax_keres_admin_modproj_hozzall_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modproj_hozz_change_tom&mit_tom="+mit_tom+"&projekt_id_tom="+projekt_id_tom+"&szerv_id="+szerv_id,
	function(d){
	ajax_keres_admin_modproj_hozzall_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#proj_hozzid_csakhozz_szur").prop("checked",mit);
	 //admin_muv_sel();
	 $("#dialog_egyeni_close").dialog("close");
	 admin_szervlist_keres("","");
	}else{
	 $("#dialog_egyeni_close").dialog("close");
	 diaglog_open(d,"Rendszerhiba");
	}
	});

}

var ajax_keres_admin_modproj_hozz_change=null;
function admin_modproj_hozz_change(projekt_id,szerv_id){
if($("#proj_hozzid_"+projekt_id).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_modproj_hozz_change!=null){
 ajax_keres_admin_modproj_hozz_change.abort();
}

ajax_keres_admin_modproj_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modproj_hozz_change&mit="+mit+"&projekt_id="+projekt_id+"&szerv_id="+szerv_id,
	function(d){
	ajax_keres_admin_modproj_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#proj_hozzid_csakhozz_szur").prop("checked",false);
	 admin_modproj_hozz_keress();
	 
	if(mit==0){
	  $("#proj_allhozzid").prop("checked",false);
	}else{//összest be kell-e pipálni...
		var allbepi=1;
		$('input[id^=proj_hozzid_').each(function(){
		if(this.id!="proj_hozzid_csakhozz_szur" && this.id!="proj_hozzid_keress"){
		 if(!$(this).prop("checked"))
		  allbepi=0;
		}
		});
		if(allbepi==1)
		 $("#proj_allhozzid").prop("checked",true);
	}
	 
	 //admin_muv_sel();
	 admin_szervlist_keres("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_mod_szerv_user_katt=null;
function admin_mod_szerv_user_katt(szerv_id,szerv_nev){
var szerv_nev=encodeURIComponent(szerv_nev);

if(ajax_keres_admin_mod_szerv_user_katt!=null){
 ajax_keres_admin_mod_szerv_user_katt.abort();
}

ajax_keres_admin_mod_szerv_user_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_szerv_user_katt&csakvan=0&szerv_id="+szerv_id+"&szerv_nev="+szerv_nev,
	function(d){
	ajax_keres_admin_mod_szerv_user_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Felhasználók");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_modszerv_ment=null;
function admin_modszerv_ment(szerv_id){
var szerv_nev=encodeURIComponent($("#admin_ujszervmod_nev_"+szerv_id).val());
var koltsegkod=encodeURIComponent($("#admin_ujszervmod_koltsegkod_"+szerv_id).val());
var adkod=encodeURIComponent($("#admin_ujszervmod_adkod_"+szerv_id).val());
var szolgkod=encodeURIComponent($("#admin_ujszervmod_szolgkod_"+szerv_id).val());
var csopid=encodeURIComponent($("#admin_ujszervmod_csopnev_"+szerv_id).val());
var smkod=encodeURIComponent($("#admin_ujszervmod_smkod_"+szerv_id).val());

if(ajax_keres_admin_modszerv_ment!=null){
 ajax_keres_admin_modszerv_ment.abort();
}

ajax_keres_admin_modszerv_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszerv_ment&szerv_nev="+szerv_nev+"&szerv_id="+szerv_id+"&koltsegkod="+koltsegkod+"&adkod="+adkod+"&szolgkod="+szolgkod+"&csopid="+csopid+"&smkod="+smkod,
	function(d){
	ajax_keres_admin_modszerv_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_modszerv_inaktiv=null;
function admin_modszerv_inaktiv(szerv_id){

if($("#admin_ujszervmod_inaktiv_"+szerv_id).prop("checked")){
 var inaktiv=1;
}else{
 var inaktiv=0;
}

if(ajax_keres_admin_modszerv_inaktiv!=null){
 ajax_keres_admin_modszerv_inaktiv.abort();
}

ajax_keres_admin_modszerv_inaktiv=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszerv_inaktiv&szerv_id="+szerv_id+"&inaktiv="+inaktiv,
	function(d){
	ajax_keres_admin_modszerv_inaktiv=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else if(d1[0]=="nook_vantagja"){
     diaglog_open(d1[1],"Hiba");
     $("#admin_ujszervmod_inaktiv_"+szerv_id).prop("checked",false);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}