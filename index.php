<?php require 'bootstrap.php'; ?>
<!doctype html>
<html>
    <head>
        <title>Battleships</title>
        <meta charset="utf-8" />
        
        <link href="css/style.css" type="text/css" rel="stylesheet" />
        <script src="js/jquery.js"></script>
        <script src="js/battleships.js"></script>
    </head>
    <body>
        <h1>Battleships</h1>

        <h2>You:</h2>
        <div class="board" id="human-board">
            <?php //Board::render(); ?>
            <div class="board-inner">

            </div>
            <div class="clear"></div>

            <div class="legend">
                <div class="game-result"></div>
            </div>
        </div>

        <h2>Computer:</h2>
        <div class="board" id="computer-board">
            <?php //Board::render(); ?>
            <div class="board-inner">

            </div>
            <div class="clear"></div>
        </div>
    </body>
</html>