<?php

function func_letolt(){

if(isset($_POST['muvelet'])){
 switch($_POST['muvelet']){
  case'ad_leker':
   include_once("ajax_ad.php");
  break;
  
  case'admin_backup_terv_projektszetbont_del':
   include_once('admin/ajax_ful_admin_backup_terv_func.php');
   admin_backup_terv_projektszetbont_del();
  break;
	
  case'admin_backup_default_change':
   include_once('admin/ajax_ful_admin_backup_func.php');
   admin_backup_default_change();
  break;
  
  case'admin_backup_terv_delete_proc':
   include_once('admin/ajax_ful_admin_backup_func.php');
   admin_backup_terv_delete_proc();
  break;
  case'admin_backup_masol_proc':
   include_once('admin/ajax_ful_admin_backup_func.php');
   admin_backup_masol_proc();
  break;
  case'admin_backup_terv':
   include_once('admin/ajax_ful_admin_backup_terv.php');
   admin_backup_terv();
  break;
  case'admin_backup_terv_adat':
   include_once('admin/ajax_ful_admin_backup_terv.php');
   echo 'ok$;$';
   admin_backup_terv_adat();
  break;
 
  case'admin_backup_terv_1pont':
   include_once('admin/ajax_ful_admin_backup_terv.php');
   admin_backup_terv_1pont();
  break;
  case'admin_backup_terv_1_del':
   include_once('admin/ajax_ful_admin_backup_terv_func.php');
   admin_backup_terv_1_del();
  break;
  
  case'admin_backup_terv_2pont':
   include_once('admin/ajax_ful_admin_backup_terv.php');
   admin_backup_terv_2pont();
  break;
  case'admin_backup_terv_2_del':
   include_once('admin/ajax_ful_admin_backup_terv_func.php');
   admin_backup_terv_2_del();
  break;

  case'admin_backup_terv_3_1pont':
   include_once('admin/ajax_ful_admin_backup_terv.php');
   admin_backup_terv_3_1pont();
  break;
  case'admin_backup_terv_3_1_del':
   include_once('admin/ajax_ful_admin_backup_terv_func.php');
   admin_backup_terv_3_1_del();
  break;

  case'admin_backup_terv_3_1_1pont':
   include_once('admin/ajax_ful_admin_backup_terv.php');
   admin_backup_terv_3_1_1pont();
  break;
  case'admin_backup_terv_3_1_1_del':
   include_once('admin/ajax_ful_admin_backup_terv_func.php');
   admin_backup_terv_3_1_1_del();
  break;

  case'admin_backup_terv_3_3pont':
   include_once('admin/ajax_ful_admin_backup_terv.php');
   admin_backup_terv_3_3pont();
  break;
  case'admin_backup_terv_3_3_del':
   include_once('admin/ajax_ful_admin_backup_terv_func.php');
   admin_backup_terv_3_3_del();
  break;

  case'admin_backup_terv_3_2pont':
   include_once('admin/ajax_ful_admin_backup_terv.php');
   admin_backup_terv_3_2pont();
  break;
  case'admin_backup_terv_3_2_del':
   include_once('admin/ajax_ful_admin_backup_terv_func.php');
   admin_backup_terv_3_2_del();
  break;

  case'admin_backup_terv_3pont':
   include_once('admin/ajax_ful_admin_backup_terv.php');
   admin_backup_terv_3pont();
  break;
  case'admin_backup_terv_3_del':
   include_once('admin/ajax_ful_admin_backup_terv_func.php');
   admin_backup_terv_3_del();
  break;

  case'admin_honapzaras_evszures_change':
   include_once('admin/ajax_ful_admin_honapzaras.php');
   admin_honapzaras_evszures_change();
  break;
  
  case'admin_honapzaras_change':
   include_once('admin/ajax_ful_admin_honapzaras.php');
   admin_honapzaras_change();
  break;
  case'admin_uj_user_ment':
   include_once('admin/ajax_ful_admin_user.php');
   admin_uj_user_ment();
  break;
  case'admin_userlist_keres':
   include_once('admin/ajax_ful_admin_user.php');
   admin_userlist_keres();
  break;
  case'admin_mod_user_ment':
   include_once('admin/ajax_ful_admin_user.php');
   admin_mod_user_ment();
  break;
  case'admin_moduser_veg_date_delete_rogzitett_proc':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_veg_date_delete_rogzitett_proc();
  break;
  case'admin_moduser_admod_proc_kuld':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_admod_proc_kuld();
  break;
  case'admin_moduser_inaktiv':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_inaktiv();
  break;
  case'admin_moduser_rogzitjog':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_rogzitjog();
  break;
  case'admin_moduser_jovahagy':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_jovahagy();
  break;
  case'admin_moduser_stat':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_stat();
  break;
 
  case'admin_moduser_adminjog_ment':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_adminjog_ment();
  break;
  case'admin_moduser_adminjog_fuljog_ment':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_adminjog_fuljog_ment();
  break;
  case'admin_moduser_adminjog_fuljog_ment_ful':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_adminjog_fuljog_ment_ful();
  break; 
  
  case'admin_moduser_riport':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_riport();
  break;
  case'admin_moduser_riport_tipusjogspan':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_riport_tipusjogspan();
  break;
  case'admin_moduser_riport_tipusjogspan_teny3_1_1_szervcsopjog_katt':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_riport_tipusjogspan_teny3_1_1_szervcsopjog_katt();
  break;
  case'admin_moduser_riport_tipusjogspan_szerzjog_katt':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_riport_tipusjogspan_szerzjog_katt();
  break;
  case'admin_moduser_riport_tipusjogspan_szerzjog_katt_all':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_riport_tipusjogspan_szerzjog_katt_all();
  break;
  case'admin_moduser_riport_tipusjogspan_katt':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_riport_tipusjogspan_katt();
  break;
  case'admin_szervlist_keres':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_szervlist_keres();
  break;
  case'admin_uj_szerv_proj_katt':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_uj_szerv_proj_katt();
  break;
  case'admin_ujszerv_ment':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_ujszerv_ment();
  break;
  case'admin_ujproj_hozz_keress':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_ujproj_hozz_keress();
  break;
  case'admin_mod_szerv_proj_katt':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_mod_szerv_proj_katt();
  break;
  case'admin_modproj_hozz_keress':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_modproj_hozz_keress();
  break;
  case'admin_modproj_hozz_change':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_modproj_hozz_change();
  break;
  case'admin_modproj_hozz_change_tom':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_modproj_hozz_change_tom();
  break;
  case'admin_modszerv_hozzall_change':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_modszerv_hozzall_change();
  break;
  case'admin_modszerv_ment':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_modszerv_ment();
  break;
  case'admin_modszerv_inaktiv':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_modszerv_inaktiv();
  break;
  case'admin_mod_szerv_user_katt':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_mod_szerv_user_katt();
  break;
  case'admin_projektlist_keres':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_projektlist_keres();
  break;
  case'admin_uj_projekt_szerv_katt':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_uj_projekt_szerv_katt();
  break;
  case'admin_ujszerv_hozz_keress':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_ujszerv_hozz_keress();
  break;
  case'admin_uj_projekt_user_katt':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_uj_projekt_user_katt();
  break;
  case'admin_ujuser_hozz_keress':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_ujuser_hozz_keress();
  break;

  case'admin_arazasreflist_keres':
   include_once('admin/ajax_ful_admin_arazasref.php');
   admin_arazasreflist_keres();
  break;
  case'admin_modarazasref_ment_arazasref':
   include_once('admin/ajax_ful_admin_arazasref.php');
   admin_modarazasref_ment_arazasref();
  break;
  
  case'admin_ujtagvkod_ment':
   include_once('admin/ajax_ful_admin_tagv.php');
   admin_ujtagvkod_ment();
  break;
  case'admin_tagvkodlist_keres':
   include_once('admin/ajax_ful_admin_tagv.php');
   admin_tagvkodlist_keres();
  break;
  case'admin_modtagvkod_ment':
   include_once('admin/ajax_ful_admin_tagv.php');
   admin_modtagvkod_ment();
  break;
  case'admin_modtagvkod_inaktiv':
   include_once('admin/ajax_ful_admin_tagv.php');
   admin_modtagvkod_inaktiv();
  break;
  
  case'admin_ujcsopnev_ment':
   include_once("admin/ajax_ful_admin_csop_nev.php");
   admin_ujcsopnev_ment();
  break;
  case'admin_csopnevlist_keres':
   include_once("admin/ajax_ful_admin_csop_nev.php");
   admin_csopnevlist_keres();
  break;
  case'admin_modcsopnev_ment':
   include_once("admin/ajax_ful_admin_csop_nev.php");
   admin_modcsopnev_ment();
  break;
  case'admin_modcsopnev_inaktiv':
   include_once("admin/ajax_ful_admin_csop_nev.php");
   admin_modcsopnev_inaktiv();
  break;

  case'admin_ujkatnev_ment':
   include_once("admin/ajax_ful_admin_kat_nev.php");
   admin_ujkatnev_ment();
  break;
  case'admin_katnevlist_keres':
   include_once("admin/ajax_ful_admin_kat_nev.php");
   admin_katnevlist_keres();
  break;
  case'admin_modkatnev_ment':
   include_once("admin/ajax_ful_admin_kat_nev.php");
   admin_modkatnev_ment();
  break;
  case'admin_modkatnev_inaktiv':
   include_once("admin/ajax_ful_admin_kat_nev.php");
   admin_modkatnev_inaktiv();
  break;
 
  case'admin_ujszolgkod_ment':
   include_once('admin/ajax_ful_admin_szolgkod.php');
   admin_ujszolgkod_ment();
  break;
  case'admin_szolgkodlist_keres':
   include_once('admin/ajax_ful_admin_szolgkod.php');
   admin_szolgkodlist_keres();
  break;
  case'admin_modszolgkod_ment':
   include_once('admin/ajax_ful_admin_szolgkod.php');
   admin_modszolgkod_ment();
  break;
  case'admin_modszolgkod_inaktiv':
   include_once('admin/ajax_ful_admin_szolgkod.php');
   admin_modszolgkod_inaktiv();
  break;
  
  case'admin_ujprojekt_ment':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_ujprojekt_ment();
  break;
  case'admin_modprojekt_ment':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_modprojekt_ment();
  break;
  case'admin_modprojekt_inaktiv':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_modprojekt_inaktiv();
  break;
  case'admin_mod_proj_szerv_katt':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_mod_proj_szerv_katt();
  break;
  case'admin_modszerv_hozz_keress':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_modszerv_hozz_keress();
  break;
  case'admin_modszerv_hozz_change':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_modszerv_hozz_change();
  break;
  case'admin_modszerv_katkivetel_change':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_modszerv_katkivetel_change();
  break;
  case'admin_moduser_katkivetel_change':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_moduser_katkivetel_change();
  break;
  case'admin_mod_proj_title_katt':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_mod_proj_title_katt();
  break;
  case'admin_mod_proj_maxido_all_ment':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_mod_proj_maxido_all_ment();
  break;
  case'admin_mod_proj_maxido_katt_all_ck':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_mod_proj_maxido_katt_all_ck();
  break;
  case'proj_maxido_uj_ev_ment':
   include_once('admin/ajax_ful_admin_proj.php');
   proj_maxido_uj_ev_ment();
  break;
  case'proj_maxido_uj_ev_del':
   include_once('admin/ajax_ful_admin_proj.php');
   proj_maxido_uj_ev_del();
  break;
  case'admin_mod_proj_title_save':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_mod_proj_title_save();
  break;
  case'admin_mod_proj_userjovahagyo_katt':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_mod_proj_userjovahagyo_katt();
  break;
  case'admin_moduserjovahagyo_hozz_keress':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_moduserjovahagyo_hozz_keress();
  break;
  case'admin_mod_proj_userjovahagyo_katt_list_ki':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_mod_proj_userjovahagyo_katt_list_ki();
  break;
  case'admin_moduserjovahagyo_hozz_change':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_moduserjovahagyo_hozz_change();
  break;
  case'admin_mod_proj_maxido_katt':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_mod_proj_maxido_katt();
  break;
  case'admin_mod_proj_user_katt':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_mod_proj_user_katt();
  break;
  case'admin_moduser_hozz_keress':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_moduser_hozz_keress();
  break;
  case'admin_moduser_hozz_change':
   include_once('admin/ajax_ful_admin_proj.php');
   admin_moduser_hozz_change();
  break;
  case'admin_mod_userfelettesjovahagyas_proj_katt':
   include_once('admin/ajax_ful_admin_user.php');
   admin_mod_userfelettesjovahagyas_proj_katt();
  break;
  case'admin_moduser_stat_szervjogspan':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_stat_szervjogspan();
  break;
  case'admin_moduser_stat_projektjogspan_szerv_aljog':
   echo "ok$;$";
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_stat_projektjogspan_szerv_aljog();
  break;
  case'admin_moduser_stat_projekt_hozz_keress':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_stat_projekt_hozz_keress();
  break;
  case'admin_moduser_stat_szerv_hozz_keress':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_stat_szerv_hozz_keress();
  break;
  case'admin_moduser_stat_szervjogspan_szerv_aljog':
   echo "ok$;$";
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_stat_szervjogspan_szerv_aljog();
  break;
  case'admin_moduser_stat_szervjogspan_all':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_stat_szervjogspan_all();
  break;
  case'admin_moduser_stat_szervjogspan_change':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_stat_szervjogspan_change();
  break;
  case'admin_mod_userjovahagyas_proj_katt':
   include_once('admin/ajax_ful_admin_user.php');
   admin_mod_userjovahagyas_proj_katt();
  break;
  case'admin_moduserfelettesjovahagyas_hozz_keress':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduserfelettesjovahagyas_hozz_keress();
  break;
  case'admin_moduserjovahagyas_hozz_keress':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduserjovahagyas_hozz_keress();
  break;
  case'admin_mod_useremailbe_katt':
   include_once('admin/ajax_ful_admin_user.php');
   admin_mod_useremailbe_katt();
  break;
  case'admin_mod_useremailbe_change':
   include_once('admin/ajax_ful_admin_user.php');
   admin_mod_useremailbe_change();
  break;
  case'admin_mod_userprojektjovahagyo_proj_katt':
   include_once('admin/ajax_ful_admin_user.php');
   admin_mod_userprojektjovahagyo_proj_katt();
  break;
  case'admin_moduserprojektjovahagyo_hozz_keress':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduserprojektjovahagyo_hozz_keress();
  break;
  case'admin_moduserprojektjovahagyo_hozz_change':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduserprojektjovahagyo_hozz_change();
  break;
  case'admin_mod_userprojekt_proj_katt':
   include_once('admin/ajax_ful_admin_user.php');
   admin_mod_userprojekt_proj_katt();
  break;
  case'admin_moduserprojekt_hozz_keress':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduserprojekt_hozz_keress();
  break;
  case'admin_modfelettesjovahagyo_hozz_change':
   include_once('admin/ajax_ful_admin_user.php');
   admin_modfelettesjovahagyo_hozz_change();
  break;
  case'admin_moduserjovahagy_hozz_change':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduserjovahagy_hozz_change();
  break;
  case'admin_moduserprojekt_hozz_change':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduserprojekt_hozz_change();
  break;
  case'admin_moduserprojekt_katkivetel_change':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduserprojekt_katkivetel_change();
  break;
  case'admin_moduser_stat_projekt_hozz_change':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_stat_projekt_hozz_change();
  break;
  case'admin_mod_user_szerv_katt':
   include_once('admin/ajax_ful_admin_user.php');
   admin_mod_user_szerv_katt();
  break;
  case'admin_moduser_szerv_hozz_keress':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_szerv_hozz_keress();
  break;
  case'admin_moduser_szerv_hozz_change':
   include_once('admin/ajax_ful_admin_user.php');
   admin_moduser_szerv_hozz_change();
  break;
  case'munkanapuser_uj_ment':
   include_once('admin/ajax_ful_admin_munkanapuser.php');
   munkanapuser_uj_ment();
  break;
  case'munkanapuser_del':
   include_once('admin/ajax_ful_admin_munkanapuser.php');
   munkanapuser_del();
  break;
  case'admin_uj_szerv_jovahagyo_katt':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_uj_szerv_jovahagyo_katt();
  break;
  case'admin_ujproj_jovahagyo_keress':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_ujproj_jovahagyo_keress();
  break;
  case'admin_mod_szerv_jovahagyok_katt':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_mod_szerv_jovahagyok_katt();
  break;
  case'admin_modszervjovahagyo_hozz_keress':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_modszervjovahagyo_hozz_keress();
  break;
  case'admin_modszervjovahagyo_hozz_change':
   include_once('admin/ajax_ful_admin_szerv.php');
   admin_modszervjovahagyo_hozz_change();
  break;
  case'admin_mod_user_maxido_change':
   include_once('admin/ajax_ful_admin_user.php');
   admin_mod_user_maxido_change();
  break;
  case'admin_munkanapuser_keress':
    include_once('admin/ajax_ful_admin_munkanapuser.php');
	admin_munkanapuser_mod();
  break;
 
  //Tulajdonosi joggyakorló lista - eleje
  case'admin_ujkapcstulaj_ment':
    include_once('admin/ajax_ful_admin_kapcstulaj.php');
	admin_ujkapcstulaj_ment();
  break;
  case'admin_kapcstulajlist_keres':
    include_once('admin/ajax_ful_admin_kapcstulaj.php');
	admin_kapcstulajlist_keres();
  break;
  case'admin_modkapcstulaj_ment':
    include_once('admin/ajax_ful_admin_kapcstulaj.php');
	admin_modkapcstulaj_ment();
  break;
  case'admin_modkapcstulaj_inaktiv':
    include_once('admin/ajax_ful_admin_kapcstulaj.php');
	admin_modkapcstulaj_inaktiv();
  break; 
  
  //Tulajdonosi joggyakorló lista - vége
  
  //Tulajdonosi törzsadatok  lista - eleje
  case'admin_ujkapcstorzs_ment':
    include_once('admin/ajax_ful_admin_kapcstorzs.php');
	admin_ujkapcstorzs_ment();
  break;
    case'admin_kapcstorzslist_keres':
    include_once('admin/ajax_ful_admin_kapcstorzs.php');
	admin_kapcstorzslist_keres();
  break;
  case'admin_modkapcstorzs_ment':
    include_once('admin/ajax_ful_admin_kapcstorzs.php');
	admin_modkapcstorzs_ment();
  break;
  case'admin_modkapcstorzs_inaktiv':
    include_once('admin/ajax_ful_admin_kapcstorzs.php');
	admin_modkapcstorzs_inaktiv();
  break;
  //Tulajdonosi törzsadatok  lista - vége
  
  //tag-szol összerendelés - eleje
  case'admin_ujkapcsossze_ment':
    include_once('admin/ajax_ful_admin_kapcsossze.php');
	admin_ujkapcsossze_ment();
  break;
  break;
  case'admin_kapcsosszelist_keres':
    include_once('admin/ajax_ful_admin_kapcsossze.php');
	admin_kapcsosszelist_keres();
  break;
  case'admin_modkapcsossze_ment':
    include_once('admin/ajax_ful_admin_kapcsossze.php');
	admin_modkapcsossze_ment();
  break;
  case'admin_modkapcsossze_kapcs_ment':
    include_once('admin/ajax_ful_admin_kapcsossze.php');
	admin_modkapcsossze_kapcs_ment();
  break;
  case'admin_modkapcsossze_del_proc':
    include_once('admin/ajax_ful_admin_kapcsossze.php');
	admin_modkapcsossze_del_proc();
  break;
  //tag-szol összerendelés - vége
  
  //Tervezése - eleje
  case'admin_ujtervezes_ment':
   include_once('admin/ajax_ful_admin_tervezes.php');
   admin_ujtervezes_ment();
  break;
  case'admin_tervezes_modment_proc':
   include_once('admin/ajax_ful_admin_tervezes.php');
   admin_tervezes_modment_proc();
  break;
  case'admin_tervezeslist_keres':
   include_once('admin/ajax_ful_admin_tervezes.php');
   admin_tervezeslist_keres();
  break;
  case'admin_tervezes_tervdel':
   include_once('admin/ajax_ful_admin_tervezes.php');
   admin_tervezes_tervdel();
  break;
  case'admin_tervezes_sordel_proc':
   include_once('admin/ajax_ful_admin_tervezes.php');
   admin_tervezes_sordel_proc();
  break;
  case'admin_tervezes_riportok':
   include_once('admin/ajax_ful_admin_tervezes.php');
   admin_tervezes_riportok();
  break;
  //Tervezése - vége
  
  //Hibajavítás - eleje
  case'admin_ujhibajavitas_egy':
   include_once('admin/ajax_ful_admin_hibajavitas.php');
   admin_ujhibajavitas_egy();
  break;
  case'admin_modhibajavitas':
   include_once('admin/ajax_ful_admin_hibajavitas.php');
   admin_modhibajavitas();
  break;
  //Hibajavítás - vége
  
  //Ténypotlas - eleje
  case'admin_tenypotlaslist_keres':
   include_once('admin/ajax_ful_admin_tenypotlas.php');
   admin_tenypotlaslist_keres();
  break;
  case'admin_tenypotlas_del_ev_proc':
   include_once('admin/ajax_ful_admin_tenypotlas.php');
   admin_tenypotlas_del_ev_proc();
  break;
  case'admin_tenypotlas_del_ho_proc':
   include_once('admin/ajax_ful_admin_tenypotlas.php');
   admin_tenypotlas_del_ho_proc();
  break;
  //Ténypotlas - vége
  
  //Szerződés tipus - eleje
  case'admin_ujszerztipus_ment':
   include_once('admin/szerz/admin_szerz_szerztipus.php');
   admin_ujszerztipus_ment();
  break;
  case'admin_modszerztipus_ment':
   include_once('admin/szerz/admin_szerz_szerztipus.php');
   admin_modszerztipus_ment();
  break;
  case'admin_szerztipuslist_keres':
   include_once('admin/szerz/admin_szerz_szerztipus.php');
   admin_szerztipuslist_keres();
  break;
  //Szerződés tipus - vége
  
  //Szerződés alapadatok - eleje
  case'admin_ujszerzalapadat_ment':
   include_once('admin/szerz/admin_szerz_szerzalapadat.php');
   admin_ujszerzalapadat_ment();
  break;
  case'admin_modszerzalapadat_ment':
   include_once('admin/szerz/admin_szerz_szerzalapadat.php');
   admin_modszerzalapadat_ment();
  break;
  case'admin_szerzalapadatlist_keres':
   include_once('admin/szerz/admin_szerz_szerzalapadat.php');
   admin_szerzalapadatlist_keres();
  break;
  //Szerződés alapadatok - vége

  //Szerződés feltöltése - eleje
  case'admin_szerzfeltoltlist_keres':
   include_once('admin/szerz/admin_szerz_szerzfeltolt.php');
   admin_szerzfeltoltlist_keres();
  break;
  case'szerz_file_del_proc':
   include_once('admin/szerz/admin_szerz_szerzfeltolt.php');
   szerz_file_del_proc();
  break;
  //Szerződés feltöltése - vége
   
  //Társaság kategória - eleje
  case'admin_szerz_tagvkat_mod':
   include_once('admin/szerz/admin_szerz_tarskat.php');
   admin_szerz_tagvkat_mod();
  break;
  case'admin_szerz_tagvkat_uj_ment':
   include_once('admin/szerz/admin_szerz_tarskat.php');
   admin_szerz_tagvkat_uj_ment();
  break;
  case'admin_szerz_tagvkat_uj_del':
   include_once('admin/szerz/admin_szerz_tarskat.php');
   admin_szerz_tagvkat_uj_del();
  break;
  case'admin_tarskatlist_keres':
   include_once('admin/szerz/admin_szerz_tarskat.php');
   admin_tarskatlist_keres();
  break;
  //Társaság kategória - vége
  
  //Szolgáltatás csoport - eleje
  case'admin_ujszolgcsop_ment':
   include_once('admin/szerz/admin_szerz_szolgcsop.php');
   admin_ujszolgcsop_ment();
  break;
  case'admin_modszolgcsop_ment':
   include_once('admin/szerz/admin_szerz_szolgcsop.php');
   admin_modszolgcsop_ment();
  break;
  case'admin_szolgcsoplist_keres':
   include_once('admin/szerz/admin_szerz_szolgcsop.php');
   admin_szolgcsoplist_keres();
  break;
  case'admin_modszolgcsopszolgkod_szolgkod_katt':
   include_once('admin/szerz/admin_szerz_szolgcsop.php');
   admin_modszolgcsopszolgkod_szolgkod_katt();
  break;
  case'admin_modszolgcsopszolgkod_hozz_keress':
   include_once('admin/szerz/admin_szerz_szolgcsop.php');
   admin_modszolgcsopszolgkod_hozz_keress();
  break;
  case'admin_modszolgcsopszolgkod_hozz_change':
   include_once('admin/szerz/admin_szerz_szolgcsop.php');
   admin_modszolgcsopszolgkod_hozz_change();
  break;
  //Szolgáltatás csoport - vége
  
  //Elszámolás típus - eleje
  case'admin_ujelsztipus_ment':
   include_once('admin/szerz/admin_szerz_elsztipus.php');
   admin_ujelsztipus_ment();
  break;
  case'admin_elsztipuslist_keres':
   include_once('admin/szerz/admin_szerz_elsztipus.php');
   admin_elsztipuslist_keres();
  break;
  case'admin_modelsztipus_ment':
   include_once('admin/szerz/admin_szerz_elsztipus.php');
   admin_modelsztipus_ment();
  break;
  //Elszámolás típus - vége
  
  //Naturála típus - eleje
  case'admin_ujnattipus_ment':
   include_once('admin/szerz/admin_szerz_nattipus.php');
   admin_ujnattipus_ment();
  break;
  case'admin_nattipuslist_keres':
   include_once('admin/szerz/admin_szerz_nattipus.php');
   admin_nattipuslist_keres();
  break;
  case'admin_modnattipus_ment':
   include_once('admin/szerz/admin_szerz_nattipus.php');
   admin_modnattipus_ment();
  break;
  //Naturála típus - vége
  
  //Szerződésgazda - eleje
  case'admin_ujszerzusergazda_ment':
   include_once('admin/szerz/admin_szerz_usergazda.php');
   admin_ujszerzusergazda_ment();
  break;
  case'admin_modszerzusergazda_ment':
   include_once('admin/szerz/admin_szerz_usergazda.php');
   admin_modszerzusergazda_ment();
  break;
  case'admin_szerzusergazdalist_keres':
   include_once('admin/szerz/admin_szerz_usergazda.php');
   admin_szerzusergazdalist_keres();
  break;
  case'admin_modszerzusergazda_inaktiv':
   include_once('admin/szerz/admin_szerz_usergazda.php');
   admin_modszerzusergazda_inaktiv();
  break;
  //Szerződésgazda - vége
  
  //Szolgáltatáshoz kapcsolódó adatok - eleje
  case'admin_ujszolgkapadat_porjekt_add':
   include_once('admin/szerz/admin_szerz_szolgkapadat.php');
   admin_ujszolgkapadat_porjekt_add();
  break;
  case'admin_ujszolgkapadatprojektadd_hozz_keress':
   include_once('admin/szerz/admin_szerz_szolgkapadat.php');
   admin_ujszolgkapadatprojektadd_hozz_keress();
  break;
  case'admin_ujszolgkapadat_ment':
   include_once('admin/szerz/admin_szerz_szolgkapadat.php');
   admin_ujszolgkapadat_ment();
  break;
  case'admin_szolgkapadatlist_keres':
   include_once('admin/szerz/admin_szerz_szolgkapadat.php');
   admin_szolgkapadatlist_keres();
  break;
  case'admin_ujszolgkapadat_rejt_mutat':
   include_once('admin/szerz/admin_szerz_szolgkapadat.php');
   admin_ujszolgkapadat_rejt_mutat();
  break;
  case'admin_szolgkapadat_reszlet':
   include_once('admin/szerz/admin_szerz_szolgkapadat_reszlet.php');
   admin_szolgkapadat_reszlet();
  break;
  case'admin_szolgkapadat_mod':
   include_once('admin/szerz/admin_szerz_szolgkapadat_mod.php');
   admin_szolgkapadat_mod();
  break;
  case'admin_szolgkapadat_mod_proc_urlap_mentes_proc':
   include_once('admin/szerz/admin_szerz_szolgkapadat_mod.php');
   admin_szolgkapadat_mod_proc_urlap_mentes_proc();
  break;
  //Szolgáltatáshoz kapcsolódó adatok - vége
  
  //Szolgáltatás módosításhoz kapcsolódó adatok - eleje
  case'admin_szolgmodadatlist_keres':
   include_once('admin/szerz/admin_szerz_szolgmodadat.php');
   admin_szolgmodadatlist_keres();
  break;
  case'admin_szolgmodadat_mod':
   include_once('admin/szerz/admin_szerz_szolgmodadat_mod.php');
   admin_szolgmodadat_mod();
  break;
  case'admin_szolgmodadat_mod_proc_urlap_mentes_proc':
   include_once('admin/szerz/admin_szerz_szolgmodadat_mod.php');
   admin_szolgmodadat_mod_proc_urlap_mentes_proc();
  break;
  case'admin_szolgmodadat_vege':
   include_once('admin/szerz/admin_szerz_szolgmodadat_vege.php');
   admin_szolgmodadat_vege();
  break;
  case'admin_szolgmodadat_vege_proc_ment':
   include_once('admin/szerz/admin_szerz_szolgmodadat_vege.php');
   admin_szolgmodadat_vege_proc_ment();
  break;
  //Szolgáltatás módosításhoz kapcsolódó adatok - vége
  
  //TIG sapszam - eleje
  case'admin_tigadatsapszamlist_keres':
   include_once('admin/szerz/admin_szerz_tigadat_sapszam.php');
   admin_tigadatsapszamlist_keres();
  break;
  case'admin_modtigadatsapszam_ment':
   include_once('admin/szerz/admin_szerz_tigadat_sapszam.php');
   admin_modtigadatsapszam_ment();
  break;
  //TIG sapszam - vége
  
  //TIG CO - eleje
  case'admin_tigadatcolist_keres':
   include_once('admin/szerz/admin_szerz_tigadat_co.php');
   admin_tigadatcolist_keres();
  break;
  case'admin_modtigadatco_ment':
   include_once('admin/szerz/admin_szerz_tigadat_co.php');
   admin_modtigadatco_ment();
  break;
  //TIG CO - vége
  
  //TIG vevőazonosító - eleje
  case'admin_tigadatvevoazonlist_keres':
   include_once('admin/szerz/admin_szerz_tigadat_vevoazon.php');
   admin_tigadatvevoazonlist_keres();
  break;
  case'admin_modtigadatvevoazon_ment':
   include_once('admin/szerz/admin_szerz_tigadat_vevoazon.php');
   admin_modtigadatvevoazon_ment();
  break;
  //TIG vevőazonosító - vége
  
  //Intergációs - eleje
  case'admin_integadatlist_keres':
   include_once('admin/szerz/admin_szerz_integadat.php');
   admin_integadatlist_keres();
  break;
  case'admin_integadattobblet_mod':
   include_once('admin/szerz/admin_szerz_integadat.php');
   admin_integadattobblet_mod();
  break;
  //Intergációs - vége
  
  //KPI szolgáltatás kód - eleje
  case'admin_ujkpiszolgkod_ment':
   include_once('admin/szerz/admin_kpi_szolgkod.php');
   admin_ujkpiszolgkod_ment();
  break;
  case'admin_kpiszolgkodlist_keres':
   include_once('admin/szerz/admin_kpi_szolgkod.php');
   admin_kpiszolgkodlist_keres();
  break;
  //KPI szolgáltatás kód - vége
  
  //KPI típus - eleje
   case'admin_ujkpitipus_ment':
   include_once('admin/szerz/admin_kpi_tipus.php');
   admin_ujkpitipus_ment();
  break;
  case'admin_kpitipuslist_keres':
   include_once('admin/szerz/admin_kpi_tipus.php');
   admin_kpitipuslist_keres();
  break;
  case'admin_modkpitipus_ment':
   include_once('admin/szerz/admin_kpi_tipus.php');
   admin_modkpitipus_ment();
  break;
  case'admin_modkpitipus_del_proc':
   include_once('admin/szerz/admin_kpi_tipus.php');
   admin_modkpitipus_del_proc();
  break;
  //KPI típus - vége
  
  //KPI összekapcs - eleje
  case'admin_kpiosszekaplist_keres':
   include_once('admin/szerz/admin_kpi_osszekap.php');
   admin_kpiosszekaplist_keres();
  break;
  case'admin_kpiosszekap_nemrelevans':
   include_once('admin/szerz/admin_kpi_osszekap.php');
   admin_kpiosszekap_nemrelevans();
  break;
  case'admin_kpiosszekap_kpiadd':
   include_once('admin/szerz/admin_kpi_osszekap.php');
   admin_kpiosszekap_kpiadd();
  break;
  case'admin_kpiosszekaplist_kpiadd_change':
   include_once('admin/szerz/admin_kpi_osszekap.php');
   admin_kpiosszekaplist_kpiadd_change();
  break;
  case'admin_kpiosszekaplist_kpiadd_ck':
   include_once('admin/szerz/admin_kpi_osszekap.php');
   admin_kpiosszekaplist_kpiadd_ck();
  break;
  case'admin_modkpiosszekap_ment_proc':
   include_once('admin/szerz/admin_kpi_osszekap.php');
   admin_modkpiosszekap_ment_proc();
  break;
  //KPI összekapcs - vége
  
  //Admin log - eleje
  case'admin_loglist_keres':
   include_once('admin/ajax_ful_admin_log.php');
   admin_loglist_keres();
  break;
  case'admin_loglist_archivalas':
   include_once('admin/ajax_ful_admin_log.php');
   admin_loglist_archivalas();
  break;
  //Admin log - vége
  
  //Admin pénznem - eleje
  case'admin_ujpenznem_ment':
   include_once('admin/szerz/admin_szerz_tigadat_penznem.php');
   admin_ujpenznem_ment();
  break;
  case'admin_penznemlist_keres':
   include_once('admin/szerz/admin_szerz_tigadat_penznem.php');
   admin_tigadatpenznemlist_keres();
  break;
  case'admin_modpenznem_nevment':
   include_once('admin/szerz/admin_szerz_tigadat_penznem.php');
   admin_modpenznem_nevment();
  break;
  case'admin_modpenznem_arfolyamment':
   include_once('admin/szerz/admin_szerz_tigadat_penznem.php');
   admin_modpenznem_arfolyamment();
  break;
  //Admin pénznem - vége
  
  //Admin Nem szerződés alapján TIG-elendő tételek - eleje
  case'admin_ujtigadatnemszerz':
   include_once('admin/szerz/admin_szerz_tigadat_nemszerz.php');
   admin_ujtigadatnemszerz();
  break;
  case'admin_modtigadatnemszerz_del':
   include_once('admin/szerz/admin_szerz_tigadat_nemszerz.php');
   admin_modtigadatnemszerz_del();
  break;
  case'admin_tigadatnemszerzlist_keres':
   include_once('admin/szerz/admin_szerz_tigadat_nemszerz.php');
   admin_tigadatnemszerzlist_keres();
  break;
  case'admin_modtigadatnemszerz_ment':
   include_once('admin/szerz/admin_szerz_tigadat_nemszerz.php');
   admin_modtigadatnemszerz_ment();
  break;
  //Admin Nem szerződés alapján TIG-elendő tételek - vége
  
  //Admin Ténypótlás TIG táblához - eleje
  case'ajax_keres_admin_szerz_tenypotlastig_generalas':
   include_once('admin/ajax_ful_admin_tenypotlas_tig_gen.php');
   echo 'ok$;$';
   ajax_keres_admin_szerz_tenypotlastig_generalas();
  break;
  case'admin_ujtenypotlastig_ment':
   include_once('admin/ajax_ful_admin_tenypotlas_tig.php');
   admin_ujtenypotlastig_ment();
  break;
  case'admin_tenypotlastiglist_keres':
   include_once('admin/ajax_ful_admin_tenypotlas_tig.php');
   admin_tenypotlastiglist_keres();
  break;
  case'admin_modtenypotlastig_ment':
   include_once('admin/ajax_ful_admin_tenypotlas_tig.php');
   admin_modtenypotlastig_ment();
  break;
  case'admin_modtenypotlastig_del':
   include_once('admin/ajax_ful_admin_tenypotlas_tig.php');
   admin_modtenypotlastig_del();
  break;
  //Admin Ténypótlás TIG táblához - vége
  
  case'admin_rogzito_helyettes_beallit':
   if(
   (isset($_POST['user_ad']))
   and($_POST['user_ad']!="")
   ){
	include_once("ajax_func.php");
	$_SESSION[$GLOBALS['sessionname']]['helyettes_beallit_ad']=$_POST['user_ad'];
	rogzito_helyettes_beallit();
   }else{
	   echo "adathiba";
   }
  break;
 }
}
}

function str_hosz_vag($srt_o, $max_hosz, $elvalaszto = ' ') {
    if (is_null($srt_o)) {
        $srt_o = '';
    }
    
    $srt = $srt_o;
    
    // Csak akkor foglalkozunk a vágással, ha a szöveg valóban hosszabb, mint a max_hosz
    if (mb_strlen($srt) > $max_hosz) {
        // Megkeressük az elválasztót, de csak a $max_hosz pozíciótól kezdve vizsgálódunk
        $pos = mb_strpos($srt, $elvalaszto, $max_hosz);
        
		//$srt_img="<img class='link_s img_hosz' title='".$srt_o."' src='image/info_18.png'>";
        if ($pos !== false) {
            // Ha megtalálta az elválasztót, eddig a pozícióig vágunk (így maga az elválasztó már kimarad)
            $srt = mb_substr($srt, 0, $pos) . "...";
        } else {
            // Biztonsági tartalék (Fallback): Ha a $max_hosz után már egyáltalán nincs elválasztó a szövegben,
            // akkor az eredeti logikád szerint fixen elvágjuk a $max_hosz-nál.
            
			$srt = rtrim(mb_substr($srt, 0, $max_hosz)) . "...";
        }
    }
    
    return $srt;
}
?>