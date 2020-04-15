<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$products_id = array();
if (filter_input(INPUT_POST,'koszyk'))
{
    if (isset($_SESSION['cart']))
    {
        $count = count($_SESSION['cart']);
        $products_id = array_column($_SESSION['cart'],'id');
        if (!in_array(filter_input(INPUT_GET,'id'), $products_id))
        {
            
            $_SESSION['cart'][$count] = array
            (
            'id' => filter_input(INPUT_GET, 'id'),
            'nazwa_produktu' => filter_input(INPUT_POST, 'nazwa_produktu'),
            'cena' => filter_input(INPUT_POST, 'cena'),
            'quantity' => filter_input(INPUT_POST, 'quantity'),
            'zdjecie' => filter_input(INPUT_POST,'zdjecie'),
           
            );
        }
        else{
            for ($i=0;$i<count($products_id);$i++)
            {
                if ($products_id[$i]==filter_input(INPUT_GET,'id'))
                {
                    $_SESSION['cart'][$i]['quantity'] += filter_input(INPUT_POST,'quantity');
                }
            }
        }
    }
    else{
        $_SESSION['cart'][0] = array
        (
            'id' => filter_input(INPUT_GET, 'id'),
            'nazwa_produktu' => filter_input(INPUT_POST, 'nazwa_produktu'),
            'cena' => filter_input(INPUT_POST, 'cena'),
            'quantity' => filter_input(INPUT_POST, 'quantity'),
            'zdjecie' => filter_input(INPUT_POST,'zdjecie'),
            

        );
    }
    header('Location: platnosc.php');
}
if (filter_input(INPUT_GET,'action') == 'delete')
{
    foreach($_SESSION['cart'] as $key => $produkt)
    {
        if ($produkt['id'] == filter_input(INPUT_GET,'id'))
        {
            unset($_SESSION['cart'][$key]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header('Location: platnosc.php');
}