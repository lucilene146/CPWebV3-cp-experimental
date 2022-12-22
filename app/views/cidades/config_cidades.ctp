<?php

	$campos['Cidade']['nome']['options']['label']['text'] 		= 'Cidade';
	$campos['Estado']['uf']['options']['label']['text'] 		= 'Uf';
	$campos['Estado']['nome']['options']['label']['text'] 		= 'Estado';

	if ($action=='editar' || $action=='imprimir')
	{
		$edicaoCampos = array('Cidade.nome','Cidade.estado_id','#','Cidade.modified','#','Cidade.created');
	}

	if ($action=='novo')
	{
		$edicaoCampos = array('Cidade.nome','Cidade.estado_id');
		$campos['Cidade']['estado_id']['options']['selected'] = 1;
	}

	if ($action=='excluir')
	{
		$edicaoCampos = array('Cidade.nome','Cidade.estado_id','#','Cidade.modified','#','Cidade.created');
	}

	if ($action=='editar' || $action=='novo')
	{
		$campos['Cidade']['estado_id']['options']['label']['style'] 	= 'width: 80px;';
		$campos['Cidade']['nome']['options']['style'] 					= 'width: 400px; ';
		$on_read_view .= "\n".'$("#CidadeNome").focus();';
	}

	if ($action=='editar' || $action=='excluir')
	{
		$campos['Cidade']['created']['options']['disabled'] 			= 'disabled';
		$campos['Cidade']['modified']['options']['disabled'] 			= 'disabled';
	}
	
	if ($action=='editar' || $action=='listar')
	{
		$camposPesquisa['nome'] = 'Nome';
		$this->set('camposPesquisa',$camposPesquisa);

		$relatorios[0]['url'] 	= Router::url('/',true).mb_strtolower($pluralHumanName).'/relatorios/sintetico';
		$relatorios[0]['tit'] 	= 'Sintético por Cidade';
		$relatorios[1]['url'] 	= Router::url('/',true).mb_strtolower($pluralHumanName).'/relatorios/sintetico_estado';
		$relatorios[1]['tit'] 	= 'Sintético por Estado';
	}

	if ($action=='listar')	
	{
		$listaCampos 								= array('Cidade.nome','Estado.nome','Cidade.modified');
		$campos['Cidade']['nome']['estilo_th'] 		= 'width="300px";';
		$campos['Estado']['nome']['estilo_th'] 		= 'width="250px";';
		$campos['Estado']['nome']['estilo_td'] 		= 'style="text-align: left; "';

		// destacando algumas linhas
		foreach($this->data as $_linha => $_modelos)
		{
			foreach($_modelos as $_modelo => $_campos)
			{
				foreach($_campos as $_campo => $_valor)
				{
					$destaque = '';
					// Destacando as cidades de MG
					if ($_modelo=='Estado' && $_campo=='nome' && $_valor=='Minas Gerais') 
						if (!isset($lista['estilo_tr_'.$this->data[$_linha]['Cidade']['id']])) 
							$destaque = 'style="background-color: #f2f378;"';

					// Destacando Belo Horizonte
					if ($_modelo=='Cidade' && $_campo=='nome' && mb_strtolower($_valor)=='belo horizonte')
						$destaque = 'style="background-color: #9fed9f;"';

					if ($destaque) $lista['estilo_tr_'.$this->data[$_linha]['Cidade']['id']] = $destaque;
				}
			}
		}
	}
?>
