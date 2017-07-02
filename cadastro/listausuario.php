<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Cadastro de Usuários</title>
</head>
<body>
	<h1>Cadastro de Usuários</h1>
	<?php
		$pdo = new PDO ( "mysql:host=localhost;dbname=iffar", "iffar", "iffar" ) or die ("Erro ao conectar no banco");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	?>
	<div id=formPadrao>
		<form name="fAlterarUsuario" id="fAlterarUsuario" method="post" action="alterausuario.php">
			<fieldset >
			
				<legend>Usuários Cadastradas:</legend>
				<table border=0><tr><th>Login</th><th>Nome</th><th></th></tr>
				
				<?php //faz uma consulta trazendo todas as pessoas cadastradas
					$stmt = $pdo->prepare("SET CHARACTER SET utf8");
					$stmt->execute();
					$consulta = $pdo->query("SELECT usuario.login, pessoa.nome from usuario, pessoa where pessoa.id=usuario.pessoa_id order by nome;");
					//monta uma tabela
					while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
						echo "<tr><td>{$linha['login']}</td>"; //mostra o identificador
						echo "<td>{$linha['nome']}</td>"; //mostra o nome da pessoa
						echo "<td><button type=\"submit\" name=\"alterar\" id=\"alterar\" value=\"{$linha['login']}\">Alterar</button></td></tr>"; //mostra um botão com o login para ser alterado
					}
				?>
				</table>
			</fieldset>
		</form>
	</div>
	<br />
	<a href="cadusuario.php">Cadastrar Usuários</a>
</body>
</html>