<!--##session report_mobile_menu##-->
<?php
	ewr_Header(TRUE);
	$conn = ewr_Connect();
	$ReportLanguage = new crLanguage();
<!--## if (bSecurityEnabled) { ##-->
	// Security
	$Security = new crAdvancedSecurity();
	if (!$Security->IsLoggedIn()) $Security->AutoLogin();
	<!--## if (bUserLevel) { ##-->
	$Security->LoadUserLevel(); // Load User Level
	<!--## } ##-->
<!--## } ##-->
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $ReportLanguage->Phrase("MobileMenu") ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo ewr_jQueryFile("jquery.mobile-%v.min.css") ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo EWR_PROJECT_STYLESHEET_FILENAME ?>" />
<link rel="stylesheet" type="text/css" href="<!--##=ew_GetFileNameByCtrlID("ewrmobile.css")##-->" />
<script type="text/javascript" src="<?php echo ewr_jQueryFile("jquery-%v.min.js") ?>"></script>
<script type="text/javascript">
	//$(document).bind("mobileinit", function() {
	//	jQuery.mobile.ajaxEnabled = false;
	//	jQuery.mobile.ignoreContentEnabled = true;
	//});
</script>
<script type="text/javascript" src="<?php echo ewr_jQueryFile("jquery.mobile-%v.min.js") ?>"></script>
<!--##=SYSTEMFUNCTIONS.CharSet()##-->
</head>
<body>
<div data-role="page">
	<div data-role="header">
		<h1><?php echo $ReportLanguage->ProjectPhrase("BodyTitle") ?></h1>
	</div>
	<div data-role="content">
<?php $RootMenu = new crMenu("RootMenu", TRUE); ?>
<!--##include rpt-phpcommon.php/render-menu##-->
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>
<?php
	 // Close connection
	$conn->Close();
?>
<!--##/session##-->