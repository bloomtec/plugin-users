<div class="documentTypes view">
<h2><?php  echo __('Document Type');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($documentType['DocumentType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Document Type'); ?></dt>
		<dd>
			<?php echo h($documentType['DocumentType']['document_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($documentType['DocumentType']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($documentType['DocumentType']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($documentType['DocumentType']['updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Document Type'), array('action' => 'edit', $documentType['DocumentType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Document Type'), array('action' => 'delete', $documentType['DocumentType']['id']), null, __('Are you sure you want to delete # %s?', $documentType['DocumentType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Document Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Document Type'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Users');?></h3>
	<?php if (!empty($documentType['User'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Role Id'); ?></th>
		<th><?php echo __('Document Type Id'); ?></th>
		<th><?php echo __('Document'); ?></th>
		<th><?php echo __('Username'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Lastname'); ?></th>
		<th><?php echo __('Password'); ?></th>
		<th><?php echo __('Birthday'); ?></th>
		<th><?php echo __('Sex'); ?></th>
		<th><?php echo __('Is Active'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Updated'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($documentType['User'] as $user): ?>
		<tr>
			<td><?php echo $user['id'];?></td>
			<td><?php echo $user['role_id'];?></td>
			<td><?php echo $user['document_type_id'];?></td>
			<td><?php echo $user['document'];?></td>
			<td><?php echo $user['username'];?></td>
			<td><?php echo $user['email'];?></td>
			<td><?php echo $user['name'];?></td>
			<td><?php echo $user['lastname'];?></td>
			<td><?php echo $user['password'];?></td>
			<td><?php echo $user['birthday'];?></td>
			<td><?php echo $user['sex'];?></td>
			<td><?php echo $user['is_active'];?></td>
			<td><?php echo $user['created'];?></td>
			<td><?php echo $user['updated'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), null, __('Are you sure you want to delete # %s?', $user['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
