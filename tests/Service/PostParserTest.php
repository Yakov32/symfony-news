<?php


namespace App\Tests\Service;


use App\DTO\PostDTO;
use App\Service\PostParser;
use PHPUnit\Framework\TestCase;

class PostParserTest extends TestCase
{
    public function setUp(): void
    {
        $this->postParser = new PostParser();
        $this->notParsedPosts = $this->getNotParsedPostsMock();
    }

    public function testParseAllPostsSuccess()
    {
        $posts = $this->postParser->parsePosts($this->notParsedPosts);

        $this->assertIsArray($posts);
        $this->assertNotEmpty($posts);

        $post1 = $posts[0];

        $this->assertIsObject($post1);
        $this->assertEquals(PostDTO::class, get_class($post1));
    }

    public function testParseOnePostSuccess()
    {
        $post = $this->postParser->parseOne($this->notParsedPosts[0]);

        $this->assertNotEmpty($post);
        $this->assertIsObject($post);
        $this->assertEquals(PostDTO::class, get_class($post));
    }

    public function getNotParsedPostsMock()
    {
        return [
            0 => new class(){
                public function __construct()
                {
                    $this->id = 25;
                    $this->text = 'Some test text';
                    $this->created_at = new \DateTime();
                }
            },
            1 => new class(){
                public function __construct()
                {
                    $this->id = 48;
                    $this->text = 'Some test text228';
                    $this->created_at = new \DateTime();
                }
            }
        ];
    }
}