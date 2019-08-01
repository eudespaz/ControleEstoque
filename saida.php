<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Nova Sa&iacute;da de Estoque";
		require_once ("includes/header.php"); 
	?>
</head>
<body>
			<?php 
				include('includes/topoemenu.php');
				require_once('includes/db.php');
				$sql= mysql_query("SELECT * FROM destinos order by DESCRICAO")or die (mysql_error());
			 ?>
			
			<div id="principal">
				
				<form action="#" method="post">
					<fieldset>
					<legend class="titulo">Escolha um destino</legend>
					<select name="destino">
						<option>Selecionar..</option>
						<?php
							while ( $query = mysql_fetch_array($sql))
							{
						?>
						<option value="<?php echo $query['CODDEST']; ?>"><?php echo $query['DESCRICAO']; ?></option>";								
						<?php
							}
						?>				
					</select>
					<input class="botao" type="submit" name="Ok" value="Ok" onclick="readonly="true";"/>
					</fieldset>
				</form>
				
				<?php 
					if($_POST['Ok'])//segue com o pedido
					{
						$i = 0;
						$destino = $_POST['destino'];
                        if($destino == 'Selecionar..')
                          echo "<script>alert('Selecione um destino !!')</script>";
                        else
                        {
						$seldestino = mysql_query("SELECT * FROM destinos WHERE CODDEST = $destino");
						$result = mysql_fetch_array($seldestino);

						$contrsai = $rescont['CONTRSAI'] + 1;
				?><br />
				<form action="cont_saida.php" method="post">
					<fieldset>
						<input type="hidden" name="coddest" value="<?php echo $result['CODDEST']; ?>" />

						<input type="hidden" name="nrit" value="<?php echo $i; ?>" />
						<label>Destino</label>
						<input type="text" value="<?php echo $result['DESCRICAO']; ?>" readonly /><br />
						<label>Data</label>
						<input type="text" name='data' value="<?php echo date("d-m-Y"); ?>"  /><br />
						<label>Respons&aacute;vel</label>
						<input type="text" name='responsavel' /><br /><br />
						<label>Observa&ccedil;&otilde;es</label>
						<textarea name="obs" rows="5" cols="50"></textarea><br />
						<label>Entregar</label>
						<input type="checkbox" checked name="entregar" class="box" value="1"/><br /><br />
						<input class="botao" type="submit" name="cadastrar" value="Continuar" />
					</fieldset>
				</form>
				<?php		
                       }
					} 		
				?><br />
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>
