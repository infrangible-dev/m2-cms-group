<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Model\ResourceModel\Group;

use Infrangible\CmsGroup\Model\Group;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Collection
    extends AbstractCollection
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(Group::class, \Infrangible\CmsGroup\Model\ResourceModel\Group::class);
    }
}
