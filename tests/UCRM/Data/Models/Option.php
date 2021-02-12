<?php
declare(strict_types=1);

namespace rspaeth\UCRM\Data\Models;

use rspaeth\Data\Models\Model;
use rspaeth\Data\Annotations\TableNameAnnotation as TableName;
use rspaeth\Data\Annotations\ColumnNameAnnotation as ColumnName;

/**
 * Class Option
 *
 * @package rspaeth\UCRM\Data
 * @author Ryan Spaeth <rspaeth@mvqn.net>
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