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

namespace WellCommerce\Bundle\CoreBundle\Form\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;

/**
 * Class FormValidator
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormValidator implements FormValidatorInterface
{
    /**
     * @var object
     */
    protected $data;

    /**
     * @var DoctrineHelperInterface
     */
    protected $doctrineHelper;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * Constructor
     *
     * @param DoctrineHelperInterface $doctrineHelper
     */
    public function __construct(DoctrineHelperInterface $doctrineHelper, ValidatorInterface $validator)
    {
        $this->doctrineHelper = $doctrineHelper;
        $this->validator      = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(FormInterface $form)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormConstraintsFromModelData(FormInterface $form, $modelData)
    {
        $entityMetadata = $this->validator->getMetadataFor($modelData);
        print_r($entityMetadata->getPropertyMetadata('enabled'));
        foreach ($entityMetadata->findConstraints('Default') as $constraint) {
            print_r($constraint);
        }
        print_r($entityMetadata);

        echo get_class($modelData);
        die();
    }
}
