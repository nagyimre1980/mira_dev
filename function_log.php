<?php

$GLOBALS[$GLOBALS['sessionname']]['log_mod_all']='0';//Ha 1, akkor minden tábláról készül mentés, különben csak alap

function log_ment($mod, $tabla, $adat, $where_hol, $where_mi, $where_hol2 = '', $where_mi2 = '', $where_hol3 = '', $where_mi3 = '') {

$log_tiltas_tabla=array();
//Táblák, amik mindig tiltva vannak
$log_tiltas_tabla['mira_log']='';
$log_tiltas_tabla['mira_user_ker_jog']=''; 
$log_tiltas_tabla['mira_user_ker_jog_admin']=''; 

//Ha 0 azaz alap, akkor ezek vannak tiltva, ezekről nincs logolás
if($GLOBALS[$GLOBALS['sessionname']]['log_mod_all']!='1'){
 $log_tiltas_tabla['rogzit']=''; 
 $log_tiltas_tabla['rogzit_ho']=''; 
 $log_tiltas_tabla['rogzit_ho_projekt']=''; 
 $log_tiltas_tabla['rogzit_ho_projekt_stat']=''; 
 $log_tiltas_tabla['rogzit_ho_stat']=''; 
 $log_tiltas_tabla['rogzit_sor']=''; 
}

	//if($tabla == 'fiona_log'){
	if(isset($log_tiltas_tabla[$tabla])){
        return true;
    }/*elseif(str_starts_with($tabla, 'bakcup_')){//backup mindig true
		return true;
	}*/

    // Előzmény adat lekérése
    $adat_elozmeny = keres_log_ment($tabla, $where_hol, $where_mi, $where_hol2, $where_mi2, $where_hol3, $where_mi3, $adat);

    $tmp_bk_ker_def[0] = [];
    $tmp_bk_ker_def[0]['log_mod']     = $mod;
    $tmp_bk_ker_def[0]['log_muvelet'] = $tabla;

    if ($mod == 'mod' || $mod == 'del') {
        $tmp_bk_ker_def[0]['log_hol']   = $where_hol;
        $tmp_bk_ker_def[0]['log_ertek'] = $where_mi;

        if ($where_hol2 != '') {
            $tmp_bk_ker_def[0]['log_hol2']  = $where_hol2;
            $tmp_bk_ker_def[0]['log_ertek2'] = $where_mi2;
        }
		
		if ($where_hol3 != '') {
            $tmp_bk_ker_def[0]['log_hol3']  = $where_hol3;
            $tmp_bk_ker_def[0]['log_ertek3'] = $where_mi3;
        }

        $adat_b = ($mod == 'mod') ? [$adat] : null;
    } else {
        $adat_b = $adat;   // bevitel esetén ez a teljes tömb
    }

    // Diff készítése
    if (is_array($adat_elozmeny) && !empty($adat_elozmeny)) {
        $eredmeny = removeIdenticalFieldsBoth($adat_b, $adat_elozmeny);
        $adat_b        = $eredmeny['tomb1'];
        $adat_elozmeny = $eredmeny['tomb2'];
    }

    // === JAVÍTÁS: TISZTA JSON TÖMB multi-row esetén ===
    $json_elozmeny = null;
    $json_adat     = null;

    if (!empty($adat_elozmeny) && is_array($adat_elozmeny)) {
        // Ha numerikus kulcsos tömb → force-oljuk tömb formátumot
        $clean_elozmeny = array_values($adat_elozmeny);
        $json_elozmeny  = json_encode($clean_elozmeny, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		//$json_elozmeny = json_encode($clean_elozmeny, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    if (!empty($adat_b) && is_array($adat_b)) {
        $clean_adat = array_values($adat_b);           // ez a lényeg!
        $json_adat  = json_encode($clean_adat, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		//$json_adat = json_encode($clean_adat, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    // Csak akkor mentsünk, ha van tényleges változás vagy törlés
    $van_valtozas = ($mod == 'del') ||
                    (!empty($json_adat) && $json_adat !== '[]') ||
                    (!empty($json_elozmeny) && $json_elozmeny !== '[]');

    if ($van_valtozas) {
        $tmp_bk_ker_def[0]['log_adat_elozmeny'] = $json_elozmeny;
        $tmp_bk_ker_def[0]['log_adat']          = $json_adat;
        $tmp_bk_ker_def[0]['ment_ki_log_user_ad'] = $_SESSION[$GLOBALS['sessionname']]['login_ad'] ?? null;

        be_visz_insert_log("mira_log", $tmp_bk_ker_def);
    }
}

/*
function log_ment_ujjj($mod,$tabla,$adat,$where_hol,$where_mi,$where_hol2='',$where_mi2='',$where_hol3='',$where_mi3=''){
    if($tabla == 'fiona_log'){
        return true;
    }

    // Előzmény adat lekérése
    $adat_elozmeny = keres_log_ment($tabla,$where_hol,$where_mi,$where_hol2,$where_mi2,$where_hol3,$where_mi3,$adat);
 
    $tmp_bk_ker_def[0] = array();
    $tmp_bk_ker_def[0]['log_mod'] = $mod;
    $tmp_bk_ker_def[0]['log_muvelet'] = $tabla;
 
    if($mod == 'mod' || $mod == 'del'){
        $tmp_bk_ker_def[0]['log_hol'] = $where_hol;
        $tmp_bk_ker_def[0]['log_ertek'] = $where_mi;
        
        if($where_hol2 != '') { $tmp_bk_ker_def[0]['log_hol2'] = $where_hol2; $tmp_bk_ker_def[0]['log_ertek2'] = $where_mi2; }
        if($where_hol3 != '') { $tmp_bk_ker_def[0]['log_hol3'] = $where_hol3; $tmp_bk_ker_def[0]['log_ertek3'] = $where_mi3; }
        
        $adat_b = ($mod == 'mod') ? array($adat) : '';
    } else {
        $adat_b = $adat;
    }

    // Diff készítése
    if(is_array($adat_elozmeny)){
        $eredmeny = removeIdenticalFieldsBoth($adat_b, $adat_elozmeny);
        $adat_b = $eredmeny['tomb1'];
        $adat_elozmeny = $eredmeny['tomb2'];

        // arrayToCustomString HELYETT Natív JSON mentés
        $tmp_bk_ker_def[0]['log_adat_elozmeny'] = json_encode($adat_elozmeny, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
 
    if(is_array($adat_b)){
        // arrayToCustomString HELYETT Natív JSON mentés
        $tmp_bk_ker_def[0]['log_adat'] = json_encode($adat_b, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
 
    // Ha nincs módosítás (üres a JSON tömb), akkor nincs lementés!
    $adat_b_json = json_encode($adat_b);
    $adat_elozmeny_json = json_encode($adat_elozmeny);

    if((($adat_b_json != $adat_elozmeny_json) && !empty($adat_b)) || ($mod == 'del')){
        $tmp_bk_ker_def[0]['ment_ki_log_user_ad'] = $GLOBALS[$GLOBALS['sessionname']]['login_ad'];
        be_visz_insert_log("fiona_log", $tmp_bk_ker_def);
    }
}

function log_ment_old($mod,$tabla,$adat,$where_hol,$where_mi,$where_hol2='',$where_mi2='',$where_hol3='',$where_mi3=''){
 if(
 ($tabla=='fiona_log')
 ){
	 return true;
 }

 //Előzmény adat lekeresése
 $adat_elozmeny=keres_log_ment($tabla,$where_hol,$where_mi,$where_hol2,$where_mi2,$where_hol3,$where_mi3,$adat);
 
 $tmp_bk_ker_def[0]=array();
 $tmp_bk_ker_def[0]['log_mod']=$mod;//jogosultság
 $tmp_bk_ker_def[0]['log_muvelet']=$tabla;//user tábla
 
 if($mod=='mod'){
  $tmp_bk_ker_def[0]['log_hol']=$where_hol;//user tábla
  $tmp_bk_ker_def[0]['log_ertek']=$where_mi;//user tábla
  
  if($where_hol2!='') $tmp_bk_ker_def[0]['log_hol2']=$where_hol2;
  if($where_mi2!='') $tmp_bk_ker_def[0]['log_ertek2']=$where_mi2;
  
  if($where_hol3!='') $tmp_bk_ker_def[0]['log_hol3']=$where_hol3;
  if($where_mi3!='') $tmp_bk_ker_def[0]['log_ertek3']=$where_mi3;
  
  $adat_b[0]=$adat;
 }elseif($mod=='del'){
  $tmp_bk_ker_def[0]['log_hol']=$where_hol;//user tábla
  $tmp_bk_ker_def[0]['log_ertek']=$where_mi;//user tábla
  
  if($where_hol2!='') $tmp_bk_ker_def[0]['log_hol2']=$where_hol2;
  if($where_mi2!='') $tmp_bk_ker_def[0]['log_ertek2']=$where_mi2;
  
  if($where_hol3!='') $tmp_bk_ker_def[0]['log_hol3']=$where_hol3;
  if($where_mi3!='') $tmp_bk_ker_def[0]['log_ertek3']=$where_mi3;
  
  $adat_b='';
 }else{
  $adat_b=$adat;
 }


 if(is_array($adat_elozmeny)){

   $eredmeny = removeIdenticalFieldsBoth($adat_b,$adat_elozmeny);
   $adat_b = $eredmeny['tomb1'];
   $adat_elozmeny = $eredmeny['tomb2'];

  //$tmp_bk_ker_def[0]['log_adat_elozmeny']=print_r($adat_elozmeny,true);
  $tmp_bk_ker_def[0]['log_adat_elozmeny']=arrayToCustomString($adat_elozmeny);
 }
 
  
 //$tmp_bk_ker_def[0]['log_adat']=print_r($adat,true);
 if(is_array($adat_b)){
  $tmp_bk_ker_def[0]['log_adat']=arrayToCustomString($adat_b);
 }
 
 //Ha nincs módosítás, akkor nincs lementés!
 if(
 (($adat_b!=$adat_elozmeny)and($adat_b!=''))or
 ($mod=='del')
 ){
  $tmp_bk_ker_def[0]['ment_ki_log_user_ad']=$GLOBALS[$GLOBALS['sessionname']]['login_ad'];
  be_visz_insert("fiona_log",$tmp_bk_ker_def);
 }
 
}

*/

function keres_log_ment($tabla,$where_hol,$where_mi,$where_hol2,$where_mi2,$where_hol3,$where_mi3,$adat){
 $eredmeny_keres="";
 
 if($where_mi!='')$where_mi=mysqli_real_escape_string($GLOBALS['mysqli'],$where_mi);
 if($where_mi2!='')$where_mi2=mysqli_real_escape_string($GLOBALS['mysqli'],$where_mi2);
 if($where_mi3!='')$where_mi3=mysqli_real_escape_string($GLOBALS['mysqli'],$where_mi3);
 
 if(!is_array($adat))return '';
 if($where_hol=='')return '';
 
 $mit='';
 foreach($adat as $mezo => $ert){
	 if($mit!='')$mit.=',';
	 $mit.=$mezo;
 }
 if($mit!='')$mit.=' ';
 else return '';
 
 $sql="SELECT ".$mit." FROM `".$tabla."` 
 where 
 ".$where_hol." = '".$where_mi."' ";
 if($where_hol2!='') $sql.=" and ".$where_hol2." = '".$where_mi2."' ";
 if($where_hol3!='') $sql.=" and ".$where_hol3." = '".$where_mi3."' ";
 
 $sql.=" limit 100";
 //print_r($adat);
 //print $sql."<br>";
 //exit;
  $adat=mysqli_query($GLOBALS['mysqli'],$sql);
 while($adatom=mysqli_fetch_assoc($adat)){
  if(!is_array($eredmeny_keres))$eredmeny_keres=array();
  $eredmeny_keres[]=$adatom;
 }
 //if(sizeof($eredmeny_keres)==1)
//	 $eredmeny_keres=$eredmeny_keres[0];
 return $eredmeny_keres;
}

/**
 * Átalakítja a tömböt a kívánt formátumba
 * Mezők elválasztója: ,$,
 * Sorok elválasztója: ;$;
 */

/*
function arrayToCustomString(array $array): string{
    if (empty($array)) {
        return '';
    }
 

    $rows = [];

    foreach ($array as $key => $value) {
        if (is_array($value)) {
            // Több soros tömb esete ([0] => Array(...), [1] => Array(...))
            $parts = [];
            foreach ($value as $field => $val) {
                $parts[] = '[' . $field . '] => ' . $val;
            }
            $rows[] = implode(',$,', $parts);   // mezők elválasztója: ,$,
        } 
        else {
            // Egyszerű asszociatív tömb esete ([admin_muv] => user)
            $rows[] = '[' . $key . '] => ' . $value;
        }
    }

    // Sorok elválasztója: ;$;
    return implode(';$;', $rows);
}
*/

/**
 * Két tömb összehasonlítása: azonos mező-érték párokat törli mindkettőből
 * Csak akkor végez módosítást, ha a két tömb szerkezete megegyezik (ugyanannyi mező minden sorban)
 * 
 * @return array [ 'tomb1' => modified_tomb1, 'tomb2' => modified_tomb2 ]
 */
function removeIdenticalFieldsBoth(array $tomb1, array $tomb2): array{
    if (empty($tomb1) || empty($tomb2)) {
        return ['tomb1' => $tomb1, 'tomb2' => $tomb2];
    }

    // Normalizálás (hogy kezelni tudjuk mind a [0] => array() mind a közvetlen mezős formát)
    $norm1 = normalizeArray($tomb1);
    $norm2 = normalizeArray($tomb2);

    // Ha a szerkezet nem egyforma → nem módosítunk semmit
    if (!hasSameStructure($norm1, $norm2)) {
        return ['tomb1' => $tomb1, 'tomb2' => $tomb2];
    }

    $result1 = [];
    $result2 = [];

    foreach ($norm1 as $rowIndex => $row1) {
        $row2 = $norm2[$rowIndex] ?? [];

        $newRow1 = [];
        $newRow2 = [];

        foreach ($row1 as $key => $value1) {
            $value2 = $row2[$key] ?? null;

            // Ha az érték megegyezik mindkét tömbben → töröljük mindkettőből
            if ($value2 !== null && $value1 == $value2) {
                continue;                    // azonos → kihagyjuk mindkettőből
            }

            // Különbözik vagy csak az egyikben van → megtartjuk
            $newRow1[$key] = $value1;
            if ($value2 !== null) {
                $newRow2[$key] = $value2;
            }
        }

        // Ha maradt valami a sorban, akkor hozzáadjuk
        if (!empty($newRow1)) {
            $result1[$rowIndex] = $newRow1;
        }
        if (!empty($newRow2)) {
            $result2[$rowIndex] = $newRow2;
        }
    }

    // Visszaalakítjuk az eredeti formára (ha egyszerű tömb volt, akkor ne legyen [0])
    return [
        'tomb1' => restoreOriginalStructure($result1, $tomb1),
        'tomb2' => restoreOriginalStructure($result2, $tomb2)
    ];
}

/* ===================== SEGÉDFÜGGVÉNYEK ===================== */

function normalizeArray(array $array): array{
    $normalized = [];
    $firstValue = reset($array);

    if (is_array($firstValue)) {
        // Több soros tömb ([0] => [...], [1] => [...])
        foreach ($array as $row) {
            $normalized[] = $row;
        }
    } else {
        // Egyszerű asszociatív tömb ([admin_muv] => 'user')
        $normalized[] = $array;
    }
    return $normalized;
}

function hasSameStructure(array $norm1, array $norm2): bool{
    if (count($norm1) !== count($norm2)) {
        return false;
    }
    foreach ($norm1 as $i => $row) {
        if (count($row) !== count($norm2[$i] ?? [])) {
            return false;
        }
    }
    return true;
}

function restoreOriginalStructure(array $normalized, array $original): array{
    $firstKey = array_key_first($original);
    $firstValue = $original[$firstKey] ?? null;

    // Ha az eredeti egyszerű tömb volt (nem numerikus indexű), akkor visszaalakítjuk
    if (!is_array($firstValue) && $firstKey !== 0 && $firstKey !== '0') {
        return $normalized[0] ?? [];
    }

    return $normalized;
}

/*
// Memória használat logolása az error logba
function log_memory_usage($label = '') {
    $current = round(memory_get_usage(true) / 1024 / 1024, 2);     // aktuális MB
    $peak    = round(memory_get_peak_usage(true) / 1024 / 1024, 2); // peak MB
    $limit   = ini_get('memory_limit');

    $log_text = date('Y-m-d H:i:s') . " [MEMORY] " . $label 
                . " | Current: " . $current . " MB"
                . " | Peak: " . $peak . " MB"
                . " | Limit: " . $limit;

    error_log($log_text);
    
    // Opcionális: ha nagyon magas, írjuk ki figyelmeztetésként is
    if ($current > 100) {   // ha több mint 100 MB-ot használ
        error_log("*** FIGYELMEZTETÉS: Magas memória használat! *** " . $label);
    }
}
*/

function be_visz_insert_log($tabla,$tomb){//Adatokat bevisz, új sor, lehet több is egyszerre.  $tmp[0]['nev']="Nagy Feró"; 

 foreach($tomb as $a =>$b){
 $mit="(";
 $mire="(";
 $i=0;
  foreach($b as $c => $d)
  {
   $i++;
   if(!is_null($d))
    $d=mysqli_real_escape_string($GLOBALS['mysqli'],$d);
   if($i!=1) {$mit.=",";}
   $mit.="`".$c."`";
   
   if($i!=1) {$mire.=",";}

   if(!is_null($d))
	$mire.="'".$d."'";
   else
	$mire.="null";

  }
  $mit.=")";
  $mire.=")";
  //sql összerakása, majd végrehajtása
  $sql="insert INTO `".$tabla."` ".$mit." VALUES ".$mire."";
  //print $sql;

	  if(mysqli_query($GLOBALS['mysqli'],$sql)){
	   //print "Mentés sikeres<br>";
	   $jo=1;
	  } else {
	  if($GLOBALS['test_sql_hibaki']=='0'){
	   //echo"<b><font color=red>Valami hiba történt!</font></b>";
	  }else{
	   //echo"<b><font color=red>Valami hiba történt! Szólj MVM KONTÓ Zrt-nek!</font></b>";
	   //echo("<br>MySQL error: ".mysqli_errno($GLOBALS['mysqli']).", ".mysqli_error($GLOBALS['mysqli'])."<br>in sql: ".$sql);
	  }
	   //exit;
	  }

 }
 //return $jo;
}
?>