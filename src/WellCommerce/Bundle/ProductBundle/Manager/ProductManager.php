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

namespace WellCommerce\Bundle\ProductBundle\Manager;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Exception\ProductNotFoundException;

/**
 * Class ProductManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductManager extends AbstractManager
{
    /**
     * Updates the product data
     *
     * @param int   $id
     * @param array $data
     */
    public function quickUpdateProduct(int $id, array $data)
    {
        $product       = $this->findProduct($id);
        $entityManager = $this->getDoctrineHelper()->getEntityManager();

        $product->setSku($data['sku']);
        $product->setWeight($data['weight']);
        $product->setStock($data['stock']);
        $product->getSellPrice()->setGrossAmount($data['grossAmount']);

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
     * @return ProductInterface
     */
    protected function findProduct(int $id) : ProductInterface
    {
        $product = $this->repository->find($id);
        if (!$product instanceof ProductInterface) {
            throw new ProductNotFoundException($id);
        }

        return $product;
    }
}
