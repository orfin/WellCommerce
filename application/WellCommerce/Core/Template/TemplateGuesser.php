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
    // loader modes
    const LOADER_ADMIN = 'twig.loader.admin';
    const LOADER_FRONT = 'twig.loader.front';

    // controller modes
    const CONTROLLER_MODE_ADMIN = 1;
    const CONTROLLER_MODE_FRONT = 2;
    const CONTROLLER_MODE_BOX   = 3;

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
        if ($r->implementsInterface('WellCommerce\\Core\\Component\\Controller\\Admin\\AdminControllerInterface')) {
            if (!preg_match('/Controller\\\Admin\\\(.+)Controller$/', $r->getName(), $matches)) {
                throw new \InvalidArgumentException(sprintf('The "%s" class does not look like an admin controller class', $controller));
            }

            return [
                sprintf('%s/%s.%s.%s', strtolower($matches[1]), $controller[1], $request->getRequestFormat(), $engine),
                self::LOADER_ADMIN,
                self::CONTROLLER_MODE_ADMIN
            ];
        }

        // check if front controller
        if ($r->implementsInterface('WellCommerce\\Core\\Component\\Controller\\Front\FrontControllerInterface')) {
            if (!preg_match('/Controller\\\Front\\\(.+)Controller$/', $r->getName(), $matches)) {
                throw new \InvalidArgumentException(sprintf('The "%s" class does not look like an front controller class', $controller));
            }

            return [
                sprintf('%s/%s.%s.%s', strtolower($matches[1]), $controller[1], $request->getRequestFormat(), $engine),
                self::LOADER_FRONT,
                self::CONTROLLER_MODE_FRONT
            ];
        }

        if ($r->implementsInterface('WellCommerce\\Core\\Component\\Controller\\Box\BoxControllerInterface')) {
            if (!preg_match('/Controller\\\Box\\\(.+)BoxController$/', $r->getName(), $matches)) {
                throw new \InvalidArgumentException(sprintf('The "%s" class does not look like an box controller class', $controller));
            }

            return [
                sprintf('%s/box/%s.%s.%s', strtolower($matches[1]), $controller[1], $request->getRequestFormat(), $engine),
                self::LOADER_FRONT,
                self::CONTROLLER_MODE_BOX
            ];
        }

    }
}
