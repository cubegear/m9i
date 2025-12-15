<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php_regex</title>

    <style>
        div#output {
            border: 1px solid #000;
            width: 300px;
            height: 180px;
            
        }
    </style>
</head>
<body>
    <h1>Formularz</h1>
    <h2>Utworzyć formularz:</h2>
    <p>1. Imię - imie: pierwsza litera wielka, pozostałe małe</p>
    <p>2. Nazwisko - nazwisko: pierwsza litera wielka pozostałe małe</p>
    <p>3. Wiek - wiek: cyfry, max 123 lata</p>
    <p>4. Ulica - ulica: pierwsze litery wyrazów wielkie</p>
    <p>5. Nr domu - dom: cyfry</p>
    <p>6. Nr mieszkania - mieszkanie: cyfry, z możliwością pustego miejsca</p>
    <p>7. Kod miejscowości - kod: uzytkownik wpisuje 5 cyfr, przygotowany jest schemat __-___</p>
    <p>8. Miasto - misato: wg. zasad nazw własnych</p>
    <p>9. Województwo - Wojewodztwo: lista</p>
    <p>Pod formularzem utworyć blok tekstu w którym zawarte będą informacje pobrane z formularza</p>

    <br><br>

    <?php
        if(isset($_POST['imie'], $_POST['nazwisko'], $_POST['wiek'], $_POST['ulica'], $_POST['nrDomu'], $_POST['nrMieszkania'], $_POST['kodMiejscowosci'], $_POST['miasto'], $_POST['wojewodztwo'])) {
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $wiek = $_POST['wiek'];
            $ulica = $_POST['ulica'];
            $nrDomu = $_POST['nrDomu'];
            $nrMieszkania = $_POST['nrMieszkania'];
            $kodMiejscowosci = $_POST['kodMiejscowosci'];
            $miasto = $_POST['miasto'];
            $wojewodztwo = $_POST['wojewodztwo'];

            
                $errors = [];
            if(empty($imie) || empty($nazwisko) || empty($wiek) || empty($ulica) || empty($nrDomu) || empty($kodMiejscowosci) || empty($miasto))  {
                $errors[] = "Conajmniej jedno z pól jest puste!";
            } else {
                
                if (!preg_match("/^[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż]+$/u", $imie)) $errors[] = "Imię może zawierać tylko litery i zaczynać się od dużej litery (pozostałe mają być małe) oraz musi się składać z conajmniej 2 znaków!";
                if (!preg_match("/^[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż]+$/u", $nazwisko)) $errors[] = "Nazwisko może zawierać tylko litery i zaczynać się od dużej litery (pozostałe mają być małe) oraz musi się składać z conajmniej 2 znaków!!";
                if (!preg_match("/^[0-9]+$/", $wiek) || $wiek < 0 || $wiek > 123) $errors[] = "Wiek musi być cyfrą od 0 do 123";
                if (!preg_match("/^[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż]*(?:\s[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż]*)*$/u", $ulica)) $errors[] = "Ulica może zawierać tylko litery oraz spacje pomiędzy słowami nie mogą być większe niż 1 spacja (Każde słowo ma się zaczynąc z dużej litery, pozostąłe mają być małe)!";
                if (!preg_match("/^[0-9]+$/", $nrDomu)) $errors[] = "Nr domu musi być cyfrą";
                if (!preg_match("/^([0-9]+)?$/", $nrMieszkania)) $errors[] = "Nr mieszkania musi być cyfrą lub być pusty!";
                if (!preg_match("/^[0-9]{2}-[0-9]{3}$/", $kodMiejscowosci)) $errors[] = "Kod miejscowości musi mieć format XX-XXX!";
                if (!preg_match("/^[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźż]+$/u", $miasto)) $errors[] = "Miasto może zawierać tylko litery i zaczynać się od dużej litery (pozostałe mają być małe)!";
                if ($wojewodztwo == "Wybierz") $errors[] = "Proszę wybrać województwo!";            

                
            }

            if(!empty($errors)) {
                foreach($errors as $e) {
                    echo "<span style='color: red;'>$e</span><br>";
                };
            }


            
        }
    ?>


    <br><br>
    <form action="" method="post" name="form">
        Imię: <input type="text" id="imie" name="imie" placeholder="Jan" value="<?php echo isset($_POST['imie']) ? htmlspecialchars($_POST['imie']) : ''; ?>">
        <input type="button" value="Wyczyść pole" onclick="resetInput('imie')">
        <span style="color: red;">*Pole Obowiązkowe</span>
        <br><br>
        Nazwisko: <input type="text" id="nazwisko" name="nazwisko" placeholder="Kowalski" value="<?php echo isset($_POST['nazwisko']) ? htmlspecialchars($_POST['nazwisko']) : ''; ?>">
        <input type="button" value="Wyczyść pole" onclick="resetInput('nazwisko')">
        <span style="color: red;">*Pole Obowiązkowe</span>
        <br><br>
        Wiek: <input type="text" id="wiek" name="wiek" placeholder="0-123" value="<?php echo isset($_POST['wiek']) ? htmlspecialchars($_POST['wiek']) : ''; ?>">
        <input type="button" value="Wyczyść pole" onclick="resetInput('wiek')">
        <span style="color: red;">*Pole Obowiązkowe</span>
        <br><br>
        Ulica: <input type="text" id="ulica" name="ulica" value="<?php echo isset($_POST['ulica']) ? htmlspecialchars($_POST['ulica']) : ''; ?>">
        <input type="button" value="Wyczyść pole" onclick="resetInput('ulica')">
        <span style="color: red;">*Pole Obowiązkowe</span>
        <br><br>
        Nr domu: <input type="text" id="nrDomu" name="nrDomu" value="<?php echo isset($_POST['nrDomu']) ? htmlspecialchars($_POST['nrDomu']) : ''; ?>">
        <input type="button" value="Wyczyść pole" onclick="resetInput('nrDomu')">
        <span style="color: red;">*Pole Obowiązkowe</span>
        <br><br>
        Nr mieszkania: <input type="text" id="nrMieszkania" name="nrMieszkania" value="<?php echo isset($_POST['nrMieszkania']) ? htmlspecialchars($_POST['nrMieszkania']) : ''; ?>">
        <input type="button" value="Wyczyść pole" onclick="resetInput('nrMieszkania')">
        <br><br>
        Kod miejscowości: <input type="text" id="kodMiejscowosci" name="kodMiejscowosci" placeholder="__-___" value="<?php echo isset($_POST['kodMiejscowosci']) ? htmlspecialchars($_POST['kodMiejscowosci']) : ''; ?>">
        <input type="button" value="Wyczyść pole" onclick="resetInput('kodMiejscowosci')">
        <span style="color: red;">*Pole Obowiązkowe</span>
        <br><br>    
        Miasto: <input type="text" id="miasto" name="miasto" value="<?php echo isset($_POST['miasto']) ? htmlspecialchars($_POST['miasto']) : ''; ?>">
        <input type="button" value="Wyczyść pole" onclick="resetInput('miasto')">
        <span style="color: red;">*Pole Obowiązkowe</span>
        <br><br>
        Województwo: <select name="wojewodztwo" id="wojewodztwo">
            <option value="Wybierz">Wybierz</option>
            <option value="Mazowieckie">Mazowieckie</option>
            <option value="Śląskie">Śląskie</option>
            <option value="Małopolskie">Małopolskie</option>
            <option value="Dolnośląskie">Dolnośląskie</option>
        </select>
        <input type="button" value="Wyczyść pole" onclick="resetInput('wojewodztwo')"><span style="color: red;">*Pole Obowiązkowe</span>
        <br><br>
        <input type="submit" value="Wyślij"><input type="button" value="Wyczyść formularz" id="formReset">
    </form>
    
    <br><br>


    <?php    
        if(isset($_POST['imie'], $_POST['nazwisko'], $_POST['wiek'], $_POST['ulica'], $_POST['nrDomu'], $_POST['nrMieszkania'], $_POST['kodMiejscowosci'], $_POST['miasto'], $_POST['wojewodztwo'])) {
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $wiek = $_POST['wiek'];
            $ulica = $_POST['ulica'];
            $nrDomu = $_POST['nrDomu'];
            $nrMieszkania = $_POST['nrMieszkania'];
            $kodMiejscowosci = $_POST['kodMiejscowosci'];
            $miasto = $_POST['miasto'];
            $wojewodztwo = $_POST['wojewodztwo'];

            if(empty($nrMieszkania)) {
                $nrMieszkaniaNowy = "Brak";
            } else {
                $nrMieszkaniaNowy = $nrMieszkania;
            }

            if(empty($errors)) {
                echo("<div id='output'><pre>
    $imie $nazwisko, lat $wiek

    Zamieszkały w:
    Województwo: $wojewodztwo
    Miasto: $miasto
    Ulica: $ulica
    Nr domu: $nrDomu
    Nr mieszkania $nrMieszkaniaNowy
    Kod miejscowości: $kodMiejscowosci
                </pre></div>");
            }     
        }      
    ?>

    <script>
        document.getElementById("formReset").addEventListener("click", function() {
            document.forms["form"].reset();
        });

        function resetInput(input) {
            if(input == "wojewodztwo") {
                document.getElementById('wojewodztwo').value = "Wybierz";
                return;
            }

            document.getElementById(input).value = "";
        };

        function firstLetterUpper() {
            this.value = this.value.replace(/[\P{L}]+/gu, "");
            this.value = this.value.slice(0, 1).toUpperCase() + this.value.slice(1).toLowerCase();
        }

        document.getElementById("imie").addEventListener("input", firstLetterUpper);
        document.getElementById("nazwisko").addEventListener("input", firstLetterUpper);
        document.getElementById("miasto").addEventListener("input", firstLetterUpper);


        document.getElementById("wiek").addEventListener("input", function() {
            this.value = this.value.replace(/\D/g, "");
            this.value = this.value.slice(0, 3);
            if(this.value > 123) {
                this.value = 123;
            }
        });

        document.getElementById("ulica").addEventListener("input", function() {
            this.value = this.value.replace(/[^A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż\s]/g, '');
            this.value = this.value.replace(/\s+/g, ' ');
            this.value = this.value.trimStart();
            this.value = this.value
                .split(" ")
                .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                .join(" ");
        });

        document.getElementById("ulica").addEventListener("blur", function() {
            this.value = this.value.trim();
        });

        document.getElementById("kodMiejscowosci").addEventListener("input", function() {
            this.value = this.value.replace(/\D/g, "");
            if (this.value.length > 2) {
                this.value = this.value.slice(0, 2) + "-" + this.value.slice(2, 5);
            }
        });

        document.getElementById("nrDomu").addEventListener("input", function() {
            this.value = this.value.replace(/\D/g, "");
        });

        document.getElementById("nrMieszkania").addEventListener("input", function() {
            this.value = this.value.replace(/[A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż\!\@\#\$\%\^\&\*\(\)\_\+\-\=\[\]\{\}\;\:\'\"\\\|\,\<\.\>\/\?\`\~]/g, '');
            this.value = this.value.replace(/\s+/g, ' ');
            this.value = this.value.trimStart();
        });

        document.getElementById("nrMieszkania").addEventListener("blur", function() {
            this.value = this.value.trim();
        });

        
    </script>
</body>
</html>
