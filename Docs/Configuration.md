# Configuration

The configuration is available from the `rich_id_tour.yaml` file. Here is a sample of configuration:

```yaml
rich_id_tour:
    user_class: App\Entity\DummyUser
    tours:
        my_first_tour:
            storage: cookie
            duration: '+6 months'
        my_second_tour:
            storage: local_storage
        my_third_tour:
            storage: database
```

The following table describes all entries.

| Key                     | Required | Type                            | Description                                                                                             |
| ---                     | ---      | ---                             | ---                                                                                                     |
| `user_class`            | x        | string                          | The user class must implement the `UserTourInterface`                                                   |
| `tours`                 |          | object[]                        | The list of available tours                                                                             |
| `tours.<name>`          |          | string                          | Name of the tour                                                                                        |
| `tours.<name>.storage`  |  x       | `cookie|local_storage|database` | The method used to store if the user saw the tour                                                       |
| `tours.<name>.duration` |          | string                          | Used only for the cookie storage. Sets the lifetime of the cookie. Must be a PHP DateTime valid string. |

