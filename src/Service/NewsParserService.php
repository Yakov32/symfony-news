<?php


namespace App\Service;


class NewsParserService
{
    private $parsed_posts = [];
    private $parsed_tags = [];

    public function parseAll($news)
    {
        foreach($news as $new){
            $this->parseOne($new);
        }
    }

    private function parseOne($element){
        $parsed_post = [];
        $parsed_post['uniqie_id'] = $element->id;
        $parsed_post['text'] = $element->text;
        $parsed_post['published_at'] = $element->created_at;
        $parsed_post['tags'] = $this->parseTags($element->entities->hashtags);

        $this->parsed_posts[] = $parsed_post;
    }

    private function parseTags($tags): array
    {
        $parsed_tags = [];

        foreach($tags as $tag){
            $parsed_tags[] = $tag->text;
        }

        return $parsed_tags;
    }

    public function getParsedPosts(): array{
        return $this->parsed_posts;
    }

}