<?php

namespace mkalkbrenner\odf;

use mkalkbrenner\odf\Shortcut\Draw;
use mkalkbrenner\odf\Shortcut\Style;
use mkalkbrenner\odf\Shortcut\Text;

/**
 * Mainclass ODF.
 *
 * @license http://www.gnu.org/licenses/gpl.txt GNU Public License
 */
class Odf
{

  /**
   * @var \DOMDocument
   */
  public $content;

  /**
   * @var \DOMDocument
   */
  public $settings;

  /**
   * @var \DOMDocument
   */
  public $styles;

  /**
   * @var \DOMDocument
   */
  public $meta;

  /**
   * @var string
   */
  public $manifest;

  /**
   * @var string
   */
  public $mimetype;

  /**
   * @var \DOMDocument
   */
  public $meta_manifest;

  /**
   * @var string[]
   */
  public $others = [];

  /**
   * Loads an existing file from disk.
   *
   * @param String $path
   *
   * @throws \Exception
   */
  public function open($path) {
    $zip = new \ZipArchive();

    if ($zip->open($path) !== TRUE) {
      throw new \Exception("Can't open file $path");
    }

    for ($i = 0; $i < $zip->numFiles; $i++) {
      $name = $zip->getNameIndex($i);

      switch ($name) {
        case 'content.xml':
          $this->content = $this->parse($zip->getStream($name));
          break;
        case 'meta.xml':
          $this->meta = $this->parse($zip->getStream($name));
          break;
        case 'settings.xml':
          $this->settings = $this->parse($zip->getStream($name));
          break;
        case 'styles.xml':
          $this->styles = $this->parse($zip->getStream($name));
          break;
        case 'manifest.rdf':
          $this->manifest = $this->read($zip->getStream($name));
          break;
        case 'mimetype':
          $this->mimetype = $this->read($zip->getStream($name));
          break;
        case 'META-INF/manifest.xml':
          $this->meta_manifest = $this->parse($zip->getStream($name));
          break;
        default:
          $this->others[$name] = $this->read($zip->getStream($name));
          break;
      }
    }

    $zip->close();
  }

  /**
   * Opens an empty file.
   *
   * @param string $type
   *
   * @throws \Exception
   */
  public function create($type) {
    try {
      switch ($type) {
        case 'text':
          $this->open(__DIR__ . '/../data/text.odt');
          break;
        case 'spreadsheet':
          $this->open(__DIR__ . '/../data/spreadsheet.ods');
          break;
        default:
          throw new \Exception('Unknown data type');
          break;
      }
    }
    catch (\Exception $e) {
      throw new \Exception("Can't create file");
    }
  }

  /**
   * Saves the file to the disk.
   *
   * @param string $path
   *
   * @throws \Exception
   */
  public function save($path) {
    $zip = new \ZipArchive();
    $success = ($zip->open($path, \ZipArchive::OVERWRITE | \ZipArchive::CREATE) === TRUE);

    if (!$success) {
      throw new \Exception("Can't use $path for saving");
    }

    $success &= $zip->addFromString('content.xml', $this->content->saveXML());
    $success &= $zip->addFromString('settings.xml', $this->settings->saveXML());
    $success &= $zip->addFromString('styles.xml', $this->styles->saveXML());
    $success &= $zip->addFromString('meta.xml', $this->meta->saveXML());

    $success &= $zip->addFromString('manifest.rdf', $this->manifest);
    $success &= $zip->addFromString('mimetype', $this->mimetype);
    $success &= $zip->addFromString('META-INF/manifest.xml', $this->meta_manifest->saveXML());

    foreach ($this->others as $name => $data) {
      $success &= $zip->addFromString($name, $data);
    }

    $success &= $zip->close();

    if (!$success) {
      throw new \Exception("Can't save file $path");
    }
  }

  /**
   * Reads from file and parses XML.
   *
   * @param resource $handle
   *
   * @return \DOMDocument
   */
  private function parse($handle) {
    $content = '';
    while ($buffer = fgets($handle))
      $content .= $buffer;

    $doc = new \DOMDocument();
    $doc->loadXML($content);
    return $doc;
  }

  /**
   * Reads from file and returns it unparsed.
   *
   * @param resource $handle
   *
   * @return String
   */
  private function read($handle) {
    $content = '';
    while ($buffer = fgets($handle))
      $content .= $buffer;
    return $content;
  }

  /**
   * Adds a Picture to the archive.
   *
   * @param string $path
   *
   * @return string
   *
   * @throws \Exception
   *    The path that is used to access the image
   */
  public function addPicture($path) {
    $dest = sprintf('Pictures/%s', basename($path));

    // Add image to Pictures/
    if($handle = fopen($path, 'r')) {
      $this->others[$dest] = $this->read($handle);
    } else {
      throw new \Exception("File '$path' doesn't exist");
    }

    // Add image to META-INF/manifest.xml
    $entry = $this->meta_manifest->createElement('manifest:file-entry');
    $entry->setAttribute('manifest:full-path', $dest);

    if(preg_match('@^https?://@is', $path, $result)) {
      $mime = get_headers($path, 1)["Content-Type"];
    } else {
      $mime = mime_content_type($path);
    }

    $entry->setAttribute('manifest:media-type', $mime);
    $this->meta_manifest->getElementsByTagName('manifest')->item(0)->appendChild($entry);

    /** @var \DOMElement $metaImageCount  */
    $metaImageCount = $this->meta->getElementsByTagName('meta')->item(0);
    /** @var \DOMElement $metaDocumentStatistic */
    $metaDocumentStatistic = $metaImageCount->getElementsByTagName('document-statistic')->item(0);
    $documentImageCount = (int)$metaDocumentStatistic->getAttribute('meta:image-count');
    $metaDocumentStatistic->setAttribute('meta:image-count', $documentImageCount + 1);

    return $dest;
  }

  /**
   * Adds a Picture to the document. All floats in cm.
   *
   * @param string $path
   *    Path to the file
   * @param array $attributes
   *    Possible attributes: width, height, x, y, wrap (odf values), background (true|false)
   *
   * @return string
   *    The path that is used to access the image
   */
  public function addDocumentPicture($path, array $attributes = []) {
    // We first check if the file exists and add file to archive
    $dest = $this->addPicture($path);
    $styleName = sprintf('imageStyle%s', md5(rand()));

    // If one of the values or both are not set, then these are calculated
    if(!isset($attributes['width']) || !isset($attributes['height'])) {
      list($origWidth, $origHeight) = getimagesize($path);
      if(isset($attributes['width']) && !isset($attributes['height'])) {
        $attributes['height'] = $origHeight * $attributes['width'] / $origWidth;
      } else if(isset($attributes['height']) && !isset($attributes['width'])) {
        $attributes['width'] = $origWidth * $attributes['height'] / $origHeight;
      } else {
        $multiplier = 2.54/72;
        $attributes['width'] = $multiplier * $origWidth;
        $attributes['height'] = $multiplier * $origHeight;
      }
    }

    // Set default attributes
    $attributes += [
      'width' => 1.0,
      'height' => 1.0,
      'x' => 0.0,
      'y' => 0.0,
      'page' => 0,
      'wrap' => 'run-through',
      'background' => false
    ];

    // Add image style to automatic styles in document
    if($attributes['page'] > 0) {
      $document = $this->content;
    } else {
      $document = $this->styles;
    }
    $properties = [ 'style:wrap' => $attributes['wrap'], 'style:run-through' => ($attributes['background']?'background':'foreground') ];

    Style::setDocument($document);
    $automaticStyle = Style::getDocumentAutomaticStyles();
    $styleProperties = Style::createGraphicProperties(NULL, $properties);
    $imageStyle = Style::createStyle($styleProperties,
      [
        'style:name'    => $styleName,
        'style:family'  => 'graphic'
      ]
    );
    Style::appendChild($automaticStyle, $imageStyle);

    // Add image to document
    $drawImage = Draw::createImage(NULL, [ 'xlink:href' => $dest ]);
    $drawFrame = Draw::createFrame($drawImage,
      [
        'draw:style-name'         => $styleName,
        'text:anchor-type'        => $attributes['page'] > 0?'page':'paragraph',
        'text:anchor-page-number' => $attributes['page'] > 0?$attributes['page']:null,
        Attribute::image_x        => $attributes['x'] . 'cm',
        Attribute::image_y        => $attributes['y'] . 'cm',
        Attribute::image_width    => $attributes['width'] . 'cm',
        Attribute::image_height   => $attributes['height'] . 'cm',
      ]
    );
    if($attributes['page'] > 0) {
      Text::prependChild(Text::getContentBody($this), $drawFrame);
    } else {
      /** @var \DOMElement $masterPage */
      $masterPage = Style::getDocumentMasterPage();
      $styleHeader = Style::search(Node::style_header, $masterPage);
      if($styleHeader && $styleHeader->length) {
        Style::prependChild($styleHeader->item(0), Text::createParagraph($drawFrame));
      } else {
        Text::setDocument($this->styles);
        Style::prependChild($masterPage, Style::createMasterStyleHeader(Text::createParagraph($drawFrame)));
      }
    }
  }

}
