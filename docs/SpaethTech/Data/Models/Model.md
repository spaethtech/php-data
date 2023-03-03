# Model

Class Model



* Full name: `\SpaethTech\Data\Models\Model`
* Parent class: [AutoObject](../../../../docs.md)



## Methods

### __construct

Model constructor.

```php
public Model::__construct(array $data = []): mixed
```








**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `data` | **array** | An associative array of column name =&gt; value pairs from the database. |


**Return Value:**





---
### buildColumnPropertiesCache

Builds a column => property cache for the calling class.

```php
private static Model::buildColumnPropertiesCache(): mixed
```



* This method is **static**.





**Return Value:**





---
### getColumnName

Compares the provided name to the column => property cache to ensure that both column and property names can be
used in functions requiring only the column name.

```php
private static Model::getColumnName(string $name): string|null
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `name` | **string** | The name of the column or property of which to lookup. |


**Return Value:**

Returns the column name for the column or property name specified.



---
### getTableName



```php
private static Model::getTableName(): string
```



* This method is **static**.





**Return Value:**





---
### getStaticChildClass

Gets the calling child class name or throws a ModelClassException if Model was used directly!

```php
private static Model::getStaticChildClass(): string
```



* This method is **static**.





**Return Value:**

Returns the child class name.



---
### parseTable



```php
private static Model::parseTable(string $table): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** |  |


**Return Value:**





---
### select

Selects all rows from the database as a Collection of Model class objects.

```php
public static Model::select(): \SpaethTech\Collections\Collection
```



* This method is **static**.





**Return Value:**

Returns a Collection of Model objects with populated data from the database.



---
### where

Selects only the matching rows from the database as a Collection of Model class objects.

```php
public static Model::where(string $column, string $operator, mixed $value): \SpaethTech\Collections\Collection
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `column` | **string** | The column name on which to compare. |
| `operator` | **string** | The operator to use for comparison. |
| `value` | **mixed** | The value on which to compare. |


**Return Value:**

Returns a Collection of Model objects with populated data from the database.



---
### insert



```php
public Model::insert(array $columns = []): self
```








**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `columns` | **array** |  |


**Return Value:**





---
### update



```php
public Model::update(array $columns = []): self
```








**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `columns` | **array** |  |


**Return Value:**





---
### getPrimaryKey

Gets the PRIMARY KEY for the specified table.

```php
private static Model::getPrimaryKey(string $table): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** | The table name to inspect. |


**Return Value:**

Returns an array of information pertaining to the PRIMARY KEY of the specified table.



---
### getPrimaryKeyName

Gets the column name of the PRIMARY KEY for the specified table.

```php
private static Model::getPrimaryKeyName(string $table): string
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** | The table name to inspect. |


**Return Value:**

Returns the column name of the PRIMARY KEY of the specified table.



---
### isPrimaryKey

Checks to see if the specified column name for the specified table is a PRIMARY KEY.

```php
private static Model::isPrimaryKey(string $table, string $column): bool
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** | The table name to inspect. |
| `column` | **string** | The column name to inspect. |


**Return Value:**

Returns TRUE if the specified column of the specified table is a PRIMARY KEY, otherwise FALSE.



---
### getForeignKeys

Gets an array of FOREIGN KEY columns for the specified table.

```php
private static Model::getForeignKeys(string $table): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** | The table name to inspect. |


**Return Value:**

Returns an array of information pertaining to the FOREIGN KEYs of the specified table.



---
### getForeignKeysNames

Get an array of the columns names of all FOREIGN KEY columns for the specified table.

```php
private static Model::getForeignKeysNames(string $table): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** | The table name to inspect. |


**Return Value:**

Returns an array of the column names of all FOREIGN KEYs of the specified table.



---
### isForeignKey

Checks to see if the specified column name for the specified table is a FOREIGN KEY.

```php
private static Model::isForeignKey(string $table, string $column): bool
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** | The table name to inspect. |
| `column` | **string** | The column name to inspect. |


**Return Value:**

Returns TRUE if the specified column of the specified table is a FOREIGN KEY, otherwise FALSE.



---
### getNullables

Gets all of the NULL-able columns from the specified table schema.

```php
private static Model::getNullables(string $table): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** | The name of the table for which to inspect. |


**Return Value:**

Returns an associative array of columns that are NULL-able.



---
### getNullableNames

Gets all of the names of NULL-able columns from the specified table schema.

```php
private static Model::getNullableNames(string $table): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** |  |


**Return Value:**





---
### isNullable

Gets the NULL-ability of a column from the specified table schema.

```php
private static Model::isNullable(string $table, string $column): bool
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** | The name of the table for which to inspect. |
| `column` | **string** | The name of the column for which to check. |


**Return Value:**

Returns TRUE if the column is NULL-able, otherwise FALSE.



---
### getColumns

Gets all of the columns from the specified table schema.

```php
private static Model::getColumns(string $table): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** | The name of the table for which to inspect. |


**Return Value:**

Returns an associative array of column name => column schema data.



---
### getColumn



```php
private static Model::getColumn(string $table, string $column): array
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `table` | **string** |  |
| `column` | **string** |  |


**Return Value:**





---
### createProperty



```php
private static Model::createProperty(\Nette\PhpGenerator\ClassType& $class, array $column): \Nette\PhpGenerator\Property
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `class` | **\Nette\PhpGenerator\ClassType** |  |
| `column` | **array** |  |


**Return Value:**





---
### create



```php
public static Model::create(string $directory, string $namespace, string $table): string
```



* This method is **static**.




**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `directory` | **string** |  |
| `namespace` | **string** |  |
| `table` | **string** |  |


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
