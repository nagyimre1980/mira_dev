<?php
ini_set('session.sid_length', 32);
date_default_timezone_set('Europe/Budapest');
function cleanupExcelFiles($directory, $filePrefix, $keepCount,$kit='xlsx') {

//$test=1;
$test=$GLOBALS['excel_auto_mappa_teszt'];

    // Ellenőrizzük, hogy létezik-e a mappa
    if (!is_dir($directory)) {
		if($test=='1'){
         echo "Hiba: A megadott mappa nem létezik: $directory<br>";
		}
        return;
    }

    // 1. lépés: Fájlok összegyűjtése, amelyek a megadott névvel kezdődnek és .xlsx a végük
    // A glob() függvény használata a leggyorsabb erre
    //$pattern = rtrim($directory, '/') . '/' . $filePrefix . '*.xlsx';
    $pattern = rtrim($directory, '/') . '/' . $filePrefix . '*.'.$kit;
    $files = glob($pattern);

    if (empty($files)) {
        if($test=='1'){
		 echo "Nem található fájl a megadott feltételekkel.<br>";
		}
        return;
    }

    $fileData = [];

    // 2. lépés: Fájlnevek elemzése
    foreach ($files as $filePath) {
        $filename = basename($filePath);
        
        // A kiterjesztés (.xlsx) hossza 5 karakter.
        // A dátum formátum (2026_01_12-11_05_55) hossza 19 karakter.
        // Tehát a fájlnévnek legalább 24 karakternek kell lennie.
        if (strlen($filename) < 24) {
            continue; // Túl rövid a fájlnév, átugorjuk (biztonsági okból)
        }

        // Levágjuk a .xlsx kiterjesztést
		if($kit=='csv')
         $nameWithoutExt = substr($filename, 0, -4);
        else
		 $nameWithoutExt = substr($filename, 0, -5);

        // Kivesszük az utolsó 19 karaktert (ez a dátum string)
        $dateString = substr($nameWithoutExt, -19);

        // Opcionális: Ellenőrizzük regex-szel, hogy tényleg dátum formátum-e (ÉÉÉÉ_HH_NN-ÓÓ_PP_MP)
        // Ez megakadályozza, hogy olyan fájlt töröljünk, aminek a vége nem dátum.
        if (!preg_match('/^\d{4}_\d{2}_\d{2}-\d{2}_\d{2}_\d{2}$/', $dateString)) {
            // Ha a vége nem illeszkedik a formátumra, békén hagyjuk a fájlt
            continue; 
        }

        // Eltároljuk a fájl elérési útját és a dátum stringet
        // Mivel a dátum ÉÉÉÉ_HH... formátumú, sima ABC sorrendbe rendezés is helyes időrendet ad.
        $fileData[$filePath] = $dateString;
    }

    // 3. lépés: Rendezés csökkenő sorrendbe (a legújabb dátum legyen elöl)
    // arsort: érték szerint rendez (dátum), de megtartja a kulcsokat (fájl útvonal)
    arsort($fileData);

    // Kinyerjük a fájlok listáját a rendezés után
    $sortedFiles = array_keys($fileData);

    // 4. lépés: Megtartjuk az első N darabot, a többit töröljük
    // array_slice: levágjuk azokat, amiket törölni kell (a $keepCount indextől a végéig)
    $filesToDelete = array_slice($sortedFiles, $keepCount);
    
    // Visszajelzés a megtartott fájlokról (opcionális, csak logolás)
    if($test=='1'){
	echo "<strong>Megtartva (Legfrissebbek):</strong><br>";
    $keptFiles = array_slice($sortedFiles, 0, $keepCount);
	foreach ($keptFiles as $file) {
        echo basename($file) . "<br>";
    }
	}

	if($test=='1'){
     echo "<br><strong>Törlésre kijelölve:</strong><br>";
	}
	
    if (empty($filesToDelete)) {
        if($test=='1') echo "Nincs törlendő fájl (kevesebb vagy pont annyi van, mint a limit).<br>";
    } else {
        foreach ($filesToDelete as $file) {
            // Itt történik a fizikai törlés
            if (unlink($file)) {
                if($test=='1') echo "Törölve: " . basename($file) . "<br>";
            } else {
                if($test=='1') echo "Hiba a törlésnél: " . basename($file) . "<br>";
            }
        }
    }
}
?>