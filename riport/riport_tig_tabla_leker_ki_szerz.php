<?php

$ma=date("Y-m-d",time());

$GLOBALS['tigtabla_proj33']=keres_riport_tig_tabla_proj33($ev,$ho_ig);
$GLOBALS['tigtabla_egyebnat']=keres_riport_tig_tabla_egyebnat($ev,$ho_ig);

if(is_array($GLOBALS['tigtabla_tomb'])){
foreach($GLOBALS['tigtabla_tomb'] as $szerz_tetel_id => $ert){
 
 $elso_modositas=min(array_keys($ert));
 $utolso_modositas=max(array_keys($ert));

 //Ki találjuk hogy mi a kezdő és vég hónap
 $tomb_ho=tig_kezdveg_hokitalal($ev,$ho_ig,$ert,$elso_modositas,$utolso_modositas);
 if(
 ($tomb_ho['kezd']!='')and($tomb_ho['veg']!='')and
 ($tomb_ho['kezd']<=$tomb_ho['veg'])
 
 ){
  for($ho=$tomb_ho['kezd'];$ho<=$tomb_ho['veg'];$ho++){
   $i++;
   
   //Szolgáltatás ID
   if($tomb_ho['tulfutas']=='1'){
    $adat[$i][]='<style bgcolor="#FF0000">'.$szerz_tetel_id;
   }elseif($tomb_ho['tulfutas_nincs_u']=='1'){
	$adat[$i][]='<style bgcolor="#00F300">'.$szerz_tetel_id;
   }else{
    $adat[$i][]=$szerz_tetel_id;
   }
   
	$adat[$i][]=$ev;
	$adat[$i][]=$ho;
	
	//Megrendelő
	$adat[$i][]=$ert[$utolso_modositas]['tagv_kod_nev'];
	
	//Vevő azonosító
	$adat[$i][]=$ert[$utolso_modositas]['tagv_kod_vevoazon'];
	
	//Partner kód
	$adat[$i][]='MC'.$ert[$utolso_modositas]['tagv_kod'];
	
	//Szerződés típusa
	$adat[$i][]=$ert[$utolso_modositas]['szerz_tipus_nev'];
	
	//Szerződés MVMS / BSZK
	$adat[$i][]='';//Üres marad
	
	//Szolgáltatás
	$adat[$i][]=$ert[$utolso_modositas]['szolg_kod_nev'];
	
	//Szerződés HA AD korábbi mint a  map dátum, akkor megszünt, különben VAN!
	if(($ert[$utolso_modositas]['ad']!='')and($ert[$utolso_modositas]['ad']<=$ma)){
	 $adat[$i][]='Megszűnt';
	}else{
	 $adat[$i][]='Van';	
	}
	
	//elszámolás módja
	$adat[$i][]=$ert[$utolso_modositas]['szerz_elsz_tipus_nev'];
	
	//Megjegyzés
	$adat[$i][]='';//Üres marad

	//Óra / fő / napi díj
	//ha az óradíj ki van töltve, akkor azt, ha a Nettó szerződés díj (eseti/maximális keret), akkor azt, ha mindkettő üres, akkor üres
	//Óradíj: szerz_tetel_oradij
	//Nettó szerződés díj (eseti/maximális keret): szerz_tetel_netto_szerzdij

	if($ert[$utolso_modositas]['szerz_tetel_oradij']!=''){
	 $adat[$i][]=$ert[$utolso_modositas]['szerz_tetel_oradij'];	
	}elseif($ert[$utolso_modositas]['szerz_tetel_netto_szerzdij']!=''){
	 $adat[$i][]=$ert[$utolso_modositas]['szerz_tetel_netto_szerzdij'];	
	}else{
	 $adat[$i][]='';//Üres marad	
	}
	
	
	//MIRA óraszám
	$adat[$i][]=projekt_osszead($ert[$utolso_modositas]['projekt_id_tomeges']);
	
	//egyéb naturália db, nap, fő, nm, dm3, stb 
	//Elszámolás típusa nem havidíjas fix, akkor kell behozni az egyedi értékét.
	//szóval mindig amikor nem 1-es
	if(
	($ert[$utolso_modositas]['szerz_elsz_tipus_id']!='1')and
	(isset($GLOBALS['tigtabla_egyebnat'][$szerz_tetel_id][$ho]))
	){
		$adat[$i][]="\0".$GLOBALS['tigtabla_egyebnat'][$szerz_tetel_id][$ho];
	}else{
		$adat[$i][]='';//Üres marad
	}
	
	//db -új oszlop fizigényhez
	$adat[$i][]='';//Üres marad
	
	//szerződéses összeg EUR-ban
	if($ert[$utolso_modositas]['szerz_tetel_netto_havidij_penznem']!='HUF'){
	 $adat[$i][]=$ert[$utolso_modositas]['szerz_tetel_netto_szerzdij'];
	}else{
	 $adat[$i][]='';//Üres marad
	}
	
	//Hó végi árfolyam
	if(
	($ert[$utolso_modositas]['szerz_tetel_netto_havidij_penznem']!='HUF')and
	(isset($GLOBALS['tigtabla_tomb_nemszerz_arfolyam'][$ert[$utolso_modositas]['szerz_tetel_netto_havidij_penznem']][$ev.$ho]))
	){
	 $adat[$i][]=$GLOBALS['tigtabla_tomb_nemszerz_arfolyam'][$ert[$utolso_modositas]['szerz_tetel_netto_havidij_penznem']][$ev.$ho];
	}else{
	 $adat[$i][]='';//Üres marad
	}
	
	//Havi Összeg Forintban 2025
	
  }

 
 }
}
}
?>