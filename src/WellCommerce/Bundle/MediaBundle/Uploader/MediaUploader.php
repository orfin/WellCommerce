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

namespace WellCommerce\Bundle\MediaBundle\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\MediaBundle\Repository\MediaRepositoryInterface;

/**
 * Class MediaUploader
 *
 * @package WellCommerce\Bundle\MediaBundle\Uploader
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaUploader implements UploaderInterface
{
    private $repository;

    public function __construct(MediaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function uploadFile(UploadedFile $file)
    {
        print_r($file);
        die();
    }

    /**
     * {@inheritdoc}
     */
    public function check(Request $request)
    {
    }

    public function process(Request $request)
    {
    }

    public function supports()
    {
        return [
            'jpg',
            'gif',
            'png',
            'jpeg'
        ];
    }

    public function upload(UploadedFile $file, $name)
    {
        $file->move($this->originalPath, $name);
    }

} 