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

namespace Benkle\FeedParser\Standards\Atom;


use Benkle\FeedInterfaces\FeedInterface;
use Benkle\FeedParser\Exceptions\InvalidNumberOfRootTagsException;
use Benkle\FeedParser\Interfaces\StandardInterface;
use Benkle\FeedParser\Standards\Atom\Rules\EnclosureLinkRule;
use Benkle\FeedParser\Standards\Atom\Rules\EntryRule;
use Benkle\FeedParser\Standards\Atom\Rules\RelationsLinkRule;
use Benkle\FeedParser\Standards\Atom\Rules\SimpleAtomFieldRule;
use Benkle\FeedParser\Standards\Atom\Rules\UpdatedRule;
use Benkle\FeedParser\Traits\WithParserTrait;
use Benkle\FeedParser\Traits\WithRuleSetTrait;

/**
 * Class Atom10Standard
 * Standard for handling Atom 1.0
 * @package Benkle\FeedParser\Standards\Atom
 */
class Atom10Standard implements StandardInterface
{

    use WithParserTrait, WithRuleSetTrait;

    const NAMESPACE_URI = 'http://www.w3.org/2005/Atom';

    /**
     * Atom10Standard constructor.
     */
    public function __construct()
    {
        $this->getRules()
             ->add(new SimpleAtomFieldRule('id', 'setPublicId'), 10)
             ->add(new SimpleAtomFieldRule('title', 'setTitle'), 10)
             ->add(new SimpleAtomFieldRule('subtitle', 'setDescription'), 10)
             ->add(new SimpleAtomFieldRule('summary', 'setDescription'), 10)
             ->add(new UpdatedRule(), 10)
             ->add(new EnclosureLinkRule(), 20)
             ->add(new RelationsLinkRule(), 25)
             ->add(new EntryRule(), 50);
    }

    /**
     * Get a new feed object.
     * @return FeedInterface
     */
    public function newFeed()
    {
        return new Feed();
    }

    /**
     * Get the feed root from a dom document.
     * @return \DOMNode
     * @throws InvalidNumberOfRootTagsException
     */
    public function getRootNode(\DOMDocument $dom)
    {
        $rootNodes = $dom->getElementsByTagNameNS(self::NAMESPACE_URI, 'feed');
        if ($rootNodes->length != 1) {
            Throw new InvalidNumberOfRootTagsException('feed', $rootNodes->length);
        }
        return $rootNodes->item(0);
    }

    /**
     * Check if a dom document is a feed this standard handles.
     * @param \DOMDocument $dom
     * @return bool
     */
    public function canHandle(\DOMDocument $dom)
    {
        return $dom->getElementsByTagNameNS(self::NAMESPACE_URI, 'feed')->length == 1;
    }
}
