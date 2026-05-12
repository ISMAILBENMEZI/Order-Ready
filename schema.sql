SELECT
    s.name,
    AVG(r.rating) as moyen
FROM
    stores s
    left JOIN products p on p.store_id = s.id
    left join ratings r on r.product_id = p.id
GROUP BY
    s.id,
    s.name