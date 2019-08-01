<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Sa&iacute;das de Estoque";
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
					if($_GET)	//exibe detalhes
					{
						$id = $_GET['id'];
				?>	<b>******* REFERENTE SAIDA N. <big><?php echo $id; ?></big> *******</b><br /><br />
						<table cellspacing="5px" align="center">
							<colgroup>
								<col align="left" span="7" />
							</colgroup>
					
							<tbody>
						<?php
							$sql = mysql_query("SELECT *,date_format(DATA, '%d/%m/%Y') AS data FROM saidas WHERE CONTRSAI = $id order by CONTRSAI")or die(mysql_error());
							//recupera os dados da saida
							while ($query1 = mysql_fetch_array($sql))//laço pra exibir o pedido
							{
								$ultimo = $query1['CONTRSAI'];
								$sql2 = mysql_query("SELECT * FROM sitens WHERE CONTRSAI = $ultimo")or die(mysql_error());
								$dest = $query1['DESTINO'];
								$query4 = mysql_query("SELECT * FROM destinos WHERE CODDEST = $dest");
								$destino = mysql_fetch_array($query4);	

						?>
								<tr>
									<td class="td" style="font-weight:bold;">Documento</td>
									<td class="td" style="font-weight:bold;">Sa&iacute;da</td>							
									<td class="td" style="font-weight:bold;">Destino</td>									
									<td class="td" style="font-weight:bold;">Retirado por</td>
									
								</tr>
								<tr>
									<td class="td"><?php echo $query1['CONTRSAI'];?></td>
									<td class="td"><?php echo $query1['data']; ?></td>
									<td class="td"><?php echo $destino['DESCRICAO']; ?></td>									
									<td class="preco"><?php echo $query1['RESPONSAV']; ?></td>
								</tr>
							</tbody>
						</table>
						<br />
						<table cellspacing="5px" align="center">					
							<tbody>			
								<tr align="center">
									<td class="td" style="font-weight:bold;">Item</td>
									<td class="td" style="font-weight:bold;">Produto</td>
									<td class="td" style="font-weight:bold;">Quantidade</td>	
									<td class="td" style="font-weight:bold;">Valor UN</td>
									<td class='td' style="font-weight:bold;">Custo Total</td>					
								</tr>								
				<?php	
						$sql5 = mysql_query("SELECT * FROM sitens WHERE CONTRSAI = $ultimo")or die(mysql_error());					
						$i = 0;
						while($query2 = mysql_fetch_array($sql5))//laço pra exibir os produtos
						{	
							$i++;
							$codprod = $query2['PRODUTO'];
							$produto = mysql_query("SELECT * FROM produtos WHERE CODPROD = $codprod");
							$prod = mysql_fetch_array($produto);
							$totalprod = $prod['CUSTO'] * $query2['QUANT'];	
							$total = $total + $totalprod;	
				?>
					<tr align="center">
						<td class="td"><?php echo $query2['NRIT']; ?></td>
						<td class="td"><?php echo $prod['PRODUTO']; ?></td>
						<td class="preco"><?php echo $query2['QUANT']; ?></td>
						<td class="preco">R$<?php echo number_format($prod['CUSTO'], 2, ',', '.'); ?></td>
						<td class="preco">R$<?php echo number_format($totalprod, 2, ',', '.'); ?></td>
					</tr>
				<?php
						}// fim do laço pra exibir os produtos
					?>  <p>Observa&ccedil;&otilde;es: <b><?php echo $query1['OBS']; ?></b></p>
				<?php 	
					}//fim do laço pra exibir o pedido
				 	
				?>		<tr><td></td><td></td><td></td><td class='preco' style="font-weight:bold;">Total</td><td class='preco' style="font-weight:bold;">R$ <?php echo number_format($total, 2, ',', '.'); ?></td></tr>
					</tbody>
				</table>
				<a href="#" onclick="window.print()"><img  class="nao_imprimir" src="css/img/imprimir.gif" alt="imprimir" /></a> <br />
				<input class="nao_imprimir" id="back" type="submit" name="voltar" value="Voltar" onclick="history.back(-1);" />
				<?php
					}
					else// exibe os links pra visualizar
					{
						$destino= mysql_query("SELECT * FROM destinos ORDER BY DESCRICAO")or die (mysql_error());
				?>
						<div id="search"><!-- Campo de pesquisa -->
							<form action="#" method="post">
								<fieldset>
									<legend class="titulo">Filtrar por datas</legend>
									<label class="data">De</label>
									<input type="text" name="data" maxlength="10" class="input" OnKeyUp="mascaraData(this);" />
							&nbsp;<select name="destino">
										<option>Selecione um Local..</option>
										<?php
											while ( $resdestino = mysql_fetch_array($destino))
											{
										?>
										<option value="<?php echo $resdestino['CODDEST']; ?>"><?php echo $resdestino['DESCRICAO']; ?></option>";								
										<?php
											}
										?>				
									</select><br />
									<label class="data">At&eacute;</label>
									<input type="text" name="data2" maxlength="10" class="input" OnKeyUp="mascaraData2(this);" /><br />
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
									<td class='td' style="font-weight:bold;">Pedido</td>
									<td class='td' style="font-weight:bold;">Data</td>
									<td class='td' style="font-weight:bold;">Destino</td>
									<td class='td' style="font-weight:bold;">Respons&aacute;vel</td>					
								</tr>
				<?php
							$coddest = $_POST['destino'];
                     $data = $_POST['data'];
                     $ate = $_POST['data2'];
                     if($data == $ate)
                        echo "Exibindo sa&iacute;das do dia ".$data.".";
                     else
       						echo "Exibindo desde ".$data." at&eacute; ".$ate."";
							$data = explode("/",$_POST['data']);
							$dt= $data[2] ."-". $data[1] ."-". $data[0];
							$ate = explode("/",$_POST['data2']);
							$dt2= $ate[2] ."-". $ate[1] ."-". $ate[0];
							if($coddest != 0 && $dt <> '' && $dt2 <> '')
								$sqlentra = mysql_query ("SELECT *,date_format(DATA, '%d/%m/%Y') AS data FROM saidas WHERE DATA >= '$dt' AND DATA <= '$dt2' AND DESTINO = $coddest order by CONTRSAI desc")or die("ERRO");
							if($dt == 0 && $dt2 == 0) 
								$sqlentra = mysql_query ("SELECT *,date_format(DATA, '%d/%m/%Y') AS data FROM saidas WHERE DESTINO = $coddest order by CONTRSAI desc")or die("ERRO");
							if ($coddest == 0)
								$sqlentra = mysql_query ("SELECT *,date_format(DATA, '%d/%m/%Y') AS data FROM saidas WHERE DATA >= '$dt' AND DATA <= '$dt2' order by CONTRSAI desc")or die("ERRO");
							while( $result = mysql_fetch_array($sqlentra))
							{							
								
								echo "<tr>";
								echo "<td class='td'>".$result['CONTRSAI']."</td>";
								echo "<td class='td'>".$result['data']."</td>";
								echo "<td class='td'>".$result['NOMEDEST']."</td>";
								echo "<td class='td'>".$result['RESPONSAV']."</td>";
				?>				<td class="nao_imprimir2"><a href="versaidas.php?id=<?php echo $result['CONTRSAI']; ?>">Ver</a></td>
								</tr>
				<?php
								
							}
				?>			</tbody>
						</table>
				<?php
						}
					
						else//mostra os resultados, limit na linha 19.
						{
					?>
						<table align="center" cellspacing="3px">
							<colgroup>
								<col align="left" span="7" />
							</colgroup>
							<thead></thead>
							<tbody>
								<tr>
									<td class="td" style="font-weight:bold;">N. Pedido</td>
									<td class="td" style="font-weight:bold;">Data</td>
									<td class="td" style="font-weight:bold;">Destino</td>
									<td class="td" style="font-weight:bold;">Respons&aacute;vel</td>												
								</tr>								
							<?php
								$sql = mysql_query("SELECT *,date_format(DATA, '%d/%m/%Y') AS data FROM saidas order by CONTRSAI desc LIMIT 100")or die(mysql_error());
								//recupera os dados da saida
								while ($query1 = mysql_fetch_array($sql))//laço pra exibir o pedido
								{
									$ultimo = $query1['CONTRSAI'];		
									$dest = $query1['DESTINO'];
									$query4 = mysql_query("SELECT * FROM destinos WHERE CODDEST = $dest");
									$destino = mysql_fetch_array($query4);
								?>
								<tr>
									<td class="td"><?php echo $query1['CONTRSAI'];?></td>
									<td class="td"><?php echo $query1['data']; ?></td>
									<td class="td"><?php echo $destino['DESCRICAO']; ?></td>
									<td class="td"><?php echo $query1['RESPONSAV']; ?></td>
									<td class="nao_imprimir2"><a href="versaidas.php?id=<?php echo $query1['CONTRSAI']; ?>">Ver</a></td>
								</tr>
								
							<?php
								}//fim do laço pra exibir o pedido
							?>			
							</tbody>
						</table>
						
					<?php			
							}//fim do else, linha 136						
						}//fim do else pra exibir os links, linha 85
					?>
					
					<div id="assinar">
						<p style="position:relative;">Itarar&eacute;, _____ de ___________________ de _______ .<br /><br /><br />
						&nbsp;--------------------------------------------<br />Assinatura do Respons&aacute;vel</p>
					</div>
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>
