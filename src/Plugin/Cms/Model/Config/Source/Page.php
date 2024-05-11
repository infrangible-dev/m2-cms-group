<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Plugin\Cms\Model\Config\Source;

use Infrangible\CmsGroup\Model\Group;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Page
{
    /** @var CollectionFactory */
    protected $pageCollectionFactory;

    /** @var \Infrangible\CmsGroup\Model\ResourceModel\Group\CollectionFactory */
    protected $groupCollectionFactory;

    /** @var array */
    private $options;

    /**
     * @param CollectionFactory                                                 $pageCollectionFactory
     * @param \Infrangible\CmsGroup\Model\ResourceModel\Group\CollectionFactory $groupCollectionFactory
     */
    public function __construct(
        CollectionFactory $pageCollectionFactory,
        \Infrangible\CmsGroup\Model\ResourceModel\Group\CollectionFactory $groupCollectionFactory
    ) {
        $this->pageCollectionFactory = $pageCollectionFactory;
        $this->groupCollectionFactory = $groupCollectionFactory;
    }

    /**
     * @param \Magento\Cms\Model\Config\Source\Page $subject
     * @param callable                              $proceed
     *
     * @return array
     * @noinspection PhpUnusedParameterInspection
     */
    public function aroundToOptionArray(\Magento\Cms\Model\Config\Source\Page $subject, callable $proceed): array
    {
        if ($this->options === null) {
            $groupData = [];

            $groupCollection = $this->groupCollectionFactory->create();

            /** @var Group $group */
            foreach ($groupCollection as $group) {
                $id = $group->getId();
                $name = $group->getData('name');
                $system = $group->getData('system');

                $groupData[$id] = $system ? __($name)->render() : $name;
            }

            $pageCollection = $this->pageCollectionFactory->create();

            $pageData = [];
            $existingIdentifiers = [];

            /** @var \Magento\Cms\Model\Page $page */
            foreach ($pageCollection as $page) {
                $id = $page->getId();
                $identifier = $page->getIdentifier();
                $title = $page->getTitle();
                $groupId = $page->getData('group_id');

                if (in_array($identifier, $existingIdentifiers)) {
                    $title .= sprintf('|%d', $id);
                } else {
                    $existingIdentifiers[] = $identifier;
                }

                $pageData[$groupData[$groupId]][$identifier] = $title;
            }

            ksort($pageData, SORT_STRING);

            $this->options = [];

            foreach ($pageData as $groupName => $groupPageData) {
                $pageResult = [];

                foreach ($groupPageData as $pageIdentifier => $pageTitle) {
                    $pageResult[] = ['value' => $pageIdentifier, 'label' => $pageTitle];
                }

                $this->options[] = [
                    'value' => $pageResult,
                    'label' => $groupName
                ];
            }
        }

        return $this->options;
    }
}
