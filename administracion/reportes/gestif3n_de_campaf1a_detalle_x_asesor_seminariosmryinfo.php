<?php

// Global variable for table object
$GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario = NULL;

//
// Table class for Gestión de Campaña Detalle x Asesor Seminario
//
class crGestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario extends crTableBase {

//	var $SelectLimit = TRUE;
	var $idusuario;
	var $asesor;
	var $idcliente;
	var $nombre;
	var $cargo;
	var $empresa;
	var $_email;
	var $telfijo;
	var $idasignar;
	var $prioridad;
	var $hora;
	var $fecha;
	var $tipificacion;
	var $idtipificacion;
	var $subtipificacion;
	var $idsubtipificacion;
	var $observaciones;
	var $idcampania;
	var $ultimo;
	var $campania;
	var $idprograma;
	var $programa;
	var $pais;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage;
		$this->TableVar = 'GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario';
		$this->TableName = 'Gestión de Campaña Detalle x Asesor Seminario';
		$this->TableType = 'REPORT';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0;

		// idusuario
		$this->idusuario = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_idusuario', 'idusuario', '`idusuario`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idusuario->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idusuario'] = &$this->idusuario;
		$this->idusuario->DateFilter = "";
		$this->idusuario->SqlSelect = "";
		$this->idusuario->SqlOrderBy = "";

		// asesor
		$this->asesor = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_asesor', 'asesor', '`asesor`', 200, EWR_DATATYPE_STRING, -1);
		$this->asesor->GroupingFieldId = 1;
		$this->fields['asesor'] = &$this->asesor;
		$this->asesor->DateFilter = "";
		$this->asesor->SqlSelect = "SELECT DISTINCT `asesor` FROM " . $this->SqlFrom();
		$this->asesor->SqlOrderBy = "`asesor`";
		$this->asesor->FldGroupByType = "";
		$this->asesor->FldGroupInt = "0";
		$this->asesor->FldGroupSql = "";

		// idcliente
		$this->idcliente = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_idcliente', 'idcliente', '`idcliente`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idcliente->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idcliente'] = &$this->idcliente;
		$this->idcliente->DateFilter = "";
		$this->idcliente->SqlSelect = "";
		$this->idcliente->SqlOrderBy = "";

		// nombre
		$this->nombre = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_nombre', 'nombre', '`nombre`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['nombre'] = &$this->nombre;
		$this->nombre->DateFilter = "";
		$this->nombre->SqlSelect = "";
		$this->nombre->SqlOrderBy = "";

		// cargo
		$this->cargo = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_cargo', 'cargo', '`cargo`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['cargo'] = &$this->cargo;
		$this->cargo->DateFilter = "";
		$this->cargo->SqlSelect = "";
		$this->cargo->SqlOrderBy = "";

		// empresa
		$this->empresa = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_empresa', 'empresa', '`empresa`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['empresa'] = &$this->empresa;
		$this->empresa->DateFilter = "";
		$this->empresa->SqlSelect = "";
		$this->empresa->SqlOrderBy = "";

		// email
		$this->_email = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x__email', 'email', '`email`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['_email'] = &$this->_email;
		$this->_email->DateFilter = "";
		$this->_email->SqlSelect = "";
		$this->_email->SqlOrderBy = "";

		// telfijo
		$this->telfijo = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_telfijo', 'telfijo', '`telfijo`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['telfijo'] = &$this->telfijo;
		$this->telfijo->DateFilter = "";
		$this->telfijo->SqlSelect = "";
		$this->telfijo->SqlOrderBy = "";

		// idasignar
		$this->idasignar = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_idasignar', 'idasignar', '`idasignar`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idasignar->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idasignar'] = &$this->idasignar;
		$this->idasignar->DateFilter = "";
		$this->idasignar->SqlSelect = "";
		$this->idasignar->SqlOrderBy = "";

		// prioridad
		$this->prioridad = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_prioridad', 'prioridad', '`prioridad`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->prioridad->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['prioridad'] = &$this->prioridad;
		$this->prioridad->DateFilter = "";
		$this->prioridad->SqlSelect = "";
		$this->prioridad->SqlOrderBy = "";

		// hora
		$this->hora = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_hora', 'hora', '`hora`', 134, EWR_DATATYPE_TIME, -1);
		$this->hora->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectTime");
		$this->fields['hora'] = &$this->hora;
		$this->hora->DateFilter = "";
		$this->hora->SqlSelect = "";
		$this->hora->SqlOrderBy = "";

		// fecha
		$this->fecha = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_fecha', 'fecha', '`fecha`', 133, EWR_DATATYPE_DATE, 7);
		$this->fecha->FldDefaultErrMsg = str_replace("%s", "/", $ReportLanguage->Phrase("IncorrectDateDMY"));
		$this->fields['fecha'] = &$this->fecha;
		$this->fecha->DateFilter = "";
		$this->fecha->SqlSelect = "";
		$this->fecha->SqlOrderBy = "";

		// tipificacion
		$this->tipificacion = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_tipificacion', 'tipificacion', '`tipificacion`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['tipificacion'] = &$this->tipificacion;
		$this->tipificacion->DateFilter = "";
		$this->tipificacion->SqlSelect = "SELECT DISTINCT `tipificacion` FROM " . $this->SqlFrom();
		$this->tipificacion->SqlOrderBy = "`tipificacion`";

		// idtipificacion
		$this->idtipificacion = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_idtipificacion', 'idtipificacion', '`idtipificacion`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idtipificacion->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idtipificacion'] = &$this->idtipificacion;
		$this->idtipificacion->DateFilter = "";
		$this->idtipificacion->SqlSelect = "";
		$this->idtipificacion->SqlOrderBy = "";

		// subtipificacion
		$this->subtipificacion = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_subtipificacion', 'subtipificacion', '`subtipificacion`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['subtipificacion'] = &$this->subtipificacion;
		$this->subtipificacion->DateFilter = "";
		$this->subtipificacion->SqlSelect = "SELECT DISTINCT `subtipificacion` FROM " . $this->SqlFrom();
		$this->subtipificacion->SqlOrderBy = "`subtipificacion`";

		// idsubtipificacion
		$this->idsubtipificacion = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_idsubtipificacion', 'idsubtipificacion', '`idsubtipificacion`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idsubtipificacion->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idsubtipificacion'] = &$this->idsubtipificacion;
		$this->idsubtipificacion->DateFilter = "";
		$this->idsubtipificacion->SqlSelect = "";
		$this->idsubtipificacion->SqlOrderBy = "";

		// observaciones
		$this->observaciones = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_observaciones', 'observaciones', '`observaciones`', 201, EWR_DATATYPE_MEMO, -1);
		$this->fields['observaciones'] = &$this->observaciones;
		$this->observaciones->DateFilter = "";
		$this->observaciones->SqlSelect = "";
		$this->observaciones->SqlOrderBy = "";

		// idcampania
		$this->idcampania = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_idcampania', 'idcampania', '`idcampania`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idcampania->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idcampania'] = &$this->idcampania;
		$this->idcampania->DateFilter = "";
		$this->idcampania->SqlSelect = "";
		$this->idcampania->SqlOrderBy = "";

		// ultimo
		$this->ultimo = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_ultimo', 'ultimo', '`ultimo`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->ultimo->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['ultimo'] = &$this->ultimo;
		$this->ultimo->DateFilter = "";
		$this->ultimo->SqlSelect = "";
		$this->ultimo->SqlOrderBy = "";

		// campania
		$this->campania = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_campania', 'campania', '`campania`', 200, EWR_DATATYPE_STRING, -1);
		$this->campania->GroupingFieldId = 2;
		$this->fields['campania'] = &$this->campania;
		$this->campania->DateFilter = "";
		$this->campania->SqlSelect = "SELECT DISTINCT `campania` FROM " . $this->SqlFrom();
		$this->campania->SqlOrderBy = "`campania`";
		$this->campania->FldGroupByType = "";
		$this->campania->FldGroupInt = "0";
		$this->campania->FldGroupSql = "";

		// idprograma
		$this->idprograma = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_idprograma', 'idprograma', '`idprograma`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->idprograma->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['idprograma'] = &$this->idprograma;
		$this->idprograma->DateFilter = "";
		$this->idprograma->SqlSelect = "";
		$this->idprograma->SqlOrderBy = "";

		// programa
		$this->programa = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_programa', 'programa', '`programa`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['programa'] = &$this->programa;
		$this->programa->DateFilter = "";
		$this->programa->SqlSelect = "SELECT DISTINCT `programa` FROM " . $this->SqlFrom();
		$this->programa->SqlOrderBy = "`programa`";

		// pais
		$this->pais = new crField('GestiF3n_de_CampaF1a_Detalle_x_Asesor_Seminario', 'Gestión de Campaña Detalle x Asesor Seminario', 'x_pais', 'pais', '`pais`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['pais'] = &$this->pais;
		$this->pais->DateFilter = "";
		$this->pais->SqlSelect = "";
		$this->pais->SqlOrderBy = "";
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
		return "`transacciones_reporte_view`";
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
		return "`asesor` ASC, `campania` ASC";
	}

	// Table Level Group SQL
	function SqlFirstGroupField() {
		return "`asesor`";
	}

	function SqlSelectGroup() {
		return "SELECT DISTINCT " . $this->SqlFirstGroupField() . " FROM " . $this->SqlFrom();
	}

	function SqlOrderByGroup() {
		return "`asesor` ASC";
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
