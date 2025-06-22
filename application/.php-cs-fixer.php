<?php
// .php-cs-fixer.php
return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'declare_strict_types' => true,
        'no_superfluous_phpdoc_tags' => false,
        'phpdoc_no_package' => false,
        'general_phpdoc_annotation_remove' => [
            'annotations' => ['author'],
        ],
        'phpdoc_separation' => false,
        'phpdoc_align' => [
            'align' => 'vertical',
        ],
        'binary_operator_spaces' => [
            'operators' => [
                '=>' => 'align_single_space_minimal',
                '='  => 'align_single_space_minimal',
            ],
        ],
        'trailing_comma_in_multiline' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'single_quote' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_extra_blank_lines' => ['tokens' => ['extra']],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__ . '/app')
            ->in(__DIR__ . '/tests')
    );