<div class="documentTypes form">
<?php echo $this->Form->create('DocumentType');?>
	<fieldset>
		<legend><?php echo __('Edit Document Type'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('document_type');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('DocumentType.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('DocumentType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Document Types'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
