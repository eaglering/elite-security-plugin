# security-plugin
esd-projects 插件，支持权限角色ip混合校验

```$xslt
/**
 * @RestController()
 *
 * Class Index
 * @package ESD\Plugins\EasyRoute
 */
class Index extends Base
    /**
     * @GetMapping("test")
     * @PreAuthorize("index.test", roles={"super_admin"}, ips={"10.0.0.0/16"})
     * @return string
     */
    public function test () {
        return 'test';
    }
}
```