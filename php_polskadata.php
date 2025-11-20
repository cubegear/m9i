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

    <br><br>


    <?php
        $weekDaysPL = ["Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota", "Niedziela"];
        $monthsPL = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];


        if(date("w") == 1) $weekDayPl = $weekDaysPL[0];
        elseif(date("w") == 2) $weekDayPl = $weekDaysPL[1];
        elseif(date("w") == 3) $weekDayPl = $weekDaysPL[2];
        elseif(date("w") == 4) $weekDayPl = $weekDaysPL[3];
        elseif(date("w") == 5) $weekDayPl = $weekDaysPL[4];
        elseif(date("w") == 6) $weekDayPl = $weekDaysPL[5];
        elseif(date("w") == 7) $weekDayPl = $weekDaysPL[6];



        switch (date("m")) {
            case 1: 
                $monthPL = $monthsPL[0];
                break;
            case 2:
                $monthPL = $monthsPL[1];
                break;
            case 3:
                $monthPL = $monthsPL[2];
                break;
            case 4:
                $monthPL = $monthsPL[3];
                break;
            case 5:
                $monthPL = $monthsPL[4];
                break;
            case 6:
                $monthPL = $monthsPL[5];
                break;
            case 7:
                $monthPL = $monthsPL[6];
                break;
            case 8:
                $monthPL = $monthsPL[7];
                break;
            case 9:
                $monthPL = $monthsPL[8];
                break;
            case 10:
                $monthPL = $monthsPL[9];
                break;
            case 11:
                $monthPL = $monthsPL[10];
                break;
            case 12:
                $monthPL = $monthsPL[11];
                break;
            default:
                $monthPL = "Nieznany";
        }


        echo ("Dzisiejsza data to: <br> $weekDayPl " . date("d") . " $monthPL " . date("Y"));

        

    ?>

</body>
</html>