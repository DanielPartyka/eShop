<?php
    if (isset($_POST['submit']))
    {
        $conn = mysqli_connect('localhost','root','','uorder');
        if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
        }
        $newname = $_POST['nazwa_produktu'];
        $price = $_POST['cena'];
        $src = $_POST['sciezka'];
        $fil = $_POST['filter'];
        $insert = "INSERT INTO PRODUKTY(nazwa_produktu,cena,zdjecie,filter) VALUES ('$newname','$price','$src','$fil')";
        mysqli_query($conn,$insert);
        mysqli_close($conn);
        header('Location: paneladministratora.php');
    }


?>