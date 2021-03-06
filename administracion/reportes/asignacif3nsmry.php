<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg7.php" ?>
<?php include_once "phprptinc/ewmysql.php" ?>
<?php include_once "phprptinc/ewrfn7.php" ?>
<?php include_once "phprptinc/ewrusrfn.php" ?>
<?php include_once "asignacif3nsmryinfo.php" ?>
<?php

//
// Page class
//

$AsignaciF3n_summary = NULL; // Initialize page object first

class crAsignaciF3n_summary extends crAsignaciF3n {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{FBAFD19E-E753-4738-84A0-8DC7FC3CBD41}";

	// Page object name
	var $PageObjName = 'AsignaciF3n_summary';

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewr_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportPdfUrl;
	var $ReportTableClass;
	var $ReportTableStyle = "";

	// Custom export
	var $ExportPrintCustom = FALSE;
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EWR_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EWR_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EWR_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EWR_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_WARNING_MESSAGE], $v);
	}

		// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sMessage . "</div>";
			$_SESSION[EWR_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EWR_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EWR_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-error ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EWR_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog ewDisplayTable\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") // Header exists, display
			echo $sHeader;
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") // Fotoer exists, display
			echo $sFooter;
	}

	// Validate page request
	function IsPageRequest() {
		if ($this->UseTokenInUrl) {
			if (ewr_IsHttpPost())
				return ($this->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (AsignaciF3n)
		if (!isset($GLOBALS["AsignaciF3n"])) {
			$GLOBALS["AsignaciF3n"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["AsignaciF3n"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'Asignación', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new crTimer();

		// Open connection
		$conn = ewr_Connect();

		// Export options
		$this->ExportOptions = new crListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions = new crListOptions();
		$this->OtherOptions->Tag = "div";
		$this->OtherOptions->TagClassName = "ewOtherOption";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $giFcfChartCnt, $gsEmailContentType, $ReportLanguage, $Security;
		global $gsCustomExport;

		// Get export parameters
		if (@$_GET["export"] <> "")
			$this->Export = strtolower($_GET["export"]);
		elseif (@$_POST["export"] <> "")
			$this->Export = strtolower($_POST["export"]);
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$giFcfChartCnt = 0; // Get chart count, used in header
		$gsEmailContentType = @$_POST["contenttype"]; // Get email content type

		// Setup placeholder
		// Global Page Loading event (in userfn*.php)

		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Setup export options
		$this->SetupExportOptions();
	}

	// Set up export options
	function SetupExportOptions() {
		global $ReportLanguage;
		$exportid = session_id();

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendlyText")) . "\" href=\"" . $this->ExportPrintUrl . "\">" . $ReportLanguage->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcelText")) . "\" href=\"" . $this->ExportExcelUrl . "\">" . $ReportLanguage->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWordText")) . "\" href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDFText")) . "\" href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = FALSE;
		// Export to Email

		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmailText")) . "\" id=\"emf_AsignaciF3n\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_AsignaciF3n',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = FALSE;
		$this->ExportOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Reset filter
		$item = &$this->OtherOptions->Add("resetfilter");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilterText")) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilterText")) . "\" href=\"" . ewr_CurrentPage() . "?cmd=reset\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</a>";
		$item->Visible = TRUE;

		// Button group for reset filter
		$this->OtherOptions->UseButtonGroup = FALSE;

		// Add group option item
		$item = &$this->OtherOptions->Add($this->OtherOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($this->Export <> "") {
			$this->ExportOptions->HideAllOptions();
			$this->OtherOptions->HideAllOptions();
		}

		// Set up table class
		if ($this->Export == "word" || $this->Export == "excel" || $this->Export == "pdf")
			$this->ReportTableClass = "ewTable";
		else
			$this->ReportTableClass = "ewTable ewTableSeparate";
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn, $ReportLanguage, $EWR_EXPORT, $gsExportFile;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EWR_EXPORT)) {
			$sContent = ob_get_contents();
			$fn = $EWR_EXPORT[$this->Export];
			if ($this->Export == "email") { // Email
				ob_end_clean();
				echo $this->$fn($sContent);
				$conn->Close(); // Close connection
				exit();
			} else {
				$this->$fn($sContent);
			}
		}

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWR_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Initialize common variables
	var $ExportOptions; // Export options
	var $OtherOptions; // Other options

	// Paging variables
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $GrpCounter = array(); // Group counter
	var $DisplayGrps = 5; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $PageFirstGroupFilter = "";
	var $UserIDFilter = "";
	var $DrillDown = FALSE;
	var $DrillDownInPanel = FALSE;
	var $DrillDownList = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $PopupName = "";
	var $PopupValue = "";
	var $FilterApplied;
	var $SearchCommand = FALSE;
	var $ShowHeader;
	var $GrpFldCount = 0;
	var $SubGrpFldCount = 0;
	var $DtlFldCount = 0;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandCnt, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;
	var $GrandSummarySetup = FALSE;
	var $GrpIdx;

	//
	// Page main
	//
	function Page_Main() {
		global $rs;
		global $rsgrp;
		global $gsFormError;
		global $gbDrillDownInPanel;
		global $ReportBreadcrumb;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 2;
		$nGrps = 4;
		$this->Val = &ewr_InitArray($nDtls, 0);
		$this->Cnt = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandCnt = &ewr_InitArray($nDtls, 0);
		$this->GrandSmry = &ewr_InitArray($nDtls, 0);
		$this->GrandMn = &ewr_InitArray($nDtls, NULL);
		$this->GrandMx = &ewr_InitArray($nDtls, NULL);

		// Set up array if accumulation required: array(Accum, SkipNullOrZero)
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
		$this->programa->SelectionList = "";
		$this->programa->DefaultSelectionList = "";
		$this->programa->ValueList = "";
		$this->campania->SelectionList = "";
		$this->campania->DefaultSelectionList = "";
		$this->campania->ValueList = "";
		$this->asesor->SelectionList = "";
		$this->asesor->DefaultSelectionList = "";
		$this->asesor->ValueList = "";

		// Check if search command
		$this->SearchCommand = (@$_GET["cmd"] == "search");

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$this->Page_FilterLoad();

		// Set up popup filter
		$this->SetupPopup();

		// Load group db values if necessary
		$this->LoadGroupDbValues();

		// Handle Ajax popup
		$this->ProcessAjaxPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// Check if filter applied
		$this->FilterApplied = $this->CheckFilter();

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);
		$this->OtherOptions->GetItem("resetfilter")->Visible = $this->FilterApplied;

		// Get sort
		$this->Sort = $this->GetSort();

		// Get total group count
		$sGrpSort = ewr_UpdateSortFields($this->SqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
		$sSql = ewr_BuildReportSql($this->SqlSelectGroup(), $this->SqlWhere(), $this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderByGroup(), $this->Filter, $sGrpSort);
		$this->TotalGrps = $this->GetGrpCnt($sSql);
		if ($this->DisplayGrps <= 0 || $this->DrillDown) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowHeader = TRUE;

		// Set up start position if not export all
		if ($this->ExportAll && $this->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Hide all options if export
		if ($this->Export <> "") {
			$this->ExportOptions->HideAllOptions();
			$this->OtherOptions->HideAllOptions();
		}

		// Get current page groups
		$rsgrp = $this->GetGrpRs($sSql, $this->StartGrp, $this->DisplayGrps);

		// Init detail recordset
		$rs = NULL;
		$this->SetupFieldCount();
	}

	// Check level break
	function ChkLvlBreak($lvl) {
		switch ($lvl) {
			case 1:
				return (is_null($this->programa->CurrentValue) && !is_null($this->programa->OldValue)) ||
					(!is_null($this->programa->CurrentValue) && is_null($this->programa->OldValue)) ||
					($this->programa->GroupValue() <> $this->programa->GroupOldValue());
			case 2:
				return (is_null($this->campania->CurrentValue) && !is_null($this->campania->OldValue)) ||
					(!is_null($this->campania->CurrentValue) && is_null($this->campania->OldValue)) ||
					($this->campania->GroupValue() <> $this->campania->GroupOldValue()) || $this->ChkLvlBreak(1); // Recurse upper level
			case 3:
				return (is_null($this->asesor->CurrentValue) && !is_null($this->asesor->OldValue)) ||
					(!is_null($this->asesor->CurrentValue) && is_null($this->asesor->OldValue)) ||
					($this->asesor->GroupValue() <> $this->asesor->GroupOldValue()) || $this->ChkLvlBreak(2); // Recurse upper level
		}
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				if ($this->Col[$iy][0]) { // Accumulate required
					$valwrk = $this->Val[$iy];

					//***if (is_null($valwrk) || !is_numeric($valwrk)) {
					if (is_null($valwrk)) { // ***
						if (!$this->Col[$iy][1])
							$this->Cnt[$ix][$iy]++;
					} else {

						//***if (!$this->Col[$iy][1] || $valwrk <> 0) {
						$accum = (!$this->Col[$iy][1] || !is_numeric($valwrk) || $valwrk <> 0); // ***
						if ($accum) { // ***
							$this->Cnt[$ix][$iy]++;
							if (is_numeric($valwrk)) { // ***
								$this->Smry[$ix][$iy] += $valwrk;
								if (is_null($this->Mn[$ix][$iy])) {
									$this->Mn[$ix][$iy] = $valwrk;
									$this->Mx[$ix][$iy] = $valwrk;
								} else {
									if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
									if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
								}
							} // ***
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy][0]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->TotCount++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy][0]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {
					if (!$this->Col[$iy][1])
						$this->GrandCnt[$iy]++;
				} else {
					if (!$this->Col[$iy][1] || $valwrk <> 0) {
						$this->GrandCnt[$iy]++;
						$this->GrandSmry[$iy] += $valwrk;
						if (is_null($this->GrandMn[$iy])) {
							$this->GrandMn[$iy] = $valwrk;
							$this->GrandMx[$iy] = $valwrk;
						} else {
							if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
							if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
						}
					}
				}
			}
		}
	}

	// Get group count
	function GetGrpCnt($sql) {
		global $conn;
		$rsgrpcnt = $conn->Execute($sql);
		$grpcnt = ($rsgrpcnt) ? $rsgrpcnt->RecordCount() : 0;
		if ($rsgrpcnt) $rsgrpcnt->Close();
		return $grpcnt;
	}

	// Get group rs
	function GetGrpRs($sql, $start, $grps) {
		global $conn;
		$wrksql = $sql;
		if ($start > 0 && $grps > -1)
			$wrksql .= " LIMIT " . ($start-1) . ", " . ($grps);
		$rswrk = $conn->Execute($wrksql);
		return $rswrk;
	}

	// Get group row values
	function GetGrpRow($opt) {
		global $rsgrp;
		if (!$rsgrp)
			return;
		if ($opt == 1) { // Get first group

			//$rsgrp->MoveFirst(); // NOTE: no need to move position
			$this->programa->setDbValue(""); // Init first value
		} else { // Get next group
			$rsgrp->MoveNext();
		}
		if (!$rsgrp->EOF)
			$this->programa->setDbValue($rsgrp->fields[0]);
		if ($rsgrp->EOF) {
			$this->programa->setDbValue("");
		}
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
			if ($this->GrpCount == 1) {
				$this->FirstRowData = array();
				$this->FirstRowData['idasignar'] = ewr_Conv($rs->fields('idasignar'),3);
				$this->FirstRowData['nombre'] = ewr_Conv($rs->fields('nombre'),200);
				$this->FirstRowData['asesor'] = ewr_Conv($rs->fields('asesor'),200);
				$this->FirstRowData['idusuario'] = ewr_Conv($rs->fields('idusuario'),3);
				$this->FirstRowData['fecha'] = ewr_Conv($rs->fields('fecha'),133);
				$this->FirstRowData['campania'] = ewr_Conv($rs->fields('campania'),200);
				$this->FirstRowData['idcampania'] = ewr_Conv($rs->fields('idcampania'),3);
				$this->FirstRowData['campnom'] = ewr_Conv($rs->fields('campnom'),200);
				$this->FirstRowData['programa'] = ewr_Conv($rs->fields('programa'),200);
			}
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->idasignar->setDbValue($rs->fields('idasignar'));
			$this->nombre->setDbValue($rs->fields('nombre'));
			$this->asesor->setDbValue($rs->fields('asesor'));
			$this->idusuario->setDbValue($rs->fields('idusuario'));
			$this->fecha->setDbValue($rs->fields('fecha'));
			$this->campania->setDbValue($rs->fields('campania'));
			$this->idcampania->setDbValue($rs->fields('idcampania'));
			$this->campnom->setDbValue($rs->fields('campnom'));
			if ($opt <> 1) {
				if (is_array($this->programa->GroupDbValues))
					$this->programa->setDbValue(@$this->programa->GroupDbValues[$rs->fields('programa')]);
				else
					$this->programa->setDbValue(ewr_GroupValue($this->programa, $rs->fields('programa')));
			}
			$this->Val[1] = $this->fecha->CurrentValue;
		} else {
			$this->idasignar->setDbValue("");
			$this->nombre->setDbValue("");
			$this->asesor->setDbValue("");
			$this->idusuario->setDbValue("");
			$this->fecha->setDbValue("");
			$this->campania->setDbValue("");
			$this->idcampania->setDbValue("");
			$this->campnom->setDbValue("");
			$this->programa->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWR_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWR_TABLE_START_GROUP];
			$this->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$this->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $this->getStartGroup();
			}
		} else {
			$this->StartGrp = $this->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$this->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$this->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$this->setStartGroup($this->StartGrp);
		}
	}

	// Load group db values if necessary
	function LoadGroupDbValues() {
		global $conn;
	}

	// Process Ajax popup
	function ProcessAjaxPopup() {
		global $conn, $ReportLanguage;
		$fld = NULL;
		if (@$_GET["popup"] <> "") {
			$popupname = $_GET["popup"];

			// Check popup name
			// Build distinct values for programa

			if ($popupname == 'AsignaciF3n_programa') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;
				$sSql = ewr_BuildReportSql($this->programa->SqlSelect, $this->SqlWhere(), $this->SqlGroupBy(), $this->SqlHaving(), $this->programa->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->programa->setDbValue($rswrk->fields[0]);
					if (is_null($this->programa->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->programa->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						$this->programa->GroupViewValue = ewr_DisplayGroupValue($this->programa,$this->programa->GroupValue());
						ewr_SetupDistinctValues($this->programa->ValueList, $this->programa->GroupValue(), $this->programa->GroupViewValue, FALSE);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->programa->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->programa->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->programa;
			}

			// Build distinct values for campania
			if ($popupname == 'AsignaciF3n_campania') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;
				$sSql = ewr_BuildReportSql($this->campania->SqlSelect, $this->SqlWhere(), $this->SqlGroupBy(), $this->SqlHaving(), $this->campania->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->campania->setDbValue($rswrk->fields[0]);
					if (is_null($this->campania->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->campania->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						$this->campania->GroupViewValue = ewr_DisplayGroupValue($this->campania,$this->campania->GroupValue());
						ewr_SetupDistinctValues($this->campania->ValueList, $this->campania->GroupValue(), $this->campania->GroupViewValue, FALSE);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->campania->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->campania->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->campania;
			}

			// Build distinct values for asesor
			if ($popupname == 'AsignaciF3n_asesor') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;
				$sSql = ewr_BuildReportSql($this->asesor->SqlSelect, $this->SqlWhere(), $this->SqlGroupBy(), $this->SqlHaving(), $this->asesor->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->asesor->setDbValue($rswrk->fields[0]);
					if (is_null($this->asesor->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->asesor->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						$this->asesor->GroupViewValue = ewr_DisplayGroupValue($this->asesor,$this->asesor->GroupValue());
						ewr_SetupDistinctValues($this->asesor->ValueList, $this->asesor->GroupValue(), $this->asesor->GroupViewValue, FALSE);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->asesor->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->asesor->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->asesor;
			}

			// Output data as Json
			if (!is_null($fld)) {
				$jsdb = ewr_GetJsDb($fld, $fld->FldType);
				ob_end_clean();
				echo $jsdb;
				exit();
			}
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		if ($this->DrillDown)
			return;

		// Process post back form
		if (ewr_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = ewr_StripSlashes($_POST["sel_$sName"]);
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWR_INIT_VALUE;
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = ewr_StripSlashes(@$_POST["rf_$sName"]);
					$_SESSION["rt_$sName"] = ewr_StripSlashes(@$_POST["rt_$sName"]);
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ClearSessionSelection('programa');
				$this->ClearSessionSelection('campania');
				$this->ClearSessionSelection('asesor');
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
		// Get programa selected values

		if (is_array(@$_SESSION["sel_AsignaciF3n_programa"])) {
			$this->LoadSelectionFromSession('programa');
		} elseif (@$_SESSION["sel_AsignaciF3n_programa"] == EWR_INIT_VALUE) { // Select all
			$this->programa->SelectionList = "";
		}

		// Get campania selected values
		if (is_array(@$_SESSION["sel_AsignaciF3n_campania"])) {
			$this->LoadSelectionFromSession('campania');
		} elseif (@$_SESSION["sel_AsignaciF3n_campania"] == EWR_INIT_VALUE) { // Select all
			$this->campania->SelectionList = "";
		}

		// Get asesor selected values
		if (is_array(@$_SESSION["sel_AsignaciF3n_asesor"])) {
			$this->LoadSelectionFromSession('asesor');
		} elseif (@$_SESSION["sel_AsignaciF3n_asesor"] == EWR_INIT_VALUE) { // Select all
			$this->asesor->SelectionList = "";
		}
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		$this->StartGrp = 1;
		$this->setStartGroup($this->StartGrp);
	}

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
					$this->DisplayGrps = 5; // Non-numeric, load default
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
				$this->DisplayGrps = 5; // Load default
			}
		}
	}

	// Render row
	function RenderRow() {
		global $conn, $rs, $Security;
		if ($this->RowTotalType == EWR_ROWTOTAL_GRAND && !$this->GrandSummarySetup) { // Grand total
			$bGotCount = FALSE;
			$bGotSummary = FALSE;

			// Get total count from sql directly
			$sSql = ewr_BuildReportSql($this->SqlSelectCount(), $this->SqlWhere(), $this->SqlGroupBy(), $this->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
				$bGotCount = TRUE;
			} else {
				$this->TotCount = 0;
			}
		$bGotSummary = TRUE;

			// Accumulate grand summary from detail records
			if (!$bGotCount || !$bGotSummary) {
				$sSql = ewr_BuildReportSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(), $this->SqlHaving(), "", $this->Filter, "");
				$rs = $conn->Execute($sSql);
				if ($rs) {
					$this->GetRow(1);
					while (!$rs->EOF) {
						$this->AccumulateGrandSummary();
						$this->GetRow(2);
					}
					$rs->Close();
				}
			}
			$this->GrandSummarySetup = TRUE; // No need to set up again
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		//
		// Render view codes
		//

		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row

			// programa
			$this->programa->GroupViewValue = $this->programa->GroupOldValue();
			$this->programa->CellAttrs["class"] = ($this->RowGroupLevel == 1) ? "ewRptGrpSummary1" : "ewRptGrpField1";
			$this->programa->GroupViewValue = ewr_DisplayGroupValue($this->programa, $this->programa->GroupViewValue);
			$this->programa->GroupSummaryOldValue = $this->programa->GroupSummaryValue;
			$this->programa->GroupSummaryValue = $this->programa->GroupViewValue;
			$this->programa->GroupSummaryViewValue = ($this->programa->GroupSummaryOldValue <> $this->programa->GroupSummaryValue) ? $this->programa->GroupSummaryValue : "&nbsp;";

			// campania
			$this->campania->GroupViewValue = $this->campania->GroupOldValue();
			$this->campania->CellAttrs["class"] = ($this->RowGroupLevel == 2) ? "ewRptGrpSummary2" : "ewRptGrpField2";
			$this->campania->GroupViewValue = ewr_DisplayGroupValue($this->campania, $this->campania->GroupViewValue);
			$this->campania->GroupSummaryOldValue = $this->campania->GroupSummaryValue;
			$this->campania->GroupSummaryValue = $this->campania->GroupViewValue;
			$this->campania->GroupSummaryViewValue = ($this->campania->GroupSummaryOldValue <> $this->campania->GroupSummaryValue) ? $this->campania->GroupSummaryValue : "&nbsp;";

			// asesor
			$this->asesor->GroupViewValue = $this->asesor->GroupOldValue();
			$this->asesor->CellAttrs["class"] = ($this->RowGroupLevel == 3) ? "ewRptGrpSummary3" : "ewRptGrpField3";
			$this->asesor->GroupViewValue = ewr_DisplayGroupValue($this->asesor, $this->asesor->GroupViewValue);
			$this->asesor->GroupSummaryOldValue = $this->asesor->GroupSummaryValue;
			$this->asesor->GroupSummaryValue = $this->asesor->GroupViewValue;
			$this->asesor->GroupSummaryViewValue = ($this->asesor->GroupSummaryOldValue <> $this->asesor->GroupSummaryValue) ? $this->asesor->GroupSummaryValue : "&nbsp;";

			// programa
			$this->programa->HrefValue = "";

			// campania
			$this->campania->HrefValue = "";

			// asesor
			$this->asesor->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";
		} else {

			// programa
			$this->programa->GroupViewValue = $this->programa->GroupValue();
			$this->programa->CellAttrs["class"] = "ewRptGrpField1";
			$this->programa->GroupViewValue = ewr_DisplayGroupValue($this->programa, $this->programa->GroupViewValue);
			if ($this->programa->GroupValue() == $this->programa->GroupOldValue() && !$this->ChkLvlBreak(1))
				$this->programa->GroupViewValue = "&nbsp;";

			// campania
			$this->campania->GroupViewValue = $this->campania->GroupValue();
			$this->campania->CellAttrs["class"] = "ewRptGrpField2";
			$this->campania->GroupViewValue = ewr_DisplayGroupValue($this->campania, $this->campania->GroupViewValue);
			if ($this->campania->GroupValue() == $this->campania->GroupOldValue() && !$this->ChkLvlBreak(2))
				$this->campania->GroupViewValue = "&nbsp;";

			// asesor
			$this->asesor->GroupViewValue = $this->asesor->GroupValue();
			$this->asesor->CellAttrs["class"] = "ewRptGrpField3";
			$this->asesor->GroupViewValue = ewr_DisplayGroupValue($this->asesor, $this->asesor->GroupViewValue);
			if ($this->asesor->GroupValue() == $this->asesor->GroupOldValue() && !$this->ChkLvlBreak(3))
				$this->asesor->GroupViewValue = "&nbsp;";

			// fecha
			$this->fecha->ViewValue = $this->fecha->CurrentValue;
			$this->fecha->ViewValue = ewr_FormatDateTime($this->fecha->ViewValue, 7);
			$this->fecha->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// programa
			$this->programa->HrefValue = "";

			// campania
			$this->campania->HrefValue = "";

			// asesor
			$this->asesor->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row

			// programa
			$CurrentValue = $this->programa->GroupViewValue;
			$ViewValue = &$this->programa->GroupViewValue;
			$ViewAttrs = &$this->programa->ViewAttrs;
			$CellAttrs = &$this->programa->CellAttrs;
			$HrefValue = &$this->programa->HrefValue;
			$LinkAttrs = &$this->programa->LinkAttrs;
			$this->Cell_Rendered($this->programa, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// campania
			$CurrentValue = $this->campania->GroupViewValue;
			$ViewValue = &$this->campania->GroupViewValue;
			$ViewAttrs = &$this->campania->ViewAttrs;
			$CellAttrs = &$this->campania->CellAttrs;
			$HrefValue = &$this->campania->HrefValue;
			$LinkAttrs = &$this->campania->LinkAttrs;
			$this->Cell_Rendered($this->campania, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// asesor
			$CurrentValue = $this->asesor->GroupViewValue;
			$ViewValue = &$this->asesor->GroupViewValue;
			$ViewAttrs = &$this->asesor->ViewAttrs;
			$CellAttrs = &$this->asesor->CellAttrs;
			$HrefValue = &$this->asesor->HrefValue;
			$LinkAttrs = &$this->asesor->LinkAttrs;
			$this->Cell_Rendered($this->asesor, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		} else {

			// programa
			$CurrentValue = $this->programa->GroupValue();
			$ViewValue = &$this->programa->GroupViewValue;
			$ViewAttrs = &$this->programa->ViewAttrs;
			$CellAttrs = &$this->programa->CellAttrs;
			$HrefValue = &$this->programa->HrefValue;
			$LinkAttrs = &$this->programa->LinkAttrs;
			$this->Cell_Rendered($this->programa, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// campania
			$CurrentValue = $this->campania->GroupValue();
			$ViewValue = &$this->campania->GroupViewValue;
			$ViewAttrs = &$this->campania->ViewAttrs;
			$CellAttrs = &$this->campania->CellAttrs;
			$HrefValue = &$this->campania->HrefValue;
			$LinkAttrs = &$this->campania->LinkAttrs;
			$this->Cell_Rendered($this->campania, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// asesor
			$CurrentValue = $this->asesor->GroupValue();
			$ViewValue = &$this->asesor->GroupViewValue;
			$ViewAttrs = &$this->asesor->ViewAttrs;
			$CellAttrs = &$this->asesor->CellAttrs;
			$HrefValue = &$this->asesor->HrefValue;
			$LinkAttrs = &$this->asesor->LinkAttrs;
			$this->Cell_Rendered($this->asesor, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// fecha
			$CurrentValue = $this->fecha->CurrentValue;
			$ViewValue = &$this->fecha->ViewValue;
			$ViewAttrs = &$this->fecha->ViewAttrs;
			$CellAttrs = &$this->fecha->CellAttrs;
			$HrefValue = &$this->fecha->HrefValue;
			$LinkAttrs = &$this->fecha->LinkAttrs;
			$this->Cell_Rendered($this->fecha, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->SetupFieldCount();
	}

	// Setup field count
	function SetupFieldCount() {
		$this->GrpFldCount = 0;
		$this->SubGrpFldCount = 0;
		$this->DtlFldCount = 0;
		if ($this->programa->Visible) $this->GrpFldCount += 1;
		if ($this->campania->Visible) { $this->GrpFldCount += 1; $this->SubGrpFldCount += 1; }
		if ($this->asesor->Visible) { $this->GrpFldCount += 1; $this->SubGrpFldCount += 1; }
		if ($this->fecha->Visible) $this->DtlFldCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = ewr_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("summary", $this->TableVar, $url, $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage;
		$item =& $this->ExportOptions->GetItem("pdf");
		$item->Visible = FALSE;
		$exportid = session_id();
		$url = $this->ExportPdfUrl;
		$item->Body = "<a data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDFText")) . "\" href=\"javascript:void(0);\" onclick=\"ewr_ExportCharts(this, '" . $url . "', '" . $exportid . "');\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_AsignaciF3n_$parm"] = "";
		$_SESSION["rf_AsignaciF3n_$parm"] = "";
		$_SESSION["rt_AsignaciF3n_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_AsignaciF3n_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_AsignaciF3n_$parm"];
		$fld->RangeTo = @$_SESSION["rt_AsignaciF3n_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {

		/**
		* Set up default values for non Text filters
		*/

		/**
		* Set up default values for extended filters
		* function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2)
		* Parameters:
		* $fld - Field object
		* $so1 - Default search operator 1
		* $sv1 - Default ext filter value 1
		* $sc - Default search condition (if operator 2 is enabled)
		* $so2 - Default search operator 2 (if operator 2 is enabled)
		* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
		*/

		/**
		* Set up default values for popup filters
		*/

		// Field asesor
		// $this->asesor->DefaultSelectionList = array("val1", "val2");
		// Field campania
		// $this->campania->DefaultSelectionList = array("val1", "val2");
		// Field programa
		// $this->programa->DefaultSelectionList = array("val1", "val2");

	}

	// Check if filter applied
	function CheckFilter() {

		// Check asesor popup filter
		if (!ewr_MatchedArray($this->asesor->DefaultSelectionList, $this->asesor->SelectionList))
			return TRUE;

		// Check campania popup filter
		if (!ewr_MatchedArray($this->campania->DefaultSelectionList, $this->campania->SelectionList))
			return TRUE;

		// Check programa popup filter
		if (!ewr_MatchedArray($this->programa->DefaultSelectionList, $this->programa->SelectionList))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field asesor
		$sExtWrk = "";
		$sWrk = "";
		if (is_array($this->asesor->SelectionList))
			$sWrk = ewr_JoinArray($this->asesor->SelectionList, ", ", EWR_DATATYPE_STRING);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->asesor->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field campania
		$sExtWrk = "";
		$sWrk = "";
		if (is_array($this->campania->SelectionList))
			$sWrk = ewr_JoinArray($this->campania->SelectionList, ", ", EWR_DATATYPE_STRING);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->campania->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field programa
		$sExtWrk = "";
		$sWrk = "";
		if (is_array($this->programa->SelectionList))
			$sWrk = ewr_JoinArray($this->programa->SelectionList, ", ", EWR_DATATYPE_STRING);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->programa->FldCaption() . "</span>" . $sFilter . "</div>";
		$divstyle = "";
		$divdataclass = "";

		// Show Filters
		if ($sFilterList <> "") {
			$sMessage = "<div class=\"ewDisplayTable\"" . $divstyle . "><div id=\"ewrFilterList\" class=\"alert alert-info\"" . $divdataclass . "><div id=\"ewrCurrentFilters\">" . $ReportLanguage->Phrase("CurrentFilters") . "</div>" . $sFilterList . "</div></div>";
			$this->Message_Showing($sMessage, "");
			echo $sMessage;
		}
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
			if (is_array($this->asesor->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->asesor, "`asesor`", EWR_DATATYPE_STRING);

				// Call Page Filtering event
				$this->Page_Filtering($this->asesor, $sFilter, "popup");
				$this->asesor->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
			if (is_array($this->campania->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->campania, "`campania`", EWR_DATATYPE_STRING);

				// Call Page Filtering event
				$this->Page_Filtering($this->campania, $sFilter, "popup");
				$this->campania->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
			if (is_array($this->programa->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->programa, "`programa`", EWR_DATATYPE_STRING);

				// Call Page Filtering event
				$this->Page_Filtering($this->programa, $sFilter, "popup");
				$this->programa->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWR_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		if ($this->DrillDown)
			return "";

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$this->setOrderBy("");
				$this->setStartGroup(1);
				$this->programa->setSort("");
				$this->campania->setSort("");
				$this->asesor->setSort("");
				$this->fecha->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$this->CurrentOrder = ewr_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $this->SortSql();
			$this->setOrderBy($sSortSql);
			$this->setStartGroup(1);
		}
		return $this->getOrderBy();
	}

	// Export to HTML
	function ExportHtml($html) {

		//global $gsExportFile;
		//header('Content-Type: text/html' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
		//header('Content-Disposition: attachment; filename=' . $gsExportFile . '.html');
		//echo $html;

	} 

	// Export to EXCEL
	function ExportExcel($html) {
		global $gsExportFile;
		header('Content-Type: application/vnd.ms-excel' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
		header('Content-Disposition: attachment; filename=' . $gsExportFile . '.xls');
		echo $html;
	}

	// Export PDF
	function ExportPDF($html) {
		global $gsExportFile;
		include_once "dompdf060b3/dompdf_config.inc.php";
		@ini_set("memory_limit", EWR_PDF_MEMORY_LIMIT);
		set_time_limit(EWR_PDF_TIME_LIMIT);
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		ob_end_clean();
		$dompdf->set_paper("a4", "portrait");
		$dompdf->render();
		ewr_DeleteTmpImages();
		$dompdf->stream($gsExportFile . ".pdf", array("Attachment" => 1)); // 0 to open in browser, 1 to download

//		exit();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ewr_Header(FALSE) ?>
<?php

// Create page object
if (!isset($AsignaciF3n_summary)) $AsignaciF3n_summary = new crAsignaciF3n_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$AsignaciF3n_summary;

// Page init
$Page->Page_Init();

// Page main
$Page->Page_Main();

// Global Page Rendering event (in ewrusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php include_once "phprptinc/header.php" ?>
<?php if ($Page->Export == "" || $Page->Export == "print" || $Page->Export == "email" && (@$giFcfChartCnt > 0 || @$gsEmailContentType == "url")) { ?>
<script type="text/javascript">

// Create page object
var AsignaciF3n_summary = new ewr_Page("AsignaciF3n_summary");

// Page properties
AsignaciF3n_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = AsignaciF3n_summary.PageID;

// Extend page with Chart_Rendering function
AsignaciF3n_summary.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
AsignaciF3n_summary.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($Page->Export == "") { ?>
<!-- container (begin) -->
<div id="ewContainer">
<!-- top container (begin) -->
<div id="ewTop">
<a id="top"></a>
<?php } ?>
<!-- top slot -->
<?php if ($Page->Export == "" && (!$Page->DrillDown || !$Page->DrillDownInPanel)) { ?>
<?php $ReportBreadcrumb->Render(); ?>
<?php } ?>
<div class="ewReportOptions">
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->Render("body");
	$Page->OtherOptions->Render("body");
}
?>
</div>
<?php $Page->ShowPageHeader(); ?>
<?php $Page->ShowMessage(); ?>
<?php if ($Page->Export == "") { ?>
</div>
<!-- top container (end) -->
	<!-- left container (begin) -->
	<div id="ewLeft" class="pull-left">
<?php } ?>
	<!-- Left slot -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- left container (end) -->
	<!-- center container - report (begin) -->
	<div id="ewCenter" class="pull-left">
<?php } ?>
	<!-- center slot -->
<!-- summary report starts -->
<div id="report_summary">
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->ShowFilterList() ?>
<?php } ?>
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGrp = $Page->TotalGrps;
} else {
	$Page->StopGrp = $Page->StartGrp + $Page->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGrp) > intval($Page->TotalGrps))
	$Page->StopGrp = $Page->TotalGrps;
$Page->RecCount = 0;

// Get first row
if ($Page->TotalGrps > 0) {
	$Page->GetGrpRow(1);
	$Page->GrpCounter[0] = 1;
	$Page->GrpCounter[1] = 1;
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray($Page->StopGrp - $Page->StartGrp + 1, -1);
$Page->GrpIdx[0] = -1;
while ($rsgrp && !$rsgrp->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->GrpCount > 1) { ?>
</tbody>
</table>
</div>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="ewGridLowerPanel">
<?php include "asignacif3nsmrypager.php" ?>
</div>
<?php } ?>
</td></tr></table>
<span data-class="tpb<?php echo $Page->GrpCount-1 ?>_AsignaciF3n"><?php echo $Page->PageBreakContent ?></span>
<?php } ?>
<table class="ewGrid"<?php echo $Page->ReportTableStyle ?>><tr>
	<td class="ewGridContent">
<!-- Report grid (begin) -->
<div class="ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->programa->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="programa"><div class="AsignaciF3n_programa"><span class="ewTableHeaderCaption"><?php echo $Page->programa->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="programa">
<?php if ($Page->SortUrl($Page->programa) == "") { ?>
		<div class="ewTableHeaderBtn AsignaciF3n_programa">
			<span class="ewTableHeaderCaption"><?php echo $Page->programa->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" onclick="ewr_ShowPopup.call(this, event, 'AsignaciF3n_programa', false, '<?php echo $Page->programa->RangeFrom; ?>', '<?php echo $Page->programa->RangeTo; ?>');" id="x_programa<?php echo $Page->Cnt[0][0]; ?>"><span class="glyphicon glyphicon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer AsignaciF3n_programa" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->programa) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->programa->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->programa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->programa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" onclick="ewr_ShowPopup.call(this, event, 'AsignaciF3n_programa', false, '<?php echo $Page->programa->RangeFrom; ?>', '<?php echo $Page->programa->RangeTo; ?>');" id="x_programa<?php echo $Page->Cnt[0][0]; ?>"><span class="glyphicon glyphicon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->campania->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="campania"><div class="AsignaciF3n_campania"><span class="ewTableHeaderCaption"><?php echo $Page->campania->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="campania">
<?php if ($Page->SortUrl($Page->campania) == "") { ?>
		<div class="ewTableHeaderBtn AsignaciF3n_campania">
			<span class="ewTableHeaderCaption"><?php echo $Page->campania->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" onclick="ewr_ShowPopup.call(this, event, 'AsignaciF3n_campania', false, '<?php echo $Page->campania->RangeFrom; ?>', '<?php echo $Page->campania->RangeTo; ?>');" id="x_campania<?php echo $Page->Cnt[0][0]; ?>"><span class="glyphicon glyphicon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer AsignaciF3n_campania" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->campania) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->campania->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->campania->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->campania->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" onclick="ewr_ShowPopup.call(this, event, 'AsignaciF3n_campania', false, '<?php echo $Page->campania->RangeFrom; ?>', '<?php echo $Page->campania->RangeTo; ?>');" id="x_campania<?php echo $Page->Cnt[0][0]; ?>"><span class="glyphicon glyphicon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->asesor->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="asesor"><div class="AsignaciF3n_asesor"><span class="ewTableHeaderCaption"><?php echo $Page->asesor->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="asesor">
<?php if ($Page->SortUrl($Page->asesor) == "") { ?>
		<div class="ewTableHeaderBtn AsignaciF3n_asesor">
			<span class="ewTableHeaderCaption"><?php echo $Page->asesor->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" onclick="ewr_ShowPopup.call(this, event, 'AsignaciF3n_asesor', false, '<?php echo $Page->asesor->RangeFrom; ?>', '<?php echo $Page->asesor->RangeTo; ?>');" id="x_asesor<?php echo $Page->Cnt[0][0]; ?>"><span class="glyphicon glyphicon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer AsignaciF3n_asesor" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->asesor) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->asesor->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->asesor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->asesor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" onclick="ewr_ShowPopup.call(this, event, 'AsignaciF3n_asesor', false, '<?php echo $Page->asesor->RangeFrom; ?>', '<?php echo $Page->asesor->RangeTo; ?>');" id="x_asesor<?php echo $Page->Cnt[0][0]; ?>"><span class="glyphicon glyphicon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->fecha->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="fecha"><div class="AsignaciF3n_fecha"><span class="ewTableHeaderCaption"><?php echo $Page->fecha->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="fecha">
<?php if ($Page->SortUrl($Page->fecha) == "") { ?>
		<div class="ewTableHeaderBtn AsignaciF3n_fecha">
			<span class="ewTableHeaderCaption"><?php echo $Page->fecha->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer AsignaciF3n_fecha" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->fecha) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->fecha->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGrps == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}

	// Build detail SQL
	$sWhere = ewr_DetailFilterSQL($Page->programa, $Page->SqlFirstGroupField(), $Page->programa->GroupValue());
	if ($Page->PageFirstGroupFilter <> "") $Page->PageFirstGroupFilter .= " OR ";
	$Page->PageFirstGroupFilter .= $sWhere;
	if ($Page->Filter != "")
		$sWhere = "($Page->Filter) AND ($sWhere)";
	$sSql = ewr_BuildReportSql($Page->SqlSelect(), $Page->SqlWhere(), $Page->SqlGroupBy(), $Page->SqlHaving(), $Page->SqlOrderBy(), $sWhere, $Page->Sort);
	$rs = $conn->Execute($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		$Page->GetRow(1);
	$Page->GrpIdx[$Page->GrpCount] = array(-1);
	$Page->GrpIdx[$Page->GrpCount][] = array(-1);
	while ($rs && !$rs->EOF) { // Loop detail records
		$Page->RecCount++;

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->programa->Visible) { ?>
		<td data-field="programa"<?php echo $Page->programa->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_AsignaciF3n_programa"<?php echo $Page->programa->ViewAttributes() ?>><?php echo $Page->programa->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->campania->Visible) { ?>
		<td data-field="campania"<?php echo $Page->campania->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_AsignaciF3n_campania"<?php echo $Page->campania->ViewAttributes() ?>><?php echo $Page->campania->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->asesor->Visible) { ?>
		<td data-field="asesor"<?php echo $Page->asesor->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_AsignaciF3n_asesor"<?php echo $Page->asesor->ViewAttributes() ?>><?php echo $Page->asesor->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->fecha->Visible) { ?>
		<td data-field="fecha"<?php echo $Page->fecha->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_AsignaciF3n_fecha"<?php echo $Page->fecha->ViewAttributes() ?>><?php echo $Page->fecha->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php

	// Next group
	$Page->GetGrpRow(2);

	// Show header if page break
	if ($Page->Export <> "")
		$Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? FALSE : ($Page->GrpCount % $Page->ExportPageBreakCount == 0);

	// Page_Breaking server event
	if ($Page->ShowHeader)
		$Page->Page_Breaking($Page->ShowHeader, $Page->PageBreakContent);
	$Page->GrpCount++;
	$Page->GrpCounter[1] = 1;
	$Page->GrpCounter[0] = 1;

	// Handle EOF
	if (!$rsgrp || $rsgrp->EOF)
		$Page->ShowHeader = FALSE;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
<?php
	$Page->ResetAttrs();
	$Page->RowType = EWR_ROWTYPE_TOTAL;
	$Page->RowTotalType = EWR_ROWTOTAL_GRAND;
	$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
	$Page->RowAttrs["class"] = "ewRptGrandSummary";
	$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>><td colspan="<?php echo ($Page->GrpFldCount + $Page->DtlFldCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
	</tfoot>
<?php } elseif (!$Page->ShowHeader) { // No header displayed ?>
<table class="ewGrid"<?php echo $Page->ReportTableStyle ?>><tr>
	<td class="ewGridContent">
<!-- Report grid (begin) -->
<div class="ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
</table>
</div>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="ewGridLowerPanel">
<?php include "asignacif3nsmrypager.php" ?>
</div>
<?php } ?>
</td></tr></table>
</div>
<!-- Summary Report Ends -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- center container - report (end) -->
	<!-- right container (begin) -->
	<div id="ewRight" class="pull-left">
<?php } ?>
	<!-- Right slot -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- right container (end) -->
<div class="clearfix"></div>
<!-- bottom container (begin) -->
<div id="ewBottom">
<?php } ?>
	<!-- Bottom slot -->
<?php if ($Page->Export == "") { ?>
	</div>
<!-- Bottom Container (End) -->
</div>
<!-- Table Container (End) -->
<?php } ?>
<?php $Page->ShowPageFooter(); ?>
<?php if (EWR_DEBUG_ENABLED) echo ewr_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php" ?>
<?php
$Page->Page_Terminate();
if (isset($OldPage)) $Page = $OldPage;
?>
