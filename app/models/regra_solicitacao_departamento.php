<?php
/**
 * CPWeb - Controle Virtual de Processos
 * Versão 3.0 - Novembro de 2010
 *
 * app/model/regra_solicitacao_departamento.php
 *
 * Este modelo mantem todas as urls que cada perfil ou usuário NÃO terá acesso
 * 
 * A reprodução de qualquer parte desse arquivo sem a prévia autorização
 * do detentor dos direitos autorais constitui crime de acordo com
 * a legislação brasileira.
 *
 * This product is protected by copyright and distributed under licenses restricting
 * copying, distribution, and non-allowed selling/trading
 * 
 *
 * @copyright   Copyright 2010, Valéria Esteves Advogados Associados ( www.veadvogados.com.br )
 * @copyright   Copyright 2010, Gustavo Dias Duarte Ramos ( gustavo at gustavo-ramos dot com )
 * @link http://cpweb.veadvogados.adv.br
 * @package cpweb
 * @subpackage cpweb.v3
 * @since CPWeb V3
 */
class RegraSolicitacaoDepartamento extends AppModel {
	/**
	 * Nome do model
	 * 
	 * @var		string
	 * @access 	public
	 */
	public $name 			= 'RegraSolicitacaoDepartamento';

	/**
	 * Campo principal
	 * 
	 * @var		string
	 * @access 	public
	 */
	public $displayField	= 'created';

	/**
	 * Nome da tabela no banco de dados
	 * 
	 * @var		string
	 * @access 	public
	 */
	public $useTable		= 'regras_solicitacoes_departamentos';

	/**
	 * Ordem padrão do model
	 * 
	 * @var		string
	 * @access	public
	 */
	public $order			= 'RegraSolicitacaoDepartamento.created DESC';

	/**
	 * Matriz de relacionamentos
	 * 
	 * @var		array
	 * @access	public
	 */
	public $belongsTo	= array
	(
		'Solicitacao'  		=> array(
			'className'		=> 'Solicitacao',
			'foreignKey'	=> 'solicitacao_id',
			'fields'		=> 'id, solicitacao'
		)
	);
}

?>
