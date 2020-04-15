<?php
    if (isset($_GET['logout']))
    {
        session_destroy();
        session_unset();
        header('Location: logowanie.php');
    }
?>