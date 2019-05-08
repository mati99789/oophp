<?php


// Start a named session
session_name("maub");
session_start();


// Guess my number
require __DIR__ . "/config.php";
require __DIR__ . "/autoload.php";


//Settings session
$tries = $_SESSION["tries"] ?? null;
$number = $_SESSION["number"] ?? null;
$guess = $_POST["guess"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;
$doInit = $_POST["doInit"] ?? null;


$games = null;

// Init the game
if ($doInit || $number === null) {
    session_destroy();
    session_start();
    $games = new Guess();
    header("Refresh:0");
    $tries = $_SESSION["tries"] = $games->tries();
    $number = $_SESSION["number"] = $games->number();
} elseif ($doGuess) {
    // Do guess
    $games = new Guess($number, $tries);
    $result = $games->makeGuess($guess);
    $tries = $_SESSION["tries"] = $games->tries();
}


// Render the page
require __DIR__ . "/view/guess_my_number.php";

echo "<pre>";
var_dump($_POST);
echo "<br>";
var_dump($_SESSION);
