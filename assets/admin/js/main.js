/** TINY MCE **/
$('textarea[data-editor]').each(function(){
	var $this = $(this),
	theme = $this.data('theme') || 'advanced';

	$this.tinymce(
	{
			// Location of TinyMCE script
			script_url : config.base + 'theme/admin/js/vendor/tiny_mce/tiny_mce.js',

			// General options
			theme : theme,
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			// template_replace_values : {
			// 	username : "Some User",
			// 	staffid : "991234"
			// }
		});

})

/** Live Binding **/
$('[data-live]').each(function(){
	var $this = $(this),
	defaultVal = $this.text(), 
	selector = $this.data('live'),
	tmpl = $this.data('tmpl'),
	$selector = $(selector);

	$selector.keyup(function(e){

		var val = $.trim($(this).val());

		if(val != ''){
			val = tmpl.replace(/\%/, val);

			$this.text(val);
		}else{
			$this.text(defaultVal);
		}
	}) 
})


$('[data-filter]').each(function(){
	var $this = $(this),
		filterExp = $.trim( $this.data('filter')  ),
		filter = $.trim( filterExp.split('|')[1] ),
		selector = $.trim( filterExp.split('|')[0] ),
		$target = $(selector);

		console.log(filterExp);

		$target.keyup(function(){

			var val = $.trim ( $(this).val() );

			if(val !== ''){

				$this.val( filters[filter](val) );

			}else{

			}

		})


})


/**  Form Validation **/
$('form.validate').validate();