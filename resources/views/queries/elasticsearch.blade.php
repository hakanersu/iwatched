{
  "query": {
    "bool": {
      "must": [
        {
          "multi_match": {
            "query": "the marti",
            "fields": [
              "original_title",
              "primary_title"
            ],
            "type": "phrase_prefix",
            "max_expansions": 1000,
            "slop": 10
          }
        }
      ],
      "filter": {
        "bool": {
          "must": [
            {
              "terms": {
                "title_type": [
                  "movie",
                  "tvseries"
                ]
              }
            }
          ]
        }
      }
    }
  },
  "_source": [
    "primary_title",
    "original_title",
    "tconst",
    "title_type",
    "weight",
    "start_year"
  ],
  "sort": [
    {
      "weight": {
        "order": "desc",
        "mode": "avg"
      }
    }
  ]
}
