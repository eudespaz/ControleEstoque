<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Apagando Registro";
		require_once ("includes/header.php"); 
	?>

</head>
<body>
			<?php 
				include('includes/topoemenu.php');
				require_once('includes/db.php');
			 ?>
			
			<div id="principal">
				<?php 
					$tabela = $_GET['tab'];
					$codigo = $_GET['cod'];
					$tabcod = $_GET['tabcod'];
					$nome = $_GET['nome'];
					$encontra = mysql_query("SELECT * FROM $tabela WHERE $tabcod = $codigo") or die(mysql_error());	
					$dados = mysql_fetch_array($encontra);
					if($_POST['enviar'])
					{
						if ($_POST['op'] == Sim)
						{
							$deleta = mysql_query("DELETE FROM $tabela WHERE $tabcod = $codigo ") or die(mysql_error());
							echo "<script>alert('Registro Excluido'); window.location='index.php'</script>";
						}
						else
							echo "<script>alert('Tome mais cuidado.'); window.location='index.php'</script>";		
					}
				?>
				<form action="#" method="post">
					<fieldset>
						<legend class="titulo">Deseja Mesmo excluir a(o) <?php echo $tabela; ?> <b><i><?php echo $dados[$nome]; ?> ?</i></b></legend>
						<label>Sim</label>
						<input type="radio" name="op" value="Sim" class="op" /><br /><br /><hr /><br />
						<label>N&atilde;o</label>
						<input type="radio" name="op" value="Nao" class="op" /><br />
						<input type="submit" class="botao" name="enviar" value="OK" />
					</fieldset>				
				</form>
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>