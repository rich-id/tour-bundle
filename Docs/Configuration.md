# Configuration

The configuration can be edited from the `rich_id_tour.yaml` file. Here is a sample of configuration:

```yaml
rich_id_tour:
    user_class: App\Entity\DummyUser
    user_tours:
        - my_first_tour
```

The following list gives more precisions about the configuration:

- `user_class`

Your User class that muist be implements UserTourInterface


- `user_tours`

This is a list of available tours that you define
