# TableNameAnnotation

Class TableNameAnnotation



* Full name: `\SpaethTech\Data\Annotations\TableNameAnnotation`
* Parent class: [Annotation](../../../../docs.md)
* This class is marked as **final** and can't be subclassed



## Constants

| Constant | Type | Value |
|:---------|:-----|:------|
|`\SpaethTech\Data\Annotations\TableNameAnnotation::SUPPORTED_TARGETS`||\SpaethTech\Annotations\Annotation::TARGET_CLASS|
|`\SpaethTech\Data\Annotations\TableNameAnnotation::SUPPORTED_DUPLICATES`||false|

## Methods

### parse



```php
public TableNameAnnotation::parse(array $existing = []): array
```








**Parameters:**

| Parameter  | Type  | Description  |
|:-----------|:------|:-------------|
| `existing` | **array** | Any existing annotations that were previously parsed from the same declaration. |


**Return Value:**

Returns an array of keyword => value(s) parsed by this Annotation implementation.



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
