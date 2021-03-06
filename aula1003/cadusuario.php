<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Cadastro de Usuário</title>

<script language="javascript" type="text/javascript">
function validar() { 
	if (fCadUsuario.pessoa_id.value == "") {
		alert('Preencha o campo pessoa');
		fCadUsuario.pessoa_id.focus();
		return false;
		}
	return true;
	}
</script>

</head>
<body> 
<h1>Cadastro de Usuário</h1>
<?php
    $pdo = new PDO ( "mysql:host=localhost;dbname=iffar", "iffar", "iffar" ) or die ("Erro ao conectar no banco");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST["botao"]) && $_POST["botao"]=="Cadastrar")
    {               //se clicou no botão cadastrar...
    try {
        $stmt = $pdo->prepare("insert into usuario (login, nivel, pessoa_id, senha) values (?,?,?,sha1(?));");
        $stmt->bindValue(1, $_POST['login']);
        $stmt->bindValue(2, $_POST['nivel']);
        $stmt->bindValue(3, $_POST['pessoa_id']);
        $stmt->bindValue(4, $_POST['senha']);    
        $stmt->execute();       //insere os dados na tabela
        echo "<script>alert('Usuario foi cadastrado!');</script>";
        }
    catch (PDOException $e) {       
        echo "<script>alert(\"Ocorreu um erro no cadastro: ".$e->getMessage ()."\");</script>";
        }
    }

?>
    <div id=formPadrao> <!— mostra um formulário para cadastrar usuario -->
        <form name="fCadUsuario" id="fCadUsuario" method="post" action="cadusuario.php">
            <fieldset >
                <legend>Informe os dados do Usuario:</legend>
                <label for="login">Login:</label><br />
                <input type="text" name="login" id="login" size="50" maxlength="45" required/><br /><br />
                <label for="senha">Senha:</label><br />
                <input type="password" name="senha" id="senha" size="50" maxlength="30" required/><br /><br />
                <label for="nivel">Nível:</label><br />

                <select name="nivel" id="nivel">
  					<option value="1">Administrador</option> 
  					<option value="2" selected>Usuário</option>
  				</select><br /><br />
                <label for="pessoa_id">Pessoa: </label><a href="#" onClick="window.open('popuppessoa.php', 'Consulta', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=500, height=400'); return false;">Localizar</a><br />
              <input type="text" name="pessoa_id" id="pessoa_id" size="5" maxlength="5" readonly />
              <input type="text" name="pessoa_nome" id="pessoa_nome" size="30" maxlength="50" readonly />


 <br />    

                          
                <br />
                <input type="submit" name="botao" id="botao" value="Cadastrar" onclick="return validar()"/>
            </fieldset>
        </form>
    </div>    
    <br />
    <a href="listausuario.php">Listar Usuários</a>
</body>
</html>