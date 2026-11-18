
function ful_rogzit_jovahagy(){//Fül betöltése után fut le..
document.title=title_orig+" - Jóváhagyás";
inp_auto_start_jovahagy_szur_user();
jovahagy_keress();
}

function duplajovahagyo_scrool_bar(){
    $("#scroll1 div").width($("#table_jovahagyo").outerWidth(true));
    var ignoreScroll_jovahagyo = false; // Zászló a végtelen ciklus ellen
	$("#scroll1").on("scroll", function(){
		 if (!ignoreScroll_jovahagyo) {
         ignoreScroll_jovahagyo = true;
         $("#scroll2").scrollLeft($(this).scrollLeft());
        
         // Hagyunk egy pici időt, majd levesszük a zászlót
         requestAnimationFrame(function(){
            ignoreScroll_jovahagyo = false;
         });
		}
    });
    $("#scroll2").on("scroll", function(){
		 if (!ignoreScroll_jovahagyo) {
         ignoreScroll_jovahagyo = true;
         $("#scroll1").scrollLeft($(this).scrollLeft());
        
         requestAnimationFrame(function() {
            ignoreScroll_jovahagyo = false;
         });
		}
    });
}

/*
function duplajovahagyo_scrool_bar(){
    $("#scroll1 div").width($("#table_jovahagyo").width());
    $("#scroll1").on("scroll", function(){
        $("#scroll2").scrollLeft($(this).scrollLeft()); 
    });
    $("#scroll2").on("scroll", function(){
        $("#scroll1").scrollLeft($(this).scrollLeft()); 
    });
}
*/

function tooltip_proc_jovahagy(){
$('.jovahagyo_ered_td').tooltip({

 //create: function(ev, ui) {
 create: function() {
      $(this).data("ui-tooltip").liveRegion.remove();
   },

 //open: function(event,ui){//Amíg nincs adat el kell rejteni!
 
 open: function(){//Amíg nincs adat el kell rejteni!
   //$(".ui-tooltip").css("visibility","hidden");
   $(".ui-tooltip").css("display","none");
 },

content:function(){
return $(this).prop('title');
},
track:true,
position: { my: "left top+25", at: "right center" },
show: false,
hide: false
});
}

var ajax_keres_jovahagy_evvalt=null;
function jovahagy_evvalt(){
var par=jovahagy_keress_par();
$("#jovahagy_melyik_szerv,#jovahagy_melyik_ev,#jovahagy_melyik_ho,#jovahagy_melyik_user").prop("disabled",true);
$(".select2-container--default .select2-selection--single .select2-selection__rendered").css("color","#4A4A4A");

//$.post(ajaxstat_p_ut,"mod=jovahagy_evvalt"+ker_par+par,

if(ajax_keres_jovahagy_evvalt!=null){
 ajax_keres_jovahagy_evvalt.abort();
}

ajax_keres_jovahagy_evvalt=$.post(ajaxstat_p_ut,"mod=jovahagy_evvalt"+par,
 function(d){
  ajax_keres_jovahagy_evvalt=null;
  if(d.slice(0,2)=="ok"){
	//$("#jovahagyas_ered_div").html("");
	$("#jovahagyas_szurered_div").html(d.slice(5));
	inp_auto_start_jovahagy_szur_user();
	jovahagy_keress();
	
	 //$("#jovahagy_melyik_szerv,#jovahagy_melyik_ev,#jovahagy_melyik_ho,#jovahagy_melyik_user").prop("disabled",false);
	 //$(".select2-container--default .select2-selection--single .select2-selection__rendered").css("color","#000");

  }else{
	 diaglog_open(d,"Rendszerhiba");	
  }  
 });
}

function jovahagy_keress_par(){

if(
(!$("#jovahagy_melyik_ev").length)||
(!$("#jovahagy_melyik_ho").length)||
(!$("#jovahagy_melyik_user").length)
){
 diaglog_open("Mezőhiány","Rendszerhiba");
 return false;
}

var szerv_id=encodeURIComponent($("#jovahagy_melyik_szerv").val());

var szerv_id_all="";
$("#jovahagy_melyik_szerv option").each(function() {
        var v=encodeURIComponent($(this).val());
		if(v!="all" && v!="all_f" && v.slice(0,8)!="projekt_"){
		 szerv_id_all+=v+"-";
		}
    });

var szerv_nev=encodeURIComponent($("#jovahagy_melyik_szerv option:selected").text());
var jovahagy_melyik_ev=encodeURIComponent($("#jovahagy_melyik_ev").val());
var jovahagy_melyik_ho=encodeURIComponent($("#jovahagy_melyik_ho").val());
var jovahagy_melyik_user=encodeURIComponent($("#jovahagy_melyik_user").val());
var par="&szerv_nev="+szerv_nev+"&szerv_id="+szerv_id+"&szerv_id_all="+szerv_id_all+"&jovahagy_melyik_ev="+jovahagy_melyik_ev+"&jovahagy_melyik_ho="+jovahagy_melyik_ho+"&jovahagy_melyik_user="+jovahagy_melyik_user;
return par;
}

var ajax_keres_jovahagy_keress=null;
function jovahagy_keress(){

//Ha nyitva van és elveszik a jogát...
if(!$("#jovahagy_melyik_szerv").length){
return false;
}

//ker_par="&order="+order+"&oldalholvagyok="+oldalholvagyok+"&userlist_keres_talszam="+userlist_keres_talszam
var ker_par="";

var par=jovahagy_keress_par();

$("#jovahagy_melyik_szerv,#jovahagy_melyik_ev,#jovahagy_melyik_ho,#jovahagy_melyik_user").prop("disabled",true);
$(".select2-container--default .select2-selection--single .select2-selection__rendered").css("color","#4A4A4A");

if(ajax_keres_jovahagy_keress!=null){
 ajax_keres_jovahagy_keress.abort();
}

ajax_keres_jovahagy_keress=$.post(ajaxstat_p_ut,"mod=jovahagy_keress"+ker_par+par,
	function(d){
	ajax_keres_jovahagy_keress=null;
	//d1=d.split("$;$");
	//d1=d.split("$;$");
	//if(d1[0]=="ok"){
	if($('#jovahagyas_ered_div').length){
	if(d.slice(0,2)=="ok"){
	 gi("jovahagyas_ered_div").innerHTML=d.slice(5);
	 //$("#jovahagyas_ered_div").html(d.slice(5));
	 
	 duplajovahagyo_scrool_bar();
	 //$("#table_jovahagyo").css("display","inline");
	 
	 //inp_auto_start_jovahagy_szur_user();
	 $("#jovahagy_melyik_szerv,#jovahagy_melyik_ev,#jovahagy_melyik_ho,#jovahagy_melyik_user").prop("disabled",false);
	 $(".select2-container--default .select2-selection--single .select2-selection__rendered").css("color","#000");
	 tooltip_proc();
	 
	 setTimeout(function(){tooltip_proc_jovahagy();},0);
	 
	 jovahagyuser_sor_mouse_bekapcs();
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	}
	},"text");
}

function jovahagyuser_sor_mouse_bekapcs(){
//$('td[class=jovahagyo_ered_td]').each(function(){
	 
  $(".jovahagyo_ered_td").on("mouseover",function(){
	var id=this.id;
	var _self=$(this);
	var ttip=_self.attr("ttip");
	if(ttip==""){
	 //$(".ui-tooltip").css("visibility","hidden");
	 var _self_p=$(this).parent();
	
	 var projekt_jovahagyas_id=encodeURIComponent(_self_p.attr("projekt_jovahagyas_id"));
	 var user_ad=encodeURIComponent(_self_p.attr("user_ad"));
	 var ev=encodeURIComponent(_self_p.attr("ev"));
	 var ho=encodeURIComponent(_self_p.attr("ho"));
	 var nap=encodeURIComponent(_self.attr("nap"));
	 jovahagyuser_sor_mouse(projekt_jovahagyas_id,user_ad,ev,ho,nap,id,_self);
	}else{
		//$("#ttip_"+id).html(_self.attr("title_b"));
	 _self.attr('title',_self.attr("title_b"));
		
	 setTimeout(function(){$(".ui-tooltip").css("display","block");},0);
		 
	 //console.log(ttip);
	 //$("#ttip_"+id).html(ttip);
	 //console.log($("#ttip_"+id).html());
	}
  });
//});
}

var ajax_keres_jovahagyuser_sor_mouse=null;
function jovahagyuser_sor_mouse(projekt_jovahagyas_id,user_ad,ev,ho,nap,id,_self){
//Adatok lekérése

var user_nev=encodeURIComponent($("#jovahagysor_user_nev_"+user_ad).html());

if(ajax_keres_jovahagyuser_sor_mouse!=null){
 ajax_keres_jovahagyuser_sor_mouse.abort();
}

ajax_keres_jovahagyuser_sor_mouse=$.post(ajaxstat_p_ut,"mod=jovahagyuser_sor_mouse&projekt_jovahagyas_id="+projekt_jovahagyas_id+"&user_ad="+user_ad+"&ev="+ev+"&ho="+ho+"&nap="+nap+"&user_nev="+user_nev,
	function(d){
	ajax_keres_jovahagyuser_sor_mouse=null;
	//d1=d.split("$;$");
	if(d.slice(0,2)=="ok"){
	 var d1_fejlec='<div style="text-align:center" class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle"><span id="ui-id-1" class="ui-dialog-title">Rögzítés részletezése</span></div>';
	 //d1[1]=d1_fejlec+d1[1];
	 var ki_str=d1_fejlec+d.slice(5);
	 //$("#ttip_"+id).html(d1[1]);
	 $("#ttip_"+id).html(ki_str);
	 //$(".ui-tooltip").css("visibility","visible");
	 $(".ui-tooltip").css("display","block");
	 _self.attr("ttip",'1').attr("title_b",ki_str);
	}
	});
}

var ajax_keres_jovahagy_proc_visszakuld_projvezeto=null;
function jovahagy_proc_visszakuld_projvezeto(user_ad,alkalom,projekt_jovahagyas_id){
var _this_ho=$("#jovahagy_melyik_ho option:selected");
var ev=$("#jovahagy_melyik_ev option:selected").val();
var ho=_this_ho.val();
if(Number(ho)<10)
 var visszakuld_ho=ev+"-0"+ho;
else var visszakuld_ho=ev+"-"+ho;

if(ajax_keres_jovahagy_proc_visszakuld_projvezeto!=null){
 ajax_keres_jovahagy_proc_visszakuld_projvezeto.abort();
}

ajax_keres_jovahagy_proc_visszakuld_projvezeto=$.post(ajaxstat_p_ut,"mod=jovahagy_proc_visszakuldheto_e&visszakuld_ho="+visszakuld_ho,
	function(d){
	ajax_keres_jovahagy_proc_visszakuld_projvezeto=null;
	if(d=="ok$;$"){
	 jovahagy_proc_visszakuld_projvezeto_kerd_elott(user_ad,alkalom,projekt_jovahagyas_id);
	}else{
	 diaglog_open(d,"Hiba!");	
	}
 });
}

function jovahagy_proc_visszakuld_projvezeto_kerd_elott(user_ad,alkalom,projekt_jovahagyas_id){
var user_nev=$("#jovahagysor_user_nev_"+user_ad).html();
var ev=$("#jovahagy_melyik_ev option:selected").val();
var _this_ho=$("#jovahagy_melyik_ho option:selected");
var ho=_this_ho.val();
var ho_str=_this_ho.text();


var title_ki="Visszaküldés: "+user_nev+", "+alkalom+". alkalommal";
var d="<b>Biztos, hogy visszaküldöd módosításra "+user_nev+" "+ev+". "+ho_str+" havi munkaidő rögzítését?</b>";
	d+="<br><br>Megjegyzés:<br>";
	d+="<textarea style='width:700px' rows='6' id='jovahagy_proc_visszakuld_projvezeto_textarea'></textarea>";
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Igen": function() {
		 jovahagy_proc_visszakuld_projvezeto_kerd_utan(ev,ho,user_ad,alkalom,projekt_jovahagyas_id);
        },
        "Mégse": function() {
          $(this).dialog("close");
        }
      },
	  	open: function (event, ui){
		$(".ui-dialog-title").html("<img src='image/del_behajtani16.png'> "+title_ki);
		//$("#dialog_egyeni_close").dialog("option","position",{my:"center",at:"center",of:window}).dialog("option","width","auto");
        $("#ui-widget-overlay").fadeIn();
		jovahagy_sor_szinez_be(user_ad);
		autosize($("#jovahagy_proc_visszakuld_textarea"));
		$(".ui-tooltip").css("visibility","hidden");
      },
        close: function() {
		if(
		(!$('#dialog_egyeni_close').dialog('isOpen')) &&
		(!$('#dialog').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
		jovahagy_sor_szinez_be(user_ad);
		
        }
	}).dialog( "open" );
}

var ajax_keres_jovahagy_proc_visszakuld_projvezeto_kerd_utan=null;
function jovahagy_proc_visszakuld_projvezeto_kerd_utan(ev,ho,user_ad,alkalom,projekt_jovahagyas_id){
var _self_texta_val=encodeURIComponent($("#jovahagy_proc_visszakuld_projvezeto_textarea").val());
if(_self_texta_val==""){
 alert("Hiba!\n\nMegjegyzés kitöltése kötelező!");
}else{
 var par="&ev="+encodeURIComponent(ev)+"&ho="+encodeURIComponent(ho)+"&user_ad="+encodeURIComponent(user_ad)+"&megj="+_self_texta_val+"&alkalom="+encodeURIComponent(alkalom)+"&projekt_jovahagyas_id="+encodeURIComponent(projekt_jovahagyas_id);
 
 if(ajax_keres_jovahagy_proc_visszakuld_projvezeto_kerd_utan!=null){
 ajax_keres_jovahagy_proc_visszakuld_projvezeto_kerd_utan.abort();
 }

 ajax_keres_jovahagy_proc_visszakuld_projvezeto_kerd_utan=$.post(ajaxstat_p_ut,"mod=jovahagy_proc_visszakuld_projvezeto_kerd_utan"+par,
	function(d){
	ajax_keres_jovahagy_proc_visszakuld_projvezeto_kerd_utan=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //ful_betolt(akt_ful);
	 jovahagy_keress();
	 $('#dialog_egyeni_close').dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
 });
}
}

var ajax_keres_jovahagy_proc_visszakuld=null;
function jovahagy_proc_visszakuld(user_ad,alkalom){
var _this_ho=$("#jovahagy_melyik_ho option:selected");
var ev=$("#jovahagy_melyik_ev option:selected").val();
var ho=_this_ho.val();
if(Number(ho)<10)
 var visszakuld_ho=ev+"-0"+ho;
else var visszakuld_ho=ev+"-"+ho;

if(ajax_keres_jovahagy_proc_visszakuld!=null){
 ajax_keres_jovahagy_proc_visszakuld.abort();
}

 ajax_keres_jovahagy_proc_visszakuld=$.post(ajaxstat_p_ut,"mod=jovahagy_proc_visszakuldheto_e&visszakuld_ho="+visszakuld_ho,
	function(d){
	ajax_keres_jovahagy_proc_visszakuld=null;
	if(d=="ok$;$"){
	 jovahagy_proc_visszakuld_kerd_elott(user_ad,alkalom);
	}else{
	 diaglog_open(d,"Hiba!");	
	}
 });
}

function jovahagy_proc_visszakuld_kerd_elott(user_ad,alkalom){
var user_nev=$("#jovahagysor_user_nev_"+user_ad).html();
var ev=$("#jovahagy_melyik_ev option:selected").val();
var _this_ho=$("#jovahagy_melyik_ho option:selected");
var ho=_this_ho.val();
var ho_str=_this_ho.text();

	var title_ki="Visszaküldés: "+user_nev+", "+alkalom+". alkalommal";
	var d="<b>Biztos, hogy visszaküldöd módosításra "+user_nev+" "+ev+". "+ho_str+" havi munkaidő rögzítését?</b>";
	d+="<br><br>Megjegyzés:<br>";
	d+="<textarea style='width:700px' rows='6' id='jovahagy_proc_visszakuld_textarea'></textarea>";
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Igen": function() {
		 jovahagy_proc_visszakuld_kerd_utan(ev,ho,user_ad,alkalom);
        },
        "Mégse": function() {
          $(this).dialog("close");
        }
      },
	  	open: function (event, ui){
		$(".ui-dialog-title").html("<img src='image/del_behajtani16.png'> "+title_ki);
		//$("#dialog_egyeni_close").dialog("option","position",{my:"center",at:"center",of:window}).dialog("option","width","auto");
        $("#ui-widget-overlay").fadeIn();
		jovahagy_sor_szinez_be(user_ad);
		autosize($("#jovahagy_proc_visszakuld_textarea"));
		$(".ui-tooltip").css("visibility","hidden");
      },
        close: function() {
		if(
		(!$('#dialog_egyeni_close').dialog('isOpen')) &&
		(!$('#dialog').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
		jovahagy_sor_szinez_be(user_ad);
		
        }
	}).dialog( "open" );
}

var ajax_keres_jovahagy_proc_visszakuld_kerd_utan=null;
function jovahagy_proc_visszakuld_kerd_utan(ev,ho,user_ad,alkalom){

var _this=$("#jovahagy_proc_visszakuld_textarea");
if(_this.length){
var _self_texta_val=encodeURIComponent(_this.val());
if(_self_texta_val==""){
 alert("Hiba!\n\nMegjegyzés kitöltése kötelező!");
}else{
 var par="&ev="+encodeURIComponent(ev)+"&ho="+encodeURIComponent(ho)+"&user_ad="+encodeURIComponent(user_ad)+"&megj="+_self_texta_val+"&alkalom="+encodeURIComponent(alkalom);
 
 if(ajax_keres_jovahagy_proc_visszakuld_kerd_utan!=null){
 ajax_keres_jovahagy_proc_visszakuld_kerd_utan.abort();
 }
 
 ajax_keres_jovahagy_proc_visszakuld_kerd_utan=$.post(ajaxstat_p_ut,"mod=jovahagy_proc_visszakuld_kerd_utan"+par,
	function(d){
	ajax_keres_jovahagy_proc_visszakuld_kerd_utan=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //ful_betolt(akt_ful);
	 jovahagy_keress();
	 $('#dialog_egyeni_close').dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
 });
}

}else{
	diaglog_open("Rendszerhiba! Megjegyzés!","Rendszerhiba");	
}

}

//Projekt jóváhagyás - eleje
function jovahagy_proc_ok_projvezeto(user_ad,alkalom,projekt_jovahagyas_id){
var user_nev=$("#jovahagysor_user_nev_"+user_ad).html();
var projekt_nev=$("#jovahagy_melyik_szerv option:selected").text();

var ev=""+$("#jovahagy_melyik_ev option:selected").val();
var _this_ho=$("#jovahagy_melyik_ho option:selected");
var ho=_this_ho.val();
var ho_str=_this_ho.text();


var title_ki="Projekt jóváhagyás: "+user_nev+", "+projekt_nev;
var d="<b>Biztos, hogy jóváhagyod "+user_nev+" "+ev+". "+ho_str+" havi "+projekt_nev+" munkaidő rögzítését?</b>";
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Igen": function() {
		 jovahagy_proc_ok_projvezeto_kerd_utan(ev,ho,user_ad,alkalom,projekt_jovahagyas_id);
        },
        "Mégse": function() {
          $(this).dialog("close");
        }
      },
	  	open: function (event, ui){
		$(".ui-dialog-title").html("<img src='image/jovahagy2_16.png'> "+title_ki);
		//$("#dialog_egyeni_close").dialog("option","position",{my:"center",at:"center",of:window}).dialog("option","width","auto");
        $("#ui-widget-overlay").fadeIn();
		jovahagy_sor_szinez_be(user_ad);
      },
        close: function() {
		if(
		(!$('#dialog_egyeni_close').dialog('isOpen')) &&
		(!$('#dialog').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
		jovahagy_sor_szinez_be(user_ad);
        }
	}).dialog( "open" );
}

var ajax_keres_jovahagy_proc_ok_projvezeto_kerd_utan=null;
function jovahagy_proc_ok_projvezeto_kerd_utan(ev,ho,user_ad,alkalom,projekt_jovahagyas_id){
var par="&ev="+encodeURIComponent(ev)+"&ho="+encodeURIComponent(ho)+"&user_ad="+encodeURIComponent(user_ad)+"&alkalom="+encodeURIComponent(alkalom)+"&projekt_jovahagyas_id="+encodeURIComponent(projekt_jovahagyas_id);

if(ajax_keres_jovahagy_proc_ok_projvezeto_kerd_utan!=null){
 ajax_keres_jovahagy_proc_ok_projvezeto_kerd_utan.abort();
}

ajax_keres_jovahagy_proc_ok_projvezeto_kerd_utan=$.post(ajaxstat_p_ut,"mod=jovahagy_proc_ok_projvezeto_kerd_utan"+par,
	function(d){
	ajax_keres_jovahagy_proc_ok_projvezeto_kerd_utan=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //ful_betolt(akt_ful);
	 jovahagy_keress();
	 $('#dialog_egyeni_close').dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
 });
}
//Projekt jóváhagyás - vége

//Projekt tömeges jóváhagyás tömeges - eleje
function jovahagy_proc_ok_tom_projvezeto(ev,ho,ho_str,projekt_jovahagyas_id,projekt_nev){

var tuser_nev="";
var tuser_ad="";
var tuser_szam=0;
$("input[type=checkbox][id^=jovahagy_tom_]").each(function(){
 if($(this).prop("checked")){
  if(tuser_ad!="")tuser_ad+="-";
  tuser_ad+=$(this).attr("adattom_kuld");
  tuser_nev+="<li>"+$(this).attr("user_nev");
  tuser_szam++;
 }
})

if(tuser_szam==0){
 diaglog_open("Hiba!<br><br>Egy felhasználót se jelöltél ki!","Hiba! Tömeges projekt jóváhagyás");
 return false;
}

if(tuser_szam==1) var felh="felhasználó";
else var felh="felhasználók";

	var title_ki="Tömeges projekt jóváhagyás";
	var d="<b>Biztos, hogy jóváhagyod az <b>alábbi "+felh+"</b> "+ev+". "+ho_str+" havi "+projekt_nev+" munkaidő rögzítését?</b>";
	d+="<br><ul>"+tuser_nev+"</ul>";
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Igen": function() {
		 jovahagy_proc_ok_tom_projvezeto_kerd_utan(ev,ho,tuser_ad,projekt_jovahagyas_id);
        },
        "Mégse": function() {
          $(this).dialog("close");
        }
      },
	  	open: function (event, ui){
		$(".ui-dialog-title").html("<img src='image/jovahagy2_16.png'> "+title_ki);
		//$("#dialog_egyeni_close").dialog("option","position",{my:"center",at:"center",of:window}).dialog("option","width","auto");
        $("#ui-widget-overlay").fadeIn();
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

var ajax_keres_jovahagy_proc_ok_tom_projvezeto_kerd_utan=null;
function jovahagy_proc_ok_tom_projvezeto_kerd_utan(ev,ho,tuser_ad,projekt_jovahagyas_id){
var par="&ev="+encodeURIComponent(ev)+"&ho="+encodeURIComponent(ho)+"&tuser_ad="+encodeURIComponent(tuser_ad)+"&projekt_jovahagyas_id="+encodeURIComponent(projekt_jovahagyas_id);

if(ajax_keres_jovahagy_proc_ok_tom_projvezeto_kerd_utan!=null){
 ajax_keres_jovahagy_proc_ok_tom_projvezeto_kerd_utan.abort();
}

ajax_keres_jovahagy_proc_ok_tom_projvezeto_kerd_utan=$.post(ajaxstat_p_ut,"mod=jovahagy_proc_ok_tom_projvezeto_kerd_utan"+par,
	function(d){
	ajax_keres_jovahagy_proc_ok_tom_projvezeto_kerd_utan=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //ful_betolt(akt_ful);
	 jovahagy_keress();
	 $('#dialog_egyeni_close').dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
 });
}
//Projekt tömeges jóváhagyás tömeges - vége

//Szervezeti jóváhagyás - eleje
function jovahagy_proc_ok(user_ad,alkalom){
var user_nev=$("#jovahagysor_user_nev_"+user_ad).html();
var ev=$("#jovahagy_melyik_ev option:selected").val();
var _this_ho=$("#jovahagy_melyik_ho option:selected");
var ho=_this_ho.val();
var ho_str=_this_ho.text();

	var title_ki="Jóváhagyás: "+user_nev;
	var d="<b>Biztos, hogy jóváhagyod "+user_nev+" "+ev+". "+ho_str+" havi munkaidő rögzítését?</b>";
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Igen": function() {
		 jovahagy_proc_ok_kerd_utan(ev,ho,user_ad,alkalom);
        },
        "Mégse": function() {
          $(this).dialog("close");
        }
      },
	  	open: function (event, ui){
		$(".ui-dialog-title").html("<img src='image/jovahagy2_16.png'> "+title_ki);
		//$("#dialog_egyeni_close").dialog("option","position",{my:"center",at:"center",of:window}).dialog("option","width","auto");
        $("#ui-widget-overlay").fadeIn();
		jovahagy_sor_szinez_be(user_ad);
		$(".ui-tooltip").css("visibility","hidden");
      },
        close: function() {
		if(
		(!$('#dialog_egyeni_close').dialog('isOpen')) &&
		(!$('#dialog').dialog('isOpen'))
		){
		 $(".ui-widget-overlay").fadeOut();
	    }
		jovahagy_sor_szinez_be(user_ad);
        }
	}).dialog( "open" );
}

var ajax_keres_jovahagy_proc_ok_kerd_utan=null;
function jovahagy_proc_ok_kerd_utan(ev,ho,user_ad,alkalom){
var par="&ev="+encodeURIComponent(ev)+"&ho="+encodeURIComponent(ho)+"&user_ad="+encodeURIComponent(user_ad)+"&alkalom="+encodeURIComponent(alkalom);

if(ajax_keres_jovahagy_proc_ok_kerd_utan!=null){
 ajax_keres_jovahagy_proc_ok_kerd_utan.abort();
}

ajax_keres_jovahagy_proc_ok_kerd_utan=$.post(ajaxstat_p_ut,"mod=jovahagy_proc_ok_kerd_utan"+par,
	function(d){
	ajax_keres_jovahagy_proc_ok_kerd_utan=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //ful_betolt(akt_ful);
	 jovahagy_keress();
	 $('#dialog_egyeni_close').dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
 });
}
//Szervezeti jóváhagyás - vége

//Szervezeti jóváhagyás tömeges - eleje
function jovahagy_proc_ok_tom(ev,ho,ho_str){

var tuser_nev="";
var tuser_ad="";
var tuser_szam=0;
$("input[type=checkbox][id^=jovahagy_tom_]").each(function(){
 if($(this).prop("checked")){
  if(tuser_ad!="")tuser_ad+="-";
  tuser_ad+=$(this).attr("adattom_kuld");
  tuser_nev+="<li>"+$(this).attr("user_nev");
  tuser_szam++;
 }
})

if(tuser_szam==0){
 diaglog_open("Hiba!<br><br>Egy felhasználót se jelöltél ki!","Hiba! Tömeges jóváhagyás");
 return false;
}

if(tuser_szam==1) var felh="felhasználó";
else var felh="felhasználók";

	var title_ki="Tömeges jóváhagyás";
	var d="<b>Biztos, hogy jóváhagyod az <b>alábbi "+felh+"</b> "+ev+". "+ho_str+" havi munkaidő rögzítését?</b>";
	d+="<br><ul>"+tuser_nev+"</ul>";
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Igen": function() {
		 jovahagy_proc_ok_tom_kerd_utan(ev,ho,tuser_ad);
        },
        "Mégse": function() {
          $(this).dialog("close");
        }
      },
	  	open: function (event, ui){
		$(".ui-dialog-title").html("<img src='image/jovahagy2_16.png'> "+title_ki);
		//$("#dialog_egyeni_close").dialog("option","position",{my:"center",at:"center",of:window}).dialog("option","width","auto");
        $("#ui-widget-overlay").fadeIn();
		$(".ui-tooltip").css("visibility","hidden");
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

var ajax_keres_jovahagy_proc_ok_tom_kerd_utan=null;
function jovahagy_proc_ok_tom_kerd_utan(ev,ho,tuser_ad){
var par="&ev="+encodeURIComponent(ev)+"&ho="+encodeURIComponent(ho)+"&tuser_ad="+encodeURIComponent(tuser_ad);

if(ajax_keres_jovahagy_proc_ok_tom_kerd_utan!=null){
 ajax_keres_jovahagy_proc_ok_tom_kerd_utan.abort();
}

ajax_keres_jovahagy_proc_ok_tom_kerd_utan=$.post(ajaxstat_p_ut,"mod=jovahagy_proc_ok_tom_kerd_utan"+par,
	function(d){
	ajax_keres_jovahagy_proc_ok_tom_kerd_utan=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //ful_betolt(akt_ful);
	 jovahagy_keress();
	 $('#dialog_egyeni_close').dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
 });
}
//Szervezeti jóváhagyás tömeges - vége



function jovahagy_tomall(){//Összes jóváhagyható sor bepipálása, és kék színű..
var vanesor=0;
$("input[type=checkbox][id^=jovahagy_tom_]").each(function(){
 var tuser_ad=this.id.split("_");
 $(this).trigger("click");
 //jovahagy_sor_szinez_be(tuser_ad[1]);
 vanesor++;
});

if(vanesor==0){
 $("#jovahagy_tomall").prop("checked",false);
}

}

function jovahagy_tomegy(user_ad){
jovahagy_sor_szinez_be(user_ad);

//Nézzük meg, hogy hány van bepipálva és hány nem
var nincsbe=0;
$("input[type=checkbox][id^=jovahagy_tom_]").each(function(){
 if(!$(this).prop("checked"))
  nincsbe=1;
});

if(nincsbe==0)$("#jovahagy_tomall").prop("checked",true);
else $("#jovahagy_tomall").prop("checked",false);
}

function jovahagy_sor_szinez_be(user_ad){//Addott sor tartos színezése
var sc="table_emre_tr_kijelolve";
var _self=$("#jovahagysor_"+user_ad);
if(_self.attr("class")==sc)
 _self.removeClass(sc);
else
 _self.addClass(sc);

}

function excel_export_jovahagy_user_tomeges(ev,ho){

var tuser_ad='';
$('tr[id^=jovahagysor_').each(function(){
 var _this_ad=$(this).attr('user_ad');
 if(tuser_ad!='')tuser_ad+=',';
 tuser_ad+=_this_ad;
});

$("<form target=_top id='pdf_export_akt_user' method=post action='excel_export/excel_export.php'><input type='hidden' id='xlsx_export_akt_user_ho_egyedi' name='mod_egyedi' value='xlsx_export_jovahagy_user_tomeges'><input type='hidden' id='user_ad' name='tuser_ad' value='"+encodeURIComponent(tuser_ad)+"'><input type='hidden' id='xlsx_export_akt_user_ho' name='ev' value='"+encodeURIComponent(ev)+"'><input type='hidden' id='xlsx_export_akt_user_ho' name='ho' value='"+encodeURIComponent(ho)+"'></form>").appendTo('body').trigger("submit").remove();
}

function excel_export_jovahagy_user(user_ad,ev,ho){
$("<form target=_top id='pdf_export_akt_user' method=post action='excel_export/excel_export.php'><input type='hidden' id='xlsx_export_akt_user_ho_egyedi' name='mod_egyedi' value='xlsx_export_jovahagy_user'><input type='hidden' id='user_ad' name='user_ad' value='"+encodeURIComponent(user_ad)+"'><input type='hidden' id='xlsx_export_akt_user_ho' name='ev' value='"+encodeURIComponent(ev)+"'><input type='hidden' id='xlsx_export_akt_user_ho' name='ho' value='"+encodeURIComponent(ho)+"'></form>").appendTo('body').trigger("submit").remove();
}

function pdf_export_jovahagy_user(user_ad,ev,ho){
/*
$("#file_form_user").val(user_ad);
$("#file_form_idoszak_ev").val(ev);
$("#file_form_idoszak_ho").val(ho);
$("#pdf_export_akt_user").trigger("submit");
*/
$("<form target=_blank id='pdf_export_akt_user' method=post action='pdf/'><input type='hidden' id='xlsx_export_akt_user_ho_egyedi' name='mod_egyedi' value='xlsx_export_jovahagy_user'><input type='hidden' id='file_form_user' name='user' value='"+user_ad+"'><input type='hidden' id='file_form_idoszak_ev' name='idoszak_ev' value='"+ev+"'><input type='hidden' id='file_form_idoszak_ho' name='idoszak_ho' value='"+ho+"'></form>").appendTo('body').trigger("submit").remove();

}

function jovahagy_kezi_lezaras(user_ad,ev,ho,ho_str){
	var title_ki=ho_str+" hónap lezárása";
	var d="<b>Biztos, hogy jóváhagyóként, ellenőrzés nélkül lezárod a hónapot?</b>";
	d+="<br><br>További módosítás már nem lehetséges!";
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Igen": function() {
		 jovahagy_kezi_lezaras_proc_kerd_utan(user_ad,ev,ho);
        },
        "Mégse": function() {
          $(this).dialog("close");
        }
      },
	  	open: function (event, ui){
		//$("#dialog_egyeni_close").dialog("option","position",{my:"center",at:"center",of:window}).dialog("option","width","auto");
        $("#ui-widget-overlay").fadeIn();
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

var ajax_keres_jovahagy_kezi_lezaras_proc_kerd_utan=null;
function jovahagy_kezi_lezaras_proc_kerd_utan(user_ad,ev,ho){

if(ajax_keres_jovahagy_kezi_lezaras_proc_kerd_utan!=null){
 ajax_keres_jovahagy_kezi_lezaras_proc_kerd_utan.abort();
}

ajax_keres_jovahagy_kezi_lezaras_proc_kerd_utan=$.post(ajaxstat_p_ut,"mod=jovahagy_kezi_lezaras_proc_kerd_utan&user_ad="+user_ad+"&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_jovahagy_kezi_lezaras_proc_kerd_utan=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	  //ful_betolt(akt_ful);
	  jovahagy_keress();
	  $('#dialog_egyeni_close').dialog("close");
	}else if(d1[0]=="noadat"){
	 diaglog_open(d1[1],"Hiba");
	 $('#dialog_egyeni_close').dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	 $('#dialog_egyeni_close').dialog("close");
	}
});
}

function inp_auto_start_jovahagy_szur_user(){

$('#jovahagy_melyik_user').select2({
 dropdownAutoWidth : true,
placeholder: "Összes",
maximumInputLength:50,
dropdownCssClass: "bigdrop",
 //minimumResultsForSearch: -1,//Letiltás  a keresésre

/*
language: {
        searching: function() {
			return "Keresés";
        }
    },
*/

   "language": {
       "noResults": function(){
           //return "No Results Found <a href='#' class='btn btn-danger'>Use it anyway</a>";
           return "Nincs találat.";
       }
   },

 //templateResult: formatSingleResult,
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
					 //szerv_id=encodeURIComponent($("#jovahagy_melyik_szerv option:selected").val());
					 var szerv_id=encodeURIComponent($("#jovahagy_melyik_szerv option:selected").attr("akt_szerv_id"));
					 var ev=encodeURIComponent($("#jovahagy_melyik_ev option:selected").val());
					 var ho=encodeURIComponent($("#jovahagy_melyik_ho option:selected").val());
					 
                    return {
                        mod:"jovahagy_melyik_user",
                        q: q_ki,
                        szerv_id: szerv_id,
                        ev: ev,
                        ho: ho,
                        sel: sel_val
                        //sel_text: sel_text,
						//,nap:nap
                    };
                },
                processResults: function (data) {
                		/*var res = data.items.map(function (item) {
                        	return {id: item.id, text: item.name};
                        });*/
                    return {
                        /*results: res*/
                        results: data
                    };
                }
            },

}).maximizeSelect2Height({
cushion: 20 //Beállíthatja, hogy mennyi extra hely maradjon a nyitott legördülő menü széle és a nézetablak széle között a következő opcióval cushion
});



//Első jó megoldás

//$(document).on('select2:open', () => {
$('#jovahagy_melyik_user').on('select2:open',function(){
    document.querySelector('.select2-search__field').focus();
	tooltip_proc();
  })/*.on('select2:close',function(){
    $('.ui-tooltip').remove();
  })*/;
}
