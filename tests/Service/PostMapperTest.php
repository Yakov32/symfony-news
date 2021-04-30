<?php


namespace App\Tests\Service;


use App\DTO\PostDTO;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use App\Service\PostMapper;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class PostMapperTest extends TestCase
{
    /**
     * @dataProvider postsProvider
     */
    public function testMapDataSuccess($postDTO, $post1DTO)
    {
        $postMapper = $this->createPostMapper();

        $res = $postMapper->mapData([$postDTO, $post1DTO]);

        $this->assertTrue($res);
    }

    /**
     * @dataProvider postsProvider
     */
    public function testMapSingePostSuccess(PostDTO $postDTO)
    {
        $postMapper = $this->createPostMapper();
        $post = $postMapper->mapSinglePost($postDTO);

        $this->assertIsObject($post);
        $this->assertSame(Post::class, get_class($post));
    }

    public function createPostMapper(){
        return new PostMapper(
            $this->createMock(EntityManager::class),
            $this->createMock(PostRepository::class),
            $this->createMock(TagRepository::class));
    }

    public function postsProvider(): array
    {
        $post = new PostDTO();
        $post->id = 2;
        $post->text = 'Some test text';
        $post->published_at = date("D M j G:i:s T Y");

        $post1 = new PostDTO();
        $post1->id = 3;
        $post1->text = 'Some test text';
        $post1->published_at = date("D M j G:i:s T Y");

        return [[$post, $post1]];
    }
}