<?php
declare(strict_types=1);

namespace MVQN\UCRM\Data\Models;

use MVQN\Data\Models\Model;
use MVQN\Data\Annotations\TableNameAnnotation as TableName;
use MVQN\Data\Annotations\ColumnNameAnnotation as ColumnName;

/**
 * Class UserGroup
 *
 * @package MVQN\UCRM\Data
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