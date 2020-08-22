### iWatched

iWatched is movie, tv series tracker for personal usage. iWatched uses [imdb dataset](https://datasets.imdbws.com/). By a command it downloads all required datasets, unzips and imports to PostgreSQL database.

Import part is done by native PostgreSql command copy with Eloquent query builder. Part of the importing process also added weight column which will help ranking more accurately. You can find more information about imdb ranking algorithm [here](https://en.wikipedia.org/wiki/IMDb#Rankings).

### Searching

By default search is done by elasticsearch if you wish to search directly from database add `ELASTICSEARCH=false` variable to you .env file.

### ElasticSearch

You can use [abc tool](https://github.com/appbaseio/abc) to import titles table. After that you will get pretty fast search results.

```sh
abc import --src_type=postgres --src_filter=titles --src_uri="postgresql://postgres:<your-password>@127.0.0.1:5432/<database-name>" "http://localhost:9200/titles"
```

![Image of Searching](./public/images/search.gif)

You can also use some shortcuts to find desired title.

```sh
the gift :year 2000
```

```sh
tt0903747 :imdb
```

### Movies

![Image of Movies](./public/images/movies.png)

### Series

![Image of Series](./public/images/series.png)

### Posters

Posters automatically fetched from themoviedb.org and stored at default storage.

### Commands

```sh
php artisan import:titles
```

You can skip tables.

```sh
php artisan import:titles --skip=title
```

Or import only given tables.

```sh
php artisan import:titles --only=rating
```

### Docker compose

Check .env.example file and be sure above ports not used.

```dotenv
PSQL_PORT=5439:5432
APP_PORT=8000:8000
```

#### Commands

```
docker-compose up -d

# If you getting any error when storage:link just remove public/storage folder.
docker-compose run --rm --no-deps iwatched-server php artisan storage:link
# This will migrate basic user tables.
docker-compose run --rm --no-deps iwatched-server php artisan migrate
# Downloads imdb dataset if its not already downloaded and imports to pgsql.
docker-compose run --rm --no-deps iwatched-server php artisan import:titles
```

You can now access app http://localhost:8000 with this url.

```
# If you start docker-compose recently please wait es cluster up and try again.
docker-compose run --rm --no-deps iwatched-server php artisan import:elastic
```

After first run you can start/stop app with below commands.

```
docker-compose start
docker-compose stop
```
### TODO

- [ ] Minio/AWS integration for posters.
