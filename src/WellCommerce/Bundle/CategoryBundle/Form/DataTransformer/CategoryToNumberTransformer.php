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

namespace WellCommerce\Bundle\CategoryBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformerInterface;

/**
 * Class CategoryToNumberTransformer
 *
 * @package WellCommerce\Bundle\CategoryBundle\Form\DataTransformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryToNumberTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($company)
    {
        if (null === $company) {
            return 0;
        }

        return $company->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $company = $this->manager->getRepository('WellCommerceCategoryBundle:Category')->find($id);

        return $company;
    }
} 