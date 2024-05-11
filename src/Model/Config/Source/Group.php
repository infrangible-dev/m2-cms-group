<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Model\Config\Source;

use Infrangible\CmsGroup\Model\ResourceModel\Group\CollectionFactory;
use Magento\Framework\Data\Collection;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Group
    implements OptionSourceInterface
{
    /** @var CollectionFactory */
    protected $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $collection = $this->collectionFactory->create();

        $collection->addOrder('system');
        $collection->addOrder('name', Collection::SORT_ORDER_ASC);

        $data = [];

        /** @var \Infrangible\CmsGroup\Model\Group $group */
        foreach ($collection as $group) {
            $name = $group->getData('name');

            $data[$group->getId()] = $group->getData('system') ? __($name) : $name;
        }

        return $data;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $collection = $this->collectionFactory->create();

        $collection->addOrder('system');
        $collection->addOrder('name', Collection::SORT_ORDER_ASC);

        $data = [];

        /** @var \Infrangible\CmsGroup\Model\Group $group */
        foreach ($collection as $group) {
            $name = $group->getData('name');

            $data[] = ['value' => $group->getId(), 'label' => $group->getData('system') ? __($name) : $name];
        }

        return $data;
    }
}
