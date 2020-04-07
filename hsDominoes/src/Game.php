<?php
namespace Dominoes;

class Game{

	private $gameOver = false;
	private $dominoStock;
	private $board;
	private $boardImages;
	private $players;

	public function play(){
		$this -> init();
		$this -> boardImages();
		$this -> output("<p class='gameStartBoard'>GAME START: " . $this -> boardImages . "</p>");

		while(!$this -> gameOver){
			foreach($this -> players as $player){
				try{
					$this -> boardImages();
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

	private function boardImages(){
		$this -> boardImages = "";
		$board = explode(" ", $this -> board);

		foreach($board as $boardImg){
			$this -> boardImages = $this -> boardImages . " <img class='domino' src='img/dominoes/$boardImg.png'/>";
		}
	}

	private function init(){
		$this -> dominoStock = new DominoSet();
		for($bottom = 0; $bottom <= 6; $bottom++){
			for($top = $bottom; $top <= 6; $top++){
				$domino = new Domino($top, $bottom);
				$this -> dominoStock -> append($domino);
			}
		}

		$this -> players[] = new Player("Player-01", new DominoSet($this -> dominoStock -> getRandomDominoes(7)));
		$this -> players[] = new Player("Player-02", new DominoSet($this -> dominoStock -> getRandomDominoes(7)));

		$this -> board = new DominoSet();
		$this -> board -> append($this -> dominoStock -> getRandomDomino());
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
			$this -> output("<p class='winner'>$player WON!!</p>");
			$this -> gameOver = true;
		}
	}

	private function checkStock(){
		if($this -> dominoStock -> isEmpty()){
			$this -> output("<p class='winner'>Out of stock!!! Game Over!!!</p>");
			$this -> gameOver = true;
		}
	}

	private function output($message){
		echo "$message";
	}
}
