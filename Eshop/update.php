<?php
if (isset($_POST['modify']))
    {
        $conn = mysqli_connect('localhost','root','','uorder');

        if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
        }
        $newid = $_POST['id_produktu'];
        $newname = $_POST['nazwa_produktu'];
        $c = $_POST['cena'];
        $src = $_POST['sciezkadp'];
        $f = $_POST['filter'];
        $update = "UPDATE produkty SET nazwa_produktu = '$newname', cena = '$c' , zdjecie = '$src' , filter = '$f' WHERE id_produktu = $newid";
        mysqli_query($conn,$update);
        mysqli_close($conn);
        header('Location: paneladministratora.php');
    }
    else{
        $conn = mysqli_connect('localhost','root','','uorder');

        if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
        }
        $needid = $_POST['id_produktu'];
        $delete = "DELETE FROM PRODUKTY WHERE id_produktu='$needid'";
        mysqli_query($conn,$delete);
        mysqli_close($conn);
        header('Location: paneladministratora.php');
    }
?>