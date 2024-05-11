<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Controller\Adminhtml\Group;

use Infrangible\CmsGroup\Traits\Group;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Save
    extends \Infrangible\BackendWidget\Controller\Backend\Object\Save
{
    use Group;

    /**
     * @return string
     */
    protected function getObjectCreatedMessage(): string
    {
        return __('The group has been created.')->render();
    }

    /**
     * @return string
     */
    protected function getObjectUpdatedMessage(): string
    {
        return __('The group has been updated.')->render();
    }
}
