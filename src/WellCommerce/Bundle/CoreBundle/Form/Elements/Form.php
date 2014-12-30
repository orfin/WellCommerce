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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\DataCollector\DataCollectorInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataMapper\DataMapperInterface;
use WellCommerce\Bundle\CoreBundle\Form\Filters\FilterInterface;
use WellCommerce\Bundle\CoreBundle\Form\Renderer\FormRendererInterface;
use WellCommerce\Bundle\CoreBundle\Form\Request\RequestHandlerInterface;
use WellCommerce\Bundle\CoreBundle\Form\Validator\ValidatorInterface;

/**
 * Class Form
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class Form extends AbstractContainer implements FormInterface
{
    /**
     * @var FormRendererInterface
     */
    protected $dataCollector;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var RequestHandlerInterface
     */
    protected $requestHandler;

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined([
            'action',
            'method',
            'tabs',
        ]);

        $resolver->setDefaults([
            'label'  => '',
            'action' => '',
            'method' => FormInterface::FORM_METHOD,
            'tabs'   => FormInterface::TABS_VERTICAL,
        ]);

        $resolver->setAllowedTypes([
            'action' => 'string',
            'method' => 'string',
            'tabs'   => 'integer'
        ]);
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

    /**
     * {@inheritdoc}
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->children->forAll(function (ElementInterface $element) use ($filter) {
            $element->addFilter($filter);
        });
    }

    public function handleRequest()
    {
        return $this->requestHandler->handleRequest($this);
    }

    public function isValid()
    {
        return false;

        return $this->validator->isValid($this);
    }

    public function prepareAttributes()
    {
        return [
            'sFormName' => $this->getName(),
            'sAction'   => $this->options['action'],
        ];
    }


}