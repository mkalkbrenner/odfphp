<?php

namespace mkalkbrenner\odf\Shortcut;

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
   * @param DOMDocument $document
   *
   * @return DOMElement
   */
  public static function getContentBody($document)
  {
    return $document->content->getElementsByTagName("body")->item(0)->getElementsByTagName("draw")->item(0);
  }

  /**
   * Creates a Frame Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createFrame($content = null, $attributes = array())
  {
    $allowed_attributes = array("draw:style-name", ODF_Attribute::image_height, ODF_Attribute::image_width, "text:anchor-type", "draw:z-index");

    $attributes["draw:style-name"] = "fr1";
    $attributes["text:anchor-type"] = "paragraph";
    $attributes["draw:z-index"] = 0;

    $frame = self::createElement(ODF_Node::frame, $content);
    self::setAttributes($frame, $attributes, $allowed_attributes);

    return $frame;
  }

  /**
   * Creates a Image Element.
   *
   * @param Mixed $content
   * @param Array $attributes
   *
   * @return DOMElement
   */
  public static function createImage($content = null, $attributes = array())
  {
    $allowed_attributes = array(ODF_Attribute::href, "xlink:type", "xlink:show", "xlink:actuate");

    $attributes["xlink:type"] = "simple";
    $attributes["xlink:show"] = "embed";
    $attributes["xlink:actuate"] = "onLoad";

    if (is_string($content))
      {
	$attributes[ODF_Attribute::href] = $content;
	$content = "";
      }

    $image = self::createElement(ODF_Node::image, $content);
    self::setAttributes($image, $attributes, $allowed_attributes);

    return $image;
  }
}
