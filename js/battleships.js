$(function() {
	$.ajax({
		url: 'shoot.php',
		data: {action: 'new_game'},
		dataType: 'json',
		success: function(data) {
			$('#human-board .board-inner').html(data.human_board);
			$('#computer-board .board-inner').html(data.computer_board);
		}
	})
});

$(function() {
	var gameStarted = true,
		gameEnded = false,
		x,
		y;

	$('#computer-board').on('click', '.field', function() {
		var x,
			y;

		x = $(this).data('x');
		y = $(this).data('y');

		$.ajax({
			url: 'shoot.php',
			dataType: 'json',
			data: {x: x, y: y, action: 'shoot'},
			success: function(data) {
				if(data == 'human_lose') {
					$('.game-result').html('You lose!');
				} else if(data == 'human_win') {
					$('.game-result').html('You win!');
				} else {
					if(data.human_result == 'missed') {
						$('#computer-board .field-' + x + '-' + y).html('<strong>x</strong>');
					} else {
						$('#computer-board .field-' + x + '-' + y).html('<strong style="color:#ca0000;">o</strong>');
					}

					if(data.computer_result == 'missed') {
						$('#human-board .field-' + data.computer_x + '-' + data.computer_y).html('<strong>x</strong>');
					} else {
						$('#human-board .field-' + data.computer_x + '-' + data.computer_y).html('<strong style="color:#ca0000;">o</strong>');
					}
				}
			}
		});
	});
});