<?php
    include "../src/config.php";
    $login = $_POST['nomeDeUsuario'];

    $sql = "SELECT * FROM cliente";
    $sql2 = "SELECT * FROM funcionario";

    $result = mysqli_query($con, $sql);
    $result2 = mysqli_query($con, $sql2);

    while ($row = mysqli_fetch_array($result)){
        if (@$login == $row['usuario']){
            echo "Esse nome de usuário já existe em nosso sistema.";
        } else {
            echo "";
        }
    }

    while ($row = mysqli_fetch_array($result2)){
        if (@$login == $row['usuario']){
            echo "Esse nome de usuário já existe em nosso sistema.";
        } else {
            echo "";
        }
    }
?>