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

namespace WellCommerce\Bundle\CoreBundle\DataFixtures;

use Faker\Factory as FakerFactory;
use Faker\Generator;

/**
 * Class AbstractDataFixture
 *
 * @package WellCommerce\Bundle\CoreBundle\DataFixtures
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataFixture
{
    /**
     * @var \Faker\Generator
     */
    protected $fakerGenerator;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fakerGenerator = FakerFactory::create();
    }
} 