<?php


namespace App\Service;

use App\DTO\PostDTO;

class PostParser
{

    private $parsed_posts;

    public function parsePosts($not_parsed_posts)
    {
        foreach($not_parsed_posts as $not_parsed_post){
           $post = $this->parseOne($not_parsed_post);
           $this->saveParsedPost($post);
        }
    }

    private function parseOne($not_parsed_post): PostDTO
    {
        $postDTO = new PostDTO();
        $postDTO->id = $not_parsed_post->id;
        $postDTO->text = $not_parsed_post->text;
        $postDTO->published_at = $not_parsed_post->created_at;
        $postDTO->tags = $this->parseTags($not_parsed_post->entities->hashtags);

        return $postDTO;
    }

    private function parseTags($tags): array
    {
        $parsed_tags = [];

        foreach($tags as $tag){
            $parsed_tags[] = $tag->text;
        }

        return $parsed_tags;
    }

    private function saveParsedPost(PostDTO $postDTO){
        $this->parsed_posts[] = $postDTO;
    }

    public function getParsedPosts(): array{
        return $this->parsed_posts;
    }
}