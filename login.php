<!DOCTYPE html>
<html lang="id">
<?php
$kdb =koneksidatabase(); ?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="canonical" href="https://library.unila.ac.id/mobile">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unila Library Mobile</title>

    <!-- TODO add manifest here -->
    <link rel="manifest" href="./manifest.json">
    <!-- Add to home screen for Safari on iOS -->
    <!-- Add to home screen for Safari on iOS -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="UnilaLibrary">
    <meta name="apple-mobile-web-app-title" content="UnilaLibrary">
    <meta name="theme-color" content="#ffab1f">
    <meta name="msapplication-navbutton-color" content="#ffab1f">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="msapplication-starturl" content="./">
    <meta name="msapplication-TileImage" content="./img/icons/apple-icon-144x144.png">
    <meta name="msapplication-TileColor" content="#ffab1f">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" sizes="72x72" href="./img/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./img/icons/apple-icon-72x72.png">
    <link rel="icon" sizes="120x120" href="./img/icons/img-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./img/icons/apple-icon-120x120.png">
    <link rel="icon" sizes="144x144" href="./img/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./img/icons/apple-icon-144x144.png">
    <link rel="icon" sizes="152x152" href="./img/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./img/icons/apple-icon-152x152.png">
    <link rel="icon" sizes="180x180" href="./img/icons/apple-icon-180x180.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./img/icons/apple-icon-180x180.png">
    <link rel="icon" href="./img/icons/apple-icon.png">
    <link rel="apple-touch-icon" href="./img/icons/apple-icon.png">

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/creative.css" rel="stylesheet">

    <!-- Login CSS -->
    <link href="css/login.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="index.html" id="tblTop">Unila Library Mobile</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="berita.html" id="tblBerita">Berita</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="opac.html" id="tblOpac">OPAC</a>
                    </li>

                    <li>
                        <a class="page-scroll" href="UniUca.html" id="tblUniuca">UniUca</a>
                    </li>

                    <li>
                        <a class="page-scroll" href="ebookejournal.html" id="tblEbookejournal">eBook & eJournal</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="openaccess.html" id="tblOpenaccess">OpenAccess</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="login.php" id="tblLogin">Login</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="Navigasi.html" id="tbNavigasi">Navigasi</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="peta.html" id="tblPeta">peta</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
   
    <section id="login">
       <div class="container">
        <div class="kotak_login">
            <p class="tulisan_login">Silahkan login</p>

            <form action="cek_login.php" method="post">
                <label>NPM</label>
                <input type="text" name="member_id" class="form_login" placeholder="Username .." required="required">
                <input type="submit" class="tombol_login" value="LOGIN">
                <br />
                <center>
                    <a class="link" href="index.html">kembali</a>
                </center>
            </form>

        </div>
        </div>
    </section>
    

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    
    <!-- main logic -->
    <script src="scripts/main.js"></script>

</body>

</html>
<?php
function koneksidatabase()
{
include ('admin/koneksi/koneksi.php');
return $kdb;


}

 ?>