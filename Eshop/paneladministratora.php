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
    <script src="filteradmin.js"></script>
    <style>
    .btn {
            white-space: nowrap;
            text-align: center;
        }

        .navbar-brand
        {
            position:relative;
        }
        
        #conta{
            min-height: 600px;
            
        }
        .btn-warning{
            width:130px;
        }
        .btn-danger{
            width:130px;
        }
        .font{
            font-family: 'Slabo 27px', serif;
            font-weight: bold 0.35;
        }
        body{
            background-color: #eeeeee;
        }
        input[type=text] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        }
        input[type=number] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        }
        input[type=list] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
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
                        echo '<li class="nav-item active">
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
                    <span>Nie Jesteś zalogowany</span>
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
    
    <div class="opakowanie" id="conta">
    <div id="tabble" class="table-striped" style="width:100%; text-align:left; margin-top: 83px;">
                <table class="table">
                   <thead class="thead-dark">
                        <th colspan="2">
                            <h3 style="font-size: 20px;">Dostępne produkty</h3>
                            <input class="form-control" style="width: 350px;" id="myInput" type="text" placeholder="Szukaj...">
                        </th>
                        <th colspan="2"></th>
                        <th colspan="1"></th>
                        <th colspan="1"></th>
                        <th colspan="1">
                                <a href="admindodajprodukt.php">
                                <div style="margin-right: 0;" class="btn btn-success">Dodaj produkt</div>
                                </a>
                        </th>
                        
                 </thead>
                    <tr>
                        <th scope="col" width="2%" style="font-size: 20px;"></th>
                        <th scope="col" width="10%"style="font-size: 20px;">Zdjęcie</th>
                        <th scope="col" width="40%" style="font-size: 20px;">Nazwa Produktu</th>
                        <th scope="col" width="8%"style="font-size: 20px;">Cena (zł)</th>
                        <th scope="col" width="15%" style="font-size: 20px">Zdjęcie</th>
                        <th scope="col" width="15%"style="font-size: 20px;">Filter</th>
                        <th scope="col" width="10%" style="font-size: 20px;">Akcja</th>
                    </tr>
                    <tbody id="myTable">
                    <?php
                    $connect = mysqli_connect('localhost','root','','uorder');
                    $query = 'Select * from produkty order by id_produktu desc';
                    $result = mysqli_query($connect,$query);
                    if ($result):
                        if (mysqli_num_rows($result)>0):
                            while($produkt = mysqli_fetch_assoc($result)):
                                ?>
                    
                    <form action="update.php" method="POST">
                    <tr>
                        <th scope="row"></h5>
                        <input type="hidden" name="id_produktu" value="<?php echo $produkt['id_produktu'];?>" />
                        </th> 
                        <th scope="row">
                            <img style="width:100px; height:100px;" src="discount/<?php echo $produkt['zdjecie'];?>"/>
                        </th>
                        <th scope="row">
                            <h5 hidden class="font"><?php echo $produkt['nazwa_produktu'];?></h5>
                            <input type="text" style="width: 600px;" name="nazwa_produktu" value="<?php echo $produkt['nazwa_produktu'];?>"/>
                        </th>
                        <th scope="row">
                            <h5 hidden class="font"><?php echo $produkt['cena'];?></h5>
                            <input type="number" step="0.01" style="width:125px;" name="cena" value="<?php echo $produkt['cena'];?>" />
                        </th>
                        <th scope="row">
                            <h5 hidden class="font"><?php echo $produkt['zdjecie'];?></h5>
                            
                            <!-- Poprawione -->
                            <input type="list" name="sciezkadp" list="zdjecia" placeholder="<?php echo $produkt['zdjecie'];?>" />
                            <datalist id="zdjecia">
                            <?php
                                $dir = 'discount';
                                $image = array_diff(scandir($dir), array('..', '.'));
                                foreach ($image as $key => $val):
                            ?>
                                <option value="<?php echo $val;?>">
                            <?php
                                endforeach;
                            ?>
                            </datalist>
                             <!-- Poprawione -->

                        </th scope="row">
                        <th scope="row">
                            <h5 hidden class="font"><?php echo $produkt['filter'];?></h5>
                            <input type="text" name="filter" value="<?php echo $produkt['filter'];?>" />
                        </th>
                        <th scope="row">
                            <button name="modify">
                                <div class="btn btn-warning"><i class="fas fa-trash"></i> Zmień</div>
                            </button>
                            <button name="delete">
                                <div class="btn btn-danger"><i class="fas fa-trash"></i> Usuń</div>
                            </button>
                        </th>
                        
                    </tr>
                    </form>
                    <?php 
                    endwhile; endif; endif;
                    ?>
                </tbody>    
            </table>
            </div>
    </div>
   
</div>


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