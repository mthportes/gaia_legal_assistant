<?php
    include "../src/config.php";
    $login = $_POST['oabAdvogado'];

    $sql = "SELECT * FROM funcionario";

    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($result)){
        if (@$login == $row['oab']){
            echo "Esse número de OAB já existe em nosso sistema.";
        } else {
            echo "";
        }
    }
?>