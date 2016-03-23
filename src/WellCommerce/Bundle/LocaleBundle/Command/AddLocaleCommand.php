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

namespace WellCommerce\Bundle\LocaleBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Intl\Intl;
use WellCommerce\Bundle\CurrencyBundle\DataSet\Admin\CurrencyDataSet;
use WellCommerce\Bundle\LocaleBundle\DataSet\Admin\LocaleDataSet;
use WellCommerce\Bundle\LocaleBundle\Manager\Admin\LocaleManager;

/**
 * Class AddLocaleCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AddLocaleCommand extends Command
{
    /**
     * @var LocaleManager
     */
    protected $localeManager;

    /**
     * @var LocaleDataSet
     */
    protected $localeDataSet;

    /**
     * @var CurrencyDataSet
     */
    protected $currencyDataSet;

    /**
     * @var array
     */
    protected $installedLocales = [];

    /**
     * @var array
     */
    protected $installedCurrencies = [];

    /**
     * @var array
     */
    protected $availableLocales = [];

    /**
     * AddLocaleCommand constructor.
     *
     * @param LocaleManager   $localeManager
     * @param LocaleDataSet   $localeDataSet
     * @param CurrencyDataSet $currencyDataSet
     */
    public function __construct(LocaleManager $localeManager, LocaleDataSet $localeDataSet, CurrencyDataSet $currencyDataSet)
    {
        parent::__construct();
        $this->localeManager   = $localeManager;
        $this->localeDataSet   = $localeDataSet;
        $this->currencyDataSet = $currencyDataSet;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Adds a new locale and copies translatable entities');
        $this->setName('wellcommerce:locale:add');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->installedLocales    = $this->getInstalledLocales();
        $this->installedCurrencies = $this->getInstalledCurrencies();
        $this->availableLocales    = $this->getAvailableLocales();
    }

    /**
     * Executes the actions
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourceLocale   = $this->chooseSourceLocale($input, $output);
        $targetLocale   = $this->chooseTargetLocale($input, $output);
        $targetCurrency = $this->chooseTargetCurrency($input, $output);

        $locale = $this->localeManager->createLocale($targetLocale, $targetCurrency);
        $output->writeln(sprintf('<info>Created a new locale "%s"</info>', $locale->getCode()));

        $this->localeManager->copyLocaleData($sourceLocale, $targetLocale);

        $output->writeln(sprintf('<info>Finished copying "%s" data</info>', $locale->getCode()));
    }

    protected function chooseSourceLocale(InputInterface $input, OutputInterface $output) : string
    {
        $defaultLocale = current($this->installedLocales);
        $question      = new ChoiceQuestion(
            sprintf(
                'Please select source locale from which new entities will be copied (defaults to "%s"):',
                $defaultLocale
            ),
            $this->installedLocales,
            $defaultLocale
        );

        $sourceLocale = $this->getHelper('question')->ask($input, $output, $question);

        return $sourceLocale;
    }

    protected function chooseTargetLocale(InputInterface $input, OutputInterface $output) : string
    {
        $question     = new ChoiceQuestion('Please select target locale to which new entities will be copied:', $this->availableLocales);
        $targetLocale = $this->getHelper('question')->ask($input, $output, $question);

        return $targetLocale;
    }

    protected function chooseTargetCurrency(InputInterface $input, OutputInterface $output) : string
    {
        $question             = new ChoiceQuestion('Please select a default currency for new locale:', $this->installedCurrencies);
        $targetLocaleCurrency = $this->getHelper('question')->ask($input, $output, $question);

        return $targetLocaleCurrency;
    }

    protected function getInstalledCurrencies() : array
    {
        return $this->currencyDataSet->getResult('select', ['order_by' => 'code'], [
            'label_column' => 'code',
            'value_column' => 'code'
        ]);
    }

    protected function getInstalledLocales() : array
    {
        return $this->localeDataSet->getResult('select', ['order_by' => 'code'], [
            'label_column' => 'code',
            'value_column' => 'code'
        ]);
    }

    public function getAvailableLocales() : array
    {
        $locales    = [];
        $collection = Intl::getLocaleBundle()->getLocaleNames();

        foreach ($collection as $locale => $name) {
            if (!in_array($locale, $this->installedLocales)) {
                $locales[$locale] = $name;
            }
        }

        return $locales;
    }
}
