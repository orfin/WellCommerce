<?php
namespace ComposerRevisionPlugin;

use Composer\Config;
use Composer\Util\Filesystem;

class ReferenceClassGenerator
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Config $config)
    {
        $this->filesystem = new Filesystem();
        $this->config = $config;
    }

    /**
     * @param string $destination
     * @param array $references
     */
    public function generate($destination, array $references)
    {
        $this->filesystem->ensureDirectoryExists(dirname($destination));

        $referencesPhp = var_export($references, true);

        $text = <<<EOF
<?php
namespace ComposerRevisions;

class Revisions
{
    public static \$byName = $referencesPhp;
}
EOF;

        file_put_contents($destination, $text);
    }
}
