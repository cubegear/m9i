<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$db = "kwintesariusz";

$conn = new mysqli($servername, $username, $password, $db);

if($conn->connect_error) {
    die("Problem połączenia z serwerem baz danych" . $conn->connect_error);
}

function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

$errors = [];
$formMessage = "";
/*
if(isset($_GET["delete"])) {
    $imie = isset($_GET["imie"]) ? urldecode($_GET["imie"]) : "";
    $wiek = isset($_GET["wiek"]) ? urldecode($_GET["wiek"]) : "";
    $plec = isset($_GET["plec"]) ? urldecode($_GET["plec"]) : "";
    $telefon = isset($_GET["telefon"]) ? urldecode($_GET["telefon"]) : "";
    $email = isset($_GET["email"]) ? urldecode($_GET["email"]) : "";
    $wyksztalcenie = isset($_GET["wyksztalcenie"]) ? urldecode($_GET["wyksztalcenie"]) : "";
    $dodatkowe = isset($_GET["dodatkowe"]) ? urldecode($_GET["dodatkowe"]) : "";
    $kwalifikacje = isset($_GET["kwalifikacje"]) ? urldecode($_GET["kwalifikacje"]) : "";

    
    $imie =  sanitizeInput($imie);
    $wiek =  sanitizeInput($wiek);
    $plec =  sanitizeInput($plec);
    $telefon = sanitizeInput($telefon);
    $email = sanitizeInput($email);
    $wyksztalcenie = sanitizeInput($wyksztalcenie);
    $dodatkowe = sanitizeInput($dodatkowe);
    $kwalifikacje = sanitizeInput($kwalifikacje);
    


    $query = "DELETE FROM osoba WHERE 
            imie = ? AND wiek = ? AND plec = ? AND 
            telefon = ? AND email = ? AND wyksztalcenie = ? AND 
            dodatkowe = ? AND kwalifikacje = ? LIMIT 1";


    $stmt = $conn->prepare($query);

    $wiekInt = (int)$wiek;

    $stmt->bind_param("sissssss", $imie, $wiekInt, $plec, $telefon, $email, $wyksztalcenie, $dodatkowe, $kwalifikacje);
    
    if($stmt->execute()) {
        $_SESSION['formMessage'] = "<span style='color: green;'>Rekord został usunięty</span>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION["formMessage"] = "<span style='color: red;'>Wystąpił błąd podczas usuwania rekordu</span>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $stmt->close();      
}
*/


//
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["usun"])) {
    $imieDelete = isset($_POST["imieDelete"]) ? sanitizeInput($_POST["imieDelete"]) : "";
    $wiekDelete = isset($_POST["wiekDelete"]) ? sanitizeInput($_POST["wiekDelete"]) : "";
    $plecDelete = isset($_POST["plecDelete"]) ? sanitizeInput($_POST["plecDelete"]) : "";
    $telefonDelete = isset($_POST["telefonDelete"]) ? sanitizeInput($_POST["telefonDelete"]) : "";
    $emailDelete = isset($_POST["emailDelete"]) ? sanitizeInput($_POST["emailDelete"]) : "";
    $wyksztalcenieDelete = isset($_POST["wyksztalcenieDelete"]) ? sanitizeInput($_POST["wyksztalcenieDelete"]) : "";
    $dodatkoweDelete = isset($_POST["dodatkoweDelete"]) ? sanitizeInput($_POST["dodatkoweDelete"]) : "";
    $kwalifikacjeDelete = isset($_POST["kwalifikacjeDelete"]) ? sanitizeInput($_POST["kwalifikacjeDelete"]) : "";


    $query = "DELETE FROM osoba WHERE 
            imie = ? AND wiek = ? AND plec = ? AND 
            telefon = ? AND email = ? AND wyksztalcenie = ? AND 
            dodatkowe = ? AND kwalifikacje = ? LIMIT 1";


    $stmt = $conn->prepare($query);

    $wiekIntDelete = (int)$wiekDelete;

    $stmt->bind_param("sissssss", $imieDelete, $wiekIntDelete, $plecDelete, $telefonDelete, $emailDelete, $wyksztalcenieDelete, $dodatkoweDelete, $kwalifikacjeDelete);
    
    if($stmt->execute()) {
        $_SESSION['formMessage'] = "<span style='color: green;'>Rekord został usunięty</span>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION["formMessage"] = "<span style='color: red;'>Wystąpił błąd podczas usuwania rekordu</span>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $stmt->close();
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["wyslij"])) {
    $imie = isset($_POST["imie"]) ? sanitizeInput($_POST["imie"]) : "";
    $wiek = isset($_POST["wiek"]) ? sanitizeInput($_POST["wiek"]) : "";
    $plec = isset($_POST["plec"]) ? sanitizeInput($_POST["plec"]) : "";
    $telefon = isset($_POST["telefon"]) ? sanitizeInput($_POST["telefon"]) : "";
    $email = isset($_POST["email"]) ? sanitizeInput($_POST["email"]) : "";
    $wyksztalcenie = isset($_POST["wyksztalcenie"]) ? sanitizeInput($_POST["wyksztalcenie"]) : "";
    $dodatkowe = isset($_POST["dodatkowe"]) ? implode(",", $_POST["dodatkowe"]) : "";
    $kwalifikacje = isset($_POST["kwalifikacje"]) ? implode(",", $_POST["kwalifikacje"]) : "";

    $errors = [
        "imieError" => "",
        "wiekError" => "",
        "plecError" => "",
        "telefonError" => "",
        "emailError" => "",
        "wyksztalcenieError" => "",
        "dodatkoweError" => "",
        "kwalifikacjeError" => ""
    ];

    if(empty($imie)) $errors["imieError"] = "Pole Imie nie może być puste!";
    if(empty($wiek)) $errors["wiekError"] = "Pole Wiek nie może być puste lub równe zero!";
    if(empty($plec)) $errors["plecError"] = "Pole Płeć musi być wybrane!";
    if(empty($telefon)) $errors["telefonError"] = "Pole Numer telefonu nie może być puste!";
    if(empty($email)) $errors["emailError"] = "Pole Email nie może być puste!";
    if($wyksztalcenie == "wybierz") $errors["wyksztalcenieError"] = "Pole Wykształcenie musi być wybrane!";
    if(empty($dodatkowe)) $errors["dodatkoweError"] = "Pole Dodatkowe musi być wybrane!";
    if(empty($kwalifikacje)) $errors["kwalifikacjeError"] = "Pole Kwalifikacje musi być wybrane!";


    if(empty($errors['imieError']) && !preg_match('/^\p{L}$/u', $imie))
        $errors['imieError'] = "Pole Imie musi się składać tylko z liter i musi się zaczynać z dużej litery (reszta małe)!";
    if(empty($errors['wiekError']) && !preg_match('/^[0-9]{1,3}$/', $wiek))
        $errors['wiekError'] = "Pole Wiek musi się składać tylko z cyfr i może być maksymalnie 3 cyframi!";
    if(empty($errors['telefonError']) && !preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{3}$/', $telefon))
        $errors['telefonError'] = "Pole Telefon musi się składać tylko z cyfr i być w formacie XXX-XXX-XXX (np. 123-456-789)!";
    if(empty($errors['emailError']) && !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors['emailError'] = "Pole Email musi się być w odpowiednim formacie (np. example@domain.com)!";


    if(empty(implode("", $errors))) {
        $query = "INSERT INTO osoba (imie, wiek, plec, telefon, email, wyksztalcenie, dodatkowe, kwalifikacje) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

        $stmt = $conn->prepare($query);

        $wiekInt = (int)$wiek;

        $stmt->bind_param("sissssss", $imie, $wiekInt, $plec, $telefon, $email, $wyksztalcenie, $dodatkowe, $kwalifikacje);

    

        if($stmt->execute()) {
            $_SESSION['formMessage'] = "<span style='color: green;'>Rekord został dodany</span>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $_SESSION['formMessage'] = "<span style='color: red;'>Wystąpił błąd podczas dodawaniu rekordu</span>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        $stmt->close();
    }
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["imieToDelete"])) {
    $imieToDelete = isset($_POST["imieToDelete"]) ? sanitizeInput($_POST["imieToDelete"]) : "";

    if(empty($imieToDelete)) $errors["imieToDeleteError"] = "Należy uzupełnić pole!";

    if(empty($errors["imieToDeleteError"]) && !preg_match('/^\p{L}*$/', $imieToDelete))
        $errors["imieToDeleteError"] = "Pole musi się skłądać tylko z liter i zaczynać się z dużej litery (reszta małe)!";

    if(empty($errors["imieToDeleteError"])) {
        $query = "DELETE FROM osoba WHERE imie = ? LIMIT 1;";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $imieToDelete);

        if($stmt->execute()) {
            if($conn->affected_rows == 1) {
                $_SESSION['formMessage'] = "<span style='color: green;'>Rekord został Usunięty</span>";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $_SESSION['formMessage'] = "<span style='color: red;'>Nie znaleziono rekordu z tym Imieiem</span>";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
            
        } else {
            $_SESSION['formMessage'] = "<span style='color: red;'>Wystąpił błąd podczas usuwania rekordu</span>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        $stmt->close();
    }
}


if(isset($_SESSION["formMessage"])) {
    $formMessage = $_SESSION["formMessage"];
    unset($_SESSION["formMessage"]);
}


$allowedSort = ["imie", "wiek"];

$sort = isset($_GET["sort"]) && in_array($_GET["sort"], $allowedSort) ? $_GET["sort"] : "imie";

$query = "SELECT * FROM osoba ORDER BY $sort ASC";

$result = $conn->query($query);

if(!$result) {
    die("Błąd pobierania danych: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php_baza4</title>
    <style>
        span.error {
            color: red;
        }

        table, tr, th, td {
            border: 1px solid #000;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <label for="imie">Imię: </label>
        <input type="text" id="imie" name="imie" value="<?php echo(isset($_POST['imie']) ? $_POST['imie'] : ''); ?>">
        <button type="button" onclick="clearInput('imie')">Wyczyść pole</button>
        <span class="error"><?php echo(isset($errors['imieError']) ? $errors['imieError'] : '');?></span>

        <br><br>

        <label for="wiek">Wiek: </label>
        <input type="text" id="wiek" name="wiek" value="<?php echo(isset($_POST['wiek']) ? $_POST['wiek'] : ''); ?>">
        <button type="button" onclick="clearInput('wiek')">Wyczyść pole</button>
        <span class="error"><?php echo(isset($errors['wiekError']) ? $errors['wiekError'] : '');?></span>
        <br><br>

        Płeć: 
        <input type="radio" name="plec" id="male" value="male" <?php echo(isset($_POST['plec']) && $_POST['plec'] == 'male' ? 'checked' : '')?>>
        <label for="male">Mężczyzna</label>
        <input type="radio" name="plec" id="female" value="female" <?php echo(isset($_POST['plec']) && $_POST['plec'] == 'female' ? 'checked' : '')?>>
        <label for="female">Kobieta</label>
        <button type="button" onclick="clearInput('plec')">Wyczyść pole</button>
        <span class="error"><?php echo(isset($errors['plecError']) ? $errors['plecError'] : '');?></span>

        <br><br>

        <label for="telefon">Numer Telefonu: </label>
        <input type="text" id="telefon" name="telefon" value="<?php echo(isset($_POST['telefon']) ? $_POST['telefon'] : ''); ?>">
        <button type="button" onclick="clearInput('telefon')">Wyczyść pole</button>
        <span class="error"><?php echo(isset($errors['telefonError']) ? $errors['telefonError'] : '');?></span>
        
        <br><br>
        
        <label for="email">Email: </label>
        <input type="text" id="email" name="email" value="<?php echo(isset($_POST['email']) ? $_POST['email'] : ''); ?>">
        <button type="button" onclick="clearInput('email')">Wyczyść pole</button>
        <span class="error"><?php echo(isset($errors['emailError']) ? $errors['emailError'] : '');?></span>

        <br><br>

        <label for="wyksztalcenie">Wyksztalcenie: </label>
        <select name="wyksztalcenie" id="wyksztalcenie">
            <option value="wybierz" <?php echo(isset($_POST['wyksztalcenie']) && $_POST['wyksztalcenie'] == 'wybierz') ? 'selected' : ''; ?>>Wybierz</option>
            <option value="podstawowe" <?php echo(isset($_POST['wyksztalcenie']) && $_POST['wyksztalcenie'] == 'podstawowe') ? 'selected' : ''; ?>>Podstawowe</option>
            <option value="srednie" <?php echo(isset($_POST['wyksztalcenie']) && $_POST['wyksztalcenie'] == 'srednie') ? 'selected' : ''; ?>>Średnie</option>
            <option value="wysokie" <?php echo(isset($_POST['wyksztalcenie']) && $_POST['wyksztalcenie'] == 'wysokie') ? 'selected' : ''; ?>>Wysokie</option>
        </select>
        <button type="button" onclick="clearInput('wyksztalcenie')">Wyczyść pole</button>
        <span class="error"><?php echo(isset($errors['wyksztalcenieError']) ? $errors['wyksztalcenieError'] : '');?></span>

        <br><br>
        

        <label for="dodatkowe[]">Dodatkowe: </label>
        <br>
        <select name="dodatkowe[]" id="dodatkowe" multiple>
            <option value="karnet" <?php echo(isset($_POST['dodatkowe']) && in_array('karnet', $_POST['dodatkowe']) ? 'selected' : ''); ?>>karnet na basen</option>
            <option value="kawa" <?php echo(isset($_POST['dodatkowe']) && in_array('kawa', $_POST['dodatkowe']) ? 'selected' : ''); ?>>kawa w pracy</option>
            <option value="samochod" <?php echo(isset($_POST['dodatkowe']) && in_array('samochod', $_POST['dodatkowe']) ? 'selected' : ''); ?>>samochód służbowy</option>
        </select>
        <br>
        <button type="button" onclick="clearInput('dodatkowe')">Wyczyść pole</button>
        <span class="error"><?php echo(isset($errors['dodatkoweError']) ? $errors['dodatkoweError'] : '');?></span>

        <br><br>

        <label for="kwalifikacje[]">Kwalifikacje: </label>
        <br>
        <input type="checkbox" name="kwalifikacje[]" value="pierwszaPomoc" id="pierwszaPomoc" <?php echo(isset($_POST['kwalifikacje']) && in_array('pierwszaPomoc', $_POST['kwalifikacje']) ? 'checked' : ''); ?>>Pierwsza pomoc
        <input type="checkbox" name="kwalifikacje[]" value="wiedzaIT" id="wiedzaIT" <?php echo(isset($_POST['kwalifikacje']) && in_array('wiedzaIT', $_POST['kwalifikacje']) ? 'checked' : ''); ?>>Wiedza IT
        <button type="button" onclick="clearInput('kwalifikacje')">Wyczyść pole</button>
        <span class="error"><?php echo(isset($errors['kwalifikacjeError']) ? $errors['kwalifikacjeError'] : '');?></span>

        <br><br>

        <input type="submit" value="Wyślij" name="wyslij">
        <input type="reset" value="Wyczyść formularz">
    </form>

    <br><br><br>

    
    <form action="" name="deleteSingleRowForm" method="post">
        <label for="imieToDelete">Wpisz Imię do usunięcia: </label>
        <input type="text" name="imieToDelete" id="imieToDelete">
        <input type="submit" name="deleteRow" value="Usuń rekord">
        <span class="error"><?php echo(isset($errors["imieToDeleteError"]) ? $errors["imieToDeleteError"] : ""); ?></span>
    </form>

    <br><br>

    <br>
    <span style="color: green;" id="formMessage"></span>
    <br>
    <?php
    echo(isset($formMessage) ? $formMessage : "");
    ?>
    <br>


    

    <br><br>

    <table>
        <tr>
            <th><a href="?sort=imie">Imię</a></th>
            <th><a href="?sort=wiek">Wiek</a></th>
            <th>Płeć</th>
            <th>Numer telefonu</th>
            <th>Email</th>
            <th>Wykształcenie</th>
            <th>Dodatkowe</th>
            <th>Kwalifikacje</th>
            <th>Usuń</th>
        </tr>

        <?php
        /*
        //change to post form input hidden
        while($row = $result->fetch_assoc()) {
            echo("<tr>");
            echo("<td>" . htmlspecialchars($row['imie']) . "</td>");
            echo("<td>" . htmlspecialchars($row['wiek']) . "</td>");
            echo("<td>" . htmlspecialchars($row['plec']) . "</td>");
            echo("<td>" . htmlspecialchars($row['telefon']) . "</tsd>");
            echo("<td>" . htmlspecialchars($row['email']) . "</td>");
            echo("<td>" . htmlspecialchars($row['wyksztalcenie']) . "</td>");
            echo("<td>" . htmlspecialchars($row['dodatkowe']) . "</td>");
            echo("<td>" . htmlspecialchars($row['kwalifikacje']) . "</td>");
            echo("<td><a name='delete' href='php_baza4.php?imie=" . urlencode($row['imie']) .
            "&plec=" . urlencode($row['plec']) .
            "&wiek=" . urlencode($row['wiek']) .
            "&telefon=" . urlencode($row['telefon']) .
            "&email=" . urlencode($row['email']) .
            "&wyksztalcenie=" . urlencode($row['wyksztalcenie']) .
            "&dodatkowe=" . urlencode($row['dodatkowe']) .
            "&kwalifikacje=" . urlencode($row['kwalifikacje']).
            "&delete=1'  
            onclick=\"return confirm('Czy na pewno chcesz usunąć ten rekord?');\">
            Usuń</a></td>");
            echo("</tr>");
        }
        */

        while($row = $result->fetch_assoc()) {
            echo("<tr>");
            echo("<td>" . htmlspecialchars($row['imie']) . "</td>");
            echo("<td>" . htmlspecialchars($row['wiek']) . "</td>");
            echo("<td>" . htmlspecialchars($row['plec']) . "</td>");
            echo("<td>" . htmlspecialchars($row['telefon']) . "</tsd>");
            echo("<td>" . htmlspecialchars($row['email']) . "</td>");
            echo("<td>" . htmlspecialchars($row['wyksztalcenie']) . "</td>");
            echo("<td>" . htmlspecialchars($row['dodatkowe']) . "</td>");
            echo("<td>" . htmlspecialchars($row['kwalifikacje']) . "</td>");
            echo("<td>" . "<form action='' method='post' name='deleteForm'>" .
                "<input type='hidden' name='imieDelete' value='" . $row['imie'] . "'>" .
                "<input type='hidden' name='wiekDelete' value='" . $row['wiek'] . "'>" .
                "<input type='hidden' name='plecDelete' value='" . $row['plec'] . "'>" .
                "<input type='hidden' name='telefonDelete' value='" . $row['telefon'] . "'>" .
                "<input type='hidden' name='emailDelete' value='" . $row['email'] . "'>" .
                "<input type='hidden' name='wyksztalcenieDelete' value='" . $row['wyksztalcenie'] . "'>" .
                "<input type='hidden' name='dodatkoweDelete' value='" . $row['dodatkowe'] . "'>" .
                "<input type='hidden' name='kwalifikacjeDelete' value='" . $row['kwalifikacje'] . "'>" .
                "<input type='submit' name='usun' value='Usuń' onclick='return confirm(\"Czy na pewno chcesz usunąć ten rekord?\");'>" .
                "</form>" . "</td>");
            echo("</tr>");  
        }

        $conn->close();
        ?>
    </table>


    
    <script>
        function getId(id) {
            return document.getElementById(id);
        }

        getId("imie").addEventListener("input", function() {
            this.value = this.value.replace(/\P{L}/gu, "");
            this.value = this.value.slice(0,1).toUpperCase() + this.value.slice(1).toLowerCase();
        });

        getId("wiek").addEventListener("input", function() {
            this.value = this.value.replace(/\D/g, "").slice(0,3);
        });

        getId("telefon").addEventListener("input", function() {
            this.value = this.value.replace(/\D/g, "");
            if(this.value.length > 6)
                this.value = this.value.slice(0,3) + "-" + this.value.slice(3,6) + "-" + this.value.slice(6,9);
            else if(this.value.length > 3)
                this.value = this.value.slice(0,3) + "-" + this.value.slice(3,9);
        });

        getId("imieToDelete").addEventListener("input", function() {
            this.value = this.value.replace(/\P{L}/gu, "");
            this.value = this.value.slice(0,1).toUpperCase() + this.value.slice(1).toLowerCase();
        });

        function clearInput(input) {
            if(input == "plec") {
                getId('male').checked = false;
                getId('female').checked = false;
                return;
            }

            if(input == "wyksztalcenie") {
                getId("wyksztalcenie").value = "wybierz";
                return;
            }

            if(input == "dodatkowe") {
                getId("dodatkowe").value = "";
                return;
            }

            if(input == "kwalifikacje") {
                getId("pierwszaPomoc").checked = false;
                getId("wiedzaIT").checked = false;
                return;
            }
 
            getId(input).value = "";
        }

        function disableForm(state) {
            getId('male').disabled = state;
            getId('female').disabled = state;
            getId('telefon').disabled = state;
            getId('email').disabled = state;
            getId('wyksztalcenie').disabled = state;
            getId('dodatkowe').disabled = state;
            getId('pierwszaPomoc').disabled = state;
            getId('wiedzaIT').disabled = state;
        }

        function checkFormState() {
            if(getId("imie").value == "" || getId("wiek").value == "") {
                disableForm(true);
                getId("formMessage").innerHTML = "<span style='color: #fc9b25;'>Proszę uzupełnić pola Imię i Wiek aby odblokować resztę formularza!</span>";
            } else {
                disableForm(false);
                getId("formMessage").innerHTML = "";
            }
        }

        checkFormState();
        setInterval(checkFormState, 500);


    </script>
</body>
</html>