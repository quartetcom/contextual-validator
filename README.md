# Contextual Validator

# Installation

    $ composer require quartet/contextual-validator

# Usage

## Single Entity/Row validation

```php
$builder = new ValidatorBuilder();
$builder
    ->default()
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
