<?php
    include '../src/config.php';
    //include '../src/verification.php'; 
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location: index.php' ) );
    }

    @$userLogin = $_SESSION['usuario'];
    @$userId = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/navigation_bar_style.css">
        <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
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
            echo '<div id="mySidenav" class="sidenav">';
            echo '<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>';
            if($data1['avatar'] != null){
                echo '<img style="display:flex;" class="userAvatar" src="../src/uploaded_img/'.$data1['avatar'].'" id="myImg"><br><br>';
            } else {
                echo '<img style="display:flex;" class="userAvatar" src="../img/no-image.png" id="myImg"><br><br>';
            }
            echo '<a href="../src/profile.php">Meu perfil</a>';
            echo '<a href="dashboard.php">Dashboard</a>';
            echo '<a href="novo_agendamento.php">Novo agendamento</a>';
            echo '<a href="meus_agendamentos.php">Meus agendamentos</a>';
            echo '<a href="meus_processos.php">Meus processos</a>';
            echo '</div>';
            echo '<div class="topnav">';
                echo '<span id="barMenu" class="test" style="font-size:30px; color: snow; cursor:pointer; float: left; margin-left: 10px; margin-bottom: 20px" onclick="openNav()">&#9776;</span>';
                echo '<a href="../src/logout.php">';
                echo '<span id="barMenu" class="test" style="font-size:30px; color: snow; cursor:pointer; float: right; margin-left: 10px; margin-right: 10px; margin-bottom: 20px"">&#10005;</span>';
                echo '</a>';
            echo '</div>';
        }

        $cargo = "advogado";
        if(mysqli_num_rows($result2) > 0 && mysqli_num_rows($result) == 0){
            if(strcmp($data2['cargo'], $cargo) === 0){
                echo '<div id="mySidenav" class="sidenav">';
                echo '<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>';
                if($data2['avatar'] != null){
                    echo '<img style="display:flex;" class="userAvatar" src="../src/uploaded_img/'.$data2['avatar'].'" id="myImg"><br><br>';
                } else {
                    echo '<img style="display:flex;" class="userAvatar" src="../img/no-image.png" id="myImg"><br><br>';
                }
                echo '<a href="../src/profile.php">Meu perfil</a>';
                echo '<a href="dashboard.php">Dashboard</a>';
                echo '<a href="meus_processos.php">Meus processos</a>';
                echo '<a href="meus_agendamentos.php">Meus agendamentos</a>';
                echo '<a href="novo_agendamento.php">Novo agendamento</a>';
                echo '<a href="cadastro_processo.php">Cadastrar processo</a>';
                echo '<a href="cadastre_se.php">Cadastrar usuário</a>';
                echo '<a href="cadastro_vara.php">Cadastrar vara judiciária</a>';
                echo '<a href="relatorio_processos.php">Relatório de Processos</a>';
                echo '<a href="relatorio_agendamento.php">Relatório de Agendamentos</a>';
                echo '</div>';
                echo '<div class="topnav">';
                    echo '<span id="barMenu" class="test" style="font-size:30px; color: snow; cursor:pointer; float: left; margin-left: 10px" onclick="openNav()">&#9776;</span>';
                    echo '<a href="../src/logout.php">';
                    echo '<span id="barMenu" class="test" style="font-size:30px; color: snow; cursor:pointer; float: right; margin-left: 10px; margin-right: 10px; margin-bottom: 20px"">&#10005;</span>';
                    echo '</a>';                        
                echo '</div>';
            } else{
                echo '<div id="mySidenav" class="sidenav">';
                echo '<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>';
                if($data2['avatar'] != null){
                    echo '<img class="userAvatar" src="../src/uploaded_img/'.$data2['avatar'].'" id="myImg"><br><br>';
                } else {
                    echo '<img class="userAvatar" src="../img/no-image.png" id="myImg"><br><br>';
                }
                echo '<a href="#">Agendamentos</a>';
                echo '<a href="../src/profile.php">Meu perfil</a>';
                echo '</div>';
                echo '<div class="topnav">';
                    echo '<span class="test" style="font-size:30px; color: snow; cursor:pointer; float: left; margin-left: 10px" onclick="openNav()">&#9776;</span>';
                    echo '<a href="../src/logout.php">';
                    echo '<span id="barMenu" class="test" style="font-size:30px; color: snow; cursor:pointer; float: right; margin-left: 10px; margin-right: 10px; margin-bottom: 20px"">&#10005;</span>';
                    echo '</a>'; 
                echo '</div>';
            }
        }
    ?>
  
<script>
    function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.body.style.marginLeft = "250px";
    document.getElementById("barMenu").style.display = "none";
    }

    function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.body.style.marginLeft = "0";
        document.getElementById("barMenu").style.display = "block";
    }
</script>
</body>
</html> 
