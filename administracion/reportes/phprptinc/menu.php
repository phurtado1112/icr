<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new crMenu(EWR_MENUBAR_ID); ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(50, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("50", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "gestif3n_campaf1a_x_programa_open_exedsmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(51, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("51", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "gestif3n_campaf1a_x_asesor_open_exedsmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(56, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("56", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "gestif3n_detalle_de_campaf1a_x_asesor_open_exedsmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(62, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("62", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "actualizacif3n_x_asesor_x_campaf1asmry.php", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
