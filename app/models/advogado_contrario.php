<?php
/**
 * CPWeb - Controle Virtual de Processos
 * Versão 3.0 - Novembro de 2010
 *
 * app/model/advogadocontrario.php
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
class Advogadocontrario extends AppModel {

	public $name 			= 'AdvogadoContrario';
	public $useTable 		= 'advogados_contrarios';
	public $primaryKey		= 'id';
	public $displayField 	= 'nome';
	public $order		 	= 'AdvogadoContrario.nome';

	public $validate = array(
		'oab' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'É necessário informar a OAB do Advogado!'
		),

		'nome' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'message' => 'É necessário informar o nome do Advogado!'
		)
	);

	public $belongsTo = array(
		'Cidade' => array(
			'className' => 'Cidade',
			'foreignKey' => 'cidade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * Antes de salvar
	 */
	public function beforeValidate()
	{
		if (isset($this->data['AdvogadoContrario']['oab']))		$this->data['AdvogadoContrario']['oab'] 		= ereg_replace('[.-/]','',$this->data['AdvogadoContrario']['oab']);
		if (isset($this->data['AdvogadoContrario']['nome']))	$this->data['AdvogadoContrario']['nome'] 		= mb_strtoupper($this->data['AdvogadoContrario']['nome']);
		if (isset($this->data['AdvogadoContrario']['e-mail'])) 	$this->data['AdvogadoContrario']['e-mail'] 		= mb_strtolower($this->data['AdvogadoContrario']['e-mail']);
		
		parent::beforeValidate();
	}
}
