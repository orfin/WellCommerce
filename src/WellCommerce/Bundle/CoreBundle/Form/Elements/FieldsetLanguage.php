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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyPath;
use WellCommerce\Bundle\IntlBundle\Repository\LocaleRepositoryInterface;

/**
 * Class FieldsetLanguage
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FieldsetLanguage extends Fieldset implements ElementInterface
{
    /**
     * @var LocaleRepositoryInterface
     */
    private $repository;

    /**
     * Constructor
     *
     * @param LocaleRepositoryInterface $repository
     */
    public function __construct(LocaleRepositoryInterface $repository)
    {
        $this->repository           = $repository;
        $this->options['languages'] = $repository->getAvailableLocales();
        parent::__construct($this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        parent::configureAttributes($resolver);

        $resolver->setRequired([
            'languages',
            'repeat_min',
            'repeat_max',
        ]);

        $languagesCount = function (Options $options) {
            return count($options['languages']);
        };

        $resolver->setDefaults([
            'languages'     => [],
            'repeat_min'    => $languagesCount,
            'repeat_max'    => $languagesCount
        ]);


        $resolver->setAllowedTypes([
            'languages'  => 'array',
            'repeat_min' => 'numeric',
            'repeat_max' => 'numeric',
        ]);
    }

    /**
     * Formats field javascript
     *
     * @return string
     */
    protected function formatLanguagesJs()
    {
        $options = [];
        foreach ($this->options['languages'] as $language) {
            $value     = addslashes($language['code']);
            $label     = addslashes($language['code']);
            $flag      = addslashes(sprintf('%s.png', substr($label, 0, 2)));
            $options[] = "{sValue: '{$value}', sLabel: '{$label}',sFlag: '{$flag}' }";
        }

        return 'aoLanguages: [' . implode(', ', $options) . ']';
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        $attributes = [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatRepeatableJs(),
            $this->formatDependencyJs(),
            $this->formatLanguagesJs(),
            'aoFields: [' . $this->renderChildren() . ']'
        ];

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function setPropertyPath()
    {
        $this->attributes['property_path'] = new PropertyPath($this->getName());
    }

    public function addRules($constraints)
    {
        $propertyPath = '[' . $this->getPropertyPath() . ']';
        $accessor     = $this->getPropertyAccessor();
        if ($accessor->isReadable($constraints, $propertyPath)) {
            $fieldsetMetadata = $accessor->getValue($constraints, $propertyPath);
            if(isset($fieldsetMetadata->members)){
                foreach ($this->children as $child) {
                    $childPropertyPath = '[' . $child->getPropertyPath() . ']';
                    if ($accessor->isReadable($fieldsetMetadata->members, $childPropertyPath)) {
                        $fieldConstraints = $accessor->getValue($fieldsetMetadata->members, $childPropertyPath);
                        if(is_array($fieldConstraints)){
                            foreach ($fieldConstraints as $constraint) {
                                foreach ($constraint->constraints as $rule) {
                                    $child->addRule('required', ['message' => $rule->message]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Sets default data for all translatable fields bound to fieldset
     *
     * @param $data
     */
    public function setDefaults($data)
    {
        $values       = [];
        $accessor     = $this->getPropertyAccessor();
        $translations = $accessor->getValue($data, $this->getPropertyPath());
        foreach ($this->children as $child) {
            foreach ($translations as $translation) {
                $values[$translation->getLocale()] = $accessor->getValue($translation, $child->getPropertyPath());
                $child->populate($values);
            }
        }
    }

    public function validate($resource)
    {
        $accessor     = $this->getPropertyAccessor();
        $translations = $accessor->getValue($resource, $this->getPropertyPath());
        $result       = true;
        foreach ($this->children as $child) {
            $values = $child->getValue();
            foreach ($translations as $translation) {
                $value      = $values[$translation->getLocale()];
                $violations = $this->getValidator()->validatePropertyValue($translation, $child->getName(), $value);
                $error      = '';
                if ($violations->count()) {
                    $errorMessages = [];
                    foreach ($violations as $violation) {
                        $errorMessages[] = $violation->getMessage();
                    }
                    $error  = implode('.', $errorMessages);
                    $result = false;
                }
                $child->attributes['error'][$translation->getLocale()] = $error;
            }

        }

        return $result;
    }

    /**
     * Handles submit request and sets translations for entity
     *
     * @param $data
     */
    public function handleRequest($data)
    {
        $accessor = $this->getPropertyAccessor();
        foreach ($this->children as $child) {
            $childValues = $child->getValue();
            foreach ($childValues as $locale => $value) {
                $translation = $data->translate($locale);
                $accessor->setValue($translation, $child->getName(), $value);
            }
        }

        $data->mergeNewTranslations();
    }
}
