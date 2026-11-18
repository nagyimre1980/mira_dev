<?php

?>
var ajaxstat_a_ut="ajax_ful_admin.php";

jQuery(function($){
        $.datepicker.regional['hu'] = {
                closeText: 'bezárás',
                prevText: '&laquo;&nbsp;vissza',
                nextText: 'előre&nbsp;&raquo;',
                currentText: 'ma',
                monthNames: ['január', 'február', 'március', 'április', 'május', 'június',
                'július', 'augusztus', 'szeptember', 'október', 'november', 'december'],
                monthNamesShort: ['Január', 'Február', 'Március', 'Április', 'Május', 'Június',
                'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'],
                dayNames: ['Vasámap', 'Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat'],
                dayNamesShort: ['Vas', 'Hét', 'Ked', 'Sze', 'Csü', 'Pén', 'Szo'],
                dayNamesMin: ['V', 'H', 'K', 'Sze', 'Cs', 'P', 'Szo'],
                dateFormat: 'yy.mm.dd', firstDay: 1,
/*showOtherMonths: true,
selectOtherMonths: true,*/
showButtonPanel:true,
changeYear: true,
changeMonth: true,
showWeek: true,
showMonthAfterYear:true,//Év legyen előbb ne a hónap
weekHeader: "Hét",
minDate: '2022.01.01',
/*maxDate: '+365d',*/
maxDate: '+1y',
                isRTL: false};
        //$.datepicker.setDefaults($.datepicker.regional['hu']);

        $.datepicker.regional['hu5'] = {
                closeText: 'bezárás',
                prevText: '&laquo;&nbsp;vissza',
                nextText: 'előre&nbsp;&raquo;',
                currentText: 'ma',
                monthNames: ['január', 'február', 'március', 'április', 'május', 'június',
                'július', 'augusztus', 'szeptember', 'október', 'november', 'december'],
                monthNamesShort: ['Január', 'Február', 'Március', 'Április', 'Május', 'Június',
                'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'],
                dayNames: ['Vasámap', 'Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat'],
                dayNamesShort: ['Vas', 'Hét', 'Ked', 'Sze', 'Csü', 'Pén', 'Szo'],
                dayNamesMin: ['V', 'H', 'K', 'Sze', 'Cs', 'P', 'Szo'],
                dateFormat: 'yy.mm.dd', firstDay: 1,
/*showOtherMonths: true,
selectOtherMonths: true,*/
showButtonPanel:true,
changeYear: true,
changeMonth: true,
showWeek: true,
showMonthAfterYear:true,//Év legyen előbb ne a hónap
weekHeader: "Hét",
minDate: '2022.01.01',
/*maxDate: '+365d',*/
maxDate:(new Date().getFullYear()+5 )+'-12-31',
                isRTL: false};

});



//Ma gomb ki is válassza a mai dátumot. - eleje
/*
var old_goToToday = $.datepicker._gotoToday;
$.datepicker._gotoToday = function(id) {
  old_goToToday.call(this,id);
  this._selectDate(id);
  $(id).trigger('blur');
};
*/
// Ellenőrizzük, hogy létezik-e a datepicker, mielőtt módosítjuk
if ($.datepicker && $.datepicker._gotoToday) {
    
    // A régi referenciát elmentjük (opcionális, ha vissza akarnánk hívni az eredetit, de itt teljesen lecseréljük a logikát)
    var old_goToToday = $.datepicker._gotoToday;

    $.datepicker._gotoToday = function(id) {
        var $target = $(id); // A input mező jQuery objektuma
        var date = new Date(); // A mai dátum

        // 1. Dátum beállítása a Hivatalos API-val (nem a belső _selectDate-tel)
        $target.datepicker("setDate", date);
        
        // 2. Naptár bezárása a Hivatalos API-val
        $target.datepicker("hide");
        
        // 3. Blur esemény kiváltása (hogy a validációk lefussanak, ha vannak)
        $target.trigger("blur");
        
        // 4. Change esemény, ha más scriptek figyelik a változást
        $target.trigger("change");
    };
}
//Ma gomb ki is válassza a mai dátumot. - vége

function date_tol_ig(){
$.datepicker.setDefaults($.datepicker.regional['hu']);
//$( function() {

    //var dateFormat = "mm/dd/yy",
	var dateFormat= 'yy-mm-dd',
      from = $(".date_tol").not('.hasDatepicker')
		//.datepicker($.datepicker.regional["hu"])
		.datepicker()
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
		  $(this).trigger("click");
        })
		.on("focus", function() {
        $('.ui-tooltip').remove();
		$(this).trigger("select");
        })
		.mask('0000.00.00')
		.on("keyup",function () {
			var datevalue = $(this).val();
			if (datevalue.trim().length == 10) {
				if(!verifyDate(datevalue)){
					alert("Érvénytelen dátum!");
					$(this).val("").trigger('blur');
					$('.date_tolegy').datepicker("hide");
					
					
				}
			}
		})
		,
      to = $(".date_ig").not('.hasDatepicker')
	  .datepicker($.datepicker.regional["hu"])
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
		$(this).trigger("click");
      })
	  .on("focus", function() {
        $('.ui-tooltip').remove();
		$(this).trigger("select");
      });

	var dateFormat= 'yy.mm.dd';
    
	
	$.each($('.date_tol2').not('.hasDatepicker'), function() {
	   var datemod=$(this).attr("datemod");
	   if(datemod) var datemod_alk=datemod;
	   else var datemod_alk='hu';
	   $(this)
		.datepicker($.datepicker.regional[datemod_alk])//Csak ha több van
        .on( "change", function() {
		  var date_ig_mezo_id=$(this).attr('date_ig_mezo');
		  $("#"+date_ig_mezo_id).datepicker( "option", "minDate", getDate( this ) );

		  $(this).datepicker( "option", "maxDate", getDate(gi(date_ig_mezo_id)) );
		  
		  $(this).trigger("click");
        })
		.on("keyup",function(){
		  
		  	var datevalue = $(this).val();
			if (datevalue.trim().length == 10) {
				if(!verifyDate(datevalue)){
					alert("Érvénytelen dátum!");
					$(this).val("").trigger('blur');
					$('.date_tolegy').datepicker("hide");
				}else{
					var date_ig_mezo_id = $(this).attr('date_ig_mezo');
					var $partnerInput = $("#" + date_ig_mezo_id);
					var partnerValue = $partnerInput.val();
					if (partnerValue && partnerValue.trim().length == 10) {
						//var currentObj = $.datepicker.parseDate(dateFormat, datevalue);
						var currentObj = getDate_v(datevalue);
						//var partnerObj = $.datepicker.parseDate(dateFormat, partnerValue);
						var partnerObj = getDate_v(partnerValue);
						if (currentObj > partnerObj) {
						 alert("Érvénytelen dátum!");
						 $(this).val(""); // Törlés	
						}
					}
				}
			
			}
		  
		})
		.mask('0000.00.00')
		.on("focus", function() {
        $('.ui-tooltip').remove();
		$(this).trigger("select");
		});
	});

	$.each($('.date_tol25').not('.hasDatepicker'), function() {
	   $(this)
		.datepicker($.datepicker.regional['hu5'])//Csak ha több van
		/*.datepicker({
			maxDate: $.datepicker.parseDate( dateFormat,$(this).attr('data-maxdate'))
		})*/
        .on( "change", function() {
		  
		  var date_ig_mezo_id=$(this).attr('date_ig_mezo');
		  if(typeof date_ig_mezo_id!=='undefined'){
		  
		  $("#"+date_ig_mezo_id).datepicker( "option", "minDate", getDate( this ) );

		  $(this).datepicker( "option", "maxDate", getDate(gi(date_ig_mezo_id)) );
		  }
		  $(this).trigger("click");
		  
        })
		.on("focus", function() {
        $('.ui-tooltip').remove();
		$(this).trigger("select");
		});
	});

	$.each($('.date_ig2').not('.hasDatepicker'), function() {
       var datemod=$(this).attr("datemod");
	   if(datemod) var datemod_alk=datemod;
	   else var datemod_alk='hu5';
	  $(this)
	  .datepicker($.datepicker.regional[datemod_alk])//Csak ha több van
	  .datepicker({
			minDate: $.datepicker.parseDate( dateFormat,$(this).attr('data-mindate')),
		})
      .on( "change", function() {
		
		var date_tol_mezo_id=$(this).attr('date_tol_mezo');
		if(typeof date_tol_mezo_id!=='undefined'){
		 $("#"+date_tol_mezo_id).datepicker( "option", "maxDate", getDate( this ) );

		 $(this).datepicker( "option", "minDate", getDate(gi(date_tol_mezo_id)) );

	    }
		$(this).trigger("click");
      })
	  .on("keyup",function(){
		  
		  	var datevalue = $(this).val();
			if (datevalue.trim().length == 10) {
				if(!verifyDate(datevalue)){
					alert("Érvénytelen dátum!");
					$(this).val("").trigger('blur');
					$('.date_tolegy').datepicker("hide");
				}else{
					var date_tol_mezo_id = $(this).attr('date_tol_mezo');
					var $partnerInput = $("#" + date_tol_mezo_id);
					var partnerValue = $partnerInput.val();
					if (partnerValue && partnerValue.trim().length == 10) {
						//var currentObj = $.datepicker.parseDate(dateFormat, datevalue);
						var currentObj = getDate_v(datevalue);
						//var partnerObj = $.datepicker.parseDate(dateFormat, partnerValue);
						var partnerObj = getDate_v(partnerValue);
						if (currentObj < partnerObj) {
						 alert("Érvénytelen dátum!");
						 $(this).val(""); // Törlés	
						}
					}
				}
			}
		  
	  })
	  .mask('0000.00.00')
	  .on("focus", function() {
        $('.ui-tooltip').remove();
		$(this).trigger("select");
      });
	});

function getDate_v(v) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat,v);
      } catch( error ) {
        date = null;
      }
 
      return date;
}


function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
}
//} );
}

function verifyDate(datevalue) {
var ok_date=false;
if (datevalue != null && datevalue != '') {
//var tmp=datevalue.split('.');
var tmp=datevalue.split('.');
var ev=tmp[0];
var honap=tmp[1];
var nap=tmp[2];
var elso_ok_ev = 2020;
//var most_ido = new Date();

//getMonth()
//var newDate5 = new Date(most_ido.setMonth(most_ido.getMonth()+5)).getMonth()+1;

    if (nap >= 1 && nap <= 31) {
            if (honap >= 1 && honap <= 12) {
                //if (ev >= elso_ok_ev && ev <= most_ido.getFullYear()) {
                if (ev >= elso_ok_ev) {
                    ok_date=true;
                }/* else {
                    //$('#msg').html('Year must be between' + " " + fromYear + " - " + now.getFullYear());
                }*/
            }/* else {
                //$('#msg').html('Month is invalid');
            }*/

}
}
return ok_date;
}

/*
function ful_admin(){

}
*/

function admin_muv_sel(){
$(".ui-tooltip").css("visibility","hidden");
var _this=$("#admin_muvelet");

var v=_this.val();

if(_this.length && v!='keremv'){
_this.prop("disabled",true);
//console.log(v+' választottam');
switch(v) {
  /*case "keremv":
    $("#admin_tal").html("");
  break;*/
  
  case "admin_user_mod":
  case "admin_szerv_mod":
  case "admin_proj_mod":
  case "admin_arazasref_mod":
  
  case "admin_tagv_kod_mod":
  case "admin_szolg_kod_mod":
  
  case "admin_csop_nev_mod":
  case "admin_kat_nev_mod":
  
  case "admin_munkanapglobal_mod":
  case "admin_munkanapuser_mod":
  case "admin_honapzaras_mod":
  case "admin_hibajavitas_mod":
  case "admin_log":
  case "admin_kapcstulaj_mod":
  case "admin_kapcstorzs_mod":
  case "admin_kapcsossze_mod":
  case "admin_tervezes_mod":
  case "admin_tenypotlas_mod":
  case "admin_tenypotlastig_mod":
  
  case "admin_szerz_szerztipus":
  case "admin_szerz_szerzalapadat":
  case "admin_szerz_szerzfeltolt":
  case "admin_szerz_tarskat":
  case "admin_szerz_szolgcsop":
  case "admin_szerz_elsztipus":
  case "admin_szerz_nattipus":
  case "admin_szerz_szerzusergazda":
  case "admin_szerz_szolgkapadat":
  case "admin_szerz_szolgmodadat":
  case "admin_szerz_tigadat_penznem":
  case "admin_szerz_tigadat_co":
  case "admin_szerz_tigadat_sapszam":
  case "admin_szerz_tigadat_vevoazon":
  case "admin_szerz_tigadat_nemszerz":
  case "admin_szerz_integadat":
  case "admin_kpi_szolgkod":
  case "admin_kpi_tipus":
  case "admin_kpi_osszekap":
      admin_muv_ajax(v);
  break;
  default:
    alert("Ismeretlen művelet: "+v);
	$("#admin_tal").html("");
   break;
  
}
}else{
 $("#admin_tal").html("");
}
}

var ajax_keres_admin_muv_ajax=null;
function admin_muv_ajax(f){

if(ajax_keres_admin_muv_ajax!=null){
 ajax_keres_admin_muv_ajax.abort();
}

ajax_keres_admin_muv_ajax=$.post(ajaxstat_a_ut,"admin_mod=muv&mul_ful="+f,
	function(d){
	ajax_keres_admin_muv_ajax=null;
	$("#admin_muvelet").prop("disabled",false);
	//d1=d.split("$;$");
	//if(d1[0]=="ok"){
	if($('#admin_tal').length){
	if(d.slice(0,2)==="ok"){
	 //gi("admin_tal").innerHTML=d1[1];
	 gi("admin_tal").innerHTML=d.slice(5);
	 
	 if(
	  (f=="admin_szerz_szerztipus")||
	  (f=="admin_szerz_szerzalapadat")||
	  (f=="admin_szerz_szerzfeltolt")||
	  (f=="admin_szerz_tarskat")||
	  (f=="admin_szerz_szolgcsop")||
	  (f=="admin_szerz_elsztipus")||
	  (f=="admin_szerz_nattipus")||
	  (f=="admin_szerz_szerzusergazda")||
	  (f=="admin_szerz_szolgkapadat")||
	  (f=="admin_szerz_szolgmodadat")||
	  (f=="admin_szerz_tigadat_penznem")||
	  (f=="admin_szerz_tigadat_co")||
	  (f=="admin_szerz_tigadat_sapszam")||
	  (f=="admin_szerz_tigadat_vevoazon")||
	  (f=="admin_szerz_tigadat_nemszerz")||
	  (f=="admin_szerz_integadat")||
	  (f=="admin_kpi_szolgkod")||
	  (f=="admin_kpi_tipus")||
	  (f=="admin_kpi_osszekap")
	){
	 tab_hattervalt('kek');
	}else{
	 tab_hattervalt('');
	}
	 
	 
	 //$("#admin_tal").html(d1[1]);
	 alap_input_select_most();
	 number_only();
	 number_only_tizedes();
	 tooltip_proc();
	 tooltip_proc_adinfo();
	 date_tol_ig();
	 if(f=="admin_proj_mod"){
	  autosize($("#admin_uj_projekt_title"));
	  duplaprojektadmin_list_scrool_bar();
	 }else if(f=="admin_munkanapuser_mod")
	  inp_auto_start_munkanapuser_uj_user();
	 else if(f=="admin_tagv_kod_mod")
		 duplatagvadmin_list_scrool_bar();
	 else if(f=="admin_user_mod")
	  duplauseradmin_list_scrool_bar();
	 else if(f=="admin_szerv_mod")
		 duplaszervadmin_list_scrool_bar();
	 else if(f=="admin_szerz_tigadat_nemszerz")
		 duplatigadatnemszerzadmin_list_scrool_bar();
	 else if(f=="admin_kpi_osszekap"){
		 admin_kpi_osszekap_indit();
		 duplakpiosszekapcsadmin_list_scrool_bar();
		}
	}else{
	 $("#admin_tal").html("");
	 diaglog_open(d,"Rendszerhiba");
	}
	}
	},"text");
}

function number_only_tizedes(){

//All input autocomplete=off
//$('input,:input').attr('autocomplete','off');
autocomplete_off();

//pont=190 vessző:188

$(".number_penz_2tizedes:not([van_mar_number])").number(true,2);

$(".number_penz:not([van_mar_number])").number(true,0);

$(".number_penz_2tizedes,.number_penz").each(function(){
 $(this).attr("van_mar_number","1");
});

$(".number_penz,.number_penz_2tizedes").on("paste",function(e) {
  if (e.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
        e.preventDefault();
    }
   
   }).on("keydown",function(event) {

var e=event.keyCode;
//console.log(e);

if(e!=17){
        if (
	
	( ( event.ctrlKey && (e==67 || e==86) ) ||e==35 || e==36 || e==37||e==39||e==116||e==13||e==46||e==8||e==9)||(e>=96&&e<=105)||(e==188)||(e==110) ) {//188 190 67 88 86
            // let it happen, don't do anything
			//
			
        }else{
            // Ensure that it is a number and stop the keypress
            if (e< 48 ||e>57) {
                event.preventDefault(); 
            }   
        }
   }
});

}
