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

namespace Benkle\FeedParser\Standards\Atom\Rules;


use Benkle\FeedInterfaces\ChannelInterface;
use Benkle\FeedInterfaces\NodeInterface;
use Benkle\FeedParser\Interfaces\RuleInterface;
use Benkle\FeedParser\Parser;
use Benkle\FeedParser\RelationLink;
use Benkle\FeedParser\Standards\Atom\Atom10Standard;

/**
 * Class RelationsLinkRule
 * Rule for atom relation links.
 * @package Benkle\FeedParser\Standards\Atom\Rules
 */
class RelationsLinkRule implements RuleInterface
{
    /**
     * Safely get an attribute value.
     * @param \DOMNode $node
     * @param string $attr
     * @param mixed|null $default
     * @return null|string
     */
    private function getAttr(\DOMNode $node, $attr, $default = null)
    {
        $attr = $node->attributes->getNamedItem($attr);
        return isset($attr) ? $attr->nodeValue : $default;
    }

    /**
     * Check if a dom node can be handled by this rule.
     * @param \DOMNode $node
     * @param NodeInterface $target
     * @return bool
     */
    public function canHandle(\DOMNode $node, NodeInterface $target)
    {
        return
            strtolower($node->localName) == 'link' &&
            $node->namespaceURI == Atom10Standard::NAMESPACE_URI &&
            $target instanceof ChannelInterface;
    }

    /**
     * Handle a dom node.
     * @param Parser $parser
     * @param \DOMNode $node
     * @param NodeInterface $target
     * @return void
     */
    public function handle(Parser $parser, \DOMNode $node, NodeInterface $target)
    {
        $rel = $this->getAttr($node, 'rel');
        $link = $this->getAttr($node, 'href');
        $title = $this->getAttr($node, 'title');
        $mime = $this->getAttr($node, 'type');
        $relation = new RelationLink();
        $relation
            ->setTitle($title)
            ->setMimeType($mime)
            ->setRelationType($rel)
            ->setUrl($link);
        /** @var ChannelInterface $target */
        $target->setRelation($relation);
    }
}
