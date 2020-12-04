# 2DV513

1189.6478948593

2174.496931076

15min

8min

1.  SELECT author, COUNT(author) AS comments\
    FROM post\
    WHERE author = '`username`'

    Replace `username`.

2.  SELECT s.name, (COUNT(p.subreddit_id) / 31) as comments_per_day\
    FROM post AS p\
    JOIN subreddit s ON (p.subreddit_id = s.id\
    WHERE s.name = '`subreddit name`'

    Replace `subreddit name`.

3.  SELECT COUNT(id) as comments_including_lol\
    FROM post\
    WHERE body LIKE '%lol%'

4.  SELECT DISTINCT s.name\
    FROM post p1\
    JOIN subreddit s ON (p1.subreddit_id = s.id)\
    WHERE p1.author IN (SELECT p2.author\
    FROM post p2\
    WHERE p2.link_id = '`link_id`')

    Replace `link_id`.

5.  (SELECT author, SUM(score) as total_score\
    FROM post\
    WHERE author != '[deleted]'\
    GROUP BY author\
    ORDER BY total_score DESC\
    LIMIT 1)\
    UNION\
    (SELECT author, SUM(score) as total_score\
    FROM post\
    WHERE author != '[deleted]'\
    GROUP BY author\
    ORDER BY total_score ASC\
    LIMIT 1)

6.  (SELECT s.name, p.score\
    FROM post p\
    JOIN subreddit s ON (p.subreddit_id = s.id)\
    ORDER BY p.score DESC\
    LIMIT 1)\
    UNION\
    (SELECT s.name, p.score\
    FROM post p\
    JOIN subreddit s ON (p.subreddit_id = s.id)\
    ORDER BY p.score ASC\
    LIMIT 1)

7.  SELECT p2.author\
    FROM post p1, post p2\
    WHERE p1.author = '`username`'\
    AND p1.link_id = p2.link_id\
    AND p2.author != '`username`'\
    AND p2.author != '[deleted]'\
    GROUP BY p2.author

    Replace `username`.

8.  SELECT author\
    FROM post\
    WHERE author != '[deleted]'\
    GROUP BY author\
    HAVING COUNT(subreddit_id) = 1
