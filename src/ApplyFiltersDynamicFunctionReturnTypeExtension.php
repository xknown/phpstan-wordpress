<?php

/**
 * Set return type of apply_filters
 */

declare(strict_types=1);

namespace PHPStan\WordPress;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\Type;

class ApplyFiltersDynamicFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(FunctionReflection $functionReflection): bool
    {
        return $functionReflection->getName() === 'apply_filters';
    }

    public function getTypeFromFunctionCall(FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope): Type
    {
        if (!isset($functionCall->args[1])) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        $arg = $functionCall->args[1];
        return $scope->getType($arg->value);
    }
}
