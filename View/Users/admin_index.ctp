<div class="users index">
	<h2><?php echo __('Usuarios');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id', __('ID', true));?></th>
			<th><?php echo $this->Paginator->sort('role_id', __('Rol', true));?></th>
			<th><?php echo $this->Paginator->sort('username', __('Nombre De Usuario', true));?></th>
			<th><?php echo $this->Paginator->sort('email', __('Correo Electrónico', true));?></th>
			<th><?php echo $this->Paginator->sort('name', __('Nombre', true));?></th>
			<th><?php echo $this->Paginator->sort('lastname', __('Apellido', true));?></th>
			<th><?php echo $this->Paginator->sort('is_active', __('Activo', true));?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($user['Role']['id'], array('controller' => 'roles', 'action' => 'view', $user['Role']['id'])); ?>
		</td>
		<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['lastname']); ?>&nbsp;</td>
		<td>
			<?php
				if($user['User']['is_active']) {
					echo '<input type="checkbox" checked="checked" disabled="true" />';
				} else {
					echo '<input type="checkbox" disabled="true" />';
				}
			?>
			&nbsp;
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Modificar'), array('action' => 'edit', $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Agregar Usuario'), array('action' => 'add')); ?></li>
	</ul>
</div>
