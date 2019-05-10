<!DOCTYPE html>
<html lang=pt dir="ltr">
<?php
include 'navbarOperador.php';
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") { }
?>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="card card-container" style="text-align:center; width:100%; max-width: 1000px">
            <p id="profile-name" class="profile-name-card"></p>
            <form class="container" action="pdfDevolucao.php" method="post">
                <div style="text-align:center">
                    <h1 style="margin-bottom:1rem;">Guia de devolução</h1>
                    <div class="container">
                        <div style="text-align:center">
                            <button type="submit" id="pdf" class="btn btn-primary" style="width:3.5rem; height:2.2rem; display:none; margin-top:-3.3rem; margin-right:13.5rem; text-align:center; float:right;">PDF</button>
                        </div>
                        <table class="table" style="font-size:16px;">
                            <thead>
                                <tr>
                                    <th width="20%">Cliente</th>
                                    <th>Dia e hora da carga</th>
                                    <th>Nº de paletes</th>
                                    <th>Artigo</th>
                                    <th>Armazém</th>
                                </tr>
                            </thead>
                            <tbody >
                            <?php 
                            $dado = mysqli_query($conn, "SELECT * FROM guia WHERE tipo_guia_id=2");
                            foreach ($dado as $eachRow) {
                                $cliID=$eachRow['cliente_id'];
                                $timeRN=$eachRow['data_prevista'];
                                $getArtigo=$eachRow['artigo_id'];
                                $GuiaID=$eachRow['id'];
                                $qtPal=$eachRow['numero_paletes'];
                                $numeroReq=$eachRow['numero_requisicao'];
                                $arID=$eachRow['armazem_id'];
                                $sql2 = mysqli_query($conn, "SELECT * FROM cliente WHERE id='$cliID'");
                                $sql3 = mysqli_fetch_array($sql2);
                                $nomeCliente = $sql3['nome'];
                                $sql4 = mysqli_query($conn, "SELECT * FROM armazem WHERE id='$arID'");
                                $sql5 = mysqli_fetch_array($sql4);
                                $nomeArmazem = $sql5['nome'];
                                $sql6 = mysqli_query($conn, "SELECT * FROM artigo WHERE id='$getArtigo'");
                                $sql7 = mysqli_fetch_array($sql6);
                                $refArtigo = $sql7['referencia'];
                                //Inacabado
                                echo '<tr>';
                                    echo '<td>'.$nomeCliente.'</td>';
                                        echo '<td>'.$timeRN.'</td>';
                                        echo '<td>'.$qtPal.'</td>';
                                        echo '<td>'.$refArtigo.'</td>';
                                         echo '<td>'.$nomeArmazem.'</td>';
                                         ?>
                                         <!-- <td><input type="submit" name="Ola" ></td> -->
                                         <td><button type="submit" name="GuiaID" value="<?php echo $GuiaID ?>">PDF</button></td>
                                         <?php
                                echo '</tr>';
                               
                                }
                                
                            ?>
                            
                            </tbody>
                        </table>
                    </div>
            </form><!-- /form -->
        </div><!-- /card-container -->
    </div><!-- /container -->
</body>

</html>
<script>
    $("#guia").on("change", function() {
        $.ajax({
            url: 'ajaxDevolucao.php',
            type: 'POST',
            data: {
                id: $("#guia").val()
            },
            success: function(data) {
                $("#pdf").css({
                    'display': 'block'
                })
                $("#tabela").html(data);
            },
        });
    });
</script>