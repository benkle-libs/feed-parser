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


use Benkle\FeedParser\Interfaces\FeedInterface;
use Benkle\FeedParser\Traits\WithDescriptionTrait;
use Benkle\FeedParser\Traits\WithFeedItemsTrait;
use Benkle\FeedParser\Traits\WithLastModifiedTrait;
use Benkle\FeedParser\Traits\WithPublicIdTrait;
use Benkle\FeedParser\Traits\WithRelationsTrait;
use Benkle\FeedParser\Traits\WithTitleTrait;

/**
 * Class Feed
 * This class contains special mapping for Link and URL.
 * @package Benkle\FeedParser\Standards\Atom
 */
class Feed implements FeedInterface, \JsonSerializable
{
    use WithTitleTrait, WithPublicIdTrait, WithDescriptionTrait,
        WithLastModifiedTrait, WithFeedItemsTrait, WithRelationsTrait;

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        $result = [
            'title'        => $this->getTitle(),
            'link'         => $this->getLink(),
            'publicId'     => $this->getPublicId(),
            'description'  => $this->getDescription(),
            'lastModified' => $this->getLastModified()->format(\DateTime::ATOM),
            'url'          => $this->getUrl(),
            'items'        => $this->getItems(),
            'relations'    => $this->getRelations(),
        ];
        return $result;
    }

    /**
     * Get the (canonical) link.
     * @return string
     */
    public function getLink()
    {
        return $this->getRelationSilently('alternate');
    }

    /**
     * Set the (canonical) link.
     * @param string $link
     * @return $this
     */
    public function setLink($link)
    {
        return $this->setRelation('alternate', $link);
    }

    /**
     * Get the feed url.
     * @return string
     */
    public function getUrl()
    {
        return $this->getRelationSilently('self');
    }

    /**
     * Set the feed url.
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        return $this->setRelation('self', $url);
    }

    /**
     * Get a relation link, failing silently.
     * @codeCoverageIgnore
     * @param string $rel
     * @return string
     */
    private function getRelationSilently($rel)
    {
        $result = '';
        try {
            $result = $this->getRelation($rel);
        } catch (\Exception $e) {
        }
        return $result;
    }
}
