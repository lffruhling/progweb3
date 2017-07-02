<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Cadastro de Pessoa através do WS Java</title>
</head>
<body>
	<h1>Cadastro de Pessoa através do WS Java</h1>
	<?php
		$clientSoap = new SoapClient( "http://localhost:8080/AulaWeb/WSCadastros?WSDL" );
		
		if (isset($_POST["botao"]) && $_POST["botao"]=="Excluir") {//Se clicou no botão excluir
			$params = array('id' => $_POST['alterar']);
			$result = $clientSoap->listarPessoa($params);
		
			if (substr($result->return,0,1)=="{" && strlen($result->return)>5) {
				$r = json_decode($result->return);
				$nome = $r->nome;
				
				echo "<script> if(confirm('Você deseja excluir definitivamente a pessoa ".$nome."?')) { location.href = 'wsalterapessoa.php?acao=ConfirmaExcluir&id=".$_POST['alterar']."'; }else{ alert('Registro não excluido!'); location.href = 'wslistapessoa.php'; } </script>";
			} else {
				echo "<script>alert(\"Ocorreu um erro no cadastro: ".$result->return."\");</script>";
			}
		}

		if (isset($_GET["acao"]) && $_GET["acao"]=="ConfirmaExcluir" ) {
			$params = array('id' => $_GET['id']);
			$result = $clientSoap->excluirPessoa($params);
			
			if ($result->return=="OK") {
				header('location:wslistapessoa.php');
			}else {
				echo "<script>alert('Não é possível excluir esse registro.');</script>";
			}
		}

		if (isset($_POST["botao"]) && $_POST["botao"]=="Salvar") {
			$params = array(
				'id' => $_POST['alterar'],
				'nome' => $_POST['nome'],
				'cpf' => $_POST['cpf'],
				'email' => $_POST['email'],
				'fone' => $_POST['fone'] );
			$result = $clientSoap->alterarPessoa($params);
			
			if ($result->return=="OK") {
				header('location:wslistapessoa.php');
			}else {
				echo "<script>alert(\"Ocorreu um erro no cadastro: ".$result->return."\");</script>";
			}
		}

		$nome = "";
		$cpf = "";
		$email = "";
		$fone = "";
		
		if (isset($_POST["alterar"])) //se há um código a ser alterado, busca os dados para já deixar
		{ //preenchido os campos com os já existentes antes
			$params = array('id' => $_POST['alterar']);
			$result = $clientSoap->listarPessoa($params);
			
			if (substr($result->return,0,1)=="{" && strlen($result->return)>5) {
				$r = json_decode($result->return);
				$nome = $r->nome;
				$cpf = $r->cpf;
				$email = $r->email;
				$fone = $r->fone;
			}
		}
	?>
	<div id=formPadrao>
		<form name="fCadPessoa" id="fCadPessoa" method="post" action="wsalterapessoa.php">
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
				if (isset($_POST["alterar"])) echo "<INPUT TYPE=\"hidden\" NAME=\"alterar\"
				VALUE=\"{$_POST["alterar"]}\">";
				?>
			</fieldset>
		</form>
	</div>
	<br />
	<a href="wscadpessoa.php">Cadastrar Pessoas (WS)</a><br>
	<a href="wslistapessoa.php">Listar Pessoas (WS)</a>
</body>
</html>