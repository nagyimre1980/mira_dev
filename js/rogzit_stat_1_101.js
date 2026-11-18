
function ful_stat(){//Fül betöltése után fut le..
document.title=title_orig+" - Statisztika";

//Tab váltáskor is nullázni kell
stat_szur_projekt_futot=0;
stat_szur_szerv_futot=0;
stat_szur_user_futot=0

$("#stat_leker_projekt_id").on('mouseover', function(){
inp_auto_start_stat_szur_projekt();
}).maximizeSelect2Height({
cushion: 20 //Beállíthatja, hogy mennyi extra hely maradjon a nyitott legördülő menü széle és a nézetablak széle között a következő opcióval cushion
});

$("#stat_leker_szerv_id").on('mouseover', function(){
inp_auto_start_stat_szur_szerv();
}).maximizeSelect2Height({
cushion: 20 //Beállíthatja, hogy mennyi extra hely maradjon a nyitott legördülő menü széle és a nézetablak széle között a következő opcióval cushion
});

$("#stat_leker_user").on('mouseover', function(){
inp_auto_start_stat_szur_user();
}).maximizeSelect2Height({
cushion: 20 //Beállíthatja, hogy mennyi extra hely maradjon a nyitott legördülő menü széle és a nézetablak széle között a következő opcióval cushion
});

/*		
inp_auto_start_stat_szur_projekt();
inp_auto_start_stat_szur_szerv();
inp_auto_start_stat_szur_user();
*/
stat_leker();
nap_beallit();
}

function duplastat_scrool_bar(){
    if($("#stat_ered_table").length){
	 $("#scroll1 div").width($("#stat_ered_table").outerWidth(true));
	}else{
     $("#scroll1 div").width('0');
	}
	
    var ignoreScroll_stat = false; // Zászló a végtelen ciklus ellen
	$("#scroll1").on("scroll", function(){
		 if (!ignoreScroll_stat) {
         ignoreScroll_stat = true;
         $("#scroll2").scrollLeft($(this).scrollLeft());
        
         // Hagyunk egy pici időt, majd levesszük a zászlót
         requestAnimationFrame(function(){
            ignoreScroll_stat = false;
         });
		}
    });
    $("#scroll2").on("scroll", function(){
		 if (!ignoreScroll_stat) {
         ignoreScroll_stat = true;
         $("#scroll1").scrollLeft($(this).scrollLeft());
        
         requestAnimationFrame(function() {
            ignoreScroll_stat = false;
         });
		}
    });
}

/*
function duplastat_scrool_bar(){
if($("#stat_ered_table").length){
    //$("#scroll1 div").width($("#stat_ered_table").width());
    $("#scroll1 div").width(gi("stat_ered_table").scrollWidth);
    $("#scroll1").on("scroll", function(){
        $("#scroll2").scrollLeft($(this).scrollLeft()); 
    });
    $("#scroll2").on("scroll", function(){
        $("#scroll1").scrollLeft($(this).scrollLeft()); 
    });
}else{//Ekkor nem kell látni!
	$("#scroll1 div").width("0");
}
}
*/

var ajax_keres_stat_leker=null;
function stat_leker(){

//Ha nyitva van és elveszik a jogát...
if(!$("#stat_leker_tipus").length){
return false;
}

var idoszak_tipus=encodeURIComponent($("#stat_leker_tipus").val());

if(idoszak_tipus=="projekt_napi" || idoszak_tipus=="projekt_szerv" || idoszak_tipus=="reszletes" || idoszak_tipus=="reszletes2"){
 $('#stat_leker_kiuser option[value="nem_rogzitett"]').prop("disabled",true);	
}else{
 $('#stat_leker_kiuser option[value="nem_rogzitett"]').prop("disabled",false);
}


if($("#stat_leker_kiuser").val()=="nem_rogzitett"){
 //$("#stat_leker_projekt_id").val("all").prop("disabled",true);
 select2_torles_def('stat_leker_projekt_id','all');
 $("#stat_leker_projekt_id").prop("disabled",true);
 
}

if(idoszak_tipus=="user_napi" || idoszak_tipus=="napi_user"){
 $("#max_user_div").css("display","inline");
}else{
 $("#max_user_div").css("display","none");
}

var idoszak_ev=encodeURIComponent($("#stat_leker_ev").val());
var idoszak_ho=encodeURIComponent($("#stat_leker_ho").val());
var idoszak_nap=encodeURIComponent($("#stat_leker_nap").val());
var szerv_id=encodeURIComponent($("#stat_leker_szerv_id").val());
var projekt_id=encodeURIComponent($("#stat_leker_projekt_id").val());
var kiuser=encodeURIComponent($("#stat_leker_kiuser").val());
var user=encodeURIComponent($("#stat_leker_user").val());

var par="&idoszak_ev="+idoszak_ev+"&idoszak_ho="+idoszak_ho+"&idoszak_nap="+idoszak_nap+"&idoszak_tipus="+idoszak_tipus+"&kiuser="+kiuser+"&szerv_id="+szerv_id+"&user="+user+"&projekt_id="+projekt_id;


//Lekérés előtt minden submit és select tiltása
//$("#stat_xlsx_leker_submit,select").prop("disabled",true);
//var _this_sel=$("#stat_xlsx_leker_submit,#stat_leker_ev,#stat_leker_ho,#stat_leker_nap,#stat_leker_tipus,#stat_leker_kiuser,#stat_leker_projekt_id,#stat_leker_szerv_id,#stat_leker_user,#max_user_select");
//var _this_sel_full=$("#stat_xlsx_leker_submit,#stat_leker_ev,#stat_leker_ho,#stat_leker_nap,#stat_leker_tipus,#stat_leker_kiuser,#stat_leker_szerv_id,#stat_leker_projekt_id,#stat_leker_user,#max_user_select");
//var _this_sel=$("#stat_xlsx_leker_submit,#stat_leker_ev,#stat_leker_ho,#stat_leker_nap,#stat_leker_tipus,#stat_leker_kiuser,#stat_leker_szerv_id,#stat_leker_user,#max_user_select");
$("#stat_xlsx_leker_submit,#stat_leker_ev,#stat_leker_ho,#stat_leker_nap,#stat_leker_tipus,#stat_leker_kiuser,#stat_leker_szerv_id,#stat_leker_projekt_id,#stat_leker_user,#max_user_select").prop("disabled",true);

if(ajax_keres_stat_leker!=null){
 ajax_keres_stat_leker.abort();
}

ajax_keres_stat_leker=$.post(ajaxstat_p_ut,"mod=stat_leker"+par,
	function(d){
	ajax_keres_stat_leker=null;
	gi("stat_ered_div").innerHTML=d;
	//gi("stat_ered_div").setHTMLUnsafe(d);
	stat_tablesort_init_van=0;
	duplastat_scrool_bar();

	 //Lekérés után minden submit és select engedélyezése
	 if($("#stat_leker_kiuser").val()!="nem_rogzitett"){
	  $("#stat_leker_projekt_id").prop("disabled",false);
	  stat_szur_projekt_futot=0;
	  inp_auto_start_stat_szur_projekt();
	 }
	 $("#stat_xlsx_leker_submit,#stat_leker_ev,#stat_leker_ho,#stat_leker_nap,#stat_leker_tipus,#stat_leker_kiuser,#stat_leker_szerv_id,#stat_leker_user,#max_user_select").prop("disabled",false);
	},"text");
}

var stat_tablesort_init_van=0;
function stat_tablesort_katt(_this){
//console.log("katt:"+event.target);
if(stat_tablesort_init_van==0){
 $('#stat_ered_table_first_th').css("text-decoration",""); 
 stat_tablesort_init();
 $(_this).trigger("click");
}
}


function stat_tablesort_init(){
stat_tablesort_init_van=1;
	  $("#stat_ered_table").tablesorter({
			 headers: {
            0: {
                sorter: 'text'
			 }},
			 sortLocaleCompare : true,
			 initWidgets:false,
			 emptyTo: 'emptyMin',//Üres a tetejére asc esetén.
			 sortList:[[0,0]]
		});
}

function stat_xlsx_leker() {
    
	// Eredeti gomb szöveg mentése
    var originalText = $("#stat_xlsx_leker_submit").val();
	
	// Gomb letiltása
    $("#stat_xlsx_leker_submit").prop("disabled", true);


// Animáció időzítő
    var dots = 0;
    var loadingAnimation = setInterval(function() {
        dots = (dots + 1) % 4; // 0, 1, 2, 3, majd vissza 0-ra
        var dotText = ".".repeat(dots);
        $("#stat_xlsx_leker_submit").val(originalText + dotText);
    }, 500); // 500ms-onként frissül a pontok száma

    // Űrlap adatainak összegyűjtése  option:selected
    var formData = {
        idoszak_ev: $("#stat_leker_ev").val(),
        idoszak_ho: $("#stat_leker_ho").val(),
        idoszak_nap: $("#stat_leker_nap").val(),
        idoszak_tipus: $("#stat_leker_tipus").val(),
        kiuser: $("#stat_leker_kiuser").val(),
        user: $("#stat_leker_user").val(),
        szerv_id: $("#stat_leker_szerv_id").val(),
        projekt_id: $("#stat_leker_projekt_id").val()
    };

    // AJAX kérés indítása
    $.ajax({
        url: "excel_export/excel_export.php", // A szerveroldali PHP fájl elérési útja
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
            $("#stat_xlsx_leker_submit").val(originalText);
			
            // Gomb újraaktiválása
            $("#stat_xlsx_leker_submit").prop("disabled", false);
        },
        error: function (xhr, status, error) {
            
			// Animáció leállítása és eredeti szöveg visszaállítása
            clearInterval(loadingAnimation);
            $("#stat_xlsx_leker_submit").val(originalText);
			
			// Hiba esetén is aktiváljuk a gombot, és jelezhetjük a hibát
            console.error("Hiba történt: ", error);
            $("#stat_xlsx_leker_submit").prop("disabled", false);
            alert("Hiba történt az exportálás során!");
        }
    });

    return false; // Megakadályozza az alapértelmezett eseményt (pl. űrlap elküldését)
}

/*
function stat_xlsx_leker_old(){
$("#stat_xlsx_leker_submit").prop("disabled",true);
//$("#stat_ered_div").css("display","none").html("");
var ev=encodeURIComponent($("#stat_leker_ev option:selected").val());
var ho=encodeURIComponent($("#stat_leker_ho option:selected").val());
var nap=encodeURIComponent($("#stat_leker_nap option:selected").val());
var tipus=encodeURIComponent($("#stat_leker_tipus option:selected").val());
var kiuser=encodeURIComponent($("#stat_leker_kiuser option:selected").val());
var user=encodeURIComponent($("#stat_leker_user option:selected").val());
var szerv_id=encodeURIComponent($("#stat_leker_szerv_id option:selected").val());
var projekt_id=encodeURIComponent($("#stat_leker_projekt_id option:selected").val());

//$("#stat_form_ev").val(ev);
//$("#stat_form_ho").val(ho);
//$("#stat_form_nap").val(nap);
//$("#stat_form_szerv_id").val(szerv_id);
//$("#stat_form_projekt_id").val(projekt_id);
//$("#stat_form_tipus").val(tipus);
//$("#stat_form_kiuser").val(kiuser);
//$("#stat_form_user").val(user);

//$("#stat_export_form").trigger("submit");

$("<form target=_parent id='stat_export_form' method=post action='excel_export/excel_export.php'><input type='hidden' id='stat_form_ev' name='idoszak_ev' value='"+ev+"'><input type='hidden' id='stat_form_ho' name='idoszak_ho' value='"+ho+"'><input type='hidden' id='stat_form_nap' name='idoszak_nap' value='"+nap+"'><input type='hidden' id='stat_form_szerv_id' name='szerv_id' value='"+szerv_id+"'><input type='hidden' id='stat_form_projekt_id' name='projekt_id' value='"+projekt_id+"'><input type='hidden' id='stat_form_tipus' name='idoszak_tipus' value='"+tipus+"'><input type='hidden' id='stat_form_kiuser' name='kiuser' value='"+kiuser+"'><input type='hidden' id='stat_form_user' name='user' value='"+user+"'></form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#stat_xlsx_leker_submit").prop("disabled",false);
},3);
}
*/

$.wait = function( callback, seconds){
   return window.setTimeout( callback, seconds * 1000);
}

/*
function stat_leker_tipus_change(){
tipus=$("#stat_leker_tipus option:selected").val();

if(tipus=="reszletes" || tipus=="reszletes2"){//Részletest csak Excelben lehet....
 //$("#stat_leker_submit").prop("disabled",true);
 $("#stat_ered_div").css("display","none").html("");
}else{
 stat_leker();
 //$("#stat_leker_submit").prop("disabled",false);
}

}
*/

function stat_leker_szerv_id_change(){


$('#stat_leker_user').val("all");
if(stat_szur_user_futot==1){
 stat_szur_user_futot=0;
 inp_auto_start_stat_szur_user();
}

stat_leker();

//ful_stat();
}

function stat_leker_projekt_id_change(){
stat_leker();
}

function stat_leker_kiuser_change(){
stat_leker();
}

function stat_leker_user_change(){
stat_leker();
}

var ajax_keres_stat_leker_ev_change=null;
function stat_leker_ev_change(){
//stat_leker();
//nap_beallit();

//Ha év változik, akkor az egész fül újratöltődik speciális módon
//ELküldjük az év módosítást, majd fül újratöltése
//;

var idoszak_ev=encodeURIComponent($("#stat_leker_ev").val());

if(ajax_keres_stat_leker_ev_change!=null){
 ajax_keres_stat_leker_ev_change.abort();
}

ajax_keres_stat_leker_ev_change=$.post(ajaxstat_p_ut,"mod=stat_leker_ev_change&idoszak_ev="+idoszak_ev,
	function(d){
	ajax_keres_stat_leker_ev_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 ful_betolt(akt_ful);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
 },"text");
 
}

function stat_leker_excelsubmit_value_change(){
if($("#stat_leker_ho").val()=='all'){
 $("#stat_xlsx_leker_submit").val('Excel csv statisztika letöltése');
}else{
 $("#stat_xlsx_leker_submit").val('Excel statisztika letöltése');
}
}

function stat_leker_ho_change(){
stat_leker_excelsubmit_value_change();


select2_torles_def('stat_leker_projekt_id',$('#stat_leker_projekt_id').val());
if(stat_szur_projekt_futot==1){
 stat_szur_projekt_futot=0;
 inp_auto_start_stat_szur_projekt();
}

select2_torles_def('stat_leker_user','all');
//Hónap váltás esetén is el kell kérni a user listát, de csak ha futott
if(stat_szur_user_futot==1){
 stat_szur_user_futot=0;
 inp_auto_start_stat_szur_user();
}

stat_leker();
nap_beallit();
}

function stat_leker_nap_change(){
stat_leker();
}

function nap_beallit(){
var ev=$("#stat_leker_ev").val();
var ho=$("#stat_leker_ho").val();
var nap=$("#stat_leker_nap").val();
//alert(nap);

var d = daysInMonth(ho,ev);

if(ho=="all"){
	$('#stat_leker_nap').val("all");
	for (let i = 1; i <= 31; i++) {
	 $('#stat_leker_nap option[value="'+i+'"]').css("display","none");
	}

}else{

	for (let i = 1; i <= 27; i++) {
	 $('#stat_leker_nap option[value="'+i+'"]').css("display","inline");
	}

for (let i = 28; i <= Number(d); i++) {
 //$('#stat_leker_nap option[value="'+i+'"]').prop("disabled",false);
 $('#stat_leker_nap option[value="'+i+'"]').css("display","inline");
}

for (let i = (Number(d)+1); i <= 31; i++) {
 //$('#stat_leker_nap option[value="'+i+'"]').prop("disabled",true);
 $('#stat_leker_nap option[value="'+i+'"]').css("display","none");
 if(nap==i){
	$("#stat_leker_nap").val("all"); 
 }
}

}

}

function daysInMonth(iMonth, iYear){
    return new Date(iYear, iMonth, 0).getDate();
}

var ajax_keres_max_user_change=null;
function max_user_change(){

//Lekérés előtt minden submit és select tiltása
$("#stat_xlsx_leker_submit,select").prop("disabled",true);
var max_user=encodeURIComponent($("#max_user_select").val());

if(ajax_keres_max_user_change!=null){
 ajax_keres_max_user_change.abort();
}

ajax_keres_max_user_change=$.post(ajaxstat_p_ut,"mod=max_user_change&max_user="+max_user,
	function(d){
	ajax_keres_max_user_change=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 ful_betolt(akt_ful);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
 },"text");
}

var stat_szur_projekt_futot=0;
function inp_auto_start_stat_szur_projekt(){
if(stat_szur_projekt_futot==0){
stat_szur_projekt_futot=1;
var m_this=$('#stat_leker_projekt_id');
var sel_val=m_this.val();
if(typeof sel_val==="undefined")
  sel_val="";

var idoszak_ev=encodeURIComponent($("#stat_leker_ev").val());
var idoszak_ho=encodeURIComponent($("#stat_leker_ho").val());

 $.ajax({
                url: 'search_stat.php',
                dataType: 'json',
                type: "POST",
                delay: 0,
               data: {mod:"stat_leker_projekt_stat",q:"",sel:sel_val,idoszak_ev:idoszak_ev,idoszak_ho:idoszak_ho},
		success: function(returnedData) {

			m_this.select2({
				dropdownAutoWidth : true,
				 maximumInputLength:50,
				  language: "hu",
				dropdownCssClass: "bigdrop",
				matcher: function(params, data) {
				 return matchStart(params, data);
				},
				
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
            // Open the Select2.
			if (m_this.is(":focus"))
             m_this.select2('open');
        }
    });

/*m_this.on('select2:open',function(){
	setTimeout(function(){
		document.querySelector('.select2-search__field').focus();
	}, 50);//add this line
	
  })*/
}
}

/*
function inp_auto_start_stat_szur_projekt_old(){
 var m_this=$('#stat_leker_projekt_id');
 var sel_val=m_this.val();
 if(typeof sel_val==="undefined")
  sel_val="";
 $.ajax({
                url: 'search_stat.php',
                dataType: 'json',
                type: "POST",
                delay: 0,
               data: {mod:"stat_leker_projekt_stat",q:"",sel:sel_val},
        success: function(returnedData) {
            m_this.select2({
				dropdownAutoWidth : true,
				 maximumInputLength:50,
				  language: "hu",
				
				matcher: function(params, data) {
				 return matchStart(params, data);
				},
 
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
            // Open the Select2.
			if (m_this.is(":focus"))
             m_this.select2('open');
        }
    });

m_this.on('select2:open',function(){
    $("#stat_leker_szerv_id,#stat_leker_user").select2("close");
	document.querySelector('.select2-search__field').focus();
	//tooltip_proc();
  });
}
*/

var stat_szur_szerv_futot=0;
function inp_auto_start_stat_szur_szerv(){
if(stat_szur_szerv_futot==0){
stat_szur_szerv_futot=1;
var m_this=$('#stat_leker_szerv_id');
var sel_val=m_this.val();
if(typeof sel_val==="undefined")
  sel_val="";

 $.ajax({
                url: 'search_stat.php',
                dataType: 'json',
                type: "POST",
                delay: 0,
               data: {mod:"stat_leker_szerv_stat",q:"",sel:sel_val},
		success: function(returnedData) {

			m_this.select2({
				dropdownAutoWidth : true,
				 maximumInputLength:50,
				  language: "hu",
				dropdownCssClass: "bigdrop",
				matcher: function(params, data) {
				 return matchStart(params, data);
				},
				
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
            // Open the Select2.
			if (m_this.is(":focus"))
             m_this.select2('open');
        }
    });

/*m_this.on('select2:open',function(){
	setTimeout(function(){
		document.querySelector('.select2-search__field').focus();
	}, 50);//add this line
	
  })*/
}
}

/*
function inp_auto_start_stat_szur_szerv_old(){
 var m_this=$('#stat_leker_szerv_id');
 var sel_val=m_this.val();
 if(typeof sel_val==="undefined")
  sel_val="";
 $.ajax({
                url: 'search_stat.php',
                dataType: 'json',
                type: "POST",
                delay: 0,
               data: {mod:"stat_leker_szerv_stat",q:"",sel:sel_val},
        success: function(returnedData) {
            m_this.select2({
				dropdownAutoWidth : true,
				 maximumInputLength:50,
				  language: "hu",
				
				matcher: function(params, data) {
				 return matchStart(params, data);
				},
 
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
            // Open the Select2.
			if (m_this.is(":focus"))
             m_this.select2('open');
        }
    });

m_this.on('select2:open',function(){
	//Minden más select bezárása
	$("#stat_leker_user,#stat_leker_projekt_id").select2("close");
    document.querySelector('.select2-search__field').focus();
	//tooltip_proc();
  });
}
*/

var stat_szur_user_futot=0;
function inp_auto_start_stat_szur_user(){
if(stat_szur_user_futot==0){
stat_szur_user_futot=1;
var m_this=$('#stat_leker_user');
var sel_val=m_this.val();
if(typeof sel_val==="undefined")
 sel_val="";
var szerv_id=encodeURIComponent($("#stat_leker_szerv_id").val());
var ev=encodeURIComponent($("#stat_leker_ev").val());
var ho=encodeURIComponent($("#stat_leker_ho").val());

 $.ajax({
                url: 'search_stat.php',
                dataType: 'json',
                type: "POST",
                delay: 0,
               data: {mod:"stat_leker_user_stat",q:"",sel:sel_val,ev: ev,ho: ho,szerv_id: szerv_id},
		success: function(returnedData) {
//m_this.empty();
			m_this.select2({
				dropdownAutoWidth : true,
				 maximumInputLength:50,
				  language: "hu",
				dropdownCssClass: "bigdrop",
				matcher: function(params, data) {
				 return matchStart_tart(params, data);
				},
				
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
            // Open the Select2.
			if (m_this.is(":focus"))
             m_this.select2('open');
        }
    });

/*m_this.on('select2:open',function(){
	setTimeout(function(){
		document.querySelector('.select2-search__field').focus();
	}, 50);//add this line
	
  })*/
}
}

/*
function inp_auto_start_stat_szur_user_old(){

$('#stat_leker_user').select2({
 dropdownAutoWidth : true,
 maximumInputLength:50,
placeholder: "Kérem válassz",
   "language": {
       "noResults": function(){
           return "Nincs találat.";
       }
   },
escapeMarkup: function (markup) { return markup; },
ajax: {
                url: 'search_stat.php',
                dataType: 'json',
                type: "POST",
                delay: 0,
                data: function (params) {
					if(typeof params.term!=="undefined")
					 var q_ki=encodeURIComponent(params.term);
					else var q_ki="";
					//nap=$("#"+this[0].id).attr("nap");
					var sel_val=$("#"+this[0].id+" option:selected").val();
					//sel_text=$("#"+this[0].id+" option:selected").text();
					if(typeof sel_val==="undefined")
					  sel_val="";
					var szerv_id=encodeURIComponent($("#stat_leker_szerv_id option:selected").val());
					var ev=encodeURIComponent($("#stat_leker_ev option:selected").val());
					var ho=encodeURIComponent($("#stat_leker_ho option:selected").val());
                    return {
                        mod:"stat_leker_user_stat",
                        q: q_ki,
                        sel: sel_val,
						ev: ev,
                        ho: ho,
                        szerv_id: szerv_id
                        //sel_text: sel_text,
						//,nap:nap
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            },
});



//Első jó megoldás

//$(document).on('select2:open', () => {
$('#stat_leker_user').on('select2:open',function(){
    $("#stat_leker_szerv_id,#stat_leker_projekt_id").select2("close");
	document.querySelector('.select2-search__field').focus();
	//tooltip_proc();
  });
}
*/