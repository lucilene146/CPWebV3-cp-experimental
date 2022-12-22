<?php
/**
 * CPWeb - Controle Virtual de Processos
 * Versão 3.0 - Novembro de 2010
 *
 * app/model/processo.php
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
class Processo extends AppModel {

	public $name 			= 'Processo';
	public $useTable		= 'processos';
	public $order		 	= 'Processo.id ASC';
	public $displayField 	= 'numero';

	/**
	 * Validação
	 * 
	 * @var	array
	 * @access	public
	 */
	public $validate	= array
	(
		'tipo_processo_id'	=> array
		(
			'rule'		=> 'notEmpty',
			'required' 	=> true,
            'message'	=> 'É necessário informar um Tipo de processo !!!'
		),
		'status_id'	=> array
		(
			'rule'		=> 'notEmpty',
			'required' 	=> true,
            'message'	=> 'É necessário informar o Status do Processo !!!'
		),
		'fase_id'	=> array
		(
			'rule'		=> 'notEmpty',
			'required' 	=> true,
            'message'	=> 'É necessário informar uma Fase !!!'
		),
		'instancia_id'	=> array
		(
			'rule'		=> 'notEmpty',
			'required' 	=> true,
            'message'	=> 'É necessário informar uma Instância !!!'
		),
		'numero'	=> array
		(
			'notEmpty' => array(
                'rule'		=> 'notEmpty',
                'required' 	=> true,
                'message'	=> 'É necessário informar um Número de Processo !!!'
            ),
            'isUnique' => array(
                'rule'		=> 'isUnique',
                'message'	=> 'Número de Processo já cadastrado na base !!!'
            )
		),
		'numero_auxiliar'	=> array
		(
			'rule'		=> 'notEmpty',
			'required' 	=> true,
            'message'	=> 'É necessário informar o número Auxiliar do processo !!!'
		),
		'data_distribuicao'	=> array
		(
			'rule'		=> 'notEmpty',
			'required' 	=> true,
            'message'	=> 'É necessário informar uma data de Distribuição !!!'
		),
		'comarca_id'	=> array
		(
			'rule'		=> 'notEmpty',
			'required' 	=> true,
            'message'	=> 'É necessário informar uma Comarca !!!'
		),
		'orgao_id'		=> array
		(
			'rule'		=> 'notEmpty',
			'required' 	=> true,
            'message'	=> 'É necessário informar Orgão !!!'
		),
		'natureza_id'		=> array
		(
			'rule'		=> 'notEmpty',
			'required' 	=> true,
            'message'	=> 'É necessário informar a Natureza !!!'
		),
		'usuario_id'		=> array
		(
			'rule'		=> 'notEmpty',
			'required' 	=> true,
            'message'	=> 'É necessário o Advogado Interno responsável !!!'
		),
	);

	/**
	 * Relacionamento belongsTo 
	 */
	public $belongsTo		= array
	(
		'Usuario'  		=> array(
			'className'		=> 'Usuario',
			'foreignKey'	=> 'usuario_id',
			'fields'		=> 'id, nome'
		),
        'Responsavel'   => array(
            'className'     => 'Usuario',
            'foreignKey'    => 'responsavel_acordo',
            'fields'        => 'id, nome'
        ),
		'Comarca'  		=> array(
			'className'		=> 'Comarca',
			'foreignKey'	=> 'comarca_id',
			'fields'		=> 'id, nome'
		),
		'Fase'  		=> array(
			'className'		=> 'Fase',
			'foreignKey'	=> 'fase_id',
			'fields'		=> 'id, nome'
		),
		'Instancia'  		=> array(
			'className'		=> 'Instancia',
			'foreignKey'	=> 'instancia_id',
			'fields'		=> 'id, nome'
		),
		'Natureza'  		=> array(
			'className'		=> 'Natureza',
			'foreignKey'	=> 'natureza_id',
			'fields'		=> 'id, nome'
		),
		'Status'  		=> array(
			'className'		=> 'Status',
			'foreignKey'	=> 'status_id',
			'fields'		=> 'id, nome'
		),
		'TipoProcesso'  		=> array(
			'className'		=> 'TipoProcesso',
			'foreignKey'	=> 'tipo_processo_id',
			'fields'		=> 'id, nome'
		),
		'Equipe'  		=> array(
			'className'		=> 'Equipe',
			'foreignKey'	=> 'equipe_id',
			'fields'		=> 'id, nome'
		),
		'Orgao'  		=> array(
			'className'		=> 'Orgao',
			'foreignKey'	=> 'orgao_id',
			'fields'		=> 'id, nome'
		),
		'Gestao'  		=> array(
			'className'		=> 'Gestao',
			'foreignKey'	=> 'gestao_id',
			'fields'		=> 'id, nome'
		),
        'Segmento'  		=> array(
			'className'		=> 'Segmento',
			'foreignKey'	=> 'segmento_id',
			'fields'		=> 'id, nome'
		),
	);

    public $hasMany = array(
        'ProcessoSolicitacao' => array(
            'className' => 'ProcessoSolicitacao',
            'foreignKey' => 'processo_id'
        ),
        'ContatoProcesso' => array(
            'className' => 'ContatoProcesso',
            'foreignKey' => 'processo_id'
        ),
    );
    
    /**
     * Executa código antes de deletar um processo
     * 
     * @return void
     */
    public function beforeDelete()
    {
		if (!$this->query('DELETE FROM eventos			WHERE processo_id='.$this->id)) return false;
		if (!$this->query('DELETE FROM eventos_acordos 	WHERE processo_id='.$this->id)) return false;
		if (!$this->query('DELETE FROM audiencias 		WHERE processo_id='.$this->id)) return false;
		if (!$this->query('DELETE FROM processos_solicitacoes WHERE processo_id='.$this->id)) return false;
		if (!$this->query('DELETE FROM contatos_processos WHERE processo_id='.$this->id)) return false;
		parent::beforeDelete();		
		return true;
	}

	/**
	 * Antes de validar
	 * 
	 * Executa a inclusão dos campos de comboBox, caso nenhuma opção tenha sido selecionada e o campo busca 
	 * rápida tenha sido preenchido.
	 * 
	 * @return void
	 */
	public function beforeValidate()
	{
		parent::beforeValidate();

		// se o tipo da instância é igual 5 (Extrajudicial) o campo número não é obrigatório
		if ($this->data[$this->name]['instancia_id']==5)
		{
            $this->validate['distribuicao'] = null;
			$this->validate['numero'] = null;
		}

		//echo '<pre>'.print_r($this->data,true).'</pre>';
		// executando a inclusão dos comboBox, caso não se
		// incluindo a cada belongsTo
		foreach($this->belongsTo as $_modelo => $_arrOpcoes)
		{
			$campo = str_replace(' ','',Inflector::humanize(Inflector::underscore($_arrOpcoes['foreignKey'])));
			$valor = isset($this->data[$this->name]['inBuscaRapida'.$this->name.$campo]) ? $this->data[$this->name]['inBuscaRapida'.$this->name.$campo] : '';
			if ($valor && empty($this->data[$this->name][$_arrOpcoes['foreignKey']]))
			{
				$primaryKey 		= isset($this->$_modelo->primaryKey) ? $this->$_modelo->primaryKey : 'id';
				$camposBelongsTo	= explode(',',$_arrOpcoes['fields']);
				$dataBelongsTo[$_modelo][trim($camposBelongsTo[1])] = $valor;
				$opcoesBelongsTo	= array();

				// incluindo o novo registro para o belongsTo
				$this->$_modelo->create();
				if ($this->$_modelo->save($dataBelongsTo,$opcoesBelongsTo))
				{
					// agora que criou o belongsTo é precisso atualizar o this->data
					$this->data[$this->name][$_arrOpcoes['foreignKey']] = $this->$_modelo->$primaryKey;
				} else
				{
					$this->validate[$_arrOpcoes['foreignKey']]['message'] = 'Não foi possível salvar o novo '.$this->$_modelo->name.'<br />';
					foreach($this->$_modelo->validationErrors as $_erroCampoBelongsTo => $_msgErroCampoBelongsTo)
					{
						$this->validate[$_arrOpcoes['foreignKey']]['message'] .= $_msgErroCampoBelongsTo.'<br />';
					}
				}
			}
		}
		return true;
	}
	
	/**
	 * Atualizando depois de salvar
	 * 
	 */
	public function afterSave($created)
	{
		if ($created)
		{
			$idProcesso =  $this->getLastInsertID();
			if ($idProcesso)
			{
				$this->saveField('familia_id',$idProcesso);
			}
		}
	}
}
?>
