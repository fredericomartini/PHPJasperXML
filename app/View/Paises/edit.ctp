<div class="paises form">
<?php echo $this->Form->create('Paise'); ?>
	<fieldset>
		<legend><?php echo __('Edit Paise'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Paise.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Paise.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Paises'), array('action' => 'index')); ?></li>
	</ul>
</div>
