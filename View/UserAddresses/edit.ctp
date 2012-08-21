<div class="userAddresses form">
	<?php echo $this -> Form -> create('UserAddress'); ?>
	<fieldset>
		<h2 class="rosa">
			<?php echo __('Modificar Dirección'); ?>
		</h2>
		<br />
		<?php
		echo $this -> Form -> input('id');
		echo $this -> Form -> input('name', array('label' => 'Nombre'));
		echo $this -> Form -> input('country', array('label' => 'País'));
		echo $this -> Form -> input('state', array('label'=>'Departamento'));
		echo $this -> Form -> input('city', array('label'=>'Ciudad'));
		echo $this -> Form -> input('phone', array('label'=>'Teléfono'));
		echo $this -> Form -> input('address', array('label'=>'Dirección'));
		?>
	</fieldset>
	<?php echo $this -> Form -> submit(__('Modificar')); ?>
	<?php echo $this -> Html -> link(__('Cancelar'),
		array(
			'controller'=>'users',
			'action'=>'profile',
			'plugin'=>'user_control'),
		array(
		'class'=>'button link-button',
		'style'=>'margin-left:5px;'
		)
		); ?>
	<?php echo $this -> Form -> end(); ?>
</div>