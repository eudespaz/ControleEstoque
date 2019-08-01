<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Ajuste de Estoque";
		require_once ("includes/header.php"); 
	?>
</head>
<body>
			<?php 
				include('includes/topoemenu.php');
				require_once('includes/db.php');
			 ?>
			
			<div id="principal">			
				<form action="#" method="post">
					<fieldset class="filtra">
						<legend class="titulo">Ajuste no Estoque</legend>
						<select name="produto">
							<option value="">Selecione um Produto...</option>
                 		<?php
								$sql =  mysql_query("SELECT CODPROD, PRODUTO as titulo, GRUPO FROM produtos order by PRODUTO");
			 					while ($result = mysql_fetch_array($sql) )
			 					{
									echo "<option value='".$result['CODPROD']."'>".$result['titulo']."</option>";								
								}
							?>							
						</select><br />
						<input class="botao" type="submit" name="ajustar" value="Ok" />
					</fieldset>
			 	</form>
			 	
			 	<?php
			 		if($_POST['terminar'])
						{
							$codprod = $_POST['codprod'];
							$add = $_POST['adicionar'];
							$retirar = $_POST['retirar'];
							$obs = $_POST['obs'];
							$data = date("Y-m-d");
							if($obs == '')
							{
								echo "<script>alert('Especifique um Motivo'); history.back(-1);</script>";
							}
							else
							{
								$sql = mysql_query("INSERT INTO ajuste(id,data,produto,qtde_entrada,qtde_saida,obs) values('','$data','$codprod','$add','$retirar','$obs') ")or die(mysql_error());
								echo "Atualizado com Sucesso";
							}
						}
					if($_POST['ajustar'])
					{
						$codprod = $_POST['produto'];
						if($codprod == '')
							echo "Escolha um produto.";
						else
						{
							$sql = mysql_query("SELECT * FROM produtos WHERE CODPROD = $codprod");
							$query = mysql_fetch_array($sql);
							$estoque = mysql_query("SELECT Sum(itensent.QUANT) as quantent FROM itensent WHERE itensent.PRODUTO = $codprod");
							$achaestoque = mysql_fetch_array($estoque);
							$saiestoque = mysql_query("SELECT Sum(sitens.QUANT) as quantsai FROM sitens WHERE sitens.PRODUTO = $codprod");
							$achasaiestoque = mysql_fetch_array($saiestoque);
							$ajustes = mysql_query("SELECT Sum(ajuste.qtde_saida) as quantsai, Sum(ajuste.qtde_entrada) as quantent FROM ajuste WHERE ajuste.PRODUTO = $codprod");	
							$achaajuste = mysql_fetch_array($ajustes);						
							$estocado = ($achaestoque['quantent'] - $achasaiestoque['quantsai']) + ($achaajuste['quantent'] - $achaajuste['quantsai']);
							$nomeprod = $query['PRODUTO'];
				?>
						<form action="#" method="post">
							<fieldset>
								<legend class="titulo"><?php echo $nomeprod; ?></legend>
								<input type="hidden" name="codprod" value="<?php echo $codprod ?>" />
								<label>Total no Estoque</label>
								<input type="text" name="estoque" readonly value="<?php echo $estocado; ?>" / ><br /><br />
								<label>Adicionar</label>
								<input type="text" name="adicionar" value="" /><br />
								<label>Retirar</label>
								<input type="text" name="retirar" value="" /><br /><br />
								<label>Motivos</label>
								<textarea name="obs" rows="5" cols="50"></textarea><br />
								<input type="submit" name="terminar" value="Enviar" class="botao" />
							</fieldset>						
						</form>
				<?php 
						}	
					}			
				?>			
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>