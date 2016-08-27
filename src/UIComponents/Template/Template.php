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

namespace UIComponents;

/**
 * light template mechanism
 *
 */
class Template extends TemplateAbstract
{

    /**
     * Constructor function
     * 
     * @param array $tags
     * @param \Zend\I18n\Translator\TranslatorInterface $translator
	 * @return \UIComponents\Template\TemplateAbstract
     */
    public function __construct ($tags = false, $translator = null)
	{
		return parent::__construct($tags, $translator);
	} 
	
} 
?>