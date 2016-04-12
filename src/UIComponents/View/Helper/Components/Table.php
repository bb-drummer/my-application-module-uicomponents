<?php
/**
 * BB's Zend Framework 2 Components
 * 
 * UI Components
 *
 * @package     [MyApplication]
 * @subpackage  BB's Zend Framework 2 Components
 * @subpackage  UI Components
 * @author      Björn Bartels <coding@bjoernbartels.earth>
 * @link        https://gitlab.bjoernbartels.earth/groups/zf2
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @copyright   copyright (c) 2016 Björn Bartels <coding@bjoernbartels.earth>
 */

namespace UIComponents\View\Helper\Components;

use UIComponents\Template\Template;

/**
 *
 * render a (simple) HTML table
 *
 */
class Table extends Void 
{
    
	public $template = null;
	
	public $data = array();
	
	public $options = array();
	
	public $tags = array(
		"container" =>	"table",
		"row"		=>	"tr",
		"cell"		=>	"td",
		"headcell"	=>	"th"
	);
	
	/**
     * View helper entry point:
     * Retrieves helper and optionally sets component options to operate on
     *
     * @param  array|StdClass $config table configuration to operate on
     * @param  array|StdClass $options [optional] component options to operate on
     * @return self
     */
    public function __invoke($config = array(), $options = array())
    {
        if ( is_object($options) && method_exists($options, 'toArray') ) {
            $options = $options->toArray();
        } else if ( is_object($options) ) {
            $options = (array)$options;
        }
        
        if ( is_object($config) && method_exists($config, 'toArray') ) {
            $config = $config->toArray();
        } else if ( is_object($options) ) {
            $config = (array)$config;
        }
        
        $this->setOptions($config);
        
        if (isset($options['container']) && (null !== $options['container'])) {
            $this->setContainer($options['container']);
        }
    
        if (isset($options['tagname']) && (null !== $options['tagname'])) {
            $this->setTagname($options['tagname']);
        }
        if (isset($options['class']) && (null !== $options['class'])) {
            $this->setClassnames($options['class']);
        }
        if (isset($options['classnames']) && (null !== $options['classnames'])) {
            $this->setClassnames($options['classnames']);
        }

        if (isset($options['attr']) && (null !== $options['attr'])) {
            $this->setAttributes($options['attr']);
        }
        if (isset($options['attributes']) && (null !== $options['attributes'])) {
            $this->setAttributes($options['attributes']);
        }

        if (isset($options['content']) && (null !== $options['content'])) {
            $this->setContent($options['content']);
        }
        if (isset($options['children']) && (null !== $options['children'])) {
            $this->setContent($options['children']);
        }
        
        $this->tags = (object)$this->tags;
        
        $component = clone $this;
        return $component;
    }

    /**
     * generate framework classnames collection as zend-config object
     * 
     * @return \Zend\Config\Config
     */
    public function render()
    {
    	return $this->buildMarkup();
    }
    
	/**
	 * generate table header HTML
	 * @param OBJECT $params
	 */
	public function buildHeaderCells ($aHTMLTableColumns) {
		$sHTMLTableHeader = "";
		$sHTMLTableColumnGroup = "";
		$aColumns = array();
		foreach ((array)$aHTMLTableColumns as $iColumn => $aColumn) {
			if ($aColumn["field"]) {
				$aColumns[] = $aColumn["field"];
				$sHTMLTableHeader .= "<".$this->tags->headcell." class=\"".$aColumn["field"]."\">".$aColumn["title"]."</".$this->tags->headcell.">";
				$sHTMLTableColumnGroup .= "<column class=\"".$aColumn["field"]."\" />";
			} else {
				$sHTMLTableHeader .= "<".$this->tags->headcell." class=\"col_".$iColumn."\">".$aColumn["title"]."</".$this->tags->headcell.">";
				$sHTMLTableColumnGroup .= "<column class=\"col_".$iColumn."\" />";
			}
		}
		$this->_sHeader = $sHTMLTableHeader;
		$this->getTemplate()->set('s', 'HEADERCELLS', $sHTMLTableHeader);
		$this->getTemplate()->set('s', 'COLUMNGROUP', "<columns>".$sHTMLTableColumnGroup."</columns>");
	}
		
	/**
	 * generate table footer HTML
	 * @param OBJECT $params
	 */
	public function buildFooterCells ($aHTMLTableColumns) {
		$sHTMLTableFooter = "";
		$aColumns = array();
		foreach ((array)$aHTMLTableColumns as $iColumn => $aColumn) {
			if ($aColumn["field"]) {
				$aColumns[] = $aColumn["field"];
				$sHTMLTableFooter .= "<".$this->tags->cell." class=\"".$aColumn["field"]."\">".$aColumn["title"]."</".$this->tags->cell.">";
			} else {
				$sHTMLTableFooter .= "<".$this->tags->cell." class=\"col_".$iColumn."\">".$aColumn["title"]."</".$this->tags->cell.">";
			}
		}
		$this->_sFooter = $sHTMLTableFooter;
		$this->getTemplate()->set('s', 'FOOTERCELLS', $sHTMLTableFooter);
	}
	
	/**
	 * generate table body HTML
	 * @param OBJECT $params
	 * @return ARRAY
	 */
	public function buildBodyCells ($aRowData, $aHTMLTableColumns) {
		$aRows = array();
		$this->_aRows = array();
		foreach ( (array)$aRowData as $iRow => $oRowData ) {
			$sCells = "";
			foreach ((array)$aHTMLTableColumns as $iColumn => $aColumn) {
				$mCellValue = $oRowData[$aColumn["field"]];
				if (!empty($aColumn["callback"]) && function_exists($aColumn["callback"])) {
					$mCellValue = call_user_func($aColumn["callback"], $oRowData, $aColumn, $iColumn, $iRow);
				}
				if ( isset($aColumn["field"]) && isset($oRowData[$aColumn["field"]]) ) {
					$sClassname = $aColumn["field"];
				} else {
					$sClassname = "col_".$iColumn;
				}
				$sCells .= "<".$this->tags->cell." class=\"".$sClassname."\">".
					$mCellValue.
				"</".$this->tags->cell.">";
			}
			
			$aRows[] = $sCells;
		}
		$this->_aRows = $aRows;
		
		foreach ($aRows as $iRow => $sRow) {
			$this->getTemplate()->set('d', 'ROWID', "row_".$aRowData[$iRow]["productID"]);
			$this->getTemplate()->set('d', 'BODYCELLS', $sRow);
			if (($iRow % 2) == 0) {
				$this->getTemplate()->set('d', 'CSS_CLASS', 'even');
			} else {
				$this->getTemplate()->set('d', 'CSS_CLASS', 'odd');
			}
			$this->getTemplate()->next();
		
		}
	}
	
	/**
	 * generate mini table mark-up template
	 * @return STRING
	 */
	public function buildMarkupTemplate () {
		$aHTML = array(
			"<".$this->tags->container.">",
				"<".$this->tags->row.">",
					"{HEADERCELLS}",
				"</".$this->tags->row.">",
					"<!-- BEGIN:BLOCK -->",
						"<".$this->tags->row.">",
							"{BODYCELLS}",
						"</".$this->tags->row.">",
					"<!-- END:BLOCK -->",
				"<".$this->tags->row.">",
					"{FOOTERCELLS}",
				"</".$this->tags->row.">",
			"</".$this->tags->container.">"
		);
		$sHTML = implode("", $aHTML);
		return $sHTML;
	}
	
	/**
	 * generate table mark-up
	 * @return STRING
	 */
	public function buildMarkup () {
		$sHTML = "";
		
		$sTableID = $this->getOptions("formID");
		if (!$sTableID) {
			$sTableID = "table" . md5(microtime());
			$this->options["formID"] = $sTableID;
		}
		
		$this->getTemplate()->reset();
		$this->getTemplate()->set('s', 'TABLEID',			$sTableID );
		$this->buildHeaderCells( $this->getOptions("columns") );
		$this->buildFooterCells( $this->getOptions("footer") );
		$this->buildBodyCells( $this->getData(), $this->getOptions("columns") );
		$sTemplate = $this->getOptions("template");
		if ($sTemplate == "") {
			$sTemplate = $this->buildMarkupTemplate();
		}
		$sHTML = $this->getTemplate()->generate( $sTemplate, true );
		return $sHTML;
	}
	
	/**
	 * generate table JSON data
	 * @return STRING
	 */
	public function buildData () {
		$sJSON = "[]";
		if ($this->data) {
			$sJSON = json_encode($this->data);
		}
		return $sJSON;
	}
	
	/**
	 * return template object
	 * @return Template
	 */
	public function getTemplate() {
		if ($this->template == null) {
			$this->setTemplate();
		}
		return $this->template;
	}

	/**
	 * generate template object
	 * @param Template $template
	 * @return ProductTable
	 */
	public function setTemplate( $template = null ) {
		if ($template == null) {
			$this->template = new Template;
		} else {
			$this->template = $template;
		}
		return ($this);
	}
	
	/**
	 * return table data
	 * @return MIXED
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * set new table data
	 * @param MIXED $data
	 * @return ProductTable
	 */
	public function setData( $data = null) {
		if ( is_array($data) ) {
			$this->data = $data;
		}
		return $this;
	}

	/**
	 * return option by key or complete option set
	 * @param	STRING $key	
	 * @return	MIXED
	 */
	public function getOptions( $key = "" ) {
		if ( !empty($key) ) { 
			if ( isset($this->options[$key]) ) {
				return $this->options[$key];
			} else {
				return false;
			}
		}
		return $this->options;
	}

	/**
	 * @param OBJECT|ARRAY $options
	 * @return ProductTable
	 */
	public function setOptions($options) {
		if ( is_array($options) ) {
			$this->options = $options;
		} else if ( is_object($options) ) {
			$this->options = (array)$options;
		} else {
			throw new Exception("invalid table options");
		}
		if ( isset($this->options["data"]) ) {
			$this->setData($this->getOptions("data"));
			unset( $this->options->data );
		}
		return $this;
	}


}