<?php

// Global variable for table object
$Detalle_de_contacto_atendido = NULL;

//
// Table class for Detalle de contacto atendido
//
class crDetalle_de_contacto_atendido extends crTableBase {

//	var $SelectLimit = TRUE;
	var $nombre;
	var $tipificacion;
	var $subtipificacion;
	var $idtrasaccion;
	var $idcampania;
	var $idtipificacion;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage;
		$this->TableVar = 'Detalle_de_contacto_atendido';
		$this->TableName = 'Detalle de contacto atendido';
		$this->TableType = 'REPORT';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0;

		// nombre
		$this->nombre = new crField('Detalle_de_contacto_atendido', 'Detalle de contacto atendido', 'x_nombre', 'nombre', '`nombre`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['nombre'] = &$this->nombre;
		$this->nombre->DateFilter = "";
		$this->nombre->SqlSelect = "";
		$this->nombre->SqlOrderBy = "";

		// tipificacion
		$this->tipificacion = new crField('Detalle_de_contacto_atendido', 'Detalle de contacto atendido', 'x_tipificacion', 'tipificacion', '`tipificacion`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['tipificacion'] = &$this->tipificacion;
		$this->tipificacion->DateFilter = "";
		$this->tipificacion->SqlSelect = "";
		$this->tipificacion->SqlOrderBy = "";

		// subtipificacion
		$this->subtipificacion = new crField('Detalle_de_contacto_atendido', 'Detalle de contacto atendido', 'x_subtipificacion', 'subtipificacion', '`subtipificacion`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['subtipificacion'] = &$this->subtipificacion;
		$this->subtipificacion->DateFilter = "";
		$this->subtipificacion->SqlSelect = "";
		$this->subtipificacion->SqlOrderBy = "";

		// idtrasaccion
		$this->idtrasaccion = new crField('Detalle_de_contacto_atendido', 'Detalle de contacto atendido', 'x_idtrasaccion', 'idtrasaccion', '`idtrasaccion`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idtrasaccion->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idtrasaccion'] = &$this->idtrasaccion;
		$this->idtrasaccion->DateFilter = "";
		$this->idtrasaccion->SqlSelect = "";
		$this->idtrasaccion->SqlOrderBy = "";

		// idcampania
		$this->idcampania = new crField('Detalle_de_contacto_atendido', 'Detalle de contacto atendido', 'x_idcampania', 'idcampania', '`idcampania`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idcampania->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idcampania'] = &$this->idcampania;
		$this->idcampania->DateFilter = "";
		$this->idcampania->SqlSelect = "";
		$this->idcampania->SqlOrderBy = "";

		// idtipificacion
		$this->idtipificacion = new crField('Detalle_de_contacto_atendido', 'Detalle de contacto atendido', 'x_idtipificacion', 'idtipificacion', '`idtipificacion`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idtipificacion->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idtipificacion'] = &$this->idtipificacion;
		$this->idtipificacion->DateFilter = "";
		$this->idtipificacion->SqlSelect = "";
		$this->idtipificacion->SqlOrderBy = "";
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
		return "`transaccion_detalle_cliente_view`";
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
		return "";
	}

	// Table Level Group SQL
	function SqlFirstGroupField() {
		return "";
	}

	function SqlSelectGroup() {
		return "SELECT DISTINCT " . $this->SqlFirstGroupField() . " FROM " . $this->SqlFrom();
	}

	function SqlOrderByGroup() {
		return "";
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
