<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Controller\Adminhtml\Group;

use Infrangible\CmsGroup\Traits\Group;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Grid
    extends \Infrangible\BackendWidget\Controller\Backend\Object\Grid
{
    use Group;
}
