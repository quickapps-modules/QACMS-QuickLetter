<h2 style="margin: 0px;" id="article_preview_title"><?php e($post['Post']['title']); ?></h2>
<hr />
<br />
<span id="article_preview_body"><?php e($post['Post']['content']); ?></span>
<input
    type="hidden" id="post_id" value="<?php e($post['Post']['id']); ?>" />
