
var ajax_keres_riport_tervteny_adat_ment=null;
function riport_tervteny_adat_ment(){

if(ajax_keres_riport_tervteny_adat_ment!=null){
 ajax_keres_riport_tervteny_adat_ment.abort();
}

var tipus1=encodeURIComponent($("#riport_tervteny_sel_tipus1").val());
var tipus2=encodeURIComponent($("#riport_tervteny_sel_tipus2").val());
var par='&tipus1='+tipus1+'&tipus2='+tipus2;

ajax_keres_riport_tervteny_adat_ment=$.post(ajaxstat_p_ut,"mod=riport_tervteny_adat_ment"+par,
	function(d){
	ajax_keres_riport_tervteny_adat_ment=null;
	if(d.slice(0,5)=="ok$;$"){
		
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");	

}

function riport_tervteny_tipus_beallit(){

var ev1=$("#riport_tervteny_sel_ev1").val();
if(ev1){
var ev2=$("#riport_tervteny_sel_ev2").val();

var tipus1=$("#riport_tervteny_sel_tipus1").val();
var tipus2=$("#riport_tervteny_sel_tipus2").val();

if(ev1=='keremv'){//Minden tiltása
 $("#riport_tervteny_sel_szerv1_contdiv,#riport_tervteny_sel_proj1_contdiv,#riport_tervteny_sel_szolgkod1_contdiv,#riport_tervteny_sel_tagv1_contdiv,#riport_tervteny_sel_user1_contdiv").css('display','none');
 $("#riport_tervteny_sel_reszlet1_div,#riport_tervteny_sel_reszlet1terv_div").css("display","none");
}else{
 if(tipus1=='terv'){
  $("#riport_tervteny_sel_szerv1_contdiv,#riport_tervteny_sel_proj1_contdiv,#riport_tervteny_sel_user1_contdiv").css('display','none');
  $("#riport_tervteny_sel_szolgkod1_contdiv,#riport_tervteny_sel_tagv1_contdiv").css('display','inline-block');
  $("#riport_tervteny_sel_reszlet1_div").css("display","none");
  $("#riport_tervteny_sel_reszlet1terv_div").css("display","block");
 }else if(tipus1=='teny'){
  $("#riport_tervteny_sel_szerv1_contdiv,#riport_tervteny_sel_proj1_contdiv,#riport_tervteny_sel_szolgkod1_contdiv,#riport_tervteny_sel_tagv1_contdiv,#riport_tervteny_sel_user1_contdiv").css('display','inline-block');
  $("#riport_tervteny_sel_reszlet1_div").css("display","block");
  $("#riport_tervteny_sel_reszlet1terv_div").css("display","none");
 }
}


if(ev2=='keremv'){//Minden tiltása
 $("#riport_tervteny_sel_szerv2_contdiv,#riport_tervteny_sel_proj2_contdiv,#riport_tervteny_sel_szolgkod2_contdiv,#riport_tervteny_sel_tagv2_contdiv,#riport_tervteny_sel_user2_contdiv").css('display','none');
 //$("#riport_tervteny_sel_reszlet2_div").css("display","none");
}else{
 if(tipus2=='terv'){
  $("#riport_tervteny_sel_szerv2_contdiv,#riport_tervteny_sel_proj2_contdiv,#riport_tervteny_sel_user2_contdiv").css('display','none');
  $("#riport_tervteny_sel_szolgkod2_contdiv,#riport_tervteny_sel_tagv2_contdiv").css('display','inline-block');
  //$("#riport_tervteny_sel_reszlet2_div").css("display","none");
 }else if(tipus2=='teny'){
  $("#riport_tervteny_sel_szerv2_contdiv,#riport_tervteny_sel_proj2_contdiv,#riport_tervteny_sel_szolgkod2_contdiv,#riport_tervteny_sel_tagv2_contdiv,#riport_tervteny_sel_user2_contdiv").css('display','inline-block');
  //$("#riport_tervteny_sel_reszlet2_div").css("display","block");
 }
}

}
}

/*
function riport_tervteny_tipus_beallit_old(){

var tipus=$("#riport_tervteny_sel_tipus1").val();
if(tipus=='teny'){
 $("#riport_tervteny_sel_ev1,#riport_tervteny_sel_szerv1_contdiv,#riport_tervteny_sel_proj1_contdiv,#riport_tervteny_sel_szolgkod1_contdiv,#riport_tervteny_sel_tagv1_contdiv,#riport_tervteny_sel_user1_contdiv").css('display','inline-block');
 //$("#riport_tervteny_sel_reszlet1").next(".select2-container").show();
 $("#riport_tervteny_sel_reszlet1_div").css("display","block");
}else if(tipus=='terv'){//terv
 
 $("#riport_tervteny_sel_ev1,#riport_tervteny_sel_ho1_contdiv,#riport_tervteny_sel_szolgkod1_contdiv,#riport_tervteny_sel_tagv1_contdiv").css('display','inline-block');
 $("#riport_tervteny_sel_szerv1_contdiv,#riport_tervteny_sel_proj1_contdiv,#riport_tervteny_sel_user1_contdiv").css('display','none');
 
 //$("#riport_tervteny_sel_reszlet1").next(".select2-container").hide();
 $("#riport_tervteny_sel_reszlet1_div").css("display","none");
}else{//Kérem válassz
 $("#riport_tervteny_sel_ev1,#riport_tervteny_sel_ho1_contdiv,#riport_tervteny_sel_szerv1_contdiv,#riport_tervteny_sel_proj1_contdiv,#riport_tervteny_sel_szolgkod1_contdiv,#riport_tervteny_sel_tagv1_contdiv,#riport_tervteny_sel_user1_contdiv").css('display','none');
 //$("#riport_tervteny_sel_reszlet1").next(".select2-container").hide();
 $("#riport_tervteny_sel_reszlet1_div").css("display","none");
}


var tipus=$("#riport_tervteny_sel_tipus2").val();
if(tipus=='teny'){
 $("#riport_tervteny_sel_ev2,#riport_tervteny_sel_szerv2_contdiv,#riport_tervteny_sel_proj2_contdiv,#riport_tervteny_sel_szolgkod2_contdiv,#riport_tervteny_sel_tagv2_contdiv,#riport_tervteny_sel_user2_contdiv").css('display','inline-block');
}else if(tipus=='terv'){//terv
 $("#riport_tervteny_sel_ev2,#riport_tervteny_sel_ho2_contdiv,#riport_tervteny_sel_szolgkod2_contdiv,#riport_tervteny_sel_tagv2_contdiv").css('display','inline-block');
 $("#riport_tervteny_sel_szerv2_contdiv,#riport_tervteny_sel_proj2_contdiv,#riport_tervteny_sel_user2_contdiv").css('display','none'); 
}else{//Kérem válassz
 $("#riport_tervteny_sel_ev2,#riport_tervteny_sel_ho2_contdiv,#riport_tervteny_sel_szerv2_contdiv,#riport_tervteny_sel_proj2_contdiv,#riport_tervteny_sel_szolgkod2_contdiv,#riport_tervteny_sel_tagv2_contdiv,#riport_tervteny_sel_user2_contdiv").css('display','none');
}
}
*/

function riport_tervteny_tipus1_change(){

var tipus1=$("#riport_tervteny_sel_tipus1").val();
var tipus2=$("#riport_tervteny_sel_tipus2").val();
if(tipus1=='terv' && tipus2=='teny'){
	$("#riport_tervteny_sel_tipus2").val('terv').trigger('change');
}

riport_tervteny_tervaltipus1_beallit();
///////////select2_torles_def('riport_tervteny_sel_ev1','keremv');
riport_tervteny_ev1_change();//Év lista lekérése

riport_tervteny_adat_ment();//típus és év elmentése



if(tipus1=='terv'){
 var newOptions = {"all": "Összes"};
 //var newOptions = '';
 ajax4_multiselect_update_array('riport_tervteny_sel_szerv1',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_proj1',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_user1',newOptions,'all');
}

riport_tervteny_tipus_beallit();
}

function riport_tervteny_tipus2_change(){

var tipus1=$("#riport_tervteny_sel_tipus1").val();
var tipus2=$("#riport_tervteny_sel_tipus2").val();
if(tipus1=='terv' && tipus2=='teny'){
	$("#riport_tervteny_sel_tipus2").val('terv').trigger('change');
}

riport_tervteny_tervaltipus2_beallit();
//////////select2_torles_def('riport_tervteny_sel_ev2','keremv');
riport_tervteny_ev2_change();

riport_tervteny_adat_ment();//típus és év elmentése

if(tipus2=='terv'){
 var newOptions = {"all": "Összes"};
 //var newOptions = '';
 ajax4_multiselect_update_array('riport_tervteny_sel_szerv2',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_proj2',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_user2',newOptions,'all');
}

riport_tervteny_tipus_beallit();
}

function riport_tervteny_tervaltipus1_beallit(){
var ev=$("#riport_tervteny_sel_ev1").val();
var tipus1=$("#riport_tervteny_sel_tipus1").val();

select2_torles_noselected('riport_tervteny_sel_tervalaptipus1');

if((ev=='keremv')||(tipus1=='teny')){
 $("#riport_tervteny_sel_tervalaptipus1").val("keremv");
 //select2_torles_noselected('riport_tervteny_sel_tervalaptipus1');
 if($("#riport_tervteny_sel_tervalaptipus1").data('select2')){
  $("#riport_tervteny_sel_tervalaptipus1").select2('destroy');
 }
 $("#riport_tervteny_sel_tervalaptipus1").css("display","none");
}else{
 if($("#riport_tervteny_sel_tipus1").val()=='terv')
  $("#riport_tervteny_sel_tervalaptipus1").css("display","inline");
}
}

function riport_tervteny_ev1_change(){
var ev=$("#riport_tervteny_sel_ev1").val();
if(ev){
if(ev=='keremv'){
 var newOptions = {"all": "Összes"};
 //var newOptions = '';
 ajax4_multiselect_update_array('riport_tervteny_sel_ho1',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_szerv1',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_proj1',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_szolgkod1',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_tagv1',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_user1',newOptions,'all');
 riport_tervteny_tipus_beallit(); 
}else{
 riport_tervteny_tipus_beallit();
 riport_tervteny_ev1_change_hole(ev);//Hó lista lekérése
 riport_tervteny_listupdate1_listle();
}
riport_tervteny_tervaltipus1_beallit();
}
}

var ajax_keres_riport_tervteny_ev1_change_hole=null;
function riport_tervteny_ev1_change_hole(ev){
var tipus=encodeURIComponent($("#riport_tervteny_sel_tipus1").val());

if(ajax_keres_riport_tervteny_ev1_change_hole!=null){
 ajax_keres_riport_tervteny_ev1_change_hole.abort();
}

ajax_keres_riport_tervteny_ev1_change_hole=$.post(ajaxstat_p_ut,"mod=riport_tervteny_ev_change_hole&tipus="+tipus+"&ev="+encodeURIComponent(ev),
	function(d){
	ajax_keres_riport_tervteny_ev1_change_hole=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_ho1',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");	
}

function riport_tervteny_tervaltipus2_beallit(){
var ev=$("#riport_tervteny_sel_ev2").val();
var tipus2=$("#riport_tervteny_sel_tipus2").val();

select2_torles_noselected('riport_tervteny_sel_tervalaptipus2');

if((ev=='keremv')||(tipus2=='teny')){
 $("#riport_tervteny_sel_tervalaptipus2").val("keremv");
 //select2_torles_noselected('riport_tervteny_sel_tervalaptipus2');
 if($("#riport_tervteny_sel_tervalaptipus2").data('select2')){
  $("#riport_tervteny_sel_tervalaptipus2").select2('destroy');
 }
 $("#riport_tervteny_sel_tervalaptipus2").css("display","none");
}else{
 if($("#riport_tervteny_sel_tipus2").val()=='terv')
  $("#riport_tervteny_sel_tervalaptipus2").css("display","inline");
}
}

function riport_tervteny_ev2_change(){
var ev=$("#riport_tervteny_sel_ev2").val();
if(ev){
if(ev=='keremv'){
 var newOptions = {"all": "Összes"};
 //var newOptions = '';
 ajax4_multiselect_update_array('riport_tervteny_sel_ho2',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_szerv2',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_proj2',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_szolgkod2',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_tagv2',newOptions,'all');
 ajax4_multiselect_update_array('riport_tervteny_sel_user2',newOptions,'all');
 riport_tervteny_tipus_beallit();
}else{
 riport_tervteny_tipus_beallit();
 riport_tervteny_ev2_change_hole(ev);
 riport_tervteny_listupdate2_listle();
}
riport_tervteny_tervaltipus2_beallit();
}
}

var ajax_keres_riport_tervteny_ev2_change_hole=null;
function riport_tervteny_ev2_change_hole(ev){
var tipus=encodeURIComponent($("#riport_tervteny_sel_tipus2").val());

if(ajax_keres_riport_tervteny_ev2_change_hole!=null){
 ajax_keres_riport_tervteny_ev2_change_hole.abort();
}

ajax_keres_riport_tervteny_ev2_change_hole=$.post(ajaxstat_p_ut,"mod=riport_tervteny_ev_change_hole&tipus="+tipus+"&ev="+encodeURIComponent(ev),
	function(d){
	ajax_keres_riport_tervteny_ev2_change_hole=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_ho2',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");	
}


function riport_tervteny_listupdate1_listle(){
var tipus1=encodeURIComponent($("#riport_tervteny_sel_tipus1").val());
var ev=encodeURIComponent($("#riport_tervteny_sel_ev1").val());
var ho=encodeURIComponent($("#riport_tervteny_sel_ho1").val());

if(tipus1=='teny'){
 riport_tervteny_szerv1_listle(ev,ho);
 riport_tervteny_projekt1_listle(ev,ho);
}

riport_tervteny_szolgkod1_listle(ev,ho);
riport_tervteny_tagv1_listle(ev,ho);

if(tipus1=='teny'){
 riport_tervteny_user1_listle(ev,ho);
}

}

var ajax_keres_riport_tervteny_szerv1_listle=null;
function riport_tervteny_szerv1_listle(ev,ho){

if(ajax_keres_riport_tervteny_szerv1_listle!=null){
 ajax_keres_riport_tervteny_szerv1_listle.abort();
}

ajax_keres_riport_tervteny_szerv1_listle=$.post(ajaxstat_p_ut,"mod=riport_tervteny_szerv_listle&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_riport_tervteny_szerv1_listle=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_szerv1',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}



function riport_tervteny_listupdate2_listle(){
var tipus2=encodeURIComponent($("#riport_tervteny_sel_tipus2").val());
var ev=encodeURIComponent($("#riport_tervteny_sel_ev2").val());
var ho=encodeURIComponent($("#riport_tervteny_sel_ho2").val());

if(tipus2=='teny'){
 riport_tervteny_szerv2_listle(ev,ho);
 riport_tervteny_projekt2_listle(ev,ho);
}

riport_tervteny_szolgkod2_listle(ev,ho);
riport_tervteny_tagv2_listle(ev,ho);

if(tipus2=='teny'){
 riport_tervteny_user2_listle(ev,ho);
}
}

var ajax_keres_riport_tervteny_szerv2_listle=null;
function riport_tervteny_szerv2_listle(ev,ho){

if(ajax_keres_riport_tervteny_szerv2_listle!=null){
 ajax_keres_riport_tervteny_szerv2_listle.abort();
}

ajax_keres_riport_tervteny_szerv2_listle=$.post(ajaxstat_p_ut,"mod=riport_tervteny_szerv_listle&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_riport_tervteny_szerv2_listle=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_szerv2',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

var ajax_keres_riport_tervteny_projekt1_listle=null;
function riport_tervteny_projekt1_listle(ev,ho){

if(ajax_keres_riport_tervteny_projekt1_listle!=null){
 ajax_keres_riport_tervteny_projekt1_listle.abort();
}

ajax_keres_riport_tervteny_projekt1_listle=$.post(ajaxstat_p_ut,"mod=riport_tervteny_projekt_listle&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_riport_tervteny_projekt1_listle=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_proj1',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");

}

var ajax_keres_riport_tervteny_projekt2_listle=null;
function riport_tervteny_projekt2_listle(ev,ho){

if(ajax_keres_riport_tervteny_projekt2_listle!=null){
 ajax_keres_riport_tervteny_projekt2_listle.abort();
}

ajax_keres_riport_tervteny_projekt2_listle=$.post(ajaxstat_p_ut,"mod=riport_tervteny_projekt_listle&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_riport_tervteny_projekt2_listle=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_proj2',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");

}

var ajax_keres_riport_tervteny_szolgkod1_listle=null;
function riport_tervteny_szolgkod1_listle(ev,ho){

if(ajax_keres_riport_tervteny_szolgkod1_listle!=null){
 ajax_keres_riport_tervteny_szolgkod1_listle.abort();
}

ajax_keres_riport_tervteny_szolgkod1_listle=$.post(ajaxstat_p_ut,"mod=riport_tervteny_szolgkod_listle&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_riport_tervteny_szolgkod1_listle=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_szolgkod1',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");	
}

var ajax_keres_riport_tervteny_szolgkod2_listle=null;
function riport_tervteny_szolgkod2_listle(ev,ho){

if(ajax_keres_riport_tervteny_szolgkod2_listle!=null){
 ajax_keres_riport_tervteny_szolgkod2_listle.abort();
}

ajax_keres_riport_tervteny_szolgkod2_listle=$.post(ajaxstat_p_ut,"mod=riport_tervteny_szolgkod_listle&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_riport_tervteny_szolgkod2_listle=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_szolgkod2',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");	
}

var ajax_keres_riport_tervteny_tagv1_listle=null;
function riport_tervteny_tagv1_listle(ev,ho){

if(ajax_keres_riport_tervteny_tagv1_listle!=null){
 ajax_keres_riport_tervteny_tagv1_listle.abort();
}

ajax_keres_riport_tervteny_tagv1_listle=$.post(ajaxstat_p_ut,"mod=riport_tervteny_tagv_listle&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_riport_tervteny_tagv1_listle=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_tagv1',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

var ajax_keres_riport_tervteny_tagv2_listle=null;
function riport_tervteny_tagv2_listle(ev,ho){

if(ajax_keres_riport_tervteny_tagv2_listle!=null){
 ajax_keres_riport_tervteny_tagv2_listle.abort();
}

ajax_keres_riport_tervteny_tagv2_listle=$.post(ajaxstat_p_ut,"mod=riport_tervteny_tagv_listle&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_riport_tervteny_tagv2_listle=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_tagv2',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");

}


var ajax_keres_riport_tervteny_user1_listle=null;
function riport_tervteny_user1_listle(ev,ho){

if(ajax_keres_riport_tervteny_user1_listle!=null){
 ajax_keres_riport_tervteny_user1_listle.abort();
}

ajax_keres_riport_tervteny_user1_listle=$.post(ajaxstat_p_ut,"mod=riport_tervteny_user_listle&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_riport_tervteny_user1_listle=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_user1',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

var ajax_keres_riport_tervteny_user2_listle=null;
function riport_tervteny_user2_listle(ev,ho){

if(ajax_keres_riport_tervteny_user2_listle!=null){
 ajax_keres_riport_tervteny_user2_listle.abort();
}

ajax_keres_riport_tervteny_user2_listle=$.post(ajaxstat_p_ut,"mod=riport_tervteny_user_listle&ev="+ev+"&ho="+ho,
	function(d){
	ajax_keres_riport_tervteny_user2_listle=null;
	if(d.slice(0,5)=="ok$;$"){
		ajax4_multiselect_update_json('riport_tervteny_sel_user2',d.slice(5),'all');
	}else{
	 diaglog_open(d,"Rendszerhiba");
	}
	},"text");
}

function riport_leker_terv_teny(){
var tipus1=encodeURIComponent($("#riport_tervteny_sel_tipus1").val());
var tipus2=encodeURIComponent($("#riport_tervteny_sel_tipus2").val());
var ev1=encodeURIComponent($("#riport_tervteny_sel_ev1").val());
var ev2=encodeURIComponent($("#riport_tervteny_sel_ev2").val());
var altipus1=encodeURIComponent($("#riport_tervteny_sel_tervalaptipus1").val());
var altipus2=encodeURIComponent($("#riport_tervteny_sel_tervalaptipus2").val());

var reszlet1=encodeURIComponent($("#riport_tervteny_sel_reszlet1").val());
var reszlet1terv=encodeURIComponent($("#riport_tervteny_sel_reszlet1terv").val());

var ho1="";
$("#riport_tervteny_sel_ho1 :selected").each(function(i, sel){
	if(ho1!='')ho1+="#";
    ho1+=encodeURIComponent($(sel).val());
});
if(ho1=='')ho1='keremv';


var ho2="";
$("#riport_tervteny_sel_ho2 :selected").each(function(i, sel){
	if(ho2!='')ho2+="#";
    ho2+=encodeURIComponent($(sel).val());
});
if(ho2=='')ho2='keremv';

var szerv1="";
$("#riport_tervteny_sel_szerv1 :selected").each(function(i, sel){
	if(szerv1!='')szerv1+="#";
    szerv1+=encodeURIComponent($(sel).val());
});
if(szerv1=='')szerv1='keremv';

var szerv2="";
$("#riport_tervteny_sel_szerv2 :selected").each(function(i, sel){
	if(szerv2!='')szerv2+="#";
    szerv2+=encodeURIComponent($(sel).val());
});
if(szerv2=='')szerv2='keremv';

var proj1="";
$("#riport_tervteny_sel_proj1 :selected").each(function(i, sel){
	if(proj1!='')proj1+="#";
    proj1+=encodeURIComponent($(sel).val());
});
if(proj1=='')proj1='keremv';

var proj2="";
$("#riport_tervteny_sel_proj2 :selected").each(function(i, sel){
	if(proj2!='')proj2+="#";
    proj2+=encodeURIComponent($(sel).val());
});
if(proj2=='')proj2='keremv';

var szolgkod1="";
$("#riport_tervteny_sel_szolgkod1 :selected").each(function(i, sel){
	if(szolgkod1!='')szolgkod1+="#";
    szolgkod1+=encodeURIComponent($(sel).val());
});
if(szolgkod1=='')szolgkod1='keremv';

var szolgkod2="";
$("#riport_tervteny_sel_szolgkod2 :selected").each(function(i, sel){
	if(szolgkod2!='')szolgkod2+="#";
    szolgkod2+=encodeURIComponent($(sel).val());
});
if(szolgkod2=='')szolgkod2='all';

var tagv1="";
$("#riport_tervteny_sel_tagv1 :selected").each(function(i, sel){
	if(tagv1!='')tagv1+="#";
    tagv1+=encodeURIComponent($(sel).val());
});
if(tagv1=='')tagv1='all';

var tagv2="";
$("#riport_tervteny_sel_tagv2 :selected").each(function(i, sel){
	if(tagv2!='')tagv2+="#";
    tagv2+=encodeURIComponent($(sel).val());
});
if(tagv2=='')tagv2='all';

var user1="";
$("#riport_tervteny_sel_user1 :selected").each(function(i, sel){
	if(user1!='')user1+="#";
    user1+=encodeURIComponent($(sel).val());
});
if(user1=='')user1='all';


var user2="";
$("#riport_tervteny_sel_user2 :selected").each(function(i, sel){
	if(user2!='')user2+="#";
    user2+=encodeURIComponent($(sel).val());
});
if(user2=='')user2='all';

//Ellenőrzés


if(tipus1=='terv' && tipus2=='teny'){
  diaglog_open('Hiba!<br><br>Adat1 táblázatban Terv típus esetén Adat2 táblázatban nem lehet tény típus kiválasztva!',"Hiba","del_behajtani16.png");
 return false;
}

if(ev1=='keremv'){
 diaglog_open('Hiba!<br><br>Adat1 táblázatban az év kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(ho1=='keremv'){
 diaglog_open('Hiba!<br><br>Adat1 táblázatban a hó kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(szerv1=='keremv'){
 diaglog_open('Hiba!<br><br>Adat1 táblázatban a szervezeti egység kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(proj1=='keremv'){
 diaglog_open('Hiba!<br><br>Adat1 táblázatban a tevékenység kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(szolgkod1=='keremv'){
 diaglog_open('Hiba!<br><br>Adat1 táblázatban a tevékenység kód kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(tagv1=='keremv'){
 diaglog_open('Hiba!<br><br>Adat1 táblázatban a társaság kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(user1=='keremv'){
 diaglog_open('Hiba!<br><br>Adat1 táblázatban a munkavállaló kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(reszlet1=='tagv' && tipus2=='terv'){
 diaglog_open('Hiba!<br><br>Társaság szintű összesítés esetén az Adat2 táblázat nem lehet Terv típus!',"Hiba","del_behajtani16.png");
 return false;
}

if(tipus2!='keremv' && ho2=='keremv'){
 diaglog_open('Hiba!<br><br>Adat2 táblázatban a hó kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(tipus2!='keremv' && szerv2=='keremv'){
 diaglog_open('Hiba!<br><br>Adat2 táblázatban a szervezeti egység kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(tipus2!='keremv' && proj2=='keremv'){
 diaglog_open('Hiba!<br><br>Adat2 táblázatban a tevékenység kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(tipus2!='keremv' && szolgkod2=='keremv'){
 diaglog_open('Hiba!<br><br>Adat2 táblázatban a tevékenység kód kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(tipus2!='keremv' && tagv2=='keremv'){
 diaglog_open('Hiba!<br><br>Adat2 táblázatban a társaság kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(tipus2!='keremv' && user2=='keremv'){
 diaglog_open('Hiba!<br><br>Adat2 táblázatban a munkavállaló kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(tipus2!='keremv' && ev2=='keremv'){
 diaglog_open('Hiba!<br><br>Adat2 táblázatban az év kiválasztása kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

//Ha a típus1 terv és a tevékenységkód nem ALL, akkor a társaságot is ki kell választani
/*
if(tipus1=='terv' && szolgkod1!='all' && tagv1=='all'){
 diaglog_open('Hiba!<br><br>Adat1 táblázatban Terv típus esetén Tevékenyság kód mellett a társaság kiválasztása is kötelező!',"Hiba","del_behajtani16.png");
 return false;
}
*/

//Terv esetén csak 1 lehet a tevékenységkód
if(tipus1=='terv' && szolgkod1!='all' && szolgkod1.split("#").length>1){
 diaglog_open('Hiba!<br><br>Terv típus esetén a csak 1 tevékenységkód kiválasztása engedélyezett!',"Hiba","del_behajtani16.png");
 return false;
}

//Terv esetén csak 1 lehet a társaság
if(tipus1=='terv' && tagv1!='all' && tagv1.split("#").length>1){
 diaglog_open('Hiba!<br><br>Terv típus esetén a csak 1 társaság kiválasztása engedélyezett!',"Hiba","del_behajtani16.png");
 return false;
}

if(tipus1!='terv' && szolgkod1!='all' && szolgkod1!=szolgkod2){
 diaglog_open('Hiba!<br><br>Terv típus esetén a két kiválasztott tevékenységkódnak meg kell egyeznie!',"Hiba","del_behajtani16.png");
 return false;
}


if(tipus1!='terv' && tagv1!='all' && tipus2!='keremv' && tagv1!=tagv2){
 diaglog_open('Hiba!<br><br>Terv típus esetén a két kiválasztott társaságnak meg kell egyeznie!',"Hiba","del_behajtani16.png");
 return false;
}

if(tipus1=='terv' && altipus1=='keremv'){
 diaglog_open('Hiba!<br><br>Adat1 táblázatban terv típus esetén az altípus kiválasztása is kötelező!',"Hiba","del_behajtani16.png");
 return false;
}

if(tipus2=='terv' && altipus2=='keremv'){
 diaglog_open('Hiba!<br><br>Adat2 táblázatban terv típus esetén az altípus kiválasztása is kötelező!',"Hiba","del_behajtani16.png");
 return false;
}


var adat1="<input type='hidden' name='tipus' value='tervteny'>";
var adat2="<input type='hidden' name='tipus1' value='"+tipus1+"'>";
var adat3="<input type='hidden' name='tipus2' value='"+tipus2+"'>";
var adat4="<input type='hidden' name='ev1' value='"+ev1+"'>";
var adat5="<input type='hidden' name='ev2' value='"+ev2+"'>";
var adat6="<input type='hidden' name='ho1' value='"+ho1+"'>";
var adat7="<input type='hidden' name='ho2' value='"+ho2+"'>";

var adat8="<input type='hidden' name='szerv1' value='"+szerv1+"'>";
var adat9="<input type='hidden' name='szerv2' value='"+szerv2+"'>";
var adat10="<input type='hidden' name='proj1' value='"+proj1+"'>";
var adat11="<input type='hidden' name='proj2' value='"+proj2+"'>";

var adat12="<input type='hidden' name='szolgkod1' value='"+szolgkod1+"'>";
var adat13="<input type='hidden' name='szolgkod2' value='"+szolgkod2+"'>";

var adat14="<input type='hidden' name='tagv1' value='"+tagv1+"'>";
var adat15="<input type='hidden' name='tagv2' value='"+tagv2+"'>";
var adat16="<input type='hidden' name='user1' value='"+user1+"'>";
var adat17="<input type='hidden' name='user2' value='"+user2+"'>";
var adat18="<input type='hidden' name='reszlet1' value='"+reszlet1+"'>";
var adat19="<input type='hidden' name='reszlet1terv' value='"+reszlet1terv+"'>";

var adat20="<input type='hidden' name='altipus1' value='"+altipus1+"'>";
var adat21="<input type='hidden' name='altipus2' value='"+altipus2+"'>";

var adat=adat1+adat2+adat3+adat4+adat5+adat6+adat7+adat8+adat9+adat10+adat11+adat12+adat13+adat14+adat15+adat16+adat17+adat18+adat19+adat20+adat21;

$("#riport_leker_terv_teny_submit").prop("disabled",true);

$("<form target=_top id='riport_leker_form' method=post action='riport/riport_leker.php'>"+adat+"</form>").appendTo('body').trigger("submit").remove();

$.wait( function(){
$("#riport_leker_terv_teny_submit").prop("disabled",false);
},3);

}
