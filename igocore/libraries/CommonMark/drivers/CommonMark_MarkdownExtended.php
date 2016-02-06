<?php

/**
 * CommonMark Driver for PHP Markdown Extra Extended v0.3
 *
 * Adapter to use the Markdown Extra Extended helper within the CommonMark
 * library.
 *
 * @link    https://github.com/egil/php-markdown-extra-extended
 */
class CommonMark_MarkdownExtended extends CommonMarkDriver
{
    /** @var string The class to instantiate and load into $this->converter. */
    protected $converterLib = 'MarkdownExtraExtended_Parser';

    /**
     * Load the Markdown Extended helper.
     *
     * @return boolean Returns true to indicate the helper has been loaded.
     */
    protected function init()
    {
        get_instance()->load->helper('markdown_extended');
        return true;
    }

    /**
     * The library method used to convert CommonMark to HTML.
     *
     * @param string $text CommonMark text to convert.
     *
     * @return string HTML text.
     */
    protected function toHtml($text)
    {
        return $this->converter->transform($text);
    }
}
