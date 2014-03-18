<div class="estados form">
<?php echo $this->Form->create('Estado'); ?>
	<fieldset>
		<legend><?php echo __('Add Estado'); ?></legend>
	<?php
		echo $this->Form->input('nome');
		echo $this->Form->input('pais_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Estados'), array('action' => 'index')); ?></li>
	</ul>
</div>
