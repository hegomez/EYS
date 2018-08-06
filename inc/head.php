<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RIPS WEB</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <link href="css/all.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/brands.css" rel="stylesheet" type="text/css">
    <link href="css/fontawesome.css" rel="stylesheet" type="text/css">
    <link href="css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="css/regular.css" rel="stylesheet" type="text/css">
    <link href="css/solid.css" rel="stylesheet" type="text/css">
    <link href="css/stylehealth.css" rel="stylesheet" type="text/css">
    <link href="css/svg-with-js.css" rel="stylesheet" type="text/css">
    <link href="css/v4-shims.css" rel="stylesheet" type="text/css">
    <link href="css/v4-shims.min.css" rel="stylesheet" type="text/css">

    
</head>
<body class="sidebar-mini pace-done">
    <div class="wrapper">
        <header class="main-header">
            <a href="index.html" class="logo">
                <span class="logo-mini">
                    <img src="img/mini-logo.png" alt="">
                </span>
                <span class="logo-lg">
                    <img src="img/logo.png" alt="">
                </span>
            </a>
            <nav class="navbar navbar-static-top ">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="min-menu"><i class="fas fa-minus-circle"></i></span>
                    <span class="max-menu"><i class="fas fa-plus-circle"></i></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                    </ul>
                </div>
                <div  style="float: right;">
					<p class="conect" style="margin: 0 !important">MySQL <?php echo $MysqlCnn ?></p>
					<p class="conect" style="margin: 0 !important">SQLServer <?php echo $SQLCnn ?></p>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <div class="sidebar" style="height: auto;">
                <div class="user-panel">
                    <div class="image pull-left">
                        <img src="img/avatar.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="info">
                        <h4>Binevenido</h4>
                        <p><?php echo $_COOKIE['name'] ?></p>
                    </div>
                </div>
                <ul class="sidebar-menu">
                   <?php
						$MENU=array(
							"main.php"=>array(
								"Name"=>"Inicio",
								"Icon"=>"far fa-hospital",
								"Url"=>"main.php",
								"Data"=>array()
							),
							"bills.php"=>array(
								"Name"=>"Cuentas",
								"Icon"=>"fas fa-file-invoice-dollar",
								"Url"=>"bills.php",
								"Data"=>array(
									
								)
							)
						);
						
						foreach ($MENU as $k => $li)
                        {
                            $URL=explode("/", $_SERVER['PHP_SELF']);
                            $C = ($URL[2]==$li['Url']) ? 'active' : '' ;
                            echo'<li class="'.$C.'"><a href="'.$li['Url'].'"><i class="'.$li['Icon'].'"></i><span>'.$li['Name'].'</span></a></li>';
                        }
					?>
                    
                </ul>
        </div> 
        </aside>
        <div class="content-wrapper" style="min-height: 879px;">
            <section class="content-header">   
                <div class="header-icon">
                    <?php
                        echo '<i class="'.$MENU[$URL[2]]['Icon'].'"></i>';
                        $h1=' '.$MENU[$URL[2]]['Name'];
                        $small=' ';
                    ?>
                </div>
                <div class="header-title">
                    <h1><?php echo $h1 ?></h1>
                    <small><?php echo $small ?></small>
                    <!--<ol class="breadcrumb hidden-xs">
                        <li><a href="http://healthadmin.thememinister.com/index.html"><i class="pe-7s-home"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>-->
                </div>
            </section>