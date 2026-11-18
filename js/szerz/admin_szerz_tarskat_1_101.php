<?php

?>

var ajax_keres_admin_szerz_tagvkat_mod=null;
function admin_szerz_tagvkat_mod(tagv_kod){

if(ajax_keres_admin_szerz_tagvkat_mod!=null){
 ajax_keres_admin_szerz_tagvkat_mod.abort();
}

ajax_keres_admin_szerz_tagvkat_mod=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szerz_tagvkat_mod&tagv_kod="+encodeURIComponent(tagv_kod),
	function(d){
	ajax_keres_admin_szerz_tagvkat_mod=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_szerz_tagvkat_mod_dialog(d1[1],"Társasági kategória módosítása:, Társaság: "+tagv_kod);	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");

}

function admin_szerz_tagvkat_mod_dialog(d,title_ki){
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons:{},
	/*buttons: {
        "Igen": function() {
		 admin_modproj_hozzall_change_proc(szerv_id);
        },
        "Mégse": function() {
		  $("#proj_allhozzid").prop("checked",false);
          $(this).dialog("close");
        }
      },*/
	  open: function (event, ui){
        $("#ui-widget-overlay").fadeIn();
		alap_input_select_most();
		autocomplete_off();
		date_tol_ig();
		tooltip_proc();
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

var ajax_admin_szerz_tagvkat_uj_ment=null;
function admin_szerz_tagvkat_uj_ment(tagv_kod){
var tagvkat=encodeURIComponent($("#admin_szerz_tagvkat_uj_tagvkat").val());
var date_kezd=encodeURIComponent($("#admin_szerz_tagvkat_uj_date_kezd").val());
var date_veg=encodeURIComponent($("#admin_szerz_tagvkat_uj_date_veg").val());

if(tagvkat=='keremv' || date_kezd==''){
 diaglog_open("Minden adat kitöltése kötelező","Hiba");
 return false;
}

if(ajax_admin_szerz_tagvkat_uj_ment!=null){
 ajax_admin_szerz_tagvkat_uj_ment.abort();
}

var par="&tagv_kod="+encodeURIComponent(tagv_kod)+"&tagvkat="+tagvkat+"&date_kezd="+date_kezd+"&date_veg="+date_veg;
ajax_admin_szerz_tagvkat_uj_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szerz_tagvkat_uj_ment"+par,
	function(d){
	ajax_keres_admin_szerz_tagvkat_mod=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#dialog_egyeni_close").html(d1[2]);
	 admin_muv_sel();
	 alap_input_select_most();
	 date_tol_ig();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
	
}

var ajax_admin_szerz_tagvkat_uj_del=null;
function admin_szerz_tagvkat_uj_del(tagv_kod,szerz_tagvkat_id){
if(ajax_admin_szerz_tagvkat_uj_del!=null){
 ajax_admin_szerz_tagvkat_uj_del.abort();
}

var par="&tagv_kod="+encodeURIComponent(tagv_kod)+"&szerz_tagvkat_id="+szerz_tagvkat_id;
ajax_admin_szerz_tagvkat_uj_del=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szerz_tagvkat_uj_del"+par,
	function(d){
	ajax_admin_szerz_tagvkat_uj_del=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#dialog_egyeni_close").html(d1[2]);
	 admin_muv_sel();
	 alap_input_select_most();
	 date_tol_ig();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_tarskatlist_keres_par(){
var tagv_kod=encodeURIComponent($("#admin_tarskatlist_keres_tagv").val());
var par="&tagv_kod="+tagv_kod;
return par;
}

var admin_tarskatlist_keres_fo_wait="";
function admin_tarskatlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_tarskatlist_keres_fo_wait);
  admin_tarskatlist_keres_fo_wait = setTimeout(function(){admin_tarskatlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_tarskatlist_keres_proc=null;
function admin_tarskatlist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_tarskatlist");
var par=admin_tarskatlist_keres_par();

if(ajax_admin_tarskatlist_keres_proc!=null){
 ajax_admin_tarskatlist_keres_proc.abort();
}

ajax_admin_tarskatlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_tarskatlist_keres"+ker_par+par,
	function(d){
	ajax_admin_tarskatlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_tarskat_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
