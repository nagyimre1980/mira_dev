<?php

?>


function admin_szerz_tenypotlastig_generalas(){
$("#admin_ujtenypotlastig3_submit").prop('disabled',true);
dialog_kerdes('Generálás','Generálás','Biztos, újragenerálod a hónapot?<br>Ezzel az adott hónap minden adata törlődik!',
function(){admin_szerz_tenypotlastig_generalas_proc()},
function(){$("#admin_ujtenypotlastig3_submit").prop('disabled',false);},
);

}

var ajax_keres_admin_szerz_tenypotlastig_generalas_proc=null;
function admin_szerz_tenypotlastig_generalas_proc(){

var ev=encodeURIComponent($("#admin_ujtigadatnemszerz_ev").val());
var ho=encodeURIComponent($("#admin_ujtigadatnemszerz_ho").val());
var nap=encodeURIComponent($("#admin_ujtigadatnemszerz_nap").val());
if($("#admin_ujtigadatnemszerz_miraorakelle").prop('checked'))
 var miraorakelle='1';
else var miraorakelle='0';
	
if(ajax_keres_admin_szerz_tenypotlastig_generalas_proc!=null){
 ajax_keres_admin_szerz_tenypotlastig_generalas_proc.abort();
}

ajax_keres_admin_szerz_tenypotlastig_generalas_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=ajax_keres_admin_szerz_tenypotlastig_generalas&ev="+ev+"&ho="+ho+"&nap="+nap+"&miraorakelle="+miraorakelle,
	function(d){
	ajax_keres_admin_szerz_tenypotlastig_generalas_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	 $("#dialog_egyeni_close").dialog("close");
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba",'hiba');	
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_ujtenypotlastig(){
var id=encodeURIComponent($("#admin_ujtenypotlastig_id").val());
var ev=encodeURIComponent($("#admin_ujtenypotlastig_ev").val());
var ho=encodeURIComponent($("#admin_ujtenypotlastig_ho").val());

if(id==""){
 diaglog_open("Szolgáltatás ID kitöltése kötelező!","Hiba");
}else{
 admin_ujtenypotlastig_ment(id,ev,ho);
}
}

var ajax_keres_admin_ujtenypotlastig_ment=null;
function admin_ujtenypotlastig_ment(id,ev,ho){
$("#admin_ujtenypotlastig_submit").prop("disabled",true);

if(ajax_keres_admin_ujtenypotlastig_ment!=null){
 ajax_keres_admin_ujtenypotlastig_ment.abort();
}

ajax_keres_admin_ujtenypotlastig_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujtenypotlastig_ment&id="+id+"&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_admin_ujtenypotlastig_ment=null;
	if(d=="ok$;$"){
	 admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");
	 $("#admin_ujtenypotlastig_submit").prop("disabled",false);
	}
	});
}

function admin_szolgkodlist_keres_par(){
var id=encodeURIComponent($("#admin_tenypotlastiglist_keres_id").val());
var ev=encodeURIComponent($("#admin_tenypotlastiglist_keres_ev").val());
var ho=encodeURIComponent($("#admin_tenypotlastiglist_keres_ho").val());

if(ev=='all')$("#admin_tenypotlastiglist_keres_ho").prop('disabled',true);
else $("#admin_tenypotlastiglist_keres_ho").prop('disabled',false);

var par="&id="+id+"&ev="+ev+"&ho="+ho;
return par;
}

var admin_tenypotlastiglist_keres_fo_wait="";
function admin_tenypotlastiglist_keres(id_honnan,hol_lep){
  clearTimeout(admin_tenypotlastiglist_keres_fo_wait);
  admin_tenypotlastiglist_keres_fo_wait = setTimeout(function(){admin_tenypotlastiglist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_admin_tenypotlastiglist_keres_proc=null;
function admin_tenypotlastiglist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_tenypotlastiglist_keres_tal_oldalholvagyok","admin_tenypotlastiglist_keres_tal_oldalmax","admin_tenypotlastiglist_keres_talszam","admin_tenypotlastiglist_keres_proc");
var par=admin_szolgkodlist_keres_par();

if(ajax_keres_admin_tenypotlastiglist_keres_proc!=null){
 ajax_keres_admin_tenypotlastiglist_keres_proc.abort();
}

ajax_keres_admin_tenypotlastiglist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tenypotlastiglist_keres"+ker_par+par,
	function(d){
	ajax_keres_admin_tenypotlastiglist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_tenypotlastig_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modtenypotlastig_ment_fo_wait="";
function admin_modtenypotlastig_ment(egyedi_id,szerz_tetel_id,evho_orig){
  clearTimeout(admin_modtenypotlastig_ment_fo_wait);
  admin_modtenypotlastig_ment_fo_wait = setTimeout(function(){admin_modtenypotlastig_ment_proc(egyedi_id,szerz_tetel_id,evho_orig);},100);
}

var ajax_keres_admin_modtenypotlastig_ment_proc=null;
function admin_modtenypotlastig_ment_proc(egyedi_id,szerz_tetel_id,evho_orig){
var egyebnat=encodeURIComponent($("#admin_modtenypotlastig_egyebnat_"+egyedi_id).val());

if(ajax_keres_admin_modtenypotlastig_ment_proc!=null){
 ajax_keres_admin_modtenypotlastig_ment_proc.abort();
}

ajax_keres_admin_modtenypotlastig_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modtenypotlastig_ment&szerz_tetel_id="+encodeURIComponent(szerz_tetel_id)+"&evho_orig="+evho_orig+"&egyebnat="+egyebnat,
	function(d){
	ajax_keres_admin_modtenypotlastig_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_modtenypotlastig_del(egyedi_id,szerz_tetel_id,evho){
$("#tr_tenypotlastig_"+egyedi_id+" td").addClass('pir_hat_red');
dialog_kerdes('Törlés','Törlés','Biztos, hogy kitörlöd ezt a rekordot?',
function(){admin_modtenypotlastig_del_proc(szerz_tetel_id,evho)},
function(){$("#tr_tenypotlastig_"+egyedi_id+" td").removeClass('pir_hat_red');}
);
}

var ajax_keres_admin_modtenypotlastig_del_proc=null;
function admin_modtenypotlastig_del_proc(szerz_tetel_id,evho){
if(ajax_keres_admin_modtenypotlastig_del_proc!=null){
 ajax_keres_admin_modtenypotlastig_del_proc.abort();
}

ajax_keres_admin_modtenypotlastig_del_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modtenypotlastig_del&szerz_tetel_id="+encodeURIComponent(szerz_tetel_id)+"&evho="+encodeURIComponent(evho),
	function(d){
	ajax_keres_admin_modtenypotlastig_del_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	 $("#dialog_egyeni_close").dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
	
}

function admin_tenypotlastig_tenybetoltomintaopen(){
$('<form target=_top action="./admin/ajax_ful_admin_tenypotlas_tig_betoltes_minta_open.php" method=POST><input type="hidden" name="admin_tenypotlastig_tenybetoltomintaopen" value="admin_tenypotlastig_tenybetoltomintaopen"></form>').appendTo('body').trigger("submit").remove();
}

function tenypotlastig_form_file_input_change(){
if($("#tenypotlastig_form_file_input").val()==""){
 $("#tenypotlastig_file_input_submit").prop("disabled",true);
}else{
 $("#tenypotlastig_file_input_submit").prop("disabled",false);
}
}

function startUpload_tenypotlastig_file(){
var file_input_val=$("#tenypotlastig_form_file_input").val();

if(file_input_val==""){
 diaglog_open("Hiba! Nem választottál ki fájlt!","Hiba",'hiba');
 return false;
}else{

 var file_input=file_input_val.split(".");
 var file_input_kit=file_input[file_input.length-1].toLowerCase();

 if(file_input_kit!='xlsx'){
  diaglog_open("Hiba!<br><br>Ez nem excel (xlsx) fájl!","Hiba",'hiba');
  stopUpload_tenypotlastig_form_reset();
  return false;
 }

//Ha  jó
  $("#upload_result_tenypotlastig_file").css("display","block");
  $("#file_upload_tenypotlastig_form,#file_upload_tenypotlas_form_str").css("display","none");
  return true;

}
}

function stopUpload_tenypotlastig_form_reset(){
 $("#upload_result_tenypotlastig_file").css("display","none");
 $("#file_upload_tenypotlastig_form").trigger('reset').css("display","block");
 $("#tenypotlastig_file_input_submit").prop("disabled",true);
}

function stopok_Upload_tenypotlastig_file(hiba){
diaglog2_open("Feltöltés sikeres!"+hiba,"OK");
//Oldal újratöltése
ful_betolt(akt_ful);
}

function stop_Upload_tenypotlastig_file(result,hiba){
diaglog_open("Hiba!<br><br>"+hiba,"Hiba",'del_behajtani16.png');
//Oldal újratöltése
ful_betolt(akt_ful);
}

