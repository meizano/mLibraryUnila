<?php
session_start();
if(!isset($_SESSION['member_type_id'])){header("location:../logout.php"); }
$menu = !empty($_GET['menu']) ? $_GET['menu'] : "1";
?>
<html lang="en">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Unila Library Mobile </title>
        <link href="bootstrap/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/docs.css" rel="stylesheet">
		
    </head>

<body>

    <header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
        <div class="container">
            <div class="pull-right">
                <p class="navbar-text navbar-right" style="color:white">
                    <?php echo "" .$_SESSION['member_id'].' | <a href=../logout.php?ob=out>Logout</a>'; ?>
                </p>
            </div>
            <div class="navbar-header">
                <a href="pinjam.php?menu=1" class="navbar-brand">PEMESANAN </a>
            </div>
        </div>
    </header>

    <div class="container bs-docs-container">
        <div class="row">
            <div class="col-md-3">
                <div class="bs-sidebar" role="complementary">
                    <ul class="nav bs-sidenav">
                        <li <?php if($menu==1) { echo 'class="active"'; } else { echo 'class=""'; } ?>>
                            <a href="pinjam.php?menu=1">
                              <span class="glyphicon glyphicon-index" aria-hidden="true"></span> HOME
                            </a>
                        </li>
                        <li <?php if($menu==5) { echo 'class="active"'; } else { echo 'class=""'; } ?>>
                            <a href="pinjam.php?menu=5">
                              <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Data Peminjaman
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9" role="main">
                <?php
                    switch($menu)
                    {case('1'): include_once('./menu/tampl.php'); break;
                        case('5'): include_once('./menu/dt_buku.php'); break;
                        default:   include_once('./menu/tampl.php'); break;
                    }
                ?>
                
            </div>
        </div>
    </div>


<footer class="bs-footer" role="contentinfo">
    <div class="container">
        <div class="">
            <center><p>Perpustakaan Universitas Negeri Lampung .</p></center>
        </div>
    </div>
</footer>

    <!-- Pinjam mlibrary --> 
    <script src="scripts/pinjam.js"></script>


</body>
</html>
