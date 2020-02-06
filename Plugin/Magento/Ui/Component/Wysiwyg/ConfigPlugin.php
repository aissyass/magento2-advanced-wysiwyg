<?php
 /**
  * Created: 2020
  *
  * @package   PHPAISS_WysiwygAdvanced
  * @category  PHPAISS
  * @author    Yassine AISSAOUI
  * @copyright PHPAISS Magento 2
  */

namespace PHPAISS\WysiwygAdvanced\Plugin\Magento\Ui\Component\Wysiwyg;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;
use Magento\Ui\Block\Wysiwyg\ActiveEditor;
use Magento\Ui\Component\Wysiwyg\ConfigInterface;
use PHPAISS\WysiwygAdvanced\Helper\Data;

class ConfigPlugin
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * ConfigPlugin constructor.
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Enable variables & widgets on product edit page
     *
     * @param ConfigInterface $configInterface
     * @param array $data
     * @return array
     */
    public function beforeGetConfig(
        ConfigInterface $configInterface,
        $data = []
    ) {
        // Check if advanced WYSIWYG and status is enabled and dependencies
        if ($this->helper->isAdvancedWysiwygEnabled() && $this->helper->checkDependencies()) {
            $data['add_variables'] = true;
            $data['add_widgets'] = true;
        }

        return [$data];
    }

    /**
     * Return WYSIWYG configuration
     *
     * @param ConfigInterface $configInterface
     * @param DataObject $result
     * @return DataObject
     */
    public function afterGetConfig(
        ConfigInterface $configInterface,
        DataObject $result
    ) {
        // Check if advanced WYSIWYG and status is enabled and dependencies
        if ($this->helper->isAdvancedWysiwygEnabled() && $this->helper->checkDependencies()) {
            if (
                ($result->getDataByPath('settings/menubar')) ||
                ($result->getDataByPath('settings/toolbar')) ||
                ($result->getDataByPath('settings/plugins'))
            ) {
                // Do not override ui_element config (unsure if this is needed)
                return $result;
            }

            $settings = $result->getData('settings');

            if (!is_array($settings)) {
                $settings = [];
            }

            // Configure tinymce settings
            $settings['menubar'] = true;
            $settings['image_advtab'] = true;
            $settings['plugins'] = 'advlist autolink code colorpicker directionality hr imagetools link media noneditable paste print table textcolor toc visualchars anchor charmap codesample contextmenu help image insertdatetime lists nonbreaking pagebreak preview searchreplace template textpattern visualblocks wordcount magentovariable magentowidget';
            $settings['toolbar1'] = 'magentovariable magentowidget | formatselect | styleselect | fontsizeselect | forecolor backcolor | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent';
            $settings['toolbar2'] = ' undo redo  | link anchor table charmap | image media insertdatetime | widget | searchreplace visualblocks  help | hr pagebreak';
            $settings['force_p_newlines'] = false;
            $settings['valid_children'] = '+body[style]';

            $result->setData('settings', $settings);
            return $result;
        }
        return $result;
    }
}