<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Controller\Adminhtml\Group;

use Infrangible\BackendWidget\Model\Backend\Session;
use Infrangible\CmsGroup\Traits\Group;
use Infrangible\Core\Helper\Cms;
use Infrangible\Core\Helper\Instances;
use Infrangible\Core\Helper\Registry;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Model\AbstractModel;
use Psr\Log\LoggerInterface;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Delete
    extends \Infrangible\BackendWidget\Controller\Backend\Object\Delete
{
    use Group;

    /** @var Cms */
    protected $cmsHelper;

    public function __construct(
        Registry $registryHelper,
        Context $context,
        Instances $instanceHelper,
        LoggerInterface $logging,
        Session $session,
        Cms $cmsHelper
    ) {
        parent::__construct($registryHelper, $context, $instanceHelper, $logging, $session);

        $this->cmsHelper = $cmsHelper;
    }

    /**
     * @throws \Exception
     */
    protected function beforeDelete(AbstractModel $object)
    {
        parent::beforeDelete($object);

        $cmsPageCollection = $this->cmsHelper->getCmsPageCollection();
        $cmsPageCollection->addFieldToFilter('group_id', $object->getId());

        if (count($cmsPageCollection->getAllIds()) > 0) {
            throw new \Exception(__('The group cannot be deleted.')->render());
        }

        $cmsBlockCollection = $this->cmsHelper->getCmsBlockCollection();
        $cmsBlockCollection->addFieldToFilter('group_id', $object->getId());

        if (count($cmsBlockCollection->getAllIds()) > 0) {
            throw new \Exception(__('The group cannot be deleted.')->render());
        }
    }

    /**
     * @return string
     */
    protected function getObjectDeletedMessage(): string
    {
        return __('The group has been deleted.')->render();
    }
}
