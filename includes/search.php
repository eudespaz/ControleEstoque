			<div id="search"><!-- Campo de pesquisa -->
					<form action="#" method="post">
						<fieldset>
							<input type="text" class="input" name="pesquisa" value="Procurar..." onfocus="this.value='';"/>
							<input type="submit" name="search" id="search" class="submit" value="  "/>
						</fieldset>					
					</form>
				</div>
				
				<?php
					if ($_POST['pesquisa']) //recupera a pesquisa digitada
					{
						$pesquisa = $_POST['pesquisa'];
						//mostrar resultados
						echo "Consulta por <b><i>".$pesquisa."</b></i>";
						if($tabela == 'produtos')
							$consulta = mysql_query ("SELECT $res_nome, $res_codigo, GRUPO FROM $tabela WHERE $res_nome LIKE '%$pesquisa%' ");
						else						
							$consulta = mysql_query ("SELECT $res_nome, $res_codigo FROM $tabela WHERE $res_nome LIKE '%$pesquisa%' ");
						$rows = mysql_num_rows($consulta);
						if ($rows == 0)
							echo " N&atilde;o obteve nenhum resultado.";
						if($rows == 1) 
								echo " resultou em ".$rows." registro<br /><br />";						
						if($rows > 1)
								echo " encontrou ".$rows." registros<br /><br /> ";
												
						while ($result = mysql_fetch_array($consulta)) //imprime os resultados e o botao editar
						{ 								
								
								echo "<a id='editar' class='nao_imprimir' href=\"frmedicao.php?cod=".$result[$res_codigo]."&cat=".$result['GRUPO']."&tab=".$tabela."&tabcod=".$res_codigo."&nome=".$res_nome." \"> Editar </a>";
								echo "<a id='deletar' class='nao_imprimir' href=\"deleta.php?cod=".$result[$res_codigo]."&cat=".$result['GRUPO']."&tab=".$tabela."&tabcod=".$res_codigo."&nome=".$res_nome." \">Deletar </a>";
								echo "<p class='td'>".$result[$res_nome]."</p>";	
								//echo "<hr />"; //traça uma linha horiz. pra melhor visualizaçao.
						}
						
					} // fim do if da pesquisa digitada
					
					else					
						if ($_POST['filtrar']) // filtra os produtos pela categoria
							{
								$grupo = $_POST['grupo'];
								$filtra = mysql_query ("SELECT produtos.PRODUTO, produtos.CODPROD, produtos.GRUPO FROM produtos WHERE produtos.GRUPO = $grupo order by produtos.PRODUTO") or die ("Erro");	
								$selgrupo = mysql_query ("SELECT GRUPO FROM grupos WHERE CODGRUP = $grupo");
								$achagrupo = mysql_fetch_array($selgrupo);
														
								echo "Filtrando por <b>".$achagrupo['GRUPO']." </b>";
								$rows = mysql_num_rows($filtra);
								if ($rows == 0)
									echo " N&atilde;o obteve nenhum resultado.";
								if($rows == 1) 
									echo " resultou em ".$rows." registro<br />".$result[$res_nome]."<br />";						
								if($rows > 1)
									echo " foram encontrados ".$rows." registros<br /><br /> ";
								while ($query = mysql_fetch_array($filtra))
								{										
										echo "<a id='editar' class='nao_imprimir' href=\"frmedicao.php?cod=".$query['CODPROD']."&cat=".$query['GRUPO']."&tab=".$tabela."&tabcod=".$res_codigo."&nome=".$res_nome."  \">Editar </a>";				
										echo "<a id='deletar' class='nao_imprimir' href=\"deleta.php?cod=".$query['CODPROD']."&cat=".$query['GRUPO']."&tab=".$tabela."&tabcod=".$res_codigo."&nome=".$res_nome." \">Deletar </a>";
										echo "<p class='td'>".$query['CODPROD']." - ".$query['PRODUTO']."</p>";											
										//echo "<hr />";
								}				
							}//fim da filtragem
							
						else
							include ('includes/resultados.php'); // mostra todos os dados 
					
				?>
