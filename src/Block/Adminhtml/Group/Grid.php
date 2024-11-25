<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Block\Adminhtml\Group;

use Exception;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Grid
    extends \Infrangible\BackendWidget\Block\Grid
{
    protected function prepareCollection(AbstractDb $collection): void
    {
        $collection->addFieldToFilter('system', ['eq' => 0]);
    }

    /**
     * @throws Exception
     */
    protected function prepareFields(): void
    {
        $this->addNumberColumn('group_id', __('Id')->render());
        $this->addTextColumn('name', __('Name')->render());
    }

    /**
     * @return string[]
     */
    protected function getHiddenFieldNames(): array
    {
        return [];
    }
}
