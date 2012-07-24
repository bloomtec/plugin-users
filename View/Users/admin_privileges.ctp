<div class="usuarios form">
	<?php echo $this -> Form -> create('User');?>
	<fieldset>
		<h2><?php echo __('Asignar Privilegios A Supervisor');?></h2>
		<br />
		<h3>Módulos</h3>
		<?php echo $this -> Form -> input('id');?>
		<table class="permisos">
			<tr class="modulo">
				<th class="nombre" colspan="1" width="150">Catálogo</th>
				<td class="accion" colspan="1" width="150"><?php echo $this -> Form -> input('Privilege.Category', array('label' => 'Categorías', 'type' => 'checkbox'));?></td>
				<td class="accion" colspan="1" width="150"><?php echo $this -> Form -> input('Privilege.Color', array('label' => 'Colores', 'type' => 'checkbox'));?></td>
				<td class="accion" colspan="1" width="150"><?php echo $this -> Form -> input('Privilege.ProductSize', array('label' => 'Tallas', 'type' => 'checkbox'));?></td>
				<td class="accion" colspan="1" width="150"><?php echo $this -> Form -> input('Privilege.Product', array('label' => 'Productos', 'type' => 'checkbox'));?></td>
			</tr>
		</table>
		<table class="permisos">
			<tr class="modulo">
				<th class="nombre" colspan="1" width="150">Promociones</th>
				<td class="accion" colspan="1" width="150"><?php echo $this -> Form -> input('Privilege.Promotion', array('label' => 'Sitio Web', 'type' => 'checkbox'));?></td>
				<td class="accion" colspan="1" width="150"><?php echo $this -> Form -> input('Privilege.CouponBatch', array('label' => 'Cupones', 'type' => 'checkbox'));?></td>
				<td class="accion" colspan="1" width="150"></td>
				<td class="accion" colspan="1" width="150"></td>
			</tr>
		</table>
		<table class="permisos">
			<tr class="modulo">
				<th class="nombre" colspan="1" width="150">Ordenes</th>
				<td class="accion" colspan="1" width="150"><?php echo $this -> Form -> input('Privilege.Order', array('label' => 'Ordenes', 'type' => 'checkbox'));?></td>
				<td class="accion" colspan="1" width="150"></td>
				<td class="accion" colspan="1" width="150"></td>
				<td class="accion" colspan="1" width="150"></td>
			</tr>
		</table>
		<table class="permisos">
			<tr class="modulo">
				<th class="nombre" colspan="1" width="150">Sondeos</th>
				<td class="accion" colspan="1" width="150"><?php echo $this -> Form -> input('Privilege.Survey', array('label' => 'Sondeos', 'type' => 'checkbox'));?></td>
				<td class="accion" colspan="1" width="150"></td>
				<td class="accion" colspan="1" width="150"></td>
				<td class="accion" colspan="1" width="150"></td>
			</tr>
		</table>
		<table class="permisos">
			<tr class="modulo">
				<th class="nombre" colspan="1" width="150">Navegación</th>
				<td class="accion" colspan="1" width="150"><?php echo $this -> Form -> input('Privilege.Page', array('label' => 'Páginas', 'type' => 'checkbox'));?></td>
				<td class="accion" colspan="1" width="150"><?php echo $this -> Form -> input('Privilege.Menu', array('label' => 'Menús', 'type' => 'checkbox'));?></td>
				<td class="accion" colspan="1" width="150"><?php echo $this -> Form -> input('Privilege.MenuItem', array('label' => 'Ítems De Menús', 'type' => 'checkbox'));?></td>
				<td class="accion" colspan="1" width="150"></td>
			</tr>
		</table>
		<script type="text/javascript">
			$(function(){
				$('#PrivilegeMenuItem').change(function() {
					if($('#PrivilegeMenuItem').is(':checked') && !$('#PrivilegeMenu').is(':checked')) {
						$('#PrivilegeMenu').attr('checked', true);
					}
				});
				$('#PrivilegeMenu').change(function() {
					if(!$('#PrivilegeMenu').is(':checked') && $('#PrivilegeMenuItem').is(':checked')) {
						$('#PrivilegeMenuItem').attr('checked', false);
					}
				});
			});
		</script>
	</fieldset>
	<?php echo $this -> Form -> end(__('Guardar'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this -> Html -> link(__('Cancelar'), array('action' => 'index'));?></li>
	</ul>
</div>