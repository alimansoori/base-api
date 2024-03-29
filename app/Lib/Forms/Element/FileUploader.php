<?php
/**
 * Summary File Text
 *
 * Description File Text
 *
 * ILYA CMS Created by ILYA-IDEA Company.
 * @author Ali Mansoori
 * Date: 10/8/2018
 * Time: 9:40 AM
 * @version 1.0.0
 * @copyright Copyright (c) 2017-2018, ILYA-IDEA Company
 */
namespace Lib\Forms\Element;

use Lib\Contents\ContentBuilder;
use Lib\Forms\Element;
use Lib\Forms\Element\FileUploader\Options;
use Lib\Forms\Form;
use Lib\Tag;
use Lib\Upload\UploadHandler;
use Lib\Mvc\Model\ModelBlobs;

class FileUploader extends Element
{
    protected $_isMultiple = false;
    /** @var Options $options */
    public $options;

    protected $_values = [];
    private $_key;

    public $storageOptions = [
        'maxNumberOfFiles' => 1
    ];

    public function __construct( $name, array $attributes = null )
    {
        $this->_key = $name;
        parent::__construct( $name, $attributes );
        $this->options = new Options($this);
        $this->_type = 'file';

        $request = new \Phalcon\Http\Request();
        if($request->isPost() && $request->getPost($this->getName()))
        {
            $this->setValues($request->getPost($this->getName()));
        }
    }

    /**
     * Renders the element widget returning html
     *
     * @param array $attributes
     * @return string
     */
    public function render( $attributes = null )
    {
        $attributes['data-key'] = $this->_key;
        $this->setName('files');
        return Tag::fileUploaderField($this->prepareAttributes($attributes));
    }

    public function isMultiple($isMultiple = false)
    {
        if($isMultiple === true)
        {
            $this->setName(
                $this->getName(). '[]'
            );
            $this->_attributes['multiple'] = 'multiple';
            $this->_isMultiple = true;
            if($this->storageOptions['maxNumberOfFiles'] === 1)
            {
                unset($this->storageOptions['maxNumberOfFiles']);
            }
        }

        return $this;
    }

    /**
     * @param Form $form
     * @throws \ReflectionException
     */
    public function process($form)
    {
        $uploadAction = $form->uploadAction($this);

        if($form->isValidUpload($this))
        {
            $uploadHandler = new UploadHandler();
            die;
        }

        $name = $this->getName();

        $content = ContentBuilder::instantiate();

        $content->assets->addCss('assets/bootstrap/dist/css/bootstrap.min.css');
        $content->assets->addCss('assets/blueimp-file-upload/css/jquery.fileupload.css');
        $content->assets->addCss('assets/blueimp-file-upload/css/jquery.fileupload-ui.css');

        $content->assets->addJs('assets/jquery/dist/jquery.min.js');
        $content->assets->addJs('assets/blueimp-tmpl/js/tmpl.min.js');
        $content->assets->addJs('assets/blueimp-load-image/js/load-image.all.min.js');
        $content->assets->addJs('assets/blueimp-canvas-to-blob/js/canvas-to-blob.min.js');
        $content->assets->addJs('assets/bootstrap/dist/js/bootstrap.min.js');
        $content->assets->addJs('assets/blueimp-gallery/js/jquery.blueimp-gallery.min.js');
        $content->assets->addJs('assets/blueimp-file-upload/js/vendor/jquery.ui.widget.js');
        $content->assets->addJs('assets/blueimp-file-upload/js/jquery.iframe-transport.js');
        $content->assets->addJs('assets/blueimp-file-upload/js/jquery.fileupload.js');
        $content->assets->addJs('assets/blueimp-file-upload/js/jquery.fileupload-process.js');
        $content->assets->addJs('assets/blueimp-file-upload/js/jquery.fileupload-image.js');
        $content->assets->addJs('assets/blueimp-file-upload/js/jquery.fileupload-audio.js');
        $content->assets->addJs('assets/blueimp-file-upload/js/jquery.fileupload-video.js');
        $content->assets->addJs('assets/blueimp-file-upload/js/jquery.fileupload-validate.js');
        $content->assets->addJs('assets/blueimp-file-upload/js/jquery.fileupload-ui.js');

        $options = json_encode($this->storageOptions);
        $values = json_encode($this->_values);

        $content->assets->addJs( /** @lang JavaScript */
            "
$(function() {
  var form = $('input[name=\"files\"][data-key=\"$this->_key\"]').closest('form');
  
  form.fileupload($options);
  
  form.bind('fileuploadsubmit', function(e, data) {
    data.formData = {upload_action:'$uploadAction'};
  });
  form.bind('fileuploaddestroy', function(e, data) {
    data.data = {upload_action: '$uploadAction'};
  });
  form.bind('fileuploadcompleted', function (e, data) {
      $.each(data.result.files, function (index, file) {
          
        var blobid = file.name.split('.').slice(0, -1).join('.');
        
          form.append('<input type=\'hidden\' name=\'$name\' value=\''+blobid+'\'/>');
      });
  });
  
  form.bind('fileuploaddestroyed', function (e, data) {
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }
        
        var filename = getParameterByName('file', data.url);
        var blobid = filename.split('.').slice(0, -1).join('.');
        
        form.find('input[type=\'hidden\'][value=\''+blobid+'\']').remove();
        console.log('destroyed');
  });
  
    // Load existing files:
    form.addClass('fileupload-processing');
    $.ajax({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: form.fileupload('option', 'url'),
        data: {upload_action: '$uploadAction', data: $values},
        dataType: 'json',
        context: form[0]
    }).always(function () {
        $(this).removeClass('fileupload-processing');
    }).done(function (result) {
        $(this).fileupload('option', 'done')
            .call(this, $.Event('done'), {result: result});
    });
})
");
        $content->assets->addJs('assets\blueimp-file-upload\js\cors\jquery.xdr-transport.js');
    }

    public function setValues($values = [])
    {
        if($values instanceof ModelBlobs)
        {
            $this->_values[] = $values->toArray();
        }
        elseif(is_numeric($values))
        {
            $image = ModelBlobs::findFirst($values);
            if($image)
            {
                $this->_values[] = $image->toArray();
            }
        }
        elseif(is_array($values))
        {
            if($this->isAssoc($values) && ctype_digit(implode('', $values)))
            {
                foreach($values as $value)
                {
                    $image = ModelBlobs::findFirst($value);
                    if($image)
                    {
                        $this->_values[] = $image->toArray();
                    }
                }
            }
        }
    }

    public function getValues()
    {
        return $this->_values;
    }

    private function isAssoc(array $arr)
    {
        if($arr === []) return false;

        return array_keys($arr) === range(0, count($arr)-1);
    }

}