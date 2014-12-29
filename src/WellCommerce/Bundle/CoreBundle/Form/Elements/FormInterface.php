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

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\DataCollector\DataCollectorInterface;
use WellCommerce\Bundle\CoreBundle\Form\Request\RequestHandlerInterface;
use WellCommerce\Bundle\CoreBundle\Form\Validator\ValidatorInterface;

/**
 * Interface FormInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FormInterface extends ElementInterface
{
    const TABS_VERTICAL   = 0;
    const TABS_HORIZONTAL = 1;
    const FORM_METHOD     = 'POST';

    /**
     * Sets form data collector
     *
     * @param DataCollectorInterface $dataCollector
     */
    public function setDataCollector(DataCollectorInterface $dataCollector);

    /**
     * Sets form validator
     *
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator);

    /**
     * Sets form request handler
     *
     * @param RequestHandlerInterface $requestHandler
     */
    public function setRequestHandler(RequestHandlerInterface $requestHandler);
}