<?php


$finder = PhpCsFixer\Finder::create()
	->notPath('vendor')
	->notPath('bootstrap')
	->notPath('storage')
    	->in(__DIR__)
    	->name('*.php')
    	->notName('*.blade.php');
;


return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
	'ordered_imports' => ['sortAlgorithm' => 'alpha'],
        'no_unused_imports' => true,
    ])
    ->setFinder($finder)
;

