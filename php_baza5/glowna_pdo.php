<?php
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baza5";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch(PDOException $e) {
    die("Wystąpił problem z połączeniem do serwera baz danych: ". $e->getMessage());
}


function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

$errors = [];
$formMessage = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mainFormSubmit"])) {
    $imie = isset($_POST["imie"]) ? sanitizeInput($_POST["imie"]) : "";
    $nazwisko = isset($_POST["nazwisko"]) ? sanitizeInput($_POST["nazwisko"]) : "";
    $wiek = isset($_POST["wiek"]) ? sanitizeInput($_POST["wiek"]) : "";
    $plec = isset($_POST["plec"]) ? sanitizeInput($_POST["plec"]) : "";
    $miasto = isset($_POST["miasto"]) ? sanitizeInput($_POST["miasto"]) : "";
    $hobby = isset($_POST["hobby"]) ? implode(",", $_POST["hobby"]) : "";
    $wyksztalcenie = isset($_POST["wyksztalcenie"]) ? sanitizeInput($_POST["wyksztalcenie"]) : "";

    if(empty($imie)) $errors["imieError"] = "Pole nie może być puste!";
    if(empty($nazwisko)) $errors["nazwiskoError"] = "Pole nie może być puste!";
    if(empty($wiek)) $errors["wiekError"] = "Pole nie może być puste!";
    if(empty($plec)) $errors["plecError"] = "Pole musi być wybrane!";
    if(empty($miasto)) $errors["miastoError"] = "Pole nie może być puste!";
    if(!isset($_POST["hobby"]) || empty($_POST["hobby"])) $errors["hobbyError"] = "Conajmniej jedno pole musi być wybrane!!";
    if(empty($wyksztalcenie) || $wyksztalcenie == "wybierz") $errors["wyksztalcenieError"] = "Pole musi być wybrane!";


    if(!isset($errors["imieError"]) && !preg_match('/^[A-ZĘÓĄŚŁŻŹĆ][a-zęóąśłżźć]*$/', $imie))
        $errors["imieError"] = "Pole musi się składać tylko z liter(pierwsza duża reszta małe)!";
    if(!isset($errors["nazwiskoError"]) && !preg_match('/^[A-ZĘÓĄŚŁŻŹĆ][a-zęóąśłżźć]*$/', $nazwisko))
        $errors["nazwiskoError"] = "Pole musi się składać tylko z liter(pierwsza duża reszta małe)!";
    if(!isset($errors["wiekError"]) && !preg_match('/^\d{1,3}$/',$wiek))
        $errors["wiekError"] = "Pole musi się składać tylko z cyfr(max 3)!";
    if(!isset($errors["miastoError"]) && !preg_match('/^[A-ZĘÓĄŚŁŻŹĆ][a-zęóąśłżźć]*$/', $miasto))
        $errors["miastoError"] = "Pole musi się składać tylko z liter(pierwsza duża reszta małe)!";

    if(empty($errors)) {
        try {
            $wiek_int = (int)$wiek;
            $sql = "INSERT INTO osoba5 (imie, nazwisko, wiek, plec, miasto, hobby, wyksztalcenie) VALUES (?, ?, ?, ?, ?, ?, ?);";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$imie, $nazwisko, $wiek_int, $plec, $miasto, $hobby, $wyksztalcenie]);


            $_SESSION["formMessage"] = "<span style='color:green'>Pomyślnie dodano rekord</span>";
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit();
        } catch(PDOException $e) {
            die("Wystąpił problem z wykonaniem zapytania: " . $e->getMessage());
        }
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usunFormSubmit"])) {
    $imieUsun = isset($_POST["imieUsun"]) ? sanitizeInput($_POST["imieUsun"]) : "";
    $nazwiskoUsun = isset($_POST["nazwiskoUsun"]) ? sanitizeInput($_POST["nazwiskoUsun"]) : "";
    $wiekUsun = isset($_POST["wiekUsun"]) ? sanitizeInput($_POST["wiekUsun"]) : "";
    $plecUsun = isset($_POST["plecUsun"]) ? sanitizeInput($_POST["plecUsun"]) : "";
    $miastoUsun = isset($_POST["miastoUsun"]) ? sanitizeInput($_POST["miastoUsun"]) : "";
    $hobbyUsun = isset($_POST["hobbyUsun"]) ? sanitizeInput($_POST["hobbyUsun"]) : "";
    $wyksztalcenieUsun = isset($_POST["wyksztalcenieUsun"]) ? sanitizeInput($_POST["wyksztalcenieUsun"]) : "";

    try {
        $wiekUsun_int = (int)$wiekUsun;
        $sql = "DELETE FROM osoba5 WHERE imie = ? AND nazwisko = ? AND wiek = ? AND plec = ? AND  miasto  = ? AND hobby = ? AND wyksztalcenie = ? LIMIT 1;";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$imieUsun, $nazwiskoUsun, $wiekUsun_int, $plecUsun, $miastoUsun, $hobbyUsun, $wyksztalcenieUsun]);

        if($stmt->rowCount() == 1) {
            $_SESSION["formMessage"] = "<span style='color:green'>Pomyślnie usunięto rekord</span>";
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit();
        } else {
            $_SESSION["formMessage"] = "<span style='color:red'>Nie znaleziono </span>";
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit();
        }

        

    } catch(PDOException $e) {
        die("Wystąpił problem z wykonaniem zapytania! " . $e->getMessage());
    }
       
}



try {
    $sql = "SELECT * FROM osoba5";

    $result = $conn->query($sql);

} catch (PDOException $e) {
    die("Wystąpił problem przy wykonywaniu zapytania: " . $e->getMessage());
}


if(isset($_SESSION["formMessage"])) {
    $formMessage = $_SESSION["formMessage"];
    unset($_SESSION["formMessage"]);
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logoutFormSubmit"])) {
    unset($_SESSION["login"]);
    header("Location: index.php");
    exit();
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
            <a href="glowna.php">glowna</a>
        </nav>

        <section>
            <form action="" method="post" name="mainForm" id="mainForm">
                <label for="imie">Imię: </label>
                <input type="text" name="imie" id="imie" value="<?php echo(isset($_POST['imie']) ? $_POST['imie'] : ''); ?>">
                <br>
                <span class="errors"><?php echo(isset($errors["imieError"]) ? $errors["imieError"] : ""); ?></span>
                <br>

                <label for="nazwisko">Nazwisko: </label>
                <input type="text" name="nazwisko" id="nazwisko" value="<?php echo(isset($_POST['nazwisko']) ? $_POST['nazwisko'] : ''); ?>">
                <br>
                <span class="errors"><?php echo(isset($errors["nazwiskoError"]) ? $errors["nazwiskoError"] : ""); ?></span>
                <br>

                <label for="wiek">Wiek: </label>
                <input type="text" name="wiek" id="wiek" value="<?php echo(isset($_POST['wiek']) ? $_POST['wiek'] : ''); ?>">
                <br>
                <span class="errors"><?php echo(isset($errors["wiekError"]) ? $errors["wiekError"] : ""); ?></span>
                <br>

                <label for="plec">Płeć: </label>
                <input type="radio" name="plec" id="male" value="male" <?php echo(isset($_POST["plec"]) && $_POST["plec"] == "male" ? "checked" : ""); ?>>Mężczyzna
                <input type="radio" name="plec" id="female" value="female" <?php echo(isset($_POST["plec"]) && $_POST["plec"] == "female" ? "checked" : ""); ?>>Kobieta
                <br>
                <span class="errors"><?php echo(isset($errors["plecError"]) ? $errors["plecError"] : ""); ?></span>
                <br>
                
                <label for="miasto">Miasto: </label>
                <input type="text" name="miasto" id="miasto" value="<?php echo(isset($_POST['miasto']) ? $_POST['miasto'] : ''); ?>">
                <br>
                <span class="errors"><?php echo(isset($errors["miastoError"]) ? $errors["miastoError"] : ""); ?></span>
                <br>

                <label for="hobby[]">Hobby:</label>
                <br>
                <input type="checkbox" name="hobby[]" id="jazdaRowerem" value="jazdaRowerem" <?php echo(isset($_POST["hobby"]) && in_array("jazdaRowerem", $_POST["hobby"]) ? "checked" : ""); ?>>jazdaRowerem
                <br>
                <input type="checkbox" name="hobby[]" id="czytanieKsiazek" value="czytanieKsiazek" <?php echo(isset($_POST["hobby"]) && in_array("czytanieKsiazek", $_POST["hobby"]) ? "checked" : ""); ?>>czytanieKsiazek
                <br>
                <input type="checkbox" name="hobby[]" id="granieWSapera" value="granieWSapera" <?php echo(isset($_POST["hobby"]) && in_array("granieWSapera", $_POST["hobby"]) ? "checked" : ""); ?>>granieWSapera
                <br>
                <span class="errors"><?php echo(isset($errors["hobbyError"]) ? $errors["hobbyError"] : ""); ?></span>
                <br>

                <label for="wyksztalcenie">Wykształcenie: </label>
                <select name="wyksztalcenie" id="wyksztalcenie">
                    <option value="wybierz" <?php echo(isset($_POST["wyksztalcenie"]) && $_POST["wyksztalcenie"] == "wybierz" ? "selected" : ""); ?> >Wybierz</option>
                    <option value="podstawowe" <?php echo(isset($_POST["wyksztalcenie"]) && $_POST["wyksztalcenie"] == "podstawowe" ? "selected" : ""); ?> >Podstawowe</option>
                    <option value="srednie" <?php echo(isset($_POST["wyksztalcenie"]) && $_POST["wyksztalcenie"] == "srednie" ? "selected" : ""); ?> >Średnie</option>
                    <option value="wysokie" <?php echo(isset($_POST["wyksztalcenie"]) && $_POST["wyksztalcenie"] == "wysokie" ? "selected" : ""); ?> >Wysokie</option>
                </select>
                <br>
                <span class="errors"><?php echo(isset($errors["wyksztalcenieError"]) ? $errors["wyksztalcenieError"] : ""); ?></span>
                <br><br>

                <input type="submit" value="Wyślij formularz" name="mainFormSubmit">
                <input type="button" value="Wyczyść formularz" onclick="return resetForm();">
                <span id="formMessage"><?php echo(isset($formMessage) ? $formMessage : ""); ?></span>
                
            </form>

            <div id="dbOutput">
                <table>
                    <tr>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Wiek</th>
                        <th>Płeć</th>
                        <th>Miasto</th>
                        <th>Hobby</th>
                        <th>Wykształcenie</th>
                        <th>Usuń</th>
                    </tr>
                    <?php
                    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo("<tr>");
                        echo("<td>" . htmlspecialchars($row['imie']) . "</td>");
                        echo("<td>" . htmlspecialchars($row['nazwisko']) . "</td>");
                        echo("<td>" . htmlspecialchars($row['wiek']) . "</td>");
                        echo("<td>" . htmlspecialchars($row['plec']) . "</td>");
                        echo("<td>" . htmlspecialchars($row['miasto']) . "</td>");
                        echo("<td>" . htmlspecialchars($row['hobby']) . "</td>");
                        echo("<td>" . htmlspecialchars($row['wyksztalcenie']) . "</td>");
                        echo("<td><form name='usunForm' id='usunForm' method='post'>");
                        echo("<input type='hidden' value='" . htmlspecialchars($row['imie']) . "' name='imieUsun'>");
                        echo("<input type='hidden' value='" . htmlspecialchars($row['nazwisko']) . "' name='nazwiskoUsun'>");
                        echo("<input type='hidden' value='" . htmlspecialchars($row['wiek']) . "' name='wiekUsun'>");
                        echo("<input type='hidden' value='" . htmlspecialchars($row['plec']) . "' name='plecUsun'>");
                        echo("<input type='hidden' value='" . htmlspecialchars($row['miasto']) . "' name='miastoUsun'>");
                        echo("<input type='hidden' value='" . htmlspecialchars($row['hobby']) . "' name='hobbyUsun'>");
                        echo("<input type='hidden' value='" . htmlspecialchars($row['wyksztalcenie']) . "' name='wyksztalcenieUsun'>");
                        echo("<input type='submit' value='Usuń' name='usunFormSubmit' onclick='return confirm(\"Czy jesteś pewny?\")'>");
                        echo("</form></td>");
                        echo("</tr>");
                    }
                    $conn = null;
                    ?>
                </table>
            </div>
            
        </section>

        <aside></aside>

        <footer>
            <form action="" method="post" name="logoutForm" id="logoutForm">
                <input type="submit" value="Wyloguj" name="logoutFormSubmit">
            </form>
        </footer>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            alert("Przypominamyz o konieczności wypełnienia formularza!");
        });

        function getId(id) {
            return document.getElementById(id);
        };

        function firstLetterUp() {
            this.value = this.value.replace(/\P{L}/gu, "");
            this.value = this.value.slice(0,1).toUpperCase() + this.value.slice(1).toLowerCase();
        };

        getId("imie").addEventListener("input", firstLetterUp);
        getId("nazwisko").addEventListener("input", firstLetterUp);
        getId("miasto").addEventListener("input", firstLetterUp);

        getId("wiek").addEventListener("input", function() {
            this.value = this.value.replace(/\D/g, "");
            this.value = this.value.slice(0,3);
        });

        function disableForm(state) {
            getId('male').disabled = state;
            getId('female').disabled = state;
            getId('wiek').disabled = state;
            getId('miasto').disabled = state;
            getId('wyksztalcenie').disabled = state;
            getId('jazdaRowerem').disabled = state;
            getId('czytanieKsiazek').disabled = state;
            getId('granieWSapera').disabled = state;
        }

        function checkFormState() {
            if(getId("imie").value == "" || getId("nazwisko").value == "") {
                disableForm(true);
                getId("formMessage").innerHTML = "<span style='color: #fc9b25;'>Proszę uzupełnić pola Imię i Nazwisko aby odblokować resztę formularza!</span>";
            } else {
                disableForm(false);
                getId("formMessage").innerHTML = "";
            }
        }

        checkFormState();
        setInterval(checkFormState, 500);


        function resetForm() {
            getId("imie").value = "";
            getId("nazwisko").value = "";
            getId("wiek").value = "";
            getId("miasto").value = "";
            getId('male').checked = false;
            getId('female').checked = false;
            getId('jazdaRowerem').checked = false;
            getId('czytanieKsiazek').checked = false;
            getId('granieWSapera').checked = false;
            getId("wyksztalcenie").value = "wybierz";
            let errorSpans = document.querySelectorAll('.errors');
            errorSpans.forEach(span => span.innerHTML = '');
            getId("formMessage").innerHTML = '';
            checkFormState();
            return false;
        }
    </script>
</body>
</html>
