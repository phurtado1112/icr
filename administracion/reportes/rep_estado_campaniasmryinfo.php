<?php

// Global variable for table object
$Rep_Estado_Campania = NULL;

//
// Table class for Rep_Estado_Campania
//
class crRep_Estado_Campania extends crTableBase {

//	var $SelectLimit = TRUE;
	var $idasignar;
	var $idcampania;
	var $campania;
	var $terminada;
	var $fechainicio;
	var $fechafin;
	var $idprograma;
	var $programa;
	var $idusuario;
	var $nombre;
	var $ATENDIDO;
	var $PENDIENTE;
	var $TOTAL;
	var $PROCENT;
	var $CALIFICADO;
	var $NOINTERESADO;
	var $OTROPROGRAMA;
	var $FALLIDA;
	var $Otras;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage;
		$this->TableVar = 'Rep_Estado_Campania';
		$this->TableName = 'Rep_Estado_Campania';
		$this->TableType = 'REPORT';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0;

		// idasignar
		$this->idasignar = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_idasignar', 'idasignar', '`idasignar`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idasignar->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idasignar'] = &$this->idasignar;
		$this->idasignar->DateFilter = "";
		$this->idasignar->SqlSelect = "";
		$this->idasignar->SqlOrderBy = "";

		// idcampania
		$this->idcampania = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_idcampania', 'idcampania', '`idcampania`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idcampania->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idcampania'] = &$this->idcampania;
		$this->idcampania->DateFilter = "";
		$this->idcampania->SqlSelect = "";
		$this->idcampania->SqlOrderBy = "";

		// campania
		$this->campania = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_campania', 'campania', '`campania`', 200, EWR_DATATYPE_STRING, -1);
		$this->campania->GroupingFieldId = 2;
		$this->fields['campania'] = &$this->campania;
		$this->campania->DateFilter = "";
		$this->campania->SqlSelect = "";
		$this->campania->SqlOrderBy = "";
		$this->campania->FldGroupByType = "";
		$this->campania->FldGroupInt = "0";
		$this->campania->FldGroupSql = "";

		// terminada
		$this->terminada = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_terminada', 'terminada', '`terminada`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['terminada'] = &$this->terminada;
		$this->terminada->DateFilter = "";
		$this->terminada->SqlSelect = "";
		$this->terminada->SqlOrderBy = "";

		// fechainicio
		$this->fechainicio = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_fechainicio', 'fechainicio', '`fechainicio`', 133, EWR_DATATYPE_DATE, 7);
		$this->fechainicio->FldDefaultErrMsg = str_replace("%s", "/", $ReportLanguage->Phrase("IncorrectDateDMY"));
		$this->fields['fechainicio'] = &$this->fechainicio;
		$this->fechainicio->DateFilter = "";
		$this->fechainicio->SqlSelect = "SELECT DISTINCT `fechainicio` FROM " . $this->SqlFrom();
		$this->fechainicio->SqlOrderBy = "`fechainicio`";

		// fechafin
		$this->fechafin = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_fechafin', 'fechafin', '`fechafin`', 133, EWR_DATATYPE_DATE, 7);
		$this->fechafin->FldDefaultErrMsg = str_replace("%s", "/", $ReportLanguage->Phrase("IncorrectDateDMY"));
		$this->fields['fechafin'] = &$this->fechafin;
		$this->fechafin->DateFilter = "";
		$this->fechafin->SqlSelect = "SELECT DISTINCT `fechafin` FROM " . $this->SqlFrom();
		$this->fechafin->SqlOrderBy = "`fechafin`";

		// idprograma
		$this->idprograma = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_idprograma', 'idprograma', '`idprograma`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idprograma->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idprograma'] = &$this->idprograma;
		$this->idprograma->DateFilter = "";
		$this->idprograma->SqlSelect = "";
		$this->idprograma->SqlOrderBy = "";

		// programa
		$this->programa = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_programa', 'programa', '`programa`', 200, EWR_DATATYPE_STRING, -1);
		$this->programa->GroupingFieldId = 1;
		$this->fields['programa'] = &$this->programa;
		$this->programa->DateFilter = "";
		$this->programa->SqlSelect = "";
		$this->programa->SqlOrderBy = "";
		$this->programa->FldGroupByType = "";
		$this->programa->FldGroupInt = "0";
		$this->programa->FldGroupSql = "";

		// idusuario
		$this->idusuario = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_idusuario', 'idusuario', '`idusuario`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idusuario->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idusuario'] = &$this->idusuario;
		$this->idusuario->DateFilter = "";
		$this->idusuario->SqlSelect = "";
		$this->idusuario->SqlOrderBy = "";

		// nombre
		$this->nombre = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_nombre', 'nombre', '`nombre`', 200, EWR_DATATYPE_STRING, -1);
		$this->nombre->GroupingFieldId = 3;
		$this->fields['nombre'] = &$this->nombre;
		$this->nombre->DateFilter = "";
		$this->nombre->SqlSelect = "";
		$this->nombre->SqlOrderBy = "";
		$this->nombre->FldGroupByType = "";
		$this->nombre->FldGroupInt = "0";
		$this->nombre->FldGroupSql = "";

		// ATENDIDO
		$this->ATENDIDO = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_ATENDIDO', 'ATENDIDO', '`ATENDIDO`', 131, EWR_DATATYPE_NUMBER, -1);
		$this->ATENDIDO->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['ATENDIDO'] = &$this->ATENDIDO;
		$this->ATENDIDO->DateFilter = "";
		$this->ATENDIDO->SqlSelect = "";
		$this->ATENDIDO->SqlOrderBy = "";

		// PENDIENTE
		$this->PENDIENTE = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_PENDIENTE', 'PENDIENTE', '`PENDIENTE`', 131, EWR_DATATYPE_NUMBER, -1);
		$this->PENDIENTE->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['PENDIENTE'] = &$this->PENDIENTE;
		$this->PENDIENTE->DateFilter = "";
		$this->PENDIENTE->SqlSelect = "";
		$this->PENDIENTE->SqlOrderBy = "";

		// TOTAL
		$this->TOTAL = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_TOTAL', 'TOTAL', '`TOTAL`', 20, EWR_DATATYPE_NUMBER, -1);
		$this->TOTAL->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['TOTAL'] = &$this->TOTAL;
		$this->TOTAL->DateFilter = "";
		$this->TOTAL->SqlSelect = "";
		$this->TOTAL->SqlOrderBy = "";

		// PROCENT
		$this->PROCENT = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_PROCENT', 'PROCENT', '`PROCENT`', 131, EWR_DATATYPE_NUMBER, -1);
		$this->PROCENT->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['PROCENT'] = &$this->PROCENT;
		$this->PROCENT->DateFilter = "";
		$this->PROCENT->SqlSelect = "";
		$this->PROCENT->SqlOrderBy = "";

		// CALIFICADO
		$this->CALIFICADO = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_CALIFICADO', 'CALIFICADO', '`CALIFICADO`', 131, EWR_DATATYPE_NUMBER, -1);
		$this->CALIFICADO->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['CALIFICADO'] = &$this->CALIFICADO;
		$this->CALIFICADO->DateFilter = "";
		$this->CALIFICADO->SqlSelect = "";
		$this->CALIFICADO->SqlOrderBy = "";

		// NOINTERESADO
		$this->NOINTERESADO = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_NOINTERESADO', 'NOINTERESADO', '`NOINTERESADO`', 131, EWR_DATATYPE_NUMBER, -1);
		$this->NOINTERESADO->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['NOINTERESADO'] = &$this->NOINTERESADO;
		$this->NOINTERESADO->DateFilter = "";
		$this->NOINTERESADO->SqlSelect = "";
		$this->NOINTERESADO->SqlOrderBy = "";

		// OTROPROGRAMA
		$this->OTROPROGRAMA = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_OTROPROGRAMA', 'OTROPROGRAMA', '`OTROPROGRAMA`', 131, EWR_DATATYPE_NUMBER, -1);
		$this->OTROPROGRAMA->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['OTROPROGRAMA'] = &$this->OTROPROGRAMA;
		$this->OTROPROGRAMA->DateFilter = "";
		$this->OTROPROGRAMA->SqlSelect = "";
		$this->OTROPROGRAMA->SqlOrderBy = "";

		// FALLIDA
		$this->FALLIDA = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_FALLIDA', 'FALLIDA', '`FALLIDA`', 131, EWR_DATATYPE_NUMBER, 7);
		$this->FALLIDA->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['FALLIDA'] = &$this->FALLIDA;
		$this->FALLIDA->DateFilter = "";
		$this->FALLIDA->SqlSelect = "";
		$this->FALLIDA->SqlOrderBy = "";

		// Otras
		$this->Otras = new crField('Rep_Estado_Campania', 'Rep_Estado_Campania', 'x_Otras', 'Otras', '`Otras`', 131, EWR_DATATYPE_NUMBER, -1);
		$this->Otras->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['Otras'] = &$this->Otras;
		$this->Otras->DateFilter = "";
		$this->Otras->SqlSelect = "";
		$this->Otras->SqlOrderBy = "";
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
		} else {
			if ($ofld->GroupingFieldId == 0) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = "";
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fld->FldExpression, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fld->FldExpression . " " . $fld->getSort();
				} else {
					if ($sDtlSortSql <> "") $sDtlSortSql .= ", ";
					$sDtlSortSql .= $fld->FldExpression . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ",";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`estado_campania_view`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "`programa` ASC, `campania` ASC, `nombre` ASC";
	}

	// Table Level Group SQL
	function SqlFirstGroupField() {
		return "`programa`";
	}

	function SqlSelectGroup() {
		return "SELECT DISTINCT " . $this->SqlFirstGroupField() . " FROM " . $this->SqlFrom();
	}

	function SqlOrderByGroup() {
		return "`programa` ASC";
	}

	function SqlSelectAgg() {
		return "SELECT SUM(`ATENDIDO`) AS `sum_atendido`, SUM(`PENDIENTE`) AS `sum_pendiente`, SUM(`TOTAL`) AS `sum_total`, SUM(`CALIFICADO`) AS `sum_calificado`, SUM(`NOINTERESADO`) AS `sum_nointeresado`, SUM(`OTROPROGRAMA`) AS `sum_otroprograma`, SUM(`FALLIDA`) AS `sum_fallida` FROM " . $this->SqlFrom();
	}

	function SqlAggPfx() {
		return "";
	}

	function SqlAggSfx() {
		return "";
	}

	function SqlSelectCount() {
		return "SELECT COUNT(*) FROM " . $this->SqlFrom();
	}

	// Sort URL
	function SortUrl(&$fld) {
		return "";
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here	
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		// if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//     $filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>
