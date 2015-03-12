<!DOCTYPE html>
<html>
<head>
	<title><?php echo $ReportLanguage->ProjectPhrase("BodyTitle") ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php if (@$gsExport == "" || @$gsExport == "print" || @$gsExport == "email" && (@$giFcfChartCnt > 0 || @$gsEmailContentType == "url")) { ?>
<script type="text/javascript">

function ewr_GetScript(url) { document.write("<" + "script type=\"text/javascript\" src=\"" + url + "\"><" + "/script>"); }

function ewr_GetCss(url) { document.write("<link rel=\"stylesheet\" type=\"text/css\" href=\"" + url + "\">"); }
</script>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<script type="text/javascript">
if (!window.jQuery || !jQuery.fn.alert) ewr_GetCss("bootstrap/css/bootstrap.css");
<?php if (!@$gbDrillDownInPanel) { ?>
ewr_GetCss("<?php echo EWR_PROJECT_STYLESHEET_FILENAME ?>");
<?php if (ewr_IsMobile()) { ?>
ewr_GetCss("phprptcss/ewrmobile.css");
<?php } ?>
<?php } ?>
</script>
<?php if (ewr_IsMobile()) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php } ?>
<?php } else { ?>
<style type="text/css">
<?php $cssfile = (@$gsExport == "pdf") ? (EWR_PDF_STYLESHEET_FILENAME == "" ? EWR_PROJECT_STYLESHEET_FILENAME : EWR_PDF_STYLESHEET_FILENAME) : EWR_PROJECT_STYLESHEET_FILENAME ?>
<?php echo file_get_contents($cssfile) ?>
</style>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print" || @$gsExport == "email" && (@$giFcfChartCnt > 0 || @$gsEmailContentType == "url")) { ?>
<script type="text/javascript">
var EWR_LANGUAGE_ID = "<?php echo $gsLanguage ?>";
var EWR_DATE_SEPARATOR = "/" || "/"; // Default date separator
var EWR_DECIMAL_POINT = "<?php echo $EWR_DEFAULT_DECIMAL_POINT ?>";
var EWR_THOUSANDS_SEP = "<?php echo $EWR_DEFAULT_THOUSANDS_SEP ?>";
var EWR_DISABLE_BUTTON_ON_SUBMIT = true;
var EWR_IMAGES_FOLDER = "phprptimages/"; // Image folder
var EWR_LOOKUP_FILE_NAME = "ewrajax7.php"; // Lookup file name
var EWR_AUTO_SUGGEST_MAX_ENTRIES = <?php echo EWR_AUTO_SUGGEST_MAX_ENTRIES ?>; // Auto-Suggest max entries
var EWR_USE_JAVASCRIPT_MESSAGE = false;
<?php if (ewr_IsMobile()) { ?>
var EWR_IS_MOBILE = true;
<?php } else { ?>
var EWR_IS_MOBILE = false;
<?php } ?>
<?php if (EWR_MOBILE_REFLOW) { ?>
var EWR_MOBILE_REFLOW = true;
<?php } else { ?>
var EWR_MOBILE_REFLOW = false;
<?php } ?>
var EWR_PROJECT_STYLESHEET_FILENAME = "<?php echo EWR_PROJECT_STYLESHEET_FILENAME ?>"; // Project style sheet
var EWR_PDF_STYLESHEET_FILENAME = "<?php echo (EWR_PDF_STYLESHEET_FILENAME == "" ? EWR_PROJECT_STYLESHEET_FILENAME : EWR_PDF_STYLESHEET_FILENAME) ?>"; // Export PDF style sheet
var EWR_EXPORT_FILE_NAME = "";
</script>
<script type="text/javascript">if (!window.jQuery) ewr_GetScript("<?php echo ewr_jQueryFile("jquery-%v.min.js") ?>");</script>
<?php if (ewr_IsMobile()) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo ewr_jQueryFile("jquery.mobile-%v.min.css") ?>">
<script type="text/javascript">
if (!window._jQuery && window.jQuery && !window.jQuery.mobile) {
	jQuery(document).bind("mobileinit", function() {
		jQuery.mobile.ajaxEnabled = false;
		jQuery.mobile.ignoreContentEnabled = true;
	});
	ewr_GetScript("<?php echo ewr_jQueryFile("jquery.mobile-%v.min.js") ?>");
}
</script>
<?php } ?>
<script type="text/javascript" src="phprptjs/ewr7.js"></script>
<script type="text/javascript" src="phprptjs/ewrusrfn.js"></script>
<script src="<?php echo EWR_FUSIONCHARTS_FREE_JSCLASS_FILE ?>" type="text/javascript"></script>
<script type="text/javascript">
if (window._jQuery) ewr_Extend(jQuery);
if (window.jQuery && !jQuery.fn.alert) ewr_GetScript("bootstrap/js/bootstrap.min.js");		
</script>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript">
<?php echo $ReportLanguage->ToJSON() ?>
</script>
<?php } ?>
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo ewr_ConvertFullUrl("favicon.ico") ?>"><link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo ewr_ConvertFullUrl("favicon.ico") ?>">
<meta name="generator" content="PHP Report Maker v7.0.0">
</head>
<body>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<?php if (ewr_IsMobile()) { ?>
<div data-role="page">
	<div data-role="header">
		<a href="rmobilemenu.php"><?php echo $ReportLanguage->Phrase("MobileMenu") ?></a>
		<h1 id="ewPageTitle"></h1>
	</div>
<?php } ?>
<?php } ?>
<?php if (@!$gbSkipHeaderFooter) { ?>
<?php if (@$gsExport == "") { ?>
<div class="ewLayout">
<?php if (!ewr_IsMobile()) { ?>
	<!-- header (begin) --><!-- *** Note: Only licensed users are allowed to change the logo *** -->
	<div id="ewHeaderRow" class="ewHeaderRow"><img src="phprptimages/phprptmkrlogo7.png" alt="" style="border: 0;"></div>
	<!-- header (end) -->
<?php } ?>
<?php if (ewr_IsMobile()) { ?>
	<div data-role="content" data-enhance="false">
	<table id="ewContentTable" class="ewContentTable">
		<tr>
<?php } else { ?>
	<!-- content (begin) -->
	<table id="ewContentTable" class="ewContentTable">
		<tr>	
			<td class="ewMenuColumn">
<?php include_once "menu.php" ?>
			<!-- left column (end) -->
			</td>
<?php } ?>
			<!-- right column (begin) -->
			<td class="ewContentColumn">
				<p class="ewSiteTitle"><?php echo $ReportLanguage->ProjectPhrase("BodyTitle") ?></p>
<?php } ?>
<?php } ?>
