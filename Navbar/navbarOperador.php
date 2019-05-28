<!DOCTYPE html>
<?php
$db = $_SERVER['DOCUMENT_ROOT'];
$db .= "/POM-Logistica/db.php";
include_once($db);
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION["perfilId"] == 1) {
    header("Location: index.php");
    ?>
    <script type="text/javascript">
        alert("Voce nao tem permissoes para acessar a isso");
    </script>
<?php
}
?>

<?php
function echoActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'active';
}
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>POM Logistica</title>

    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="\POM-Logistica\css\bootstrap.css"> -->

    <!-- FontAwesome CSS -->
    <!-- <link rel="stylesheet" href="/POM-Logistica/css/font-awesome.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- ElegantFonts CSS -->
    <link rel="stylesheet" href="/POM-Logistica/css/elegant-fonts.css">

    <!-- themify-icons CSS -->
    <link rel="stylesheet" href="/POM-Logistica/css/themify-icons.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="/POM-Logistica/css/swiper.min.css">

    <!-- Styles -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" crossorigin="anonymous"> -->
    <!-- <link href="https://rawgit.com/tempusdominus/bootstrap-4/master/build/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" /> -->
    <link rel="icon" type="image/png" href="/POM-Logistica/images/titlelogo.png">
    <link rel="stylesheet" type="text/css" href="/POM-Logistica/styles/style.css">
    <link rel="stylesheet" type="text/css" href="/POM-Logistica/styles/style3.css">

    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.0/moment-with-locales.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    <!-- <script src="https://rawgit.com/tempusdominus/bootstrap-4/master/build/js/tempusdominus-bootstrap-4.min.js"></script> -->
</head>

<style>
    @media (min-width: 992px) {
        .animate {
            animation-duration: 0.3s;
            -webkit-animation-duration: 0.3s;
            animation-fill-mode: both;
            -webkit-animation-fill-mode: both;
        }
    }

    @keyframes slideIn {
        0% {
            transform: translateY(1rem);
            opacity: 0;
        }

        100% {
            transform: translateY(0rem);
            opacity: 1;
        }

        0% {
            transform: translateY(1rem);
            opacity: 0;
        }
    }

    @-webkit-keyframes slideIn {
        0% {
            -webkit-transform: transform;
            -webkit-opacity: 0;
        }

        100% {
            -webkit-transform: translateY(0);
            -webkit-opacity: 1;
        }

        0% {
            -webkit-transform: translateY(1rem);
            -webkit-opacity: 0;
        }
    }

    .slideIn {
        -webkit-animation-name: slideIn;
        animation-name: slideIn;
    }

    .dropdown-menu {
        margin-top: -0.3rem !important;
        border-radius: 3px !important;
    }

    body {
        background-color: #f5f5f5 !important;
    }
</style>

<body>
    <nav role="navigation">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="d-block" style="margin-top:5px" href="\POM-Logistica\Operador\Menu.php" rel="home"><img class="d-block" src="/POM-Logistica/images/logosemsombra.png" alt="logo"></a>
            </li>
            <li class="nav-item" style="margin-left:1rem;">
                <a class="nav-link <?= echoActiveClassIfRequestMatches("Listar_clientes") ?>" href="/POM-Logistica/Operador/Listagens/Listar_clientes.php">Clientes</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?= echoActiveClassIfRequestMatches("Listar_guia_rececao") ?> <?= echoActiveClassIfRequestMatches("Listar_guia_devolucao") ?>" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Imprimir Guias</a>
                <div class="dropdown-menu dropdown-menu-right animate slideIn">

                    <a class="dropdown-item <?= echoActiveClassIfRequestMatches("Listar_guia_rececao") ?>" href="/POM-Logistica/Operador/Listagens/Listar_guia_rececao.php">Guia Receção</a>
                    <a class="dropdown-item <?= echoActiveClassIfRequestMatches("Listar_guia_devolucao") ?>" href="/POM-Logistica/Operador/Listagens/Listar_guia_devolucao.php">Guia Devolução</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?= echoActiveClassIfRequestMatches("inserir_paletes") ?> <?= echoActiveClassIfRequestMatches("Guia_Operador") ?>" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Confirmar Guias</a>
                <div class="dropdown-menu dropdown-menu-right animate slideIn">

                    <a class="dropdown-item <?= echoActiveClassIfRequestMatches("inserir_paletes") ?>" href="/POM-Logistica/Operador/inserir_paletes.php">Guia Entrega</a>
                    <a class="dropdown-item <?= echoActiveClassIfRequestMatches("Guia_Operador") ?>" href="/POM-Logistica/Operador/Guia_Operador.php">Guia Transporte</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= echoActiveClassIfRequestMatches("Listar_todas_as_guias") ?>" href="/POM-Logistica/Operador/Listagens/Listar_todas_as_guias.php">Consultar Pedidos</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?= echoActiveClassIfRequestMatches("mudar_pass") ?> data-toggle=" dropdown href="#" role="button" aria-haspopup="true" aria-expanded="false">Conta</a>
                <div class="dropdown-menu dropdown-menu-right animate slideIn">
                    <a class="dropdown-item <?= echoActiveClassIfRequestMatches("mudar_pass") ?>" href="/POM-Logistica/Operador/mudar_pass.php">Alterar Palavra-Passe</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= echoActiveClassIfRequestMatches("index") ?>" href="/POM-Logistica/index.php">Sair</a>
            </li>
        </ul>
    </nav>
</body>

</html>