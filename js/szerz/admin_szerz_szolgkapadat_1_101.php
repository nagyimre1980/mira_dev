<?php

?>

var ajax_keres_admin_ujszolgkapadat_rejt_mutat=null;
function admin_ujszolgkapadat_rejt_mutat(){
var _this=$("#div_admin_szerz_szolgkapadat_urlap")
var lat=_this.css('display');
if(lat=='none'){
 _this.fadeIn();
 var rejt='0';
}else{
 _this.fadeOut();
 var rejt='1';
}

if(ajax_keres_admin_ujszolgkapadat_rejt_mutat!=null){
 ajax_keres_admin_ujszolgkapadat_rejt_mutat.abort();
}

ajax_keres_admin_ujszolgkapadat_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujszolgkapadat_rejt_mutat&rejt="+rejt,
	function(d){
	ajax_keres_admin_ujszolgkapadat_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba");	
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_admin_ujszolgkapadat_porjekt_add=null;
function admin_ujszolgkapadat_porjekt_add(mod){

var projekt_id=encodeURIComponent($("#admin_ujszolgkapadat_projektid_"+mod).val());

if(ajax_admin_ujszolgkapadat_porjekt_add!=null){
 ajax_admin_ujszolgkapadat_porjekt_add.abort();
}

ajax_admin_ujszolgkapadat_porjekt_add=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujszolgkapadat_porjekt_add&projekt_id="+projekt_id+"&mod="+encodeURIComponent(mod),
	function(d){
	ajax_admin_ujszolgkapadat_porjekt_add=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Tevékenységek");
	}else{
	 diaglog_open(d,"Rendszerhiba","hiba");	
	}
	});
	
}

function admin_ujszolgkapadatprojektadd_hozz_keress_par(){

var mod=$("#ujszolgkapadatprojektadd_hozzid_mod_szur").attr('mod');

var projekt_id=$("#admin_ujszolgkapadat_projektid_"+mod).val();
var projekt_nev=$("#ujszolgkapadatprojektadd_hozzidkod_keress").val();

if($("#ujszolgkapadatprojektadd_hozzid_csakhozz_szur").prop("checked")){
 var csakvan=1;
}else{
 var csakvan=0;
}

var par="&csakvan="+csakvan+"&projekt_nev="+projekt_nev+"&projekt_id="+projekt_id+"&mod="+mod;
return par;
}

var admin_ujszolgkapadatprojektadd_hozz_keress_fo_wait="";
function admin_ujszolgkapadatprojektadd_hozz_keress(id_honnan,hol_lep){
 clearTimeout(admin_ujszolgkapadatprojektadd_hozz_keress_fo_wait);
 admin_ujszolgkapadatprojektadd_hozz_keress_fo_wait = setTimeout(function(){admin_ujszolgkapadatprojektadd_hozz_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_ujszolgkapadatprojektadd_hozz_keress_proc=null;
function admin_ujszolgkapadatprojektadd_hozz_keress_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_ujszolgkapadatprojektlist");
var par=admin_ujszolgkapadatprojektadd_hozz_keress_par();

if(ajax_admin_ujszolgkapadatprojektadd_hozz_keress_proc!=null){
 ajax_admin_ujszolgkapadatprojektadd_hozz_keress_proc.abort();
}

ajax_admin_ujszolgkapadatprojektadd_hozz_keress_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujszolgkapadatprojektadd_hozz_keress"+ker_par+par,
	function(d){
	ajax_admin_ujszolgkapadatprojektadd_hozz_keress_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#szolgcsopszolgkod_hozzid_tal_div").html(d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

function admin_ujszolgkapadatprojekt_hozz_change(projekt_id,mod){
var v="";
var projekt_nev="";

$("input[type=checkbox][id^=ujszolgkapadatprojekt_hozzid_]").each(function(){
if(!$(this).prop("checked")){
	var projekt_id=$(this).attr("projekt_id");
	//$("#admin_ujszolgkapadat_projektid").attr("projekt_id_"+projekt_id,"");
	$("#admin_ujszolgkapadat_projektid_"+mod).removeAttr("projekt_id_"+projekt_id);
}
});

//korábbiak - eleje
var korabbi_projekt_id_tomb=new Array();
var korabbi_id_tomb=$("#admin_ujszolgkapadat_projektid_"+mod).val();
if(korabbi_id_tomb!=""){
var korabbi_projekt_id=korabbi_id_tomb.split(",");
for (var i = 0; i < korabbi_projekt_id.length; i++) {

 var tmp_projekt_id=korabbi_projekt_id[i];
 korabbi_projekt_id_tomb[tmp_projekt_id]=korabbi_projekt_id[i];
 
 var korabbi_projekt_nev=$("#admin_ujszolgkapadat_projektid_"+mod).attr("projekt_id_"+korabbi_projekt_id[i]);
 if(korabbi_projekt_nev!="" && korabbi_projekt_nev!==undefined){
  if(v!="")v+=",";
  v+=korabbi_projekt_id[i];
  
  if(projekt_nev!="")projekt_nev+="<br>";
  projekt_nev+=korabbi_projekt_nev;
 }
}
}
//korábbiak - vége

$("input[type=checkbox][id^=ujszolgkapadatprojekt_hozzid_]").each(function(){
if($(this).prop("checked")){

 var projekt_id=$(this).attr("projekt_id");
 
 if(korabbi_projekt_id_tomb[projekt_id]===undefined){//korábbiak
  if(v!="")v+=",";
  v+=projekt_id;
  
  if(projekt_nev!="")projekt_nev+="<br>";
  var projekt_nev_most=$(this).attr("projekt_nev");
  projekt_nev+=projekt_nev_most;
  $("#admin_ujszolgkapadat_projektid_"+mod).attr("projekt_id_"+projekt_id,projekt_nev_most);
 }
}
});

if(projekt_nev=="")projekt_nev="Tevékenységek hozzáadása";
$("#admin_ujszolgkapadat_projektid_"+mod).val(v).trigger('change');
$("#admin_ujszolgkapadat_projektid_szam_"+mod).html(projekt_nev);
admin_ujszolgkapadatprojektadd_hozz_keress('','');

}

function admin_ujszolgkapadat(){
var szerz_id=encodeURIComponent($("#admin_ujszolgkapadat_szerzid").val());
var szerz_tetel_modszam_kezi=encodeURIComponent($("#admin_ujszolgkapadat_modszamkezi").val());
var szerz_csop_id=encodeURIComponent($("#admin_ujszolgkapadat_szerzcsopid").val());
var szolg_kod=encodeURIComponent($("#admin_ujszolgkapadat_szolgkod").val());
var szerz_tetel_utok=encodeURIComponent($("#admin_ujszolgkapadat_tetelutok").val());

var szerz_tetel_netto_szerzdij=encodeURIComponent($("#admin_ujszolgkapadat_nettoszerzdij").val());

var szerz_tetel_szolg_kezd_date=encodeURIComponent($("#admin_ujszolgkapadat_szolgkezddate").val());

if($("#admin_ujszolgkapadat_szolgkezddatefolyamatban").prop('checked'))
 var folyamatban='1';
else var folyamatban='0';
	
var szerz_tetel_netto_havidij=encodeURIComponent($("#admin_ujszolgkapadat_nettohavidij").val());
var szerz_tetel_netto_havidij_penznem=encodeURIComponent($("#admin_ujszolgkapadat_nettohavidij_penznem").val());

var szerz_elsz_tipus_id=encodeURIComponent($("#admin_ujszolgkapadat_elsztipusid").val());

var szerz_tetel_oradij=encodeURIComponent($("#admin_ujszolgkapadat_oradij").val());

var szerz_tetel_arajanlat_alair=encodeURIComponent($("#admin_ujszolgkapadat_arajanlatalair").val());
var szerz_tetel_alair_date=encodeURIComponent($("#admin_ujszolgkapadat_alairdate").val());
var szerz_tetel_szolg_origveg_date=encodeURIComponent($("#admin_ujszolgkapadat_szolgorigvegdate").val());

var szerz_tetel_netto_evesdij=encodeURIComponent($("#admin_ujszolgkapadat_nettoevesdij").val());

var szerz_naturalia_id=encodeURIComponent($("#admin_ujszolgkapadat_naturaliaid").val());
var szerz_tetel_naturalia_darab=encodeURIComponent($("#admin_ujszolgkapadat_naturaliadarab").val());
var szerz_usergazda_ad=encodeURIComponent($("#admin_ujszolgkapadat_usergazdaad").val());

//var szerz_tetel_integ_erint_date=encodeURIComponent($("#admin_ujszolgkapadat_integerintdate").val());
var szerz_tetel_integ_erintett=encodeURIComponent($("#admin_ujszolgkapadat_integerintett").val());


var szerz_tetel_megj=encodeURIComponent($("#admin_ujszolgkapadat_megj").val());
var szerz_tetel_tt_megj=encodeURIComponent($("#admin_ujszolgkapadat_ttmegj").val());
//var szerz_tetel_link=encodeURIComponent($("#admin_ujszolgkapadat_tetellink").val());

if($("#admin_ujszolgkapadat_nettoszerzdij_nemrelevans").prop("checked")){
 var nettoszerzdij_nemrelevans='1';
}else{
 var nettoszerzdij_nemrelevans='0';
}

if($("#admin_ujszolgkapadat_oradij_nemrelevans").prop("checked")){
 var oradij_nemrelevans='1';
}else{
 var oradij_nemrelevans='0';
}

if(szerz_id=='keremv'){
 diaglog_open("Hiba!<br><br>Szerződéses alapadat kiválasztása kötelező!","Hiba","hiba");
 return false;
}

if(szerz_csop_id=='keremv'){
 diaglog_open("Hiba!<br><br>Szolgáltatás csoport kiválasztása kötelező!","Hiba","hiba");
 return false;
}

if(szolg_kod=='keremv'){
 diaglog_open("Hiba!<br><br>Szolgáltatás kód kiválasztása kötelező!","Hiba","hiba");
 return false;
}

if(szerz_tetel_szolg_kezd_date==''){
 diaglog_open("Hiba!<br><br>Szolgáltásnyújtás megkezdésének időpontjának kitöltése kötelező!","Hiba","hiba");
 return false;
}


if(folyamatban=='0'){
	if(szerz_tetel_alair_date==''){
	 diaglog_open("Hiba!<br><br>Aláírás dátumának kitöltése kötelező!","Hiba","hiba");
	 return false;
	}
}

if(szerz_tetel_utok=='keremv'){
 diaglog_open("Hiba!<br><br>Utókalkuláció kiválasztása kötelező!","Hiba","hiba");
 return false;
}

if(szerz_elsz_tipus_id=='keremv'){
 diaglog_open("Hiba!<br><br>Elszámolás típusa kiválasztása kötelező!","Hiba","hiba");
 return false;
}

if(szerz_naturalia_id=='keremv'){
 diaglog_open("Hiba!<br><br>Naturália típus kiválasztása kötelező!","Hiba","hiba");
 return false;
}

if(szerz_tetel_integ_erintett=='keremv'){
 diaglog_open("Hiba!<br><br>Integrációban érintett kiválasztása kötelező!","Hiba","hiba");
 return false;
}

if(szerz_usergazda_ad=='keremv'){
 diaglog_open("Hiba!<br><br>Szerződésgazda kiválasztása kötelező!","Hiba","hiba");
 return false;
}

var projektid=encodeURIComponent($("#admin_ujszolgkapadat_projektid_uj").val());

var par="&szerz_id="+szerz_id+"&szerz_csop_id="+szerz_csop_id+"&szolg_kod="+szolg_kod+"&szerz_tetel_utok="+szerz_tetel_utok+"&szerz_tetel_netto_szerzdij="+szerz_tetel_netto_szerzdij+"&szerz_tetel_szolg_kezd_date="+szerz_tetel_szolg_kezd_date+"&szerz_tetel_netto_havidij="+szerz_tetel_netto_havidij+"&szerz_elsz_tipus_id="+szerz_elsz_tipus_id+"&szerz_tetel_oradij="+szerz_tetel_oradij+"&szerz_tetel_szolg_origveg_date="+szerz_tetel_szolg_origveg_date+"&szerz_tetel_netto_evesdij="+szerz_tetel_netto_evesdij+"&szerz_naturalia_id="+szerz_naturalia_id+"&szerz_tetel_naturalia_darab="+szerz_tetel_naturalia_darab+"&szerz_usergazda_ad="+szerz_usergazda_ad+"&szerz_tetel_integ_erintett="+szerz_tetel_integ_erintett+"&szerz_tetel_megj="+szerz_tetel_megj+"&szerz_tetel_tt_megj="+szerz_tetel_tt_megj+"&nettoszerzdij_nemrelevans="+nettoszerzdij_nemrelevans+"&oradij_nemrelevans="+oradij_nemrelevans+"&folyamatban="+folyamatban+"&szerz_tetel_modszam_kezi="+szerz_tetel_modszam_kezi+"&szerz_tetel_alair_date="+szerz_tetel_alair_date+"&szerz_tetel_arajanlat_alair="+szerz_tetel_arajanlat_alair+"&projektid="+projektid+"&szerz_tetel_netto_havidij_penznem="+szerz_tetel_netto_havidij_penznem;

admin_ujszolgkapadat_ment(par);
}

var ajax_keres_admin_ujszolgkapadat_ment=null;
function admin_ujszolgkapadat_ment(par){

if(ajax_keres_admin_ujszolgkapadat_ment!=null){
 ajax_keres_admin_ujszolgkapadat_ment.abort();
}

ajax_keres_admin_ujszolgkapadat_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_ujszolgkapadat_ment"+par,
	function(d){
	ajax_keres_admin_ujszolgkapadat_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba",'hiba');	
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_ujszolgkapadat_nemrelevans_nettoszerzdij(){
if($("#admin_ujszolgkapadat_nettoszerzdij_nemrelevans").prop("checked")){
 $("#admin_ujszolgkapadat_nettoszerzdij").val("").prop("disabled",true);
}else{
 $("#admin_ujszolgkapadat_nettoszerzdij").prop("disabled",false);
}
}

function admin_ujszolgkapadat_nemrelevans_oradij(){
if($("#admin_ujszolgkapadat_oradij_nemrelevans").prop("checked")){
 $("#admin_ujszolgkapadat_oradij").val("").prop("disabled",true);
}else{
 $("#admin_ujszolgkapadat_oradij").prop("disabled",false);
}
}

function admin_szolgkapadatlist_keres_par(){
//var szerz_id=encodeURIComponent($("#admin_szolgkapadatlist_keres_szerzid").val());
//var par="&szerz_id="+szerz_id;
var mire1=encodeURIComponent($("#admin_szolgkapadatlist_keres_mire1").val());
var mit1=encodeURIComponent($("#admin_szolgkapadatlist_keres_mit1").val());
var mit1_value=encodeURIComponent($("#admin_szolgkapadatlist_keres_mit1 option:selected").text());

var mire2=encodeURIComponent($("#admin_szolgkapadatlist_keres_mire2").val());
var mit2=encodeURIComponent($("#admin_szolgkapadatlist_keres_mit2").val());
var mit2_value=encodeURIComponent($("#admin_szolgkapadatlist_keres_mit2 option:selected").text());

var mire3=encodeURIComponent($("#admin_szolgkapadatlist_keres_mire3").val());
var mit3=encodeURIComponent($("#admin_szolgkapadatlist_keres_mit3").val());
var mit3_value=encodeURIComponent($("#admin_szolgkapadatlist_keres_mit3 option:selected").text());

var szerz_tetel_id=encodeURIComponent($("#admin_szolgkapadatlist_keres_szerztetelid").val());
var sapszam=encodeURIComponent($("#admin_szolgkapadatlist_keres_szerzsapszam").val());

if($("#admin_szolgkapadatlist_keres_akt").prop('checked')){
 var akt='1';
}else{
 var akt='0';
}

var par="&mire1="+mire1+"&mit1="+mit1+"&mire2="+mire2+"&mit2="+mit2+"&mire3="+mire3+"&mit3="+mit3+"&szerz_tetel_id="+szerz_tetel_id+"&akt="+akt+"&sapszam="+sapszam;
par+="&mit1_value="+mit1_value+"&mit2_value="+mit2_value+"&mit3_value="+mit3_value;
return par;
}

var admin_szolgkapadatlist_keres_fo_wait="";
function admin_szolgkapadatlist_keres(id_honnan,hol_lep){
  clearTimeout(admin_szolgkapadatlist_keres_fo_wait);
  admin_szolgkapadatlist_keres_fo_wait = setTimeout(function(){admin_szolgkapadatlist_keres_proc(id_honnan,hol_lep);},100);
}

var ajax_admin_szolgkapadatlist_keres_proc=null;
function admin_szolgkapadatlist_keres_proc(id_honnan,hol_lep){
var ker_par=emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,"admin_szolgkapadatlist");
var par=admin_szolgkapadatlist_keres_par();

if(ajax_admin_szolgkapadatlist_keres_proc!=null){
 ajax_admin_szolgkapadatlist_keres_proc.abort();
}

ajax_admin_szolgkapadatlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szolgkapadatlist_keres"+ker_par+par,
	function(d){
	ajax_admin_szolgkapadatlist_keres_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_uj_szolgkapadat_list_keres_tal").html(d1[1]);
	 alap_input_select_most();
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

var ajax_admin_szolgkapadat_reszlet=null;	
function admin_szolgkapadat_reszlet(szerz_tetel_id,szerz_tetel_adat_id){
if(ajax_admin_szolgkapadat_reszlet!=null){
 ajax_admin_szolgkapadat_reszlet.abort();
}

ajax_admin_szolgkapadatlist_keres_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szolgkapadat_reszlet&szerz_tetel_id="+encodeURIComponent(szerz_tetel_id)+"&szerz_tetel_adat_id="+encodeURIComponent(szerz_tetel_adat_id),
	function(d){
	ajax_admin_szolgkapadatlist_keres_proc=null;
	if(d.slice(0,2)=="ok"){
	 //diaglog_open(d.slice(5),"Részletezés: ID: "+szerz_tetel_id);
	 diaglog_open(d.slice(5),"Részletezés");
	 	 	 
	 /*setTimeout(function () {
			alap_input_select_most();
		},0);
		*/
		
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

function admin_szolgkapadat_reszlet_valt(szerz_tetel_id){
var szerz_tetel_adat_id=encodeURIComponent($("#admin_szolgkapadat_reszlet_eloz_sel").val());
admin_szolgkapadat_reszlet(szerz_tetel_id,szerz_tetel_adat_id);
}

function admin_szolgkapadat_mod(szerz_tetel_id,szerz_tetel_adat_id,statusz_str){
 var d="Biztos, hogy elindítod a hibajavítást?";
 d+="<br><br>Szolgáltatás ID: "+szerz_tetel_id;
 //if(mod_szam!='0')
 //d+="<br>Szerződésmódosítás száma: "+statusz_str;
 d+="<br>Módosítás ID: "+statusz_str;
 //if(szerz_tetel_akt=='1') d+=" - aktuális";

 //var title_ki="Hibajavítás: ID: "+szerz_tetel_id;
 var title_ki="Hibajavítás";

$("#dialog_egyeni_close").css('background-color','#A6CFF5').html(d).dialog({
	title: title_ki,
	buttons: {
		
		"hibajavitas":{
                    click: function () {
					 //$(this).dialog('widget').find('button').prop('disabled',true);
                     admin_szolgkapadat_mod_proc(szerz_tetel_id,szerz_tetel_adat_id,statusz_str);
                    },
                    'text': 'Hibajavítás',
                    'class': 'submit2'
		
		},
		"megse":{
                    click: function () {
                     //$("#admin_ujkapcstulajmod_inaktiv_"+id).prop("checked",false);
					 $(this).dialog("close");
                    },
                    'text': 'Mégse',
                    'class': 'submit2'
		
		},
		
      },
	  	open: function (event, ui){
		$(".ui-dialog-titlebar").css('background','linear-gradient(to bottom, #B8DEFF 5%, #0061a7 100%)').css('color','#fff');
		$(".ui-dialog-title").html("<img src='image/mod15_2.png'> "+title_ki);
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

var ajax_admin_szolgkapadat_mod_proc=null;
function admin_szolgkapadat_mod_proc(szerz_tetel_id,szerz_tetel_adat_id,mod_szam){
if(ajax_admin_szolgkapadat_mod_proc!=null){
 ajax_admin_szolgkapadat_mod_proc.abort();
}

ajax_admin_szolgkapadat_mod_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szolgkapadat_mod&szerz_tetel_id="+encodeURIComponent(szerz_tetel_id)+"&szerz_tetel_adat_id="+encodeURIComponent(szerz_tetel_adat_id),
	function(d){
	ajax_admin_szolgkapadat_mod_proc=null;
	if(d.slice(0,2)=="ok"){
	 admin_szolgkapadat_mod_proc_urlap(d.slice(5),szerz_tetel_id,szerz_tetel_adat_id,mod_szam);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}

/*
function admin_szolgkapadat_mod_proc_urlap(d,szerz_tetel_id){
	 diaglog_open(d,"Hibajavítás: ID: "+szerz_tetel_id);
	 	 setTimeout(function () {
			$("#admin_modszolgkapadat_nettoszerzdij").trigger("focus");
			alap_input_select_most();
			date_tol_ig();
		},0);
}*/

function admin_szolgkapadat_mod_proc_urlap(d,szerz_tetel_id,szerz_tetel_adat_id,mod_szam){
var title_ki="Hibajavítás: ID: "+szerz_tetel_id;
 //if(mod_szam!='0')
 //title_ki+=" Szerződésmódosítás száma: "+mod_szam;
 //if(szerz_tetel_akt=='1') title_ki+=" - aktuális";
 
$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
		
		"mentes":{
                    click: function () {
					 //$(this).dialog('widget').find('button').prop('disabled',true);
                     admin_szolgkapadat_mod_proc_urlap_mentes(szerz_tetel_id,szerz_tetel_adat_id);
                    },
                    'text': 'Hibajavítás mentése',
                    'class': 'submit2'
		
		},
		"megse":{
                    click: function () {
                     //$("#admin_ujkapcstulajmod_inaktiv_"+id).prop("checked",false);
					 $(this).dialog("close");
                    },
                    'text': 'Mégse',
                    'class': 'submit2'
		
		},
		
      },
	  	open: function (event, ui){
		$(".ui-dialog-title").html("<img src='image/mod15_2.png'> "+title_ki);
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
		$('#dialog').dialog('close');
        }
	}).dialog( "open" );

		$(".ui-dialog-title").html("<img src='image/mod15_2.png'> "+title_ki);
		alap_input_select_most();
		number_only();
		number_only_tizedes();
		date_tol_ig();
		tooltip_proc();
}

function admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,id){
var _this=$("#"+id);

var orig_val=_this.attr('orig_value');
if(id=='admin_modszolgkapadat_naturaliadarab' || id=='admin_modszolgmodadat_naturaliadarab'){
 orig_val=orig_val.replace(".00", "");
}

if(_this.val()!=orig_val){
 $("#lihiba_"+id).css("display","");
 return true;
}else{
 $("#lihiba_"+id).css("display","none");
 if(!hiba_vane)return false;
 else return true;
}

}

function admin_szolgkapadat_mod_proc_urlap_valt_func_ck(hiba_vane,id){

if(!$("#"+id).length){
 if(!hiba_vane)return false;
 else return true;
}

if($("#"+id).prop('checked'))
 var ert='1';
else var ert='0';

if($("#"+id).attr('orig_value')=='')
 var ert_orig='0';
else ert_orig=$("#"+id).attr('orig_value');

if(ert!=ert_orig){
 $("#lihiba_"+id).css("display","");
 return true;
}else{
 $("#lihiba_"+id).css("display","none");
 if(!hiba_vane)return false;
 else return true;
}

}

function admin_szolgkapadat_mod_proc_urlap_valt_vane(){
var hiba_vane=false;
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_modszamkezi");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_szerzcsopid");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_szolgkod");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_tetelutok");

hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_nettoszerzdij");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func_ck(hiba_vane,"admin_modszolgkapadat_nettoszerzdij_nemrelevans");

hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_arajanlatalair");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_alairdate");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_szolgkezddate");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func_ck(hiba_vane,"admin_modszolgkapadat_folyamatban");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_nettohavidij");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_nettohavidij_penznem");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_elsztipusid");

hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_oradij");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func_ck(hiba_vane,"admin_modszolgkapadat_oradij_nemrelevans");

hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_szolgorigvegdate");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_szolgaktvegdate");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_nettoevesdij");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_naturaliaid");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_naturaliadarab");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_szolgmoddate");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_ujszolgkapadat_projektid_hibajavitas");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_usergazdaad");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_integerintett");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_megj");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_ttmegj");
hiba_vane=admin_szolgkapadat_mod_proc_urlap_valt_func(hiba_vane,"admin_modszolgkapadat_tetellink");
return hiba_vane;
}

function admin_szolgkapadat_mod_proc_urlap_valt(){

if(!admin_szolgkapadat_mod_proc_urlap_valt_vane()){
 $("#admin_szolgkapadat_mod_mezok").css("display","none");
}else{
 $("#admin_szolgkapadat_mod_mezok").css("display","inline-block");
}
}

function admin_szolgkapadat_mod_proc_urlap_mentes(szerz_tetel_id,szerz_tetel_adat_id){
if(admin_szolgkapadat_mod_proc_urlap_valt_vane()){
if (confirm('Biztos, hogy elmented a hibajavítás változtatásait?')){
 admin_szolgkapadat_mod_proc_urlap_mentes_proc(szerz_tetel_id,szerz_tetel_adat_id);
}
}else{
 diaglog_open("Mentés nem lehetséges: nem történt módosítás!","Hiba","hiba");
}
}

var ajax_keres_admin_szolgkapadat_mod_proc_urlap_mentes_proc=null;
function admin_szolgkapadat_mod_proc_urlap_mentes_proc(szerz_tetel_id,szerz_tetel_adat_id){

var par="&szerz_tetel_id="+encodeURIComponent(szerz_tetel_id)+"&szerz_tetel_adat_id="+encodeURIComponent(szerz_tetel_adat_id);

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_modszamkezi")){
 par+="&szerz_tetel_modszam_kezi="+encodeURIComponent($("#admin_modszolgkapadat_modszamkezi").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_szerzcsopid")){
 par+="&szerz_csop_id="+encodeURIComponent($("#admin_modszolgkapadat_szerzcsopid").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_szolgkod")){
 par+="&szolg_kod="+encodeURIComponent($("#admin_modszolgkapadat_szolgkod").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_tetelutok")){
 par+="&szerz_tetel_utok="+encodeURIComponent($("#admin_modszolgkapadat_tetelutok").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_nettoszerzdij")){
 par+="&szerz_tetel_netto_szerzdij="+encodeURIComponent($("#admin_modszolgkapadat_nettoszerzdij").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func_ck(false,"admin_modszolgkapadat_nettoszerzdij_nemrelevans")){
 if($("#admin_modszolgkapadat_nettoszerzdij_nemrelevans").prop('checked')){
  var nettoszerzdij_nemrelevans='1'; 
 }else{
  var nettoszerzdij_nemrelevans='0'; 
 }
 par+="&nettoszerzdij_nemrelevans="+nettoszerzdij_nemrelevans;
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_arajanlatalair")){
 par+="&szerz_tetel_arajanlat_alair="+encodeURIComponent($("#admin_modszolgkapadat_arajanlatalair").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_alairdate")){
 par+="&szerz_tetel_alair_date="+encodeURIComponent($("#admin_modszolgkapadat_alairdate").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_szolgkezddate")){
 par+="&szerz_tetel_szolg_kezd_date="+encodeURIComponent($("#admin_modszolgkapadat_szolgkezddate").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func_ck(false,"admin_modszolgkapadat_folyamatban")){
 if($("#admin_modszolgkapadat_folyamatban").prop('checked')){
  var akt_folyamatban='1'; 
 }else{
  var akt_folyamatban='0'; 
 }
 par+="&szerz_tetel_szolg_kezd_date_folyamatban="+akt_folyamatban;
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_nettohavidij")){
 par+="&szerz_tetel_netto_havidij="+encodeURIComponent($("#admin_modszolgkapadat_nettohavidij").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_nettohavidij_penznem")){
 par+="&szerz_tetel_netto_havidij_penznem="+encodeURIComponent($("#admin_modszolgkapadat_nettohavidij_penznem").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_elsztipusid")){
 par+="&szerz_elsz_tipus_id="+encodeURIComponent($("#admin_modszolgkapadat_elsztipusid").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_oradij")){
 par+="&szerz_tetel_oradij="+encodeURIComponent($("#admin_modszolgkapadat_oradij").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func_ck(false,"admin_modszolgkapadat_oradij_nemrelevans")){
 if($("#admin_modszolgkapadat_oradij_nemrelevans").prop('checked')){
  var oradij_nemrelevans='1'; 
 }else{
  var oradij_nemrelevans='0'; 
 }
 par+="&oradij_nemrelevans="+oradij_nemrelevans;
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_szolgorigvegdate")){
 par+="&szerz_tetel_szolg_origveg_date="+encodeURIComponent($("#admin_modszolgkapadat_szolgorigvegdate").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_szolgaktvegdate")){
 par+="&szerz_tetel_szolg_aktveg_date="+encodeURIComponent($("#admin_modszolgkapadat_szolgaktvegdate").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_nettoevesdij")){
 par+="&szerz_tetel_netto_evesdij="+encodeURIComponent($("#admin_modszolgkapadat_nettoevesdij").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_naturaliaid")){
 par+="&szerz_naturalia_id="+encodeURIComponent($("#admin_modszolgkapadat_naturaliaid").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_naturaliadarab")){
 par+="&szerz_tetel_naturalia_darab="+encodeURIComponent($("#admin_modszolgkapadat_naturaliadarab").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_szolgmoddate")){
 par+="&szerz_tetel_szolg_mod_date="+encodeURIComponent($("#admin_modszolgkapadat_szolgmoddate").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_ujszolgkapadat_projektid_hibajavitas")){
 par+="&projektid="+encodeURIComponent($("#admin_ujszolgkapadat_projektid_hibajavitas").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_usergazdaad")){
 par+="&szerz_usergazda_ad="+encodeURIComponent($("#admin_modszolgkapadat_usergazdaad").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_integerintett")){
 par+="&szerz_tetel_integ_erintett="+encodeURIComponent($("#admin_modszolgkapadat_integerintett").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_megj")){
 par+="&szerz_tetel_megj="+encodeURIComponent($("#admin_modszolgkapadat_megj").val());
}

if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_ttmegj")){
 par+="&szerz_tetel_tt_megj="+encodeURIComponent($("#admin_modszolgkapadat_ttmegj").val());
}

/*
if(admin_szolgkapadat_mod_proc_urlap_valt_func(false,"admin_modszolgkapadat_tetellink")){
 par+="&szerz_tetel_link="+encodeURIComponent($("#admin_modszolgkapadat_tetellink").val());
}
*/

//var par="&szerz_csop_id="+szerz_csop_id+"&szolg_kod="+szolg_kod+"&szerz_tetel_utok="+szerz_tetel_utok+"&szerz_tetel_netto_szerzdij="+szerz_tetel_netto_szerzdij+"&szerz_tetel_szolg_kezd_date="+szerz_tetel_szolg_kezd_date+"&szerz_tetel_netto_havidij="+szerz_tetel_netto_havidij+"&szerz_elsz_tipus_id="+szerz_elsz_tipus_id+"&szerz_tetel_oradij="+szerz_tetel_oradij+"&szerz_tetel_szolg_origveg_date="+szerz_tetel_szolg_origveg_date+"&szerz_tetel_netto_evesdij="+szerz_tetel_netto_evesdij+"&szerz_naturalia_id="+szerz_naturalia_id+"&szerz_tetel_naturalia_darab="+szerz_tetel_naturalia_darab+"&szerz_usergazda_ad="+szerz_usergazda_ad+"&szerz_tetel_integ_erint_date="+szerz_tetel_integ_erint_date+"&szerz_tetel_megj="+szerz_tetel_megj+"&szerz_tetel_tt_megj="+szerz_tetel_tt_megj+"&szerz_tetel_link="+szerz_tetel_link;

if(ajax_keres_admin_szolgkapadat_mod_proc_urlap_mentes_proc!=null){
 ajax_keres_admin_szolgkapadat_mod_proc_urlap_mentes_proc.abort();
}

ajax_keres_admin_szolgkapadat_mod_proc_urlap_mentes_proc=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_szolgkapadat_mod_proc_urlap_mentes_proc"+par,
	function(d){
	ajax_keres_admin_szolgkapadat_mod_proc_urlap_mentes_proc=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //admin_muv_sel();
	 admin_szolgkapadatlist_keres_proc("","");
	 $("#dialog_egyeni_close").dialog('close');
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba","hiba");	
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}



function admin_szolgkapadat_mod_nettoszerzdij_nemrelevans_change(){

 if($("#admin_modszolgkapadat_nettoszerzdij_nemrelevans").prop('checked')){
  $("#admin_modszolgkapadat_nettoszerzdij").val('').prop('disabled',true); 
 }else{
  $("#admin_modszolgkapadat_nettoszerzdij").prop('disabled',false); 
 }
 admin_szolgkapadat_mod_proc_urlap_valt();
}

function admin_szolgkapadat_mod_oradij_nemrelevans_change(){

 if($("#admin_modszolgkapadat_oradij_nemrelevans").prop('checked')){
  $("#admin_modszolgkapadat_oradij").val('').prop('disabled',true); 
 }else{
  $("#admin_modszolgkapadat_oradij").prop('disabled',false); 
 }
 admin_szolgkapadat_mod_proc_urlap_valt();
}
