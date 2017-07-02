<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Cadastro de Pessoa através do WS Java</title>
</head>
<body>
	<h1>Cadastro de Pessoa Cadastro de Pessoa através do WS Java</h1>
	<?php
		$clientSoap = new SoapClient( "http://localhost:8080/AulaWeb/WSCadastros?WSDL" );
			if (isset($_POST["botao"]) && $_POST["botao"]=="Cadastrar")
			{ //se clicou no botão cadastrar...
				$params = array('nome' => $_POST['nome'],
					'cpf' => $_POST['cpf'],
					'email' => $_POST['email'],
					'fone' => $_POST['fone'] );
				$result = $clientSoap->cadastrarPessoa($params);
				
				if ($result->return=="OK") {
					echo "<script>alert('Pessoa foi cadastrada!');</script>";
				}else {
					echo "<script>alert(\"Ocorreu um erro no cadastro: ".$result->return."\");</script>";
				}
			}
	?>
	<div id=formPadrao> <!— mostra um formulário para cadastrar pessoas -->
		<form name="fCadPessoa" id="fCadPessoa" method="post" action="wscadpessoa.php">
			<fieldset >

				<legend>Informe os dados da Pessoa:</legend>
				
				<label for="nome">Nome:</label><br />
				<input type="text" name="nome" id="nome" size="50" maxlength="50" required/><br/>

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
	<a href="wslistapessoa.php">Listar Pessoas (WS)</a>
</body>
</html>