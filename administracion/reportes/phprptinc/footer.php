<?php if (@$gsExport == "") { ?>
<?php if (@!$gbSkipHeaderFooter) { ?>			
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
<?php } ?>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
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
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
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
<?php } ?>
<?php if (@$gsExport == "") { ?>
<!-- message box -->
<div id="ewrMsgBox" class="modal hide" data-backdrop="false"><div class="modal-body"></div><div class="modal-footer"><a href="#" class="btn btn-primary ewButton" data-dismiss="modal" aria-hidden="true"><?php echo $ReportLanguage->Phrase("MessageOK") ?></a></div></div>
<!-- popup filter -->
<div id="ewrPopupFilterDialog"></div>
<!-- export chart -->
<div id="ewrExportDialog"></div>
<!-- drill down -->
<?php if (@!$gbDrillDownInPanel) { ?>
<div id="ewrDrillDownPanel"></div>
<?php } ?>
<?php } ?>
</body>
</html>
