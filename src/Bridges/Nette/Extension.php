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
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        // definice modelu
        $builder->addDefinition($this->prefix('default'))
            ->setClass(FilterLatte::class);
    }


    /**
     * Before Compile.
     */
    public function beforeCompile()
    {
        $builder = $this->getContainerBuilder();

        // pripojeni filru do latte
        $builder->getDefinition('latte.latteFactory')
            ->addSetup('addFilter', [null, $this->prefix('@default')]);
    }
}
