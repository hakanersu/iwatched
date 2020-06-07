### iWatched

iWatched is movie, tv series tracker for personal usage. iWatched uses [imdb dataset](https://datasets.imdbws.com/). By a command it downloads all required datasets, unzips and imports to PostgreSQL database.

```
php artisan import:titles
```

You can skip tables.

```
php artisan import:titles --skip=title
```

Or import only given tables.

```
php artisan import:titles --only=rating
```
