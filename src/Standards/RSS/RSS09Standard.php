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

namespace Benkle\FeedParser\Standards\RSS;


use Benkle\FeedInterfaces\FeedInterface;
use Benkle\FeedParser\Exceptions\InvalidNumberOfRootTagsException;
use Benkle\FeedParser\Feed;
use Benkle\FeedParser\Interfaces\StandardInterface;
use Benkle\FeedParser\Standards\Atom\Rules\RelationsLinkRule;
use Benkle\FeedParser\Standards\RSS\Rules\ChannelRule;
use Benkle\FeedParser\Standards\RSS\Rules\EnclosureRule;
use Benkle\FeedParser\Standards\RSS\Rules\ItemRule;
use Benkle\FeedParser\Standards\RSS\Rules\LastBuildDateRule;
use Benkle\FeedParser\Standards\RSS\Rules\LinkRule;
use Benkle\FeedParser\Standards\RSS\Rules\PubDateRule;
use Benkle\FeedParser\Standards\RSS\Rules\SimpleRSSFieldRule;
use Benkle\FeedParser\Traits\WithParserTrait;
use Benkle\FeedParser\Traits\WithRuleSetTrait;

/**
 * Class RSS09Standard
 * Standard for handling RSS 0.9*
 * @package Benkle\FeedParser\Standards\RSS
 */
class RSS09Standard implements StandardInterface
{

    use WithParserTrait, WithRuleSetTrait;

    /**
     * RSS09Standard constructor.
     */
    public function __construct()
    {
        $this->getRules()
             ->add(new ChannelRule(), 0)
             ->add(new SimpleRSSFieldRule('title', 'setTitle'), 25)
             ->add(new LinkRule(), 10)
             ->add(new LastBuildDateRule(), 10)
             ->add(new EnclosureRule(), 10)
             ->add(new RelationsLinkRule(), 15)
             ->add(new SimpleRSSFieldRule('description', 'setDescription'), 25)
             ->add(new ItemRule(), 50)
             ->add(new PubDateRule(), 50);
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
        $rootNodes = $dom->getElementsByTagName('rss');
        if ($rootNodes->length != 1) {
            Throw new InvalidNumberOfRootTagsException('rss', $rootNodes->length);
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
        $result = false;
        $rootNodes = $dom->getElementsByTagName('rss');
        if ($rootNodes->length == 1) {
            $version = $rootNodes->item(0)->attributes->getNamedItem('version');
            $result = $version && fnmatch($this->getVersionPattern(), $version->nodeValue);
        }
        return $result;
    }

    /**
     * Get the pattern for matching RSS versions.
     * @return string
     */
    protected function getVersionPattern()
    {
        return '0.9*';
    }

}
