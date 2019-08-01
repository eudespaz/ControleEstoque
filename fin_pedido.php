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
			 ?>
			
			<div id="principal">
				<?php // essa pagina faz parte do cadastro de entrada de estoque
					if ($_POST['add'])
					{
						$i = $_POST['nritem'];
						$i++;
						$nritem = $i;
						$controle = $_POST['controle'];
						$quant = $_POST['quantidade'];
						$produto = $_POST['produto'];
						$custoun = $_POST['custoun'];
						$custoprod = mysql_query("SELECT * FROM produtos WHERE CODPROD = $produto ");						
						$achacusto = mysql_fetch_array($custoprod);
						$custocad = $achacusto['CUSTO'];
						$customed = $achacusto['CUSTOMED'];
						if($custoun != $custocad)
						{
							$customed = ($customed + $custoun) / 2;
							$altera = mysql_query("UPDATE produtos SET CUSTO='$custoun', CUSTOMED='$customed' WHERE CODPROD = $produto");						
						}						
						$cad = mysql_query("INSERT INTO itensent(CONTROLE,NRITEM,PRODUTO,QUANT,CUSTO) values('$controle','$nritem','$produto','$quant','$custoun')")or die(mysql_error());
						$achaprod = mysql_query("SELECT itensent.CONTROLE, itensent.NRITEM, itensent.PRODUTO, produtos.PRODUTO as produtos, produtos.CODPROD as codigo, itensent.QUANT as quantidade, itensent.CUSTO as custo FROM itensent INNER JOIN produtos ON itensent.PRODUTO = produtos.CODPROD WHERE itensent.CONTROLE=$controle")or die(mysql_error());
					}
				?>
				<form method="post" action="verentradas.php?id=<?php echo $controle; ?>">
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
								$custototal = $result['quantidade'] * $result['custo'];
								$total = $total + $custototal;
								
								$codprod = $result['codigo'];
								$estoque = mysql_query("SELECT Sum(itensent.QUANT) as quantent FROM itensent WHERE itensent.PRODUTO = $codprod");
								$achaestoque = mysql_fetch_array($estoque);
								$saiestoque = mysql_query("SELECT Sum(sitens.QUANT) as quantsai FROM sitens WHERE sitens.PRODUTO = $codprod");
								$achasaiestoque = mysql_fetch_array($saiestoque);
								$ajustes = mysql_query("SELECT Sum(ajuste.qtde_saida) as quantsai, Sum(ajuste.qtde_entrada) as quantent FROM ajuste WHERE ajuste.PRODUTO = $codprod");	
								$achaajuste = mysql_fetch_array($ajustes);						
								$estocado = ($achaestoque['quantent'] - $achasaiestoque['quantsai']) + ($achaajuste['quantent'] - $achaajuste['quantsai']);	
								echo "<tr>
											<td><input type='text' name='produto' value='".$result['produtos']."' /></td>
											<td><input class='quant' type='text' name='quantidade' value='".$result['quantidade']."' /></td>
											<td><input class='quant' type='text' name='custo' value='".number_format($result['custo'], 2, ',', '.')."' /></td>
											<td><input class='quant' type='text' name='custototal' value='".number_format($custototal, 2, ',', '.')."' /></td>								
											<td><input class='quant' type='text' name='estoque' value='".$estocado."' /></td>
											<td><a id='editar' class='nao_imprimir' href=''> Editar </a></td>
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
				<form method="post" action="cont_pedido.php">
					<input type="hidden" name="controle" value="<?php echo $controle; ?>" />	
					<input type="hidden" name="nritem" value="<?php echo $i; ?>" />		
					<input type="submit" class="botao" name="maisitens" value="Mais Itens" />
				</form>
				
			</div> <!-- Fim da div#principal -->
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>
