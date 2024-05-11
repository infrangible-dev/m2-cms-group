<?php

declare(strict_types=1);

namespace Infrangible\CmsGroup\Traits;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
trait Group
{
    /**
     * @return string
     */
    protected function getAclResourceName(): string
    {
        return 'Magento_Cms::group';
    }

    /**
     * @return string
     */
    protected function getResourceKey(): string
    {
        return 'group';
    }

    /**
     * @return string
     */
    protected function getModuleKey(): string
    {
        return 'Infrangible_CmsGroup';
    }

    /**
     * @return string
     */
    protected function getActiveMenu(): string
    {
        return 'Magento_Backend::content_elements';
    }

    /**
     * @return string
     */
    protected function getMenuKey(): string
    {
        return 'group';
    }

    /**
     * @return string
     */
    protected function getTitle(): string
    {
        return __('Groups')->render();
    }

    /**
     * @return string
     */
    protected function getObjectName(): string
    {
        return 'Group';
    }

    /**
     * @return string|null
     */
    protected function getObjectField(): string
    {
        return 'group_id';
    }

    /**
     * @return bool
     */
    protected function allowAdd(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    protected function allowEdit(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    protected function allowView(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    protected function allowDelete(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    protected function getObjectNotFoundMessage(): string
    {
        return __('Unable to find the group with id: %s!')->render();
    }
}
