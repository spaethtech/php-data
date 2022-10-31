<?php
declare(strict_types=1);

namespace SpaethTech\UCRM\Data\Models;

use SpaethTech\Data\Models\Model;
use SpaethTech\Data\Annotations\TableNameAnnotation as TableName;
use SpaethTech\Data\Annotations\ColumnNameAnnotation as ColumnName;

/**
 * Class General
 *
 * @package SpaethTech\UCRM\Data
 * @author Ryan Spaeth <rspaeth@spaethtech.com>
 * @final
 *
 * @method int|null getGeneralId()
 * @method string|null getCode()
 * @method string|null getValue()
 */
final class General extends Model
{
    /**
     * @var int
     * @ColumnName general_id
     */
    protected $generalId;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $value;

}
