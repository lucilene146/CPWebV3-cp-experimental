<?php
/**
 * CPWeb - Controle Virtual de Processos
 * Versão 3.0 - Novembro de 2010
 *
 * app/controllers/components/cpweb_crud.php
 *
 * A reprodução de qualquer parte desse arquivo sem a prévia autorização
 * do detentor dos direitos autorais constitui crime de acordo com
 * a legislação brasileira.
 *
 * This product is protected by copyright and distributed under licenses restricting
 * copying, distribution, and non-allowed selling/trading
 *
 * @copyright   Copyright 2010, Valéria Esteves Advogados Associados ( www.veadvogados.com.br )
 * @copyright   Copyright 2010, Gustavo Dias Duarte Ramos ( gustavo at gustavo-ramos dot com )
 * @link http://cpweb.veadvogados.adv.br
 * @package cpweb
 * @subpackage cpweb.v3
 * @since CPWeb V3
 */
class CpwebCrudComponent extends Object {
	 /**
	 * método start
	 * @return void
	 */
	function startup(&$controller) 
	{
		$this->controller 	=& $controller;
		$title_for_layout 	= __(SISTEMA.' :: ', true).Inflector::humanize($this->controller->viewPath).' :: '.Inflector::humanize($this->controller->action);
		$modelClass 		= $this->controller->modelClass;
		$primaryKey 		= isset($this->controller->$modelClass->primaryKey)   ? $this->controller->$modelClass->primaryKey : 'id';
		$displayField 		= isset($this->controller->$modelClass->displayField) ? $this->controller->$modelClass->displayField : 'id';
		$tamLista			= isset($this->controller->viewVars['tamLista']) ? $this->controller->viewVars['tamLista'] : '90%';
		$arqListaMenu		= isset($this->controller->viewVars['arqListaMenu']) ? $this->controller->viewVars['arqListaMenu'] : 'menu_administracao';
		$singularVar 		= Inflector::variable($modelClass);
		$pluralVar 			= Inflector::variable($this->controller->name);
		$singularHumanName 	= Inflector::humanize(Inflector::underscore($modelClass));
		$pluralHumanName 	= Inflector::humanize(Inflector::underscore($this->controller->name));
		$action				= $this->controller->action;
		$id					= isset($this->controller->params['pass'][0]) ? $this->controller->params['pass'][0] : '';
		$on_read_view		= '';
		$campos 			= isset($this->controller->viewVars['campos']) ? $this->controller->viewVars['campos'] : array();
		$name				= mb_strtolower(str_replace(' ','_',$pluralHumanName));
		$urlsNao			= $this->controller->Session->check('urlsNao') ? $this->controller->Session->read('urlsNao') : array();

		// configurando o título da tela
		$id_titulo			= $id ? '/'.$id : '';
		$tituloCab[1]['label']	= isset($this->controller->viewVars['tituloCab'][1]['label']) 	? $this->controller->viewVars['tituloCab'][1]['label'] : $pluralHumanName;
		$tituloCab[1]['link']	= isset($this->controller->viewVars['tituloCab'][1]['link'])	? $this->controller->viewVars['tituloCab'][1]['link']	: Router::url('/',true).mb_strtolower(str_replace(' ','_',$pluralHumanName));
		$tituloCab[2]['label']	= isset($this->controller->viewVars['tituloCab'][2]['label']) 	? $this->controller->viewVars['tituloCab'][2]['label'] : ucfirst(strtolower($action));
		$tituloCab[2]['link']	= isset($this->controller->viewVars['tituloCab'][2]['link'])	? $this->controller->viewVars['tituloCab'][2]['link']	: Router::url('/',true).mb_strtolower(str_replace(' ','_',$pluralHumanName)).'/'.strtolower($action).$id_titulo;
		$tituloCab[3]['label']	= '';
		$tituloCab[3]['link']	= '';

		$this->name			= $name;
		$this->action		= $action;
		$this->urlsNao		= $urlsNao;

		if ($arqListaMenu=='menu_administracao')	$this->controller->Session->write('admin_ativo',$name);
		if ($arqListaMenu=='menu_modulos')			$this->controller->Session->write('modul_ativo',$name);
		if ($arqListaMenu=='menu_sistema')			$this->controller->Session->write('siste_ativo',$name);

		$campos[$modelClass]['nome']['estilo_th'] 						= 'width="450px"';

		$campos[$modelClass]['modified']['options']['label']['text'] 	= 'Modificado';
		$campos[$modelClass]['modified']['options']['dateFormat'] 		= 'DMY';
		$campos[$modelClass]['modified']['options']['timeFormat'] 		= '24';
		$campos[$modelClass]['modified']['mascara'] 					= 'datahora';
		$campos[$modelClass]['modified']['estilo_th'] 					= 'width="180px"';
		$campos[$modelClass]['modified']['estilo_td'] 					= 'style="text-align: center; "';
		$campos[$modelClass]['modified']['options']['disabled'] 		= 'disabled';

		$campos[$modelClass]['created']['options']['label']['text'] 	= 'Criado';
		$campos[$modelClass]['created']['options']['dateFormat'] 		= 'DMY';
		$campos[$modelClass]['created']['options']['timeFormat'] 		= '24';
		$campos[$modelClass]['created']['mascara'] 						= 'datahora';
		$campos[$modelClass]['created']['estilo_th'] 					= 'width="160px"';
		$campos[$modelClass]['created']['estilo_td'] 					= 'style="text-align: center; "';
		$campos[$modelClass]['created']['options']['disabled'] 			= 'disabled';

		$this->controller->set(compact('tituloCab','urlsNao','name','arqListaMenu','action','id','on_read_view','title_for_layout', 'modelClass', 'primaryKey', 'displayField', 'singularVar', 'pluralVar','singularHumanName', 'pluralHumanName','tamLista','campos'));

		$this->setUrlPermissao($name.'/'.$action);
	}

	/**
	 * Executa o método de paginação
	 * 
	 * @parameter integer $pag Número da página a exibir
	 * @return void
	 */
	 public function listar($pag=1, $assModel, $assId)
	 {
        if( isset( $assModel ) && isset( $assId ) )
        {
            $assModel = $this->controller->params['pass'][0];
            $assId = $this->controller->params['pass'][1];
            $this->controller->data = $this->controller->paginate( array( $assModel.'_id' => $assId ) );
            $this->setParametrosLista();
		    $this->setBotoesLista();
		    $this->setFerramentasLista();
        }
        else
        {
            $this->controller->data = $this->controller->paginate();
            $this->setParametrosLista();
            $this->setBotoesLista();
            $this->setFerramentasLista();
        }
     }

     public function filtrar()
     {
         if( isset( $this->controller->params['named'] ) && !empty( $this->controller->params['named'] ) )
         {
            foreach( $this->controller->params['named'] as $_campo => $_valor )
            {
				if (!in_array($_campo,array( 'page', 'direction', 'sort'))) $findConditions[$this->controller->modelClass.'.'.$_campo] = $_valor;
			}
         }
         else
         {
             $this->controller->Session->setFlash('<span style="font-size: 20px;">Erro! Não foram passados parâmetros para o filtro!</span>');
             $this->controller->redirect( $this->controller->referer() );
         }

         $this->controller->data = $this->controller->paginate( $findConditions );
         $this->setParametrosLista();
         $this->setBotoesLista();
         $this->setFerramentasLista();
     }

	 /**
	  * Executa a edição do registro
	  * 
	  * @return void
	  */
	  public function editar($id=null)
	  {
		// parâmetros
		$modelClass 	= $this->controller->modelClass;
		$camposSalvar	= isset($this->controller->camposSalvar) ? $this->controller->camposSalvar : null;

		// salvando os dados do formulário
		if (!empty($this->controller->data))
		{
			$salvarCampos 	= array();
			$opcoes			= array();
			foreach($this->controller->data as $_modelo => $_arrCampos) foreach($_arrCampos as $_campo => $_valor) array_unshift($salvarCampos,$_campo);
			if (count($salvarCampos)) $opcoes['fieldList'] = $salvarCampos;

			if ($this->controller->$modelClass->save($this->controller->data,$opcoes))
			{
				$this->controller->Session->setFlash('<span style="font-size: 20px;">Registro atualizado com sucesso !!!</span>');
				$this->controller->data = $this->controller->$modelClass->read(null,$id);
			} else
			{
				$this->controller->Session->setFlash('O Formulário ainda contém erros !!!');
				$this->controller->viewVars['on_read_view'] = '$("#flashMessage").css("color","red")'."\n";
				$this->controller->set('errosForm',array_reverse($this->controller->$modelClass->validationErrors));
				unset($this->controller->$modelClass->validationErrors);
			}
		} else
		{
			$this->controller->data = $this->controller->$modelClass->read(null,$id);
			$msgFlash = ($this->controller->Session->check('Message.flash.message')) ? $this->controller->Session->read('Message.flash.message') : 'Editando '.$this->controller->data[$modelClass][$this->controller->$modelClass->displayField];
			$this->controller->Session->setFlash($msgFlash);
		}

		// configurando os botões da edição, configurando os relacionamentos, atualizando a msg e renderizando a página
		$this->setBotoesEdicao();
		$this->setRelacionamentos();
	  }

	 /**
	  * Exibe o formulário de inclusão do model
	  * 
	  * @retur void
	  */
	 public function novo()
	 {
		 // parâmetros
		$modelClass 	= $this->controller->modelClass;
		$primaryKey 	= isset($this->$modelClass->primaryKey) ? $this->$modelClass->primaryKey : 'id';
		$camposSalvar	= isset($this->controller->camposSalvar) ? $this->controller->camposSalvar : null;

		// inclui o novo registro e redireciona para sua tela de edição
		// só salva os campos que foram postados
		if (!empty($this->controller->data))
		{
			$salvarCampos 	= array();
			$opcoes			= array();
			foreach($this->controller->data as $_modelo => $_arrCampos) foreach($_arrCampos as $_campo => $_valor) array_unshift($salvarCampos,$_campo);
			if (count($salvarCampos)) $opcoes['fieldList'] = $salvarCampos;

			$this->controller->$modelClass->create();
			if ($this->controller->$modelClass->save($this->controller->data,$opcoes))
			{
				$this->controller->Session->setFlash('<span style="font-size: 20px;">Registro incluído com sucesso !!!</span>');
				$this->controller->viewVars['on_read_view'] .= '$("#flashMessage").css("color","green")'."\n";
				if (!isset($this->controller->NaoRedirecionarNovo)) $this->controller->redirect(Router::url('/',true).$this->name.'/editar/'.$this->controller->$modelClass->$primaryKey);
			} else
			{
				$this->controller->Session->setFlash('O Formulário ainda contém erros !!!');
				$this->controller->viewVars['on_read_view'] .= '$("#flashMessage").css("color","red")'."\n";
				$this->controller->set('errosForm',array_reverse($this->controller->$modelClass->validationErrors));
				unset($this->controller->$modelClass->validationErrors);
			}
		}

		// verifica  a permissão de url
		$this->setUrlPermissao();

		// configura os botões do formulário, os relacionamentos e renderiza.
		$this->setBotoesEdicao();
		$this->setRelacionamentos();
	 }

	/**
	 * Deleta um registro do banco de dados. Em caso de sucesso retorna para a lista.
	 * 
	 * @parameter integer $id Id do registro a ser excluído
	 * @return void
	 */
	public function delete($id=null)
	{
		// recuperando parãmetros
		$modelClass	= $this->controller->viewVars['modelClass'];
		$primaryKey	= isset($this->$modelClass->primaryKey)   ? $this->$modelClass->primaryKey : 'id';

		// excluíndo o registro
		if ($this->controller->$modelClass->delete($id)) 
		{
			$this->controller->Session->setFlash('Registro excluído com sucesso !!!');
			$this->controller->redirect(Router::url('/',true).$this->name.'/listar'.$this->getParametrosLista());
		} else
		{
			$this->controller->Session->setFlash('Não foi possível deletar o id '.$id);
		}
	}

	/**
	 * Exibe o formulário de exclusão de um registro.
	 * 
	 * @parameter integer $id Id do registro a ser excluído
	 * @return void
	 */
	public function excluir($id=null)
	{
		$this->editar($id);
		$modelClass 											= $this->controller->modelClass;
		$this->controller->viewVars['botoesEdicao']['Excluir']	= array();
		$this->controller->viewVars['botoesEdicao']['Atualizar']= array();
		$this->controller->viewVars['botoesEdicao']['Salvar'] 	= array();
		$this->controller->viewVars['botoesEdicao']['Listar'] 	= array();
		$this->controller->viewVars['msgEdicao'] = 'Você tem certeza de Excluir <strong>'.$this->controller->data[$modelClass][$this->controller->$modelClass->displayField].'</strong> ? <a href="'.Router::url('/',true).$this->name.'/delete/'.$id.'" class="linkEdicaoExcluir">Sim</a>&nbsp;&nbsp;<a href="javascript:history.back(-1)" class="linkEdicaoExcluir">Não</a>';
		$this->controller->Session->setFlash('Excluindo '.$this->controller->data[$modelClass][$this->controller->$modelClass->displayField]);
		$this->controller->render('../cpweb_crud/editar');
	}

	/**
	 * Redireciona para a tela de avisão se permissão.
	 * 
	 * @return void
	 */
	public function semPermissao()
	{
		$this->controller->render('../cpweb_crud/sem_permissao');
	}

	/**
	 * Imprimi o registro de cadastro
	 * 
	 * @acccess public
	 * @return void
	 */
	public function imprimir($id=null)
	{
       $modelClass 	= $this->controller->modelClass;
       $data = $this->controller->$modelClass->read(null,$id);
       $this->setRelacionamentos();
       $relatorio 	= file_exists('../views/'.$this->name.'/rel_registro.ctp') ? '../'.$this->name.'/rel_registro' : '../cpweb_crud/rel_registro';
       $nomeArquivo = ucwords(mb_strtolower($data[$modelClass][$this->controller->$modelClass->displayField]));
       $nomeArquivo = str_replace(' ','',$nomeArquivo);
       $this->controller->set(compact('data','nomeArquivo'));
       $this->controller->render($relatorio);
	}

	/**
	 * Imprime o relatório
	 * 
	 * @parameter	string	$rel	Nome do relatório
	 * @parameter	array	$data	Dados as serem impressos
	 * @access public
	 * @return void
	 */
	public function relatorios($rel=null,$data=array())
	{
		$relatorio 		= file_exists('../views/'.$this->name.'/rel_'.$rel.'.ctp') ? '../'.$this->name.'/rel_'.$rel : '../cpweb_crud/rel_'.$rel;
		$nomeArquivo 	= str_replace(' ','',$this->controller->name);
		$this->controller->set(compact('data','nomeArquivo'));
		$this->controller->render($relatorio);
	}

	/**
	 * Exibe a tela de filtro, caso o formulário filtro seja enviado é redirecinado para o relatório em questão que está no cpwebcrud ou no próprio cadastro
	 * 
	 * @parameter	string	$fil	nome do filtro, pode ser genérico do cpwebCrud ou da próprio cadastro
	 * @parameter	string	$rel	nome do relatório 
	 * @return void
	 */
	public function filtro($fil=null,$rel=null)
	{
		if (!empty($this->controller->data))
		{
			$data = $this->controller->data;
			$this->relatorios($rel,$data);
		} else
		{
			$filtro	= file_exists('../views/'.$this->name.'/fil_'.$fil.'.ctp') ? '../'.$this->name.'/fil_'.$fil : '../cpweb_crud/fil_'.$fil;
			$this->controller->set('relatorio',$rel);
			$this->controller->render($filtro);
		}
	}

	/**
	 * Retorna a url de complementação da lista, informando página, ordem e ordenação
	 * 
	 * @return string $url
	 */
	public function getParametrosLista()
	{
		$url	= '';
		$page	= ($this->controller->Session->check($this->controller->name.'.Page')) ? $this->controller->Session->read($this->controller->name.'.Page') : '';
		$sort	= ($this->controller->Session->check($this->controller->name.'.Sort')) ? $this->controller->Session->read($this->controller->name.'.Sort') : '';
		$dire	= ($this->controller->Session->check($this->controller->name.'.Dire')) ? $this->controller->Session->read($this->controller->name.'.Dire') : '';

		if ($page) $url	.= '/page:'.$page;
		if ($sort) $url	.= '/sort:'.$sort;
		if ($dire) $url	.= '/direction:'.$dire;

		return $url;
	}

	/**
	 * Configura os relacionamentos do model corrente, joga na view a lista 
	 * 
	 * @return void
	 */
	private function setRelacionamentos()
	{
		$modelClass 	= $this->controller->modelClass;
		if (method_exists($this->controller,'beforeRelacionamentos'))
		{
			$this->controller->beforeRelacionamentos();
		}
		foreach($this->controller->$modelClass->__associations as $associacao)
		{
			if (count($this->controller->$modelClass->$associacao))
			{
				foreach($this->controller->$modelClass->$associacao as $assoc => $arr_opcoes)
				{
					$parametros = array();
					if (isset($arr_opcoes['fields'])) 		$parametros['fields'] 		= $arr_opcoes['fields'];
					if (isset($arr_opcoes['conditions']))	$parametros['conditions'] 	= $arr_opcoes['conditions'];
					$this->controller->viewVars[Inflector::pluralize(strtolower($assoc))] = $this->controller->$modelClass->$assoc->find('list',$parametros);
				}
			}
		}
	}

	/**
	 * Atualiza o subformulário
	 * obs: 
	 * A tabela de subFormalário deve ser hasMany. 
	 * os ids do modelo que não foram enviados serão deletados.
	 * campos sem id serão incluídos
	 * 
	 * @parameter 	string 	$nomeCampoPai	Nome do campo pai
	 * @parameter	string	$valorCampoPai	Valor do camo pai
	 * @parameter 	string 	$modelo	Nome do modelo que será atualizado
	 * @return		boolean
	 */
	//public function setSubForm($modeloPai,$idPai,$modelo,$salvarModeloPai=false)
	public function setSubForm($modeloPai,$idPai,$modelo,$salvarModeloPai=array())
	{
		$dataModelo		= array();
		$arrIdSalvos	= array();
		$delCondicao	= array();
		//if (isset($this->controller->data['subForm'])) pr($this->controller->data['subForm']);
		// salvando os ids que serão atualizados, e portanto  não deleteados
		if (isset($this->controller->data['subForm']))
		{
			foreach($this->controller->data['subForm'] as $_id => $_arrCampos)
			{
				if(!in_array($_id,$arrIdSalvos)) array_unshift($arrIdSalvos,$_id);
				foreach($_arrCampos as $_campo => $_valor)
				{
					$dataModelo[$modelo][$_id][$this->controller->$modelo->primaryKey] = $_id;
					$dataModelo[$modelo][$_id][$_campo] = $_valor;
				}
			}
		}

		// só deleta quem não foi salvo
		$delCondicao['NOT'][$modelo.'.'.$this->controller->$modelo->primaryKey] = $arrIdSalvos;

		// incluindo mais campos para condição de exclusão
		if (count($salvarModeloPai))
		{
			$l = 0;
			foreach($salvarModeloPai as $_campo)
			{
				if (!$l) $delCondicao['AND'][$modelo.'.'.$_campo] = $idPai; else $delCondicao['AND'][$modelo.'.'.$_campo] = $modeloPai;
				$l++;
			}
		}
		//pr($delCondicao);
		if (!$this->controller->$modelo->deleteAll($delCondicao))
		{
			exit('Não foi possível deletar '.$modelo.' ...');
			return false;
		}

		// atualizando o modelo filho
		if (count($dataModelo))
		{
			$this->controller->$modelo->recursive = 2;
			if (!$this->controller->$modelo->saveAll($dataModelo[$modelo]))
			{
				echo $modelo.'<br />';
				echo '<pre>'.print_r($dataModelo,true).'</pre>';
				echo '<pre>'.print_r($this->controller->$modelo->validationErrors,true).'</pre>';
				exit('Não foi possível ATUALIZAR '.$modelo.' ...');
				return false;
			}
		}

		// incluindo o modelo filho
		$dataModelo	= array();
		foreach($this->controller->data['subNovoForm'] as $_campo => $_valor)
		{
			if ($_valor) $dataModelo[$modelo][$_campo] = $_valor;
		}
		if (count($dataModelo))
		{
			$dataModelo[$modelo][$this->controller->$modelo->primaryKey] = null;
			if ($salvarModeloPai)
			{
				$dataModelo[$modelo]['modelo']		= $modeloPai;
				$dataModelo[$modelo]['modelo_id']	= $idPai;
			}
			$this->controller->$modelo->create();
			if (!$this->controller->$modelo->save($dataModelo[$modelo]))
			{
				echo '<pre>'.print_r($this->controller->$modelo->validationErrors,true).'</pre>';
				exit('Não foi possível INCLUIR '.$modelo.', no subFormulário !!!');
				return false;
			}
		}
		return true;
	}

	/**
	 * Configura os botões para a edição
	 * 
	 * @return void
	 */
	private function setBotoesEdicao()
	{
		// parâmetros
		$pluralVar 		= Inflector::variable($this->controller->name);
		$modelClass 	= $this->controller->modelClass;
		$primaryKey 	= isset($this->$modelClass->primaryKey)   ? $this->$modelClass->primaryKey : 'id';
		$id 			= isset($this->controller->data[$modelClass][$primaryKey]) ? $this->controller->data[$modelClass][$primaryKey] : 0;
		$urlLista		= $this->getParametrosLista();

		// botões padrão (podem ser re-escritos pelo controller pai)
		if ($this->controller->action=='editar' || $this->controller->action=='excluir')
		{
			if ($this->controller->action=='editar')
			{
				if (!in_array($this->name.'/novo',$this->urlsNao))
				{
					$botoes['Novo']['onClick']		= 'javascript:document.location.href=\''.Router::url('/',true).$this->name.'/novo\'';
					$botoes['Novo']['title']		= 'Insere um novo registro ...';
				}
				if (!in_array($this->name.'/imprimir',$this->urlsNao))
				{
					$botoes['Imprimir']['onClick']	= 'javascript:document.location.href=\''.Router::url('/',true).$this->name.'/imprimir/'.$id.'\'';
					$botoes['Imprimir']['title']	= 'Imprime o registro corrente em um arquivo pdf ...';
				}
			}
			if (!in_array($this->name.'/excluir',$this->urlsNao))
			{
				$botoes['Excluir']['onClick']	= 'javascript:$(\'#botoesEdicao\').fadeOut(); $(\'#msgEdicao\').show(100);';
				$botoes['Excluir']['title']		= 'Excluir o registro corrente ...';
				$this->controller->viewVars['msgEdicao'] = 'Você tem certeza de Excluir <strong>'.$this->controller->data[$modelClass][$this->controller->$modelClass->displayField].'</strong> ? <a href="'.Router::url('/',true).$this->name.'/delete/'.$id.'" class="linkEdicaoExcluir">Sim</a>&nbsp;&nbsp;<a href="javascript:return false;" onclick="javascript:$(\'#msgEdicao\').fadeOut(); $(\'#botoesEdicao\').show();" class="linkEdicaoExcluir">Não</a>';
			}
		}

		if (!in_array($this->name.'/salvar',$this->urlsNao))
		{
			$botoes['Salvar']['type']		= 'submit';
			$botoes['Salvar']['title']		= 'Salva as alterações do registro ...';
			if ($id) $botoes['Atualizar']['onClick']	= 'javascript:document.location.href=\''.Router::url('/',true).$this->name.'/editar/'.$id.'\'';
			if ($id) $botoes['Atualizar']['title']		= 'Atualize o registro ...';		
		}

		if (!in_array($this->name.'/listar',$this->urlsNao) && $this->controller->action != 'novo' )
		{
			$botoes['Listar']['onClick']	= 'javascript:document.location.href=\''.Router::url('/',true).$this->name.'/listar'.$urlLista.'\'';
			$botoes['Listar']['title']		= 'Volta para a Lista ...';
		}

		// configurando as propriedades padrão
		foreach($botoes as $_label => $_arrOpcao)
		{
			$botoes[$_label]['type']		= isset($botoes[$_label]['type'])    ? $botoes[$_label]['type']    : 'button';
			$botoes[$_label]['class']		= isset($botoes[$_label]['class'])   ? $botoes[$_label]['class']   : 'btEdicao';
			$botoes[$_label]['id']			= isset($botoes[$_label]['id'])      ? $botoes[$_label]['id']      : 'btEdicao'.$_label;
			$botoes[$_label]['onClick']		= isset($botoes[$_label]['onClick']) ? $botoes[$_label]['onClick'] : null;
		}

		// atualizando a view
		$this->controller->viewVars['botoesEdicao'] = $botoes;
	}

	/**
	 * Configura os botões na lista
	 * 
	 * @return void
	 */
	private function setBotoesLista()
	{
		$botoes = array();
		if (!in_array($this->name.'/novo',$this->urlsNao))
		{
			$botoes['Novo']['onClick']		=  ( isset( $this->controller->params['pass'][1] ) && !empty( $this->controller->params['pass'][1] ) ) ?
                                                'javascript:document.location.href=\''.Router::url('/',true).$this->name.'/novo/'.$this->controller->params['pass'][1].'\'' :
                                                'javascript:document.location.href=\''.Router::url('/',true).$this->name.'/novo\'' ;

			$botoes['Novo']['title']		= 'Clique para inserir um registro...';
		}

		// configurando as propriedades padrão
		foreach($botoes as $_label => $_arrOpcao)
		{
			$botoes[$_label]['type']		= 'button';
			$botoes[$_label]['class']		= 'btEdicao';
			$botoes[$_label]['id']			= 'btEdicao'.$_label;
		}

		// atualizando a view
		$this->controller->viewVars['botoesLista'] = $botoes;
	}

	 /**
	  * Configura as ferramentas que serão usadas na Lista. Implementando as opções que são padrão
	  * bem como, implementando as opções que vem co controller pai.
	  * 
	  * @return void
	  */
	  private function setFerramentasLista()
	  {
		if (!isset($this->controller->viewVars['listaFerramentas'][0]))
		{
			$ferramentas[0]['link']		= Router::url('/',true).$this->name.'/imprimir/{id}';
			$ferramentas[0]['title']	= 'Imprimir';
			$ferramentas[0]['icone']	= 'bt_imprimir.png';
		}
		if (!isset($this->controller->viewVars['listaFerramentas'][1]))
		{
			$ferramentas[1]['link']		= Router::url('/',true).$this->name.'/editar/{id}';
			$ferramentas[1]['title']	= 'Editar';
			$ferramentas[1]['icone']	= 'bt_editar.png';
		}
		if (!isset($this->controller->viewVars['listaFerramentas'][2]))
		{
			$ferramentas[2]['link']		= Router::url('/',true).$this->name.'/excluir/{id}';
			$ferramentas[2]['title']	= 'Excluir';
			$ferramentas[2]['icone']	= 'bt_excluir.png';
		}
		$this->controller->viewVars['listaFerramentas'] = $ferramentas;
	  }
	  
	 /**
	  * Joga na sessão os parâmetros da lista, que são, página, ordem e ordanação (asc/desc).
	  * 
	  * @return void
	  */
	 private function setParametrosLista()
	 {
		if (isset($this->controller->params['named']['page']))  $this->controller->Session->write($this->controller->name.'.Page',$this->controller->params['named']['page']);
		if (isset($this->controller->params['named']['sort']))  $this->controller->Session->write($this->controller->name.'.Sort',$this->controller->params['named']['sort']);
		if (isset($this->controller->params['named']['direction']))  $this->controller->Session->write($this->controller->name.'.Dire',$this->controller->params['named']['direction']);
	 }
	 
	 /**
	  * Verifica se o usuário ou o perfil logado tem permissão para acessar a url solicitada.
	  * Caso não possui acesso é redirecionado para um tela de erro
	  * 
	  * @return
	  */
	 private function setUrlPermissao($url=null)
	 {
		 if (in_array($url,$this->urlsNao))
		 {
			 $this->controller->Session->setFlash('<span style="font-size: 18px;">Você não tem acesso autorizado a esta tela !!!</span>');
			 $this->controller->redirect('/');
		 }
		 
		 if (in_array($this->name,$this->urlsNao))
		 {
			 $this->controller->Session->setFlash('<span style="font-size: 18px;">Você não tem acesso autorizado a esta tela !!!</span>');
			 $this->controller->redirect('/');
		 }
	 }
}
?>
