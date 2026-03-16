<?php
session_start();

if(isset($_SESSION["login"])) {
    header("Location: glowna.php");
    exit();
}

$formMessage = "";
$errors = [];

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logowanieFormSubmit"])) {
    $login = isset($_POST["login"]) ? $_POST["login"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if(empty($login)) $errors["loginError"] = "Pole nie może być puste!";
    if(empty($password)) $errors["passwordError"] = "Pole nie może być puste!";

    if(empty($errors)) {
        if($login !== "user1" || $password !== "pass1") {
            $formMessage = "<span style='color: red;'>Niepoprawne dane logowania!</style>";
        } else {
            $_SESSION["login"] = true;
            header("Location: glowna.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php_baza5</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div id="main">

        <header>
            <h1>DB - Spis ludności</h1>
        </header>

        <nav>

        </nav>

        <section>
            <form action="" method="post" name="logowanieForm" id="logowanieForm">
                <label for="login">Login: </label>
                <input type="text" name="login">
                <br>
                <span class="errors"><?php echo(isset($errors["loginError"]) ? $errors["loginError"] : ""); ?></span>
                <br>
                <label for="password">Hasło: </label>
                <input type="text" name="password">
                <br>
                <span class="errors"><?php echo(isset($errors["passwordError"]) ? $errors["passwordError"] : ""); ?></span>
                <br>
                <input type="submit" value="Zaloguj" name="logowanieFormSubmit">
                <br>
                <?php echo($formMessage); ?>
                <span id="formMessage"></span>
                <br>
            </form>           
        </section>

        <aside></aside>

        <footer></footer>
    </div>

    
</body>
</html>