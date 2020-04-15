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
    header('Location: promocje.php');
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
    header('Location: promocje.php');
}
?>

<html lang="pl-PL">

<head>
<title>eShop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="mdboostrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="fontawesome/css/all.css" rel="stylesheet">
    <link href="mdboostrap/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="mdboostrap/js/jquery-3.4.0.min.js"></script>
    <script type="text/javascript" src="mdboostrap/js/popper.min.js"></script>
    <script type="text/javascript" src="mdboostrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="mdboostrap/js/popper.min.js"></script>

    <script src="sc.js"></script>
    <link rel="stylessheet" href="przedmioty.css">
    

    <style>
        .carousel-inner img {
            width: 100%;
            height: 100%;
        }
    </style>
    <style>
        .badge-notify {
            background: red;
            position: relative;
            top: -20px;
            right: 10px;
        }

        .my-cart-icon-affix {
            position: fixed;
            z-index: 999;
        }
    </style>
    <style>
        .buttons {
            margin-left: auto;
            margin-right: auto;
        }

        .gallery-title {
            font-size: 36px;
            color: #42B32F;
            text-align: center;
            font-weight: 500;
            margin-bottom: 70px;
        }

        .gallery-title:after {
            content: "";
            position: absolute;
            width: 7.5%;
            left: 46.5%;
            height: 45px;
            border-bottom: 1px solid #5e5e5e;
        }

        .filter-button {
            font-size: 18px;
            border: 1px solid #42B32F;
            border-radius: 5px;
            text-align: center;
            color: white;
            margin-bottom: 30px;

        }

        .filter-button:hover {
            font-size: 18px;
            border: 1px solid #42B32F;
            border-radius: 5px;
            text-align: center;
            color: red;
            background-color: #42B32F;

        }

        .btn-default:active .filter-button:active {
            background-color: #42B32F;
            color: white;
        }

        .port-image {
            width: 100%;
        }

        .card {
            margin-bottom: 30px;
        }
        .btn {
            white-space: nowrap;
            text-align: center;
        }
        #foot {
            
  position: fixed;
  bottom: 0;
  width: 100%;
 
  

        } 
    </style>




</head>

<body id="myPage">

    
<header>
        <nav class="navbar fixed-top navbar-dark bg-dark navbar-expand-lg justify-content-between">
            <button class="navbar-toggler order-2" type="button" data-toggle="collapse" data-target="#navbar-list-9"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse w-100 order-3 order-lg-1" id="navbar-list-9">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-tv"></i><b><i>eShop</i></b><span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="asortyment.php"><i class="fas fa-memory"></i>Asortyment</a>
                    <li class="nav-item active">
                        <a class="nav-link" href="promocje.php"><i class="fas fa-percent"></i>Promocje</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="zestaw.php"><i class="fas fa-plus"></i>Stwórz Zestaw</a>
                    </li>
                    <?php if ($_SESSION['uzytkownik']=='admin'){
                        echo '<li class="nav-item">
                        <a class="nav-link" href="paneladministratora.php"><i class="fas fa-user-cog"></i>Panel administratora</a>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="navbar-brand mx-lg-0 order-3 order-lg-3 href=#">
                    <button class="wyloguj btn btn-success">
                    <?php 
                    if (isset($_SESSION['uzytkownik']))
                    {
                        echo $_SESSION['uzytkownik'];
                    }
                    else echo "Nie jesteś zalogowany";
                    ?></button>
                
            </div>
            <form style="margin-top: 20px; width: 500px;" class="navbar-brand mx-lg-0 order-1 order-lg-2">
            <input class="form-control" id="myInput" type="text" placeholder="Szukaj produktów...">
            </form>
            <a class="navbar-brand mx-lg-0 order-4 order-lg-4" href="#tabble">
                <button type="button" class="btn peach-gradient"><i class="fas fa-shopping-cart"></i> 
                <?php
                    if (!empty($_SESSION['cart'])) {
                        $total = 0;
                        $quan = 0;
                        foreach($_SESSION['cart'] as $key => $produkt)
                        {
                            $total = $total + ($produkt['quantity']*$produkt['cena']);
                            $quan = $quan + $produkt['quantity'];
                        }
                        echo $total . " " . "zł";
                    }
                    else {
                        $total = 0;
                        $quan = 0;
                        echo $total . " " . "zł";
                    }
                ?>
                <span class="badge badge-primary badge-pill"><?php echo $quan?></span></button>
                
            </a>
            

        </nav>
    </header>

        <main>
            <br><br><br><br>
            
            <div class="container" style="width:100%; margin-top: 20px" class="col 12">
            <div class="row">
            <button id="all" class="col btn-default btn-sm filter-button" data-filter="all">Wszystko</button>
            <button id="kartygraficzne" class="col btn-default btn-sm filter-button" data-filter="kartygraficzne">Karty Graficzne</button>
            <button id="procesory" class="col btn-default btn-sm  filter-button" data-filter="procesory">Procesory</button>
            <button id="plytyglowne" class="col btn-default btn-sm  filter-button" data-filter="plytyglowne">Płyty Główne</button>
            <button id="smartphone" class="col btn-default btn-sm filter-button" data-filter="smartphone">Smartfony</button>
            <button id="kierownice" class="col btn-default btn-sm filter-button" data-filter="laptopy">Laptopy</button>
            </div>
            <div class="row" style="margin-top: -28px;">
            <button id="smartphone" class="col btn-default btn-sm filter-button" data-filter="smartphone">SmartPhony</button>
            <button id="laptopy" class="col btn-default btn-sm filter-button" data-filter="laptopy">Laptopy</button>
            <button id="akcesoria" class="col btn-default btn-sm filter-button" data-filter="akcesoria">Akcesoria</button>
            <button id="kamery" class="col btn-default btn-sm filter-button" data-filter="kamery">Foto i Kamery</button>
            <button id="strefagracza" class="col btn-default btn-sm filter-button" data-filter="strefagracza">Strefa Gracza</button>
            <button id="inne" class="col  btn-default btn-sm filter-button" data-filter="inne">Inne</button>

            </div>

            
            
            
             </div>            
             <div class="container">
             
            <div class="row">
                <?php
                    $connect = mysqli_connect('localhost','root','','uorder');
                    $query = 'Select * from promocje';
                    $result = mysqli_query($connect,$query);
                    if ($result):
                        if (mysqli_num_rows($result)>0):
                            while($produkt = mysqli_fetch_assoc($result)):
                                ?>
                



                    <div class="card col-lg-6 col-md-3 col-sm-2 col-xs-2 filter <?php echo $produkt['filter']?>">
                        <form method="post" action="promocje.php?action=add&id=<?php echo $produkt['id_produktu'];?>">

                            <div class="products">
                                <input type="image" style="card-img-top mh200-text" class="img-responsive" src="discount/<?php echo $produkt['zdjecie'];?>"/>
                                <h4 class="card-title mw30-text produkt-info"><?php echo $produkt['nazwa_produktu'];?></h4>
                                <h5 class="font"><s><?php echo round($produkt['cena']*1.15,2)?> zł</s></h5>
                                <h2 class="font"><?php echo $produkt['cena'];?> zł</h2>
                                <input style="margin-right:auto; width:80px;" type="number" name="quantity"
                                    class="form-control" min="1" value="1" />
                                <input type="hidden" name="nazwa_produktu"
                                    value="<?php echo $produkt['nazwa_produktu'];?>" />
                                <input type="hidden" name="cena" value="<?php echo $produkt['cena'];?>" />
                                <input type="submit" name="koszyk" class="btn btn-outline-success"
                                    value="Dodaj do koszyka" />
                                <input type="hidden" name="zdjecie" value="discount/<?php echo $produkt['zdjecie'];?>"/>
                            </div>
                        </form>
                    </div>
                    

                    <?php
                    endwhile;
                endif;
            endif;
            ?>
            </div>
        </div>
            
        
            <div style="clear:both"></div>
            <br>
            <div id="tabble" class="table-striped table-responsive" style="width:100%; text-align:left;">
                <table class="table">
                    <?php
                    if (isset($_SESSION['cart'])):
                    if (count($_SESSION['cart'])>0):
                    ?>
                        <thead class="thead-dark">
                        <th colspan="6">
                            <h3 style="font-size: 34px;">Szczegóły Zamówienia</h3>
                        </th>
                 </thead>
                    <tr>
                        <th width="20%" style="font-size: 20px;">Produkt</th>
                        <th width="40%" style="font-size: 20px;">Nazwa Produktu</th>
                        <th width="10%"style="font-size: 20px;">Ilość</th>
                        <th width="10%"style="font-size: 20px;">Cena</th>
                        <th width="15%"style="font-size: 20px;">Wartość Zamówienia</th>
                        <th width="5%"style="font-size: 20px;"></th>
                    </tr>
                    <?php
            if (!empty($_SESSION['cart'])):
                $total = 0;
                $quan = 0;
                
                foreach($_SESSION['cart'] as $key => $produkt):
            
        ?>
                    <tr>
                        <th><img style="width:100px; height:100px;" src="<?php echo $produkt['zdjecie'];?>"/></th> 
                        <th><h5 class="font"><?php echo $produkt['nazwa_produktu'];?></h5></th>
                        <th><h5 class="font"><?php echo $produkt['quantity'];?></h5></th>
                        <th><h5 class="font"><?php echo $produkt['cena'];?> zł</h5></th>
                        <th><h5 class="font"><?php echo number_format($produkt['quantity']*$produkt['cena'],2);?> zł</h5></th>
                        <th>
                            <a href="promocje.php?action=delete&id=<?php echo $produkt['id'];?>">
                            <div class="btn btn-danger"><i class="fas fa-trash"></i> Usuń</div>
                            </a>
                        </th>
                    </tr>
                    <?php 
            $total = $total + ($produkt['quantity']*$produkt['cena']);
            $quan = $quan + $produkt['quantity'];
        endforeach;
        ?>
                    <tr>
                        <th colspan="2" style="align:right;"><h5 class="font">Suma</h5></td>
                        <th><h5 class="font"><?php echo $quan?></h5></th>
                        <th></td>
                        <th style="align:right;"> <h5 class="font"><?php echo number_format($total,2);?> zł</h5></td>
                        <th></td>
                        
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align:right;">
                            <?php 
                    
                ?>
                            <a href="validator.php?platnosc" class="btn btn-danger">Przejdź do Zamówienia</a>
                           
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php endif; endif; ?>
                </table>
            </div>
    </div>

    </main>


<br>


<footer id="foot"
    class="page-footer sticky-bottom font-small stylish-color-dark pt-4" style="margin-bottom: -16px;">

    
    <div class="container text-center text-md-left">

        
        <div class="row">

            
            <div class="col-md-4 mx-auto">

                
                <h5 class="font-weight-bold text-uppercase mt-3 mb-4">eShop S.A.</h5>
                <p>ul. Leśna 29, 30-232 Kraków tel. 111 222 333 </p>

            </div>
            

            <hr class="clearfix w-100 d-md-none">

            
            <div class="col-md-2 mx-auto">

                
                <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Informacje</h5>

                <ul class="list-unstyled">
                    <li>
                        <a href="#!">Pomoc</a>
                    </li>
                    <li>
                        <a href="rejestracja.html"></a>
                    </li>
                    <li>
                        <a href="#!">Regulamin</a>
                    </li>
                    <li>
                        <a href="#!">Polityka prywatności</a>
                    </li>
                </ul>

            </div>
            

            <hr class="clearfix w-100 d-md-none">

            
            <div class="col-md-2 mx-auto">

                
                <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Sklep</h5>

                <ul class="list-unstyled">
                    <li>
                        Serwis - Reklamacje
                    </li>
                    <li>
                        <a href="#!">Zwroty towarów</a>
                    </li>
                    <li>
                        <a href="#!">Kontakt</a>
                    </li>
                    <li>
                        <a href="#!">Promocje</a>
                    </li>
                </ul>

            </div>
            

            <hr class="clearfix w-100 d-md-none">

            
            <div class="col-md-2 mx-auto">

                
                <h5 class="font-weight-bold text-uppercase mt-3 mb-4">O nas</h5>

                <ul class="list-unstyled">
                    <li>
                        <a href="#!">Aktualności</a>
                    </li>
                    <li>
                        <a href="#!">Galeria</a>
                    </li>
                    <li>
                        <a href="#!">Współpraca</a>
                    </li>
                    <li>
                        <a href="#!">Grupa eShop</a>
                    </li>
                </ul>

            </div>
            

        </div>
        

    </div>
    



    
    <ul class="list-unstyled list-inline text-center">
        <li class="list-inline-item">
            <a class="btn-floating btn-fb mx-1">
                <i class="fab fa-facebook-f fa-2x"> </i>
            </a>
        </li>
        <li class="list-inline-item">
            <a class="btn-floating btn-tw mx-1">
                <i class="fab fa-twitter fa-2x"> </i>
            </a>
        </li>
        <li class="list-inline-item">
            <a class="btn-floating btn-gplus mx-1">
                <i class="fab fa-google-plus-g fa-2x"> </i>
            </a>
        </li>
        <li class="list-inline-item">
            <a class="btn-floating btn-li mx-1">
                <i class="fab fa-linkedin-in fa-2x"> </i>
            </a>
        </li>
        <li class="list-inline-item">
            <a class="btn-floating btn-dribbble mx-1">
                <i class="fab fa-dribbble fa-2x"> </i>
            </a>
        </li>
    </ul>
    
    <div class="footer-copyright text-center py-3">
        <a href="#myPage" title="To Top">
            <i class="fas fa-arrow-up fa-2x"></i>
            <br>
        </a>
        © 2019 Copyright: Daniel Partyka
    </div>
    

</footer>


</body>

</html>