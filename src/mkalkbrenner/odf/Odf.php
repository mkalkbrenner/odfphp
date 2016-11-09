<?php

namespace mkalkbrenner\odf;

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
   * Adds a Picture to the archive anchored by page.
   *
   * @param string $path
   *
   * @return string
   *   The path that is used to access the image
   *
   * @throws \Exception
   */
  public function addPicture($path) {
    $dest = sprintf('Pictures/%s', basename($path));

    if (!file_exists($path)) {
      throw new \Exception("File '$path' doesn't exist");
    }

    // Add image to Pictures/
    $handle = fopen($path, 'r');
    $this->others[$dest] = $this->read($handle);

    // Add image to META-INF/manifest.xml
    $entry = $this->meta_manifest->createElement('manifest:file-entry');
    $entry->setAttribute('manifest:full-path', $dest);
    $entry->setAttribute('manifest:media-type', mime_content_type($path));
    $this->meta_manifest->getElementsByTagName('manifest')->item(0)->appendChild($entry);

    // Adjust meta.xml
    $metaImageCount = $this->meta->getElementsByTagName('meta')->item(0);
    $metaDocumentStatistic = $metaImageCount->getElementsByTagName('document-statistic')->item(0);
    $documentImageCount = (int)$metaDocumentStatistic->getAttribute('meta:image-count');
    $metaDocumentStatistic->setAttribute('meta:image-count', $documentImageCount + 1);

    // Add styles
    $styles = $this->styles->getElementsByTagName('styles')->item(0);
    $graphicsStyle = $this->styles->createElement('style:style');
    $graphicsStyle->setAttribute('style:name', 'Graphics');
    $graphicsStyle->setAttribute('style:family', 'graphic');
    $graphicsProperties = $this->styles->createElement('style:graphic-properties');
    $graphicsProperties->setAttribute('text:anchor-type', 'paragraph');
    $graphicsProperties->setAttribute('svg:x', '0cm');
    $graphicsProperties->setAttribute('svg:y', '0cm');
    $graphicsProperties->setAttribute('style:wrap', 'dynamic');
    $graphicsProperties->setAttribute('style:number-wrapped-paragraphs', 'no-limit');
    $graphicsProperties->setAttribute('style:wrap-contour', 'false');
    $graphicsProperties->setAttribute('style:vertical-pos', 'top');
    $graphicsProperties->setAttribute('style:vertical-rel', 'paragraph');
    $graphicsProperties->setAttribute('style:horizontal-pos', 'center');
    $graphicsProperties->setAttribute('style:horizontal-rel', 'paragraph');
    $graphicsStyle->appendChild($graphicsProperties);
    $styles->appendChild($graphicsStyle);

    $automaticStyle = $this->content->getElementsByTagName('automatic-styles')->item(0);
    $imageStyle = $this->content->createElement('style:style');
    $imageStyle->setAttribute('style:name', 'myImageStyle');
    $imageStyle->setAttribute('style:family', 'graphic');
    $imageStyle->setAttribute('style:parent-style-name', 'Graphics');
    $styleProperties = $this->content->createElement('style:graphic-properties');
    $styleProperties->setAttribute('style:vertical-pos', 'from-top');
    $styleProperties->setAttribute('style:vertical-rel', 'page');
    $styleProperties->setAttribute('style:horizontal-pos', 'from-left');
    $styleProperties->setAttribute('style:horizontal-rel', 'page');
    $styleProperties->setAttribute('style:mirror', 'none');
    $styleProperties->setAttribute('fo:clip', "rect(0cm, 0cm, 0cm, 0cm)");
    $styleProperties->setAttribute('draw:luminance', "0%");
    $styleProperties->setAttribute('draw:contrast', "0%");
    $styleProperties->setAttribute('draw:red', "0%");
    $styleProperties->setAttribute('draw:green', "0%");
    $styleProperties->setAttribute('draw:blue', "0%");
    $styleProperties->setAttribute('draw:gamma', "100%");
    $styleProperties->setAttribute('draw:color-inversion', "false");
    $styleProperties->setAttribute('draw:image-opacity', "100%");
    $styleProperties->setAttribute('draw:color-mode', "standard");
    $imageStyle->appendChild($styleProperties);
    $automaticStyle->appendChild($imageStyle);

    // Add image to content.xml
    $drawFrame = $this->content->createElement('draw:frame');
    $drawFrame->setAttribute('draw:style-name', 'myImageStyle');
    $drawFrame->setAttribute('draw:name', 'Image1');
    $drawFrame->setAttribute('text:anchor-type', 'page');
    $drawFrame->setAttribute('text:anchor-page-number', '1');
    $drawFrame->setAttribute('svg:x', '16.371cm');
    $drawFrame->setAttribute('svg:y', '2.79cm');
    $drawFrame->setAttribute('svg:width', '2.392cm');
    $drawFrame->setAttribute('svg:height', '2.586cm');
    $drawFrame->setAttribute('draw:z-index', '0');

    $drawImage = $this->content->createElement('draw:image');
    $drawImage->setAttribute('xlink:href', $dest);
    $drawImage->setAttribute('xlink:type', 'simple');
    $drawImage->setAttribute('xlink:show', 'embed');
    $drawImage->setAttribute('xlink:actuate', 'onLoad');
    $drawFrame->appendChild($drawImage);

    /** @var \DOMElement $body */
    $body = $this->content->getElementsByTagName('body')->item(0);
    /** @var \DOMElement $text */
    $text = $body->getElementsByTagName('text')->item(0);
    // It make sense on which position in xml the image inserted. we insert it on first position!
    $firstChild = $text->firstChild;
    //$text->appendChild($drawFrame);
    $text->insertBefore($drawFrame, $firstChild);

    return $dest;
  }

  /**
   * Adds a Picture at end of document anchored by paragraph.
   *
   * @param string $path
   *
   * @return string
   *   The path that is used to access the image
   *
   * @throws \Exception
   */
  public function addPictureParagraph($path) {
    $dest = sprintf('Pictures/%s', basename($path));

    if (!file_exists($path)) {
      throw new \Exception("File '$path' doesn't exist");
    }

    // Add image to Pictures/
    $handle = fopen($path, 'r');
    $this->others[$dest] = $this->read($handle);

    // Add image to META-INF/manifest.xml
    $entry = $this->meta_manifest->createElement('manifest:file-entry');
    $entry->setAttribute('manifest:full-path', $dest);
    $entry->setAttribute('manifest:media-type', mime_content_type($path));
    $this->meta_manifest->getElementsByTagName('manifest')->item(0)->appendChild($entry);

    // Add image to content.xml
    $textP = $this->content->createElement('text:p');
    $textP->setAttribute('text:style-name', 'Standard');
    $drawFrame = $this->content->createElement('draw:frame');
    $drawFrame->setAttribute('draw:style-name', 'fr1');
    $drawFrame->setAttribute('draw:name', 'Image1');
    $drawFrame->setAttribute('text:anchor-type', 'paragraph');
    $drawFrame->setAttribute('svg:x', '14.54cm');
    $drawFrame->setAttribute('svg:y', '0.039cm');
    $drawFrame->setAttribute('svg:width', '2.392cm');
    $drawFrame->setAttribute('svg:height', '2.586cm');
    $drawFrame->setAttribute('draw:z-index', '0');
    $drawImage = $this->content->createElement('draw:image');
    $drawImage->setAttribute('xlink:href', $dest);
    $drawImage->setAttribute('xlink:type', 'simple');
    $drawImage->setAttribute('xlink:show', 'embed');
    $drawImage->setAttribute('xlink:actuate', 'onLoad');
    $drawFrame->appendChild($drawImage);
    $textP->appendChild($drawFrame);

    $body = $this->content->getElementsByTagName('body')->item(0);
    $text = $body->getElementsByTagName('text')->item(0);
    $text->appendChild($textP);

    return $dest;
  }

}
