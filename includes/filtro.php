<?php
	$data = $_POST['data'];
	$data2 = $_POST['data2'];
	$data = implode("-", array_reverse(explode("/", $data)));
	$data2 = implode("-", array_reverse(explode("/", $data2)));
	if($id == 'saidas')
	{
?>
			<?php					
				if($_POST['filtra']) // Verifica se foi filtrado
				{
					$destino = $_POST['destino'];				
					$produto = $_POST['produto'];
						if($sql != 0)
						{
							if(isset($_POST['grupo']) && $destino && $data && $data2) // verifica os campos					
							{
								$sql = mysql_query("SELECT *,saidas.CONTRSAI as contrsai, destinos.DESCRICAO as destino FROM saidas, destinos WHERE saidas.DESTINO = $destino AND destinos.CODDEST = $destino AND saidas.DATA >= '$data' AND saidas.DATA <= '$data2'");
								$result = mysql_fetch_array($sql);								
								echo "<b>".$result['destino']."</b><br />";
								echo "Sa&iacute;das acumuladas de &nbsp;&nbsp;&nbsp;<i>".$_POST['data']."</i> &nbsp;&nbsp;&nbsp; at&eacute; &nbsp;&nbsp; <i>".$_POST['data2']."</i>";
							}							
							if($destino == '' && $data == '' || $data2 == '')
							{
								$sql = mysql_query("SELECT * FROM destinos WHERE CODDEST = $destino ");
								$result = mysql_fetch_array($sql);								
								echo "<b>".$result['DESCRICAO']."</b><br />";
							}
							$contrsai = $result['contrsai'];							
							foreach($_POST["grupo"] as $valor) //percorre o vetor grupo, de checkbox
							{
								if(isset($_POST['grupo']) && $destino && $data && $data2 && $produto)
									$achaitens = mysql_query ("SELECT date_format(saidas.DATA, '%d/%m/%Y') as data, sitens.PRODUTO AS CodProd,  produtos.CODPROD, produtos.PRODUTO as produto, sitens.QUANT as quantidade, sitens.NRIT as nrit 
																		FROM (saidas INNER JOIN sitens ON saidas.CONTRSAI = sitens.CONTRSAI) INNER JOIN produtos ON sitens.PRODUTO = produtos.CODPROD 
																		WHERE saidas.DATA >= '$data' AND saidas.DATA <= '$data2' AND produtos.GRUPO = $valor AND saidas.DESTINO = $destino AND produtos.CODPROD = $produto ORDER BY saidas.DATA desc") or die(mysql_error());
								if(isset($_POST['grupo']) && $destino && $data == '' && $data2 == '' && $produto)
									$achaitens = mysql_query ("SELECT date_format(saidas.DATA, '%d/%m/%Y') as data, sitens.PRODUTO AS CodProd,  produtos.CODPROD, produtos.PRODUTO as produto, sitens.QUANT as quantidade, sitens.NRIT as nrit 
																		FROM (saidas INNER JOIN sitens ON saidas.CONTRSAI = sitens.CONTRSAI) INNER JOIN produtos ON sitens.PRODUTO = produtos.CODPROD 
																		WHERE produtos.GRUPO = $valor AND saidas.DESTINO = $destino AND produtos.CODPROD = $produto ORDER BY saidas.DATA desc") or die(mysql_error());
								if(isset($_POST['grupo']) && $destino && $data == '' && $data2 == '' && $produto == '')
									$achaitens = mysql_query ("SELECT date_format(saidas.DATA, '%d/%m/%Y') as data, sitens.PRODUTO AS CodProd,  produtos.CODPROD, produtos.PRODUTO as produto, sitens.QUANT as quantidade, sitens.NRIT as nrit 
																		FROM (saidas INNER JOIN sitens ON saidas.CONTRSAI = sitens.CONTRSAI) INNER JOIN produtos ON sitens.PRODUTO = produtos.CODPROD 
																		WHERE produtos.GRUPO = $valor AND saidas.DESTINO = $destino ORDER BY saidas.DATA desc") or die(mysql_error());								
								if(isset($_POST['grupo']) && $destino == '' && $data && $data2 && $produto)
									$achaitens = mysql_query ("SELECT date_format(saidas.DATA, '%d/%m/%Y') as data, sitens.PRODUTO AS CodProd,  produtos.CODPROD, produtos.PRODUTO as produto, sitens.QUANT as quantidade, sitens.NRIT as nrit 
																		FROM (saidas INNER JOIN sitens ON saidas.CONTRSAI = sitens.CONTRSAI) INNER JOIN produtos ON sitens.PRODUTO = produtos.CODPROD 
																		WHERE saidas.DATA >= '$data' AND saidas.DATA <= '$data2' AND produtos.GRUPO = $valor AND produtos.CODPROD = $produto ORDER BY saidas.DATA desc") or die(mysql_error());
								if(isset($_POST['grupo']) && $destino && $data && $data2 && $produto == '')
									$achaitens = mysql_query ("SELECT date_format(saidas.DATA, '%d/%m/%Y') as data, sitens.PRODUTO AS CodProd,  produtos.CODPROD, produtos.PRODUTO as produto, sitens.QUANT as quantidade, sitens.NRIT as nrit 
																		FROM (saidas INNER JOIN sitens ON saidas.CONTRSAI = sitens.CONTRSAI) INNER JOIN produtos ON sitens.PRODUTO = produtos.CODPROD 
																		WHERE saidas.DATA >= '$data' AND saidas.DATA <= '$data2' AND produtos.GRUPO = $valor AND saidas.DESTINO = $destino ORDER BY saidas.DATA desc") or die(mysql_error());
								if(isset($_POST['grupo']) && $destino == '' && $data && $data2 && $produto)
									$achaitens = mysql_query ("SELECT date_format(saidas.DATA, '%d/%m/%Y') as data, sitens.PRODUTO AS CodProd,  produtos.CODPROD, produtos.PRODUTO as produto, sitens.QUANT as quantidade, sitens.NRIT as nrit 
																		FROM (saidas INNER JOIN sitens ON saidas.CONTRSAI = sitens.CONTRSAI) INNER JOIN produtos ON sitens.PRODUTO = produtos.CODPROD 
																		WHERE saidas.DATA >= '$data' AND saidas.DATA <= '$data2' AND produtos.GRUPO = $valor AND produtos.CODPROD = $produto ORDER BY produtos.PRODUTO") or die(mysql_error());							
								$pegagrupo = mysql_query("SELECT * FROM grupos WHERE CODGRUP = $valor"); // pega o nome do grupo
								$nomegrupo = mysql_fetch_array($pegagrupo);
								//echo "<br /><br /><b>".$nomegrupo['GRUPO']."</b>";
								if(mysql_num_rows($achaitens) > 0)
								{
									echo "<table cellspacing='5px'>
												<tbody>
													<tr>
														<td class='td' style='font-weight:bold;'>Data</td>
														<td class='td' style='font-weight:bold;'>Grupo</td>
														<td class='td' style='font-weight:bold;'>Produto</td>
														<td class='td' style='font-weight:bold;'>Quantidade</td>
													</tr>";
									while ($result = mysql_fetch_array($achaitens))
									{
										echo "	<tr>
														<td class='td'>".$result['data']."</td>
														<td class='td'>".$nomegrupo['GRUPO']."</td>
														<td class='td'>".$result['produto']."</td>
														<td class='preco'>".$result['quantidade']."</td>
													</tr>";
									}
									echo "	</tbody>
											</table>";
								}
							}
						} //fim da verificacao
				}
				else //começa o form de filtrar saidas
				{
				?>
						<form action="#" method="post">
							<fieldset>
								<legend class="titulo">Filtrando Saidas</legend>
								<label>Grupos</label><br /><br />
								
									<?php
										while ( $query = mysql_fetch_array($sql))
										{
									?>
											<input class="box" checked type="checkbox" name="grupo[]" value="<?php echo $query['CODGRUP']; ?>" /><?php echo $query['GRUPO']; ?><br />
									<?php
										}
									?>				
								<a href="javascript:marcar()">Marcar Todas</a> | 
								<a href="javascript:desmarcar()">Desmarcar Todas</a>
								<br />
								<label>Destino</label>
								<select name="destino">
									<option value="">Selecione um Destino . . .</option>	
									<?php
										while ( $query = mysql_fetch_array($sql2))
										{
											echo "<option value='".$query['CODDEST']."'>".$query['DESCRICAO']."</option>";								
										}
									?>							
								</select><br /><br />
								<label>Produto</label>
								<select name="produto">
									<option value="">Selecione um Produto . . .</option>	
									<?php
										$sql= mysql_query("SELECT PRODUTO, CODPROD,CUSTO FROM produtos order by PRODUTO") or die("Erro");
										while ( $query = mysql_fetch_array($sql3))
										{
											echo "<option value='".$query['CODPROD']."'>".$query['PRODUTO']."</option>";								
										}
									?>							
								</select><br /><br />
								<label class="data">De</label>
								<input type="text" name="data" maxlength="10" onkeyup="mascaraData(this);" /><br />					
								<label class="data">At&eacute;</label>
								<input type="text" name="data2" maxlength="10" class="input" onkeyup="mascaraData2(this);" /> *Usar /<br />
								<input name="filtra" type="submit" class="botao" value="Filtrar"/>							
							</fieldset>						
						</form>
<?php
				} //fim do else pro form.
		} //fim do filtro de saidas
		
		if($id == 'entradas')
		{
?>							
						<form action="#" method="post">
							<fieldset>
								<legend class="titulo">Filtrando Entradas</legend>
								<select name="fornecedor">
									<option>Selecione um Fornecedor...</option>	
									<?php
										while ( $query = mysql_fetch_array($sql))
										{
											echo "<option value='".$query['CODIGO']."'>".$query['NOME']."</option>";								
										}
									?>							
								</select><br />
								<label class="data">De</label>
								<input type="text" name="data" maxlength="10" onkeyup="mascaraData(this);" /><br />					
								<label class="data">At&eacute;</label>
								<input type="text" name="data2" maxlength="10" class="input" onkeyup="mascaraData2(this);" /> *Usar /<br />
								<input name="filtra" type="submit" class="botao" value="Filtrar"/>
							</fieldset>
						</form>				
						<?php 
							if($_POST['filtra'])
							{
						?><br />
								<table>
									<tbody>
										<tr>
											<td class="td" style="font-weight:bold;">Data </td>
											<td class="td" style="font-weight:bold;">Produto </td>
											<td class="td" style="font-weight:bold;">Quantidade</td>
										</tr>
						<?php
								$fornecedor = $_POST['fornecedor'];
								if($data <> 0 && $data2 <> 0 && $fornecedor <> 0)
								{
									$sql = mysql_query("SELECT *,date_format(entra.DATA, '%d/%m/%Y') as data,fornec.NOME as nome FROM entra, fornec WHERE entra.FORNECEDOR = $fornecedor AND DATA BETWEEN '$data' AND '$data2' AND fornec.CODIGO = $fornecedor ORDER BY CONTROLE desc")or die(mysql_error());
									$sql2 = mysql_query("SELECT *,date_format(entra.DATA, '%d/%m/%Y') as data,fornec.NOME as nome FROM entra, fornec WHERE entra.FORNECEDOR = $fornecedor AND DATA BETWEEN '$data' AND '$data2' AND fornec.CODIGO = $fornecedor ORDER BY CONTROLE desc")or die(mysql_error());									
									$result = mysql_fetch_array($sql2);									
									$data = $_POST['data'];
									$data2 = $_POST['data2'];									
									echo "Filtrando Entradas de <i>".$data."</i> at&eacute; <i>".$data2." do Fornecedor ".$result['nome']."</i>";								
								}
								if($data == 0 && $data2 == 0 && $fornecedor <> 0)
								{
									$sql = mysql_query("SELECT *,date_format(entra.DATA, '%d/%m/%Y') as data, fornec.NOME as nome FROM entra, fornec WHERE entra.FORNECEDOR = $fornecedor AND fornec.CODIGO = $fornecedor ORDER BY CONTROLE desc")or die(mysql_error());
									$sql2 = mysql_query("SELECT *,date_format(entra.DATA, '%d/%m/%Y') as data, fornec.NOME as nome FROM entra, fornec WHERE entra.FORNECEDOR = $fornecedor AND fornec.CODIGO = $fornecedor ORDER BY CONTROLE desc")or die(mysql_error());
									$result = mysql_fetch_array($sql2);									
									echo "Filtrando Entradas do Fornecedor <i><b>".$result['nome']."</b></i>";	
								}
								if($fornecedor == 0 && $data <> 0 && $data2 <> 0)
								{
									$sql = mysql_query("SELECT *,date_format(DATA, '%d/%m/%Y') as data FROM entra WHERE DATA BETWEEN '$data' AND '$data2' ORDER BY CONTROLE desc")or die(mysql_error());
									$data = $_POST['data'];
									$data2 = $_POST['data2'];									
									echo "De &nbsp;<i>".$data."</i>&nbsp;&nbsp;  at&eacute; &nbsp;<i>".$data2."</i>";	
								}
								while($result = mysql_fetch_array($sql))
								{
									$controle = $result['CONTROLE'];
									$achaprods = mysql_query("SELECT *, Sum(QUANT) AS quant FROM itensent WHERE CONTROLE = $controle GROUP BY PRODUTO, QUANT, CONTROLE ORDER BY PRODUTO desc")or die(mysql_error());
									while ($pegaprods = mysql_fetch_array($achaprods))
									{
										$codprod = $pegaprods['PRODUTO'];
										$peganome = mysql_query("SELECT * FROM produtos WHERE CODPROD = $codprod")or die(mysql_error());
										$arrayprod = mysql_fetch_array($peganome);
						?>
											<tr>
												<td class="td"><?php echo $result['data']; ?></td>
												<td class="td"><?php echo $arrayprod['PRODUTO']; ?></td>
												<td class="preco"><?php echo $pegaprods['quant']; ?></td>
											</tr>
						<?php
									}
								}
						?>
									</tbody>
								</table>
						<?php
							} //fim do $_POST['filtra']
						?>							
<?php
		} //fim do if($id == 'entradas') 
?>