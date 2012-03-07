function send_message(type){
	tinyMCE.triggerSave();

	var allNodes = Form.serialize('send_form');
	new Ajax.Request	(	base_url+'mod_newsletters/messages/send', {
			method: "post",
			parameters: allNodes+'&data[Message][send_type]='+type,
			onSuccess: function (t){
				if ( type == 'test' ) {
					msg = __('Test sent!');									
				} else if ( type == 'draft' ){
					$('msg_draft_btn').hide();
					window.location.href = base_url+'mod_newsletters/messages/edit/'+t.responseText;
					msg = __("Draft saved!");	
				} else if( type == 'update' ){
					msg = __("Message updated!");
				} else if ( type == 'queue' ){
					msg = __("Sending Message...Redirecting in 3 secs");
				}
				
				Messaging.hello(msg, 2, false);
				if ( type == 'queue' ) {
					window.setTimeout('document.location.href= "'+t.responseText+'"; ', 3000);
				} else {
					window.setTimeout("Messaging.kill('')", 1000);
				}
			},
			onFailure:function (t){
				$('message_edit_dialogue_wrap').innerHTML = t.responseText;
				Messaging.dialogue('message_edit_dialogue');
			}
	});
	return;
}

function message_preview(){
	tinyMCE.triggerSave();
	var allNodes = Form.serialize('send_form');

	new Ajax.Updater( 'message_edit_dialogue_wrap', base_url+'mod_newsletters/messages/preview', {
				method: "post",
				evalScripts:true,
				parameters: allNodes,
				onComplete: function(){
					Messaging.dialogue('message_edit_dialogue');
				}
			} 
	);		
}

function chkAll(el) {
	if (el.checked==true){ c = true; } else { c = false; }
	$$( 'input[type="checkbox"]' ).each(function(e){e.checked=c;});
}

function actions_select(action){

		count_selected = 0;
		$$( 'input[type="checkbox"]' ).each(function(e){
			if ( e.checked == true && !isNaN(e.value) ){ count_selected = count_selected+1; }
		} );

		if ( parseInt(action) != 0 && count_selected > 0){
		for(var i=0; i < $('actions_select').options.length; i++){
			if($('actions_select').options[i].selected){
				selected = i;
			}
		}
		
		Messaging.confirm(__('Confirm this action: ')+$('actions_select').options[selected].getAttribute('text')+'?', "actions_select_exe('"+action+"')");
	}
	$('actions_select').options[0].selected = true;
}

function actions_select_exe(action){
		var selected = "";
		$$( 'input[type="checkbox"]' ).each(function(e){
			if ( e.checked == true && !isNaN(e.value) ){ selected = selected+'&data[Items][id][]='+e.value; }
		} );
		
		if ( selected != "" ) {
		Messaging.hello(__("Processing..."), 1, false);
			new Ajax.Request	( base_url+'mod_newsletters/'+action, {
									method: "post",
									parameters: selected,
									evalScripts: true,
									onComplete: function(){
										render_list();
										Messaging.hello(__('Processing...done'), 2, false);
										window.setTimeout("Messaging.kill('')", 1000);
									}
								});
		}
}

function render_list(){
	new Ajax.Updater	('items_list', url, {
							method: 'post',
							evalScripts: true,
							parameters: 'data[act]=render_items_list'
						});
}


/* update template content */
function update_template(form_id){
	Messaging.hello(__('Saving data...'), 1, false);
	tinyMCE.triggerSave();
	var params = Form.serialize(form_id);
	new Ajax.Request	(	base_url+'mod_newsletters/templates/edit', {
							method: "post",
							parameters: params,
							onSuccess: function (){
								Messaging.hello(__('Saving data...done'), 2, false);
								window.setTimeout("Messaging.kill('')", 1000);
							},
							onFailure: function (t){
								window.setTimeout("Messaging.kill('')", 1000);
								$('template_errors_dialogue_wrap').innerHTML = t.responseText;
								Messaging.dialogue('template_errors_dialogue');
							}
						});

}
/* edit form*/
function edit_template(id){
	new Ajax.Updater	(	'template_edit_dialogue_wrap', base_url+'mod_newsletters/templates/edit/'+id, {
							method: "get",
							evalScripts: true,
							onSuccess: function (t){
								window.setTimeout("Messaging.kill('')", 1000);
								Messaging.dialogue('template_edit_dialogue');
							},
							onFailure: function (t){
							}
						});

}


/* save as template*/
function save_template(){
	tinyMCE.triggerSave();
	new Ajax.Updater( 'message_edit_dialogue_wrap', base_url+'mod_newsletters/templates/add/1', { 
		method: "post",
		evalScripts:true,
		parameters: "data[Template][content]="+encodeURIComponent($F('html_message')),
		onComplete: function(){
			Messaging.dialogue('message_edit_dialogue');
		}
	} );	
}

function save_template_exe(form) {
	Messaging.hello(__('Saving template...'), 1, false);
	tinyMCE.triggerSave();

	var params = Form.serialize(form);
	new Ajax.Request	(	base_url+'mod_newsletters/templates/add', {
							method: "post",
							parameters: params,
							onSuccess: function (){
								Messaging.hello(__('Saving template...done'), 1, false);
								window.setTimeout("Messaging.kill('')", 1000);
							},
							onFailure: function (t){
								Messaging.kill('');
								$('add_template_errors_dialogue_wrap').innerHTML = t.responseText;
								Messaging.dialogue('add_template_errors_dialogue')
							}
						});
}

function html2plain(){
	tinyMCE.triggerSave();
	if ( !$('html_message').value.blank() ) {
		new Ajax.Request	(	base_url+'mod_newsletters/messages/html2plain', {
								method: "post",
								parameters: $('html_message').serialize(),
								onComplete: function(t) { 
									$('plain_message').value = t.responseText;
								}
							});
	}
}


function add_list(){
	new Ajax.Request	(	base_url+'mod_newsletters/groups/add', {
							method: "post",
							parameters: 'data[Group][name]='+$F('addList_name')+'&data[Group][parent_id]='+$F('addList_parentList'),
							evalScripts: true,
							onComplete: function() { 
								if ( $('lists_checkboxes') ) { render_lists('lists_checkboxes', 'checkboxes'); }
								if ( $('lists_select') ) { render_lists('lists_select', 'selectbox');  }
								render_lists('groups_list', 'table');
								
							}
						});
}

function render_lists(target, type){
	new Ajax.Updater	(target, base_url+'mod_newsletters/groups/render_list/', {
							method: "post",
							evalScripts: true,
							parameters: 'data[render_type]='+type
						});

}

function optionsDisplay(selected){
	['smtpOptions', 'gmailOptions'].each( function(s, index){ $(s).hide(); } );
	switch (selected) {
		case "smtp":
			$('smtpOptions').show();
		break;
		case "gmail":
			$('gmailOptions').show();
		break;
	}
}


function optionsAuth(selected){
	['authUsername', 'authPassword'].each( function(s, index){ if ( selected == 'false') { $(s).hide(); } else { $(s).show(); } } );

}

function save_setup(form){
	Messaging.hello(__('Saving data...'), 1, false);
	var params = Form.serialize(form);
	new Ajax.Request	(	url, {
							method: "post",
							parameters: params,
							onSuccess: function (){
								Messaging.hello(__('Saving data...done'), 2, false);
								window.setTimeout("Messaging.kill('')", 1000);
							},
							onFailure: function (t){
								Messaging.kill('');
								$('setup_errors_dialogue_wrap').innerHTML = t.responseText;
								Messaging.dialogue('setup_errors_dialogue');
							}
						});
}

function unselect(type){
	$$('input[type='+type+']').each( function(e){ e.checked = 0; } );
	var show = ( type == 'radio' ) ? 'checkbox' : 'radio';
	$(type+'_actions').hide();
	$(show+'_actions').show();
}

function radio_queue_actions_select(selected){
	if ( parseInt(selected) != 0){
		$$('input[type=radio]').each( function(e){  if (e.checked  == true){ qid = e.value; }  } );
		window.location.href= base_url+'mod_newsletters/queue/index/'+qid+'/'+selected;
	}
}

function delete_list_form(list_id){
	var myAjax = new Ajax.Updater('groups_list_dialogue_wrap', base_url+'mod_newsletters/groups/delete/1', {
		method: 'post',
		parameters: 'data[Group][id]='+list_id,
		evalScripts: true,
		onComplete: function() {
			Messaging.dialogue('groups_list_dialogue');
		}
	});
}

function delete_group(form_id){
	Messaging.hello(__('Deleting list...'), 1, false);
	
	var allNodes = Form.serialize(form_id);
	var myAjax = new Ajax.Request(base_url+'mod_newsletters/groups/delete', {
		method: 'post',
		parameters: allNodes,
		onSuccess: function() {
			Messaging.hello(__('Deleting list...done'), 2, false);
			window.setTimeout("Messaging.kill('')", 1000);
			window.setTimeout("$('groups_list_dialogue').fade();", 1500);
			
		},
		onComplete: function() { render_lists('groups_list', 'table'); }
	});
}


function add_user(form_id){
	Messaging.hello(__('Saving user...'), 1, false);
	var params = Form.serialize(form_id);
	new Ajax.Request	(	url, {
							method: "post",
							parameters: params,
							onSuccess: function (){
								Messaging.hello(__('Saving user...done'), 2, false);
								window.setTimeout("Messaging.kill('')", 1000);
							},
							onFailure: function (t){
								Messaging.kill('');
								$('users_dialogue_wrap').innerHTML = t.responseText;
								Messaging.dialogue('users_dialogue');
							}
						});
}


function delete_field(field_id){
	Messaging.confirm(__('Please confirm that you wish to delete the following custom field. Please note that if you delete this custom field, it will remove all pertaining custom user data as well.'), "delete_field_exe('"+field_id+"')");
}

function delete_field_exe(field_id){
	Messaging.hello(__('Deleting field...'), 1, false);
	new Ajax.Request	( url, {
							method: "post",
							parameters: 'act=delete_cfield&id='+field_id,
							onSuccess: function (){
								Messaging.hello(__('Deleting field...done'), 2, false);
								window.setTimeout("Messaging.kill('')", 1000);
							},
							onComplete: function (){ render_fields_list(); }
						});
}

function add_field(form_id, update){
	Messaging.hello(__('Saving field...'), 1, false);
	$(form_id+'Errors').hide();
	var params = Form.serialize(form_id);
	new Ajax.Request	(	url, {
							method: "post",
							parameters: params,
							onSuccess: function (){
								
								if ( update == false ){
									render_fields_list();
									$('addFieldContainer').hide();
								}
									
								Messaging.hello(__('Saving field...done'), 2, false);
								window.setTimeout("Messaging.kill('')", 1000);
							},
							onFailure: function (t){
								Messaging.kill('');
								$(form_id+'Errors').innerHTML = t.responseText;
								$(form_id+'Errors').show();
								new Effect.Highlight(form_id+'Errors', { startcolor: '#812E04', endcolor: '#CC3300', duration:0.5 });
							}
						});
}


function reorder_cfields(form_id){
	Messaging.hello(__('Reordering fields...'), 1, false);
	var params = Form.serialize(form_id);
	new Ajax.Request	(	url, {
							method: "post",
							parameters: params,
							onSuccess: function (){
								render_fields_list();
								Messaging.hello(__('Reordering fields...done'), 2, false);
								window.setTimeout("Messaging.kill('')", 1000);
							}
						});
}

function render_fields_list(){
	new Ajax.Updater	(	'fields_container', url, {
							method: "post",
							evalScripts: true,
							parameters: 'act=render_fields_list'
						});
}


function move_list(from, to){
	new Ajax.Request	(	url, {
							method: "post",
							parameters: 'act=move_list&from='+from+'&to='+to,
							onSuccess: function (){
								render_list();
								render_lists('lists_select', 'selectbox');
							}
						});
}






















/* News Importing */
function import_news(){
	var myAjax = new Ajax.Updater('message_edit_dialogue_wrap', base_url+'mod_newsletters/messages/import_news', {
		method: 'get',
		evalScripts: true,
		onComplete: function() {
			Messaging.dialogue('message_edit_dialogue');
		}
	});
}

function render_news_preview(news_id){
	if ( !isNaN(news_id) && news_id > 0){
		var myAjax = new Ajax.Updater('news_preview', base_url+'mod_newsletters/messages/news_preview/'+news_id, {
			method: 'get',
			evalScripts: true
		});
	}
}

function import_news_content(){
	if ( !$('news_preview').innerHTML.blank() ) {
		if ( !$('news_preview_title').innerHTML.blank() )
			$('subject').value = $('news_preview_title').innerHTML;
		
		var content =  $('news_preview').innerHTML+"<br/>"+__("Full version:")+" <a href=\"http://[DOMAIN]/news/details/"+$F('news_id')+"\">http://[DOMAIN]/news/details/"+$F('news_id')+"</a>";
		$('plain_message').value = content.stripTags();
		tinyMCE.get('html_message').setContent(content);
	}
}
/* END - News Importing */


/* Articles Importing */
function import_article(){
	var myAjax = new Ajax.Updater('message_edit_dialogue_wrap', base_url+'mod_newsletters/messages/import_articles', {
		method: 'get',
		evalScripts: true,
		onComplete: function() {
			Messaging.dialogue('message_edit_dialogue');
		}
	});
}

function render_article_preview(post_id){
	if ( !isNaN(post_id) && post_id > 0){
		var myAjax = new Ajax.Updater('article_preview', base_url+'mod_newsletters/messages/article_preview/'+post_id, {
			method: 'get',
			evalScripts: true
		});
	}
}

function import_article_content(){
	if ( !$('article_preview').innerHTML.blank() ) {
		if ( !$('article_preview_title').innerHTML.blank() )
			$('subject').value = $('article_preview_title').innerHTML;
		
		var content = $('article_preview').innerHTML+"<br/>"+__("Full version:")+" <a href=\"http://[DOMAIN]/posts/details/"+$F('post_id')+"\">http://[DOMAIN]/posts/details/"+$F('post_id')+"</a>";
		$('plain_message').value = content.stripTags();
		tinyMCE.get('html_message').setContent(content);
	}
}

/* END - Articles Importing */


function export_csv(){
	var allNodes = Form.serialize('exportForm') ;
	new Ajax.Request	(	 base_url+'mod_newsletters/users/export/', {
							method: 'post',
							parameters: allNodes,
							evalScripts: true,
							onSuccess: function() {
								window.location.href = base_url+'mod_newsletters/users/export/1';

							},
							onFailure:function (t){
								Messaging.window(t.responseText);
							}
						});
}


function import_csv(path, next_path){
	var allNodes = ( $('importForm')  ) ?  Form.serialize('importForm') : false;
	new Ajax.Request	(	 base_url+'mod_newsletters/users/import/'+path, {
							method: 'post',
							parameters: allNodes,
							evalScripts: true,
							onSuccess: function() {
								if ( next_path ){
									window.location.href= base_url+'mod_newsletters/users/import/'+next_path;
								}
							},
							onFailure:function (t){
								Messaging.window(t.responseText);
							}
						});
	
}


function reorder_cfieds(){
	Messaging.hello(__("Reordering fields..."), 1, true);
	var allNodes = Form.serialize('cfieldsFrom');
	new Ajax.Updater	(	'items_list', base_url+'mod_newsletters/cfields/reorder/', {
							method: 'post',
							parameters: allNodes,
							evalScripts: true,
							onComplete: function() {
								Messaging.hello(__('Reordering fields...done!'), 2, true);
							}
						});

}


function cfield_form(id){
	Messaging.hello(__("Loading..."), 1, true);
	var url = ( !id ) ? 'add/' : 'edit/'+id;
	new Ajax.Updater	(	'formContainer', base_url+'mod_newsletters/cfields/'+url, {
							method: 'get',
							evalScripts: true,
							onComplete: function() {
								$('formContainer').show();
								Messaging.hello(__('Loading...done'), 2, true);
							}
						});

}

function add_cfield(update_id){
	msg = (!update_id) ? __('Creating custom field...') : __('Updating custom field...');
	allNodes = Form.serialize('cfieldForm');
	Messaging.hello(msg, 1, true);
	method = (!update_id) ?  'add' : 'edit/'+update_id;
	new Ajax.Request	( base_url+'mod_newsletters/cfields/'+method, {
							method: 'post',
							parameters: allNodes,
							onSuccess: function(t) {
								$('items_list').innerHTML = t.responseText;
								Messaging.hello(msg+__('done'), 2, true);
							},
							onFailure:function (t){
								Messaging.window(t.responseText);
							}							
						});

}

