<table width="100%" id="table_list" class="tablekit">
	<thead>
		<tr>
			<th width="2%" class="nosort"><input type="checkbox" id="checkAll" onClick="chkAll(this); unselect('radio');"></th>
			<th width="15%" align="left" class="<?php __e("date-iso"); //es: date-eu ?>"><?php __e("Sent Date"); ?></th>
			<th width="37%" align="left" class="text"><?php __e("Message Title"); ?></th>
			<th width="22%" align="left" class="text"><?php __e("Groups"); ?></th>
			<th width="9%" align="left" class="number"><?php __e("Progress"); ?></th>
			<th width="15%" align="left" class="text"><?php __e("Status"); ?></th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td id="list-alert" colspan="6" style="display: none;" align="center">
			<?php __e("No items that match your filter settings were found."); ?>
			</td>
		</tr>
		<?php
		if ( count($results) > 0){
			foreach ($results as $queue) {

				?>
		<tr class="content" style="<?php echo ($queue['Queue']['status'] == 'Stalled') ? 'background-color:#FFD5D5;' : (    ($queue['Queue']['status'] == 'Paused') ? 'background-color:#FFF8D5;': ''  ); ?>">
			<td align="center">
				<?php if ( $queue['Queue']['status'] != 'Stalled' && $queue['Queue']['status'] != 'Paused' ) { ?>
				<input type="checkbox" name="data[Queue][id][]" id="queue_checkbox" value="<?php e($queue['Queue']['id']); ?>" onclick="unselect('radio'); " />
				<?php } else { ?>
				<input type="radio" name="data[Queue][id]" id="queue_radio"	value="<?php e($queue['Queue']['id']); ?>"	onclick="unselect('checkbox');">
				<?php } ?>
			</td>
			<td align="left"><?php echo date(  _e('Y-m-d H:i:s'), strtotime($queue['Queue']['date'])  ); ?></td>
			<td align="left"><a	href="<?php echo $html->url("/{$this->plugin}/messages/edit/{$queue['Message']['id']}"); ?>"><?php echo $queue['Message']['name']; ?></a></td>
			<td align="left"><?php echo implode(',', Set::extract('/Group/name', $queue)); ?></td>
			<td align="left"><?php echo $queue['Queue']['percentage']; ?> %</td>
			<td align="left"><?php __e($queue['Queue']['status']); echo ( $queue['Queue']['status'] == 'Complete') ? " ({$queue['Queue']['total']})" : ""; ?></td>
		</tr>
		<?php
			}

		}else{
			?>
		<tr>
			<td align="center" colspan="6"><br />
			<?php __e("You have no queues."); ?><br />
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
			<form action="" method="post"><?php __e("Rows per Page"); ?>: <input
				name="rows_per_page" type="text" id="rows_per_page"
				value="<?php echo Configure::read('rows_per_page') ?>" size="3" /></form>
			</td>
		</tr>

	</tfoot>
</table>


<script type="text/javascript">
	TableKit.unloadTable('table_list');
	TableKit.Sortable.init('table_list');
</script>

<?php if ( count($stalled) > 0 && !isset($iframe_action) ) { ?>

	<div id="queue_dialogue" class="dialogue-wrap" style="display: none;">
		<div class="dialogue">
			<div class="dialogue-content" style="width: 670px">
				<div class="wrap">
					<div id="queue_dialogue_wrap">
						<?php 
						foreach ( $stalled as $queue ){
							echo sprintf(_e("It appears as though queue id <b>%s</b> has stalled. Please resume sending or cancel this message.<br/>"), $queue['Queue']['id']) ;
						}
						?>
					</div>
					<fieldset class="nopad">
						<button type="button" class="primary_lg right" onclick="Messaging.kill('queue_dialogue');"><?php __e("Close"); ?></button>
					</fieldset>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		Messaging.dialogue('queue_dialogue');
	</script>
<?php } ?>