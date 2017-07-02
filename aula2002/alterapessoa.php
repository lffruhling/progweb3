<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Editar de Pessoa</title>
</head>
<body>
	<h1>Editar de Pessoa</h1>
	<?php
		$pdo = new PDO("mysql:host=localhost;dbname=aula2002_pessoa","iffar","iffar") or die ('Erro ao conectar na base de dados');
		
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		if (isset($_POST["botao"]) && $_POST["botao"]=="Excluir") {
			//Se clicou no botão excluir
			$stmt = $pdo->prepare("select * from pessoa where id = ?;");
			$stmt->bindValue(1, $_POST['alterar']);
			$stmt->execute();
			if ($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
				$nome = $linha['nome'];
				echo "<script> if(confirm('Você deseja excluir definitivamente a pessoa ".$linha['nome']."?')) {
					location.href = 'alterapessoa.php?acao=ConfirmaExcluir&id=".$_POST['alterar']."';
				}else{
				alert('Registro não excluido!');
				location.href = 'listapessoa.php';
				} </script>";
			}
		}

		if (isset($_GET["acao"]) && $_GET["acao"]=="ConfirmaExcluir" ) {
			//Se clicou no botão excluir
			try{
				$stmt = $pdo->prepare("delete from pessoa where id = ?;"); //faz um comando sql
				$stmt->bindValue(1, $_GET['id']); //preenche o ? com o código a alterar
				$stmt->execute(); //exclui o registro
				header('location:listapessoa.php'); //redireciona para o listapessoa.php
			}
			catch(PDOException $e){
				echo "<script>alert('Não é possível excluir esse registro.');</script>";
			}
		}

		if (isset($_POST["botao"]) && $_POST["botao"]=="Salvar"){
			//Se clicou no botão salvar
		 	//faz um comando sql para atualizar (update) a tabela
			try {
				$stmt = $pdo->prepare("update pessoa set nome=?, cpf=?, email=?, fone=? where id = ?;");
				$stmt->bindValue(1, $_POST['nome']);
				$stmt->bindValue(2, $_POST['cpf']);
				$stmt->bindValue(3, $_POST['email']);
				$stmt->bindValue(4, $_POST['fone']);
				$stmt->bindValue(5, $_POST['alterar']);
				$stmt->execute();
				header('location:listapessoa.php'); //redireciona para o listapessoa.php
			}
			catch (PDOException $e) {
				echo "<script>alert(\"Ocorreu um erro no cadastro: ".$e->getMessage ()."\");</script>";
			}
		}

		$nome = "";
		$cpf = "";
		$email = "";
		$fone = "";
		if (isset($_POST["alterar"])){
			//se há um código a ser alterado, busca os dados para já deixar
		 	//preenchido os campos com os já existentes antes
			$stmt = $pdo->prepare("select * from pessoa where id = ?;");
			$stmt->bindValue(1, $_POST['alterar']);
			$stmt->execute();
			
			if ($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
				$nome = $linha['nome'];
				$cpf = $linha['cpf'];
				$email = $linha['email'];
				$fone = $linha['fone'];
			}
		}
	?>
	<div id=formPadrao>
		<form name="fCadPessoa" id="fCadPessoa" method="post" action="alterapessoa.php">
			<fieldset >
				<legend>Alteração dos dados da Pessoa:</legend>
				<label for="nome">Nome:</label><br />
				<input type="text" name="nome" id="nome" size="50" maxlength="50" value="<?php echo $nome; ?>" required/><br />

				<label for="cpf">CPF:</label><br />
				<input type="text" name="cpf" id="cpf" size="50" maxlength="11" value="<?php echo $cpf; ?>" required/><br />
				
				<label for="email">E-Mail:</label><br />
				<input type="email" name="email" id="email" size="50" maxlength="100" value="<?php echo $email; ?>" required/><br />
				
				<label for="fone">Fone:</label><br />
				<input type="text" name="fone" id="fone" size="50" maxlength="30" value="<?php echo $fone; ?>" ><br />
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
	<a href="cadpessoa.php">Cadastrar Pessoas</a>
	<a href="listapessoa.php">Listar Pessoas</a>
	<a href="index.php">Voltar</a>
</body>
</html>