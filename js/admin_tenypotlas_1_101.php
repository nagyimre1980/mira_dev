<?php

?>

function admin_tenypotlaslist_keres_par(){
var tagv=encodeURIComponent($("#admin_tenypotlaslist_keres_tagv").val());
var szolg_kod=encodeURIComponent($("#admin_tenypotlaslist_keres_szolg_kod").val());
var ev=encodeURIComponent($("#admin_tenypotlaslist_keres_ev").val());
var ho=encodeURIComponent($("#admin_tenypotlaslist_keres_ho").val());
var par="&tagv="+tagv+"&szolg_kod="+szolg_kod+"&ev="+ev+"&ho="+ho;
return par;
}

var admin_tenypotlaslist_keres_fo_wait="";
function admin_tenypotlaslist_keres(id_honnan,hol_lep){
  clearTimeout(admin_tenypotlaslist_keres_fo_wait);
  admin_tenypotlaslist_keres_fo_wait = setTimeout(function(){admin_tenypotlaslist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_admin_tenypotlaslist_keres_proc=null;
function admin_tenypotlaslist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_tenypotlaslist_keres_tal_oldalholvagyok","admin_tenypotlaslist_keres_tal_oldalmax","admin_tenypotlaslist_keres_talszam","admin_tenypotlaslist_keres_proc");
var par=admin_tenypotlaslist_keres_par();

if(ajax_keres_admin_tenypotlaslist_keres_proc!=null){
 ajax_keres_admin_tenypotlaslist_keres_proc.abort();
}

ajax_keres_admin_tervezeslist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tenypotlaslist_keres"+ker_par+par,
	function(d){
	ajax_keres_admin_tenypotlaslist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_tenypotlas_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");

}

function admin_tenypotlas_tenybetoltomintaopen(){
$('<form target=_top action="./admin/ajax_ful_admin_tenypotlas_betoltes_minta_open.php" method=POST><input type="hidden" name="admin_tenypotlas_tenybetoltomintaopen" value="admin_tenypotlas_tenybetoltomintaopen"></form>').appendTo('body').trigger("submit").remove();
}

function tenypotlas_form_file_input_change(){
if($("#tenypotlas_form_file_input").val()==""){
 $("#tenypotlas_file_input_submit").prop("disabled",true);
}else{
 $("#tenypotlas_file_input_submit").prop("disabled",false);
}
}

function startUpload_tenypotlas_file(){
var file_input_val=$("#tenypotlas_form_file_input").val();

if(file_input_val==""){
 diaglog_open("Hiba! Nem választottál ki fájlt!","Hiba",'hiba');
 return false;
}else{

 var file_input=file_input_val.split(".");
 var file_input_kit=file_input[file_input.length-1].toLowerCase();

 if(file_input_kit!='xlsx'){
  diaglog_open("Hiba!<br><br>Ez nem excel (xlsx) fájl!","Hiba",'hiba');
  stopUpload_tenypotlas_form_reset();
  return false;
 }

//Ha  jó
  $("#upload_result_tenypotlas_file").css("display","block");
  $("#file_upload_tenypotlas_form,#file_upload_tenypotlas_form_str").css("display","none");
  return true;

}
}

function stopUpload_tenypotlas_form_reset(){
 $("#upload_result_tenypotlas_file").css("display","none");
 $("#file_upload_tenypotlas_form").trigger('reset').css("display","block");
 $("#tenypotlas_file_input_submit").prop("disabled",true);
}

function stopok_Upload_tenypotlas_file(hiba){
diaglog2_open("Feltöltés sikeres!"+hiba,"OK");
//Oldal újratöltése
ful_betolt(akt_ful);
}

function stop_Upload_tenypotlas_file(result,hiba){
diaglog_open("Hiba!<br><br>"+hiba,"Hiba",'hiba');
//Oldal újratöltése
ful_betolt(akt_ful);
}

function admin_tenypotlas_del_ev(ev){
var d="Biztos, hogy törlöd a teljes "+ev+". évet?";
var title_ki="Év törlése";
$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
		"torles":{
                    click: function () {
					 $(this).dialog('widget').find('button').prop('disabled',true);
                     admin_tenypotlas_del_ev_proc(ev);
                    },
                    'text': 'Törlés',
                    'class': 'submit2'
		},
		"megse":{
                    click: function () {
					 $(this).dialog("close");
                    },
                    'text': 'Mégse',
                    'class': 'submit2'
		},
		
      },
	  	open: function (event, ui){
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

var ajax_keres_admin_tenypotlas_del_ev_proc=null;
function admin_tenypotlas_del_ev_proc(ev){

if(ajax_keres_admin_tenypotlas_del_ev_proc!=null){
 ajax_keres_admin_tenypotlas_del_ev_proc.abort();
}

ajax_keres_admin_tenypotlas_del_ev_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tenypotlas_del_ev_proc&ev="+encodeURIComponent(ev),
	function(d){
	ajax_keres_admin_tenypotlas_del_ev_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_tenypotlaslist_keres_proc('tallep_elso','');
	 $("#dialog_egyeni_close").dialog('close');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

function admin_tenypotlas_del_ho(ev,ho){
var d="Biztos, hogy törlöd a teljes "+ev+". év "+ho+". hónapját?";
var title_ki="Év törlése";
$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
		"torles":{
                    click: function () {
					 $(this).dialog('widget').find('button').prop('disabled',true);
                     admin_tenypotlas_del_ho_proc(ev,ho);
                    },
                    'text': 'Törlés',
                    'class': 'submit2'
		},
		"megse":{
                    click: function () {
					 $(this).dialog("close");
                    },
                    'text': 'Mégse',
                    'class': 'submit2'
		},
		
      },
	  	open: function (event, ui){
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

var ajax_keres_admin_tenypotlas_del_ho_proc=null;
function admin_tenypotlas_del_ho_proc(ev,ho){

if(ajax_keres_admin_tenypotlas_del_ho_proc!=null){
 ajax_keres_admin_tenypotlas_del_ho_proc.abort();
}

ajax_keres_admin_tenypotlas_del_ho_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tenypotlas_del_ho_proc&ev="+encodeURIComponent(ev)+"&ho="+encodeURIComponent(ho),
	function(d){
	ajax_keres_admin_tenypotlas_del_ho_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_tenypotlaslist_keres_proc('tallep_elso','');
	 $("#dialog_egyeni_close").dialog('close');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}