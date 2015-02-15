<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg7.php" ?>
<?php include_once "phprptinc/ewmysql.php" ?>
<?php include_once "phprptinc/ewrfn7.php" ?>
<?php include_once "phprptinc/ewrusrfn.php" ?>
<?php
	ewr_Header(TRUE);
	$conn = ewr_Connect();
	$ReportLanguage = new crLanguage();
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $ReportLanguage->Phrase("MobileMenu") ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo ewr_jQueryFile("jquery.mobile-%v.min.css") ?>">
<link rel="stylesheet" type="text/css" href="<?php echo EWR_PROJECT_STYLESHEET_FILENAME ?>">
<link rel="stylesheet" type="text/css" href="phprptcss/ewrmobile.css">
<script type="text/javascript" src="<?php echo ewr_jQueryFile("jquery-%v.min.js") ?>"></script>
<script type="text/javascript">

	//$(document).bind("mobileinit", function() {
	//	jQuery.mobile.ajaxEnabled = false;
	//	jQuery.mobile.ignoreContentEnabled = true;
	//});

</script>
<script type="text/javascript" src="<?php echo ewr_jQueryFile("jquery.mobile-%v.min.js") ?>"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="generator" content="PHP Report Maker v7.0.0">
</head>
<body>
<div data-role="page">
	<div data-role="header">
		<h1><?php echo $ReportLanguage->ProjectPhrase("BodyTitle") ?></h1>
	</div>
	<div data-role="content">
<?php $RootMenu = new crMenu("RootMenu", TRUE); ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(40, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("40", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "estado_de_campaf1as_x_programa_x_campaf1asmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(41, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("41", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "asignacif3nsmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(43, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("43", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "detalle_de_contacto_atendidosmry.php?cmd=resetdrilldown", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(46, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("46", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "estado_de_campaf1as_x_asesorsmry.php", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>
<?php

	 // Close connection
	$conn->Close();
?>
