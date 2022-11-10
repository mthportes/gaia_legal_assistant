<?php session_start(); ?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/index_style2.css">
    <title>Início</title>
</head>
<?php
    if(isset($_GET['msg'])){

        $msg = $_GET['msg'];

        if($msg == "error"){
            echo '<script>
                setInterval(function (){
                    document.getElementById("msgErro").innerHTML = "Erro: credenciais de login incorretas.";
                }, 1000);
               </script>';
        }

        if($msg == "logout"){
            echo '<script>
                setInterval(function (){
                    document.getElementById("msgErro").innerHTML = "Você saiu. Volte sempre!";
                }, 100);
               </script>';
        }
    }
?>
<body>
<div class="container">
    <div class="center">
        <div class="left">
            <h3>GAIA</h3>
            <span>
        Buscando facilitar a rotina de advogados no
    </span><br>
            <span>Brasil. O seu assistente para gestão </span><br>
            <span>
                jurídica de qualidade.
            </span>
            <br>
            <h4>Comece a usar agora</h4>
            <span>
            Entre em contato e realize um orçamento para<br>
        </span>
            <span>
            implementação do Gaia em seu escritório.
        </span>
            <br><br>
            <a href="https://unicuritiba.com.br" target="_blank">
                <button type="button" class="getStarted">
                    Orçamento
                </button>
            </a>
        </div>

        <div class="right">
            <form action="index.php" method="post">
                <p id="msgErro" style="text-align: center; padding-bottom: 10px"></p>
                <h2 style="font-family: 'Asap Condensed Medium'; font-weight: normal">Entre na sua conta</h2>
                <input type="text" placeholder="Nome de usuário" name="nomeUsuarioCliente">
                <br><br>
                <input type="password" placeholder="Senha" name="senhaCliente">
                <br> <br>
                <input type="submit" value="Login" class="loginButton" name="loginButton">
                <a href="cadastre_se.php"><p class="registerLink">Não possui conta? Cadastre-se</p></a>
            </form>
            <?php
                if(@$msg == "error" || @$msg == "logout"){
                    echo '<footer style="margin-top: 30%; font-size: small; font-family: Montserrat, sans-serif; color: darkgrey"><h4>Luana Povroznik & Matheus Portes</h4></footer>';
                } else {
                    echo '<footer style="margin-top: 40%; font-size: small; font-family: Montserrat, sans-serif; color: darkgrey"><h4>Luana Povroznik & Matheus Portes</h4></footer>';
                }
            ?>

        </div>
    </div>
</div>
</body>
</html>

<?php
    include 'config.php';

    if(@$_REQUEST['loginButton'] == "Login") {
        $nomeUsuarioCliente = $_POST["nomeUsuarioCliente"];
        $senhaCliente = md5($_POST["senhaCliente"]);


        $sql = "SELECT * FROM cliente WHERE usuario = '$nomeUsuarioCliente' AND senha = '$senhaCliente'";
        $sql2 = "SELECT * FROM funcionario WHERE usuario = '$nomeUsuarioCliente' AND senha = '$senhaCliente'";
        $result = mysqli_query($con, $sql);
        $result2 = mysqli_query($con, $sql2);

        if (mysqli_num_rows($result) > 0 || mysqli_num_rows($result2) > 0){
            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_array($result)){
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['usuario'] = $row['usuario'];
                }
            }
            
            if(mysqli_num_rows($result2) > 0){
                while ($row = mysqli_fetch_array($result2)){
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['usuario'] = $row['usuario'];
                }
            }

            echo "<script>top.location.href='dashboard.php';</script>";
        } else {
            echo "<script>top.location.href='index.php?msg=error';</script>";
        }
    }

?>