<?php
namespace Lib\Di;


use Ilya\Services;
use Lib\Acl\AbstractAcl;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Component;
use Phalcon\Text;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

class ModuleServices extends Component
{
    private $namespace;
    private $path;
    private $moduleName;

    public function __construct($path, $namespace = null)
    {
        $this->path = $path;

        $this->namespace = $namespace;

        $this->moduleName = Text::uncamelize(basename(($this->path)), '-');
        $this->getDI()->setShared('config', $this->setConfig($path));

        $this->bindServices();
    }

    protected function setConfig($path)
    {
        $coreConfig = $this->getDI()->getShared('config');

        $defaultConfig = new Config([
            'module' => [
                'name' => $this->moduleName,
                'path' => $this->path,
                'namespace' => $this->namespace,
            ]
        ]);

        /** @var Config $coreConfig */
        $coreConfig = $coreConfig->merge($defaultConfig);
        if(file_exists($path. '/config/config.php'))
        {
            $moduleConfig = require_once $path. '/config/config.php';

            /** @var Config $coreConfig */
            $coreConfig['module'] = $coreConfig['module']->merge($moduleConfig);
        }

        return $coreConfig;
    }

    private function bindServices()
    {
//        $this->getDI()->setShared('acl', $this->setAcl());
        $this->getDI()->setShared('dispatcher', $this->setDispatcher());
        $this->getDI()->setShared('modelManager', $this->setModelManager());
        $this->getDI()->setShared('tConfig', $this->setTConfig());
        $this->getDI()->setShared('view', $this->setView());

        if(
            isset($this->config->module->database) &&
            isset($this->config->module->database->host) &&
            isset($this->config->module->database->username) &&
            isset($this->config->module->database->password) &&
            isset($this->config->module->database->dbname) &&
            isset($this->config->module->database->adapter)
        )
        {
            $dbModuleName = 'db'. ucfirst($this->config->module->name);
            $this->getDI()->set($dbModuleName, $this->setDbModule($dbModuleName));
        }

        $this->getDI()->set('moduleTransaction', $this->setTransactions());

        foreach (get_class_methods($this) as $method)
        {
            $this->condForUseSetOrSetSharedMethod($method);
        }

    }

    protected function setTConfig()
    {
        /** @var Config $tConfig */
        $tConfig = $this->getDI()->getShared('tConfig');

        $lang = ModelLanguage::getCurrentLanguage();

        $langJsonFile = $this->path. '/config/lang/'. $lang. '.json';
        $langPhpFile = $this->path. '/config/lang/'. $lang. '.php';

        $defLangJsonFile = $this->path. '/config/lang/en.php';
        $defLangPhpFile = $this->path. '/config/lang/en.php';

        if(file_exists($langJsonFile))
        {
            return $tConfig->merge(
                new Config\Adapter\Json($langJsonFile)
            );
        }
        elseif(file_exists($langPhpFile))
        {
            return $tConfig->merge(
                new Config\Adapter\Php($langPhpFile)
            );
        }
        elseif(file_exists($defLangJsonFile))
        {
            return $tConfig->merge(
                new Config\Adapter\Json($defLangJsonFile)
            );
        }
        elseif(file_exists($defLangPhpFile))
        {
            return $tConfig->merge(
                new Config\Adapter\Php($defLangPhpFile)
            );
        }

        return $tConfig;
    }

    protected function setTransactions()
    {
        /** @var \Phalcon\Mvc\Model\Transaction\Manager $transactions */
        $transactions = new TransactionManager();

        $config = $this->getDI()->getShared('config');
        if(isset($config->module->database->connection))
        {
            $transactions->setDbService(
                $config->module->database->connection
            );
        }

        return $transactions;
    }

    protected function setDispatcher()
    {
        /** @var Dispatcher $dispatcher */
        $dispatcher = $this->getDI()->getShared('dispatcher');

        /** @var Manager $eventManager */
        $eventManager = $this->getDI()->getShared('eventsManager');

        $dispatcher->setEventsManager($eventManager);
        $dispatcher->setDefaultNamespace($this->namespace. '\Controllers\\');
        return $dispatcher;
    }

    protected function setModelManager()
    {
        /** @var \Lib\Mvc\Model\Manager $modelsManager */
        $modelsManager = $this->getDI()->getShared('modelsManager');

        $config = $this->getDI()->getShared('config');
        if(isset($config->module->database->prefix))
        {
            $modelsManager->setModelPrefix($config->module->database->prefix);
        }

        return $modelsManager;
    }

    protected function setAcl()
    {
        /** @var AbstractAcl $acl */
        $acl = $this->getDI()->getShared( 'acl' );

//        $aclPath = $this->path. '/config/acl.php';

//        $controllers = ModuleManager::getAllControllers($this->path, $this->namespace);

//        $acl->addResourcesForControllerClass($controllers);

//        if(!file_exists($aclPath))
//        {
//            return $acl;
//        }

//        $resources = require_once $aclPath;

//        $acl->addRolesAndAllow($resources, $this->namespace);
//        $acl->addRolesAndAllowFromModule();

        return $acl;
    }

    private function setView()
    {
        $view = $this->getDI()->getShared('view');
        $view->setViewsDir($this->path. '/views/');
        return $view;
    }

    private function setDbModule($dbModuleName)
    {

        $dbConf = $this->config->module->database->toArray();

        $adapter = 'Phalcon\Db\Adapter\Pdo\\'.$dbConf['adapter'];
        unset($dbConf['adapter']);

//        $conn = mysqli_connect($this->config->module->database->host, $this->config->module->database->username, $this->config->module->database->password);

//        if(! $conn ) {
//            throw new \Exception('Could not connect: ' . mysqli_error());
//        }

        $dbName = $dbConf['dbname'];
        $sql = "CREATE DATABASE IF NOT EXISTS `$dbName`";

//        $retval = mysqli_query( $conn, $sql );

//        if(! $retval ) {
//            throw new \Exception('Could not create database: ' . mysqli_error());
//        }
//
//        mysqli_close($conn);

        /** @var Mysql $connection */
        $connection = new $adapter($dbConf);

        $this->config->module->database->connection = $dbModuleName;
        return $connection;
    }

    protected function condForUseSetOrSetSharedMethod($method)
    {
        if (Text::startsWith($method, 'initShared'))
        {
            $this->getDI()->setShared(lcfirst(substr($method, 10)), $this->$method());
        }
        elseif (Text::startsWith($method, 'init'))
        {
            $this->getDI()->set(lcfirst(substr($method, 4)), $this->$method());
        }
    }

    /**
     * Summary Function isMethodNameStart
     *
     * Description Function isMethodNameStart
     *
     * @author Ali Mansoori
     * @copyright Copyright (c) 2017-2018, ILYA-IDEA Company
     * @param $name
     * @param $maxLenght
     * @param $needle
     * @return bool
     * @version 1.0.0
     * @example Desc <code></code>
     */
    protected function isMethodNameStart($name, $maxLenght, $needle)
    {
        if ((strlen($name) > $maxLenght) && (strpos($name, $needle) === 0))
        {
            return true;
        }

        return false;
    }


}