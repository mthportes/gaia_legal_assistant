<?php
    include 'verification.php';
    include 'config.php';
    include '../components/navigation_bar.php';

    @$userLogin = $_SESSION['usuario'];
    @$userId = $_SESSION['id'];
    @$userNome = $_SESSION['nome'];
?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/dashboard_style.css" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body>
    <?php
    @$url_id = mysqli_real_escape_string($con, $_SESSION['usuario']);
    $sql = "SELECT usuario FROM cliente WHERE usuario = '{$url_id}'";
    $result = mysqli_query($con, $sql);

    $sql1 = "SELECT * FROM cliente WHERE usuario = '{$url_id}'";
    $result1 = mysqli_query($con, $sql1);
    $data1 = mysqli_fetch_array($result1);

    $sql2 = "SELECT usuario FROM funcionario WHERE usuario = '{$url_id}'";
    $result2 = mysqli_query($con, $sql2);

    $sql3 = "SELECT * FROM funcionario WHERE usuario = '{$url_id}'";
    $result3 = mysqli_query($con, $sql3);
    $data2 = mysqli_fetch_array($result3);

    if(mysqli_num_rows($result) > 0 && mysqli_num_rows($result2) == 0){
        echo "<h1 style=\"font-size: 26px; margin-left: 10px;\">Bem vindo, ". $data1['nome']."</h1>";
        echo '<div class="row">';
        echo '<div class="column">';
            echo '<div class="card" style="text-align: left;">';
                echo '<h2 style="text-align: left;">Meus processos</h2>';
                    $getMyInfo = "SELECT * FROM cliente WHERE id = '$userId'";
                    $resultMyInfo = mysqli_query($con, $getMyInfo);
                    while ($row = mysqli_fetch_array($resultMyInfo)){
                       @$clienteId = $row['id'];
                    }

                    $getMeusProcessos = "SELECT * FROM processo WHERE cliente = '$clienteId'";
                    $resultMeusProcessos = mysqli_query($con, $getMeusProcessos);
                    while ($row = mysqli_fetch_array($resultMeusProcessos)){
                        echo '<p><span style="font-weight: bold;">Número do processo:</span> '.$row['numero'].'</p>';
                        echo '<p><span style="font-weight: bold;">Assunto:</span> '.$row['assunto'].'</p>';
                        echo '<p><span style="font-weight: bold;">Última movimentação:</span> '.$row['movimentacao'].'</p>';
                        echo '<p><span style="font-weight: bold;">--------------------------------------------</span> </p>';
                    }
            echo '</div>';
            echo '</div>';
            //echo '<div class="column">';
              //  echo '<div class="card">';
                //    echo '<p>grafico</p>';
                //echo '</div>';
            //echo '</div>';
            echo '<div class="column">';
                echo '<div class="card" style="text-align: left;">';
                    echo '<h2>Meus agendamentos</h2>';

                        $getMyInfo = "SELECT * FROM cliente WHERE id = '$userId'";
                        $resultMyInfo = mysqli_query($con, $getMyInfo);
                        while ($row = mysqli_fetch_array($resultMyInfo)){
                            @$clienteId = $row['id'];
                        }

                        $getMinhasReunioes = "SELECT * FROM reuniao WHERE cliente = '$clienteId' 
                                                ORDER BY data ASC LIMIT 0, 10";
                        $resultMinhasReunioes = mysqli_query($con, $getMinhasReunioes);
                        $hoje = date_create()->format('Y-m-d');
                        echo '<script>console.log("'.$hoje.'")</script>';
                        while ($row = mysqli_fetch_array($resultMinhasReunioes)){
                            if ($row['data'] < $hoje){
                                $oldDate = date_create($row['data']);
                                $novaData = date_format($oldDate, "d/M/y");
                                echo '<p><span style="font-weight: bold; text-decoration: line-through">Data: '.$novaData.'</span> — já realizada.</p>';
                            } else if ($row['data'] == $hoje){
                                $oldDate = date_create($row['data']);
                                $novaData = date_format($oldDate, "d/M/y");
                                echo '<p style="font-weight: bold; color: green"><span style="font-weight: bold;">Data:</span> '.$novaData.' — hoje!</p>';
                            } else {
                                $oldDate = date_create($row['data']);
                                $novaData = date_format($oldDate, "d/M/y");
                                echo '<p style="color: grey"><span style="font-weight: bold;">Data:</span> '.$novaData.'</p>';
                            }

                        }
                echo '</div>';
            echo '</div>';
        echo '</div>';

    }
    
    $cargo = "advogado";

    if(mysqli_num_rows($result2) > 0 && mysqli_num_rows($result) == 0){
        if(strcmp($data2['cargo'], $cargo) === 0){
            echo "<h1 style=\"font-size: 26px; margin-left: 10px;\">Bem vindo, ". $data2['nome']."</h1>";

            echo '<div class="row">';
            echo '<div class="column">';
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
                        echo '<p><span style="font-weight: bold;">Número do processo:</span> '.$row['numero'].'</p>';
                        echo '<p><span style="font-weight: bold;">Assunto:</span> '.$row['assunto'].'</p>';
                        echo '<p><span style="font-weight: bold;">Última movimentação:</span> '.$row['movimentacao'].'</p>';
                        echo '<p><span style="font-weight: bold;">--------------------------------------------</span> </p>';
                    }
                echo '</div>';
                echo '</div>';
                //echo '<div class="column">';
                  //  echo '<div class="card">';
                    //    echo '<p>grafico</p>';
                    //echo '</div>';
                //echo '</div>';
                echo '<div class="column">';
                    echo '<div class="card" style="text-align: left;">';
                        echo '<h2 style="text-align: left;">Meus agendamentos</h2>';
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

                        $getMinhasReunioes = "SELECT * FROM reuniao WHERE advogado = '$advTableId' ORDER BY data ASC";
                        $resultMinhasReunioes = mysqli_query($con, $getMinhasReunioes);
                        $hoje = date_create()->format('Y-m-d');
                        echo '<script>console.log("'.$hoje.'")</script>';
                        while ($row = mysqli_fetch_array($resultMinhasReunioes)){
                            if ($row['data'] < $hoje){
                                $oldDate = date_create($row['data']);
                                $novaData = date_format($oldDate, "d/M/y");
                                echo '<p><span style="font-weight: bold; text-decoration: line-through">Data: '.$novaData.'</span> — já realizada.</p>';
                            } else if ($row['data'] == $hoje){
                                $oldDate = date_create($row['data']);
                                $novaData = date_format($oldDate, "d/M/y");
                                echo '<p style="font-weight: bold; color: green"><span style="font-weight: bold;">Data:</span> '.$novaData.' — hoje!</p>';
                            } else {
                                $oldDate = date_create($row['data']);
                                $novaData = date_format($oldDate, "d/M/y");
                                echo '<p style="color: grey"><span style="font-weight: bold;">Data:</span> '.$novaData.'</p>';
                            }
                        }
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        } else{
            echo "<script>console.log('No dasboard: ".$data2['cargo']."');</script>";
            echo "<h1 style=\"font-size: 26px\">Bem vindo ao Dashboard ". $data2['nome']."</h1>";
    
            echo '<div class="row">';
            echo '<div class="column">';
                echo '<div class="card">';
                    echo '<p>funcionario padrão</p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="column">';
                    echo '<div class="card">';
                        echo '<p>grafico</p>';
                    echo '</div>';
                echo '</div>';
                echo '<div class="column">';
                echo '<div class="column">';
                    echo '<div class="card">';
                        echo '<p>agendamentos</p>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
?>
</body>
</html>