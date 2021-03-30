<?php
include SSW_WPRDI_PATH."/views/template/header.php";
$RDI = new Rdi_wp();
$fields = $RDI->getFields();
?>
<h2>Custom Fields</h2>
<?php
if (isset($fields->errors)) {
	echo('<h3>Houve um erro ao verificar os custom posts</h3>');
	echo('<p>Tipo do erro: '.$fields->errors->error_type.'</p>');
	echo('<p>Mensagem do erro: '.$fields->errors->error_message.'</p>');
	echo('<p>Entre em contato com o desenvolvedor do sistema.</p>');
} else if (isset($fields->fields)) {
?>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th scope="col" id="title" class="manage-column column-categories column-primary">
				Label
			</th>
			<th scope="col" id="title" class="manage-column column-author column-primary">
				Name
			</th>
			<th scope="col" id="title" class="manage-column column-author column-primary">
				Api Identifier
			</th>
			<th scope="col" id="title" class="manage-column column-author column-primary">
				Presentation Type
			</th>
			<th scope="col" id="title" class="manage-column column-author column-primary">
				Data Type
			</th>
			<th scope="col" id="title" class="manage-column column-author column-primary">
				Validation Rules
			</th>
		</tr>
	</thead>
	<tbody id="the-list" data-wp-lists="list:post">
		<?php
		foreach($fields->fields as $field){
		?>
		<tr class="linha">
            <td class="title column-title has-row-actions column-primary" data-colname="Title">
                <strong>
					<?php echo $field->label->{'pt-BR'}; ?>
                </strong>
            </td>
            <td class="title column-title">
				<?php echo $field->name->{'pt-BR'}; ?>
            </td>
            <td class="title column-title">
				<?php echo $field->api_identifier; ?>
            </td>
            <td class="title column-title">
				<?php echo $field->presentation_type; ?>
            </td>
            <td class="title column-title">
				<?php echo $field->data_type; ?>
            </td>
            <td class="title column-title">
				<?php
				if (isset($field->validation_rules->valid_options)){
					foreach($field->validation_rules->valid_options as $key => $option){
						echo ($key + 1).') "'.$option->value.'"';
						echo '<br>';
					}
				} else {
					// não aplicavel
					echo '';
				}
				?>
            </td>
		</tr>
		<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr>
			<th scope="col" id="title" class="manage-column column-categories column-primary">
				Label
			</th>
			<th scope="col" id="title" class="manage-column column-author column-primary">
				Name
			</th>
			<th scope="col" id="title" class="manage-column column-author column-primary">
				Api Identifier
			</th>
			<th scope="col" id="title" class="manage-column column-author column-primary">
				Presentation Type
			</th>
			<th scope="col" id="title" class="manage-column column-author column-primary">
				Data Type
			</th>
			<th scope="col" id="title" class="manage-column column-author column-primary">
				Validation Rules
			</th>
		</tr>
	</tfoot>
</table>
<?php
} else { // se retornou falso
	echo('<h3>Houve um erro ao verificar os custom posts, já configurou o acesso?</h3>');
}
include SSW_WPRDI_PATH."/views/template/footer.php";
?>