<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$connect = mysqli_connect('localhost','root','','uorder');

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

    if (isset($_POST['submit']))
    {
        $email = $_POST['email'];
        $phaslo = $_POST['phaslo'];
        $haslo = $_POST['haslo'];
        $phaslo = md5($phaslo);
        $haslo = md5($haslo);
        $sql = "INSERT INTO rejestracja(email,haslo) values ('$email','$haslo')"; 
        $checkemail = "Select * from rejestracja where email='".$email."'";
        $result1 = mysqli_query($connect,$checkemail);
        if ($phaslo!=$haslo)
        {
            header('Location: rejestracja.php?bladzhaslem= Hasła nie są identyczne!');
        }
        else {
        if (mysqli_fetch_assoc($result1)==NULL)
        {
            $result = mysqli_query($connect,$sql);
            if ($result)
            {
                
                if ($result)
                {
                    header('Location: logowanie.php');
                }
                else {
                    header('Location: rejestracja.php');
                }
            }
            
        }
        else{
            header('Location: rejestracja.php?rejestracja= Użytkownik ' . ' ' . $email . ' już istnieje!');
        }
    }
    }
    mysqli_close($connect);
    
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
        .btn {
            white-space: nowrap;
            text-align: center;
        }
        body{
            background-color: #eeeeee;
        }
        #conta{
            min-height: 485px;
            
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
            <div class="navbar-brand mx-lg-0 order-3 order-lg-3 href=#">
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
    
            <br><br><br><br><br>

        
            
            <div class="container" id="conta">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <header class="card-header">
                            <a href="logowanie.php" class="float-right btn btn-outline-primary mt-1">Zaloguj się</a>
                            <h4 class="card-title mt-2">Rejestracja</h4>
                            <?php
                            if (@$_GET['rejestracja']==true)
                            {
                        ?>        
                            <h6 style="color:red;" class="card-title-mt2"><?php echo $_GET['rejestracja']?></h6>
                          <?php  
                            }
                        ?>
                        <?php
                            if (@$_GET['bladzhaslem']==true)
                            {
                        ?>        
                            <h6 style="color:red;" class="card-title-mt2"><?php echo $_GET['bladzhaslem']?></h6>
                          <?php  
                            }
                        ?>
                        </header>
                        <article class="card-body">
                            <form action="rejestracja.php" method="post">
                                
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                                </div> 
                                <div class="form-group">
                                    <label>Hasło</label>
                                    <input class="form-control" name="haslo" type="password" minlength="6" required>
                                </div> 
                                <div class="form-group">
                                    <label>Powtórz hasło</label>
                                    <input class="form-control" name="phaslo" type="password" minlength="6" required>
                                </div> 
                                <div class="form-group" href="index.php">
                                   <button type="submit" type="submit" name="submit" class="btn btn-primary btn-block"> Zarejestruj się </button>
                                </div> 
                                <small class="text-muted">Rejestrując się wyrażasz zgodę na przetwarzanie danych osobowych</small>
                            </form>
                        </article> 
                        
                    </div> 
                </div> 

            </div>
            
       
            </div>












        <br>
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