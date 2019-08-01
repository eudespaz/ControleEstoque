// Valida campos de acordo com tipo e tamanho
function ValidarCampo(id,tipo,min,max){
        var resultado = '';
        var valor = $('#'+id).val();
        if(valor.length<=max && valor.length>=min){
                switch(tipo){
                        case 'nome':
                                var i = 0;
                                var formato = /^[A-Za-z\sáàãâäéèêëíìîïóòõôöúùûüç]+$/;
                                valida = valor.match(formato);
                                if(valida){
                                        valor = valor.replace(/\s{2,}/g,' ');
                                        valor = valor.replace(/^\s+/g,'');
                                        valor = valor.replace(/\s+$/g,'');
                                        valor = valor.toLowerCase();
                                        if(valor.match(/\s/)){
                                                valor = valor.split(' ');
                                                for(i=0;i<=valor.length-1;i++){
                                                        if(!(valor[i].match(/^DA|da|DE|de$/))){
                                                                valor[i] = valor[i].replace(valor[i][0],valor[i][0].toUpperCase());
                                                        }
                                                        i==0 ? resultado = valor[i] : resultado = resultado+' '+valor[i];
                                                }
                                        }else{
                                                valor = valor.replace(valor[0],valor[0].toUpperCase());
                                                resultado = valor;                                              
                                        }
                                }       
                        break;
                        
                        case 'email':
                                var formato = /^[A-Za-z0-9_\-\.][A-Za-z0-9_\-]+@[A-Za-z0-9]+[A-Za-z0-9\-\.]\.[A-Za-z]{2,4}(\.[A-Za-z]{2})?$/;
                                valida = valor.match(formato);
                                if(valida){ resultado = valor.toLowerCase(); }
                        break;
                        
                        case 'senha':
                        case 'usuario':
                                var formato = /^[A-Za-z0-9]+$/;
                                valida = valor.match(formato);
                                if(valida){ resultado = valor; }
                        break;
                }
        }
        return resultado;
} 

/*	Contador Regressivo  */
function contador(segundos,pagina){
	contador1 = setTimeout('redireciona(\''+pagina+'\')', segundos*1000);
	atualiza(segundos);
}
function atualiza(segundos){
	if(segundos>0){
		$('#tempo').html(segundos);
		segundos = segundos-1;
		contador2 = setTimeout('atualiza(\''+segundos+'\')', 1000);
	}
}
function redireciona(pagina){
	window.location = pagina;
}

/*	Esconde todas as DIVs  */
function hideall(){
	$('#txtload').hide();
	$('#txt0').hide();
	$('#txt1').hide();
	$('#txt2').hide();
	$('#txt3').hide();
	$('#txt4').hide();
}

/*	GIF de Carregamento  */
$(document).ready(function(){
	hideall();
	$('#txt2').ajaxStart(function(){
		hideall();
		$('#txtload').show();
		$('#txt').hide();
		$('#form').hide();
	});
	$('#txt2').ajaxStop(function(){
		hideall();
	});
});