<?php

?>

function admin_ujkapcsossze(){
var tagvkod=encodeURIComponent($("#admin_ujkapcsossze_tagvkod").val());
var szolgkod=encodeURIComponent($("#admin_ujkapcsossze_szolgkod").val());

if(tagvkod=="keremv"){
 diaglog_open("Hiba!<br><br>Társaság kiválasztása kötelező!","Hiba","del_behajtani16.png");
}else if(szolgkod=="keremv"){
 diaglog_open("Hiba!<br><br>Szolgáltatás kiválasztása kötelező!","Hiba","del_behajtani16.png");
}else{
 admin_ujkapcsossze_ment(tagvkod,szolgkod);
}
}

var ajax_keres_admin_ujkapcsossze_ment=null;
function admin_ujkapcsossze_ment(tagvkod,szolgkod){
$("#admin_ujkapcsossze_submit").prop("disabled",true);

if(ajax_keres_admin_ujkapcsossze_ment!=null){
 ajax_keres_admin_ujkapcsossze_ment.abort();
}

ajax_keres_admin_ujkapcsossze_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujkapcsossze_ment&tagvkod="+tagvkod+"&szolgkod="+szolgkod,
	function(d){
	ajax_keres_admin_ujkapcsossze_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_kapcsosszelist_keres_tagv").val(tagvkod).trigger('change');
	 $("#admin_kapcsosszelist_keres_szolgkod").val(szolgkod).trigger('change');
	 $("#admin_ujkapcsossze_tagvkod,#admin_ujkapcsossze_szolgkod").val('keremv').trigger('change');
	 $("#admin_ujkapcsossze_submit").prop("disabled",false);
	 //admin_muv_sel();
	}else if(d1[0]=="nook"){
		diaglog_open(d1[1],"Hiba","del_behajtani16.png");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_kapcsosszelist_keres_par(){
var tagv=encodeURIComponent($("#admin_kapcsosszelist_keres_tagv").val());
var szolg_kod=encodeURIComponent($("#admin_kapcsosszelist_keres_szolgkod").val());
var nev=encodeURIComponent($("#admin_kapcsosszelist_keres_nev").val());

var par="&tagv="+tagv+"&szolg_kod="+szolg_kod+"&nev="+nev;
return par;
}


var admin_kapcsosszelist_keres_fo_wait="";
function admin_kapcsosszelist_keres(id_honnan,hol_lep){
  clearTimeout(admin_kapcsosszelist_keres_fo_wait);
  admin_kapcsosszelist_keres_fo_wait = setTimeout(function(){admin_kapcsosszelist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_admin_kapcsosszelist_keres_proc=null;
function admin_kapcsosszelist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_kapcsosszelist_keres_tal_oldalholvagyok","admin_kapcsosszelist_keres_tal_oldalmax","admin_kapcsosszelist_keres_talszam","admin_kapcsosszelist_keres_proc");
var par=admin_kapcsosszelist_keres_par();

if(ajax_keres_admin_kapcsosszelist_keres_proc!=null){
 ajax_keres_admin_kapcsosszelist_keres_proc.abort();
}

ajax_keres_admin_kapcsosszelist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_kapcsosszelist_keres"+ker_par+par,
	function(d){
	ajax_keres_admin_kapcsosszelist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_kapcsossze_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_keres_admin_modkapcsossze_ment=null;
function admin_modkapcsossze_ment(kapcs_ossze_id){

var torzs_id_mvms=encodeURIComponent($("#admin_modkapcstorzs_mvms_"+kapcs_ossze_id).val());
var torzs_id_sla=encodeURIComponent($("#admin_modkapcstorzs_sla_"+kapcs_ossze_id).val());

if(ajax_keres_admin_modkapcsossze_ment!=null){
 ajax_keres_admin_modkapcsossze_ment.abort();
}

ajax_keres_admin_modkapcsossze_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkapcsossze_ment&kapcs_ossze_id="+encodeURIComponent(kapcs_ossze_id)+"&torzs_id_mvms="+torzs_id_mvms+"&torzs_id_sla="+torzs_id_sla,
	function(d){
	ajax_keres_admin_modkapcsossze_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

function admin_modkapcsossze_kapcs1_add(kapcs_ossze_id,sorvan){
var soradd=Number(sorvan)+1;

var html_add='<div style="margin-top:5px">';
html_add+='<select onchange="admin_modkapcsossze_kapcs1_ment(\''+kapcs_ossze_id+'\',\'\',\''+soradd+'\')" id="admin_modkapcsossze_kapcs1_'+kapcs_ossze_id+'_'+soradd+'" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit_id="admin_modkapcstorzs_hid_tagvkod_'+kapcs_ossze_id+'" style="width:211px">';
html_add+='<option value="keremv">Kérem válassz';
html_add+='</select>';
html_add+='<img onclick="admin_modkapcsossze_kapcs1_add(\''+kapcs_ossze_id+'\',\''+soradd+'\')" src="image\\add_16.png" class="admin_modkapcsossze_kapcs1_img_add">';
html_add+='</div>';

$(".admin_modkapcsossze_kapcs1_img_add").css("display","none");
$("#td_admin_modkapcsossze_kapcs1_"+kapcs_ossze_id).append(html_add);
//Összes + gomb elkell rejteni
alap_input_select_most();

}

function admin_modkapcsossze_kapcs2_add(kapcs_ossze_id,sorvan){
var soradd=Number(sorvan)+1;

var html_add='<div style="margin-top:5px">';
html_add+='<select onchange="admin_modkapcsossze_kapcs2_ment(\''+kapcs_ossze_id+'\',\'\',\''+soradd+'\')" id="admin_modkapcsossze_kapcs2_'+kapcs_ossze_id+'_'+soradd+'" class="select2_ajax" csonkolt=1 mod="admin_kapcs_torzs" mit_id="admin_modkapcstorzs_hid_tagvkod_'+kapcs_ossze_id+'" style="width:211px">';
html_add+='<option value="keremv">Kérem válassz';
html_add+='</select>';
html_add+='<img onclick="admin_modkapcsossze_kapcs2_add(\''+kapcs_ossze_id+'\',\''+soradd+'\')" src="image\\add_16.png" class="admin_modkapcsossze_kapcs2_img_add">';
html_add+='</div>';

$(".admin_modkapcsossze_kapcs2_img_add").css("display","none");
$("#td_admin_modkapcsossze_kapcs2_"+kapcs_ossze_id).append(html_add);
//Összes + gomb elkell rejteni
alap_input_select_most();

}

function admin_modkapcsossze_kapcs1_ment(kapcs_ossze_id,kapcs_ossze_kapcs_id,sor){
var kapcs_torzs_id=$("#admin_modkapcsossze_kapcs1_"+kapcs_ossze_id+"_"+sor).val();
admin_modkapcsossze_kapcs_ment(kapcs_ossze_kapcs_id,kapcs_ossze_id,'kapcs1',kapcs_torzs_id);
}

function admin_modkapcsossze_kapcs2_ment(kapcs_ossze_id,kapcs_ossze_kapcs_id,sor){
var kapcs_torzs_id=$("#admin_modkapcsossze_kapcs2_"+kapcs_ossze_id+"_"+sor).val();
admin_modkapcsossze_kapcs_ment(kapcs_ossze_kapcs_id,kapcs_ossze_id,'kapcs2',kapcs_torzs_id);
}

var ajax_keres_admin_modkapcsossze_kapcs_ment=null;
function admin_modkapcsossze_kapcs_ment(kapcs_ossze_kapcs_id,kapcs_ossze_id,kapcs_ossze_kapcs_tipus,kapcs_torzs_id){

if(ajax_keres_admin_modkapcsossze_kapcs_ment!=null){
 ajax_keres_admin_modkapcsossze_kapcs_ment.abort();
}

var par="&kapcs_ossze_kapcs_id="+encodeURIComponent(kapcs_ossze_kapcs_id)+"&kapcs_ossze_id="+encodeURIComponent(kapcs_ossze_id)+"&kapcs_ossze_kapcs_tipus="+encodeURIComponent(kapcs_ossze_kapcs_tipus)+"&kapcs_torzs_id="+encodeURIComponent(kapcs_torzs_id);
ajax_keres_admin_modkapcsossze_kapcs_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkapcsossze_kapcs_ment"+par,
	function(d){
	ajax_keres_admin_modkapcsossze_kapcs_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba","del_behajtani16.png");
	 admin_kapcsosszelist_keres_proc("","");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	 admin_kapcsosszelist_keres_proc("","");
	}
	},"text");
}

function admin_modkapcsossze_del(kapcs_ossze_id){
var tagv=$("#admin_modkapcstorzs_tagvkod_"+kapcs_ossze_id).html();
var szolg=$("#admin_modkapcstorzs_szolgkod_"+kapcs_ossze_id).html();
var d="Biztos, hogy törlöd az alábbi társaság - szolgáltatás kapcsolattartóit?";
d+="<br><br>ID: "+kapcs_ossze_id;
d+="<br>Társaság: "+tagv;
d+="<br>Szolgáltatás: "+szolg;
var title_ki="Társaság - szolgáltatás kapcsolattartó törlés";

$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
		
		"torles":{
                    click: function () {
					 $(this).dialog('widget').find('button').prop('disabled',true);
                     admin_modkapcsossze_del_proc(kapcs_ossze_id);
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

var ajax_keres_admin_modkapcsossze_del_proc=null;
function admin_modkapcsossze_del_proc(kapcs_ossze_id){

if(ajax_keres_admin_modkapcsossze_del_proc!=null){
 ajax_keres_admin_modkapcsossze_del_proc.abort();
}

ajax_keres_admin_modkapcsossze_del_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_modkapcsossze_del_proc&kapcs_ossze_id="+encodeURIComponent(kapcs_ossze_id),
	function(d){
	ajax_keres_admin_modkapcsossze_del_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_kapcsosszelist_keres_proc("","");
	 $('#dialog_egyeni_close').dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

