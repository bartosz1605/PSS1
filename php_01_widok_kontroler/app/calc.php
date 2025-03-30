<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// Parametry bezpośrednio z formularza
$loan_amount = isset($_GET['loan_amount']) ? $_GET['loan_amount'] : null;
$loan_years = isset($_GET['loan_years']) ? $_GET['loan_years'] : null;
$interest_rate = isset($_GET['interest_rate']) ? $_GET['interest_rate'] : null;

// Walidacja danych
$messages = array();
if (!is_numeric($loan_amount) || $loan_amount <= 0) {
    $messages[] = 'Niepoprawna kwota kredytu.';
}
if (!is_numeric($loan_years) || $loan_years <= 0) {
    $messages[] = 'Niepoprawna liczba lat spłaty.';
}
if (!is_numeric($interest_rate) || $interest_rate <= 0) {
    $messages[] = 'Niepoprawne oprocentowanie.';
}

// Miesięczna rata kredytu
if (empty($messages)) {
    $monthly_interest = $interest_rate / 100 / 12;
    $num_payments = $loan_years * 12;
    $monthly_payment = ($loan_amount * $monthly_interest) / (1 - pow(1 + $monthly_interest, -$num_payments));
    $monthly_payment = round($monthly_payment, 2);
}

// Widok z przekazaniem zmiennych
include 'calc_view.php';
?>