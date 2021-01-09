### iWatched

iWatched is movie, tv series tracker for personal usage. iWatched uses [imdb dataset](https://datasets.imdbws.com/). By a command it downloads all required datasets, unzips and imports to PostgreSQL database.

Import part is done by native PostgreSql command copy with Eloquent query builder. Part of the importing process also added weight column which will help ranking more accurately. You can find more information about imdb ranking algorithm [here](https://en.wikipedia.org/wiki/IMDb#Rankings).

### Searching

For searching we are using meilisearch.

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

#### Commands

```
docker-compose up -d

# If you getting any error when storage:link just remove public/storage folder.
utils/iwatched php artisan storage:link
# This will migrate basic user tables.
utils/iwatched php artisan migrate
# Downloads imdb dataset if its not already downloaded and imports to pgsql.
utils/iwatched import
```

You can now access app http://localhost:8000 with this url.

```
# If you start docker-compose recently please wait es cluster up and try again.
utils/iwatched index
```

After first run you can start/stop app with below commands.

```
docker-compose start
docker-compose stop
```
