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
namespace WellCommerce\Core\Translation;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Translation
 *
 * @package WellCommerce\Core
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Translation extends Translator
{

    /**
     * @var null
     */
    protected $locale;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     * @param null               $locale
     */
    public function __construct(ContainerInterface $container, $locale)
    {
        $this->container = $container;
        $this->locale    = $locale;

        parent::__construct($this->locale);

        $this->addLoader('array', new ArrayLoader());

        $this->addResource('array', $this->getResource(), $this->locale);
    }

    /**
     * @return array
     */
    protected function getResource()
    {
        $Data = Array();

        return $Data;
    }
}