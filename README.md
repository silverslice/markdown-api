Tiny library for generating API documentation for your class
============================================================

## Install

`composer require silverslice/markdown-api`

## Live example

```php
require __DIR__ . '/../vendor/autoload.php';

$g = new Silverslice\MarkdownApi\Generator();
$g->generate('Silverslice\MarkdownApi\Generator')->output();
```

This code generates following documentation for class \Silverslice\MarkdownApi\Generator:

### generate
Generates markdown documentation for public methods in a specified class

```php
generate($className)
```

*Parameters:*
- *string* $className - Fully qualified class name

*Returns:*
- *$this*

### save
Saves generated documentation to a file

```php
save($fileName)
```

*Parameters:*
- *string* $fileName - The name of the file

*Returns:*
- *int* - The number of bytes that were written to the file, or false on failure

### output
Outputs generated documentation

```php
output()
```

### setTemplate
Sets file path for template of a method

```php
setTemplate($file)
```

*Parameters:*
- *string* $file - Path to the template

*Throws:*

- *\InvalidArgumentException* - If the file cannot be read

