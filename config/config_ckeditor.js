/*
 Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */
CKEDITOR.editorConfig = function(config) {
    config.font_names = 'Verdana';
    config.toolbar = 'maTool';
    config.toolbar_maTool =
        [
            { name: 'clipboard', items : ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo']},
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ]},
            { name: 'paragraph', items : ['NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl']},
            { name: 'links', items : ['Link','Unlink']},
            { name: 'insert', items : ['Image','Flash','Table','HorizontalRule','SpecialChar','Iframe']},
            { name: 'styles', items : ['Format', 'Font', 'FontSize']},
            { name: 'colors', items : ['TextColor', 'Source']}
        ];

    config.enterMode = CKEDITOR.ENTER_BR;
    config.shiftEnterMode = CKEDITOR.ENTER_BR;

    config.colorButton_colors = '373243,d44b28,643ebf,2d89ef,b6086e,bd921e,bd1e4a,009719,373259,121773';
};