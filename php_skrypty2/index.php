<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php_skrypty2</title>
    <style>
        span.error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>PLIKI</h1>
    <?php
    $errors = [];
    /*
    $file = fopen("./pierwszyRaz.txt", "a+");

    rewind($file);

    $content = fread($file, 100);

    

    if(empty($content)) {
        $date = Date("d-m-Y");
        fwrite($file, $date);
    }
    
    
    rewind($file);

    $pierwszyRaz = fread($file, 100);
    fclose($file);

    $file = fopen("./iloscOdwiedzin.txt", "a+");

    rewind($file);

    $content = fread($file, 100);

    if(empty($content)) {
        fwrite($file, "1");
        rewind($file);
        $iloscOdwiedzin = fread($file, 100);
    } else {
        rewind($file);
        file_put_contents("./iloscOdwiedzin.txt", "");
        (int)$content += 1;
        fwrite($file, (string) $content);

        rewind($file);

        $iloscOdwiedzin = fread($file, 100);

    }

    ?>

    <br>
    <?php
    echo($pierwszyRaz);
    echo("<br>");
    echo($iloscOdwiedzin);
    */

    $pierwszyRazPlik = "./pierwszyRaz.txt";
    $pierwszyRaz = file_get_contents($pierwszyRazPlik);
    if(empty($pierwszyRaz)) file_put_contents($pierwszyRazPlik, Date("d-m-Y"));
    $pierwszyRaz = file_get_contents($pierwszyRazPlik);

    $iloscOdwiedzinPlik = "./iloscOdwiedzin.txt";
    $iloscOdwiedzin = file_get_contents($iloscOdwiedzinPlik);
    if(empty($iloscOdwiedzin)) {
        file_put_contents($iloscOdwiedzinPlik, 1);
    } else {
        $count = (int) $iloscOdwiedzin += 1;
        file_put_contents($iloscOdwiedzinPlik, $count);
    }
    $iloscOdwiedzin = file_get_contents($iloscOdwiedzinPlik);

    echo("Witryna została odwiedzona $iloscOdwiedzin razy od $pierwszyRaz");
    ?>
    <br><br>

    <h3>Głosowanie</h3>

    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["glosowanieFormSubmit"])) {
        $kolor = isset($_POST["kolor"]) ? $_POST["kolor"] : "" ;

        if(empty($kolor)) $errors["kolorError"] = "Proszę uzupełnić pole przed wysłaniem!";
        else $errors["kolorError"] = "";



        if(empty($errors["kolorError"])) {
            $fileName = "./glosowanie/$kolor.txt";
            $count = file_get_contents($fileName);
            $wszystkie = file_get_contents("./glosowanie/wszystkie.txt");
            if(empty($count)) file_put_contents($fileName, "0");
            if(empty($wszystkie)) file_put_contents($fileName, "0");

            $ilosc = (int) $count;
            $ilosc += 1;
            file_put_contents($fileName, "");
            file_put_contents($fileName, $ilosc);
            $count = file_get_contents($fileName);

            $wszystkieInt = (int) $wszystkie;
            $wszystkieInt += 1;
            file_put_contents("./glosowanie/wszystkie.txt", "");
            file_put_contents("./glosowanie/wszystkie.txt", $wszystkieInt);
            $wszystkie = file_get_contents("./glosowanie/wszystkie.txt");

            header("Location: " . $_SERVER["PHP_SELF"]);
            exit();
        }
    }
    ?>

    <form action="" method="post" name="glosowanieForm">
        <label for="kolor">Jakie jest twój ulubiony kolor?</label><br>
        czerwony<input type="radio" name="kolor" id="czerwony" value="czerwony"><br>
        zielony<input type="radio" name="kolor" id="zielony" value="zielony"><br>
        niebieski<input type="radio" name="kolor" id="niebieski" value="niebieski"><br>
        fioletowy<input type="radio" name="kolor" id="fioletowy" value="fioletowy"><br>
        czarny<input type="radio" name="kolor" id="czarny" value="czarny"><br>
        <br>
        <span class="error"><?php echo(isset($errors["kolorError"]) ? $errors["kolorError"] : ""); ?></span>
        <br>
        <input type="submit" value="Głosuj" name="glosowanieFormSubmit">
    </form>
    <br><br>

    <table>
        <tr>
            <th>Nazwa koloru</th>
            <th>Ilość głosów</th>
            <th>Procent głosów</th>
        </tr>

        <tr>
            <td>czerwony</td>
            <td><?php echo(empty(file_get_contents("./glosowanie/czerwony.txt")) ? "0" : file_get_contents("./glosowanie/czerwony.txt")); ?></td>
            <td>
                <?php
                $wszystkieGlosy = empty(file_get_contents("./glosowanie/wszystkie.txt")) ? "0" : file_get_contents("./glosowanie/wszystkie.txt");
                $czerwonyGlosy = empty(file_get_contents("./glosowanie/czerwony.txt")) ? "0" : file_get_contents("./glosowanie/czerwony.txt");

                if($czerwonyGlosy == "0" || $wszystkieGlosy == "0") {
                    $procent = "0";
                } else {
                    $procent = round(((int)$czerwonyGlosy / (int)$wszystkieGlosy) * 100, 2);
                }

                echo("$procent %");
                ?>
            </td>
        </tr>

        <tr>
            <td>zielony</td>
            <td><?php echo(empty(file_get_contents("./glosowanie/zielony.txt")) ? "0" : file_get_contents("./glosowanie/zielony.txt")); ?></td>
            <td>
                <?php
                $wszystkieGlosy = empty(file_get_contents("./glosowanie/wszystkie.txt")) ? "0" : file_get_contents("./glosowanie/wszystkie.txt");
                $zielonyGlosy = empty(file_get_contents("./glosowanie/zielony.txt")) ? "0" : file_get_contents("./glosowanie/zielony.txt");

                if($zielonyGlosy == "0" || $wszystkieGlosy == "0") {
                    $procent = "0";
                } else {
                    $procent = round(((int)$zielonyGlosy / (int)$wszystkieGlosy) * 100, 2);
                }

                echo("$procent %");
                ?>
            </td>
        </tr>

        <tr>
            <td>niebieski</td>
            <td><?php echo(empty(file_get_contents("./glosowanie/niebieski.txt")) ? "0" : file_get_contents("./glosowanie/niebieski.txt")); ?></td>
            <td>
                <?php
                $wszystkieGlosy = empty(file_get_contents("./glosowanie/wszystkie.txt")) ? "0" : file_get_contents("./glosowanie/wszystkie.txt");
                $niebieskiGlosy = empty(file_get_contents("./glosowanie/niebieski.txt")) ? "0" : file_get_contents("./glosowanie/niebieski.txt");

                if($niebieskiGlosy == "0" || $wszystkieGlosy == "0") {
                    $procent = "0";
                } else {
                    $procent = round(((int)$niebieskiGlosy / (int)$wszystkieGlosy) * 100, 2);
                }

                echo("$procent %");
                ?>
            </td>
        </tr>

        <tr>
            <td>fioletowy</td>
            <td><?php echo(empty(file_get_contents("./glosowanie/fioletowy.txt")) ? "0" : file_get_contents("./glosowanie/fioletowy.txt")); ?></td>
            <td>
                <?php
                $wszystkieGlosy = empty(file_get_contents("./glosowanie/wszystkie.txt")) ? "0" : file_get_contents("./glosowanie/wszystkie.txt");
                $fioletowyGlosy = empty(file_get_contents("./glosowanie/fioletowy.txt")) ? "0" : file_get_contents("./glosowanie/fioletowy.txt");

                if($fioletowyGlosy == "0" || $wszystkieGlosy == "0") {
                    $procent = "0";
                } else {
                    $procent = round(((int)$fioletowyGlosy / (int)$wszystkieGlosy) * 100, 2);
                }

                echo("$procent %");
                ?>
            </td>
        </tr>

        <tr>
            <td>czarny</td>
            <td><?php echo(empty(file_get_contents("./glosowanie/czarny.txt")) ? "0" : file_get_contents("./glosowanie/czarny.txt")); ?></td>
            <td>
                <?php
                $wszystkieGlosy = empty(file_get_contents("./glosowanie/wszystkie.txt")) ? "0" : file_get_contents("./glosowanie/wszystkie.txt");
                $czarnyGlosy = empty(file_get_contents("./glosowanie/czarny.txt")) ? "0" : file_get_contents("./glosowanie/czarny.txt");

                if($czarnyGlosy == "0" || $wszystkieGlosy == "0") {
                    $procent = "0";
                } else {
                    $procent = round(((int)$czarnyGlosy / (int)$wszystkieGlosy) * 100, 2);
                }

                echo("$procent %");
                ?>
            </td>
        </tr>

      

        
    </table>
    
    <h3>IP</h3>

    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hostIpFormSubmit"])) {
        $host = isset($_POST["host"]) ? $_POST["host"] : "" ;

        if(empty($host)) $errors["hostError"] = "Proszę uzupełnić pole przed wysłaniem!";
        else $errors["hostError"] = "";

        if(empty($errors["hostError"])) {
            $ip = gethostbyname($host);
        }
    }
    ?>

    <form action="" method="post" name="hostIpForm">
        <label for="host">Nazwa hosta: </label><input type="text" name="host" id="host">
        <span class="error"><?php echo(isset($errors["hostError"]) ? $errors["hostError"] : ""); ?></span>
        <br>
        <input type="submit" value="OK" name="hostIpFormSubmit">
    </form>

    <?php
    echo(isset($ip) ? $ip : "");
    ?>

    

    
</body>
</html>