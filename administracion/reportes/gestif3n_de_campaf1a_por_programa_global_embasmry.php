<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg7.php" ?>
<?php include_once "phprptinc/ewmysql.php" ?>
<?php include_once "phprptinc/ewrfn7.php" ?>
<?php include_once "phprptinc/ewrusrfn.php" ?>
<?php include_once "gestif3n_de_campaf1a_por_programa_global_embasmryinfo.php" ?>
<?php

//
// Page class
//

$GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary = NULL; // Initialize page object first

class crGestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary extends crGestiF3n_de_CampaF1a_por_Programa_Global_EMBA {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{FBAFD19E-E753-4738-84A0-8DC7FC3CBD41}";

	// Page object name
	var $PageObjName = 'GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary';

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

		// Table object (GestiF3n_de_CampaF1a_por_Programa_Global_EMBA)
		if (!isset($GLOBALS["GestiF3n_de_CampaF1a_por_Programa_Global_EMBA"])) {
			$GLOBALS["GestiF3n_de_CampaF1a_por_Programa_Global_EMBA"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["GestiF3n_de_CampaF1a_por_Programa_Global_EMBA"];
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
			define("EWR_TABLE_NAME", 'Gestión de Campaña por Programa Global EMBA', TRUE);

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
		$item->Body = "<a data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmailText")) . "\" id=\"emf_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
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
		$item->Visible = FALSE;

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

		$nDtls = 14;
		$nGrps = 1;
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
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

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

		// No filter
		$this->FilterApplied = FALSE;

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);
		$this->OtherOptions->GetItem("resetfilter")->Visible = $this->FilterApplied;

		// Get sort
		$this->Sort = $this->GetSort();

		// Get total count
		$sSql = ewr_BuildReportSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0 || $this->DrillDown) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowHeader = ($this->TotalGrps > 0);

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

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
		$this->SetupFieldCount();
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

	// Get count
	function GetCnt($sql) {
		global $conn;
		$rscnt = $conn->Execute($sql);
		$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
		if ($rscnt) $rscnt->Close();
		return $cnt;
	}

	// Get rs
	function GetRs($sql, $start, $grps) {
		global $conn;
		$wrksql = $sql;
		if ($start > 0 && $grps > -1)
			$wrksql .= " LIMIT " . ($start-1) . ", " . ($grps);
		$rswrk = $conn->Execute($wrksql);
		return $rswrk;
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
				$this->FirstRowData['asesor'] = ewr_Conv($rs->fields('asesor'),200);
				$this->FirstRowData['tipo'] = ewr_Conv($rs->fields('tipo'),3);
				$this->FirstRowData['activo'] = ewr_Conv($rs->fields('activo'),3);
				$this->FirstRowData['fechatrans'] = ewr_Conv($rs->fields('fechatrans'),133);
				$this->FirstRowData['idtipificacion'] = ewr_Conv($rs->fields('idtipificacion'),3);
				$this->FirstRowData['idtipificaciontipo'] = ewr_Conv($rs->fields('idtipificaciontipo'),3);
				$this->FirstRowData['ultimo'] = ewr_Conv($rs->fields('ultimo'),3);
				$this->FirstRowData['TOTAL'] = ewr_Conv($rs->fields('TOTAL'),20);
				$this->FirstRowData['ATENDIDO'] = ewr_Conv($rs->fields('ATENDIDO'),131);
				$this->FirstRowData['PENDIENTE'] = ewr_Conv($rs->fields('PENDIENTE'),131);
				$this->FirstRowData['CALIFICADO'] = ewr_Conv($rs->fields('CALIFICADO'),131);
				$this->FirstRowData['NOINTERESADO'] = ewr_Conv($rs->fields('NOINTERESADO'),131);
				$this->FirstRowData['OTROPROGRAMA'] = ewr_Conv($rs->fields('OTROPROGRAMA'),131);
				$this->FirstRowData['FALLIDA'] = ewr_Conv($rs->fields('FALLIDA'),131);
				$this->FirstRowData['Otras'] = ewr_Conv($rs->fields('Otras'),131);
				$this->FirstRowData['PROCENT'] = ewr_Conv($rs->fields('PROCENT'),131);
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
			$this->programa->setDbValue($rs->fields('programa'));
			$this->idusuario->setDbValue($rs->fields('idusuario'));
			$this->nombre->setDbValue($rs->fields('nombre'));
			$this->asesor->setDbValue($rs->fields('asesor'));
			$this->tipo->setDbValue($rs->fields('tipo'));
			$this->activo->setDbValue($rs->fields('activo'));
			$this->fechatrans->setDbValue($rs->fields('fechatrans'));
			$this->idtipificacion->setDbValue($rs->fields('idtipificacion'));
			$this->idtipificaciontipo->setDbValue($rs->fields('idtipificaciontipo'));
			$this->ultimo->setDbValue($rs->fields('ultimo'));
			$this->TOTAL->setDbValue($rs->fields('TOTAL'));
			$this->ATENDIDO->setDbValue($rs->fields('ATENDIDO'));
			$this->PENDIENTE->setDbValue($rs->fields('PENDIENTE'));
			$this->CALIFICADO->setDbValue($rs->fields('CALIFICADO'));
			$this->NOINTERESADO->setDbValue($rs->fields('NOINTERESADO'));
			$this->OTROPROGRAMA->setDbValue($rs->fields('OTROPROGRAMA'));
			$this->FALLIDA->setDbValue($rs->fields('FALLIDA'));
			$this->Otras->setDbValue($rs->fields('Otras'));
			$this->PROCENT->setDbValue($rs->fields('PROCENT'));
			$this->Val[1] = $this->campania->CurrentValue;
			$this->Val[2] = $this->programa->CurrentValue;
			$this->Val[3] = $this->asesor->CurrentValue;
			$this->Val[4] = $this->fechatrans->CurrentValue;
			$this->Val[5] = $this->TOTAL->CurrentValue;
			$this->Val[6] = $this->ATENDIDO->CurrentValue;
			$this->Val[7] = $this->PENDIENTE->CurrentValue;
			$this->Val[8] = $this->CALIFICADO->CurrentValue;
			$this->Val[9] = $this->NOINTERESADO->CurrentValue;
			$this->Val[10] = $this->OTROPROGRAMA->CurrentValue;
			$this->Val[11] = $this->FALLIDA->CurrentValue;
			$this->Val[12] = $this->Otras->CurrentValue;
			$this->Val[13] = $this->PROCENT->CurrentValue;
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
			$this->asesor->setDbValue("");
			$this->tipo->setDbValue("");
			$this->activo->setDbValue("");
			$this->fechatrans->setDbValue("");
			$this->idtipificacion->setDbValue("");
			$this->idtipificaciontipo->setDbValue("");
			$this->ultimo->setDbValue("");
			$this->TOTAL->setDbValue("");
			$this->ATENDIDO->setDbValue("");
			$this->PENDIENTE->setDbValue("");
			$this->CALIFICADO->setDbValue("");
			$this->NOINTERESADO->setDbValue("");
			$this->OTROPROGRAMA->setDbValue("");
			$this->FALLIDA->setDbValue("");
			$this->Otras->setDbValue("");
			$this->PROCENT->setDbValue("");
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
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
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

			// campania
			$this->campania->HrefValue = "";

			// programa
			$this->programa->HrefValue = "";

			// asesor
			$this->asesor->HrefValue = "";

			// fechatrans
			$this->fechatrans->HrefValue = "";

			// TOTAL
			$this->TOTAL->HrefValue = "";

			// ATENDIDO
			$this->ATENDIDO->HrefValue = "";

			// PENDIENTE
			$this->PENDIENTE->HrefValue = "";

			// CALIFICADO
			$this->CALIFICADO->HrefValue = "";

			// NOINTERESADO
			$this->NOINTERESADO->HrefValue = "";

			// OTROPROGRAMA
			$this->OTROPROGRAMA->HrefValue = "";

			// FALLIDA
			$this->FALLIDA->HrefValue = "";

			// Otras
			$this->Otras->HrefValue = "";

			// PROCENT
			$this->PROCENT->HrefValue = "";
		} else {

			// campania
			$this->campania->ViewValue = $this->campania->CurrentValue;
			$this->campania->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// programa
			$this->programa->ViewValue = $this->programa->CurrentValue;
			$this->programa->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// asesor
			$this->asesor->ViewValue = $this->asesor->CurrentValue;
			$this->asesor->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// fechatrans
			$this->fechatrans->ViewValue = $this->fechatrans->CurrentValue;
			$this->fechatrans->ViewValue = ewr_FormatDateTime($this->fechatrans->ViewValue, 7);
			$this->fechatrans->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->fechatrans->CellAttrs["style"] = "text-align:center;";

			// TOTAL
			$this->TOTAL->ViewValue = $this->TOTAL->CurrentValue;
			$this->TOTAL->ViewValue = ewr_FormatNumber($this->TOTAL->ViewValue, 0, -2, -2, -2);
			$this->TOTAL->ViewAttrs["style"] = "font-weight:bold;";
			$this->TOTAL->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->TOTAL->CellAttrs["style"] = "text-align:center;";

			// ATENDIDO
			$this->ATENDIDO->ViewValue = $this->ATENDIDO->CurrentValue;
			$this->ATENDIDO->ViewValue = ewr_FormatNumber($this->ATENDIDO->ViewValue, 0, -2, -2, -2);
			$this->ATENDIDO->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->ATENDIDO->CellAttrs["style"] = "text-align:center;";

			// PENDIENTE
			$this->PENDIENTE->ViewValue = $this->PENDIENTE->CurrentValue;
			$this->PENDIENTE->ViewValue = ewr_FormatNumber($this->PENDIENTE->ViewValue, 0, -2, -2, -2);
			$this->PENDIENTE->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->PENDIENTE->CellAttrs["style"] = "text-align:center;";

			// CALIFICADO
			$this->CALIFICADO->ViewValue = $this->CALIFICADO->CurrentValue;
			$this->CALIFICADO->ViewValue = ewr_FormatNumber($this->CALIFICADO->ViewValue, 0, -2, -2, -2);
			$this->CALIFICADO->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->CALIFICADO->CellAttrs["style"] = "text-align:center;";

			// NOINTERESADO
			$this->NOINTERESADO->ViewValue = $this->NOINTERESADO->CurrentValue;
			$this->NOINTERESADO->ViewValue = ewr_FormatNumber($this->NOINTERESADO->ViewValue, 0, -2, -2, -2);
			$this->NOINTERESADO->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->NOINTERESADO->CellAttrs["style"] = "text-align:center;";

			// OTROPROGRAMA
			$this->OTROPROGRAMA->ViewValue = $this->OTROPROGRAMA->CurrentValue;
			$this->OTROPROGRAMA->ViewValue = ewr_FormatNumber($this->OTROPROGRAMA->ViewValue, 0, -2, -2, -2);
			$this->OTROPROGRAMA->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->OTROPROGRAMA->CellAttrs["style"] = "text-align:center;";

			// FALLIDA
			$this->FALLIDA->ViewValue = $this->FALLIDA->CurrentValue;
			$this->FALLIDA->ViewValue = ewr_FormatNumber($this->FALLIDA->ViewValue, 0, -2, -2, -2);
			$this->FALLIDA->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->FALLIDA->CellAttrs["style"] = "text-align:center;";

			// Otras
			$this->Otras->ViewValue = $this->Otras->CurrentValue;
			$this->Otras->ViewValue = ewr_FormatNumber($this->Otras->ViewValue, 0, -2, -2, -2);
			$this->Otras->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->Otras->CellAttrs["style"] = "text-align:center;";

			// PROCENT
			$this->PROCENT->ViewValue = $this->PROCENT->CurrentValue;
			$this->PROCENT->ViewValue = ewr_FormatNumber($this->PROCENT->ViewValue, 2, -2, -2, -2);
			$this->PROCENT->ViewAttrs["style"] = "font-weight:bold;";
			$this->PROCENT->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->PROCENT->CellAttrs["style"] = "text-align:center;";

			// campania
			$this->campania->HrefValue = "";

			// programa
			$this->programa->HrefValue = "";

			// asesor
			$this->asesor->HrefValue = "";

			// fechatrans
			$this->fechatrans->HrefValue = "";

			// TOTAL
			$this->TOTAL->HrefValue = "";

			// ATENDIDO
			$this->ATENDIDO->HrefValue = "";

			// PENDIENTE
			$this->PENDIENTE->HrefValue = "";

			// CALIFICADO
			$this->CALIFICADO->HrefValue = "";

			// NOINTERESADO
			$this->NOINTERESADO->HrefValue = "";

			// OTROPROGRAMA
			$this->OTROPROGRAMA->HrefValue = "";

			// FALLIDA
			$this->FALLIDA->HrefValue = "";

			// Otras
			$this->Otras->HrefValue = "";

			// PROCENT
			$this->PROCENT->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row
		} else {

			// campania
			$CurrentValue = $this->campania->CurrentValue;
			$ViewValue = &$this->campania->ViewValue;
			$ViewAttrs = &$this->campania->ViewAttrs;
			$CellAttrs = &$this->campania->CellAttrs;
			$HrefValue = &$this->campania->HrefValue;
			$LinkAttrs = &$this->campania->LinkAttrs;
			$this->Cell_Rendered($this->campania, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// programa
			$CurrentValue = $this->programa->CurrentValue;
			$ViewValue = &$this->programa->ViewValue;
			$ViewAttrs = &$this->programa->ViewAttrs;
			$CellAttrs = &$this->programa->CellAttrs;
			$HrefValue = &$this->programa->HrefValue;
			$LinkAttrs = &$this->programa->LinkAttrs;
			$this->Cell_Rendered($this->programa, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// asesor
			$CurrentValue = $this->asesor->CurrentValue;
			$ViewValue = &$this->asesor->ViewValue;
			$ViewAttrs = &$this->asesor->ViewAttrs;
			$CellAttrs = &$this->asesor->CellAttrs;
			$HrefValue = &$this->asesor->HrefValue;
			$LinkAttrs = &$this->asesor->LinkAttrs;
			$this->Cell_Rendered($this->asesor, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// fechatrans
			$CurrentValue = $this->fechatrans->CurrentValue;
			$ViewValue = &$this->fechatrans->ViewValue;
			$ViewAttrs = &$this->fechatrans->ViewAttrs;
			$CellAttrs = &$this->fechatrans->CellAttrs;
			$HrefValue = &$this->fechatrans->HrefValue;
			$LinkAttrs = &$this->fechatrans->LinkAttrs;
			$this->Cell_Rendered($this->fechatrans, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// TOTAL
			$CurrentValue = $this->TOTAL->CurrentValue;
			$ViewValue = &$this->TOTAL->ViewValue;
			$ViewAttrs = &$this->TOTAL->ViewAttrs;
			$CellAttrs = &$this->TOTAL->CellAttrs;
			$HrefValue = &$this->TOTAL->HrefValue;
			$LinkAttrs = &$this->TOTAL->LinkAttrs;
			$this->Cell_Rendered($this->TOTAL, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

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

			// Otras
			$CurrentValue = $this->Otras->CurrentValue;
			$ViewValue = &$this->Otras->ViewValue;
			$ViewAttrs = &$this->Otras->ViewAttrs;
			$CellAttrs = &$this->Otras->CellAttrs;
			$HrefValue = &$this->Otras->HrefValue;
			$LinkAttrs = &$this->Otras->LinkAttrs;
			$this->Cell_Rendered($this->Otras, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// PROCENT
			$CurrentValue = $this->PROCENT->CurrentValue;
			$ViewValue = &$this->PROCENT->ViewValue;
			$ViewAttrs = &$this->PROCENT->ViewAttrs;
			$CellAttrs = &$this->PROCENT->CellAttrs;
			$HrefValue = &$this->PROCENT->HrefValue;
			$LinkAttrs = &$this->PROCENT->LinkAttrs;
			$this->Cell_Rendered($this->PROCENT, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
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
		if ($this->campania->Visible) $this->DtlFldCount += 1;
		if ($this->programa->Visible) $this->DtlFldCount += 1;
		if ($this->asesor->Visible) $this->DtlFldCount += 1;
		if ($this->fechatrans->Visible) $this->DtlFldCount += 1;
		if ($this->TOTAL->Visible) $this->DtlFldCount += 1;
		if ($this->ATENDIDO->Visible) $this->DtlFldCount += 1;
		if ($this->PENDIENTE->Visible) $this->DtlFldCount += 1;
		if ($this->CALIFICADO->Visible) $this->DtlFldCount += 1;
		if ($this->NOINTERESADO->Visible) $this->DtlFldCount += 1;
		if ($this->OTROPROGRAMA->Visible) $this->DtlFldCount += 1;
		if ($this->FALLIDA->Visible) $this->DtlFldCount += 1;
		if ($this->Otras->Visible) $this->DtlFldCount += 1;
		if ($this->PROCENT->Visible) $this->DtlFldCount += 1;
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

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
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
				$this->campania->setSort("");
				$this->programa->setSort("");
				$this->asesor->setSort("");
				$this->fechatrans->setSort("");
				$this->TOTAL->setSort("");
				$this->ATENDIDO->setSort("");
				$this->PENDIENTE->setSort("");
				$this->CALIFICADO->setSort("");
				$this->NOINTERESADO->setSort("");
				$this->OTROPROGRAMA->setSort("");
				$this->FALLIDA->setSort("");
				$this->Otras->setSort("");
				$this->PROCENT->setSort("");
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
if (!isset($GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary)) $GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary = new crGestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary;

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
var GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary = new ewr_Page("GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary");

// Page properties
GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary.PageID;

// Extend page with Chart_Rendering function
GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_summary.Chart_Rendered = 
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
	$Page->GetRow(1);
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray(1, -1);
$Page->GrpIdx[0] = -1;
$Page->GrpIdx[1] = $Page->StopGrp - $Page->StartGrp + 1;
while ($rs && !$rs->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<table class="ewGrid"<?php echo $Page->ReportTableStyle ?>><tr>
	<td class="ewGridContent">
<!-- Report grid (begin) -->
<div class="ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->campania->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="campania"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_campania"><span class="ewTableHeaderCaption"><?php echo $Page->campania->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="campania">
<?php if ($Page->SortUrl($Page->campania) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_campania">
			<span class="ewTableHeaderCaption"><?php echo $Page->campania->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_campania" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->campania) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->campania->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->campania->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->campania->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->programa->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="programa"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_programa"><span class="ewTableHeaderCaption"><?php echo $Page->programa->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="programa">
<?php if ($Page->SortUrl($Page->programa) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_programa">
			<span class="ewTableHeaderCaption"><?php echo $Page->programa->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_programa" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->programa) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->programa->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->programa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->programa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->asesor->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="asesor"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_asesor"><span class="ewTableHeaderCaption"><?php echo $Page->asesor->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="asesor">
<?php if ($Page->SortUrl($Page->asesor) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_asesor">
			<span class="ewTableHeaderCaption"><?php echo $Page->asesor->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_asesor" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->asesor) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->asesor->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->asesor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->asesor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->fechatrans->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="fechatrans"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_fechatrans" style="text-align: center;"><span class="ewTableHeaderCaption"><?php echo $Page->fechatrans->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="fechatrans">
<?php if ($Page->SortUrl($Page->fechatrans) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_fechatrans" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->fechatrans->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_fechatrans" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->fechatrans) ?>',0);" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->fechatrans->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->fechatrans->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->fechatrans->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->TOTAL->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="TOTAL"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_TOTAL" style="text-align: center;"><span class="ewTableHeaderCaption"><?php echo $Page->TOTAL->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="TOTAL">
<?php if ($Page->SortUrl($Page->TOTAL) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_TOTAL" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->TOTAL->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_TOTAL" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->TOTAL) ?>',0);" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->TOTAL->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->TOTAL->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->TOTAL->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ATENDIDO->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ATENDIDO"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_ATENDIDO" style="text-align: center;"><span class="ewTableHeaderCaption"><?php echo $Page->ATENDIDO->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ATENDIDO">
<?php if ($Page->SortUrl($Page->ATENDIDO) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_ATENDIDO" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->ATENDIDO->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_ATENDIDO" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ATENDIDO) ?>',0);" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->ATENDIDO->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ATENDIDO->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ATENDIDO->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->PENDIENTE->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="PENDIENTE"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_PENDIENTE" style="text-align: center;"><span class="ewTableHeaderCaption"><?php echo $Page->PENDIENTE->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="PENDIENTE">
<?php if ($Page->SortUrl($Page->PENDIENTE) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_PENDIENTE" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->PENDIENTE->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_PENDIENTE" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->PENDIENTE) ?>',0);" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->PENDIENTE->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->PENDIENTE->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->PENDIENTE->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->CALIFICADO->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="CALIFICADO"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_CALIFICADO" style="text-align: center;"><span class="ewTableHeaderCaption"><?php echo $Page->CALIFICADO->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="CALIFICADO">
<?php if ($Page->SortUrl($Page->CALIFICADO) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_CALIFICADO" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->CALIFICADO->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_CALIFICADO" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->CALIFICADO) ?>',0);" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->CALIFICADO->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->CALIFICADO->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->CALIFICADO->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->NOINTERESADO->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="NOINTERESADO"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_NOINTERESADO" style="text-align: center;"><span class="ewTableHeaderCaption"><?php echo $Page->NOINTERESADO->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="NOINTERESADO">
<?php if ($Page->SortUrl($Page->NOINTERESADO) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_NOINTERESADO" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->NOINTERESADO->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_NOINTERESADO" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->NOINTERESADO) ?>',0);" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->NOINTERESADO->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->NOINTERESADO->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->NOINTERESADO->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->OTROPROGRAMA->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="OTROPROGRAMA"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_OTROPROGRAMA" style="text-align: center;"><span class="ewTableHeaderCaption"><?php echo $Page->OTROPROGRAMA->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="OTROPROGRAMA">
<?php if ($Page->SortUrl($Page->OTROPROGRAMA) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_OTROPROGRAMA" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->OTROPROGRAMA->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_OTROPROGRAMA" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->OTROPROGRAMA) ?>',0);" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->OTROPROGRAMA->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->OTROPROGRAMA->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->OTROPROGRAMA->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->FALLIDA->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="FALLIDA"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_FALLIDA" style="text-align: center;"><span class="ewTableHeaderCaption"><?php echo $Page->FALLIDA->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="FALLIDA">
<?php if ($Page->SortUrl($Page->FALLIDA) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_FALLIDA" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->FALLIDA->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_FALLIDA" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->FALLIDA) ?>',0);" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->FALLIDA->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->FALLIDA->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->FALLIDA->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Otras->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Otras"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_Otras" style="text-align: center;"><span class="ewTableHeaderCaption"><?php echo $Page->Otras->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Otras">
<?php if ($Page->SortUrl($Page->Otras) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_Otras" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->Otras->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_Otras" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Otras) ?>',0);" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->Otras->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Otras->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Otras->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->PROCENT->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="PROCENT"><div class="GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_PROCENT" style="text-align: center;"><span class="ewTableHeaderCaption"><?php echo $Page->PROCENT->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="PROCENT">
<?php if ($Page->SortUrl($Page->PROCENT) == "") { ?>
		<div class="ewTableHeaderBtn GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_PROCENT" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->PROCENT->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_PROCENT" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->PROCENT) ?>',0);" style="text-align: center;">
			<span class="ewTableHeaderCaption"><?php echo $Page->PROCENT->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->PROCENT->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->PROCENT->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
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
	$Page->RecCount++;

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->campania->Visible) { ?>
		<td data-field="campania"<?php echo $Page->campania->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_campania"<?php echo $Page->campania->ViewAttributes() ?>><?php echo $Page->campania->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->programa->Visible) { ?>
		<td data-field="programa"<?php echo $Page->programa->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_programa"<?php echo $Page->programa->ViewAttributes() ?>><?php echo $Page->programa->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->asesor->Visible) { ?>
		<td data-field="asesor"<?php echo $Page->asesor->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_asesor"<?php echo $Page->asesor->ViewAttributes() ?>><?php echo $Page->asesor->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->fechatrans->Visible) { ?>
		<td data-field="fechatrans"<?php echo $Page->fechatrans->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_fechatrans"<?php echo $Page->fechatrans->ViewAttributes() ?>><?php echo $Page->fechatrans->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->TOTAL->Visible) { ?>
		<td data-field="TOTAL"<?php echo $Page->TOTAL->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_TOTAL"<?php echo $Page->TOTAL->ViewAttributes() ?>><?php echo $Page->TOTAL->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ATENDIDO->Visible) { ?>
		<td data-field="ATENDIDO"<?php echo $Page->ATENDIDO->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_ATENDIDO"<?php echo $Page->ATENDIDO->ViewAttributes() ?>><?php echo $Page->ATENDIDO->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->PENDIENTE->Visible) { ?>
		<td data-field="PENDIENTE"<?php echo $Page->PENDIENTE->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_PENDIENTE"<?php echo $Page->PENDIENTE->ViewAttributes() ?>><?php echo $Page->PENDIENTE->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->CALIFICADO->Visible) { ?>
		<td data-field="CALIFICADO"<?php echo $Page->CALIFICADO->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_CALIFICADO"<?php echo $Page->CALIFICADO->ViewAttributes() ?>><?php echo $Page->CALIFICADO->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->NOINTERESADO->Visible) { ?>
		<td data-field="NOINTERESADO"<?php echo $Page->NOINTERESADO->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_NOINTERESADO"<?php echo $Page->NOINTERESADO->ViewAttributes() ?>><?php echo $Page->NOINTERESADO->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->OTROPROGRAMA->Visible) { ?>
		<td data-field="OTROPROGRAMA"<?php echo $Page->OTROPROGRAMA->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_OTROPROGRAMA"<?php echo $Page->OTROPROGRAMA->ViewAttributes() ?>><?php echo $Page->OTROPROGRAMA->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->FALLIDA->Visible) { ?>
		<td data-field="FALLIDA"<?php echo $Page->FALLIDA->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_FALLIDA"<?php echo $Page->FALLIDA->ViewAttributes() ?>><?php echo $Page->FALLIDA->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Otras->Visible) { ?>
		<td data-field="Otras"<?php echo $Page->Otras->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_Otras"<?php echo $Page->Otras->ViewAttributes() ?>><?php echo $Page->Otras->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->PROCENT->Visible) { ?>
		<td data-field="PROCENT"<?php echo $Page->PROCENT->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->RecCount ?>_GestiF3n_de_CampaF1a_por_Programa_Global_EMBA_PROCENT"<?php echo $Page->PROCENT->ViewAttributes() ?>><?php echo $Page->PROCENT->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);
	$Page->GrpCount++;
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
<?php include "gestif3n_de_campaf1a_por_programa_global_embasmrypager.php" ?>
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
