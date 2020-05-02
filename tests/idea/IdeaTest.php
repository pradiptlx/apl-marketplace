<?php
declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use Dex\Marketplace\Domain\Model\Idea;
use Dex\Marketplace\Domain\Model\Author;

class IdeaTest extends TestCase
{

    public function testCanBeInstantiated() : void
    {
        $author = new Author("John Doe", "john.doe@mail.com");
        $idea = Idea::makeIdea("my marketplace", "my description", $author);

        $this->assertEquals("my marketplace", $idea->title());
        $this->assertEquals("my description", $idea->description());
        $this->assertEquals($author, $idea->author());
    }

}
