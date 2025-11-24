<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	
	<title>PHP - instrukcje sterujące</title>

    <script>
    </script>

    <style>

    </style>

</head>
<body>
    <h1>PHP - Ćwiczenie</h1>

    <h3>Ćwiczenie: php_instrukcjesterujące</h3>


    <div>
        Proszę napisać skrypt, pobierający z formularza imię i nazwisko, a następnie sprawdzający 
        czy: wpisy są puste, czy są liczbami. Jeżeli są znakami literowymi, skrypt poniżej pokazuje 
        na ekranie wpisane imię i nazwisko. Również powinien pojawić się komunikat o pustych 
        polach formularza oraz o tym, że nie są znakami tekstowymi (literowymi)
    </div>

    <br><br>

    <div>
        Ćwiczenie należy wykonać różnymi metodami (min 1 poprawna), używając instrukcji 
        warunkowych. Czas wykonania ok.30', waga 2.
    </div>

    <br><br><br><br>

    <br><br>

    <h3>Insturckja warunkowa if...else...</h3>
    <form action="" method="POST">
        <label for="imie1">Imię: </label>
        <input type="text" name="imie1" placeholder="Imię">
        <br>
        <label for="nazwisko1">Nazwisko: </label>
        <input type="text" name="nazwisko1" placeholder="Nazwisko">
        <br>
        <input type="submit">
    </form>
 

    <?php
        // insturckja warunkowa if...else...
        if(isset($_POST['imie1']) && isset($_POST['nazwisko1'])) {
            if(empty($_POST['imie1']) && empty($_POST['nazwisko1'])) {
                echo("Oba pola są puste, należy je uzupełnić!!!");
            } else {
                if(empty($_POST['imie1'])) {
                    echo("Pole Imie jest puste, należy je uzupełnić!!!");
                }

                if(empty($_POST['nazwisko1'])) {
                    echo("Pole Nazwisko jest puste, należy je uzupełnić!!!");
                }
            }

            if(!empty($_POST['imie1']) && !empty($_POST['nazwisko1'])) {
                $imie = $_POST['imie1'];
                $nazwisko = $_POST['nazwisko1'];
                if(preg_match('/\d/', $imie) || preg_match('/\d/', $nazwisko)) {
                    if(preg_match('/\d/', $imie) && preg_match('/\d/', $nazwisko)) {
                        echo("Wpisy nie mogą zawierać liczb!!!");
                    } else {
                        if(preg_match('/\d/', $imie)) {
                            echo("Wpis Imie nie może zawierać liczb!!!");
                        }

                        if(preg_match('/\d/', $nazwisko)) {
                            echo("Wpis Nazwisko nie może zawierać liczb!!!");
                        }       
                    }
                } else {
                    echo("Imię: $imie <br> Nazwisko: $nazwisko");
                }     
            }           
        }
    ?>

    <br><br>

    <h3>Insturckja warunkowa if...elseif...</h3>
    <form action="" method="POST">
        <label for="imie2">Imię: </label>
        <input type="text" name="imie2" placeholder="Imię">
        <br>
        <label for="nazwisko2">Nazwisko: </label>
        <input type="text" name="nazwisko2" placeholder="Nazwisko">
        <br>
        <input type="submit">
    </form>
 

    <?php

        // insturckja warunkowa if...elseif...
        if(isset($_POST['imie2']) && isset($_POST['nazwisko2'])) {
            if(empty($_POST['imie2']) && empty($_POST['nazwisko2'])) {
                echo("Oba pola są puste, należy je uzupełnić!!!");
            } elseif(empty($_POST['imie2'])) {
                echo("Pole Imie jest puste, należy je uzupełnić!!!");
            } elseif(empty($_POST['nazwisko2'])) {
                echo("Pole Nazwisko jest puste, należy je uzupełnić!!!");
            }

            if(!empty($_POST['imie2']) && !empty($_POST['nazwisko2'])) {
                $imie = $_POST['imie2'];
                $nazwisko = $_POST['nazwisko2'];
                if(preg_match('/\d/', $imie) || preg_match('/\d/', $nazwisko)) {
                    if(preg_match('/\d/', $imie) && preg_match('/\d/', $nazwisko)) {
                        echo("Wpisy nie mogą zawierać liczb!!!");
                    } elseif(preg_match('/\d/', $imie)) {
                        echo("Wpis Imie nie może zawierać liczb!!!");    
                    } elseif(preg_match('/\d/', $nazwisko)) {
                        echo("Wpis Nazwisko nie może zawierać liczb!!!");
                    }
                } else {
                    echo("Imię: $imie <br> Nazwisko: $nazwisko");
                }     
            }           
        }
    ?>

    <br><br>

    <h3>Insturckja warunkowa switch...case</h3>
    <form action="" method="POST">
        <label for="imie3">Imię: </label>
        <input type="text" name="imie3" placeholder="Imię">
        <br>
        <label for="nazwisko3">Nazwisko: </label>
        <input type="text" name="nazwisko3" placeholder="Nazwisko">
        <br>
        <input type="submit">
    </form>
 

    <?php
        //insturckja warunkowa switch...case

        switch(isset($_POST['imie3']) && isset($_POST['nazwisko3'])) {
            case true:
                switch(empty($_POST['imie3']) && empty($_POST['nazwisko3'])) {
                    case true;
                        echo("Oba pola są puste, należy je uzupełnić!!!");
                        break;

                    case false;
                        switch(empty($_POST['imie3'])) {
                            case true:
                                echo("Pole Imie jest puste, należy je uzupełnić!!!");
                                break;

                            case false:
                                switch (empty($_POST['nazwisko3'])) {
                                    case true:
                                        echo("Pole Nazwisko jest puste, należy je uzupełnić!!!");
                                        break;

                                    case false:
                                        $imie = $_POST['imie3'];
                                        $nazwisko = $_POST['nazwisko3'];

                                        switch(preg_match('/\d/', $imie) && preg_match('/\d/', $nazwisko)) {
                                            case true:
                                                echo("Wpisy nie mogą zawierać liczb!!!");
                                                break;

                                            case false:
                                                switch(preg_match('/\d/', $imie)) {
                                                    case true:
                                                        echo("Wpis Imie nie może zawierać liczb!!!");
                                                        break;

                                                    case false:
                                                        switch(preg_match('/\d/', $nazwisko)) {
                                                            case true:
                                                                echo("Wpis Nazwisko nie może zawierać liczb!!!");
                                                                break;

                                                            case false:
                                                                echo("Imię: $imie <br> Nazwisko: $nazwisko");
                                                                break;
                                                        }
                                                        break;
                                                }
                                                break;
                                        }
                                        break;
                                }
                                break;
                        }
                        break;
                }
                break;

            case false:
                break;
        }

    ?>

    <br><br>


    <h3>Insturckja warunkowa prosta if...</h3>
    <form action="" method="POST">
        <label for="imie">Imię: </label>
        <input type="text" name="imie" placeholder="Imię">
        <br>
        <label for="nazwisko">Nazwisko: </label>
        <input type="text" name="nazwisko" placeholder="Nazwisko">
        <br>
        <input type="submit">
    </form>
 
    
    <?php
        // insturckja warunkowa prosta if...

        if(isset($_POST['imie']) && isset($_POST['nazwisko'])) {
            if(empty($_POST['imie']) && empty($_POST['nazwisko'])) {
                echo("Oba pola są puste, należy je uzupełnić!!!");
            }

            if(!(empty($_POST['imie']) && empty($_POST['nazwisko']))) {
                if(empty($_POST['imie'])) {
                    echo("Pole Imie jest puste, należy je uzupełnić!!!");
                }

                if(empty($_POST['nazwisko'])) {
                    echo("Pole Nazwisko jest puste, należy je uzupełnić!!!");
                }
                
            }
        
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            
            if(preg_match('/\d/', $imie) && preg_match('/\d/', $nazwisko)) {
                echo("Wpisy nie mogą zawierać liczb!!!");
            }

            if(!(preg_match('/\d/', $imie) && preg_match('/\d/', $nazwisko))) {
                if(preg_match('/\d/', $imie)) {
                    echo("Wpis Imie nie może zawierać liczb!!!");
                }

                if(preg_match('/\d/', $nazwisko)) {
                    echo("Wpis Nazwisko nie może zawierać liczb!!!");
                }
            }

            if((!empty($_POST['imie']) && !empty($_POST['nazwisko'])) && (!preg_match('/\d/', $imie) && !preg_match('/\d/', $nazwisko))) {
                echo("Imię: $imie <br> Nazwisko: $nazwisko");
            }           
        }
    ?>


    
</body>
</html>