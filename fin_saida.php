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
			 ?>
			
			<div id="principal">
				<?php
					if ($_POST['adicionar'])
					{
						$controle = $_POST['contrsaida'];
						$i = $_POST['nrit'];
						$i++;
						$nrit = $i;
						$produto = $_POST['produto'];
						$quantidade = $_POST['quantidade'];
						$custototal = $result['quantidade'] * $result['custo'];
						$total = $total + $custototal;
						$sql = mysql_query("INSERT INTO sitens(CONTRSAI,NRIT,PRODUTO,QUANT) values('$controle','$nrit','$produto','$quantidade')");
						$achaprod = mysql_query("SELECT sitens.CONTRSAI, sitens.NRIT, produtos.CODPROD as codigo, produtos.PRODUTO as produtos, produtos.CUSTO as custo, sitens.QUANT as quantidade  FROM sitens INNER JOIN produtos ON sitens.PRODUTO = produtos.CODPROD WHERE sitens.CONTRSAI = $controle") or die(mysql_error());
						
					}			
				?>
				<form method="post" action="versaidas.php?id=<?php echo $controle; ?>">
					<fieldset>
						<legend class="titulo">Produtos Cadastrados</legend>
						<table>
							<tbody>
								<tr>
									<td class="td" style="font-weight:bold;">Produto</td>
									<td class="td" style="font-weight:bold;">Quantidade</td>
									<td class="td" style="font-weight:bold;">Custo</td>
									<td class="td" style="font-weight:bold;">Custo Total</td>
									<td class="td" style="font-weight:bold;">No Estoque</td>															
								</tr>
								<?php 
									$total = 0;
									while ($result = mysql_fetch_array($achaprod))
									{
										$codprod = $result['codigo'];
										$estoque = mysql_query("SELECT Sum(itensent.QUANT) as quantent FROM itensent WHERE itensent.PRODUTO = $codprod");
										$achaestoque = mysql_fetch_array($estoque);
										$saiestoque = mysql_query("SELECT Sum(sitens.QUANT) as quantsai FROM sitens WHERE sitens.PRODUTO = $codprod");
										$achasaiestoque = mysql_fetch_array($saiestoque);
										$ajustes = mysql_query("SELECT Sum(ajuste.qtde_saida) as quantsai, Sum(ajuste.qtde_entrada) as quantent FROM ajuste WHERE ajuste.PRODUTO = $codprod");	
										$achaajuste = mysql_fetch_array($ajustes);						
										$estocado = ($achaestoque['quantent'] - $achasaiestoque['quantsai']) + ($achaajuste['quantent'] - $achaajuste['quantsai']);				
										
										$custototal = $result['quantidade'] * $result['custo'];
										$total = $total + $custototal;
										echo "<tr>
													<td><input type='text' name='produto' value='".$result['produtos']."' /></td>
													<td><input class='quant' type='text' name='quantidade' value='".$result['quantidade']."' /></td>
													<td><input class='quant' type='text' name='custo' value='".number_format($result['custo'], 2, ',', '.')."' /></td>
													<td><input class='quant' type='text' name='custototal' value='".number_format($custototal, 2, ',', '.')."' /></td>
												";
										if($estocado <= 0) 
											echo "<td><input style='color:red; font-weight:bold' class='quant' type='text' name='estoque' value='".$estocado."' /></td>";
										else
											echo "<td><input class='quant' type='text' name='estoque' value='".$estocado."' /></td>	
												</tr>								
												";
									}
									echo "
											<tr><td></td><td></td>
												<td class='td' style='font-weight:bold;'>Total</td>
												<td style='background: #EEE;'><input readonly class='quant' type='text' name='total' value='R$".number_format($total, 2, ',', '.')."' /></td>
											</tr>
											";
								?>
							</tbody>
						</table>						
						<br />
						<input type="submit" class="botao" name="finalizar" value="Finalizar" />
					</fieldset>
				</form>		
				<form method="post" action="cont_saida.php">
					<input type="hidden" name="contrsaida" value="<?php echo $controle; ?>" />	
					<input type="hidden" name="nrit" value="<?php echo $i; ?>" />		
					<input type="submit" class="botao" name="maisitens" value="Mais Itens" />
				</form>
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>