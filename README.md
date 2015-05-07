# Contextual Validator

[![Build Status](https://travis-ci.org/quartetcom/contextual-validator.svg?branch=master)](https://travis-ci.org/quartetcom/contextual-validator)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c89d2296-dcd3-46c1-bbab-9b4d8a88573a/mini.png)](https://insight.sensiolabs.com/projects/c89d2296-dcd3-46c1-bbab-9b4d8a88573a)
[![Total Downloads](https://poser.pugx.org/quartet/contextual-validator/downloads.png)](https://packagist.org/packages/quartet/contextual-validator)
[![Latest Stable Version](https://poser.pugx.org/quartet/contextual-validator/v/stable.png)](https://packagist.org/packages/quartet/contextual-validator)
[![Latest Unstable Version](https://poser.pugx.org/quartet/contextual-validator/v/unstable.png)](https://packagist.org/packages/quartet/contextual-validator)

# Installation

    $ composer require quartet/contextual-validator

# Usage

## Single Entity/Row validation

```php
$builder = new ValidatorBuilder();
$builder
    ->defaultContext()
        ->target('name')
            ->rule(new NotBlank())
        ->target('email')
            ->rule(new NotBlank())
    ->context('create')
        ->target('name')
            ->rule(new NotBlank())
        ->target('email')
            ->rule(new NotBlank())
    ->context('edit')
        ->target('name')
            ->rule(new NotBlank())
        ->target('email')
            ->rule(new NotBlank())
    ;
$validator = $builder->getValidator();

$entity = ...
$result = $validator->validate($entity);
if ($result->hasError()) {
    echo 'validation failed';
}
```

## Multiple Entities/Rows validation

```php
$builder = new ValidatorBuilder();
$builder...
    ;
$validator = $builder->getValidator();

$entity = ...

$runner = new ValidationRunner();
$runner->addRowValidator($validator);
$result = $runner->run();

if ($result->hasError()) {
    foreach ($result as $error) {
        echo $error->getPosition() . $error->getMessage() . PHP_EOL;
    }
}
```


# Support

If you find a bug or have a question, or want to request a feature, create an issue or pull request for it on [Issues](https://github.com/quartetcom/contexual-validation/issues).

# Copyright

Copyright (c) 2015 GOTO Hidenori, All rights reserved.

# License

[The BSD 2-Clause License](http://opensource.org/licenses/BSD-2-Clause)
