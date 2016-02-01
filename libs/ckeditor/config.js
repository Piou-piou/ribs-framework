/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.editorConfig = function(config) {
	config.resize_enabled = true;
	config.resize_maxWidth = 1130;
	config.width = 1130;
	config.height = 600;
	
	config.font_names = 'Verdana';
	config.toolbar = 'maTool';
	config.toolbar_maTool =
	[
		{ name: 'clipboard', items : ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo']},
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ]},
		{ name: 'paragraph', items : ['NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl']},
		{ name: 'links', items : ['Link','Unlink','Anchor']},
		{ name: 'insert', items : ['Image','Flash','Table','HorizontalRule','SpecialChar','PageBreak','Iframe']},
		{ name: 'styles', items : ['Styles','Format']},
		{ name: 'colors', items : ['TextColor','BGColor', 'Source']}
	];
	
	config.enterMode = CKEDITOR.ENTER_BR; 
	config.shiftEnterMode = CKEDITOR.ENTER_BR;
	
	config.colorButton_colors = '373243,d44b28,643ebf,2d89ef,b6086e,bd921e,bd1e4a,009719,373259,121773';
	
	

	
	/*toobar au complet*/
	//config.toolbar_Full =
	//[
	//	{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
	//	{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	//	{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
	//	{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
	//		'HiddenField' ] },
	//	'/',
	//	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
	//	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
	//	'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	//	{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
	//	{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
	//	'/',
	//	{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
	//	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
	//	{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
	//];
	
};
