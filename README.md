# 2DV513

1189.6478948593

2174.496931076

15min

8min

SELECT COUNT(author)
FROM post
WHERE author = 'drinkmorecoffee'

(COUNT(subreddit_id) / 31) as comments_per_day

SELECT (COUNT(subreddit_id) / 31) as comments_per_day
FROM post
JOIN subreddit ON (subreddit_id = subreddit.id)
WHERE subreddit.name = "wow"

SELECT COUNT(id) as comments_with_lol
FROM post
WHERE body LIKE '%lol%'

SELECT DISTINCT subreddit.name
FROM post
JOIN subreddit ON (post.subreddit_id = subreddit.id)
WHERE author IN (SELECT author
FROM post
WHERE link_id = 't3_j5200')

select author
from ( select SUM(score)
  from post
  order by score desc )
  where  < 2;
  