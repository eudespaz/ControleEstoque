<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Entrada de Estoque";
		require_once ("includes/header.php"); 
	?>
</head>
<body>
			<?php 
				include('includes/topoemenu.php');
				require_once('includes/db.php');
				$sql2= mysql_query("SELECT NOME,CODIGO FROM fornec order by NOME") or die("Erro");
				$sql3= mysql_query("SELECT CONTROLE FROM entra order by CONTROLE desc");				
				$controle = mysql_fetch_array($sql3);
			 ?>
			
			<div id="principal">
				
				<form action="cont_pedido.php" method="post">
					<fieldset>
						<legend class="titulo">Entrada de Produtos &darr; </legend>
						<input type="hidden" name="nritem" value="<?php echo $i; ?>" />
						<!--<label>ID</label>
						<input type="text" name="controle" readonly value="<?php $controle = $controle['CONTROLE'] + 1; echo $controle ?>" /><br />-->
						<label>Fornecedor</label>						
						<select name="fornecedor">
							<option>Selecione um Fornecedor...</option>	
							<?php
								while ( $query2 = mysql_fetch_array($sql2))
								{
									echo "<option value='".$query2['CODIGO']."'>".$query2['NOME']."</option>";								
								}
							?>							
						</select><br />	
						<label>Numero NF</label>
						<input type="text" name="numeronf" maxlength="6" /><br />
						<label>Data</label>
						<input type="text" name='data' value="<?php echo date("d-m-Y"); ?>" maxlength="10" /><br />	
						<label>Valor Nota Fiscal</label>
						<input type="text" name="valornf" maxlength="10" /><br />					
						<input class="botao" type="submit" name="enviar" value="Cadastrar"/>
					</fieldset>		
					
				</form>
				
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>