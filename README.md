# Description

Symfony-news it's test application on Symfony framework.

## Installation


Run these commands in your bash.
```bash
git clone https://github.com/Yakov32/symfony-news.git

composer install
```

## Usage

1. Create .env.local and override vars from .env with your own TWITTER API data.

2. Execute these commands.
```python
  
sudo docker-compose up -d 

sudo docker exec -it bash symfony-news-php-cli

php bin/console dodctrine:database:create

php/bin/console doctrine:migrations:migrate

```
5. Collect posts from twitter by collect-news.
## License
[MIT](https://choosealicense.com/licenses/mit/)