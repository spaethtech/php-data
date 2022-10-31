<?php
declare(strict_types=1);

namespace SpaethTech\UCRM\Data\Models;

use SpaethTech\Data\Models\Model;
use SpaethTech\Data\Annotations\TableNameAnnotation as TableName;
use SpaethTech\Data\Annotations\ColumnNameAnnotation as ColumnName;

/**
 * Class Option
 *
 * @package SpaethTech\UCRM\Data
 * @author Ryan Spaeth <rspaeth@spaethtech.com>
 * @final
 *
 * @TableName option
 *
 * @method int|null getOptionId()
 * @method string|null getCode()
 * @method string|null getValue()
 */
final class Option extends Model
{
    /**
     * @var int
     * @ColumnName option_id
     */
    protected $optionId;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $value;

}
