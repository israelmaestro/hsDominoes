<?php
namespace Dominoes;

class Domino{
	protected $top;
	protected $bottom;

	public function __construct($top, $bottom){
		$this -> top = $top;
		$this -> bottom = $bottom;
	}

	public function matches($top, $bottom){
		if($this -> top() === $top){
			return [DominoSet :: POSITION_TOP, true];
		}else if($this -> bottom() === $top){
			return [DominoSet :: POSITION_TOP, false];
		}else if($this -> bottom() === $bottom){
			return [DominoSet :: POSITION_BOTTOM, true];
		}else if($this -> top() === $bottom){
			return [DominoSet :: POSITION_BOTTOM, false];
		}else{
			return [DominoSet :: POSITION_NONE, false];
		}
	}

	public function top() {
		return $this -> top;
	}

	public function bottom() {
		return $this -> bottom;
	}

	public function turn(){
		$temp = $this -> top;
		$this -> top = $this -> bottom;
		$this -> bottom = $temp;
		return $this;
	}


	public function __toString(){
		return "{$this->top}_{$this->bottom}";
	}
}
