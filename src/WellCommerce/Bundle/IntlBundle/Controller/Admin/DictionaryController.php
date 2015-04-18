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

namespace WellCommerce\Bundle\IntlBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\AdminBundle\Controller\AbstractAdminController;

/**
 * Class DictionaryController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class DictionaryController extends AbstractAdminController
{
    public function syncAction(Request $request)
    {
        $manager = $this->getManager();
        $manager->syncDictionary($request, $this->get('kernel'));
        $manager->getFlashHelper()->addSuccess('translation.flashes.success.synchronization');

        return $manager->getRedirectHelper()->redirectToAction('index');
    }

    /**
     * @return \WellCommerce\Bundle\IntlBundle\Manager\Admin\DictionaryManager
     */
    protected function getManager()
    {
        return parent::getManager();
    }
}
