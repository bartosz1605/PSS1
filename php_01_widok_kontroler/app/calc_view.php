<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator kredytowy</title>
</head>
<body>

<h1>Kalkulator kredytowy</h1>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="get">
    <label for="loan_amount">Kwota kredytu: </label>
    <input id="loan_amount" type="text" name="loan_amount" value="<?php isset($loan_amount)?print($loan_amount):''; ?>" /><br/>
    <label for="loan_years">Liczba lat spłaty: </label>
    <input id="loan_years" type="text" name="loan_years" value="<?php isset($loan_years)?print($loan_years):''; ?>" /><br/>
    <label for="interest_rate">Oprocentowanie (%): </label>
    <input id="interest_rate" type="text" name="interest_rate" value="<?php isset($interest_rate)?print($interest_rate):''; ?>" /><br/>
    <input type="submit" value="Oblicz" />
</form>    

<?php
//lista błędów, w razie istnienia
if (isset($messages)) {
    if (count ( $messages ) > 0) {
        echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
        foreach ( $messages as $key => $msg ) {
            echo '<li>'.$msg.'</li>';
        }
        echo '</ol>';
    }
}
?>

<?php if (isset($monthly_payment)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Miesięczna rata: '.$monthly_payment; ?>
</div>
<?php } ?>

</body>
</html>