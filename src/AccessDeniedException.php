<?php
namespace Elite\Plugins\Security;

use ESD\Core\Exception;

class AccessDeniedException extends Exception
{
    public function __construct()
    {
        parent::__construct("没有相应权限", 403, null);
        $this->setTrace(false);
    }
}