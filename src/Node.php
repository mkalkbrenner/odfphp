<?php

namespace mkalkbrenner\odf;

/**
 * Collection of ODF Nodetypes.
 *
 * @license http://www.gnu.org/licenses/gpl.txt GNU Public License
 */
interface Node
{
  const body = "office:body";
  const text = "office:text";

  const h = "text:h";
  const p = "text:p";
  const list_body = "text:list";
  const list_header = "text:list-header";
  const list_item = "text:list-item";
  const line_break = "text:line-break";
  const numbered_p = "text:numbered-paragraph";
  const page_sequence = "text:page-sequence";
  const page = "text:page";
  const section = "text:section";

  const table = "table:table";
  const table_row = "table:table-row";
  const table_column = "table:table-column";
  const table_cell = "table:table-cell";

  const frame = "draw:frame";
  const image = "draw:image";

  const style = "style:style";
  const paragraph_properties = "style:paragraph-properties";
  const text_properties = "style:text-properties";
}
