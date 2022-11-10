<?php
    include 'config.php';
    include 'verification.php';
    include '../components/navigation_bar.php'
; ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/cadastre_se_style.css">
    <title>Novo Agendamento</title>
</head>
<?php
    @$user_name = mysqli_real_escape_string($con, $_SESSION['usuario']);
    $sql = "SELECT * FROM funcionario WHERE usuario = '{$user_name}'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_array($result)){
            @$userRole = $row['cargo'];
        }
    }
?>
<body>
<div class="container">
    <div class="center">
        <div class="right">
            <a href="dashboard.php" style="text-align: left;"><p class="registerLink" style="margin-left: 15px">&#8592 Voltar</p></a>
            <form action="novo_agendamento.php" method="post">
                <h2 style="font-family: 'Asap Condensed Medium'; font-weight: normal">Novo agendamento</h2>
                <?php if (@$userRole != "advogado"){?>
                    <label for="dataReuniao" style="margin-right: 85px">Data desejada:</label>
                    <input type="date" name="dataReuniao"><br><br>
                    <label for="advogadoReuniao">Advogado responsável: </label>
                    <select name="advogadoReuniao" id="" required style="margin-left: 10px">
                        <option value="#" selected disabled>Selecione...</option>
                        <?php
                            @$userId = $_SESSION['id'];
                            $sql3 = "SELECT * FROM processo WHERE cliente = '{$userId}'";
                            $result3 = mysqli_query($con, $sql3);

                            if(mysqli_num_rows($result3) > 0){
                                while ($row = mysqli_fetch_array($result3)){
                                    @$idAdvogado = $row['advogado'];
                                }
                            }
                            $sql4 = "SELECT * FROM advogado WHERE id = '$idAdvogado'";
                            $result4 = mysqli_query($con, $sql4);
                            if(mysqli_num_rows($result4) > 0){
                                while ($row = mysqli_fetch_array($result4)){
                                    @$funcionarioId = $row['funcionario'];
                                }
                            }

                            $sql5 = "SELECT * FROM funcionario WHERE id = '$funcionarioId'";
                            $result5 = mysqli_query($con, $sql5);
                            if(mysqli_num_rows($result5) > 0){
                                while ($row = mysqli_fetch_array($result5)){
                                    echo '<option value="'.$row['nome'].'">'.$row['nome'].' - OAB/PR: '.$row['oab'].'</option>';
                                }
                            }
                        ?>
                    </select><br><br>
                    <textarea name="assuntoReuniao" id="" cols="35" rows="7" placeholder="Descreva o assunto da reunião..."></textarea><br><br>
                    <input type="submit" value="Agendar" class="loginButton" name="agendamento" id="registerButton">
                <?php } else {?>
                    <label for="dataReuniao" style="margin-right: 85px">Data desejada:</label>
                    <input type="date" name="dataReuniao"><br><br>
                    <label for="clienteReuniao">Cliente atendido: </label>
                    <select name="clienteReuniao" id="" required style="margin-left: 60px">
                        <option value="#" selected disabled>Selecione...</option>
                        <?php
                        @$userId = $_SESSION['id'];
                        $sql3 = "SELECT * FROM advogado WHERE funcionario = '{$userId}'";
                        $result3 = mysqli_query($con, $sql3);

                        if(mysqli_num_rows($result3) > 0){
                            while ($row = mysqli_fetch_array($result3)){
                                @$idAdvogado = $row['id'];
                            }
                        }

                        $sql4 = "SELECT * FROM processo WHERE advogado = '$idAdvogado'";
                        $result4 = mysqli_query($con, $sql4);
                        if(mysqli_num_rows($result4) > 0){
                            while ($row = mysqli_fetch_array($result4)){
                                @$idCliente = $row['cliente'];
                            }
                        }

                        $sql5 = "SELECT * FROM cliente WHERE id = '$idCliente'";
                        $result5 = mysqli_query($con, $sql5);
                        if(mysqli_num_rows($result5) > 0){
                            while ($row = mysqli_fetch_array($result5)){
                                echo '<option value="'.$row['nome'].'">'.$row['nome'].'</option>';
                            }
                        }
                        ?>
                    </select><br><br>
                    <textarea name="assuntoReuniao" id="" cols="35" rows="7" placeholder="Descreva o assunto da reunião..."></textarea><br><br>
                    <input type="submit" value="Agendar" class="loginButton" name="agendamento" id="registerButton">
                <?php }?>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <p class="confirmationRegister">Agendado com sucesso.</p>
        <a href="dashboard.php"><input type="button" class="backLogin" value="Ir para dashboard &#8594;"></a>
    </div>
</div>

<div id="errorModal" class="modal">
    <div class="modal-content">
        <p class="confirmationRegister">Erro ao tentar realizar agendamento.</p>
        <a href="novo_agendamento.php"><input type="button" class="backLogin" value="&#8592; Tentar novamente"></a>
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
if(@$_REQUEST['agendamento'] == "Agendar") {
    @$dataReuniao = $_POST['dataReuniao'];
    @$assuntoReuniao = $_POST['assuntoReuniao'];

    if($userRole == "advogado"){
        @$clienteDesejado = $_POST['clienteReuniao'];
        $consultaCliente = "SELECT * FROM cliente WHERE nome = '$clienteDesejado'";
        $resultCliente = mysqli_query($con, $consultaCliente);
        while($row = mysqli_fetch_array($resultCliente)){
            @$idCliReuniao = $row['id'];
        }

        $consultaIdUsuario = "SELECT * FROM advogado WHERE funcionario = '$userId'";
        $resultConsultIdUser = mysqli_query($con, $consultaIdUsuario);
        while($row = mysqli_fetch_array($resultConsultIdUser)){
            @$idUserAdv = $row['id'];
        }

        $sql = "INSERT INTO reuniao (data, assunto, cliente, advogado, processo)
                        VALUES ('$dataReuniao', '$assuntoReuniao', '$idCliReuniao', '$idUserAdv', null)";

        if (mysqli_query($con, $sql)) {
            echo '<script>confirmationModal()</script>';
        } else {
            echo "<script>console.log('".mysqli_error($con)."');</script>";
            echo '<script>errorModal()</script>';
        }
    } else {
        @$advogadoReuniao = $_POST['advogadoReuniao'];
        $consultaAdv = "SELECT * FROM funcionario WHERE nome = '$advogadoReuniao'";
        $resultAdv = mysqli_query($con, $consultaAdv);
        while($row = mysqli_fetch_array($resultAdv)){
            @$idAdvReuniao = $row['id'];
        }

        $consultaIdUsuario = "SELECT * FROM advogado WHERE funcionario = '$idAdvReuniao'";
        $resultConsultIdUser = mysqli_query($con, $consultaIdUsuario);
        while($row = mysqli_fetch_array($resultConsultIdUser)){
            @$idUserAdv = $row['id'];
        }

        $sql = "INSERT INTO reuniao (data, assunto, cliente, advogado, processo)
                        VALUES ('$dataReuniao', '$assuntoReuniao', '$userId', '$idUserAdv', null)";

        if (mysqli_query($con, $sql)) {
            echo '<script>confirmationModal()</script>';
        } else {
            echo "<script>console.log('".mysqli_error($con)."');</script>";
            echo '<script>errorModal()</script>';
        }
    }
}
?>
