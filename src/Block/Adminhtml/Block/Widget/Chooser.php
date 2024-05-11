<?php /** @noinspection PhpDeprecationInspection */

declare(strict_types=1);

namespace Infrangible\CmsGroup\Block\Adminhtml\Block\Widget;

use Exception;
use Infrangible\BackendWidget\Helper\Grid;
use Infrangible\CmsGroup\Model\Config\Source\Group;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Cms\Model\BlockFactory;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Chooser
    extends \Magento\Cms\Block\Adminhtml\Block\Widget\Chooser
{
    /** @var Grid */
    protected $gridHelper;

    /** @var Group */
    protected $sourceGroup;

    /**
     * @param Context           $context
     * @param Data              $backendHelper
     * @param BlockFactory      $blockFactory
     * @param CollectionFactory $collectionFactory
     * @param Grid              $gridHelper
     * @param Group             $sourceGroup
     * @param array             $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        BlockFactory $blockFactory,
        CollectionFactory $collectionFactory,
        Grid $gridHelper,
        Group $sourceGroup,
        array $data = []
    ) {
        parent::__construct($context, $backendHelper, $blockFactory, $collectionFactory, $data);

        $this->gridHelper = $gridHelper;

        $this->sourceGroup = $sourceGroup;
    }

    /**
     * @return Extended
     * @throws Exception
     */
    protected function _prepareColumns(): Extended
    {
        parent::_prepareColumns();

        $this->gridHelper->addOptionsColumn($this, 'group_id', __('Group')->render(), $this->sourceGroup->toArray());

        $this->sortColumnsByOrder();

        return $this;
    }
}
