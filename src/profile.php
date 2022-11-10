<!doctype html>
    <?php
        include 'config.php';
        include 'verification.php';
        include '../components/navigation_bar.php';

        @$userLogin = $_SESSION['usuario'];
        @$userId = $_SESSION['id'];
    ?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/cadastre_se_style.css" rel="stylesheet">
    <title>Perfil</title>
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
            $sql = "SELECT * FROM cliente WHERE id = $userId";
            $result = mysqli_query($con, $sql);
            $data = mysqli_fetch_array($result);
            if($result != null){
                echo "<div class=\"container\">";
                echo "<form action=\"\" method=\"POST\" enctype=\"multipart/form-data\">";
                echo "<div class=\"center\">";       
                echo "<div class=\"right\">";
                echo "<div class=\"upper-line\">";
                echo "</div>";
                echo "<div class=\"container\">";
                echo "<div>";
                if($data['avatar'] != null){
                    echo '<img class="userAvatar" src="uploaded_img/'.$data['avatar'].'" id="myImg"><br><br>';
                } else {
                    echo '<img class="userAvatar" src="../img/no-image.png" id="myImg"><br><br>';
                }
                echo '<label for="avatar" class="avatarButton" id="avatarUpload" name="avatar"> Escolha seu avatar </label>';
                echo '<input name="avatar" id="avatar" type="file" accept="image/jpg, image/jpeg, image/png" style="display: none"/>';
                echo '<script>
                        const fileInput = document.getElementById(\'avatar\');

                            fileInput.onchange = function(e){
                                if(e.target.files.length > 0){
                                    document.getElementById(\'avatarUpload\').style.backgroundColor = \'purple\';
                                    document.getElementById(\'avatarUpload\').innerText = "Atualizando...";
                                    document.getElementById(\'avatarUpload\').style.color = \'white\';
                                    document.getElementById("myImg").src = "./img/loading.gif";
                                    setInterval(function () {
                                        document.getElementById("myImg").style.height = "150px";
                                        document.getElementById("myImg").src = "./img/check.png";
                                        document.getElementById(\'avatarUpload\').innerText = "Atualizado. Selecionar outro...";
                                        document.getElementById("myImg").style.backgroundColor = "white";                   
                                    }, 5000);
                                }
                            }
                       </script>';
                $nome =$data['nome'];
                echo "<h4><b> Nome: <input type=\"text\" name=\"nome\" id=\"inputNome\" maxlength=\"80\" placeholder=\"Digite seu nome\" value=\"$nome\" required></b></h4>";
                $login =$data['usuario'];
                echo "<h4><b> Login: <input type=\"text\" name=\"login\" id=\"inputLogin\" maxlength=\"60\" value=\"$login\" required></b></h4>";
                $password =$data['senha'];
                echo "<h4><b> Senha: <input type=\"password\" name=\"password\" id=\"password\" maxlength=\"80\" required></b></h4>";
                $cpf =$data['cpf'];
                echo "<h4><b> CPF: <input type=\"text\" name=\"cpf\" id=\"inputCPF\" maxlength=\"80\" placeholder=\"$cpf\" value=\"$cpf\" disabled></b></h4>";
                echo "<input type=\"submit\" name=\"botao\" id=\"update\" value=\"Salvar\" class=\"loginButton\"><br> ";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                
                echo "</form>";
                
                echo "</div>";
                echo "</div>";
            } else {
                echo "Error find Client.";
                header("Refresh:7");
            }
    
            if(@$_REQUEST['botao'] == "Salvar"){
                $password = md5($_POST['password']);  
                if($_FILES['avatar']['name'] != ''){
                    $image_name = $_FILES['avatar']['name'];
                    $image_size = $_FILES['avatar']['size'];
                    $image_tmp_name = $_FILES['avatar']['tmp_name'];
                    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                    $new_name = $_POST['login'].'.'.$extension;
                    $image_folder = "uploaded_img/".$new_name;
                    $insere = "UPDATE cliente SET 
                    nome = '{$_POST['nome']}'
                    , usuario = '{$_POST['login']}'
                    , senha = '$password'
                    , avatar = '$new_name'
                    WHERE id = $userId";
                    $result_update = mysqli_query($con, $insere);
                    if ($result_update){
                        move_uploaded_file($image_tmp_name, $image_folder);
                        echo "<h2> Perfil atualizado com sucesso!!!</h2>";
                        echo "<script>top.location.href=\"profile.php\"</script>";
                    } else {
                        echo "<h2> Não consegui atualizar!!!</h2>"; 
                    }  
                exit; 
                } else{
                    $insere = "UPDATE cliente SET 
                    nome = '{$_POST['nome']}'
                    , usuario = '{$_POST['login']}'
                    , senha = '$password'
                    WHERE id = $userId";
                    $result_update = mysqli_query($con, $insere);
                    if ($result_update){
                        move_uploaded_file($image_tmp_name, $image_folder);
                        echo "<h2> Perfil atualizado com sucesso!!!</h2>";
                        echo "<script>top.location.href=\"profile.php\"</script>";
                    } else {
                        echo "<h2> Não consegui atualizar!!!</h2>"; 
                    }  
                exit; 
                }  
                
            }
        }
        $cargo = "advogado";

        if(mysqli_num_rows($result2) > 0 && mysqli_num_rows($result) == 0){
            if(strcmp($data2['cargo'], $cargo) === 0){
                $sql = "SELECT * FROM funcionario WHERE id = $userId";
                $sql2 = "SELECT * FROM advogado WHERE funcionario = $userId";
                $result = mysqli_query($con, $sql);
                $result2 = mysqli_query($con, $sql2);
                $data = mysqli_fetch_array($result);
                $data2 = mysqli_fetch_array($result2);
                if($result != null){
                    echo "<div class=\"container\">";
                    echo "<form action=\"\" method=\"POST\" enctype=\"multipart/form-data\">";
                    echo "<div class=\"center\">";       
                    echo "<div class=\"right\">";
                    echo "<div class=\"upper-line\">";
                    echo "</div>";
                    echo "<div class=\"container\">";
                    echo "<div>";
                    if($data['avatar'] != null){
                        echo '<img class="userAvatar" src="uploaded_img/'.$data['avatar'].'" id="myImg"><br><br>';
                    } else {
                        echo '<img class="userAvatar" src="../img/no-image.png" id="myImg"><br><br>';
                    }
                    echo '<label for="avatar" class="avatarButton" id="avatarUpload" name="avatar"> Escolha seu avatar </label>';
                    echo '<input name="avatar" id="avatar" type="file" accept="image/jpg, image/jpeg, image/png" style="display: none"/>';
                    echo '<script>
                            const fileInput = document.getElementById(\'avatar\');
    
                                fileInput.onchange = function(e){
                                    if(e.target.files.length > 0){
                                        document.getElementById(\'avatarUpload\').style.backgroundColor = \'purple\';
                                        document.getElementById(\'avatarUpload\').innerText = "Atualizando...";
                                        document.getElementById(\'avatarUpload\').style.color = \'white\';
                                        document.getElementById("myImg").src = "./img/loading.gif";
                                        setInterval(function () {
                                            document.getElementById("myImg").style.height = "150px";
                                            document.getElementById("myImg").src = "./img/check.png";
                                            document.getElementById(\'avatarUpload\').innerText = "Atualizado. Selecionar outro...";
                                            document.getElementById("myImg").style.backgroundColor = "white";                   
                                        }, 5000);
                                    }
                                }
                           </script>';
                    $nome =$data['nome'];
                    echo "<h4><b> Nome: <input type=\"text\" name=\"nome\" id=\"inputNome\" maxlength=\"80\" placeholder=\"Digite seu nome\" value=\"$nome\" required></b></h4>";
                    $login =$data['usuario'];
                    echo "<h4><b> Login: <input type=\"text\" name=\"login\" id=\"inputLogin\" maxlength=\"60\" value=\"$login\" required></b></h4>";
                    $password =$data['senha'];
                    echo "<h4><b> Senha: <input type=\"password\" name=\"password\" id=\"password\" maxlength=\"80\" required></b></h4>";
                    $oab =$data2['oab'];
                    echo "<h4><b> OAB: <input type=\"text\" name=\"oab\" id=\"inputOAB\" maxlength=\"80\" placeholder=\"$oab\" value=\"$oab\" disabled></b></h4>";
                    echo "<input type=\"submit\" name=\"botao\" id=\"update\" value=\"Salvar\" class=\"loginButton\"><br> ";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    
                    echo "</form>";
                    
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "Error find Advogado.";
                    header("Refresh:7");
                }
        
                if(@$_REQUEST['botao'] == "Salvar"){
                    $password = md5($_POST['password']);  
                    if($_FILES['avatar']['name'] != ''){
                        $image_name = $_FILES['avatar']['name'];
                        $image_size = $_FILES['avatar']['size'];
                        $image_tmp_name = $_FILES['avatar']['tmp_name'];
                        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                        $new_name = $_POST['login'].'.'.$extension;
                        $image_folder = "uploaded_img/".$new_name;
                        $insere = "UPDATE funcionario SET 
                        nome = '{$_POST['nome']}'
                        , usuario = '{$_POST['login']}'
                        , senha = '$password'
                        , avatar = '$new_name'
                        WHERE id = $userId";
                        $result_update = mysqli_query($con, $insere);
                        if ($result_update){
                            move_uploaded_file($image_tmp_name, $image_folder);
                            echo "<h2> Perfil atualizado com sucesso!!!</h2>";
                            echo "<script>top.location.href=\"profile.php\"</script>";
                        } else {
                            echo "<h2> Não consegui atualizar!!!</h2>"; 
                        }  
                    exit; 
                    } else{
                        $insere = "UPDATE funcionario SET 
                        nome = '{$_POST['nome']}'
                        , usuario = '{$_POST['login']}'
                        , senha = '$password'
                        WHERE id = $userId";
                        $result_update = mysqli_query($con, $insere);
                        if ($result_update){
                            move_uploaded_file($image_tmp_name, $image_folder);
                            echo "<h2> Perfil atualizado com sucesso!!!</h2>";
                            echo "<script>top.location.href=\"profile.php\"</script>";
                        } else {
                            echo "<h2> Não consegui atualizar!!!</h2>"; 
                        }  
                    exit; 
                    }
                }
            } else {
                $sql = "SELECT * FROM funcionario WHERE id = $userId";
                $result = mysqli_query($con, $sql);
                $data = mysqli_fetch_array($result);
                if($result != null){
                    echo "<div class=\"container\">";
                    echo "<form action=\"\" method=\"POST\" enctype=\"multipart/form-data\">";
                    echo "<div class=\"center\">";       
                    echo "<div class=\"right\">";
                    echo "<div class=\"upper-line\">";
                    echo "</div>";
                    echo "<div class=\"container\">";
                    echo "<div>";
                    if($data['avatar'] != null){
                        echo '<img class="userAvatar" src="uploaded_img/'.$data['avatar'].'" id="myImg"><br><br>';
                    } else {
                        echo '<img class="userAvatar" src="../img/no-image.png" id="myImg"><br><br>';
                    }
                    echo '<label for="avatar" class="avatarButton" id="avatarUpload" name="avatar"> Escolha seu avatar </label>';
                    echo '<input name="avatar" id="avatar" type="file" accept="image/jpg, image/jpeg, image/png" style="display: none"/>';
                    echo '<script>
                            const fileInput = document.getElementById(\'avatar\');
    
                                fileInput.onchange = function(e){
                                    if(e.target.files.length > 0){
                                        document.getElementById(\'avatarUpload\').style.backgroundColor = \'purple\';
                                        document.getElementById(\'avatarUpload\').innerText = "Atualizando...";
                                        document.getElementById(\'avatarUpload\').style.color = \'white\';
                                        document.getElementById("myImg").src = "./img/loading.gif";
                                        setInterval(function () {
                                            document.getElementById("myImg").style.height = "150px";
                                            document.getElementById("myImg").src = "./img/check.png";
                                            document.getElementById(\'avatarUpload\').innerText = "Atualizado. Selecionar outro...";
                                            document.getElementById("myImg").style.backgroundColor = "white";                   
                                        }, 5000);
                                    }
                                }
                           </script>';
                    $nome =$data['nome'];
                    echo "<h4><b> Nome: <input type=\"text\" name=\"nome\" id=\"inputNome\" maxlength=\"80\" placeholder=\"Digite seu nome\" value=\"$nome\" required></b></h4>";
                    $login =$data['usuario'];
                    echo "<h4><b> Login: <input type=\"text\" name=\"login\" id=\"inputLogin\" maxlength=\"60\" value=\"$login\" required></b></h4>";
                    $password =$data['senha'];
                    echo "<h4><b> Senha: <input type=\"password\" name=\"password\" id=\"password\" maxlength=\"80\" required></b></h4>";
                    echo "<input type=\"submit\" name=\"botao\" id=\"update\" value=\"Salvar\" class=\"loginButton\"><br> ";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    
                    echo "</form>";
                    
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "Error find Client.";
                    header("Refresh:7");
                }
        
                if(@$_REQUEST['botao'] == "Salvar"){
                    $password = md5($_POST['password']);  
                    if($_FILES['avatar']['name'] != ''){
                        $image_name = $_FILES['avatar']['name'];
                        $image_size = $_FILES['avatar']['size'];
                        $image_tmp_name = $_FILES['avatar']['tmp_name'];
                        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                        $new_name = $_POST['nome'].'.'.$extension;       
                        $image_folder = "uploaded_img/".$new_name;
                        $insere = "UPDATE funcionario SET 
                        nome = '{$_POST['nome']}'
                        , usuario = '{$_POST['login']}'
                        , senha = '$password'
                        , avatar = '$new_name'
                        WHERE id = $userId";
                        $result_update = mysqli_query($con, $insere);
                        if ($result_update){
                            move_uploaded_file($image_tmp_name, $image_folder);
                            echo "<h2> Perfil atualizado com sucesso!!!</h2>";
                            echo "<script>top.location.href=\"profile.php\"</script>";
                        } else {
                            echo "<h2> Não consegui atualizar!!!</h2>"; 
                        }  
                    exit; 
                    } else{
                        $insere = "UPDATE funcionario SET 
                        nome = '{$_POST['nome']}'
                        , usuario = '{$_POST['login']}'
                        , senha = '$password'
                        WHERE id = $userId";
                        $result_update = mysqli_query($con, $insere);
                        if ($result_update){
                            move_uploaded_file($image_tmp_name, $image_folder);
                            echo "<h2> Perfil atualizado com sucesso!!!</h2>";
                            echo "<script>top.location.href=\"profile.php\"</script>";
                        } else {
                            echo "<h2> Não consegui atualizar!!!</h2>"; 
                        }  
                    exit; 
                    }  
                    
                }
            }
        }

       
        
    ?>
</body>
</html>
