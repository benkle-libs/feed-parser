<?php
/**
 * Copyright (c) 2016 Benjamin Kleiner
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of
 * the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Benkle\FeedParser\DOMParsers;


use Benkle\FeedParser\Interfaces\DOMParserInterface;

/**
 * Class PHPDOMParser
 * Adapter for the PHP DOM module.
 * @package Benkle\FeedParser\DOMParsers
 */
class PHPDOMParser implements DOMParserInterface
{

    /**
     * Parse a string into a DOMDocument.
     * @param $source
     * @return \DOMDocument
     * @throws \DOMException
     */
    public function parse($source)
    {
        $dom = new \DOMDocument();
        if (!$dom->loadXML($source, LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR)) {
            throw new \DOMException('Unable to parse source');
        }
        return $dom;
    }
}
