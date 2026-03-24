<?php
$sessionName = "sesja";
session_start(["name" => $sessionName]);

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
    try {
        $checkSQL = "SHOW DATABASES LIKE 'visitors';";
        $checkResult = $conn->query($checkSQL);
        $dbExists = ($checkResult->rowCount() > 0);
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        $conn->exec($sql);

        if($dbExists) {
            $formMessage = "<span style='color:red;'>Baza danych $dbname już istnieje!</span>";
        } else {
            $formMessage = "<span style='color:green;'>Pomyślnie stworzono bazę danych $dbname</span>";
        }
    } catch(PDOException $e) {
        $formMessage = "<span style='color:red;'>Wystąpił problem z wykonywaniem zapytania:" . $e->getMessage() . "</span>";
    }   
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dbDelete"])) {
    try {
        $checkSQL = "SHOW DATABASES LIKE 'visitors';";
        $checkResult = $conn->query($checkSQL);
        $dbExists = ($checkResult->rowCount() > 0);
        $sql = "DROP DATABASE IF EXISTS $dbname";
        $conn->exec($sql);

        if($dbExists) {
            $formMessage = "<span style='color:green;'>Pomyślnie usunięto bazę danych $dbname</span>";
        } else {
            $formMessage = "<span style='color:red;'>Baza danych $dbname nie istnieje!</span>";
        }
    } catch(PDOException $e) {
        $formMessage = "<span style='color:red;'>Wystąpił problem z wykonywaniem zapytania:" . $e->getMessage() . "</span>";
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tableAdd"])) {
    try {
        $checkSQL = "SHOW DATABASES LIKE 'visitors';";
        $checkResult = $conn->query($checkSQL);
        $dbExists = ($checkResult->rowCount() > 0);

        if(!$dbExists) {
            $formMessage = "<span style='color:red;'>Nie można stworzyć tabeli users bez bazy danych $dbname!</span>";
        } else {
            $conn->exec("USE $dbname");
            $checkSQL = "SHOW TABLES LIKE 'users';";
            $checkResult = $conn->query($checkSQL);
            $tableExists = ($checkResult->rowCount() > 0);

            $createTableSQL = "CREATE TABLE IF NOT EXISTS users (
                pesel INT NOT NULL,
                imie VARCHAR(50) NOT NULL,
                nazwisko VARCHAR(50) NOT NULL,
                plec VARCHAR(50) NOT NULL,
                wiek INT NOT NULL,
                hobby VARCHAR(50) NOT NULL
            );";

            $conn->exec($createTableSQL);

            if($tableExists) {
                $formMessage = "<span style='color:red;'>Tabela users już istnieje!</span>";
            } else {
                $formMessage = "<span style='color:green;'>Pomyślnie stworzono tabelę users</span>";
            }
        }

        
    } catch (PDOException $e) {
        $formMessage = "<span style='color:red;'>Wystąpił problem z wykonywaniem zapytania:" . $e->getMessage() . "</span>";
    }

}


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
    <h1>Ćwiczenie php_skrypty3, waga: 3, czas 2l.</h1>

    <br>

    <h2>Utworzenie sesji</h2>
    <p>Utworzyć sesje, a następnie pokazać na ekranie ID tej sesji</p>
    <?php
        echo('Utworzono sesje o zmiennej: '.$sessionName.'.<br>Identyfikatorem sesji jest: '. session_id());
    ?>
    
    <br><br>

    <h2>Ciągi znaków</h2>
    <div>formatowanie tekstu</div>

    <form action="" method="post" name="textForm">
        <textarea name="text" id="text"></textarea><br>
        <input type="submit" value="Tylko wyświetl" name="wyswietl">
        <input type="submit" value="Wyświetl tylko z małych liter" name="wyswietlLowercase">
        <input type="submit" value="Wyświetl pierwsze litery słów z wielkiej litery" name="wyswietlFirstUppercase">
    </form>


    <?php
    echo(isset($output) ? $output : "");
    ?>
    

    <br><br>

    <h2>Baza danych PDO</h2>
    <div>Utwórz bazę danych o nazwie visitors oraz tabelę user, w której występują pola: pesel(int), imie(varchar), nazwisko(varchar), plec(varchar), wiek(int), hobby(varchar) - lista wyboru</div>
    <form action="" method="post" name="pdoDatabase">
        <input type="submit" value="Utwórz bazę danych" name="dbCreate">
        <input type="submit" value="Utwórz tabelę" name="tableAdd">
        <input type="submit" value="Usuń bazę danych" name="dbDelete">
    </form>
    <br>
    <?php
        echo(isset($formMessage) ? $formMessage : "");
    ?>
</body>
</html>
