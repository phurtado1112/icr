<form action="<?php echo ewr_CurrentPage() ?>" name="ewPagerForm" class="ewForm form-horizontal">
<table class="ewPager">
<tr><td>
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Page->StartGrp, $Page->DisplayGrps, $Page->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
<table class="ewStdTable"><tbody><tr><td>
	<?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;
<div class="input-prepend input-append">
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo ewr_CurrentPage() ?>?start=<?php echo $Pager->FirstButton->Start ?>"><i class="icon-step-backward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-step-backward"></i></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo ewr_CurrentPage() ?>?start=<?php echo $Pager->PrevButton->Start ?>"><i class="icon-prev"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-prev"></i></a>
	<?php } ?>
<!--current page number-->
	<input class="input-mini" type="text" name="<?php echo EWR_TABLE_PAGE_NO ?>" value="<?php echo $Pager->CurrentPage ?>">
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo ewr_CurrentPage() ?>?start=<?php echo $Pager->NextButton->Start ?>"><i class="icon-play"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-play"></i></a>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo ewr_CurrentPage() ?>?start=<?php echo $Pager->LastButton->Start ?>"><i class="icon-step-forward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-step-forward"></i></a>
	<?php } ?>
</div>
	&nbsp;<?php echo $ReportLanguage->Phrase("of") ?>&nbsp;<?php echo $Pager->PageCount ?>
</td>
<td>
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ReportLanguage->Phrase("Record") ?> <?php echo $Pager->FromIndex ?> <?php echo $ReportLanguage->Phrase("To") ?> <?php echo $Pager->ToIndex ?> <?php echo $ReportLanguage->Phrase("Of") ?> <?php echo $Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Page->Filter == "0=101") { ?>
	<p><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $ReportLanguage->Phrase("NoRecord") ?></p>
	<?php } ?>
<?php } ?>
</td>
<?php if ($Page->TotalGrps > 0) { ?>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ReportLanguage->Phrase("RecordsPerPage") ?>&nbsp;
<select name="<?php echo EWR_TABLE_GROUP_PER_PAGE; ?>" class="input-small" onchange="this.form.submit();">
<option value="5"<?php if ($Page->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Page->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="30"<?php if ($Page->DisplayGrps == 30) echo " selected=\"selected\"" ?>>30</option>
<option value="50"<?php if ($Page->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Page->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
</select>
</td>
<?php } ?>
</tr></table>
</form>
