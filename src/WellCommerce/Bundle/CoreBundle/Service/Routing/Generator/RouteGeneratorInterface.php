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

namespace WellCommerce\Bundle\CoreBundle\Service\Routing\Generator;

use WellCommerce\Bundle\AppBundle\Entity\RoutableSubjectInterface;
use WellCommerce\Bundle\AppBundle\Entity\RouteInterface;

/**
 * Interface RouteGeneratorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RouteGeneratorInterface
{
    const PATH_PARAMS_SEPARATOR = ',';

    /**
     * Checks whether generator can handle such a type of generation strategy
     *
     * @param $strategy
     *
     * @return mixed
     */
    public function supports($strategy);

    /**
     * Generates real Symfony route using passed entity
     *
     * @param RoutableSubjectInterface $entity
     *
     * @return \Symfony\Component\Routing\Route
     */
    public function generate(RouteInterface $entity);
}
