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

/**
 * Class AdminTemplateGuesser
 *
 * @package WellCommerce\Core\Template\Guesser
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminTemplateGuesser implements TemplateGuesserInterface
{

    const TEMPLATING_SERVICE_NAME = 'template.admin';

    /**
     * {@inheritdoc}
     */
    public function guess ($controller, $action)
    {
        return sprintf('%s\%s.%s', $this->check($controller), $action, TemplateGuesserInterface::TEMPLATING_ENGINE);
    }

    /**
     * {@inheritdoc}
     */
    public function check ($controller)
    {
        if (! preg_match('/Controller\\\Admin\\\(.+)Controller$/', $controller, $matches)){
            throw new \InvalidArgumentException(sprintf('The "%s" class does not look like an admin controller class', $controller));
        }
        return strtolower($matches[1]);
    }
}