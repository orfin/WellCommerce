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

namespace WellCommerce\AppBundle\Manager\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\AppBundle\Exception\ProductNotFoundException;
use WellCommerce\CoreBundle\Manager\Admin\AbstractAdminManager;

/**
 * Class ProductManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductManager extends AbstractAdminManager
{
    /**
     * Updates the product data
     *
     * @param int   $id
     * @param array $data
     */
    public function quickUpdateProduct($id, array $data)
    {
        $product       = $this->findProduct($id);
        $entityManager = $this->getDoctrineHelper()->getEntityManager();

        $product->setSku($data['sku']);
        $product->setWeight($data['weight']);
        $product->setStock($data['stock']);
        $product->getSellPrice()->setAmount($data['sellPrice']);

        $errors = $this->getValidatorHelper()->validate($product);
        if ($errors->count()) {
            throw new ValidatorException('Product data is not valid: ' . (string)$errors);
        }

        $entityManager->flush();
    }

    /**
     * Returns the product entity by its identifier
     *
     * @param int $id
     *
     * @return \WellCommerce\AppBundle\Entity\Product
     */
    protected function findProduct($id)
    {
        $product = $this->getRepository()->find($id);
        if (null === $product) {
            throw new ProductNotFoundException($id);
        }

        return $product;
    }
}
