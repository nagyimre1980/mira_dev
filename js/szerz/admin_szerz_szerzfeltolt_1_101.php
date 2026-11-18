<?php

?>

function admin_szerzfeltoltlist_keres_par(){
var szerz_id=encodeURIComponent($("#admin_szerzfeltoltlist_keres_szerzid").val());
var tagv_kod=encodeURIComponent($("#admin_szerzfeltoltlist_keres_tagv").val());
var szerztipusid=encodeURIComponent($("#admin_szerzfeltoltlist_keres_szerztipusid").val());
var szerzvane=encodeURIComponent($("#admin_szerzfeltoltlist_keres_szerzvane").val());
var arvane=encodeURIComponent($("#admin_szerzfeltoltlist_keres_arvane").val());
var par="&szerz_id="+szerz_id+"&tagv_kod="+tagv_kod+"&szerztipusid="+szerztipusid+"&szerzvane="+szerzvane+"&arvane="+arvane;
return par;
}

var admin_szerzfeltoltlist_keres_fo_wait="";
function admin_szerzfeltoltlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_szerzfeltoltlist_keres_fo_wait);
  admin_szerzfeltoltlist_keres_fo_wait = setTimeout(function(){admin_szerzfeltoltlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_szerzfeltoltlist_keres_proc=null;
function admin_szerzfeltoltlist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_szerzfeltoltlist_keres_tal_oldalholvagyok","admin_szerzfeltoltlist_keres_tal_oldalmax","admin_szerzfeltoltlist_keres_talszam","admin_szerzfeltoltlist_keres_proc");
var par=admin_szerzfeltoltlist_keres_par();

if(ajax_admin_szerzfeltoltlist_keres_proc!=null){
 ajax_admin_szerzfeltoltlist_keres_proc.abort();
}

ajax_admin_szerzfeltoltlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szerzfeltoltlist_keres"+ker_par+par,
	function(d){
	ajax_admin_szerzfeltoltlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_szerzfeltolt_list_keres_tal").html(d1[1]);
	 tooltip_proc();
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

//Szerződés - eleje
function szerzfeltoltes_form_file_input_change(szerz_id,szerz_tetel_modszam_kezi){
if($("#szerzfeltoltes_form_file_input_"+szerz_id+"_"+szerz_tetel_modszam_kezi).val()==""){
 $("#szerzfeltoltes_file_input_submit_"+szerz_id+"_"+szerz_tetel_modszam_kezi).prop("disabled",true);
}else{
 $("#szerzfeltoltes_file_input_submit_"+szerz_id+"_"+szerz_tetel_modszam_kezi).prop("disabled",false);
}
}

function startUpload_szerzfeltoltes_file(szerz_id,szerz_tetel_modszam_kezi){//indítás
var file_input_val=$("#szerzfeltoltes_form_file_input_"+szerz_id+"_"+szerz_tetel_modszam_kezi).val();

if(file_input_val==""){
 diaglog2_open("Hiba! Nem választottál ki fájlt!","Hiba",'del_behajtani16.png');
 return false;
}else{

 var file_input=file_input_val.split(".");
 var file_input_kit=file_input[file_input.length-1].toLowerCase();
 
 if(file_input_kit!='pdf'){
  diaglog2_open("Hiba!<br><br>Ez nem PDF fájl!","Hiba",'del_behajtani16.png');
  stopUpload_szerzfeltoltes_form_reset(szerz_id,szerz_tetel_modszam_kezi);
  return false;
 }

var fiz_tom_file_meret=gi("szerzfeltoltes_form_file_input_"+szerz_id+"_"+szerz_tetel_modszam_kezi).files[0].size;
if(fiz_tom_file_meret>52428800){
 diaglog2_open("Feltöltés sikertelen!<br><br>Megengedett maximális fájlméret 50MB!<br><br>Feltöltendő fájl ennél nagyobb: "+Number(fiz_tom_file_meret/1048576).toFixed(2)+" Mb","Feltöltés sikertelen!",'hiba');
 return false;
}else{
//Ha  jó
  $("#upload_result_szerzfeltoltes_file_"+szerz_id+"_"+szerz_tetel_modszam_kezi).css("display","block");
  $("#file_upload_szerzfeltoltes_form_"+szerz_id+"_"+szerz_tetel_modszam_kezi).css("display","none");
  return true;
}
}
}

function stopok_Upload_szerzfeltoltes_file(szerz_file_id,name,szerz_id,szerz_tetel_modszam_kezi){//Ha jó
stopUpload_szerzfeltoltes_form_reset(szerz_id,szerz_tetel_modszam_kezi);
admin_szerzfeltoltlist_keres_proc("","");
}

function stop_Upload_szerzfeltoltes_file(result,meret,szerz_id,szerz_tetel_modszam_kezi){//Ha nem jó
//1 általános hiba, 2-fájl túl nagy
if(result==2){
 diaglog2_open("Feltöltés sikertelen!<br><br>Megengedett maximális fájlméret 50MB!<br><br>Feltöltendő fájl ennél nagyobb: "+Number(meret/1048576).toFixed(2)+" Mb","Feltöltés sikertelen!",'hiba');
}else{
 diaglog2_open("Feltöltés sikertelen!","Feltöltés sikertelen!",'hiba');
}

stopUpload_szerzfeltoltes_form_reset(szerz_id,szerz_tetel_modszam_kezi);
admin_szerzfeltoltlist_keres_proc("","");
}

function stopUpload_szerzfeltoltes_form_reset(szerz_id,szerz_tetel_modszam_kezi){
 $("#upload_result_szerzfeltoltes_file_"+szerz_id+"_"+szerz_tetel_modszam_kezi).css("display","none");
 $("#file_upload_szerzfeltoltes_form_"+szerz_id+"_"+szerz_tetel_modszam_kezi).trigger('reset').css("display","block");
 $("#szerzfeltoltes_file_input_submit_"+szerz_id+"_"+szerz_tetel_modszam_kezi).prop("disabled",true);
}
//Szerződés - vége

//Árajánlat - eleje
function szerzfeltoltes_ar_form_file_input_change(szerz_id,szerz_tetel_modszam_kezi){
if($("#szerzfeltoltes_ar_form_file_input_"+szerz_id+"_"+szerz_tetel_modszam_kezi).val()==""){
 $("#szerzfeltoltes_ar_file_input_submit_"+szerz_id+"_"+szerz_tetel_modszam_kezi).prop("disabled",true);
}else{
 $("#szerzfeltoltes_ar_file_input_submit_"+szerz_id+"_"+szerz_tetel_modszam_kezi).prop("disabled",false);
}
}

function startUpload_szerzfeltoltes_ar_file(szerz_id,szerz_tetel_modszam_kezi){//indítás
var file_input_val=$("#szerzfeltoltes_ar_form_file_input_"+szerz_id+"_"+szerz_tetel_modszam_kezi).val();

if(file_input_val==""){
 diaglog2_open("Hiba! Nem választottál ki fájlt!","Hiba",'del_behajtani16.png');
 return false;
}else{

 var file_input=file_input_val.split(".");
 var file_input_kit=file_input[file_input.length-1].toLowerCase();
 
 if(file_input_kit!='pdf'){
  diaglog2_open("Hiba!<br><br>Ez nem PDF fájl!","Hiba",'del_behajtani16.png');
  stopUpload_szerzfeltoltes_ar_form_reset(szerz_id,szerz_tetel_modszam_kezi);
  return false;
 }

var fiz_tom_file_meret=gi("szerzfeltoltes_ar_form_file_input_"+szerz_id+"_"+szerz_tetel_modszam_kezi).files[0].size;
if(fiz_tom_file_meret>52428800){
 diaglog2_open("Feltöltés sikertelen!<br><br>Megengedett maximális fájlméret 50MB!<br><br>Feltöltendő fájl ennél nagyobb: "+Number(fiz_tom_file_meret/1048576).toFixed(2)+" Mb","Feltöltés sikertelen!",'hiba');
 return false;
}else{
//Ha  jó
  $("#upload_result_szerzfeltoltes_ar_file_"+szerz_id+"_"+szerz_tetel_modszam_kezi).css("display","block");
  $("#file_upload_szerzfeltoltes_ar_form_"+szerz_id+"_"+szerz_tetel_modszam_kezi).css("display","none");
  return true;
}
}
}

function stopok_Upload_szerzfeltoltes_ar_file(szerz_file_id,name,szerz_id,szerz_tetel_modszam_kezi){
stopUpload_szerzfeltoltes_ar_form_reset(szerz_id,szerz_tetel_modszam_kezi);
admin_szerzfeltoltlist_keres_proc("","");
}

function stop_Upload_szerzfeltoltes_ar_file(result,meret,szerz_id,szerz_tetel_modszam_kezi){
//1 általános hiba, 2-fájl túl nagy
if(result==2){
 diaglog2_open("Feltöltés sikertelen!<br><br>Megengedett maximális fájlméret 50MB!<br><br>Feltöltendő fájl ennél nagyobb: "+Number(meret/1048576).toFixed(2)+" Mb","Feltöltés sikertelen!",'hiba');
}else{
 diaglog2_open("Feltöltés sikertelen!","Feltöltés sikertelen!",'hiba');
}

stopUpload_szerzfeltoltes_ar_form_reset(szerz_id,szerz_tetel_modszam_kezi);
admin_szerzfeltoltlist_keres_proc("","");
}

function stopUpload_szerzfeltoltes_ar_form_reset(szerz_id,szerz_tetel_modszam_kezi){
 $("#upload_result_szerzfeltoltes_ar_file_"+szerz_id+"_"+szerz_tetel_modszam_kezi).css("display","none");
 $("#file_upload_szerzfeltoltes_ar_form_"+szerz_id+"_"+szerz_tetel_modszam_kezi).trigger('reset').css("display","block");
 $("#szerzfeltoltes_ar_file_input_submit_"+szerz_id+"_"+szerz_tetel_modszam_kezi).prop("disabled",true);
}
//Árajánlat - vége

function szerz_file_open(szerz_file_id,tipus){
$("<form target=_blank id='szerz_file_open_form' method=post action='admin/szerz/admin_szerz_szerzfeltolt_open.php'><input type='hidden' id='szerz_file_open_id' name='szerz_file_id' value='"+encodeURIComponent(szerz_file_id)+"'><input type='hidden' id='szerz_file_open_tipus' name='tipus' value='"+encodeURIComponent(tipus)+"'></form>").appendTo('body').trigger("submit").remove();
}

function szerz_file_del(szerz_file_id,tipus,name){
dialog_kerdes('Törlés','Törlés','<b>Biztos, hogy kitörlöd az alábbi szerződést?</b><br><br>'+name,function(){szerz_file_del_proc(szerz_file_id,tipus)});
}

var ajax_szerz_file_del=null;
function szerz_file_del_proc(szerz_file_id,tipus){

if(ajax_szerz_file_del!=null){
 ajax_szerz_file_del.abort();
}

ajax_admin_szerzfeltoltlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=szerz_file_del_proc&szerz_file_id="+encodeURIComponent(szerz_file_id)+"&tipus="+encodeURIComponent(tipus),
	function(d){
	ajax_admin_szerzfeltoltlist_keres_proc=null;
	 $("#dialog_egyeni_close").dialog('widget').find('button').prop('disabled',false);
	 $("#dialog_egyeni_close").dialog("close");
	if(d=="ok$;$"){
	 admin_szerzfeltoltlist_keres_proc("","");
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");

}
