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

namespace WellCommerce\Bundle\ReviewBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\ReviewBundle\Entity\ReviewInterface;

/**
 * Class ReviewController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewController extends AbstractAdminController
{
    public function enableAction(int $id): JsonResponse
    {
        $this->changeStatus($id, true);
        
        return $this->jsonResponse(['success' => true]);
    }
    
    public function disableAction(int $id): JsonResponse
    {
        $this->changeStatus($id, false);
        
        return $this->jsonResponse(['success' => true]);
    }
    
    private function changeStatus(int $id, bool $enabled)
    {
        $review = $this->getManager()->getRepository()->find($id);
        if ($review instanceof ReviewInterface) {
            $review->setEnabled($enabled);
            $this->getManager()->updateResource($review);
        }
    }
}
