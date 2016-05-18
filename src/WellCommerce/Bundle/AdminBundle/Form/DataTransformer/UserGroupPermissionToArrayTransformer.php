<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\AdminBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\AdminBundle\Entity\UserGroupInterface;
use WellCommerce\Bundle\AdminBundle\Entity\UserGroupPermission;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\CollectionToArrayTransformer;

/**
 * Class UserGroupPermissionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserGroupPermissionToArrayTransformer extends CollectionToArrayTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        $values = [];

        if ($modelData instanceof Collection) {
            $modelData->map(function (UserGroupPermission $userGroupPermission) use (&$values) {
                list($permissionType, $action) = explode('.', $userGroupPermission->getName());
                $values[$permissionType][$action] = $userGroupPermission->isEnabled();
            });
        }

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $values)
    {
        if ($modelData instanceof UserGroupInterface) {
            $previousCollection = $modelData->getPermissions();
            $this->clearPreviousCollection($previousCollection);
            $newCollection = $this->createCollection($values, $modelData);
            $modelData->setPermissions($newCollection);
        }
    }

    protected function createCollection(array $values = [], UserGroupInterface $userGroup)
    {
        $collection = new ArrayCollection();
        foreach ($values as $permissionType => $actions) {
            foreach ($actions as $action => $enabled) {
                $name       = sprintf('%s.%s', $permissionType, $action);
                $permission = new UserGroupPermission();
                $permission->setGroup($userGroup);
                $permission->setName($name);
                $permission->setEnabled($enabled);
                $collection->add($permission);
            }
        }

        return $collection;
    }

    /**
     * Resets previous photo collection
     *
     * @param Collection $collection
     */
    protected function clearPreviousCollection(Collection $collection)
    {
        if ($collection->count()) {
            foreach ($collection as $item) {
                $collection->removeElement($item);
            }
        }
    }
}
