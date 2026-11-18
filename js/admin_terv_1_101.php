<?php

?>

var ajax_admin_backup_default_change=null;
function admin_backup_default_change(idoszak){

if(ajax_admin_backup_default_change!=null){
 ajax_admin_backup_default_change.abort();
}

var mit=encodeURIComponent($("#admin_backup_terv_default_"+idoszak).val());

ajax_admin_backup_default_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_default_change&idoszak="+encodeURIComponent(idoszak)+"&mit="+mit,
	function(d){
	ajax_admin_backup_default_change=null;
	
	if(d=="ok$;$"){
	 
	}else{
		diaglog_open(d,"Hiba");
	}
	});
}

var ajax_admin_backup_masol_proc=null;
function admin_backup_masol_proc(ev,ho){
$("#backup_atmasol_"+ev+ho).prop("disabled",true).val('Áttöltés folyamatban, kérlek várj...');

$("input[type=submit][id^=backup_atmasol_]").each(function(){
 $(this).prop("disabled",true).val('Áttöltés folyamatban, kérlek várj...');
})

if(ajax_admin_backup_masol_proc!=null){
 ajax_admin_backup_masol_proc.abort();
}

ajax_admin_backup_masol_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_masol_proc&ev="+encodeURIComponent(ev)+"&ho="+encodeURIComponent(ho),
	function(d){
	ajax_admin_backup_masol_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Áttöltés sikeres");
	}else{
		diaglog_open(d,"Hiba");
	}
	admin_muv_sel();
	});
}

function admin_backup_terv_delete(idoszak){

var backup_ver_id_teszt=$("#admin_backup_terv_megnyit_"+idoszak+" option:selected").text();

var title_ki="Áttöltés törlése";
var d="<b>Biztos, hogy törlöd az alábbi áttöltést?</b>";
	d+="<br><br>"+backup_ver_id_teszt;
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
		
		"Törlés":{
                    click: function () {
                     var backup_ver_id=$("#admin_backup_terv_megnyit_"+idoszak).val();
					 $(this).dialog('widget').find('button').prop('disabled',true);
					 admin_backup_terv_delete_proc(backup_ver_id);
                    },
                    'text': 'Törlés',
                    'class': 'submit2'
		
		},
		"Mégse":{
                    click: function () {
                     $(this).dialog("close");;
                    },
                    'text': 'Mégse',
                    'class': 'submit2'
		
		},
		
      },
	  	open: function (event, ui){
		$(".ui-dialog-title").html("<img src='image/del_behajtani16.png'> "+title_ki);
        $("#ui-widget-overlay").fadeIn();
      },
        close: function() {
		if(
		(!$('#dialog_egyeni_close').dialog('isOpen')) &&
		(!$('#dialog').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }

        }
	}).dialog( "open" );

}

var ajax_keres_admin_backup_terv_delete_proc=null;
function admin_backup_terv_delete_proc(backup_ver_id){

if(ajax_keres_admin_backup_terv_delete_proc!=null){
 ajax_keres_admin_backup_terv_delete_proc.abort();
}

ajax_keres_admin_backup_terv_delete_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_delete_proc&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_delete_proc=null;
	if(d.slice(0,5)=="ok$;$"){
	 diaglog_open('Áttöltés törlése sikeres',"Áttöltés törlése");
	 $("#dialog_egyeni_close").dialog("close");
	 admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});

}

var ajax_keres_admin_backup_terv=null;
function admin_backup_terv(idoszak){

if(ajax_keres_admin_moduser_inaktiv!=null){
 ajax_keres_admin_moduser_inaktiv.abort();
}

var backup_ver_id=encodeURIComponent($("#admin_backup_terv_megnyit_"+idoszak).val());

ajax_keres_admin_backup_terv=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv=null;
	if(d.slice(0,5)=="ok$;$"){
	 diaglog_open(d.slice(5),"Tervezés");
	 
	 if(stopok_Upload_terv_file_uzi!=""){
		diaglog2_open(stopok_Upload_terv_file_uzi,"Feltöltés ok");
		stopok_Upload_terv_file_uzi='';
	 }
	 
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_backup_terv_adat=null;
function admin_backup_terv_adat(idoszak){

if(ajax_keres_admin_backup_terv_adat!=null){
 ajax_keres_admin_backup_terv_adat.abort();
}

var backup_ver_id=encodeURIComponent($("#admin_backup_terv_megnyit_"+idoszak).val());

ajax_keres_admin_backup_terv_adat=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_adat&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_adat=null;
	if(d.slice(0,5)=="ok$;$"){
	 $("#div_admin_backup_terv_adat").html(d.slice(5));
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}


var ajax_keres_admin_backup_terv_1pont=null;
function admin_backup_terv_1pont(idoszak,backup_ver_id){
$("#admin_backup_terv_1pont_"+backup_ver_id).prop('disabled',true).val('Kalkuláció folyamatban');
$(".submit2.terv").prop('disabled',true);

if(ajax_keres_admin_backup_terv_1pont!=null){
 ajax_keres_admin_backup_terv_1pont.abort();
}

ajax_keres_admin_backup_terv_1pont=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_1pont&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_1pont=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_backup_terv_1_del=null;
function admin_backup_terv_1_del(idoszak,backup_ver_id){

if(ajax_keres_admin_backup_terv_1_del!=null){
 ajax_keres_admin_backup_terv_1_del.abort();
}

ajax_keres_admin_backup_terv_1_del=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_1_del&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_1_del=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}





var ajax_keres_admin_backup_terv_2pont=null;
function admin_backup_terv_2pont(idoszak,backup_ver_id){
$("#admin_backup_terv_2pont_"+backup_ver_id).prop('disabled',true).val('Kalkuláció folyamatban');
$(".submit2.terv").prop('disabled',true);

if(ajax_keres_admin_backup_terv_2pont!=null){
 ajax_keres_admin_backup_terv_2pont.abort();
}

ajax_keres_admin_backup_terv_2pont=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_2pont&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_2pont=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_backup_terv_2_del=null;
function admin_backup_terv_2_del(idoszak,backup_ver_id){

if(ajax_keres_admin_backup_terv_2_del!=null){
 ajax_keres_admin_backup_terv_2_del.abort();
}

ajax_keres_admin_backup_terv_2_del=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_2_del&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_2_del=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}





//3.1 tény - eleje
var ajax_keres_admin_backup_terv_3_1pont=null;
function admin_backup_terv_3_1pont(idoszak,backup_ver_id){
$("#admin_backup_terv_3_1pont_"+backup_ver_id).prop('disabled',true).val('Kalkuláció folyamatban');
$(".submit2.terv").prop('disabled',true);

if(ajax_keres_admin_backup_terv_3_1pont!=null){
 ajax_keres_admin_backup_terv_3_1pont.abort();
}

ajax_keres_admin_backup_terv_3_1pont=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_3_1pont&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_3_1pont=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_backup_terv_3_1_del=null;
function admin_backup_terv_3_1_del(idoszak,backup_ver_id){

if(ajax_keres_admin_backup_terv_3_1_del!=null){
 ajax_keres_admin_backup_terv_3_1_del.abort();
}

ajax_keres_admin_backup_terv_3_1_del=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_3_1_del&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_3_1_del=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}
//3.1 tény - vége

//3.1.1 tény - eleje
var ajax_keres_admin_backup_terv_3_1_1pont=null;
function admin_backup_terv_3_1_1pont(idoszak,backup_ver_id){
$("#admin_backup_terv_3_1_1pont_"+backup_ver_id).prop('disabled',true).val('Kalkuláció folyamatban');
$(".submit2.terv").prop('disabled',true);

if(ajax_keres_admin_backup_terv_3_1_1pont!=null){
 ajax_keres_admin_backup_terv_3_1_1pont.abort();
}

ajax_keres_admin_backup_terv_3_1_1pont=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_3_1_1pont&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_3_1_1pont=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_backup_terv_3_1_1_del=null;
function admin_backup_terv_3_1_1_del(idoszak,backup_ver_id){

if(ajax_keres_admin_backup_terv_3_1_1_del!=null){
 ajax_keres_admin_backup_terv_3_1_1_del.abort();
}

ajax_keres_admin_backup_terv_3_1_1_del=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_3_1_1_del&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_3_1_1_del=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}
//3.1.1 tény - vége

//3.3 tény - eleje
var ajax_keres_admin_backup_terv_3_3pont=null;
function admin_backup_terv_3_3pont(idoszak,backup_ver_id){
$("#admin_backup_terv_3_3pont_"+backup_ver_id).prop('disabled',true).val('Kalkuláció folyamatban');
$(".submit2.terv").prop('disabled',true);

if(ajax_keres_admin_backup_terv_3_3pont!=null){
 ajax_keres_admin_backup_terv_3_3pont.abort();
}

ajax_keres_admin_backup_terv_3_3pont=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_3_3pont&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_3_3pont=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_backup_terv_3_3_del=null;
function admin_backup_terv_3_3_del(idoszak,backup_ver_id){

if(ajax_keres_admin_backup_terv_3_3_del!=null){
 ajax_keres_admin_backup_terv_3_3_del.abort();
}

ajax_keres_admin_backup_terv_3_3_del=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_3_3_del&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_3_3_del=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}
//3.3 tény - vége

//3.2 tény - eleje
var ajax_keres_admin_backup_terv_3_2pont=null;
function admin_backup_terv_3_2pont(idoszak,backup_ver_id){
$("#admin_backup_terv_3_2pont_"+backup_ver_id).prop('disabled',true).val('Kalkuláció folyamatban');
$(".submit2.terv").prop('disabled',true);

if(ajax_keres_admin_backup_terv_3_2pont!=null){
 ajax_keres_admin_backup_terv_3_2pont.abort();
}

ajax_keres_admin_backup_terv_3_2pont=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_3_2pont&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_3_2pont=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	 admin_backup_terv_3_3pont(idoszak,backup_ver_id);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_backup_terv_3_2_del=null;
function admin_backup_terv_3_2_del(idoszak,backup_ver_id){

if(ajax_keres_admin_backup_terv_3_2_del!=null){
 ajax_keres_admin_backup_terv_3_2_del.abort();
}

ajax_keres_admin_backup_terv_3_2_del=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_3_2_del&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_3_2_del=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}
//3.2 tény - vége

//3 tény - eleje
var ajax_keres_admin_backup_terv_3pont=null;
function admin_backup_terv_3pont(idoszak,backup_ver_id){
$("#admin_backup_terv_3pont_"+backup_ver_id).prop('disabled',true).val('Kalkuláció folyamatban');
$(".submit2.terv").prop('disabled',true);

if(ajax_keres_admin_backup_terv_3pont!=null){
 ajax_keres_admin_backup_terv_3pont.abort();
}

ajax_keres_admin_backup_terv=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_3pont&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_backup_terv_3_del=null;
function admin_backup_terv_3_del(idoszak,backup_ver_id){

if(ajax_keres_admin_backup_terv_3_del!=null){
 ajax_keres_admin_backup_terv_3_del.abort();
}

ajax_keres_admin_backup_terv_3_del=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_3_del&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_3_del=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv_adat(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}
//3 tény - vége

function admin_backup_terv_1pont_letolt(backup_ver_id){
$('<form target=_top action="./ajax_ful_admin.php" method=POST><input type="hidden" name="backup_ver_id" value="'+backup_ver_id+'"><input type="hidden" name="admin_backup_terv_xlsx_letolt" value="terv1"></form>').appendTo('body').trigger("submit").remove();
}

function admin_backup_terv_2pont_letolt(backup_ver_id){
$('<form target=_top action="./ajax_ful_admin.php" method=POST><input type="hidden" name="backup_ver_id" value="'+backup_ver_id+'"><input type="hidden" name="admin_backup_terv_xlsx_letolt" value="terv2"></form>').appendTo('body').trigger("submit").remove();
}

function admin_backup_terv_3_1pont_letolt(backup_ver_id){
$('<form target=_top action="./ajax_ful_admin.php" method=POST><input type="hidden" name="backup_ver_id" value="'+backup_ver_id+'"><input type="hidden" name="admin_backup_terv_xlsx_letolt" value="terv3_1"></form>').appendTo('body').trigger("submit").remove();
}

function admin_backup_terv_3_1_1pont_letolt(backup_ver_id){
$('<form target=_top action="./ajax_ful_admin.php" method=POST><input type="hidden" name="backup_ver_id" value="'+backup_ver_id+'"><input type="hidden" name="admin_backup_terv_xlsx_letolt" value="terv3_1_1"></form>').appendTo('body').trigger("submit").remove();
}

function admin_backup_terv_3_2pont_letolt(backup_ver_id){
$('<form target=_top action="./ajax_ful_admin.php" method=POST><input type="hidden" name="backup_ver_id" value="'+backup_ver_id+'"><input type="hidden" name="admin_backup_terv_xlsx_letolt" value="terv3_2"></form>').appendTo('body').trigger("submit").remove();
}

function admin_backup_terv_3_3pont_letolt(backup_ver_id){
$('<form target=_top action="./ajax_ful_admin.php" method=POST><input type="hidden" name="backup_ver_id" value="'+backup_ver_id+'"><input type="hidden" name="admin_backup_terv_xlsx_letolt" value="terv3_3"></form>').appendTo('body').trigger("submit").remove();
}

function admin_backup_terv_3pont_letolt(backup_ver_id){
var tipus=encodeURIComponent($("#terv3_tipus").val());
var hatar_also=encodeURIComponent($("#terv3_hatar_also").val());
var hatar_felso=encodeURIComponent($("#terv3_hatar_felso").val());
var hatar_jelentos=encodeURIComponent($("#terv3_hatar_jelentos").val());

if(hatar_also!='' && hatar_felso!=''){
 $('<form target=_top action="./ajax_ful_admin.php" method=POST><input type="hidden" name="backup_ver_id" value="'+backup_ver_id+'"><input type="hidden" name="tipus" value="'+tipus+'"><input type="hidden" name="hatar_also" value="'+hatar_also+'"><input type="hidden" name="hatar_felso" value="'+hatar_felso+'"><input type="hidden" name="hatar_jelentos" value="'+hatar_jelentos+'"><input type="hidden" name="admin_backup_terv_xlsx_letolt" value="terv3"></form>').appendTo('body').trigger("submit").remove();
}
}

//Tevékenység lista betöltéshez
function admin_backup_terv_projekt_le(backup_ver_id){
$('<form target=_top action="./ajax_ful_admin.php" method=POST><input type="hidden" name="backup_ver_id" value="'+backup_ver_id+'"><input type="hidden" name="admin_backup_terv_xlsx_letolt" value="terv_projekt_le"></form>').appendTo('body').trigger("submit").remove();
}

//Tevékenység szétbontás adatok
function admin_backup_terv_projektszetbont_le(backup_ver_id){
$('<form target=_top action="./ajax_ful_admin.php" method=POST><input type="hidden" name="backup_ver_id" value="'+backup_ver_id+'"><input type="hidden" name="admin_backup_terv_xlsx_letolt" value="terv_projektszetbont_le"></form>').appendTo('body').trigger("submit").remove();
}

function admin_backup_terv_betoltominta_szetbontas(){
//<input type="hidden" name="backup_ver_id" value="'+backup_ver_id+'">
$('<form target=_top action="./ajax_ful_admin.php" method=POST><input type="hidden" name="admin_backup_terv_xlsx_letolt" value="terv_betoltominta_szetbontas"></form>').appendTo('body').trigger("submit").remove();
}

function terv_form_file_input_change(){//Fájl ki van-e választva
if($("#terv_form_file_input").val()==""){
 $("#terv_file_input_submit").prop("disabled",true);
}else{
 $("#terv_file_input_submit").prop("disabled",false);
}
}

function startUpload_terv_file(){//indítás

var file_input_val=$("#terv_form_file_input").val();

if(file_input_val==""){
 diaglog2_open("Hiba! Nem választottál ki fájlt!","Hiba",'del_behajtani16.png');
 return false;
}else{

 var file_input=file_input_val.split(".");
 var file_input_kit=file_input[file_input.length-1].toLowerCase();

 if(file_input_kit!='xlsx'){
  diaglog2_open("Hiba!<br><br>Ez nem excel (xlsx) fájl!","Hiba",'del_behajtani16.png');
  stopUpload_terv_form_reset();
  return false;
 }
 
 if($("#terv_file_input_tipus").val()=="keremv"){
	 diaglog2_open("Hiba!<br><br>Típus kiválasztása kötelező!","Hiba",'del_behajtani16.png');
	 return false;
 }
 
//Ha  jó
  $("#upload_result_terv_file").css("display","block");
  $("#file_upload_terv_form").css("display","none");
  return true;
}
}

var stopok_Upload_terv_file_uzi="";
function stopok_Upload_terv_file(hiba,backup_ver_ev_ho,backup_ver_id){

//diaglog2_open("Hiba!<br><br>Feltöltés sikeres"+hiba,"Feltöltés ok");
//diaglog2_open("Feltöltés sikeres"+hiba,"Feltöltés ok");
stopok_Upload_terv_file_uzi="Feltöltés sikeres"+hiba;
stopUpload_terv_form_reset();
admin_backup_terv(backup_ver_ev_ho);



//admin_backup_terv_3_1_1_del(backup_ver_ev_ho,backup_ver_id);
//alert("Feltöltés sikeres"+hiba);
}

function stop_Upload_terv_file(result,hiba){
diaglog2_open("Hiba!<br><br>"+hiba,"Hiba",'del_behajtani16.png');
stopUpload_terv_form_reset();
}

function stopUpload_terv_form_reset(){
	$("#upload_result_terv_file").css("display","none");
	$("#file_upload_terv_form").trigger('reset').css("display","block");
	 $("#terv_file_input_submit").prop("disabled",true);
}

var ajax_keres_admin_backup_terv_projektszetbont_del=null;
function admin_backup_terv_projektszetbont_del(idoszak,backup_ver_id){

if(ajax_keres_admin_backup_terv_projektszetbont_del!=null){
 ajax_keres_admin_backup_terv_projektszetbont_del.abort();
}

ajax_keres_admin_backup_terv_projektszetbont_del=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_backup_terv_projektszetbont_del&backup_ver_id="+encodeURIComponent(backup_ver_id),
	function(d){
	ajax_keres_admin_backup_terv_projektszetbont_del=null;
	if(d.slice(0,5)=="ok$;$"){
	 admin_backup_terv(idoszak);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

