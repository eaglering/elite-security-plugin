<?php
namespace Elite\Plugins\Security\Beans;

class Principal
{
    /**
     * 角色
     * @var string[]
     */
    private $roles = [];

    /**
     * 权限
     * @var string[]
     */
    private $permissions = [];

    /**
     * 用户姓名
     * @var string
     */
    private $username = "";

    public function addRole(string $role)
    {
        $this->roles[] = $role;
    }

    public function addPermissions(string $permissions)
    {
        $this->permissions[] = $permissions;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string|array $roles
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        if (is_string($roles)) $roles = [$roles];
        elseif (!is_array($roles)) return false;
        foreach ($roles as $role) {
            if (in_array($role, $this->roles)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string|array $permissions
     * @return bool
     */
    public function hasAnyPermission($permissions)
    {
        if (is_string($permissions)) $permissions = [$permissions];
        elseif (!is_array($permissions)) return false;
        foreach ($permissions as $permission) {
            if (in_array($permission, $this->permissions)) {
                return true;
            }
        }
        return false;
    }
}