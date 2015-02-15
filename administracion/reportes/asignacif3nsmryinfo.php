<?php

// Global variable for table object
$AsignaciF3n = NULL;

//
// Table class for Asignación
//
class crAsignaciF3n extends crTableBase {

//	var $SelectLimit = TRUE;
	var $idasignar;
	var $nombre;
	var $asesor;
	var $idusuario;
	var $fecha;
	var $campania;
	var $idcampania;
	var $campnom;
	var $programa;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage;
		$this->TableVar = 'AsignaciF3n';
		$this->TableName = 'Asignación';
		$this->TableType = 'REPORT';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0;

		// idasignar
		$this->idasignar = new crField('AsignaciF3n', 'Asignación', 'x_idasignar', 'idasignar', '`idasignar`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idasignar->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idasignar'] = &$this->idasignar;
		$this->idasignar->DateFilter = "";
		$this->idasignar->SqlSelect = "";
		$this->idasignar->SqlOrderBy = "";

		// nombre
		$this->nombre = new crField('AsignaciF3n', 'Asignación', 'x_nombre', 'nombre', '`nombre`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['nombre'] = &$this->nombre;
		$this->nombre->DateFilter = "";
		$this->nombre->SqlSelect = "";
		$this->nombre->SqlOrderBy = "";

		// asesor
		$this->asesor = new crField('AsignaciF3n', 'Asignación', 'x_asesor', 'asesor', '`asesor`', 200, EWR_DATATYPE_STRING, -1);
		$this->asesor->GroupingFieldId = 3;
		$this->fields['asesor'] = &$this->asesor;
		$this->asesor->DateFilter = "";
		$this->asesor->SqlSelect = "SELECT DISTINCT `asesor` FROM " . $this->SqlFrom();
		$this->asesor->SqlOrderBy = "`asesor`";
		$this->asesor->FldGroupByType = "";
		$this->asesor->FldGroupInt = "0";
		$this->asesor->FldGroupSql = "";

		// idusuario
		$this->idusuario = new crField('AsignaciF3n', 'Asignación', 'x_idusuario', 'idusuario', '`idusuario`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idusuario->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idusuario'] = &$this->idusuario;
		$this->idusuario->DateFilter = "";
		$this->idusuario->SqlSelect = "";
		$this->idusuario->SqlOrderBy = "";

		// fecha
		$this->fecha = new crField('AsignaciF3n', 'Asignación', 'x_fecha', 'fecha', '`fecha`', 133, EWR_DATATYPE_DATE, 7);
		$this->fecha->FldDefaultErrMsg = str_replace("%s", "/", $ReportLanguage->Phrase("IncorrectDateDMY"));
		$this->fields['fecha'] = &$this->fecha;
		$this->fecha->DateFilter = "";
		$this->fecha->SqlSelect = "";
		$this->fecha->SqlOrderBy = "";

		// campania
		$this->campania = new crField('AsignaciF3n', 'Asignación', 'x_campania', 'campania', '`campania`', 200, EWR_DATATYPE_STRING, -1);
		$this->campania->GroupingFieldId = 2;
		$this->fields['campania'] = &$this->campania;
		$this->campania->DateFilter = "";
		$this->campania->SqlSelect = "SELECT DISTINCT `campania` FROM " . $this->SqlFrom();
		$this->campania->SqlOrderBy = "`campania`";
		$this->campania->FldGroupByType = "";
		$this->campania->FldGroupInt = "0";
		$this->campania->FldGroupSql = "";

		// idcampania
		$this->idcampania = new crField('AsignaciF3n', 'Asignación', 'x_idcampania', 'idcampania', '`idcampania`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idcampania->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idcampania'] = &$this->idcampania;
		$this->idcampania->DateFilter = "";
		$this->idcampania->SqlSelect = "";
		$this->idcampania->SqlOrderBy = "";

		// campnom
		$this->campnom = new crField('AsignaciF3n', 'Asignación', 'x_campnom', 'campnom', '`campnom`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['campnom'] = &$this->campnom;
		$this->campnom->DateFilter = "";
		$this->campnom->SqlSelect = "";
		$this->campnom->SqlOrderBy = "";

		// programa
		$this->programa = new crField('AsignaciF3n', 'Asignación', 'x_programa', 'programa', '`programa`', 200, EWR_DATATYPE_STRING, -1);
		$this->programa->GroupingFieldId = 1;
		$this->fields['programa'] = &$this->programa;
		$this->programa->DateFilter = "";
		$this->programa->SqlSelect = "SELECT DISTINCT `programa` FROM " . $this->SqlFrom();
		$this->programa->SqlOrderBy = "`programa`";
		$this->programa->FldGroupByType = "";
		$this->programa->FldGroupInt = "0";
		$this->programa->FldGroupSql = "";
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
		return "`asignacion_view`";
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
		return "`programa` ASC, `campania` ASC, `asesor` ASC";
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
		return "SELECT * FROM " . $this->SqlFrom();
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
