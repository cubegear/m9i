<?php
    $db_lnk = new mysqli("localhost", "root", "", "baza1");

    if ($db_lnk->connect_error) {
        die("Błąd połączenia z bazą: " . $db_lnk->connect_error);
    }

    if (isset($_POST['imie'], $_POST['nazwisko'], $_POST['wiek'], $_POST['miasto'], $_POST['kodMiasta'], $_POST['email'])) {
        $imie = trim($_POST['imie']);
        $nazwisko = trim($_POST['nazwisko']);
        $wiek = trim($_POST['wiek']);
        $miasto = trim($_POST['miasto']);
        $kodMiasta = trim($_POST['kodMiasta']);
        $email = trim($_POST['email']);

        if(empty($imie) || empty($nazwisko) || empty($wiek) || empty($miasto) || empty($kodMiasta) || empty($email)) {
            echo "<p style='color: red;'>Conajmniej jedno z pól jest puste</p>";
        } else {
            $errors = [];

            if (!preg_match("/^[\p{L}]+$/u", $imie)) $errors[] = "Imię może zawierać tylko litery!";
            if (!preg_match("/^[\p{L}]+$/u", $nazwisko)) $errors[] = "Nazwisko może zawierać tylko litery!";
            if (!preg_match("/^[0-9]{2}$/", $wiek)) $errors[] = "Wiek musi być 2 cyframi (00–99)!";
            if (!preg_match("/^[\p{L}]+$/u", $miasto)) $errors[] = "Miasto może zawierać tylko litery!";
            if (!preg_match("/^[0-9]{2}-[0-9]{3}$/", $kodMiasta)) $errors[] = "Kod miasta musi mieć format XX-XXX!";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Niepoprawny email!";

            if (empty($errors)) {

                $wiek_int = (int)$wiek;

                $stmt = $db_lnk->prepare( "INSERT INTO baza1 (imie, nazwisko, wiek, miasto, kodmiasta, email) VALUES (?, ?, ?, ?, ?, ?)" );

                $stmt->bind_param("ssisss", $imie, $nazwisko, $wiek_int, $miasto, $kodMiasta, $email);

                if ($stmt->execute()) {
                    echo "<p style='color: green;'>Dodano osobę!</p>";
                } else {
                    echo "<p style='color: red;'>Błąd dodawania: {$stmt->error}</p>";
                }

                $stmt->close();
            } else {
                foreach ($errors as $e) {
                    echo "<p style='color: red;'>$e</p>";
                }
            }
        }
    }

    $allowed = ["id", "nazwisko", "wiek"];
    $sort = (isset($_GET['sort']) && in_array($_GET['sort'], $allowed)) ? $_GET['sort'] : "id";

    $result = $db_lnk->query("SELECT * FROM baza1 ORDER BY $sort ASC");
    if (!$result) {
        die("Błąd zapytania SELECT: " . $db_lnk->error);
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php_baza1</title>

    <style>
        body {
            font-family: arial;
        }

        table {
            border-collapse: collapse;
            border: 1px solid #000;
        }

        th, td {
            padding: 5px 10px;
            border: 1px solid #000;
        }

        tr {
            border: 1px solid #000;
        }

        div#main {
            width: 100%;
            margin: auto;
        }
    </style>

</head>
<body>
    <div id="main">
        <h3>Dodaj osobę</h3>

        <form method="post">
            <label for="imie">Imię: </label>
            <input type="text" id="imie" name="imie"><br><br>

            <label for="imie">Nazwisko: </label>
            <input type="text" id="nazwisko" name="nazwisko"><br><br>

            <label for="imie">Wiek: </label>
            <input type="text" id="wiek" name="wiek" maxlength="2"><br><br>

            <label for="imie">Miasto: </label>
            <input type="text" id="miasto" name="miasto"><br><br>

            <label for="imie">Kod miasta: </label>
            <input type="text" id="kodMiasta" name="kodMiasta" placeholder="XX-XXX"><br><br>

            <label for="imie">Email: </label>
            <input type="email" id="email" name="email"><br><br>

            <input type="submit" value="Dodaj">
        </form>

            
        <script>
            document.getElementById("imie").addEventListener("input", function() {
                this.value = this.value.replace(/[\P{L}]+/gu, "");
                this.value = this.value.slice(0, 1).toUpperCase() + this.value.slice(1);
            });


            document.getElementById("nazwisko").addEventListener("input", function() {
                this.value = this.value.replace(/[\P{L}]+/gu, "");
                this.value = this.value.slice(0, 1).toUpperCase() + this.value.slice(1);
            });

            document.getElementById("wiek").addEventListener("input", function() {
                this.value = this.value.replace(/\D/g, "");
                this.value = this.value.slice(0, 2);
            });

            document.getElementById("miasto").addEventListener("input", function() {
                this.value = this.value.replace(/[\P{L}]+/gu, "");
                this.value = this.value.slice(0, 1).toUpperCase() + this.value.slice(1);
            });

            document.getElementById("kodMiasta").addEventListener("input", function() {
                this.value = this.value.replace(/\D/g, "");
                if (this.value.length > 2) {
                    this.value = this.value.slice(0, 2) + "-" + this.value.slice(2, 5);
                }
            });

        </script>

        <br><br>

        <h3>Zawartość bazy</h3>
        
        <p>
            Sortuj wg: 
            <a href="?sort=nazwisko">Nazwisko</a> |
            <a href="?sort=wiek">Wiek</a> |
            <a href="?sort=id">ID</a>
        </p>

        <table>
            <tr>
                <th>ID</th><th>Imię</th><th>Nazwisko</th><th>Wiek</th><th>Miasto</th><th>Kod miasta</th><th>Email</th>
            </tr>

            <?php
                while($row = $result->fetch_assoc()) {
                    echo("<tr>");
                    echo("<td>" . htmlspecialchars($row['id']) . "</td>");
                    echo("<td>" . htmlspecialchars($row['imie']) . "</td>");
                    echo("<td>" . htmlspecialchars($row['nazwisko']) . "</td>");
                    echo("<td>" . htmlspecialchars($row['wiek']) . "</td>");
                    echo("<td>" . htmlspecialchars($row['miasto']) . "</td>");
                    echo("<td>" . htmlspecialchars($row['kodmiasta']) . "</td>");
                    echo("<td>" . htmlspecialchars($row['email']) . "</td>");
                    echo("</tr>");
                }
            ?>
        </table>
    </div>
</body>
</html>

