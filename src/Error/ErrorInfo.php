<?php
namespace Quartet\ContextualValidation\Error;

use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Errors occurred at one entity/row
 */
class ErrorInfo implements EntityInterface
{
    protected $error = false;
    protected $errors = [];

    /**
     * @param $target
     * @param $message
     */
    public function addError($target, $message)
    {
        $this->error = true;
        $this->errors[$target][] = $message;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return $this->error;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param ErrorInfo $target
     */
    public function merge(ErrorInfo $target)
    {
        $this->error = $this->error || $target->error;
        $this->errors = array_merge($this->errors, $target->errors);
    }
}
