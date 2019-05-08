<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<h1>Hey guess my number</h1>
<p>Guess a number between 1 and 100, you have <b><?= $tries ?></b> left.</p>

<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries -1 ?>">
    <input type="submit" name="doGuess" value="Make guess"
    <?php if ($tries <= 0) {
        echo 'disabled';
    } elseif ($guess == $number) {
        echo 'disabled';
    }
    ?>>
    <input type="submit" name="doInit" value="Start from beginning">
    <input type="submit" name="doCheat" value="Cheat">
</form>



<?php if ($result) : ?>
    <p>Your guess is : <?= $guess ?> is <?php echo $result ?>. </p>
<?php endif; ?>

<?php if ($doCheat) :  ?>
    <p>Cheat: Current number is: <?= $number ?>. </p>
<?php endif; ?>

<?php if ($tries <= 0) : ?>
        <p>Game Over! Start again ! </p>
<?php endif; ?>
