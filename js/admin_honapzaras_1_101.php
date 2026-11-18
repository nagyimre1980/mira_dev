<?php

?>


var ajax_keres_admin_honapzaras_evszures_change=null;
function admin_honapzaras_evszures_change(){
var honapzar_ev_szures=encodeURIComponent($("#admin_honapzaras_evszures_ev").val());
 
if(ajax_keres_admin_honapzaras_evszures_change!=null){
 ajax_keres_admin_honapzaras_evszures_change.abort();
}

ajax_keres_admin_honapzaras_evszures_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_honapzaras_evszures_change&honapzar_ev_szures="+honapzar_ev_szures,
	function(d){
	ajax_keres_admin_honapzaras_evszures_change=null;
	if(d=="ok$;$"){
	 admin_muv_sel();	
	}else{//Lezárás sikeres, terv DB meg kell mutatni.
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
	
}

var ajax_keres_admin_honapzaras_change=null;
function admin_honapzaras_change(ev_ho){
var ck=$("#admin_honapzaras_ck_"+ev_ho).prop("checked");
if(ck){
 var lezar=1;
}else{
 var lezar=0;
}

if(ajax_keres_admin_honapzaras_change!=null){
 ajax_keres_admin_honapzaras_change.abort();
}

ajax_keres_admin_honapzaras_change=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_honapzaras_change&lezar="+lezar+"&ev_ho="+encodeURIComponent(ev_ho),
	function(d){
	ajax_keres_admin_honapzaras_change=null;
	if(d!="ok$;$"){
	 diaglog_open(d,"Rendszerhiba");	
	}else{//Lezárás sikeres, terv DB meg kell mutatni.
	 if(lezar==1)
	  $("#terv_lat_"+ev_ho).css('display','inline');
	 else
	  $("#terv_lat_"+ev_ho).css('display','none');
	}
	});
}


