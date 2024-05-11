<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Group
    extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('cms_group', 'group_id');
    }

    /**
     * @param AbstractModel $object
     *
     * @return AbstractDb
     */
    protected function _beforeSave(AbstractModel $object): AbstractDb
    {
        parent::_beforeSave($object);

        if ($object->isObjectNew()) {
            $object->setDataUsingMethod('created_at', gmdate('Y-m-d H:i:s'));
        }

        $object->setDataUsingMethod('updated_at', gmdate('Y-m-d H:i:s'));

        return $this;
    }
}
