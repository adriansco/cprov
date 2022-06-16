<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/favicon.ico">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="assets/css/login/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
</head>

<body>
    <img class="wave" src="assets/css/login/img/wave.png">
    <div class="container" onclick="onclick">
        <div class="img">
            <img src="assets/css/login/img/bg.svg">
        </div>
        <div class="login-content">
            <form action="" id="frmlogin">
                <img src="assets/css/login/img/avatar.svg">
                <h2 class="title">EMV-PROV</h2>
                <div id="msg_error" class="alert alert-danger" role="alert" style="display: none"></div>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Usuario</h5>
                        <!-- <input type="text" class="input"> -->
                        <input type="text" class="input" id="email" name="email" placeholder="" />
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Contraseña</h5>
                        <input type="password" class="input" id="password" name="password">
                    </div>
                </div>
                <a href="#">¿Se te olvidó tu contraseña??</a>
                <!-- <input type="submit" class="btn" value="Login"> -->
                <button type="submit" class="btn" name="iniciar" id="iniciar">Iniciar</button>
            </form>
        </div>
    </div>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/funciones/auth.js"></script>
    <script type="text/javascript" src="assets/css/login/js/main.js"></script>
</body>

</html>