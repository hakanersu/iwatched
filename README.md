```
ALTER TABLE titles ADD COLUMN tsv_title_text tsvector;
```


```
CREATE INDEX tsv_title_text_idx ON titles USING gin(tsv_title_text);
```

```
UPDATE titles SET tsv_title_text = setweight(to_tsvector(coalesce(primary_title,'')), 'A') || setweight(to_tsvector(coalesce(original_title,'')), 'B');
```


```
SELECT primary_title FROM titles, plainto_tsquery('The Gift') AS q WHERE (tsv_title_text @@ q) ORDER BY weight DESC LIMIT 15;
```
