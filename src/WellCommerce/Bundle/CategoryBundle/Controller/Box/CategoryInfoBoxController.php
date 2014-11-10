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

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;

/**
 * Class CategoryInfoBoxController
 *
 * @package WellCommerce\Bundle\CategoryBundle\Controller\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class CategoryInfoBoxController extends AbstractBoxController implements BoxControllerInterface
{
    public function indexAction(Request $request)
    {
        $resource = $this->repository->findResource($request);
        $category = [
            'id'                => $resource->getId(),
            'name'              => $resource->translate()->getName(),
            'short_description' => $resource->translate()->getShortDescription(),
            'description'       => $resource->translate()->getDescription(),
        ];

        return [
            'category' => $category
        ];
    }
} 