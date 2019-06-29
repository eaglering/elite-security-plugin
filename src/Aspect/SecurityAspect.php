<?php
namespace Elite\Plugins\Security\Aspect;

use Elite\Plugins\Security\GetSecurity;
use Elite\Plugins\Security\SecurityConfig;
use ESD\Plugins\Aop\OrderAspect;
use Elite\Plugins\Security\AccessDeniedException;
use Elite\Plugins\Security\Annotation\PostAuthorize;
use Elite\Plugins\Security\Annotation\PreAuthorize;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;

class SecurityAspect extends OrderAspect
{
    use GetSecurity;

    /**
     * @param MethodInvocation $invocation Invocation
     *
     * @Around("@execution(Eaglering\Plugins\Security\Annotation\PostAuthorize)")
     * @return mixed
     * @throws AccessDeniedException
     */
    public function aroundPostAuthorize(MethodInvocation $invocation)
    {
        /** @var PostAuthorize $postAuthorize */
        $postAuthorize = $invocation->getMethod()->getAnnotation(PostAuthorize::class);
        $returnObject = $invocation->proceed();
        /** @var SecurityConfig $securityConfig */
        $securityConfig = DIGet(SecurityConfig::class);
        $roles = array_merge($securityConfig->getIncludeRoles(), $postAuthorize->roles);
        if ($this->hasAnyPermission($postAuthorize->value)
            || ($roles && $this->hasAnyRole($postAuthorize->roles))) {
            $ips = array_merge($securityConfig->getIncludeIps(), $postAuthorize->ips);
            if ($ips && !$this->hasIpAddress($postAuthorize->ips)) {
                throw new AccessDeniedException();
            }
            return $returnObject;
        }
        throw new AccessDeniedException();
    }

    /**
     * @param MethodInvocation $invocation Invocation
     *
     * @Around("@execution(Eaglering\Plugins\Security\Annotation\PreAuthorize)")
     * @return mixed
     * @throws AccessDeniedException
     */
    public function aroundPreAuthorize(MethodInvocation $invocation)
    {
        $preAuthorize = $invocation->getMethod()->getAnnotation(PreAuthorize::class);
        /** @var SecurityConfig $securityConfig */
        $securityConfig = DIGet(SecurityConfig::class);
        $roles = array_merge($securityConfig->getIncludeRoles(), $preAuthorize->roles);
        if ($this->hasAnyPermission($preAuthorize->value)
            || ($roles && $this->hasAnyRole($preAuthorize->roles))) {
            $ips = array_merge($securityConfig->getIncludeIps(), $preAuthorize->ips);
            if ($ips && !$this->hasIpAddress($preAuthorize->ips)) {
                throw new AccessDeniedException();
            }
            return $invocation->proceed();
        }
        throw new AccessDeniedException();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'SecurityAspect';
    }
}