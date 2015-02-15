<!--##session chart_content##-->
<!-- Chart Content (Start) -->
<?php
$id = "<!--##=gsTblVar##-->";
$chartxml = $<!--##=sPageObj##-->->gantt->Xml();
$wrkwidth = <!--##=iChartWidth##-->;
$wrkheight = <!--##=iChartHeight##-->;
?>
<div id="div_<?php echo $id; ?>"></div>
<script type="text/javascript">
	var chartwidth = "<?php echo $wrkwidth ?>";
	var chartheight = "<?php echo $wrkheight ?>";
	var chartxml = "<?php echo ewr_EscapeJs($chartxml) ?>";
	var chartid = "div_<?php echo $id ?>";
	var chartswf = "<?php echo EWR_FUSIONCHARTS_FREE_CHART_PATH ?>FCF_Gantt.swf";
	var cht_<?php echo $id ?> = new FusionChartsFree(chartswf, "chart_<?php echo $id ?>", chartwidth, chartheight);
	cht_<?php echo $id ?>.setDataXML(chartxml);
	cht_<?php echo $id ?>.addParam("wmode", "transparent");
	var f = <?php echo $<!--##=sPageObj##-->->PageObjName ?>.Chart_Rendering;
	if (typeof f == "function") f(cht_<?php echo $id ?>, 'chart_<?php echo $id ?>');
	cht_<?php echo $id ?>.render(chartid);
	f = <?php echo $<!--##=sPageObj##-->->PageObjName ?>.Chart_Rendered;
	if (typeof f == "function") f(cht_<?php echo $id ?>, 'chart_<?php echo $id ?>');
</script>
<?php
// Add debug XML
if (EWR_DEBUG_ENABLED)
	echo "<p>(Chart XML): " . ewr_HtmlEncode($chartxml) . "</p>";
?>
<!-- Chart Content (End) -->
<!--##/session##-->