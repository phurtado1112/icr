<!--##session currenttable##-->
<!--##
	// Set security table current
	if (ew_IsNotEmpty(PROJ.SecTbl)) {
		TABLE = DB.Tables(PROJ.SecTbl);
		goFlds = goTblFlds.Fields;
		gsTblVar = TABLE.TblVar;
	}
	
	sLoginOption = PROJ.LoginOption;
	if (sLoginOption == "") sLoginOption = "AUTO,USER,ASK";
	arLoginOption = sLoginOption.split(",");
	dLoginOption = {};
	lLoginOptionCount = 0;
	for (var i = 0; i < arLoginOption.length; i++) {
		sOption = arLoginOption[i].trim();
		if (sOption == "AUTO" || sOption == "USER" || sOption == "ASK") {
			if (!(sOption in dLoginOption)) {
				dLoginOption[sOption] = sOption;
				lLoginOptionCount += 1;
			}
		}
	}
	
	sExpStart = "";
	sExpEnd = "";
	sBreadcrumbCheckStart = "";
	sBreadcrumbCheckEnd = "";
##-->
<!--##/session##-->


<?php
<!--##session phpmain##-->

<!--##include rpt-captcha.php/phpcaptcha_var##-->

	var $Username;
	var $LoginType;

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $ReportLanguage, $gsFormError, $ReportBreadcrumb;
		
		$ReportBreadcrumb = new crBreadcrumb;
		$ReportBreadcrumb->Add("<!--##=CTRL.CtrlID##-->", "LoginPage", ewr_CurrentUrl(), "", TRUE);
		
		$sPassword = "";
		$sLastUrl = $Security->LastUrl(); // Get last URL
		if ($sLastUrl == "")
			$sLastUrl = "<!--##=sFnDefault##-->";

		if (!$Security->IsLoggedIn())
			$Security->AutoLogin();

	<!--## if (bUserLevel) { ##-->
		$Security->LoadUserLevel(); // Load user level
	<!--## } ##-->

		$this->Username = ""; // Initialize
		if (@$_POST["username"] <> "") {
			// Setup variables
			$this->Username = ewr_RemoveXSS(ewr_StripSlashes(@$_POST["username"]));
			$sPassword = ewr_RemoveXSS(ewr_StripSlashes(@$_POST["password"]));
			$this->LoginType = strtolower(ewr_RemoveXSS(@$_POST["type"]));
<!--## if (PROJ.GetV("AllowLoginByUrl")) { ##-->
		} else if (@$_GET["username"] <> "") {
			// Setup variables
			$this->Username = ewr_RemoveXSS(ewr_StripSlashes(@$_GET["username"]));
			$sPassword = ewr_RemoveXSS(ewr_StripSlashes(@$_GET["password"]));
			$this->LoginType = strtolower(ewr_RemoveXSS(@$_GET["type"]));
<!--## } ##-->
		}

		if ($this->Username <> "") {

			$bValidate = $this->ValidateForm($this->Username, $sPassword);
			if (!$bValidate)
				$this->setFailureMessage($gsFormError);

		} else {

			if ($Security->IsLoggedIn()) {
				if ($this->getFailureMessage() == "")
					$this->Page_Terminate($sLastUrl); // Return to last accessed page
			}

			$bValidate = FALSE;

			// Restore settings
			if (@$_COOKIE[EWR_PROJECT_NAME]['Checksum'] == strval(crc32(md5(EWR_RANDOM_KEY))))
				$this->Username = TEAdecrypt(@$_COOKIE[EWR_PROJECT_NAME]['Username'], EWR_RANDOM_KEY);
			if (@$_COOKIE[EWR_PROJECT_NAME]['AutoLogin'] == "autologin") {
				$this->LoginType = "a";
			} elseif (@$_COOKIE[EWR_PROJECT_NAME]['AutoLogin'] == "rememberusername") {
				$this->LoginType = "u";
			} else {
				$this->LoginType = "";
			}

		}

		$bValidPwd = FALSE;

		<!--##include rpt-captcha.php/phpcaptcha_php##-->

		if ($bValidate) {

		<!--## if (SYSTEMFUNCTIONS.ServerScriptExist("Other","User_LoggingIn")) { ##-->
			// Call Logging In event
			$bValidate = $this->User_LoggingIn($this->Username, $sPassword);
		<!--## } else { ##-->
			$bValidate = TRUE;
		<!--## } ##-->
		
			if ($bValidate) {
				$bValidPwd = $Security->ValidateUser($this->Username, $sPassword, FALSE); // Manual login
				if (!$bValidPwd) {
					if ($this->getFailureMessage() == "")
						$this->setFailureMessage($ReportLanguage->Phrase("InvalidUidPwd")); // Invalid user id/password
				}
			} else {
				if ($this->getFailureMessage() == "")
					$this->setFailureMessage($ReportLanguage->Phrase("LoginCancelled")); // Login cancelled
			}
		}

		if ($bValidPwd) {
			// Write cookies
			if ($this->LoginType == "a") { // Auto login
				setcookie(EWR_PROJECT_VAR . '[AutoLogin]',  "autologin", EWR_COOKIE_EXPIRY_TIME); // Set autologin cookie
				setcookie(EWR_PROJECT_VAR . '[Username]', TEAencrypt($this->Username, EWR_RANDOM_KEY), EWR_COOKIE_EXPIRY_TIME); // Set user name cookie
				setcookie(EWR_PROJECT_VAR . '[Password]', TEAencrypt($sPassword, EWR_RANDOM_KEY), EWR_COOKIE_EXPIRY_TIME); // Set password cookie
				setcookie(EWR_PROJECT_VAR . '[Checksum]', crc32(md5(EWR_RANDOM_KEY)), EWR_COOKIE_EXPIRY_TIME);
			} elseif ($this->LoginType == "u") { // Remember user name
				setcookie(EWR_PROJECT_VAR . '[AutoLogin]', "rememberusername", EWR_COOKIE_EXPIRY_TIME); // Set remember user name cookie
				setcookie(EWR_PROJECT_VAR . '[Username]', TEAencrypt($this->Username, EWR_RANDOM_KEY), EWR_COOKIE_EXPIRY_TIME); // Set user name cookie
				setcookie(EWR_PROJECT_VAR . '[Checksum]', crc32(md5(EWR_RANDOM_KEY)), EWR_COOKIE_EXPIRY_TIME);
			} else {
				setcookie(EWR_PROJECT_VAR . '[AutoLogin]', "", EWR_COOKIE_EXPIRY_TIME); // Clear auto login cookie
			}

		<!--## if (SYSTEMFUNCTIONS.ServerScriptExist("Other","User_LoggedIn")) { ##-->
			// Call loggedin event
			$this->User_LoggedIn($this->Username);
		<!--## } ##-->

			$this->Page_Terminate($sLastUrl); // Return to last accessed URL

		} elseif ($this->Username <> "" && $sPassword <> "") {

<!--## if (SYSTEMFUNCTIONS.ServerScriptExist("Other","User_LoginError")) { ##-->
			// Call user login error event
			$this->User_LoginError($this->Username, $sPassword);
<!--## } ##-->

		}

	}

<!--##/session##-->
?>


<!--##session login_htm##-->
<script type="text/javascript">

var <!--##=sFormName##--> = new ewr_Form("<!--##=sFormName##-->");

// Validate method
<!--##=sFormName##-->.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if (!ewr_HasValue(fobj.username))
		return this.OnError(fobj.username, ewLanguage.Phrase("EnterUid"));
	if (!ewr_HasValue(fobj.password))
		return this.OnError(fobj.password, ewLanguage.Phrase("EnterPwd"));

<!--##include rpt-captcha.php/phpcaptcha_js##-->

<!--## if (SYSTEMFUNCTIONS.ClientScriptExist("Other","Form_CustomValidate")) { ##-->
	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
<!--## } ##-->

	return true;
}

<!--## if (SYSTEMFUNCTIONS.ClientScriptExist("Other","Form_CustomValidate")) { ##-->
// Form_CustomValidate method
<!--##=sFormName##-->.Form_CustomValidate = <!--##~SYSTEMFUNCTIONS.GetClientScript("Other","Form_CustomValidate")##-->
<!--## } ##-->

// Requires js validation
<?php if (EWR_CLIENT_VALIDATE) { ?>
<!--##=sFormName##-->.ValidateRequired = true;
<?php } else { ?>
<!--##=sFormName##-->.ValidateRequired = false;
<?php } ?>

</script>

<!--##include rpt-phpcommon.php/breadcrumb##-->
<!--##include rpt-phpcommon.php/header-message##-->
<!--##include rpt-phpcommon.php/common-message##-->

<form name="<!--##=sFormName##-->" id="<!--##=sFormName##-->" class="ewForm form-horizontal" action="<?php echo ewr_CurrentPage() ?>" method="post">

<div class="ewLoginContent">
<!--##
	sPlaceHolder = (sUsePlaceHolder == "Caption") ? " placeholder=\"<?php echo $ReportLanguage->Phrase(\"Username\") ?>\"" : "";
##-->
	<div class="control-group">
		<label class="control-label" for="username"><!--##@Username##--></label>
		<div class="controls"><input type="text" name="username" id="username" class="input-large" value="<?php echo $<!--##=gsPageObj##-->->Username ?>"<!--##=sPlaceHolder##--> /></div>
	</div>
<!--##
	sPlaceHolder = (sUsePlaceHolder == "Caption") ? " placeholder=\"<?php echo $ReportLanguage->Phrase(\"Password\") ?>\"" : "";
##-->
	<div class="control-group">
		<label class="control-label" for="password"><!--##@Password##--></label>
		<div class="controls"><input type="password" name="password" id="password" class="input-large"<!--##=sPlaceHolder##--> /></div>
	</div>
<!--## if (lLoginOptionCount > 1) { ##--> 
	<div class="control-group">
		<div class="controls">
		<!--## if (String("AUTO") in dLoginOption) { ##-->
		<label class="radio ewRadio" style="white-space: nowrap;"><input type="radio" name="type" value="a"<?php if ($<!--##=sPageObj##-->->LoginType == "a") { ?> checked="checked"<?php } ?>><!--##@AutoLogin##--></label>
		<!--## } ##-->
		<!--## if (String("USER") in dLoginOption) { ##-->
		<label class="radio ewRadio" style="white-space: nowrap;"><input type="radio" name="type" value="u"<?php if ($<!--##=sPageObj##-->->LoginType == "u") { ?>  checked="checked"<?php } ?>><!--##@SaveUserName##--></label>
		<!--## } ##-->
		<!--## if (String("ASK") in dLoginOption) { ##-->
		<label class="radio ewRadio" style="white-space: nowrap;"><input type="radio" name="type" value=""<?php if ($<!--##=sPageObj##-->->LoginType == "") { ?> checked="checked"<?php } ?>><!--##@AlwaysAsk##--></label>
		<!--## } ##-->
		</div>
	</div>
<!--## } ##-->

<!--## if (lLoginOptionCount == 1) { ##-->
	<!--## if (String("AUTO") in dLoginOption) { ##-->
		<input type="hidden" name="type" value="a" />
	<!--## } else if (String("USER") in dLoginOption) { ##-->
		<input type="hidden" name="type" value="u" />
	<!--## } else if (String("ASK") in dLoginOption) { ##-->
		<input type="hidden" name="type" value="" />
	<!--## } ##-->
<!--## } ##-->

<!--##include rpt-captcha.php/phpcaptcha_htm##-->

	<div class="control-group">
		<div class="controls">
			<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $ReportLanguage->Phrase("Login") ?></button>
		</div>
	</div>

</div>

</form>

<script type="text/javascript">
<!--##=sFormName##-->.Init();
<?php if (EWR_MOBILE_REFLOW && ewr_IsMobile()) { ?>
ewr_Reflow();
<?php } ?>
</script>

<!--##include rpt-phpcommon.php/footer-message##-->
<!--##/session##-->


<?php
<!--##session phpfunction##-->

	//
	// Validate form
	//
	function ValidateForm($usr, $pwd) {
		global $ReportLanguage, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EWR_SERVER_VALIDATE)
			return TRUE;

		if (trim($usr) == "") {
			$gsFormError .= ($gsFormError <> "") ? "<p>&nbsp;</p>" : "";
			$gsFormError .= $ReportLanguage->Phrase("EnterUid");
		}

		if (trim($pwd) == "") {
			$gsFormError .= ($gsFormError <> "") ? "<p>&nbsp;</p>" : "";
			$gsFormError .= $ReportLanguage->Phrase("EnterPwd");
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

	<!--## if (SYSTEMFUNCTIONS.ServerScriptExist("Other","Form_CustomValidate")) { ##-->
		// Call Form Custom Validate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<p>&nbsp;</p>" : "";
			$gsFormError .= $sFormCustomError;
		}
	<!--## } ##-->

		return $ValidateForm;

	}

<!--##/session##-->
?>


<?php
<!--##session phpevents##-->
	<!--##~SYSTEMFUNCTIONS.GetServerScript("Other","User_LoggingIn")##-->
	<!--##~SYSTEMFUNCTIONS.GetServerScript("Other","User_LoggedIn")##-->
	<!--##~SYSTEMFUNCTIONS.GetServerScript("Other","User_LoginError")##-->
	<!--##~SYSTEMFUNCTIONS.GetServerScript("Other","Form_CustomValidate")##-->
<!--##/session##-->
?>