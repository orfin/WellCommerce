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

namespace WellCommerce\Bundle\CategoryBundle\Controller\Box;

use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;

/**
 * Class CategoryMenuBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryMenuBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $active         = null;
        $activeCategory = $this->getManager()->getCategoryProvider()->getCurrentCategory();

        if ($activeCategory instanceof Category) {
            $active = $activeCategory->getId();
        }

        return $this->render('WellCommerceCategoryBundle:Box/CategoryMenuBox:index.html.twig', [
            'active' => $active
        ]);
    }
}
