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

namespace WellCommerce\Bundle\CoreBundle\Templating;

/**
 * Interface TemplateResolverInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TemplateResolverInterface
{
    /**
     * Resolves the controller's template name
     *
     * @param object $class
     * @param string $templateName
     *
     * @return string
     */
    public function resolveControllerTemplate($class, $templateName);
}
