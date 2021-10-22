<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>GreEngineers</title>
    <!-- Favicon icon -->
   <!--=============== css  ===============-->
   <link href="assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="assets/css/style.css?v=<?php echo rand(); ?>" rel="stylesheet">
    <link href="assets/css/estilos.css?v=<?php echo rand(); ?>" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&display=swap"
       rel="stylesheet">
    <style>
            .img-login-right{
                margin:0px;
                border-radius:5px;
                padding:0px;
                width:100%;
                height: 535px;
                background-repeat:no-repeat;
                background:url('assets/images/banner-bg.jpg');
                background-size: cover;
                opacity: 0.75;
            }
            .img img{
                width: 100%;
            }

            .img img{
                width:100%;
            }
            .text-login{
                padding-top: 83%;
                color: #1eeffc;
                font-weight: bold;
            }
            @media (max-width: 1400px) {
                .img-login-right {
                    height: 490px !important;
                }
                .text-login {
                    padding-top: 75%;
                }
            }
            @media (max-width: 1200px) {
                .hidden-sm {
                    display: none !important;
                }
            }
        </style>
    <!--=============== SHA256 ===============-->
    <script src="LoginI/sha256.js"></script>
</head>

<body class="h-100">
    <div class="authincation h-100" style="background: #F4F5F8;">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6" style="margin: 0px; padding: 0px;">
                    <div class="authincation-content" style="background: #FFFFFF;" class="img-login-right">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form pt-3 pb-3">
                                    <div class="text-center mb-3">
                                      <a href="#" class="logo">GreEngineer's</a>
                                    </div>
                                    <h3 class="text-center mb-2">Inicio de Sesión</h3>

                                    <div class="form-group">
                                        <label class="mb-1">Correo:</label>
                                        <input type="text" class="form-control" id="user" placeholder="Correo de acceso">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Contraseña</label>
                                        <input type="password" class="form-control" id="pass" placeholder="Contraseña de acceso">
                                    </div>

                                    <div class="text-center">
                                        <button style="background-color: #436d8a !important; color: white !important;" type="button" id="botonRegistra" class="btn bg-white text-primary btn-block" onclick="iniciarSesion(user.value, pass.value, event)">Ingresar</button>
                                    </div>
                                    <div class="new-account mt-3 text-center">
                                        <p><a class="text-info" href="index.html">Página Principal</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
  
    <!-- Scripts -->
    <script src="assets/vendor/global/global.min.js"></script>
  	<script src="assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="assets/js/custom.min.js"></script>
  	<script src="assets/js/deznav-init.js"></script>

    <script src="assets/js/bootstrap-notify.js"></script>

      <!--=============== login scripts  ===============-->
  	<script src="LoginI/login.js?v=<?php echo rand(); ?>"></script>
  	<script src="LoginI/bootstrap-notify.js"></script>

</body>

</html>
