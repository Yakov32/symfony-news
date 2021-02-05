<?php


namespace App\Command;


use App\Service\PostMapper;
use App\Service\PostOnlineCollector;
use App\Service\PostParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CollectPostsCommand extends Command
{
    protected static $defaultName = 'app:collect-posts';
    private $postMapper;
    private $postParser;
    private $postOnlineCollector;

    public function __construct(string $name = null, PostOnlineCollector $postOnlineCollector, PostParser $postParser, PostMapper $postMapper)
    {
        parent::__construct($name);

        $this->postOnlineCollector = $postOnlineCollector;
        $this->postParser = $postParser;
        $this->postMapper = $postMapper;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $collected_posts = $this->postOnlineCollector->collectPosts();

        $this->postParser->parsePosts($collected_posts);
        $posts = $this->postParser->getParsedPosts();

        $this->postMapper->mapData($posts);

        $output->writeLn('Success. Posts have been collected.');

        return Command::SUCCESS;
    }
}