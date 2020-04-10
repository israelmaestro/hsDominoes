<?php
namespace Dominoes;

class Player{
	private $name;
	private $dominoes;

	public function __construct(string $name, DominoSet $dominoes){
		$this -> name = $name;
		$this -> dominoes = $dominoes;
	}

	public function moveDomino($top, $bottom){
		$dominoPosition = DominoSet :: POSITION_NONE;
		$result = null;

		foreach($this -> dominoes -> all() as $d => $domino){
			list($dominoPosition, $turn) = $domino -> matches($top, $bottom);
			if($dominoPosition != DominoSet :: POSITION_NONE){
				$result = $turn ? $domino->turn() : $domino;
				$this -> dominoes -> remove($d);
				break;
			}
		}
		return [$dominoPosition, $result];
	}

	public function noMoreDominoes(){
		return $this -> dominoes -> isEmpty();
	}

	public function prependDomino(Domino $domino){
		$this -> dominoes -> prepend($domino);
	}

	public function __toString(){
		return $this -> name;
	}

	public function dominoes(){
		return $this->dominoes->all();
	}
}
