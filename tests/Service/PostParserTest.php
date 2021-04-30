<?php


namespace App\Tests\Service;


use App\DTO\PostDTO;
use App\Service\PostParser;
use PHPUnit\Framework\TestCase;

class PostParserTest extends TestCase
{
    /**
     * @dataProvider notParsedPostsProvider
     */
    public function testParseAllPostsSuccess($notParsedPost, $notParsedPost1)
    {
        $postParser = new PostParser();
        $posts = $postParser->parsePosts([$notParsedPost, $notParsedPost1]);

        $this->assertNotEmpty($posts);
        $this->assertIsArray($posts);

        $post = $posts[0];

        $this->assertIsObject($post);
        $this->assertEquals(PostDTO::class, get_class($post));
    }

    /**
     * @dataProvider notParsedPostsProvider
     */
    public function testParseOnePostSuccess($notParsedPost)
    {
        $postParser = new PostParser();
        $post = $postParser->parseOne($notParsedPost);

        $this->assertNotEmpty($post);
        $this->assertIsObject($post);
        $this->assertEquals(PostDTO::class, get_class($post));
    }

    public function notParsedPostsProvider()
    {
        $notParsedPosts = [
            new class(){
                public function __construct()
                {
                    $this->id = 25;
                    $this->text = 'Some test text';
                    $this->created_at = new \DateTime();
                }
            },
            new class(){
                public function __construct()
                {
                    $this->id = 48;
                    $this->text = 'Some test text228';
                    $this->created_at = new \DateTime();
                }
            }
        ];
        return [$notParsedPosts];
    }
}