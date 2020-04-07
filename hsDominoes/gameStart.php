<?php
spl_autoload_register(
	function ($class){
		$file = str_replace(
			["\\", "Dominoes"],
			[DIRECTORY_SEPARATOR,"src"],
			$class
			).".php";
			if(file_exists($file)){
				require $file;
				return true;
			}
			return false;
	}
	);

use Dominoes\Game;
?>

<!DOCTYPE
	html
	PUBLIC
	"-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"
	>
<html>
	<head>
		<link href="styles/styles.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<center>
			<img class="letter" src="img/letters/Dominoes-letters-D.png"/>
			<img class="letter" src="img/letters/Dominoes-letters-O.png"/>
			<img class="letter" src="img/letters/Dominoes-letters-M.png"/>
			<img class="letter" src="img/letters/Dominoes-letters-I.png"/>
			<img class="letter" src="img/letters/Dominoes-letters-N.png"/>
			<img class="letter" src="img/letters/Dominoes-letters-O.png"/>
			<img class="letter" src="img/letters/Dominoes-letters-E.png"/>
			<img class="letter" src="img/letters/Dominoes-letters-S.png"/>
			<br/>
			<b class="gameTitle">GAME DEMO</b>
		</center>

		<?php
			$game = new Game();
			$game -> play();
		?>
	</body>
</html>