<!DOCTYPE html>
<html lang=pt dir="ltr">
<?php
include 'navbarAdmin.php';
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["data"]))
      {
      $data = $_POST["data"];
      }
    elseif (isset($_POST["saveEntrega"]))
    {
        $nomeCli = $_POST["comboboxCli"];
      $dataEntrega = $_POST["dataentrega"];
      $getCBart = $_POST["comboboxArtigo"];
      $getQT = $_POST["qt"];
      $getCBtp = $_POST["comboboxTipo_Palete"];
      $getCBtz = $_POST["comboboxTipoZona"];
      $getREQ = $_POST["req"];
      $getArmazem = $_POST["Armazem"];
      $getREQ="REQ-$getREQ";
      $stmt = $conn->prepare("INSERT INTO guia (cliente_id, tipo_guia_id, tipo_palete_id, tipo_zona_id,armazem_id,artigo_id,data_prevista,numero_paletes, numero_requisicao) VALUES (?,1,?,?,?,?,?,?,?)");
      $stmt->bind_param("iiiiisis", $nomeCli, $getCBtp, $getCBtz, $getArmazem, $getCBart, $dataEntrega, $getQT, $getREQ);
      $stmt->execute();
    }
    elseif (isset($_POST["saveTransporte"]))
    {
      $cliente = $_POST['cliente'];
    $matricula = $_POST["matricula"];
    $horadescarga = $_POST["horadescarga"];
    $morada = $_POST["morada"];
    $nreq = $_POST["Referencia"];
    $npal = $_POST["NPaletes"];
    $artigoo = $_POST["artigo"];
    $Localidade = $_POST["Localidade"];
    $nreq="REQ-$nreq";


    
        $stmt = $conn->prepare("SELECT palete.tipo_palete_id as tipo_palete_id, palete.id as id, localizacao.zona_id as zona_id, zona.armazem_id as armazem_id, zona.tipo_zona_id as tipo_zona_id FROM palete INNER JOIN localizacao on localizacao.palete_id=palete.id INNER JOIN zona on zona.id=localizacao.zona_id WHERE artigo_id=?");
        $stmt->bind_param("s", $artigoo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($tipoPalete, $paleteeID, $zonaID,$armazemID,$tipoZona);
        $stmt->fetch();
    //echo $armazemID;

    $stmt = $conn->prepare("INSERT INTO guia (cliente_id, tipo_guia_id, tipo_palete_id, tipo_zona_id, armazem_id, artigo_id, data_prevista, numero_paletes, numero_requisicao, morada, localidade, matricula) VALUES (?,2,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("iiiiisissss", $cliente, $tipoPalete, $tipoZona, $armazemID, $artigoo, $horadescarga, $npal,$nreq, $morada, $Localidade, $matricula);
    $stmt->execute();
    }
}
?>

<head>
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles\table.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="node_modules\jquery\dist\jquery.js">
</head>

<style>
    body {
        overflow: hidden;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 0.3rem;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #007bff;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #0056b3;
    }

    .btn-success {
        background-color: #01d932;
    }

    .btn-success:hover {
        background-color: #01bc2c;
    }

    body {
        color: #566787;
    }

    table,
    tr td {
        /* border: 1px solid red */
    }

    tbody {
        display: block;
        max-height: 22rem;
        overflow-y: auto;
        overflow-x: hidden;
    }

    thead,
    tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
        /* even columns width , fix width of table too*/
    }

    thead {
        width: calc(100% - 1rem)
            /* scrollbar is average 1em/16px width, remove it from thead width */
    }
</style>

<body>
    <?php
    $timeRN = date("Y-m-d");
    ?>
    <div class="row align-items-center">
        <div class="card card-container" style="text-align:center; width:85rem; height:35rem; margin-bottom:auto; max-width: 10000px;">
            <p id="profile-name" class="profile-name-card"></p>
            <form class="container" action="Listar_todas_as_guiasAdmin.php" method="post">
                
                
                <div style="text-align:center;">
                    <h1 style="margin-bottom:1rem;">Todas as Guias</h1>
                    <input class="form-control" style="text-align:center; text-indent:1.5rem; margin-left:auto; margin-right:auto; width:17rem;"  id="DataEntrega2"  type="date" name="DataEntrega2">
                    </div>
                    <ul class="nav nav-pills">
                    <li class="nav-item">
                        <button style="border-radius:0.2rem; margin-right:1rem;" class="nav-link active" value="1" data-toggle="pill" id="notConfirmed" >Entrega</button>
                    </li>
                    <li class="nav-item">
                        <button style="border-radius:0.2rem;" class="nav-link" value="2" data-toggle="pill" id="Confirmed">Transporte</button>
                    </li>
                    </ul>
                    <br>
                    <div id="guiaTeste">
                    </div>
                        <table style="margin-top:2rem; margin-left:-25px; width: 1160px; text-align:center" class="table">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Nº de requisição</th>
                                    <th>Armazém</th>
                                    <th>Nº paletes</th>
                                    <th style="width:17%">Data e hora prevista</th>
                                    <th>Morada</th>
                                </tr>
                            </thead>
                            <tbody id="Testeeee">
                                <?php
                                date_default_timezone_set("Europe/Lisbon");
                                ?>
                            </tbody>
                        </table>
                     <!--MODAL HERE -->
                     <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModal" aria-hidden="true">
            <div class="modal-dialog" role="document" id="ModalGuia">
              
                </div>
              </div>

            </form><!-- /form -->
        </div><!-- /card-container -->
    </div><!-- /container -->
    <script type="text/javascript"></script>
    <script type="text/javascript"></script>
</body>

</html>

<script>
  $("#notConfirmed").on("click", function() {
    $.ajax({
      url: 'ajaxPedidosTotais.php',
      type: 'POST',
      data: {
        id: $("#notConfirmed").val(),dataescolhida: $("#DataEntrega2").val()
      },
      success: function(data) {
        $("#notConfirmed").removeClass('btn2')
        $("#notConfirmed").addClass('btn3')
        $("#Confirmed").removeClass('btn3')
        $("#Confirmed").addClass('btn2')
        $("#Testeeee").html(data);
      },
    });
    $.ajax({
      url: 'ajaxGuiaTeste.php',
      type: 'POST',
      data: {
        id: $("#notConfirmed").val(),
        
      },
      success: function(data) {
        $("#guiaTeste").html(data);
      },
    });
  });
</script>

<script>
  $("#Confirmed").on("click", function() {
    $.ajax({
      url: 'ajaxPedidosTotais.php',
      type: 'POST',
      data: {
        id: $("#Confirmed").val(),
        dataescolhida: $("#DataEntrega2").val()
        
      },
      success: function(data) {

        $("#Confirmed").removeClass('btn2')
        $("#Confirmed").addClass('btn3')
        $("#notConfirmed").removeClass('btn3')
        $("#notConfirmed").addClass('btn2')
        $("#Testeeee").html(data);
      },
    });
    $.ajax({
      url: 'ajaxGuiaTeste.php',
      type: 'POST',
      data: {
        id: $("#Confirmed").val(),
        
      },
      success: function(data) {
        $("#guiaTeste").html(data);
      },
    });
  });
</script>

<script>
  $(document).ready(function() {
    $.ajax({
      url: 'ajaxPedidosTotais.php',
      type: 'POST',
      data: {
        id: $("#notConfirmed").val(), dataescolhida: $("#DataEntrega2").val()
      },
      success: function(data) {
        $("#notConfirmed").removeClass('btn2')
        $("#notConfirmed").addClass('btn3')
        $("#Confirmed").removeClass('btn3')
        $("#Confirmed").addClass('btn2')
        $("#Testeeee").html(data);
      },
    });
    $.ajax({
      url: 'ajaxGuiaTeste.php',
      type: 'POST',
      data: {
        id: $("#notConfirmed").val(),
        
      },
      success: function(data) {
        $("#guiaTeste").html(data);
      },
    });
  });
</script>

<script>
 $("#DataEntrega2").on("change", function() {
    $.ajax({
      url: 'ajaxPedidosTotais.php',
      type: 'POST',
      data: {
        id: $("#notConfirmed").val(), dataescolhida: $("#DataEntrega2").val()
      },
      success: function(data) {
        $("#notConfirmed").removeClass('btn2')
        $("#notConfirmed").addClass('btn3')
        $("#Confirmed").removeClass('btn3')
        $("#Confirmed").addClass('btn2')
        $("#Testeeee").html(data);
      },
    });
  });
</script>



