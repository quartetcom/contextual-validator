<?php
namespace Quartet\ContextualValidation;

/**
 * Rule should return false when rule is broken
 */
interface RuleInterface
{
    /**
     * @return string
     */
    public function getMessage();
}
