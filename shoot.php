<?php

require 'db.php';
require 'autoload.php';

if($_GET['action'] == 'new_game') {
	$computer = new Computer('Computer');
	$human = new Human('Tomek');

	/* Generate the computer board */
	$shipsToAdd = array(
		'Aircraft carrier' => 5,
		'Battleship' => 4,
		'Submarine' => 3,
		'Destroyer' => 3,
		'Patrol boat' => 2
	);

	$humanShipsToAdd = $shipsToAdd;

	$directions = array('vertical', 'horizontal');

	while(!empty($shipsToAdd)) {
		foreach($shipsToAdd as $ship => $size) {
			$randX = rand(1, 10);
			$randY = rand(1, 10);
			$dir = rand(0, 1);

			if($computer->board->addShip(new Ship($ship, $size, $directions[$dir], $randX, $randY), true)) {
				unset($shipsToAdd[$ship]);
			}
		}
	}

	while(!empty($humanShipsToAdd)) {
		foreach($humanShipsToAdd as $ship => $size) {
			$randX = rand(1, 10);
			$randY = rand(1, 10);
			$dir = rand(0, 1);

			if($human->board->addShip(new Ship($ship, $size, $directions[$dir], $randX, $randY), true)) {
				unset($humanShipsToAdd[$ship]);
			}
		}
	}

	$result = array(
		'human_board' => $human->board->printBoard(),
		'computer_board' => $computer->board->printBoard(false)
	);

	$s_human = serialize($human);
	$s_computer = serialize($computer);

	file_put_contents('human.txt', $s_human);
	file_put_contents('computer.txt', $s_computer);

	echo json_encode($result);

	exit();
}

if($_GET['action'] == 'shoot') {
	$computer = unserialize(file_get_contents('computer.txt'));
	$human = unserialize(file_get_contents('human.txt'));

	$x = $_GET['x'];
	$y = $_GET['y'];

	if($human->isDefeated()) {
		echo json_encode('human_lose');
		exit();
	}

	if($computer->isDefeated()) {
		echo json_encode('human_win');
		exit();
	}

	$humanResult = $human->shoot($computer, $x, $y);
	$computerResult = $computer->makeMove($human);

	$s_human = serialize($human);
	$s_computer = serialize($computer);

	file_put_contents('human.txt', $s_human);
	file_put_contents('computer.txt', $s_computer);

	echo json_encode(array(
			'human_result' => $humanResult,
			'computer_result' => $computerResult['result'],
			'computer_x' => $computerResult['x'],
			'computer_y' => $computerResult['y'],
		)
	);

	exit();
}