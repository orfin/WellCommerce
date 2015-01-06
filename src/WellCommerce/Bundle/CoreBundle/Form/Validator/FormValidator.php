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

    protected $validator;

    public function isValid(FormInterface $form)
    {
        return false;
    }
//    /**
//     * Constructor
//     *
//     * @param DoctrineHelperInterface $doctrineHelper
//     * @param ValidatorInterface      $validator
//     */
//    public function __construct(DoctrineHelperInterface $doctrineHelper)
//    {
//        $this->doctrineHelper = $doctrineHelper;
//    }

    public function getClass($data)
    {
        return ClassUtils::getClass($data);
    }

    public function getValidationMetadata($data)
    {
        $className = $this->getClass($data);

//        if ($this->getMetadataFactory()->hasMetadataFor($className)) {
//            $metadata        = $this->getClassMetadata($className);
//            $metadataFactory = $this->getValidator()->getMetadataFactory();
//
//            foreach ($metadata->getAssociationMappings() as $association) {
//                $targetEntity = $association['targetEntity'];
//                if ($metadataFactory->hasMetadataFor($targetEntity)) {
//                    $targetEntityMetadata = $metadataFactory->getMetadataFor($targetEntity);
//                    if (!empty($targetEntityMetadata->members)) {
//                        $constraints[$association['fieldName']] = $targetEntityMetadata;
//                    }
//                }
//            }
//        }
//
//        return $constraints;
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