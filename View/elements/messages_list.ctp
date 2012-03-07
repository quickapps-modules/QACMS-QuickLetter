<table width="100%" id="table_list" class="tablekit">
	<thead>
		<tr>
			<th width="2%" class="nosort"><input type="checkbox" id="checkAll"
				onClick="chkAll(this);"></th>
			<th width="11%" align="left"
				class="<?php __e("date-iso"); //es: date-eu ?>"><?php __e("Created"); ?></th>
			<th width="47%" align="left" class="text"><?php __e("Title"); ?></th>
			<th width="40%" align="left" class="text"><?php __e("Subject"); ?></th>
		</tr>
	</thead>

	<tbody>
	<?php
	if ( count($results) > 0){//mostrar si hay registros
		foreach ($results as $message) {
			?>
		<tr class="content">
			<td align="center"><input type="checkbox" name="data[Message][id][]"
				value="<?php e($message['Message']['id']); ?>" /></td>
			<td align="left"><a
				href="<?php echo $html->url("/{$this->plugin}/messages/edit/{$message['Message']['id']}"); ?>"><?php e(date(_e('Y-m-d H:i:s'), strtotime($message['Message']['created']) ) ); ?></a></td>
			<td align="left"><a
				href="<?php echo $html->url("/{$this->plugin}/messages/edit/{$message['Message']['id']}"); ?>"><?php e($message['Message']['name']); ?></a></td>
			<td align="left"><a
				href="<?php echo $html->url("/{$this->plugin}/messages/edit/{$message['Message']['id']}"); ?>"><?php e($message['Message']['subject']); ?></a></td>
		</tr>
		<?php
		}

	}else{//si no hay registros que mostrar:
		?>
		<tr>
			<td align="center" colspan="4"><br />
			<?php __e("You have no messages."); ?><br />
			</td>
		</tr>
		<?php }?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="4" align="center"><span class="paginator"> <?php $paginator->options( array( 'url'=> $this->passedArgs ) ); ?>
			<?php echo $paginator->prev('« ', null, null, array('class' => 'disabled') ); ?>
			<?php echo $paginator->numbers( array('separator' => ' ') ); ?> <?php echo $paginator->next(' »', null, null, array('class' => 'disabled')); ?>
			</span></th>
		</tr>

		<tr>
			<td colspan="4" align="center">
			<form action="" method="post"><?php __e("Rows per Page"); ?>: <input
				name="rows_per_page" type="text" id="rows_per_page"
				value="<?php echo Configure::read('rows_per_page'); ?>" size="3" />
			</form>
			</td>
		</tr>
	</tfoot>
</table>


<script type="text/javascript">
	TableKit.unloadTable('table_list');
	TableKit.Sortable.init('table_list');
</script>
