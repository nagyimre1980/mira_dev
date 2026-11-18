
var input_time_no_mentes=0;
var global_ev='';
var global_ho='';
var global_user='';
function ful_rogzit(){//Rogiz fül betöltés után (Hóváltáskor is
//fo_table_ki();
//fo_table_evho_elsoki();
//autosize($('textarea'));

//V1.059 Admin-Hibajavításnál NE legyen mentés
input_time_no_mentes=0;

//Csak tabozás esetén írjuk át, sima usernél nem!
if(title_orig!=""){
 document.title=title_orig+" - Rögzítés";
}
		timespinner_start(".input_time");
		
		//timespinner_start_egyeb_egy(".input_time");//Láthatóakra elindul
		//De jobb egyenként!
		////V1.20 hogy csak egyszer legyen elindítva soronként
		timespinner_van=new Array();//De ekkor a fül újratöltésre került, nullázuk ki
		$('.input_time').each(function(){
		 timespinner_start_egyeb_egy("#"+this.id);
		});
		
		
		/*if(isIE()){
		 inp_auto_start('.sel_proj');
		}*/
		
		/*inp_auto_start();*/

$("#table_emre_bejovo").css("display","inline");

if($("#fo_div_notab").length ){//Tab nélkülinél kell a fődiv-t is engedélyezni!
 $("#fo_div_notab").css("display","block");
}
//console.log("width: "+$("#table_emre_bejovo").width());
//console.log("innerWidth: "+$("#table_emre_bejovo").innerWidth());
//console.log("outerWidth: "+$("#table_emre_bejovo").outerWidth());
//console.log("outerWidth-true: "+$("#table_emre_bejovo").outerWidth(true));
/*
Metódus	Mit mér?
.width()	Csak a tiszta tartalom (content).
.innerWidth()	Tartalom + Padding.
.outerWidth()	Tartalom + Padding + Border (Ez a "látható" szélesség).
.outerWidth(true)	Tartalom + Padding + Border + Margin.
*/
//Dupla scrollbar - eleje
    //$("#scroll1 div").width($("#table_emre_bejovo").width());
    $("#scroll1 div").width($("#table_emre_bejovo").outerWidth(true));
    var ignoreScroll = false; // Zászló a végtelen ciklus ellen
	$("#scroll1").on("scroll", function(){
        //$("#scroll2").scrollLeft($(this).scrollLeft()); 
		 if (!ignoreScroll) {
         ignoreScroll = true;
         $("#scroll2").scrollLeft($(this).scrollLeft());
        
         // Hagyunk egy pici időt, majd levesszük a zászlót
         requestAnimationFrame(function() {
            ignoreScroll = false;
         });
		}
    });
    $("#scroll2").on("scroll", function(){
         //$("#scroll1").scrollLeft($(this).scrollLeft()); 
		 if (!ignoreScroll) {
         ignoreScroll = true;
         $("#scroll1").scrollLeft($(this).scrollLeft());
        
         requestAnimationFrame(function() {
            ignoreScroll = false;
         });
		}
    });
//Dupla scrollbar - vége

//if(!isIE()){
 //$('.sel_proj').on('mouseover', function(){
 $('.sel_proj').on('mouseover', function(){
  inp_auto_start("#"+this.id);
 });
//}

rogzit_textrarea_meretezes_all();
osszesen_all();
tooltip_proc();
number_only();

global_ev=encodeURIComponent($("#sel_melyik_ev").val());
global_ho=encodeURIComponent($("#sel_melyik_ho").val());
global_user=encodeURIComponent($("#user_ad_ellhez").val());

//sor színezés- eleje
/*
$('#table_emre_bejovo tr').hover(function() {
	
	this_classorig=$(this).attr("orig_class");
	if(this_classorig=="paros" || this_classorig=="paratlan"){
    if(this_classorig=="paros")
	 class_fel='table_emre_bejovo_akt_nap_paros';
	else if($(this).attr("orig_class")=="paratlan")
	 class_fel='table_emre_bejovo_akt_nap_paratlan';
	 
	 $(this).addClass('table_emre_bejovo_akt_zold').removeClass(class_fel);
	}
}, function() {
	
	this_classorig=$(this).attr("orig_class");
	if(this_classorig=="paros" || this_classorig=="paratlan"){
	if(this_classorig=="paros")
	 class_fel='table_emre_bejovo_akt_nap_paros';
	else if($(this).attr("orig_class")=="paratlan")
	 class_fel='table_emre_bejovo_akt_nap_paratlan';
	 
    $(this).removeClass('table_emre_bejovo_akt_zold').addClass(class_fel);
   }
});
*/
$("#table_emre_bejovo tr").on({
  mouseenter: function(){
    var this_classorig=$(this).attr("orig_class");
	if(this_classorig=="paros" || this_classorig=="paratlan"){
    if(this_classorig=="paros")
	 var class_fel='table_emre_bejovo_akt_nap_paros';
	else if($(this).attr("orig_class")=="paratlan")
	 var class_fel='table_emre_bejovo_akt_nap_paratlan';
	 
	 $(this).addClass('table_emre_bejovo_akt_zold').removeClass(class_fel);
	}
  },
  mouseleave: function(){
    var this_classorig=$(this).attr("orig_class");
	if(this_classorig=="paros" || this_classorig=="paratlan"){
	if(this_classorig=="paros")
	 var class_fel='table_emre_bejovo_akt_nap_paros';
	else if($(this).attr("orig_class")=="paratlan")
	 var class_fel='table_emre_bejovo_akt_nap_paratlan';
	 
    $(this).removeClass('table_emre_bejovo_akt_zold').addClass(class_fel);
   }
   
  }
});

//sor színezés- vége


//selct2-re kattintva ne maradjon ott a tooltip
//$(".select2-selection__rendered").click(function() {
$(".select2-selection__rendered").on("click",function() {
 $('.ui-tooltip').remove();
});

manual_eger_rogzit_ho_all_td();
}

//var rogzit_ment_fo_wait="";
var rogzit_ment_fo_wait={};
function rogzit_ment(nap_akt,sorsz,projekt_id_last){
  osszesen_nap(nap_akt,"1");
  
  var kulcs = nap_akt + "_" + sorsz;
  
  //clearTimeout(rogzit_ment_fo_wait);
  clearTimeout(rogzit_ment_fo_wait[kulcs]);
  //rogzit_ment_fo_wait = setTimeout(function(){rogzit_ment_proc(nap_akt,sorsz,projekt_id_last);},100);
  rogzit_ment_fo_wait[kulcs] = setTimeout(function() {
        rogzit_ment_proc(nap_akt, sorsz, projekt_id_last);
        delete rogzit_ment_fo_wait[kulcs];
    }, 100);
}

//var ajax_keres_rogzit_ment=null;
//var ajax_keres_rogzit_ment=new Array();
var ajax_keres_rogzit_ment = {};
function rogzit_ment_proc(nap_akt,sorsz,projekt_id_last){

//var projekt_id=encodeURIComponent($("#proj_"+nap_akt+"_"+sorsz+" option:selected").val());
var projekt_id=encodeURIComponent($("#proj_"+nap_akt+"_"+sorsz).val());

//projekt_id_last=$("#proj_"+nap_akt+"_"+sorsz).attr("last_sel_id");

var ido=encodeURIComponent($("#input_proj_"+nap_akt+"_"+sorsz).val());

//logba="nap: "+nap_akt+" sorszám:"+sorsz+" Mentése PROJ_ID: "+projekt_id+" napráfordítás: "+ido+" projekt_id_last: "+projekt_id_last;
//console.log(logba);

/*
if(typeof ajax_keres_rogzit_ment[nap_akt]!=="undefined" && ajax_keres_rogzit_ment[nap_akt]!=""){
 ajax_keres_rogzit_ment[nap_akt].abort();
}
*/
var kulcs = nap_akt + "_" + sorsz;
if (ajax_keres_rogzit_ment[kulcs]) {
    ajax_keres_rogzit_ment[kulcs].abort();
}

//ajax_keres_rogzit_ment[nap_akt]=$.post(ajaxstat_p_ut,"mod=rogzit_ment&nap="+nap_akt+"&sorsz="+sorsz+"&ido="+ido+"&projekt_id="+projekt_id+"&projekt_id_last="+projekt_id_last+"&ev="+global_ev+"&ho="+global_ho+"&user_ad="+global_user,
ajax_keres_rogzit_ment[kulcs]=$.post(ajaxstat_p_ut,"mod=rogzit_ment&nap="+nap_akt+"&sorsz="+sorsz+"&ido="+ido+"&projekt_id="+projekt_id+"&projekt_id_last="+projekt_id_last+"&ev="+global_ev+"&ho="+global_ho+"&user_ad="+global_user,
	function(d){
	
	delete ajax_keres_rogzit_ment[kulcs];
	
	if(d!='nookreload'){
	//ajax_keres_rogzit_ment[nap_akt]="";
	
	$("#proj_"+nap_akt+"_"+sorsz).attr("last_sel_id",projekt_id);

	fopage_reopen();
	}else{
		reload_disabled();
	}
},"text");

//osszesen_nap(nap_akt,"1");//V1.034 korábbra került a késletetés miatt
}


function rogzit_ment_mezobol(id){
var d=id.split("_");
var nap_akt=d[2];
var sorsz=d[3];
rogzit_ment(nap_akt,sorsz,"");
tooltip_proc();
}




var timespinner_van=new Array();
function timespinner_start_egyeb_egy(id){

if (!timespinner_van[id]){//V1.20 hogy csak egyszer legyen elindítva soronként
timespinner_van[id]=1;

$(id).on("copy", function () {
 var _self=$(this);
 _self.trigger("select");
}).on("paste", function (event) {
	var _self=$(this);
	var cd = event.originalEvent.clipboardData;
	var uj_ertek_vagolap;
	uj_ertek_vagolap=cd.getData("text/plain");
	var len=uj_ertek_vagolap.length;
	
	var max_ora=_self.attr("max_ora");
	var max_perc=_self.attr("max_perc");
	var beirt_perc=uj_ertek_vagolap.split(":");
	//console.log(max_ora);
	if(
	 (len==4 && Number(uj_ertek_vagolap[0])<max_ora && uj_ertek_vagolap[1]==":")//1:00 és max 7:59 (8:00 max esetén)
	 ||
	 (len==4 && Number(uj_ertek_vagolap[0])==max_ora && uj_ertek_vagolap[2]==0 && uj_ertek_vagolap[3]==0 && uj_ertek_vagolap[1]==":")//1:00 és max 8:00 (8:00 max esetén)
	 ||
	 (len==5 && Number(uj_ertek_vagolap[0]+uj_ertek_vagolap[1])<max_ora && uj_ertek_vagolap[2]==":")//10:00 és 11:59 (12:00) max esetén
	 ||
	 (len==5 && Number(uj_ertek_vagolap[0]+uj_ertek_vagolap[1])==max_ora && uj_ertek_vagolap[3]==0 && uj_ertek_vagolap[4]==0 && uj_ertek_vagolap[2]==":")//10:00 és 12:00 (12:00) max esetén
	 ||//1:00 és max 9:00 között ha a perc nagyobb mint 00
	 (len==4 && Number(uj_ertek_vagolap[0])==max_ora && Number(beirt_perc[1])<=Number(max_perc) && uj_ertek_vagolap[1]==":")
	){
	 _self.trigger("select");
	 return true;
	}else{
	 return false;
	}
}).on("keydown", function (event) {
var code = event.keyCode;//event.which

if(code == '37' || code =='39'){//bal-jobb esetén itt nincs mit csinálni
 return true;
}

//Mask - eleje
 var _self=$(this);
 var val_this=_self.val();
 var len=val_this.length;
 var v=doGetCaretPosition(this);
 
if(len>5){//Ha sok, ne legyen semmi
 _self.val("0:00");
 var val_this=_self.val();
 var len=val_this.length;
 event.preventDefault();
}
 
/*if(len==5)
 $(this).mask('00:00');
else
 $(this).mask('0:00');*/
//Mask - vége

		
		switch(code){
			case 38: case 33:
			 input_tobb($(this));
			break;
			case 40: case 34:
			 input_kevesebb($(this));
			break;
			/*default:
			 //event.preventDefault();Így nem lehet gépelni
			break;*/
			
		}
		
		//67 - 86 ctrl+c+v
		if((event.ctrlKey)&&(code==67 || code==86)){
			//_self.select();
			///////////////_self.trigger("select");
			//////////return true;//CTRL+V tiltása
		}else if(
			(event.shiftKey)||
			(
			(
			(code<48)|| 
			(code>57 && code<96)||			
			(code>105)
			)
			&&(code!=8)//backspace
			&&(code!=46)//del
			&&(code!=116)//f5
			//&&(code!=9)//tab
			)
			){
				//console.log(code);
			 event.preventDefault();//Így nem lehet gépelni	
			}

//Backspace lekezelése
if(code==8 || code==46){
 if(v==4 || v==5){//perc
 
 var d1=val_this.split(":");
 
  //kijelolve_start=_self.prop("selectionStart");
  //kijelolve_end=_self.prop("selectionEnd");
  if(val_this.length==5){
	  var kijelolve_start=3;
	  var kijelolve_end=5;
  }else{
	  if(d1[0].length==1){//1:00 végén törlés
	   var kijelolve_start=2;
	   var kijelolve_end=4;
	  }else if(d1[0].length==2){//10:1 végén törlés
		var kijelolve_start=3;
	    var kijelolve_end=5;  
	  }
  }
  
  _self.val(d1[0]+":00"); 
  _self.prop({'selectionStart':kijelolve_start,'selectionEnd':kijelolve_end});
  rogzit_ment_mezobol(this.id);
 }else if(v==1 || v==2){//óra 9 vagy kevesebb, 10-nél is 0-ra vált
  var kijelolve_start=0;
  var kijelolve_end=1;
   var d1=val_this.split(":");
  _self.val("0:"+d1[1]);
  _self.prop({'selectionStart':kijelolve_start,'selectionEnd':kijelolve_end});
  rogzit_ment_mezobol(this.id);
 }else if(v==3){//Ekkor 0:2 van a mezőben
  var d1=val_this.split(":");
  _self.val(d1[0]+":00");
  var kijelolve_start=2;
  var kijelolve_end=4;
  _self.prop({'selectionStart':kijelolve_start,'selectionEnd':kijelolve_end});
  rogzit_ment_mezobol(this.id);
 }else if(v==0){//Ekkor az egész ki van jelölve
	 var kijelolve_start=_self.prop("selectionStart");
	 var kijelolve_end=_self.prop("selectionEnd");
	 _self.val("0:00");
	 _self.prop({'selectionStart':kijelolve_start,'selectionEnd':kijelolve_end});
	 rogzit_ment_mezobol(this.id);
 }
 return false;
}



//if(len==1){
 //$(this).mask('0:00');
 //console.log(val_this);
 //_self.val(val_this+":00");
//}
/*else if(len==5)
 $(this).mask('00:00');
else
 $(this).mask('0:00');*/
}).on("keyup", function (event) {
 var code = event.keyCode;// || event.which
 var _self=$(this);
 var v=doGetCaretPosition(this);
 var val_this=_self.val();
 var len=val_this.length;

if(len==1){
 _self.val(val_this+":00");
}

if(code==86){
			//_self.select();
			_self.trigger("select");
			//return true;
		}

if(code==37){//Bal átugrás
if(len==3){
 rogzit_elhagy_kieg(this);
 var _self=$(this);
 var v=doGetCaretPosition(this);
 var val_this=_self.val();
 var len=val_this.length;
}


 if(len==4 && v==4){
  _self.prop({'selectionStart': 0,'selectionEnd': 1});
 }else if(len==5 && v==5){
  _self.prop({'selectionStart': 0,'selectionEnd': 2});
 }else if (len==4 && v==3){//1:01-nél a perc közepén állunk és bal-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 1}); 
 }else if (len==4 && v==2){//1:01-nél a perc :után és bal-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 1});
 }else if (len==4 && v==1){//1:01-nél a perc :előtt és bal-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 1});
 }else if (len==4 && v==0){//1:01-nél a óra :előtt és bal-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 1}); 
 }else if (len==5 && v==4){//11:01-nél a perc közepén állunk és bal-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 2}); 
 }else if (len==5 && v==3){//11:01-nél a perc :után és bal-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 2}); 
 }else if (len==5 && v==2){//11:01-nél a perc :előtt és bal-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 2}); 
 }else if (len==5 && v==1){//11:01-nél a óra közepén állunk bal-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 2}); 
 }else if (len==5 && v==0){//11:01-nél a óra előtt állunk bal-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 2}); 
 }
 
 
//}else if(code==39 || code==102){//Jobb átugrás
}else if(code==39){//Jobb átugrás

if(len==3){
 rogzit_elhagy_kieg(this);
 var _self=$(this);
 var v=doGetCaretPosition(this);
 var val_this=_self.val();
 var len=val_this.length;
}


 if(len==4 && v==1){
  _self.prop({'selectionStart': 2,'selectionEnd': 4});
 }else if(len==4 && v==0){//1:01-nél a óra előtt és jobb-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 1});
 }else if(len==4 && v==2){//1:01-nél a óra :előtt és jobb-ra megyünk...
  _self.prop({'selectionStart': 2,'selectionEnd': 4});
 }else if(len==4 && v==3){//1:01-nél a óra :után és jobb-ra megyünk...
  _self.prop({'selectionStart': 2,'selectionEnd': 4});
 }else if(len==4 && v==4){//1:01-nél a perc után és jobb-ra megyünk...
  _self.prop({'selectionStart': 2,'selectionEnd': 4});
 }else if(len==5 && v==2){
  _self.prop({'selectionStart': 3,'selectionEnd': 5});
 }else if(len==5 && v==0){//11:01-nél a óra előtt és jobb-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 2});
 }else if(len==5 && v==1){//11:01-nél a óra közepén és jobb-ra megyünk...
  _self.prop({'selectionStart': 0,'selectionEnd': 2});
 }else if(len==5 && v==3){//11:01-nél a :után és jobb-ra megyünk...
  _self.prop({'selectionStart': 3,'selectionEnd': 5});
 }else if(len==5 && v==4){//11:01-nél a perc közepén és jobb-ra megyünk...
  _self.prop({'selectionStart': 3,'selectionEnd': 5});
 }else if(len==5 && v==5){//11:01-nél a perc után és jobb-ra megyünk...
  _self.prop({'selectionStart': 3,'selectionEnd': 5});
 }
 
}else if(code==13 || code==9){//enter tab
    rogzit_elhagy_kieg(this);
	var _self=$(this);
	var v=doGetCaretPosition(this);
	var val_this=_self.val();
	var len=val_this.length;
	//rogzit_ment_mezobol(this.id);
	
	if(event.shiftKey && code==9){//Shifttab
		//Mindig az órát jelöljük ki
	  _self.prop({'selectionStart': 0,'selectionEnd': 1});
	 
	}else if(code==9){//TAB lekezelése
		if(len==4 && v==0){//1:01-nél a óra előtt
			_self.prop({'selectionStart': 2,'selectionEnd': 4});
		}else if (len==4 && v==1){//1:01-nél a perc :előtt
			_self.prop({'selectionStart': 2,'selectionEnd': 4});
		}else if(len==4 && v==2){//1:01-nél a perc után
			_self.prop({'selectionStart': 2,'selectionEnd': 4});
		}else if(len==4 && v==3){//1:01-nél a óra :után
			_self.prop({'selectionStart': 2,'selectionEnd': 4});
		}
	}
	
}
		
var d1_perc=val_this.split(":");
//61 nagyobb perc lekezelése - eleje
if(v>2 && typeof d1_perc[1]!=='undefined' && d1_perc[1]>60){
	 //$(this).val(d1_perc[0]+":60").prop({'selectionStart': 2,'selectionEnd': 4});
	 var ki_ora=Number(d1_perc[0])+1;
	 var ki_perc=d1_perc[1]-60;
	 if(ki_perc<10)ki_perc="0"+ki_perc;
	
	 //Max óra lekezelése
	 var max_ora=_self.attr("max_ora");
	 if(ki_ora>=max_ora){
		var ki_ora=max_ora;
		var ki_perc="00";
	 }
	 
	 //$(this).val(ki_ora+":"+ki_perc).prop({'selectionStart': 2,'selectionEnd': 4});
	 _self.val(ki_ora+":"+ki_perc);
	
	var val_this=_self.val();
	var len=val_this.length;
	
	if(len==4){
	 var selectionStart=2;
	 var selectionEnd=4;
	}else if(len==5){
	 var selectionStart=3;
	 var selectionEnd=5;
	}
	_self.prop({'selectionStart': selectionStart,'selectionEnd': selectionEnd});
	 
	 rogzit_ment_mezobol(this.id);
}
//61 nagyobb perc lekezelése - vége
/*
if(len==5)
 $(this).mask('00:00');
else
 $(this).mask('0:00');
*/

//if(len==5)_self.attr("maxlength",5);
//else if(len==4)_self.attr("maxlength",4);
if(Number(d1_perc[0])>9){
 _self.attr("maxlength",5);
}else{
 _self.attr("maxlength",4);
}

//12:00 nagyobbat ne engedjünk meg. Vagy ami a max óra
var max_ora=_self.attr("max_ora");
var max_perc=_self.attr("max_perc");
//if(Number(d1_perc[0])==max_ora){
if(
((Number(d1_perc[0])==max_ora)&&(Number(d1_perc[1]>Number(max_perc))))
||
(Number(d1_perc[0])>max_ora)
){

 _self.val(max_ora+":00");//console.log(max_ora+":00");
 osszesen_nap(this.id.split("_")[2],"1");
 //return true;
}

				if((len==4 && v==4)||(len==5 && v==5)||(len==3)){
					return true;
				}
				
				

//Ha az óránál gépeltünk, akkor legyen a perc kijelölve				
		if(((code>=48 && code<=57)||(code>=96 && code<=105))&&(v==1)){
			$(this).prop({'selectionStart': 2,'selectionEnd': 4});
		
		}
 
}).on('click contextmenu', function(){
var v=doGetCaretPosition(this);
var len=$(this).val().length;
var v_start=0;
var v_end=1;

if(len==5){//00:00
if(v==0 || v==1 || v==2){
 v_start=0;
 v_end=2;
}else{
 v_start=3;
 v_end=5;
}
}else if(len==4){//0:00
 
 if(v==0 || v==1){
  v_start=0;
  v_end=1; 
 }else{
  v_start=2;
  v_end=4;
 }
 
}else{
 return false;	
}

/*
$(this).prop({
    'selectionStart': v_start,
    'selectionEnd': v_end
});
*/


var _this_curkes=this;
var rogzit_keses_curcor_fo_wait="";
  clearTimeout(rogzit_keses_curcor_fo_wait);
  rogzit_keses_curcor_fo_wait = setTimeout(
  function(){
	  $(_this_curkes).prop({
    'selectionStart': v_start,
    'selectionEnd': v_end
});
	  },0
  );

/*}).on('mousewheel', function(event,delta) {
    //console.log(event.deltaX, event.deltaY, event.deltaFactor);
	//$(this).select();
	//event.preventDefault();
	//alert(event.deltaX);
	//$(this).focus().select();
	//$(this).focus().select();
	//console.log(delta);
	//return false;
	
			if(delta==1){
				//ADD
				input_tobb($(this));
				//return false;
				event.preventDefault();
			}else{
				//Subtract
				input_kevesebb($(this));
				//return false;
				event.preventDefault();
			}
*/	
	//timespinner_start_perckijelol($(this));
})/*.on('blur', function(event) {
	v=$(this).val();
	$(this).timespinner( "stepDown","0");
})*//*.m1ask('0:00', {
      translation: {
        'r': {
          pattern: /[\/]/,
          fallback: '/'
        },
        placeholder: "__/__/____"
      }
})*/
//.mask('0:00')
.on('blur', function() {
    rogzit_elhagy_kieg(this);
	//V1.031 verzióban kikapcsoltam
	////////////////rogzit_ment_mezobol(this.id);
	//Kilépéskor tegyük át a focus-t alapra
	//$(this).prop({'selectionStart':0,'selectionEnd':0});
	
});
/*.on('focus',function(){

len=$(this).val().length;
if(len==5)
 $(this).mask('00:00');
else
  $(this).mask('0:00');
})*/



}
}

function rogzit_elhagy_kieg(_this){
var v=doGetCaretPosition(_this);
var _this_s=$(_this);
var value=_this_s.val();
var len=value.length;

var d1=value.split(":");

if(typeof d1[1]!=='undefined' && d1[1].length==1){//Ekkor 00:1 vagy 0:1
 if(d1[0]=="")d1[0]="0";
 var value_uj=d1[0]+":0"+d1[1];
 _this_s.val(value_uj);
}else if(
(typeof d1[1]==='undefined')
||
(typeof d1[1]!=='undefined' && d1[1].length==0)
){//Akkor nincs :, azaz csak óra
 if(d1[0]=="")d1[0]="0";
 if(d1[0].length>2)d1[0]=d1[0][0]+d1[0][1];
 var value_uj=d1[0]+":00";
 
 _this_s.val(value_uj);	
}

//rogzit_ment_mezobol(_this.id);
}

//ho_all_ido = new Array();
var ho_all_ido_ora = new Array();
var ho_all_ido_perc = new Array();

var hoprojekt_all_ido_nev = new Array();
var proj_nev_szam=0;
var hoprojekt_all_ido_ora = new Array();
var hoprojekt_all_ido_perc = new Array();

function osszesen_all(){
//ho_all_ido = new Array();
ho_all_ido_ora = new Array();
ho_all_ido_perc = new Array();

hoprojekt_all_ido_nev = new Array();
proj_nev_szam=0;
hoprojekt_all_ido_ora = new Array();
hoprojekt_all_ido_perc = new Array();

$('.span_nap').each(function(){
	osszesen_nap($(this).attr("nap"),"0");
});
osszesen_all_ki();

}

//ALL TD-re rá álva manuálisan mouseover
function manual_eger_rogzit_ho_all_td(){
//$("#rogzit_ho_all_td").mouseover(function(){
$("#rogzit_ho_all_td").on("mouseover",function(){
  osszesen_all();
  osszesen_all_ki_tooltipp();
}).on("mouseleave",function(){
 $(this).attr("title","");
});
}

function osszesen_all_ki_tooltipp(){

var egeszzam_ora=ki_all_ido_ora;
egeszzam_ora+=Number(ki_all_ido_perc)/60;
//ki_all_ido=Number(egeszzam_ora.toFixed(2));


//összesen tooltip - eleje
//1. összesen tört formában
var ki_all_ido=egeszzam_ora.toFixed(2);
ki_all_ido=ki_all_ido.replace(".", ",");
var osszesen_tooltip="<table border=0 cellpadding=0 cellspacing=0 id='osszesen_all_ki_tooltipp' class='table_emre_bejovo'>";
osszesen_tooltip+="<thead><tr><th><th>Óra:perc<th>Óra";
osszesen_tooltip+="</tr></thead>";
osszesen_tooltip+="<tbody><tr>";
osszesen_tooltip+="<td><b>Összesen</b><td>"+ki_all_ido_ora+":"+ki_all_ido_perc+"<td>"+ki_all_ido;

hoprojekt_all_ido_nev=hoprojekt_all_ido_nev.sort();

for (var i=0;i<hoprojekt_all_ido_nev.length;i++){
 var i_projnev=hoprojekt_all_ido_nev[i];
 var ora_all_tipp_ki=hoprojekt_all_ido_ora[i_projnev]['ora_ki'];
 var perc_all_tipp_ki=hoprojekt_all_ido_ora[i_projnev]['perc_ki'];
 
 if(
 (ora_all_tipp_ki!="0") ||(ora_all_tipp_ki=="0" && perc_all_tipp_ki!="0")
 ){
  osszesen_tooltip+="<tr>";
  osszesen_tooltip+="<td>";
  osszesen_tooltip+=i_projnev;
  osszesen_tooltip+="<td>";
  osszesen_tooltip+=ora_all_tipp_ki;
  osszesen_tooltip+=":";
  osszesen_tooltip+=perc_all_tipp_ki;
   if(perc_all_tipp_ki=="0") osszesen_tooltip+="0";
   
	var proj_egeszzam_ora=ora_all_tipp_ki;
	proj_egeszzam_ora+=Number(perc_all_tipp_ki)/60;
	var proj_ki_all_ido=proj_egeszzam_ora.toFixed(2);
	proj_ki_all_ido=proj_ki_all_ido.replace(".", ",");
	osszesen_tooltip+="<td>";
	osszesen_tooltip+=proj_ki_all_ido;

  osszesen_tooltip+="</tr>";
 }	
};

osszesen_tooltip+="</tr></tbody>";
osszesen_tooltip+="</table>";
//összesen tooltip - vége	
//console.log(osszesen_tooltip);

//$("#rogzit_ho_all_td").attr("title",osszesen_tooltip);
///////$("#title_rogzit_ho_all_td").html(osszesen_tooltip);
setTimeout(function(){$("#title_rogzit_ho_all_td").html(osszesen_tooltip);},0);
//tooltip_proc();

}

var ki_all_ido_ora=0;
var ki_all_ido_perc=0;
function osszesen_all_ki(){
var ki_all_ido=0;
ki_all_ido_ora=0;
ki_all_ido_perc=0;

//Tört összesen
for(var i=0;i<ho_all_ido_ora.length;++i){
    if(typeof ho_all_ido_ora[i]!=="undefined"){
	 ki_all_ido_ora+=Number(ho_all_ido_ora[i]);
	 ki_all_ido_perc+=Number(ho_all_ido_perc[i]);
	}

    //if(typeof ho_all_ido[i]!=="undefined")
	 //ki_all_ido+=Number(ho_all_ido[i]);

}

//Óra perc összesen
ki_all_ido_ora+=Math.floor(ki_all_ido_perc/60);
ki_all_ido_perc=ki_all_ido_perc % 60;
if(ki_all_ido_perc<10)ki_all_ido_perc="0"+ki_all_ido_perc;



$("#rogzit_ho_all_td").html(ki_all_ido_ora+":"+ki_all_ido_perc);

//console.log(ki_all_ido);
//console.log(ki_all_ido_ora+":"+ki_all_ido_perc);
}

function osszesen_nap(nap_akt,all_ki){
//Összeszámlja az aznapi cuccokat.

var ora_ki=0;
var perc_ki=0;
var max_ora="";
var max_perc="";
$('input[id^=input_proj_'+nap_akt+'_]').each(function(){
	var _this=$(this);
	if(!_this.prop("disabled")){
		//if(isNaN(value)){
		var d1=_this.val().split(":");
		
		var ora_most=Number(d1[0]);
		ora_ki+=ora_most;
		if(typeof d1[1]!=="undefined"){
		  var perc_most=Number(d1[1]);
		  perc_ki+=perc_most;
		  
		  if(max_ora==""){
		   max_ora=_this.attr("max_ora");
		  }
		  if(max_perc==""){
		   max_perc=_this.attr("max_perc");
		  }
		}else{
			var perc_most=0;
		}
		
		  //válaszott projekt név - eleje
		  var proj_sel_id=this.id.replace("input_","");
		  var proj_nev=$("#"+proj_sel_id+" option:selected").text();

		  if(hoprojekt_all_ido_ora[proj_nev]===undefined){
			hoprojekt_all_ido_nev[proj_nev_szam]=proj_nev;
			hoprojekt_all_ido_ora[proj_nev]=new Array();
			hoprojekt_all_ido_ora[proj_nev]['ora_ki']=ora_most;
			hoprojekt_all_ido_ora[proj_nev]['perc_ki']=perc_most;
			proj_nev_szam++;
		  }else{
			hoprojekt_all_ido_ora[proj_nev]['ora_ki']+=ora_most;
			hoprojekt_all_ido_ora[proj_nev]['perc_ki']+=perc_most;
		  }
		  //válaszott projekt név - vége
		
	}
});

//Jóváhagyott sor
$('span[id^=spanido_proj_'+nap_akt+'_]').each(function(){
	var _this=$(this);
	
		//if(isNaN(value)){
		var d1=_this.html().split(":");
		var ora_most=Number(d1[0]);
		ora_ki+=ora_most;
		if(typeof d1[1]!=="undefined"){
		  var perc_most=Number(d1[1]);
		  perc_ki+=perc_most;
		}else{
		  var perc_most=0;	
		}
	
		  //válaszott projekt név - eleje
		  var proj_nev=$("#proj_"+this.id).html();
		  if(hoprojekt_all_ido_ora[proj_nev]===undefined){
			hoprojekt_all_ido_nev[proj_nev_szam]=proj_nev;
		    hoprojekt_all_ido_ora[proj_nev]=new Array();
			hoprojekt_all_ido_ora[proj_nev]['ora_ki']=ora_most;
			hoprojekt_all_ido_ora[proj_nev]['perc_ki']=perc_most;
			proj_nev_szam++;
		  }else{
			hoprojekt_all_ido_ora[proj_nev]['ora_ki']+=ora_most;
			hoprojekt_all_ido_ora[proj_nev]['perc_ki']+=perc_most;
		  }
		  //válaszott projekt név - vége
	
});




ora_ki+=Math.floor(perc_ki/60);
perc_ki=perc_ki % 60;
if(perc_ki<10)perc_ki="0"+perc_ki;

if(
(ora_ki=="0" || ora_ki=="00")
&& (perc_ki=="00")){
 $("#all_nap_"+nap_akt).html("");
}else{
 //egészszám
  var egeszzam_ora=ora_ki;
  egeszzam_ora+=Number(perc_ki)/60;
  var egeszzam_ora_ketto=egeszzam_ora.toFixed(2);
  var tort_ora=egeszzam_ora_ketto.replace(".", ",");

  //Hó  összesen
  //ho_all_ido[nap_akt]=egeszzam_ora_ketto;
  ho_all_ido_ora[nap_akt]=ora_ki;
  ho_all_ido_perc[nap_akt]=perc_ki;
  
 
 if(
 (
  (max_ora!="")&&
  (Number(ora_ki)>Number(max_ora))
 )||(
  (max_ora!="")&&
  (Number(ora_ki)==Number(max_ora))&&
  (perc_ki!="00")
  &&(Number(perc_ki)>Number(max_perc))
 )
 ){
	 var css="class='pir_vas_tooltip'";
 }else{
	 var css="class='linkm_tooltip'";
 }
 $("#all_nap_"+nap_akt).html("<span "+css+" title='"+tort_ora+"'>"+ora_ki+":"+perc_ki+"</span>");
 //$("#all_nap_"+nap_akt).html("<span title='"+tort_ora+"'>"+ora_ki+":"+perc_ki+"</span>");
 
 
 
}
if(all_ki=="1")
 osszesen_all_ki();
/*else//V1.062 kapcsoltam ki
 tooltip_proc();
*/
}


function proj_szabi_change(ev,nap_akt){
var v=$("#proj_szabi_"+nap_akt).prop("checked");
if(v){//Naphoz tartozó cucc törlése mert szabin van

 
 //1. - 2. Nap törlésének mentése DB-nen szabadság miatt! És a szabadság státusz mentése. és kiírása is.
 rogzit_szabadsag_igen(nap_akt);
 
}else{//Naphoz tartozó cucc engedélyezése
 rogzit_szabadsag_nem(ev,nap_akt);
}
}

var ajax_keres_rogzit_szabadsag_nem=null;
function rogzit_szabadsag_nem(ev,nap_akt){

if(ajax_keres_rogzit_szabadsag_nem!=null){
 ajax_keres_rogzit_szabadsag_nem.abort();
}

ajax_keres_rogzit_szabadsag_nem=$.post(ajaxstat_p_ut,"mod=tavollet_rogzit_del&nap="+nap_akt,
	function(d){
	ajax_keres_rogzit_szabadsag_nem=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //1. szabadság szöveg törlése
	 $("#td_proj_"+nap_akt).html("");
	 //2 első sor hozzáadása
	 raford_projekt_select_addsor(ev,nap_akt,"1","1");
	}else if(d1[0]=="nookreload"){
	 fopage_reopen();
	}else{
	 //alert("Hiba");
	}
});
}

var rogzit_szabadsag_igen=null;
function rogzit_szabadsag_igen(nap_akt){
//Adott nap teljes törlése!
var megj=encodeURIComponent($("#td_textarea_"+nap_akt).val());

if(rogzit_szabadsag_igen!=null){
 rogzit_szabadsag_igen.abort();
}

rogzit_szabadsag_igen=$.post(ajaxstat_p_ut,"mod=tavollet_rogzit_ment&nap="+nap_akt+"&megj="+megj,
	function(d){
	rogzit_szabadsag_igen=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	  //1. adatok törlése vizuálisan
	 //Csak ha a mentés sikeres
	 $("#td_proj_"+nap_akt).html("<div class='div_szabi'>Távollét</div>");
	 
	 //Nap összesítés kuka!f
	 $("#all_nap_"+nap_akt).html("");
	 
	 //Havi összesítést is el kell rendezni - eleje
		ho_all_ido_ora[nap_akt]=0;
		ho_all_ido_perc[nap_akt]=0;
		osszesen_all_ki();
	 //Havi összesítést is el kell rendezni - vége
	 
	 rogzit_textrarea_meretezes(nap_akt);
	}else if(d1[0]=="nookreload"){
	 fopage_reopen();
	}else{
	 //alert("Hiba");
	}
});

}

//var rogzit_megj_ment_wait_val="";
var rogzit_megj_ment_wait_val=new Array();
function rogzit_megj_ment_wait(nap_akt){
  clearTimeout(rogzit_megj_ment_wait_val[nap_akt]);
  rogzit_megj_ment_wait_val[nap_akt] = setTimeout(function(){rogzit_megj_ment(nap_akt);},200);
  
  /*
  clearTimeout($.data(this, 'timer'));
  //var wait = setTimeout(kereses_bejovo_tal,200);
  var wait = setTimeout(function(){rogzit_megj_ment(nap_akt);},100);
  $(this).data('timer', wait);
  */
}

//var ajax_keres_rogzit_megj_ment=null;
var ajax_keres_rogzit_megj_ment=new Array();
function rogzit_megj_ment(nap_akt){
if($("#td_textarea_"+nap_akt).length){
//var megj=encodeURIComponent($("#td_textarea_"+nap_akt).val());
var megj=$("#td_textarea_"+nap_akt).val();

if(ajax_keres_rogzit_megj_ment[nap_akt]!=null){
 ajax_keres_rogzit_megj_ment[nap_akt].abort();
}

/*
ajax_keres_rogzit_megj_ment[nap_akt]=$.post(ajaxstat_p_ut,{
mod: "rogzit_megj_ment",
nap: nap_akt,
ev: ev,
ho: ho,
megj: megj
},
*/

//ajax_keres_rogzit_megj_ment[nap_akt]=$.post(ajaxstat_p_ut,"mod=rogzit_megj_ment&nap="+nap_akt+"&megj="+megj,
ajax_keres_rogzit_megj_ment[nap_akt]=$.post(ajaxstat_p_ut,"mod=rogzit_megj_ment&nap="+encodeURIComponent(nap_akt)+"&megj="+encodeURIComponent(megj)+"&ev="+global_ev+"&ho="+global_ho+"&user_ad="+global_user,
	function(d){
	ajax_keres_rogzit_megj_ment[nap_akt]=null;
	/*var d1=d.split("$;$");
	if(d1[0]=="ok"){
	  
	}else*/
	if(d=='ok$;$'){
		return true;
	}else if(d=='nookreload'){
		reload_disabled();
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
},"text");
}
}

//Nézzük meg, hogy van-e kapcsolat a szerverrel, last_projekt_id miatt
var ajax_keres_rogzit_elkuld_ell=null;
function rogzit_elkuld_ell(ev,ho,ho_str){

$("#sel_melyik_holezargomb").prop("disabled",true);
if(ajax_keres_rogzit_elkuld_ell!=null){
 ajax_keres_rogzit_elkuld_ell.abort();
}

ajax_keres_rogzit_elkuld_ell=$.post(ajaxstat_p_ut,"mod=rogzit_elkuld_ell_allment_vanenet&ev="+global_ev+"&ho="+global_ho+"&user_ad="+global_user,
	function(d){
	ajax_keres_rogzit_elkuld_ell=null;
	$("#sel_melyik_holezargomb").prop("disabled",false);
	if(d=="ok$;$"){
	 rogzit_elkuld_ell_van_net(ev,ho,ho_str);
	}else if(d=='nookreload'){
		reload_disabled();
	}else{
	 diaglog_open("Hiba! Nincs kapcsolat a szerverrel!",""+ho_str+" hónap lezárása");
	 tooltip_proc();
	}
//},"text").fail(function(xhr, status, error) {
},"text").fail(function() {
        ajax_keres_rogzit_elkuld_ell = null; // Takarítás
		// --- Ez a rész fut le HIBA (nem 200, pl. 404, 500) esetén ---
        //console.error("Ajax hiba: " + error); // Debugoláshoz
        $("#sel_melyik_holezargomb").prop("disabled",false);
        // Ide írd a parancsot, amit futtatni szeretnél hiba esetén:
        diaglog_open("Hiba! Nincs kapcsolat a szerverrel!",""+ho_str+" hónap lezárása");
		tooltip_proc();
        
});
}

function rogzit_elkuld_ell_van_net(ev,ho,ho_str){

var par='';
$('input[id^=input_proj_]').each(function(){
	var _this=$(this);
	if(!_this.prop("disabled")){
		var d=this.id.split("_");
		var nap_akt=encodeURIComponent(d[2]);
		var sorsz=encodeURIComponent(d[3]);
		var _this_projekt=$("#proj_"+nap_akt+"_"+sorsz);
		//var projekt_id=encodeURIComponent($("#proj_"+nap_akt+"_"+sorsz).val());
		var projekt_id=encodeURIComponent(_this_projekt.val());
		//var ido=encodeURIComponent($("#input_proj_"+nap_akt+"_"+sorsz).val());
		var ido=encodeURIComponent(_this.val());
		//var last_sel_id=encodeURIComponent($("#proj_"+nap_akt+"_"+sorsz).attr('last_sel_id'));
		var last_sel_id=encodeURIComponent(_this_projekt.attr('last_sel_id'));
		//nap=n
		//sorsz=s
		//ido=i
		//projekt_it=p
		//projekt_id_last nem küldjük át, mindog üres dde ez az l!
		//par+="&nap="+nap_akt+"&sorsz="+sorsz+"&ido="+ido+"&projekt_id="+projekt_id+"&projekt_id_last=";
		//&& last_sel_id
		if(nap_akt && sorsz && projekt_id  && ido && nap_akt!="" && sorsz!='' && projekt_id!='' && ido!=''){
		 if(par!='')par+="$";
		 par+="n-"+nap_akt+"_s-"+sorsz+"_i-"+ido+"_p-"+projekt_id;
		 if(projekt_id!=last_sel_id){
			par+='_l-'+last_sel_id;
			//$("#proj_"+nap_akt+"_"+sorsz).attr('last_sel_id',projekt_id);
			_this_projekt.attr('last_sel_id',projekt_id);
		 }else{
			par+='_l-'; 
		 }
		}
	}
});

if(par!=''){
 rogzit_elkuld_ell_allment(par,ev,ho,ho_str);
}else{//Ekkor nincs adat pl: hétvége látható csak, nézzük meg a lezárást!
 rogzit_elkuld_ell_elkuld(ev,ho,ho_str);
}
//var nap_akt=d[2];
//var sorsz=d[3];
//rogzit_ment(nap_akt,sorsz,"");


}

var ajax_keres_rogzit_elkuld_ell_allment=null;
function rogzit_elkuld_ell_allment(par,ev,ho,ho_str){
if(ajax_keres_rogzit_elkuld_ell_allment!=null){
 ajax_keres_rogzit_elkuld_ell_allment.abort();
}

ajax_keres_rogzit_elkuld_ell_allment=$.post(ajaxstat_p_ut,"mod=rogzit_elkuld_ell_allment&par_ment="+par,
	function(d){
	ajax_keres_rogzit_elkuld_ell_allment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 rogzit_elkuld_ell_elkuld(ev,ho,ho_str);
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],""+ho_str+" hónap lezárása");
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
},"text");
}

var ajax_keres_rogzit_elkuld_ell=null;
function rogzit_elkuld_ell_elkuld(ev,ho,ho_str){

if(ajax_keres_rogzit_elkuld_ell!=null){
 ajax_keres_rogzit_elkuld_ell.abort();
}

ajax_keres_rogzit_elkuld_ell=$.post(ajaxstat_p_ut,"mod=rogzit_elkuld_ell&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_rogzit_elkuld_ell=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 rogzit_elkuld_ell_proc(ev,ho,ho_str);
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],""+ho_str+" hónap lezárása");
	 tooltip_proc();
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
},"text");
}

function rogzit_elkuld_ell_proc(ev,ho,ho_str){

	var title_ki=ho_str+" hónap lezárása?";
	var d="<b>Biztos, hogy lezárod az "+ho_str+" hónapot?</b>";
	d+="<br><br>További módosítás már nem lehetséges!";
	$("#dialog_egyeni_close").html(d).dialog({
	title: title_ki,
	buttons: {
        "Igen": function() {
		 rogzit_elkuld_ell_proc_kerd_utan(ev,ho);
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

var ajax_keres_rogzit_elkuld_ell_proc_kerd_utan=null;
function rogzit_elkuld_ell_proc_kerd_utan(ev,ho){

if(ajax_keres_rogzit_elkuld_ell_proc_kerd_utan!=null){
 ajax_keres_rogzit_elkuld_ell_proc_kerd_utan.abort();
}

ajax_keres_rogzit_elkuld_ell_proc_kerd_utan=$.post(ajaxstat_p_ut,"mod=rogzit_elkuld_ell_proc_kerd_utan&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_rogzit_elkuld_ell_proc_kerd_utan=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
		if(typeof akt_ful==="undefined" || akt_ful=="")//Ekkor tabozni kell
		 fo_table_evho_elsoki();
		else
	     ful_betolt(akt_ful);
	  $('#dialog_egyeni_close').dialog("close");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	 $('#dialog_egyeni_close').dialog("close");
	}
},"text");
}

function fo_table_helyettes_change(){
fo_table_ki();
}

var ajax_keres_rogzito_helyettes_beallit=null;
function rogzito_helyettes_beallit(){

$("#gomb_helyettes_beallit").prop("disabled",true);
if(ajax_keres_rogzito_helyettes_beallit!=null){
 ajax_keres_rogzito_helyettes_beallit.abort();
}

ajax_keres_rogzito_helyettes_beallit=$.post(ajaxstat_p_ut,"mod=rogzito_helyettes_beallit",
	function(d){
	ajax_keres_rogzito_helyettes_beallit=null;
	$("#gomb_helyettes_beallit").prop("disabled",false);
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 diaglog_open(d1[1],"Helyettes beállítása");
	}else if(d1[0]=="nook"){
	 str="Hiba!<br><br>Helyettesítés esetén nincs jogosultságod további helyettes beállításá";
	 diaglog_open(str,"Hiba!");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
},"text");
}

function user_modhelyettes_hozz_keress_par(){
var keress_nev=encodeURIComponent($("#modhelyettes_hozzid_keress").val());
if($("#modhelyettes_hozzid_csakhozz_szur").prop("checked"))
 var csakvan=1;
else var csakvan=0;

var par="&keress_nev="+keress_nev+"&csakvan="+csakvan;
return par;
}

var user_modhelyettes_hozz_keress_fo_wait="";
function user_modhelyettes_hozz_keress(id_honnan,hol_lep){
  clearTimeout(user_modhelyettes_hozz_keress_fo_wait);
  user_modhelyettes_hozz_keress_fo_wait = setTimeout(function(){user_modhelyettes_hozz_keress_proc(id_honnan,hol_lep);},100);
}

var ajax_keres_modhelyettes_hozz_keress=null;
function user_modhelyettes_hozz_keress_proc(id_honnan,hol_lep){

var ker_par=emre_keres_oldalas_ker_par(id_honnan,hol_lep,"user_modhelyettes_keres_tal_oldalholvagyok","user_modhelyettes_keres_tal_oldalmax","user_modhelyettes_keres_talszam","user_modhelyettes_hozz_keress_proc");

var par=user_modhelyettes_hozz_keress_par();

if(ajax_keres_modhelyettes_hozz_keress!=null){
 ajax_keres_modhelyettes_hozz_keress.abort();
}

ajax_keres_modhelyettes_hozz_keress=$.post(ajaxstat_p_ut,"mod=user_modhelyettes_hozz_keress"+ker_par+par,
	function(d){
	ajax_keres_modhelyettes_hozz_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#userhelyettes_hozzid_tal_div").html(d1[1]);
	 alap_input_select_most();
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");

}

function user_modhelyettes_hozz_change(user_ad){
if($("#userhelyettes_hozzid_"+user_ad).prop("checked")){
 var mit=1;	
}else{
 var mit=0;
}

$.post(ajaxstat_p_ut,"mod=user_modhelyettes_hozz_change&mit="+mit+"&user_ad="+user_ad,
	function(d){
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 //$("#modhelyettes_hozzid_csakhozz_szur").prop("checked",false);
	 //admin_muv_sel();
	 if($("#admin_userlist_keres_nev").length)//Csak admin felületen
	  admin_userlist_keres("","");
	 if(mit==0){//Csak ha kivettük a pipát, bepipálásnál semmi értelme (Szűrés miatt)
	   user_modhelyettes_hozz_keress("","");
	 }
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	},"text");
}
