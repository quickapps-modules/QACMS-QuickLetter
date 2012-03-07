<h2 style="margin: 0px;" id="news_preview_title"><?php e($news['News']['title']); ?></h2>
<h3 style="font-style: italic; margin: 0px;" id="news_preview_subtitle"><?php e($news['News']['titleAlias']); ?></h3>
<br />
<span style="font-style: italic;" id="news_preview_header"><?php e($news['News']['introText']); ?></span>
<hr />
<br />
<span id="news_preview_body"><?php e($news['News']['fullText']); ?></span>
<input
	type="hidden" id="news_id" value="<?php e($news['News']['id']); ?>" />
