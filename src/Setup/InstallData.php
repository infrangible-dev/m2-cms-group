<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Setup;

use Magento\Framework\DB\Adapter\Pdo\Mysql;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Zend_Db_Adapter_Exception;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class InstallData
    implements InstallDataInterface
{
    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     *
     * @return void
     * @throws Zend_Db_Adapter_Exception
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var Mysql $connection */
        $connection = $setup->getConnection();

        $connection->insert($connection->getTableName('cms_group'), ['group_id' => 0, 'name' => 'None', 'system' => 1]);

        $noGroupId = $connection->lastInsertId();

        $connection->update($connection->getTableName('cms_block'), ['group_id' => $noGroupId], 'group_id IS NULL');
        $connection->update($connection->getTableName('cms_page'), ['group_id' => $noGroupId], 'group_id IS NULL');
    }
}
