<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class InstallSchema
    implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     *
     * @return void
     * @throws Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $connection = $setup->getConnection();

        $connection->startSetup();

        $this->addTable($connection);
        $this->updateCmsBlockTable($connection);
        $this->updateCmsPageTable($connection);

        $connection->endSetup();
    }

    /**
     * @throws Zend_Db_Exception
     */
    private function addTable(AdapterInterface $dbAdapter): void
    {
        $groupTableName = $dbAdapter->getTableName('cms_group');

        if ($dbAdapter->isTableExists($groupTableName)) {
            return;
        }

        $table = $dbAdapter->newTable($groupTableName);

        $table->addColumn(
            'group_id', Table::TYPE_SMALLINT, 6,
            ['identity' => true, 'primary' => true, 'nullable' => false, 'unsigned' => true]
        );
        $table->addColumn('name', Table::TYPE_TEXT, 255, ['nullable' => false]);
        $table->addColumn('system', Table::TYPE_SMALLINT, 6, ['nullable' => false, 'unsigned' => true, 'default' => 0]);
        $table->addColumn('created_at', Table::TYPE_DATETIME, null, ['nullable' => false]);
        $table->addColumn('updated_at', Table::TYPE_DATETIME, null, ['nullable' => false]);

        $dbAdapter->createTable($table);
    }

    private function updateCmsBlockTable(AdapterInterface $dbAdapter): void
    {
        $blockTableName = $dbAdapter->getTableName('cms_block');

        if ($dbAdapter->tableColumnExists($blockTableName, 'group_id')) {
            return;
        }

        $dbAdapter->addColumn($blockTableName, 'group_id', [
            'type'     => Table::TYPE_SMALLINT,
            'length'   => 6,
            'unsigned' => true,
            'nullable' => true,
            'comment'  => 'Id of CMS group'
        ]);

        $groupTableName = $dbAdapter->getTableName('cms_group');

        $dbAdapter->addForeignKey(
            $dbAdapter->getForeignKeyName(
                $blockTableName,
                'group_id',
                $groupTableName,
                'group_id'
            ),
            $blockTableName,
            'group_id',
            $groupTableName,
            'group_id',
            AdapterInterface::FK_ACTION_SET_NULL
        );
    }

    private function updateCmsPageTable(AdapterInterface $dbAdapter): void
    {
        $pageTableName = $dbAdapter->getTableName('cms_page');

        if ($dbAdapter->tableColumnExists($pageTableName, 'group_id')) {
            return;
        }

        $dbAdapter->addColumn($pageTableName, 'group_id', [
            'type'     => Table::TYPE_SMALLINT,
            'length'   => 6,
            'unsigned' => true,
            'nullable' => true,
            'comment'  => 'Id of CMS group'
        ]);

        $groupTableName = $dbAdapter->getTableName('cms_group');

        $dbAdapter->addForeignKey(
            $dbAdapter->getForeignKeyName(
                $pageTableName,
                'group_id',
                $groupTableName,
                'group_id'
            ),
            $pageTableName,
            'group_id',
            $groupTableName,
            'group_id',
            AdapterInterface::FK_ACTION_SET_NULL
        );
    }
}
