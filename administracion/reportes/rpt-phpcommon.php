<!--##session phpcommon-config##-->
<!--##
	// Page objects
	sPageObj = ew_PageObj();
	gsPageObj = "Page";

	// Form object
	sFormName = ew_FormObj();

	// Control type
	switch (CTRL.CtrlType.toLowerCase()) {
		case "table":
			sCtrlType = "Table";
			break;
		case "report":
			sCtrlType = "Table";
			break;
		case "other":
			sCtrlType = "Other";
			break;
		default:
			sCtrlType = "Other";
			break;
	}

	bGenCompatHeader = (PROJ.AppCompat && ew_IsNotEmpty(PROJ.AppHeader));

	// Project name and variable
	sProjName = PROJ.ProjName;
	sProjVar = PROJ.ProjVar;
	sImageFolder = ew_FolderPath("_images");

	// Date separator
	sDateSeparator = PROJ.DateSeparator;
	if (ew_IsEmpty(sDateSeparator)) sDateSeparator = "/";

	// Common files
	sFnDefault = ew_GetFileNameByCtrlID("rptdefault", false); // PR7
	var sFnHomePage = PROJ.StartPage;
	if (sFnHomePage == "") sFnHomePage = PROJ.DefaultPage;
	if (sFnHomePage == "") sFnHomePage = sFnDefault;
	sFnLogin = ew_GetFileNameByCtrlID("rptlogin", false); // PR7
	sFnLogout = ew_GetFileNameByCtrlID("rptlogout", false); // PR7

	// JavasSript message
	bUseJavaScriptMessage = PROJ.GetV("UseJavaScriptMessage");

	// Disable submit button
	bDisableButtonOnSubmit = PROJ.GetV("DisableButtonOnSubmit");

	// Security related
	bSecurityEnabled = !(PROJ.SecType == "None" || PROJ.SecType == "");
	bHardCodeAdmin = (PROJ.SecType == "Both" || PROJ.SecType == "Hard Code");
	bUserTable = (PROJ.SecType == "Both" || PROJ.SecType == "Use Table");
	if (bUserTable) {
		SECTABLE = DB.Tables(PROJ.SecTbl);
		sSecTblVar = SECTABLE.TblVar;
	}
	bStaticUserLevel = (bUserTable && (!DB.UseDynamicUserLevel && ew_IsNotEmpty(DB.SecUserLevelFld)));
	bDynamicUserLevel = (bUserTable && (DB.UseDynamicUserLevel && ew_IsNotEmpty(DB.UserLevelTbl) && ew_IsNotEmpty(DB.SecUserLevelFld)));
	bUserLevel = (bStaticUserLevel || bDynamicUserLevel);
	bUserID = (bUserTable && ew_IsNotEmpty(DB.SecuUserIDFld));
	bParentUserID = (bUserID && ew_IsNotEmpty(DB.SecuParentUserIDFld));

	// Language files
	sLanguageFolder = ew_FolderPath("_language");
	if (ew_IsNotEmpty(sLanguageFolder)) sLanguageFolder += "/";
	sLanguageFiles = PROJ.LanguageFiles;
	sDefaultLanguageFile = PROJ.DefaultLanguageFile;
	if (ew_IsEmpty(sLanguageFiles)) sLanguageFiles = "english.xml";
	if (ew_IsEmpty(sDefaultLanguageFile)) sDefaultLanguageFile = "english.xml";
	bMultiLanguage = PROJ.MultiLanguage;
	if (bMultiLanguage)
		arLanguageFile = sLanguageFiles.split(",");
	else
		arLanguageFile = sDefaultLanguageFile.split(",");

	// Use place holder for textbox
	sUsePlaceHolder = PROJ.GetV("UsePlaceHolder");
##-->
<!--##/session##-->

<!--##session phpcommon-directive##-->
<!--##=SYSTEMFUNCTIONS.PHPCgiPath()##-->
<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<!--##/session##-->


<!--##session phpcommon-header-compat##-->
<!--##=SYSTEMFUNCTIONS.IncludeFile("header","compat")##-->
<!--##/session##-->


<!--##session phpcommon-footer-compat##-->
<!--##=SYSTEMFUNCTIONS.IncludeFile("footer","compat")##-->
<!--##/session##-->

<!--##session breadcrumb##-->
<!--##=sBreadcrumbCheckStart##-->
<?php $ReportBreadcrumb->Render(); ?>
<!--##=sBreadcrumbCheckEnd##-->
<!--##/session##-->

<!--##session common-message##-->
<?php $<!--##=gsPageObj##-->->ShowMessage(); ?>
<!--##/session##-->

<!--##session header-message##-->
<?php $<!--##=gsPageObj##-->->ShowPageHeader(); ?>
<!--##/session##-->

<!--##session footer-message##-->
<?php $<!--##=gsPageObj##-->->ShowPageFooter(); ?>
<?php if (EWR_DEBUG_ENABLED) echo ewr_DebugMsg(); ?>
<!--##/session##-->


<!--##session render-menu##-->
<?php
// Generate all menu items
$RootMenu->IsRoot = TRUE;
<!--##
	for (var i = 1; i <= MENULIST.Count(); i++) {

		if (MENULIST(i).MenuShow) {

			bMenuGroup = MENULIST(i).MenuGroup;

			if (MENULIST(i).MenuCustomUrl) {

				sUrl = MENULIST(i).MenuUrl.replace(new RegExp("\"", "g"), "&quot;");
				sMenuId = MENULIST(i).MenuId;
				sParentId = MENULIST(i).MenuParentId;
				sText = MENULIST(i).MenuText;
				iAnonymous = MENULIST(i).MenuAnonymous;
				bAnonymous = ((iAnonymous & 8) == 8);
				if (bAnonymous) {
					sTableSecChk = "TRUE";
				} else if (bSecurityEnabled) {
					sTableSecChk = "IsLoggedIn()";
				} else {
					sTableSecChk = "TRUE";
				}
##-->
$RootMenu->AddMenuItem(<!--##=sMenuId##-->, $ReportLanguage->MenuPhrase("<!--##=sMenuId##-->", "MenuText"), <!--##=ew_DoubleQuote(sUrl, 1)##-->, <!--##=sParentId##-->, "", <!--##=sTableSecChk##-->, <!--##=ew_Val(bMenuGroup)##-->, TRUE);
<!--##
			} else {

				sMenuId = MENULIST(i).MenuId;
				sParentId = MENULIST(i).MenuParentId;
				sText = MENULIST(i).MenuText;
				sMenuType = MENULIST(i).MenuType;
				sMenuUrl = MENULIST(i).MenuUrl;
				if (sMenuType == "Table") {
					TABLE = DB.Tables(sMenuUrl);
				} else if (sMenuType == "Chart" && ew_IsNotEmpty(sMenuUrl)) {
					if (sMenuUrl.indexOf("|") > 0) {
						sTableName = sMenuUrl.split("|")[0];
						sChartName = sMenuUrl.split("|")[1];
						TABLE = DB.Tables(sTableName);
						CHART = TABLE.Charts(sChartName);
						bIsShowChart = IsShowChart(CHART);
					} else {
						alert("menu: Invalid chart url - " + sMenuUrl + ". Menu generation incomplete.");
						break;
					}
				}
				sTblVar = TABLE.TblVar;
				if (TABLE.TblType == "REPORT") {
					sFn = ew_GetFileNameByCtrlID(TABLE.TblReportType, false); // PR7
					if (TABLE.TblReportType == "crosstab") {
						sText = "$ReportLanguage->Phrase(\"CrosstabReportMenuItemPrefix\") . $ReportLanguage->MenuPhrase(\"" + sMenuId + "\", \"MenuText\") . $ReportLanguage->Phrase(\"CrosstabReportMenuItemSuffix\")";
					} else if (TABLE.TblReportType == "summary") {
						sText = "$ReportLanguage->Phrase(\"DetailSummaryReportMenuItemPrefix\") . $ReportLanguage->MenuPhrase(\"" + sMenuId + "\", \"MenuText\") . $ReportLanguage->Phrase(\"DetailSummaryReportMenuItemSuffix\")";
					} else {
						sText = "$ReportLanguage->MenuPhrase(\"" + sMenuId + "\", \"MenuText\")";
					}
				} else {
					sFn = ew_GetFileNameByCtrlID("rpt", false); // PR7
					sText = "$ReportLanguage->Phrase(\"SimpleReportMenuItemPrefix\") . $ReportLanguage->MenuPhrase(\"" + sMenuId + "\", \"MenuText\") . $ReportLanguage->Phrase(\"SimpleReportMenuItemSuffix\")";
				}
				if (HasDrillDownParm(TABLE))
					sFn += "?cmd=resetdrilldown";
				if (sMenuType == "Chart") {
					sChartId = "cht_" + TABLE.TblVar + "_" + CHART.ChartVar;
					if (PROJ.OutputNameLCase) sChartId = sChartId.toLowerCase();
					sFn += "#" + sChartId;
					sText = "$ReportLanguage->Phrase(\"ChartReportMenuItemPrefix\") . $ReportLanguage->MenuPhrase(\"" + sMenuId + "\", \"MenuText\") . $ReportLanguage->Phrase(\"ChartReportMenuItemSuffix\")";
				}

				iAnonymous = TABLE.TblAnonymous; // Allow anonymous access
				bAnonymous = ((iAnonymous & 8) == 8);

				// User Level Security
				bUserTable = (PROJ.SecType == "Both" || PROJ.SecType == "Use Table");
				bUserLevel = (bUserTable && (ew_IsNotEmpty(DB.SecUserLevelFld) && ew_IsNotEmpty(TABLE.TblSecurity)));
				if (bUserLevel && !bAnonymous) {
					sTableSecChk = "AllowList(\"" + PROJ.ProjID + TABLE.TblName + "\")";
				} else if (bSecurityEnabled && !bAnonymous) {
					sTableSecChk = "IsLoggedIn()";
				} else {
					sTableSecChk = "TRUE";
				}
				if (sMenuType == "Table" || (sMenuType == "Chart" && PROJ.ChartMenuItems && bIsShowChart)) {
##-->
$RootMenu->AddMenuItem(<!--##=sMenuId##-->, <!--##=sText##-->, "<!--##=sFn##-->", <!--##=sParentId##-->, "", <!--##=sTableSecChk##-->, <!--##=ew_Val(bMenuGroup)##-->);
<!--##
				}

			}
		}
	}

	if (bSecurityEnabled) {
##-->
if (IsLoggedIn()) {
	$RootMenu->AddMenuItem(0xFFFFFFFF, $ReportLanguage->Phrase("Logout"), "<!--##=sFnLogout##-->", -1, "", TRUE);
} elseif (substr(ewr_ScriptName(), 0 - strlen("<!--##=sFnLogin##-->")) <> "<!--##=sFnLogin##-->") {
	$RootMenu->AddMenuItem(0xFFFFFFFF, $ReportLanguage->Phrase("Login"), "<!--##=sFnLogin##-->", -1, "", TRUE);
}
<!--##
	}
##-->
$RootMenu->Render();
?>
<!--##/session##-->
