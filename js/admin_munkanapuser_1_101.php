<?php

?>



var ajax_keres_admin_munkanapuser_uj_ment=null;
function admin_munkanapuser_uj_ment(){
var user_ad=encodeURIComponent($("#munkanapuser_uj_user option:selected").val());
//if(user_ad=="keremv"){
if(user_ad==="undefined"){
 var d="Hiba!<br><br>Felhasználó kiválasztása kötelező!";
 diaglog_open(d,"Rendszerhiba");
 return false;
}else{
 
}

var munkanap=encodeURIComponent($("#munkanapuser_uj_munkanap").val());
if(munkanap==""){
 var d="Hiba!<br><br>Dátum kiválasztása kötelező!";
 diaglog_open(d,"Rendszerhiba");
 return false;
}

var tipus=encodeURIComponent($("#munkanapuser_uj_tipus option:selected").val());
if(tipus=="keremv"){
 var d="Hiba!<br><br>Típus kiválasztása kötelező!";
 diaglog_open(d,"Rendszerhiba");
 return false;
}

var par="&user_ad="+user_ad+"&munkanap="+munkanap+"&tipus="+tipus;

if(ajax_keres_admin_munkanapuser_uj_ment!=null){
 ajax_keres_admin_munkanapuser_uj_ment.abort();
}

ajax_keres_admin_munkanapuser_uj_ment=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=munkanapuser_uj_ment"+par,
	function(d){
	ajax_keres_admin_munkanapuser_uj_ment=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba");
	}else{
	 diaglog_open(d,"Rendszerhiba");	
	}
	});
}

var ajax_keres_admin_munkanapuser_del=null;
function admin_munkanapuser_del(user_ad,munkanap){
var par="&user_ad="+user_ad+"&munkanap="+munkanap;

if(ajax_keres_admin_munkanapuser_del!=null){
 ajax_keres_admin_munkanapuser_del.abort();
}

ajax_keres_admin_munkanapuser_del=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=munkanapuser_del"+par,
	function(d){
	ajax_keres_admin_munkanapuser_del=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 admin_muv_sel();
	}else if(d1[0]=="nook"){
	 diaglog_open(d1[1],"Hiba");
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	});	
}

var ajax_keres_admin_munkanapuser_keress=null;
function admin_munkanapuser_keress(){
var limit=encodeURIComponent($("#munkanapuser_keress_max_tal option:selected").val());

if(ajax_keres_admin_munkanapuser_keress!=null){
 ajax_keres_admin_munkanapuser_keress.abort();
}

ajax_keres_admin_rogzito_helyettes_beallit=$.post(ajaxstat_a_ut,"admin_mod=func&muvelet=admin_munkanapuser_keress&limit="+limit,
	function(d){
	ajax_keres_admin_munkanapuser_keress=null;
	var d1=d.split("$;$");
	if(d1[0]=="ok"){
	 $("#admin_tal").html(d1[1]);
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
});
}	


function inp_auto_start_munkanapuser_uj_user(){

$('#munkanapuser_uj_user').select2({
 dropdownAutoWidth : true,
placeholder: "Kérem válassz",
maximumInputLength:50,
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
                url: 'search_admin.php',
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
                    return {
                        mod:"admin_munkanapuser_uj_user",
                        q: q_ki,
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

});



//Első jó megoldás

//$(document).on('select2:open', () => {
$('#munkanapuser_uj_user').on('select2:open',function(){
    document.querySelector('.select2-search__field').focus();
	//tooltip_proc();
  });
}

