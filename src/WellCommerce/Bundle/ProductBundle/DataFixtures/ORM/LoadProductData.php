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
use WellCommerce\Bundle\AppBundle\Entity\Dimension;
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\AvailabilityBundle\DataFixtures\ORM\LoadAvailabilityData;
use WellCommerce\Bundle\CategoryBundle\DataFixtures\ORM\LoadCategoryData;
use WellCommerce\Bundle\CoreBundle\Helper\Sluggable;
use WellCommerce\Bundle\CurrencyBundle\DataFixtures\ORM\LoadCurrencyData;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\MediaBundle\DataFixtures\ORM\LoadMediaData;
use WellCommerce\Bundle\ProducerBundle\DataFixtures\ORM\LoadProducerData;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductPhoto;
use WellCommerce\Bundle\ProductStatusBundle\DataFixtures\ORM\LoadProductStatusData;
use WellCommerce\Bundle\TaxBundle\DataFixtures\ORM\LoadTaxData;
use WellCommerce\Bundle\UnitBundle\DataFixtures\ORM\LoadUnitData;

/**
 * Class LoadProductData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadProductData extends AbstractDataFixture
{
    public static $samples = [];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $limit = $this->container->getParameter('fixtures_product_limit');
        $faker = $this->getFakerGenerator();
        $names = [];

        for ($i = 0; $i < $limit; $i++) {
            $sentence     = $faker->unique()->sentence(3);
            $name         = substr($sentence, 0, strlen($sentence) - 1);
            $names[$name] = $name;
        }

        foreach ($names as $name) {
            $this->createRandomProduct($name, $manager);
        }

        $manager->flush();
    }

    protected function createRandomProduct(string $name, ObjectManager $manager)
    {
        $faker            = $this->getFakerGenerator();
        $shortDescription = $faker->text(100);
        $description      = $faker->text(1000);
        $sku              = $faker->creditCardNumber();
        $shop             = $this->getReference('shop');
        $currency         = $this->randomizeSamples('currency', LoadCurrencyData::$samples);
        $producer         = $this->randomizeSamples('producer', LoadProducerData::$samples);
        $availability     = $this->randomizeSamples('availability', LoadAvailabilityData::$samples);
        $categories       = $this->randomizeSamples('category', $s = LoadCategoryData::$samples, rand(2, 4));
        $statuses         = $this->randomizeSamples('product_status', LoadProductStatusData::$samples, rand(2, 3));
        $tax              = $this->randomizeSamples('tax', LoadTaxData::$samples);
        $unit             = $this->randomizeSamples('unit', LoadUnitData::$samples);

        $dimension = new Dimension();
        $dimension->setDepth(rand(10, 100));
        $dimension->setHeight(rand(10, 100));
        $dimension->setWidth(rand(10, 100));

        $buyPrice = new Price();
        $buyPrice->setGrossAmount(rand(50, 80));
        $buyPrice->setCurrency($currency->getCode());

        $sellPrice = new DiscountablePrice();
        $sellPrice->setGrossAmount($price = rand(100, 200));
        $sellPrice->setCurrency($currency->getCode());

        foreach ($statuses as $status) {
            if ($status->translate()->getName() === 'Promotions') {
                $sellPrice->setDiscountedGrossAmount($price * (rand(80, 95) / 100));
                $sellPrice->setValidFrom(new \DateTime());
                $sellPrice->setValidTo((new \DateTime())->modify('+30 days'));
            }
        }

        $product = new Product();
        $product->setSKU($sku);
        $product->setHierarchy(rand(0, 10));
        $product->setEnabled(true);
        $product->setAvailability($availability);
        $product->setBuyPrice($buyPrice);
        $product->setBuyPriceTax($tax);
        $product->setSellPrice($sellPrice);
        $product->setSellPriceTax($tax);
        $product->setCategories($categories);
        $product->addShop($shop);
        $product->setStatuses($statuses);

        $product->translate($this->getDefaultLocale())->setName($name);
        $product->translate($this->getDefaultLocale())->setSlug(Sluggable::makeSlug($name));
        $product->translate($this->getDefaultLocale())->setShortDescription($shortDescription);
        $product->translate($this->getDefaultLocale())->setDescription($description);
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
        $mediaFiles    = $this->randomizeSamples('photo', LoadMediaData::$samples, 3);
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
