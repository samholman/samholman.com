<?php

use SamHolman\Site\Article\FileRepository;

class FileRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function testFindAll()
    {
        $filename = '310514-test-article.md';

        $articleFile = Mockery::Mock('DirectoryIterator');
        $articleFile->shouldReceive('getFilename')->andReturn($filename);
        $articleFile->shouldReceive('getPathname')->andReturn('/tmp/' . $filename);

        $file = Mockery::mock('DirectoryIterator');
        $file->shouldReceive('isDot')->andReturn(false);
        $file->shouldReceive('isReadable')->andReturn(true);
        $file->shouldReceive('getExtension')->andReturn('md');
        $file->shouldReceive('getFilename')->andReturn($filename);
        $file->shouldReceive('getFileInfo')->andReturn($articleFile);

        $directoryIterator = Mockery::mock('DirectoryIterator');
        $directoryIterator->shouldReceive('rewind');
        $directoryIterator->shouldReceive('valid')->once()->andReturn(true);
        $directoryIterator->shouldReceive('valid')->between(1, 1)->andReturn(false);
        $directoryIterator->shouldReceive('current')->once()->andReturn($file);
        $directoryIterator->shouldReceive('next')->once()->andReturn(false);

        $fileReader = Mockery::mock('\SamHolman\Base\File\Reader');
        $fileReader->shouldReceive('read')->andReturn('File contents');

        $filenameParser = Mockery::mock('\SamHolman\Site\Article\FilenameParser');
        $filenameParser->shouldReceive('getDetailsFromFilename')
            ->andReturn(['310514-test-article', new DateTime(), 'Test Article']);

        $repo = new FileRepository($directoryIterator, $fileReader, $filenameParser);
        $articles = $repo->findAll();

        foreach ($articles as $article) {
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
