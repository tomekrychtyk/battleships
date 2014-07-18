<?php

class Board
{
	public $fields = array();
	public $map = array(
			1 => 'A',
			2 => 'B',
			3 => 'C',
			4 => 'D',
			5 => 'E',
			6 => 'F',
			7 => 'G',
			8 => 'H',
			9 => 'I',
			10 => 'J'
		);

	public function __construct()
	{
		for($i = 1; $i < 11; $i++) {
			$this->fields[$i] = array(1 => '', '', '', '', '', '', '', '', '', '');
		}
	}

	public function addShip($ship, $computerShip = false)
	{
		$position = $ship->getPosition();
		if($this->checkPosition($ship) === true) {
			$x = $position['x'];
			$y = $position['y'];
			$size = $ship->getSize();

			if($ship->getDirection() == 'vertical') {
				for($i = 0; $i < $size; $i++) {
					$this->fields[$x][$y + $i] = $ship;
				}
			} else if($ship->getDirection() == 'horizontal') {
				for($i = 0; $i < $size; $i++) {
					$this->fields[$x + $i][$y] = $ship;
				}
			}
		} else if($this->checkPosition($ship) == 'Out of boundries') {
			if(!$computerShip) {
				throw new Exception("cannot add a {$ship->getName()} ship in: " . $this->map[$position['x']] . ' - ' . $position['y'] . '. The ships cannot be placed outside the board.');
			} else {
				return false;
			}
		} else if($this->checkPosition($ship) == 'Ships overlap') {
			if(!$computerShip) {
				throw new Exception("Cannot add a {$ship->getName()} ship in: " . $this->map[$position['x']] . ' - ' . $position['y'] . '. The ships cannot overlap.');
			} else {
				return false;
			}
		} else if($this->checkPosition($ship) == 'Ships touching') {
			if(!$computerShip) {
				throw new Exception("Cannot add a {$ship->getName()} ship in: " . $this->map[$position['x']] . ' - ' . $position['y'] . '. The ships cannot touch each other.');
			} else {
				return false;
			}
		}
		
		return true;
	}

	public function checkPosition($ship)
	{
		$size = $ship->getSize();
		$position = $ship->getPosition();
		$x = $position['x'];
		$y = $position['y'];
		
		if($ship->getDirection() == 'vertical') {
			for($i = 0; $i < $size; $i++) {
				if(!isset($this->fields[$x][$y + $i])) {
					return 'Out of boundries';
				} else if(is_object($this->fields[$x][$y + $i])) {
					return 'Ships overlap';
				} else if(@is_object($this->fields[$x - 1][$y + $i]) || @is_object($this->fields[$x + 1][$y + $i]) || @is_object($this->fields[$x][$y + $i + 1]) || @is_object($this->fields[$x][$y + $i - 1])) {
					return 'Ships touching';
				}
			}
		} else if($ship->getDirection() == 'horizontal') {
			for($i = 0; $i < $size; $i++) {
				if(!isset($this->fields[$x + $i][$y])) {
					return 'Out of boundries';
				} else if(is_object($this->fields[$x + $i][$y])) {
					return 'Ships overlap';
				} else if(@is_object($this->fields[$x - 1 + $i][$y]) || @is_object($this->fields[$x + 1 + $i][$y]) || @is_object($this->fields[$x + $i][$y + 1]) || @is_object($this->fields[$x + $i][$y - 1])) {
					return 'Ships touching';
				}
			}
		}

		return true;
	}

	public static function render()
	{
		$fields = array('', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
		foreach($fields as $field) {
			echo '<div class="field">' . $field . '</div>';
		}

		for($i = 1; $i < 11; $i++) {
			echo '<div class="field">' . $i . '</div>';
			for($j = 1; $j < 11; $j++) {
				echo '<div class="field" id="field-'.$i . '-' . $j . '" data-x="'.$i.'" data-y="'.$j.'"></div>';
			}
		}
	}

	public function printBoard($showShips = true)
	{
		$out = '';
		for($i = 1; $i < 11; $i++) {
			for($j = 1; $j < 11; $j++) {
				$out .= '<div class="field field-'.$i.'-'.$j.'" data-x="'.$i.'" data-y="'.$j.'">';
				if($showShips) {
					$out .= $this->fields[$i][$j];
				}
				$out .= '</div>';
			}
		}

		return $out;
	}
}