<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package	PHPExcel_Writer_HTML
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license	http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version	1.8.0, 2014-03-02
 */


/**
 * PHPExcel_Writer_HTML
 *
 * @category   PHPExcel
 * @package	PHPExcel_Writer_HTML
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Writer_HTML extends PHPExcel_Writer_Abstract implements PHPExcel_Writer_IWriter {
	/**
	 * PHPExcel object
	 *
	 * @var PHPExcel
	 */
	protected $_phpExcel;

	/**
	 * Sheet index to write
	 *
	 * @var int
	 */
	private $_sheetIndex	= 0;

	/**
	 * Images root
	 *
	 * @var string
	 */
	private $_imagesRoot	= '.';

	/**
	 * embed images, or link to images
	 *
	 * @var boolean
	 */
	private $_embedImages	= FALSE;

	/**
	 * Use inline CSS?
	 *
	 * @var boolean
	 */
	private $_useInlineCss = false;

	/**
	 * Array of CSS styles
	 *
	 * @var array
	 */
	private $_cssStyles = null;

	/**
	 * Array of column widths in points
	 *
	 * @var array
	 */
	private $_columnWidths = null;

	/**
	 * Default font
	 *
	 * @var PHPExcel_Style_Font
	 */
	private $_defaultFont;

	/**
	 * Flag whether spans have been calculated
	 *
	 * @var boolean
	 */
	private $_spansAreCalculated	= false;

	/**
	 * Excel cells that should not be written as HTML cells
	 *
	 * @var array
	 */
	private $_isSpannedCell	= array();

	/**
	 * Excel cells that are upper-left corner in a cell merge
	 *
	 * @var array
	 */
	private $_isBaseCell	= array();

	/**
	 * Excel rows that should not be written as HTML rows
	 *
	 * @var array
	 */
	private $_isSpannedRow	= array();

	/**
	 * Is the current writer creating PDF?
	 *
	 * @var boolean
	 */
	protected $_isPdf = false;

	/**
	 * Generate the Navigation block
	 *
	 * @var boolean
	 */
	private $_generateSheetNavigationBlock = true;

	/**
	 * Create a new PHPExcel_Writer_HTML
	 *
	 * @param	PHPExcel	$phpExcel	PHPExcel object
	 */
	public function __construct(PHPExcel $phpExcel) {
		$this->_phpExcel = $phpExcel;
		$this->_defaultFont = $this->_phpExcel->getDefaultStyle()->getFont();
	}

	/**
	 * Save PHPExcel to file
	 *
	 * @param	string		$pFilename
	 * @throws	PHPExcel_Writer_Exception
	 */
	public function save($pFilename = null) {
		// garbage collect
		$this->_phpExcel->garbageCollect();

		$saveDebugLog = PHPExcel_Calculation::getInstance($this->_phpExcel)->getDebugLog()->getWriteDebugLog();
		PHPExcel_Calculation::getInstance($this->_phpExcel)->getDebugLog()->setWriteDebugLog(FALSE);
		$saveArrayReturnType = PHPExcel_Calculation::getArrayReturnType();
		PHPExcel_Calculation::setArrayReturnType(PHPExcel_Calculation::RETURN_ARRAY_AS_VALUE);

		// Build CSS
		$this->buildCSS(!$this->_useInlineCss);

		// Open file
		$fileHandle = fopen($pFilename, 'wb+');
		if ($fileHandle === false) {
			throw new PHPExcel_Writer_Exception("Could not open file $pFilename for writing.");
		}

		// Write headers
		fwrite($fileHandle, $this->generateHTMLHeader(!$this->_useInlineCss));

		// Write navigation (tabs)
		if ((!$this->_isPdf) && ($this->_generateSheetNavigationBlock)) {
			fwrite($fileHandle, $this->generateNavigation());
		}

		// Write data
		fwrite($fileHandle, $this->generateSheetData());

		// Write footer
		fwrite($fileHandle, $this->generateHTMLFooter());

		// Close file
		fclose($fileHandle);

		PHPExcel_Calculation::setArrayReturnType($saveArrayReturnType);
		PHPExcel_Calculation::getInstance($this->_phpExcel)->getDebugLog()->setWriteDebugLog($saveDebugLog);
	}

	/**
	 * Map VAlign
	 *
	 * @param	string		$vAlign		Vertical alignment
	 * @return string
	 */
	private function _mapVAlign($vAlign) {
		switch ($vAlign) {
			case PHPExcel_Style_Alignment::VERTICAL_BOTTOM:		return 'bottom';
			case PHPExcel_Style_Alignment::VERTICAL_TOP:		return 'top';
			case PHPExcel_Style_Alignment::VERTICAL_CENTER:
			case PHPExcel_Style_Alignment::VERTICAL_JUSTIFY:	return 'middle';
			default: return 'baseline';
		}
	}

	/**
	 * Map HAlign
	 *
	 * @param	string		$hAlign		Horizontal alignment
	 * @return string|false
	 */
	private function _mapHAlign($hAlign) {
		switch ($hAlign) {
			case PHPExcel_Style_Alignment::HORIZONTAL_GENERAL:				return false;
			case PHPExcel_Style_Alignment::HORIZONTAL_LEFT:					return 'left';
			case PHPExcel_Style_Alignment::HORIZONTAL_RIGHT:				return 'right';
			case PHPExcel_Style_Alignment::HORIZONTAL_CENTER:
			case PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS:	return 'center';
			case PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY:				return 'justify';
			default: return false;
		}
	}

	/**
	 * Map border style
	 *
	 * @param	int		$borderStyle		Sheet index
	 * @return	string
	 */
	private function _mapBorderStyle($borderStyle) {
		switch ($borderStyle) {
			case PHPExcel_Style_Border::BORDER_NONE:				return 'none';
			case PHPExcel_Style_Border::BORDER_DASHDOT:				return '1px dashed';
			case PHPExcel_Style_Border::BORDER_DASHDOTDOT:			return '1px dotted';
			case PHPExcel_Style_Border::BORDER_DASHED:				return '1px dashed';
			case PHPExcel_Style_Border::BORDER_DOTTED:				return '1px dotted';
			case PHPExcel_Style_Border::BORDER_DOUBLE:				return '3px double';
			case PHPExcel_Style_Border::BORDER_HAIR:				return '1px solid';
			case PHPExcel_Style_Border::BORDER_MEDIUM:				return '2px solid';
			case PHPExcel_Style_Border::BORDER_MEDIUMDASHDOT:		return '2px dashed';
			case PHPExcel_Style_Border::BORDER_MEDIUMDASHDOTDOT:	return '2px dotted';
			case PHPExcel_Style_Border::BORDER_MEDIUMDASHED:		return '2px dashed';
			case PHPExcel_Style_Border::BORDER_SLANTDASHDOT:		return '2px dashed';
			case PHPExcel_Style_Border::BORDER_THICK:				return '3px solid';
			case PHPExcel_Style_Border::BORDER_THIN:				return '1px solid';
			default: return '1px solid'; // map others to thin
		}
	}

	/**
	 * Get sheet index
	 *
	 * @return int
	 */
	public function getSheetIndex() {
		return $this->_sheetIndex;
	}

	/**
	 * Set sheet index
	 *
	 * @param	int		$pValue		Sheet index
	 * @return PHPExcel_Writer_HTML
	 */
	public function setSheetIndex($pValue = 0) {
		$this->_sheetIndex = $pValue;
		return $this;
	}

	/**
	 * Get sheet index
	 *
	 * @return boolean
	 */
	public function getGenerateSheetNavigationBlock() {
		return $this->_generateSheetNavigationBlock;
	}

	/**
	 * Set sheet index
	 *
	 * @param	boolean		$pValue		Flag indicating whether the sheet navigation block should be generated or not
	 * @return PHPExcel_Writer_HTML
	 */
	public function setGenerateSheetNavigationBlock($pValue = true) {
		$this->_generateSheetNavigationBlock = (bool) $pValue;
		return $this;
	}

	/**
	 * Write all sheets (resets sheetIndex to NULL)
	 */
	public function writeAllSheets() {
		$this->_sheetIndex = null;
		return $this;
	}

	/**
	 * Generate HTML header
	 *
	 * @param	boolean		$pIncludeStyles		Include styles?
	 * @return	string
	 * @throws PHPExcel_Writer_Exception
	 */
	public function generateHTMLHeader($pIncludeStyles = false) {
		// PHPExcel object known?
		if (is_null($this->_phpExcel)) {
			throw new PHPExcel_Writer_Exception('Internal PHPExcel object not set to an instance of an object.');
		}

		// Construct HTML
		$properties = $this->_phpExcel->getProperties();
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">' . PHP_EOL;
		$html .= '<!-- Generated by PHPExcel - http://www.phpexcel.net -->' . PHP_EOL;
		$html .= '<html>' . PHP_EOL;
		$html .= '  <head>' . PHP_EOL;
		$html .= '	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . PHP_EOL;
		if ($properties->getTitle() > '')
			$html .= '	  <title>' . htmlspecialchars($properties->getTitle()) . '</title>' . PHP_EOL;

		if ($properties->getCreator() > '')
			$html .= '	  <meta name="author" content="' . htmlspecialchars($properties->getCreator()) . '" />' . PHP_EOL;
		if ($properties->getTitle() > '')
			$html .= '	  <meta name="title" content="' . htmlspecialchars($properties->getTitle()) . '" />' . PHP_EOL;
		if ($properties->getDescription() > '')
			$html .= '	  <meta name="description" content="' . htmlspecialchars($properties->getDescription()) . '" />' . PHP_EOL;
		if ($properties->getSubject() > '')
			$html .= '	  <meta name="subject" content="' . htmlspecialchars($properties->getSubject()) . '" />' . PHP_EOL;
		if ($properties->getKeywords() > '')
			$html .= '	  <meta name="keywords" content="' . htmlspecialchars($properties->getKeywords()) . '" />' . PHP_EOL;
		if ($properties->getCategory() > '')
			$html .= '	  <meta name="category" content="' . htmlspecialchars($properties->getCategory()) . '" />' . PHP_EOL;
		if ($properties->getCompany() > '')
			$html .= '	  <meta name="company" content="' . htmlspecialchars($properties->getCompany()) . '" />' . PHP_EOL;
		if ($properties->getManager() > '')
			$html .= '	  <meta name="manager" content="' . htmlspecialchars($properties->getManager()) . '" />' . PHP_EOL;

		if ($pIncludeStyles) {
			$html .= $this->generateStyles(true);
		}

		$html .= '  </head>' . PHP_EOL;
		$html .= '' . PHP_EOL;
		$html .= '  <body>' . PHP_EOL;

		// Return
		return $html;
	}

	/**
	 * Generate sheet data
	 *
	 * @return	string
	 * @throws PHPExcel_Writer_Exception
	 */
	public function generateSheetData() {
		// PHPExcel object known?
		if (is_null($this->_phpExcel)) {
			throw new PHPExcel_Writer_Exception('Internal PHPExcel object not set to an instance of an object.');
		}

		// Ensure that Spans have been calculated?
		if (!$this->_spansAreCalculated) {
			$this->_calculateSpans();
		}

		// Fetch sheets
		$sheets = array();
		if (is_null($this->_sheetIndex)) {
			$sheets = $this->_phpExcel->getAllSheets();
		} else {
			$sheets[] = $this->_phpExcel->getSheet($this->_sheetIndex);
		}

		// Construct HTML
		$html = '';

		// Loop all sheets
		$sheetId = 0;
		foreach ($sheets as $sheet) {
			// Write table header
			$html .= $this->_generateTableHeader($sheet);

			// Get worksheet dimension
			$dimension = explode(':', $sheet->calculateWorksheetDimension());
			$dimension[0] = PHPExcel_Cell::coordinateFromString($dimension[0]);
			$dimension[0][0] = PHPExcel_Cell::columnIndexFromString($dimension[0][0]) - 1;
			$dimension[1] = PHPExcel_Cell::coordinateFromString($dimension[1]);
			$dimension[1][0] = PHPExcel_Cell::columnIndexFromString($dimension[1][0]) - 1;

			// row min,max
			$rowMin = $dimension[0][1];
			$rowMax = $dimension[1][1];

			// calculate start of <tbody>, <thead>
			$tbodyStart = $rowMin;
			$theadStart = $theadEnd   = 0; // default: no <thead>	no </thead>
			if ($sheet->getPageSetup()->isRowsToRepeatAtTopSet()) {
				$rowsToRepeatAtTop = $sheet->getPageSetup()->getRowsToRepeatAtTop();

				// we can only support repeating rows that start at top row
				if ($rowsToRepeatAtTop[0] == 1) {
					$theadStart = $rowsToRepeatAtTop[0];
					$theadEnd   = $rowsToRepeatAtTop[1];
					$tbodyStart = $rowsToRepeatAtTop[1] + 1;
				}
			}

			// Loop through cells
			$row = $rowMin-1;
			while($row++ < $rowMax) {
				// <thead> ?
				if ($row == $theadStart) {
					$html .= '		<thead>' . PHP_EOL;
				}

				// <tbody> ?
				if ($row == $tbodyStart) {
					$html .= '		<tbody>' . PHP_EOL;
				}

				// Write row if there are HTML table cells in it
				if ( !isset($this->_isSpannedRow[$sheet->getParent()->getIndex($sheet)][$row]) ) {
					// Start a new rowData
					$rowData = array();
					// Loop through columns
					$column = $dimension[0][0] - 1;
					while($column++ < $dimension[1][0]) {
						// Cell exists?
						if ($sheet->cellExistsByColumnAndRow($column, $row)) {
							$rowData[$column] = PHPExcel_Cell::stringFromColumnIndex($column) . $row;
						} else {
							$rowData[$column] = '';
						}
					}
					$html .= $this->_generateRow($sheet, $rowData, $row - 1);
				}

				// </thead> ?
				if ($row == $theadEnd) {
					$html .= '		</thead>' . PHP_EOL;
				}
			}
			$html .= $this->_extendRowsForChartsAndImages($sheet, $row);

			// Close table body.
			$html .= '		</tbody>' . PHP_EOL;

			// Write table footer
			$html .= $this->_generateTableFooter();

			// Writing PDF?
			if ($this->_isPdf) {
				if (is_null($this->_sheetIndex) && $sheetId + 1 < $this->_phpExcel->getSheetCount()) {
					$html .= '<div style="page-break-before:always" />';
				}
			}

			// Next sheet
			++$sheetId;
		}

		// Return
		return $html;
	}

	/**
	 * Generate sheet tabs
	 *
	 * @return	string
	 * @throws PHPExcel_Writer_Exception
	 */
	public function generateNavigation()
	{
		// PHPExcel object known?
		if (is_null($this->_phpExcel)) {
			throw new PHPExcel_Writer_Exception('Internal PHPExcel object not set to an instance of an object.');
		}

		// Fetch sheets
		$sheets = array();
		if (is_null($this->_sheetIndex)) {
			$sheets = $this->_phpExcel->getAllSheets();
		} else {
			$sheets[] = $this->_phpExcel->getSheet($this->_sheetIndex);
		}

		// Construct HTML
		$html = '';

		// Only if there are more than 1 sheets
		if (count($sheets) > 1) {
			// Loop all sheets
			$sheetId = 0;

			$html .= '<ul class="navigation">' . PHP_EOL;

			foreach ($sheets as $sheet) {
				$html .= '  <li class="sheet' . $sheetId . '"><a href="#sheet' . $sheetId . '">' . $sheet->getTitle() . '</a></li>' . PHP_EOL;
				++$sheetId;
			}

			$html .= '</ul>' . PHP_EOL;
		}

		return $html;
	}

	private function _extendRowsForChartsAndImages(PHPExcel_Worksheet $pSheet, $row) {
		$rowMax = $row;
		$colMax = 'A';
		if ($this->_includeCharts) {
			foreach ($pSheet->getChartCollection() as $chart) {
				if ($chart instanceof PHPExcel_Chart) {
				    $chartCoordinates = $chart->getTopLeftPosition();
				    $chartTL = PHPExcel_Cell::coordinateFromString($chartCoordinates['cell']);
					$chartCol = PHPExcel_Cell::columnIndexFromString($chartTL[0]);
					if ($chartTL[1] > $rowMax) {
						$rowMax = $chartTL[1];
						if ($chartCol > PHPExcel_Cell::columnIndexFromString($colMax)) {
							$colMax = $chartTL[0];
						}
					}
				}
			}
		}

		foreach ($pSheet->getDrawingCollection() as $drawing) {
			if ($drawing instanceof PHPExcel_Worksheet_Drawing) {
			    $imageTL = PHPExcel_Cell::coordinateFromString($drawing->getCoordinates());
				$imageCol = PHPExcel_Cell::columnIndexFromString($imageTL[0]);
				if ($imageTL[1] > $rowMax) {
					$rowMax = $imageTL[1];
					if ($imageCol > PHPExcel_Cell::columnIndexFromString($colMax)) {
						$colMax = $imageTL[0];
					}
				}
			}
		}
		$html = '';
		$colMax++;
		while ($row < $rowMax) {
			$html .= '<tr>';
			for ($col = 'A'; $col != $colMax; ++$col) {
				$html .= '<td>';
				$html .= $this->_writeImageInCell($pSheet, $col.$row);
				if ($this->_includeCharts) {
					$html .= $this->_writeChartInCell($pSheet, $col.$row);
				}
				$html .= '</td>';
			}
			++$row;
			$html .= '</tr>';
		}
		return $html;
	}


	/**
	 * Generate image tag in cell
	 *
	 * @param	PHPExcel_Worksheet	$pSheet			PHPExcel_Worksheet
	 * @param	string				$coordinates	Cell coordinates
	 * @return	string
	 * @throws	PHPExcel_Writer_Exception
	 */
	private function _writeImageInCell(PHPExcel_Worksheet $pSheet, $coordinates) {
		// Construct HTML
		$html = '';

		// Write images
		foreach ($pSheet->getDrawingCollection() as $drawing) {
			if ($drawing instanceof PHPEx