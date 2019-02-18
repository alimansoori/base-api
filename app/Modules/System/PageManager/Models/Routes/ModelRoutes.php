<?php
namespace Modules\System\PageManager\Models\Routes;


use Lib\Events\Router\BeforeCheckRoutes;
use Lib\Mvc\Model;
use Lib\Mvc\Router;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Mvc\RouterInterface;

class ModelRoutes extends Model
{
    use TModelRoutesProperties;
    use TModelRoutesRelations;
    use TModelRoutesValidation;
    use TModelRoutesEvents;
    use TModelRoutesQueries;

    public function init()
    {
        $this->setSource('routes');
        $this->setDbRef(true);
    }

    public function getPaths()
    {
        $paths = [];

        if($this->getModule())
            $paths['module'] = $this->getModule();
        if($this->getController())
            $paths['controller'] = $this->getController();
        if($this->getAction())
            $paths['action'] = $this->getAction();
        if($this->getParams())
            $paths['params'] = $this->getParams();
        if($this->getNamespace())
            $paths['namespace'] = $this->getNamespace();
        if($this->getInt())
            $paths['int'] = $this->getInt();

        return $paths;
    }

    /**
     * @param RouterInterface|Router $router
     * @uses BeforeCheckRoutes
     */
    public static function setApplicationRoutes(RouterInterface $router)
    {
        // منقضی شد
        
        /** @var ModelRoutes[] $routes */
        $routes = self::find([
            'conditions' => 'language_iso=:lang:',
            'bind' => [
                'lang' => ModelLanguage::getCurrentLanguage()
            ]
        ]);

        foreach($routes as $route)
        {
            $router->addSingleLanguage(
                $route->getPattern(),
                $route->getPaths(),
                $route->getId(),
                $route->getLanguageIso(),
                $route->getHttpMethods() ? explode(',', $route->getHttpMethods()) : null
            );
        }
    }
}