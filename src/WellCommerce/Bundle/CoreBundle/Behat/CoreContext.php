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
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class CoreContext
 *
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
     * @Given I am logged as an administrator
     */
    public function iAmLoggedAsAnAdministrator()
    {
        $username = 'admin';
        $password = 'admin';

        $this->getSession()->visit($this->generateUrl('admin.user.login'));

        $this->fillFormField('_username', $username);
        $this->fillFormField('_password', $password);
        $this->clickButton('log_in');
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

    /**
     * @When /^I click "([^"]*)" near "([^"]*)"$/
     */
    public function iClickNear($button, $value)
    {
        $tr      = $this->assertSession()->elementExists('css', sprintf('table tbody tr:contains("%s")', $value));
        $locator = sprintf('a:contains("%s")', $button);
        if ($tr->has('css', $locator)) {
            $tr->find('css', $locator)->press();
        } else {
            $tr->clickLink($button);
        }
    }

    /**
     * @When /^I click "([^"]*)" in message bar$/
     */
    public function iClickButtonInMessageBar($button)
    {
        $messageBar = $this->assertSession()->elementExists('css', '.GMessageBar .options');
        $locator    = sprintf('a:contains("%s")', $button);
        if ($messageBar->has('css', $locator)) {
            $messageBar->find('css', $locator)->press();
        }
    }

    /**
     * @Then /^I wait for the message bar to appear$/
     */
    public function iWaitForTheMessageBarToAppear()
    {
        $this->getSession()->wait(5000);
    }

    /**
     * @Then /^I wait for the datagrid to finish loading$/
     */
    public function iWaitForTheDataGridToFinishLoading()
    {
        $this->getSession()->wait(5000, "$('.GF_Datagrid_Col__options').children().length > 0");
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
     * Returns Symfony container
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private function getContainer()
    {
        return $this->kernel->getContainer();
    }
}
