<!--##session phppager##-->
<form action="<?php echo ewr_CurrentPage() ?>" name="ewPagerForm" class="ewForm form-horizontal">
<table class="ewPager">
<!--##
	if (TABLE.TblType != "REPORT") {
		sItem = "<?php echo $ReportLanguage->Phrase(\"Record\") ?>";
		sItemsPerPage = "<?php echo $ReportLanguage->Phrase(\"RecordsPerPage\") ?>";
	} else {
		sItem = "<?php echo $ReportLanguage->Phrase(\"Group\") ?>";
		sItemsPerPage = "<?php echo $ReportLanguage->Phrase(\"GroupsPerPage\") ?>";
	}
	sImageFolder = ew_FolderPath("_images") + "/";
	iAnonymous = TABLE.TblAnonymous;
	bAnonymous = ((iAnonymous & 8) == 8);

	switch (iPagerStyle) {
		case 1: // Pager Style 1
##-->
<tr><td>
<?php if (!isset($Pager)) $Pager = new crNumericPager($<!--##=gsPageObj##-->->StartGrp, $<!--##=gsPageObj##-->->DisplayGrps, $<!--##=gsPageObj##-->->TotalGrps, $<!--##=gsPageObj##-->->GrpRange) ?>
<?php if ($Pager->RecordCount > 0) { ?>
<table class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo ewr_CurrentPage() ?>?start=<?php echo $Pager->FirstButton->Start ?>"><!--##@PagerFirst##--></a></li>
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo ewr_CurrentPage() ?>?start=<?php echo $Pager->PrevButton->Start ?>"><!--##@PagerPrevious##--></a></li>
	<?php } ?>
	<?php foreach ($Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php echo ewr_CurrentPage() ?>?start=<?php echo $PagerItem->Start ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo ewr_CurrentPage() ?>?start=<?php echo $Pager->NextButton->Start ?>"><!--##@PagerNext##--></a></li>
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo ewr_CurrentPage() ?>?start=<?php echo $Pager->LastButton->Start ?>"><!--##@PagerLast##--></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<!--##@Record##--> <?php echo $Pager->FromIndex ?> <!--##@To##--> <?php echo $Pager->ToIndex ?> <!--##@Of##--> <?php echo $Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<!--## if (bUserLevel && !bAnonymous) { ##-->
	<?php if (($Security->CurrentUserLevel() & EWR_ALLOW_LIST) == EWR_ALLOW_LIST) { ?>
	<!--## } ##-->
	<?php if ($<!--##=gsPageObj##-->->Filter == "0=101") { ?>
	<!--##@EnterSearchCriteria##-->
	<?php } else { ?>
	<!--##@NoRecord##-->
	<?php } ?>
	<!--## if (bUserLevel && !bAnonymous) { ##-->
	<?php } else { ?>
	<!--##@NoPermission##-->
	<?php } ?>
	<!--## } ##-->
<?php } ?>
</td>
<!--##
			break;
		case 2: // Pager Style 2
##-->
<tr><td>
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($<!--##=gsPageObj##-->->StartGrp, $<!--##=gsPageObj##-->->DisplayGrps, $<!--##=gsPageObj##-->->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
<table class="ewStdTable"><tbody><tr><td>
	<!--##@Page##-->&nbsp;
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
	<input class="input-mini" type="text" name="<?php echo EWR_TABLE_PAGE_NO ?>" value="<?php echo $Pager->CurrentPage ?>" />
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
	&nbsp;<!--##@of##-->&nbsp;<?php echo $Pager->PageCount ?>
</td>
<td>
&nbsp;&nbsp;&nbsp;&nbsp;<!--##@Record##--> <?php echo $Pager->FromIndex ?> <!--##@To##--> <?php echo $Pager->ToIndex ?> <!--##@Of##--> <?php echo $Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<!--## if (bUserLevel && !bAnonymous) { ##-->
	<?php if (($Security->CurrentUserLevel() & EWR_ALLOW_LIST) == EWR_ALLOW_LIST) { ?>
	<!--## } ##-->
	<?php if ($<!--##=gsPageObj##-->->Filter == "0=101") { ?>
	<p><!--##@EnterSearchCriteria##--></p>
	<?php } else { ?>
	<p><!--##@NoRecord##--></p>
	<?php } ?>
	<!--## if (bUserLevel && !bAnonymous) { ##-->
	<?php } else { ?>
	<p><!--##@NoPermission##--></p>
	<?php } ?>
	<!--## } ##-->
<?php } ?>
</td>
<!--##
		break;
	}
##-->

<!--##
	if (ew_IsNotEmpty(sGrpPerPageList)) {
		arrGrpPerPage = sGrpPerPageList.split(",");
##-->
<?php if ($<!--##=gsPageObj##-->->TotalGrps > 0) { ?>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<!--##=sItemsPerPage##-->&nbsp;
<select name="<?php echo EWR_TABLE_GROUP_PER_PAGE; ?>" class="input-small" onchange="this.form.submit();">
	<!--##
		for (var i = 0; i < arrGrpPerPage.length; i++) {
			thisDisplayGrps = arrGrpPerPage[i];
			if (parseInt(thisDisplayGrps) > 0) {
				thisValue = parseInt(thisDisplayGrps);
	##-->
<option value="<!--##=thisDisplayGrps##-->"<?php if ($<!--##=gsPageObj##-->->DisplayGrps == <!--##=thisValue##-->) echo " selected=\"selected\"" ?>><!--##=thisDisplayGrps##--></option>
	<!--##
			} else {
	##-->
<option value="ALL"<?php if ($<!--##=gsPageObj##-->->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><!--##@AllRecords##--></option>
	<!--##
			}
		}
	##-->
</select>
</td>
<?php } ?>
<!--##
	}
##-->
</tr></table>
</form>
<!--##/session##-->

<?php
<!--##session setupdisplaygrps##-->
	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {

		$sWrk = @$_GET[EWR_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // Display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = <!--##=iGrpPerPage##-->; // Non-numeric, load default
				}
			}
			$this->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$this->setStartGroup($this->StartGrp);
		} else {
			if ($this->getGroupPerPage() <> "") {
				$this->DisplayGrps = $this->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = <!--##=iGrpPerPage##-->; // Load default
			}
		}
	}
<!--##/session##-->
?>
