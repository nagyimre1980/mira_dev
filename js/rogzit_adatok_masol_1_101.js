
var ajax_keres_rogzit_adatok_masol=null;
function rogzit_adatok_masol(){

var ev=encodeURIComponent($("#sel_melyik_ev").val());
var ho=encodeURIComponent($("#sel_melyik_ho").val());

if(ajax_keres_rogzit_adatok_masol!=null){
 ajax_keres_rogzit_adatok_masol.abort();
}

ajax_keres_rogzit_adatok_masol=$.post(ajaxstat_p_ut,"mod=rogzit_adatok_masol&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_rogzit_adatok_masol=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 rogzit_adatok_masol_proc(d1[1],d1[2],ev,ho);
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});

}

function rogzit_adatok_masol_proc(title_ki,d,ev,ho){

//var title_ki="Nap másolása";
	$("#dialog_egyeni_close").html(d).css('background-color','#E5E5E5').dialog({
	title: title_ki,
	buttons: {
		
		"masolas":{
                    click: function () {
					 $(this).dialog('widget').find('button').prop('disabled',true);
                     rogzit_adatok_masol_proc_ment(ev,ho);
                    },
                    'text': 'Másolás',
                    'class': 'submit2'
		
		},
		"megse":{
                    click: function () {
                     //$("#admin_modkapcstorzs_inaktiv_"+id).prop("checked",false);
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
		$(this).css('background-color','#fff');
        }
	}).dialog( "open" );
}

function rogzit_adatok_masol_proc_ment(ev,ho){

var masol_nap='';
$('input[id^=masolasradio_]').each(function(){
 var _this=$(this);
 if(_this.prop("checked")){
  var d=this.id.split("_");
  masol_nap=d[1];
 }
});

if(masol_nap==''){
 $('#dialog_egyeni_close').dialog('widget').find('button').prop('disabled',false)
 diaglog_open("Hiba!<br><br>Másolás napját nem választottad ki!","Rendszerhiba","del_behajtani16.png");
 return false;
}

var beilleszt_nap="";
$('input[id^=beillesztck_]').each(function(){
 var _this=$(this);
 if(_this.prop("checked")){
  var d=this.id.split("_");
  beilleszt_nap+=d[1]+";";
 }
});

if(beilleszt_nap==''){
 $('#dialog_egyeni_close').dialog('widget').find('button').prop('disabled',false);
 diaglog_open("Hiba!<br><br>Beillesztés napjait nem választottad ki!","Rendszerhiba","del_behajtani16.png");
 return false;
}

rogzit_adatok_masol_proc_ment_proc(ev,ho,masol_nap,beilleszt_nap);
}

var ajax_keres_rogzit_adatok_masol_proc_ment_proc=null;
function rogzit_adatok_masol_proc_ment_proc(ev,ho,masol_nap,beilleszt_nap){

if(ajax_keres_rogzit_adatok_masol_proc_ment_proc!=null){
 ajax_keres_rogzit_adatok_masol_proc_ment_proc.abort();
}

ajax_keres_rogzit_adatok_masol_proc_ment_proc=$.post(ajaxstat_p_ut,"mod=rogzit_adatok_masol_proc_ment_proc&ev="+ev+"&ho="+ho+"&masol_nap="+masol_nap+"&beilleszt_nap="+beilleszt_nap,
	function(d){
	ajax_keres_rogzit_adatok_masol_proc_ment_proc=null;
	var d1=d.split("$;$");
	 $('#dialog_egyeni_close').dialog('widget').find('button').prop('disabled',false);
	if(d1[0]=="ok"){
	 //diaglog_open(d,"Rendszerhiba");
	 $('#dialog_egyeni_close').dialog('close');
	 
	 if($('#fo_div_notab').length){
	  fo_table_evho_elsoki();
	 }else{//Ekkor tabozni kell
	  ful_betolt(akt_ful);
	 }
	 
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	});
}

function rogzit_adatok_masol_beilleszt_ckall(){
var ckall=$("#beillesztckall").prop("checked");

if(ckall){
 $('input[id^=beillesztck_]').each(function(){
	$(this).prop("checked",true);
 });
}else{
 $('input[id^=beillesztck_]').each(function(){
	$(this).prop("checked",false);
 });
}
}

function rogzit_adatok_masol_beilleszt_ckegy(){

var all_ck=0;
var be_ck=0;
 $('input[id^=beillesztck_]').each(function(){
	all_ck++;
	if($(this).prop("checked"))be_ck++;
 });

if(all_ck==be_ck){
 $("#beillesztckall").prop("checked",true);
}else{
 $("#beillesztckall").prop("checked",false);
}

}


