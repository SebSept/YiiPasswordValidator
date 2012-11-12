# SPasswordValidator

SPasswordValidator is a password validator for the [Yii framework](http://www.yiiframework.com).

It's to use for a form/model validation rule.

## Features

- ready to use out of the box (see example basic below)
- customize parameters 
  - minimum number of characters
  - minimum number of upper case characters
  - minimum number of lower case characters
  - minimum number of digits characters
  - minimum number of special characters
- documentation included
- code quality (coded using unit test)

## Examples

### Basic (default params)

```php
    public function rules()
    {
        return array(
            array('password','ext.SPasswordValidator.SPasswordValidator')
        );
    }
```

### With custom parameters

Number of upper case chars set to 1, minimum number of characters set to 10.

```php
    public function rules()
    {
        return array(
            array('password','ext.SPasswordValidator.SPasswordValidator', 'up' => 1, 'min' => 10)
        );
    }

```

## Installation 

uncompress the archive in `protected/extensions/`. So path to php file will be `protected/extensions/SPasswordValidator/SPasswordValidator.php`.

## Contribute

Use to the _fullapp_ branch to fork (include phpunit's unit tests)

## Todo

- Add a 'max' parameter to avoid using another rule for attribute length.
- Add a 'preset' parameter so validator can be quicky parametrized with for example array('password','ext.SPasswordValidator', 'preset' => 'relax')

## Licence

Code is published under the [Creative Commons Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0) licence](http://creativecommons.org/licenses/by-sa/3.0/deed)