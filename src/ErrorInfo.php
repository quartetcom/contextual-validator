<?php
namespace Quartet\ContextualValidation;

use PHPMentors\DomainKata\Entity\EntityInterface;

class ErrorInfo implements EntityInterface
{
    protected $error = false;
    protected $errors = [];

    public function __construct()
    {
    }

    /**
     * @param $error
     */
    public function addError($error)
    {
        $this->error = true;
        $this->errors[] = $error;
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
        $this->error |= $target->error;
        $this->errors = array_merge($this->errors, $target->errors);
    }
}
