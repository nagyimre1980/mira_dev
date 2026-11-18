<?php

?>

function admin_ujhibajavitas(){

//ev=encodeURIComponent($("#admin_ujhibajavitas_ev").val());
//ho=encodeURIComponent($("#admin_ujhibajavitas_ho").val());
var backup_ver_id=encodeURIComponent($("#admin_ujhibajavitas_backup_ver_id").val());
var user_ad=encodeURIComponent($("#admin_ujhibajavitas_user_ad").val());

if(backup_ver_id=='keremv'){
 diaglog_open("Backup DB áttöltés verzió kiválasztása kötelező!","Hiba","del_behajtani16.png");
 return false;
}else if(user_ad=='keremv'){
 diaglog_open("Felhasználó  kiválasztása kötelező!","Hiba","del_behajtani16.png");
 return false;
}

admin_ujhibajavitas_egy(backup_ver_id,user_ad);
}

var ajax_keres_admin_ujhibajavitas_egy=null;
function admin_ujhibajavitas_egy(backup_ver_id,user_ad){

var ev=encodeURIComponent($("#admin_ujhibajavitas_ev").val());
var ho=encodeURIComponent($("#admin_ujhibajavitas_ho").val());
var nap=encodeURIComponent($("#admin_ujhibajavitas_nap").val());

$("#admin_ujhibajavitas_submit,#admin_ujhibajavitas_ev,#admin_ujhibajavitas_ho,#admin_ujhibajavitas_nap,#admin_ujhibajavitas_backup_ver_id,#admin_ujhibajavitas_user_ad").prop("disabled",true);

if(ajax_keres_admin_ujhibajavitas_egy!=null){
 ajax_keres_admin_ujhibajavitas_egy.abort();
}

ajax_keres_admin_ujhibajavitas_egy=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujhibajavitas_egy&backup_ver_id="+backup_ver_id+"&user_ad="+user_ad+"&ev="+ev+"&ho="+ho+"&nap="+nap,
	function(d){
	ajax_keres_admin_ujhibajavitas_egy=null;
	//var d1=d.split("$;$");
	if(d.slice(0,2)=="ok"){
	 //admin_muv_sel();
	 //$("#admin_uj_hibajavitas_list_keres_tal").html(d1[1]);
	 gi("admin_uj_hibajavitas_list_keres_tal").innerHTML=d.slice(5);
	 admin_ujhibajavitas_input();
	 
	 /*
	 var _csonkolt = $('.select2_csonkolt').not('.select2-hidden-accessible');
	 if (_csonkolt.length) {
	  select2_sima_proc_csonkolt(_csonkolt);
	 }
	 */
	//if(nap!='all'){
	 /*
	 $('.select2_csonkolt').each(function(){
	 var _this=$(this);
	 if(!_this.data('select2')){
	   select2_sima_proc_csonkolt(_this);
	  }
	 });
	 */
	//}
	 
	}else{
	 diaglog_open(d,"Rendszerhiba","del_behajtani16.png");
	 admin_muv_sel();
	}
	
	select2_ajax();
	//console.log('select2-container:'+$('.select2-container').length);
	//console.log('accessible:'+$('.select2-hidden-accessible').length);
	//console.log('select2_ajax:'+$('.select2_ajax').length);
	
	},"text");
}

function admin_ujhibajavitas_input(){
input_time_no_mentes=1;
timespinner_start(".input_time");
}

var ajax_keres_admin_modhibajavitas=null;
function admin_modhibajavitas(user_ad,backup_ver_ev){
$("#admin_modhibajavitas_submit").prop("disabled",true);

if(ajax_keres_admin_modhibajavitas!=null){
 ajax_keres_admin_modhibajavitas.abort();
}

var par="&user_ad="+user_ad+"&ev="+backup_ver_ev+"&adat=";
$('.input_time').each(function(){
	var _this=$(this);
	var rogzit_nap=encodeURIComponent(_this.attr("rogzit_nap"));
	var origbackup_pojekt_id=encodeURIComponent(_this.attr("origbackup_pojekt_id"));
	var uj_pojekt_id=encodeURIComponent($("#projektlist_"+this.id+" option:selected").attr("uj_pojekt_id"));
	console.log(uj_pojekt_id);
	var ujbackup_pojekt_id=encodeURIComponent($("#projektlist_"+this.id).val());
	par+=encodeURIComponent(_this.attr("backup_adat_id"))+"-"+encodeURIComponent(_this.val())+"-"+ujbackup_pojekt_id+'-'+origbackup_pojekt_id+'-'+rogzit_nap+'-'+uj_pojekt_id+'#';
});

ajax_keres_admin_modhibajavitas=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modhibajavitas"+par,
	function(d){
	ajax_keres_admin_modhibajavitas=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open("Adatok mentése sikeres az éles és a backup adatbázisban is!","Mentés sikeres");
	 //admin_muv_sel();
	 $("#admin_uj_hibajavitas_list_keres_tal").html('');
	 $("#admin_ujhibajavitas_submit,#admin_ujhibajavitas_ev,#admin_ujhibajavitas_ho,#admin_ujhibajavitas_nap,#admin_ujhibajavitas_backup_ver_id,#admin_ujhibajavitas_user_ad").prop("disabled",false);


	}else{
	 diaglog_open(d,"Rendszerhiba","del_behajtani16.png");
	}
	},"text");
}

function admin_modhibajavitas_megse(){
$("#admin_uj_hibajavitas_list_keres_tal").html('');
$("#admin_ujhibajavitas_submit,#admin_ujhibajavitas_ev,#admin_ujhibajavitas_ho,#admin_ujhibajavitas_nap,#admin_ujhibajavitas_backup_ver_id,#admin_ujhibajavitas_user_ad").prop("disabled",false);

}

