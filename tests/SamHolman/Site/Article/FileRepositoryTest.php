<?php

use SamHolman\Site\Article\FileRepository;

class FileRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (version_compare(PHP_VERSION, '5.5.13') >= 0) {
            $this->markTestSkipped('Skipping test due to issue with mocking DirectoryIterator in 5.5.13 and above.');
        }
    }

    private function getFile($filename)
    {
        $articleFile = Mockery::Mock('DirectoryIterator');
        $articleFile->shouldReceive('getFilename')->andReturn($filename);
        $articleFile->shouldReceive('getPathname')->andReturn('/tmp/' . $filename);

        $file = Mockery::mock('DirectoryIterator');
        $file->shouldReceive('isDot')->andReturn(false);
        $file->shouldReceive('isReadable')->andReturn(true);
        $file->shouldReceive('getExtension')->andReturn('md');
        $file->shouldReceive('getFilename')->andReturn($filename);
        $file->shouldReceive('getFileInfo')->andReturn($articleFile);

        return $file;
    }

    public function testFindAll()
    {
        $file1 = $this->getFile('310514-test-article.md');
        $file2 = $this->getFile('190714-test-article-2.md');

        $directoryIterator = Mockery::mock('DirectoryIterator');
        $directoryIterator->shouldReceive('rewind');
        $directoryIterator->shouldReceive('valid')->twice()->andReturn(true);
        $directoryIterator->shouldReceive('valid')->once()->andReturn(false);
        $directoryIterator->shouldReceive('current')->once()->andReturn($file1);
        $directoryIterator->shouldReceive('current')->once()->andReturn($file2);
        $directoryIterator->shouldReceive('next')->twice()->andReturn(true);

        $fileReader = Mockery::mock('\SamHolman\Base\File\Reader');
        $fileReader->shouldReceive('read')->andReturn('File contents');

        $filenameParser = Mockery::mock('\SamHolman\Site\Article\FilenameParser');
        $filenameParser->shouldReceive('getDetailsFromFilename')
            ->andReturn(['310514-test-article', new DateTime(), 'Test Article']);

        $repo = new FileRepository($directoryIterator, $fileReader, $filenameParser);

        foreach ($repo->findAll() as $article) {
            $this->assertEquals('Test Article', $article->getTitle());
            $this->assertEquals('File contents', $article->getContent());
        }
    }

    public function articleProvider()
    {
        return [
            ['310514-test-article.md', '310514-test-article', 'Test Article'],
            ['_010614-test-article-2.md', '_010614-_test-article-2', 'Test Article 2'],
        ];
    }

    /**
     * @dataProvider articleProvider
     */
    public function testFind($filename, $slug, $title)
    {
        $directoryIterator = Mockery::mock('DirectoryIterator');
        $directoryIterator->shouldReceive('getPath')->andReturn('/tmp/' . $filename);

        $fileReader = Mockery::mock('\SamHolman\Base\File\Reader');
        $fileReader->shouldReceive('exists')->andReturn(true);
        $fileReader->shouldReceive('read')->andReturn('File contents');

        $filenameParser = Mockery::mock('\SamHolman\Site\Article\FilenameParser');
        $filenameParser->shouldReceive('getDetailsFromFilename')
            ->andReturn([$slug, new DateTime(), $title]);

        $repo = new FileRepository($directoryIterator, $fileReader, $filenameParser);

        $article = $repo->find($slug);
        $this->assertEquals($title, $article->getTitle());
    }

    public function testFindFailsWithInvalidFile()
    {
        $directoryIterator = Mockery::mock('DirectoryIterator');
        $directoryIterator->shouldReceive('getPath');

        $fileReader = Mockery::mock('\SamHolman\Base\File\Reader');
        $fileReader->shouldReceive('exists')->andReturn(false);

        $filenameParser = Mockery::mock('\SamHolman\Site\Article\FilenameParser');

        $repo = new FileRepository($directoryIterator, $fileReader, $filenameParser);

        $this->assertNull($repo->find('invalid'));
    }

    public function testCount()
    {
        $file = Mockery::mock('DirectoryIterator');
        $file->shouldReceive('isDot')->andReturn(false);
        $file->shouldReceive('isReadable')->andReturn(true);
        $file->shouldReceive('getExtension')->andReturn('md');
        $file->shouldReceive('getFilename');
        $file->shouldReceive('getFileInfo');

        $directoryIterator = Mockery::mock('DirectoryIterator');
        $directoryIterator->shouldReceive('rewind');
        $directoryIterator->shouldReceive('valid')->once()->andReturn(true);
        $directoryIterator->shouldReceive('valid')->between(1, 1)->andReturn(false);
        $directoryIterator->shouldReceive('current')->once()->andReturn($file);
        $directoryIterator->shouldReceive('next')->once()->andReturn(false);

        $fileReader = Mockery::mock('\SamHolman\Base\File\Reader');
        $filenameParser = Mockery::mock('\SamHolman\Site\Article\FilenameParser');

        $repo = new FileRepository($directoryIterator, $fileReader, $filenameParser);
        $this->assertEquals(1, $repo->count());
    }
}
