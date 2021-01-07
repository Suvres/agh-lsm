<?php
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use Symplify\CodingStandard\CognitiveComplexity\Rules\ClassLikeCognitiveComplexityRule;
use Symplify\CodingStandard\CognitiveComplexity\Rules\FunctionLikeCognitiveComplexityRule;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use Symplify\CodingStandard\Fixer\Commenting\ParamReturnAndVarTagMalformsFixer;

return static function (ContainerConfigurator $containerConfigurator): void {
// A. standalone rule
    $services = $containerConfigurator->services();
    $services->set(ArraySyntaxFixer::class)
    ->call('configure', [[
    'syntax' => 'short',
    ]]);
    $services->set(UnusedVariableSniff::class)
        ->property('ignoreUnusedValuesWhenOnlyKeysAreUsedInForeach', true);

    $services->set(CastSpacesFixer::class)
        ->call('configure', [['space' => 'none']]);
    $services->set(FunctionLikeCognitiveComplexityRule::class);

    $services->set(NoWhitespaceBeforeCommaInArrayFixer::class);
    $services->set(WhitespaceAfterCommaInArrayFixer::class);
    $services->set(ReturnAssignmentFixer::class);
    $services->set(ParamReturnAndVarTagMalformsFixer::class);

    $parameters = $containerConfigurator->parameters();
    $parameters->set('exclude_files', ['tests/**', 'src/DataFixtures/**', 'src/Menu/MenuBuilder.php']);

    $parameters->set(Option::SETS, [
        SetList::CLEAN_CODE,
        SetList::PSR_12,
        SetList::DEAD_CODE,
        SetList::SYMFONY,
        SetList::PHP_71,
        SetList::NAMESPACES,
        SetList::DOCBLOCK,
        SetList::DOCTRINE_ANNOTATIONS,
        SetList::ARRAY,
        SetList::CONTROL_STRUCTURES,
        SetList::STRICT,
        SetList::SYMFONY_RISKY,
//        SetList::SYMPLIFY
    ]);
};