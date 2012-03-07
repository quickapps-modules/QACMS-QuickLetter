<table width="90%" align="center" border="0" cellspacing="0"
	cellpadding="0">
	<tr>
		<td width="122" align="left"><b><?php __e("Availables Articles"); ?>:</b></td>
		<td width="508" align="left"><select name="article_select"
			id="article_select" onChange="render_article_preview(this.value);">
			<option value=""><?php __e('Select by Title'); ?></option>
			<?php foreach ( $posts as $post ){ ?>
			<option value="<?php e($post['Post']['id']); ?>"><?php e($post['Post']['title']); ?></option>
			<?php } ?>
		</select></td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left">&nbsp;</td>
	</tr>
	<tr>
		<td align="left"><b><?php __e("Article Preview"); ?>:</b></td>
		<td align="left">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="left">
		<div id="article_preview"
			style="width: 630px; height: 380px; overflow: auto; border: 1px solid #CCCCCC;"></div>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left"><br />
		<button onClick="import_article_content(); return false;"
			class="primary_lg"><?php __e('Import'); ?></button>
		</td>
	</tr>
</table>
