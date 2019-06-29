<?php
namespace Elite\Plugins\Security;

use ESD\Core\Context\Context;
use ESD\Core\PlugIn\AbstractPlugin;
use ESD\Core\PlugIn\PluginInterfaceManager;
use ESD\Plugins\Aop\AopConfig;
use ESD\Plugins\Aop\AopPlugin;
use Elite\Plugins\Security\Aspect\SecurityAspect;
use ESD\Plugins\Session\SessionPlugin;

class SecurityPlugin extends AbstractPlugin
{
    /**
     * @var SecurityConfig|null
     */
    private $securityConfig;

    /**
     * 获取插件名字
     * @return string
     */
    public function getName(): string
    {
        return "Security";
    }

    /**
     * CachePlugin constructor.
     * @param SecurityConfig|null $securityConfig
     */
    public function __construct(?SecurityConfig $securityConfig = null)
    {
        parent::__construct();
        $this->atAfter(AopPlugin::class);
        $this->atAfter(SessionPlugin::class);
        if ($securityConfig == null) {
            $securityConfig = new SecurityConfig();
        }
        $this->securityConfig = $securityConfig;
    }

    /**
     * @param PluginInterfaceManager $pluginInterfaceManager
     * @return mixed|void
     * @throws \ESD\Core\Exception
     * @throws \ReflectionException
     */
    public function onAdded(PluginInterfaceManager $pluginInterfaceManager)
    {
        parent::onAdded($pluginInterfaceManager);
        $pluginInterfaceManager->addPlug(new AopPlugin());
        $pluginInterfaceManager->addPlug(new SessionPlugin());
    }


    /**
     * @param Context $context
     * @return mixed|void
     * @throws \ESD\Core\Plugins\Config\ConfigException
     * @throws \ReflectionException
     */
    public function init(Context $context)
    {
        parent::init($context);
        $this->securityConfig->merge();
        $aopConfig = DIget(AopConfig::class);
        $aopConfig->addAspect(new SecurityAspect());
    }

    /**
     * 在服务启动前
     * @param Context $context
     * @return mixed|void
     * @throws \ESD\Core\Plugins\Config\ConfigException
     * @throws \ReflectionException
     */
    public function beforeServerStart(Context $context)
    {
        $this->securityConfig->merge();
    }

    /**
     * 在进程启动前
     * @param Context $context
     * @return mixed|void
     */
    public function beforeProcessStart(Context $context)
    {
        $this->ready();
    }
}