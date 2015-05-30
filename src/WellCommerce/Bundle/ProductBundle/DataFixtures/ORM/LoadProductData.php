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

namespace WellCommerce\Bundle\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\AvailabilityBundle\DataFixtures\ORM\LoadAvailabilityData;
use WellCommerce\Bundle\CategoryBundle\DataFixtures\ORM\LoadCategoryData;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\CoreBundle\Entity\Dimension;
use WellCommerce\Bundle\CoreBundle\Entity\Price;
use WellCommerce\Bundle\IntlBundle\DataFixtures\ORM\LoadCurrencyData;
use WellCommerce\Bundle\MediaBundle\DataFixtures\ORM\LoadMediaData;
use WellCommerce\Bundle\ProducerBundle\DataFixtures\ORM\LoadProducerData;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductPhoto;
use WellCommerce\Bundle\RoutingBundle\Helper\Sluggable;
use WellCommerce\Bundle\TaxBundle\DataFixtures\ORM\LoadTaxData;
use WellCommerce\Bundle\UnitBundle\DataFixtures\ORM\LoadUnitData;

/**
 * Class LoadProductData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadProductData extends AbstractDataFixture
{
    const SAMPLES = [];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $this->createRandomProduct($manager);
        }

        $manager->flush();
    }

    protected function createRandomProduct(ObjectManager $manager)
    {
        $faker            = $this->getFakerGenerator();
        $sentence         = $faker->unique()->sentence(3);
        $name             = substr($sentence, 0, strlen($sentence) - 1);
        $shortDescription = $faker->text(100);
        $description      = $faker->text(1000);
        $sku              = $this->getFakerGenerator()->creditCardNumber();
        $shop             = $this->getReference('shop');
        $currency         = $this->randomizeSamples('currency', LoadCurrencyData::SAMPLES);
        $producer         = $this->randomizeSamples('producer', LoadProducerData::SAMPLES);
        $availability     = $this->randomizeSamples('availability', LoadAvailabilityData::SAMPLES);
        $categories       = $this->randomizeSamples('category', $s = LoadCategoryData::SAMPLES, rand(2, 4));
        $statuses         = $this->randomizeSamples('product_status', LoadProductStatusData::SAMPLES, rand(2, 3));
        $tax              = $this->randomizeSamples('tax', LoadTaxData::SAMPLES);
        $unit             = $this->randomizeSamples('unit', LoadUnitData::SAMPLES);

        $dimension = new Dimension();
        $dimension->setDepth(rand(10, 100));
        $dimension->setHeight(rand(10, 100));
        $dimension->setWidth(rand(10, 100));

        $buyPrice = new Price();
        $buyPrice->setAmount(rand(1, 100));
        $buyPrice->setCurrency($currency->getCode());
        $buyPrice->setTax($tax->getId());

        $sellPrice = new Price();
        $sellPrice->setAmount(rand(100, 200));
        $sellPrice->setCurrency($currency->getCode());
        $sellPrice->setTax($tax->getId());

        $product = new Product();
        $product->setSKU($sku);
        $product->setHierarchy(rand(0, 10));
        $product->setEnabled(true);
        $product->setAvailability($availability);
        $product->setBuyPrice($buyPrice);
        $product->setSellPrice($sellPrice);
        $product->setCategories($categories);
        $product->addShop($shop);
        $product->setStatuses($statuses);

        $product->translate('en')->setName($name);
        $product->translate('en')->setSlug(Sluggable::makeSlug($name));
        $product->translate('en')->setShortDescription($shortDescription);
        $product->translate('en')->setDescription($description);
        $product->mergeNewTranslations();

        $product->setProductPhotos($this->getPhotos($product, $manager));
        $product->setProducer($producer);
        $product->setStock(rand(0, 1000));
        $product->setUnit($unit);
        $product->setDimension($dimension);
        $product->setTrackStock(true);
        $product->setPackageSize(1);
        $product->setWeight(rand(0, 5));

        $manager->persist($product);
    }

    protected function getPhotos(Product $product, ObjectManager $manager)
    {
        $productPhotos = new ArrayCollection();
        $mediaFiles    = $this->randomizeSamples('photo', LoadMediaData::SAMPLES, 3);
        $isMainPhoto   = true;

        foreach ($mediaFiles as $media) {
            $productPhoto = new ProductPhoto();
            $productPhoto->setHierarchy(0);
            $productPhoto->setMainPhoto($isMainPhoto);
            $productPhoto->setPhoto($media);
            $productPhoto->setProduct($product);
            $manager->persist($productPhoto);

            if ($isMainPhoto) {
                $product->setPhoto($media);
                $isMainPhoto = false;
            }

            $productPhotos->add($productPhoto);
        }

        return $productPhotos;
    }
}
