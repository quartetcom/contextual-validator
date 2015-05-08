<?php
/*
 * Copyright (c) 2015 GOTO Hidenori <hidenorigoto@gmail.com>,
 * All rights reserved.
 *
 * This file is part of Quartet/Contextual Validation.
 *
 * This program and the accompanying materials are made available under
 * the terms of the BSD 2-Clause License which accompanies this
 * distribution, and is available at http://opensource.org/licenses/BSD-2-Clause
 */

namespace Quartet\ContextualValidation;

use Quartet\ContextualValidation\Error\ErrorInfo;
use Quartet\ContextualValidation\Error\ErrorInfoCollection;

class ValidationRunner
{
    /**
     * @var Validator[]
     */
    private $rowValidators;
    /**
     * @var Validator[]
     */
    private $collectionValidators;

    /**
     * @param Validator $validator
     */
    public function addRowValidator(Validator $validator)
    {
        $this->rowValidators[] = $validator;
    }

    /**
     * @param Validator $validator
     */
    public function addCollectionValidator(Validator $validator)
    {
        $this->collectionValidators[] = $validator;
    }

    /**
     * @param $data
     * @return ErrorInfoCollection
     */
    public function run($data)
    {
        $errorInfoList = new ErrorInfoCollection();
        $rowNumber = 0;
        foreach ($data as $row) {
            foreach ($this->rowValidators as $rowValidator) {
                /** @var Validator $rowValidator */
                /** @var ErrorInfo $e */
                $e = $rowValidator->validate($row, $rowNumber);
                if ($e->hasError()) {
                    $errorInfoList->add($e);
                }
            }
            $rowNumber++;
        }

        return $errorInfoList;
    }
}
