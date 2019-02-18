<?php
namespace Ilya;

use Lib\Acl\DefaultAcl;
use Lib\Assets\Collection;
use Lib\Authenticates\JWT;
use Lib\Common\MobileDetect;
use Lib\Contents\ContentBuilder;
use Lib\Debug;
use Lib\Di\FactoryDefault;
use Lib\Filter;
use Lib\Flash\Session;
use Lib\Http\Response;
use Lib\Mvc\Helper;
use Modules\System\Users\Models\ModelUsers;
use Phalcon\Mvc\View;
use Lib\Assets\Minify\CSS;
use Lib\Assets\Minify\JS;
use Lib\Tag;
use Lib\Translate\Adapter\NativeArray;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Cache\Backend\Memcache;
use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Config;
use Phalcon\Config\Adapter\Json;
use Phalcon\Crypt;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Db\Dialect\MysqlExtended;
use Phalcon\Events\Manager;
use Lib\Mvc\Dispatcher;
use Phalcon\Registry;
use Phalcon\Security;
use Phalcon\Session\Adapter\Files;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

class Services extends FactoryDefault
{
    public function initSharedRegistry()
    {
        return new Registry();
    }

    public function initSharedEventsManager()
    {
        return new Manager();
    }

    public function initUrl()
    {
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri($this->getShared('config')->app->baseUri);
        $url->setStaticBaseUri($this->getShared('config')->app->baseUri);
        $url->setBasePath($this->getShared('config')->app->baseUri);
        return $url;
    }

    public function initSharedContent()
    {
        return ContentBuilder::instantiate();
    }

    public function initSharedAssets()
    {
        $assets = new \Lib\Assets\Manager();

        $assets->collection('head');

        $assets->collection('body');

        return $assets;
    }

    public function initSharedAssetsCollection()
    {
        $assetsCollection = new Collection();
        return $assetsCollection;
    }

    public function initSharedAssetsWidgets()
    {
        $assetsWidgets = new Collection();
        return $assetsWidgets;
    }

    public function initSharedView()
    {
        $view = new View();

        $view->disable();

        return $view;
    }

    public function initSharedResponse()
    {
        return new Response();
    }

    public function initSharedDb()
    {
        $dbConf = $this->getShared('config')->database->toArray();
        $dbConf['dialectClass'] = MysqlExtended::class;

        $adapter = 'Phalcon\Db\Adapter\Pdo\\'. $dbConf['adapter'];
        unset($dbConf['adapter']);

        /** @var Mysql $connection */
        $connection = new $adapter($dbConf);

        /** @var Manager $eventManager */
        $eventManager = $this->getShared('eventsManager');

        $connection->setEventsManager($eventManager);
        return $connection;
    }

    public function initSharedHelper()
    {
        return new Helper();
    }

    public function initFlash()
    {
        return new Session();
    }

    public function initSharedSession()
    {
        $session = new Files();
        $session->start();
        return $session;
    }

    public function initSharedCrypt()
    {
        $crypt = new Crypt();
        $crypt->setCipher('aes-256-ctr');
        $crypt->setKey($this->getShared('config')->app->cryptSalt);
        return $crypt;
    }

    public function initSharedCssmin()
    {
        $cssMin = new CSS();
        return $cssMin;
    }

    public function initSharedJsmin()
    {
        $jsMin = new JS();
        return $jsMin;
    }

//    public function initUploader()
//    {
//        $uploader = new Uploader();
//
//        $uploader->setRules([
//            'directory' => BASE_PATH.'data/files/',
//            'minsize' => 1000,
//            'maxsize' => 10000000, // 10 MB
//            'mimes'   => [
//                'image/jpeg',
//                'image/png'
//            ],
//            'extensions' => [
//                'jpeg',
//                'jpg',
//                'png'
//            ],
//            'sanitize' => true,
//            'hash' => 'md5'
//        ]);
//        return $uploader;
//    }

    public function initSecurity()
    {
        return new Security();
    }

    public function initSharedFilter()
    {
        return new Filter();
    }

    public function initCache()
    {
        return $this->getCache();
    }

    public function initSharedModelsCache()
    {
        return $this->getCache();
    }

    private function getCache()
    {
        $config = $this->getShared('config');
        $frontendCache = new FrontData([
            'lifetime' => 86400,
            'prefix'   => HOST_HASH
        ]);

        $cache = null;

        switch($config->cache)
        {
            case "file":
                $cache = new File($frontendCache, [
                    'cacheDir' => BASE_PATH. 'data/cache/backend/'
                ]);
                break;
            case "memcache":
                $cache = new Memcache(
                    $frontendCache,
                    [
                        'host' => $config->memcache->host,
                        'port' => $config->memcache->port,
                    ]
                );
                break;
            case "memcached":
                $cache = new Libmemcached(
                    $frontendCache,
                    [
                        'host' => $config->memcache->host,
                        'port' => $config->memcache->port,
                    ]
                );
                break;
        }

        return $cache;
    }

    public function initSharedDevice()
    {
        $detect = new MobileDetect();
        return $detect;
    }

    public function initSharedAuth()
    {
        $sessionAuth = new JWT(
            ModelUsers::class,
            'username',
            'email',
            'password',
            'id'
        );
        return $sessionAuth;
    }

    public function initSharedAcl()
    {
        $acl = new DefaultAcl();

        $acl->setEventsManager($this->getShared('eventsManager'));
        $acl->setEvents();

        return $acl;
    }

    public function initSharedTag()
    {
        return new Tag();
    }

    public function initSharedForms()
    {
        return new \Lib\Forms\Manager();
    }

    public function initSharedDispatcher()
    {
        $di = $this;
        $dispatcher = new Dispatcher();

        $eventManager = $this->getShared('eventsManager');

//        $eventManager->attach('dispatch:beforeException', new NotFoundPlugin());

        $dispatcher->setEventsManager($this->getShared('eventsManager'));
        $dispatcher->setEvents();

        return $dispatcher;
    }

    public function initTransactions()
    {
        return (new TransactionManager())->get();
    }

    public function initSharedModelsManager()
    {
        $manager = new \Lib\Mvc\Model\Manager();

        if($this->getShared('config')->database->prefix)
            $manager->setModelPrefix($this->getShared('config')->database->prefix);

        return $manager;
    }

    public function initDebug()
    {
        return new Debug();
    }

    /**
     * Run in end application
     */
    public function afterInitDebug()
    {
        /** @var Debug $debug */
        $debug = $this[ 'debug'];
        $debug->listen();
    }

    // after dispatcher
    public function initSharedTConfig()
    {
        $lang = ModelLanguage::getCurrentLanguage();

        $langJsonFile = APP_PATH. 'config/lang/'. $lang. '.json';
        $langPhpFile = APP_PATH. 'config/lang/'. $lang. '.php';

        $defLangJsonFile = APP_PATH. 'config/lang/en.php';
        $defLangPhpFile = APP_PATH. 'config/lang/en.php';

        if(file_exists($langJsonFile))
        {
            return new Json($langJsonFile);
        }
        elseif(file_exists($langPhpFile))
        {
            return new Config\Adapter\Php($langPhpFile);
        }
        elseif(file_exists($defLangJsonFile))
        {
            return new Json($defLangJsonFile);
        }
        elseif(file_exists($defLangPhpFile))
        {
            return new Config\Adapter\Php($defLangPhpFile);
        }

        return new Config([]);
    }

    public function initSharedT()
    {
        /** @var Config $content */
        $content = $this->getShared('tConfig');

        return new NativeArray([
            'content' => $content->toArray()
        ]);
    }
}