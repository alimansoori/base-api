<?php
namespace Lib\Assets;


use Lib\Assets\Minify\CSS;
use Lib\Assets\Minify\JS;
use Lib\Mvc\Helper\CmsCache;
use Lib\Assets\Resource AS Res;
use Phalcon\Mvc\User\Component;

/**
 * @property CSS cssmin
 * @property JS jsmin
 * @property Collection $assetsCollection
 * @property Collection $assetsWidgets
 */
class Asset extends Component
{
//    private static $instance = null;
    private $key;
    private $css = [];
    private $js = [];

    public function __construct()
    {
        $this->key = $this->getHashKey();
    }

    public function addCss($_, $name = null)
    {
        if(is_array($_))
            $this->css = array_merge($this->css, $_);
        elseif($name !== null && is_string($name))
        {
            $this->css[$name] = $_;
        }
        else
            $this->css[$_] = $_;
    }

    public function getCss($name = null, $onlyValues = true)
    {
        if($name !== null && is_string($name))
            return $this->css[$name];

        if(!$onlyValues)
            return $this->css;

        return array_values($this->css);
    }

    public function addJs($_, $name = null)
    {
        if(is_array($_))
            $this->js = array_merge($this->js, $_);
        elseif($name !== null && is_string($name))
            $this->js[$name] = $_;
        else
            $this->js[$_] = $_;
    }

    public function getJs($name = null, $onlyValues = true)
    {
        if($name !== null && is_string($name))
            return $this->js[$name];

        if(!$onlyValues)
            return $this->js;

        return array_values($this->js);
    }

    public function process()
    {
        $this->assets->addCss('assets/fontawesome/css/all.min.css');
        $this->assets->addCss('ilya-theme/ui/assets/themes/template.css');
        $this->assets->addJs('assets/jquery/dist/jquery.min.js');

        $this->addRemoteAssets();

        /** @var Res $resource */
        foreach($this->assetsCollection->getResources() as $resource)
        {
            if($resource->getType() == 'css' && $resource->getLocal() && file_exists($resource->getPath()))
            {
                $this->assets->addCss($resource->getPath());
            }
            elseif($resource->getType() == 'js' && $resource->getLocal() && file_exists($resource->getPath()))
            {
                $this->assets->addJs($resource->getPath());
            }
        }

        /** @var Inline $code */
        foreach($this->assetsCollection->getCodes() as $code)
        {
            if($code->getType() == 'css')
            {
                $this->assets->addInlineCss($code->getContent());
            }
            elseif($code->getType() == 'js')
            {
                $this->assets->addInlineJs($code->getContent());
            }
        }

        // init base
        $this->assets->addCss('tmp/'. $this->key.'.css');
        $this->assets->addJs('tmp/'. $this->key.'.js');

//        $this->assetsCollection->reset();

    }

    public function process3()
    {
        $this->addRemoteAssets();

        // init base
        $this->assets->addCss('tmp/'. $this->key.'.css');
        $this->assets->addCss('tmp/'. $this->key.'cache.css?version='. rand(0, 1000));
        $this->assets->addJs('tmp/'. $this->key.'.js');
        $this->assets->addJs('tmp/'. $this->key.'cache.js?version='. rand(0, 1000));
    }

    public function process2()
    {
        $cssSize = 0;
        $cssCacheSize = 0;
        $jsSize = 0;
        $jsCacheSize = 0;

        $jsCache = new JS();
        $cssCache = new CSS();

//        $this->assets->addCss('assets/fontawesome/css/all.min.css');
//        $this->assets->addCss('ilya-theme/ui/assets/themes/template.css');
//        $this->assets->addJs('assets/jquery/dist/jquery.min.js');

//        if(file_exists('assets/fontawesome/css/all.min.css'))
//        {
//            $cssSize += strlen('assets/fontawesome/css/all.min.css');
//            $this->cssmin->add('assets/fontawesome/css/all.min.css');
//        }
//
//        if(file_exists('ilya-theme/ui/assets/themes/template.css'))
//        {
//            $cssSize += strlen('ilya-theme/ui/assets/themes/template.css');
//            $this->cssmin->add('ilya-theme/ui/assets/themes/template.css');
//        }

        if(file_exists('assets/jquery/dist/jquery.min.js'))
        {
            $jsSize += strlen('assets/jquery/dist/jquery.min.js');
            $this->jsmin->add('assets/jquery/dist/jquery.min.js');
        }


        /** @var Res $resource */
        foreach($this->assetsCollection->getResources() as $resource)
        {
            $attrs = $resource->getAttributes();

            if($resource->getType() == 'css' && $resource->getLocal() && file_exists($resource->getPath()))
            {
                if ($attrs['cache'] === false)
                {
                    $cssCacheSize += strlen($resource->getPath());
                    $cssCache->add($resource->getPath());
                    continue;
                }
                $cssSize += strlen($resource->getPath());
                $this->cssmin->add($resource->getPath());
            }
            elseif($resource->getType() == 'js' && $resource->getLocal() && file_exists($resource->getPath()))
            {
                if ($attrs['cache'] === false)
                {
                    $jsCacheSize += strlen($resource->getPath());
                    $jsCache->add($resource->getPath());
                    continue;
                }
                $jsSize += strlen($resource->getPath());
                $this->jsmin->add($resource->getPath());
            }
            elseif ($resource->getLocal() && !file_exists($resource->getPath()))
            {
                throw new Exception('does not exits assets => '. $resource->getPath());
            }
        }

        /** @var Inline $code */
        foreach($this->assetsCollection->getCodes() as $code)
        {
            $attrs = $code->getAttributes();

            if($code->getType() == 'css')
            {
                if ($attrs['cache'] === false)
                {
                    $cssCacheSize += strlen($code->getContent());
                    $cssCache->add($code->getContent());
                    continue;
                }
                $cssSize += strlen($code->getContent());
                $this->cssmin->add($code->getContent());
            }
            elseif($code->getType() == 'js')
            {
                if ($attrs['cache'] === false)
                {
                    $jsCacheSize += strlen($code->getContent());
                    $jsCache->add($code->getContent());
                    continue;
                }
                $jsSize += strlen($code->getContent());
                $this->jsmin->add($code->getContent());
            }
        }

        if($cssSize !== CmsCache::getInstance()->get($this->key. '.css'))
        {
            $this->cssmin->minify('tmp/'. $this->key.'.css');
            CmsCache::getInstance()->save($this->key.'.css', $cssSize);
        }

        if($jsSize !== CmsCache::getInstance()->get($this->key. '.js'))
        {
            $this->jsmin->minify( 'tmp/'. $this->key.'.js');
            CmsCache::getInstance()->save($this->key.'.js', $jsSize);
        }

        if($cssCacheSize !== CmsCache::getInstance()->get($this->key. 'cache.css'))
        {
            $cssCache->minify('tmp/'. $this->key.'cache.css');
            CmsCache::getInstance()->save($this->key.'.css', $cssCacheSize);
        }

        if($jsCacheSize !== CmsCache::getInstance()->get($this->key. 'cache.js'))
        {
            $jsCache->minify( 'tmp/'. $this->key.'cache.js');
            CmsCache::getInstance()->save($this->key.'.js', $jsCacheSize);
        }
    }

    public function process4()
    {
        $cssSize = 0;
        $jsSize = 0;

        /** @var Res $resource */
        foreach($this->assetsCollection->getResources() as $resource)
        {
            if($resource->getType() == 'css' && $resource->getLocal() && file_exists($resource->getPath()))
            {
                $cssSize += strlen($resource->getPath());
                $this->cssmin->add($resource->getPath());
            }
            elseif($resource->getType() == 'js' && $resource->getLocal() && file_exists($resource->getPath()))
            {
                //                dump($this->assetsCollection->getResources());
                $jsSize += strlen($resource->getPath());
                $this->jsmin->add($resource->getPath());
            }
        }

        /** @var Inline $code */
        foreach($this->assetsCollection->getCodes() as $code)
        {
            if($code->getType() == 'css')
            {
                $cssSize += strlen($code->getContent());
                $this->cssmin->add($code->getContent());
            }
            elseif($code->getType() == 'js')
            {
                $jsSize += strlen($code->getContent());
                $this->jsmin->add($code->getContent());
            }
        }

        if($cssSize !== CmsCache::getInstance()->get($this->key. '.css'))
        {
            $this->cssmin->minify('tmp/'. $this->key.'.css');
            CmsCache::getInstance()->save($this->key.'.css', $cssSize);
        }

        if($jsSize !== CmsCache::getInstance()->get($this->key. '.js'))
        {
            $this->jsmin->minify( 'tmp/'. $this->key.'.js');
            CmsCache::getInstance()->save($this->key.'.js', $jsSize);
        }
    }

    protected function getHashKey()
    {
        return
//            HOST_HASH.
            $this->dispatcher->getParam('lang').
            md5(
                $this->router->getRewriteUri()
            );
    }

    private function addRemoteAssets()
    {
        /** @var Res $resource */
        foreach($this->assetsCollection->getResources() as $resource)
        {
            if($resource->getType() == 'css' && !$resource->getLocal())
            {
                $this->assets->addCss($resource->getPath(), $resource->getLocal(), $resource->getFilter(), $resource->getAttributes());
            }
            elseif($resource->getType() == 'js' && !$resource->getLocal())
            {
                $this->assets->addJs($resource->getPath(), $resource->getLocal(), $resource->getFilter(), $resource->getAttributes());
            }
        }
    }
}