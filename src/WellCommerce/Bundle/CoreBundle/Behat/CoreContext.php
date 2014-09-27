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

namespace WellCommerce\Bundle\CoreBundle\Behat;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Class CoreContext
 *
 * @package WellCommerce\Bundle\CoreBundle\Behat
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CoreContext extends RawMinkContext implements SnippetAcceptingContext, KernelAwareContext
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * Sets application kernel
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Returns Symfony container
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * Returns a service by its id
     *
     * @param $id
     *
     * @return object
     */
    protected function getService($id)
    {
        return $this->getContainer()->get($id);
    }

    /**
     * Generates an url
     *
     * @param       $url
     * @param array $parameters
     *
     * @return string
     */
    protected function generateUrl($url, array $parameters = [])
    {
        $route = $this->getContainer()->get('router')->generate($url, $parameters);

        return $this->locatePath($route);
    }

    /**
     * @Given I am logged as an admin user
     */
    public function iAmLoggedAsAnAdminUser()
    {
        $username = 'admin';
        $password = 'admin';

        $this->getSession()->visit($this->generateUrl('admin.user.login'));

        $this->fillFormField('_username', $username);
        $this->fillFormField('_password', $password);
        $this->clickButton('log_in');
    }

    /**
     * Fills form field
     *
     * @param $fieldName
     * @param $fieldValue
     */
    protected function fillFormField($fieldName, $fieldValue)
    {
        $this->getSession()->getPage()->fillField($fieldName, $fieldValue);
    }

    /**
     * Clicks a button on page
     *
     * @param $button
     */
    protected function clickButton($button)
    {
        $this->getSession()->getPage()->pressButton($button);
    }
}