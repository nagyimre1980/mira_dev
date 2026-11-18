<?php

?>

function admin_ujkapcstulaj(){
var kod=encodeURIComponent($("#admin_ujkapcstulaj_kod").val());
var nev=encodeURIComponent($("#admin_ujkapcstulaj_nev").val());

if(kod==""){
 diaglog_open("Tulajdonosi joggyakorló kód kitöltése kötelező!","Hiba","del_behajtani16.png");
}else if(nev==""){
 diaglog_open("Tulajdonosi joggyakorló nevének kitöltése kötelező!","Hiba","del_behajtani16.png");
}else{
 admin_ujkapcstulaj_ment(kod,nev);
}
}

var ajax_keres_admin_ujkapcstulaj_ment=null;
function admin_ujkapcstulaj_ment(kod,nev){
$("#admin_ujkapcstulaj_submit").prop("disabled",true);

if(ajax_keres_admin_ujkapcstulaj_ment!=null){
 ajax_keres_admin_ujkapcstulaj_ment.abort();
}

ajax_keres_admin_ujkapcstulaj_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujkapcstulaj_ment&kod="+kod+"&nev="+nev,
	function(d){
	ajax_keres_admin_ujkapcstulaj_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_kapcstulajlist_keres_par(){
var kod=encodeURIComponent($("#admin_kapcstulajlist_keres_kod").val());
var nev=encodeURIComponent($("#admin_kapcstulajlist_keres_nev").val());
var inaktiv=encodeURIComponent($("#admin_kapcstulajlist_keres_inaktiv").val());
var par="&kod="+kod+"&nev="+nev+"&inaktiv="+inaktiv;
return par;
}

var admin_kapcstulajlist_keres_fo_wait="";
function admin_kapcstulajlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_kapcstulajlist_keres_fo_wait);
  admin_kapcstulajlist_keres_fo_wait = setTimeout(function(){admin_kapcstulajlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_admin_kapcstulajlist_keres_proc=null;
function admin_kapcstulajlist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_kapcstulajlist_keres_tal_oldalholvagyok","admin_kapcstulajlist_keres_tal_oldalmax","admin_kapcstulajlist_keres_talszam","admin_kapcstulajlist_keres_proc");
var par=admin_kapcstulajlist_keres_par();

if(ajax_keres_admin_kapcstulajlist_keres_proc!=null){
 ajax_keres_admin_kapcstulajlist_keres_proc.abort();
}

ajax_keres_admin_kapcstulajlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_kapcstulajlist_keres"+ker_par+par,
	function(d){
	ajax_keres_admin_kapcstulajlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_kapcstulaj_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var admin_modkapcstulaj_ment_fo_wait="";
function admin_modkapcstulaj_ment(tagv_kod){
  clearTimeout(admin_modkapcstulaj_ment_fo_wait);
  admin_modkapcstulaj_ment_fo_wait = setTimeout(function(){admin_modkapcstulaj_ment_proc(tagv_kod);},100);
}

var ajax_keres_admin_modkapcstulaj_ment_proc=null;
function admin_modkapcstulaj_ment_proc(kod){

if(ajax_keres_admin_modkapcstulaj_ment_proc!=null){
 ajax_keres_admin_modkapcstulaj_ment_proc.abort();
}

var nev=encodeURIComponent($("#admin_ujkapcstulaj_nev_"+kod).val());

ajax_keres_admin_modkapcstulaj_ment_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkapcstulaj_ment&kod="+encodeURIComponent(kod)+"&nev="+nev,
	function(d){
	ajax_keres_admin_modkapcstulaj_ment_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

function admin_modkapcstulaj_inaktiv(kod){
if(!$("#admin_ujkapcstulajmod_inaktiv_"+kod).prop("checked")){
 admin_modkapcstulaj_inaktiv_proc(kod);
}else{
 var nev=encodeURIComponent($("#admin_ujkapcstulaj_nev_"+kod).val());
 var d="Biztos, hogy inaktiválod "+nev+" ("+kod+") tulajdonosi joggyakorlót?";
 d+="<br><br>Ezzel minden tulajdonosi joggyakorló beállítása törlésre kerül!";
 var title_ki="tulajdonosi joggyakorló inaktiválása";
$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
		
		"inaktiválás":{
                    click: function () {
					 $(this).dialog('widget').find('button').prop('disabled',true);
                     admin_modkapcstulaj_inaktiv_proc(kod);
                    },
                    'text': 'Inaktiválás',
                    'class': 'submit2'
		
		},
		"megse":{
                    click: function () {
                     $("#admin_ujkapcstulajmod_inaktiv_"+kod).prop("checked",false);
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

var ajax_keres_admin_modkapcstulaj_inaktiv_proc=null;
function admin_modkapcstulaj_inaktiv_proc(kod){
if($("#admin_ujkapcstulajmod_inaktiv_"+kod).prop("checked")){
 var inaktiv=1;
}else{
 var inaktiv=0;
}

if(ajax_keres_admin_modkapcstulaj_inaktiv_proc!=null){
 ajax_keres_admin_modkapcstulaj_inaktiv_proc.abort();
}

ajax_keres_admin_modkapcstulaj_inaktiv_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkapcstulaj_inaktiv&kod="+encodeURIComponent(kod)+"&inaktiv="+inaktiv,
	function(d){
	ajax_keres_admin_modkapcstulaj_inaktiv_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_kapcstulajlist_keres_proc("","");
	 if($('#dialog_egyeni_close').dialog('isOpen')){
	  $("#dialog_egyeni_close").dialog('close');
	 }
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
