<?php
$conn = mysqli_connect('localhost','root','','uorder');

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
    if (isset($_POST['sub']))
    {
        
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $email = $_POST['email'];
        $miasto = $_POST['miasto'];
        $kodpocztowy = $_POST['kodpocztowy'];
        $insertzamowienie = "INSERT INTO zamowienie(email_zamawiajacego) values ('$email')";
        mysqli_query($conn,$insertzamowienie);
        $selectid = "SELECT id_zamowienia from zamowienie where email_zamawiajacego='$email'";
        $result = mysqli_query($conn,$selectid);
        $id = mysqli_fetch_assoc($result);
        $idzamowienia = $id['id_zamowienia'];
        mysqli_query($conn,$insertdata);
        foreach($_SESSION['cart'] as $key => $produkt)
        {
            $idp = $produkt['id'];
            $sqllq = "SELECT id_produktu from produkty where id_produktu='$idp'";
            $query = mysqli_query($conn,$sqllq);
            $idq = mysqli_fetch_assoc($query);
            $idins = $idq['id_produktu'];
            $inspr = "INSERT INTO zamowienie_produkty(id_zamowienia,id_produktu) values ('$idzamowienia','$idins')";
            mysqli_query($conn,$inspr);
        }
        $insertdane = "INSERT INTO dane_zamawiajacego(id_zamowienia,imie,nazwisko,miasto,kod_pocztowy) values ('$idzamowienia','$imie','$nazwisko','$miasto','$kodpocztowy')";
        mysqli_query($conn,$insertdane);
        
        foreach($_SESSION['cart'] as $key => $produkt)
        {
            unset($_SESSION['cart'][$key]);
        }
        mysqli_close($conn);
        header('Location: index.php');
    }    
    
        

    
?>