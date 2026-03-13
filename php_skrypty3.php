<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";

$formMessage = "";
$dbname = "visitors";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    die("Wystąpił problem przy łączeniu z serwerem baz danych: " . $e->getMessage());
}   

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dbCreate"])) {
    

    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $conn->exec($sql);

    $formMessage = "Pomyślnie stworzono bazę danych $dbname (jeżeli nie istniała)";
 
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dbDelete"])) {

    $sql = "DROP DATABASE IF EXISTS $dbname";
    $conn->exec($sql);

    $formMessage = "Pomyślnie usunięto bazę danych $dbname (jeżeli istniała)";
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tableAdd"])) {

    try {
        $conn->exec("USE $dbname");
        $createTableSQL = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $conn->exec($createTableSQL);
        $formMessage = "Pomyślnie stworzono tabelę";

    } catch (PDOException $e) {
        $formMessage = "Nie można stworzyć tabeli bez bazy danych!";
    }

}

    




$_SESSION["sesja"] = "true";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["wyswietl"])) {
    $text = isset($_POST["text"]) ? $_POST["text"] : "";
    $output = $text;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["wyswietlLowercase"])) {
    $text = isset($_POST["text"]) ? $_POST["text"] : "";
    $output = strtolower($text);
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["wyswietlFirstUppercase"])) {
    $text = isset($_POST["text"]) ? $_POST["text"] : "";
    $output = ucwords($text);
}


$conn = null;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php_skrypty3</title>
</head>
<body>
    <!-- 
    do zrobienia:
    1) Tworzenie sesji o nazwie "sesja" i wyswietlanie jej ID
    2) Input z text area:
    - przycisk wyswietlajacy text z textarea 1:1
    - przycisk wyswietlajacy text z textarea tylko ze lowercase
    - przycisk wyswietlajacy text z textarea ktory zmienia 1 znaki kazdego slowa na uppercase
    3) Baza danych PDO:
    - przycisk tworzacy baze danych "visitors"
    - przycisk dodajacy do bazy danych "visitors" tabele "users" z pesel: int, imie: varchar, nazwisko: varchar, plec: varchar, wiek: int, hobby: varchar
    - przycisk usuwajacy baze danych "visitors"
    -->

    <h3>Id sesji</h3>
    <?php
    echo(session_id());
    ?>

    <br><br>

    <h3>textarea</h3>
    <form action="" method="post" name="textForm">
        <textarea name="text" id="text"></textarea>
        <input type="submit" value="Wyświetl" name="wyswietl">
        <input type="submit" value="Wyświetl Lowercase" name="wyswietlLowercase">
        <input type="submit" value="Wyświetl Pierwsze Uppercase" name="wyswietlFirstUppercase">
    </form>

    <div id="output">
        <?php
        echo(isset($output) ? $output : "");
        ?>
    </div>

    <br><br>

    <h3>baza danych pdo</h3>
    <form action="" method="post" name="pdoDatabase">
        <input type="submit" value="Stwórz baze danych" name="dbCreate">
        <input type="submit" value="Dodaj tabele" name="tableAdd">
        <input type="submit" value="Usuń baze danych" name="dbDelete">
    </form>
    <?php
        echo(isset($formMessage) ? $formMessage : "");
    ?>


</body>
</html>
