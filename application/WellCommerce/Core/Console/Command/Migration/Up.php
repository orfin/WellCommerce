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
namespace WellCommerce\Core\Console\Command\Migration;

use Symfony\Component\Finder\Finder;
use WellCommerce\Core\Model\Migration;
use WellCommerce\Core\Console\Command\AbstractCommand;
use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Up
 *
 * @package WellCommerce\Core\Console\Command\Migration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Up extends AbstractCommand
{

    protected function configure()
    {
        $this->setName('migration:up');

        $this->setDescription('Executes migration classes');

        $this->setHelp(sprintf('%Executes "up" command in migration classes.%s', PHP_EOL, PHP_EOL));
    }

    private function getMigrations()
    {
        $migrations = Migration::all();
        $classes    = [];

        foreach ($migrations as $migration) {
            $classes[] = $migration->name;
        }

        return $classes;
    }

    private function saveInfo($class)
    {
        $migration             = new Migration();
        $migration->name       = $class;
        $migration->created_at = date('Y-m-d H:i:s');
        $migration->save();
    }

    /**
     * Executes migration:up command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->getDatabaseManager()->schema()->hasTable('migration')) {
            throw new \RuntimeException(sprintf('Table %s does not exists', 'migration'));
        }

        $migrations = $this->getMigrations();
        $finder     = new Finder();
        $files      = $finder->files()->in(ROOTPATH . 'application')->name('Migration*.php')->notName('*Interface.php')->sortByName();

        foreach ($files as $file) {
            $namespace = str_replace(DS, '\\', $file->getRelativePath());
            $className = str_replace(DS, '\\', $file->getBasename('.php'));
            $class     = sprintf('%s\%s', $namespace, $className);

            if (!in_array($class, $migrations)) {

                $refClass  = new \ReflectionClass($class);
                $interface = 'WellCommerce\\Core\\Migration\\MigrationInterface';
                if ($refClass->implementsInterface($interface)) {

                    // instantiate migration class
                    $migrationObj = new $class();
                    $migrationObj->up();

                    // save info about migration
                    $this->saveInfo($class);

                    $out = sprintf('Migration %s executed.%s', $class, PHP_EOL);
                    $output->write($out);
                }
            }
        }

        $out = sprintf('All migrations executed.%s', PHP_EOL);
        $output->write($out);
    }
}