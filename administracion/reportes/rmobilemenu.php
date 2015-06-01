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
$RootMenu->AddMenuItem(50, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("50", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "gestif3n_campaf1a_x_programa_open_exedsmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(51, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("51", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "gestif3n_campaf1a_x_asesor_open_exedsmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(56, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("56", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "gestif3n_detalle_de_campaf1a_x_asesor_open_exedsmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(62, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("62", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "actualizacif3n_x_asesor_x_campaf1asmry.php", -1, "", TRUE, FALSE);
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
