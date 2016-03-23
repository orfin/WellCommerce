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

namespace WellCommerce\Bundle\LocaleBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class LocaleController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleController extends AbstractAdminController
{
    public function deleteAction(int $id) : Response
    {
        return $this->jsonResponse([
            'error' => 'You can delete a locale only by using "wellcommerce:locale:delete" console command.'
        ]);
    }
}
