# task-api

## API Reference

#### Create array of length `size` with random elements

```http
  POST /api/tasks
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `size` | `int` | **Required**. Your array size |

#### Get task

```http
  GET /api/tasks/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of item to fetch |

## Running Tests

To run tests, run the following command

```bash
  php artisan test
```
