jQuery(document).ready(function() {

	var config = {
		toolbar:
		[
			['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-',
			    'Blockquote', '-',
			    'Styles'
			],    
			['JustifyLeft','JustifyCenter','JustifyRight']
		]
	} 
	
    config.stylesCombo_stylesSet = 'my_styles';
	
	jQuery('.ckedit').ckeditor(config)
				
});
