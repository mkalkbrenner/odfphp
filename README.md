odfphp
======

PHP Library to create and edit OpenDocument formats like .odt, .ods, .odp etc.
It provides Shortcuts to manipulate the files in an easy way.
It is a fork of hanspolo/odfphp to supports newer PHP versions.

## Basic usage
This section gives a short introduction in the manipulation of documents.

The first example shows how to create a new document.
$type can be _text_, _spreadsheet_ or an other document type.

```php
   $document = new ODF();
   $document->create($type);
```

To save the document, you can use the following code.
$path is used as the path where the document will be saved.

```php
  $document->save($path);
```

If you want to extend an existing document, you can load it with this code.

```php
  $document = new ODF();
  $document->open($path);
```

After initializing your document, you can call:

```php
  $content = Text::getContentBody($document);
```

or, if you are editing an spreadsheet:

```php
  $content = Spreadsheet::getContentBody($document);
```

Now you can add elements to your document.
ODFphp provides some shortcuts to do this.

## Installation
Add the content of the src/ directory into your project.
To use ODFphp you have to include at least the odf.php file.

## License
ODFphp is licensed under [GPL v.3](http://www.gnu.org/licenses/gpl.html)
