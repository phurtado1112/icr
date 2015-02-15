<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg7.php" ?>
<?php include_once "phprptinc/ewmysql.php" ?>
<?php include_once "phprptinc/ewrfn7.php" ?>
<?php include_once "phprptinc/ewrusrfn.php" ?>
<?php include_once "rep_estado_campaniasmryinfo.php" ?>
<?php

//
// Page class
//

$Rep_Estado_Campania_summary = NULL; // Initialize page object first

class crRep_Estado_Campania_summary extends crRep_Estado_Campania {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{FBAFD19E-E753-4738-84A0-8DC7FC3CBD41}";

	// Page object name
	var $PageObjName = 'Rep_Estado_Campania_summary';

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

		// Table object (Rep_Estado_Campania)
		if (!isset($GLOBALS["Rep_Estado_Campania"])) {
			$GLOBALS["Rep_Estado_Campania"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["Rep_Estado_Campania"];
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
			define("EWR_TABLE_NAME", 'Rep_Estado_Campania', TRUE);

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
//		$item->Visible = TRUE;
		// Export to Email

		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmailText")) . "\" id=\"emf_Rep_Estado_Campania\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_Rep_Estado_Campania',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
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
	var $DisplayGrps = 20; // Groups per page
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

		$nDtls = 11;
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
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(TRUE,FALSE), array(TRUE,FALSE), array(TRUE,FALSE), array(FALSE,FALSE), array(TRUE,FALSE), array(TRUE,FALSE), array(TRUE,FALSE), array(TRUE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
		$this->fechainicio->SelectionList = "";
		$this->fechainicio->DefaultSelectionList = "";
		$this->fechainicio->ValueList = "";
		$this->fechafin->SelectionList = "";
		$this->fechafin->DefaultSelectionList = "";
		$this->fechafin->ValueList = "";

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
				return (is_null($this->nombre->CurrentValue) && !is_null($this->nombre->OldValue)) ||
					(!is_null($this->nombre->CurrentValue) && is_null($this->nombre->OldValue)) ||
					($this->nombre->GroupValue() <> $this->nombre->GroupOldValue()) || $this->ChkLvlBreak(2); // Recurse upper level
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
				$this->FirstRowData['idcampania'] = ewr_Conv($rs->fields('idcampania'),3);
				$this->FirstRowData['campania'] = ewr_Conv($rs->fields('campania'),200);
				$this->FirstRowData['terminada'] = ewr_Conv($rs->fields('terminada'),200);
				$this->FirstRowData['fechainicio'] = ewr_Conv($rs->fields('fechainicio'),133);
				$this->FirstRowData['fechafin'] = ewr_Conv($rs->fields('fechafin'),133);
				$this->FirstRowData['idprograma'] = ewr_Conv($rs->fields('idprograma'),3);
				$this->FirstRowData['programa'] = ewr_Conv($rs->fields('programa'),200);
				$this->FirstRowData['idusuario'] = ewr_Conv($rs->fields('idusuario'),3);
				$this->FirstRowData['nombre'] = ewr_Conv($rs->fields('nombre'),200);
				$this->FirstRowData['ATENDIDO'] = ewr_Conv($rs->fields('ATENDIDO'),131);
				$this->FirstRowData['PENDIENTE'] = ewr_Conv($rs->fields('PENDIENTE'),131);
				$this->FirstRowData['TOTAL'] = ewr_Conv($rs->fields('TOTAL'),20);
				$this->FirstRowData['PROCENT'] = ewr_Conv($rs->fields('PROCENT'),131);
				$this->FirstRowData['CALIFICADO'] = ewr_Conv($rs->fields('CALIFICADO'),131);
				$this->FirstRowData['NOINTERESADO'] = ewr_Conv($rs->fields('NOINTERESADO'),131);
				$this->FirstRowData['OTROPROGRAMA'] = ewr_Conv($rs->fields('OTROPROGRAMA'),131);
				$this->FirstRowData['FALLIDA'] = ewr_Conv($rs->fields('FALLIDA'),131);
				$this->FirstRowData['Otras'] = ewr_Conv($rs->fields('Otras'),131);
			}
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->idasignar->setDbValue($rs->fields('idasignar'));
			$this->idcampania->setDbValue($rs->fields('idcampania'));
			$this->campania->setDbValue($rs->fields('campania'));
			$this->terminada->setDbValue($rs->fields('terminada'));
			$this->fechainicio->setDbValue($rs->fields('fechainicio'));
			$this->fechafin->setDbValue($rs->fields('fechafin'));
			$this->idprograma->setDbValue($rs->fields('idprograma'));
			if ($opt <> 1) {
				if (is_array($this->programa->GroupDbValues))
					$this->programa->setDbValue(@$this->programa->GroupDbValues[$rs->fields('programa')]);
				else
					$this->programa->setDbValue(ewr_GroupValue($this->programa, $rs->fields('programa')));
			}
			$this->idusuario->setDbValue($rs->fields('idusuario'));
			$this->nombre->setDbValue($rs->fields('nombre'));
			$this->ATENDIDO->setDbValue($rs->fields('ATENDIDO'));
			$this->PENDIENTE->setDbValue($rs->fields('PENDIENTE'));
			$this->TOTAL->setDbValue($rs->fields('TOTAL'));
			$this->PROCENT->setDbValue($rs->fields('PROCENT'));
			$this->CALIFICADO->setDbValue($rs->fields('CALIFICADO'));
			$this->NOINTERESADO->setDbValue($rs->fields('NOINTERESADO'));
			$this->OTROPROGRAMA->setDbValue($rs->fields('OTROPROGRAMA'));
			$this->FALLIDA->setDbValue($rs->fields('FALLIDA'));
			$this->Otras->setDbValue($rs->fields('Otras'));
			$this->Val[1] = $this->fechainicio->CurrentValue;
			$this->Val[2] = $this->fechafin->CurrentValue;
			$this->Val[3] = $this->ATENDIDO->CurrentValue;
			$this->Val[4] = $this->PENDIENTE->CurrentValue;
			$this->Val[5] = $this->TOTAL->CurrentValue;
			$this->Val[6] = $this->PROCENT->CurrentValue;
			$this->Val[7] = $this->CALIFICADO->CurrentValue;
			$this->Val[8] = $this->NOINTERESADO->CurrentValue;
			$this->Val[9] = $this->OTROPROGRAMA->CurrentValue;
			$this->Val[10] = $this->FALLIDA->CurrentValue;
		} else {
			$this->idasignar->setDbValue("");
			$this->idcampania->setDbValue("");
			$this->campania->setDbValue("");
			$this->terminada->setDbValue("");
			$this->fechainicio->setDbValue("");
			$this->fechafin->setDbValue("");
			$this->idprograma->setDbValue("");
			$this->programa->setDbValue("");
			$this->idusuario->setDbValue("");
			$this->nombre->setDbValue("");
			$this->ATENDIDO->setDbValue("");
			$this->PENDIENTE->setDbValue("");
			$this->TOTAL->setDbValue("");
			$this->PROCENT->setDbValue("");
			$this->CALIFICADO->setDbValue("");
			$this->NOINTERESADO->setDbValue("");
			$this->OTROPROGRAMA->setDbValue("");
			$this->FALLIDA->setDbValue("");
			$this->Otras->setDbValue("");
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
			// Build distinct values for fechainicio

			if ($popupname == 'Rep_Estado_Campania_fechainicio') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;
				$sSql = ewr_BuildReportSql($this->fechainicio->SqlSelect, $this->SqlWhere(), $this->SqlGroupBy(), $this->SqlHaving(), $this->fechainicio->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->fechainicio->setDbValue($rswrk->fields[0]);
					if (is_null($this->fechainicio->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->fechainicio->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						$this->fechainicio->ViewValue = ewr_FormatDateTime($this->fechainicio->CurrentValue, 7);
						ewr_SetupDistinctValues($this->fechainicio->ValueList, $this->fechainicio->CurrentValue, $this->fechainicio->ViewValue, FALSE, $this->fechainicio->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->fechainicio->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->fechainicio->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->fechainicio;
			}

			// Build distinct values for fechafin
			if ($popupname == 'Rep_Estado_Campania_fechafin') {
				$bNullValue = FALSE;
				$bEmptyValue = FALSE;
				$sFilter = $this->Filter;
				$sSql = ewr_BuildReportSql($this->fechafin->SqlSelect, $this->SqlWhere(), $this->SqlGroupBy(), $this->SqlHaving(), $this->fechafin->SqlOrderBy, $sFilter, "");
				$rswrk = $conn->Execute($sSql);
				while ($rswrk && !$rswrk->EOF) {
					$this->fechafin->setDbValue($rswrk->fields[0]);
					if (is_null($this->fechafin->CurrentValue)) {
						$bNullValue = TRUE;
					} elseif ($this->fechafin->CurrentValue == "") {
						$bEmptyValue = TRUE;
					} else {
						$this->fechafin->ViewValue = ewr_FormatDateTime($this->fechafin->CurrentValue, 7);
						ewr_SetupDistinctValues($this->fechafin->ValueList, $this->fechafin->CurrentValue, $this->fechafin->ViewValue, FALSE, $this->fechafin->FldDelimiter);
					}
					$rswrk->MoveNext();
				}
				if ($rswrk)
					$rswrk->Close();
				if ($bEmptyValue)
					ewr_SetupDistinctValues($this->fechafin->ValueList, EWR_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
				if ($bNullValue)
					ewr_SetupDistinctValues($this->fechafin->ValueList, EWR_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);
				$fld = &$this->fechafin;
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
				$this->ClearSessionSelection('fechainicio');
				$this->ClearSessionSelection('fechafin');
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
		// Get fechainicio selected values

		if (is_array(@$_SESSION["sel_Rep_Estado_Campania_fechainicio"])) {
			$this->LoadSelectionFromSession('fechainicio');
		} elseif (@$_SESSION["sel_Rep_Estado_Campania_fechainicio"] == EWR_INIT_VALUE) { // Select all
			$this->fechainicio->SelectionList = "";
		}

		// Get fechafin selected values
		if (is_array(@$_SESSION["sel_Rep_Estado_Campania_fechafin"])) {
			$this->LoadSelectionFromSession('fechafin');
		} elseif (@$_SESSION["sel_Rep_Estado_Campania_fechafin"] == EWR_INIT_VALUE) { // Select all
			$this->fechafin->SelectionList = "";
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
					$this->DisplayGrps = 20; // Non-numeric, load default
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
				$this->DisplayGrps = 20; // Load default
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

			// Get total from sql directly
			$sSql = ewr_BuildReportSql($this->SqlSelectAgg(), $this->SqlWhere(), $this->SqlGroupBy(), $this->SqlHaving(), "", $this->Filter, "");
			$sSql = $this->SqlAggPfx() . $sSql . $this->SqlAggSfx();
			$rsagg = $conn->Execute($sSql);
			if ($rsagg) {
				$this->GrandCnt[1] = $this->TotCount;
				$this->GrandCnt[2] = $this->TotCount;
				$this->GrandCnt[3] = $this->TotCount;
				$this->GrandSmry[3] = $rsagg->fields("sum_atendido");
				$this->GrandCnt[4] = $this->TotCount;
				$this->GrandSmry[4] = $rsagg->fields("sum_pendiente");
				$this->GrandCnt[5] = $this->TotCount;
				$this->GrandSmry[5] = $rsagg->fields("sum_total");
				$this->GrandCnt[6] = $this->TotCount;
				$this->GrandCnt[7] = $this->TotCount;
				$this->GrandSmry[7] = $rsagg->fields("sum_calificado");
				$this->GrandCnt[8] = $this->TotCount;
				$this->GrandSmry[8] = $rsagg->fields("sum_nointeresado");
				$this->GrandCnt[9] = $this->TotCount;
				$this->GrandSmry[9] = $rsagg->fields("sum_otroprograma");
				$this->GrandCnt[10] = $this->TotCount;
				$this->GrandSmry[10] = $rsagg->fields("sum_fallida");
				$rsagg->Close();
				$bGotSummary = TRUE;
			}

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

			// nombre
			$this->nombre->GroupViewValue = $this->nombre->GroupOldValue();
			$this->nombre->CellAttrs["class"] = ($this->RowGroupLevel == 3) ? "ewRptGrpSummary3" : "ewRptGrpField3";
			$this->nombre->GroupViewValue = ewr_DisplayGroupValue($this->nombre, $this->nombre->GroupViewValue);
			$this->nombre->GroupSummaryOldValue = $this->nombre->GroupSummaryValue;
			$this->nombre->GroupSummaryValue = $this->nombre->GroupViewValue;
			$this->nombre->GroupSummaryViewValue = ($this->nombre->GroupSummaryOldValue <> $this->nombre->GroupSummaryValue) ? $this->nombre->GroupSummaryValue : "&nbsp;";

			// ATENDIDO
			$this->ATENDIDO->SumViewValue = $this->ATENDIDO->SumValue;
			$this->ATENDIDO->SumViewValue = ewr_FormatNumber($this->ATENDIDO->SumViewValue, 0, -2, -2, -2);
			$this->ATENDIDO->CellAttrs["class"] =  ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// PENDIENTE
			$this->PENDIENTE->SumViewValue = $this->PENDIENTE->SumValue;
			$this->PENDIENTE->SumViewValue = ewr_FormatNumber($this->PENDIENTE->SumViewValue, 0, -2, -2, -2);
			$this->PENDIENTE->CellAttrs["class"] =  ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// TOTAL
			$this->TOTAL->SumViewValue = $this->TOTAL->SumValue;
			$this->TOTAL->SumViewValue = ewr_FormatNumber($this->TOTAL->SumViewValue, 0, -2, -2, -2);
			$this->TOTAL->CellAttrs["class"] =  ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// CALIFICADO
			$this->CALIFICADO->SumViewValue = $this->CALIFICADO->SumValue;
			$this->CALIFICADO->SumViewValue = ewr_FormatNumber($this->CALIFICADO->SumViewValue, 0, -2, -2, -2);
			$this->CALIFICADO->CellAttrs["class"] =  ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// NOINTERESADO
			$this->NOINTERESADO->SumViewValue = $this->NOINTERESADO->SumValue;
			$this->NOINTERESADO->SumViewValue = ewr_FormatNumber($this->NOINTERESADO->SumViewValue, 0, -2, -2, -2);
			$this->NOINTERESADO->CellAttrs["class"] =  ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// OTROPROGRAMA
			$this->OTROPROGRAMA->SumViewValue = $this->OTROPROGRAMA->SumValue;
			$this->OTROPROGRAMA->SumViewValue = ewr_FormatNumber($this->OTROPROGRAMA->SumViewValue, 0, -2, -2, -2);
			$this->OTROPROGRAMA->CellAttrs["class"] =  ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// FALLIDA
			$this->FALLIDA->SumViewValue = $this->FALLIDA->SumValue;
			$this->FALLIDA->SumViewValue = ewr_FormatDateTime($this->FALLIDA->SumViewValue, 7);
			$this->FALLIDA->CellAttrs["class"] =  ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// programa
			$this->programa->HrefValue = "";

			// campania
			$this->campania->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// fechainicio
			$this->fechainicio->HrefValue = "";

			// fechafin
			$this->fechafin->HrefValue = "";

			// ATENDIDO
			$this->ATENDIDO->HrefValue = "";

			// PENDIENTE
			$this->PENDIENTE->HrefValue = "";

			// TOTAL
			$this->TOTAL->HrefValue = "";

			// PROCENT
			$this->PROCENT->HrefValue = "";

			// CALIFICADO
			$this->CALIFICADO->HrefValue = "";

			// NOINTERESADO
			$this->NOINTERESADO->HrefValue = "";

			// OTROPROGRAMA
			$this->OTROPROGRAMA->HrefValue = "";

			// FALLIDA
			$this->FALLIDA->HrefValue = "";
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

			// nombre
			$this->nombre->GroupViewValue = $this->nombre->GroupValue();
			$this->nombre->CellAttrs["class"] = "ewRptGrpField3";
			$this->nombre->GroupViewValue = ewr_DisplayGroupValue($this->nombre, $this->nombre->GroupViewValue);
			if ($this->nombre->GroupValue() == $this->nombre->GroupOldValue() && !$this->ChkLvlBreak(3))
				$this->nombre->GroupViewValue = "&nbsp;";

			// fechainicio
			$this->fechainicio->ViewValue = $this->fechainicio->CurrentValue;
			$this->fechainicio->ViewValue = ewr_FormatDateTime($this->fechainicio->ViewValue, 7);
			$this->fechainicio->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// fechafin
			$this->fechafin->ViewValue = $this->fechafin->CurrentValue;
			$this->fechafin->ViewValue = ewr_FormatDateTime($this->fechafin->ViewValue, 7);
			$this->fechafin->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// ATENDIDO
			$this->ATENDIDO->ViewValue = $this->ATENDIDO->CurrentValue;
			$this->ATENDIDO->ViewValue = ewr_FormatNumber($this->ATENDIDO->ViewValue, 0, -2, -2, -2);
			$this->ATENDIDO->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// PENDIENTE
			$this->PENDIENTE->ViewValue = $this->PENDIENTE->CurrentValue;
			$this->PENDIENTE->ViewValue = ewr_FormatNumber($this->PENDIENTE->ViewValue, 0, -2, -2, -2);
			$this->PENDIENTE->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// TOTAL
			$this->TOTAL->ViewValue = $this->TOTAL->CurrentValue;
			$this->TOTAL->ViewValue = ewr_FormatNumber($this->TOTAL->ViewValue, 0, -2, -2, -2);
			$this->TOTAL->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// PROCENT
			$this->PROCENT->ViewValue = $this->PROCENT->CurrentValue;
			$this->PROCENT->ViewValue = ewr_FormatNumber($this->PROCENT->ViewValue, 0, -2, -2, -2);
			$this->PROCENT->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// CALIFICADO
			$this->CALIFICADO->ViewValue = $this->CALIFICADO->CurrentValue;
			$this->CALIFICADO->ViewValue = ewr_FormatNumber($this->CALIFICADO->ViewValue, 0, -2, -2, -2);
			$this->CALIFICADO->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// NOINTERESADO
			$this->NOINTERESADO->ViewValue = $this->NOINTERESADO->CurrentValue;
			$this->NOINTERESADO->ViewValue = ewr_FormatNumber($this->NOINTERESADO->ViewValue, 0, -2, -2, -2);
			$this->NOINTERESADO->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// OTROPROGRAMA
			$this->OTROPROGRAMA->ViewValue = $this->OTROPROGRAMA->CurrentValue;
			$this->OTROPROGRAMA->ViewValue = ewr_FormatNumber($this->OTROPROGRAMA->ViewValue, 0, -2, -2, -2);
			$this->OTROPROGRAMA->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// FALLIDA
			$this->FALLIDA->ViewValue = $this->FALLIDA->CurrentValue;
			$this->FALLIDA->ViewValue = ewr_FormatDateTime($this->FALLIDA->ViewValue, 7);
			$this->FALLIDA->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// programa
			$this->programa->HrefValue = "";

			// campania
			$this->campania->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// fechainicio
			$this->fechainicio->HrefValue = "";

			// fechafin
			$this->fechafin->HrefValue = "";

			// ATENDIDO
			$this->ATENDIDO->HrefValue = "";

			// PENDIENTE
			$this->PENDIENTE->HrefValue = "";

			// TOTAL
			$this->TOTAL->HrefValue = "";

			// PROCENT
			$this->PROCENT->HrefValue = "";

			// CALIFICADO
			$this->CALIFICADO->HrefValue = "";

			// NOINTERESADO
			$this->NOINTERESADO->HrefValue = "";

			// OTROPROGRAMA
			$this->OTROPROGRAMA->HrefValue = "";

			// FALLIDA
			$this->FALLIDA->HrefValue = "";
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

			// nombre
			$CurrentValue = $this->nombre->GroupViewValue;
			$ViewValue = &$this->nombre->GroupViewValue;
			$ViewAttrs = &$this->nombre->ViewAttrs;
			$CellAttrs = &$this->nombre->CellAttrs;
			$HrefValue = &$this->nombre->HrefValue;
			$LinkAttrs = &$this->nombre->LinkAttrs;
			$this->Cell_Rendered($this->nombre, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ATENDIDO
			$CurrentValue = $this->ATENDIDO->SumValue;
			$ViewValue = &$this->ATENDIDO->SumViewValue;
			$ViewAttrs = &$this->ATENDIDO->ViewAttrs;
			$CellAttrs = &$this->ATENDIDO->CellAttrs;
			$HrefValue = &$this->ATENDIDO->HrefValue;
			$LinkAttrs = &$this->ATENDIDO->LinkAttrs;
			$this->Cell_Rendered($this->ATENDIDO, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// PENDIENTE
			$CurrentValue = $this->PENDIENTE->SumValue;
			$ViewValue = &$this->PENDIENTE->SumViewValue;
			$ViewAttrs = &$this->PENDIENTE->ViewAttrs;
			$CellAttrs = &$this->PENDIENTE->CellAttrs;
			$HrefValue = &$this->PENDIENTE->HrefValue;
			$LinkAttrs = &$this->PENDIENTE->LinkAttrs;
			$this->Cell_Rendered($this->PENDIENTE, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TOTAL
			$CurrentValue = $this->TOTAL->SumValue;
			$ViewValue = &$this->TOTAL->SumViewValue;
			$ViewAttrs = &$this->TOTAL->ViewAttrs;
			$CellAttrs = &$this->TOTAL->CellAttrs;
			$HrefValue = &$this->TOTAL->HrefValue;
			$LinkAttrs = &$this->TOTAL->LinkAttrs;
			$this->Cell_Rendered($this->TOTAL, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// CALIFICADO
			$CurrentValue = $this->CALIFICADO->SumValue;
			$ViewValue = &$this->CALIFICADO->SumViewValue;
			$ViewAttrs = &$this->CALIFICADO->ViewAttrs;
			$CellAttrs = &$this->CALIFICADO->CellAttrs;
			$HrefValue = &$this->CALIFICADO->HrefValue;
			$LinkAttrs = &$this->CALIFICADO->LinkAttrs;
			$this->Cell_Rendered($this->CALIFICADO, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// NOINTERESADO
			$CurrentValue = $this->NOINTERESADO->SumValue;
			$ViewValue = &$this->NOINTERESADO->SumViewValue;
			$ViewAttrs = &$this->NOINTERESADO->ViewAttrs;
			$CellAttrs = &$this->NOINTERESADO->CellAttrs;
			$HrefValue = &$this->NOINTERESADO->HrefValue;
			$LinkAttrs = &$this->NOINTERESADO->LinkAttrs;
			$this->Cell_Rendered($this->NOINTERESADO, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// OTROPROGRAMA
			$CurrentValue = $this->OTROPROGRAMA->SumValue;
			$ViewValue = &$this->OTROPROGRAMA->SumViewValue;
			$ViewAttrs = &$this->OTROPROGRAMA->ViewAttrs;
			$CellAttrs = &$this->OTROPROGRAMA->CellAttrs;
			$HrefValue = &$this->OTROPROGRAMA->HrefValue;
			$LinkAttrs = &$this->OTROPROGRAMA->LinkAttrs;
			$this->Cell_Rendered($this->OTROPROGRAMA, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// FALLIDA
			$CurrentValue = $this->FALLIDA->SumValue;
			$ViewValue = &$this->FALLIDA->SumViewValue;
			$ViewAttrs = &$this->FALLIDA->ViewAttrs;
			$CellAttrs = &$this->FALLIDA->CellAttrs;
			$HrefValue = &$this->FALLIDA->HrefValue;
			$LinkAttrs = &$this->FALLIDA->LinkAttrs;
			$this->Cell_Rendered($this->FALLIDA, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
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

			// nombre
			$CurrentValue = $this->nombre->GroupValue();
			$ViewValue = &$this->nombre->GroupViewValue;
			$ViewAttrs = &$this->nombre->ViewAttrs;
			$CellAttrs = &$this->nombre->CellAttrs;
			$HrefValue = &$this->nombre->HrefValue;
			$LinkAttrs = &$this->nombre->LinkAttrs;
			$this->Cell_Rendered($this->nombre, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// fechainicio
			$CurrentValue = $this->fechainicio->CurrentValue;
			$ViewValue = &$this->fechainicio->ViewValue;
			$ViewAttrs = &$this->fechainicio->ViewAttrs;
			$CellAttrs = &$this->fechainicio->CellAttrs;
			$HrefValue = &$this->fechainicio->HrefValue;
			$LinkAttrs = &$this->fechainicio->LinkAttrs;
			$this->Cell_Rendered($this->fechainicio, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// fechafin
			$CurrentValue = $this->fechafin->CurrentValue;
			$ViewValue = &$this->fechafin->ViewValue;
			$ViewAttrs = &$this->fechafin->ViewAttrs;
			$CellAttrs = &$this->fechafin->CellAttrs;
			$HrefValue = &$this->fechafin->HrefValue;
			$LinkAttrs = &$this->fechafin->LinkAttrs;
			$this->Cell_Rendered($this->fechafin, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ATENDIDO
			$CurrentValue = $this->ATENDIDO->CurrentValue;
			$ViewValue = &$this->ATENDIDO->ViewValue;
			$ViewAttrs = &$this->ATENDIDO->ViewAttrs;
			$CellAttrs = &$this->ATENDIDO->CellAttrs;
			$HrefValue = &$this->ATENDIDO->HrefValue;
			$LinkAttrs = &$this->ATENDIDO->LinkAttrs;
			$this->Cell_Rendered($this->ATENDIDO, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// PENDIENTE
			$CurrentValue = $this->PENDIENTE->CurrentValue;
			$ViewValue = &$this->PENDIENTE->ViewValue;
			$ViewAttrs = &$this->PENDIENTE->ViewAttrs;
			$CellAttrs = &$this->PENDIENTE->CellAttrs;
			$HrefValue = &$this->PENDIENTE->HrefValue;
			$LinkAttrs = &$this->PENDIENTE->LinkAttrs;
			$this->Cell_Rendered($this->PENDIENTE, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TOTAL
			$CurrentValue = $this->TOTAL->CurrentValue;
			$ViewValue = &$this->TOTAL->ViewValue;
			$ViewAttrs = &$this->TOTAL->ViewAttrs;
			$CellAttrs = &$this->TOTAL->CellAttrs;
			$HrefValue = &$this->TOTAL->HrefValue;
			$LinkAttrs = &$this->TOTAL->LinkAttrs;
			$this->Cell_Rendered($this->TOTAL, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// PROCENT
			$CurrentValue = $this->PROCENT->CurrentValue;
			$ViewValue = &$this->PROCENT->ViewValue;
			$ViewAttrs = &$this->PROCENT->ViewAttrs;
			$CellAttrs = &$this->PROCENT->CellAttrs;
			$HrefValue = &$this->PROCENT->HrefValue;
			$LinkAttrs = &$this->PROCENT->LinkAttrs;
			$this->Cell_Rendered($this->PROCENT, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// CALIFICADO
			$CurrentValue = $this->CALIFICADO->CurrentValue;
			$ViewValue = &$this->CALIFICADO->ViewValue;
			$ViewAttrs = &$this->CALIFICADO->ViewAttrs;
			$CellAttrs = &$this->CALIFICADO->CellAttrs;
			$HrefValue = &$this->CALIFICADO->HrefValue;
			$LinkAttrs = &$this->CALIFICADO->LinkAttrs;
			$this->Cell_Rendered($this->CALIFICADO, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// NOINTERESADO
			$CurrentValue = $this->NOINTERESADO->CurrentValue;
			$ViewValue = &$this->NOINTERESADO->ViewValue;
			$ViewAttrs = &$this->NOINTERESADO->ViewAttrs;
			$CellAttrs = &$this->NOINTERESADO->CellAttrs;
			$HrefValue = &$this->NOINTERESADO->HrefValue;
			$LinkAttrs = &$this->NOINTERESADO->LinkAttrs;
			$this->Cell_Rendered($this->NOINTERESADO, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// OTROPROGRAMA
			$CurrentValue = $this->OTROPROGRAMA->CurrentValue;
			$ViewValue = &$this->OTROPROGRAMA->ViewValue;
			$ViewAttrs = &$this->OTROPROGRAMA->ViewAttrs;
			$CellAttrs = &$this->OTROPROGRAMA->CellAttrs;
			$HrefValue = &$this->OTROPROGRAMA->HrefValue;
			$LinkAttrs = &$this->OTROPROGRAMA->LinkAttrs;
			$this->Cell_Rendered($this->OTROPROGRAMA, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// FALLIDA
			$CurrentValue = $this->FALLIDA->CurrentValue;
			$ViewValue = &$this->FALLIDA->ViewValue;
			$ViewAttrs = &$this->FALLIDA->ViewAttrs;
			$CellAttrs = &$this->FALLIDA->CellAttrs;
			$HrefValue = &$this->FALLIDA->HrefValue;
			$LinkAttrs = &$this->FALLIDA->LinkAttrs;
			$this->Cell_Rendered($this->FALLIDA, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
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
		if ($this->nombre->Visible) { $this->GrpFldCount += 1; $this->SubGrpFldCount += 1; }
		if ($this->fechainicio->Visible) $this->DtlFldCount += 1;
		if ($this->fechafin->Visible) $this->DtlFldCount += 1;
		if ($this->ATENDIDO->Visible) $this->DtlFldCount += 1;
		if ($this->PENDIENTE->Visible) $this->DtlFldCount += 1;
		if ($this->TOTAL->Visible) $this->DtlFldCount += 1;
		if ($this->PROCENT->Visible) $this->DtlFldCount += 1;
		if ($this->CALIFICADO->Visible) $this->DtlFldCount += 1;
		if ($this->NOINTERESADO->Visible) $this->DtlFldCount += 1;
		if ($this->OTROPROGRAMA->Visible) $this->DtlFldCount += 1;
		if ($this->FALLIDA->Visible) $this->DtlFldCount += 1;
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
		$item->Visible = TRUE;
		$exportid = session_id();
		$url = $this->ExportPdfUrl;
		$item->Body = "<a data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDFText")) . "\" href=\"javascript:void(0);\" onclick=\"ewr_ExportCharts(this, '" . $url . "', '" . $exportid . "');\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_Rep_Estado_Campania_$parm"] = "";
		$_SESSION["rf_Rep_Estado_Campania_$parm"] = "";
		$_SESSION["rt_Rep_Estado_Campania_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_Rep_Estado_Campania_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_Rep_Estado_Campania_$parm"];
		$fld->RangeTo = @$_SESSION["rt_Rep_Estado_Campania_$parm"];
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

		// Field fechainicio
		// $this->fechainicio->DefaultSelectionList = array("val1", "val2");
		// Field fechafin
		// $this->fechafin->DefaultSelectionList = array("val1", "val2");

	}

	// Check if filter applied
	function CheckFilter() {

		// Check fechainicio popup filter
		if (!ewr_MatchedArray($this->fechainicio->DefaultSelectionList, $this->fechainicio->SelectionList))
			return TRUE;

		// Check fechafin popup filter
		if (!ewr_MatchedArray($this->fechafin->DefaultSelectionList, $this->fechafin->SelectionList))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field fechainicio
		$sExtWrk = "";
		$sWrk = "";
		if (is_array($this->fechainicio->SelectionList))
			$sWrk = ewr_JoinArray($this->fechainicio->SelectionList, ", ", EWR_DATATYPE_DATE);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->fechainicio->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field fechafin
		$sExtWrk = "";
		$sWrk = "";
		if (is_array($this->fechafin->SelectionList))
			$sWrk = ewr_JoinArray($this->fechafin->SelectionList, ", ", EWR_DATATYPE_DATE);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->fechafin->FldCaption() . "</span>" . $sFilter . "</div>";
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
			if (is_array($this->fechainicio->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->fechainicio, "`fechainicio`", EWR_DATATYPE_DATE);

				// Call Page Filtering event
				$this->Page_Filtering($this->fechainicio, $sFilter, "popup");
				$this->fechainicio->CurrentFilter = $sFilter;
				ewr_AddFilter($sWrk, $sFilter);
			}
			if (is_array($this->fechafin->SelectionList)) {
				$sFilter = ewr_FilterSQL($this->fechafin, "`fechafin`", EWR_DATATYPE_DATE);

				// Call Page Filtering event
				$this->Page_Filtering($this->fechafin, $sFilter, "popup");
				$this->fechafin->CurrentFilter = $sFilter;
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
				$this->nombre->setSort("");
				$this->fechainicio->setSort("");
				$this->fechafin->setSort("");
				$this->ATENDIDO->setSort("");
				$this->PENDIENTE->setSort("");
				$this->TOTAL->setSort("");
				$this->PROCENT->setSort("");
				$this->CALIFICADO->setSort("");
				$this->NOINTERESADO->setSort("");
				$this->OTROPROGRAMA->setSort("");
				$this->FALLIDA->setSort("");
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
if (!isset($Rep_Estado_Campania_summary)) $Rep_Estado_Campania_summary = new crRep_Estado_Campania_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$Rep_Estado_Campania_summary;

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
var Rep_Estado_Campania_summary = new ewr_Page("Rep_Estado_Campania_summary");

// Page properties
Rep_Estado_Campania_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = Rep_Estado_Campania_summary.PageID;

// Extend page with Chart_Rendering function
Rep_Estado_Campania_summary.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
Rep_Estado_Campania_summary.Chart_Rendered = 
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
<?php if ($Page->Export <> "pdf") { ?>
<div id="report_summary">
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->ShowFilterList() ?>
<?php } ?>
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
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="ewGridLowerPanel">
<?php include "rep_estado_campaniasmrypager.php" ?>
</div>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</td></tr></table>
<?php } ?>
<span data-class="tpb<?php echo $Page->GrpCount-1 ?>_Rep_Estado_Campania"><?php echo $Page->PageBreakContent ?></span>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
<table class="ewGrid"<?php echo $Page->ReportTableStyle ?>><tr>
	<td class="ewGridContent">
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div class="ewGridMiddlePanel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->programa->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="programa"><div class="Rep_Estado_Campania_programa"><span class="ewTableHeaderCaption"><?php echo $Page->programa->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="programa">
<?php if ($Page->SortUrl($Page->programa) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_programa">
			<span class="ewTableHeaderCaption"><?php echo $Page->programa->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_programa" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->programa) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->programa->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->programa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->programa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->campania->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="campania"><div class="Rep_Estado_Campania_campania"><span class="ewTableHeaderCaption"><?php echo $Page->campania->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="campania">
<?php if ($Page->SortUrl($Page->campania) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_campania">
			<span class="ewTableHeaderCaption"><?php echo $Page->campania->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_campania" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->campania) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->campania->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->campania->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->campania->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->nombre->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="nombre"><div class="Rep_Estado_Campania_nombre"><span class="ewTableHeaderCaption"><?php echo $Page->nombre->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="nombre">
<?php if ($Page->SortUrl($Page->nombre) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_nombre">
			<span class="ewTableHeaderCaption"><?php echo $Page->nombre->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_nombre" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->nombre) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->nombre->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->fechainicio->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="fechainicio"><div class="Rep_Estado_Campania_fechainicio"><span class="ewTableHeaderCaption"><?php echo $Page->fechainicio->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="fechainicio">
<?php if ($Page->SortUrl($Page->fechainicio) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_fechainicio">
			<span class="ewTableHeaderCaption"><?php echo $Page->fechainicio->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" onclick="ewr_ShowPopup.call(this, event, 'Rep_Estado_Campania_fechainicio', false, '<?php echo $Page->fechainicio->RangeFrom; ?>', '<?php echo $Page->fechainicio->RangeTo; ?>');" id="x_fechainicio<?php echo $Page->Cnt[0][0]; ?>"><span class="glyphicon glyphicon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_fechainicio" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->fechainicio) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->fechainicio->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->fechainicio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->fechainicio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" onclick="ewr_ShowPopup.call(this, event, 'Rep_Estado_Campania_fechainicio', false, '<?php echo $Page->fechainicio->RangeFrom; ?>', '<?php echo $Page->fechainicio->RangeTo; ?>');" id="x_fechainicio<?php echo $Page->Cnt[0][0]; ?>"><span class="glyphicon glyphicon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->fechafin->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="fechafin"><div class="Rep_Estado_Campania_fechafin"><span class="ewTableHeaderCaption"><?php echo $Page->fechafin->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="fechafin">
<?php if ($Page->SortUrl($Page->fechafin) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_fechafin">
			<span class="ewTableHeaderCaption"><?php echo $Page->fechafin->FldCaption() ?></span>
			<a class="ewTableHeaderPopup" onclick="ewr_ShowPopup.call(this, event, 'Rep_Estado_Campania_fechafin', false, '<?php echo $Page->fechafin->RangeFrom; ?>', '<?php echo $Page->fechafin->RangeTo; ?>');" id="x_fechafin<?php echo $Page->Cnt[0][0]; ?>"><span class="glyphicon glyphicon-filter"></span></a>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_fechafin" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->fechafin) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->fechafin->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->fechafin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->fechafin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
			<a class="ewTableHeaderPopup" onclick="ewr_ShowPopup.call(this, event, 'Rep_Estado_Campania_fechafin', false, '<?php echo $Page->fechafin->RangeFrom; ?>', '<?php echo $Page->fechafin->RangeTo; ?>');" id="x_fechafin<?php echo $Page->Cnt[0][0]; ?>"><span class="glyphicon glyphicon-filter"></span></a>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ATENDIDO->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ATENDIDO"><div class="Rep_Estado_Campania_ATENDIDO"><span class="ewTableHeaderCaption"><?php echo $Page->ATENDIDO->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ATENDIDO">
<?php if ($Page->SortUrl($Page->ATENDIDO) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_ATENDIDO">
			<span class="ewTableHeaderCaption"><?php echo $Page->ATENDIDO->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_ATENDIDO" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ATENDIDO) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ATENDIDO->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ATENDIDO->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ATENDIDO->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->PENDIENTE->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="PENDIENTE"><div class="Rep_Estado_Campania_PENDIENTE"><span class="ewTableHeaderCaption"><?php echo $Page->PENDIENTE->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="PENDIENTE">
<?php if ($Page->SortUrl($Page->PENDIENTE) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_PENDIENTE">
			<span class="ewTableHeaderCaption"><?php echo $Page->PENDIENTE->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_PENDIENTE" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->PENDIENTE) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->PENDIENTE->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->PENDIENTE->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->PENDIENTE->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->TOTAL->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="TOTAL"><div class="Rep_Estado_Campania_TOTAL"><span class="ewTableHeaderCaption"><?php echo $Page->TOTAL->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="TOTAL">
<?php if ($Page->SortUrl($Page->TOTAL) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_TOTAL">
			<span class="ewTableHeaderCaption"><?php echo $Page->TOTAL->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_TOTAL" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->TOTAL) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->TOTAL->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->TOTAL->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->TOTAL->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->PROCENT->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="PROCENT"><div class="Rep_Estado_Campania_PROCENT"><span class="ewTableHeaderCaption"><?php echo $Page->PROCENT->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="PROCENT">
<?php if ($Page->SortUrl($Page->PROCENT) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_PROCENT">
			<span class="ewTableHeaderCaption"><?php echo $Page->PROCENT->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_PROCENT" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->PROCENT) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->PROCENT->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->PROCENT->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->PROCENT->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->CALIFICADO->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="CALIFICADO"><div class="Rep_Estado_Campania_CALIFICADO"><span class="ewTableHeaderCaption"><?php echo $Page->CALIFICADO->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="CALIFICADO">
<?php if ($Page->SortUrl($Page->CALIFICADO) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_CALIFICADO">
			<span class="ewTableHeaderCaption"><?php echo $Page->CALIFICADO->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_CALIFICADO" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->CALIFICADO) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->CALIFICADO->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->CALIFICADO->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->CALIFICADO->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->NOINTERESADO->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="NOINTERESADO"><div class="Rep_Estado_Campania_NOINTERESADO"><span class="ewTableHeaderCaption"><?php echo $Page->NOINTERESADO->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="NOINTERESADO">
<?php if ($Page->SortUrl($Page->NOINTERESADO) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_NOINTERESADO">
			<span class="ewTableHeaderCaption"><?php echo $Page->NOINTERESADO->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_NOINTERESADO" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->NOINTERESADO) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->NOINTERESADO->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->NOINTERESADO->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->NOINTERESADO->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->OTROPROGRAMA->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="OTROPROGRAMA"><div class="Rep_Estado_Campania_OTROPROGRAMA"><span class="ewTableHeaderCaption"><?php echo $Page->OTROPROGRAMA->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="OTROPROGRAMA">
<?php if ($Page->SortUrl($Page->OTROPROGRAMA) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_OTROPROGRAMA">
			<span class="ewTableHeaderCaption"><?php echo $Page->OTROPROGRAMA->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_OTROPROGRAMA" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->OTROPROGRAMA) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->OTROPROGRAMA->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->OTROPROGRAMA->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->OTROPROGRAMA->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->FALLIDA->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="FALLIDA"><div class="Rep_Estado_Campania_FALLIDA"><span class="ewTableHeaderCaption"><?php echo $Page->FALLIDA->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="FALLIDA">
<?php if ($Page->SortUrl($Page->FALLIDA) == "") { ?>
		<div class="ewTableHeaderBtn Rep_Estado_Campania_FALLIDA">
			<span class="ewTableHeaderCaption"><?php echo $Page->FALLIDA->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer Rep_Estado_Campania_FALLIDA" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->FALLIDA) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->FALLIDA->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->FALLIDA->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->FALLIDA->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
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
<span data-class="tpx<?php echo $Page->GrpCount ?>_Rep_Estado_Campania_programa"<?php echo $Page->programa->ViewAttributes() ?>><?php echo $Page->programa->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->campania->Visible) { ?>
		<td data-field="campania"<?php echo $Page->campania->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_Rep_Estado_Campania_campania"<?php echo $Page->campania->ViewAttributes() ?>><?php echo $Page->campania->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->nombre->Visible) { ?>
		<td data-field="nombre"<?php echo $Page->nombre->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_Rep_Estado_Campania_nombre"<?php echo $Page->nombre->ViewAttributes() ?>><?php echo $Page->nombre->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->fechainicio->Visible) { ?>
		<td data-field="fechainicio"<?php echo $Page->fechainicio->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_Rep_Estado_Campania_fechainicio"<?php echo $Page->fechainicio->ViewAttributes() ?>><?php echo $Page->fechainicio->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->fechafin->Visible) { ?>
		<td data-field="fechafin"<?php echo $Page->fechafin->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_Rep_Estado_Campania_fechafin"<?php echo $Page->fechafin->ViewAttributes() ?>><?php echo $Page->fechafin->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ATENDIDO->Visible) { ?>
		<td data-field="ATENDIDO"<?php echo $Page->ATENDIDO->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_Rep_Estado_Campania_ATENDIDO"<?php echo $Page->ATENDIDO->ViewAttributes() ?>><?php echo $Page->ATENDIDO->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->PENDIENTE->Visible) { ?>
		<td data-field="PENDIENTE"<?php echo $Page->PENDIENTE->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_Rep_Estado_Campania_PENDIENTE"<?php echo $Page->PENDIENTE->ViewAttributes() ?>><?php echo $Page->PENDIENTE->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->TOTAL->Visible) { ?>
		<td data-field="TOTAL"<?php echo $Page->TOTAL->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_Rep_Estado_Campania_TOTAL"<?php echo $Page->TOTAL->ViewAttributes() ?>><?php echo $Page->TOTAL->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->PROCENT->Visible) { ?>
		<td data-field="PROCENT"<?php echo $Page->PROCENT->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_Rep_Estado_Campania_PROCENT"<?php echo $Page->PROCENT->ViewAttributes() ?>><?php echo $Page->PROCENT->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->CALIFICADO->Visible) { ?>
		<td data-field="CALIFICADO"<?php echo $Page->CALIFICADO->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_Rep_Estado_Campania_CALIFICADO"<?php echo $Page->CALIFICADO->ViewAttributes() ?>><?php echo $Page->CALIFICADO->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->NOINTERESADO->Visible) { ?>
		<td data-field="NOINTERESADO"<?php echo $Page->NOINTERESADO->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_Rep_Estado_Campania_NOINTERESADO"<?php echo $Page->NOINTERESADO->ViewAttributes() ?>><?php echo $Page->NOINTERESADO->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->OTROPROGRAMA->Visible) { ?>
		<td data-field="OTROPROGRAMA"<?php echo $Page->OTROPROGRAMA->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_Rep_Estado_Campania_OTROPROGRAMA"<?php echo $Page->OTROPROGRAMA->ViewAttributes() ?>><?php echo $Page->OTROPROGRAMA->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->FALLIDA->Visible) { ?>
		<td data-field="FALLIDA"<?php echo $Page->FALLIDA->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_Rep_Estado_Campania_FALLIDA"<?php echo $Page->FALLIDA->ViewAttributes() ?>><?php echo $Page->FALLIDA->ListViewValue() ?></span></td>
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
	</tfoot>
<?php } elseif (!$Page->ShowHeader) { // No header displayed ?>
<?php if ($Page->Export <> "pdf") { ?>
<table class="ewGrid"<?php echo $Page->ReportTableStyle ?>><tr>
	<td class="ewGridContent">
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div class="ewGridMiddlePanel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
</table>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="ewGridLowerPanel">
<?php include "rep_estado_campaniasmrypager.php" ?>
</div>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</td></tr></table>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
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
