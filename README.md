# travel company

---

## This is an example of the API laravel project. Task is used from

The app will build a company tree with associated travel cost from two remote API endpoints.

-   Process data from the two endpoints to have a nested array of companies with travel cost
-   Travel cost of a particular company is the total travel price of employees in that company and its child companies

---

Open the page http://127.0.01:8000/api/list to see the list of companies

```
http://127.0.01:8000/api/list
```

We should get next response (this is only example)

```
[
  {
    "id": "uuid-1",
    "createdAt": "2021-02-26T00:55:36.632Z",
    "name": "Webprovise Corp",
    "parentId": "0",
    "cost": 52983,
    "children": [
      {
        "id": "uuid-2",
        "createdAt": "2021-02-25T10:35:32.978Z",
        "name": "Stamm LLC",
        "parentId": "uuid-1",
        "cost": 2223,
        "children": [...]
      }
    ]
  }
]
```
