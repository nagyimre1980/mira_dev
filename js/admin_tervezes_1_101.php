<?php

?>

function admin_ujtervezes(){
var tipus=encodeURIComponent($("#admin_ujtervezes_tipus").val());
var ev=encodeURIComponent($("#admin_ujtervezes_ev").val());
var nev=encodeURIComponent($("#admin_ujtervezes_nev").val());
var megj=encodeURIComponent($("#admin_ujtervezes_megj").val());

if(tipus=="keremv"){
 diaglog_open("Hiba!<br><br>Típus kiválasztása kötelező!","Hiba","del_behajtani16.png");
}else if(ev==""){
 diaglog_open("Hiba!<br><br>Év kiválasztása kötelező!","Hiba","del_behajtani16.png");
}else if(nev==""){
 diaglog_open("Hiba!<br><br>Típus nevének kitöltése kötelező!","Hiba","del_behajtani16.png");
}else if(megj==""){
 diaglog_open("Hiba!<br><br>Megjegyzés kitöltése kötelező!","Hiba","del_behajtani16.png");
}else{
 admin_ujtervezes_ment(tipus,ev,nev,megj);
}
}

var ajax_keres_admin_ujtervezes_proc=null;
function admin_ujtervezes_ment(tipus,ev,nev,megj){
$("#admin_ujtervezes_submit").prop("disabled",true);

if(ajax_keres_admin_ujtervezes_proc!=null){
 ajax_keres_admin_ujtervezes_proc.abort();
}

ajax_keres_admin_ujtervezes_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujtervezes_ment&tipus="+tipus+"&ev="+ev+"&nev="+nev+"&megj="+megj,
	function(d){
	ajax_keres_admin_ujtervezes_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_tervezeslist_keres_par(){
var tipus=encodeURIComponent($("#admin_tervezeslist_keres_tipus").val());
var ev=encodeURIComponent($("#admin_tervezeslist_keres_ev").val());
var par="&tipus="+tipus+"&ev="+ev;
return par;
}

var admin_tervezeslist_keres_fo_wait="";
function admin_tervezeslist_keres(id_honnan,hol_lep){
  clearTimeout(admin_tervezeslist_keres_fo_wait);
  admin_tervezeslist_keres_fo_wait = setTimeout(function(){admin_tervezeslist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_admin_tervezeslist_keres_proc=null;
function admin_tervezeslist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_tervezeslist_keres_tal_oldalholvagyok","admin_tervezeslist_keres_tal_oldalmax","admin_tervezeslist_keres_talszam","admin_tervezeslist_keres_proc");
var par=admin_tervezeslist_keres_par();

if(ajax_keres_admin_tervezeslist_keres_proc!=null){
 ajax_keres_admin_tervezeslist_keres_proc.abort();
}

ajax_keres_admin_tervezeslist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tervezeslist_keres"+ker_par+par,
	function(d){
	ajax_keres_admin_tervezeslist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_tervezes_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_tervezes_modment_keres_fo_wait="";
function admin_tervezes_modment(backup_terv_tipus_id){
  clearTimeout(admin_tervezes_modment_keres_fo_wait);
  admin_tervezes_modment_keres_fo_wait = setTimeout(function(){admin_tervezes_modment_proc(backup_terv_tipus_id);},100);
}

var ajax_keres_admin_tervezes_modment_proc=null;
function admin_tervezes_modment_proc(backup_terv_tipus_id){

var nev=encodeURIComponent($("#admin_modtervezes_nev_"+backup_terv_tipus_id).val());
var megj=encodeURIComponent($("#admin_modtervezes_megj_"+backup_terv_tipus_id).val());

if(ajax_keres_admin_tervezes_modment_proc!=null){
 ajax_keres_admin_tervezes_modment_proc.abort();
}

ajax_keres_admin_tervezes_modment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tervezes_modment_proc&backup_terv_tipus_id="+encodeURIComponent(backup_terv_tipus_id)+"&nev="+nev+"&megj="+megj,
	function(d){
	ajax_keres_admin_tervezes_modment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

var ajax_keres_admin_tervezes_riportok=null;
function admin_tervezes_riportok(backup_terv_tipus_id){

if($("#admin_modtervezes_riportok_"+backup_terv_tipus_id).prop("checked")){
 var riportok='1';
}else{
 var riportok='0';
}

if(ajax_keres_admin_tervezes_riportok!=null){
 ajax_keres_admin_tervezes_riportok.abort();
}

ajax_keres_admin_tervezes_riportok=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tervezes_riportok&backup_terv_tipus_id="+encodeURIComponent(backup_terv_tipus_id)+"&riportok="+riportok,
	function(d){
	ajax_keres_admin_tervezes_riportok=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){

	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_tervezes_sordel(backup_terv_tipus_id,tipus,nev,ev){

var d="Biztos, hogy törlöd az alábbi tervezés típust?";
d+="<br><br>Tervezés típus: "+tipus;
d+="<br>Tervezés típus név: "+nev;
d+="<br>Tervezés típus év: "+ev;
var title_ki="Tervezés típus törlése";

	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
		
		"torles":{
                    click: function () {
					 $(this).dialog('widget').find('button').prop('disabled',true);
                     admin_tervezes_sordel_proc(backup_terv_tipus_id);
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

var ajax_keres_admin_tervezes_sordel_proc=null;
function admin_tervezes_sordel_proc(backup_terv_tipus_id){

if(ajax_keres_admin_tervezes_sordel_proc!=null){
 ajax_keres_admin_tervezes_sordel_proc.abort();
}

ajax_keres_admin_tervezes_sordel_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tervezes_sordel_proc&backup_terv_tipus_id="+encodeURIComponent(backup_terv_tipus_id),
	function(d){
	ajax_keres_admin_tervezes_sordel_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_tervezeslist_keres_proc("","");
	 $("#dialog_egyeni_close").dialog('widget').find('button').prop('disabled',false);
	 $("#dialog_egyeni_close").dialog('close');
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_keres_admin_tervezes_tervdel=null;
function admin_tervezes_tervdel(backup_terv_tipus_id){

if(ajax_keres_admin_tervezes_tervdel!=null){
 ajax_keres_admin_tervezes_tervdel.abort();
}

ajax_keres_admin_tervezes_tervdel=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tervezes_tervdel&backup_terv_tipus_id="+encodeURIComponent(backup_terv_tipus_id),
	function(d){
	ajax_keres_admin_tervezes_tervdel=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_tervezeslist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_tervezes_export(backup_terv_tipus_id){
$('<form target=_top action="./admin/ajax_ful_admin_tervezes_betoltes_export.php" method=POST><input type="hidden" name="admin_tervezes_tervbetoltomintaexport" value="'+encodeURIComponent(backup_terv_tipus_id)+'"></form>').appendTo('body').trigger("submit").remove();

}

function admin_tervezes_tervbetoltomintaopen(){
$('<form target=_top action="./admin/ajax_ful_admin_tervezes_betoltes_minta_open.php" method=POST><input type="hidden" name="admin_tervezes_tervbetoltomintaopen" value="admin_tervezes_tervbetoltomintaopen"></form>').appendTo('body').trigger("submit").remove();
}

function tervezes_form_file_input_change(backup_terv_tipus_id){
if($("#tervezes_form_file_input_"+backup_terv_tipus_id).val()==""){
 $("#tervezes_file_input_submit_"+backup_terv_tipus_id).prop("disabled",true);
}else{
 $("#tervezes_file_input_submit_"+backup_terv_tipus_id).prop("disabled",false);
}
}

function startUpload_tervezes_file(backup_terv_tipus_id){//indítás

var file_input_val=$("#tervezes_form_file_input_"+backup_terv_tipus_id).val();

if(file_input_val==""){
 diaglog2_open("Hiba! Nem választottál ki fájlt!","Hiba",'del_behajtani16.png');
 return false;
}else{

 var file_input=file_input_val.split(".");
 var file_input_kit=file_input[file_input.length-1].toLowerCase();

 if(file_input_kit!='xlsx'){
  diaglog2_open("Hiba!<br><br>Ez nem excel (xlsx) fájl!","Hiba",'del_behajtani16.png');
  stopUpload_tervezes_form_reset(backup_terv_tipus_id);
  return false;
 }

//Ha  jó
  $("#upload_result_tervezes_file_"+backup_terv_tipus_id).css("display","block");
  $("#file_upload_tervezes_form_"+backup_terv_tipus_id).css("display","none");
  return true;

}
}

var stopok_Upload_terv_file_uzi="";
function stopok_Upload_tervezes_file(hiba,backup_terv_tipus_id){
diaglog2_open("Feltöltés sikeres!"+hiba,"Hiba",'del_behajtani16.png');
stopUpload_tervezes_form_reset(backup_terv_tipus_id);
admin_tervezeslist_keres_proc("","");
}

function stop_Upload_tervezes_file(result,hiba,backup_terv_tipus_id){
diaglog2_open("Hiba!<br><br>"+hiba,"Hiba",'del_behajtani16.png');
stopUpload_tervezes_form_reset(backup_terv_tipus_id);
admin_tervezeslist_keres_proc("","");
}


function stopUpload_tervezes_form_reset(backup_terv_tipus_id){
 $("#upload_result_tervezes_file_"+backup_terv_tipus_id).css("display","none");
 $("#file_upload_tervezes_form_"+backup_terv_tipus_id).trigger('reset').css("display","block");
 $("#tervezes_file_input_submit_"+backup_terv_tipus_id).prop("disabled",true);
}