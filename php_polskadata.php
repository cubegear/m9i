<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	
	<title>Data</title>

    <script>
    </script>

</head>
<body>
    

    <h1>Data</h1>

    <div>
        Napisać skrypt, zamieniający nazwy dni tygodnia w dacie z 
        angielskich na polskie, wykorzystując: instrukcje warunkowe 
        proste, instrukcję switch...case oraz tablice. Data bieżąca: nazwa 
        dnia tygodnia, nr dnia, nazwa miesąca i pełny rok.
        Nazwa ćwiczenia: js_polskadata, waga ćwiczenia: 3, czas na 
        wykonanie 25'.
    </div>

    <br><br><br>


    <?php
        //instrukcja warunkowa prosta if

        $weekDaysPL = ["Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota", "Niedziela"];
        $monthsPL = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];


        if(date("w") == 1) $weekDayPl1 = $weekDaysPL[0];
        if(date("w") == 2) $weekDayPl1 = $weekDaysPL[1];
        if(date("w") == 3) $weekDayPl1 = $weekDaysPL[2];
        if(date("w") == 4) $weekDayPl1 = $weekDaysPL[3];
        if(date("w") == 5) $weekDayPl1 = $weekDaysPL[4];
        if(date("w") == 6) $weekDayPl1 = $weekDaysPL[5];
        if(date("w") == 7) $weekDayPl1 = $weekDaysPL[6];



        if(date("m") == 1) $monthPL1 = $monthsPL[0];
        if(date("m") == 2) $monthPL1 = $monthsPL[1];
        if(date("m") == 3) $monthPL1 = $monthsPL[2];
        if(date("m") == 4) $monthPL1 = $monthsPL[3];
        if(date("m") == 5) $monthPL1 = $monthsPL[4];
        if(date("m") == 6) $monthPL1 = $monthsPL[5];
        if(date("m") == 7) $monthPL1 = $monthsPL[6];
        if(date("m") == 8) $monthPL1 = $monthsPL[7];
        if(date("m") == 9) $monthPL1 = $monthsPL[8];
        if(date("m") == 10) $monthPL1 = $monthsPL[9];
        if(date("m") == 11) $monthPL1 = $monthsPL[10];
        if(date("m") == 12) $monthPL1 = $monthsPL[11];


        echo ("Dzisiejsza data to: <br> $weekDayPl1 " . date("d") . " $monthPL1 " . date("Y"));
    ?>

    <br><br><br><br>

        <?php
        //instrukcja switch...case

        switch(date("w")) {
            case 1:
                $weekDayPl2 = $weekDaysPL[0];
                break;
            case 2:
                $weekDayPl2 = $weekDaysPL[1];
                break;
            case 3:
                $weekDayPl2 = $weekDaysPL[2];
                break;
            case 4:
                $weekDayPl2 = $weekDaysPL[3];
                break;
            case 5:
                $weekDayPl2 = $weekDaysPL[4];
                break;
            case 6:
                $weekDayPl2 = $weekDaysPL[5];
                break;
            case 7:
                $weekDayPl2 = $weekDaysPL[6];
                break;
            default:
                $monthPL2 = "Nieznany";  
        }

        switch (date("m")) {
            case 1: 
                $monthPL2 = $monthsPL[0];
                break;
            case 2:
                $monthPL2 = $monthsPL[1];
                break;
            case 3:
                $monthPL2 = $monthsPL[2];
                break;
            case 4:
                $monthPL2 = $monthsPL[3];
                break;
            case 5:
                $monthPL2 = $monthsPL[4];
                break;
            case 6:
                $monthPL2 = $monthsPL[5];
                break;
            case 7:
                $monthPL2 = $monthsPL[6];
                break;
            case 8:
                $monthPL2 = $monthsPL[7];
                break;
            case 9:
                $monthPL2 = $monthsPL[8];
                break;
            case 10:
                $monthPL2 = $monthsPL[9];
                break;
            case 11:
                $monthPL2 = $monthsPL[10];
                break;
            case 12:
                $monthPL2 = $monthsPL[11];
                break;
            default:
                $monthPL2 = "Nieznany";
        }


        echo ("Dzisiejsza data to: <br> $weekDayPl2 " . date("d") . " $monthPL2 " . date("Y"));
    ?>

</body>
</html>
