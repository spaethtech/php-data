# Database

Class Database



* Full name: `\SpaethTech\Data\Database`
* This class is marked as **final** and can't be subclassed



## Methods

### connect

Attempts a connection to the database or simply returns an existing connection unless otherwise requested.

```php
public static Database::connect(string $host = &quot;&quot;, int $port, string $dbname = &quot;&quot;, string $user = &quot;&quot;, string $pass = &quot;&quot;, bool $reconnect = false): null|\PDO
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `host` | **string** | The host name where the database exists. |
| `port` | **int** | The port number to which the database connection should be made. |
| `dbname` | **string** | The database name. |
| `user` | **string** | The username with access to the database. |
| `pass` | **string** | The password for the provided username. |
| `reconnect` | **bool** | If TRUE, then forces a new database (re-)connection to be made, defaults to FALSE. |


**Return Value:**

Returns a valid database object for use with future database commands.



---
### query



```php
public static Database::query(string $query, array $params = []): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `query` | **string** |  |
| `params` | **array** |  |


**Return Value:**





---
### select

Issues a SELECT query to the database.

```php
public static Database::select(string $table, array $columns = [], string $orderBy = &quot;&quot;): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** | The table for which to make the query. |
| `columns` | **array** | An optional array of column names to be returned. |
| `orderBy` | **string** | An optional ORDER BY suffix for sorting. |


**Return Value:**

Returns an associative array of rows from the database.



---
### parseTable



```php
private static Database::parseTable(string $table): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** |  |


**Return Value:**





---
### where

Issues a SELECT/WHERE query to the database.

```php
public static Database::where(string $table, string $where = &quot;&quot;, array $columns = [], string $orderBy = &quot;&quot;): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** | The table for which to make the query. |
| `where` | **string** | An optional WHERE clause to use for matching, when omitted a SELECT query is made instead. |
| `columns` | **array** | An optional array of column names to be returned. |
| `orderBy` | **string** | An optional ORDER BY suffix for sorting. |


**Return Value:**

Returns an associative array of matching rows from the database.



---
### insert



```php
public static Database::insert(string $table, array $values, array $columns = []): int
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** |  |
| `values` | **array** |  |
| `columns` | **array** |  |


**Return Value:**





---
### delete



```php
public static Database::delete(string $table, string $where): int
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** |  |
| `where` | **string** |  |


**Return Value:**





---


---
> Automatically generated from source code comments on 2023-03-03 using
> [phpDocumentor](http://www.phpdoc.org/) for [spaethtech/php-monorepo](https://github.com/spaethtech/php-monorepo)

<style>
/* Remove padding and background in <code> used in the structs title */
h2 code,
h3 code,
h4 code,
h5 code {
    background: none !important;
    padding: 0 !important;
}

table {
    width: 100%;
    display: table;
}

thead > tr > th {
    text-align: left;
}

thead > tr > th:first-child {
    width: 20%;
}

/* Remove padding and background in <code> used in the tables */
td code,
th code {
    background: none;
    padding: 0;
}
</style>
