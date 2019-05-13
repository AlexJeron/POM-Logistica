<!DOCTYPE html>
<html lang=pt dir="ltr">
<?php
//include 'operador.php';
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['Confirm'])) {
    $buscaId = mysqli_query($conn, "SELECT * FROM guia WHERE id='".$_POST['Confirm']."'");
        $dado = mysqli_fetch_array($buscaId);
        $tpID=$dado[ 'tipo_palete_id'];
        $arID=$dado['armazem_id'];
        $cliID=$dado['cliente_id'];
        date_default_timezone_set("Europe/Lisbon");
        $timeRN=date("Y-m-d H:i:s");
        $getCBtz=$dado['tipo_zona_id'];
        $getArtigo=$dado['artigo_id'];
        $qtPal=$dado['numero_paletes'];
        $numeroReq=$dado['numero_requisicao'];
   $sql = "INSERT INTO guia (cliente_id,guia_id, tipo_guia_id, tipo_palete_id, tipo_zona_id,armazem_id,artigo_id,data_prevista,numero_paletes, numero_requisicao,confirmar) VALUES ($cliID,'".$_POST['Confirm']."',3,$tpID, $getCBtz,$arID,$getArtigo, '$timeRN', $qtPal,'$numeroReq',1)";
if (mysqli_query($conn, $sql)) {
        
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
$sql2 = "UPDATE guia SET confirmar=1 where id='".$_POST['Confirm']."'";
if (mysqli_query($conn, $sql2)) {
        
} else {
  echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
}


}
elseif(isset($_POST['confirmTotal']))

{ 
  echo $_POST['confirmTotal'];
  
  $updateGuia = mysqli_query($conn,"UPDATE guia SET confirmarTotal=1 WHERE id='".$_POST['confirmTotal']."'");
  if (mysqli_query($conn, $updateGuia)) {
  }
} 
elseif (isset($_POST['Guia_ID2'])) {
  date_default_timezone_set("Europe/Lisbon");
        $timeRN=date("Y-m-d H:i:s");
  $dataehora = $timeRN;
  $referencia = $_POST['refpal'];
  $nomepal = $_POST['nomepal'];
  $eachLocalizacao = $_POST['comboBoxLocalizacao'];

  $buscaId = mysqli_query($conn, "SELECT guia.id,guia.artigo_id, guia.tipo_zona_id, zona.id as zonaid, zona.espaco as zonaespaco, armazem.espaco as armazemespaco,guia.tipo_palete_id,guia.armazem_id FROM guia INNER JOIN cliente on guia.cliente_id = cliente.id INNER JOIN artigo on guia.artigo_id=artigo.id INNER JOIN tipo_palete on guia.tipo_palete_id=tipo_palete.id INNER JOIN armazem on guia.armazem_id=armazem.id INNER JOIN zona on (zona.armazem_id=armazem.id and zona.tipo_zona_id=tipo_palete.id) where guia.id='".$_POST['Guia_ID2']."'");
  $dado = mysqli_fetch_array($buscaId);
  $tpID = $dado['tipo_palete_id'];
  $arID = $dado['armazem_id'];
  $artigo= $dado['artigo_id'];

  $zonaID = $dado['zonaid'];

  $getEspacoo = $dado['zonaespaco'];
  $espaco = $getEspacoo - 1;

  $getArmaID = $dado['armazemespaco'];
  $getEspaco2 = $dado['armazemespaco'];
  $espacoTotal = $getEspaco2 - 1;

  $result = $conn->query("SELECT count(*) FROM palete  WHERE referencia = '$referencia'");
  $row = $result->fetch_row();
  //echo '#: ', $row[0];
  $count = $row[0];

  $countEspaco = $conn->query("SELECT count(*) FROM localizacao  WHERE hasPalete = 1 AND zona_id=$zonaID");
  $row12 = $countEspaco->fetch_row();
  //echo '#: ', $row12[0];
  $countRows = $row12[0];

  date_default_timezone_set("Europe/Lisbon");
  $timeRN = date("Y-m-d H:i:s");
  $nomepal="Palete de $nomepal";
  $referencia="PAL-$referencia";



  if ($count == 0) {
    $sql = "INSERT INTO palete (guia_entrada_id, artigo_id, tipo_palete_id, referencia, nome, Data) VALUES ('".$_POST['Guia_ID2']."', '$artigo','$tpID', '$referencia','$nomepal', '$timeRN')";
    if (mysqli_query($conn, $sql)) {
      ?>
    <?php

  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }


  $buscaPaleteID = mysqli_query($conn, "SELECT id FROM palete WHERE referencia='$referencia'");
  $dado2 = mysqli_fetch_array($buscaPaleteID);
  $palete_idd = $dado2['id'];


  $sqlLocal = "UPDATE localizacao SET palete_id='$palete_idd', zona_id='$zonaID',data_entrada='$dataehora',hasPalete=1 WHERE id='$eachLocalizacao'";
  if (mysqli_query($conn, $sqlLocal)) { } else {
    echo "Error: " . $sqlLocal . "<br>" . mysqli_error($conn);
  }

  $sqlEspaco = "UPDATE armazem SET espaco='$espacoTotal' WHERE id='$getArmaID'";
  if (mysqli_query($conn, $sqlEspaco)) { } else {
    echo "Error: " . $sqlEspaco . "<br>" . mysqli_error($conn);
  }
  $sqlEspacoZona = "UPDATE zona SET espaco='$espaco' WHERE id='$zonaID'";
  if (mysqli_query($conn, $sqlEspacoZona)) { } else {
    echo "Error: " . $sqlEspacoZona . "<br>" . mysqli_error($conn);
  }
} else {
  ?>
    <script type="text/javascript">
      ;
      alert("Essa referencia de palete já existe");
    </script>
  <?php
}
}


}
?>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <link rel="stylesheet" href="styles\style2.css">
</head>

<body >
    <nav role="navigation">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="operador.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Guia_Operador_operador.php">Guia do Operador</a></li>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="showGuiaEntrega.php">Registar Palete</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="mudarpass_operador.php">Mudar Palavra-Passe</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="listagem_pedidos_armazem_operador.php">Pedidos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="Guia_Rececao.php">Imprimir Receção</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Guia_Devolucao.php">Imprimir Devolução</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Sair</a>
            </li>
        </ul>
    </nav>
    <form class="container" action="paletesTeste.php" method="post" id="mainForm" novalidate>
    
    <div class="container" id="onLoad" >
        <div class="card card-container" style="text-align:center; width:120%; margin-right:auto; margin-left:auto; max-width: 100000px">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <p id="profile-name" class="profile-name-card"></p>
           
                <div style="text-align:center">
                    <h1 style="margin-bottom:1rem;">Registar Paletes</h1>
                    <div class="container">
                    <nav role="navigation">
                      <ul class="nav">
                          <li class="nav-item">
                          <button class="btn2" type="button"  value ="1" id ="notConfirmed">Por Confirmar</button>
                          <button class="btn2" type="button" value ="2" id ="Confirmed">Confirmadas</button>
                          </li>
                      </ul>
                  </nav>
                        <!-- <div style="text-align:center">
                            <button type="submit" id="pdf" class="btn btn-primary" style="width:3.5rem; height:2.2rem; display:none; margin-top:-3.3rem; margin-right:17rem; text-align:center; float:right;">PDF</button>
                        </div> -->
                        <table class="table" style="font-size:16px; margin-top:1.5rem;">
                            <thead>
                                <tr>
                                    <th style="width:15%">Cliente</th>
                                    <th style="width:15%">N Guia</th>
                                    <th style="width:30%">Dia e hora da carga</th>
                                    <th style="width:15%">Nº de Paletes</th>
                                    <th style="width:20%">Artigo</th>
                                    <th style="width:20%">Armazém</th>
                                </tr>
                            </thead>
                            <tbody id="Testeeee">

                            </tbody>
                        </table>
                        <div id="DivEntrega"></div>
                        
                    </div>
            <!-- /form -->
        </div><!-- /card-container -->
    </div><!-- /container -->

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Registar um cliente</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                                      <div class="modal-body">
            
                                  
          <select style="text-align-last:center; margin-top:1rem; color: #6C757D;" class="form-control" name="comboBoxLocalizacao" id="comboBoxLocalizacao" required>
            <option value="" disabled selected>Localização</option>
            <?php
            $busca = mysqli_query($conn, "SELECT * FROM localizacao WHERE hasPalete=0");
            foreach ($busca as $eachRow) {
              ?>
              <option value=" <?php echo $eachRow['id'] ?>"><?php echo $eachRow['referencia'] ?></option>
            <?php
          }
          ?>
          </select>
          <div style="text-align:center;" class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" style="height:2.35rem; margin-top:1rem; width:5.65rem; text-indent:1.15rem;" id="inputGroup-sizing">PAL-</span>
            </div>
            <input type="text" class="form-control" style="width:5rem; margin-top:1rem;" placeholder="Referência da palete" name="refpal" required>
          </div>
          <div style="text-align:center; margin-top:-1.5rem;" class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" style="height:2.35rem; margin-top:1rem;" id="inputGroup-sizing">Palete de</span>
            </div>
            <input placeholder="Nome da palete" class="form-control" style="width:5rem; margin-top:1rem;" type="text" id="inputdata" name="nomepal" placeholder="Data" required>
          </div>
          </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary" name="save">Save changes</button>
                                      </div>
                           </div>
                         </div>
      </div>
      </form>

</body>

</html>

<script>
  $("#notConfirmed").on("click", function() {
    $.ajax({
      url: 'ajaxTeste.php',
      type: 'POST',
      data: {
        id: $("#notConfirmed").val()
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

<script>
  $("#Confirmed").on("click", function() {
    $.ajax({
      url: 'ajaxTeste.php',
      type: 'POST',
      data: {
        id: $("#Confirmed").val()
      },
      success: function(data) {
        
        $("#Confirmed").removeClass('btn2')
        $("#Confirmed").addClass('btn3')
        $("#notConfirmed").removeClass('btn3')
        $("#notConfirmed").addClass('btn2')
        $("#Testeeee").html(data);
      },
    });
  });
</script>


<script>
  $(document).ready(function(){
    $.ajax({
      url: 'ajaxTeste.php',
      type: 'POST',
      data: {
        id: $("#notConfirmed").val()
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
<script type="text/javascript">
$('mainForm').submit(function () {
   singleAmount =$("#confirmTotal").val();
   if (confirm("Are you sure you want to submit the value of " + singleAmount + " ?"))
      return true;
   else
     return false;
});
</script>