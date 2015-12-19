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

namespace WellCommerce\Bundle\CoreBundle\Helper\Templating;

use WellCommerce\Bundle\CoreBundle\Controller\ControllerInterface;

/**
 * Interface TemplatingHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TemplatingHelperInterface
{
    /**
     * Returns the template with given parameters
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return string
     */
    public function render($name, array $parameters = []);

    /**
     * Resolves the controller's template name
     *
     * @param ControllerInterface $class
     * @param string              $templateName
     *
     * @return string
     */
    public function resolveControllerTemplate(ControllerInterface $class, $templateName);

    /**
     * Renders the controller's response
     *
     * @param ControllerInterface $controller
     * @param string              $templateName
     * @param array               $parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderControllerResponse(ControllerInterface $controller, $templateName, array $parameters = []);
}
