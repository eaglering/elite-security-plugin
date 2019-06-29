<?php
namespace Elite\Plugins\Security;

use ESD\Core\Plugins\Config\BaseConfig;

class SecurityConfig extends BaseConfig
{
    const key = "security";

    /**
     * @var array
     */
    protected $includeRoles = [];

    /**
     * @var array
     */
    protected $includeIps = [];

    public function __construct()
    {
        parent::__construct(self::key);
    }

    /**
     * @return array
     */
    public function getIncludeRoles(): array
    {
        return $this->includeRoles;
    }

    /**
     * @param array $includeRoles
     */
    public function setIncludeRoles(array $includeRoles): void
    {
        $this->includeRoles = $includeRoles;
    }

    /**
     * @return array
     */
    public function getIncludeIps(): array
    {
        return $this->includeIps;
    }

    /**
     * @param array $includeIps
     */
    public function setIncludeIps(array $includeIps): void
    {
        $this->includeIps = $includeIps;
    }

}