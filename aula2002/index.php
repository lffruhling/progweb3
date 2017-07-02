<!DOCTYPE html>
<html>
<head>
	<title>Cadastro de Pessoas</title>
</head>
<body>
	<h2>Bem Vindo ao Cadastro de Pessoa</h2>
	<a href="cadpessoa.php">Adicionar Pessoa</a>

	<h1>Pessoas Cadastradas</h1>
	<?php
		$pdo = new PDO("mysql:host=localhost;dbname=aula2002_pessoa","iffar","iffar") or die ('Erro ao conectar na base de dados');

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	?>
	<div id=formPadrao>
		<form name="fAlterarPessoa" id="fAlterarPessoa" method="post" action="alterapessoa.php">
			<fieldset >
				<legend>Pessoas Cadastradas:</legend>
				<table border=0><tr><th>Id</th><th>Nome</th><th></th></tr>
					<?php //faz uma consulta trazendo todas as pessoas cadastradas
						$consulta = $pdo->query("SELECT * from pessoa order by nome;");
						//monta uma tabela
						while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
						echo "<tr><td>{$linha['id']}</td>"; //mostra o identificador
						echo "<td>{$linha['nome']}</td>"; //mostra o nome da pessoa
						echo "<td><button type=\"submit\" name=\"alterar\" id=\"alterar\" value=\"{$linha['id']}\">Alterar</button></td></tr>"; //mostra um botão com o id para ser alterado
						}
					?>
				</table>
			</fieldset>
		</form>
	</div>
	<br />
	<hr>
	<h1>Web Service</h1>
	<a href="wslistapessoa.php">Listar Pessoas</a>

</body>
</html>