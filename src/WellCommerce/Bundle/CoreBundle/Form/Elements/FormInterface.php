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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use WellCommerce\Bundle\CoreBundle\Form\Elements\Container\ContainerInterface;
use WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface;

/**
 * Interface FormInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormInterface
{
    /**
     * Adds container to form
     *
     * @param ContainerInterface $container
     *
     * @return ContainerInterface
     */
    public function addContainer(ContainerInterface $container);

    /**
     * Adds filter to all form containers
     *
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter);

//    public function setRenderer(FormRendererInterface $renderer);
//
//    public function setValidator(ValidatorInterface $validator);
//
//    public function setRequestHandler(RequestHandlerInterface $requestHandler);
//
//    public function setDataCollector(DataCollectorInterface $dataCollector);
//
//    public function addChild(ElementInterface $element);
}