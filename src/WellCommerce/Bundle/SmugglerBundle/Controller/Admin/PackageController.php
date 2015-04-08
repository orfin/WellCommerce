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

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;
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
        /**
         * @var $manager \WellCommerce\Bundle\SmugglerBundle\Manager\Admin\PackageManager
         */
        $manager = $this->getManager();
        $manager->syncPackages(PackageHelperInterface::DEFAULT_PACKAGE_PLUGIN_TYPE);
        $manager->syncPackages(PackageHelperInterface::DEFAULT_PACKAGE_THEME_TYPE);
        $manager->getFlashHelper()->addSuccess('package.flashes.sync_success');

        return $manager->getRedirectHelper()->redirectToAction('index');
    }

    public function installAction(Request $request)
    {
        $resource = $this->getManager()->findResource($request);
        if (null === $resource) {
            return $this->redirectToAction('index');
        }

        $form = $this->getManager()->getForm($resource);

        return [
            'form' => $form,
        ];

    }

    public function consoleAction(Request $request)
    {
        $helper    = $this->get('environment_helper');
        $arguments = $this->getConsoleCommandArguments($request);
        $command   = $helper->getConsoleCommand($arguments);
        $process   = new Process($command, $helper->getCwd());
        $process->setTimeout(720);
        $process->run();

        if($process->getExitCode() === 127){
            return $this->jsonResponse(['success' => true]);
        }
    }

    protected function getConsoleCommandArguments(Request $request)
    {
        $port      = (int)$request->attributes->get('port');
        $package   = $request->attributes->get('id');
        $operation = $request->attributes->get('operation');

        return [
            'app/console',
            'wellcommerce:package:' . $operation,
            '--port=' . $port,
            '--package=' . $package
        ];
    }
}
