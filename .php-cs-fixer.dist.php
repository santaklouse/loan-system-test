<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/tests',
    ])
    ->exclude([
        'bootstrap',
        'storage',
        'vendor',
    ]);

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'no_unused_imports' => true,
    'concat_space' => ['spacing' => 'one'],
    'trailing_comma_in_multiline' => true,
])
    ->setFinder($finder);
