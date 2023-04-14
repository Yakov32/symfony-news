# Description

Symfony-news it's a test application on Symfony framework

## Installation


Run these commands in your bash.
```bash
git clone https://github.com/Yakov32/symfony-news.git

composer install
```

## Usage

1. Create .env.local and override vars from .env with your own TWITTER API data. Also you can configurate collector params in services.yaml


2. Execute these commands.

```python
sudo docker-compose up -d 

sudo docker exec -it symfony-news-php-cli bash

php bin/console doctrine:database:create

php bin/console doctrine:migrations:migrate
```
3. Collect posts from twitter by ```php bin/console app:collect-posts```
## License
[MIT](https://choosealicense.com/licenses/mit/)
