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

namespace WellCommerce\Bundle\SmugglerBundle\Controller\Admin;

use WellCommerce\Bundle\AdminBundle\Controller\AbstractAdminController;
use WellCommerce\Bundle\SmugglerBundle\Manager\Admin\PackageManager;

/**
 * Class PackageController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class PackageController extends AbstractAdminController
{
    /**
     * Action used to sync packages from remote servers ie. packagist.org
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function syncAction()
    {
        /**
         * @var $manager \WellCommerce\Bundle\SmugglerBundle\Manager\Admin\PackageManager
         */
        $manager = $this->getManager();
        $manager->syncPackages(PackageManager::DEFAULT_PACKAGE_TYPE);
        $manager->getFlashHelper()->addSuccess('package.sync.success');

        return $manager->getRedirectHelper()->redirectToAction('index');
    }
}

