<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Observer;

use FeWeDev\Base\Arrays;
use FeWeDev\Base\Variables;
use Infrangible\CmsGroup\Model\ResourceModel\Group\CollectionFactory;
use Magento\Cms\Model\Block;
use Magento\Cms\Model\Page;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class CmsEntitySaveBefore
    implements ObserverInterface
{
    /** @var CollectionFactory */
    protected $groupCollectionFactory;

    /** @var Variables */
    protected $variables;

    /** @var Arrays */
    protected $arrays;

    public function __construct(CollectionFactory $groupCollectionFactory, Variables $variables, Arrays $arrays)
    {
        $this->groupCollectionFactory = $groupCollectionFactory;
        $this->variables = $variables;
        $this->arrays = $arrays;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $object = $observer->getDataUsingMethod('object');

        if (($object instanceof Block || $object instanceof Page)
            && $this->variables->isEmpty(
                $object->getDataUsingMethod('group_id')
            )) {

            $object->setDataUsingMethod('group_id', $this->getNoGroupId());
        }
    }

    private function getNoGroupId(): ?int
    {
        $cmsGroupData = $this->groupCollectionFactory->create()->addFilter('name', 'None')->getFirstItem()->getData();

        return $cmsGroupData ? intval($this->arrays->getValue($cmsGroupData, 'group_id', 0)) : null;
    }
}
