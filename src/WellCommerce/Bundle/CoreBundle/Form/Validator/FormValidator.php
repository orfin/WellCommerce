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

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Util\ClassUtils;
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

    public function isValid(FormInterface $form)
    {
        return false;
    }


    public function getClass($data)
    {
        return ClassUtils::getClass($data);
    }

    public function resolveConstraints($modelData, FormInterface $form)
    {
        $this->getValidationMetadata($modelData);
    }

    public function getValidationMetadata($data)
    {
        $className = $this->getClass($data);
        if ($this->getMetadataFactory()->hasMetadataFor($className)) {
            $metadata = $this->getClassMetadata($className);

            foreach ($metadata->getAssociationNames() as $association) {
                $associationTargetClass = $metadata->getAssociationTargetClass($association);
                $associationMetadata    = $this->getEntityMetadata($associationTargetClass);
                if (!empty($targetEntityMetadata->members)) {
                    $constraints[$association['fieldName']] = $targetEntityMetadata;
                }
            }
        }
//
//        return $constraints;
    }

    /**
     * @param $targetEntity
     *
     * @return \Symfony\Component\Validator\Mapping\ClassMetadata
     */
    private function getEntityMetadata($targetEntity)
    {
        return $this->validator->getMetadataFor($targetEntity);
    }

    /**
     * Returns metadata factory
     *
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadataFactory
     */
    protected function getMetadataFactory()
    {
        return $this->doctrineHelper->getEntityManager()->getMetadataFactory();
    }

    /**
     * Returns entity mapping
     *
     * @param $className
     *
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    protected function getClassMetadata($className)
    {
        return $this->doctrineHelper->getEntityManager()->getClassMetadata($className);
    }
} 