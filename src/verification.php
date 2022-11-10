<?php
    session_start();
    if(!isset($_SESSION["id"]) && !isset($_SESSION["usuario"])) {
        echo "<script>top.location.href='index.php';</script>";
    } else {
    }
?> 