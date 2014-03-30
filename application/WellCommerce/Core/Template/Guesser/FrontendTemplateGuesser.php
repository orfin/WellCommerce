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
namespace WellCommerce\Core\Template\Guesser;

use Symfony\Component\HttpKernel\HttpKernelInterface;

class FrontendTemplateGuesser implements TemplateGuesserInterface
{

    const TEMPLATING_SERVICE_NAME = 'template.front';

    /**
     * {@inheritdoc}
     */
    public function guess($controller, $action, $requestType = HttpKernelInterface::MASTER_REQUEST)
    {
        $controller = $this->check($controller, $requestType);
        $extension  = TemplateGuesserInterface::TEMPLATING_ENGINE;

        switch ($requestType) {
            case HttpKernelInterface::SUB_REQUEST:
                return sprintf('%s\box\%s.%s', $controller, $action, $extension);
                break;
            case HttpKernelInterface::MASTER_REQUEST:
                return sprintf('%s\%s.%s', $controller, $action, $extension);
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function check($controller, $requestType)
    {
        // if request is forwarded we assume its LayoutBox
        if (HttpKernelInterface::SUB_REQUEST == $requestType) {
            if (!preg_match('/Controller\\\Frontend\\\(.+)BoxController$/', $controller, $matches)) {
                throw new \InvalidArgumentException(sprintf('The "%s" class does not look like an box controller class', $controller));
            }

            return strtolower($matches[1]);
        }

        if (HttpKernelInterface::MASTER_REQUEST == $requestType) {
            if (!preg_match('/Controller\\\Frontend\\\(.+)Controller$/', $controller, $matches)) {
                throw new \InvalidArgumentException(sprintf('The "%s" class does not look like an frontend controller class', $controller));
            }

            return strtolower($matches[1]);
        }
    }
}