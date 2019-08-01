<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Ver Entradas";
		$data = date("d-m-Y");
		require_once ("includes/header.php"); 
	?>
	<script type="text/javascript" src="includes/js/data.js"></script>
</head>
<body>
			<?php 
				include('includes/topoemenu.php');
				require_once('includes/db.php');
			?>
			
			<div id="principal">
				
				<?php
					$sqlentra1 = mysql_query("SELECT *,date_format(DATA, '%d/%m/%Y') AS data FROM entra ORDER BY CONTROLE")or die(mysql_error());
					$fornec = mysql_fetch_array($sqlentra1);
					if($_GET)//mostra detalhadamente
					{
						$cod = $_GET['id'];
						$sqlentra = mysql_query("SELECT *, date_format(DATA, '%d/%m/%Y') AS data FROM entra WHERE CONTROLE = $cod order by CONTROLE desc")or die(mysql_error());
						$result = mysql_fetch_array($sqlentra);
						$fornec = $result['FORNECEDOR'];
						$sqlforn = mysql_query("SELECT NOME, CODIGO FROM fornec WHERE CODIGO = $fornec")or die(mysql_error());
						$achafor = mysql_fetch_array($sqlforn);
				?>
						<table cellspacing="3px" align="center">
							<tbody>
								<tr>
									<td class='td' style="font-weight:bold;">COD</td>
									<td class='td' style="font-weight:bold;">Data</td>
									<td class='td' style="font-weight:bold;">Fornecedor</td>
									<td class='td' style="font-weight:bold;">Nota Fiscal</td>
									<td class='td' style="font-weight:bold;">Valor Nota Fiscal</td>
														
								</tr>
				<?php
							$valornf = number_format($result['VALORNF'], 2, ',', '.');
							echo "<tr>";
							echo "<td class='td'>".$result['CONTROLE']."</td>";
							echo "<td class='td'>".$result['data']."</td>";
							echo "<td class='td'>".$achafor['NOME']."</td>";
							echo "<td class='td'>".$result['NFNR']."</td>";
							echo "<td class='preco'>R$ ".$valornf."</td>";
							echo "</tr>";
				?>
								</tbody>
							</table><br />
						<table cellspacing="3px" align="center">
							<tbody>
								<tr>
									<td class='td' style="font-weight:bold;">Item</td>
									<td class='td' style="font-weight:bold;">Produto</td>
									<td class='td' style="font-weight:bold;">Quantidade</td>
									<td class='td' style="font-weight:bold;">Custo Unit&aacute;rio</td>		
									<td class='td' style="font-weight:bold;">Custo Total</td>		
								</tr>
								
				<?php
							$itens = mysql_query("SELECT * FROM itensent WHERE CONTROLE = $cod order by NRITEM")or die (mysql_error());
							while($result = mysql_fetch_array($itens))//carrega os dados escolhidos no get
							{
								$codprod = $result['PRODUTO'];
								$produto = mysql_query("SELECT PRODUTO,CODPROD FROM produtos WHERE CODPROD = $codprod")or die (mysql_error());;
								$prod = mysql_fetch_array($produto);
								$totalprod = $result['CUSTO'] * $result['QUANT'];	
								$total = $total + $totalprod;
								$totalprod = number_format($totalprod, 2, ',', '.');
								$custo = number_format($result['CUSTO'], 2, ',', '.');
								echo "<tr>";
								echo "<td class='td'>".$result['NRITEM']."</td>";
								echo "<td class='td'>".$prod['PRODUTO']."</td>";
								echo "<td class='preco'>".$result['QUANT']."</td>";
								echo "<td class='preco'>R$ ".$custo."</td>";
								echo "<td class='preco'>R$ ".$totalprod."</td>";
								echo "</tr>";							
							}
				?>		<tr><td></td><td></td><td></td><td class='preco' style="font-weight:bold;">Total</td><td class='preco' style="font-weight:bold;">R$ <?php echo number_format($total, 2, ',', '.'); ?></td></tr>
						</tbody>
					</table>
					<a href="#materia" onclick="window.print()"><img  class="nao_imprimir" src="css/img/imprimir.gif" alt="imprimir" /></a> <br />
				<input class="nao_imprimir" id="back" type="submit" name="voltar" value="Voltar" onclick="history.back(-1);" />
				<?php		
					}// fim do if
					else//começa o form e os resultados 
					{
						$sql2= mysql_query("SELECT NOME,CODIGO FROM fornec order by NOME") or die("Erro");
					?>
						<div id="search"><!-- Campo de pesquisa -->
							<form action="#" method="post">
								<fieldset>
									<legend class="titulo">Filtrar Resultados . . .</legend>
									<label class="data">De</label>
									<input type="text" name="data" maxlength="10" class="input" onkeyup="mascaraData(this);" />
									&nbsp;<select name="fornecedor">
										<option>Selecione um Fornecedor...</option>	
										<?php
											while ( $query2 = mysql_fetch_array($sql2))
											{
												echo "<option value='".$query2['CODIGO']."'>".$query2['NOME']."</option>";								
											}
										?>							
									</select><br />
									<label class="data">At&eacute;</label>
									<input type="text" name="data2" maxlength="10" class="input" onkeyup="mascaraData2(this);" /><br />
									<input name="datas" type="submit" class="botao" value="Filtrar"/>
								</fieldset>
							</form>
						</div>
				<?php 
						if($_POST['datas'])//filtra pelas datas 
						{
				?>
							<table cellspacing="3px" align="center">
							<tbody>
								<tr>
									<td class='td' style="font-weight:bold;">COD</td>
									<td class='td' style="font-weight:bold;">Data</td>
									<td class='td' style="font-weight:bold;">Fornecedor</td>
									<td class='td' style="font-weight:bold;">Nota Fiscal</td>
									<td class='td' style="font-weight:bold;">Valor Nota Fiscal</td>					
								</tr>
				<?php
							$codfor = $_POST['fornecedor'];
							$fornecedor = mysql_query("SELECT NOME, CODIGO FROM fornec WHERE CODIGO = $codfor");
							$data = explode("/",$_POST['data']);
							$dt= $data[2] ."-". $data[1] ."-". $data[0];
							$ate = explode("/",$_POST['data2']);
							$dt2= $ate[2] ."-". $ate[1] ."-". $ate[0];
							if($codfor != 0 && $dt <> '' && $dt2 <> '')
								$sqlentra = mysql_query ("SELECT *,date_format(DATA, '%d/%m/%Y') AS data FROM entra WHERE DATA >= '$dt' AND DATA <= '$dt2' AND FORNECEDOR = $codfor")or die("ERRO");
							if($dt == 0 && $dt2 == 0) 
								$sqlentra = mysql_query ("SELECT *,date_format(DATA, '%d/%m/%Y') AS data FROM entra WHERE FORNECEDOR = $codfor")or die("ERRO");
							if ($codfor == 0)
								$sqlentra = mysql_query ("SELECT *,date_format(DATA, '%d/%m/%Y') AS data FROM entra WHERE DATA >= '$dt' AND DATA <= '$dt2'")or die("ERRO");
								
							while( $result = mysql_fetch_array($sqlentra))
							{							
								$codigoforn = $result['FORNECEDOR'];
								$sqlforn = mysql_query("SELECT NOME, CODIGO FROM fornec WHERE CODIGO = $codigoforn")or die(mysql_error());
								$achafor = mysql_fetch_array($sqlforn);
								$valornf = number_format($result['VALORNF'], 2, ',', '.');
								echo "<tr>";
								echo "<td class='td'>".$result['CONTROLE']."</td>";
								echo "<td class='td'>".$result['data']."</td>";
								echo "<td class='td'>".$achafor['NOME']."</td>";
								echo "<td class='td'>".$result['NFNR']."</td>";
								echo "<td class='preco'>R$ ".$valornf."</td>";
						?>		<td class="nao_imprimir2"><a href="verentradas.php?id=<?php echo $result['CONTROLE']; ?>">Ver</a></td>
						<?php
								echo "</tr>";
							}
				?>			</tbody>
						</table>
				<?php
						}
					
						else //mostra os resultados normais, sql na linha 54.
						{	
				?>
						<table cellspacing="3px" align="center">
							<tbody>
								<tr>
									<td class='td' style="font-weight:bold;">COD</td>
									<td class='td' style="font-weight:bold;">Data</td>
									<td class='td' style="font-weight:bold;">Fornecedor</td>
									<td class='td' style="font-weight:bold;">Nota Fiscal</td>
									<td class='td' style="font-weight:bold;">Valor Nota Fiscal</td>					
								</tr>
				<?php
                        $sqlentra = mysql_query("SELECT *,date_format(DATA, '%d/%m/%Y') AS data FROM entra ORDER BY CONTROLE desc LIMIT 200")or die(mysql_error());
						while($result = mysql_fetch_array($sqlentra))
						{
							$codigoforn = $result['FORNECEDOR'];
							$sqlforn = mysql_query("SELECT NOME, CODIGO FROM fornec WHERE CODIGO = $codigoforn")or die(mysql_error());
							$achafor = mysql_fetch_array($sqlforn);
							$valornf = number_format($result['VALORNF'], 2, ',', '.');
							
							echo "<tr>";
							echo "<td class='td'>".$result['CONTROLE']."</td>";
							echo "<td class='td'>".$result['data']."</td>";
							echo "<td class='td'>".$achafor['NOME']."</td>";
							echo "<td class='td'>".$result['NFNR']."</td>";
							echo "<td class='preco'>R$ ".$valornf." </td>";
					?>
							<td class="nao_imprimir2"><a href="verentradas.php?id=<?php echo $result['CONTROLE']; ?>">Ver</a></td>
					<?php
							echo "</tr>";						
						}	//fim do while
							
						echo "</tbody>";
					echo "</table>";	
						}//fim do else, linha 198
					}//fim do else p exibir os links, linha 125
				?>
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>
