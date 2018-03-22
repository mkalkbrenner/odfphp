<?php

namespace mkalkbrenner\odf\Shortcut;

/**
 * Abstract class for Shortcuts.
 * @license http://www.gnu.org/licenses/gpl.txt GNU Public License
 */
abstract class Shortcut
{

  /**
   * @var \DOMDocument
   */
  protected static $document;

  /**
   *
   */
  public static function setDocument(\DOMDocument $document) {
    self::$document = $document;
  }

  /**
   * Searchs inside the DOM
   *
   * @param string $path
   * @param \DOMNode $relative
   *
   * @return \DOMNodeList
   */
  public static function search($path, $relative = NULL) {
    $xpath = new \DOMXPath(self::$document);

    return $relative != NULL ? $xpath->query($path, $relative) : $xpath->query($path);
  }

  /**
   * Inserts a child element at last position in parent
   *
   * @param \DOMElement $parent
   * @param \DOMElement $child
   *
   * @return \DOMElement
   */
  public static function appendChild(\DOMElement $parent, \DOMElement $child) {
    $parent->appendChild($child);

    return $parent;
  }

  /**
   * Inserts a child element at first position in parent
   *
   * @param \DOMElement $parent
   * @param \DOMElement $child
   *
   * @return \DOMElement
   */
  public static function prependChild(\DOMElement $parent, \DOMElement $child) {
    $parent->insertBefore($child, $parent->firstChild);

    return $parent;
  }

  /**
   * Returns child element by name
   *
   * @param \DOMElement $parent
   * @param string $name
   *
   * @return \DOMElement|null
   */
  public static function getChildByName(\DOMElement $parent, $name) {
    /** @var \DOMElement $children */
    $children = $parent->childNodes;
    /** @var \DOMElement $child */
    foreach($children as $child) {
      if($child->hasAttribute('style:name') && $name == $child->getAttribute('style:name')) {
        return $child;
      }
    }

    return null;
  }

  /**
   * Creates a new Element.
   *
   * @param string $title
   * @param mixed $content
   * @param boolean $isleaf
   * @param string|null $namespace
   *
   * @return \DOMElement
   *
   * @throws \Exception
   */
  protected static function createElement($title, $content, $isleaf = FALSE, $namespace = null) {
    $element = NULL;

    $args = [$namespace, $title, (is_string($content)?$content:null)];

    if (!is_null($namespace)) {
      $element = self::$document->createElementNS($args[0], $args[1], $args[2]);
    } else {
      $element = self::$document->createElement($args[1], $args[2]);
    }

    if (!$isleaf && is_null($args[2]) && $content instanceof \DOMNode) {
      $element->appendChild($content);
    } else if (!is_null($content)) {
      throw new \Exception('Content has to be a String' . ($isleaf ? '' : ' or a DOMNode'));
    }

    return $element;
  }

  /**
   * Adds or updates attributes to an element.
   *
   * @param \DOMElement $element
   * @param string[] $attributes
   * @param string[] $allowed_attributes
   */
  protected static function setAttributes($element, $attributes, $allowed_attributes) {
    foreach ($attributes as $key => $value) {
      if (in_array($key, $allowed_attributes)) {
        $element->setAttribute($key, $value);
      }
    }
  }

}
