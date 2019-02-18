<?php
namespace Lib\Acl;


use Lib\Events\Acl\AfterCheckAccess;
use Lib\Events\Acl\BeforeCheckAccess;
use Phalcon\Loader;
use Lib\Module\ModuleManager;
use Lib\Translate\T;
use Modules\System\PageManager\Models\PageRoleMap\ModelPageRoleMap;
use Modules\System\PageManager\Models\Pages\ModelPages;
use Modules\System\Permission\Models\ModelRoleResourceMap;
use Modules\System\Permission\Models\ModelRoles;
use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Events\Event;
use Phalcon\Events\ManagerInterface;
use Phalcon\Acl\Resource;
use Phalcon\Text;

abstract class AbstractAcl extends Memory
{
    public function __construct()
    {
        parent::__construct();

        $this->setDefaultAction(
            Acl::DENY
        );

        $this->setAdmin();
        $this->addResources();
        $this->addRolesAndAllow();
    }

    protected function setAdmin()
    {
        $adminRole = new Role('admin', T::_('admin_role'));

        $this->addRole($adminRole);

        $this->allow('admin', '*', '*');
    }

    protected function addResources()
    {
        /** @var ModelPages[] $pages */
        $pages = ModelPages::find([
            'conditions' => 'status=:status:',
            'bind' => [
                'status' => 'active'
            ]
        ]);

        foreach($pages as $page)
        {
            $this->addResource(new Resource($page->getId()), '*');
        }
    }

    protected function addRolesAndAllowFromModule()
    {
        /** @var ModelRoles[] $roles */
        $roles = ModelRoles::findAllExceptByName('admin');

        foreach($roles as $role)
        {
            /** @var ModelRoleResourceMap[] $resources */
            $resources = $role->getRoleResourceMaps();

            foreach($resources as $resource)
            {
                if($resource->getStatus() == 'allow')
                {
                    $this->allow(
                        $role->getName(),
                        $resource->getResource()->getModule()->getNamespace(). '\\Controllers\\'. Text::camelize($resource->getResource()->getController(), '_-').'Controller'.$resource->getResource()->getAction(),
                        $resource->getResource()->getAction()
                    );
                }
                else
                {
                    $this->deny($role->getName(),
                        $resource->getResource()->getModule()->getNamespace(). '\\Controllers\\'. Text::camelize($resource->getResource()->getController(), '_-').'Controller'.$resource->getResource()->getAction(),
                        $resource->getResource()->getAction()
                    );
                }
            }
        }
    }

    protected function addRolesAndAllow()
    {
        /** @var ModelRoles[] $roles */
        $roles = ModelRoles::findAllExceptByName('admin');

        foreach($roles as $role)
        {
            $this->addRole(
                new Role($role->getName(), $role->getDescription())
            );

            /** @var ModelPageRoleMap[] $resources */
            $resources = $role->getPageRoleMaps();

            foreach($resources as $resource)
            {
                // later check if exist resource after allow
                $this->allow($role->getName(), $resource->getPageId(), '*');
            }
        }
    }

    /**
     * The task is to add Controllers Array to resources for ACL
     *
     * @param array $controllers
     */
    public function addResourcesForControllerClass( $controllers )
    {
        foreach($controllers as $controller)
        {
            foreach(ModuleManager::getAllActions($controller) as $action)
            {
                $this->addResource(new Resource($controller.$action), $action);
            }
        }
    }

    public function setEvents()
    {
        $eventManager = $this->getEventsManager();
        if(!$eventManager instanceof ManagerInterface)
            return false;

        $eventManager->attach('acl:afterCheckAccess', function(Event $event, Memory $acl) {
            new AfterCheckAccess($event, $acl);
        });

        $eventManager->attach('acl:beforeCheckAccess', function(Event $event, Memory $acl) {
            new BeforeCheckAccess($event, $acl);
        });
    }
}