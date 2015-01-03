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
namespace WellCommerce\Bundle\CoreBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\CoreBundle\Form\DataCollector\DataCollectorInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataMapper\DataMapperInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Container\ContainerInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface;
use WellCommerce\Bundle\CoreBundle\Form\Formatter\FormatterInterface;
use WellCommerce\Bundle\CoreBundle\Form\Handler\FormHandlerInterface;
use WellCommerce\Bundle\CoreBundle\Form\Request\RequestHandlerInterface;
use WellCommerce\Bundle\CoreBundle\Form\Validator\ValidatorInterface;

/**
 * Class AbstractForm
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractForm extends AbstractContainer
{
    public function getContainers(){

    }

    public function addFilter(FilterInterface $filter)
    {

    }

    public function configureOptions(OptionsResolver $resolver){

    }

    public function getName(){

    }

    public function addChild(ElementInterface $element){

    }

    public function getChildren(){

    }

    public function prepareAttributes(){

    }

    /**
     * {@inheritdoc}
     */
    public function setDataMapper(DataMapperInterface $dataCollector)
    {
        $this->dataCollector = $dataCollector;
    }

    /**
     * {@inheritdoc}
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function setRequestHandler(RequestHandlerInterface $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    public function hasOption($option)
    {
        return isset($this->options[$option]);
    }

    public function getOption($option)
    {
        if (!$this->hasOption($option)) {
        }

        return $this->options[$option];
    }

    public function getPropertyPath()
    {
        return $this->getOption('property_path');
    }

    public function setFormHandler(FormHandlerInterface $formHandler)
    {
        $this->formHandler = $formHandler;
    }
}