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
namespace WellCommerce\Plugin\Contact\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Plugin\Contact\Model\Contact;
use WellCommerce\Plugin\Contact\Model\ContactTranslation;

/**
 * Class ContactAbstractRepository
 *
 * @package WellCommerce\Plugin\Contact\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactRepository extends AbstractRepository implements ContactRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Contact::with('translation')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Contact::with('translation')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $contact = $this->find($id);
        $contact->delete();
        $this->dispatchEvent(ContactRepositoryInterface::POST_DELETE_EVENT, $contact);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            $contact = Contact::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(ContactRepositoryInterface::PRE_SAVE_EVENT, $contact, $data);

            $contact->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = ContactTranslation::firstOrCreate([
                    'contact_id'  => $contact->id,
                    'language_id' => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $this->dispatchEvent(ContactRepositoryInterface::POST_SAVE_EVENT, $contact, $data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getAllContactToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }
}