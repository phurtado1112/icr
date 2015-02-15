<!--##session exportemail_htm##-->
<form id="ewrEmailForm" class="ewForm form-horizontal" action="<?php echo ewr_CurrentPage() ?>">
<input type="hidden" name="export" value="email" />
<div class="ewEmailContent">
	<div class="control-group">
		<label class="control-label" for="ewrSender"><!--##@EmailFormSender##--></label>
		<div class="controls"><input type="text" name="sender" id="ewrSender" size="30" /></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ewrRecipient"><!--##@EmailFormRecipient##--></label>
		<div class="controls"><input type="text" name="recipient" id="ewrRecipient" size="30" /></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ewrCc"><!--##@EmailFormCc##--></label>
		<div class="controls"><input type="text" name="cc" id="ewrCc" size="30" /></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ewrBcc"><!--##@EmailFormBcc##--></label>
		<div class="controls"><input type="text" name="bcc" id="ewrBcc" size="30" /></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ewrSubject"><!--##@EmailFormSubject##--></label>
		<div class="controls"><input type="text" name="subject" id="ewrSubject" size="50" /></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ewrMessage"><!--##@EmailFormMessage##--></label>
		<div class="controls"><textarea cols="50" rows="6" name="message" id="ewrMessage"></textarea></div>
	</div>
	<div class="control-group">
		<label class="control-label"><!--##@EmailFormContentType##--></label>
		<div class="controls">
		<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="contenttype" value="html" checked="checked" /><!--##@EmailFormContentTypeHtml##--></label>
		<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="contenttype" value="url" /><!--##@EmailFormContentTypeUrl##--></label>
		</div>
	</div>
</div>
</form>
<!--##/session##-->

<?php
<!--##session report_email_function##-->
<!--##
	if (bExportEmail) {
##-->

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $ReportLanguage;

		$sContentType = @$_POST["contenttype"];
		$sSender = @$_POST["sender"];
		$sRecipient = @$_POST["recipient"];
		$sCc = @$_POST["cc"];
		$sBcc = @$_POST["bcc"];
		
		// Subject
		$sSubject = ewr_StripSlashes(@$_POST["subject"]);
		$sEmailSubject = $sSubject;
		
		// Message
		$sContent = ewr_StripSlashes(@$_POST["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "")
			return "<p class=\"text-error\">" . $ReportLanguage->Phrase("EnterSenderEmail") . "</p>";

		if (!ewr_CheckEmail($sSender))
			return "<p class=\"text-error\">" . $ReportLanguage->Phrase("EnterProperSenderEmail") . "</p>";
	
		// Check recipient
		if (!ewr_CheckEmailList($sRecipient, EWR_MAX_EMAIL_RECIPIENT))
			return "<p class=\"text-error\">" . $ReportLanguage->Phrase("EnterProperRecipientEmail") . "</p>";

		// Check cc
		if (!ewr_CheckEmailList($sCc, EWR_MAX_EMAIL_RECIPIENT))
			return "<p class=\"text-error\">" . $ReportLanguage->Phrase("EnterProperCcEmail") . "</p>";

		// Check bcc
		if (!ewr_CheckEmailList($sBcc, EWR_MAX_EMAIL_RECIPIENT))
			return "<p class=\"text-error\">" . $ReportLanguage->Phrase("EnterProperBccEmail") . "</p>";

		// Check email sent count
		$emailcount = ewr_LoadEmailCount();
		if (intval($emailcount) >= EWR_MAX_EMAIL_SENT_COUNT)
			return "<p class=\"text-error\">" . $ReportLanguage->Phrase("ExceedMaxEmailExport") . "</p>";

		if ($sEmailMessage <> "") {
			if (EWR_REMOVE_XSS) $sEmailMessage = ewr_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		$sAttachmentContent = $EmailContent;
		$sAppPath = ewr_FullUrl();
		$sAppPath = substr($sAppPath, 0, strrpos($sAppPath, "/")+1);
		if (strpos($sAttachmentContent, "<head>") !== FALSE)
			$sAttachmentContent = str_replace("<head>", "<head><base href=\"" . $sAppPath . "\" />", $sAttachmentContent); // Add <base href> statement inside the header
		else
			$sAttachmentContent = "<base href=\"" . $sAppPath . "\" />" . $sAttachmentContent; // Add <base href> statement as the first statement

		//$sAttachmentFile = $this->TableVar . "_" . Date("YmdHis") . ".html";
		$sAttachmentFile = $this->TableVar . "_" . Date("YmdHis") . "_" . ewr_Random() . ".html";
		if ($sContentType == "url") {
			ewr_SaveFile(EWR_UPLOAD_DEST_PATH, $sAttachmentFile, $sAttachmentContent);
			$sAttachmentFile = EWR_UPLOAD_DEST_PATH . $sAttachmentFile;
			$sUrl = $sAppPath . $sAttachmentFile;
			$sEmailMessage .= $sUrl; // Send URL only
			$sAttachmentFile = "";
			$sAttachmentContent = "";
	<!--## if (bUseEmbeddedImagesForEmail) { ##-->
		} else {
			$sEmailMessage .= $sAttachmentContent;
		<!--## if (bUseCustomTemplate) { ##-->
			// Replace images in custom template
			if (preg_match_all('/<img([^>]*)>/i', $sEmailMessage, $matches, PREG_SET_ORDER)) {
				foreach ($matches as $match) {
					if (preg_match('/\s+src\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $match[1], $submatches)) { // Match src='src'
						$src = $submatches[1];
						if (substr($src,0,4) <> "cid:") { // Not embedded image
							$data = file_get_contents($src);
							if ($data <> "")
								$sEmailMessage = str_replace($match[0], "<img src=\"" . ewr_TmpImage($data) . "\">", $sEmailMessage);
						}
					}
				}
			}
		<!--## } ##-->
			$sAttachmentFile = "";
			$sAttachmentContent = "";
	<!--## } ##-->
		}

		// Send email
		$Email = new crEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Content = $sEmailMessage; // Content
		if ($sAttachmentFile <> "" || $sAttachmentContent <> "") {
			$Email->AttachmentContent = $sAttachmentContent; // Attachment
			$Email->AttachmentFileName = $sAttachmentFile; // Attachment file name
		} elseif ($sContentType <> "url") { // Inline attachment
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
		}
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		$Email->Charset = EWR_EMAIL_CHARSET;

<!--## if (SYSTEMFUNCTIONS.ServerScriptExist("Table","Email_Sending")) { ##-->
		$EventArgs = array();
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();
<!--## } else { ##-->
		$bEmailSent = $Email->Send();
<!--## } ##-->

		ewr_DeleteTmpImages();

		// Check email sent status
		if ($bEmailSent) {
			// Update email sent count and write log
			ewr_AddEmailLog($sSender, $sRecipient, $sEmailSubject, $sEmailMessage);
			// Sent email success
			return "<p class=\"text-success\">" . $ReportLanguage->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {
			// Sent email failure
			return "<p class=\"text-error\">" . $Email->SendErrDescription . "</p>";
		}

	}

<!--##
	};
##-->
<!--##/session##-->
?>
