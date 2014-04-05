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

use Symfony\Component\HttpFoundation\Request;

/**
 * Class TemplateGuesser
 *
 * @package WellCommerce\Core\Template
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TemplateGuesser
{
    const LOADER_ADMIN = 'twig.loader.admin';
    const LOADER_FRONT = 'twig.loader.front';

    /**
     * Guesses and returns the template name
     *
     * @param         $controller
     * @param Request $request
     * @param string  $engine
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function guess($controller, Request $request, $engine = 'twig')
    {
        $r = new \ReflectionClass($controller[0]);

        // check if admin controller
        if ($r->implementsInterface('WellCommerce\\Core\\Component\\Controller\\AdminControllerInterface')) {
            if (!preg_match('/Controller\\\Admin\\\(.+)Controller$/', $r->getName(), $matches)) {
                throw new \InvalidArgumentException(sprintf('The "%s" class does not look like an admin controller class', $controller));
            }

            return [
                sprintf('%s/%s.%s.%s', strtolower($matches[1]), $controller[1], $request->getRequestFormat(), $engine),
                self::LOADER_ADMIN
            ];
        }
    }
}
