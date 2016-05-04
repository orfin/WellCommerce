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
namespace WellCommerce\Bundle\CoreBundle\Controller\Front;

use WellCommerce\Bundle\CategoryBundle\Storage\CategoryStorageInterface;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\CoreBundle\Service\Breadcrumb\BreadcrumbItem;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class AbstractFrontController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFrontController extends AbstractController implements FrontControllerInterface
{
    /**
     * Shorthand to add new breadcrumb items to collection
     *
     * @param BreadcrumbItem $item
     */
    protected function addBreadCrumbItem(BreadcrumbItem $item)
    {
        $this->get('breadcrumb.collection')->add($item);
    }

    protected function getCategoryStorage() : CategoryStorageInterface
    {
        return $this->get('category.storage');
    }
}
