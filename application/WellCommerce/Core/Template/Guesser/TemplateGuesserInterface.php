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
 * Interface TemplateGuesserInterface
 *
 * @package WellCommerce\Core\Template\Guesser
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TemplateGuesserInterface
{

    /**
     * Application uses Twig Engine
     * 
     * @var string
     */
    const TEMPLATING_ENGINE = 'twig';

    /**
     * Guesses template name for action in controller
     * 
     * @param string $controller
     * @param string $action
     * 
     * @return string Template name
     */
    public function guess ($controller, $action);

    /**
     * Checks controller type 
     * 
     * @param string $controller
     * 
     * @throws \InvalidArgumentException if controller doesn't match pattern
     * 
     * @return array Controller name parts
     */
    public function check ($controller);
}