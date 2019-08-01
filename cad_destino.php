<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Cadastrar Destino";
		require_once ("includes/header.php"); 
	?>
</head>
<body>
			<?php 
				include('includes/topoemenu.php');
				require_once('includes/db.php');
				if ($_POST)
				{
					$descricao = $_POST['destino'];
					if($descricao == '')
						echo "Preencha a descriçao do destino";
					else
					$cad = mysql_query ("INSERT INTO destinos(CODDEST,DESCRICAO) values(NULL,'$descricao') ") or die ("ERRO ! LOL: mysql_error()");	
					if ($cad != '')
						echo "<script>alert('Cadastro foi efetuado com sucesso');</script>";			
				}
			 ?>
			
			<div id="principal">
				<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
					<fieldset>
						<legend class="titulo">Cadastro de Destino &darr; </legend>
						<label>Descri&ccedil;&atilde;o</label>
						<input type="text" name="destino" maxlength="30"/><br />	
						<input class="botao" type="submit" name="enviar" value="Cadastrar" />
					</fieldset>				
				</form>
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>