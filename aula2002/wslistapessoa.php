<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Cadastro de Pessoa através do WS Java </title>
</head>
<body>
	<h1>Cadastro de Pessoa através do WS Java</h1>
	<?php
		$clientSoap = new SoapClient( "http://localhost:8080/AulaWeb/WSCadastros?WSDL" );
	?>
	<div id=formPadrao>
		<form name="fAlterarPessoa" id="fAlterarPessoa" method="post" action="wsalterapessoa.php">
			<fieldset >
				<legend>Pessoas Cadastradas:</legend>
				<table border=0><tr><th>Id</th><th>Nome</th><th></th></tr>
					<?php //faz uma consulta trazendo todas as pessoas cadastradas
						$result = $clientSoap->listarTodos();
						$r = json_decode($result->return);
						//monta uma tabela
						foreach ($r as $linha) {
							echo "<tr><td>{$linha->id}</td>"; //mostra o identificador
							echo "<td>{$linha->nome}</td>"; //mostra o nome da pessoa
							echo "<td><button type=\"submit\" name=\"alterar\" id=\"alterar\"value=\"{$linha->id}\">Alterar</button></td></tr>"; //mostra um botão com o id para ser alterado
						}
						echo "</table>";
					?>
			</fieldset>
		</form>
	</div>
	<br />
	<a href="wscadpessoa.php">Cadastrar Pessoas (WS)</a>
</body>
</html>