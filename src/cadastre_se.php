<?php
    session_start();
    include 'config.php';
    include 'host.php';
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/cadastre_se_style.css">
    <?php
    
        @$url_id = mysqli_real_escape_string($con, $_SESSION['usuario']);
        $sql2 = "SELECT * FROM funcionario WHERE usuario = '{$url_id}'";
        $result2 = mysqli_query($con, $sql2);

        if(mysqli_num_rows($result2) > 0){
                while ($row = mysqli_fetch_array($result2)){
                    @$userRole = $row['cargo'];
                }
        }

    ?>
    <title>Cadastre-se</title>
</head>

<body>
<div class="container">
    <div class="center">
        <div class="right">
            <form action="cadastre_se.php" method="post" enctype="multipart/form-data">
                <?php 
                    if (!isset($_SESSION['usuario']) || !isset($_SESSION['id'])) {
                        echo '<h2 style="font-family: \'Asap Condensed Medium\'; font-weight: normal">Cadastre-se</h2>';
                    } else {
                        echo '<h2 style="font-family: \'Asap Condensed Medium\'; font-weight: normal">Cadastrar novo usuário</h2>';
                    }
                ?>
                <select name="cargoUsuario" id="cargoUsuario" style="margin-right: 90px" onchange="mostrarCampos()">
                    <option value="Cliente">Cliente</option>
                    <?php 
                        if(@$userRole == "advogado"){
                            echo '<option value="secretario">Secretária</option>';
                            echo '<option value="advogado">Advogada</option>';
                        }
                    ?>
                </select>
                <label for="avatar" class="avatarButton" id="avatarUpload">
                    Escolha seu avatar
                </label>
                <input name="avatar" id="avatar" type="file" accept="image/jpg, image/jpeg, image/png" style="display: none"/><br><br>
                <input type="text" placeholder="Nome completo" name="nomeUsuario" required>
                <br><br>
                <input type="password" placeholder="Senha" name="senhaUsuario" required>
                <br> <br>
                <input type="text" placeholder="CPF (apenas números)" name="cpfUsuario" id="cpfUsuario" required
                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                       onfocusout="checkCPF('<?php echo $localUrl; ?>')">
                <script>
                    function checkCPF(url) {
                        fetch(`${url}/api/checar_cpf.php`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                            },
                            body: `cpfUsuario=${document.getElementById("cpfUsuario").value}`,
                        }).then((response) => response.text())
                            .then((res) => {
                                letRegisterCPF(res);
                            });
                    }

                    function letRegisterCPF(cpfAvaiable){
                        if(cpfAvaiable.includes("Esse CPF já existe em nosso sistema.") ||
                            cpfAvaiable === " Esse CPF já existe em nosso sistema." ||
                                cpfAvaiable === "CPF Inválido." ||
                                    cpfAvaiable == "Obrigatório CPF com 11 dígitos."){
                            document.getElementById("resultCPF").innerHTML = "CPF Inválido ou já existente.";
                            document.getElementById("registerButton").style.backgroundColor="grey";
                            document.querySelector('#registerButton').disabled = true;
                        } else {
                            document.getElementById("registerButton").style.backgroundColor="mediumseagreen";
                            document.querySelector('#registerButton').disabled = false;
                        }
                    }
                </script>
                <p id="resultCPF" style="font-style: italic; font-size: x-small; color: red;"></p>
                <input type="text" placeholder="Nome de usuário" name="nomeDeUsuario" id="nomeDeUsuario" required onfocusout="checkUser('<?php echo $localUrl; ?>')">
                <script>
                    function checkUser(url) {
                        fetch(`${url}/api/checar_usuario.php`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                            },
                            body: `nomeDeUsuario=${document.getElementById("nomeDeUsuario").value}`,
                        }).then((response) => response.text())
                            .then((res) => {
                                document.getElementById("result").innerHTML = res;
                                letRegister();
                            });
                    }

                    function letRegister(){
                        userAvaiable = document.getElementById("result").innerHTML.valueOf();
                        if(userAvaiable === "Esse nome de usuário já existe em nosso sistema."){
                            document.getElementById("registerButton").style.backgroundColor="grey";
                            document.querySelector('#registerButton').disabled = true;
                        } else {
                            document.getElementById("registerButton").style.backgroundColor="mediumseagreen";
                            document.querySelector('#registerButton').disabled = false;
                        }
                    }
                </script>
                <p id="result" style="font-style: italic; font-size: x-small; color: red"></p>
                <input type="text" placeholder="Número OAB" name="oabAdvogado" id="oabAdvogado" style="display: none" onfocusout="checkOAB('<?php echo $localUrl; ?>')">
                <script>
                    function checkOAB(url) {
                        fetch(`${url}/api/checar_oab.php`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                            },
                            body: `oabAdvogado=${document.getElementById("oabAdvogado").value}`,
                        }).then((response) => response.text())
                            .then((res) => {
                                document.getElementById("resultOAB").innerHTML = res;
                                letRegisterOAB();
                            });
                    }

                    function letRegisterOAB(){
                        oabAvaiable = document.getElementById("resultOAB").innerHTML.valueOf();
                        if(oabAvaiable === "Esse número de OAB já existe em nosso sistema."){
                            document.getElementById("registerButton").style.backgroundColor="grey";
                            document.querySelector('#registerButton').disabled = true;
                        } else {
                            document.getElementById("registerButton").style.backgroundColor="mediumseagreen";
                            document.querySelector('#registerButton').disabled = false;
                        }
                    }
                </script>
                <p id="resultOAB" style="font-style: italic; font-size: x-small; color: red"></p>
                <input type="submit" value="Cadastre-se" class="loginButton" name="registerButton" id="registerButton">
                <?php 
                    if (!isset($_SESSION['usuario']) || !isset($_SESSION['id'])) {
                        echo '<a href="index.php"><p class="registerLink">Já possui uma conta? Faça login</p></a>';
                    } else {
                        echo '<a href="dashboard.php"><p class="registerLink">&#8592 Voltar para dashboard</p></a>';
                    }
                ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<script>
    function mostrarCampos(){
        const value = document.getElementById("cargoUsuario").value;
        if (value == "advogado"){
            document.getElementById("oabAdvogado").style.display = "";
        } else {
            document.getElementById("oabAdvogado").style.display = "none";
        }
    }
</script>

<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <p class="confirmationRegister">Cadastrado com sucesso.</p>
        <a href="index.php"><input type="button" class="backLogin" value="Ir para login &#8594;"></a>
    </div>
</div>

<div id="novoUsuarioConfirmacao" class="modal">
    <div class="modal-content">
        <p class="confirmationRegister">Novo usuário cadastrado com sucesso.</p>
        <a href="dashboard.php"><input type="button" class="backLogin" value="Ir para tela inicial &#8594;"></a>
    </div>
</div>

<div id="errorModal" class="modal">
    <div class="modal-content">
        <p class="confirmationRegister">Erro ao tentar realizar cadastro.</p>
        <a href="cadastre_se.php"><input type="button" class="backLogin" value="&#8592; Tentar novamente"></a>
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

    function novoUsuario(){
        const modal = document.getElementById("novoUsuarioConfirmacao");
        modal.style.display = "block";
    }
</script>
<?php
    if(@$_REQUEST['registerButton'] == "Cadastre-se") {
        @$cpfUsuario = $_POST["cpfUsuario"];
        @$nomeUsuario = $_POST["nomeUsuario"];
        @$nomeDeUsuario = $_POST["nomeDeUsuario"];
        @$senhaUsuario = md5($_POST["senhaUsuario"]);
        @$oabAdvogado = $_POST["oabAdvogado"];
        @$cargoUsuario = $_POST["cargoUsuario"];

        $image_name = $_FILES['avatar']['name'];
        $image_size = $_FILES['avatar']['size'];
        $image_tmp_name = $_FILES['avatar']['tmp_name'];
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        if($extension != null){
            $avatarCliente = $_POST['nomeDeUsuario'].'.'.$extension;
        } else {
            $avatarCliente = null;
        }
        $image_folder = "uploaded_img/".$avatarCliente;

        if (@$cargoUsuario == "Cliente"){
            $sql = "INSERT INTO cliente (cpf, nome, usuario, senha, avatar)
                        VALUES ('$cpfUsuario', '$nomeUsuario', '$nomeDeUsuario', '$senhaUsuario', '$avatarCliente')";
            move_uploaded_file($image_tmp_name, $image_folder);
            if (mysqli_query($con, $sql)) {
                echo '<script>confirmationModal()</script>';
            } else {
                echo '<script>errorModal()</script>';
            }
        } else if (@$cargoUsuario == "secretario"){
            $sql = "INSERT INTO funcionario (cpf, nome, cargo, usuario, senha, avatar)
                        VALUES ('$cpfUsuario', '$nomeUsuario', '$cargoUsuario', '$nomeDeUsuario', '$senhaUsuario', '$avatarCliente')";
            if (mysqli_query($con, $sql)) {
                echo '<script>novoUsuario()</script>';
            } else {
                echo mysqli_error($con);
                echo '<script>errorModal()</script>';
            }
        } else {
            $sql = "INSERT INTO funcionario (cpf, nome, cargo, oab, usuario, senha, avatar)
                        VALUES ('$cpfUsuario', '$nomeUsuario', '$cargoUsuario', '$oabAdvogado', '$nomeDeUsuario', '$senhaUsuario', '$avatarCliente')";
            $result = mysqli_query($con, $sql);

            $getId = "SELECT id FROM funcionario WHERE usuario = '$nomeDeUsuario'";
            $result2 = mysqli_query($con, $getId);

            while($row = mysqli_fetch_array($result2)){
                @$userId = $row['id'];
            }

            $sql2 = "INSERT INTO advogado (nome, oab, funcionario)
                        VALUES ('$nomeUsuario', '$oabAdvogado', '$userId')";
            if (mysqli_query($con, $sql2)) {
                echo '<script>novoUsuario()</script>';
            } else {
                echo '<script>errorModal()</script>';
            }
        }
    }
?>
