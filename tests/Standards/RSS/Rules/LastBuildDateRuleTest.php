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

namespace Benkle\FeedParser\Standards\RSS\Rules;


use Benkle\FeedInterfaces\FeedInterface;
use Benkle\FeedInterfaces\ItemInterface;
use Benkle\FeedParser\Interfaces\RuleInterface;
use Benkle\FeedParser\Parser;

class LastBuildDateRuleTest extends \PHPUnit_Framework_TestCase
{

    public function testNewRule()
    {
        $rule = new LastBuildDateRule();
        $this->assertInstanceOf(RuleInterface::class, $rule);
    }

    public function testCanHandle()
    {
        $rule = new LastBuildDateRule();
        $dom = new \DOMDocument();
        $feed = $this->createMock(FeedInterface::class);
        $item = $this->createMock(ItemInterface::class);

        $domNode = $dom->createElement('lastbuilddate');
        $this->assertEquals(true, $rule->canHandle($domNode, $feed));
        $this->assertEquals(false, $rule->canHandle($domNode, $item));

        $domNode = $dom->createElement('LASTBUILDDATE');
        $this->assertEquals(true, $rule->canHandle($domNode, $feed));
        $this->assertEquals(false, $rule->canHandle($domNode, $item));

        $domNode = $dom->createElement('not-lastbuilddate');
        $this->assertEquals(false, $rule->canHandle($domNode, $feed));
        $this->assertEquals(false, $rule->canHandle($domNode, $item));
    }

    public function testHandle()
    {
        $rule = new LastBuildDateRule();
        $dom = new \DOMDocument();
        $domNode = $dom->createElement('lastbuilddate');
        $feed = $this->createMock(FeedInterface::class);
        $domNode->nodeValue = 'Mon, 15 Aug 2005 15:52:01 +0000';
        $parser = $this
            ->getMockBuilder(Parser::class)
            ->disableOriginalConstructor()
            ->getMock();
        $channel = $this->createMock(FeedInterface::class);
        $channel
            ->expects($this->atLeast(1))
            ->method('setLastModified')
            ->with($this->isInstanceOf(\DateTime::class));

        $rule->handle($parser, $domNode, $channel);
    }
}
