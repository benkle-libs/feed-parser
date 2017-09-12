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


namespace Benkle\FeedParser\Traits;

use Benkle\FeedInterfaces\RelationLinkInterface;
use Benkle\FeedParser\RelationLink;

/**
 * Trait WithMappedLinkTrait
 * @package Benkle\FeedParser\Traits
 * @method $this setRelation(RelationLinkInterface $relation)
 * @method RelationLinkInterface getRelation(string $type)
 */
trait WithMappedLinkTrait
{
    /**
     * Get the feed url.
     * @return string
     */
    public function getUrl()
    {
        $relation = $this->getRelationSilently('self');
        return isset($relation) ? $relation->getUrl() : '';
    }

    /**
     * Set the feed url.
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $relation = new RelationLink();
        $relation
            ->setRelationType('self')
            ->setUrl($url);
        return $this->setRelation($relation);
    }

    /**
     * Get the (canonical) link.
     * @return string
     */
    public function getLink()
    {
        $relation = $this->getRelationSilently('alternate');
        return isset($relation) ? $relation->getUrl() : '';
    }

    /**
     * Set the (canonical) link.
     * @param string $link
     * @return $this
     */
    public function setLink($link)
    {
        $relation = new RelationLink();
        $relation
            ->setRelationType('alternate')
            ->setUrl($link);
        return $this->setRelation($relation);
    }

    /**
     * Get a relation link, failing silently.
     * @codeCoverageIgnore
     * @param string $rel
     * @return RelationLinkInterface|null
     */
    private function getRelationSilently($rel)
    {
        $result = null;
        try {
            $result = $this->getRelation($rel);
        } catch (\Exception $e) {
        }
        return $result;
    }
}
