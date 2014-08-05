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
namespace WellCommerce\Bundle\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Form;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilder;

/**
 * Class FormEvent
 *
 * @package WellCommerce\Bundle\CoreBundle\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FormEvent extends Event
{
    /**
     * Form builder instance
     *
     * @var \WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilder
     */
    protected $formBuilder;

    /**
     * Constructor
     *
     * @param Form $form
     */
    public function __construct(FormBuilder $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * Returns form instance
     *
     * @return FormInterface|Form
     */
    public function getFormBuilder()
    {
        return $this->formBuilder;
    }
}