<?php
declare(strict_types=1);

namespace MVQN\UCRM\Data\Models;

use MVQN\Data\Annotations\ColumnNameAnnotation as ColumnName;
use MVQN\Data\Annotations\TableNameAnnotation as TableName;
use MVQN\Data\Models\Model;

/**
 * Class User
 *
 * @package MVQN\UCRM\Data
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 * @final
 *
 * @TableName user
 *
 * @method int getUserId()
 * @method int|null getGroupId()
 * @method string getPassword()
 * @method bool getIsActive()
 * @method string|null getFirstName()
 * @method string|null getLastName()
 * @method string getRole()
 * @method string|null getConfirmationToken()
 * @see    string|null getPasswordRequestedAt()
 * @method string|null getFirstLoginToken()
 * @see    string|null getDeletedAt()
 * @see    string|null getLastLogin()
 * @method int|null getLocaleId()
 * @method string|null getGoogleOauthToken()
 * @method string|null getGoogleCalendarId()
 * @see    string|null getNextGoogleCalendarSynchronization()
 * @method bool getGoogleSynchronizationErrorNotificationSent()
 * @method int|null getUserPersonalizationId()
 * @method string|null getGoogleAuthenticatorSecret()
 * @see    string getBackupCodes()
 * @see    string getCreatedAt()
 * @method string|null getAvatarColor()
 * @method int getTwoFactorFailureCount()
 * @see    string|null getTwoFactorFailureResetAt()
 * @method string|null getFullName()
 * @method string|null getUsername()
 * @method string|null getEmail()
 */
final class User extends Model
{
	/**
	 * @var int
	 * @ColumnName user_id
	 */
	protected $userId;

	/**
	 * @var int|null
	 * @ColumnName group_id
	 */
	protected $groupId;

	/**
	 * @var string
	 */
	protected $password;

	/**
	 * @var bool
	 * @ColumnName is_active
	 */
	protected $isActive;

	/**
	 * @var string|null
	 * @ColumnName first_name
	 */
	protected $firstName;

	/**
	 * @var string|null
	 * @ColumnName last_name
	 */
	protected $lastName;

	/**
	 * @var string
	 */
	protected $role;

	/**
	 * @var string|null
	 * @ColumnName confirmation_token
	 */
	protected $confirmationToken;

	/**
	 * @var string|null
	 * @ColumnName password_requested_at
	 */
	protected $passwordRequestedAt;

	/**
	 * @var string|null
	 * @ColumnName first_login_token
	 */
	protected $firstLoginToken;

	/**
	 * @var string|null
	 * @ColumnName deleted_at
	 */
	protected $deletedAt;

	/**
	 * @var string|null
	 * @ColumnName last_login
	 */
	protected $lastLogin;

	/**
	 * @var int|null
	 * @ColumnName locale_id
	 */
	protected $localeId;

	/**
	 * @var string|null
	 * @ColumnName google_oauth_token
	 */
	protected $googleOauthToken;

	/**
	 * @var string|null
	 * @ColumnName google_calendar_id
	 */
	protected $googleCalendarId;

	/**
	 * @var string|null
	 * @ColumnName next_google_calendar_synchronization
	 */
	protected $nextGoogleCalendarSynchronization;

	/**
	 * @var bool
	 * @ColumnName google_synchronization_error_notification_sent
	 */
	protected $googleSynchronizationErrorNotificationSent;

	/**
	 * @var int|null
	 * @ColumnName user_personalization_id
	 */
	protected $userPersonalizationId;

	/**
	 * @var string|null
	 * @ColumnName google_authenticator_secret
	 */
	protected $googleAuthenticatorSecret;

	/**
	 * @var string
	 * @ColumnName backup_codes
	 */
	protected $backupCodes;

	/**
	 * @var string
	 * @ColumnName created_at
	 */
	protected $createdAt;

	/**
	 * @var string|null
	 * @ColumnName avatar_color
	 */
	protected $avatarColor;

	/**
	 * @var int
	 * @ColumnName two_factor_failure_count
	 */
	protected $twoFactorFailureCount;

	/**
	 * @var string|null
	 * @ColumnName two_factor_failure_reset_at
	 */
	protected $twoFactorFailureResetAt;

	/**
	 * @var string|null
	 * @ColumnName full_name
	 */
	protected $fullName;

	/**
	 * @var string|null
	 */
	protected $username;

	/**
	 * @var string|null
	 */
	protected $email;


	/**
	 * @return \DateTimeImmutable|null
	 * @throws \Exception
	 */
	public function getPasswordRequestedAt()
	{
		return new \DateTimeImmutable($this->passwordRequestedAt);
	}


	/**
	 * @return \DateTimeImmutable|null
	 * @throws \Exception
	 */
	public function getDeletedAt()
	{
		return new \DateTimeImmutable($this->deletedAt);
	}


	/**
	 * @return \DateTimeImmutable|null
	 * @throws \Exception
	 */
	public function getLastLogin()
	{
		return new \DateTimeImmutable($this->lastLogin);
	}


	/**
	 * @return \DateTimeImmutable|null
	 * @throws \Exception
	 */
	public function getNextGoogleCalendarSynchronization()
	{
		return new \DateTimeImmutable($this->nextGoogleCalendarSynchronization);
	}


	/**
	 * @return array
	 */
	public function getBackupCodes()
	{
		return json_decode($this->backupCodes, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}


	/**
	 * @return \DateTimeImmutable
	 * @throws \Exception
	 */
	public function getCreatedAt()
	{
		return new \DateTimeImmutable($this->createdAt);
	}


	/**
	 * @return \DateTimeImmutable|null
	 * @throws \Exception
	 */
	public function getTwoFactorFailureResetAt()
	{
		return new \DateTimeImmutable($this->twoFactorFailureResetAt);
	}
}
