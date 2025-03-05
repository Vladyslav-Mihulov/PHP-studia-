<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator kredytowy</title>
</head>
<body>

<form action="<?php print(_APP_URL);?>/app/kredyt.php" method="get">
	<label for="id_kwota">Kwota: </label>
	<input id="id_kwota" type="text" name="kwota" value="<?php isset($kwota)?print($kwota): " " ; ?>" /><br />
	<label for="id_op">Oprocentowanie: </label>
	<select name="op">
		<option value="1%">1%</option>
		<option value="1,5%">1,5%</option>
		<option value="2%">2%</option>
		<option value="2,5%">2,5%</option>
	</select><br />
	<label for="id_okres">Okres ( Proszę podać ilość w latach`): </label>
	<input id="id_okres" type="text" name="okres" value="<?php isset($okres)?print($okres): " " ; ?>" /><br />
	<input type="submit" value="Oblicz" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
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

<?php if (isset($result)){ ?>
<div style="margin: 50px; padding: 30px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Musisz miesięcznie płacić: '.$result; ?>
</div>
<?php } ?>

</body>
</html>