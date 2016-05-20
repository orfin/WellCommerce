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

namespace WellCommerce\Bundle\RoutingBundle\Generator;

/**
 * Interface SlugGeneratorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SlugGeneratorInterface
{
    /**
     * Generates and validates uniqueness of slug
     *
     * @param string   $name   Passed value to generate slug
     * @param int|null $id     Entity id
     * @param string   $locale Field locale
     * @param array    $values Other sluggable field values
     * @param int      $iteration
     *
     * @return string
     */
    public function generate(string $name, $id, string $locale, $values, int $iteration = 0) : string;
}
