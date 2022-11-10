<?php
    session_start();
    include 'config.php';
    include '../components/navigation_bar.php'; ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/cadastre_se_style.css">
    <title>Cadastro de Processo</title>
</head>
<body>
<div class="container">
    <div class="center">
        <div class="right">
            <a href="dashboard.php" style="text-align: left;"><p class="registerLink" style="margin-left: 15px">&#8592 Voltar</p></a>
            <form action="cadastro_processo.php" method="post">
                <h2 style="font-family: 'Asap Condensed Medium'; font-weight: normal">Cadastro de Processo</h2>
                <input type="text" placeholder="Número do processo" name="numero">
                <br><br>
                <input type="text" placeholder="Assunto" name="assunto">
                <br><br>
                <div style="text-align: left; margin-left: 200px">
                    <span>Movimentação: <input type="date" required="required" name="movimentacao" style="margin-left:10px"></span>
                    <br><br>
                    <label for="cliente"><span>Cliente</span></label>
                        <?php
                        $sqlGet = "SELECT nome FROM cliente ORDER BY nome ASC";
                        $resultGet = mysqli_query($con, $sqlGet);
                        echo '<select name="cliente" id="cliente"  style="margin-left:70px">';
                        while($row = mysqli_fetch_array($resultGet)){
                            echo "<option style='color: grey' value='{$row['nome']}'>" . $row['nome'] . "</option>";
                        }
                        echo '</select>';
                        ?>
                    <br><br>
                    <label for="vara"><span>Vara judiciária</span></label>
                        <?php
                        $sqlGet = "SELECT nome FROM vara ORDER BY nome ASC";
                        $resultGet = mysqli_query($con, $sqlGet);
                        echo '<select name="vara" id="vara"  style="margin-left:20px">';
                        while($row = mysqli_fetch_array($resultGet)){
                            echo "<option style='color: grey' value='{$row['nome']}'>" . $row['nome'] . "</option>";
                        }
                        echo '</select>';
                        ?>
                    <br><br>
                    <label for="advogado"><span>Advogado</span></label>
                        <?php
                        $sqlGet = "SELECT nome FROM advogado ORDER BY nome ASC";
                        $resultGet = mysqli_query($con, $sqlGet);
                        echo '<select name="advogado" id="advogado" style="margin-left:50px">';
                        while($row = mysqli_fetch_array($resultGet)){
                            echo "<option style='color: grey' value='{$row['nome']}'>" . $row['nome'] . "</option>";
                        }
                        echo '</select>';
                        ?>
                    <br><br>
                </div>
                <input type="submit" value="Cadastrar" class="loginButton" name="cadastro" id="registerButton">
            </form>
        </div>
    </div>
</div>
</body>
</html>

<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <p class="confirmationRegister">Cadastrado com sucesso.</p>
        <a href="dashboard.php"><input type="button" class="backLogin" value="Ir para o inicio &#8594;"></a>
    </div>
</div>

<div id="errorModal" class="modal">
    <div class="modal-content">
        <p class="confirmationRegister">Erro ao tentar realizar cadastro.</p>
        <a href="cadastro_processo.php"><input type="button" class="backLogin" value="&#8592; Tentar novamente"></a>
    </div>
</div>

<script>
    function confirmationModal(){
        const modal = document.getElementById("confirmationModal");
        modal.style.display = "block";
    }

    function errorModal(){
        const modal = document.getElementById("errorModal");
        modal.style.display = "block";
    }
</script>
<?php
    if(@$_REQUEST['cadastro'] == "Cadastrar") {
        @$numero = $_POST["numero"];
        @$assunto = $_POST["assunto"];
        @$movimentacao = $_POST["movimentacao"];
        @$cliente = $_POST["cliente"];
        @$vara = $_POST["vara"];
        @$advogado = $_POST["advogado"];

        @$getClienteId = mysqli_query($con, "SELECT id FROM cliente WHERE nome = '".@$cliente."'");
        while(@$resultCliente = mysqli_fetch_array($getClienteId)){
            @$clienteId = @$resultCliente['id'];
        }

        @$getVaraId = mysqli_query($con, "SELECT id FROM vara WHERE nome = '".@$vara."'");
        while(@$resultVara = mysqli_fetch_array($getVaraId)){
            @$varaId = @$resultVara['id'];
        }

        @$getAdvogadoId = mysqli_query($con, "SELECT id FROM advogado WHERE nome = '".@$advogado."'");
        while(@$resultAdvogado = mysqli_fetch_array($getAdvogadoId)){
            @$advogadoId = @$resultAdvogado['id'];
        }
        echo $numero;
        echo $assunto;
        echo $movimentacao;
        echo $clienteId;
        echo $varaId;
        echo $advogadoId;
        $sql = "INSERT INTO processo (numero, assunto, movimentacao, cliente, vara, advogado, status) 
            VALUES ('$numero', '$assunto', '$movimentacao', '$clienteId', '$varaId', '$advogadoId', 0)";


        if (mysqli_query($con, $sql)) {
            echo '<script>confirmationModal()</script>';
        } else {
            echo '<script>errorModal()</script>';
        }
    }
?>
