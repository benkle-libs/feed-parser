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


use Benkle\FeedInterfaces\RelationLinkInterface;

/**
 * Class RelationLink
 * @package Benkle\FeedParser
 */
class RelationLink implements RelationLinkInterface, \JsonSerializable
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $relationType;

    /**
     * @var string
     */
    private $mimeType;

    /**
     * @var string
     */
    private $title;

    /**
     * Get the relation url.
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the relation url.
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get the relation type, e.g. "self" or "alternate".
     * @return string
     */
    public function getRelationType()
    {
        return $this->relationType;
    }

    /**
     * Set the relation type.
     * @param string $rel
     * @return $this
     */
    public function setRelationType($rel)
    {
        $this->relationType = $rel;
        return $this;
    }

    /**
     * Get the mime type.
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set the mime type.
     * @param string $mimeType
     * @return $this
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * Get the relation title.
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the relation title.
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'url'          => $this->getUrl(),
            'relationType' => $this->getRelationType(),
            'mimeType'     => $this->getMimeType(),
            'title'        => $this->getTitle(),
        ];
    }
}
