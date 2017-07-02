<html> 
<head> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript"> //função javascript que retornará o codigo 
function retorna(id, nome)//passando um parametro 
{ 
window.opener.document.fCadUsuario.pessoa_id.value = id; 
//a janela mãe recebe o id, você precisa passar o nome do formulario e do textfield que receberá o valor passado por parametro. 
window.opener.document.fCadUsuario.pessoa_nome.value = nome;
window.close();	//fecha a janla popup 
} 
</script> 
</head> 
<body> 
<?php 
$pdo = new PDO ( "mysql:host=localhost;dbname=iffar", "iffar", "iffar" ) or die ("Erro ao conectar no banco");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SET CHARACTER SET utf8");
	$stmt->execute();
?>
<form name="fConsultaPessoa" id="fConsultaPessoa" method="GET" action="popuppessoa.php">
	<label for="busca">Busca:</label><br />
    <input type="text" name="busca" id="busca" size="40" maxlength="40">
    <input type="submit" name="botao" id="botao" value="Buscar" />
    <br /><br />
<?php
	$busca="";
	if (isset($_GET["botao"]) && $_GET["botao"]=="Buscar") {
		$busca = trim($_GET['busca']);
		$sqlconsulta = "SELECT * FROM  pessoa WHERE nome LIKE \"%".$busca."%\" OR cpf LIKE \"%".$busca."%\" order by nome ";
		}
	else {
			$sqlconsulta = "SELECT * from pessoa order by nome ";
		}
	$consulta = $pdo->query($sqlconsulta);
    $total = $consulta->rowCount(); //conta o total de itens              
    if($total < 1) {
        $numPaginas = 0;
        } 
    else {
    	$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1; //verifica a página atual caso seja informada na URL, senão atribui como 1ª página
		$registros = 8;//seta a quantidade para 8 itens por página
    	$numPaginas = ceil($total/$registros);
    	if($pagina<1) $pagina = 1;
    	if($pagina>$numPaginas) $pagina = $numPaginas;
    	$inicio = ($registros*$pagina)-$registros;

    	$sqlconsulta = $sqlconsulta." limit $inicio, $registros";
    	$consulta = $pdo->query($sqlconsulta);
    	}	   
	$cont=0;
	echo '<table>';
	while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $nome = $linha['nome'];
        $nome = str_replace("'"," ",$nome);
		echo "<tr><td><a href=\"javascript:retorna('{$linha['id']}', '{$nome}')\">{$linha['id']}</a></td>";
		echo "<td><a href=\"javascript:retorna('{$linha['id']}', '{$nome}')\">{$nome}</a></td></tr>";
		$cont++;
		}
	for($i=$cont;$i<=$registros;$i++) echo "<tr><td>&nbsp</td><td></td></tr>";
	echo '</table>'; 

	if ($numPaginas>1) { //exibe a paginação
        echo "<center>";
        if ($pagina>1) {
        	$anterior = $pagina-1;
            echo "<a href='popuppessoa.php?busca=$busca&pagina=$anterior'> << Anterior</a> ";  
        	}
        for($i = 1; $i < $numPaginas + 1; $i++) {
            if ($i==$pagina) {
                echo " <b>$i</b> ";
            	}
            else {
                echo "<a href='popuppessoa.php?busca=$busca&pagina=$i'>".$i."</a> ";  
                }                
            }
        if ($pagina<$numPaginas) {
            $proxima = $pagina + 1;
            echo "<a href='popuppessoa.php?busca=$busca&pagina=$proxima'> Próxima >></a> ";  
            }
                echo "</center>";
        } 
?> 
</body> 
</html> 