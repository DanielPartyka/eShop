<?php
    require "log.php";
    require "validator.php";
?>
<?php
    if (empty($_SESSION['cart']))
    {
        header('Location: index.php');
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
        .btn {
            white-space: nowrap;
            text-align: center;
        }
        table,th,td{
            border: 0.3px solid black;
        }
        .wys {
            text-align: center;
            font-size: 25px;
        }
        #conta{
            min-height: 1200px;
            
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
            <a class="navbar-brand mx-lg-0 order-1 order-lg-2" href="#tabble">
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
    <br><br><br>
    
    <main>
    <div class="container" id="conta">
    
            <div id="tabble" class="table-striped table-responsive" style="width:100%; text-align:left;">
                <table class="table">
                    <thead class="thead-dark">
                        <th colspan="6">
                            <h3 style="font-size: 34px; margin-top:20px;">Szczegóły Zamówienia</h3>
                        </th>
                 </thead>
                    <tr>
                        <th width="20%" style="font-size: 20px;">Produkt</th>
                        <th width="40%" style="font-size: 20px;">Nazwa Produktu</th>
                        <th width="10%"style="font-size: 20px;">Ilość</th>
                        <th width="10%"style="font-size: 20px;">Cena</th>
                        <th width="15%"style="font-size: 20px;">Wartość Zamówienia</th>
                        <th width="5%"style="font-size: 20px;">Akcja</th>
                    </tr>
                    <?php
            if (!empty($_SESSION['cart'])):
                $total = 0;
                $quan = 0;
                $zestaw = 20;
                
                foreach($_SESSION['cart'] as $key => $produkt):
            
        ?>
                    <tr>
                        <th><img style="width:100px; height:100px;" src="<?php echo $produkt['zdjecie'];?>"/></th> 
                        <th><h5 class="font"><?php echo $produkt['nazwa_produktu'];?></h5></th>
                        <th><h5 class="font"><?php echo $produkt['quantity'];?></h5></th>
                        <th><h5 class="font"><?php echo $produkt['cena'];?> zł</h5></th>
                        <th><h5 class="font"><?php echo number_format($produkt['quantity']*$produkt['cena'],2);?> zł</h5></th>
                        <th>
                            <a href="platnosc.php?action=delete&id=<?php echo $produkt['id'];?>">
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
                        <th><h5 class="font">Wysyłka</h5></td>
                        <th class="wys">-</th>
                        <th class="wys">-</td>
                        <th class="wys">-</td>
                        <th style="align:right;"> <h5 class="font"> <?php echo $zestaw?> zł</h5></td>
                        <th class="wys">-</td>   
                </tr>
                    <tr>
                        <th colspan="2" style="align:right;"><h5 class="font">Suma</h5></td>
                        <th><h5 class="font"><?php echo $quan?></h5></th>
                        <th></td>
                        <th style="align:right;"> <h5 class="font"><?php echo number_format($total+$zestaw,2);?> zł</h5></td>
                        <th></td>
                        
                    </tr>
                 
                    <?php endif; ?>
                </table>
            </div>
    
    
    <div class="formularz row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <header class="card-header">
                           
                            <h4 class="card-title mt-2">Zamówienie</h4>
                        </header>
                        <article class="card-body">
                            <form action="pplatnosc.php" method="post">
                                <div class="form-row">
                                    <div class="col form-group">
                                        <label>Imie</label>
                                        <input type="text" name="imie" class="form-control" value="" placeholder="" required>
                                    </div> 
                                    <div class="col form-group">
                                        <label>Nazwisko</label>
                                        <input type="text" name="nazwisko" class="form-control" 
                                        value="" placeholder="" required>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="
                                        <?php echo $_SESSION['uzytkownik'];
                                        ?>" placeholder="" readonly>
                                </div> 
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Miasto</label>
                                        <input type="text" name="miasto" value="" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label>Kod Pocztowy</label>
                                            <input type="text" name="kodpocztowy" value="" class="form-control" required>
                                        </div> 
                                     
                                     <div class="float-center custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="defaultInline1" name="radio-stacked" required>
                                            <label class="custom-control-label" for="defaultInline1"><i class="fab fa-cc-mastercard" style="font-size:48px"></i></label>
                                    </div>
                                    
                                    <div class="float-center custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="defaultInline2" name="radio-stacked" required>
                                    <label class="custom-control-label" for="defaultInline2"><i class="fab fa-cc-paypal" style="font-size:48px"></i></label>
                                    </div>
                                    <div class="invalid-feedback">More example invalid feedback text</div>
                                    </div>
                                    <br>
                                </div> 
                                 
                                 <?php 
                    if (isset($_SESSION['cart'])):
                    if (count($_SESSION['cart'])>0):
                ?>
                                <div class="form-group" href="platnosc.php">
                                   <a>
                                   <button type="sub"  name="sub" class="btn btn-primary btn-block"> Złóż Zamówienie </button>
                                </div> 
                                <?php endif; endif; ?>        
                            </form>
                        </article>
                        
                    </div>
                </div> 

            </div>
           
    </div>
</div>
    
    
            <br>
            
    

    </main>
    
    
<footer id="foot"
    class="page-footer sticky-bottom font-small stylish-color-dark pt-4">

    
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