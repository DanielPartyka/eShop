<?php
    if (isset($_GET['platnosc']))
    {
        if (isset($_SESSION['uzytkownik']))
        {
            header('Location: platnosc.php');
        }
        else {
            header('Location: logowanie.php');
        }
    }

?>