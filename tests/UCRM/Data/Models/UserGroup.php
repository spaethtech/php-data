<?php
declare(strict_types=1);

namespace rspaeth\UCRM\Data\Models;

use rspaeth\Data\Models\Model;
use rspaeth\Data\Annotations\TableNameAnnotation as TableName;
use rspaeth\Data\Annotations\ColumnNameAnnotation as ColumnName;

/**
 * Class UserGroup
 *
 * @package rspaeth\UCRM\Data
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 * @final
 *
 * @method int|null getGeneralId()
 * @method string|null getCode()
 * @method string|null getValue()
 */
final class UserGroup extends Model
{
    /**
     * @var int
     * @ColumnName group_id
     */
    protected $groupId;

    /**
     * @var string
     */
    protected $name;

}