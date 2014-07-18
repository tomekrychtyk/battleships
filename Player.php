<?php

class Player
{
	public $board;
	protected $filedsLeft = 17;

	public function __construct()
	{
		$this->board = new Board();
	}

	public function getName()
	{
		return $this->name;
	}

	public function shoot($player, $x, $y)
	{
		$result = $player->getShot($x, $y);
		return $result;
	}
	public function getShot($x, $y)
	{
		if(is_object($this->board->fields[$x][$y])) {
			$this->filedsLeft--;
			return 'hit';
		} else {
			return 'missed';
		}
	}

	public function isDefeated()
	{
		if($this->filedsLeft == 0) {
			return true;
		}
	}
}