<?php
	include_once(ROOT.'libs/ckeditor/ckeditor.php');
	require_once(ROOT.'libs/ckfinder/ckfinder.php');
	$ckeditor = new CKEditor();
	$ckeditor->basePath	= WEBROOT.'libs/ckeditor/';
	CKFinder::SetupCKEditor( $ckeditor, WEBROOT.'libs/ckfinder/' );
?>