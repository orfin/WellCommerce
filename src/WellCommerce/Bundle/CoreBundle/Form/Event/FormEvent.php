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
namespace WellCommerce\Bundle\CoreBundle\Form\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;

/**
 * Class FormEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FormEvent extends Event
{
    /**
     * Form builder instance
     *
     * @var FormBuilderInterface
     */
    protected $formBuilder;

    /**
     * Constructor
     *
     * @param FormBuilderInterface $formBuilder
     */
    public function __construct(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * Returns form builder instance
     *
     * @return FormBuilderInterface
     */
    public function getFormBuilder()
    {
        return $this->formBuilder;
    }
}
