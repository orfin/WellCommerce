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
namespace WellCommerce\Plugin\File\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use WellCommerce\Plugin\File\Model\File;

/**
 * Class FileAbstractRepository
 *
 * @package WellCommerce\Plugin\File\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FileRepository extends AbstractRepository implements FileRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return File::all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return File::findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $this->dispatchEvent(FileRepositoryInterface::PRE_DELETE_EVENT, [], $id);

        $this->transaction(function () use ($id) {
            return File::destroy($id);
        });

        $this->dispatchEvent(FileRepositoryInterface::POST_DELETE_EVENT, [], $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(UploadedFile $uploadedFile)
    {
        $id = null;

        $data = [
            'name'      => $uploadedFile->getClientOriginalName(),
            'size'      => $uploadedFile->getClientSize(),
            'extension' => $uploadedFile->getClientOriginalExtension(),
            'type'      => $uploadedFile->getClientMimeType(),
        ];


        $file = $this->transaction(function () use ($data, $id) {

            $file = File::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(FileRepositoryInterface::PRE_SAVE_EVENT, $file, $data);
            $file->update($data);
            $this->dispatchEvent(FileRepositoryInterface::POST_SAVE_EVENT, $file, $data);

            return $file;
        });

        return $file;
    }
}