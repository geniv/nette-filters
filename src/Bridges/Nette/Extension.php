<?php declare(strict_types=1);

namespace Filters\Bridges\Nette;

use Filters\FilterLatte;
use Nette\DI\CompilerExtension;


/**
 * Class Extension
 *
 * @author  geniv
 * @package Filters\Bridges\Nette
 */
class Extension extends CompilerExtension
{

    /**
     * Before compile.
     */
    public function beforeCompile()
    {
        $builder = $this->getContainerBuilder();

        // connect filter to latte
        $builder->getDefinition('latte.latteFactory')
            ->addSetup('addFilter', [null, FilterLatte::class . '::_loader']);
    }
}
