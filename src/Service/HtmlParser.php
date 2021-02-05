<?php


namespace App\Service;


class HtmlParser
{
    public function addColor(string $html, string $query): string
    {
        $array_words = explode(' ',$query);
        $search = implode('|', $array_words);

        return preg_replace(
            '%(?<=[^\p{L}\p{N}])('.str_replace('*', '[\p{L}\p{N}]*', $search).')(?=[^\p{L}\p{N}])(?=[^>]*<)%ui',
            '<span class="bg-warning"">$1</span>', $html);
    }

    public function tagsToLinks(string $html)
    {
        return preg_replace("/#(\w+)/i", "<a href=\"/$1\">$0</a>", $html);
    }
}