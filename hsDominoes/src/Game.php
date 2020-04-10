<?php
namespace Dominoes;

use Dominoes\Player;

class Game{
	private $gameOver = false;
	private $dominoStock;
	private $board;
	private $boardImages;
	private $players;
	const DOMINO_SIZE = 6;
	const NUMBER_OF_PLAYERS = 5;
	const DOMINOES_AMMOUNT = 4;

	public function play(){
		$this -> dominoStock = new DominoSet();
		for($bottom = 0; $bottom <= $this :: DOMINO_SIZE; $bottom++){
			for($top = $bottom; $top <= $this :: DOMINO_SIZE; $top++){
				$domino = new Domino($top, $bottom);
				$this -> dominoStock -> append($domino);
			}
		}

		for($i = 1; $i <= $this :: NUMBER_OF_PLAYERS; $i++){
			$this -> players[] = new Player("Player-" . $i, new DominoSet($this -> dominoStock -> getRandomDominoes($this :: DOMINOES_AMMOUNT)));
		}

		$this -> board = new DominoSet();
		$this -> board -> append($this -> dominoStock -> getRandomDomino());

		$this -> getBoardImages();
		$this -> output("<p class='gameStartBoard'>GAME START: " . $this -> boardImages . "</p>");

		while(!$this -> gameOver){
			foreach($this -> players as $player){
				try{
					$this -> getBoardImages();
					$this -> output("<p class='boardStatus'>Board Status:" . $this -> boardImages . "</p>");
					$this -> shot($player);
					$this -> checkWinner($player);
					$this -> checkStock();

					if($this -> gameOver){
						break;
					}
				}catch(Exception $e){
					$this -> output($e -> getMessage());
				}
			}
		}
	}

	private function getBoardImages(){
		$this -> boardImages = "";
		$board = explode(" ", $this -> board);

		foreach($board as $boardImg){
			$this -> boardImages = $this -> boardImages . " <img class='domino' src='img/dominoes/$boardImg.png'/>";
		}
	}

	private function shot(Player $player){
		$domino = null;
		$position = DominoSet :: POSITION_NONE;

		while(empty($domino) && !$this -> dominoStock -> isEmpty()){
			list ($position, $domino) = $player -> moveDomino($this -> board -> top(), $this -> board -> bottom());

			if(!empty($domino)){
				$this -> output("<p class='player'>$player: <img class='domino' src='img/dominoes/$domino.png'/></p>");
				$this -> board -> add($position, $domino);
			}else{
				$dominoFromStock = $this -> dominoStock -> getRandomDomino();
				$player -> prependDomino($dominoFromStock);
				$this -> output("<p class='drawFromStock'>$player drew from stock: <img class='domino' src='img/dominoes/$dominoFromStock.png'/></p>");
			}
		}
	}

	private function checkWinner(Player $player){
		if($player -> noMoreDominoes()){
			$this -> output("<p class='winner'>$player WON!!!");

			foreach($this -> players as $p){
				if(!empty($p -> dominoes())){
					$playerDominoesImages = "";

					foreach($p -> dominoes() as $d){
						$playerDominoesImages = "$playerDominoesImages <img class='domino' src='img/dominoes/$d.png'/>";
					}

					$this -> output("<br/><br/>$p: $playerDominoesImages");
				}
			}

			$this -> output("</p>");
			$this -> gameOver = true;
		}
	}

	private function checkStock(){
		if($this -> dominoStock -> isEmpty()){
			$sizes = array();
			$winner = null;

			$this -> output("<p class='winner'>Out of stock!!!<br/><br/>");

			$this -> getBoardImages();
			$this -> output("Board Status:" . $this -> boardImages . "<br/><br/>");

			foreach($this -> players as $i => $p){
				$playerDominoesImages = "";

				foreach($p -> dominoes() as $d){
					$playerDominoesImages = "$playerDominoesImages <img class='domino' src='img/dominoes/$d.png'/>";
				}

				$this -> output("$p: $playerDominoesImages<br/><br/>");

				$sizes[] = count($p -> dominoes());
			}

			$countMin;

			foreach($sizes as $s){
				if($s === min($sizes)){
					$countMin[] = $s;
				}
			}

			if(count($countMin) === 1){
				foreach($sizes as $i => $s){
					if($s === min($sizes)){
						$winner = $i;
					}
				}
			}

			if(null !== $winner){
				$this -> output($this -> players[$winner] . " won!!!");
			}else{
				$this -> output("GAME OVER!!!");
			}

			$this -> gameOver = true;
		}
	}

	private function output($message){
		echo "$message";
	}
}
