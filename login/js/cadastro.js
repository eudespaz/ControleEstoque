/* Script de Login AJAX */
$(document).ready(function(){

	/* Muda o titulo da pagina */
	document.title = document.title+' Cadastro';
	
	/* Muda o background do titulo */
	$('#titulo').css({
						'background-image':'url(img/cadastro.gif)',
						'background-position':'6px 6px'
					});
	
	$('#submit').click(function(){
	
		/* Pega as informacoes nos inputs */
		var v_nome = ValidarCampo('nome','nome',4,32);
		var v_usuario = ValidarCampo('usuario','usuario',4,32);
		var v_senha = ValidarCampo('senha','senha',4,32);
		var v_c1 = $('input#recaptcha_challenge_field').val();
		var v_c2 = $('input#recaptcha_response_field').val();
		
		/* Manda para o servidor */
		$.post('func_cadastro.php',{ nome:v_nome, usuario:v_usuario, senha:v_senha,
		recaptcha_challenge_field: v_c1, recaptcha_response_field: v_c2 },
		
			/* Lê o resultado e escreve na tela */
			function(data){
				if(data=='0'){hideall();$('#txt0').show('slow');$('#form').show();}
				if(data=='1'){hideall();$('#txt1').show('slow');$('#form').show();}
				if(data=='2'){hideall();$('#txt2').show('slow');contador(5,'login.php');}
				if(data=='3'){hideall();$('#txt3').show('slow');$('#form').show();}
				if(data=='4'){hideall();$('#txt4').show('slow');$('#form').show();}
			}
			
		);
	});
});