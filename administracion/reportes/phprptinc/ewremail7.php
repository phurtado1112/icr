<form id="ewrEmailForm" class="ewForm form-horizontal" action="<?php echo ewr_CurrentPage() ?>">
<input type="hidden" name="export" value="email">
<div class="ewEmailContent">
	<div class="control-group">
		<label class="control-label" for="ewrSender"><?php echo $ReportLanguage->Phrase("EmailFormSender") ?></label>
		<div class="controls"><input type="text" name="sender" id="ewrSender" size="30"></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ewrRecipient"><?php echo $ReportLanguage->Phrase("EmailFormRecipient") ?></label>
		<div class="controls"><input type="text" name="recipient" id="ewrRecipient" size="30"></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ewrCc"><?php echo $ReportLanguage->Phrase("EmailFormCc") ?></label>
		<div class="controls"><input type="text" name="cc" id="ewrCc" size="30"></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ewrBcc"><?php echo $ReportLanguage->Phrase("EmailFormBcc") ?></label>
		<div class="controls"><input type="text" name="bcc" id="ewrBcc" size="30"></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ewrSubject"><?php echo $ReportLanguage->Phrase("EmailFormSubject") ?></label>
		<div class="controls"><input type="text" name="subject" id="ewrSubject" size="50"></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ewrMessage"><?php echo $ReportLanguage->Phrase("EmailFormMessage") ?></label>
		<div class="controls"><textarea cols="50" rows="6" name="message" id="ewrMessage"></textarea></div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo $ReportLanguage->Phrase("EmailFormContentType") ?></label>
		<div class="controls">
		<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="contenttype" value="html" checked="checked"><?php echo $ReportLanguage->Phrase("EmailFormContentTypeHtml") ?></label>
		<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="contenttype" value="url"><?php echo $ReportLanguage->Phrase("EmailFormContentTypeUrl") ?></label>
		</div>
	</div>
</div>
</form>
