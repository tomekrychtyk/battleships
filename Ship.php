<?php

class Ship
{
	private $sank = false;
	private $size;
	private $name;
	private $direction;
	private $position = array();

	public function __construct($name, $size, $dir, $x, $y)
	{
		$this->name = $name;
		$this->size = $size;
		$this->direction = $dir;
		$this->position['x'] = $x;
		$this->position['y'] = $y;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function getDirection()
	{
		return $this->direction;
	}

	public function getPosition()
	{
		return $this->position;
	}

	public function getName()
	{
		return $this->name;
	}

	public function __toString()
	{
		$name = $this->name;
		return $name[0];
	}
}