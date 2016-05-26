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

namespace Benkle\Feeding\FileAccess;


use Benkle\Feeding\Interfaces\FileAccessInterface;

class BasicFileAccessTest extends \PHPUnit_Framework_TestCase
{

    public function testNewFileAccess()
    {
        $fileAccess = new BasicFileAccess();
        $this->assertInstanceOf(FileAccessInterface::class, $fileAccess);
    }

    public function testExists()
    {
        $fileAccess = new BasicFileAccess();
        $this->assertTrue($fileAccess->exists(__FILE__));
        $this->assertFalse($fileAccess->exists(__FILE__ . '.nothere'));
    }

    public function testGet()
    {
        $fileAccess = new BasicFileAccess();
        $this->assertEquals(file_get_contents(__FILE__), $fileAccess->get(__FILE__));
    }

}
