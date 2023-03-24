Рекурсивный CTE в mysql
```sql
with recursive cte (id) as (
  select id
  from category
        where alias = 'dolorem-totam'

  union all

  select c.id
    from category as c
    inner join cte
        on c.parent_id = cte.id
)
select * from products where category_id in (select * from cte);
```