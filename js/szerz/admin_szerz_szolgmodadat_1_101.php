<?php

?>

function admin_szolgmodadatlist_keres_par(){
var mire1=encodeURIComponent($("#admin_szolgmodadatlist_keres_mire1").val());
var mit1=encodeURIComponent($("#admin_szolgmodadatlist_keres_mit1").val());
var mit1_value=encodeURIComponent($("#admin_szolgmodadatlist_keres_mit1 option:selected").text());

var mire2=encodeURIComponent($("#admin_szolgmodadatlist_keres_mire2").val());
var mit2=encodeURIComponent($("#admin_szolgmodadatlist_keres_mit2").val());
var mit2_value=encodeURIComponent($("#admin_szolgmodadatlist_keres_mit2 option:selected").text());

var mire3=encodeURIComponent($("#admin_szolgmodadatlist_keres_mire3").val());
var mit3=encodeURIComponent($("#admin_szolgmodadatlist_keres_mit3").val());
var mit3_value=encodeURIComponent($("#admin_szolgmodadatlist_keres_mit3 option:selected").text());

var szerz_tetel_id=encodeURIComponent($("#admin_szolgmodadatlist_keres_szerztetelid").val());
var sapszam=encodeURIComponent($("#admin_szolgmodadatlist_keres_szerzsapszam").val());


var par="&mire1="+mire1+"&mit1="+mit1+"&mire2="+mire2+"&mit2="+mit2+"&mire3="+mire3+"&mit3="+mit3+"&szerz_tetel_id="+szerz_tetel_id+"&sapszam="+sapszam;
par+="&mit1_value="+mit1_value+"&mit2_value="+mit2_value+"&mit3_value="+mit3_value;
return par;
}

var admin_szolgmodadatlist_keres_fo_wait="";
function admin_szolgmodadatlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_szolgmodadatlist_keres_fo_wait);
  admin_szolgmodadatlist_keres_fo_wait = setTimeout(function(){admin_szolgmodadatlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_szolgmodadatlist_keres_proc=null;
function admin_szolgmodadatlist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_szolgmodadatlist");
var par=admin_szolgmodadatlist_keres_par();

if(ajax_admin_szolgmodadatlist_keres_proc!=null){
 ajax_admin_szolgmodadatlist_keres_proc.abort();
}

ajax_admin_szolgmodadatlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szolgmodadatlist_keres"+ker_par+par,
	function(d){
	ajax_admin_szolgmodadatlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_szolgmodadat_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_szolgmodadat_mod(szerz_tetel_id,szerz_tetel_adat_id,tatusz_str){
var d="Biztos, hogy elindítod a szerződés módosítást?";
d+="<br><br>Szolgáltatás ID: "+szerz_tetel_id; 
//d+="<br>Aktuális szerződésmódosítás száma: "+tatusz_str;
d+="<br>Aktuális módosítás ID: "+tatusz_str;
var title_ki="Szerződésmódosítás";

$("#dialog_egyeni_close").css('background-color','#A6CFF5').html(d).dialog({//D6ECFF
	title: title_ki,
	buttons: {
		
		"mod":{
                    click: function () {
					 //$(this).dialog('widget').find('button').prop('disabled',true);
                     admin_szolgmodadat_mod_proc(szerz_tetel_id,szerz_tetel_adat_id);
                    },
                    'text': 'Szerződésmódoítás',
                    'class': 'submit2'
		
		},
		"megse":{
                    click: function () {
                     //$("#admin_ujkapcstulajmod_inaktiv_"+id).prop("checked",false);
					 $(this).dialog("close");
                    },
                    'text': 'Mégse',
                    'class': 'submit2'
		
		},
		
      },
	  	open: function (event, ui){
		$(".ui-dialog-title").html("<img src='image/mod15_2.png'> "+title_ki);
		alap_input_select_most();
        $("#ui-widget-overlay").fadeIn();
      },
        close: function() {
		$(this).css('background-color','');
		if(
		(!$('#dialog_egyeni_close').dialog('isOpen')) &&
		(!$('#dialog').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
		$(this).dialog('close');
        }
	}).dialog( "open" );
}

var ajax_admin_szolgmodadat_mod_proc=null;
function admin_szolgmodadat_mod_proc(szerz_tetel_id,szerz_tetel_adat_id){
if(ajax_admin_szolgmodadat_mod_proc!=null){
 ajax_admin_szolgmodadat_mod_proc.abort();
}

ajax_admin_szolgkapadat_mod_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szolgmodadat_mod&szerz_tetel_id="+encodeURIComponent(szerz_tetel_id)+"&szerz_tetel_adat_id="+encodeURIComponent(szerz_tetel_adat_id),
	function(d){
	ajax_admin_szolgkapadat_mod_proc=null;
	if(d.slice(0,2)=="ok"){
	 admin_szolgmodadat_mod_proc_urlap(d.slice(5),szerz_tetel_id,szerz_tetel_adat_id);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_szolgmodadat_mod_proc_urlap(d,szerz_tetel_id,szerz_tetel_adat_id){
//var title_ki="Szerződésmódosítás: ID: "+szerz_tetel_id;
var title_ki="Szerződésmódosítás";
 
$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
		
		"mentes":{
                    click: function () {
					 //$(this).dialog('widget').find('button').prop('disabled',true);
                     admin_szolgmodadat_mod_proc_urlap_mentes(szerz_tetel_id,szerz_tetel_adat_id);
                    },
                    'text': 'Szerződésmódosítás mentése',
                    'class': 'submit2'
		
		},
		"megse":{
                    click: function () {
                     //$("#admin_ujkapcstulajmod_inaktiv_"+id).prop("checked",false);
					 $(this).dialog("close");
                    },
                    'text': 'Mégse',
                    'class': 'submit2'
		
		},
		
      },
	  	open: function (){
		$(".ui-dialog-title").html("<img src='image/mod15_2.png'> "+title_ki);
		alap_input_select_most();
        $("#ui-widget-overlay").fadeIn();
      },
        close: function() {
		$(this).css('background-color','');
		if(
		(!$('#dialog_egyeni_close').dialog('isOpen')) &&
		(!$('#dialog').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
		$(this).dialog('close');
        }
	}).dialog( "open" );

		alap_input_select_most();
		number_only();
		number_only_tizedes();
		date_tol_ig();
		tooltip_proc();
}

function admin_szolgmodadat_mod_proc_urlap_valt_vane(){
var hiba_vane=false;
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_modszamkezi");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_szerzcsopid");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_szolgkod");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_tetelutok");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_nettoszerzdij");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func_ck(hiba_vane,"admin_modszolgmodadat_nettoszerzdij_nemrelevans");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_szolgkezddate");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_nettohavidij");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_nettohavidij_penznem");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_elsztipusid");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_oradij");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func_ck(hiba_vane,"admin_modszolgmodadat_oradij_nemrelevans");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_szolgmoddate");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func_ck(hiba_vane,"admin_modszolgmodadat_folyamatban");

hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_alairdate");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_szolgaktvegdate");
//hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_szolgorigvegdate");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_arajanlatalairdate");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_nettoevesdij");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_naturaliaid");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_naturaliadarab");

hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_ujszolgkapadat_projektid_mod");

hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_usergazdaad");

hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_integerintett");

hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_megj");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_ttmegj");
//hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgmodadat_tetellink");
return hiba_vane;
}

function admin_szolgmodadat_mod_proc_urlap_valt(){

if(!admin_szolgmodadat_mod_proc_urlap_valt_vane()){
 $("#admin_szolgmodadat_mod_mezok").css("display","none");
}else{
 $("#admin_szolgmodadat_mod_mezok").css("display","inline-block");
}
}

function admin_szolgmodadat_mod_proc_urlap_mentes(szerz_tetel_id,szerz_tetel_adat_id){
var mod_date=$("#admin_modszolgmodadat_szolgmoddate").val();
var akt_folyamatban=$("#admin_modszolgmodadat_folyamatban").prop('checked')
if(admin_szolgmodadat_mod_proc_urlap_valt_vane() && (mod_date!='' || akt_folyamatban) ){
if (confirm('Biztos, hogy elmented a szerződésmódosítás változtatásait, és ezzel új szerződésmódosítást hozol létre?')){
 admin_szolgmodadat_mod_proc_urlap_mentes_proc(szerz_tetel_id,szerz_tetel_adat_id);
}
}else if(mod_date=='' && !akt_folyamatban){
 diaglog_open("Hiba! Mentés nem lehetséges!<br><br>Szerződésmódosítás hatályba lépésének dátumának kitöltése kötelező!","Hiba","del_behajtani16.png");
}else{
 diaglog_open("Hiba! Mentés nem lehetséges!<br><br>Nem történt módosítás!","Hiba","del_behajtani16.png");
}
}

var ajax_keres_admin_szolgmodadat_mod_proc_urlap_mentes_proc=null;
function admin_szolgmodadat_mod_proc_urlap_mentes_proc(szerz_tetel_id,szerz_tetel_adat_id){

var par="&szerz_tetel_id="+encodeURIComponent(szerz_tetel_id)+"&szerz_tetel_adat_id="+encodeURIComponent(szerz_tetel_adat_id);

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_modszamkezi")){
 par+="&szerz_tetel_modszam_kezi="+encodeURIComponent($("#admin_modszolgmodadat_modszamkezi").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_tetelutok")){
 par+="&szerz_tetel_utok="+encodeURIComponent($("#admin_modszolgmodadat_tetelutok").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_nettoszerzdij")){
 par+="&szerz_tetel_netto_szerzdij="+encodeURIComponent($("#admin_modszolgmodadat_nettoszerzdij").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func_ck(false,"admin_modszolgmodadat_nettoszerzdij_nemrelevans")){
 if($("#admin_modszolgmodadat_nettoszerzdij_nemrelevans").prop('checked')){
  var nettoszerzdij_nemrelevans='1'; 
 }else{
  var nettoszerzdij_nemrelevans='0'; 
 }
 par+="&nettoszerzdij_nemrelevans="+nettoszerzdij_nemrelevans;
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_alairdate")){
 par+="&szerz_tetel_alair_date="+encodeURIComponent($("#admin_modszolgmodadat_alairdate").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_szolgaktvegdate")){
 par+="&szerz_tetel_szolg_aktveg_date="+encodeURIComponent($("#admin_modszolgmodadat_szolgaktvegdate").val());
}

/*
if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_szolgkezddate")){
 par+="&szerz_tetel_szolg_kezd_date="+encodeURIComponent($("#admin_modszolgmodadat_szolgkezddate").val());
}
*/

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_szolgmoddate")){
 par+="&szerz_tetel_szolg_mod_date="+encodeURIComponent($("#admin_modszolgmodadat_szolgmoddate").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func_ck(false,"admin_modszolgmodadat_folyamatban")){
 if($("#admin_modszolgmodadat_folyamatban").prop('checked')){
  var akt_folyamatban='1'; 
 }else{
  var akt_folyamatban='0'; 
 }
 par+="&akt_folyamatban="+akt_folyamatban;
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_nettohavidij")){
 par+="&szerz_tetel_netto_havidij="+encodeURIComponent($("#admin_modszolgmodadat_nettohavidij").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_nettohavidij_penznem")){
 par+="&szerz_tetel_netto_havidij_penznem="+encodeURIComponent($("#admin_modszolgmodadat_nettohavidij_penznem").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_elsztipusid")){
 par+="&szerz_elsz_tipus_id="+encodeURIComponent($("#admin_modszolgmodadat_elsztipusid").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_oradij")){
 par+="&szerz_tetel_oradij="+encodeURIComponent($("#admin_modszolgmodadat_oradij").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func_ck(false,"admin_modszolgmodadat_oradij_nemrelevans")){
 if($("#admin_modszolgmodadat_oradij_nemrelevans").prop('checked')){
  var oradij_nemrelevans='1'; 
 }else{
  var oradij_nemrelevans='0'; 
 }
 par+="&oradij_nemrelevans="+oradij_nemrelevans;
}

/*
if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_szolgorigvegdate")){
 par+="&szerz_tetel_szolg_origveg_date="+encodeURIComponent($("#admin_modszolgmodadat_szolgorigvegdate").val());
}
*/

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_arajanlatalairdate")){
 par+="&szerz_tetel_arajanlat_alair_date="+encodeURIComponent($("#admin_modszolgmodadat_arajanlatalairdate").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_nettoevesdij")){
 par+="&szerz_tetel_netto_evesdij="+encodeURIComponent($("#admin_modszolgmodadat_nettoevesdij").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_naturaliaid")){
 par+="&szerz_naturalia_id="+encodeURIComponent($("#admin_modszolgmodadat_naturaliaid").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_naturaliadarab")){
 par+="&szerz_tetel_naturalia_darab="+encodeURIComponent($("#admin_modszolgmodadat_naturaliadarab").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_ujszolgkapadat_projektid_mod")){
 par+="&projektid="+encodeURIComponent($("#admin_ujszolgkapadat_projektid_mod").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_usergazdaad")){
 par+="&szerz_usergazda_ad="+encodeURIComponent($("#admin_modszolgmodadat_usergazdaad").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_integerintett")){
 par+="&szerz_tetel_integ_erintett="+encodeURIComponent($("#admin_modszolgmodadat_integerintett").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_megj")){
 par+="&szerz_tetel_megj="+encodeURIComponent($("#admin_modszolgmodadat_megj").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_ttmegj")){
 par+="&szerz_tetel_tt_megj="+encodeURIComponent($("#admin_modszolgmodadat_ttmegj").val());
}

/*if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgmodadat_tetellink")){
 par+="&szerz_tetel_link="+encodeURIComponent($("#admin_modszolgmodadat_tetellink").val());
}*/

if(ajax_keres_admin_szolgmodadat_mod_proc_urlap_mentes_proc!=null){
 ajax_keres_admin_szolgmodadat_mod_proc_urlap_mentes_proc.abort();
}

ajax_keres_admin_szolgmodadat_mod_proc_urlap_mentes_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szolgmodadat_mod_proc_urlap_mentes_proc"+par,
	function(d){
	ajax_keres_admin_szolgmodadat_mod_proc_urlap_mentes_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //admin_muv_sel();
	 admin_szolgmodadatlist_keres_proc("","");
	 $("#dialog_egyeni_close").dialog('close');
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba","hiba");	
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_keres_admin_szolgmodadat_vege=null;
function admin_szolgmodadat_vege(szerz_tetel_id,szerz_tetel_adat_id){

if(ajax_keres_admin_szolgmodadat_vege!=null){
 ajax_keres_admin_szolgmodadat_vege.abort();
}

ajax_keres_admin_szolgmodadat_vege=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szolgmodadat_vege&szerz_tetel_id="+encodeURIComponent(szerz_tetel_id)+"&szerz_tetel_adat_id="+encodeURIComponent(szerz_tetel_adat_id),
	function(d){
	ajax_keres_admin_szolgmodadat_vege=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_szolgmodadat_vege_proc(szerz_tetel_id,szerz_tetel_adat_id,d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_szolgmodadat_vege_proc(szerz_tetel_id,szerz_tetel_adat_id,d){
//var d="Biztos, hogy megszünteted a szerződést?";
//d+="<br><br>ID: "+szerz_tetel_id;

var title_ki="Szolgáltatás megszüntetése";

$("#dialog_egyeni_close").css('background-color','#A6CFF5').html(d).dialog({
	title: title_ki,
	buttons: {
		
		"mod":{
                    click: function () {
					 //$(this).dialog('widget').find('button').prop('disabled',true);
                     admin_szolgmodadat_vege_proc_ment(szerz_tetel_id,szerz_tetel_adat_id);
                    },
                    'text': 'Szolgáltatás megszüntetése',
                    'class': 'submit2'
		
		},
		"megse":{
                    click: function () {
                     //$("#admin_ujkapcstulajmod_inaktiv_"+id).prop("checked",false);
					 $(this).dialog("close");
                    },
                    'text': 'Mégse',
                    'class': 'submit2'
		
		},
		
      },
	  	open: function (event, ui){
		$(".ui-dialog-title").html("<img src='image/del.png'> "+title_ki);
		alap_input_select_most();
		autocomplete_off();
		date_tol_ig();
		tooltip_proc();
        $("#ui-widget-overlay").fadeIn();
		
		
		setTimeout(function(){
		 $("#admin_modszolgmodadat_vegedate").trigger('blur');
		},0);
		
      },
        close: function() {
		$(this).css('background-color','');
		if(
		(!$('#dialog_egyeni_close').dialog('isOpen')) &&
		(!$('#dialog').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
		 $(this).dialog('close');
		 $("#dialog").dialog('close');
        }
	}).dialog( "open" );
}

var ajax_keres_admin_szolgmodadat_vege_proc_ment=null;
function admin_szolgmodadat_vege_proc_ment(szerz_tetel_id,szerz_tetel_adat_id){
var szerz_tetel_vege_date=encodeURIComponent($("#admin_modszolgmodadat_vegedate").val());

if(szerz_tetel_vege_date==""){
 diaglog_open("Hiba!<br><br><b>Szerződésmódosítás vége Aktuális</b> mező kitöltése kötelező!","Hiba","del_behajtani16.png");
 return false;
}

if(ajax_keres_admin_szolgmodadat_vege_proc_ment!=null){
 ajax_keres_admin_szolgmodadat_vege_proc_ment.abort();
}

var par="&szerz_tetel_id="+encodeURIComponent(szerz_tetel_id)+"&szerz_tetel_adat_id="+encodeURIComponent(szerz_tetel_adat_id)+"&szerz_tetel_vege_date="+szerz_tetel_vege_date;
ajax_keres_admin_szolgmodadat_vege_proc_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szolgmodadat_vege_proc_ment"+par,
	function(d){
	ajax_keres_admin_szolgmodadat_vege_proc_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //admin_muv_sel();
	 admin_szolgmodadatlist_keres_proc("","");
	 $("#dialog_egyeni_close").dialog('close');
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba","hiba");	
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_szolgmodadat_mod_nettoszerzdij_nemrelevans_change(){

 if($("#admin_modszolgmodadat_nettoszerzdij_nemrelevans").prop('checked')){
  $("#admin_modszolgmodadat_nettoszerzdij").val('').prop('disabled',true); 
 }else{
  $("#admin_modszolgmodadat_nettoszerzdij").attr('class','number_penz').prop('disabled',false); 
 }
 admin_szolgmodadat_mod_proc_urlap_valt();
}

function admin_szolgmodadat_mod_oradij_nemrelevans_change(){

 if($("#admin_modszolgmodadat_oradij_nemrelevans").prop('checked')){
  $("#admin_modszolgmodadat_oradij").val('').prop('disabled',true); 
 }else{
  $("#admin_modszolgmodadat_oradij").prop('disabled',false); 
 }
 admin_szolgmodadat_mod_proc_urlap_valt();
}

function admin_modszolgmodadat_folyamatban_change(){
if($("#admin_modszolgmodadat_folyamatban").prop('checked')){
 $("#admin_modszolgmodadat_szolgmoddate").val('').prop('disabled',true);	
}else{
$("#admin_modszolgmodadat_szolgmoddate").prop('disabled',false);
}
}
