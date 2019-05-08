<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    // init the session for the gamestart;
    $games = new Mat\Guess\Guess();
    $tries = $_SESSION["tries"] = $games->tries();
    $number = $_SESSION["number"] = $games->number();

    return $app->response->redirect("guess/play");
});



/**
 * PLay the game - show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    // //Settings session
    // $guess = $_POST["guess"] ?? null;
    // $doGuess = $_POST["doGuess"] ?? null;
    // $doCheat = $_POST["doCheat"] ?? null;
    // $doInit = $_POST["doInit"] ?? null;

    $tries = $_SESSION["tries"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $result = $_SESSION["result"] ?? null;
    $guess = $_SESSION["guess"] ?? null;
    $doCheat = $_SESSION["doCheat"] ?? null;



    $_SESSION["result"] = null;

    // // Init the game
    // if ($doInit || $number === null) {
    //     session_destroy();
    //     session_start();
    //     $games = new Guess();
    //     header("Refresh:0");
    //     $tries = $_SESSION["tries"] = $games->tries();
    //     $number = $_SESSION["number"] = $games->number();
    // } elseif ($doGuess) {
    //     // Do guess
    //     $games = new Guess($number, $tries);
    //     $result = $games->makeGuess($guess);
    //     $tries = $_SESSION["tries"] = $games->tries();
    // }

    $data = [
        "guess" => $guess ?? null,
        "number" => $number ?? null,
        "tries" => $tries,
        "result" => $result,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
    ];

    $app->page->add("guess/play", $data);
    $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * PLay the game - make a guess
 */
$app->router->post("guess/play", function () use ($app) {
    $title = "PLay the game";

    //Settings session
    $guess = $_POST["guess"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;
    $doInit = $_POST["doInit"] ?? null;

    $tries = $_SESSION["tries"] ?? null;
    $number = $_SESSION["number"] ?? null;

    $result= null;

    // Init the game
    if ($doInit || $number === null) {
        session_destroy();
        session_start();
        $games = new Mat\Guess\Guess();
        header("Refresh:0");
        $tries = $_SESSION["tries"] = $games->tries();
        $number = $_SESSION["number"] = $games->number();
    } elseif ($doGuess) {
        // Do guess
        $games = new Mat\Guess\Guess($number, $tries);
        $result = $games->makeGuess($guess);
        $tries = $_SESSION["tries"] = $games->tries();
        $_SESSION["result"] = $result;
        $_SESSION["guess"] = $guess;
    }

    if ($doCheat) {
        $_SESSION["doCheat"] = $doCheat;
    }

    $data = [
        "guess" => $guess,
        "number" => $number,
        "tries" => $tries,
        "result" => $result,
        "doGuess" => $doGuess,
        "doCheat" => $doCheat,
    ];

    return $app->response->redirect("guess/play");
});
