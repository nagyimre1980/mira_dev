<?php

?>


function ad_leker_enter(e){
var c=e.keyCode;
if(c==13){//13 enter 9 tab
 ad_leker();
}else if(c!=9){
 $("#admin_ujuser_nev").val("");
 $("#admin_ujuser_email").val("");
 $("#admin_ujuser_tsz").val("");
 $("#admin_ujuser_szerv").val("keremv").trigger("change");
 $("#admin_ujuser_nev_tiltott").html('');
}
}

var ajax_keres_ad_leker=null;
function ad_leker(){
var ad=encodeURIComponent($("#admin_ujuser_ad").val());
if(ad!=""){

if(ajax_keres_ad_leker!=null){
 ajax_keres_ad_leker.abort();
}

ajax_keres_ad_leker=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=ad_leker&ad="+ad,
	function(d){
	ajax_keres_ad_leker=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_ujuser_nev").val(d1[1]);
	 $("#admin_ujuser_email").val(d1[2]);
	 $("#admin_ujuser_tsz").val(d1[3]);
	 
	 //Részleg kiválasztás
	 if(d1[4]==""){//Kérem válassz
		 $("#admin_ujuser_szerv").val("keremv").trigger("change");
	 }else{
		var szerv_adkod_no=0;
		$("#admin_ujuser_szerv > option").each(function(){
			if(szerv_adkod_no==0){
			 var _self_szerv=$(this);
			 if(d1[4]==_self_szerv.attr("szerv_adkod")){
			  $("#admin_ujuser_szerv").val(_self_szerv.val()).trigger("change");
			  szerv_adkod_no=1;
			 }
			}
		});
	 //Ha nincs ez ott sehol, akkor kérem
	 if(szerv_adkod_no==0){
		$("#admin_ujuser_szerv").val("keremv").trigger("change"); 
	 }
	 }
	 
	 //Letiltott kiírása - eleje
	 if(typeof d1[5]!=='undefined' && d1[5]!=""){
		 console.log('alma');
		$("#admin_ujuser_nev_tiltott").html(d1[5]);
	 }
	 //Letiltott kiírása - vége
	 
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	});	
}else{
	diaglog_open("AD adatok lekérdezéséhez add meg az AD azonosítót!","Rendszerhiba");
}
}

function admin_moduser_admod(ad){
var nev=$("#admin_ujmod_nev_"+ad).val();
	var title_ki=nev+" AD azonosító módosítása";
	var d="Biztos, hogy módosítod <b>"+nev+"</b> AD azonosítóját?";
	d+="<table border=0 class='table_emre' style='margin-top:10px'>";
	d+="<tr><td><b>Régi AD</b><td>"+ad+"</tr>";
	d+="<tr><td><b>Új AD</b><td><input id='admin_moduser_admod_ad' type='text' maxlength='17' style='width:150px' autocomplete='off'></tr>";
	d+="</table>";
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Mentés": function() {
		 admin_moduser_admod_proc(ad);
        },
        "Mégse": function() {
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
		if(
		(!$('#dialog').dialog('isOpen'))&&
		(!$('#dialog2').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
      }
	}).dialog( "open" );
}

function admin_moduser_admod_proc(ad){
var ujad=$("#admin_moduser_admod_ad").val();
if(ujad!=""){
 admin_moduser_admod_proc_kuld(ad,ujad);
}else{
 diaglog_open("Új AD azonosító kitöltése kötelező!","Hiba");
}
}

var ajax_keres_admin_moduser_admod_proc_kuld=null;
function admin_moduser_admod_proc_kuld(ad,ujad){

if(ajax_keres_admin_moduser_admod_proc_kuld!=null){
 ajax_keres_admin_moduser_admod_proc_kuld.abort();
}

ajax_keres_admin_moduser_admod_proc_kuld=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_admod_proc_kuld&ad="+encodeURIComponent(ad)+"&ujad="+encodeURIComponent(ujad),
	function(d){
	ajax_keres_admin_moduser_admod_proc_kuld=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
		admin_userlist_keres_proc("","");
		$('#dialog_egyeni_close').dialog("close");
	}else if(d1[0]=="ujadvan"){
		diaglog_open("Hiba!<br><br>Új AD azonosító már foglalt!<br>Név: "+d1[1],"Hiba");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	});
}

var ajax_keres_admin_moduser_adupdate=null;
function admin_moduser_adupdate(ad){

if(ajax_keres_admin_moduser_adupdate!=null){
 ajax_keres_admin_moduser_adupdate.abort();
}

ajax_keres_admin_moduser_adupdate=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=ad_leker&ad="+ad,
	function(d){
	ajax_keres_admin_moduser_adupdate=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $(gi("admin_ujmod_ad_update_"+ad+"_img")).attr("title","Aktualizálás kész");	
	 $(gi("admin_ujmod_nev_"+ad)).val(d1[1]);
	 $(gi("admin_ujmod_email_"+ad)).val(d1[2]);
	 $(gi("admin_ujmod_tsz_"+ad)).val(d1[3]);
	 admin_moduser_ment(ad);
	 //tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	});
}

function isEmail(email){
  var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(email);
}

function admin_ujuser(){
var nev=encodeURIComponent($("#admin_ujuser_nev").val());
var ad=encodeURIComponent($("#admin_ujuser_ad").val());
var email_orig=$("#admin_ujuser_email").val();
var email=encodeURIComponent(email_orig);
var tsz=encodeURIComponent($("#admin_ujuser_tsz").val());
var szerv_id=encodeURIComponent($("#admin_ujuser_szerv").val());
var maxido=encodeURIComponent($("#admin_ujuser_maxido").val());
var maxperc=encodeURIComponent($("#admin_ujuser_maxido_perc").val());
var kezd_date=encodeURIComponent($("#admin_ujuser_kezd_date").val());

/*if((nev=="")||(ad=="")||(email=="")||(tsz=="")||(szerv_id=="keremv")){
 diaglog_open("Hiba!<br><br>Minden mező kitöltése kötelező!","Hiba");*/
if(ad==""){
 diaglog_open("Hiba!<br><br>AD azonosító mező kitöltése kötelező!","Hiba");
}else if(nev==""){
 diaglog_open("Hiba!<br><br>Név mező kitöltése kötelező!","Hiba");
}else if(email==""){
 diaglog_open("Hiba!<br><br>Email cím mező kitöltése kötelező!","Hiba");
}else if(tsz==""){
 diaglog_open("Hiba!<br><br>Törzsszám mező kitöltése kötelező!","Hiba");
}else if(szerv_id=="keremv"){
 diaglog_open("Hiba!<br><br>Szervezet kiválasztása kötelező!","Hiba");
}else if(kezd_date==""){
 diaglog_open("Hiba!<br><br>Rögzítés kezdete mező kitöltése kötelező!","Hiba");
}else if(!isEmail(email_orig)){
 diaglog_open("Hibás az email cím!<br><br>Email cím mezőben mindig (módosításnál is) valódi, formatilag helyes email címmel kell kitölteni!","Hiba");
}else if(maxido==0 && maxperc==0){
 diaglog_open("Hiba!<br><br>Max rögzíthető óra és perc nem lehet egyszerre 0!","Hiba");
}else{
 admin_ujuser_ment(nev,ad,email,tsz,szerv_id,maxido,maxperc,kezd_date);
}
	
}

var ajax_keres_admin_ujuser_ment=null;
function admin_ujuser_ment(nev,ad,email,tsz,szerv_id,maxido,maxperc,kezd_date){

if(ajax_keres_admin_ujuser_ment!=null){
 ajax_keres_admin_ujuser_ment.abort();
}

ajax_keres_admin_ujuser_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_uj_user_ment&nev="+nev+"&ad="+ad+"&email="+email+"&tsz="+tsz+"&szerv_id="+szerv_id+"&maxido="+maxido+"&maxperc="+maxperc+"&kezd_date="+kezd_date,
	function(d){
	ajax_keres_admin_ujuser_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_ujuser_kezd_date_delete(){
var c=event.keyCode;
if(c == 46 || c==8){//Del backspace
 $("#admin_ujuser_kezd_date").val("");
}else{
 return false;
}
}

function admin_moduser_kezd_date_delete(ad){
var c=event.keyCode;
if(c == 46 || c==8){//Del backspace
 $("#admin_ujmod_kezd_date_"+ad).val("");
 admin_moduser_ment(ad);
}else{
 return false;
}
}

function admin_moduser_veg_date_delete_rogzitett(ad){
var nev=$(gi("admin_ujmod_nev_"+ad)).val();
var user_veg_date=encodeURIComponent($(gi("admin_ujmod_veg_date_"+ad)).val());
	var title_ki=nev+" rögzítés vége";
	var d="Biztos, hogy törlöd a "+nev+" minden "+user_veg_date+" után rögzített összes rögzített tevékenységeit?";
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Igen": function() {
		 admin_moduser_veg_date_delete_rogzitett_proc(ad,user_veg_date);
        },
        "Mégse": function() {
          $(this).dialog("close");
        }
      },
	  open: function (event, ui){
        $("#ui-widget-overlay").fadeIn();
      },
	  close: function (event, ui){
		$("#dialog_egyeni_close").dialog('widget').find('button').prop('disabled',false).css('color',"");
		$('#dialog_egyeni_close').html("");
		if(
		(!$('#dialog').dialog('isOpen'))&&
		(!$('#dialog2').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
      }
	}).dialog( "open" );
}

var ajax_keres_admin_moduser_veg_date_delete_rogzitett_proc=null;
function admin_moduser_veg_date_delete_rogzitett_proc(ad,user_veg_date){

if(ajax_keres_admin_moduser_veg_date_delete_rogzitett_proc!=null){
 ajax_keres_admin_moduser_veg_date_delete_rogzitett_proc.abort();
}

ajax_keres_admin_moduser_veg_date_delete_rogzitett_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_veg_date_delete_rogzitett_proc&ad="+ad+"&user_veg_date="+user_veg_date,
	function(d){
	ajax_keres_admin_moduser_veg_date_delete_rogzitett_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //admin_userlist_keres("","");
	 diaglog_open("<b>Felhasználó "+user_veg_date+" utáni rögzített tevékenységének törlés sikeres!</b>","Törlés sikeres!");
	 $('#dialog_egyeni_close').dialog("close");
	}else if(d1[0]=="vanlezarthonap"){
		admin_userlist_keres_proc("","");
		diaglog_open("<b>Hiba! Törlés sikertelen!</b><br><br>Rögzítés vége utáni időszakra ("+user_veg_date+") van már legalább egy olyan hónap, amit legalább egyszer már lezárt a felhasználó!<br>Ezért a törlés nem végrehajtható!<br><br>Felhasználó rögzítés vége beállítása törlésre került!","Hiba");
		$('#dialog_egyeni_close').dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	 $('#dialog_egyeni_close').dialog("close");
	}
	});
}

function admin_moduser_veg_date_chenge_update_list(ad){
if(!$(gi("admin_ujmod_veg_date_img_"+ad)).length){
var user_veg_date=encodeURIComponent($(gi("admin_ujmod_veg_date_"+ad)).val());
if(user_veg_date.length==10){
 admin_userlist_keres("","");
}
}
}

function admin_moduser_veg_date_delete(ad){
var c=event.keyCode;
if(c == 46 || c==8){//Del backspace
 $(gi("admin_ujmod_veg_date_"+ad)).val("");
 admin_moduser_ment(ad);
 admin_userlist_keres_proc("","");
}else{
 return false;
}
}

var ajax_keres_admin_moduser_ment=null;
function admin_moduser_ment(ad){
var nev=encodeURIComponent($(gi("admin_ujmod_nev_"+ad)).val());
var email=encodeURIComponent($(gi("admin_ujmod_email_"+ad)).val());
var tsz=encodeURIComponent($(gi("admin_ujmod_tsz_"+ad)).val());

if($(gi("admin_ujmod_kezd_date_"+ad)).length)
 var user_kezd_date=encodeURIComponent($(gi("admin_ujmod_kezd_date_"+ad)).val());
else user_kezd_date='';
	
var user_veg_date=encodeURIComponent($(gi("admin_ujmod_veg_date_"+ad)).val());

if(ajax_keres_admin_moduser_ment!=null){
 ajax_keres_admin_moduser_ment.abort();
}

ajax_keres_admin_moduser_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_user_ment&nev="+nev+"&ad="+ad+"&email="+email+"&tsz="+tsz+"&user_kezd_date="+user_kezd_date+"&user_veg_date="+user_veg_date,
	function(d){
	ajax_keres_admin_moduser_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
		//Ha jó semmi....
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba");
	 admin_userlist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_moduser_inaktiv_kezd_date_teves_katt(){
var ck=$("#admin_moduser_inaktiv_kezd_date_teves").prop("checked");

if(ck){
 $("#admin_moduser_inaktiv_kezd_date").val("");
 $("#admin_moduser_inaktiv_kezd_date_span,#admin_moduser_inaktiv_kezd_date_figyspan").css("display","none");
}else{
 $("#admin_moduser_inaktiv_kezd_date_span,#admin_moduser_inaktiv_kezd_date_figyspan").css("display","inline");
}

}

function admin_moduser_inaktiv(ad,nev){

if($(gi("admin_ujmod_inaktiv_"+ad)).prop("checked")){
 admin_moduser_inaktiv_kerd_utan(ad,"");
}else{
var title_ki="Felhasználó visszaaktiválása";
d="<b>"+nev+"</b> felhasználót visszaengedélyezését kezedményezted!";
d+="<br><br><span id='admin_moduser_inaktiv_kezd_date_span'>Kérem add meg a visszatérés napját: ";
d+="<input id='admin_moduser_inaktiv_kezd_date' type='text' class='date_tol' style='width:75px'></span>";
d+="<br><span id='admin_moduser_inaktiv_kezd_date_figyspan'>Figyelem: Rögzítés vége dátum automatikusan törlésre kerül!</span>";
d+="<br><br><label style='cursor:pointer'><input type='checkbox' onclick='admin_moduser_inaktiv_kezd_date_teves_katt()' id='admin_moduser_inaktiv_kezd_date_teves'>Nem visszatérő kolléga, téves inaktiválás!</label>";

	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Visszaakativálás": function(){
		if(!$("#admin_moduser_inaktiv_kezd_date_teves").prop("checked")){
		 var uj_rog_nap=$("#admin_moduser_inaktiv_kezd_date").val();
		 if(uj_rog_nap!=""){
		  admin_moduser_inaktiv_kerd_utan(ad,uj_rog_nap);
		 }else{
			diaglog_open("Hiba!<br><br>Visszatérő kolléga esetén az új rögzítés kezdete dátum megadása kötelező!","Hiba");
		 }
		}else{//Be van pipálva, akkor mehet üressen!
		  admin_moduser_inaktiv_kerd_utan(ad,"");
		}
        },
        "Mégse": function() {
		  event.preventDefault();
		  $(gi("admin_ujmod_inaktiv_"+ad)).prop("checked",true);
          $(this).dialog("close");
        }
      },
	  open: function (event, ui){
        $("#ui-widget-overlay").fadeIn();
		date_tol_ig();
		$("#admin_moduser_inaktiv_kezd_date").trigger("blur");
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
}


var ajax_keres_admin_moduser_inaktiv=null;
function admin_moduser_inaktiv_kerd_utan(ad,uj_rog_nap){
var ck=$(gi("admin_ujmod_inaktiv_"+ad)).prop("checked");
if(ck){
 var user_inaktiv=1;
}else{
 var user_inaktiv=0;
}

if(ajax_keres_admin_moduser_inaktiv!=null){
 ajax_keres_admin_moduser_inaktiv.abort();
}

ajax_keres_admin_moduser_inaktiv=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_inaktiv&ad="+ad+"&user_inaktiv="+user_inaktiv+"&uj_rog_nap="+encodeURIComponent(uj_rog_nap),
	function(d){
	ajax_keres_admin_moduser_inaktiv=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //admin_muv_sel();
	 if($('#dialog_egyeni_close').dialog('isOpen'))
	  $("#dialog_egyeni_close").dialog("close");
	 admin_userlist_keres_proc("","");
	 $('.ui-tooltip').remove();
	}else if(d1[0]=="okutolso" || d1[0]=="noinaktiv_vanrog"){
		$(gi("admin_ujmod_inaktiv_"+ad)).prop("checked",false);
		//$(".ui-tooltip").css("visibility","hidden");
		$('.ui-tooltip').remove();
		diaglog_open(d1[1],"Hiba");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_rogzitjog=null;
function admin_moduser_rogzitjog(ad){
var ck=$(gi("admin_ujmod_rogzitjog_"+ad)).prop("checked");

if(ck){
 var ful_rogzitck=1;
 //Nem, mert nem tudjuk, hogy lehet-e, majd oldal frissítés, ha akar ilyet
 //$("#admin_ujmod_kezd_date_"+ad).css("display","inline");
}else{
 var ful_rogzitck=0;
 //$("#admin_ujmod_kezd_date_"+ad).css("display","none").val("");
 //$("#admin_ujmod_kezd_date_"+ad+",#admin_ujmod_veg_date_"+ad).css("display","none");
 $( [gi("admin_ujmod_kezd_date_" + ad),gi("admin_ujmod_veg_date_" + ad)] ).css("display", "none");
}

if(ajax_keres_admin_moduser_rogzitjog!=null){
 ajax_keres_admin_moduser_rogzitjog.abort();
}

ajax_keres_admin_moduser_rogzitjog=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_rogzitjog&ad="+ad+"&ful_rogzit="+ful_rogzitck,
	function(d){
	ajax_keres_admin_moduser_rogzitjog=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //admin_muv_sel();
	 if(ck){
	  admin_userlist_keres_proc("","");
	  diaglog_open("Kérem ellenőrizd le a rögzítés kezdete dátumot!","Rögzítés kezdete ellenőrzés!");
	 }
	 $('.ui-tooltip').remove();
	}else if(d1[0]=="nook"){
		if(ful_rogzitck==0){
			$(gi("admin_ujmod_rogzitjog_"+ad)).prop("checked",true);
		}
		diaglog_open(d1[1],"Hiba");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_jovahagy=null;
function admin_moduser_jovahagy(ad){
var ck=$(gi("admin_ujmod_jovahagy_"+ad)).prop("checked");
if(ck){
 var user_jovahagy=1;
 //$("#admin_mod_userjovahagyas_proj_katt_span_"+ad+",#admin_mod_userprojektjovahagyo_proj_katt_span_"+ad+",#admin_mod_useremailbe_katt_span_"+ad+"").css("display","inline");
 $([gi("admin_mod_userjovahagyas_proj_katt_span_" + ad),gi("admin_mod_userprojektjovahagyo_proj_katt_span_" + ad),gi("admin_mod_useremailbe_katt_span_" + ad)]).css("display","inline");
}else{
 var user_jovahagy=0;
 //$("#admin_mod_userjovahagyas_proj_katt_span_"+ad+",#admin_mod_userprojektjovahagyo_proj_katt_span_"+ad+",#admin_mod_useremailbe_katt_span_"+ad+"").css("display","none");
 $([gi("admin_mod_userjovahagyas_proj_katt_span_" + ad),gi("admin_mod_userprojektjovahagyo_proj_katt_span_" + ad),gi("admin_mod_useremailbe_katt_span_" + ad)]).css("display","none");
}

if(ajax_keres_admin_moduser_jovahagy!=null){
 ajax_keres_admin_moduser_jovahagy.abort();
}

ajax_keres_admin_moduser_jovahagy=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_jovahagy&ad="+ad+"&user_jovahagy="+user_jovahagy,
	function(d){
	ajax_keres_admin_moduser_jovahagy=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //admin_muv_sel();
	 //admin_userlist_keres("","")
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_stat_szervjogspan=null;
function admin_moduser_stat_szervjogspan(user_ad,user_nev){
var user_nev=encodeURIComponent(user_nev);

if(ajax_keres_admin_moduser_stat_szervjogspan!=null){
 ajax_keres_admin_moduser_stat_szervjogspan.abort();
}

ajax_keres_admin_moduser_stat_szervjogspan=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_stat_szervjogspan&csakvan=0&user_ad="+user_ad+"&user_nev="+user_nev,
	function(d){
	ajax_keres_admin_moduser_stat_szervjogspan=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Statisztika jogosultság");//szervezet
	 if($("#user_stat_projekt_hozzid_keress").length)
		 $("#user_stat_projekt_hozzid_keress").trigger("focus");
	 else if($("#user_stat_szerv_hozzid_keress").length)
		 $("#user_stat_szerv_hozzid_keress").trigger('focus');
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_stat_szervjogspan_all=null;
function admin_moduser_stat_szervjogspan_all(user_ad){

var szervjogspan_all=$("#admin_moduser_stat_szervjogspan_all");
var projektjogspan_all=$("#admin_moduser_stat_projektjogspan_all");

var ck=szervjogspan_all.prop("checked");
if(ck){
 var ful_stat_all=1;
 projektjogspan_all.prop("disabled",false);
}else{
 var ful_stat_all=0;
 projektjogspan_all.prop("checked",true).prop("disabled",true);
}

var ck_proj=projektjogspan_all.prop("checked");
if(ck_proj){
  var ful_stat_projekt_all=1;
  szervjogspan_all.prop("disabled",false);
}else{
  var ful_stat_projekt_all=0;
  szervjogspan_all.prop("checked",true).prop("disabled",true);
}

if(ajax_keres_admin_moduser_stat_szervjogspan_all!=null){
 ajax_keres_admin_moduser_stat_szervjogspan_all.abort();
}

ajax_keres_admin_moduser_stat_szervjogspan_all=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_stat_szervjogspan_all&csakvan=0&user_ad="+user_ad+"&ful_stat_all="+ful_stat_all+"&ful_stat_projekt_all="+ful_stat_projekt_all,
	function(d){
	ajax_keres_admin_moduser_stat_szervjogspan_all=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_userlist_keres_proc("","");
	 if(ful_stat_all==1 && ful_stat_projekt_all==1){
	  $("#admin_moduser_stat_szervjogspan_szerv_aljog_tal_div").html("");
	  dialogok_atmeretezes();
	 }else if(ful_stat_all==0 && ful_stat_projekt_all==1){
	  admin_moduser_stat_szervjogspan_szerv_aljog(user_ad);
	 }else if(ful_stat_all==1 && ful_stat_projekt_all==0){
	  admin_moduser_stat_projektjogspan_szerv_aljog(user_ad);
	 }
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});	
}

var ajax_keres_admin_moduser_stat_projektjogspan_szerv_aljog=null;
function admin_moduser_stat_projektjogspan_szerv_aljog(user_ad){

if(ajax_keres_admin_moduser_stat_projektjogspan_szerv_aljog!=null){
 ajax_keres_admin_moduser_stat_projektjogspan_szerv_aljog.abort();
}

	ajax_keres_admin_moduser_stat_projektjogspan_szerv_aljog=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_stat_projektjogspan_szerv_aljog&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_moduser_stat_projektjogspan_szerv_aljog=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_moduser_stat_szervjogspan_szerv_aljog_tal_div").html(d1[1]);
	 $("#user_stat_projekt_hozzid_keress").trigger("focus");
	 dialogok_atmeretezes();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_moduser_stat_projekt_hozz_keress_par(){
var user_ad=$("#user_stat_projekt_hozzid_keress").attr("user_ad");
var projekt_nev=$("#user_stat_projekt_hozzid_keress").val();
if($("#user_stat_projekt_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var par="&csakvan="+csakvan+"&user_ad="+user_ad+"&projekt_nev="+projekt_nev;
return par;
}

var admin_moduser_stat_projekt_hozz_keress_fo_wait="";
function admin_moduser_stat_projekt_hozz_keress(id_honnan,hol_lep){
  clearTimeout(admin_moduser_stat_projekt_hozz_keress_fo_wait);
  admin_moduser_stat_projekt_hozz_keress_fo_wait = setTimeout(function(){admin_moduser_stat_projekt_hozz_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_moduser_stat_projekt_hozz_keress=null;
function admin_moduser_stat_projekt_hozz_keress_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"user_stat_projekthozza_keres_tal_oldalholvagyok","user_stat_projekthozza_keres_tal_oldalmax","user_stat_projekthozza_keres_talszam","admin_moduser_stat_projekt_hozz_keress_proc");

var par=admin_moduser_stat_projekt_hozz_keress_par();

if(ajax_keres_moduser_stat_projekt_hozz_keress!=null){
 ajax_keres_moduser_stat_projekt_hozz_keress.abort();
}

ajax_keres_moduser_stat_projekt_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_stat_projekt_hozz_keress"+ker_par+par,
	function(d){
	ajax_keres_moduser_stat_projekt_hozz_keress=null
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#user_stat_projekt_hozzid_tal_div").html(d1[1]);
	 dialogok_atmeretezes();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_stat_projekt_hozz_change=null;
function admin_moduser_stat_projekt_hozz_change(projekt_id,user_ad){
if($("#user_stat_projekt_hozzid_"+projekt_id).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_moduser_stat_projekt_hozz_change!=null){
 ajax_keres_admin_moduser_stat_projekt_hozz_change.abort();
}

ajax_keres_admin_moduser_stat_projekt_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_stat_projekt_hozz_change&mit="+mit+"&projekt_id="+projekt_id+"&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_moduser_stat_projekt_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_moduser_stat_projekt_hozz_keress("","");
	 admin_userlist_keres_proc("","")
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_stat_szervjogspan_szerv_aljog=null;
function admin_moduser_stat_szervjogspan_szerv_aljog(user_ad){

if(ajax_keres_admin_moduser_stat_szervjogspan_szerv_aljog!=null){
 ajax_keres_admin_moduser_stat_szervjogspan_szerv_aljog.abort();
}

	ajax_keres_admin_moduser_stat_szervjogspan_szerv_aljog=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_stat_szervjogspan_szerv_aljog&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_moduser_stat_szervjogspan_szerv_aljog=null
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_moduser_stat_szervjogspan_szerv_aljog_tal_div").html(d1[1]);
	 $("#user_stat_szerv_hozzid_keress").trigger('focus');
	 dialogok_atmeretezes();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});	
}

function admin_moduser_stat_szerv_hozz_keress_par(){
var user_ad=$("#user_stat_szerv_hozzid_keress").attr("user_ad");
var szerv_nev=$("#user_stat_szerv_hozzid_keress").val();
if($("#user_stat_szerv_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var par="&csakvan="+csakvan+"&user_ad="+user_ad+"&szerv_nev="+szerv_nev;
return par;
}

var admin_moduser_stat_szerv_hozz_keress_fo_wait="";
function admin_moduser_stat_szerv_hozz_keress(id_honnan,hol_lep){
  clearTimeout(admin_moduser_stat_szerv_hozz_keress_fo_wait);
  admin_moduser_stat_szerv_hozz_keress_fo_wait = setTimeout(function(){admin_moduser_stat_szerv_hozz_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_moduser_stat_szerv_hozz_keress_proc=null;
function admin_moduser_stat_szerv_hozz_keress_proc(id_honnan,hol_lep){

/////var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"user_stat_projekthozza_keres_tal_oldalholvagyok","user_stat_projekthozza_keres_tal_oldalmax","user_stat_projekthozza_keres_talszam","admin_moduser_stat_projekt_hozz_keress_proc");
var ker_par='';

var par=admin_moduser_stat_szerv_hozz_keress_par();

if(ajax_admin_moduser_stat_szerv_hozz_keress_proc!=null){
 ajax_admin_moduser_stat_szerv_hozz_keress_proc.abort();
}

ajax_admin_moduser_stat_szerv_hozz_keress_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_stat_szerv_hozz_keress"+ker_par+par,
	function(d){
	ajax_admin_moduser_stat_szerv_hozz_keress_proc=null
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#user_stat_szerv_hozzid_tal_div").html(d1[1]);
	 dialogok_atmeretezes();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_stat_szervjogspan_change=null;
function admin_moduser_stat_szervjogspan_change(szerv_id,user_ad){
if($("#userstat_szervjogspan_hozzid_"+szerv_id).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_moduser_stat_szervjogspan_change!=null){
 ajax_keres_admin_moduser_stat_szervjogspan_change.abort();
}

ajax_keres_admin_moduser_stat_szervjogspan_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_stat_szervjogspan_change&mit="+mit+"&szerv_id="+szerv_id+"&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_moduser_stat_szervjogspan_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#userjovahagyas_hozzid_csakhozz_szur").prop("checked",false);
	 admin_moduserjovahagyas_hozz_keress(user_ad);
	 admin_userlist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});	
}

var ajax_keres_admin_moduser_tervstat=null;
function admin_moduser_riport(ad){
var ck=$("#admin_ujmod_tervstat_"+ad).prop("checked");
if(ck){
 var user_riport=1;
}else{
 var user_riport=0;
}

if(ajax_keres_admin_moduser_tervstat!=null){
 ajax_keres_admin_moduser_tervstat.abort();
}

ajax_keres_admin_moduser_tervstat=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_riport&ad="+ad+"&user_riport="+user_riport,
	function(d){
	ajax_keres_admin_moduser_tervstat=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_userlist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_riport_tipusjogspan_teny3_1_1_szervcsopjog_katt=null;
function admin_moduser_riport_tipusjogspan_teny3_1_1_szervcsopjog_katt(user_ad,mira_szerv_csoport_id){
var vanbe_ck=0;
$('input[id^=riportjog_teny3_1_1_szervcsop_inpt_]').each(function(){
	if($(this).prop('checked')){
		vanbe_ck++;
	}
});

$("#riport_szervcsop_szam_ert").html(vanbe_ck);
if(vanbe_ck==0){
 $("#riport_szervcsop_szam_fo").css('color','red');
}else{
 $("#riport_szervcsop_szam_fo").css('color','#000');
}

if($("#riportjog_teny3_1_1_szervcsop_inpt_"+mira_szerv_csoport_id).prop("checked")){
 var mit='1';
}else{
 var mit='0';
}

if(ajax_keres_admin_moduser_riport_tipusjogspan_teny3_1_1_szervcsopjog_katt!=null){
 ajax_keres_admin_moduser_riport_tipusjogspan_teny3_1_1_szervcsopjog_katt.abort();
}

ajax_keres_admin_moduser_riport_tipusjogspan_teny3_1_1_szervcsopjog_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_riport_tipusjogspan_teny3_1_1_szervcsopjog_katt&user_ad="+encodeURIComponent(user_ad)+"&mira_szerv_csoport_id="+encodeURIComponent(mira_szerv_csoport_id)+"&mit="+mit,
	function(d){
	ajax_keres_admin_moduser_riport_tipusjogspan_teny3_1_1_szervcsopjog_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){

	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
	
}

var ajax_keres_admin_moduser_riport_tipusjogspan_szerzjog_katt_all=null;
function admin_moduser_riport_tipusjogspan_szerzjog_katt_all(user_ad){

if($("#riportjog_szerz_inptall").prop("checked")){
 $('.riport_szerz_tr').css('display','none');
 var mit='1';
}else{
 $('.riport_szerz_tr').css('display','table-row');
 var mit='0';
}

if(ajax_keres_admin_moduser_riport_tipusjogspan_szerzjog_katt_all!=null){
 ajax_keres_admin_moduser_riport_tipusjogspan_szerzjog_katt_all.abort();
}

ajax_keres_admin_moduser_riport_tipusjogspan_szerzjog_katt_all=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_riport_tipusjogspan_szerzjog_katt_all&user_ad="+encodeURIComponent(user_ad)+"&szerz_csop_id="+"&mit="+mit,
	function(d){
	ajax_keres_admin_moduser_riport_tipusjogspan_szerzjog_katt_all=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 if(mit=='1'){
		$('input[id^=riportjog_szerz_inpt_]').each(function(){
		 $(this).prop('checked',false);
		}); 
	 }
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_riport_tipusjogspan_szerzjog_katt=null;
function admin_moduser_riport_tipusjogspan_szerzjog_katt(user_ad,szerz_csop_id){

var hanykattintva=0;
 $('input[id^=riportjog_szerz_inpt_]').each(function(){
	if($(this).prop('checked')){
		hanykattintva++;
	}
 });

if($("#riportjog_szerz_inpt_"+szerz_csop_id).prop("checked")){
 var mit='1';
}else{
 
 if(hanykattintva==0){
 diaglog2_open("<b>Hiba!</b><br><br>Minden szerződésnyilvántartó szolgáltatás csoport jogosultság nem szüntethető meg!","Hiba");
 $("#riportjog_szerz_inpt_"+szerz_csop_id).prop("checked",true);
 return false;
}
 
 var mit='0';
}

if(ajax_keres_admin_moduser_riport_tipusjogspan_szerzjog_katt!=null){
 ajax_keres_admin_moduser_riport_tipusjogspan_szerzjog_katt.abort();
}

ajax_keres_admin_moduser_riport_tipusjogspan_szerzjog_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_riport_tipusjogspan_szerzjog_katt&user_ad="+encodeURIComponent(user_ad)+"&szerz_csop_id="+encodeURIComponent(szerz_csop_id)+"&mit="+mit,
	function(d){
	ajax_keres_admin_moduser_riport_tipusjogspan_szerzjog_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){

	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_riport_tipusjogspan=null;
function admin_moduser_riport_tipusjogspan(user_ad,user_nev){

if(ajax_keres_admin_moduser_riport_tipusjogspan!=null){
 ajax_keres_admin_moduser_riport_tipusjogspan.abort();
}

ajax_keres_admin_moduser_riport_tipusjogspan=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_riport_tipusjogspan&user_ad="+encodeURIComponent(user_ad)+"&user_nev="+encodeURIComponent(user_nev),
	function(d){
	ajax_keres_admin_moduser_riport_tipusjogspan=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Riport jogosultság");//szervezet
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_riport_tipusjogspan_katt=null;
function admin_moduser_riport_tipusjogspan_katt(user_ad){
if($("#riport_aljog_all").prop("checked"))
 var jog_all='1';
else var jog_all='0';

if($("#riport_aljog_nonp").prop("checked"))
 var jog_nonp='1';
else var jog_nonp='0';

if($("#riport_aljog_tervteny").prop("checked"))
 var jog_tervteny='1';
else var jog_tervteny='0';

if($("#riport_aljog_teny3_1_1_szervcsop").prop("checked"))
 var jog_teny311_szervcsop='1';
else var jog_teny311_szervcsop='0';

if($("#riport_aljog_teny3_1_1").prop("checked"))
 var jog_teny311='1';
else var jog_teny311='0';

if($("#riport_aljog_teny3_2").prop("checked"))
 var jog_teny32='1';
else var jog_teny32='0';

if($("#riport_aljog_teny3_3").prop("checked"))
 var jog_teny33='1';
else var jog_teny33='0';

if($("#riport_aljog_teny3").prop("checked"))
 var jog_teny3='1';
else var jog_teny3='0';

if($("#riport_aljog_teny3_elteres").prop("checked"))
 var jog_teny3_elteres='1';
else var jog_teny3_elteres='0';

if($("#riport_aljog_kapcs_ossze").prop("checked"))
 var jog_kapcs_ossze='1';
else var jog_kapcs_ossze='0';

if($("#riport_aljog_szerznyilv").prop("checked"))
 var jog_szerznyilv='1';
else var jog_szerznyilv='0';

if($("#riport_aljog_szerznyilv_elo").prop("checked"))
 var jog_szerznyilv_elo='1';
else var jog_szerznyilv_elo='0';

if($("#riport_aljog_proj_k99").prop("checked"))
 var jog_proj_k99='1';
else var jog_proj_k99='0';

if($("#riport_aljog_proj_beszkoz").prop("checked"))
 var jog_proj_beszkoz='1';
else var jog_proj_beszkoz='0';

if($("#riport_aljog_proj_kpiriport").prop("checked"))
 var jog_proj_kpiriport='1';
else var jog_proj_kpiriport='0';

if($("#riport_aljog_proj_tigtabla").prop("checked"))
 var jog_proj_tigtabla='1';
else var jog_proj_tigtabla='0';

if($("#riport_aljog_proj_adminuser").prop("checked"))
 var jog_proj_adminuser='1';
else var jog_proj_adminuser='0';

if($("#riport_aljog_proj_adminszerv").prop("checked"))
 var jog_proj_adminszerv='1';
else var jog_proj_adminszerv='0';

if($("#riport_aljog_proj_adminproj").prop("checked"))
 var jog_proj_adminproj='1';
else var jog_proj_adminproj='0';

//All sorok eltűntetése
if(jog_all=='1'){
 $(".riport_all_sor").css('visibility','hidden');
 jog_nonp=jog_tervteny=jog_teny311=jog_teny32=jog_teny33=jog_teny3=jog_teny3_elteres=jog_kapcs_ossze=jog_szerznyilv=jog_szerznyilv_elo=jog_proj_k99=jog_proj_beszkoz=jog_proj_kpiriport=jog_proj_adminuser=jog_proj_adminszerv=jog_proj_adminproj=jog_teny311_szervcsop=jog_proj_tigtabla='0';
 $("#riport_aljog_nonp,#riport_aljog_tervteny,#riport_aljog_teny3_1_1,#riport_aljog_teny3_2,#riport_aljog_teny3,#riport_aljog_teny3_elteres,#riport_aljog_kapcs_ossze,#riport_aljog_szerznyilv,#riport_aljog_szerznyilv_elo,#riport_aljog_proj_k99,#riport_aljog_proj_beszkoz,#riport_aljog_proj_kpiriport,#riport_aljog_proj_adminuser,#riport_aljog_proj_adminszerv,#riport_aljog_proj_adminproj,#riport_aljog_teny3_1_1_szervcsop,#riport_aljog_proj_tigtabla").prop("checked",false);
 
 $("#riportjog_szerz_div,#riportjog_teny3_1_1_szervcsop_div").css("display","none");
}else{
 $(".riport_all_sor").css('visibility','visible');
 
 //3.1.1 szervcsop DIV mutatása - eleje
 if(jog_teny311_szervcsop=='1'){
  $("#riportjog_teny3_1_1_szervcsop_div").css("display","block");
 }else{
 	 $("#riportjog_teny3_1_1_szervcsop_div").css("display","none");
	 
	 $('input[id^=riportjog_teny3_1_1_szervcsop_inpt_]').each(function(){
	  $(this).prop('checked',false);
	 });
 }
 //3.1.1 szervcsop DIV mutatása - vége
 
 //Szerződéscsoport jogok DIV mutatása - eleje
 if(jog_szerznyilv=='1' || jog_szerznyilv_elo=='1'){
  $("#riportjog_szerz_div").css("display","block");
 }else{
	 $("#riportjog_szerz_div").css("display","none");
	 
	 $('input[id^=riportjog_szerz_inpt_]').each(function(){
	  $(this).prop('checked',false);
	 });

 }
 //Szerződéscsoport jogok DIV mutatása - vége
}

if(jog_nonp=='1' || jog_tervteny=='1' || jog_teny311=='1' || jog_teny32=='1' || jog_teny33=='1' || jog_teny3=='1' || jog_teny3_elteres=='1' || jog_kapcs_ossze=='1' || jog_szerznyilv=='1' ||jog_szerznyilv_elo=='1' || jog_proj_k99=='1' || jog_proj_beszkoz=='1' || jog_proj_kpiriport=='1'|| jog_proj_adminuser=='1'|| jog_proj_adminszerv=='1'|| jog_proj_adminproj=='1' || jog_teny311_szervcsop=='1' || jog_proj_tigtabla=='1'){
 jog_all='0';
 $("#riport_aljog_all").prop("checked",false);
}

if(ajax_keres_admin_moduser_riport_tipusjogspan_katt!=null){
 ajax_keres_admin_moduser_riport_tipusjogspan_katt.abort();
}

var par="&jog_all="+jog_all+"&jog_nonp="+jog_nonp+"&jog_tervteny="+jog_tervteny+"&jog_teny311="+jog_teny311+"&jog_teny32="+jog_teny32+"&jog_teny33="+jog_teny33+"&jog_teny3="+jog_teny3+"&jog_teny3_elteres="+jog_teny3_elteres+"&jog_kapcs_ossze="+jog_kapcs_ossze+"&jog_szerznyilv="+jog_szerznyilv+"&jog_szerznyilv_elo="+jog_szerznyilv_elo+"&jog_proj_k99="+jog_proj_k99+"&jog_proj_beszkoz="+jog_proj_beszkoz+"&jog_proj_kpiriport="+jog_proj_kpiriport+"&jog_proj_adminuser="+jog_proj_adminuser+"&jog_proj_adminszerv="+jog_proj_adminszerv+"&jog_proj_adminproj="+jog_proj_adminproj+"&jog_teny311_szervcsop="+jog_teny311_szervcsop+"&jog_proj_tigtabla="+jog_proj_tigtabla;
ajax_keres_admin_moduser_riport_tipusjogspan_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_riport_tipusjogspan_katt&user_ad="+encodeURIComponent(user_ad)+par,
	function(d){
	ajax_keres_admin_moduser_riport_tipusjogspan_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_userlist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
	
}

var ajax_keres_admin_moduser_stat=null;
function admin_moduser_stat(ad){
var ck=$("#admin_ujmod_stat_"+ad).prop("checked");
if(ck){
 var user_stat=1;
}else{
 var user_stat=0;
}

if(ajax_keres_admin_moduser_stat!=null){
 ajax_keres_admin_moduser_stat.abort();
}

ajax_keres_admin_moduser_stat=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_stat&ad="+ad+"&user_stat="+user_stat,
	function(d){
	ajax_keres_admin_moduser_stat=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //admin_muv_sel();
	 //admin_userlist_keres("","")
	 if(user_stat==1){
	  $("#admin_ujmod_stat_szervjogspan_"+ad).html(" Jog: teljes").removeClass("link_pir_vas").addClass("link").css("display","inline");
	 }else{
	  $("#admin_ujmod_stat_szervjogspan_"+ad).html("").removeClass("link").addClass("link_pir_vas").css("display","none");
	 }
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_adminjog_ment=null;
function admin_moduser_adminjog_ment(user_ad){

if($(gi("admin_user_jogadmin_jog_ck_"+user_ad)).prop("checked")){
 var jog_admin=1;	
}else{
 var jog_admin=0;
}

if(ajax_keres_admin_moduser_adminjog_ment!=null){
 ajax_keres_admin_moduser_adminjog_ment.abort();
}

ajax_keres_admin_moduser_adminjog_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_adminjog_ment&jog_admin="+jog_admin+"&user_ad="+encodeURIComponent(user_ad),
	function(d){
	ajax_keres_admin_moduser_adminjog_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_userlist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

var ajax_keres_admin_moduser_adminjog_fuljog_ment=null;
function admin_moduser_adminjog_fuljog_ment(user_ad){

if(ajax_keres_admin_moduser_adminjog_fuljog_ment!=null){
 ajax_keres_admin_moduser_adminjog_fuljog_ment.abort();
}

ajax_keres_admin_moduser_adminjog_fuljog_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_adminjog_fuljog_ment&user_ad="+encodeURIComponent(user_ad),
	function(d){
	ajax_keres_admin_moduser_adminjog_fuljog_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Admin művelet jogosultságok");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

var ajax_keres_admin_moduser_adminjog_fuljog_ment_ful=null;
function admin_moduser_adminjog_fuljog_ment_ful(muv_kod,user_ad){

if($(gi(muv_kod+"_"+user_ad)).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_moduser_adminjog_fuljog_ment_ful!=null){
 ajax_keres_admin_moduser_adminjog_fuljog_ment_ful.abort();
}

ajax_keres_admin_moduser_adminjog_fuljog_ment_ful=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_adminjog_fuljog_ment_ful&user_ad="+encodeURIComponent(user_ad)+"&muv_kod="+encodeURIComponent(muv_kod)+"&mit="+mit,
	function(d){
	ajax_keres_admin_moduser_adminjog_fuljog_ment_ful=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_userlist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

function admin_userlist_keres_par(){
var ad=encodeURIComponent($("#admin_userlist_keres_ad").val());
var nev=encodeURIComponent($("#admin_userlist_keres_nev").val());
var tsz=encodeURIComponent($("#admin_userlist_keres_tsz").val());
var inaktiv=encodeURIComponent($("#admin_userlist_keres_inaktiv").val());
var szerv_id=encodeURIComponent($("#admin_userlist_keres_szerv option:selected").val());
var maxido=encodeURIComponent($("#admin_userlist_keres_maxido option:selected").val());
var jog=encodeURIComponent($("#admin_userlist_keres_jog option:selected").val());

var kezd_date=encodeURIComponent($("#admin_userlist_keres_kezd_date").val());
var kezd_date_mod=encodeURIComponent($("#admin_userlist_keres_kezd_date_mod option:selected").val());
var veg_date=encodeURIComponent($("#admin_userlist_keres_veg_date").val());
var veg_date_mod=encodeURIComponent($("#admin_userlist_keres_veg_date_mod option:selected").val());

var par="&ad="+ad+"&nev="+nev+"&tsz="+tsz+"&inaktiv="+inaktiv+"&szerv_id="+szerv_id+"&maxido="+maxido+"&jog="+jog+"&kezd_date="+kezd_date+"&kezd_date_mod="+kezd_date_mod+"&veg_date="+veg_date+"&veg_date_mod="+veg_date_mod;
return par;
}

var admin_userlist_keres_fo_wait="";
function admin_userlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_userlist_keres_fo_wait);
  admin_userlist_keres_fo_wait = setTimeout(function(){admin_userlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_userlist_keres=null;
function admin_userlist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_userlist_keres_tal_oldalholvagyok","admin_userlist_keres_tal_oldalmax","user_userlist_keres_talszam","admin_userlist_keres_proc");

var par=admin_userlist_keres_par();

var scroll_poz=$("#scroll2").scrollLeft();

if(ajax_keres_userlist_keres!=null){
 ajax_keres_userlist_keres.abort();
}

ajax_keres_userlist_keres=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_userlist_keres"+ker_par+par,
	function(d){
	ajax_keres_userlist_keres=null;
	//var d1=d.split("$;$");
	//if(d1[0]=="ok"){
	if(d.slice(0,2)=="ok"){
	 //$("#admin_uj_user_list_keres_tal").html(d1[1]);
	 gi("admin_uj_user_list_keres_tal").innerHTML=d.slice(5);
	 alap_input_select_most();
	 autocomplete_off();
	 $("#scroll2").scrollLeft(scroll_poz);
	 duplauseradmin_list_scrool_bar();
	 date_tol_ig();
	 tooltip_proc();
	 tooltip_proc_adinfo();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function duplauseradmin_list_scrool_bar(){
    $("#scroll1 div").width($("#admin_userlist_table").outerWidth(true));
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

/*
function duplauseradmin_list_scrool_bar_old(){
    $("#scroll1 div").width($("#admin_userlist_table").width());	
    $("#scroll1").on("scroll", function(){
        $("#scroll2").scrollLeft($(this).scrollLeft()); 
    });
    $("#scroll2").on("scroll", function(){
        $("#scroll1").scrollLeft($(this).scrollLeft()); 
    });
}
*/

var ajax_keres_admin_mod_userfelettesjovahagyas_proj_katt=null;
function admin_mod_userfelettesjovahagyas_proj_katt(user_ad,user_nev){
var user_nev=encodeURIComponent(user_nev);

if(ajax_keres_admin_mod_userfelettesjovahagyas_proj_katt!=null){
 ajax_keres_admin_mod_userfelettesjovahagyas_proj_katt.abort();
}

ajax_keres_admin_mod_userfelettesjovahagyas_proj_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_userfelettesjovahagyas_proj_katt&csakvan=0&user_ad="+user_ad+"&user_nev="+user_nev,
	function(d){
	ajax_keres_admin_mod_userfelettesjovahagyas_proj_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Jóváhagyás");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});	
}

function admin_moduserfelettesjovahagyas_hozz_keress_par(){
var keress_nev=encodeURIComponent($("#userfelettesjovahagyas_hozzid_keress").val());
var user_ad=$("#userfelettesjovahagyas_hozzid_keress").attr("user_ad");
if($("#userfelettesjovahagyas_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var par="&keress_nev="+keress_nev+"&user_ad="+user_ad+"&csakvan="+csakvan;
return par;
}

var admin_moduserfelettesjovahagyas_hozz_keress_fo_wait="";
function admin_moduserfelettesjovahagyas_hozz_keress(id_honnan,hol_lep){
  clearTimeout(admin_moduserfelettesjovahagyas_hozz_keress_fo_wait);
  admin_moduserfelettesjovahagyas_hozz_keress_fo_wait = setTimeout(function(){admin_moduserfelettesjovahagyas_hozz_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_moduserfelettesjovahagyas_hozz_keress=null;
function admin_moduserfelettesjovahagyas_hozz_keress_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"user_felettesjovahagyo_keres_tal_oldalholvagyok","user_felettesjovahagyo_keres_tal_oldalmax","user_felettesjovahagyo_keres_talszam","admin_moduserfelettesjovahagyas_hozz_keress_proc");

var par=admin_moduserfelettesjovahagyas_hozz_keress_par();

if(ajax_keres_moduserfelettesjovahagyas_hozz_keress!=null){
 ajax_keres_moduserfelettesjovahagyas_hozz_keress.abort();
}

ajax_keres_moduserfelettesjovahagyas_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduserfelettesjovahagyas_hozz_keress"+ker_par+par,
	function(d){
	ajax_keres_moduserfelettesjovahagyas_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#userfelettesjovahagyas_hozzid_tal_div").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_modfelettesjovahagyo_hozz_change=null;
function admin_modfelettesjovahagyo_hozz_change(user_ad_felettes_jovahagyo,user_ad){
if($("#felettesjovahagyo_hozzid_"+user_ad_felettes_jovahagyo).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_modfelettesjovahagyo_hozz_change!=null){
 ajax_keres_admin_modfelettesjovahagyo_hozz_change.abort();
}

ajax_keres_admin_modfelettesjovahagyo_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modfelettesjovahagyo_hozz_change&mit="+mit+"&user_ad_felettes_jovahagyo="+user_ad_felettes_jovahagyo+"&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_modfelettesjovahagyo_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#userfelettesjovahagyas_hozzid_csakhozz_szur").prop("checked",false);
	 admin_moduserfelettesjovahagyas_hozz_keress("","");
	 admin_userlist_keres("","")
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}


var ajax_keres_admin_mod_userjovahagyas_proj_katt=null;
function admin_mod_userjovahagyas_proj_katt(user_ad,user_nev){
var user_nev=encodeURIComponent(user_nev);

if(ajax_keres_admin_mod_userjovahagyas_proj_katt!=null){
 ajax_keres_admin_mod_userjovahagyas_proj_katt.abort();
}

ajax_keres_admin_mod_userjovahagyas_proj_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_userjovahagyas_proj_katt&csakvan=0&user_ad="+user_ad+"&user_nev="+user_nev,
	function(d){
	ajax_keres_admin_mod_userjovahagyas_proj_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Jóváhagyás");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});	
}

var ajax_keres_moduserjovahagyas_hozz_keress=null;
function admin_moduserjovahagyas_hozz_keress(user_ad){
if($("#userjovahagyas_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var szerv_nev=$("#userjovahagyas_hozzid_keress").val();

if(ajax_keres_moduserjovahagyas_hozz_keress!=null){
 ajax_keres_moduserjovahagyas_hozz_keress.abort();
}

ajax_keres_moduserjovahagyas_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduserjovahagyas_hozz_keress&csakvan="+csakvan+"&user_ad="+user_ad+"&szerv_nev="+szerv_nev,
	function(d){
	ajax_keres_moduserjovahagyas_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#userjovahagyas_hozzid_tal_div").html(d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduserjovahagy_hozz_change=null;
function admin_moduserjovahagy_hozz_change(szerv_id,user_ad){
if($("#userjovahagy_hozzid_"+szerv_id).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_moduserjovahagy_hozz_change!=null){
 ajax_keres_admin_moduserjovahagy_hozz_change.abort();
}

ajax_keres_admin_moduserjovahagy_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduserjovahagy_hozz_change&mit="+mit+"&szerv_id="+szerv_id+"&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_moduserjovahagy_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#userjovahagyas_hozzid_csakhozz_szur").prop("checked",false);
	 admin_moduserjovahagyas_hozz_keress(user_ad);
	 admin_userlist_keres("","")
	}else if(d1[0]=="okutolso"){
		$("#userjovahagy_hozzid_"+szerv_id).prop("checked",true);
		diaglog2_open(d1[1],"Hiba");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	});
}


var ajax_keres_admin_mod_userprojekt_proj_katt=null;
function admin_mod_userprojekt_proj_katt(user_ad,user_nev){
var user_nev=encodeURIComponent(user_nev);

if(ajax_keres_admin_mod_userprojekt_proj_katt!=null){
 ajax_keres_admin_mod_userprojekt_proj_katt.abort();
}

ajax_keres_admin_mod_userprojekt_proj_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_userprojekt_proj_katt&csakvan=0&user_ad="+encodeURIComponent(user_ad)+"&user_nev="+user_nev,
	function(d){
	ajax_keres_admin_mod_userprojekt_proj_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Tevékenységek");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_moduserprojekt_hozz_keress_par(){
var user_ad=$("#userprojekt_hozzid_keress").attr("user_ad");
var projekt_nev=$("#userprojekt_hozzid_keress").val();
if($("#userprojekt_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var par="&csakvan="+csakvan+"&user_ad="+user_ad+"&projekt_nev="+projekt_nev;
return par;
}

var admin_moduserprojekt_hozz_keress_keres_fo_wait="";
function admin_moduserprojekt_hozz_keress(id_honnan,hol_lep){
  clearTimeout(admin_moduserprojekt_hozz_keress_keres_fo_wait);
  admin_moduserprojekt_hozz_keress_keres_fo_wait = setTimeout(function(){admin_moduserprojekt_hozz_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_moduserprojekt_hozz_keress=null;
function admin_moduserprojekt_hozz_keress_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"user_projekthozza_keres_tal_oldalholvagyok","user_projekthozza_keres_tal_oldalmax","user_projekthozza_keres_talszam","admin_moduserprojekt_hozz_keress_proc");

var par=admin_moduserprojekt_hozz_keress_par();

if(ajax_keres_modszerv_hozz_keress!=null){
 ajax_keres_modszerv_hozz_keress.abort();
}

ajax_keres_modszerv_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduserprojekt_hozz_keress"+ker_par+par,
	function(d){
	ajax_keres_modszerv_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#userprojekt_hozzid_tal_div").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduserprojekt_hozz_change=null;
function admin_moduserprojekt_hozz_change(projekt_id,user_ad){
if($("#userprojekt_hozzid_"+projekt_id).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_moduserprojekt_hozz_change!=null){
 ajax_keres_admin_moduserprojekt_hozz_change.abort();
}

ajax_keres_admin_moduserprojekt_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduserprojekt_hozz_change&mit="+mit+"&projekt_id="+projekt_id+"&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_moduserprojekt_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#userprojekt_hozzid_csakhozz_szur").prop("checked",false);
	 admin_moduserprojekt_hozz_keress("","");
	 admin_userlist_keres("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}


var ajax_keres_admin_moduserprojekt_katkivetel_change=null;
function admin_moduserprojekt_katkivetel_change(user_ad,projekt_id){
var katkivetel=encodeURIComponent($("#userprojekt_katkivetelid_"+projekt_id).val());

if(ajax_keres_admin_moduserprojekt_katkivetel_change!=null){
 ajax_keres_admin_moduserprojekt_katkivetel_change.abort();
}

ajax_keres_admin_moduserprojekt_katkivetel_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduserprojekt_katkivetel_change&user_ad="+encodeURIComponent(user_ad)+"&projekt_id="+encodeURIComponent(projekt_id)+"&katkivetel="+katkivetel,
	function(d){
	ajax_keres_admin_moduserprojekt_katkivetel_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){

	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}


var ajax_keres_admin_mod_userprojektjovahagyo_proj_katt=null;
function admin_mod_userprojektjovahagyo_proj_katt(user_ad,user_nev){
var user_nev=encodeURIComponent(user_nev);

if(ajax_keres_admin_mod_userprojektjovahagyo_proj_katt!=null){
 ajax_keres_admin_mod_userprojektjovahagyo_proj_katt.abort();
}

ajax_keres_admin_mod_userprojektjovahagyo_proj_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_userprojektjovahagyo_proj_katt&csakvan=0&user_ad="+user_ad+"&user_nev="+user_nev,
	function(d){
	ajax_keres_admin_mod_userprojektjovahagyo_proj_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Projekt jóváhagyás");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_moduserprojektjovahagyo_hozz_keress_par(){
var user_ad=$("#userprojektjovahagyo_hozzid_keress").attr("user_ad");
var projekt_nev=$("#userprojektjovahagyo_hozzid_keress").val();
if($("#userprojektjovahagyo_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var par="&csakvan="+csakvan+"&user_ad="+user_ad+"&projekt_nev="+projekt_nev;
return par;
}

var admin_moduserprojektjovahagyo_hozz_keress_fo_wait="";
function admin_moduserprojektjovahagyo_hozz_keress(id_honnan,hol_lep){
  clearTimeout(admin_moduserprojektjovahagyo_hozz_keress_fo_wait);
  admin_moduserprojektjovahagyo_hozz_keress_fo_wait = setTimeout(function(){admin_moduserprojektjovahagyo_hozz_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_moduserprojektjovahagyo_hozz_keress=null;
function admin_moduserprojektjovahagyo_hozz_keress_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"user_projektjovahagyohozza_keres_tal_oldalholvagyok","user_projektjovahagyohozza_keres_tal_oldalmax","user_projektjovahagyohozza_keres_talszam","admin_moduserprojektjovahagyo_hozz_keress_proc");

var par=admin_moduserprojektjovahagyo_hozz_keress_par();

if(ajax_keres_moduserprojektjovahagyo_hozz_keress!=null){
 ajax_keres_moduserprojektjovahagyo_hozz_keress.abort();
}

ajax_keres_moduserprojektjovahagyo_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduserprojektjovahagyo_hozz_keress"+ker_par+par,
	function(d){
	ajax_keres_moduserprojektjovahagyo_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#userprojekt_hozzid_tal_div").html(d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduserprojektjovahagyo_hozz_change=null;
function admin_moduserprojektjovahagyo_hozz_change(projekt_id,user_ad){
if($("#userprojektjovahagyo_hozzid_"+projekt_id).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

if(ajax_keres_admin_moduserprojektjovahagyo_hozz_change!=null){
 ajax_keres_admin_moduserprojektjovahagyo_hozz_change.abort();
}

ajax_keres_admin_moduserprojektjovahagyo_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduserprojektjovahagyo_hozz_change&mit="+mit+"&projekt_id="+projekt_id+"&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_moduserprojektjovahagyo_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_moduserprojektjovahagyo_hozz_keress("","");
	 admin_userlist_keres("","")
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_mod_useremailbe_katt=null;
function admin_mod_useremailbe_katt(user_ad,user_nev){
var user_nev=encodeURIComponent(user_nev);

if(ajax_keres_admin_mod_useremailbe_katt!=null){
 ajax_keres_admin_mod_useremailbe_katt.abort();
}

ajax_keres_admin_mod_useremailbe_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_useremailbe_katt&csakvan=0&user_ad="+user_ad+"&user_nev="+user_nev,
	function(d){
	ajax_keres_admin_mod_useremailbe_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Projekt jóváhagyás");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_mod_useremailbe_change=null;
function admin_mod_useremailbe_change(user_ad){

if($("#email_jova_elso_szak").prop("checked")){
 var email_jova_elso_szak=1;	
}else{
 var email_jova_elso_szak=0;
}

if($("#email_vissza_szak").prop("checked")){
 var email_vissza_szak=1;	
}else{
 var email_vissza_szak=0;
}

if($("#email_vissza_proj").prop("checked")){
 var email_vissza_proj=1;	
}else{
 var email_vissza_proj=0;
}

var par="&user_ad="+user_ad+"&email_jova_elso_szak="+email_jova_elso_szak+"&email_vissza_szak="+email_vissza_szak+"&email_vissza_proj="+email_vissza_proj

if(ajax_keres_admin_mod_useremailbe_change!=null){
 ajax_keres_admin_mod_useremailbe_change.abort();
}

ajax_keres_admin_mod_useremailbe_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_useremailbe_change&"+par,
	function(d){
	ajax_keres_admin_mod_useremailbe_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_mod_user_szerv_katt=null;
function admin_mod_user_szerv_katt(user_ad,user_nev){
var user_nev=encodeURIComponent(user_nev);

if(ajax_keres_admin_mod_user_szerv_katt!=null){
 ajax_keres_admin_mod_user_szerv_katt.abort();
}

ajax_keres_admin_mod_user_szerv_katt=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_user_szerv_katt&csakvan=0&user_ad="+user_ad+"&user_nev="+user_nev,
	function(d){
	ajax_keres_admin_mod_user_szerv_katt=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Szervezetek");
	}else if(d1[0]=="noszerv_mod"){
		diaglog_open(d1[1],"Hiba");	
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_moduser_szerv_hozz_keress=null;
function admin_moduser_szerv_hozz_keress(user_ad){
if($("#userprojekt_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var szerv_nev=$("#user_szerv_hozzid_keress").val();

if(ajax_keres_moduser_szerv_hozz_keress!=null){
 ajax_keres_moduser_szerv_hozz_keress.abort();
}

ajax_keres_moduser_szerv_hozz_keress=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_szerv_hozz_keress&csakvan="+csakvan+"&user_ad="+user_ad+"&szerv_nev="+szerv_nev,
	function(d){
	ajax_keres_moduser_szerv_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#user_szerv_hozzid_tal_div").html(d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_moduser_szerv_hozz_change=null;
function admin_moduser_szerv_hozz_change(szerv_id,user_ad){

if(ajax_keres_admin_moduser_szerv_hozz_change!=null){
 ajax_keres_admin_moduser_szerv_hozz_change.abort();
}

ajax_keres_admin_moduser_szerv_hozz_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_moduser_szerv_hozz_change&szerv_id="+szerv_id+"&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_moduser_szerv_hozz_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}



var ajax_keres_admin_rogzito_helyettes_beallit=null;
function admin_rogzito_helyettes_beallit(user_ad){

if(ajax_keres_admin_rogzito_helyettes_beallit!=null){
 ajax_keres_admin_rogzito_helyettes_beallit.abort();
}

ajax_keres_admin_rogzito_helyettes_beallit=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_rogzito_helyettes_beallit&user_ad="+user_ad,
	function(d){
	ajax_keres_admin_rogzito_helyettes_beallit=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Rögzítő helyettes beállítása");
	}else if(d1[0]=="nook"){
	 str="Hiba!<br><br>Helyettesítés esetén nincs jogosultságod további helyettes beállításá";
	 diaglog_open(str,"Hiba!");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
});
}

function tooltip_proc_adinfo(){
$('.ad_info_img').tooltip({

 //create: function(ev, ui) {
 create: function() {
      $(this).data("ui-tooltip").liveRegion.remove();
   },

 //open: function(event,ui){//Amíg nincs adat el kell rejteni!
 
 open: function(){//Amíg nincs adat el kell rejteni!
   //$(".ui-tooltip").css("visibility","hidden");
   $(".ui-tooltip").css("display","none");
 },

content:function(){
return $(this).prop('title');
},
track:true,
position: { my: "left top+25", at: "right center" },
show: false,
hide: false
});
}

var ajax_keres_admin_adinfo=null;
function ad_info_leker(id_ad){
//tooltip_proc();
var ad=$("#"+id_ad).val();
if(ad!=""){

if(ajax_keres_admin_adinfo!=null){
 ajax_keres_admin_adinfo.abort();
}

ajax_keres_admin_adinfo=$.post("ajax_ad_info.php","ad="+ad,
	function(d){
	ajax_keres_admin_adinfo=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#"+id_ad+"_info").prop("title",d1[1]);
	 $("#ad_info_div").html(d1[1]);
	 //$(".ui-tooltip").css("visibility","visible");
	 $(".ui-tooltip").css("display","block");
	 //tooltip_proc();
	}else{
	 $("#ad_info_div").html("");
	}
	});	
}else{
 $("#ad_info_div").html("");
}
}

function ad_info_leker_kuka(id_ad){
$("#ad_info_div").html("");
}

function admin_ujuser_maxrogiztheto_ora_change(){
var maxido=$("#admin_ujuser_maxido").val();
var maxidoperc=$("#admin_ujuser_maxido_perc").val();

if(maxido=='0' && maxidoperc=='0'){
 $(gi("admin_ujuser_maxido_perc")).val('1').trigger('change').prop("disabled",false);
 return false;
}else if(maxido=='12' && maxidoperc!='0'){
	console.log('mod 0ra');
 $(gi("admin_ujuser_maxido_perc")).val('0').trigger('change').prop("disabled",false);
 return false;
}else if(maxido!='global'){
 $(gi("admin_ujuser_maxido_perc")).prop("disabled",false);
}else if(maxido=='global' && maxidoperc!='0'){
 $(gi("admin_ujuser_maxido_perc")).val('0').trigger('change').prop("disabled",true);
 return false;
}else if(maxido=='global'){
 $(gi("admin_ujuser_maxido_perc")).prop("disabled",true);
}
}

var ajax_keres_admin_mod_user_maxido_change=null;
function admin_mod_user_maxido_change(user_ad){
var maxido=encodeURIComponent($(gi("admin_moduser_maxido_"+user_ad)).val());
var maxidoperc=encodeURIComponent($(gi("admin_moduser_maxidoperc_"+user_ad)).val());

if(maxido=='0' && maxidoperc=='0'){
 $(gi("admin_moduser_maxidoperc_"+user_ad)).val('1').trigger('change').prop("disabled",false);
 return false;
}else if(maxido=='12' && maxidoperc!='0'){
 $(gi("admin_moduser_maxidoperc_"+user_ad)).val('0').trigger('change').prop("disabled",false);
 return false;
}else if(maxido!='global'){
 $(gi("admin_moduser_maxidoperc_"+user_ad)).prop("disabled",false);
}else if(maxido=='global' && maxidoperc!='0'){
 $(gi("admin_moduser_maxidoperc_"+user_ad)).val('0').trigger('change').prop("disabled",true);
 return false;
}else if(maxido=='global'){
 $(gi("admin_moduser_maxidoperc_"+user_ad)).prop("disabled",true);
}

if(ajax_keres_admin_mod_user_maxido_change!=null){
 ajax_keres_admin_mod_user_maxido_change.abort();
}

ajax_keres_admin_mod_user_maxido_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_mod_user_maxido_change&user_ad="+user_ad+"&maxido="+maxido+"&maxidoperc="+maxidoperc,
	function(d){
	ajax_keres_admin_mod_user_maxido_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}