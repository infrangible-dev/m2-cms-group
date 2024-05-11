<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Model\Product\Attribute\Source;

use Infrangible\CmsGroup\Model\Group;
use Magento\Cms\Model\Block;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class CmsBlock
    extends AbstractSource
{
    /** @var CollectionFactory */
    protected $blockCollectionFactory;

    /** @var \Infrangible\CmsGroup\Model\ResourceModel\Group\CollectionFactory */
    protected $groupCollectionFactory;

    public function __construct(
        CollectionFactory $blockCollectionFactory,
        \Infrangible\CmsGroup\Model\ResourceModel\Group\CollectionFactory $groupCollectionFactory
    ) {
        $this->blockCollectionFactory = $blockCollectionFactory;
        $this->groupCollectionFactory = $groupCollectionFactory;
    }

    /**
     * @return array|null
     */
    public function getAllOptions(): ?array
    {
        if (!$this->_options) {
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

            /** @var Block $block */
            foreach ($blockCollection as $block) {
                $id = $block->getId();
                $title = $block->getTitle();
                $groupId = $block->getData('group_id');

                $blockData[$groupData[$groupId]][$id] = $title;
            }

            ksort($blockData, SORT_STRING);

            $this->_options = [
                [
                    'value' => '',
                    'label' => __('Please select a static block.')
                ]
            ];

            foreach ($blockData as $groupName => $groupBlockData) {
                $blockResult = [];

                foreach ($groupBlockData as $blockId => $blockTitle) {
                    $blockResult[] = ['value' => $blockId, 'label' => $blockTitle];
                }

                $this->_options[] = [
                    'value' => $blockResult,
                    'label' => $groupName
                ];
            }
        }

        return $this->_options;
    }
}
