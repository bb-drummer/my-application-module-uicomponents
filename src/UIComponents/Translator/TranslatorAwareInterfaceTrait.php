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

namespace UIComponents\Translator;

use Zend\I18n\Translator\TranslatorInterface as Translator;

/**
 * provides basic Zend\I18n\Translator handling methods
 *        
 */
trait TranslatorAwareInterfaceTrait {
	
    /**
     * Translator (optional)
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Translator text domain (optional)
     *
     * @var string
     */
    protected $translatorTextDomain = 'default';

    /**
     * Whether translator should be used
     *
     * @var bool
     */
    protected $translatorEnabled = true;
	
    /**
     * Translate a message (for label, title, …)
     *
     * @param    string $message    ID of the message to translate
     * @param    string $textDomain Text domain (category name for the translations)
     * @return string             Translated message
     */
    public function translate($message, $textDomain = null)
    {
        if (is_string($message) && !empty($message)) {
            if (null !== ($translator = $this->getTranslator())) {
                if (null === $textDomain) {
                    $textDomain = $this->getTranslatorTextDomain();
                }

                return $translator->translate($message, $textDomain);
            }
        }

        return $message;
    }

    /**
     * Sets translator to use in helper
     *
     * @param    Translator $translator    [optional] translator.
     *                                 Default is null, which sets no translator.
     * @param    string     $textDomain    [optional] text domain
     *                                 Default is null, which skips setTranslatorTextDomain
     * @return AbstractHelper
     */
    public function setTranslator(Translator $translator = null, $textDomain = null)
    {
        $this->translator = $translator;
        if (null !== $textDomain) {
            $this->setTranslatorTextDomain($textDomain);
        }
    
        return $this;
    }
    
    /**
     * Returns translator used in helper
     *
     * @return Translator|null
     */
    public function getTranslator()
    {
        if (! $this->isTranslatorEnabled()) {
            return;
        }
    
        return $this->translator;
    }
    
    /**
     * Checks if the helper has a translator
     *
     * @return bool
     */
    public function hasTranslator()
    {
        return (bool) $this->getTranslator();
    }
    
    /**
     * Sets whether translator is enabled and should be used
     *
     * @param    bool $enabled
     * @return AbstractHelper
     */
    public function setTranslatorEnabled($enabled = true)
    {
        $this->translatorEnabled = (bool) $enabled;
        return $this;
    }
    
    /**
     * Returns whether translator is enabled and should be used
     *
     * @return bool
     */
    public function isTranslatorEnabled()
    {
        return $this->translatorEnabled;
    }
    
    /**
     * Set translation text domain
     *
     * @param    string $textDomain
     * @return AbstractHelper
     */
    public function setTranslatorTextDomain($textDomain = 'default')
    {
        $this->translatorTextDomain = $textDomain;
        return $this;
    }
    
    /**
     * Return the translation text domain
     *
     * @return string
     */
    public function getTranslatorTextDomain()
    {
        return $this->translatorTextDomain;
    }
    
}
