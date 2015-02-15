<?php
<!--##session chart_class_ext##-->
	// Process chart parms
	function ProcessChartParms(&$Parms) {
		if ($this->LoadParm("type") == 104) $this->SaveParm("type",3); // Bar 3D, Switch back to Bar 2D
		// Remove numVisiblePlot (scroll charts)
		if (array_key_exists("numVisiblePlot", $Parms))
			unset($Parms["numVisiblePlot"]);
	}
	// Encode special characters for FusionChartsFree
	// + => %2B
	function ChartEncode($val) {
		$v = str_replace("+", "%2B", $val);
		return $v;
	}

	// Format number for chart
	function ChartFormatNumber($v) {
		$cht_decimalprecision = $this->LoadParm("decimalPrecision");
		if (is_null($cht_decimalprecision)) {
			if ($this->ChartDefaultDecimalPrecision >= 0)
				$cht_decimalprecision = $this->ChartDefaultDecimalPrecision; // Use default precision
			else
				$cht_decimalprecision = (($v-(int)$v) == 0) ? 0 : strlen(abs($v-(int)$v))-2; // Use original decimal precision
		}
		return number_format($v, $cht_decimalprecision, '.', '');
	}

	// Category content XML (multi series)
	function WriteChartCatContent(&$node, $name) {
		$cat = $this->XmlDoc->createElement('category');
		$this->WriteAtt($cat, "name", $name);
	<!--## if (SYSTEMFUNCTIONS.ServerScriptExist("Global","Chart_DataRendered")) { ##-->
		$this->Chart_DataRendered($cat);
	<!--## } ##-->
		$node->appendChild($cat);
	}

	// Chart content XML
	function WriteChartContent(&$node, $name, $val, $color, $alpha, $lnk) {
		$cht_shownames = $this->LoadParm("shownames");
		$set = $this->XmlDoc->createElement('set');
		$this->WriteAtt($set, "name", $name);
		$this->WriteAtt($set, "value", $this->ChartFormatNumber($val));
		$this->WriteAtt($set, "color", $this->ColorCode($color));
		$this->WriteAtt($set, "alpha", $alpha);
		if ($lnk <> "")
			$this->WriteAtt($set, "link", $lnk);
		if ($cht_shownames == "1")
			$this->WriteAtt($set, "showName", "1");
	<!--## if (SYSTEMFUNCTIONS.ServerScriptExist("Global","Chart_DataRendered")) { ##-->
		$this->Chart_DataRendered($set);
	<!--## } ##-->
		$node->appendChild($set);
	}

	// Get chart link
	function GetChartLink($src, $row) {
		if ($src <> "" && is_array($row)) {
			$cntrow = count($row);
			$lnk = $src;
			$sdt = $this->SeriesDateType;
			$xdt = $this->XAxisDateFormat;
			$ndt = ($this->ChartType == 20) ? $this->NameDateFormat : "";
			if ($sdt <> "") $xdt = $sdt;
			if (preg_match("/&t=([^&]+)&/", $lnk, $m))
				$tblcaption = $GLOBALS["ReportLanguage"]->TablePhrase($m[1], 'TblCaption');
			else
				$tblcaption = "";
			for ($i = 0; $i < $cntrow; $i++) {
				// Link format: %i:Parameter:FieldType%
				if (preg_match("/%" . $i . ":([^%:]*):([\d]+)%/", $lnk, $m)) {
					$fldtype = ewr_FieldDataType($m[2]);
					if ($i == 0) { // Format X SQL
						$lnk = str_replace($m[0], TEAencrypt(ewr_ChartXSQL("@" . $m[1], $fldtype, $row[$i], $xdt)), $lnk);
					} elseif ($i == 1) { // Format Series SQL
						$lnk = str_replace($m[0], TEAencrypt(ewr_ChartSeriesSQL("@" . $m[1], $fldtype, $row[$i], $sdt)), $lnk);
					} else {
						$lnk = str_replace($m[0], TEAencrypt("@" . $m[1] . " = " . ewr_QuotedValue($row[$i], $fldtype)), $lnk);
					}
				}
			}
			return "javascript:" . ewr_DrillDownJs($lnk, $this->ID, $tblcaption, $this->UseDrillDownPanel, "div_" . $this->ID, FALSE);
		} else {
			return "";
		}
	}

<!--##/session##-->
?>


<!--##session chart_common_ext##-->
<!--##
	EXT_CHART = null;

	if (ew_IsNotEmpty(sChartXFldName) && ew_IsNotEmpty(sChartYFldName)) {

		// Load extended chart
		var EXT = EXTS("FusionCharts");
		if (EXT) {
			var EXT_PROJ = EXT.PROJ; // Extended project
			var EXT_DB = EXT.PROJ.DB; // Extended database
			if (EXT_DB.Tables.TableExist(TABLE.TblName)) {
				var EXT_TABLE = EXT_DB.Tables(TABLE.TblName);
				if (EXT_TABLE.Charts.ChartExist(goCht.ChartName)) {
	
					EXT_CHART = EXT_TABLE.Charts(goCht.ChartName);
	
				}
			}
		}

	}
##-->
<!--##/session##-->


<!--##session chart_config_ext##-->
<!--## if (ew_IsNotEmpty(sChartXFldName) && ew_IsNotEmpty(sChartYFldName)) { ##-->
<?php
<!--## if (EXT_CHART != null) { ##-->
<!--##
	var parmdata = "";
	//for (var prp in EXT_CHART.Properties) {
	for (var enumerator = new Enumerator(EXT_CHART.Properties) ; !enumerator.atEnd(); enumerator.moveNext()) {
		var prp = enumerator.item();
		name = prp.Name;
		value = prp.Value;
		if (name != "ChartSeq" && name != "ChartName" && ew_IsNotEmpty(name) && ew_IsNotEmpty(value)) {
			value = ConvertData(value, prp.DataType);
			if (parmdata != "") parmdata += ",\r\n\t";
			parmdata += "array(\"" + ew_Quote(name) + "\", \"" + ew_Quote(value) + "\")";
		}
	}
	if (parmdata != "") {
##-->
$Chart->SetChartParms(array(<!--##=parmdata##-->));
<!--##
	}
##-->
<!--## } ##-->

// Define trend lines
<!--##
	for (var j = 1, cnt = CHART.Trendlines.Count(); j <= cnt; j++) {
		var TREND = CHART.Trendlines.Seq(j);
		if (TREND.TrendShow) {
			sStartValue = TREND.TrendStartValue;
			if (ew_IsEmpty(sStartValue)) sStartValue = 0;
			sEndValue = TREND.TrendEndValue;
			if (ew_IsEmpty(sEndValue)) sEndValue = 0;
			sColor = TREND.TrendColor;
			sDispValue = TREND.TrendDisplayValue;
			sThickness = TREND.TrendThickness;
			if (ew_IsEmpty(sThickness)) sThickness = 1;
			sIsTrendZone = (TREND.TrendIsTrendZone) ? "1" : "0";
			sShowOnTop = (TREND.TrendShowOnTop) ? "1" : "0";
			sAlpha = TREND.TrendAlpha;
			if (ew_IsEmpty(sAlpha)) sAlpha = 0;
##-->
$Chart->Trends[] = array(<!--##=sStartValue##-->, <!--##=sEndValue##-->, "<!--##=sColor##-->", "<!--##=sDispValue##-->", <!--##=sThickness##-->, "<!--##=sIsTrendZone##-->", "<!--##=sShowOnTop##-->", <!--##=sAlpha##-->);
<!--##
		}
	}
##-->
?>
<!--## } ##-->
<!--##/session##-->


<!--##session chart_js_ext##-->
<script src="<?php echo EWR_FUSIONCHARTS_FREE_JSCLASS_FILE ?>" type="text/javascript"></script>
<!--##/session##-->


<?php
<!--##session chart_show_ext##-->
echo $Chart->ShowChartFCF($chartxml);
<!--##/session##-->
?>