
function ful_riport(){//Fül betöltése után fut le..
document.title=title_orig+" - Riport";

$('#riport_ho1,#riport_teny3_1_1_szervcsop_ho1,#riport_teny3_1_1_szervcsop_szervcsop_szervcsopid,#riport_teny3_1_1_ho1,#riport_teny3_2_ho1,#riport_teny3_3_ho1,#riport_teny3_ho1,#riport_teny3_elteres_ho1').multiSelect({
    noneText: 'Összes',
    'menuMinHeight': '50',
	'searchinp':false
});


//var tipus=$("#riport_tipus").val();
 
//if($('#riport_tipus option[value="tervteny"]').length > 0){
 riport_tervteny_ev1_change();
 riport_tervteny_ev2_change();
 riport_tervteny_tipus_beallit();
//}

duplariportkapcsossze_list_scrool_bar();
}

var ajax_keres_riport_tipus_change=null;
function riport_tipus_change(){

if(ajax_keres_riport_tipus_change!=null){
 ajax_keres_riport_tipus_change.abort();
}

var tipus=$("#riport_tipus").val();

ajax_keres_riport_tipus_change=$.post(ajaxstat_p_ut,"mod=riport_tipus_change&tipus="+tipus,
	function(d){
	ajax_keres_riport_tipus_change=null;
	//if(d=="ok$;$"){
	if(d=="ok$;$"){
	 gi("riport_tal").innerHTML='';
	 riport_tipus_change_proc(tipus);
	}else if(d.slice(0,5)=="ok$;$"){
		gi("riport_tal").innerHTML=d.slice(5);
		alap_input_select_most();
		duplariportkapcsossze_list_scrool_bar();
		riport_tipus_change_proc(tipus);
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
	
}

function duplariportkapcsossze_list_scrool_bar(){
    $("#scroll1 div").width($("#riport_kapcstulajlist_table").width());	
    $("#scroll1").on("scroll", function(){
        $("#scroll2").scrollLeft($(this).scrollLeft()); 
    });
    $("#scroll2").on("scroll", function(){
        $("#scroll1").scrollLeft($(this).scrollLeft()); 
    });
}

var ajax_keres_riport_kapcsosszelist_keres=null;
function riport_kapcsosszelist_keres(){
var tagv=encodeURIComponent($("#riport_kapcsosszelist_keres_tagv").val());

if(ajax_keres_riport_kapcsosszelist_keres!=null){
 ajax_keres_riport_kapcsosszelist_keres.abort();
}

ajax_keres_riport_kapcsosszelist_keres=$.post(ajaxstat_p_ut,"mod=riport_kapcsosszelist_keres&tagv="+tagv,
 function(d){
 if(d.slice(0,5)=="ok$;$"){
  gi("admin_uj_kapcstulaj_list_keres_tal").innerHTML=d.slice(5);
  duplariportkapcsossze_list_scrool_bar();
 }else{
  diaglog_open(d,"Rendszerhiba"); 
 }
},"text");

}

function riport_tipus_change_proc(tipus){
const riportConfig = {
    'nonp':          ['#riport_div_nonp',          '#riport_div_nonp_gomb'],
    'tervteny':      ['#riport_div_tervteny',      '#riport_div_tervteny_gomb'],
    'teny3_1_1':     ['#riport_div_teny3_1_1',     '#riport_div_teny3_1_1_gomb'],
    'teny3_1_1_szervcsop':     ['#riport_div_teny3_1_1_szervcsop',     '#riport_div_teny3_1_1_szervcsop_gomb'],
    'teny3_2':       ['#riport_div_teny3_2',       '#riport_div_teny3_2_gomb'],
    'teny3_3':       ['#riport_div_teny3_3',       '#riport_div_teny3_3_gomb'],
    'teny3':         ['#riport_div_teny3',         '#riport_div_teny3_gomb'],
    'teny3_elteres': ['#riport_div_teny3_elteres', '#riport_div_teny3_elteres_gomb'],
    'kapcs_ossze':   ['#riport_div_kapcs_ossze'],
    'szerznyilv':    ['#riport_div_szerznyilv'],
    'szerznyilv_elo':['#riport_div_szerznyilv_elo'],
    'proj_k99':      ['#riport_div_proj_k99'],
    'proj_beszkoz':  ['#riport_div_proj_beszkoz'],
    'kpi_riport':    ['#riport_div_kpi_riport'],
    'tig_tabla':     ['#riport_div_tig_tabla', '#riport_div_tig_tabla_gomb'],
    'admin_user':    ['#riport_div_admin_user'],
    'admin_szerv':   ['#riport_div_admin_szerv'],
    'admin_proj':    ['#riport_div_admin_proj']
};
// Összes div automatikusan kigyűjtve (nem kell kézzel karbantartani)
const allRiportSelectors = Object.values(riportConfig).flat();

// 1. Minden riport div elrejtése (egyetlen sor!)
    $(allRiportSelectors.join(', ')).css('display', 'none');

    // 2. Csak a kiválasztott mutatása
    if (riportConfig[tipus]) {
        $(riportConfig[tipus].join(', ')).css('display', 'flex');
    }
    // ha ismeretlen típus jön → minden marad rejtve (mint a régi "else" ág)
}

/*
function riport_tipus_change_proc(tipus){

if(tipus=='nonp'){
 $("#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_1_1,#riport_div_teny3_2,#riport_div_teny3,#riport_div_teny3_elteres,#riport_div_teny3_1_1_gomb,#riport_div_teny3_2_gomb,#riport_div_teny3_gomb,#riport_div_teny3_elteres_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv,#riport_div_szerznyilv_elo,#riport_div_proj_k99,#riport_div_proj_beszkoz,#riport_div_kpi_riport").css('display','none');
 $("#riport_div_nonp,#riport_div_nonp_gomb").css('display','flex');
 
}else if(tipus=='tervteny'){
 $("#riport_div_nonp,#riport_div_teny3_1_1,#riport_div_teny3_2,#riport_div_teny3,#riport_div_teny3_elteres,#riport_div_nonp_gomb,#riport_div_teny3_1_1_gomb,#riport_div_teny3_2_gomb,#riport_div_teny3_gomb,#riport_div_teny3_elteres_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv,#riport_div_szerznyilv_elo,#riport_div_proj_k99,#riport_div_proj_beszkoz,#riport_div_kpi_riport").css('display','none');
 $("#riport_div_tervteny,#riport_div_tervteny_gomb").css('display','flex');
}else if(tipus=='teny3_1_1'){
 $("#riport_div_nonp,#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_2,#riport_div_teny3,#riport_div_teny3_elteres,#riport_div_nonp_gomb,#riport_div_teny3_2_gomb,#riport_div_teny3_gomb,#riport_div_teny3_elteres_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv,#riport_div_szerznyilv_elo,#riport_div_proj_k99,#riport_div_proj_beszkoz,#riport_div_kpi_riport").css('display','none');
 $("#riport_div_teny3_1_1,#riport_div_teny3_1_1_gomb").css('display','flex');
}else if(tipus=='teny3_2'){
 $("#riport_div_nonp,#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_1_1,#riport_div_teny3,#riport_div_teny3_elteres,#riport_div_nonp_gomb,#riport_div_teny3_1_1_gomb,#riport_div_teny3_gomb,#riport_div_teny3_elteres_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv,#riport_div_szerznyilv_elo,#riport_div_proj_k99,#riport_div_proj_beszkoz,#riport_div_kpi_riport").css('display','none');
 $("#riport_div_teny3_2,#riport_div_teny3_2_gomb").css('display','flex');
}else if(tipus=='teny3'){
 $("#riport_div_nonp,#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_1_1,#riport_div_teny3_elteres,#riport_div_teny3_2,#riport_div_nonp_gomb,#riport_div_teny3_1_1_gomb,#riport_div_teny3_2_gomb,#riport_div_teny3_elteres_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv,#riport_div_szerznyilv_elo,#riport_div_proj_k99,#riport_div_proj_beszkoz,#riport_div_kpi_riport").css('display','none');
 $("#riport_div_teny3,#riport_div_teny3_gomb").css('display','flex');
}else if(tipus=='teny3_elteres'){
 $("#riport_div_nonp,#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_1_1,#riport_div_teny3,#riport_div_teny3_2,#riport_div_nonp_gomb,#riport_div_teny3_1_1_gomb,#riport_div_teny3_gomb,#riport_div_teny3_2_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv,#riport_div_szerznyilv_elo,#riport_div_proj_k99,#riport_div_proj_beszkoz,#riport_div_kpi_riport").css('display','none');
 $("#riport_div_teny3_elteres,#riport_div_teny3_elteres_gomb").css('display','flex');
}else if(tipus=='kapcs_ossze'){
 $("#riport_div_nonp,#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_1_1,#riport_div_teny3_2,#riport_div_nonp_gomb,#riport_div_teny3_1_1_gomb,#riport_div_teny3_2_gomb,#riport_div_teny3,#riport_div_teny3_elteres_gomb,#riport_div_teny3_elteres,#riport_div_teny3_gomb,#riport_div_szerznyilv,#riport_div_szerznyilv_elo,#riport_div_proj_k99,#riport_div_proj_beszkoz,#riport_div_kpi_riport").css('display','none');
 $("#riport_div_kapcs_ossze").css('display','flex');
}else if(tipus=='szerznyilv'){
 $("#riport_div_nonp,#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_1_1,#riport_div_teny3_2,#riport_div_nonp_gomb,#riport_div_teny3_1_1_gomb,#riport_div_teny3_2_gomb,#riport_div_teny3,#riport_div_teny3_elteres_gomb,#riport_div_teny3_elteres,#riport_div_teny3_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv_elo,#riport_div_proj_k99,#riport_div_proj_beszkoz,#riport_div_kpi_riport").css('display','none');
 $("#riport_div_szerznyilv").css('display','flex');
}else if(tipus=='szerznyilv_elo'){
 $("#riport_div_nonp,#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_1_1,#riport_div_teny3_2,#riport_div_nonp_gomb,#riport_div_teny3_1_1_gomb,#riport_div_teny3_2_gomb,#riport_div_teny3,#riport_div_teny3_elteres_gomb,#riport_div_teny3_elteres,#riport_div_teny3_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv,#riport_div_proj_k99,#riport_div_proj_beszkoz,#riport_div_kpi_riport").css('display','none');
 $("#riport_div_szerznyilv_elo").css('display','flex');
}else if(tipus=='proj_k99'){
 $("#riport_div_nonp,#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_1_1,#riport_div_teny3_2,#riport_div_nonp_gomb,#riport_div_teny3_1_1_gomb,#riport_div_teny3_2_gomb,#riport_div_teny3,#riport_div_teny3_elteres_gomb,#riport_div_teny3_elteres,#riport_div_teny3_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv,#riport_div_szerznyilv_elo,#riport_div_proj_beszkoz,#riport_div_kpi_riport").css('display','none');
 $("#riport_div_proj_k99").css('display','flex');
}else if(tipus=='proj_beszkoz'){
 $("#riport_div_nonp,#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_1_1,#riport_div_teny3_2,#riport_div_nonp_gomb,#riport_div_teny3_1_1_gomb,#riport_div_teny3_2_gomb,#riport_div_teny3,#riport_div_teny3_elteres_gomb,#riport_div_teny3_elteres,#riport_div_teny3_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv,#riport_div_szerznyilv_elo,#riport_div_proj_k99,#riport_div_kpi_riport").css('display','none');
 $("#riport_div_proj_beszkoz").css('display','flex');
}else if(tipus=='kpi_riport'){
 $("#riport_div_nonp,#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_1_1,#riport_div_teny3_2,#riport_div_nonp_gomb,#riport_div_teny3_1_1_gomb,#riport_div_teny3_2_gomb,#riport_div_teny3,#riport_div_teny3_elteres_gomb,#riport_div_teny3_elteres,#riport_div_teny3_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv,#riport_div_szerznyilv_elo,#riport_div_proj_k99,#riport_div_proj_beszkoz").css('display','none');
 $("#riport_div_kpi_riport").css('display','flex');
}else{
 $("#riport_div_nonp,#riport_div_tervteny,#riport_div_tervteny_gomb,#riport_div_teny3_1_1,#riport_div_nonp_gomb,#riport_div_teny3_1_1_gomb,#riport_div_teny3_2_gomb,#riport_div_teny3_gomb,#riport_div_teny3_elteres_gomb,#riport_div_kapcs_ossze,#riport_div_szerznyilv,#riport_div_szerznyilv_elo,#riport_div_proj_k99,#riport_div_proj_beszkoz,#riport_div_kpi_riport").css('display','none');
}

}
*/

function riport_leker(){

var tipus=encodeURIComponent($("#riport_tipus").val());
var date1_ev=encodeURIComponent($("#riport_ev1").val());

//var date1_ho=encodeURIComponent($("#riport_ho1").val());
var date1_ho="";
$("#riport_ho1 :selected").each(function(i, sel){
	if(date1_ho!='')date1_ho+="#";
    date1_ho+=encodeURIComponent($(sel).val());
});
if(date1_ho=='')date1_ho='all';

    // Űrlap adatainak összegyűjtése
    var formData = {
		tipus:tipus,
		date1_ev:date1_ev,
		date1_ho:date1_ho,
	}

letoltes_excel_ajax('riport_leker_submit',formData,'riport/riport_leker.php');
/*
var adat1="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='"+tipus+"'>";
var adat2="<input type='hidden' id='riport_leker_form_date1_ev' name='date1_ev' value='"+date1_ev+"'>";
var adat3="<input type='hidden' id='riport_leker_form_date1_ho' name='date1_ho' value='"+date1_ho+"'>";
var adat=adat1+adat2+adat3;

$("#riport_leker_submit").prop("disabled",true);

$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_leker_submit").prop("disabled",false);
},3);
*/

}

function riport_teny3_1_1_szervcsop_leker(){
var date1_ev=encodeURIComponent($("#riport_teny3_1_1_szervcsop_ev1").val());
var date1_ho="";
$("#riport_teny3_1_1_szervcsop_ho1 :selected").each(function(i, sel){
	if(date1_ho!='')date1_ho+="#";
    date1_ho+=encodeURIComponent($(sel).val());
});
if(date1_ho=='')date1_ho='all';

var szervcsop_id="";
$("#riport_teny3_1_1_szervcsop_szervcsop_szervcsopid :selected").each(function(i, sel){
	if(szervcsop_id!='')szervcsop_id+="#";
    szervcsop_id+=encodeURIComponent($(sel).val());
});
if(szervcsop_id=='')szervcsop_id='all';

    // Űrlap adatainak összegyűjtése
    var formData = {
		tipus:"teny3_1_1_szervcsop",
		date1_ev:date1_ev,
		date1_ho:date1_ho,
		szervcsop_id:szervcsop_id,
	}

letoltes_excel_ajax('riport_teny3_1_1_szervcsop_leker_submit',formData,'riport/riport_leker.php');

/*
var adat1="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='teny3_1_1_szervcsop'>";
var adat2="<input type='hidden' id='riport_leker_form_date1_ev' name='date1_ev' value='"+date1_ev+"'>";
var adat3="<input type='hidden' id='riport_leker_form_date1_ho' name='date1_ho' value='"+date1_ho+"'>";
var adat4="<input type='hidden' id='riport_leker_form_date1_szervcsop_id' name='szervcsop_id' value='"+szervcsop_id+"'>";
var adat=adat1+adat2+adat3+adat4;

$("#riport_teny3_1_1_szervcsop_leker_submit").prop("disabled",true);

$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();
$.wait( function(){
$("#riport_teny3_1_1_szervcsop_leker_submit").prop("disabled",false);
},3);
*/

}

function riport_teny3_1_1_leker(){
var date1_ev=encodeURIComponent($("#riport_teny3_1_1_ev1").val());
var date1_ho="";
$("#riport_teny3_1_1_ho1 :selected").each(function(i, sel){
	if(date1_ho!='')date1_ho+="#";
    date1_ho+=encodeURIComponent($(sel).val());
});
if(date1_ho=='')date1_ho='all';

    // Űrlap adatainak összegyűjtése
    var formData = {
		tipus:"teny3_1_1",
		date1_ev:date1_ev,
		date1_ho:date1_ho,
	}

letoltes_excel_ajax('riport_teny3_1_1_leker_submit',formData,'riport/riport_leker.php');
}

/*
function riport_teny3_1_1_leker_old(){
var date1_ev=encodeURIComponent($("#riport_teny3_1_1_ev1").val());
var date1_ho="";
$("#riport_teny3_1_1_ho1 :selected").each(function(i, sel){
	if(date1_ho!='')date1_ho+="#";
    date1_ho+=encodeURIComponent($(sel).val());
});
if(date1_ho=='')date1_ho='all';

var adat1="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='teny3_1_1'>";
var adat2="<input type='hidden' id='riport_leker_form_date1_ev' name='date1_ev' value='"+date1_ev+"'>";
var adat3="<input type='hidden' id='riport_leker_form_date1_ho' name='date1_ho' value='"+date1_ho+"'>";
var adat=adat1+adat2+adat3;

$("#riport_teny3_1_1_leker_submit").prop("disabled",true);

$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_teny3_1_1_leker_submit").prop("disabled",false);
},3);

}
*/

function riport_teny3_3_leker(){
var date1_ev=encodeURIComponent($("#riport_teny3_3_ev1").val());
var date1_ho="";
$("#riport_teny3_3_ho1 :selected").each(function(i, sel){
	if(date1_ho!='')date1_ho+="#";
    date1_ho+=encodeURIComponent($(sel).val());
});
if(date1_ho=='')date1_ho='all';

    // Űrlap adatainak összegyűjtése
    var formData = {
		tipus:"teny3_3",
		date1_ev:date1_ev,
		date1_ho:date1_ho,
	}

//letoltes_excel_ajax('riport_teny3_3_leker_submit',formData,'riport/riport_leker.php');

var adat1="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='teny3_3'>";
var adat2="<input type='hidden' id='riport_leker_form_date1_ev' name='date1_ev' value='"+date1_ev+"'>";
var adat3="<input type='hidden' id='riport_leker_form_date1_ho' name='date1_ho' value='"+date1_ho+"'>";
var adat=adat1+adat2+adat3;

$("#riport_teny3_3_leker_submit").prop("disabled",true);

$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_teny3_3_leker_submit").prop("disabled",false);
},3);
}

function riport_teny3_2_leker(){
var date1_ev=encodeURIComponent($("#riport_teny3_2_ev1").val());
var date1_ho="";
$("#riport_teny3_2_ho1 :selected").each(function(i, sel){
	if(date1_ho!='')date1_ho+="#";
    date1_ho+=encodeURIComponent($(sel).val());
});
if(date1_ho=='')date1_ho='all';

    // Űrlap adatainak összegyűjtése
    var formData = {
		tipus:"teny3_2",
		date1_ev:date1_ev,
		date1_ho:date1_ho,
	}

letoltes_excel_ajax('riport_teny3_2_leker_submit',formData,'riport/riport_leker.php');
/*
var adat1="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='teny3_2'>";
var adat2="<input type='hidden' id='riport_leker_form_date1_ev' name='date1_ev' value='"+date1_ev+"'>";
var adat3="<input type='hidden' id='riport_leker_form_date1_ho' name='date1_ho' value='"+date1_ho+"'>";
var adat=adat1+adat2+adat3;

$("#riport_teny3_2_leker_submit").prop("disabled",true);

$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_teny3_2_leker_submit").prop("disabled",false);
},3);
*/

}

function riport_teny3_leker(){
var date1_ev=encodeURIComponent($("#riport_teny3_ev1").val());
var date1_ho="";
$("#riport_teny3_ho1 :selected").each(function(i, sel){
	if(date1_ho!='')date1_ho+="#";
    date1_ho+=encodeURIComponent($(sel).val());
});
if(date1_ho=='')date1_ho='all';

    // Űrlap adatainak összegyűjtése
    var formData = {
		tipus:"teny3",
		date1_ev:date1_ev,
		date1_ho:date1_ho,
	}

letoltes_excel_ajax('riport_teny3_leker_submit',formData,'riport/riport_leker.php');
/*
var adat1="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='teny3'>";
var adat2="<input type='hidden' id='riport_leker_form_date1_ev' name='date1_ev' value='"+date1_ev+"'>";
var adat3="<input type='hidden' id='riport_leker_form_date1_ho' name='date1_ho' value='"+date1_ho+"'>";
var adat=adat1+adat2+adat3;

$("#riport_teny3_leker_submit").prop("disabled",true);

$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_teny3_leker_submit").prop("disabled",false);
},3);
*/
}

function riport_teny3_elteres_leker(){
var date1_ev=encodeURIComponent($("#riport_teny3_elteres_ev1").val());
var date1_ho="";
$("#riport_teny3_elteres_ho1 :selected").each(function(i, sel){
	if(date1_ho!='')date1_ho+="#";
    date1_ho+=encodeURIComponent($(sel).val());
});
if(date1_ho=='')date1_ho='all';

var tervalaptipus=encodeURIComponent($("#riport_teny3_elteres_also_tervalaptipus").val());
var hatar_also=encodeURIComponent($("#riport_teny3_elteres_also").val());
var hatar_felso=encodeURIComponent($("#riport_teny3_elteres_felso").val());
var hatar_jelentos=encodeURIComponent($("#riport_teny3_elteres_jelentos").val());

if(tervalaptipus=='keremv'){
 diaglog_open('Hiba!<br<br>Terv típus kiválasztása kötelező!',"Hiba",'del_behajtani16.png');
 return false;
}

    // Űrlap adatainak összegyűjtése
    var formData = {
		tipus:"teny3_elteres",
		date1_ev:date1_ev,
		date1_ho:date1_ho,
		tervalaptipus:tervalaptipus,
		hatar_also:hatar_also,
		hatar_felso:hatar_felso,
	}

letoltes_excel_ajax('riport_teny3_elteres_leker_submit',formData,'riport/riport_leker.php');
/*
var adat1="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='teny3_elteres'>";
var adat2="<input type='hidden' id='riport_leker_form_date1_ev' name='date1_ev' value='"+date1_ev+"'>";
var adat3="<input type='hidden' id='riport_leker_form_date1_ho' name='date1_ho' value='"+date1_ho+"'>";
var adat4="<input type='hidden' id='riport_leker_form_altipus' name='tervalaptipus' value='"+tervalaptipus+"'>";
var adat5="<input type='hidden' id='riport_leker_form_hatar_also' name='hatar_also' value='"+hatar_also+"'>";
var adat6="<input type='hidden' id='riport_leker_form_hatar_felso' name='hatar_felso' value='"+hatar_felso+"'>";
var adat=adat1+adat2+adat3+adat4+adat5+adat6;

$("#riport_teny3_elteres_leker_submit").prop("disabled",true);

$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_teny3_elteres_leker_submit").prop("disabled",false);
},3);
*/
}

var ajax_keres_riport_nonp_ev1_change=null;
function riport_nonp_ev1_change(){
//$("#riport_ho1 option:selected").prop('selected',false).trigger("change");

var ev1=encodeURIComponent($("#riport_ev1").val());

if(ajax_keres_riport_nonp_ev1_change!=null){
 ajax_keres_riport_nonp_ev1_change.abort();
}

ajax_keres_riport_nonp_ev1_change=$.post(ajaxstat_p_ut,"mod=riport_nonp_ev1_change&ev1="+ev1,
	function(d){
	ajax_keres_riport_nonp_ev1_change=null;
	if(d=="ok$;$"){
		ful_betolt(akt_ful);
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");

}

var ajax_keres_riport_teny3_1_1_ev1_change=null;
function riport_teny3_1_1_ev1_change(){

var ev1=encodeURIComponent($("#riport_teny3_1_1_ev1").val());

if(ajax_keres_riport_teny3_1_1_ev1_change!=null){
 ajax_keres_riport_teny3_1_1_ev1_change.abort();
}

ajax_keres_riport_nonp_ev1_change=$.post(ajaxstat_p_ut,"mod=riport_teny3_1_1_ev1_change&ev1="+ev1,
	function(d){
	ajax_keres_riport_teny3_1_1_ev1_change=null;
	if(d=="ok$;$"){
		ful_betolt(akt_ful);
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

var ajax_keres_riport_teny3_2_ev1_change=null;
function riport_teny3_2_ev1_change(){

var ev1=encodeURIComponent($("#riport_teny3_2_ev1").val());

if(ajax_keres_riport_teny3_2_ev1_change!=null){
 ajax_keres_riport_teny3_2_ev1_change.abort();
}

ajax_keres_riport_teny3_2_ev1_change=$.post(ajaxstat_p_ut,"mod=riport_teny3_2_ev1_change&ev1="+ev1,
	function(d){
	ajax_keres_riport_teny3_2_ev1_change=null;
	if(d=="ok$;$"){
		ful_betolt(akt_ful);
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

var ajax_keres_riport_teny3_3_ev1_change=null;
function riport_teny3_3_ev1_change(){

var ev1=encodeURIComponent($("#riport_teny3_3_ev1").val());

if(ajax_keres_riport_teny3_3_ev1_change!=null){
 ajax_keres_riport_teny3_3_ev1_change.abort();
}

ajax_keres_riport_teny3_3_ev1_change=$.post(ajaxstat_p_ut,"mod=riport_teny3_3_ev1_change&ev1="+ev1,
	function(d){
	ajax_keres_riport_teny3_3_ev1_change=null;
	if(d=="ok$;$"){
		ful_betolt(akt_ful);
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

var ajax_keres_riport_teny3_ev1_change=null;
function riport_teny3_ev1_change(){

var ev1=encodeURIComponent($("#riport_teny3_ev1").val());

if(ajax_keres_riport_teny3_ev1_change!=null){
 ajax_keres_riport_teny3_ev1_change.abort();
}

ajax_keres_riport_teny3_ev1_change=$.post(ajaxstat_p_ut,"mod=riport_teny3_ev1_change&ev1="+ev1,
	function(d){
	ajax_keres_riport_teny3_ev1_change=null;
	if(d=="ok$;$"){
		ful_betolt(akt_ful);
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

var ajax_keres_riport_teny3_elteres_ev1_change=null;
function riport_teny3_elteres_ev1_change(){

var ev1=encodeURIComponent($("#riport_teny3_elteres_ev1").val());

if(ajax_keres_riport_teny3_elteres_ev1_change!=null){
 ajax_keres_riport_teny3_elteres_ev1_change.abort();
}

ajax_keres_riport_teny3_elteres_ev1_change=$.post(ajaxstat_p_ut,"mod=riport_teny3_elteres_ev1_change&ev1="+ev1,
	function(d){
	ajax_keres_riport_teny3_elteres_ev1_change=null;
	if(d=="ok$;$"){
		ful_betolt(akt_ful);
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

function riport_kapcs_ossze_leker(){

    // Űrlap adatainak összegyűjtése
    var formData = {
		tipus:"kapcs_ossze",
	}

letoltes_excel_ajax('riport_leker_kapcs_ossze_submit',formData,'riport/riport_leker.php');
/*
$("#riport_leker_kapcs_ossze_submit").prop("disabled",true);

var adat1="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='kapcs_ossze'>";
var adat=adat1;
$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_leker_kapcs_ossze_submit").prop("disabled",false);
},3);
*/
}

function riport_szerznyilv_leker(){

    // Űrlap adatainak összegyűjtése
    var formData = {
		tipus:"szerznyilv",
	}

letoltes_excel_ajax('riport_leker_szerznyilv_submit',formData,'riport/riport_leker.php');
/*
$("#riport_leker_szerznyilv_submit").prop("disabled",true);

var adat="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='szerznyilv'>";
$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_leker_szerznyilv_submit").prop("disabled",false);
},3);
*/
}

function riport_szerznyilv_elo_leker(){
/*
$("#riport_leker_szerznyilv_elo_submit").prop("disabled",true);

var adat="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='szerznyilv_elo'>";
$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_leker_szerznyilv_elo_submit").prop("disabled",false);
},3);
*/
var formData = {
 tipus: 'szerznyilv_elo'
};
letoltes_excel_ajax('riport_leker_szerznyilv_elo_submit',formData,'riport/riport_leker.php');

}

function riport_szerznyilvlist_keres_par(){
var tagv_kod=encodeURIComponent($("#riport_szerznyilvlist_keres_tagv").val());
var akt=encodeURIComponent($("#riport_szerznyilvlist_keres_tagv").val());
var par="&tagv_kod="+tagv_kod+"&akt="+akt;
return par;
}

var riport_szerznyilvlist_keres_fo_wait="";
function riport_szerznyilvlist_keres(id_honnan,hol_lep){
  clearTimeout(riport_szerznyilvlist_keres_fo_wait);
  riport_szerznyilvlist_keres_fo_wait = setTimeout(function(){riport_szerznyilvlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_riport_szerznyilvlist_keres_proc=null;
function riport_szerznyilvlist_keres_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"admin_riportszerznyilvlist_keres_tal_oldalholvagyok","admin_riportszerznyilvlist_keres_tal_oldalmax","admin_riportszerznyilvlist_keres_talszam","riport_szerznyilvlist_keres_proc");
var par=riport_szerznyilvlist_keres_par();

var scroll_poz=$("#scroll2").scrollLeft();

if(ajax_keres_riport_szerznyilvlist_keres_proc!=null){
 ajax_keres_riport_szerznyilvlist_keres_proc.abort();
}


}

function riport_proj_k99_leker(){
/*
$("#riport_leker_proj_k99_submit").prop("disabled",true);
var adat="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='proj_k99'>";
$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_leker_proj_k99_submit").prop("disabled",false);
},3);
*/
var formData = {
 tipus: 'proj_k99'
};
letoltes_excel_ajax('riport_leker_proj_k99_submit',formData,'riport/riport_leker.php');
}

/*
function riport_proj_beszkoz_leker(){
 var _this_gomb=$("#riport_leker_proj_beszkoz_submit");
 // Eredeti gomb szöveg mentése
 var originalText = _this_gomb.val();

	// Gomb letiltása
    _this_gomb.prop("disabled", true);
	
// Animáció időzítő
    var dots = 0;
    var loadingAnimation = setInterval(function() {
        dots = (dots + 1) % 4; // 0, 1, 2, 3, majd vissza 0-ra
        var dotText = ".".repeat(dots);
        _this_gomb.val(originalText + dotText);
    }, 500); // 500ms-onként frissül a pontok száma

    // Űrlap adatainak összegyűjtése
    var formData = {
        tipus: 'proj_beszkoz'
    };
 // AJAX kérés indítása
    $.ajax({
        url: "riport/riport_leker.php", // A szerveroldali PHP fájl elérési útja
        type: "POST",
        data: formData,
        xhrFields: {
            responseType: "blob" // Blobként kezeljük a választ, mivel XLSX fájlt várunk
        },
        success: function (data, status, xhr) {
			
			// Fájlnév kinyerése a Content-Disposition fejlécből
            var disposition = xhr.getResponseHeader("Content-Disposition");
            var filename = "export.xlsx"; // Alapértelmezett fájlnév
            if (disposition && disposition.indexOf("attachment") !== -1) {
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);
                if (matches != null && matches[1]) {
                    filename = matches[1].replace(/['"]/g, ""); // Idézőjelek eltávolítása
                    filename = decodeURIComponent(filename); // URL-dekódolás (pl. %3A → :)
                }
            }

            // Blob objektum létrehozása és letöltés indítása
            var blob = new Blob([data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
            var link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
			
			// Animáció leállítása és eredeti szöveg visszaállítása
            clearInterval(loadingAnimation);
            _this_gomb.val(originalText);
			
            // Gomb újraaktiválása
            _this_gomb.prop("disabled", false);
        },
        error: function (xhr, status, error) {
            
			// Animáció leállítása és eredeti szöveg visszaállítása
            clearInterval(loadingAnimation);
            _this_gomb.val(originalText);
			
			// Hiba esetén is aktiváljuk a gombot, és jelezhetjük a hibát
            console.error("Hiba történt: ", error);
            _this_gomb.prop("disabled", false);
            alert("Hiba történt az exportálás során!");
        }
    });

    return false; // Megakadályozza az alapértelmezett eseményt (pl. űrlap elküldését)
}
*/

function riport_proj_beszkoz_leker(){
var formData = {
 tipus: 'proj_beszkoz'
};
letoltes_excel_ajax('riport_leker_proj_beszkoz_submit',formData,'riport/riport_leker.php');
}

/*
function riport_proj_beszkoz_leker_old(){

$("#riport_leker_proj_beszkoz_submit").prop("disabled",true);
var adat="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='proj_beszkoz'>";
$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_leker_proj_beszkoz_submit").prop("disabled",false);
},3);
}
*/

function riport_tig_tabla_leker(){
var date1_ev=encodeURIComponent($("#riport_tig_tabla_ev1").val());
var date1_ho=encodeURIComponent($("#riport_tig_tabla_ho1").val());
var formData = {
 tipus: 'tig_tabla',
 date1_ev:date1_ev,
 date1_ho:date1_ho
};
letoltes_excel_ajax('riport_leker_tig_tabla_submit',formData,'riport/riport_leker.php');
}

function riport_kpi_riport_leker(){
var formData = {
 tipus: 'kpi_riport'
};
letoltes_excel_ajax('riport_leker_kpi_riport_submit',formData,'riport/riport_leker.php');
}

/*
function riport_kpi_riport_leker(){

$("#riport_leker_kpi_riport_submit").prop("disabled",true);
var adat="<input type='hidden' id='riport_leker_form_tipus' name='tipus' value='kpi_riport'>";
$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_leker_kpi_riport_submit").prop("disabled",false);
},3);
}
*/

function riport_admin_user_leker(){
var formData = {
 riport_lekeres: '1',
 tipus: 'admin_user'
};
letoltes_excel_ajax('riport_leker_admin_user_submit',formData,'riport/riport_leker.php');
}

function riport_admin_szerv_leker(){
var formData = {
 riport_lekeres: '1',
 tipus: 'admin_szerv'
};
letoltes_excel_ajax('riport_leker_admin_szerv_submit',formData,'riport/riport_leker.php');
}

function riport_admin_proj_leker(){
var formData = {
 riport_lekeres: '1',
 tipus: 'admin_proj'
};
letoltes_excel_ajax('riport_leker_admin_proj_submit',formData,'riport/riport_leker.php');
}
