		<?php if($rows >= 1)
			{							
				echo "
						<table cellspacing='3px'>	
							<tbody>							
						";				
							echo "
									<tr>
										<td class='td' style='font-weight:bold;'>Produto</td>	
										<td class='td' style='font-weight:bold;'>Quantidade</td>
										<td class='td' style='font-weight:bold;'>custo</td>							
									</tr>
						  			";									
						while($query = mysql_fetch_array($sql))
						{							
							echo "
									<tr>
										<td class='td'>".$query['produto']."</td>
										<td class='preco'>".$query['QTDE']."</td>
										<td class='custoun'>".$query['custoun']."</td>
									</tr>
							  		";						
						}	
				echo "
							</tbody>
						</table>
					  ";
			}