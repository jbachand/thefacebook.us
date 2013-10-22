<?PHP

include('classes/classes.php');				// Include local class lib


	$log= new log($_SERVER["PHP_SELF"], $_GET, $_POST, $_SERVER['HTTP_REFERER'] ); 
	header("Location: http://meta.wikimedia.org/wiki/Don%27t_be_a_dick");
	die();
	
	?>