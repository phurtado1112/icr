<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new crMenu(EWR_MENUBAR_ID); ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(50, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("50", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "gestif3n_campaf1a_x_programa_seminariossmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(51, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("51", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "gestif3n_campaf1a_x_asesor_seminariossmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(52, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("52", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "gestif3n_campaf1a_x_asesor_global_embasmry.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(54, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("54", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "gestif3n_campaf1a_x_programa_global_embasmry.php", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
