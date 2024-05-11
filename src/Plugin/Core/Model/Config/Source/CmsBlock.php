<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Plugin\Core\Model\Config\Source;

use Infrangible\CmsGroup\Model\Group;
use Magento\Cms\Model\Block;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class CmsBlock
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
     * @param \Infrangible\Core\Model\Config\Source\CmsBlock $subject
     * @param callable                                       $proceed
     *
     * @return array
     * @noinspection PhpUnusedParameterInspection
     */
    public function aroundGetAllOptions(
        \Infrangible\Core\Model\Config\Source\CmsBlock $subject,
        callable $proceed
    ): array {
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

        $result = [['value' => '', 'label' => __('--Please Select--')]];

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
