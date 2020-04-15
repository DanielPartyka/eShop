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
    }
?>
<!DOCTYPE HTML>
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
        
    
<style>
        .carousel-inner img {
            width: 100%;
            height: 100%;
        }
        .btn {
            white-space: nowrap;
            text-align: center;
        }

        .navbar-brand
        {
            position:relative;
        }
        
        .wyloguj:hover span{
            display:none;
        }
        .wyloguj:hover:before{
            content: "Wyloguj się z konta";
        }
    </style>



</head>

<body id="myPage">
    
<header>
        <nav class="navbar fixed-top navbar-dark bg-dark navbar-expand-lg justify-content-between">
            <button class="navbar-toggler order-2" type="button" data-toggle="collapse" data-target="#navbar1"
                aria-controls="navbarl" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse w-100 order-3 order-lg-1" id="navbar1">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php"><i class="fas fa-tv"></i><b><i>eShop</i></b><span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="asortyment.php"><i class="fas fa-memory"></i>Asortyment</a>
                    <li class="nav-item">
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
            <div class="navbar-brand mx-lg-0 order-2 order-lg-2 href=#">
                <a href="logout.php?logout" data-hover="Wyloguj się">
                    <?php
                    if (isset($_SESSION['uzytkownik'])):
                    ?>
                    <button class="wyloguj btn btn-success">
                    <span><?php echo $_SESSION['uzytkownik'];?></span>
                    </button>
                    <?php
                    else:
                    ?>
                    <button class="zaloguj btn btn-success">
                    <span>Zaloguj się</span>
                    </button>
                    <?php
                        endif;
                    ?>
                </a>
            </div>

            </div>
            <a class="navbar-brand mx-lg-0 order-1 order-lg-2" href="validator.php?platnosc">
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

    
        <br>
        <br>
        <br>
    
        <div id="demo" class="carousel slide" data-interval="3000" data-ride="carousel" style="margin-top:12.3px;">

            
            <ul class="carousel-indicators">
                <li data-target="#demo" data-slide-to="0" class="active"></li>
                <li data-target="#demo" data-slide-to="1"></li>
                <li data-target="#demo" data-slide-to="2"></li>
            </ul>

            
            <div class="carousel-inner">
                <div class="carousel-item active">

                    <a href="asortyment.php">
                        <img src="carousel/płytagłowna.png" alt="motherboard">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="asortyment.php">
                    <img src="carousel/zestaw.png" href="asortyment.php" alt="computer">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="asortyment.php">
                    <img src="carousel/logitech.png" alt="gamingdriver">
                    </a>
                </div>
            </div>

            
            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>

        </div>
        <br>

        <div class="discount mt-4">
            <div class="container bg-grey">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="txt">Szybki Strzał ---></h5>
                                <div class="row py-2">
                                    <div class="col-md-4 vertical-box">
                                        <div class="card">
                                            <img class="card-img-top mh200-text" src="discount/i7.jpg" width="130"
                                                height="300" alt="Card image">
                                            <div class="card-body">
                                                <h4 class="card-title mw30-text">Procesor Intel Core i7-9700K, Octa
                                                    Core, 4.9GHz, 12MB,14mn, BOX</h4>
                                                <h6><s>1889 zł </s></h6>
                                                <h2 class="font">1500 zł</h2>
                                                <a href="asortyment.php">
                                                    <button type="button"
                                                        class="btn btn-outline-success">Sprawdź</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 vertical-box">
                                        <div class="card">
                                            <img class="card-img-top mh200-text" src="discount/gtx1070.jpg" width="130"
                                                height="300" alt="Card image">
                                            <div class="card-body">
                                                <h4 class="card-title mw30-text">Karta graficzna Gigabyte GeForce RTX
                                                    2070 GAMING 8G GDDR6</h4>
                                                <h6><s>2349 zł</s></h6>
                                                <h2 class="font">2039 zł</h2>
                                                <a href="asortyment.php">
                                                    <button type="button"
                                                        class="btn btn-outline-success">Sprawdź</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 vertical-box">
                                        <div class="card">
                                            <img class="card-img-top mh200-text" src="discount/mysz.jpg" width="130"
                                                height="300" alt="Card image">
                                            <div class="card-body">
                                                <h4 class="card-title mw30-text">Mysz Razer Lancehead Tournament Edition (RZ01-02130100-929)</h4>
                                                <h6><s>314,61 zł</s></h6>
                                                <h2 class="font">289 zł</h2>
                                                <a href="asortyment.php">
                                                    <button type="button"
                                                        class="btn btn-outline-success">Sprawdź</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <br>

        <div id="services" class="container-fluid text-center">
            <h2><b>Dlaczego eShop?</b></h2>
            <br>
            <div class="row">
                <div class="col-sm-4">
                    <i class="fas fa-desktop fa-2x"></i>
                    <h4>Sprzęt</h4>
                    <p>Sprzedajemy sprzęt komputerowy wysokiej jakości</p>
                </div>
                <div class="col-sm-4">
                    <i class="fas fa-building fa-2x"></i>
                    <h4>Dostępność</h4>
                    <p>Posiadamy placówki w wiekszości miast w Polsce</p>
                </div>
                <div class="col-sm-4">
                    <i class="fas fa-tools fa-2x"></i>
                    <h4>Gwarancja</h4>
                    <p>Oferujemy długą gwarancje na produkty</p>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-sm-4">
                    <i class="fas fa-stamp fa-2x"></i>
                    <h4>Certyfikowany sklep</h4>
                    <p>Posiadamy wiele certyfikaów, i medali za sprzedaż detaliczną</p>
                </div>
                <div class="col-sm-4">
                    <i class="fas fa-phone fa-2x" width="100px" height="100px"></i>
                    <h4>Kontakt</h4>
                    <p>Oferujemy kontakt telefoniczny w godzinach 8-20</p>
                </div>
                <div class="col-sm-4">
                    <i class="fas fa-user-check fa-2x"></i>
                    <h4>Klient</h4>
                    <p>Naszym najważniejszym celem jest dobro klienta</p>
                </div>
            </div>
        </div>




    

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