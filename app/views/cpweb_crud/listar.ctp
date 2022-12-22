<?php $this->Html->css('listar.css', null, array('inline' => false)); ?>
<?php $this->Html->script('listar.js', array('inline' => false)); ?>
<?php if (file_exists(WWW_ROOT.'css/'.$this->params['controller'].'.css')) 	echo $this->Html->css($this->params['controller'], null, array('inline'=>false))."\n"; ?>

<?php $arq = mb_strtolower('../views/'.$name.'/config_'.$name.'.ctp'); if (file_exists($arq)) include_once($arq); else exit('não foi possível localizar o arquivo '.$arq); ?>
<?php if (isset($arqListaMenu)) { $arq = '../views/elements/'.$arqListaMenu.'.ctp'; if (file_exists($arq)) include($arq); } ?>

<div class="lista" id="lista<?php echo str_replace(' ','',$pluralHumanName);?>" >

<div id="topo">
	<div id="msgLista"><?php if (isset($msgLista)) echo $msgLista; ?></div>
	<div id="botoes_lista">
	<?php foreach($botoesLista as $_label => $_arrOpcoes) if (count($_arrOpcoes)) echo "\t".$form->button($_label,$_arrOpcoes)."\n"; ?>
	</div>
	<div id="paginas">
		<ul>
		<?php if (isset($paginator->options))
			{
				echo '<li>'.$paginator->first('<<',array('class'=>'bt_primeiro')).'</li>';
				if ($this->params['paging'][$modelClass]['pageCount']>1) echo '<li>'.$paginator->prev('<',array('class'=>'bt_anterior')).'</li>';
				if ($this->params['paging'][$modelClass]['pageCount']>1) echo '<li>'.$paginator->next('>',array('class'=>'bt_proximo')).'</li>';
				echo '<li>'.$paginator->last('>>',array('class'=>'bt_ultimo')).'</li>';
			}
			if ($this->params['paging'][$modelClass]['pageCount']>1 && isset($paginator->options['url']['page'])) if ($paginator->options['url']['page']!=1)
			{
				$pagOpcoes['value'] 	= $this->params['paging'][$modelClass]['page'];
				$pagOpcoes['div'] 		= null;
				$pagOpcoes['id'] 		= 'pagNum';
				$pagOpcoes['format'] 	= array('input');
				echo '<li class="pagAtiva">';
				echo $this->Form->input('Página',$pagOpcoes).' / ';
				echo $this->params['paging'][$modelClass]['pageCount'].' ';
				$irOpcoes['type']		= 'button';
				$irOpcoes['div'] 		= null;
				$irOpcoes['id'] 		= 'pagIr';
				echo $this->Form->button('Ir',$irOpcoes);
				echo '</li>';
				$on_read_view .= "\n\t".'$("#pagIr").click(function() { window.location.href="'.Router::url('/',true).mb_strtolower($pluralHumanName).'/listar/page:"+$("#pagNum").val(); });';
			}
		?>
		</ul>
	</div>
	<?php if (isset($camposPesquisa)) echo $this->element('pesquisa'); ?>
</div>

<div id="esquerda">
<ul>
<?php
	if (isset($listaMenu) && in_array('ADMINISTRADOR',$this->Session->read('perfis')) ) 
	foreach($listaMenu as $_item => $_arrOpcoes) 
		if (count($_arrOpcoes)) 
		{
			$_arrOpcoes['options']['style'] = $_arrOpcoes['url']=='#' ? 'background-color: #ddd;' : '';
			echo "<li>\n\t".$this->Html->link($_arrOpcoes['text'],$_arrOpcoes['url'],(isset($_arrOpcoes['options'])? $_arrOpcoes['options'] : null), (isset($_arrOpcoes['confirmMessage']) ? $_arrOpcoes['confirmMessage'] : null) )."\n\t</li>\n";
		}
?>
</ul>
</div>

<div id="direita">

<table class="linhas" cellpadding="0" cellspacing="0" border="0" >
<tr>
<?php
	// cabeçalho da lista
	if (isset($listaCampos))
	{
		foreach($listaCampos as $_field)
		{
			$_arrField = explode('.',$_field);
			$titulo = isset($campos[$_arrField[0]][$_arrField[1]]['options']['label']['text']) ? $campos[$_arrField[0]][$_arrField[1]]['options']['label']['text'] : $_field;
			$estilo = isset($campos[$_arrField[0]][$_arrField[1]]['estilo_th']) ? $campos[$_arrField[0]][$_arrField[1]]['estilo_th'] : '';

			if ($_field=='Processo.id_controle') 	$_field = 'Processo.id';

			//if ($_field=='Processo.cliente')		$_field = 'Contato.nome';
			
			//if ($_field=='Processo.parte')			$_field = 'Contato.nome';
			
			if (isset($campos[$_arrField[0]][$_arrField[1]]['thOff']) && $campos[$_arrField[0]][$_arrField[1]]['thOff']==true)
				echo "<th $estilo>$titulo</th>\n";
			else
				echo "<th $estilo>".$this->Paginator->sort($titulo,$_field)."</th>\n";
		}
		
		// verificando se tem ferramenta
		$totFerramentas = 0;
		foreach($listaFerramentas as $_item => $_ferramenta) if (count($_ferramenta)) $totFerramentas++;
		if ($totFerramentas>0) echo "<th colspan='$totFerramentas'>Ferramentas</th>";
	}
?>
</tr>

<?php
	// linha a linha da lista
	foreach($this->data as $_line => $_dataModel)
	{
		$id 		= $_dataModel[$modelClass][$primaryKey];
		$_estilo_tr	= 'estilo_tr_'.$id;
		$estilo_tr	= isset($lista[$_estilo_tr]) ? $lista[$_estilo_tr] : '';
		
		echo "<tr id='tr_$id' title='clique aqui para editar ...' $estilo_tr class='lista_linha_fora' onmouseover='javascript:this.className=\"lista_linha_ativa\"' onmouseout='javascript:this.className=\"lista_linha_fora\"'>\n";

		// campo a campo
		if (isset($listaCampos))
		{
			foreach($listaCampos as $_field)
			{
				$_arrField = explode('.',$_field);
				$estilo = isset($campos[$_arrField[0]][$_arrField[1]]['estilo_td'])     ? $campos[$_arrField[0]][$_arrField[1]]['estilo_td'] : '';
				$titulo = isset($campos[$_arrField[0]][$_arrField[1]]['label']['text']) ? $campos[$_arrField[0]][$_arrField[1]]['label']['text'] : $_field;
				$idTd	= 'td_'.$id.'_'.mb_strtolower(Inflector::slug($titulo));
				$estilo = isset($campos[$_arrField[0]][$_arrField[1]]['estilo_'.$idTd]) ? $campos[$_arrField[0]][$_arrField[1]]['estilo_'.$idTd] : $estilo;
				$masc	= isset($campos[$_arrField[0]][$_arrField[1]]['options']['dateFormat']) ? $campos[$_arrField[0]][$_arrField[1]]['options']['dateFormat'] : '';
				$valor 	= $_dataModel[$_arrField[0]][$_arrField[1]];
				$onclick= "onclick='javascript:document.location.href=\"".Router::url('/',true).$name.'/editar/'.$id."\";'";
				if (isset($campos[$_arrField[0]][$_arrField[1]]['link_off'])) $onclick='';

				// se possui máscara 
				if (isset($campos[$_arrField[0]][$_arrField[1]]['mascara']))			$valor = $this->Formatacao->getMascara($campos[$_arrField[0]][$_arrField[1]]['mascara'],$valor);

				// se é um comboBox, exibe o vetor 1
				if (isset($campos[$_arrField[0]][$_arrField[1]]['options']['options'][$valor]))
				{
					$valor = $campos[$_arrField[0]][$_arrField[1]]['options']['options'][$valor];
				}

				echo "\t<td $onclick id='$idTd' $estilo>$valor</td>\n";
			}
		}

		// removendo botão excluir se o usuário não é admin
		if (!in_array('ADMINISTRADOR',$this->Session->read('perfis')))
		{
			$listaFerramentas[2] = array();
		}

		// ferramentas
		foreach($listaFerramentas as $_item => $_ferramenta)
		{
			if (count($_ferramenta))
			{
				$_ferramenta['type']  = isset($_ferramenta['type'])  ? $_ferramenta['type']  : '';
				$_ferramenta['link']  = isset($_ferramenta['link'])  ? $_ferramenta['link']  : '';
				$_ferramenta['icone'] = isset($_ferramenta['icone']) ? $_ferramenta['icone'] : '';
				
				$link = (isset($listaFerramentasId[$_item]['link'][$id]))  ? $listaFerramentasId[$_item]['link'][$id]  : str_replace('{id}',$id,$_ferramenta['link']);
				$icon = (isset($listaFerramentasId[$_item]['icone'][$id])) ? $listaFerramentasId[$_item]['icone'][$id] : $_ferramenta['icone'];
				$tipo = (isset($listaFerramentasId[$_item]['type'][$id]))  ? $listaFerramentasId[$_item]['type'][$id]  : $_ferramenta['type'];
				
				echo "\t<td width='35px' align='center'>";
				if ($tipo != 'checkbox')
				{
					if ($link) echo "<a href='".$link."' title='".$_ferramenta['title']."'>";
					if ($icon) echo "<img src='".Router::url('/',true)."img/".$_ferramenta['icone']."' border='0'/>";
					if ($link) echo "</a>";
				} else
				{
					$arrCmp = explode('.',($_ferramenta['value']));
					$fValue = $_dataModel[$arrCmp[0]][$arrCmp[1]];
					echo "<input value='$fValue' name='data[".$id."][".$arrCmp[0]."][".$arrCmp[1]."]' ";
					//echo "id='data[".$id."][".$arrCmp[0]."][".$arrCmp[1]."]' ";
					echo "id='".$this->Form->domId($id)."' ";
					echo "title='clique aqui para marcar a finalização do Processo Solitação' type='checkbox' />";
				}
				echo "</td>\n";
			}
		}
		echo "</tr>\n\n";
	}
?>
</table>

<div class="listaRodape">
Página <?php echo $this->params['paging'][$modelClass]['page']; ?> de <?php echo $this->params['paging'][$modelClass]['pageCount']; ?> - Total de Registro: <?php echo $this->params['paging'][$modelClass]['count']; ?></td>
</div>

</div>

</div>
<?php include_once('../views/cpweb_crud/rodape.ctp'); ?>
