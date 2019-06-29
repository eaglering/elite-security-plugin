<?php
namespace Elite\Plugins\Security\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class PostAuthorize extends Annotation
{
    /**
     * @var array
     */
    public $roles = [];

    /**
     * @var array
     */
    public $ips = [];

    /**
     * @var array
     */
    public $options = [];
}