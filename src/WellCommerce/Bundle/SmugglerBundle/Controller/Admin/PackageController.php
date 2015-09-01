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

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\AdminBundle\Controller\AbstractAdminController;
use WellCommerce\Bundle\SmugglerBundle\Helper\PackageHelperInterface;

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
        $manager = $this->getManager();
        $manager->syncPackages(PackageHelperInterface::DEFAULT_PACKAGE_PLUGIN_TYPE);
        $manager->syncPackages(PackageHelperInterface::DEFAULT_PACKAGE_THEME_TYPE);
        $manager->getFlashHelper()->addSuccess('package.flashes.sync_success');

        return $manager->getRedirectHelper()->redirectToAction('index');
    }

    /**
     * @return \WellCommerce\Bundle\SmugglerBundle\Manager\Admin\PackageManager
     */
    protected function getManager()
    {
        return parent::getManager();
    }

    public function packageAction(Request $request, $operation)
    {
        $resource = $this->getManager()->findResource($request);
        if (null === $resource) {
            return $this->redirectToAction('index');
        }

        $form = $this->getManager()->getForm($resource);

        return [
            'operation'   => $operation,
            'packageName' => $resource->getFullName(),
            'form'        => $form,
        ];
    }

    public function consoleAction(Request $request)
    {
        $helper    = $this->get('environment_helper');
        $arguments = $this->getManager()->getConsoleCommandArguments($request);
        $process   = $helper->getProcess($arguments, 720);
        $process->run();

        if ($process->getExitCode() !== null) {
            if (0 === (int)$process->getExitCode()) {
                $this->getManager()->changePackageStatus($request);
            }

            return $this->jsonResponse(['code' => $process->getExitCode()]);
        }
    }
}
