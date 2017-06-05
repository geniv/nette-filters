<?php

namespace Filters\Bridges\Nette;

use Filters\FilterLatte;
use Nette\DI\CompilerExtension;


/**
 * Class Extension
 *
 * nette extension pro alias router jako rozsireni
 *
 * @author  geniv
 * @package Filters\Bridges\Nette
 */
class Extension extends CompilerExtension
{

    /**
     * Before Compile.
     */
    public function beforeCompile()
    {
        $builder = $this->getContainerBuilder();

        // pripojeni filru do latte
        $builder->getDefinition('latte.latteFactory')
            ->addSetup('addFilter', [null, FilterLatte::class . '::common']);
    }
}
