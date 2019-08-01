<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$tabela = $_GET['tab'];
		$titulo = "Controle &raquo; Editar $tabela";
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
					$edita = $_GET['cod'];
					if($tabela == "produtos") //verifica o que esta sendo editado, no caso produtos
					{		
						// aqui começa a recuperar dados pra preencher o form 
						//$cat = $_GET['cat'];
						if($_POST['alterar']) // faz a alteraçao
						{
							$preco = mysql_query("SELECT CUSTO FROM produtos WHERE CODPROD = $edita");
							$antigo = mysql_fetch_array($preco);
							$produto = $_POST['produto'];
							$grupo = $_POST['grupo'];
							$cat = $grupo;
							$custo = $_POST['custo'];
							$unidade = $_POST['unidade'];
							$customed = ($custo + $antigo['CUSTO'] + $antigo['CUSTOMED']) / 3;
							$altera = mysql_query("UPDATE produtos SET PRODUTO='$produto', GRUPO = '$grupo', CUSTO = '$custo', CUSTOMED = '$customed', UNIDADE='$unidade' WHERE CODPROD = $edita") or die(mysql_error());
							echo "Alterado com Sucesso.";
						}
						//faz as consultas pra gerar o formulario	
						$recupera = mysql_query("SELECT * FROM produtos WHERE CODPROD = $edita") or die (mysql_error());
						$query = mysql_fetch_array($recupera);//aqui recupera o produto escolhido a ser editado
						$cat = $query['GRUPO'];		
						$recupera2 = mysql_query("SELECT * FROM grupos WHERE CODGRUP = $cat");
						$query2 = mysql_fetch_array($recupera2);//aqui recupera o grupo/categoria do produto a ser editado
						$grupos = mysql_query("SELECT * FROM grupos order by GRUPO");// aqui pega todos os grupos pra pode alterar
						$unidade = $query['UNIDADE']; // aqui recupera o codigo da unidade atual desse produto
						$recupera3 = mysql_query("SELECT * FROM unidades order by UNIDADE");//aqui recupera todas as un. pra poder alterar
						$unatual = mysql_query("SELECT * FROM unidades WHERE CODUNI = '$unidade'"); //aqui é a sql pra rec. o nome da unidade do produto
						$query4 = mysql_fetch_array($unatual); //aqui pega o nome da unidade do produto
						$codprod = $query['CODPROD'];
						$estoque = mysql_query("SELECT Sum(itensent.QUANT) as quantent FROM itensent WHERE itensent.PRODUTO = $codprod");
						$achaestoque = mysql_fetch_array($estoque);
						$saiestoque = mysql_query("SELECT Sum(sitens.QUANT) as quantsai FROM sitens WHERE sitens.PRODUTO = $codprod");
						$achasaiestoque = mysql_fetch_array($saiestoque);
						$ajustes = mysql_query("SELECT Sum(ajuste.qtde_saida) as quantsai, Sum(ajuste.qtde_entrada) as quantent FROM ajuste WHERE ajuste.PRODUTO = $codprod");	
						$achaajuste = mysql_fetch_array($ajustes);						
						$estocado = ($achaestoque['quantent'] - $achasaiestoque['quantsai']) + ($achaajuste['quantent'] - $achaajuste['quantsai']);
				?> 
					
				<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" >
					<fieldset>
						<legend class="titulo">Editar Produto</legend>
						<label>Nome</label>						
						<input type="text" name="produto" value="<?php echo $query['PRODUTO']; ?>" /><br />
						<label>Grupo</label>						
						<select name="grupo">
							<option value="<?php echo $query2['CODGRUP']; ?>"><?php echo $query2['GRUPO']; ?></option>
							<?php
								while ($res_grupos= mysql_fetch_array($grupos))
								{
									if($res_grupos['GRUPO'] == $query2['GRUPO'])
										echo " ";
									else
									{
								?>
									<option value="<?php echo $res_grupos['CODGRUP']; ?>"><?php echo $res_grupos['GRUPO']; ?></option>";								
							<?php
									}
								}
							?>				
						</select><br />
						<label>R$</label>						
						<input type="text" name="custo" value="<?php echo $valornf = number_format($query['CUSTO'], 2, ',', '.'); ?>" /><br />
						<label>Custo M&eacute;dio</label>						
						<input type="text" name="customedio" value="<?php echo $valornf = number_format($query['CUSTOMED'], 2, ',', '.'); ?>" readonly /> *<br />
						<label>Unidade</label>						
						<select name="unidade">
							<option value="<?php echo $query4['CODUNI']; ?>"><?php echo $query4['UNIDADE']; ?></option>
							<?php
								while ( $query3 = mysql_fetch_array($recupera3))
								{
									if ($query3['CODUNI'] == $query4['CODUNI'])
										echo " ";
									else
									{
							?>
									<option value="<?php echo $query3['CODUNI']; ?>"><?php echo $query3['UNIDADE']; ?></option>";								
							<?php
									}
								}
							?>				
						</select><br />
						<label>Total no Estoque</label>
						<input type="text" readonly value="<?php echo $estocado; ?>" />
						<input class="botao" type="submit" name="alterar" value="Editar" />
						<a class="botao" href="produtos.php">Voltar</a>	
					</fieldset>
				</form>
				* C&aacute;lculo autom&aacute;tico baseado nos &uacute;ltimos pre&ccedil;os.
				<?php 
					}//fim da ediçao de produtos
					else //aqui começa a ediçao de outras tabelas.
						if ($tabela == fornec) //aqui a ediçao de fornecedor
						{
							if($_POST)
							{
								$nome = $_POST['nome'];
								$contato = $_POST['contato'];
								$cgc = $_POST['cgc'];
								$ie = $_POST['ie'];
								$rua = $_POST['rua'];
								$bairro = $_POST['bairro'];
								$cidade = $_POST['cidade'];
								$uf = $_POST['uf'];
								$cep = $_POST['cep'];
								$fonenovo = $_POST['fonenovo'];
								$fone2 = $_POST['fone2'];
								$fone3 = $_POST['fone3'];
								$fax = $_POST['fax'];
								$altera = mysql_query("UPDATE fornec SET NOME = '$nome', CONTATO = '$contato', CGC = '$cgc', IE='$ie', RUA = '$rua', BAIRRO = '$bairro', CIDADE = '$cidade', UF = '$uf', CEP = '$cep', FONENOVO = '$fonenovo', FONE_2 = '$fone2', FONE_3 = '$fone3', FAX = '$fax' WHERE CODIGO = $edita")
								or die("ERRO");
								echo "Alterado com sucesso.";
							}
							$fornec = mysql_query("SELECT * FROM fornec WHERE CODIGO = $edita");
							$result = mysql_fetch_array($fornec);
				?>
							<form action="#" method="post">
								<fieldset>
									<legend class="titulo">Editar Fornecedor </legend>
									<label>Raz&atilde;o Social</label>
									<input type="text" name="nome" value="<?php echo $result['NOME']; ?>" /><br />
									<label>Contato</label>
									<input type="text" name="contato" value="<?php echo $result['CONTATO']; ?>" /><br />
									<label>CNPJ</label>
									<input type="text" name="cgc" value="<?php echo $result['CGC']; ?>" /><br />
									<label>IE</label>
									<input type="text" name="ie" value="<?php echo $result['IE']; ?>" /><br />
									<label>Rua</label>
									<input type="text" name="rua" value="<?php echo $result['RUA']; ?>" /><br />
									<label>Bairro</label>
									<input type="text" name="bairro" value="<?php echo $result['BAIRRO']; ?>" /><br />
									<label>Cidade</label>
									<input type="text" name="cidade" value="<?php echo $result['CIDADE']; ?>" /><br />
									<label>Estado</label>
									<input type="text" name="uf" value="<?php echo $result['UF']; ?>" maxlength="2"/><br />
									<label>CEP</label>
									<input type="text" name="cep" value="<?php echo $result['CEP']; ?>"/><br />
									<label>Fone</label>
									<input type="text" name="fonenovo" value="<?php echo $result['FONENOVO']; ?>" /><br />
									<label>Fone 2</label>
									<input type="text" name="fone2" value="<?php echo $result['FONE_2']; ?>" /><br />
									<label>Fone 3</label>
									<input type="text" name="fone3" value="<?php echo $result['FONE_3']; ?>" /><br />
									<label>FAX</label>
									<input type="text" name="fax" value="<?php echo $result['FAX']; ?>" /><br />
									<input class="botao" type="submit" name="alterar" value="Editar"/>
				<?php
						}//fim da ediçao de fornecedor
					else
						if ($tabela == grupos) //aqui a ediçao de grupos
						{
							if($_POST)
							{
								$grupo = $_POST['grupo'];
								$query = mysql_query("UPDATE grupos SET GRUPO = '$grupo' WHERE CODGRUP = $edita");
								echo "Alterado com sucesso.";
							}
							$grupo = mysql_query("SELECT * FROM grupos WHERE CODGRUP = $edita");
							$result = mysql_fetch_array($grupo);
				?>
							<form action="#" method="post">
								<fieldset>
									<legend class="titulo">Editar Grupo</legend>
									<label>Nome</label>
									<input type="text" name="grupo" value="<?php echo $result['GRUPO']; ?>" /><br />
									<input class="botao" type="submit" name="alterar" value="Editar"/>
								</fieldset>
							</form>
				<?php
						}//fim da ediçao de grupos
					else
						if ($tabela == destinos) //aqui a ediçao de destino
						{
							if($_POST)
							{
								$descricao = $_POST['descricao'];
								$query = mysql_query("UPDATE destinos SET DESCRICAO = '$descricao' WHERE CODDEST = $edita")or die("Erro");
								echo "Alterado com sucesso para $descricao";
							}
							$destino = mysql_query("SELECT * FROM destinos WHERE CODDEST = $edita");
							$result = mysql_fetch_array($destino);
				?>
							<form action="#" method="post">
								<fieldset>
									<legend class="titulo">Editar Destino</legend>
									<label>Descri&ccedil;&atilde;o</label>
									<input type="text" name="descricao" value="<?php echo $result['DESCRICAO']; ?>" /><br />
									<input class="botao" type="submit" name="alterar" value="Editar"/>
								</fieldset>
							</form>
				<?php 
						}//fim da ediçao de destinos
						if($tabela == unidades)
						{
							echo "Em constru&ccedil;&atilde;o";
						}
				?>
				
			</div> 
			<?php include('includes/fimerodape.php'); ?>
</body>
</html>