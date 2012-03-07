<script type="text/javascript">


	function start_inplace_editor(){
		$$('span.inPlaceEdit').each(function(e) {
			if ( !e.hasClassName('__inplace_editor__') ){
				var id 		= e.id.split('_')[1];
				new Ajax.InPlaceEditor(e, base_url+'mod_newsletters/groups/edit', {
				submitOnBlur: true,
				//okButton: true,
				
				//okText: '<?php __e('save'); ?>',
				//cancelText: '<?php __e('cancel'); ?>',
				savingText: '<?php __e('saving...'); ?>',
				clickToEditText:'<?php __e('click to edit'); ?>',
				
				//hoverClassName: 'editor_hoverClassName',
				//highlightcolor: '#ffffff',
				
				cancelControl:'button',
				ajaxOptions: {method: 'post'},
				onComplete: function(t) {
					
					}
				});
				
				e.addClassName('__inplace_editor__');
			}
			
		});
		
	}


Ext.BLANK_IMAGE_URL = '<?php echo $html->url("/{$this->plugin}/js/ext-2.0.1/resources/images/default/s.gif") ?>';

Ext.onReady(function(){

	var getnodesUrl = '<?php echo $html->url("/{$this->plugin}/groups/getnodes/") ?>';
	var reorderUrl = '<?php echo $html->url("/{$this->plugin}/groups/reorder/") ?>';
	var reparentUrl = '<?php echo $html->url("/{$this->plugin}/groups/reparent/") ?>';
	
	var Tree = Ext.tree;
	
	var tree = new Tree.TreePanel({
		el:'tree-div',
		autoScroll:true,
		animate:true,
		enableDD:true,
		containerScroll: true,
		rootVisible: true,
		loader: new Ext.tree.TreeLoader({
			dataUrl:getnodesUrl
		})
	});
	
	var root = new Tree.AsyncTreeNode({
		text:'<?php __e('Groups'); ?>',
		draggable:false,
		id:'root'
	});

	tree.setRootNode(root);
	
	var oldPosition = null;
	var oldNextSibling = null;
	
	tree.on('startdrag', function(tree, node, event){
		oldPosition = node.parentNode.indexOf(node);
		oldNextSibling = node.nextSibling;
	});
	
	tree.on('movenode', function(tree, node, oldParent, newParent, position){
	
		if (oldParent == newParent){
			var url = reorderUrl;
			var params = {'node':node.id, 'delta':(position-oldPosition)};
		} else {
			var url = reparentUrl;
			var params = {'node':node.id, 'parent':newParent.id, 'position':position};
		}
		
		tree.disable();
		
		Ext.Ajax.request({
			url:url,
			params:params,
			success:function(response, request) {
				if (response.responseText.charAt(0) != 1){
					request.failure();
				} else {
					tree.enable();
				}
				start_inplace_editor();
			},
			failure:function() {
				tree.suspendEvents();
				oldParent.appendChild(node);
				if (oldNextSibling){
					oldParent.insertBefore(node, oldNextSibling);
				}
				
				tree.resumeEvents();
				tree.enable();
				
				alert("Oh no! Your changes could not be saved!");
			}
		
		});
	
	});
	
	tree.on('click', function(){
		start_inplace_editor();
	} );
	
	tree.render();
	root.expand();
	

});

</script>

<div id="tree-div"
	style="height: 400px;" align="left"></div>
