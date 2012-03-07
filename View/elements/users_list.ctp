<table width="100%" id="table_list" class="tablekit">
	<thead>
		<tr>
			<th width="2%" align="center" class="nosort"><input type="checkbox"
				id="checkAll" onClick="chkAll(this);"></th>
			<th width="24%" align="left" class="text"><?php __e("Name"); ?></th>
			<th width="37%" align="left" class="email"><?php __e("E-Mail Address"); ?></th>
			<th width="19%" align="left" class="text"><?php __e("Lists"); ?></th>
			<th width="7%" align="center" class="text"><?php __e("Status"); ?></th>
			<th width="11%" align="center"
				class="<?php __e("date-iso"); //es: date-eu ?>"><?php __e("Signup Date"); ?></th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td id="list-alert" colspan="6" style="display: none;" align="center">
			<?php __e("No items that match your filter settings were found."); ?>
			</td>
		</tr>
		<?php
		if ( count($results) > 0){//mostrar si hay registros
			foreach ($results as $user) {
				?>
		<tr
			class="content <?php echo $user['User']['status'] == 0 ? 'inactive' : 'active'; ?>">
			<td align="center"><input type="checkbox" name="data[User][id][]"
				value="<?php e($user['User']['id']); ?>" /></td>
			<td align="left"><a
				href="<?php echo $html->url("/{$this->plugin}/users/edit/{$user['User']['id']}"); ?>"><?php e($user['User']['name']); ?></a></td>
			<td align="left"><a
				href="<?php echo $html->url("/{$this->plugin}/users/edit/{$user['User']['id']}"); ?>"><?php e($user['User']['email']); ?></a></td>
			<td align="left"><?php echo implode(", ", Set::extract("/name", $user['Group']) ); ?>
			</td>
			<td align="center">
			<?php
				switch ($user['User']['status']):
					case 0: default:
						echo $html->image("0_ico.gif", array('border' => 0) );
					break;
			
					case 1:
						echo $html->image("1_ico.gif", array('border' => 0) );
					break;
				endswitch;
			 ?>
			</td>
			<td align="center"><a
				href="<?php echo $html->url("/{$this->plugin}/users/edit/{$user['User']['id']}"); ?>"><?php e(date(_e('Y-m-d H:i:s'), strtotime($user['User']['created']) ) ); ?></a></td>
		</tr>
		<?php
			}

		}else{//si no hay registros que mostrar:
			?>
		<tr>
			<td align="center" colspan="6"><br />
			<?php __e("You have no users."); ?><br />
			</td>
		</tr>
		<?php }?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="6" align="center"><span class="paginator"> <?php $paginator->options( array( 'url'=> $this->passedArgs ) ); ?>
			<?php echo $paginator->prev('« ', null, null, array('class' => 'disabled') ); ?>
			<?php echo $paginator->numbers( array('separator' => ' ') ); ?> <?php echo $paginator->next(' »', null, null, array('class' => 'disabled')); ?>
			</span></th>
		</tr>

		<tr>
			<td colspan="6" align="center">
			<form action="" method="post"><?php __e("Rows per Page"); ?>: 
				<input name="rows_per_page" type="text" id="rows_per_page" value="<?php echo Configure::read('rows_per_page') ?>" size="3" />
			</form>
			</td>
		</tr>
	</tfoot>
</table>

<script type="text/javascript">
	TableKit.unloadTable('table_list');
	TableKit.Sortable.init('table_list');
</script>
