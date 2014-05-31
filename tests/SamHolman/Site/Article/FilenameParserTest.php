<?php

use SamHolman\Site\Article\FilenameParser;

class FilenameParserTest extends PHPUnit_Framework_TestCase
{
    public function filenameProvider()
    {
        return [
            ['310514-test-filename.md', '310514-test-filename', 310514, 'Test Filename'],
            ['_010614-test-filename-2.md', '_010614-test-filename-2', '010614', 'Test Filename 2'],
        ];
    }

    /**
     * @dataProvider filenameProvider
     */
    public function testGetDetailsFromFilename($filename, $slug, $date, $title)
    {
        $parser = new FilenameParser();
        $this->assertEquals(
            [$slug, \DateTime::createFromFormat('dmy', $date), $title],
            $parser->getDetailsFromFilename($filename)
        );
    }
}
