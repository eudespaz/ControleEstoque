/* Script de Login AJAX */
$(document).ready(function(){

	/* Muda o titulo da pagina */
	document.title = document.title+' Login';
	
	/* Muda o background do titulo */
	$('#titulo').css({
						'background-image':'url(img/cadeado.gif)',
						'background-position':'0px 5px'
					});
	
	$('#submit').click(function(){
	
		/* Pega as informacoes nos inputs */
		var v_usuario = $('#usuario').val();
		var v_senha = $('#senha').val();
		var v_c1 = $('input#recaptcha_challenge_field').val();
		var v_c2 = $('input#recaptcha_response_field').val();
		var p_index = $('input#p_index').val();
				
		/* Manda para o servidor */
		$.post('func_login.php',{ usuario:v_usuario, senha:v_senha,
		recaptcha_challenge_field: v_c1, recaptcha_response_field: v_c2 },
		
			/* Lê o resultado e escreve na tela */
			function(data){
				if(data=='0'){hideall();$('#txt0').show('slow');$('#form').show();}
				if(data=='1'){hideall();$('#txt1').show('slow');$('#form').show();}
				if(data=='2'){hideall();$('#txt2').show('slow');contador(3,p_index);}
				if(data=='3'){hideall();$('#txt3').show('slow');$('#form').show();}
				if(data=='4'){hideall();$('#txt4').show('slow');$('#form').show();}
			}
			
		);
	});
});
