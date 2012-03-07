<div align="center" class="centermain"><!-- navigation bar -->
<table width="100%" class="navigation-menu" cellpadding="0"
	cellspacing="0" border="0">
	<tr>
		<td width="50%" align="left" valign="middle" class="left-col"><?php echo $html->bread_crumb(); ?>
		</td>

		<td align="right" valign="middle" class="right-col"><?php echo $this->element('nav_bar'); ?>
		</td>
	</tr>
</table>
<!-- end navigation bar -->



<div class="main">
<table width="100%">
	<tr>
		<td width="100%" align="left" valign="top"><?php echo $this->element('users_sub_nav'); ?>
		</td>
	</tr>

	<tr>
		<td align="left" valign="top">


		<div align="center" class="centermain">
			<div id="tabs">
				<div class="tab"><a href="#"><?php  __e("Import Mailing List"); ?></a></div>
			</div>

			<div class="module">
				<div class="module-head">&nbsp;</div>
					<div class="module-wrap">

					
						<?php 
							$errors = $session->read('Import.errors');
							$oks = $session->read('Import.oks');
							
							if ( count($errors) > 0 ) {
						?>
						
						<div style="border:1px solid #993300; background:#CC3300; color:#fff; text-align:left; padding:10px;">
							<b><?php printf(_("You have %s errors for review"), count($errors)); ?>:</b><br/><br/>
							<?php $i=0; foreach ( $errors as $error ) {$i++; ?>
								<?php echo "{$i}.&nbsp;&nbsp;{$error}<br/>"; ?>
							<?php } ?>
						</div>						
			
						<?php } if ( count($oks) > 0 ) { ?>
						<div style="border:1px solid #669900; background:#F0FFD1; text-align:left; padding:10px;">
							<b><?php printf(_("Successfully completed %s tasks"), count($oks)); ?>:</b><br/><br/>
							<?php $i=0; foreach ( $oks as $ok ) {$i++; ?>
								<?php echo "{$i}.&nbsp;&nbsp;{$ok}<br/>"; ?>
							<?php } ?>
						</div>
					<?php } ?>	
					
					
					<br/>
					<br/>
						<input type="button" class="primary_lg right" onclick="import_csv('finish', 'redirect');" value="<?php __e("Finish »"); ?>" />
						<?php if ( count($errors) > 0 ) { ?><input type="button" class="primary_lg right" onclick="window.location.href= base_url+'mod_newsletters/users/import/prepare';" value="<?php __e("« Try Again"); ?>" /><?php } ?>
						
					<br/>
					<br/>

					
					</div>
				<div class="module-footer">
					<div>&nbsp;</div>
				</div>
			</div>


		</div>
		</td>
	</tr>
</table>
</div>
</div>