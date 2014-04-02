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
namespace WellCommerce\Core\Template;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TemplateGuesser
 *
 * @package WellCommerce\Core\Template
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TemplateGuesser
{
    /**
     * Guesses and returns the template name to render based on the controller
     * and action names.
     *
     * @param  array   $controller An array storing the controller object and action method
     * @param  Request $request    A Request instance
     * @param  string  $engine
     *
     * @return TemplateReference         template reference
     * @throws \InvalidArgumentException
     */
    public function guessTemplateName($controller, Request $request, $engine = 'twig')
    {
        print_r($controller[1]);die();

        $r = new \ReflectionClass($controller[0]);
        if($r->implementsInterface('WellCommerce\\Core\\Component\\Controller\\AdminControllerInterface')){
            echo $r->getNamespaceName();
        }



        return new TemplateReference($bundleName, $matchController[1], $matchAction[1], $request->getRequestFormat(), $engine);
    }
}
