<?php

class Computer extends Player
{
	private $innerMap = array();
	private $currentHits = array();
	private $preferredMoves = array();

	public function __construct()
	{
		parent::__construct();

		for($i = 1; $i < 11; $i++) {
			$this->innerMap[$i] = array(1 => '', '', '', '', '', '', '', '', '', '');
		}
	}

	public function getCoords()
	{
			if(!empty($this->preferredMoves)) {
				$coords = array_pop($this->preferredMoves);
				$x = $coords['x'];
				$y = $coords['y'];
			} else {
				$x = rand(1, 10);
				$y = rand(1, 10);

				while(!empty($this->innerMap[$x][$y])) {
					$x = rand(1, 10);
					$y = rand(1, 10);
				}
			}

			return array(
				'x' => $x,
				'y' => $y,
			);
	}

	public function makeMove($human)
	{
			$coords = $this->getCoords();

			$result = $this->shoot($human, $coords['x'], $coords['y']);
			$this->saveMove($coords['x'], $coords['y'], $result);

			return array(
				'result' => $result,
				'x' => $coords['x'],
				'y' => $coords['y'],
			);
	}

	public function saveMove($x, $y, $result)
	{
		if($result == 'hit') {
			$this->currentHits[] = array($x, $y);

			if(isset($this->innerMap[$x][$y + 1]) && empty($this->innerMap[$x][$y + 1])) {
				$this->preferredMoves[] = array('x' => $x, 'y' => $y + 1);
			}

			if(isset($this->innerMap[$x][$y - 1]) && empty($this->innerMap[$x][$y - 1])) {
				$this->preferredMoves[] = array('x' => $x, 'y' => $y - 1);
			}

			if(isset($this->innerMap[$x + 1][$y]) && empty($this->innerMap[$x + 1][$y])) {
				$this->preferredMoves[] = array('x' => $x + 1, 'y' => $y);
			}

			if(isset($this->innerMap[$x - 1][$y]) && empty($this->innerMap[$x - 1][$y])) {
				$this->preferredMoves[] = array('x' => $x - 1, 'y' => $y);
			}

			$this->innerMap[$x][$y] = 'H';
		} else {
			$this->innerMap[$x][$y] = 'M';
		}
	}
}