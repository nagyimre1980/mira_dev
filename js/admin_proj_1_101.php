<?php

?>

function admin_ujmodproj_date_delete(id){
var c=event.keyCode;
if(c == 46 || c==8){//Del backspace
 $("#"+id).val("").trigger('change');
}else{
 return false;
}
}

function admin_ujprojekt(){
var projekt_nev=encodeURIComponent($("#admin_ujprojekt_nev").val());
var projekt_title=encodeURIComponent($("#admin_uj_projekt_title").val());

var tagvkod=encodeURIComponent($("#admin_ujprojekt_tagvkod").val());
var szolgkod=encodeURIComponent($("#admin_ujprojekt_szolgkod").val());
var kat_id=encodeURIComponent($("#admin_ujprojekt_kat_id").val());
var co=encodeURIComponent($("#admin_ujprojekt_co").val());

//projekt_tipus=encodeURIComponent($("#admin_ujprojekt_tipus option:selected").val());
var szerv_id=encodeURIComponent($("#admin_uj_projekt_szerv_id").val());
var user_ad=encodeURIComponent($("#admin_uj_projekt_user_id").val());

var kezd_date=encodeURIComponent($("#admin_ujprojekt_kezddate").val());
var veg_date=encodeURIComponent($("#admin_ujprojekt_vegdate").val());

//if(projekt_nev=="" || projekt_tipus=="keremv"){
if(projekt_nev==""){
 //diaglog_open("Projekt nevének kitöltése és Projekt típusának kiválasztása kötelező!","Hiba");
 diaglog_open("Tevékenység nevének kitöltése kötelező!","Hiba","del_behajtani16.png");
}else if(kezd_date==""){
  diaglog_open("Rögzítés kezdete kitöltése kötelező!","Hiba","del_behajtani16.png");
}else if(tagvkod==""){
 diaglog_open("Társasági SAP kód kitöltése kötelező!","Hiba","del_behajtani16.png");
}else if(szolgkod==""){
 diaglog_open("Tevékenységek szolgáltatás kód kitöltése kötelező!","Hiba","del_behajtani16.png");
}else if(kat_id=="" ||kat_id=="keremv"){
  diaglog_open("Kategória kitöltése kötelező!","Hiba","del_behajtani16.png");
}else{
 //admin_ujprojekt_ment(projekt_nev,projekt_title,szerv_id,user_ad,projekt_tipus);
 admin_ujprojekt_ment(projekt_nev,projekt_title,szerv_id,user_ad,tagvkod,szolgkod,kat_id,co,kezd_date,veg_date);
}
}

var ajax_keres_admin_ujprojekt_ment=null;
function admin_ujprojekt_ment(projekt_nev,projekt_title,szerv_id,user_ad,tagvkod,szolgkod,kat_id,co,kezd_date,veg_date){
$("#admin_ujprojekt_submit").prop("disabled",true);

if(ajax_keres_admin_ujprojekt_ment!=null){
 ajax_keres_admin_ujprojekt_ment.abort();
}

ajax_keres_admin_ujprojekt_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujprojekt_ment&projekt_nev="+projekt_nev+"&projekt_title="+projekt_title+"&szerv_id="+szerv_id+"&user_ad="+user_ad+"&tagvkod="+tagvkod+"&szolgkod="+szolgkod+"&kat_id="+kat_id+"&co="+co+"&kezd_date="+kezd_date+"&veg_date="+veg_date,
	function(d){
	ajax_keres_admin_ujprojekt_ment=null;
	
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else{
	 $("#admin_ujprojekt_submit").prop("disabled",false);
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var admin_modprojekt_ment_fo_wait="";
function admin_modprojekt_ment(projekt_id){
  clearTimeout(admin_modprojekt_ment_fo_wait);
  admin_modprojekt_ment_fo_wait = setTimeout(function(){admin_modprojekt_ment_proc(projekt_id);},100);
}

var ajax_keres_admin_modprojekt_ment=null;
function admin_modprojekt_ment_proc(projekt_id){
var tagvkod=encodeURIComponent($("#admin_ujprojktmod_tagvkod_"+projekt_id).val());
var szolgkod=encodeURIComponent($("#admin_ujprojktmod_szolgkod_"+projekt_id).val());
var kat=encodeURIComponent($("#admin_ujprojktmod_kat_"+projekt_id).val());
var co=encodeURIComponent($("#admin_ujprojktmod_co_"+projekt_id).val());
var kezd_date=encodeURIComponent($("#admin_ujprojktmod_kezddate_"+projekt_id).val());
var veg_date=encodeURIComponent($("#admin_ujprojktmod_vegdate_"+projekt_id).val());

var projekt_nev_orig=$("#admin_ujprojktmod_nev_"+projekt_id).val();
var projekt_nev=encodeURIComponent(projekt_nev_orig);
//projekt_tipus=encodeURIComponent($("#admin_ujprojktmod_tipus_"+projekt_id+" option:selected").val());

if(ajax_keres_admin_modprojekt_ment!=null){
 ajax_keres_admin_modprojekt_ment.abort();
}

ajax_keres_admin_modprojekt_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modprojekt_ment&projekt_nev="+projekt_nev+"&projekt_id="+encodeURIComponent(projekt_id)+"&tagvkod="+tagvkod+"&szolgkod="+szolgkod+"&kat="+kat+"&co="+co+"&kezd_date="+kezd_date+"&veg_date="+veg_date,
	function(d){
	ajax_keres_admin_modprojekt_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //tooltip frissítése, mert ha a nevet átírták..
	 var title_ki="<b>"+projekt_nev_orig+"</b>"+$("#admin_ujprojktmod_tooltipnyers_"+projekt_id).html();
	 $("#admin_ujprojktmod_tooltip_"+projekt_id).attr("title",title_ki);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_modprojekt_inaktiv=null;
function admin_modprojekt_inaktiv(projekt_id){

if($("#admin_ujprojektmod_inaktiv_"+projekt_id).prop("checked")){
 var inaktiv=1;
}else{
 var inaktiv=0;
}

if(ajax_keres_admin_modprojekt_inaktiv!=null){
 ajax_keres_admin_modprojekt_inaktiv.abort();
}

ajax_keres_admin_modprojekt_inaktiv=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modprojekt_inaktiv&projekt_id="+projekt_id+"&inaktiv="+inaktiv,
	function(d){
	ajax_keres_admin_modprojekt_inaktiv=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 /////////////admin_muv_sel();
	 admin_projektlist_keres("","");
	 $('.ui-tooltip').remove();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_mod_proj_szerv_katt=null;
function admin_mod_proj_szerv_katt(projekt_id,projekt_nev){
var projekt_nev=encodeURIComponent(projekt_nev);

if(ajax_keres_admin_mod_proj_szerv_katt!=null){
 ajax_keres_admin_mod_proj_szerv_katt.abort();
}

ajax_keres_admin_mod_proj_szerv_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_proj_szerv_katt&csakvan=0&katkivetel_csakvan=0&projekt_id="+projekt_id+"&projekt_nev="+projekt_nev,
	function(d){
	ajax_keres_admin_mod_proj_szerv_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Szervezetek");
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_modszerv_hozz_keress_par(){
var projekt_id=$("#szerv_hozzid_keress").attr("projekt_id");
var szerv_nev=$("#szerv_hozzid_keress").val();
if($("#szerv_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

if($("#szerv_hozzid_csakkatkivetel_szur").prop("checked")){
 var katkivetel_csakvan=1;
}else{
 var katkivetel_csakvan=0;
}

var par="&csakvan="+csakvan+"&projekt_id="+projekt_id+"&szerv_nev="+szerv_nev+"&katkivetel_csakvan="+katkivetel_csakvan;
return par;
}

var ajax_keres_modszerv_hozz_keress=null;
function admin_modszerv_hozz_keress(){

var par=admin_modszerv_hozz_keress_par();

if(ajax_keres_modszerv_hozz_keress!=null){
 ajax_keres_modszerv_hozz_keress.abort();
}

ajax_keres_modszerv_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszerv_hozz_keress"+par,
	function(d){
	ajax_keres_modszerv_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#szerv_hozzid_tal_div").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_modszerv_katkivetel_change=null;
function admin_modszerv_katkivetel_change(szerv_id,projekt_id){
var katkivetel=encodeURIComponent($("#szerv_katkivetelid_"+szerv_id).val());

if(ajax_keres_admin_modszerv_katkivetel_change!=null){
 ajax_keres_admin_modszerv_katkivetel_change.abort();
}

ajax_keres_admin_modszerv_katkivetel_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszerv_katkivetel_change&szerv_id="+encodeURIComponent(szerv_id)+"&projekt_id="+encodeURIComponent(projekt_id)+"&katkivetel="+katkivetel,
	function(d){
	ajax_keres_admin_modszerv_katkivetel_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){

	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_modszerv_hozz_change=null;
function admin_modszerv_hozz_change(szerv_id,projekt_id){
if($("#szerv_hozzid_"+szerv_id).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_modszerv_hozz_change!=null){
 ajax_keres_admin_modszerv_hozz_change.abort();
}

ajax_keres_admin_modszerv_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszerv_hozz_change&mit="+mit+"&szerv_id="+encodeURIComponent(szerv_id)+"&projekt_id="+encodeURIComponent(projekt_id),
	function(d){
	ajax_keres_admin_modszerv_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#szerv_hozzid_csakhozz_szur").prop("checked",false);
	 admin_modszerv_hozz_keress();
	 //admin_muv_sel();
	 admin_projektlist_keres("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_modszerv_hozzall_change(projekt_id){
if($("#szerv_allhozzid").prop("checked")){
	var title_ki="Összes szervezet hozzárendelése";
	var d="Biztos, hogy hozzárendeled az összes szervezetet?";
}else{
	var title_ki="Összes szervezet hozzárendelés törlése";
	var d="Biztos, hogy törlöd az összes szervezet hozzárendelését?";
}
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Igen": function() {
		 admin_modszerv_hozzall_change_proc(projekt_id);
        },
        "Mégse": function() {
		  $("#szerv_allhozzid").prop("checked",false);
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

var ajax_keres_admin_modszerv_hozzall_change=null;
function admin_modszerv_hozzall_change_proc(projekt_id){
if($("#szerv_allhozzid").prop("checked")){
 var mit=true;	
 var mit_tom=1;	
}else{
 var mit=false;
 var mit_tom=0;
}

var szerv_id_tom="";
$('input[id^=szerv_hozzid_').each(function(){
if(this.id!="szerv_hozzid_csakhozz_szur" && this.id!="szerv_hozzid_keress"){
 $(this).prop("checked",mit);
 var d1=this.id.split("_");
 if(szerv_id_tom!="")szerv_id_tom+="-";
 szerv_id_tom+=d1[2];
}
});

if(ajax_keres_admin_modszerv_hozzall_change!=null){
 ajax_keres_admin_modszerv_hozzall_change.abort();
}

ajax_keres_admin_modszerv_hozzall_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modszerv_hozzall_change&mit_tom="+mit_tom+"&szerv_id_tom="+szerv_id_tom+"&projekt_id="+projekt_id,
	function(d){
	ajax_keres_admin_modszerv_hozzall_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#proj_hozzid_csakhozz_szur").prop("checked",mit);
	 //admin_muv_sel();
	 $("#dialog_egyeni_close").dialog("close");
	 admin_projektlist_keres("","");
	}else{
	 $("#dialog_egyeni_close").dialog("close");
	 diaglog_open(d,"Rendszerhiba");
	}
	});

}

var ajax_keres_admin_mod_proj_title_katt=null;
function admin_mod_proj_title_katt(projekt_id){

if(ajax_keres_admin_mod_proj_title_katt!=null){
 ajax_keres_admin_mod_proj_title_katt.abort();
}

ajax_keres_admin_mod_proj_title_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_proj_title_katt&projekt_id="+projekt_id,
	function(d){
	ajax_keres_admin_mod_proj_title_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Leírás");
	 var _this_title=$("#admin_mod_projekt_title");
	 _this_title.trigger("focus");
	 autosize(_this_title);
	 
	 //Hossz lerendezése
	 _this_title.on("keyup",function(){//input change keyup
		$("#admin_mod_projekt_title_hossz").html($(this).val().length);
	 });
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_mod_proj_title_save=null;
function admin_mod_proj_title_save(projekt_id){
var projekt_title=encodeURIComponent($("#admin_mod_projekt_title").val());

if(ajax_keres_admin_mod_proj_title_save!=null){
 ajax_keres_admin_mod_proj_title_save.abort();
}

ajax_keres_admin_mod_proj_title_save=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_proj_title_save&projekt_id="+projekt_id+"&projekt_title="+projekt_title,
	function(d){
	ajax_keres_admin_mod_proj_title_save=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $('#dialog').dialog("close");
	 admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_mod_proj_user_katt=null;
function admin_mod_proj_user_katt(projekt_id,projekt_nev){
var projekt_nev=encodeURIComponent(projekt_nev);

if(ajax_keres_admin_mod_proj_user_katt!=null){
 ajax_keres_admin_mod_proj_user_katt.abort();
}

ajax_keres_admin_mod_proj_user_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_proj_user_katt&csakvan=0&projekt_id="+projekt_id+"&projekt_nev="+projekt_nev,
	function(d){
	ajax_keres_admin_mod_proj_user_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Felhasználók");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_moduser_hozz_keress_par(){
var projekt_id=$("#user_hozzid_keress").attr("projekt_id");
var keress_nev=encodeURIComponent($("#user_hozzid_keress").val());

if($("#user_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var par="&projekt_id="+projekt_id+"&keress_nev="+keress_nev+"&csakvan="+csakvan;
return par;
}

var admin_moduser_hozz_keress_fo_wait="";
function admin_moduser_hozz_keress(id_honnan,hol_lep){
  clearTimeout(admin_moduser_hozz_keress_fo_wait);
  admin_moduser_hozz_keress_fo_wait = setTimeout(function(){admin_moduser_hozz_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_moduser_hozz_keress=null;
function admin_moduser_hozz_keress_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"user_projuserhozza_keres_tal_oldalholvagyok","user_projuserhozza_keres_tal_oldalmax","user_projuserhozza_keres_talszam","admin_moduser_hozz_keress_proc");

var par=admin_moduser_hozz_keress_par();

if(ajax_keres_moduser_hozz_keress!=null){
 ajax_keres_moduser_hozz_keress.abort();
}

ajax_keres_moduser_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_hozz_keress"+ker_par+par,
	function(d){
	ajax_keres_moduser_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#user_hozzid_tal_div").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_hozz_change=null;
function admin_moduser_hozz_change(user_ad,projekt_id){
if($("#user_hozzid_"+user_ad).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_moduser_hozz_change!=null){
 ajax_keres_admin_moduser_hozz_change.abort();
}

ajax_keres_admin_moduser_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_hozz_change&mit="+mit+"&user_ad="+user_ad+"&projekt_id="+projekt_id,
	function(d){
	ajax_keres_admin_moduser_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#user_hozzid_csakhozz_szur").prop("checked",false);
	 admin_moduser_hozz_keress("","");
	 //admin_muv_sel();
	 admin_projektlist_keres("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_mod_proj_userjovahagyo_katt=null;
function admin_mod_proj_userjovahagyo_katt(projekt_id,projekt_nev){
var projekt_nev=encodeURIComponent(projekt_nev);

if(ajax_keres_admin_mod_proj_userjovahagyo_katt!=null){
 ajax_keres_admin_mod_proj_userjovahagyo_katt.abort();
}

ajax_keres_admin_mod_proj_userjovahagyo_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_proj_userjovahagyo_katt&csakvan=0&projekt_id="+projekt_id+"&projekt_nev="+projekt_nev,
	function(d){
	ajax_keres_admin_mod_proj_userjovahagyo_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Projekt jóváhagyók");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_moduserjovahagyo_hozz_keress_par(){
var projekt_id=$("#userjovahagyo_hozzid_keress").attr("projekt_id");
var keress_nev=encodeURIComponent($("#userjovahagyo_hozzid_keress").val());

if($("#userjovahagyo_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var par="&projekt_id="+projekt_id+"&keress_nev="+keress_nev+"&csakvan="+csakvan;
return par;
}

var ajax_keres_moduserjovahagyo_hozz_keress=null;
	
var admin_moduserjovahagyo_hozz_keress_fo_wait="";
function admin_moduserjovahagyo_hozz_keress(id_honnan,hol_lep){
  clearTimeout(admin_moduserjovahagyo_hozz_keress_fo_wait);
  admin_moduserjovahagyo_hozz_keress_fo_wait = setTimeout(function(){admin_moduserjovahagyo_hozz_keress_proc(id_honnan,hol_lep);},100);
}

function admin_moduserjovahagyo_hozz_keress_proc(id_honnan,hol_lep){	

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"user_projuserjovahagyohozza_keres_tal_oldalholvagyok","user_projuserjovahagyohozza_keres_tal_oldalmax","user_projuserjovahagyohozza_keres_talszam","admin_moduserjovahagyo_hozz_keress_proc");

var par=admin_moduserjovahagyo_hozz_keress_par();

if(ajax_keres_moduserjovahagyo_hozz_keress!=null){
 ajax_keres_moduserjovahagyo_hozz_keress.abort();
}

ajax_keres_moduserjovahagyo_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduserjovahagyo_hozz_keress"+ker_par+par,
	function(d){
	ajax_keres_moduserjovahagyo_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#userjovahagyo_hozzid_tal_div").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});

}

var ajax_keres_admin_moduserjovahagyo_hozz_change=null;
function admin_moduserjovahagyo_hozz_change(user_ad,projekt_id){
if($("#userjovahagyo_hozzid_"+user_ad).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_moduserjovahagyo_hozz_change!=null){
 ajax_keres_admin_moduserjovahagyo_hozz_change.abort();
}

ajax_keres_admin_moduserjovahagyo_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduserjovahagyo_hozz_change&mit="+mit+"&user_ad="+user_ad+"&projekt_id="+projekt_id,
	function(d){
	ajax_keres_admin_moduserjovahagyo_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_moduserjovahagyo_hozz_keress("","");
	 admin_projektlist_keres("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_mod_proj_maxido_katt=null;
function admin_mod_proj_maxido_katt(projekt_id,projekt_nev){
var projekt_nev=encodeURIComponent(projekt_nev);

if(ajax_keres_admin_mod_proj_maxido_katt!=null){
 ajax_keres_admin_mod_proj_maxido_katt.abort();
}

ajax_keres_admin_mod_proj_maxido_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_proj_maxido_katt&projekt_id="+projekt_id+"&projekt_nev="+projekt_nev,
	function(d){
	ajax_keres_admin_mod_proj_maxido_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#dialog_egyeni_close").html(d1[1]).dialog({title:"Havonta rögzíthető max óra"}).dialog( "open" );
	 admin_mod_proj_maxido_katt_spinner();
	 if($("#projekt_max_all_span").css("display")!="none"){
		//$("#projekt_max_all").focus().select();
		$("#projekt_max_all").trigger("focus").trigger("select");
	 }else{
		 tooltip_proc();
		 //$("#projekt_max_uj").focus().select();
		 $("#projekt_max_uj").trigger("focus").trigger("select");
	 }
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_mod_proj_maxido_katt_spinner(){
autocomplete_off();
$(".projekt_max_ido").spinner({
  min: 0,
  max: 65535,
   spin: function( event, ui ){
	if(this.id=="projekt_max_all"){
	 admin_mod_proj_maxido_all_ment($(this).val(),ui.value);
	}
   }
}).on("keydown",function(event) {
var e=event.keyCode;

if(event.ctrlKey && e==86){//ctrl+v tiltás
 event.preventDefault();
}else if(e!=17)
        if (( e==35 || e==36 || e==86||e==37||e==39||e==116||e==13||e==46||e==8||e==9)||(e>=96&&e<=105)) {//188 190 67 88 86
            // let it happen, don't do anything
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (e< 48 ||e>57) {
                event.preventDefault(); 
            }   
        }
}).on("keyup",function(){
 if(this.id=="projekt_max_all"){
	var maxido=Number(encodeURIComponent($("#projekt_max_all").val()));
	if(maxido>65535){
	 maxido=65535;
	 $("#projekt_max_all").val(maxido);
	}
	 admin_mod_proj_maxido_all_ment("",maxido);
 }
}).on("blur",function(){
 if(Number($(this).val())>65535){
  $(this).val(65535);
 }
});
}

var ajax_keres_admin_mod_proj_maxido_all_ment=null;
function admin_mod_proj_maxido_all_ment(regival,maxido){
var _this=$("#projekt_max_all");
var projekt_id=encodeURIComponent(_this.attr('projekt_id'));

if(ajax_keres_admin_mod_proj_maxido_all_ment!=null){
 ajax_keres_admin_mod_proj_maxido_all_ment.abort();
}

ajax_keres_admin_mod_proj_maxido_all_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_proj_maxido_all_ment&projekt_id="+projekt_id+"&maxido="+maxido,
	function(d){
	ajax_keres_admin_mod_proj_maxido_all_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 if(regival=="0"||maxido=="0"){//Ha a rgi nulla vagy az új nulla, akkor a háttér Table kell frissíteni
		 admin_projektlist_keres("","");
	 }
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_mod_proj_maxido_katt_all_ck=null;
function admin_mod_proj_maxido_katt_all_ck(projekt_id){
if($("#admin_mod_proj_maxido_katt_all_ckbox").prop("checked")){
 var max_all_igen=1;
 var projekt_max_all=encodeURIComponent($("#projekt_max_all").val());
}else{
 var max_all_igen=0;
 var projekt_max_all=0;
}

if(ajax_keres_admin_mod_proj_maxido_katt_all_ck!=null){
 ajax_keres_admin_mod_proj_maxido_katt_all_ck.abort();
}

ajax_keres_admin_mod_proj_maxido_katt_all_ck=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_proj_maxido_katt_all_ck&projekt_id="+projekt_id+"&max_all_igen="+max_all_igen+"&projekt_max_all="+projekt_max_all,
	function(d){
	ajax_keres_admin_mod_proj_maxido_katt_all_ck=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
		proj_maxido_tal_div_update(max_all_igen,d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function proj_maxido_tal_div_update(max_all_igen,d1){
	 admin_projektlist_keres("","");
	 if(max_all_igen==1){
		$("#proj_maxido_tal_div").html("");
		$("#projekt_max_all_span").css("display","inline");
		dialogok_atmeretezes();
		$("#projekt_max_all").trigger("focus").trigger("select");
	 }else{
		$("#projekt_max_all_span").css("display","none");
		$("#proj_maxido_tal_div").html(d1);
		dialogok_atmeretezes();
		admin_mod_proj_maxido_katt_spinner();
		$("#projekt_max_uj").trigger("focus").trigger("select");
		tooltip_proc();
	 }
}

function proj_maxido_uj_ev_change(ev_kezdo_ev,ev_kezdo_ho,evnext,homost){
var sel_ev=$("#proj_maxido_uj_ev_sel option:selected").val();

var homost=Number(homost);
if(homost<12)
 var homost_next=homost+1;
else
 var homost_next=homost;

if(sel_ev==evnext){
 
 for (let i=1;i<=homost_next;i++) {
  $("#proj_maxido_uj_ho_sel option[value="+i+"]").css("display","inline");
 }
 
 for (let i=homost_next;i<=12;i++) {
  $("#proj_maxido_uj_ho_sel option[value="+i+"]").css("display","none");
 }
 $("#proj_maxido_uj_ho_sel").val(homost);
}else if(sel_ev==ev_kezdo_ev){
 for (let i=1;i<ev_kezdo_ho;i++) {
  $("#proj_maxido_uj_ho_sel option[value="+i+"]").css("display","none");
 }
 for (let i=ev_kezdo_ho;i<=12;i++) {
  $("#proj_maxido_uj_ho_sel option[value="+i+"]").css("display","inline");
 }
 $("#proj_maxido_uj_ho_sel").val(ev_kezdo_ho);
}else{//Se az első, se az utolsó (2022 ha 2021 a kezdő és 2022 van éppen) akkor minden kell
 for (let i=1;i<=12;i++) {
  $("#proj_maxido_uj_ho_sel option[value="+i+"]").css("display","inline");
 }
 $("#proj_maxido_uj_ho_sel").val(homost);
}
}

var ajax_keres_proj_maxido_uj_ev_ment=null;
function proj_maxido_uj_ev_ment(projekt_id){
var ev=encodeURIComponent($("#proj_maxido_uj_ev_sel option:selected").val());
var ho=encodeURIComponent($("#proj_maxido_uj_ho_sel option:selected").val());
var max_ora=encodeURIComponent($("#projekt_max_uj").val());
var projekt_id=encodeURIComponent(projekt_id);

if(max_ora=="" || max_ora=="0"){
 diaglog_open("Hiba!<br><br>Max óra megadása kötelező!","Hiba");
 return false;
}

if(ajax_keres_proj_maxido_uj_ev_ment!=null){
 ajax_keres_proj_maxido_uj_ev_ment.abort();
}

ajax_keres_proj_maxido_uj_ev_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=proj_maxido_uj_ev_ment&ev="+ev+"&ho="+ho+"&max_ora="+max_ora+"&projekt_id="+projekt_id,
	function(d){
	ajax_keres_proj_maxido_uj_ev_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 proj_maxido_tal_div_update(0,d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});

}

function proj_maxido_uj_ev_mod(ev,ho,max_ora){
$("#proj_maxido_uj_ev_sel").val(ev);
$("#proj_maxido_uj_ho_sel").val(ho);
$("#projekt_max_uj").val(max_ora).trigger("focus");
}

var ajax_keres_proj_maxido_uj_ev_del=null;
function proj_maxido_uj_ev_del(ev,ho,projekt_id){
var ev=encodeURIComponent(ev);
var ho=encodeURIComponent(ho);
var projekt_id=encodeURIComponent(projekt_id);

if(ajax_keres_proj_maxido_uj_ev_del!=null){
 ajax_keres_proj_maxido_uj_ev_del.abort();
}

ajax_keres_proj_maxido_uj_ev_del=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=proj_maxido_uj_ev_del&ev="+ev+"&ho="+ho+"&projekt_id="+projekt_id,
	function(d){
	ajax_keres_proj_maxido_uj_ev_del=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 proj_maxido_tal_div_update(0,d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_projektlist_keres_par(){
var id=encodeURIComponent($("#admin_projektlist_keres_id").val());
var nev=encodeURIComponent($("#admin_projektlist_keres_nev").val());
var kat_id=encodeURIComponent($("#admin_projektlist_keres_kat").val());
var inaktiv=encodeURIComponent($("#admin_projektlist_keres_inaktiv").val());
//tipus=encodeURIComponent($("#admin_projektlist_keres_tipus option:selected").val());
//par="&nev="+nev+"&inaktiv="+inaktiv+"&tipus="+tipus;
var par="&id="+id+"&nev="+nev+"&kat_id="+kat_id+"&inaktiv="+inaktiv;
return par;
}

var admin_projektlist_keres_fo_wait="";
function admin_projektlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_projektlist_keres_fo_wait);
  admin_projektlist_keres_fo_wait = setTimeout(function(){admin_projektlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_projektlist_keres=null;
function admin_projektlist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_projektlist_keres_tal_oldalholvagyok","admin_projektlist_keres_tal_oldalmax","projektlist_keres_talszam","admin_projektlist_keres_proc");

var par=admin_projektlist_keres_par();

if(ajax_keres_projektlist_keres!=null){
 ajax_keres_projektlist_keres.abort();
}

ajax_keres_projektlist_keres=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_projektlist_keres"+ker_par+par,
	function(d){
	ajax_keres_projektlist_keres=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_proj_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 date_tol_ig();
	 tooltip_proc();
	 duplaprojektadmin_list_scrool_bar();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function duplaprojektadmin_list_scrool_bar(){
    $("#scroll1 div").width($("#admin_projektlist_table").outerWidth(true));
    var ignoreScroll_projekt = false; // Zászló a végtelen ciklus ellen
	$("#scroll1").on("scroll", function(){
		 if (!ignoreScroll_projekt) {
         ignoreScroll_projekt = true;
         $("#scroll2").scrollLeft($(this).scrollLeft());
        
         // Hagyunk egy pici időt, majd levesszük a zászlót
         requestAnimationFrame(function(){
            ignoreScroll_projekt = false;
         });
		}
    });
    $("#scroll2").on("scroll", function(){
		 if (!ignoreScroll_projekt) {
         ignoreScroll_projekt = true;
         $("#scroll1").scrollLeft($(this).scrollLeft());
        
         requestAnimationFrame(function() {
            ignoreScroll_projekt = false;
         });
		}
    });
}

var ajax_keres_admin_uj_projekt_szerv_katt=null;
function admin_uj_projekt_szerv_katt(){
var szerv_id=$("#admin_uj_projekt_szerv_id").val();

if(ajax_keres_admin_uj_projekt_szerv_katt!=null){
 ajax_keres_admin_uj_projekt_szerv_katt.abort();
}

ajax_keres_admin_uj_projekt_szerv_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_uj_projekt_szerv_katt&szerv_id="+szerv_id,
	function(d){
	ajax_keres_admin_uj_projekt_szerv_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Szervezetek");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_ujszerv_hozz_keress=null;
function admin_ujszerv_hozz_keress(){
var szerv_id=$("#admin_uj_projekt_szerv_id").val();
var szerv_nev=encodeURIComponent($("#szerv_hozzid_keress").val());

if(ajax_keres_ujszerv_hozz_keress!=null){
 ajax_keres_ujszerv_hozz_keress.abort();
}

ajax_keres_ujszerv_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujszerv_hozz_keress&szerv_id="+szerv_id+"&szerv_nev="+szerv_nev,
	function(d){
	ajax_keres_ujszerv_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#szerv_hozzid_tal_div").html(d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_ujszerv_hozzall_change(){
$("input[type=checkbox][id^=szerv_hozzid_]").each(function(){
 $(this).trigger("click");
})
}

function admin_ujszerv_hozz_change(){
var v="";
var szerv_nev="";
var szerv_szam=0;
$("input[type=checkbox][id^=szerv_hozzid_]").each(function(){
if($(this).prop("checked")){
 if(v!="")v+=",";
 v+=$(this).attr("szerv_id");
 szerv_szam++;
 if(szerv_nev!="")szerv_nev+="<br>";
 szerv_nev+=$(this).attr("szerv_nev");
 
}
});

//if(szerv_nev=="")szerv_nev="Szervezet hozzáadása";
if(szerv_szam==0)
  $("#admin_uj_projekt_szerv_span").html("Szervezet hozzáadása");
else
 $("#admin_uj_projekt_szerv_span").html(szerv_szam);	
$("#admin_uj_projekt_szerv_id").val(v);
//$("#admin_uj_projekt_szerv_span").html(szerv_nev);

}

var ajax_keres_admin_uj_projekt_user_katt=null;
function admin_uj_projekt_user_katt(){
var user_ad=$("#admin_uj_projekt_user_id").val();

if(ajax_keres_admin_uj_projekt_user_katt!=null){
 ajax_keres_admin_uj_projekt_user_katt.abort();
}

ajax_keres_admin_uj_projekt_user_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_uj_projekt_user_katt&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_uj_projekt_user_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Felhasználók");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var admin_ujuser_hozz_keress_fo_wait="";
function admin_ujuser_hozz_keress(id_honnan,hol_lep){
  clearTimeout(admin_ujuser_hozz_keress_fo_wait);
  admin_ujuser_hozz_keress_fo_wait = setTimeout(function(){admin_ujuser_hozz_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_ujuser_hozz_keress=null;
function admin_ujuser_hozz_keress_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"user_ujtevekenyseguserhozza_keres_tal_oldalholvagyok","user_ujtevekenyseguserhozza_keres_tal_oldalmax","user_ujtevekenyseguserhozza_keres_talszam","admin_ujuser_hozz_keress_proc");

var user_ad=$("#admin_uj_projekt_user_id").val();
var user_nev=encodeURIComponent($("#user_hozzid_keress").val());

if(ajax_keres_ujuser_hozz_keress!=null){
 ajax_keres_ujuser_hozz_keress.abort();
}

ajax_keres_ujuser_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujuser_hozz_keress"+ker_par+"&user_ad="+user_ad+"&user_nev="+user_nev,
	function(d){
	ajax_keres_ujuser_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#user_hozzid_tal_div").html(d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var tomb_admin_ujuser_hozz_change=[];
function admin_ujuser_hozz_change(id){
var v="";
var szerv_nev="";

//Új módszer - eleje
if($("#"+id).prop('checked')){//Bepipálás történt
 tomb_admin_ujuser_hozz_change[$("#"+id).attr("user_ad")]=$("#"+id).attr("user_nev");
}else{//Törölni kell
 tomb_admin_ujuser_hozz_change[$("#"+id).attr("user_ad")]='';
}

for (var ad in tomb_admin_ujuser_hozz_change) {
    if (Object.hasOwn(tomb_admin_ujuser_hozz_change, ad) && tomb_admin_ujuser_hozz_change[ad]!='') {
        
        if(v!="")v+=",";
		v+=ad;
		
		if(szerv_nev!="")szerv_nev+="<br>";
		szerv_nev+=tomb_admin_ujuser_hozz_change[ad];
    }
}
//Új módszer - vége




if(szerv_nev=="")szerv_nev="Felhasználók hozzáadása";

$("#admin_uj_projekt_user_id").val(v);
$("#admin_uj_projekt_user_span").html(szerv_nev);
}

var ajax_keres_admin_moduser_katkivetel_change=null;
function admin_moduser_katkivetel_change(user_ad,projekt_id){
var katkivetel=encodeURIComponent($("#user_katkivetelid_"+user_ad).val());

if(ajax_keres_admin_moduser_katkivetel_change!=null){
 ajax_keres_admin_moduser_katkivetel_change.abort();
}

ajax_keres_admin_moduser_katkivetel_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_katkivetel_change&user_ad="+encodeURIComponent(user_ad)+"&projekt_id="+encodeURIComponent(projekt_id)+"&katkivetel="+katkivetel,
	function(d){
	ajax_keres_admin_moduser_katkivetel_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){

	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}


