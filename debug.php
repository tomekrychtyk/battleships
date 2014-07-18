<link href="css/style.css" type="text/css" rel="stylesheet" />

<?php

require 'autoload.php';

$human = unserialize(file_get_contents('human.txt'));


?>
<div class="board">
<?php echo $human->board; ?>
</div>