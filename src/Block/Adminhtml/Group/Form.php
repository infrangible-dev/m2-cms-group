<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Block\Adminhtml\Group;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Form
    extends \Infrangible\BackendWidget\Block\Form
{
    /**
     * @param \Magento\Framework\Data\Form $form
     */
    protected function prepareFields(\Magento\Framework\Data\Form $form)
    {
        $fieldSet = $form->addFieldset('General', ['legend' => __('General')]);

        $this->addTextField($fieldSet, 'name', __('Name')->render());
    }
}
