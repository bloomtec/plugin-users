<div class="content">
	<h1>Mis datos</h1>
		<h3>Email:</h3>
		<span><?php echo $user['User']['email']?></span>
		<h3>Nombres:</h3>
		<span><?php echo $user['User']['name']?></span>
		<h3>Apellidos:</h3>
		<span><?php echo $user['User']['lastname']?></span>
		<h3>Numero de Identificacion:</h3>
		<span><?php echo $user['DocumentType']['document_type']." ".$user['User']['document']?></span>
		<h3>Sexo:</h3>
		<span><?php echo $user['User']['sex']?></span>
		<h3>Fecha de Nacimiento:</h3>
		<span><?php echo $user['User']['birthday']?></span>
	<br />
	<br />
	<h1>Mis Direcciones</h1>
	<div>
	<?php foreach($user['UserAddress'] as $address): ?>
		<div class="address">
			<div class='name'>
				<h3>Nombre:</h3><?php echo $address['name']?>
			</div>
			<div class='country'>
				<h3>País:</h3><?php echo $address['country']?>
			</div>
			<div class='state'>
				<h3>Departamento:</h3>	<?php echo $address['state']?>
			</div>
			<div class='city'>
				<h3>Ciudad:</h3><?php echo $address['city']?>
			</div>
			<div class='the-address'>
				<h3>Direccción:</h3><?php echo $address['address']?>
			</div>
			<div class='phone'>
				<h3>telefono:</h3><?php echo $address['phone']?>
			</div>
				<div class="actions">
				<a href="/user_control/user_addresses/edit/<?php echo $address['id']; ?>">Modificar</a>
				
				<?php
					echo $this->Form->postLink(
						__('Eliminar'),
						array(
							'plugin' => 'user_control',
							'controller' => 'user_addresses',
							'action' => 'delete',
							$address['id']
						),
						array(
							'class'=>'delete'
						),
						__('¿Elimiinar la dirección ' . $address['name'] . '?', $address['id'])
					);
				?>
					<div style="clear:both;"></div>
				</div>
		</div>
	<?php endforeach;?>
	</div>
	<div style="clear: both"></div><br />
	<a class="button" href="/user_control/user_addresses/add" style="padding:5px;">Agregar Dirección</a>
</div>