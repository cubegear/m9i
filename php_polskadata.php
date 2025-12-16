```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Polska Data PHP</title>
</head>
<body>
    <h1>Polska Data PHP</h1>
    
    <div>
        Napisać skrypty, zamieniające nazwy dni tygodnia w dacie z angielkich na polskie, wykorzystując:
        - różne instrukcje warunkowe,
        - operatory warunkowe,
        - tablice.
        (min 1 poprawnie skonstruowana instrukcja warunkowa + operator warunkowy lub tablica na ocenę dop).
        Data bieżąca: nazwa dnia tygodnia, nr dnia miesiąca, nazwa miesiąc i pełny rok.
    
        Nazwa ćwiczenia: php_polskadata, waga ćwiczenia: 2, czas: 30'
    </div>

    <br><br><br>

    <?php
    $weekDaysPL = ["Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota"];
    $monthsPL = ["Stycznia", "Lutego", "Marca", "Kwietnia", "Maja", "Czerwca", "Lipca", "Sierpnia", "Września", "Października", "Listopada", "Grudnia"];
    
    $currentDayOfWeek = (int) date("w");
    $currentDay = date("d");
    $currentMonth = (int) date("n");
    $currentYear = date("Y");
    ?>

    <h3>Tylko tablice</h3>
    <?php
    echo "Dzisiejsza data to: <br>" . 
         $weekDaysPL[$currentDayOfWeek] . ", " . 
         $currentDay . " " . 
         $monthsPL[$currentMonth - 1] . " " . 
         $currentYear;
    ?>

    <br><br><br><br>

    <h3>Instrukcja warunkowa if else</h3>
    <?php
    if($currentDayOfWeek == 0) {
        $weekDayPl1 = $weekDaysPL[0];
    } else if($currentDayOfWeek == 1) {
        $weekDayPl1 = $weekDaysPL[1];
    } else if($currentDayOfWeek == 2) {
        $weekDayPl1 = $weekDaysPL[2];
    } else if($currentDayOfWeek == 3) {
        $weekDayPl1 = $weekDaysPL[3];
    } else if($currentDayOfWeek == 4) {
        $weekDayPl1 = $weekDaysPL[4];
    } else if($currentDayOfWeek == 5) {
        $weekDayPl1 = $weekDaysPL[5];
    } else if($currentDayOfWeek == 6) {
        $weekDayPl1 = $weekDaysPL[6];
    }
    
    if($currentMonth == 1) {
        $monthPL1 = $monthsPL[0];
    } else if($currentMonth == 2) {
        $monthPL1 = $monthsPL[1];
    } else if($currentMonth == 3) {
        $monthPL1 = $monthsPL[2];
    } else if($currentMonth == 4) {
        $monthPL1 = $monthsPL[3];
    } else if($currentMonth == 5) {
        $monthPL1 = $monthsPL[4];
    } else if($currentMonth == 6) {
        $monthPL1 = $monthsPL[5];
    } else if($currentMonth == 7) {
        $monthPL1 = $monthsPL[6];
    } else if($currentMonth == 8) {
        $monthPL1 = $monthsPL[7];
    } else if($currentMonth == 9) {
        $monthPL1 = $monthsPL[8];
    } else if($currentMonth == 10) {
        $monthPL1 = $monthsPL[9];
    } else if($currentMonth == 11) {
        $monthPL1 = $monthsPL[10];
    } else if($currentMonth == 12) {
        $monthPL1 = $monthsPL[11];
    }
    
    echo "Dzisiejsza data to: <br>" . $weekDayPl1 . ", " . $currentDay . " " . $monthPL1 . " " . $currentYear;
    ?>

    <br><br><br><br>

    <h3>Instrukcja if...elseif z operatorem warunkowym</h3>
    <?php
    if($currentDayOfWeek == 0) {
        $weekDayPl2 = $weekDaysPL[0];
    } elseif($currentDayOfWeek == 1) {
        $weekDayPl2 = $weekDaysPL[1];
    } elseif($currentDayOfWeek == 2) {
        $weekDayPl2 = $weekDaysPL[2];
    } elseif($currentDayOfWeek == 3) {
        $weekDayPl2 = $weekDaysPL[3];
    } elseif($currentDayOfWeek == 4) {
        $weekDayPl2 = $weekDaysPL[4];
    } elseif($currentDayOfWeek == 5) {
        $weekDayPl2 = $weekDaysPL[5];
    } elseif($currentDayOfWeek == 6) {
        $weekDayPl2 = $weekDaysPL[6];
    } else {
        $weekDayPl2 = "Nieznany dzień";
    }
    
    $monthPL2 = ($currentMonth >= 1 && $currentMonth <= 12) 
                ? $monthsPL[$currentMonth - 1] 
                : "Nieznany miesiąc";
    
    echo "Dzisiejsza data to: <br>" . $weekDayPl2 . ", " . $currentDay . " " . $monthPL2 . " " . $currentYear;
    ?>

    <br><br><br><br>

    <h3>Switch case</h3>
    <?php
    switch($currentDayOfWeek) {
        case 0:
            $weekDayPl3 = $weekDaysPL[0];
            break;
        case 1:
            $weekDayPl3 = $weekDaysPL[1];
            break;
        case 2:
            $weekDayPl3 = $weekDaysPL[2];
            break;
        case 3:
            $weekDayPl3 = $weekDaysPL[3];
            break;
        case 4:
            $weekDayPl3 = $weekDaysPL[4];
            break;
        case 5:
            $weekDayPl3 = $weekDaysPL[5];
            break;
        case 6:
            $weekDayPl3 = $weekDaysPL[6];
            break;
        default:
            $weekDayPl3 = "Nieznany dzień";
    }
    
    switch($currentMonth) {
        case 1: $monthPL3 = $monthsPL[0]; break;
        case 2: $monthPL3 = $monthsPL[1]; break;
        case 3: $monthPL3 = $monthsPL[2]; break;
        case 4: $monthPL3 = $monthsPL[3]; break;
        case 5: $monthPL3 = $monthsPL[4]; break;
        case 6: $monthPL3 = $monthsPL[5]; break;
        case 7: $monthPL3 = $monthsPL[6]; break;
        case 8: $monthPL3 = $monthsPL[7]; break;
        case 9: $monthPL3 = $monthsPL[8]; break;
        case 10: $monthPL3 = $monthsPL[9]; break;
        case 11: $monthPL3 = $monthsPL[10]; break;
        case 12: $monthPL3 = $monthsPL[11]; break;
        default: $monthPL3 = "Nieznany miesiąc";
    }
    
    echo "Dzisiejsza data to: <br>" . $weekDayPl3 . ", " . $currentDay . " " . $monthPL3 . " " . $currentYear;
    ?>

    <br><br><br><br>

    <h3>Match</h3>
    <?php
    $weekDayPl4 = match($currentDayOfWeek) {
        0 => $weekDaysPL[0],
        1 => $weekDaysPL[1],
        2 => $weekDaysPL[2],
        3 => $weekDaysPL[3],
        4 => $weekDaysPL[4],
        5 => $weekDaysPL[5],
        6 => $weekDaysPL[6],
        default => "Nieznany dzień"
    };
    
    $monthPL4 = match($currentMonth) {
        1 => $monthsPL[0],
        2 => $monthsPL[1],
        3 => $monthsPL[2],
        4 => $monthsPL[3],
        5 => $monthsPL[4],
        6 => $monthsPL[5],
        7 => $monthsPL[6],
        8 => $monthsPL[7],
        9 => $monthsPL[8],
        10 => $monthsPL[9],
        11 => $monthsPL[10],
        12 => $monthsPL[11],
        default => "Nieznany miesiąc"
    };
    
    echo "Dzisiejsza data to: <br>" . $weekDayPl4 . ", " . $currentDay . " " . $monthPL4 . " " . $currentYear;
    ?>

    <?php echo phpversion(); ?>
    <br><br><br><br>

    <h3>Instrukcja warunkowa prosta if</h3>
    <?php
        $weekDayPl5 = "Nieznany dzień";
        $monthPL5 = "Nieznany miesiąc";
        
        if($currentDayOfWeek == 0) $weekDayPl5 = $weekDaysPL[0];
        if($currentDayOfWeek == 1) $weekDayPl5 = $weekDaysPL[1];
        if($currentDayOfWeek == 2) $weekDayPl5 = $weekDaysPL[2];
        if($currentDayOfWeek == 3) $weekDayPl5 = $weekDaysPL[3];
        if($currentDayOfWeek == 4) $weekDayPl5 = $weekDaysPL[4];
        if($currentDayOfWeek == 5) $weekDayPl5 = $weekDaysPL[5];
        if($currentDayOfWeek == 6) $weekDayPl5 = $weekDaysPL[6];
        
        if($currentMonth == 1) $monthPL5 = $monthsPL[0];
        if($currentMonth == 2) $monthPL5 = $monthsPL[1];
        if($currentMonth == 3) $monthPL5 = $monthsPL[2];
        if($currentMonth == 4) $monthPL5 = $monthsPL[3];
        if($currentMonth == 5) $monthPL5 = $monthsPL[4];
        if($currentMonth == 6) $monthPL5 = $monthsPL[5];
        if($currentMonth == 7) $monthPL5 = $monthsPL[6];
        if($currentMonth == 8) $monthPL5 = $monthsPL[7];
        if($currentMonth == 9) $monthPL5 = $monthsPL[8];
        if($currentMonth == 10) $monthPL5 = $monthsPL[9];
        if($currentMonth == 11) $monthPL5 = $monthsPL[10];
        if($currentMonth == 12) $monthPL5 = $monthsPL[11];
        
        echo "Dzisiejsza data to: <br>" . $weekDayPl5 . ", " . $currentDay . " " . $monthPL5 . " " . $currentYear;
    ?>

    <br><br><br><br>

    
</body>
</html>
