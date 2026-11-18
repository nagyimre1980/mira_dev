

function select2_torles_def(id,mire){
var _this=$('#'+id);
if(_this.hasClass("select2-hidden-accessible")){
 
 _this.select2('destroy').val(mire);
 //$('#userfizmodjogcim_jogcimek_id_hozzid_keress').val($("#target option:first").val());
 
 $('#'+id+' option:not(:selected)').remove();
}
}

function select2_torles_noselected(id){
var _this=$('#'+id);
if(_this.data('select2')){//Ha létezik
 _this.select2('destroy');
 $('#'+id+' option:not(:selected)').remove();
}

}

function alap_input_select_most(){
		select2_sima();
		select2_ajax();
		//number_only();
		//date_tol_ig();
}

function select2_ajax() {
  $(document)
    .off('.select2ajax')
    .on('mouseover.select2ajax', '.select2_ajax', function () {
      var $el = $(this);
      if ($el.data('select2')) return;
      select2_ajax_ajax($el);
    })
    .on('select2:open.select2ajax', '.select2_ajax', function () {
      var $el = $(this);
      if (!$el.data('select2-tooltip-done')) {
        $el.data('select2-tooltip-done', 1);
        tooltip_proc();
      }
	  delete_select2($(this));
    })
    .on('select2:close.select2ajax', '.select2_ajax', function () {
      $('.ui-tooltip').remove();
	  $(document).off('keydown.select2delete');
	  $('.select2-search__field').off('keydown.select2delete');
    });
}

/*
function select2_ajax_old(){
//select2_allajax();

$('.select2_ajax').one('select2:open',function(){
	//tooltip_proc();
	tooltip_proc();
//////}).on('select2:open',function(){
 


//Huzzuk alá a hozzátartozó szöveget ha van...
//select2_text_alahuz(this);

}).on('select2:close',function(){
 //$(this).select2('destroy');
 //$('#'+this.id+' option:not(:selected)').remove();

//Huzzuk alá a hozzátartozó szöveget ha van...
//select2_text_alahuz_del(this);


 $('.ui-tooltip').remove();
//}).on('mouseover', function(){
}).on('mouseover', function(){
 var _this = $(this);
 if(_this.data('select2')) return;
 select2_ajax_ajax(_this);
})

.maximizeSelect2Height({
cushion: 20 //Beállíthatja, hogy mennyi extra hely maradjon a nyitott legördülő menü széle és a nézetablak széle között a következő opcióval cushion
});

}
*/

var ajax_keres_select2_ajax_ajax=null;
function select2_ajax_ajax(m_this){
	//console.log('alma');
	/*
	csonkolt=0 igy kezdődik valami*
	csonkolt=1 csonkolt valami*
	*/
 	var csonkolt=0;
	if(typeof m_this.attr("csonkolt")!="undefined")
	 csonkolt=m_this.attr("csonkolt");

 	var mod=encodeURIComponent(m_this.attr("mod"));
	if(typeof mod==="undefined")
	 mod="";
	
	var mit_id=m_this.attr("mit_id");
	if(typeof mit_id!=="undefined")
	 var mit_val=encodeURIComponent($("#"+mit_id).val());
	else var mit_val="";
	
	var mit2_id=m_this.attr("mit2_id");
	if(typeof mit2_id!="undefined")
	 var mit2_val=encodeURIComponent($("#"+mit2_id).val());
	else var mit2_val="";
	
	var mit3_attr=m_this.attr("mit3");
	if(typeof mit3_attr!="undefined")
		var mit3_val=encodeURIComponent(mit3_attr);
	else var mit3_val="";
//console.log(ajax_keres_select2_ajax_ajax);
if(ajax_keres_select2_ajax_ajax!=null){
 ajax_keres_select2_ajax_ajax.abort();
}


 ajax_keres_select2_ajax_ajax=$.ajax({
                url: 'search2.php',
                dataType: 'json',
                type: "POST",
                delay: 0,
               data: {mod:mod,mit:mit_val,mit2:mit2_val,mit3:mit3_val},

		success: function(returnedData) {
            // Clear the notification text of the option.
            //$('#'+id+' option:eq(0)').text('a');
            // Initialize the Select2 with the data returned from the AJAX.
            //$(_this).select2({ data: returnedData });

ajax_keres_select2_ajax_ajax=null;
		
//2025.10.30 Ha nincs a lekérrt listában a selected elem, akkor a lista első eleme legyen az - eleje

////////////////var currentValue = m_this.val(); // Elmentjük az aktuális kiválasztott értéket
////////////////var hasMatch = false;

	/*		
// Ellenőrizzük, hogy az aktuális érték benne van-e az új adatokban
            if(currentValue) {
                for (var i = 0; i < returnedData.length; i++) {
                    if (returnedData[i].id == currentValue) {
                        hasMatch = true;
                        break;
                    }
                }
            }

// Ha nincs egyezés, és van új adat, kiválasztjuk az elsőt
            if (!hasMatch && returnedData.length > 0) {
                 // **FONTOS:** Először le kell rombolni a Select2-t, ha létezik, hogy az opciókat módosítani lehessen!
                 if (m_this.hasClass("select2-hidden-accessible")) {
                    //m_this.select2('destroy');
                 }

			// 2. Töröljük az ÖSSZES opciót. Ez eltávolítja a "keremv"-t.
            // Ezzel biztosítjuk, hogy a Select2 tiszta lappal induljon.
            //m_this.empty();
			
				// Mivel az AJAX data opcióval inicializáljuk, a returnedData az opciók.
                // Ha van adat és nincs korábbi egyezés, az első elem ID-jét állítjuk be.
                m_this.val(returnedData[0].id).trigger('change');
                // Ha biztosra akarsz menni, hogy minden "nem kiválasztott" opció eltűnjön, de ez 
                // csak a Select2 inicializálása ELŐTT működik a hagyományos select mezőnél.
                //$('#'+m_this.attr('id')+' option:not(:selected)').remove();
			} else if (!hasMatch && returnedData.length === 0) {
                // Ha nincs adat, győződj meg róla, hogy nincs kiválasztva semmi
                 if (m_this.hasClass("select2-hidden-accessible")) {
                    m_this.select2('destroy');
                 }
                 m_this.val(null).trigger('change');
            } else {
                 // Ha van egyezés, vagy a "keremv" (null/üres) az érték, csak pusztítsuk el az esetleges
                 // korábbi Select2-t a biztonság kedvéért, mielőtt újra inicializáljuk.
                 if (m_this.hasClass("select2-hidden-accessible")) {
                    m_this.select2('destroy');
                 }
            }
	*/
//2025.10.30 Ha nincs a lekérrt listában a selected elem, akkor a lista első eleme legyen az - vége

			//m_this.select2({
			var opts = {
				dropdownAutoWidth : true,
				 maximumInputLength:50,
				  language: "hu",
				dropdownCssClass: "bigdrop",
				
				matcher: function(params, data) {
				 return matchStart_uj(params, data,csonkolt);
				},

					
				  //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
				  //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
				 
				sorter: function(data) {
				    return data.sort(function (a, b) {	
					
					if (a.sorsz > b.sorsz) {
						return 1;
					}else if (a.sorsz < b.sorsz) {
						return -1;
					}
					return 0;
					});
				},
				  
				data: returnedData
			//});
			};
	
if (typeof m_this.attr("rejt_kereses") !== "undefined") {
  opts.minimumResultsForSearch = Infinity;
}

//m_this.select2(opts);
//m_this.maximizeSelect2Height({ cushion: 20 });
m_this.select2(opts).maximizeSelect2Height({ cushion: 20 });

//Hibajavítás miatt, itt van plusz paraméter
if (
  mod=="projekt_backup_ver_id" &&
  Array.isArray(returnedData) &&
  returnedData.length &&
  returnedData[0] &&
  typeof returnedData[0].uj_pojekt_id !== 'undefined'
) {
  for (var i = 0; i < returnedData.length; i++) {
    var item = returnedData[i];
    if (!item || item.id == null || item.uj_pojekt_id == null) continue;
    m_this.find('option').filter(function () {
      return String(this.value) === String(item.id);
    }).attr('uj_pojekt_id', item.uj_pojekt_id);
  }
}


// Ha van selected elem a returnedData-ban, triggereljük a change-et - eleje
if (Array.isArray(returnedData) && returnedData.some(function(item){ return item.selected; })) {
    m_this.trigger('change');
}
// Ha van selected elem a returnedData-ban, triggereljük a change-et - vége
	
	/*
	if(typeof m_this.attr("rejt_kereses")!=="undefined"){
			m_this.select2({minimumResultsForSearch: Infinity});
	}
	*/
			
            // Open the Select2.
			if (m_this.is(":focus"))
             m_this.select2('open');
        }
    });
}


//Sima kereső mező nélkül
function select3_nosearch(){
//Régi módszer
/*
$('.select3').each(function(){
 var _this=$(this);
 if(!_this.data('select2')){
   select3_nosearch_proc_sima(_this);
 }
});
*/

//Új módszer
var $sel = $('.select3').not('.select2-hidden-accessible');
  if ($sel.length) {
    select3_nosearch_proc_sima($sel);
  }
}

function select3_nosearch_proc_sima(_this){
//$('.select2').select2({
_this.select2({
 dropdownAutoWidth : true,
 language: "hu",
placeholder: "Kérem válassz",
minimumResultsForSearch: Infinity,

/*maximumInputLength:50,*/
dropdownCssClass: "bigdrop",
/*matcher: function(params, data) {
				 return matchStart(params, data,0);
				}*/
})
.maximizeSelect2Height({
cushion:20//Beállíthatja, hogy mennyi extra hely maradjon a nyitott legördülő menü széle és a nézetablak széle között a következő opcióval cushion
})
.one('select2:open',function(){
	//tooltip_proc();
	tooltip_proc();
}).on('select2:open',function(){
	
	//$('.ui-tooltip').remove();
	/*
	setTimeout(function(){
		tooltip_proc();
	},0);
	*/
	//Huzzuk alá a hozzátartozó szöveget ha van...
	//select2_text_alahuz(this);
	delete_select2($(this));
  }).on('select2:close',function(){
    $('.ui-tooltip').remove();
	//Huzzuk alá a hozzátartozó szöveget ha van...
	//select2_text_alahuz_del(this);
	$(document).off('keydown.select2delete');
	$('.select2-search__field').off('keydown.select2delete');
  });
}



function select2_sima(){

//Régi módszer
/*
$('.select2_sima').each(function(){
 var _this=$(this);
 if(!_this.data('select2')){
   select2_sima_proc_sima(_this);
 }
});

$('.select2_csonkolt').each(function(){
 var _this=$(this);
 if(!_this.data('select2')){
   select2_sima_proc_csonkolt(_this);
 }
});
*/

//Új módszer
var $sima = $('.select2_sima').not('.select2-hidden-accessible');
  if ($sima.length) {
    select2_sima_proc_sima($sima);
  }

  var $csonkolt = $('.select2_csonkolt').not('.select2-hidden-accessible');
  if ($csonkolt.length) {
    select2_sima_proc_csonkolt($csonkolt);
  }

select3_nosearch();
}

function select2_sima_proc_sima(_this){
//$('.select2').select2({
_this.select2({
 dropdownAutoWidth : true,
 language: "hu",
placeholder: "Kérem válassz",
maximumInputLength:50,
dropdownCssClass: "bigdrop",
matcher: function(params, data) {
				 return matchStart_uj(params, data,0);
				}
})
.maximizeSelect2Height({
cushion:20//Beállíthatja, hogy mennyi extra hely maradjon a nyitott legördülő menü széle és a nézetablak széle között a következő opcióval cushion
})
.one('select2:open',function(){
	//tooltip_proc();
	tooltip_proc();
}).on('select2:open',function(){
	//$('.ui-tooltip').remove();
	/*
	setTimeout(function(){
		tooltip_proc();
	},0);
	*/
	/*setTimeout(function(){
		document.querySelector('.select2-search__field').focus();
	},50);*/
	
	//Huzzuk alá a hozzátartozó szöveget ha van...
	//select2_text_alahuz(this);
	delete_select2($(this));
  }).on('select2:close',function(){
    $('.ui-tooltip').remove();
	//Huzzuk alá a hozzátartozó szöveget ha van...
	//select2_text_alahuz_del(this);
	$(document).off('keydown.select2delete');
	$('.select2-search__field').off('keydown.select2delete');
  });
}


function select2_sima_proc_csonkolt(_this){

_this.select2({
 dropdownAutoWidth : true,
 language: "hu",

placeholder: "Összes",
maximumInputLength:50,
dropdownCssClass: "bigdrop",
matcher: function(params, data) {
				 return matchStart_uj(params, data,1);
				}
})
.maximizeSelect2Height({
cushion:20//Beállíthatja, hogy mennyi extra hely maradjon a nyitott legördülő menü széle és a nézetablak széle között a következő opcióval cushion
})
.one('select2:open',function(){
	//tooltip_proc();
	tooltip_proc();
}).on('select2:open',function(){
	//$('.ui-tooltip').remove();
	/*
	setTimeout(function(){
		tooltip_proc();
	},0);
	*/
	/*setTimeout(function(){
		document.querySelector('.select2-search__field').focus();
	},50);*/



	//Huzzuk alá a hozzátartozó szöveget ha van...
	//select2_text_alahuz(this);
	delete_select2($(this));
  }).on('select2:close',function(){
	$('.ui-tooltip').remove();
	
	//Huzzuk alá a hozzátartozó szöveget ha van...
	//select2_text_alahuz_del(this);
	$(document).off('keydown.select2delete');
	$('.select2-search__field').off('keydown.select2delete');
  });
}




function ajax4_multiselect_update_json(id,adat_json,selected){
var _this_sel=$("#"+id);
//törlés
_this_sel.empty();

//Hozzáadás
var obj = JSON.parse(adat_json);
		$.each(obj, function(key,value) {
			  if(value.id=="all")
			   _this_sel.append($("<option only_radio_delete_fo='fo'></option>").attr("value",value.id).text(value.text));
			  else{
			   if(value.title!='')
			   _this_sel.append($("<option only_radio_delete_fo='al'></option>").attr("value",value.id).attr('title',value.title).text(value.text));
			   else
				_this_sel.append($("<option only_radio_delete_fo='al'></option>").attr("value",value.id).text(value.text));
			  }
		}); 

if(selected!=''){
 _this_sel.val(selected);
}

if($("#"+id).attr('class')=='select4_multiajax_search'){
 var searchinp=true;
}else{
 var searchinp=false;
}

//Törlés
_this_sel.each(function() {
  $.removeData(this,"plugin_multiSelect");
  $('#'+this.id+'_contdiv').remove();
}).multiSelect({//és beállítás
    //noneText: 'Összes',
	noneText: 'Kérem válassz',
    'menuMinHeight': '50',
	'searchinp':searchinp
});

//tooltip_proc_s();
}


function ajax4_multiselect_update_array(id,newOptions,beck){

/*
var newOptions = {
  "z": "zzzzz",
  "all": "Összes",
  "1": "Január",
  "value2": "value2",
  "value3": "value3"
};
*/

var _this_sel=$("#"+id);
_this_sel.empty();

$.each(newOptions,function(value,key){
  _this_sel.append($("<option></option>").attr("value", value).text(key));
});

if(beck!=''){
 _this_sel.val(beck);
}

if($("#"+id).attr('class')=='select4_multiajax_search'){
 var searchinp=true;
}else{
 var searchinp=false;
}

/*
_this_sel.each(function() {
  $.removeData(this,"plugin_multiSelect");
  $('#'+this.id+'_contdiv').remove();
});
return true;
*/

//Törlés
_this_sel.each(function() {
  $.removeData(this,"plugin_multiSelect");
  $('#'+this.id+'_contdiv').remove();
}).multiSelect({//és beállítás
    //noneText: 'Összes',
	noneText: 'Kérem válassz',
    'menuMinHeight': '50',
	'searchinp':searchinp
});
}


function delete_select2($select) {
  setTimeout(function () {
    // Mindig takarítunk először
    $(document).off('keydown.select2delete');
    $('.select2-search__field').off('keydown.select2delete');

    $(document).on('keydown.select2delete', function (e) {
      // Csak akkor reagálunk, ha tényleg nyitva van egy select2
      if (!$('.select2-container--open').length) return;

      if (e.key === 'Delete' || e.which === 46 || e.keyCode === 46) {
        e.preventDefault();
        e.stopPropagation();

        var $first = $('.select2-results__option--selectable')
          .not('.select2-results__option--disabled')
          .first();

        if ($first.length) {
          // Kiemeljük az elsőt
          $('.select2-results__option--highlighted')
            .removeClass('select2-results__option--highlighted');
          $first.addClass('select2-results__option--highlighted');

          // Enter szimuláció (működik keresős és kereső nélküli esetben is)
          var enterEvent = $.Event('keydown', {
            key: 'Enter',
            keyCode: 13,
            which: 13,
            bubbles: true
          });

          // Ha van keresőmező, arra küldjük, különben a document-re
          var $search = $('.select2-container--open .select2-search__field');
          if ($search.length) {
            $search.trigger(enterEvent);
          } else {
            $(document).trigger(enterEvent);
          }
        } else {
          // Fallback: első option
          var $firstOpt = $select.find('option').first();
          if ($firstOpt.length && $firstOpt.val() !== '') {
            $select.val($firstOpt.val()).trigger('change');
          }
          $select.select2('close');
        }
      }
    });
  }, 10);
}
