<!--##session phpconfig##-->
<!--##

	bShowChart = false;
	iFcfChartCnt = 0;
	bUseEmbeddedImagesForEmail = false;
	nSearchFlds = 0; // Number of search fields
	bShowYearSelection = false;
	bUseCustomTemplate = SYSTEMFUNCTIONS.CustomTemplateExist() && TABLE.TblDashboardType == "custom";

	for (var i = 0, len = goTbls.length; i < len; i++) {
		var TMPTABLE = goTbls[i];
		bGenInfoClass = false;
		sTmpTblVar = TMPTABLE.TblVar;
		if (TMPTABLE.TblName != TABLE.TblName) {

			// Table with dashboard chart
			for (var j = 0, chtlen = arAllCharts.length; j < chtlen; j++) {
				if (GetChtObj(arAllCharts[j])) {
					if (goCht.ChartSourceTable == TMPTABLE.TblName) {
						var WRKTABLE = DB.Tables(TMPTABLE.TblName);
						if (WRKTABLE.Charts.ChartExist(goCht.ChartSourceChart)) {
							bGenInfoClass = true;
							break;
						}
					}
				}
			}

			if (bGenInfoClass) {
				CURRENTTABLE = TABLE; // Save current table
				TABLE = TMPTABLE; // Set table object
				if (!(sTmpTblVar in dIncludeTable)) {
					dIncludeTable[sTmpTblVar] = ew_GetFileNameByCtrlID(TABLE.TblReportType + "info");
				}
				TABLE = CURRENTTABLE; // Restore current table
			}
		}
	}

##-->
<!--##/session##-->


<!--##session include-table##-->
<!--##
	for (var tmpTblVar in dIncludeTable) {
##-->
<?php include_once "<!--##=dIncludeTable[tmpTblVar]##-->" ?>
<!--##
	}
##-->
<!--##/session##-->


<?php
<!--##session phpmain##-->

	var $DrillDown = FALSE;
	var $DrillDownInPanel = TRUE;
	var $Filter = "";

	//
	// Page main
	//
	function Page_Main() {

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

	}

<!--##/session##-->
?>


<!--##session report_content##-->

<!-- Container (begin) -->
<div id="ewContainer">

<!-- Top container (begin) -->
<div id="ewTop">
<a id="top"></a>
<!--##include rpt-phpcommon.php/breadcrumb##-->

<!--##include rpt-phpcommon.php/header-message##-->
<!--##include rpt-phpcommon.php/common-message##-->
</div>
<!-- Top container (end) -->

<!-- Dashboard container (begin) -->
<div id="ewDashboard">

<!--##
	if (bUseCustomTemplate) {
##-->

<!--##~SYSTEMFUNCTIONS.GetCustomTemplate()##-->

<!--##
	} else {

		// Generate charts
		for (var i = 0, len = arAllCharts.length; i < len; i++) {
			if (GetChtObj(arAllCharts[i])) {
##-->
<!--##include rpt-chartcommon.php/chart_common##-->
<!--##include rpt-chartcommon.php/chart_html##-->
<!--##
			}
		}; // End for i, Chart on top

	}
##-->
</div>
<!-- Dashboard container (end) -->

</div>
<!-- Container (end) -->

<!--##
	// Generate charts
	for (var i = 0, len = arAllCharts.length; i < len; i++) {
		if (GetChtObj(arAllCharts[i])) {
##-->
<!--##include rpt-chartcommon.php/chart_common##-->
<!--##include rpt-chartcommon.php/chart_include##-->
<!--##
		}
	}; // End for i, Chart on top
##-->

<!--##/session##-->


<?php
<!--##session phpfunction##-->

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = ewr_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("<!--##=CTRL.CtrlID##-->", $this->TableVar, $url, $this->TableVar, TRUE);
	}

<!--##/session##-->
?>