<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Plugin\Cms\Model\Config\Source;

use Infrangible\CmsGroup\Model\Group;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Block
{
    /** @var CollectionFactory */
    protected $blockCollectionFactory;

    /** @var \Infrangible\CmsGroup\Model\ResourceModel\Group\CollectionFactory */
    protected $groupCollectionFactory;

    /**
     * @param CollectionFactory                                                 $blockCollectionFactory
     * @param \Infrangible\CmsGroup\Model\ResourceModel\Group\CollectionFactory $groupCollectionFactory
     */
    public function __construct(
        CollectionFactory $blockCollectionFactory,
        \Infrangible\CmsGroup\Model\ResourceModel\Group\CollectionFactory $groupCollectionFactory
    ) {
        $this->blockCollectionFactory = $blockCollectionFactory;
        $this->groupCollectionFactory = $groupCollectionFactory;
    }

    /**
     * @param \Magento\Cms\Model\Config\Source\Block $subject
     *
     * @return array
     * @noinspection PhpUnusedParameterInspection
     */
    public function aroundToOptionArray(\Magento\Cms\Model\Config\Source\Block $subject): array
    {
        $groupCollection = $this->groupCollectionFactory->create();

        $groupData = [];

        /** @var Group $group */
        foreach ($groupCollection as $group) {
            $id = $group->getId();
            $name = $group->getData('name');
            $system = $group->getData('system');

            $groupData[$id] = $system ? __($name)->render() : $name;
        }

        $blockCollection = $this->blockCollectionFactory->create();

        $blockData = [];

        /** @var \Magento\Cms\Model\Block $block */
        foreach ($blockCollection as $block) {
            $id = $block->getId();
            $title = $block->getTitle();
            $groupId = $block->getData('group_id');

            $blockData[$groupData[$groupId]][$id] = $title;
        }

        ksort($blockData, SORT_STRING);

        $result = [];

        foreach ($blockData as $groupName => $groupBlockData) {
            $blockResult = [];

            foreach ($groupBlockData as $blockId => $blockTitle) {
                $blockResult[] = ['value' => $blockId, 'label' => $blockTitle];
            }

            $result[] = [
                'value' => $blockResult,
                'label' => $groupName
            ];
        }

        return $result;
    }
}
