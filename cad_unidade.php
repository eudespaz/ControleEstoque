<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Cadastrar Unidades";
		require_once ("includes/header.php"); 
	?>
</head>
<body>
			<?php 
				include('includes/topoemenu.php');
				require_once('includes/db.php');
				if ($_POST)
				{
					$codigo = $_POST['codunidade'];
					$unidade = $_POST['unidade'];
					if ($codigo == '' || $unidade == '')
					{
						echo "Preencha todos os campos";					
					}
					else
					$cad = mysql_query ("INSERT INTO unidades(CODUNI,UNIDADE) values('$codigo','$unidade') ") or die ("ERRO");
						echo "<script>alert('Cadastro foi efetuado com sucesso');</script>";
				}
			 ?>
			
			<div id="principal">
				<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
					<fieldset>
						<legend class="titulo">Cadastro de Novas Unidades &darr; </legend>
						<label>Abreviatura</label>						
						<input type="text" name="codunidade" maxlength="2" /><br /><br />
						<label>Unidade</label>
						<input type="text" name="unidade" maxlength="10" /><br />
						<input class="botao" type="submit" name="enviar" value="Cadastrar"/>
					</fieldset>				
				</form>
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>