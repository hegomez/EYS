<?php include("inc/func.php"); DelGall(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login EyS</title>
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
<body>
    <!-- Content Wrapper -->
    <div class="login-wrapper">
        <div class="container-center">
            <div class="panel panel-bd">
                <div class="panel-heading">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="fas fa-unlock"></i>
                        </div>
                        <div class="header-title">
                            <h3>Inicio de Sesión</h3>
                            <small><strong>Por favor ingrese sus credenciales.</strong></small>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <form action="login" method="post">
                       	<div class="input-group">
							<div class="input-group-addon"><i class="fas fa-user-md"></i></div>
							<input required autocomplete="off" class="form-control" type="text" name="user" placeholder="Usuario">
						</div>
                        <span class="help-block small">Usuario unico para el Aplicativo</span>
                        <div class="input-group">
							<div class="input-group-addon"><i class="fas fa-key"></i></div>
							<input class="form-control" autocomplete="off" type="password" required name="pass" placeholder="Contraseña">
						</div>
                        <span class="help-block small">Su Contraseña Segura</span>
                        <div>
                            <button type="submit" class="btn btn-primary">Iniciar</button>
                        </div>
                        <?php if(isset($_GET["3R"])) { echo '<div class="alert alert-danger alert-test" role="alert">Usuario o Contraseña Errado</div>';}?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>