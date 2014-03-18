<div class="cidades view">
<h2><?php echo __('Cidade'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cidade['Cidade']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nome'); ?></dt>
		<dd>
			<?php echo h($cidade['Cidade']['nome']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado Id'); ?></dt>
		<dd>
			<?php echo h($cidade['Cidade']['estado_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cidade'), array('action' => 'edit', $cidade['Cidade']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cidade'), array('action' => 'delete', $cidade['Cidade']['id']), null, __('Are you sure you want to delete # %s?', $cidade['Cidade']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cidades'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cidade'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Relatóriso'), array('action' => 'imprimirRelatorio', $cidade['Cidade']['id'])); ?> </li>
	</ul>
</div>
