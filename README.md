# Description

Symfony-news it's test application on Symfony framework.

## Installation


Run these commands in your bash.
```bash
git clone https://github.com/Yakov32/symfony-news.git

composer install
```

## Usage

```python
  
1. Create .env.local and override vars from .env with your own TWITTER API data.

2. docker-compose up -d 

3. sudo docker exec -it bash symfony-news-php-cli

4. php bin/console dodctrine:database:create & php/bin/console doctrine:migrations:migrate

5. Collect posts from twitter buy collect-news.



foobar.pluralize('word') # returns 'words'
foobar.pluralize('goose') # returns 'geese'
foobar.singularize('phenomena') # returns 'phenomenon'
```

## License
[MIT](https://choosealicense.com/licenses/mit/)