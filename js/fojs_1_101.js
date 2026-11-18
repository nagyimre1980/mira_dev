
var ajaxstat_p_ut="ajax.php";

//select2 hun 4.0.1 rc1
(function(){
 if($&&$.fn&&$.fn.select2&&$.fn.select2.amd)
  var e=$.fn.select2.amd;e.define("select2/i18n/hu",[],function()
  {
	  return{
		  errorLoading:function()
		  {
			  return"Az eredmények betöltése nem sikerült."
		  }
		  ,inputTooLong:
		  function(e){
			  return"Túl hosszú. "+(e.input.length-e.maximum)+" karakterrel több, mint kellene."
		  },
		  inputTooShort:function(e){
			  return"Túl rövid. Még "+(e.minimum-e.input.length)+" karakter hiányzik."
		  },
		  loadingMore:function(){
			  return"Töltés…"
		  },
		  maximumSelected:function(e){
			  return"Csak "+e.maximum+" elemet lehet kiválasztani."
		  },
		  noResults:function(){
			  return"Nincs találat."
		  },
		  searching:function(){
			  return"Keresés…"
		  },
		  removeAllItems:function(){
			  return"Távolítson el minden elemet"
		  },
		  removeItem:function(){
			  return"Elem eltávolítása"
		  },
		  search:function(){
			  return"Keresés"}
		 }
 }
)
//,e.define,e.require
}());


function gi(id){return document.getElementById(id);}


function doGetCaretPosition (oField) {

  // Initialize
  var iCaretPos = 0;

/*
  // IE Support
  if (document.selection) {

    // Set focus on the element
    oField.focus();

    // To get cursor position, get empty selection range
    var oSel = document.selection.createRange();

    // Move selection start to 0 position
    oSel.moveStart('character', -oField.value.length);

    // The caret position is selection length
    iCaretPos = oSel.text.length;
  }
*/
  // Firefox support
  //else 
  if (oField.selectionStart || oField.selectionStart == '0')
    iCaretPos = oField.selectionDirection=='backward' ? oField.selectionStart : oField.selectionEnd;

  // Return results
  return iCaretPos;
}

// mock Globalize numberFormat for mins and secs using jQuery spinner ...
/*
if (!window.Globalize) window.Globalize = {
        format: function(number, format) {
                number = String(this.parseFloat(number, 10) * 1);
                format = (m = String(format).match(/^[nd](\d+)$/)) ? m[1] : 2;
                for (i = 0; i < format - number.length; i++)
                        number = '0'+number;
                return number;
        },
        parseFloat: function(number, radix) {
                return parseFloat(number, radix || 10);
        }
};
*/

//var lepes_step=10*60000;
//var lepes_step=600000;
var lepes_step=10;

//timespinner "hh:mm"
// https://gist.github.com/takamin/a2f3c0edfee5f86ed4ac
 
$.widget( "ui.timespinner", $.ui.spinner, {
    options: {
		step:lepes_step,
		disabled: true,
        page: 60
		},

// --- JAVÍTOTT METÓDUS ---
_adjustValue: function( value ) {
    var options = this.options;

    if ( options.max !== null && value >= options.max ) return options.max;
    if ( options.min !== null && value <= options.min ) return options.min;

    var base = options.min !== null ? options.min : 0;
    var alignedValue = base + Math.round((value - base) / options.step) * options.step;

    if ( options.max !== null && alignedValue > options.max ) return options.max;
    if ( options.min !== null && alignedValue < options.min ) return options.min;

    return alignedValue;
},
    // --- JAVÍTOTT METÓDUS VÉGE ---

    _parse: function( value ) {
        
		if ( typeof value === "string" ) {
            if ( Number( value ) == value ) {
                return Number( value );
            }
            if(value == '') {
                return null;
            }
            var t = value.split(':', 2);
            var n = (Number(t[0]) * 60 + Number(t[1]));
            return Number(n);
        }
        return value;
    },
    _format: function( value ) {
        //console.log("_format: "+value);
		if(value == null) {
            return '';
        }
		var v = Number(value);
        while(v < 0) {
            v += (24 * 60);
        }
		v = (v % (24 * 60));
		var mm = "00" + (v % 60);
		mm = mm.substring(mm.length - 2);
		var hh = "00" + (Math.floor(v / 60) % 24);
		hh=Number(hh);
        //hh = hh.substring(hh.length - 2);
		//console.log("_format: mm: "+hh);
		return hh + ":" + mm;
        //return value;
    }
});

/*
$( function() {
    $.widget( "ui.timespinner", $.ui.spinner, {
      options: {
        // seconds
       //step: 60 * 1000,
        step:lepes_step,
		disabled: true,
        // hours
        page: 60
      },
 
      _parse: function( value ) {
		if ( typeof value === "string" ) {
          // already a timestamp
          if ( Number( value ) == value ) {
            return Number( value );
          }
          return +Globalize.parseDate( value );
        }
        return value;
      },
 
      _format: function( value ) {
		return Globalize.format( new Date(value), "x" );
      }
    });
 
 Globalize.culture("hu");
 //Globalize.culture("de-DE");
 //alert(Globalize.format( new Date("de-DE"), "t" ));
    // ".input_time" ).timespinner();
  }
);
*/

function timespinner_start_orakijelol(_self){
var len=_self.val().length;

if(len==4 || len==5){
if(len==4){
 var kijelolve_start=0;
 var kijelolve_end=1;
}else{
 var kijelolve_start=0;
 var kijelolve_end=2;
}
//_self.focus().prop({'selectionStart':kijelolve_start,'selectionEnd':kijelolve_end});
_self.trigger("focus").prop({'selectionStart':kijelolve_start,'selectionEnd':kijelolve_end});
}
}


function timespinner_start_perckijelol(_self){

var len=_self.val().length;
//console.log("len: "+len);
if(len==4 || len==5){
if(len==4){
 var kijelolve_start=2;
 var kijelolve_end=4;
}else{
 var kijelolve_start=3;
 var kijelolve_end=5;
}
_self.trigger("focus").prop({'selectionStart':kijelolve_start,'selectionEnd':kijelolve_end});
}

}


function timespinner_start(_this){

$(_this).timespinner({
//$("#"+id).timespinner({
    //spin: function( event, ui ) {
    spin: function(event) {
	 //var code = event.keyCode || event.which;
	 var code = event.which;
	 if(typeof event.handleObj!=="undefined"){
	  if(event.handleObj.type=="keydown"){
		event.preventDefault(); 
	 }
	 
	 //console.log(event.originalEvent.type);
	 //if (event.originalEvent && event.originalEvent.type === 'mousewheel') {
	 if (event.originalEvent && event.originalEvent.type === 'wheel') {
                //Tekerő letiltása, mert saját megolás van rá..
				//Már inkább ez van!
				//event.preventDefault();
				//var delta = event.deltaY || event.originalEvent && event.originalEvent.deltaY;
				//console.log(event.originalEvent.originalEvent.deltaY);
				var deltaY=-event.originalEvent.originalEvent.deltaY;
				//console.log(deltaY);
			
				 //if (event.deltaY > 0){
				 if (deltaY > 0){
				 	//ADD
					/////////event.preventDefault();
					input_tobb($(this));
					//return false;
					
				 //}else if (event.deltaY < 0){
				 }else if (deltaY < 0){
				  	//Subtract
					/////////event.preventDefault();
					input_kevesebb($(this));
					//return false;
					
				 }
	
				
     }
	 
	 if(code==1){///Csak ha a gombot nyomtuk meg
		 var _self=$(this);
		 
		 if(_self.prop('disabled')){
		  return false;
		 }
		 
		 var kijelolve_start=_self.prop("selectionStart");
		 var kijelolve_end=_self.prop("selectionEnd");
		 
		 //console.log(kijelolve_start+"-"+kijelolve_end);
		 
		 if(kijelolve_start==0 && kijelolve_end==0){
		    //Kijelöl óra:
			//timespinner_start_orakijelol(_self);
			//Kijelöl perc:
			timespinner_start_perckijelol(_self);
			
		 }
		// if(kijelolve_start!=0 || kijelolve_end!=0){

			if ($(event.currentTarget).hasClass('ui-spinner-up')) {
				//ADD
				input_tobb(_self);
				//return false;
				event.preventDefault();
			}else if($(event.currentTarget).hasClass('ui-spinner-down')) {
				//Subtract
				input_kevesebb(_self);
				//return false;
				event.preventDefault();
			}
			 
		// }
		 
	 }
	 
	 }
	
	}
	
	,
	 //stop: function( event, ui ) {
	 stop: function(event) {
	  
	  //V1.059 Admin-Hibajavításnál NE legyen mentés
	  if(input_time_no_mentes==0){
	   rogzit_ment_mezobol(this.id);
	  }
	  
	  //var code = event.keyCode || event.which;
	  //var code = event.keyCode;
	  var code = event.which;
	  if((typeof code!=="undefined")&&(code==0||code==1)){
	   var _self=$(this);
	   ///timespinner_start_perckijelol(_self);
	   
	   var len=_self.val().length;
	   if(len==5)_self.attr("maxlength",5);
	   else if(len==4)_self.attr("maxlength",4);
	   
	  }
	}
	
	//,create: function( event, ui ) {
	,create: function() {
		if($(this).attr('kitoltheto')=="1"){
		 $(this).timespinner("enable");
		}
	}
	
	
	
	});
}

/*
function matchStart_csonkolt(params, data) {
//console.log(params.term.slice(1));
if (data.text.toUpperCase().indexOf(params.term.slice(0).toUpperCase())!=-1) {
        return data;
    }else{
		return null;
	}
}
*/

function matchStart(params, data) {  
	//Ha van * karakter, akkor csonkolt
	if(params.term=="*"){
		 return data;
	}else if(params.term.indexOf("*")!=-1){
		//ker=params.term.slice(1);
		//console.log(ker);
		////////console.log(params.term.slice(1));
		//console.log(data.text.toUpperCase().indexOf(params.term.toUpperCase()));
     if (data.text.toUpperCase().indexOf(params.term.slice(1).toUpperCase())!=-1) {
        return data;
    }else{
		return null;
	}
	}else{//Különben csak az elején keresünk
	params.term = params.term || '';
    if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
		return data;
    }else{
		return null;
	}
	}
    //return data;
}

function matchStart_tart(params, data) {  
	//Ha van * karakter, akkor csonkolt
	/*if(params.term=="*"){
		 return data;
	}else if(params.term.indexOf("*")!=-1){*/
		//ker=params.term.slice(1);
		//console.log(data.text.toUpperCase().indexOf(params.term.toUpperCase()));
     if (data.text.toUpperCase().indexOf(params.term.slice(0).toUpperCase())!=-1) {
        //console.log(data.text+" ok");
		return data;
    }else{
		return null;
	}
	/*}else{//Különben csak az elején keresünk
	params.term = params.term || '';
    if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
		return data;
    }else{
		return null;
	}
	}*/
    //return data;
}

function matchStart_uj(params,data,csonkolt) {  

// Always return the object if there is nothing to compare
if((params.term.trim() === '')||(params.term=="*")){
			return data;
}
        data.parentText = data.parentText || "";

        

        // Do a recursive check for options with children
        if (data.children && data.children.length > 0) {
            // Clone the data object if there are children
            // This is required as we modify the object to remove any non-matches
            var match = $.extend(true, {}, data);

            // Check each child of the option
            for (var c = data.children.length - 1; c >= 0; c--) {
                var child = data.children[c];
                child.parentText += data.parentText + " " + data.text;

                //var matches = matchStart(params, child,csonkolt);
                var matches = matchStart(params, child);

                // If there wasn't a match, remove the object in the array
                if (matches == null) {
                    match.children.splice(c, 1);
                }
            }

            // If any children matched, return the new object
            if (match.children.length > 0) {
                return match;
            }

            // If there were no matching children, check just the plain object
            //return matchStart(params, match,csonkolt);
            return matchStart(params, match);
        }

        // If the typed-in term matches the text of this term, or the text from any
        // parent term, then it's a match.
        /*
		var original = (data.parentText + ' ' + data.text).toUpperCase();
        var term = params.term.toUpperCase();
		*/

if(csonkolt=="1" || params.term.indexOf("*")!=-1){
		//ker=params.term.slice(1);
		//console.log(ker);
		//console.log(params.term.slice(0,1));
		//console.log(data.text.toUpperCase().indexOf(params.term.toUpperCase()));
    if(params.term.slice(0,1)=="*"){
	 var ker_data=params.term.slice(1);
	}else{
	 var ker_data=params.term.slice(0);
	}
	//console.log(ker_data);
	//if (data.text.toUpperCase().indexOf(params.term.slice(1).toUpperCase())!=-1) {
	if (data.text.toUpperCase().indexOf(ker_data.toUpperCase())!=-1) {
        return data;
    }else{
		return null;
	}
	}else{//Különben csak az elején keresünk
	params.term = params.term || '';
    if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
		return data;
    }else{
		return null;
	}
	}


        // Check if the text contains the term
        /*if (original.indexOf(term) > -1) {
            return data;
        }*/

        // If it doesn't contain the term, don't return anything
        //return null;

}


//$.fn.select2.defaults.set("dropdownAutoWidth",true);
//$.fn.select2.defaults.set("maximumInputLength","50");
//$.fn.select2.defaults.set("language","hu");

function inp_auto_start_select2(m_this){
 
 //m_this.attr("sel2_futott","1");
 
//var id=m_this.attr('id');
//console.log(id);
 //$('#'+id+' option:eq(0)').text('Data is being loaded...');
 
 ///////////////var q_ki="";
 //nap=$("#"+this.id).attr("nap");
 var nap=m_this.attr("nap");
 //sel_val=$("#"+this.id+" option:selected").val();
 var sel_val=m_this.val();
 if(typeof sel_val==="undefined")
  sel_val="";

var this_id=m_this.attr('id');
var korabbi_sel_proj="";
$('select[id^=proj_'+nap+'_]').each(function(){
	if(this.id!=this_id ){//korábbi érték
	 var this_k_val=$(this).val();
	 if(this_k_val!="keremv"){
	  if(korabbi_sel_proj!="")korabbi_sel_proj+="-";
	  korabbi_sel_proj+=this_k_val;
	 }
	}
});

 ///////////////var datat='mod:"user_projekt",q: q_ki,sel: sel_val,nap:nap';
 
//$(_this).children().remove();//.append('<option id="keremv">Kérem válasz</option>'); 
 
 $.ajax({
                url: 'search.php',
                dataType: 'json',
                type: "POST",
                delay: 0,
               //data: {mod:"user_projekt",q:"",sel:sel_val,nap:nap,korabbi_sel_proj:korabbi_sel_proj}, // Any data that is needed to pass to the controller
               data: {mod:"user_projekt",sel:sel_val,nap:nap,korabbi_sel_proj:korabbi_sel_proj}, // Any data that is needed to pass to the controller

		success: function(returnedData) {
            // Clear the notification text of the option.
            //$('#'+id+' option:eq(0)').text('a');
            // Initialize the Select2 with the data returned from the AJAX.
            //$(_this).select2({ data: returnedData });
m_this.attr("sel2_futott","1");
			m_this.select2({
				dropdownAutoWidth : true,
				 maximumInputLength:50,
				  language: "hu",
				dropdownCssClass: "bigdrop",
				matcher: function(params, data) {
				 //return matchStart_csonkolt(params, data);
				 return matchStart_uj(params, data,"1");
				},

					
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
			});
         
	m_this.maximizeSelect2Height({ cushion: 20 });

 // Open the Select2.
			if (m_this.is(":focus"))
             m_this.select2('open');
		 
        }
    });
    // Blur the select to register the text change of the option.
    //$(this).blur();

//});


		 
}

function inp_auto_start(_this){
//'.sel_proj'
//console.log("inp_auto_start. Id:"+$(_this).attr('id'));
// Ahonnét jött az ötlet az 1 search lekérésre
//https://stackoverflow.com/questions/20701570/loading-remote-data-only-once-with-select2

var m_this=$(_this);
//m_this.one('click', function(){
//m_this.on('click', function(){

/*
m_this.on('select2:open',function(){
console.log("alma2");
//console.log(m_this.attr("sel2_futott"));
});
*/
/*
m_this.on('mouseover',function(){
	console.log(this.id);
  });

$(document).on('mouseover', '.select2-container', function(e) {
    console.log(this.id);
});*/

m_this.one('select2:open.emre1',function(){
	tooltip_proc();
  })

m_this.on('select2:open.emre2',function(){
	$('.ui-tooltip').remove();
	//console.log(this.id);
    //document.querySelector('.select2-search__field').focus();
	//document.querySelector(".select2-container--open .select2-search__field").focus();
	/*
	setTimeout(function(){
		document.querySelector('.select2-search__field').focus();
	}, 50);//add this line
	*/
	
	
	// Először keressük meg az aktív (fókuszált) keresőmezőt
	/*
        $('.select2-search__field').on('keydown.del_fix', function (e) {
            // A Delete (vagy Del) billentyű kódja: 46
            if(e.keyCode === 46){
            if(m_this.val()!='keremv'){
                // Megelőzzük a Select2 alapértelmezett viselkedését (pl. a tag törlését többválasztásnál)
                e.preventDefault();
                e.stopPropagation();

                // 3. Programozottan beállítjuk a 'keremv' értéket
                m_this.val('keremv').trigger('change.select2'); 

                // 4. Bezárjuk a Select2 listát
                m_this.select2('close');
				
				// 4. AZONNAL leválasztjuk az eseménykezelőt a keresőmezőről (ez a kulcs!)
                $(this).off('keydown.del_fix');
			}else{
			 m_this.select2('close');
			 //$(this).off('keydown.del_fix');
			}
            }
        });
		*/
		$('.select2-search__field')
		.off('keydown.del_fix')
		.on('keydown.del_fix', function (e) {
		if (e.keyCode !== 46) return;

		if (m_this.val() != 'keremv') {
		  e.preventDefault();
		  e.stopPropagation();
		  m_this.val('keremv').trigger('change.select2');
		  m_this.select2('close');
		} else {
		  m_this.select2('close');
		}

		$(this).off('keydown.del_fix');
		});
	
  })
  
.one('select2:select.emre3',function(){
		 //$(".sel_proj").removeAttr("sel2_futott");
		 //console.log("select2:select");
		var nap=$(this).attr("nap");		 
		$('select[id^=proj_'+nap+'_]').each(function(){
		//var id_akt=this.id;
		_this=$(this);
		
		//if((typeof $("#"+id_akt).attr("sel2_futott")!=="undefined")){
		if((typeof _this.attr("sel2_futott")!=="undefined")){
		 //console.log("#"+id_akt);
		 //console.log("Megszüntetés: "+id_akt+"_"+$("#"+id_akt).attr("sel2_futott"));
		 //$("#"+id_akt).removeAttr("sel2_futott");
		 _this.removeAttr("sel2_futott");
		 //console.log("Megszüntetés: "+id_akt);
		 
		 //$("#"+id_akt).off('select2:open.emre1').off('select2:open.emre2').off('select2:open.emre3').off('select2:open.emre4'); 
		 //$("#"+id_akt).select2('destroy');
		 _this.select2('destroy').off();
		 //$('#'+id_akt+' option:not(:selected)').remove();
		 _this.find('option:not(:selected)').remove();
		 
		  _this.on('mouseover', function(){
				inp_auto_start("#"+this.id);
			});
		 
		 //$("#"+id_akt).select2('destroy');
		 //inp_auto_start("#"+id_akt);//V1.031 nem futtatjuk le, majd ha csak rávitte az egeret
		}
		});
})

.on('select2:close.emre4',function(){
	$('.ui-tooltip').remove();
	//Fokusz legyen az adott sor időjén
		_this=$(this);
		var nap=_this.attr("nap");
		var sorsz=_this.attr("sorsz");
		if($("#proj_"+nap+"_"+sorsz).val()!="keremv")
		 //$("#input_proj_"+nap+"_"+sorsz).focus().select();
		 timespinner_start_orakijelol($("#input_proj_"+nap+"_"+sorsz));
  })/*.maximizeSelect2Height({
cushion: 20 //Beállíthatja, hogy mennyi extra hely maradjon a nyitott legördülő menü széle és a nézetablak széle között a következő opcióval cushion
})*/;

//console.log( m_this.attr("sel2_futott"));
if((typeof m_this.attr("sel2_futott")==="undefined")){
 inp_auto_start_select2(m_this);
 //console.log("inp_auto_start_select2. Id:"+$(_this).attr('id'));
}


/*
$("_this").select2({
 dropdownAutoWidth : true,
 maximumInputLength:30,
//placeholder: "Kérem válassz",
 //minimumResultsForSearch: -1,//Letiltás  a keresésre

 language: "hu",


 //templateResult: formatSingleResult,
/////////////////escapeMarkup: function (markup) { return markup; },

ajax: {
                url: 'search.php',
                dataType: 'json',
                type: "POST",
                delay: 0,
                data: function (params) {
					if(typeof params.term!=="undefined")
					 q_ki=encodeURIComponent(params.term);
					else q_ki="";
					nap=$("#"+this[0].id).attr("nap");
					sel_val=$("#"+this[0].id+" option:selected").val();
					//sel_text=$("#"+this[0].id+" option:selected").text();
					if(typeof sel_val==="undefined")
					  sel_val="";
                    return {
                        mod:"user_projekt",
                        q: q_ki,
                        sel: sel_val,
                        //sel_text: sel_text,
						nap:nap
                    };
                },
                processResults: function (data) {
                	//var res = data.items.map(function (item) {
                      //  	return {id: item.id, text: item.name};
                        //});
                    return {
                        //results: res
                        results: data
                    };
                }
            },

//});
})
.on('select2:open',function(){
	$('.ui-tooltip').remove();
	//console.log(this.id);
    //document.querySelector('.select2-search__field').focus();
	//document.querySelector(".select2-container--open .select2-search__field").focus();
	setTimeout(function(){
		document.querySelector('.select2-search__field').focus();
	}, 10);//add this line
	tooltip_proc();
  })
.on('select2:close',function(){
    $('.ui-tooltip').remove();
	//Fokusz legyen az adott sor időjén
		nap=$(this).attr("nap");
		sorsz=$(this).attr("sorsz");
		if($("#proj_"+nap+"_"+sorsz+" option:selected").val()!="keremv")
		 //$("#input_proj_"+nap+"_"+sorsz).focus().select();
		 timespinner_start_orakijelol($("#input_proj_"+nap+"_"+sorsz));
  });
*/

//Első jó megoldás

//$(document).on('select2:open', () => {
/*
$('.sel_proj').on('select2:open',function(){
    document.querySelector('.select2-search__field').focus();
	tooltip_proc();
  });
*/
  
  
}

var ajax_raford_projekt_meg_katt=null;
function raford_projekt_meg_katt(nap_akt,sorsz){

//Nézzük meg az input mezőt, ha az disabled, akkor megállunk
if($("#input_proj_"+nap_akt+"_"+sorsz).prop("disabled")){
 return false;
}

if(ajax_raford_projekt_meg_katt!=null){
 ajax_raford_projekt_meg_katt.abort();
}

//projekt_id
//proj_2_1
var projekt_id=$("#proj_"+nap_akt+"_"+sorsz).val();

var par="&nap_akt="+encodeURIComponent(nap_akt)+"&sorsz="+encodeURIComponent(sorsz)+"&projekt_id="+encodeURIComponent(projekt_id)+"&ev="+global_ev+"&ho="+global_ho+"&user_ad="+global_user;
ajax_raford_projekt_meg_katt=$.post(ajaxstat_p_ut,"mod=raford_projekt_meg_katt"+par,
	function(d){
	ajax_raford_projekt_meg_katt=null;
	if(d.slice(0,5)=="ok$;$"){
	 raford_projekt_meg_katt_dialog(d.slice(5),nap_akt,sorsz,projekt_id);
	}else if(d=="nookreload"){
		reload_disabled();
	}else{
	 diaglog_open("Rendszerhiba, kérjük problálja később újra!","Rendszerhiba");	
	}
 },"text");
}

function raford_projekt_meg_katt_dialog(d,nap_akt,sorsz,projekt_id){

var title_ki='Megjegyzés';
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Mentés": function() {
		 $(this).dialog('widget').find('button').prop('disabled',true);
		 raford_projekt_meg_katt_dialog_mentes(nap_akt,sorsz,projekt_id);
        },
        "Mégse": function() {
          $(this).dialog("close");
        }
      },
	  	open: function (event, ui){
		$(".ui-dialog-title").html("<img style='height:17px' src='image/comment_2.png'> "+title_ki);
		//$("#dialog_egyeni_close").dialog("option","position",{my:"center",at:"center",of:window}).dialog("option","width","auto");
        $("#ui-widget-overlay").fadeIn();
		/*autosize($("#proj_egysor_megj"));*/
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

var ajax_raford_projekt_meg_katt_dialog_mentes=null;
function raford_projekt_meg_katt_dialog_mentes(nap_akt,sorsz,projekt_id){

if(ajax_raford_projekt_meg_katt_dialog_mentes!=null){
 ajax_raford_projekt_meg_katt_dialog_mentes.abort();
}

var rogzit_sor_megj=encodeURIComponent($("#proj_egysor_megj").val());

var par="&nap_akt="+encodeURIComponent(nap_akt)+"&sorsz="+encodeURIComponent(sorsz)+"&projekt_id="+encodeURIComponent(projekt_id)+"&rogzit_sor_megj="+rogzit_sor_megj;
ajax_raford_projekt_meg_katt_dialog_mentes=$.post(ajaxstat_p_ut,"mod=raford_projekt_meg_katt_dialog_mentes"+par,
	function(d){
	ajax_raford_projekt_meg_katt_dialog_mentes=null;
	$("#dialog_egyeni_close").dialog('widget').find('button').prop('disabled',false);
	
	//Ha nincs megjegyzés, akkor kép legyen fekete, ha van piros
	var _this_megj_img=$("#projmegjimg_"+nap_akt+"_"+sorsz);
	if(rogzit_sor_megj==""){
	 _this_megj_img.attr("src","image/comment_2.png");
	}else{
	 _this_megj_img.attr("src","image/comment_2_pir.png");
	}
	
	if(d=="ok$;$"){
	 $("#dialog_egyeni_close").dialog("close");
	}else{
	 diaglog_open("Rendszerhiba, kérjük problálja később újra!","Rendszerhiba");	
	}
 },"text");
}

function raford_projekt_select(ev,nap_akt,sorsz){
var v=$("#proj_"+nap_akt+"_"+sorsz).val();

var van_akt_sor=0;
$('select[id^=proj_'+nap_akt+'_]').each(function(){
 var _selected_v=$("#"+this.id);
 if(typeof _selected_v.val()!=='undefined' && _selected_v.val()!="keremv"){
  van_akt_sor=1;
 }
});

if(v!="" && v!="keremv"){

//Ekkor az input-ra class csere.
var input_projakt=$("#input_proj_"+nap_akt+"_"+sorsz);
input_projakt.addClass('input_time').removeClass('input_time_dis');
timespinner_start("#input_proj_"+nap_akt+"_"+sorsz);
timespinner_start_egyeb_egy("#input_proj_"+nap_akt+"_"+sorsz);
//console.log("#input_proj_"+nap_akt+"_"+sorsz);

//Változott-e a kiválasztott projekt?
var last_sel_id=$("#proj_"+nap_akt+"_"+sorsz).attr("last_sel_id");
if(last_sel_id!=v){
 var last_sel_id_kuld=last_sel_id;
}else{
 var last_sel_id_kuld="";
}

//V1.047 verzió tevékenység megjegyzés csak mód miatt
if(last_sel_id_kuld=='')last_sel_id_kuld='keremv';

//Utolsó választott cucc elmentése
//$("#proj_"+nap_akt+"_"+sorsz).attr("last_sel_id",v);

rogzit_ment_proc(nap_akt,sorsz,last_sel_id_kuld);
//Adott sor engedélyezve
 //$("#input_proj_"+nap_akt+"_"+sorsz).prop("disabled",false);
 input_projakt.timespinner("enable");

 var sorsz_uj=Number($("#proj_"+nap_akt+"_"+sorsz).attr("sorsz"))+1;
 if(!$("#proj_"+nap_akt+"_"+sorsz_uj).length){
  raford_projekt_select_addsor(ev,nap_akt,sorsz,sorsz_uj);
 }else{//Ekkor van, csak el van rejtve!
  $("#span_proj_"+nap_akt+"_"+sorsz).css("display","flex");
 }

/*if(van_akt_sor==1){//Megjegyzés engedélyezése
 $("#td_textarea_"+nap_akt).prop("disabled",false);
}*/

//Ekkor engedélyezzük a megjegyzés ikon-t
$("#projmegjimg_"+nap_akt+"_"+sorsz).css("display","inline-block");

}else{//Ekkor kéremv, adott sor tiltás, köv törlése és nullázása és mentése?

var last_sel_id=$("#proj_"+nap_akt+"_"+sorsz).attr("last_sel_id");
if(last_sel_id!="" && last_sel_id!="keremv"){
 var last_sel_id_kuld=last_sel_id;
}else{
 var last_sel_id_kuld="";
}
rogzit_ment_proc(nap_akt,sorsz,last_sel_id_kuld);

 //Adott sor tiltása
 $("#input_proj_"+nap_akt+"_"+sorsz).val("0:00").timespinner("disable");
 //Mentés?
 
 //Elrejtés
  $("#span_proj_"+nap_akt+"_"+sorsz).css("display","none");
  rogzit_textrarea_meretezes(nap_akt);

//ALL-nál legyen nulla
ho_all_ido_ora[nap_akt]=0;
  ho_all_ido_perc[nap_akt]=0;

//if(van_akt_sor==0){//Megjegyzés tiltása
 //$("#td_textarea_"+nap_akt).val("").prop("disabled",true);
 osszesen_nap(nap_akt,"1");
//}
  
}
$('.ui-tooltip').remove();
}

var ajax_keres_raford_projekt_select_addsor=null;
function raford_projekt_select_addsor(ev,nap_akt,sorsz,sorsz_uj){
var td_id='td_proj_'+nap_akt;

if(ajax_keres_raford_projekt_select_addsor!=null){
 ajax_keres_raford_projekt_select_addsor.abort();
}

ajax_keres_raford_projekt_select_addsor=$.post(ajaxstat_p_ut,"mod=proj_kov_sor&ev="+ev+"&nap_akt="+nap_akt+"&sorsz_uj="+sorsz_uj,
	function(d){
	ajax_keres_raford_projekt_select_addsor=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#"+td_id).append(d1[1]);
	 //timespinner_start("#input_proj_"+nap_akt+"_"+sorsz_uj);
	 //timespinner_start_egyeb_egy("#input_proj_"+nap_akt+"_"+sorsz_uj);
	 inp_auto_start("#proj_"+nap_akt+"_"+sorsz_uj);
	 
	rogzit_textrarea_meretezes(nap_akt);
	
	 
	 
	}else{
	 alert("Hiba");
	}
	},"text");


}

function rogzit_textrarea_meretezes_all(){

$('.rogzit_megj_textarea').each(function(){
	//$(this).css("height","1px");
	
	//alert($(this).parent().css("height"));
	//alert($(this).parent().parent().css("height"));
	//return false;
	
	//$(this).css("height",$(this).parent().css("height"));
	var _self=$(this);
	var nap_akt=_self.attr("nap_akt");
	var _self_tav=$("#proj_szabi_"+nap_akt);
	
	if(
	(!_self_tav.length)||(_self_tav.length  && !_self_tav.prop("checked"))
	){
	 var mag=_self.parent().parent().css("height");
	 if(mag=="46px" || mag=="42px")//Chomre és //IE fix
	   mag="35px";
	 _self.css("height",mag);
//	 console.log(mag);
	}
});

}

function rogzit_textrarea_meretezes(nap_akt){
//Textrarea növelés
//_this_texta=$(".rogzit_megj_textarea");

var _this_texta=$("#td_textarea_"+nap_akt);

_this_texta.css("height","1px");

var mag=_this_texta.parent().css("height");
if(mag=="46px" || mag=="21.25px")//Chomre és //IE fix
 mag="35px";
//_this_texta.css("height",_this_texta.parent().css("height"));
_this_texta.css("height",mag);

//autosize(_this_texta);
//autosize.update(_this_texta);
}

//$(function(){
function dialog_indul(){  

function dialog_egy_igazit(sel){
	var $d = $(sel);
	if(!$d.length || !$d.data('ui-dialog') || !$d.dialog('isOpen')) return;

	var widget = $d.dialog('widget')[0];
	if(!widget) return;

	var rect = widget.getBoundingClientRect();
	var vh = window.innerHeight;
	if(rect.top >= -1 && rect.bottom <= vh + 1) return;

	var most_height = Math.floor(vh * 0.95);
	var position = {my: 'center', at: 'center', of: window};

	$d.dialog('option', 'maxHeight', most_height);
	$d.dialog('option', 'height', 'auto');
	$d.dialog('option', 'position', position);
}

function dialog_tartalom_figyelo(){
	['#dialog','#dialog2','#dialog_egyeni_close'].forEach(function(sel){
		var el = document.querySelector(sel);
		if(!el || el._dialogObs) return;

		var obs = new MutationObserver(function(){
			dialog_egy_igazit(sel);
		});
		obs.observe(el, {childList: true, subtree: true});
		el._dialogObs = obs;
	});
}

dialog_tartalom_figyelo();
	
	var most_height=$(window).height()*0.95;
	
	$("#dialog").dialog({
	  autoOpen: false,
	  width: "auto",
	  maxHeight: most_height,
	  position: {my: "center", at: "center", of: window},
	  resizable: false,
	  titleIsHtml:true,
	  closeOnEscape: false,
	  closeText : "Bezárás", // Here is the Gem
	  open: function (){
		//$("#dialog").dialog("option","position",{my:"center",at:"center",of:window}).dialog("option","width","auto");
		$(this).dialog("option","position",{my:"center",at:"center",of:window});
        $("#ui-widget-overlay").fadeIn();
		alap_input_select_most();//2025_03_17
		autocomplete_off();
		$(".ui-tooltip").css("visibility","hidden");
		tooltip_proc();
      },
	  close: function (){
		//$(this).dialog('destroy').remove();
		//$(this).dialog('destroy').remove();
		//$('#dialog').dialog("close");
		$(this).dialog('widget').find('button').prop('disabled',false).css('color',"");
		$(this).html("");
		
		if(
		(!$('#dialog2').dialog('isOpen'))&&
		(!$('#dialog_egyeni_close').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }

      }
    });
	
    $("#dialog2").dialog({
	  autoOpen: false,
	  width: "auto",
	  maxHeight: most_height,
	  position: {my: "center", at: "center", of: window},
	  resizable: false,
	   closeText : "Bezárás", // Here is the Gem
	  open: function (){
		//$("#dialog2").dialog("option","position",{my:"center",at:"center",of:window}).dialog("option","width","auto");
        $("#ui-widget-overlay").fadeIn();
		autocomplete_off();
		$(".ui-tooltip").css("visibility","hidden");
      },
	  close: function (){
		//$(this).dialog('destroy').remove();
		//$(this).dialog('destroy').remove();
		//$('#dialog').dialog("close");
		$(this).dialog('widget').find('button').prop('disabled',false).css('color',"");
		$(this).html("");
		
		if(
		(!$('#dialog').dialog('isOpen'))&&
		(!$('#dialog_egyeni_close').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }

      }
    });
	
	    $("#dialog_egyeni_close").dialog({
	  autoOpen: false,
	  width: "auto",
	  maxHeight: most_height,
	  position: {my: "center", at: "center", of: window},
	  resizable: false,
	  closeText : "Bezárás", // Here is the Gem
	  closeOnEscape: false,
	  open: function (){
		//$("#dialog_egyeni_close").dialog("option","position",{my:"center",at:"center",of:window});
        $("#ui-widget-overlay").fadeIn();
      },
	  close: function (){
		//$(this).dialog('destroy').remove();
		//$(this).dialog('destroy').remove();
		//$('#dialog').dialog("close");
		$(this).dialog('widget').find('button').prop('disabled',false).css('color',"");
		$(this).html("");
		
		if(
		(!$('#dialog').dialog('isOpen'))&&
		(!$('#dialog2').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
      }
    });

}
//});

$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
    _title: function(title) {
       var _this_op=this.options;
	   if(_this_op.title!='' && _this_op.title!=null){
		var title_ = _this_op.title || '&nbsp;';
        if( ("titleIsHtml" in _this_op) && _this_op.titleIsHtml == true )
            title.html(title_);
        else title.text(title_);
		 //title.html(title_);
	   }
    }
}));


function diaglog_open(d,title_ki,title_img){

if(title_img=="hiba"){
 title_ki="<img class='dialog_fejlec_img' src='image/del_behajtani16.png'> "+title_ki;
}else if(
(typeof title_img!=="undefined")&&
(title_img!="")){
 title_ki="<img class='dialog_fejlec_img' src='image/"+title_img+"'> "+title_ki;
}

$("#dialog").html(d).dialog({title: title_ki,buttons:''}).dialog("open");
//dialogok_kozepre();
}

function diaglog2_open(d,title_ki){
//$("#dialog").html(d).dialog({title: title_ki,buttons:''}).dialog( "open" );	
$("#dialog2").html(d).dialog({title: title_ki,buttons:''}).dialog("open");
}

function dialogok_atmeretezes(){

var most_height=$(window).height()*0.95;

var _this_d=$('#dialog');
var _this_d2=$('#dialog2');
var _this_d_egy=$('#dialog_egyeni_close');

//if(_this_d.dialog('isOpen')){
 _this_d.dialog("option", "position", {my: "center", at: "center", of: window}).dialog("option", "maxHeight",most_height);
//}

//if(_this_d2.dialog('isOpen')){
 _this_d2.dialog("option", "position", {my: "center", at: "center", of: window}).dialog("option", "maxHeight",most_height);
//}

//if(_this_d_egy.dialog('isOpen')){
 _this_d_egy.dialog("option", "position", {my: "center", at: "center", of: window}).dialog("option", "maxHeight",most_height);
//}

}

//Új
function chrome_tab_change() {
  document.addEventListener('visibilitychange', function () {
    if (document.visibilityState === 'visible') {
      fopage_reopen();
    }
  });
}

/**
 * Modernizált funkció a böngésző fül láthatóságának és fókuszának kezelésére.
 * Meghívja a fopage_reopen() függvényt, amikor az oldal láthatóvá/fókuszba kerül.
 * (Feltételezi, hogy a fopage_reopen() globálisan elérhető).
 */

/*
function chrome_tab_change_old() {
    let isVisible = true; // Belső flag a duplázás elkerülésére

    function onVisible() {
        if (isVisible) {
            return;
        }
        isVisible = true;
        // console.log('visible');
        fopage_reopen();
    }

    function onHidden() {
        if (!isVisible) {
            return;
        }
        isVisible = false;
        // console.log('hidden');
    }

    
     //* Kezeli a láthatósági eseményeket és a focus/blur eseményekről érkező jelzéseket.
     //* @param {boolean|Event} source - A 'true'/'false' flag a focus/blur-től, vagy az Event objektum a visibilitychange-től.
     
    function handleVisibilityChange(source) {
        // 1. Focus/Blur események (forrás: boolean)
        if (typeof source === "boolean") {
            return source ? onVisible() : onHidden();
        }

        // 2. VisibilityChange esemény (a forrás: Event objektum)
        // Használjuk a szabványos document.hidden property-t
        if (document.hidden) {
            return onHidden();
        }
        return onVisible();
    }

    // Fő eseménykezelő regisztrálása (szabványos Page Visibility API)
    document.addEventListener('visibilitychange', handleVisibilityChange, false);

    // Kiegészítő eseménykezelők a jobb viselkedésért (különösen a fül-váltás detektálására)
    // Megjegyzés: A document helyett a window a relevánsabb a teljes ablak fókuszához.
    window.addEventListener('focus', () => handleVisibilityChange(true), false);
    window.addEventListener('blur', () => handleVisibilityChange(false), false);
}

*/

function fopage_reopen(){
$('body').trigger('mousedown');
}

//$(document).ready(function(){
$(function(){

dialog_indul();

   //Vissza gomb mgnyomásakor legyen újratöltés
   $(window).on('popstate', function() {
      location.reload();//true csak firefox nem szabványos
   }).on("resize",function() {
	   //Átméretezéskor tooltip eltüntetése
	   dialogok_atmeretezes();
	   
	   //select2 bezárása átméretezéskor
	   $('body').trigger('mousedown');
	   
	   $('.tooltip').tooltip("close");
   }).on('scroll',function(){
    $('.ui-tooltip').remove();
  });
   
if($("#fo_table_evho").length){
 fo_table_evho_elsoki();
}else{//Ekkor tabozni kell
 fotab();
}
chrome_tab_change();

//setInterval(elekkuld,1000*60*20);//20percenként élek..

elekkuld_indit();
//setInterval(elekkuld,1200000);//20percenként élek..

}).on("contextmenu",function(){
 return false;
}).on('keyup',function(e) {
 //if(e.keyCode == 27){
 if(e.key == 'Escape'){
  
  var _ethis_dialog=$('#dialog');
  var _ethis_dialog_egyeni=$('#dialog_egyeni_close');

  if((_ethis_dialog.dialog('isOpen'))&&(_ethis_dialog_egyeni.dialog('isOpen'))){
   _ethis_dialog.dialog('close');
   
   return true;
  }else{
   $("#dialog,#dialog2,#dialog_egyeni_close").dialog('close');
  }
 }// esc
});

var title_orig="";
function fotab(){
var t_id="";
var vane_aktiv_tab="";
$("#tabs_fo").tabs({

create: function(){
 //t_id=ui.tab.attr("aria-controls"); 
 title_orig=document.title;
 $("#tabs_fo").css("display","block");
 fotab_indul_ful("");
 if(vane_aktiv_tab==""){//Nincs tab, history akkor is kell
	 updateURLParameter("mit","");
 }
},
beforeActivate: function( e, ui ){
 t_id=ui.newPanel[0].id;
 vane_aktiv_tab="1";
 updateURLParameter("mit",t_id);
 ful_betolt(t_id);
}
});
 
}

function tab_hattervalt(hova){
if(hova=='kek'){
 $(".ui-tabs .ui-tabs-panel").css('background-color','#A6CFF5');
 //$(".ui-tabs-panel").css('box-shadow','3px 3px 10px #95caf9').css('border','1px ridge #f7f7ff');
 $(".ui-tabs-panel").css({'box-shadow':'3px 3px 10px #95caf9','border':'1px ridge #f7f7ff'});
}else{
 $(".ui-tabs .ui-tabs-panel").css('background-color','#fafafa');
 //$(".ui-tabs-panel").css('box-shadow','').css('border','');
 $(".ui-tabs-panel").css({'box-shadow':'','border':''});
}
}

var ajax_keres_ful_betolt_post=null;
function ful_betolt_post(id){

if(ajax_keres_ful_betolt_post!=null){
 ajax_keres_ful_betolt_post.abort();
}

ajax_keres_ful_betolt_post=$.post(ajaxstat_p_ut,"mod=ful_letolt&ful="+id,
	function(d){
	ajax_keres_ful_betolt_post=null;
	$('.ui-tooltip').remove();
	//d1=d.split("$;$");
	var d1ok=d.slice(0,2);
	var d1hasz=d.slice(5);
	//if(d.slice(0,2)=="ok" && d1[1]!="" ){
	if($('#'+id).length){
	if(d1ok=="ok" && d1hasz!=""){
	
	if(id!="ful_admin"){
	 tab_hattervalt('');	
	}
	
	gi(id).innerHTML=d1hasz;
	//$("#"+id).html(d1hasz);
	alap_input_select_most();
	
	if(id=='ful_rogzit'){
		ful_rogzit();
	}else if(id=='ful_rogzit_jovahagy'){
		ful_rogzit_jovahagy();
	}else if(id=='ful_riport'){
	 ful_riport();
	}else if(id=='ful_stat'){
		ful_stat();
	//if(id=='ful_admin')ful_admin();
	
	}else if(id=="ful_admin"){
	document.title=title_orig+" - Admin";
	if(admin_muv_akt_ful!="" && admin_muv_akt_ful!="keremv"){
		$("#admin_muvelet").val(admin_muv_akt_ful);
		admin_muv_sel();
		
	}else{
		
		if($("#admin_muvelet").val()!="keremv"){
		 admin_muv_sel();
		}
	}
	}
	
	//}else if(d1[0]=="nologin"){
	}else if(d=="logout" || d1ok=="nologin"){
	 location.reload();
	}else{
		$("#"+id).html("");
		alert("Rendszerhiba! "+d);
	}
	}
	},"text");
}

var admin_muv_akt_ful="";
var akt_ful="";
function ful_betolt(id){

//Admin művelet megjegyzése length
if(id=="ful_admin" && $("#admin_muvelet").length){//Ekkor van admin művelet select
 admin_muv_akt_ful=$("#admin_muvelet").val();
}

if(akt_ful!='')
 $("#"+akt_ful).html("");

akt_ful=id;

//$(".div_ablakok").not("#"+id).html("");//Többi tartalom üresítése

//$("img[id^=refresimg_]").each(function(){
$("img[id^=refresimg_]:not(#refresimg_"+id+")").each(function(){
 $(this).css("display","none");
});

$("#refresimg_"+id).css("display","inline");
ful_betolt_post(id);
//iktatido_kulon_felt();
}

function fotab_indul_ful(){
var params={};
params.mit="";
window.location.search
  .replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str,key,value) {
    params[key] = value;
  }
);
//if(params.mit!=""){
if(params.mit=="ful_rogzit" ||params.mit=="ful_rogzit_jovahagy" ||params.mit=="ful_stat" ||params.mit=="ful_riport" ||params.mit=="ful_admin"){
 var ujindex_ell = $('#tabs_fo li').index($('#tabs_'+params.mit));
 if(ujindex_ell<=0){
  ujindex_ell=0;
  //var fullidt=$('#tabs_fo li:first').attr("id");
  var fullidt=$('#tabs_fo li').first().attr("id");//emre
  var tabidf=fullidt.split("_");
  if(tabidf[3]===undefined)
   var elso_ful_id=tabidf[1]+"_"+tabidf[2];
  else
   var elso_ful_id=tabidf[1]+"_"+tabidf[2]+"_"+tabidf[3];
  ful_betolt(elso_ful_id);
  updateURLParameter("mit",elso_ful_id);
 }
  $('#tabs_fo').tabs( "option", "active",ujindex_ell);
//}else if(params.mit=="") {
}else{
$('#tabs_fo').tabs({ active:0});
var df=$("#tabs_fo .ui-tabs-panel:visible").attr("id");
ful_betolt(df);
}

}


function elekkuld_indit(){
//	Régi megoldás
//setInterval(elekkuld,1200000);//20percenként élek

// --- BEÁLLÍTÁSOK ---
    //const KEEPALIVE_URL = 'e.php'; // A PHP fájl, ami fenntartja a sessiont
    const PERC_20 = 1200000; // 20 perc millisecondban

// A funkció, ami elvégzi a kérést (ezt hívjuk meg a workerből és a fallbackből is)
    //function sessionMentes() {
        //$.get("e.php");
        //$.post(KEEPALIVE_URL, { ping: 1 })
            //.done(function() {
            //    console.log("Session Keep-Alive OK: " + new Date().toLocaleTimeString());
            //})
            //.fail(function() {
                //console.log("Hiba a szerver elérésében.");
            //});
   // }
	

    // --- WORKER LÉTREHOZÁSA MEMÓRIÁBAN ---
    
    // Ellenőrizzük, támogatja-e a böngésző a Workert (Edge, Chrome, FF: IGEN)
    if (window.Worker) {
        
        try {
            // Ez a kód fog futni a háttérszálon. 
            // Fontos: Itt a változókat beleégetjük a szövegbe (${PERC_20})
            //const workerKod = `
                //const interval = ${PERC_20};
              //  setInterval(() => {
            //        postMessage('tick');
           //     }, interval);
           // `;
			
			const workerKod = "const interval = " + PERC_20 + "; setInterval(() => { postMessage('tick'); }, interval);";

            // Létrehozzuk a "virtuális fájlt" (Blob)
            const blob = new Blob([workerKod], { type: 'application/javascript' });
            const workerUrl = URL.createObjectURL(blob);

            // Elindítjuk a Workert
            const myWorker = new Worker(workerUrl);

            //console.log("Web Worker (memória-alapú) elindítva.");

            // Ha jelez a worker, mentünk
            myWorker.onmessage = function() {
                //sessionMentes();
				elekkuld();
            };

        } catch (e) {
            // Ha valamiért mégis elhasalna a worker létrehozása, jöhet a "B" terv
            //console.warn("Hiba a worker indításakor, visszaváltás setIntervalra.");
            //setInterval(sessionMentes, PERC_20);
			setInterval(elekkuld,1200000);
        }

    } else {
        // --- FALLBACK (RÉGI BÖNGÉSZŐK) ---
        //console.log("A böngésző nem támogatja a Web Workert. Hagyományos mód.");
        //setInterval(sessionMentes, PERC_20);
		setInterval(elekkuld,1200000);
    }

}


var elekkuldh=0;
function elekkuld(){
if(elekkuldh<66){
elekkuldh++;
$.get("e.php");
}
}


/*
function fo_table_ev_change(){
ev=$("#sel_melyik_ev option:selected").val();

$.post(ajaxstat_p_ut,"mod=fo_table_ev_change&ev="+ev,
	function(d){
	d1=d.split("$;$");
	if(d1[0]=="ok"){
		$("#fo_table_evho").html(d1[1]);
		fo_table_ki();
	}else{
	 alert("Hiba");
	}
});	
}
*/

var ajax_keres_fo_table_evho_elsoki=null;
function fo_table_evho_elsoki(){//Ez az első lekérés

if(ajax_keres_fo_table_evho_elsoki!=null){
 ajax_keres_fo_table_evho_elsoki.abort();
}

ajax_keres_fo_table_evho_elsoki=$.post(ajaxstat_p_ut,"mod=fo_table_evho_elsoki",
	function(d){
	ajax_keres_fo_table_evho_elsoki=null;
	//if($('#fo_table_evho').length){
	if(typeof akt_ful==="undefined" || akt_ful==""){//Ekkor tabozni kell
	//if(typeof akt_ful==="undefined" || akt_ful=="")
	//d1=d.split("$;$");
	//if(d1[0]=="ok"){
	if(d.slice(0,2)=="ok"){
		//gi("fo_table_evho").innerHTML=d1[1];
		//$("#fo_table_evho").html(d1[1]);

		//fo_table_ki();
		///////gi("fo_div_notab").innerHTML=d.slice(5);
		
		if($('#fo_div_notab').length){
		 gi("fo_div_notab").innerHTML=d.slice(5);
		}else//if($('#ful_rogzit').length)
		 gi("ful_rogzit").innerHTML=d.slice(5);	
		
		//$("#fodiv").html(d1[2]);
		ful_rogzit();
		
		
	}else if(d=="logout"){
		location.reload();
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	}
},"text");	
}

var ajax_keres_fo_table_ki=null;
function fo_table_ki(){
var ev=encodeURIComponent($("#sel_melyik_ev").val());//option:selected
var ho=encodeURIComponent($("#sel_melyik_ho").val());
var nap=encodeURIComponent($("#sel_melyik_nap").val());

if($("#sel_helyettes_valaszt").length ) {
 var hely_user_ad=encodeURIComponent($("#sel_helyettes_valaszt").val());
}else{
 var hely_user_ad="";
}

//$("#fodiv").html("");
var _self_tilt=$(".sel_proj,.input_time,.link_cktavollet,.rogzit_megj_textarea,#sel_melyik_ev,#sel_melyik_ho,#sel_melyik_nap,#sel_melyik_holezargomb,#sel_helyettes_valaszt,#gomb_helyettes_beallit");
_self_tilt.prop("disabled",true);

//$("input,select,textarea").prop("disabled",true);

if(ajax_keres_fo_table_ki!=null){
 ajax_keres_fo_table_ki.abort();
}

ajax_keres_fo_table_ki=$.post(ajaxstat_p_ut,"mod=fo_table_ki&ev="+ev+"&ho="+ho+"&nap="+nap+"&hely_user_ad="+hely_user_ad,
	function(d){
	ajax_keres_fo_table_ki=null;
	//d1=d.split("$;$");
	//if(d1[0]=="ok"){
	if(d.slice(0,2)=="ok"){
		
		//if(d1[1]!="")//Év váltás esetén
		 //gi("fo_table_evho").innerHTML=d1[1];
		 //$("#fo_table_evho").html(d1[1]);
		//else
		 
		if($('#fo_div_notab').length)
		 gi("fo_div_notab").innerHTML=d.slice(5);
		else// if($('#ful_rogzit').length)
		 gi("ful_rogzit").innerHTML=d.slice(5);	
		//gi("fodiv").innerHTML=d1[2];
		//$("#fodiv").html(d1[2]);
		ful_rogzit();
		_self_tilt.prop("disabled",false);
	}else{
	 alert("Hiba");
	}
},"text");

}


function input_kevesebb(_self){

var valm=_self.val();
var len=valm.length;

if(len==5){
 var elso_negyed=3;
}else if(len==4){
 var elso_negyed=2;	
}else{
 return false;
}

var kijelolve_start=_self.prop("selectionStart");
var kijelolve_end=_self.prop("selectionEnd");//2-óra 5-Perc
//if(kijelolve_start<3){//1 óra plusz
if(kijelolve_start<elso_negyed){//1 óra plusz

//step=_self.prop("step");
//step=lepes_step;
//lep_ora=60/(step/60000);
//var lep_ora=60/(lepes_step/60000);
if(lepes_step==10)
 var lep_ora=6;
else
 var lep_ora=60/(lepes_step/60000);
//lep_ora=6;

_self.timespinner( "stepDown",lep_ora);
}else{//1 perc plusz
 _self.timespinner( "stepDown","1");
}

//var valm=_self.val();

/*if(uj_leng=valm.length==4 && len==5){
 kijelolve_end=1;
}*/

var val_ora=_self.val().split(":");
//var val_ora=valm.split(":");
if(kijelolve_start==0){
if(Number(val_ora[0])>=10){
 kijelolve_start=0;
 kijelolve_end=2;
}else{
 kijelolve_start=0;
 kijelolve_end=1;	
}
}else{//Perc van kijelölve
if(Number(val_ora[0])>=10){
 kijelolve_start=3;
 kijelolve_end=5;
}else{
 kijelolve_start=2;
 kijelolve_end=4;
}
}

//_self.focus().prop({'selectionStart':kijelolve_start,'selectionEnd':kijelolve_end});
_self.trigger("focus").prop({'selectionStart':kijelolve_start,'selectionEnd':kijelolve_end});
	
}

function input_tobb(_self){

var valm=_self.val();
var len=valm.length;

if(len==5){
 var elso_negyed=3;
}else if(len==4){
 var elso_negyed=2;	
}else{
 return false;
}

var kijelolve_start=_self.prop("selectionStart");
var kijelolve_end=_self.prop("selectionEnd");//2-óra 5-Perc

if(kijelolve_start<elso_negyed){//1 óra plusz

//step=_self.prop("step");
//step=lepes_step;
//lep_ora=60/(step/60000);
//var lep_ora=60/(lepes_step/60000);
if(lepes_step==10)
 var lep_ora=6;
else
 var lep_ora=60/(lepes_step/60000);
//lep_ora=6;

 _self.timespinner( "stepUp",lep_ora);
}else{//1 perc plusz
 _self.timespinner( "stepUp","1");
}


/*uj_leng=_self.val().length;
if(uj_leng==5)
 $(_self).mask('00:00');
else
 $(_self).mask('0:00');*/
 

 //val_ora=valm.split(":");
 var val_ora=_self.val().split(":");
 //var val_ora=valm.split(":");
if(kijelolve_start==0){


if(Number(val_ora[0])>9){
 kijelolve_start=0;
 kijelolve_end=2;
}else{
 kijelolve_start=0;
 kijelolve_end=1;	
}
}else{//perc van kijelölve
 kijelolve_end=4;
if(Number(val_ora[0])>9){
 kijelolve_start=3;
 kijelolve_end=5;
}else{
 kijelolve_start=2;
 kijelolve_end=4;
}
}

//_self.focus().prop({'selectionStart':kijelolve_start,'selectionEnd':kijelolve_end});
_self.trigger("focus").prop({'selectionStart':kijelolve_start,'selectionEnd':kijelolve_end});

return false;
}

var updateURLParameter_mar_futott="";
function updateURLParameter(param, paramVal){
	var url=window.location.href;
    var TheAnchor = null;
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";
//console.log("updateURLParameter:"+param);
    if (additionalURL) 
    {
        var tmpAnchor = additionalURL.split("#");
        var TheParams = tmpAnchor[0];
            TheAnchor = tmpAnchor[1];
        if(TheAnchor)
            additionalURL = TheParams;

        tempArray = additionalURL.split("&");

        for (var i=0; i<tempArray.length; i++)
        {
            if(tempArray[i].split('=')[0] != param)
            {
                //newAdditionalURL += temp + tempArray[i];
                newAdditionalURL +=  tempArray[i]+temp;
                temp = "&";
            }
        }        
    }
    else
    {
        var tmpAnchor = baseURL.split("#");
        var TheParams = tmpAnchor[0];
            TheAnchor  = tmpAnchor[1];

        if(TheParams)
            baseURL = TheParams;
    }
				
    if(TheAnchor)
        paramVal += "#" + TheAnchor;

    //var rows_txt = temp + "" + param + "=" + paramVal;
    var rows_txt = "" + param + "=" + paramVal;
    //return baseURL + "?" + newAdditionalURL + rows_txt;
	if(paramVal!=""){
	if(newAdditionalURL!="")
		newAdditionalURL="&"+newAdditionalURL;
	var new_url=baseURL + "?" + rows_txt + newAdditionalURL;
	}else{
		new_url=baseURL;
	}
	if(updateURLParameter_mar_futott==""){//Első futásnál csere kell
	 window.history.replaceState('', '',new_url);
	 updateURLParameter_mar_futott=1;
	}else{//Aztán már csak hozzáadás
	 window.history.pushState('', '',new_url);
	}
}

function autocomplete_off(){
$('input').attr('autocomplete','off');
$('.disabled_auto_fill').attr('autocomplete','chrome-off');
}

function number_only(){
  autocomplete_off();

  $(document)
    .off('paste.numberonly keydown.numberonly', 'input[type=text]:not(.number_penz_2tizedes):not(.number_penz), textarea')
    .on('paste.numberonly', 'input[type=text]:not(.number_penz_2tizedes):not(.number_penz), textarea', function (e) {
      var f = e.originalEvent.clipboardData.getData('Text');
      if (f != '') {
        var _this = $(this);
        setTimeout(function () {
          _this.val(function () {
            return this.value.replaceAll("'", " ").replaceAll('"', " ").replaceAll("`", " ");
          });
        }, 0);
      }
    })
    .on('keydown.numberonly', 'input[type=text]:not(.number_penz_2tizedes):not(.number_penz), textarea', function (event) {
      var code = event.keyCode;
      if (event.shiftKey && (code == 49 || code == 50 || code == 55)) {
        event.preventDefault();
      }
    });

  $(document)
    .off('keydown.numberonly2', '.number')
    .on('keydown.numberonly2', '.number', function (event) {
      var e = event.keyCode;
      if (e == 17) return;
      if (
        e == 35 || e == 36 || e == 86 || e == 37 || e == 39 ||
        e == 116 || e == 13 || e == 46 || e == 8 || e == 9 ||
        (e >= 96 && e <= 105)
      ) {
        return;
      }
      if (e < 48 || e > 57) {
        event.preventDefault();
      }
    });
}

/*
function number_only_old(){

//All input autocomplete=off
//$('input,:input').attr('autocomplete','off');
autocomplete_off();

$("input[type=text]:not(.number_penz_2tizedes):not(.number_penz),textarea").on("paste",function(e) {
 var f=e.originalEvent.clipboardData.getData('Text');
 if(f!=''){
  var _this = $(this); 
	 
	 setTimeout(function () {
			_this.val(function(){
				return this.value.replaceAll("'"," ").replaceAll('"'," ").replaceAll("`"," "); 
			})
		},0);
		
		//setTimeout(function () {
		//	var a=_this.val().replaceAll("'"," ").replaceAll('"'," ").replaceAll("`"," ");
		//	_this.val(a);
		//},0);
		
		
 }
}).on("keydown",function(event) {
var code=event.keyCode;
//console.log(code);
 if((event.shiftKey) &&(code==49 || code==50 || code==55)){//' " `
	event.preventDefault(); 
 }
});

//$(".number").keydown(function(event) {
$(".number").on("keydown",function(event) {
var e=event.keyCode;
if(e!=17)
        if (( e==35 || e==36 || e==86||e==37||e==39||e==116||e==13||e==46||e==8||e==9)||(e>=96&&e<=105)) {//188 190 67 88 86
            // let it happen, don't do anything
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (e< 48 ||e>57) {
                event.preventDefault(); 
            }   
        }
});

}
*/

function tooltip_proc(){
setTimeout(function(){
		//console.time();
		$('.ui-tooltip').remove();
		
		tooltip_proc_s();
		//console.timeEnd();
	},0);
}

//.ui-helper-hidden-accessible eltüntetése - eleje
//globálisan kell futtatni jueryui betöltése után, tooltip előtt.
// Ellenőrizzük, hogy betöltődött-e a jQuery UI Tooltip
if ($.ui && $.ui.tooltip) {

    // Kiterjesztjük (felülírjuk) a gyári Tooltip widgetet
    $.widget("ui.tooltip", $.ui.tooltip, {
        
        // Felülírjuk a létrehozó (_create) metódust
        _create: function() {
            // 1. Lefuttatjuk az eredeti logikát (hogy a gombok működjenek, eventek felépüljenek)
            this._super();

            // 2. A HACK:
            // Az eredeti kód létrehozta a this.liveRegion-t és betette a body-ba.
            // Mi most azonnal kivesszük, és ami fontosabb: "kiüresítjük" a változót.
            if (this.liveRegion) {
                this.liveRegion.remove(); // Kivesszük a DOM-ból
                this.liveRegion = $();    // Egy üres jQuery objektumra cseréljük
            }
        },

        // Opcionális: Ha nagyon biztosra akarsz menni, hogy a 'close' esemény se keressen semmit
        // Bár a fenti (this.liveRegion = $()) miatt ez általában nem kell, mert a jQuery
        // metódusok (pl. .html(), .hide()) üres objektumon hívva nem dobnak hibát.
    });
}
//.ui-helper-hidden-accessible eltüntetése - vége

function tooltip_proc_s(){
//$('.multi-select-menuitem,#admin_szolgkapadat_mod_proc_urlap_valt li,#admin_szolgmodadat_mod_proc_urlap_valt li,.ttooltip,.jovavissza_img,.jovaok_img,.spanlezar_ures_tev,.jovahagyo_ered_td,.proj_span,.select2-results__options,.pdf_ikon_rogz,.xlsx_ikon_rogz,.select2-selection__rendered,.linkm_tooltip,.linkimg_tooltip,.pir_vas_tooltip,.link,.link_pir,.link_pir_vas,.link_fek_vas,.del_img').tooltip({

var _sel='.multi-select-menuitem,#admin_szolgkapadat_mod_proc_urlap_valt li,#admin_szolgmodadat_mod_proc_urlap_valt li,.ttooltip,.jovavissza_img,.jovaok_img,.spanlezar_ures_tev,.proj_span,.select2-results__options,.pdf_ikon_rogz,.xlsx_ikon_rogz,.select2-selection__rendered,.linkm_tooltip,.linkimg_tooltip,.pir_vas_tooltip,.link,.link_pir,.link_pir_vas,.link_fek_vas,.del_img';
//$('.multi-select-menuitem,#admin_szolgkapadat_mod_proc_urlap_valt li,#admin_szolgmodadat_mod_proc_urlap_valt li,.ttooltip,.jovavissza_img,.jovaok_img,.spanlezar_ures_tev,.proj_span,.select2-results__options,.pdf_ikon_rogz,.xlsx_ikon_rogz,.select2-selection__rendered,.linkm_tooltip,.linkimg_tooltip,.pir_vas_tooltip,.link,.link_pir,.link_pir_vas,.link_fek_vas,.del_img').tooltip({

$(_sel).filter(function () {
    return !$(this).data('ui-tooltip');
  }).tooltip({
 //create: function(ev, ui) {
 /*create: function() {
      $(this).data("ui-tooltip").liveRegion.remove();
   },*/

content:function(){
//return $(this).prop('title');
return this.getAttribute("title");
},
track:true,
/*p1osition: { my: "left top+25", at: "right center" },*/
position: { my: "left+5 top+25", at: "right center",collision: "flipfit" },
show: false,
hide: false,

    open: function(event, ui) {
        var tooltip = ui.tooltip;
        var winHeight = $(window).height();
        var tooltipHeight = tooltip.outerHeight();
        
        // Ha nagyon magas, korlátozzuk + scroll
        if (tooltipHeight > winHeight * 0.8) {
            tooltip.css({
                'max-height': (winHeight * 0.8) + 'px',
                'overflow-y': 'auto',
                'font-size': '13px'
            });
        }
    }

//}).tooltip({


});

//$(".ui-helper-hidden-accessible").remove();

}

function pdf_export_akt_user(){
$("<form target=_blank id='pdf_export_akt_user' method=post action='pdf/'><input type='hidden' id='xlsx_export_akt_user_ho_egyedi' name='mod_egyedi' value='xlsx_export_akt_user'><input type='hidden' id='file_form_user' name='user' value='akt'><input type='hidden' id='file_form_idoszak_ev' name='idoszak_ev' value=''><input type='hidden' id='file_form_idoszak_ho' name='idoszak_ho' value=''></form>").appendTo('body').trigger("submit").remove();
}

function xlsx_export_akt_user(user_ad,ev,ho){
$("<form target=_top id='pdf_export_akt_user' method=post action='excel_export/excel_export.php'><input type='hidden' id='xlsx_export_akt_user_ho_egyedi' name='mod_egyedi' value='xlsx_export_akt_user'><input type='hidden' id='user_ad' name='user_ad' value='"+encodeURIComponent(user_ad)+"'><input type='hidden' id='xlsx_export_akt_user_ev' name='ev' value='"+encodeURIComponent(ev)+"'><input type='hidden' id='xlsx_export_akt_user_ho' name='ho' value='"+encodeURIComponent(ho)+"'></form>").appendTo('body').trigger("submit").remove();
}

function excel_export(id,th){
if(th>100000){
 var d="<b>Hiba</b><br><br>Excel exportálás nem lehetséges!<br>Maximum 100.000 db találati lista exportálható!";
diaglog_open(d,"Hiba");
}else{

var fajta=$("#"+id).attr("fajta");
//////$("#kimeno_excel_export_open_fajta_id").val(fajta);

var egyeni_id1='';

if(fajta=="user_helyettes"){
 egyeni_id1=user_modhelyettes_hozz_keress_par();
}else if(fajta=="szerv_jovahagyo"){
 egyeni_id1=admin_modszervjovahagyo_hozz_keress_par();
}else if(fajta=="felettes_jovahagyo"){
 egyeni_id1=admin_moduserfelettesjovahagyas_hozz_keress_par();
}else if(fajta=="projekthez_user"){
 egyeni_id1=admin_moduser_hozz_keress_par();
}else if(fajta=="projekthez_userjovahagyo"){
 egyeni_id1=admin_moduserjovahagyo_hozz_keress_par();
 
}else if(fajta=="admin_userlist_keres"){
 egyeni_id1=admin_userlist_keres_par();
}else if(fajta=="admin_szervlist_keres"){
 egyeni_id1=admin_szervlist_keres_par();
}else if(fajta=="admin_projektlist_keres"){
 egyeni_id1=admin_projektlist_keres_par();
}else if(fajta=="userhez_projekt"){
 egyeni_id1=admin_moduserprojekt_hozz_keress_par();
}else if(fajta=="userhez_projektjovahagyo"){
 egyeni_id1=admin_moduserprojektjovahagyo_hozz_keress_par();
}else if(fajta=="userhez_stat_projekt"){
 egyeni_id1=admin_moduser_stat_projekt_hozz_keress_par();
}else if(fajta=="admin_szervezethez_projekt_rend"){
 egyeni_id1=admin_modproj_hozz_keress_par();
}else if(fajta=="admin_szervezetben_user"){
 egyeni_id1=$("#szervezetben_user_szerv_id").val();
}else if(fajta=="admin_szervezethez_projekt"){
 egyeni_id1=admin_modszerv_hozz_keress_par();
}else if(fajta=="admin_tagvkodlist_keres"){
 egyeni_id1=admin_tagvkodlist_keres_par();
}else if(fajta=="admin_szolgkodlist_keres"){
 egyeni_id1=admin_szolgkodlist_keres_par();
}else if(fajta=="admin_csopnevlist_keres"){
 egyeni_id1=admin_csopnevlist_keres_par();
}else if(fajta=="admin_katnevlist_keres"){
 egyeni_id1=admin_katnevlist_keres_par();
}else if(fajta=="admin_kapcstorzslist_keres"){
 egyeni_id1=admin_kapcstorzslist_keres_par();
}else if(fajta=="admin_kapcstulajlist_keres"){
 egyeni_id1=admin_kapcstulajlist_keres_par();
}else if(fajta=="admin_kapcsosszelist_keres"){
 egyeni_id1=admin_kapcsosszelist_keres_par();
}else if(fajta=="admin_tenypotlaslist_keres"){
 egyeni_id1=admin_tenypotlaslist_keres_par();
}else if(fajta=="admin_szerztipuslist_keres"){
 egyeni_id1=admin_szerztipuslist_keres_par();
}else if(fajta=="admin_szerzalapadatlist_keres"){
 egyeni_id1=admin_szerzalapadatlist_keres_par();
}else if(fajta=="admin_szolgkapadatlist_keres"){
 egyeni_id1=admin_szolgkapadatlist_keres_par();
}else if(fajta=="admin_szolgmodadatlist_keres"){
 egyeni_id1=admin_szolgmodadatlist_keres_par();
}else if(fajta=="admin_tigadatsapszamlist_keres"){
 egyeni_id1=admin_tigadatsapszamlist_keres_par();
}else if(fajta=="admin_tigadatcolist_keres"){
 egyeni_id1=admin_tigadatcolist_keres_par();
}else if(fajta=="admin_integadatlist_keres"){
 egyeni_id1=admin_integadatlist_keres_par();
}else if(fajta=="admin_szolgcsoplist_keres"){
 egyeni_id1=admin_szolgcsoplist_keres_par();
}else if(fajta=="admin_szolgcsophozszolgkodlist_keres"){
 egyeni_id1=admin_szolgcsoplist_keres_par();
}else if(fajta=="admin_elsztipuslist_keres"){
 egyeni_id1=admin_elsztipuslist_keres_par();
}else if(fajta=="admin_nattipuslist_keres"){
 egyeni_id1=admin_nattipuslist_keres_par();
}else if(fajta=="admin_szerzusergazdalist_keres"){
 egyeni_id1=admin_szerzusergazdalist_keres_par();
}else if(fajta=="admin_tarskatlist_keres"){
 egyeni_id1=admin_tarskatlist_keres_par();
}else if(fajta=="admin_arazasreflist_keres"){
 egyeni_id1=admin_arazasreflist_keres_par();
}else if(fajta=="admin_szerzfeltoltlist_keres"){
 egyeni_id1=admin_szerzfeltoltlist_keres_par();
}else if(fajta=="admin_kpiszolgkodlist_keres"){
 egyeni_id1=admin_kpiszolgkod_keres_par();
}else if(fajta=="admin_kpitipuslist_keres"){
 egyeni_id1=admin_kpitipus_keres_par();
}else if(fajta=="admin_kpiosszekaplist_keres"){
 egyeni_id1=admin_kpiosszekaplist_keres_par();
}else if(fajta=="admin_loglist_keres"){
 egyeni_id1=admin_loglist_keres_par();
}else if(fajta=="admin_ujszolgkapadatprojektlist_keres"){
 egyeni_id1=admin_ujszolgkapadatprojektadd_hozz_keress_par();
}else if(fajta=="admin_tigadatvevoazonlist_keres"){
 egyeni_id1=admin_tigadatvevoazonlist_keres_par();
}else if(fajta=="admin_tigadatnemszerzlist_keres"){
 egyeni_id1=admin_tigadatnemszerzlist_keres_par();
}else if(fajta=="admin_tenypotlastiglist_keres"){
 egyeni_id1=admin_szolgkodlist_keres_par();
}else{
	 diaglog_open("Fejlesztés alatt!<br>id: "+id+"<br>th: "+th+"<br>fajta: "+fajta,"Hiba");
	 return false;
 }

//$("#kimeno_excel_export_open_form").trigger("submit");

$("<form target=_parent id='kimeno_excel_export_open_form' method=post action='excel_export/excel_export.php'><input type='hidden' id='kimeno_excel_export_open_fajta_id' name='fajta_id' value='"+fajta+"'><input type='hidden' id='kimeno_excel_export_open_egyeni_id1' name='egyeni_id1' value='"+egyeni_id1+"'></form>").appendTo('body').trigger("submit").remove();

}
}

//Ez a másohdik paramétert tenné hozzá..

function ess_ido_konv(){
var _this_div=$("#ess_ido_konv_div");
if(_this_div.css("display")=="none"){
 _this_div.css("display","inline");
 $("#ess_ido_konv_ess_in").trigger("focus");
}else{
 _this_div.css("display","none");
 $("#ess_ido_konv_ess_in").val("");
 $("#ess_ido_konv_ered").html("");
}
}

function ess_ido_konv_ess(){
var v=$("#ess_ido_konv_ess_in").val();
if(v!=""){
 var d1=v.split(",");
 if(typeof d1[1]!=="undefined"){
	if(d1[1]!="" && d1[1]!="0"){
	 var perc_t=0+Number(d1[1]);
	 var perc=perc_t/(100/60);
	 var perc_ki=Math.round(perc);
	 if(perc_ki<10)perc_ki="0"+perc_ki;
	}else{
		var perc_ki="00";
	}
	$("#ess_ido_konv_ered").html(d1[0]+":"+perc_ki);
 }else{
	$("#ess_ido_konv_ered").html(v); 
 }
}

}


var ajax_keres_jovahagy_infok_leker=null;
function jovahagy_infok_leker(user_ad,ev,ho){

if(ajax_keres_jovahagy_infok_leker!=null){
 ajax_keres_jovahagy_infok_leker.abort();
}

ajax_keres_jovahagy_infok_leker=$.post(ajaxstat_p_ut,"mod=jovahagy_infok_leker&user_ad="+user_ad+"&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_jovahagy_infok_leker=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#jovahagy_infok_"+user_ad).html(d1[1]);
	}
	},"text");
}

function jovahagy_infok_leker_kuka(user_ad){
$("#jovahagy_infok_"+user_ad).html("");
}


function open_kitolt_utm(){
$('<form target=_top action="./" method=POST><input type="hidden" name="doc_open" value="open_kitolt_utm"></form>').appendTo('body').trigger("submit").remove();
}

function open_felh_kezi(){
$('<form target=_blank action="./" method=POST><input type="hidden" name="doc_open" value="open_felh_kezi"></form>').appendTo('body').trigger("submit").remove();
}

function open_jovah_kezi(){
$('<form target=_blank action="./" method=POST><input type="hidden" name="doc_open" value="open_jovah_kezi"></form>').appendTo('body').trigger("submit").remove();
}

function open_stat_kezi(){
$('<form target=_blank action="./" method=POST><input type="hidden" name="doc_open" value="open_stat_kezi"></form>').appendTo('body').trigger("submit").remove();
}

/*
function select2_torles_def(id,mire){
var _this=$('#'+id);
if(_this.hasClass("select2-hidden-accessible")){
  if(mire!='')
   _this.select2('destroy').val(mire);
  else
   _this.select2('destroy');
 //$('#userfizmodjogcim_jogcimek_id_hozzid_keress').val($("#target option:first").val());
 $('#'+id+' option:not(:selected)').remove();
}
}
*/

/*
function select2_torles_noselected(id){
var _this=$('#'+id);
_this.select2('destroy');
$('#'+id+' option:not(:selected)').remove();
//select2_ajax();
}
*/

function emre_keres_oldalas_ker_par_uj(id_honnan,hol_lep,holvagyok){
return emre_keres_oldalas_ker_par(id_honnan,hol_lep,holvagyok+"_keres_tal_oldalholvagyok",holvagyok+"_keres_tal_oldalmax",holvagyok+"_keres_talszam",holvagyok+"_keres_proc");
}

function emre_keres_oldalas_ker_par(id_honnan,hol_lep,oldalholvagyok_id,oldalmax_id,talszam_id,keres_fug){
//$("#"+keres_fug+"_tallep_elso,#"+keres_fug+"_tallep_elozo,#"+keres_fug+"_tallep_kov,#"+keres_fug+"_tallep_ut").prop("disabled",true);
$("#"+keres_fug+"_tallep_elso,#"+keres_fug+"_tallep_elozo,#"+keres_fug+"_tallep_kov,#"+keres_fug+"_tallep_ut,#"+talszam_id).prop("disabled",true);

var _this_oldalholvagyok=$("#"+oldalholvagyok_id);
//if(_this_oldalholvagyok.val()!==undefined){
var oldalholvagyok=0;
if(_this_oldalholvagyok.length){
 oldalholvagyok=Number(_this_oldalholvagyok.val());
}

var _this_oldalmax=$("#"+oldalmax_id);
var hanyoldal=1;//Nincs jelentősége
if(_this_oldalmax.val()!==undefined)
 hanyoldal=Number(_this_oldalmax.val());


var _this_talszam=$("#"+talszam_id);
//if(_this_talszam.val()!==undefined){
var talszam=5;
if(_this_talszam.length){
 talszam=Number(_this_talszam.val());
}

if(id_honnan!=""){
switch(id_honnan) {
  case "tallep_elso":
    oldalholvagyok=0;
  break;
  case "tallep_elozo":
    oldalholvagyok=oldalholvagyok-talszam;
  break;
  case "tallep_kov":
    oldalholvagyok=oldalholvagyok+talszam;
  break;
  case "tallep_ut":
	oldalholvagyok=(hanyoldal-1)*talszam;
  break;
  /*default:

  break;*/
}
}

//Lépegetésnél előző oldal előtt talászám növelés ne lehessne minusz!
if(oldalholvagyok<0)oldalholvagyok=0;

//Rendezés - eleje
var order="";
if(id_honnan=="order"){
  order=hol_lep;
}
//Rendezés - vége

var ker_par="&order="+encodeURIComponent(order)+"&oldalholvagyok="+encodeURIComponent(oldalholvagyok)+"&"+talszam_id+"="+encodeURIComponent(talszam);
return ker_par;
}

function dialog_kerdes(gomb_igen,title_ki,d,func_igen,func_nem){
	
	// 1. Létrehozzuk az üres buttons objektumot
    var dialogButtons = {};

	// 2. Ha a gomb_igen NEM üres, akkor adjuk hozzá az ÖSSZES gombot
    if (gomb_igen !== '') {

        // Hozzáadjuk a dinamikus gombot (gomb_igen)
        dialogButtons = {
            [gomb_igen]: {
                click: function () {
                    $(this).dialog('widget').find('button').prop('disabled', true);
                    func_igen();
                },
                'text': gomb_igen,
                'class': 'submit2'
            }
        };

        // Hozzáadjuk a "Mégse" gombot
        dialogButtons["Mégse"] = {
            click: function () {
                $(this).dialog("close");
            },
            'text': 'Mégse',
            'class': 'submit2'
        };
    } 
    // Ha gomb_igen üres (== ''), a dialogButtons objektum üres marad, azaz {}
	
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	
	buttons: dialogButtons, // Ha gomb_igen üres, ez az opció: buttons: {} lesz
	/*
	buttons: {
		
		gomb_igen:{
                    click: function () {
					 $(this).dialog('widget').find('button').prop('disabled',true);
					 func_igen();
                    },
                    'text': gomb_igen,
                    'class': 'submit2'
		
		},
		"Mégse":{
                    click: function () {
                     $(this).dialog("close");
                    },
                    'text': 'Mégse',
                    'class': 'submit2'
		
		},
		
      },*/
	  	open: function (event, ui){
		if(gomb_igen=='Törlés'){
		 $(".ui-dialog-title").html("<img src='image/del_behajtani16.png'> "+title_ki);
		}
        $("#ui-widget-overlay").fadeIn();
		tooltip_proc();
      },
        close: function() {
		$(this).dialog('widget').find('button').prop('disabled',false);
		if(
		(!$(this).dialog('isOpen')) &&
		(!$('#dialog').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
		
		//if (typeof func_nem !== 'undefined') {
		if (func_nem && typeof func_nem === 'function') {
				// A func_nem paraméter meg van adva.
				// Itt futtathatod: func_nem();
				func_nem(); 
		}
        }
	}).dialog( "open" );
}


function letoltes_excel_ajax(gomb_id,formData,url){
 var _this_gomb=$("#"+gomb_id);
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

	/*
    // Űrlap adatainak összegyűjtése
    var formData = {
        tipus: 'proj_beszkoz'
    };
	*/
	
 // AJAX kérés indítása
    $.ajax({
        //url: "riport/riport_leker.php", // A szerveroldali PHP fájl elérési útja
        url: url, // A szerveroldali PHP fájl elérési útja
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

function isFunction(func){
    return typeof func === "function";
  }

function reload_disabled(){
$(".sel_proj,.input_time,.link_cktavollet,.rogzit_megj_textarea,#sel_melyik_ev,#sel_melyik_ho,#sel_melyik_holezargomb,#sel_helyettes_valaszt,#gomb_helyettes_beallit").prop("disabled",true);
location.reload();
}

/*
function indit_titkos_dolog(event){
if (event.ctrlKey) {
        inditTetrisz(event);
    }
}

var ajax_keres_inditTetrisz=null;
function inditTetrisz(event) {
  if (event && event.preventDefault) event.preventDefault();
  ajax_keres_inditTetrisz = $.post(ajaxstat_p_ut, "mod=inditTetrisz", function (d) {
    ajax_keres_inditTetrisz = null;
    if (d == "ok$;$") inditTetrisz_proc();
    else diaglog_open(d, "Rendszerhiba");
  }, "text");
  return false;
}
function inditTetrisz_proc() {
  $.getScript("tetrisz/tetrisz-indit.js").done(function () {
    if (typeof tetriszIndit === "function") tetriszIndit();
  });
  return false;
}
*/

/*
function post_sajat(url, params, callback, dataType) {
    // A 'dataType' itt csak kompatibilitás miatt van, a kód text-ként kezel mindent.
    
    const controller = new AbortController();
    const signal = controller.signal;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
            'X-Requested-With': 'XMLHttpRequest', // PHP felismeri, hogy AJAX
            'Accept': 'text/plain, *' + '/*; q=0.01'
        },
        body: params,
        signal: signal,
        credentials: 'same-origin' // Session cookie kezelése
    })
    .then(response => {
        if (!response.ok) { 
            // 404, 500 és egyéb szerver hibák elkapása
            throw new Error("HTTP hiba: " + response.status); 
        }
        return response.text(); 
    })
    .then(data => {
        if (callback) callback(data);
    })
    .catch(error => {
        // Csak a valódi hibákat logoljuk, a megszakítást (abort) nem
        if (error.name !== 'AbortError') {
            console.error('AJAX Hiba:', error);
            // Ide jöhet: diaglog_open("Hálózati hiba történt", "Hiba");
        }
    });

    return {
        abort: () => controller.abort()
    };
}
*/