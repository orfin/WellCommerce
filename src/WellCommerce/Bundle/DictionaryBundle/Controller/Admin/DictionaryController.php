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

namespace WellCommerce\Bundle\DictionaryBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class DictionaryController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\AppBundle\Manager\Admin\DictionaryManager
     */
    protected $manager;

    /**
     * Synchronizes translations to filesystem and database
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function syncAction(Request $request)
    {
        $this->manager->syncDictionary($request, $this->get('kernel'));
        $this->manager->getFlashHelper()->addSuccess('translation.flashes.success.synchronization');

        return $this->redirectToAction('index');
    }
}
