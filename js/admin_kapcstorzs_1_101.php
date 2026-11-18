<?php

?>

function admin_ujkapcstorzs(){
var nev=encodeURIComponent($("#admin_ujkapcstorzs_nev").val());
var tagvkod=encodeURIComponent($("#admin_ujkapcstorzs_tagvkod").val());
var beosztas=encodeURIComponent($("#admin_ujkapcstorzs_beosztas").val());
var tel_orig=$("#admin_ujkapcstorzs_tel").val();
var tel=encodeURIComponent(tel_orig);
var email_orig=$("#admin_ujkapcstorzs_email").val();
var email=encodeURIComponent(email_orig);

//var filter = /[^0-9-]+$/;
var filter =  /[^-0-9+ \\\/]/;

if(nev==""){
 diaglog_open("Hiba!<br><br>Név kitöltése kötelező!","Hiba","del_behajtani16.png");
}else if(tagvkod=="keremv"){
 diaglog_open("Hiba!<br><br>Társaság kiválasztása kötelező!","Hiba","del_behajtani16.png");
}else if(beosztas==""){
 diaglog_open("Hiba!<br><br>Beosztás kitöltése kötelező!","Hiba","del_behajtani16.png");
}else if(tel!="" && tel.length<10){
  diaglog_open("Hiba!<br><br>Telefonszám túl rövid!","Hiba","del_behajtani16.png");
}else if(tel_orig!="" && filter.test(tel_orig)){
 diaglog_open("Hiba!<br><br>Telefonszám nem megengedett karaktereket tartalmaz!","Hiba","del_behajtani16.png");
}else if(email_orig!="" && !isEmail(email_orig)){
 diaglog_open("Hibás az email cím!<br><br>Email cím mezőben mindig (módosításnál is) valódi, formatilag helyes email címmel kell kitölteni!","Hiba","del_behajtani16.png");
}else{
 admin_ujkapcstorzs_ment(nev,tagvkod,beosztas,tel,email);
}
}

var ajax_keres_admin_ujkapcstorzs_ment=null;
function admin_ujkapcstorzs_ment(nev,tagvkod,beosztas,tel,email){
$("#admin_ujkapcstorzs_submit").prop("disabled",true);

if(ajax_keres_admin_ujkapcstorzs_ment!=null){
 ajax_keres_admin_ujkapcstorzs_ment.abort();
}

ajax_keres_admin_ujkapcstorzs_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujkapcstorzs_ment&nev="+nev+"&tagvkod="+tagvkod+"&beosztas="+beosztas+"&tel="+tel+"&email="+email,
	function(d){
	ajax_keres_admin_ujkapcstorzs_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_kapcstorzslist_keres_par(){
var nev=encodeURIComponent($("#admin_kapcstorzslist_keres_nev").val());
var tagv=encodeURIComponent($("#admin_kapcstorzslist_keres_tagv").val());
var beosztas=encodeURIComponent($("#admin_kapcstorzslist_keres_beosztas").val());
var inaktiv=encodeURIComponent($("#admin_kapcstorzslist_keres_inaktiv").val());
var par="&nev="+nev+"&tagv="+tagv+"&beosztas="+beosztas+"&inaktiv="+inaktiv;
return par;
}

var admin_kapcstorzslist_keres_fo_wait="";
function admin_kapcstorzslist_keres(id_honnan,hol_lep){
  clearTimeout(admin_kapcstorzslist_keres_fo_wait);
  admin_kapcstorzslist_keres_fo_wait = setTimeout(function(){admin_kapcstorzslist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_admin_kapcstorzslist_keres_proc=null;
function admin_kapcstorzslist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_kapcstorzslist_keres_tal_oldalholvagyok","admin_kapcstorzslist_keres_tal_oldalmax","admin_kapcstorzslist_keres_talszam","admin_kapcstorzslist_keres_proc");
var par=admin_kapcstorzslist_keres_par();

if(ajax_keres_admin_kapcstorzslist_keres_proc!=null){
 ajax_keres_admin_kapcstorzslist_keres_proc.abort();
}

ajax_keres_admin_kapcstorzslist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_kapcstorzslist_keres"+ker_par+par,
	function(d){
	ajax_keres_admin_kapcstorzslist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_kapcstorzs_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modkapcstorzs_ment_fo_wait="";
function admin_modkapcstorzs_ment(id){
  clearTimeout(admin_modkapcstorzs_ment_fo_wait);
  admin_modkapcstorzs_ment_fo_wait = setTimeout(function(){admin_modkapcstorzs_ment_proc(id);},100);
}

var ajax_keres_admin_modkapcstorzs_ment_proc=null;
function admin_modkapcstorzs_ment_proc(id){

var nev=encodeURIComponent($("#admin_modkapcstorzs_nev_"+id).val());
var tagv=encodeURIComponent($("#admin_modkapcstorzs_tagvkod_"+id).val());
var beosztas=encodeURIComponent($("#admin_modkapcstorzs_beosztas_"+id).val());
var tel_orig=$("#admin_modkapcstorzs_tel_"+id).val();
var tel=encodeURIComponent(tel_orig);
var email_orig=$("#admin_modkapcstorzs_email_"+id).val();
var email=encodeURIComponent(email_orig);

var filter =  /[^-0-9+ \\\/]/;

if(email_orig!="" && !isEmail(email_orig)){
 diaglog_open("Hibás az email cím!<br><br>Email cím mezőben mindig (módosításnál is) valódi, formatilag helyes email címmel kell kitölteni!","Hiba","del_behajtani16.png");
 return false;
}

if(tel_orig!="" && filter.test(tel_orig)){
 diaglog_open("Hiba!<br><br>Telefonszám nem megengedett karaktereket tartalmaz!","Hiba","del_behajtani16.png");
 return false;
}

if(ajax_keres_admin_modkapcstorzs_ment_proc!=null){
 ajax_keres_admin_modkapcstorzs_ment_proc.abort();
}

ajax_keres_admin_modkapcstorzs_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkapcstorzs_ment&id="+encodeURIComponent(id)+"&nev="+nev+"&tagv="+tagv+"&beosztas="+beosztas+"&tel="+tel+"&email="+email,
	function(d){
	ajax_keres_admin_modkapcstorzs_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

function admin_modkapcstorzs_inaktiv(id){
if(!$("#admin_modkapcstorzs_inaktiv_"+id).prop("checked")){
 admin_modkapcstorzs_inaktiv_proc(id);
}else{
var nev=$("#admin_modkapcstorzs_nev_"+id).val();
var tagv=$("#admin_modkapcstorzs_tagvkod_"+id).val();
var d="Biztos, hogy inaktiválod "+nev+" ("+tagv+") kapcsolattartó tözsadatot?";
d+="<br><br>Ezzel minden kapcsolattartó beállítása törlésre kerül!";
var title_ki="Kapcsolattartó törzsadat inaktiválása";
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
		
		"inaktiválás":{
                    click: function () {
					 $(this).dialog('widget').find('button').prop('disabled',true);
                     admin_modkapcstorzs_inaktiv_proc(id);
                    },
                    'text': 'Inaktiválás',
                    'class': 'submit2'
		
		},
		"megse":{
                    click: function () {
                     $("#admin_modkapcstorzs_inaktiv_"+id).prop("checked",false);
					 $(this).dialog("close");
                    },
                    'text': 'Mégse',
                    'class': 'submit2'
		
		},
		
      },
	  	open: function (event, ui){
		//$(".ui-dialog-title").html("<img src='image/info_18.png'> "+title_ki);
		alap_input_select_most();
       $("#ui-widget-overlay").fadeIn();
      },
        close: function() {
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
}

var ajax_keres_admin_modkapcstorzs_inaktiv_proc=null;
function admin_modkapcstorzs_inaktiv_proc(id){
if($("#admin_modkapcstorzs_inaktiv_"+id).prop("checked")){
 var inaktiv=1;
}else{
 var inaktiv=0;
}

if(ajax_keres_admin_modkapcstorzs_inaktiv_proc!=null){
 ajax_keres_admin_modkapcstorzs_inaktiv_proc.abort();
}

ajax_keres_admin_modkapcstorzs_inaktiv_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkapcstorzs_inaktiv&id="+encodeURIComponent(id)+"&inaktiv="+inaktiv,
	function(d){
	ajax_keres_admin_modkapcstorzs_inaktiv_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_kapcstorzslist_keres_proc("","");
	 if($('#dialog_egyeni_close').dialog('isOpen')){
	  $("#dialog_egyeni_close").dialog('close');
	 }
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
