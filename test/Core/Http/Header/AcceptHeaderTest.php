<?php

namespace ParsTest\Core\Http\Header;

use HttpSoft\Message\Request;
use Pars\Core\Http\Header\Accept\AcceptHeader;
use PHPUnit\Framework\TestCase;

class AcceptHeaderTest extends TestCase
{
    public function testShouldParseFromRequest()
    {
        $request = new Request();
        $exampleHeader = "text/html," .
            "application/xhtml+xml," .
            "application/xml;q=0.9," .
            "image/avif," .
            "image/webp," .
            "image/apng,*/*;q=0.8," .
            "application/signed-exchange;v=b3;q=0.9";

        $request = $request->withAddedHeader('Accept', $exampleHeader);

        $headerObject = new AcceptHeader($request);
        $this->assertTrue($headerObject->isHtml());
    }
}
