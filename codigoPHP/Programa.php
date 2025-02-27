<?php
/* llamar al fichero de recuperar sessiones */
require 'session.php';

/* usar el fichero de lenguajes */
require '../core/lenguajes.php';

/* destroy la session y devolver al usuario al login */
if (isset($_REQUEST['logout'])) {
    session_unset();
    session_destroy();

    setcookie("IdiomaReg", "", time() - 3600); // set the expiration date to one hour ago
    header("Location:../indexProyectoLoginLogout.php");
    exit;
}
/* llevarle a al detalle */
if (isset($_REQUEST['detalle'])) {
    header("Location:Detalle.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>OB - Programa</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="icon" href="../webroot/media/fav.png" type="image/ico" sizes="16x16">
        <style>
            body{
                background-image: url(../webroot/media/building-g458550d32_1920.jpg);
                background-repeat: no-repeat;
                background-size: cover;
            }
            input{
                margin: 10px;
            }
            .alert {
                padding: 20px;
                background-color: #864879;
                color: white;
                width: 29%;
                position: relative;
                bottom: 0;

            }
            .closebtn {
                margin-left: 15px;
                color: white;
                font-weight: bold;
                float: right;
                font-size: 22px;
                line-height: 20px;
                cursor: pointer;
                transition: 0.3s;
            }
            .closebtn:hover {
                color: black;
            }
            #mynavbar{
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
        </style>
    </head>
    <body>
        <?php
        /* Usamos el fichero de configuracion ala base de datos */
        require_once '../config/confDBPDO.php';

        try {
            /* Establecemos la connection con pdo en global */
            $miDB = new PDO(HOST, USER, PASSWORD);

            /* configurar las excepcion */
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /* Hgamos la comprobacion en la base de datos si existe este usuario con consulta preparada */
            $sql = "SELECT T01_CodUsuario,T01_DescUsuario,T01_NumConexiones FROM T01_Usuario WHERE T01_CodUsuario='" . $_SESSION['usuario202DWESAppLoginLogout'] . "'";
            $resultadoConsulta = $miDB->prepare($sql);
            $resultadoConsulta->execute();
            $registro = $resultadoConsulta->fetchObject();
            ?>
            <div class="w3-bar w3-black  ">
                <p style="padding: 10px;font-size: 18px;font-weight: bold;" class="w3-center ">Web Application Login-Logout</p>
            </div> 
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="mynavbar">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"> 
                                <p style="font-size: 20px;" class="nav-link" > <?php echo $aLeng[1] . ' , ' . $_SESSION['usuario202DWESAppLoginLogout']; ?> </p>
                            </li>
                        </ul>
                        <form class="d-flex">
                            <input type="submit" class="btn btn-primary" name="detalle" value="Detalle" type="button"/>
                            <input type="submit" class="btn btn-info" name="logout" value="<?php echo $aLeng[3] ?>" type="button"/>
                            <div class="w3-dropdown-hover w3-right">
                                <img src="../webroot/media/icons8-usuario-masculino-en-círculo-48.png" alt="Avatar" style="width:38px;height: 38px;margin-top:10px;" class="w3-circle">
                                <div class="w3-dropdown-content w3-bar-block " style="right:0;margin-top: 20%;">
                                    <a href="editarPerfil.php" class="w3-bar-item w3-button w3-black w3-hover-blue">Editar Perfil</a>
                                    <a href="delete.php" class="w3-bar-item w3-button w3-black w3-hover-red ">Delete Account</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="container-fluid mt-3">
                <div class="alert">
        <!--<span class="closebtn" onclick="this.parentElement.style.display = 'none';">&times;</span> -->
                    <p><?php echo ($registro->T01_NumConexiones > 1) ? $aLeng[2] . ' ' . $registro->T01_DescUsuario . ' es la ' . $registro->T01_NumConexiones . ' vez que se connecta y su ultima connexion anterior fue "' . date("d/m/Y H:i:s", $_SESSION['T01_FechaHoraUltimaConexionAnterior']) . '"' : $aLeng[2] . ' ' . $registro->T01_DescUsuario . ' esta es la primera vez que se connecta.'; ?></p>
                </div>
            </div>
            <div style="height:100px;">
            </div>
            <footer style="position: fixed;bottom: 0;width: 100%" class="bg-dark text-center text-white">
                <!-- Grid container -->
                <div class="container p-3 pb-0">
                    <!-- Section: Social media -->
                    <section class="mb-3">
                        <!-- Github -->
                        <a class="btn btn-outline-light btn-floating m-1" href="https://github.com/outmaneBH/202DWESproyectoLoginLogout" target="_blank" role="button">
                            <img id="git" style="width: 30px;height:30px; " src="../webroot/media/git.png" alt="github"/>  
                        </a>
                    </section>
                </div>
                <!-- Grid container -->
                <!-- Copyright -->
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                    Copyrights © 2021 
                    <a class="text-white" href="../index.html">OUTMANE BOUHOU</a>
                    . All rights reserved.
                </div>
                <!-- Copyright -->
            </footer>
            <?php
        } catch (PDOException $exception) {
            /* llamar al fichero de configuracion de Catch */
            require '../error/catchConfig.php';
        } finally {
            /* Ceramos la connection */
            unset($miDB);
        }
        ?>
    </body>
</html>


