<!--##session common_config##-->
<!--##
	var bExport = IsExport();
	if (bExport) {
		sTmplExpStart = "<?php if (@$gsExport == \"\") { ?>";
		sTmplExpEnd = "<?php } ?>";
		sTmplHtmlExpStart = "<?php if (@$gsExport == \"\" || @$gsExport == \"print\") { ?>";
		sTmpHtmlExpElse = "<?php } else { ?>";
		sTmplHtmlExpEnd = "<?php } ?>";
		sTmplHtmlEmailExpStart = "<?php if (@$gsExport == \"\" || @$gsExport == \"print\" || @$gsExport == \"email\" && (@$giFcfChartCnt > 0 || @$gsEmailContentType == \"url\")) { ?>";
		sTmplHtmlEmailExpEnd = "<?php } ?>";
	} else {
		sTmplExpStart = "";
		sTmplExpEnd = "";
		sTmplHtmlExpStart = "";
		sTmpHtmlExpElse = "";
		sTmplHtmlExpEnd = "";
		sTmplHtmlEmailExpStart = "";
		sTmplHtmlEmailExpEnd = "";
	}
	sTmplSkipStart = "<?php if (@!$gbSkipHeaderFooter) { ?>";
	sTmplSkipEnd = "<?php } ?>";
	sDrillSkipStart = "<?php if (@!$gbDrillDownInPanel) { ?>"
	sDrillSkipEnd = "<?php } ?>";

	bUseEmailExport = UseEmailExport(); // Export to Email
	bUsePdfExport = UsePdfExport(); // Export PDF

	bUseJSTemplate = UseJSTemplate(); // Use JS Template

	bDisableProjectStyles = PROJ.GetV("DisableProjectStyles");
##-->
<!--##/session##-->

<!--##session header_top##-->
<!--## if (bUseEmailExport || bUsePdfExport) { ##-->
<?php if (@$gsExport == "email" || @$gsExport == "pdf") ob_clean(); ?>
<!--## } ##-->
<!--##
	if (!bGenCompatHeader) {
##-->
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $ReportLanguage->ProjectPhrase("BodyTitle") ?></title>
<!--##=SYSTEMFUNCTIONS.CharSet()##-->
<!--##
	}
##-->
<!--##=sTmplHtmlEmailExpStart##-->
<script type="text/javascript">
function ewr_GetScript(url) { document.write("<" + "script type=\"text/javascript\" src=\"" + url + "\"><" + "/script>"); }
function ewr_GetCss(url) { document.write("<link rel=\"stylesheet\" type=\"text/css\" href=\"" + url + "\" />"); }
</script>
<!--##=sTmplHtmlEmailExpEnd##-->
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<script type="text/javascript">
if (!window.jQuery || !jQuery.fn.alert) ewr_GetCss("bootstrap/css/bootstrap.css");
<!--## if (!bDisableProjectStyles) { ##-->
<?php if (!@$gbDrillDownInPanel) { ?>
ewr_GetCss("<?php echo EWR_PROJECT_STYLESHEET_FILENAME ?>");
<!--##include rpt-menuext.php/menuextcss##-->
<?php if (ewr_IsMobile()) { ?>
ewr_GetCss("<!--##=ew_FolderPath("_css")##-->/<!--##=ew_GetFileNameByCtrlID("ewrmobile.css", false)##-->");
<?php } ?>
<?php } ?>
<!--## } ##-->
</script>
<!--## if (!bDisableProjectStyles) { ##-->
<?php if (ewr_IsMobile()) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php } ?>
<!--## } ##-->
<!--##=SYSTEMFUNCTIONS.CSSFile()##-->
<?php } else { ?>
<style type="text/css">
<?php $cssfile = (@$gsExport == "pdf") ? (EWR_PDF_STYLESHEET_FILENAME == "" ? EWR_PROJECT_STYLESHEET_FILENAME : EWR_PDF_STYLESHEET_FILENAME) : EWR_PROJECT_STYLESHEET_FILENAME ?>
<?php echo file_get_contents($cssfile) ?>
</style>
<?php } ?>
<!--##=sTmplExpStart##-->
<!--##
    if (IsPopupCalendar()) {
##-->
<script type="text/javascript">
if (!window.Calendar) {
	ewr_GetCss("jscalendar/calendar.css");
	ewr_GetScript("jscalendar/calendar.min.js");
	ewr_GetScript("jscalendar/lang/calendar-en.js");
	ewr_GetScript("jscalendar/calendar-setup.js");
}
</script>
<!--##
    }
##-->
<!--##=sTmplExpEnd##-->
<!--##=sTmplHtmlEmailExpStart##-->
<script type="text/javascript">
var EWR_LANGUAGE_ID = "<?php echo $gsLanguage ?>";
var EWR_DATE_SEPARATOR = "<!--##=PROJ.DateSeparator##-->" || "/"; // Default date separator
var EWR_DECIMAL_POINT = "<?php echo $EWR_DEFAULT_DECIMAL_POINT ?>";
var EWR_THOUSANDS_SEP = "<?php echo $EWR_DEFAULT_THOUSANDS_SEP ?>";
	<!--## if (bUseEmailExport) { ##-->
var EWR_MAX_EMAIL_RECIPIENT = <?php echo EWR_MAX_EMAIL_RECIPIENT ?>;
	<!--## } ##-->
var EWR_DISABLE_BUTTON_ON_SUBMIT = <!--##=ew_JsVal(bDisableButtonOnSubmit)##-->;
var EWR_IMAGES_FOLDER = "<!--##=ew_FolderPath("_images")##-->/"; // Image folder
var EWR_LOOKUP_FILE_NAME = "<!--##=ew_GetFileNameByCtrlID("lookup", false)##-->"; // Lookup file name
var EWR_AUTO_SUGGEST_MAX_ENTRIES = <?php echo EWR_AUTO_SUGGEST_MAX_ENTRIES ?>; // Auto-Suggest max entries
var EWR_USE_JAVASCRIPT_MESSAGE = <!--##=ew_JsVal(bUseJavaScriptMessage)##-->;
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
var EWR_EXPORT_FILE_NAME = "<!--##=ew_GetFileNameByCtrlID("ewexport", false)##-->";
</script>
<script type="text/javascript">if (!window.jQuery) ewr_GetScript("<?php echo ewr_jQueryFile("jquery-%v.min.js") ?>");</script>
<?php if (ewr_IsMobile()) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo ewr_jQueryFile("jquery.mobile-%v.min.css") ?>" />
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
<script type="text/javascript" src="<!--##=ew_FolderPath("_js")##-->/<!--##=ew_GetFileNameByCtrlID("ewr.js", false)##-->"></script>
<script type="text/javascript" src="<!--##=ew_FolderPath("_js")##-->/<!--##=ew_GetFileNameByCtrlID("rptuser.js", false)##-->"></script>
<!--##include rpt-chartcommon-ext.php/chart_js_ext##-->
<!--## if (bUseJSTemplate) { ##-->
<?php if (@$gsExport <> "") { ?>
<script type="text/javascript">if (window.jQuery && !window.jQuery.views) ewr_GetScript("<!--##=ew_FolderPath("_js")##-->/<!--##=ew_GetFileNameByCtrlID("jsrender.min.js", false)##-->");</script>
<?php } ?>
<!--## } ##-->
<script type="text/javascript">
if (window._jQuery) ewr_Extend(jQuery);
if (window.jQuery && !jQuery.fn.alert) ewr_GetScript("bootstrap/js/bootstrap.min.js");		
</script>
<!--##=sTmplHtmlEmailExpEnd##-->
<!--##=sTmplExpStart##-->
<script type="text/javascript">
<?php echo $ReportLanguage->ToJSON() ?>
</script>
<!--##
	if (!bGenCompatHeader) {
##-->
<!--##include rpt-menuext.php/menuextjs##-->
<!--##
	}
##-->
<!--## if (SYSTEMFUNCTIONS.ServerScriptExist("Global","Page_Head")) { ##-->
<?php
<!--##~SYSTEMFUNCTIONS.GetServerScript("Global","Page_Head")##-->
?>
<!--## } ##-->
<!--##=sTmplExpEnd##-->
<!--##
	if (!bGenCompatHeader) {
##-->
<!--##=SYSTEMFUNCTIONS.FavIcon()##-->
</head>
<body>
<!--##=sTmplHtmlExpStart##-->
<?php if (ewr_IsMobile()) { ?>
<div data-role="page">
	<div data-role="header">
		<a href="<!--##=ew_GetFileNameByCtrlID("rptmobilemenu", false)##-->"><?php echo $ReportLanguage->Phrase("MobileMenu") ?></a>
		<h1 id="ewPageTitle"></h1>
<!--## if (bSecurityEnabled) { ##-->
	<?php if (IsLoggedIn()) { ?>
		<a href="<!--##=sFnLogout##-->"><?php echo $ReportLanguage->Phrase("Logout") ?></a>
	<?php } elseif (substr(ewr_ScriptName(), 0 - strlen("<!--##=sFnLogin##-->")) <> "<!--##=sFnLogin##-->") { ?>
		<a href="<!--##=sFnLogin##-->"><?php echo $ReportLanguage->Phrase("Login") ?></a>
	<?php } ?>
<!--## } ##-->
	</div>
<?php } ?>
<!--##=sTmplHtmlExpEnd##-->
<!--##=sTmplSkipStart##-->
<!--##=sTmplExpStart##-->
<div class="ewLayout">
<?php if (!ewr_IsMobile()) { ?>
	<!-- header (begin) --><!-- *** Note: Only licensed users are allowed to change the logo *** -->
	<div id="ewHeaderRow" class="ewHeaderRow"><!--##=SYSTEMFUNCTIONS.HeaderLogo()##--></div>
	<!-- header (end) -->
<?php } ?>
<!--##
	}
##-->
<!--##/session##-->


<!--##session menu##-->
<!--##
	if (!bGenCompatHeader) {
##-->
<?php if (ewr_IsMobile()) { ?>
	<div data-role="content" data-enhance="false">
	<table id="ewContentTable" class="ewContentTable">
		<tr>
<?php } else { ?>
	<!-- content (begin) -->
	<table id="ewContentTable" class="ewContentTable">
		<tr>	
			<td class="ewMenuColumn">
<!--##=SYSTEMFUNCTIONS.IncludeFile("rptmenu","")##-->
			<!-- left column (end) -->
			</td>
<?php } ?>
<!--##
	}
##-->
<!--##/session##-->


<!--##session header_bottom##-->
<!--##
	if (!bGenCompatHeader) {
##-->
			<!-- right column (begin) -->
			<td class="ewContentColumn">
	<!--## if (bMultiLanguage) { ##-->
<form class="ewForm ewLangForm form-horizontal">
<?php echo $ReportLanguage->Phrase("Language") ?>
<select id="language" name="language" onchange="ewr_SubmitLanguageForm(this.form);">
<?php foreach ($EWR_LANGUAGE_FILE as $langfile) { ?>
<option value="<?php echo $langfile[0] ?>"<?php if ($gsLanguage == $langfile[0]) echo " selected=\"selected\"" ?>><?php echo $langfile[1] ?></option>
<?php } ?>
</select>
</form>
	<!--## } ##-->
				<p class="ewSiteTitle"><?php echo $ReportLanguage->ProjectPhrase("BodyTitle") ?></p>
<!--##=sTmplExpEnd##-->
<!--##=sTmplSkipEnd##-->
<!--##
	}
##-->
<!--##/session##-->


<!--##session footer##-->
<!--##
	if (!bGenCompatHeader) {
##-->
<!--##=sTmplExpStart##-->
<!--##=sTmplSkipStart##-->			
			<?php if (isset($gsTimer)) $gsTimer->Stop(); ?>
			<!-- right column (end) -->
			</td>
		</tr>
	</table>
	<!-- content (end) -->
<?php if (!ewr_IsMobile()) { ?>
	<!-- footer (begin) --><!-- *** Note: Only licensed users are allowed to remove or change the following copyright statement. *** -->
	<div id="ewFooterRow" class="ewFooterRow">
		<div class="ewFooterText"><?php echo $ReportLanguage->ProjectPhrase("FooterText"); ?></div>
		<!-- Place other links, for example, disclaimer, here -->
	</div>
	<!-- footer (end) -->	
<?php } ?>
</div>
<!--##=sTmplSkipEnd##-->
<!--##=sTmplExpEnd##-->
<!--##=sTmplHtmlExpStart##-->
<?php if (ewr_IsMobile()) { ?>
	</div>
	<!-- footer (begin) --><!-- *** Note: Only licensed users are allowed to remove or change the following copyright statement. *** -->
<!-- *** Remove comment lines to show footer for mobile
	<div data-role="footer">
		<h4><?php echo $ReportLanguage->ProjectPhrase("FooterText") ?></h4>
	</div>
*** -->
	<!-- footer (end) -->	
</div>
<?php } ?>
<!--##=sTmplHtmlExpEnd##-->
<!--##
	}
##-->
<!--##=sTmplHtmlExpStart##-->
<?php if (ewr_IsMobile()) { ?>
<script type="text/javascript">
jQuery("#ewPageTitle").html(jQuery("#ewPageCaption").html());
<?php if (@$_GET["chart"] <> "") { ?>
jQuery.later(500, null, function() {
	var el = document.getElementById("<?php echo $_GET["chart"] ?>");
	if (el) el.scrollIntoView();
});
<?php } ?>
</script>
<?php } ?>
<!--##=sTmplHtmlExpEnd##-->
<!--##=sTmplExpStart##-->
<!--## if (bUseEmailExport) { ##-->
<!-- email dialog -->
<div id="ewrEmailDialog" class="modal hide" data-backdrop="false"><div class="modal-header" style="cursor: move;"><h3></h3></div>
<div class="modal-body">
<!--##=SYSTEMFUNCTIONS.IncludeFile("ewemail","other")##-->
</div><div class="modal-footer"><a href="#" class="btn btn-primary ewButton"><?php echo $ReportLanguage->Phrase("SendEmailBtn") ?></a><a href="#" class="btn ewButton" data-dismiss="modal" aria-hidden="true"><?php echo $ReportLanguage->Phrase("CancelBtn") ?></a></div></div>
<!--## } ##-->
<!-- message box -->
<div id="ewrMsgBox" class="modal hide" data-backdrop="false"><div class="modal-body"></div><div class="modal-footer"><a href="#" class="btn btn-primary ewButton" data-dismiss="modal" aria-hidden="true"><?php echo $ReportLanguage->Phrase("MessageOK") ?></a></div></div>
<!-- popup filter -->
<div id="ewrPopupFilterDialog"></div>
<!-- export chart -->
<div id="ewrExportDialog"></div>
<!-- drill down -->
<!--##=sDrillSkipStart##-->
<div id="ewrDrillDownPanel"></div>
<!--##=sDrillSkipEnd##-->
<!--##=sTmplExpEnd##-->
<!--##
	if (!bGenCompatHeader) {
##-->
</body>
</html>
<!--##
	}
##-->
<!--##/session##-->
