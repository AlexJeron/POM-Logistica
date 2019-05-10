<!DOCTYPE html>
<html lang=pt dir="ltr">
<?php
//include 'operador.php';
include 'db.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["Nome"];
        $nifNumber = $_POST["nif"];
        $nifNumberr = (int)$nifNumber;
        $Morada = $_POST["morada"];
        $localidade = $_POST["local"];
    
        $sql = "INSERT INTO cliente (nome,nif,morada, localidade) VALUES ('$nome',$nifNumberr,'$Morada', '$localidade')";
        if (mysqli_query($conn, $sql)) {
        }
 }
?>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body>
    <nav role="navigation">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="operador.php">Home</a>
                </li>
            <li class="nav-item">
                <a class="nav-link active" href="ListarClientes.php">Registar Cliente</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ListarUtilizadores.php">Registar Utilizador</a></li>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="mudarpass_admin.php">Mudar Palavra-Passe</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="listagem_pedidos_armazem_admin.php">Pedidos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="fatura_cliente.php">Fatura</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Sair</a>
            </li>
        </ul>
    </nav>
    <div class="container">
    
        <div class="card card-container" style="text-align:center; width:100%; max-width: 100000px">
        
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <p id="profile-name" class="profile-name-card"></p>
            <form class="container" action="ListarClientes.php" method="post">
                <div style="text-align:center">
                    <h1 style="margin-bottom:1rem;">Clientes</h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Registar Cliente
</button>
                    <div class="container">
                        <div style="text-align:center">
                            <button type="submit" id="pdf" class="btn btn-primary" style="width:3.5rem; height:2.2rem; display:none; margin-top:-3.3rem; margin-right:17rem; text-align:center; float:right;">PDF</button>
                        </div>
                        <table class="table" style="font-size:16px;">
                            <thead>
                                <tr>
                                    <th style="width:15%">Cliente</th>
                                    <th style="width:30%">NIF</th>
                                    <th style="width:40%">Morada</th>
                                    <th style="width:30%">Localidade</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $dado = mysqli_query($conn, "SELECT * FROM cliente");
                            foreach ($dado as $eachRow) {

                                $nomeID=$eachRow['id'];
                                $Nome=$eachRow['nome'];
                                $nif = $eachRow['nif'];
                                $Morada = $eachRow['morada'];
                                $Localidade = $eachRow['localidade'];
                                //Inacabado
                                echo '<tr>';
                                    echo '<td> '.$Nome.'</td>';
                                        echo '<td> '.$nif.'</td>';
                                        echo '<td> '.$Morada.'</td>';
                                        echo '<td> '.$Localidade.'</td>';
                                echo '</tr>';
                                }
                                ?>
                               
                            </tbody>
                            
                        </table>
                        
      
                        </div>
                      </div>
                    </div>
                <!-- Button trigger modal -->


<!-- Modal -->
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
                            <input style="margin-top:1rem; height:auto;" type="input" name="Nome" class="form-control" placeholder="Nome" pattern="[A-Za-z\sâàáêèééìíôòóùúçãõ ]+" title="Apenas deve conter letras." required autofocus>
                            <input style="margin-top:1rem; height:auto;" type="number" id="uintTextBox" name="nif" class="form-control" placeholder="NIF" max="999999999" pattern=".{9,}" minlength=9 maxlength=9 title="O NIF tem de ter 9 dígitos." required>
                            <input style="margin-top:1rem; height:auto;" type="input" name="morada" class="form-control" placeholder="Morada" pattern="[A-Za-z0-9\sâàáêèééìíôòóùúçãõªº-;,. ]+" required>
                            <input style="margin-top:1rem; height:auto;" type="input" name="local" class="form-control" placeholder="Localidade" pattern="[A-Za-z0-9\sâàáêèééìíôòóùúçãõªº-;,. ]+" pattern="[A-Za-z]+" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
       </div>
      </div>
</div>
            </form><!-- /form -->
        </div><!-- /card-container -->
        
    </div><!-- /container -->
    
</body>

</html>
<script>
        function setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                textbox.addEventListener(event, function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    }
                });
            });
        }
        setInputFilter(document.getElementById("uintTextBox"), function(value) {
            return /^\d*$/.test(value);
        });
    </script>
