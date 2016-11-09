<?php

namespace mkalkbrenner\odf\Shortcut;

use mkalkbrenner\odf\Attribute;
use mkalkbrenner\odf\Node;
use mkalkbrenner\odf\Odf;

/**
 * Shortcuts primarily for Draw-documents.
 *
 * @license http://www.gnu.org/licenses/gpl.txt GNU Public License
 */
class Draw extends Shortcut
{

  /**
   * Returns the Element /body/spreadsheet.
   *
   * @param Odf $document
   *
   * @return \DOMElement
   */
  public static function getContentBody(Odf $document) {
    return $document->content->getElementsByTagName("body")->item(0)->getElementsByTagName("draw")->item(0);
  }

  /**
   * Creates a Frame Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createFrame($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      'draw:style-name',
      Attribute::image_height,
      Attribute::image_width,
      Attribute::image_x,
      Attribute::image_y,
      'text:anchor-type',
      'text:anchor-page-number',
      'draw:z-index',
    ];

    $attributes += [
      'draw:style-name' => 'fr1',
      'text:anchor-type' => 'paragraph',
      'draw:z-index' => 0
    ];

    $frame = self::createElement(Node::frame, $content);
    self::setAttributes($frame, $attributes, $allowed_attributes);

    return $frame;
  }

  /**
   * Creates a Image Element.
   *
   * @param mixed $content
   * @param string[] $attributes
   *
   * @return \DOMElement
   */
  public static function createImage($content = NULL, $attributes = []) {
    static $allowed_attributes = [
      Attribute::href,
      'xlink:type',
      'xlink:show',
      'xlink:actuate',
    ];

    $attributes += [
      'xlink:type' => 'simple',
      'xlink:show' => 'embed',
      'xlink:actuate' => 'onLoad',
    ];

    if (is_string($content)) {
      $attributes[Attribute::href] = $content;
      $content = '';
    }

    $image = self::createElement(Node::image, $content);
    self::setAttributes($image, $attributes, $allowed_attributes);

    return $image;
  }
}
