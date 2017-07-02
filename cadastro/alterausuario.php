<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Cadastro de Usuário</title>
</head>
<body>
	<h1>Cadastro de Usuário</h1>
	<?php
		$pdo = new PDO ( "mysql:host=localhost;dbname=iffar", "iffar", "iffar" ) or die ("Erro ao conectar no banco");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		if (isset($_POST["botao"]) && $_POST["botao"]=="Excluir") {//Se clicou no botão excluir
			$stmt = $pdo->prepare("select * from usuario, pessoa where pessoa.id=usuario.pessoa_id and login = ?;");
			$stmt->bindValue(1, $_POST['alterar']);
			$stmt->execute();
			if ($linha = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$nome = $linha['nome'];
				echo "<script> if(confirm('Você deseja excluir definitivamente o usuário ".$linha['login']."?')) {
				location.href = 'alterausuario.php?acao=ConfirmaExcluir&login=".$_POST['alterar']."';
				}else{
				alert('Registro não excluido!');
				location.href = 'listausuario.php';
				} </script>";
			}
		}
		
		if (isset($_GET["acao"]) && $_GET["acao"]=="ConfirmaExcluir" ) //Se clicou no botão excluir
		{
			try
			{
				$stmt = $pdo->prepare("delete from usuario where login = ?;"); //faz um comando sql
				$stmt->bindValue(1, $_GET['login']);
				$stmt->execute();
				header('location:listausuario.php');
			}
			catch(PDOException $e)
			{
				echo "<script>alert('Não é possível excluir esse registro.');</script>";
			}
		}

		if (isset($_POST["botao"]) && $_POST["botao"]=="Salvar") //Se clicou no botão salvar
		{ //faz um comando sql para atualizar (update) a tabela
			try {
				if (strlen(trim( $_POST['senha']))>0) { /* só altera a senha se for digitada uma senha no formulário. Se deixar em branco, mantém a que já está cadastrada*/
					$stmt = $pdo->prepare("update usuario set nivel=?, pessoa_id=?, senha=sha1(?) where login = ?;");
					$stmt->bindValue(1, $_POST['nivel']);
					$stmt->bindValue(2, $_POST['pessoa_id']);
					$stmt->bindValue(3, $_POST['senha']);
					$stmt->bindValue(4, $_POST['alterar']);
					$stmt->execute();
				}
				else {
					$stmt = $pdo->prepare("update usuario set nivel=?, pessoa_id=? where login = ?;");
					$stmt->bindValue(1, $_POST['nivel']);
					$stmt->bindValue(2, $_POST['pessoa_id']);
					$stmt->bindValue(3, $_POST['alterar']);
					$stmt->execute();
				}
				header('location:listausuario.php');
			}
			catch (PDOException $e) {
				echo "<script>alert(\"Ocorreu um erro no cadastro: ".$e->getMessage ()."\");</script>";
			}
		}

		$login = "";
		$nome = "";
		$nivel = "";
		$pessoa_id = "";
	
		if (isset($_POST["alterar"])) //se há um código a ser alterado, busca os dados para já deixar
		{ //preenchido os campos com os já existentes antes
			$stmt = $pdo->prepare("select * from usuario, pessoa where pessoa.id=usuario.pessoa_id and login = ?;");
			$stmt->bindValue(1, $_POST['alterar']);
			$stmt->execute();
			
			if ($linha = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$login = $linha['login'];
				$nome = $linha['nome'];
				$nivel = $linha['nivel'];
				$pessoa_id = $linha['pessoa_id'];
			}
		}
	?>
	<div id=formPadrao>
	<form name="fCadUsuario" id="fCadUsuario" method="post" action="alterausuario.php">
	<fieldset >
	<legend>Alteração dos dados do Usuario:</legend>
	Login: <?php echo $login; ?><br />
	<label for="senha">Senha: </label><i>digite a nova senha ou deixe em branco para não alterar</i><br />
	<input type="password" name="senha" id="senha" size="50" maxlength="30" > <br />
	<label for="nivel">Nível:</label><br />
	<select name="nivel" id="nivel" >
	<option value="1"
	<?php if ($nivel==1) echo " selected"; ?>
	>Administrador</option>
	<option value="2"
	<?php if ($nivel==2) echo " selected"; ?>
	>Usuário</option>
	</select><br />
	<label for="pessoa_id">Pessoa:</label><br />
	<select name="pessoa_id" id="pessoa_id" >
	<?php //faz uma consulta trazendo todas as pessoas cadastradas
	$stmt = $pdo->prepare("SET CHARACTER SET utf8");
	$stmt->execute();
	$consulta = $pdo->query("SELECT * from pessoa order by nome;");
	//preenche a caixa de escolha
	while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
	if ($pessoa_id==$linha['id']) {
	echo "<option value=\"{$linha['id']}\" selected>{$linha['nome']} </option>";
	}
	else {
	echo "<option value=\"{$linha['id']}\">{$linha['nome']} </option>";
	}
	}
	?>
	</select><br />
	<br />
	<input type="submit" name="botao" id="botao" value="Salvar" />
	<input type="submit" name="botao" id="botao" value="Excluir" />
	<?php
	if (isset($_POST["alterar"])) echo "<INPUT TYPE=\"hidden\" NAME=\"alterar\" VALUE=\"{$_POST["alterar"]}\">";
	?>
	</fieldset>
	</form>
	</div>
	<br />
	<a href="cadusuario.php">Cadastrar Usuários</a>
	<a href="listausuario.php">Listar Usuários</a>
</body>
</html>