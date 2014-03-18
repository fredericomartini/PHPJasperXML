<div class="paises view">
<h2><?php echo __('Paise'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($paise['Paise']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nome'); ?></dt>
		<dd>
			<?php echo h($paise['Paise']['nome']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Paise'), array('action' => 'edit', $paise['Paise']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Paise'), array('action' => 'delete', $paise['Paise']['id']), null, __('Are you sure you want to delete # %s?', $paise['Paise']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Paises'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paise'), array('action' => 'add')); ?> </li>
	</ul>
</div>
