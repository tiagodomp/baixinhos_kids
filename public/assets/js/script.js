$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();

    $(".valores").keypress(function(e){
        if(e.key == "."){
            e.preventDefault();
        }
    });

	$(".selProdutoVariacao").change(function() {
		if($(this).val() == 1) {
			$("#produtoVariacao").show();
    		$('html,body').animate({scrollTop: $("#produtoVariacaoAncora").offset().top}, 2000);
    		if(produtoVariacaoSeq == 0){
				$("#addProdutoVariacao").click();
			}
		}else{
			$("#produtoVariacao").hide();
		}
	});

	$(".headVariacao").change(function() {
		var id_coluna = $(this).attr("id");
		if($(this).is(":checked")) {
			$("."+id_coluna).show();
		}else{
			$("."+id_coluna).hide();
		}
	});

	let produtoVariacaoSeq = 0;

	$("#somaProdutoVariacaoSeq").click(function() {
		var auxVarContagem= $("#produtoVariacaoContagem").val();
		auxVarContagem++;
		$("#produtoVariacaoContagem").val(auxVarContagem);
		$("#produtoVariacaoSeq").val(produtoVariacaoSeq);
		produtoVariacaoSeq++;
		$(".headVariacao").each(function() {
			var id_coluna = $(this).attr("id");
			if($(this).is(":checked")) {
				$("."+id_coluna).show();
			}else{
				$("."+id_coluna).hide();
			}
		});
	});

	$("#addProdutoVariacao").click(function() {
		$("#var_tr_null").hide();
		$("#bodyProdutoVariacao").after(
			'<tr id="var_tr_'+produtoVariacaoSeq+'" class="var_tr_'+produtoVariacaoSeq+'">'
				+'<td><a onclick="removerVariacao(\'var_tr_'+produtoVariacaoSeq+'\')" class="cursorPointer" data-position="top" data-tooltip="Remover Item"><i class="ti-trash"></i></a></td>'
				+'<td><a onclick="duplicarVariacao('+produtoVariacaoSeq+')" class="cursorPointer tooltipped" data-position="top" data-tooltip="Duplica esta linha para agilizar o cadastramento"><i class="ti-layers"></i> Duplicar</a></td>'
                //+'<td><a href="#addProdutoFotoVariacao" onclick="exibeImagensProduto('+produtoVariacaoSeq+')" id="var_foto_'+produtoVariacaoSeq+'"><i class="ti-image"></i></a></td>'
                +'<td><button type="button" class="btn btn-default" onclick="exibeImagensProduto('+produtoVariacaoSeq+')" data-toggle="modal" data-target="#addProdutoFotoVariacao" id="var_foto_'+produtoVariacaoSeq+'"><i class="ti-image"></i></button></td>'
                +'<input type="hidden" name="var_cod_linha[]" value="'+produtoVariacaoSeq+'"></td>'
                +'<td><input type="number" class="var_quantidade form-control"	id="var_quantidade_'+produtoVariacaoSeq+'" name="var_quantidade[]"  placeholder="Ex: 10"></td>'
                +'<td><input type="text"   class="var_codigo form-control"		id="var_codigo_'+produtoVariacaoSeq+'" name="var_codigo[]"  placeholder="Ex: 65494984951495"></td>'
                +'<td><input type="text"   class="var_sku form-control"			id="var_sku_'+produtoVariacaoSeq+'" name="var_sku[]"  placeholder="Ex: iPhone 8s Prata"></td>'
				+'<td class="var_tamanho"><div class="row tamanhodiv"><div class="col-7"><input type="text" class="form-control" id="var_tamanho_'+produtoVariacaoSeq+'" name="var_tamanho[]" placeholder="Ex: P, M ou G / 14, 15 ou 16..."></div><div class="col-5"><a class="cursorPointer btnSistema btn btn-default" onclick="novoTamanho(\''+produtoVariacaoSeq+'\')"> Mais tamanhos </a></div></div></td>'
				+'<td class="var_cor"><a class="cursorPointer var_cor_input ti-close black-text" onclick="setCampoCor(\'var_cor_principal_'+produtoVariacaoSeq+'\')" id="var_cor_principal_'+produtoVariacaoSeq+'_a"></a> <input type="hidden" id="var_cor_principal'+produtoVariacaoSeq+'" name="var_cor_principal[]">   <input type="text" id="var_cor_principal_text_'+produtoVariacaoSeq+'" name="var_cor_principal_text" class="form-control" placeholder="Ex: Preto"></td>'
				+'<td class="var_cor"><a class="cursorPointer var_cor_input ti-close" onclick="setCampoCor(\'var_cor_secundaria_'+produtoVariacaoSeq+'\')" id="var_cor_secundaria_'+produtoVariacaoSeq+'_a"></a>          <input type="hidden" id="var_cor_secundaria'+produtoVariacaoSeq+'" name="var_cor_secundaria[]"> <input type="text" id="var_cor_secundaria_text_'+produtoVariacaoSeq+'" name="var_cor_secundaria_text" class="form-control" placeholder="Ex: Azul"></td>'
				+'<td class="var_voltagem"><select class="form-control" id="var_voltagem_'+produtoVariacaoSeq+'" name="var_voltagem[]"><option value="110">110 V</option><option value="220">220 V</option><option value="330">330 V</option></select></td>'
            +'</tr>'
		);
		$(".galeriaProdutoVar").append('<div id="variacaoFotos_'+produtoVariacaoSeq+'" class="escondeImagemProduto"></div>');

		if(produtoVariacaoSeq == 0){
			$("#produtoVariacaoContagem").val(1);
		}else{
			var auxVarContagem= $("#produtoVariacaoContagem").val();
			auxVarContagem++;
			$("#produtoVariacaoContagem").val(auxVarContagem);
		}
		$("#produtoVariacaoSeq").val(produtoVariacaoSeq);
		produtoVariacaoSeq++;

		$(".headVariacao").each(function() {
			var id_coluna = $(this).attr("id");
			if($(this).is(":checked")) {
				$("."+id_coluna).show();
			}else{
				$("."+id_coluna).hide();
			}
		});

	});

	let produtoTamanhoSeq = 0;
	$("#novoTamanhoProdutoPrincipal").click(function() {
		var estoque = $("#estoque").val();
		var cod = $("#cod_eangtinupc").val();
		var sku = $("#sku").val();
		$("#novosTamanhos").append(
			'<div id="novoTamanho_'+produtoTamanhoSeq+'" class="row">'
				+'<div class="col-6 col-md-1">'
                    +'<label>Remover</label><a onclick="removerTamanho(\'novoTamanho_'+produtoTamanhoSeq+'\')" class="cursorPointer"><i class="ti-trash"></i></a>'
                +'</div>'
                +'<div class="col-6 col-md-2">'
                    +'<label  class="active">Quantidade</label>'
                    +'<input type="number" name="var_p_quantidade[]" placeholder="Ex: 10" value="'+estoque+'" class="form-control">'
                +'</div>'
                +'<div class="col-6 col-md-3">'
                    +'<label  class="active">EAN/GTIN/UPC</label>'
                    +'<input type="text" name="var_p_codigo[]" placeholder="Ex: 65494984951495" value="'+cod+'" class="form-control">'
                +'</div>'
                +'<div class="col-6 col-md-3">'
                    +'<label  class="active">SKU</label>'
                    +'<input type="text" name="var_p_sku[]" placeholder="Ex: iPhone 8s Prata" value="'+sku+'" class="form-control">'
                +'</div>'
                +'<div class="col-6 col-md-3">'
                    +'<label  class="active">Tamanho</label>'
                    +'<input type="text" name="var_p_tamanho[]" class="upperCase form-control" placeholder="Ex: P, M ou G / 14, 15 ou 16...">'
                +'</div>'
			+'</div>'
		);
		produtoTamanhoSeq++;
	});

	
	let imagensSeq = 0;
	$('.uploadChange').on('change',function() {
        var id = $(this).attr('id');
        var totalFiles = $(this).get(0).files.length;

        for (var i=0; i < totalFiles; i++) {
            var arquivo = $(this).get(0).files[i];

			if(arquivo.size >= 1048576) { //1MB
				alert('Imagem: '+arquivo.name+' \n Verifique se o tamanho da imagem é menor que 1MB'); //Acima do limite
				upload.value = ""; //Limpa o campo          
			}

	        var reader = new FileReader();
            reader.onload = function(event) {
				//ID QUE RETORNA DA REQUISIÇÃO ASSOCIAR AO LI EM TELA PARA PODER EFETUAR A EXCLUSÃO
                $.ajax({
					type: 'post',
					dataType : 'json',
					url: URL+'/imagem/produto/store',
					async: true,
					headers: {
						'X-CSRF-TOKEN': $('input[name="_token"]').val()
					},
					data: {
						imagem : event.target.result,
						hash_criar_produto: $('#hash_criar_produto').val()
					},
					success: function(data){

						var idDivImagem = "divImagemProduto_"+imagensSeq;
				        $('.galeriaProduto').append(
				        	'<li>'
				    			+'<input type="radio" name="imagemPrincipal" value="'+data['id']+'" id="s_'+data['id']+'">'
                                +'<label for="s_'+data['id']+'">Principal</label>'
				    			+'<div class="box-images" id="'+idDivImagem+'"><img class="imgProduto" src="'+URL+'/'+data['url']+'"></div>'
				    			+'<div class="divRemove"><a href="javascript:removeFile(\''+idDivImagem+'\','+data['id']+',0)" class="remove text-red">Remover</a></div>'
				    			//+'<span>'+arquivo.name+'</span>'
				    		+'</li>'
						);
						imagensSeq++;
		                //$($.parseHTML('<img class="imgProduto">')).attr('src', event.target.result).appendTo('#'+idDivImagem);

					},
				});

            }
            reader.readAsDataURL($(this).get(0).files[i]);
        }
    });


    $('.uploadChangeVar').on('change',function() {
        var id = $(this).attr('id');
        var totalFiles = $(this).get(0).files.length;

        for (var i=0; i < totalFiles; i++) {
            var arquivo = $(this).get(0).files[i];

			if(arquivo.size >= 1048576) { //1MB
				alert('Imagem: '+arquivo.name+' \n Verifique se o tamanho da imagem é menor que 1MB'); //Acima do limite
				upload.value = ""; //Limpa o campo          
			}

	        var reader = new FileReader();
            reader.onload = function(event) {
				var idLinhaVariacao = $("#produtoVariacaoMod").val();
				console.log(idLinhaVariacao);
                $.ajax({
					type: 'post',
					dataType : 'json',
					url: URL+'/imagem/produto/store',
					async: true,
					headers: {
						'X-CSRF-TOKEN': $('input[name="_token"]').val()
					},
					data: {
						imagem : event.target.result,
						hash_criar_produto: $('#hash_criar_produto').val(),
						linha:idLinhaVariacao,
					},
					success: function(data){

						//apenas a primeira imagem
			            if($("#variacaoFotos_"+idLinhaVariacao+" li").length == 0){
			            	$("#var_foto_"+idLinhaVariacao).html('<img class="imgProdutoPequeno" src="'+URL+'/'+data['url']+'">');
			            }

						var idDivImagem = "divImagemProduto_"+imagensSeq;
				        $('#variacaoFotos_'+idLinhaVariacao).append(
				        	'<li>'
				    			+'<input type="radio" name="imagemPrincipalVar_'+idLinhaVariacao.replace("s_", "")+'" value="'+data['id']+'" id="s_'+data['id']+'" class="imagemPrincipalVar" onclick="mudaImagemPequena('+idLinhaVariacao+',\''+URL+'/'+data['url']+'\')">'
	                            +'<label for="s_'+data['id']+'">Principal</label>'
				    			+'<div class="box-images" id="'+idDivImagem+'"><img class="imgProduto" src="'+URL+'/'+data['url']+'"></div>'
				    			+'<div class="divRemove"><a href="javascript:removeFile(\''+idDivImagem+'\','+data['id']+',0,\''+idLinhaVariacao+'\')" class="remove text-red">Remover</a></div>'
				    			//+'<span>'+arquivo.name+'</span>'
				    		+'</li>'
						);
						imagensSeq++;
		                //$($.parseHTML('<img class="imgProduto">')).attr('src', event.target.result).appendTo('#'+idDivImagem);
					},
				});

            }
            reader.readAsDataURL($(this).get(0).files[i]);
        }
    });


    $("#formProduto").submit(function(e){
    	$(".imagemPrincipalVar").each(function(){
    		if($(this).is(":checked")){
    			var id = $(this).val();
    			$("#formProduto").append('<input type="hidden" name="imagemPrincipal[]" value="'+id+'">');
    		}
    	});
    	//e.preventDefault();
    });

});