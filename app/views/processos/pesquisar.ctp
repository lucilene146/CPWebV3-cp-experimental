<?php // exibe a resposta da pesquisa ?>
<ul>
<?php foreach($pesquisa as $id => $valor) echo "\t".'<li onclick="document.location.href=\''.$link.'/'.$id.'\'">'.$valor.'</li>'."\n"; ?>
</ul>
<?php //echo str_replace('`','',$this->element('sql_dump')); ?>
