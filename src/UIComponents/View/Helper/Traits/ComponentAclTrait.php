<?php
/**
 * BB's Zend Framework 2 Components
 *
 * UI Components
 *
 * @package     [MyApplication]
 * @subpackage  BB's Zend Framework 2 Components
 * @subpackage  UI Components
 * @author      Björn Bartels <coding@bjoernbartels.earth>
 * @link        https://gitlab.bjoernbartels.earth/groups/zf2
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @copyright   copyright (c) 2016 Björn Bartels <coding@bjoernbartels.earth>
 */

namespace UIComponents\View\Helper\Traits;

use Zend\Permissions\Acl\AclInterface;

/**
 *
 * @author bba
 *        
 */
trait ComponentAclTrait {

    /**
     * ACL to use when iterating pages
     *
     * @var Acl\AclInterface
     */
    protected $acl;

    /**
     * ACL role to use when iterating pages
     *
     * @var string|Acl\Role\RoleInterface
     */
    protected $role;

    /**
     * Whether ACL should be used for filtering out pages
     *
     * @var bool
     */
    protected $useAcl = true;

    /**
     * Default ACL to use when iterating pages if not explicitly set in the
     * instance by calling {@link setAcl()}
     *
     * @var Acl\AclInterface
     */
    protected static $defaultAcl;

    /**
     * Default ACL role to use when iterating pages if not explicitly set in the
     * instance by calling {@link setRole()}
     *
     * @var string|Acl\Role\RoleInterface
     */
    protected static $defaultRole;

	/**
     * Sets ACL to use when iterating pages
     *
     * Implements {@link HelperInterface::setAcl()}.
     *
     * @param    Acl\AclInterface $acl ACL object.
     * @return AbstractHelper
     */
    public function setAcl(AclInterface $acl = null)
    {
        $this->acl = $acl;
        return $this;
    }

    /**
     * Returns ACL or null if it isn't set using {@link setAcl()} or
     * {@link setDefaultAcl()}
     *
     * Implements {@link HelperInterface::getAcl()}.
     *
     * @return Acl\AclInterface|null    ACL object or null
     */
    public function getAcl()
    {
        if ($this->acl === null && static::$defaultAcl !== null) {
            return static::$defaultAcl;
        }

        return $this->acl;
    }

    /**
     * Checks if the helper has an ACL instance
     *
     * Implements {@link HelperInterface::hasAcl()}.
     *
     * @return bool
     */
    public function hasAcl()
    {
        if ($this->acl instanceof Acl\Acl
            || static::$defaultAcl instanceof Acl\Acl
        ) {
            return true;
        }

        return false;
    }

	/**
     * Sets ACL role(s) to use when iterating pages
     *
     * Implements {@link HelperInterface::setRole()}.
     *
     * @param    mixed $role [optional] role to set. Expects a string, an
     *                     instance of type {@link Acl\Role\RoleInterface}, or null. Default
     *                     is null, which will set no role.
     * @return AbstractHelper
     * @throws Exception\InvalidArgumentException
     */
    public function setRole($role = null)
    {
        if (null === $role || is_string($role) ||
            $role instanceof Acl\Role\RoleInterface
        ) {
            $this->role = $role;
        } else {
            throw new Exception\InvalidArgumentException(sprintf(
                '$role must be a string, null, or an instance of '
                . 'Zend\Permissions\Role\RoleInterface; %s given',
                (is_object($role) ? get_class($role) : gettype($role))
            ));
        }

        return $this;
    }

    /**
     * Returns ACL role to use when iterating pages, or null if it isn't set
     * using {@link setRole()} or {@link setDefaultRole()}
     *
     * Implements {@link HelperInterface::getRole()}.
     *
     * @return string|Acl\Role\RoleInterface|null
     */
    public function getRole()
    {
        if ($this->role === null && static::$defaultRole !== null) {
            return static::$defaultRole;
        }

        return $this->role;
    }

    /**
     * Checks if the helper has an ACL role
     *
     * Implements {@link HelperInterface::hasRole()}.
     *
     * @return bool
     */
    public function hasRole()
    {
        if ($this->role instanceof Acl\Role\RoleInterface
            || is_string($this->role)
            || static::$defaultRole instanceof Acl\Role\RoleInterface
            || is_string(static::$defaultRole)
        ) {
            return true;
        }

        return false;
    }

    /**
     * Sets whether ACL should be used
     *
     * Implements {@link HelperInterface::setUseAcl()}.
     *
     * @param    bool $useAcl
     * @return AbstractHelper
     */
    public function setUseAcl($useAcl = true)
    {
        $this->useAcl = (bool) $useAcl;
        return $this;
    }

    /**
     * Returns whether ACL should be used
     *
     * Implements {@link HelperInterface::getUseAcl()}.
     *
     * @return bool
     */
    public function getUseAcl()
    {
        return $this->useAcl;
    }

    // Static methods:

    /**
     * Sets default ACL to use if another ACL is not explicitly set
     *
     * @param    Acl\AclInterface $acl [optional] ACL object. Default is null, which
     *                        sets no ACL object.
     * @return void
     */
    static function setDefaultAcl(Acl\AclInterface $acl = null)
    {
        static::$defaultAcl = $acl;
    }

    /**
     * Sets default ACL role(s) to use when iterating pages if not explicitly
     * set later with {@link setRole()}
     *
     * @param    mixed $role [optional] role to set. Expects null, string, or an
     *                     instance of {@link Acl\Role\RoleInterface}. Default is null, which
     *                     sets no default role.
     * @return void
     * @throws Exception\InvalidArgumentException if role is invalid
     */
    public function setDefaultRole($role = null)
    {
        if (null === $role
            || is_string($role)
            || $role instanceof Acl\Role\RoleInterface
        ) {
            static::$defaultRole = $role;
        } else {
            throw new Exception\InvalidArgumentException(sprintf(
                '$role must be null|string|Zend\Permissions\Role\RoleInterface; received "%s"',
                (is_object($role) ? get_class($role) : gettype($role))
            ));
        }
    }

}

?>