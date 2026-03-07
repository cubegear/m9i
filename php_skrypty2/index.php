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

    $odwiedzinyDane = [
        "pierwszyRaz" => "",
        "iloscOdwiedzin" => ""
    ];

    $odwiedzinyPlik = "./odwiedziny.json";
    $odwiedzinyJson = file_get_contents($odwiedzinyPlik);
    $odwiedziny = json_decode($odwiedzinyJson, true);

    

    if(empty($odwiedziny)) {
        $odwiedzinyDane = [
            "pierwszyRaz" => Date("d-m-Y"),
            "iloscOdwiedzin" => "1"
        ];
        
        file_put_contents($odwiedzinyPlik, json_encode($odwiedzinyDane, JSON_PRETTY_PRINT));
        $odwiedzinyJson = file_get_contents($odwiedzinyPlik);
        $odwiedziny = json_decode($odwiedzinyJson, true);
    }

    
    
    if(empty($odwiedziny["pierwszyRaz"])) {
        $odwiedzinyDane = [
            "pierwszyRaz" => Date("d-m-Y"),
            "iloscOdwiedzin" => $odwiedziny["iloscOdwiedzin"]
        ];
        
        file_put_contents($odwiedzinyPlik, json_encode($odwiedzinyDane, JSON_PRETTY_PRINT));
        $odwiedzinyJson = file_get_contents($odwiedzinyPlik);
        $odwiedziny = json_decode($odwiedzinyJson, true);
    }

    

    if(empty($odwiedziny["iloscOdwiedzin"])) {
        $odwiedzinyDane = [
            "pierwszyRaz" => $odwiedziny["pierwszyRaz"],
            "iloscOdwiedzin" => "1"
        ];
        
        file_put_contents($odwiedzinyPlik, json_encode($odwiedzinyDane, JSON_PRETTY_PRINT));
        $odwiedzinyJson = file_get_contents($odwiedzinyPlik);
        $odwiedziny = json_decode($odwiedzinyJson, true);
    }


    $odwiedzinyDane = [
        "pierwszyRaz" => $odwiedziny["pierwszyRaz"],
        "iloscOdwiedzin" => ((int)$odwiedziny["iloscOdwiedzin"] + 1)
    ];
        
    file_put_contents($odwiedzinyPlik, json_encode($odwiedzinyDane, JSON_PRETTY_PRINT));
    $odwiedzinyJson = file_get_contents($odwiedzinyPlik);
    $odwiedziny = json_decode($odwiedzinyJson, true);

    
    echo("Witryna zostala odwiedzona: " . $odwiedziny["iloscOdwiedzin"] . " razy od " . $odwiedziny["pierwszyRaz"]);

    ?>
    <br><br>

    <h3>Głosowanie</h3>

    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["glosowanieFormSubmit"])) {
        $kolor = isset($_POST["kolor"]) ? $_POST["kolor"] : "" ;

        if(empty($kolor)) $errors["kolorError"] = "Proszę uzupełnić pole przed wysłaniem!";
        else $errors["kolorError"] = "";


        $glosowaniePlik = "./glosowanie.json";
        $glosowanieJson = file_get_contents($glosowaniePlik);
        $glosowanieDane = json_decode($glosowanieJson, true);

        if(empty($errors["kolorError"])) {
           

            if(empty($glosowanieDane)) {
                $glosowanieDane = [
                    "czerwony" => "0",
                    "zielony" => "0",
                    "niebieski" => "0",
                    "fioletowy" => "0",
                    "czarny" => "0",
                    "wszystkie" => "0"
                ];

                file_put_contents($glosowaniePlik, json_encode($glosowanieDane, JSON_PRETTY_PRINT));
                $glosowanieJson = file_get_contents($glosowaniePlik);
                $glosowanieDane = json_decode($glosowanieJson, true);    
            }

            $glosowanieDane[$kolor] = (int)$glosowanieDane[$kolor] + 1;
            $glosowanieDane["wszystkie"] = (int)$glosowanieDane["wszystkie"] + 1;

            file_put_contents($glosowaniePlik, json_encode($glosowanieDane, JSON_PRETTY_PRINT));
            $glosowanieJson = file_get_contents($glosowaniePlik);
            $glosowanieDane = json_decode($glosowanieJson, true);
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
            <td><?php echo(isset($glosowanieDane) ? $glosowanieDane["czerwony"] : "0"); ?></td>
            <td>
                <?php
                if(isset($glosowanieDane)) {
                    echo($glosowanieDane["wszystkie"] == "0" ? "0" : round(((int)$glosowanieDane["czerwony"] / (int)$glosowanieDane["wszystkie"]) * 100, 2) . " %");
                }
                ?>
            </td>
        </tr>
        
        <tr>
            <td>zielony</td>
            <td><?php echo(isset($glosowanieDane) ? $glosowanieDane["zielony"] : "0"); ?></td>
            <td>
                <?php
                if(isset($glosowanieDane)) {
                    echo($glosowanieDane["wszystkie"] == "0" ? "0" : round(((int)$glosowanieDane["zielony"] / (int)$glosowanieDane["wszystkie"]) * 100, 2) . " %");
                }
                ?>
            </td>
        </tr>

        <tr>
            <td>niebieski</td>
            <td><?php echo(isset($glosowanieDane) ? $glosowanieDane["niebieski"] : "0"); ?></td>
            <td>
                <?php
                if(isset($glosowanieDane)) {
                    echo($glosowanieDane["wszystkie"] == "0" ? "0" : round(((int)$glosowanieDane["niebieski"] / (int)$glosowanieDane["wszystkie"]) * 100, 2) . " %");
                }
                ?>
            </td>
        </tr>

        <tr>
            <td>fioletowy</td>
            <td><?php echo(isset($glosowanieDane) ? $glosowanieDane["fioletowy"] : "0"); ?></td>
            <td>
                <?php
                if(isset($glosowanieDane)) {
                    echo($glosowanieDane["wszystkie"] == "0" ? "0" : round(((int)$glosowanieDane["fioletowy"] / (int)$glosowanieDane["wszystkie"]) * 100, 2) . " %");
                }
                ?>
            </td>
        </tr>

        <tr>
            <td>czarny</td>
            <td><?php echo(isset($glosowanieDane) ? $glosowanieDane["czarny"] : "0"); ?></td>
            <td>
                <?php
                if(isset($glosowanieDane)) {
                    echo($glosowanieDane["wszystkie"] == "0" ? "0" : round(((int)$glosowanieDane["czarny"] / (int)$glosowanieDane["wszystkie"]) * 100, 2) . " %");
                }
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