<!DOCTYPE html>
<html>
<head>
	<title>Oups !</title>
</head>
<style type="text/css">

h2{
	text-align: center;
	color: white;
}
fieldset{
    background-image: linear-gradient(to right, black, #578aa9);
}

</style>
<body>
	<fieldset>
		<h2>Le site est indisponible pour l'instant, nous mettons tout en oeuvre pour vous accueillir de nouveau rapidement.</h2>
</fieldset>
<?= $errorMessage ?>
<pre><?php print_r($GLOBALS);?></pre>
</body>
</html>