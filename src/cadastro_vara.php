<?php
    include 'config.php';
    include 'verification.php';
    include '../components/navigation_bar.php'; ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/cadastre_se_style.css">
    <title>Cadastro de Vara</title>
</head>
<body>
<div class="container">
    <div class="center">
        <div class="right">
            <a href="dashboard.php" style="text-align: left;"><p class="registerLink" style="margin-left: 15px">&#8592 Voltar</p></a>
            <form action="cadastro_vara.php" method="post">
                <h2 style="font-family: 'Asap Condensed Medium'; font-weight: normal">Cadastro de vara judiciária</h2>
                <input type="text" placeholder="Nome da vara judiciária" name="vara">
                <br><br>
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
        <a href="cadastro_vara.php"><input type="button" class="backLogin" value="&#8592; Tentar novamente"></a>
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
        @$nome = $_POST["vara"];
        $sql = "INSERT INTO vara (nome) VALUES ('$nome')";


        if (mysqli_query($con, $sql)) {
            echo '<script>confirmationModal()</script>';
        } else {
            echo '<script>errorModal()</script>';
        }
    }
?>
