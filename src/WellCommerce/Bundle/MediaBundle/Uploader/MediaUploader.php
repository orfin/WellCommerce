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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use WellCommerce\Bundle\MediaBundle\Entity\Media;
use WellCommerce\Bundle\MediaBundle\Repository\MediaRepositoryInterface;

/**
 * Class FileUploader
 *
 * @package WellCommerce\Bundle\CoreBundle\Uploader
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaUploader implements MediaUploaderInterface
{
    const PRE_UPLOAD_EVENT  = 'media.pre_upload';
    const POST_UPLOAD_EVENT = 'media.post_upload';
    const PRE_DELETE_EVENT  = 'media.pre_delete';
    const POST_DELETE_EVENT = 'media.post_delete';

    /**
     * @var string
     */
    protected $kernelDir;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var MediaRepositoryInterface
     */
    protected $repository;

    protected $uploadPath;

    /**
     * Constructor
     *
     * @param Filesystem               $filesystem
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        $kernelDir,
        Filesystem $filesystem,
        EventDispatcherInterface $eventDispatcher,
        MediaRepositoryInterface $repository
    ) {
        $this->kernelDir       = $kernelDir;
        $this->filesystem      = $filesystem;
        $this->eventDispatcher = $eventDispatcher;
        $this->repository      = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function upload(UploadedFile $file, $dir)
    {
        $this->dispatchEvent(self::PRE_UPLOAD_EVENT, $file);

        if (!$file->isValid()) {
            throw new \Exception('Passed file object is not valid');
        }

        $media      = $this->repository->save($file, $dir);
        $uploadPath = $this->getUploadRootDir($dir);
        $file->move(
            $uploadPath,
            $media->getPath()
        );

        $this->dispatchEvent(self::POST_UPLOAD_EVENT, $file);

        return $media;
    }

    /**
     * Dispatches file event
     *
     * @param      $name
     * @param File $file
     */
    private function dispatchEvent($name, File $file)
    {
        $event = new GenericEvent($file);
        $this->eventDispatcher->dispatch($name, $event);
    }

    private function getUploadRootDir($dir)
    {
        $dir = rtrim($dir, '/\\');

        return sprintf('%s/../web/media/%s', $this->kernelDir, $dir);
    }

    /**
     * Returns relative path to file
     *
     * @param Media $media
     *
     * @return string
     */
    public function getRelativePath(Media $media)
    {
        return sprintf('%s/%s.%s',
            $media->getPath(),
            $media->getId(),
            $media->getExtension()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function delete(File $file)
    {
        $this->dispatchEvent(self::PRE_DELETE_EVENT, $file);

        $this->dispatchEvent(self::POST_DELETE_EVENT, $file);
    }
}
