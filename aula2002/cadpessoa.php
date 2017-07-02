<!DOCTYPE html>
<html>
<head>
	<title>Cadastro de Pessoas</title>
</head>
<body>
	<?php
		$pdo = new PDO("mysql:host=localhost;dbname=aula2002_pessoa","iffar","iffar") or die ('Erro ao conectar na base de dados');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if (isset($_POST["botao"]) && $_POST["botao"]=="Cadastrar"){ 
			//se clicou no botão cadastrar...
			try {
				$stmt = $pdo->prepare("insert into pessoa (nome, cpf, email, fone) values (?,?,?,?);");
				$stmt->bindValue(1, $_POST['nome']);
				$stmt->bindValue(2, $_POST['cpf']);
				$stmt->bindValue(3, $_POST['email']);
				$stmt->bindValue(4, $_POST['fone']);
				$stmt->execute(); //insere os dados na tabela
				echo "<script>alert('Pessoa foi cadastrada!');</script>";
			}catch (PDOException $e) {
				echo "<script>alert(\"Ocorreu um erro no cadastro: ".$e->getMessage ()."\");</script>";
			}
		}
	?>
	<div id=formPadrao> <!-- mostra um formulário para cadastrar pessoas -->
	<form name="fCadPessoa" id="fCadPessoa" method="post" action="cadpessoa.php">
	<fieldset >
	<legend>Informe os dados da Pessoa:</legend>
	<label for="nome">Nome:</label><br />
	<input type="text" name="nome" id="nome" size="50" maxlength="50" required/><br />
	<label for="cpf">CPF:</label><br />
	<input type="text" name="cpf" id="cpf" size="50" maxlength="11" required/><br />
	<label for="email">E-Mail:</label><br />
	<input type="email" name="email" id="email" size="50" maxlength="100" required/><br />
	<label for="fone">Fone:</label><br />
	<input type="text" name="fone" id="fone" size="50" maxlength="30" ><br />
	<br />
	<input type="submit" name="botao" id="botao" value="Cadastrar" />
	</fieldset>
	</form>
	</div>
	<br />
	<a href="listapessoa.php">Listar Pessoas</a>
	<a href="index.php">Voltar</a>
</body>
</html>