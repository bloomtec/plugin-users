<div class="userMailConfigs form">
	<?php echo $this -> Form -> create('UserMailConfig'); ?>
	<fieldset>
		<?php echo $this -> Form -> input('id'); ?>
		<table id="MailServices" class="mail-services">
			<tbody>
				<caption>Configurar Servicio De Correo</caption>
				<tr>
					<td class="service">
						<?php echo $this -> Form -> input('mail_service_id', array('label' => __('Servicio', true))); ?>
					</td>
					<td class="key">
						<?php echo $this -> Form -> input('api_key', array('label' => __('Llave API', true))); ?>
					</td>
					<td class="active">
						<?php echo $this -> Form -> input('is_active', array('label' => __('Activo', true))); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<table id="MailingLists" class="mailing-lists">
			<tbody>
				<caption>Configurar Listas De Correo</caption>
				<?php foreach ($this -> data['MailingList'] as $key => $mailing_list) : ?>
				<tr>
					<?php echo $this -> Form -> input("MailingList.$key.id", array('value' => $mailing_list['id'])); ?>
					<td class="scenario">
						<?php echo $this -> Form -> input("MailingList.$key.scenario", array('label' => __('Escenario De Envío', true), 'disabled' => true)); ?>
					</td>
					<td class="list-unique-code">
						<?php echo $this -> Form -> input("MailingList.$key.list_unique_code", array('label' => __('Código De La Lista', true), 'type' => 'text')); ?>
					</td>
					<td class="campaign-unique-code">
						<?php echo $this -> Form -> input("MailingList.$key.campaign_unique_code", array('label' => __('Código De La Campaña', true), 'type' => 'text')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</fieldset>
	<?php echo $this -> Form -> end(__('Modificar')); ?>
</div>
<style>
	form#UserMailConfigAdminEditForm {padding:20px;}
	table#MailServices td input {text-align:center;}
	table#MailServices td.key input {width:300px;}
	table#MailServices td, table#MailingLists td {padding:5px;}
	table#MailServices, table#MailingLists {margin-left:auto; margin-right:auto;}
	table#MailingLists td label, table#MailingLists td input {max-width:300px;}
	table#MailingLists td input {text-align:center;}
</style>