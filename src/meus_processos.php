<!doctype html>
<?php
    include 'config.php';
    include 'verification.php';
    include '../components/navigation_bar.php';

    @$userLogin = $_SESSION['usuario'];
    @$userId = $_SESSION['id'];

    @$url_id = mysqli_real_escape_string($con, $_SESSION['usuario']);
    @$id = mysqli_real_escape_string($con, $_SESSION['id']);

    $sql = "SELECT usuario FROM cliente WHERE usuario = '{$url_id}'";
    $result = mysqli_query($con, $sql);

    $sql2 = "SELECT usuario FROM funcionario WHERE usuario = '{$url_id}'";
    $result2 = mysqli_query($con, $sql2);

    $sql1 = "SELECT * FROM cliente WHERE usuario = '{$url_id}'";
    $result1 = mysqli_query($con, $sql1);
    $data1 = mysqli_fetch_array($result1);

    $sql3 = "SELECT * FROM funcionario WHERE usuario = '{$url_id}'";
    $result3 = mysqli_query($con, $sql3);
    $data2 = mysqli_fetch_array($result3);

    $sql4 = "SELECT * FROM advogado WHERE funcionario = '{$userId}'";
    $result4 = mysqli_query($con, $sql4);
    $data3 = mysqli_fetch_array($result4);

?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/register_style.css" rel="stylesheet">
    <link href="../css/dashboard_style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/cadastre_se_style.css">
    <title>Meus Processos</title>
</head>
<body>
    <?php
     if(mysqli_num_rows($result) > 0 && mysqli_num_rows($result2) == 0){
        $sqlC = "SELECT * FROM processo WHERE cliente = $userId";
        $resultC = mysqli_query($con, $sqlC);
            if($resultC != null){
                while($row = mysqli_fetch_array($resultC)){
                    echo "<div class=\"card\" style=\"text-align: left;  margin-bottom: 20px;\">"; 
                        $processoId = $row['id'];
                        echo "<input type=\"hidden\" value=\"$processoId\" name=\"potionId\">";
                        $numero =$row['numero'];
                        echo "<p> <span>Numero do processo: </span> ".$numero."</p>";
                        $assunto =$row['assunto'];
                        echo "<p> <span>Assunto: </span> ".$assunto."</p>";;
                        $movimentacao =$row['movimentacao'];
                        echo "<p> <span>Movimentação: </span> ".$movimentacao."</p>";
                        @$clienteId = $row['cliente'];
                        @$getClienteId = mysqli_query($con, "SELECT nome FROM cliente WHERE id = $clienteId");
                        while(@$resultClienteNome = mysqli_fetch_array($getClienteId)){
                            @$nomeCliente = @$resultClienteNome['nome'];
                        }
                        echo "<p> <span>Cliente: </span> ".$nomeCliente."</p>";
                        @$varaId = $row['vara'];
                        @$getVaraId = mysqli_query($con, "SELECT nome FROM vara WHERE id = $varaId");
                        while(@$resultVaraNome = mysqli_fetch_array($getVaraId)){
                            @$nomeVara = @$resultVaraNome['nome'];
                        }
                        echo "<p> <span>Vara: </span> ".$nomeVara."</p>";
                        @$advogadoId = $row['advogado'];
                        @$getAdvogadoId = mysqli_query($con, "SELECT nome FROM advogado WHERE id = $advogadoId");
                        while(@$resultAdvogadoNome = mysqli_fetch_array($getAdvogadoId)){
                            @$nomeAdvogado = @$resultAdvogadoNome['nome'];
                        }
                        echo "<p> <span>Advogado: </span> ".$nomeAdvogado."</p>";
                    echo "</div>";
                }
            }
    }
    $cargo = "advogado";

    if(mysqli_num_rows($result2) > 0 && mysqli_num_rows($result) == 0){
        if(strcmp($data2['cargo'], $cargo) === 0){
   
                echo '<div class="card" style="text-align: left;">';
                    echo '<h2 style="text-align: left;">Meus processos</h2>';
                    $getMyInfo = "SELECT * FROM funcionario WHERE id = '$userId'";
                    $resultMyInfo = mysqli_query($con, $getMyInfo);
                    while ($row = mysqli_fetch_array($resultMyInfo)){
                        @$advId = $row['id'];
                    }

                    $getMyInfoAdv = "SELECT * FROM advogado WHERE funcionario = '$advId'";
                    $resultMyInfoAdv = mysqli_query($con, $getMyInfoAdv);
                    while ($row = mysqli_fetch_array($resultMyInfoAdv)){
                        @$advTableId = $row['id'];
                    }

                    $getMeusProcessos = "SELECT * FROM processo WHERE advogado = '$advTableId'";
                    $resultMeusProcessos = mysqli_query($con, $getMeusProcessos);
                    while ($row = mysqli_fetch_array($resultMeusProcessos)){
//                        echo '<h4>Último processo cadastrado</h4>';
                        echo '<p><span style="font-weight: bold;">Número do processo:</span> '.$row['numero'].'</p>';
                        echo '<p><span style="font-weight: bold;">Assunto:</span> '.$row['assunto'].'</p>';
                        echo '<p><span style="font-weight: bold;">Última movimentação:</span> '.$row['movimentacao'].'</p>';
//                        echo '<input type="button" class="backLogin" value="Encerrar vínculo" style="background-color: #4D0916; width: 120px;">';
                        echo '<p><span style="font-weight: bold;">--------------------------------------------</span> </p>';
                    }
          
   
        }
    }
  
   
?>
<a href="dashboard.php" style="margin: auto;"><input type="button" class="backLogin" value="Ir para tela inicial &#8594;"></a>
</body>
</html>