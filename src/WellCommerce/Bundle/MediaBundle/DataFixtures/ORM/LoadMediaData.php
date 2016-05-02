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

namespace WellCommerce\Bundle\MediaBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\MediaBundle\Entity\Media;

/**
 * Class LoadMediaData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadMediaData extends AbstractDataFixture
{
    public static $samples
        = [
            'prod1.jpg',
            'prod2.jpg',
            'prod3.jpg',
            'prod4.jpg',
            'prod5.jpg',
            'prod6.jpg',
            'prod7.jpg',
            'prod8.jpg',
            'prod9.jpg',
            'prod10.jpg',
            'prod11.jpg',
            'prod12.jpg',
            'prod13.jpg',
            'prod14.jpg',
            'prod15.jpg',
            'prod16.jpg'
        ];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $rootPath   = $this->container->get('kernel')->getRootDir() . '/../web/themes/wellcommerce-default-theme/assets/prod/';
        $uploader   = $this->container->get('media.uploader');
        $uploadPath = $uploader->getUploadDir('images');
        $filesystem = $this->container->get('filesystem');

        foreach (self::$samples as $photo) {
            $image = new UploadedFile(
                $rootPath . $photo,
                $photo,
                'image/jpeg',
                filesize($rootPath . $photo)
            );

            $media = new Media();
            $media->setName($image->getClientOriginalName());
            $media->setExtension($image->guessClientExtension());
            $media->setMime($image->getClientMimeType());
            $media->setSize($image->getClientSize());
            $manager->persist($media);
            $filesystem->copy($rootPath . $photo, $uploadPath . '/' . $media->getPath());
            $this->setReference('photo_' . $photo, $media);
        }

        $manager->flush();
    }
}
