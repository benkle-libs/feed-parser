<?php
/*
 * Copyright (c) 2017 Benjamin Kleiner
 *
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.  IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */


namespace Benkle\FeedParser;


class RelationLinkTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessors()
    {
        $relationLink = new RelationLink();

        $this->assertEquals($relationLink, $relationLink->setUrl('url'));
        $this->assertEquals('url', $relationLink->getUrl());
        $this->assertEquals($relationLink, $relationLink->setTitle('title'));
        $this->assertEquals('title', $relationLink->getTitle());
        $this->assertEquals($relationLink, $relationLink->setMimeType('mime'));
        $this->assertEquals('mime', $relationLink->getMimeType());
        $this->assertEquals($relationLink, $relationLink->setRelationType('relation'));
        $this->assertEquals('relation', $relationLink->getRelationType());
    }

    public function testJson()
    {
        $relationLink = new RelationLink();
        $relationLink
            ->setUrl('url')
            ->setRelationType('relationType')
            ->setMimeType('mimeType')
            ->setTitle('title');

        $this->assertEquals(
            [
                'url' => 'url',
                'relationType' => 'relationType',
                'mimeType' => 'mimeType',
                'title' => 'title',
            ], $relationLink->jsonSerialize()
        );
    }
}
