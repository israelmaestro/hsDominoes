<?php
namespace Dominoes;

use function Dominoes\DominoSet\getRandomDominoes;

class DominoSet{

	const POSITION_NONE = 0;

	const POSITION_TOP = 1;

	const POSITION_BOTTOM = 2;

	private $dominoes;

	public function add($position, $domino){
		switch($position){
			case self :: POSITION_TOP:
				$this -> prepend($domino);
				break;
			case self :: POSITION_BOTTOM:
				$this -> append($domino);
				break;
			default:
				throw new Exception("Unknown position to add: <img class='domino' src='img/dominoes/$domino.png'/>");
		}
	}

	public function __construct(array $dominoes = []){
		$this -> dominoes = $dominoes;
	}

	public function prepend(Domino $domino){
		array_unshift($this -> dominoes, $domino);
		return $this;
	}

	public function append(Domino $domino){
		$this -> dominoes[] = $domino;
		return $this;
	}

	public function getRandomDomino(): Domino{
		return $this -> getRandomDominoes(1)[0];
	}

	public function getRandomDominoes($quantity): array{
		$result = [];

		$positions = array_rand($this -> dominoes, $quantity);

		if($quantity == 1){
			$positions = [
				$positions
			];
		}

		foreach($positions as $p){
			$result[] = $this -> dominoes[$p];
			unset($this -> dominoes[$p]);
		}
		return $result;
	}

	public function isEmpty(){
		return empty($this -> dominoes);
	}

	public function top(){
		return $this -> dominoes[0] -> top();
	}

	public function bottom(){
		return $this -> dominoes[count($this -> dominoes) - 1] -> bottom();
	}

	public function remove($position){
		if(isset($this -> dominoes[$position])){
			unset($this -> dominoes[$position]);
		}
	}

	public function all(){
		return $this -> dominoes;
	}

	/**
	 *
	 * @inheritdoc
	 */
	public function __toString(){
		return implode(' ', $this -> dominoes);
	}
}