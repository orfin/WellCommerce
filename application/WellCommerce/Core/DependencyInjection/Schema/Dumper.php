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

namespace WellCommerce\Core\DependencyInjection\Schema;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class Dumper
 *
 * @package WellCommerce\Core\DependencyInjection\Schema
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Dumper
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    private $containerBuilder;

    /**
     * Constructor
     *
     * @param ContainerBuilder $containerBuilder
     */
    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    /**
     * Returns DB connection
     *
     * @return \Illuminate\Database\Connection
     */
    private function getConnection()
    {
        return $this->containerBuilder->get('database_manager')->connection();
    }

    /**
     * Returns all database columns as an array
     *
     * @return array
     */
    private function getAllColumns()
    {
        $connection = $this->getConnection();

        $sql = $this->getSchemaInfoQuery();

        $database = $connection->getDatabaseName();

        $results = $connection->select($sql, [$database]);

        $schema = [];
        foreach ($results as $result) {
            $schema[$result['table_name']][] = $result['column_name'];
        }

        return $schema;
    }

    /**
     * Returns SQL to execute on database to fetch column and table info
     *
     * @return string
     */
    private function getSchemaInfoQuery()
    {
        return "SELECT table_name, column_name FROM information_schema.columns WHERE table_schema = ?";
    }

    /**
     * Generates string containing columns as a variable which is used in class generator
     *
     * @return string
     */
    private function generateColumns()
    {
        $allColumns = $this->getAllColumns();

        $columns = "[\n";
        foreach ($allColumns as $table => $info) {
            $columns .= sprintf("        '%s' => ['%s'],\n", $table, implode('\',\'', $info));
        }
        $columns .= '    ]';

        return $columns;
    }

    /**
     * Dumps generated class as a file
     *
     * @param array $options
     *
     * @return string
     */
    public function dump(array $options = [])
    {
        return <<<EOF
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

namespace {$options['namespace']};

/**
 * Class {$options['class']}
 *
 * This helper class was auto-generated. Please do not remove it.
 *
 * @package WellCommerce\Core\Helper
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class {$options['class']}
{
    private static \$columns  = {$this->generateColumns()};

    public static function getColumns(\$table)
    {
        if(!isset(self::\$columns[\$table])){
            throw new \InvalidArgumentException(sprintf('Table %s does not exists in schema information', \$table));
        }

        return self::\$columns[\$table];
    }

}

EOF;
    }
} 