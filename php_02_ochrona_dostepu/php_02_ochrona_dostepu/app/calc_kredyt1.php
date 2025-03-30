<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

//ochrona kontrolera- - podczas trybu offline
include _ROOT_PATH.'/app/security/check.php';

//pobranie potrzebnych parametrów
function getParams(&$kwota,&$lata,&$oprocentowanie){
	$kwota = isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
	$lata = isset($_REQUEST['lata']) ? $_REQUEST['lata'] : null;
	$oprocentowanie = isset($_REQUEST['oprocentowanie']) ? $_REQUEST['oprocentowanie'] : null;	
}


// walidacja  
//walidacja wraz z przygotowaniem zmiennych
function validate(&$kwota,&$lata,&$oprocentowanie,&$messages){
// sprawdzenie przekazanych parametrów
	if ( ! (isset($kwota) && isset($lata) && isset($oprocentowanie))) {
		// sytuacja kiedy np. wystąpi bezpośrednie wywołanie kontrolera
		// założenie, że nie jest to błąd. Brak wykonania obliczeń
		return false;
	}

	// sprawdzenie czy zostały przekazane wartości
	if ( $kwota == "") {
		$messages [] = 'Nie podano kwoty';
	}

	if ( $lata == "") {
		$messages [] = 'Nie podano okresu spłaty kredytu';
	}

	if ( $oprocentowanie == "") {
		$messages [] = 'Nie podano oprocentowania';
	}


	
	if (count ( $messages ) != 0) return false;
	
	
	if (! is_numeric( $kwota )) {
		$messages [] = 'Wartość kredytu nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $lata )) {
		$messages [] = 'Okres spłaty kredytu nie jest liczbą całkowitą';
	}	

	if (! is_numeric( $oprocentowanie )) {
		$messages [] = 'Oprocentowanie nie jest liczbą całkowitą';
	}

	if (count ( $messages ) != 0) return false;
    else return true;
}

function process(&$kwota,&$lata,&$oprocentowanie,&$messages,&$rataMiesieczna){
    global $role;
    
    //konwersja na float
    $kwota = floatval($kwota);
    $lata = floatval($lata);
    $oprocentowanie = floatval($oprocentowanie);
    
    // kalkulator kredytowy
    $oprocentowanieMiesieczne = ($oprocentowanie / 100) / 12; //miesięczne oprocentowanie
    $liczbaMiesiecy = $lata * 12; //liczba miesięcy
    $rataMiesieczna = ($kwota * $oprocentowanieMiesieczne) / (1 - pow(1 + $oprocentowanieMiesieczne, -$liczbaMiesiecy));
    $rataMiesieczna = round($rataMiesieczna, 2);  //zaokrąlenie do części setnej 
}

//zmienne kontrolera
$kwota = null;
$lata = null;
$oprocentowanie = null;
$rataMiesieczna = null;
$messages = array();

//pobierz parametrów jeśli wszystko jest odpowiednie
getParams($kwota,$lata,$oprocentowanie);
if ( validate($kwota,$lata,$oprocentowanie,$messages) ) { // podczas braku błędów
    process($kwota,$lata,$oprocentowanie,$messages,$rataMiesieczna);
}

//  widok z przekazaniem zmiennych
// zainicjowane zmienne ($messages,$kwota,$lata,$oprocentowanie,$rataMiesieczna)
//   zmienne w skrypcie
include 'calc_kredyt_view1.php';