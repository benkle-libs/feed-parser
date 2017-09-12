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
use Benkle\FeedInterfaces\RelationLinkInterface;
use Benkle\FeedParser\Interfaces\RuleInterface;
use Benkle\FeedParser\Parser;
use Benkle\FeedParser\Standards\Atom\Atom10Standard;

class RelationsLinkRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testNewRule()
    {
        $rule = new RelationsLinkRule();
        $this->assertInstanceOf(RuleInterface::class, $rule);
    }

    public function testCanHandle()
    {
        $rule = new RelationsLinkRule();
        $dom = new \DOMDocument();
        $channel = $this->createMock(ChannelInterface::class);

        $domNode = $this->createLinkTag($dom, 'test', 'localhost');
        $this->assertEquals(true, $rule->canHandle($domNode, $channel));

        $domNode = $this->createLinkTag($dom, 'test', 'localhost', true);
        $this->assertEquals(true, $rule->canHandle($domNode, $channel));
    }

    public function testHandle()
    {
        $rule = new RelationsLinkRule();
        $dom = new \DOMDocument();
        $domNode = $this->createLinkTag($dom, 'test', 'localhost');
        $parser = $this
            ->getMockBuilder(Parser::class)
            ->disableOriginalConstructor()
            ->getMock();
        $channel = $this->createMock(ChannelInterface::class);
        $channel
            ->expects($this->atLeast(1))
            ->method('setRelation')
            ->with($this->isInstanceOf(RelationLinkInterface::class));

        $rule->handle($parser, $domNode, $channel);
    }

    private function createLinkTag(\DOMDocument $dom, $rel, $href, $upperCase = false)
    {
        $node = $dom->createElementNS(Atom10Standard::NAMESPACE_URI, $upperCase ? 'LINK' : 'link');
        $relAttr = $dom->createAttribute('rel');
        $relAttr->nodeValue = $rel;
        $node->appendChild($relAttr);
        $hrefAttr = $dom->createAttribute('href');
        $hrefAttr->nodeValue = $href;
        $node->appendChild($hrefAttr);
        return $node;
    }

}
