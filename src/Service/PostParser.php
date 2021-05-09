<?php


namespace App\Service;

use App\DTO\PostDTO;

class PostParser
{
    private $parsed_posts;

    public function parsePosts(array $not_parsed_posts)
    {
        foreach($not_parsed_posts as $not_parsed_post){
           $post = $this->parseOne($not_parsed_post);
            $this->parsed_posts[] = $post;
        }

        return $this->getParsedPosts();
    }

    public function parseOne($not_parsed_post): PostDTO
    {
        $postDTO = new PostDTO();
        $postDTO->id = $not_parsed_post->id;
        $postDTO->text = $not_parsed_post->text;
        $postDTO->published_at = $not_parsed_post->created_at;

        if (property_exists($not_parsed_post, 'entities')) {
            $postDTO->tags = $this->parseTags($not_parsed_post->entities->hashtags);
        }
        return $postDTO;
    }

    private function parseTags(array $tags): array
    {
        $parsed_tags = [];

        foreach ($tags as $tag) {
            $parsed_tags[] = $tag->text;
        }

        return $parsed_tags;
    }

    public function getParsedPosts(): array{
        return $this->parsed_posts;
    }
}