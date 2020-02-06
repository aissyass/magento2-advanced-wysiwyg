<?php

namespace PHPAISS\WysiwygAdvanced\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Cms\Model\Wysiwyg\Config as CmsConfig;
use Magento\Ui\Model\Config as UiConfig;

class Data extends AbstractHelper
{
    /**
     * Advanced WYSIWYG configuration path
     */
    const ADVANCED_WYSIWYG_CONFIG_PATH = 'cms/wysiwyg/advanced_wysiwyg';

    /**
     * Is advanced WYSIWYG enabled
     *
     * @return bool
     */
    public function isAdvancedWysiwygEnabled()
    {
        return $this->scopeConfig->getValue(self::ADVANCED_WYSIWYG_CONFIG_PATH);
    }

    /**
     * Check dependencies (Is status and version of tinymce is v4)
     *
     * @return bool
     */
    public function checkDependencies()
    {
        return $this->_isWysiwygStatutEnabled() && $this->_isCurrentWysiwygTinymceV4();
    }

    /**
     * Is WYSIWYG status enabled
     *
     * @return bool
     */
    protected function _isWysiwygStatutEnabled()
    {
        return $this->scopeConfig->getValue(CmsConfig::WYSIWYG_STATUS_CONFIG_PATH) ==  CmsConfig::WYSIWYG_ENABLED;
    }

    /**
     * Is the current wysiwyg tinymce v4 ?
     *
     * @return bool
     */
    protected function _isCurrentWysiwygTinymceV4()
    {
        if (strpos($this->scopeConfig->getValue(UiConfig::WYSIWYG_EDITOR_CONFIG_PATH), 'tinymce4Adapter')) {
            return true;
        }

        return false;
    }
}