<html>
<head>
    <title>Relatório de Agendamentos</title>
    <link rel="stylesheet" href="../css/search_bar_style.css">
    <?php 
    include 'verification.php';
    include 'config.php';
    include '../components/navigation_bar.php';


    $quantidade = 10;
    $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
    $inicio = ($quantidade * $pagina) - $quantidade;

    $sql = "SELECT data, cliente, advogado, processo FROM reuniao ORDER BY data ASC LIMIT $inicio, $quantidade";
    $result = mysqli_query($con, $sql);
    $agendamentos = [];
    if ($result != null) {
        $agendamentos = $result->fetch_all(MYSQLI_ASSOC);
    }
    if (@$_REQUEST['botao'] == "Exportar arquivo"){
        $myfile = fopen("relatorios/agendamentos.txt", "a");
        if(!empty($agendamentos)){
            foreach($agendamentos as $agendamento) {
                echo '<script> console.log(" Entrei no foreach")</script>';
                @$data = $agendamento['data'];
                @$clienteId = $agendamento['cliente'];
                @$advogadoId = $agendamento['advogado'];
                @$getClienteNome = mysqli_query($con, "SELECT nome FROM cliente WHERE id = $clienteId");
                while(@$resultClienteNome = mysqli_fetch_array($getClienteNome)){
                    @$clienteNome = @$resultClienteNome['nome'];
                }                
                @$getAdvogadoNome = mysqli_query($con, "SELECT nome FROM advogado WHERE id = $advogadoId");
                while(@$resultAdvogadoNome = mysqli_fetch_array($getAdvogadoNome)){
                    @$advogadoNome = @$resultAdvogadoNome['nome'];
                }
                @$processoId = $agendamento['processo'];
                @$getProcessoNumero = mysqli_query($con, "SELECT numero FROM processo WHERE id = $processoId");
                while(@$resultProcessoNumero = mysqli_fetch_array($getProcessoNumero)){
                    @$processoNumero = @$resultProcessoNumero['numero'];
                }
                echo '<script> console.log("2 Entrei no foreach")</script>';
                $txt = "$data $clienteNome $advogadoNome $processoNumero\n";
                fwrite($myfile, $txt); 
            } 
        }
            
        fclose($myfile); 
    }
    ?>
</head>
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: center;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    td {
        height: 30px;
    }
    tr:hover{
        background-color: #f9f9f9;
    }
    th, th:hover{
        cursor: pointer;
        height: 50px;
    }
</style>
    <body>
        <input 
         type="text" 
         id="myInput" 
         onkeyup="myFunction()" 
         placeholder="&#128269 Procure pela data, cliente, advogado ou processo"
         title="Filtra a tabela"
         class="searchBar">
        <table id="myTable" style="width: 100%; align-content: center; justify-content: center; text-align: center">
            <thead>
                <th onclick="sortTable(0)">Data  &#8645</th>
                <th onclick="sortTable(1)">Cliente  &#8645</th>
                <th onclick="sortTable(2)">Advogado  &#8645</th>
            </thead>
            <tbody>
                <?php if(!empty($agendamentos)) { ?>
                    <?php foreach($agendamentos as $agendamento) { ?>
                        <tr>
                            <td><?php echo $agendamento['data']; ?></td>
                            <?php 
                                @$clienteId = $agendamento['cliente'];
                                @$getClienteNome = mysqli_query($con, "SELECT nome FROM cliente WHERE id = $clienteId");
                                while(@$resultClienteNome = mysqli_fetch_array($getClienteNome)){
                                    @$clienteNome = @$resultClienteNome['nome'];
                                }
                            ?>
                            <td><?php echo $clienteNome; ?></td>
                            <?php
                                @$advogadoId = $agendamento['advogado'];
                                @$getAdvogadoNome = mysqli_query($con, "SELECT nome FROM advogado WHERE id = $advogadoId");
                                while(@$resultAdvogadoNome = mysqli_fetch_array($getAdvogadoNome)){
                                    @$advogadoNome = @$resultAdvogadoNome['nome'];
                                }
                                @$processoId = $agendamento['processo'];
                                @$getProcessoNumero = mysqli_query($con, "SELECT numero FROM processo WHERE id = $processoId");
                                while(@$resultProcessoNumero = mysqli_fetch_array($getProcessoNumero)){
                                    @$processoNumero = @$resultProcessoNumero['numero'];
                                }
                            ?>
                            <td><?php echo @$advogadoNome; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
            <tfoot>
                <p id="totalRegister" style="text-align: center"></p>
            </tfoot>
            <?php
                $sqlTotal   = "SELECT id FROM reuniao";
                $qrTotal    = mysqli_query($con, $sqlTotal);
                $numTotal   = mysqli_num_rows($qrTotal);
                $totalPagina= ceil($numTotal/$quantidade);
                $exibir = 3;
                $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
                $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
            ?>
            <div class="navegacao" style="text-align: center">
                <?php
                echo '<a href="?pagina=1" style=\'text-decoration: none; color: rebeccapurple\'>primeira</a> | ';
                echo "<a href=\"?pagina=$anterior\" style='text-decoration: none; color: rebeccapurple'> &#11013 </a> | ";
                ?>
                <?php
                for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                    if($i > 0)
                        echo '<a href="?pagina='.$i.'" style=\'text-decoration: none; color: rebeccapurple\'> '.$i.' </a>';
                }

                echo '<a href="?pagina='.$pagina.'" style=\'text-decoration: none; color: rebeccapurple\'><strong>'.$pagina.'</strong></a>';

                for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                    if($i <= $totalPagina)
                        echo '<a href="?pagina='.$i.'" style=\'text-decoration: none; color: rebeccapurple\'> '.$i.' </a>';
                }
                ?>
                <?php
                echo " | <a href=\"?pagina=$posterior\" style='text-decoration: none; color: rebeccapurple'> &#10145 </a> | ";
                echo "  <a href=\"?pagina=$totalPagina\" style='text-decoration: none; color: rebeccapurple'>última</a>";
                ?>
            </div><br>
        </table>
<!--        <form action="#" method="POST" style="width: 97%; align-content: center; justify-content: center">-->
<!--            <a href="agendamentos.txt" download><button value="Exportar arquivo" name="botao" class="exportButton" style="float: right; margin: 10px">Exportar arquivo</button></a>-->
<!--            <a href="#" target="_blank"><input type="button" value="Imprimir" class="printButton" style="float: right; margin: 10px"/>-->
<!--        </form>-->
        <script>
            const myFunction = () => {
                const trs = document.querySelectorAll('#myTable tr:not(.header)')
                const filter = document.querySelector('#myInput').value
                const regex = new RegExp(filter, 'i')
                const isFoundInTds = td => regex.test(td.innerHTML)
                const isFound = childrenArr => childrenArr.some(isFoundInTds)
                const setTrStyleDisplay = ({ style, children }) => {
                    style.display = isFound([
                    ...children 
                ]) ? '' : 'none' 
                }
  
                trs.forEach(setTrStyleDisplay)
            }
            var x = document.getElementById("myTable").rows.length;
            var textRegistro = (x-1) > 1 ? "registros" : "registro";
            document.getElementById("totalRegister").innerHTML = "Mostrando "+(x-1)+" "+textRegistro+".";
            function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                    }
                }
                }
                if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++;
                } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
                }
            }
            }
        </script>
    </body>
</html>