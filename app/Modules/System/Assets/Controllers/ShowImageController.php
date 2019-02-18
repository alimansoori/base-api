<?php
namespace Modules\System\Assets\Controllers;


use Lib\Mvc\Controller;
use Lib\Mvc\Model\ModelBlobs;

class ShowImageController extends Controller
{
    public function indexAction()
    {
        ModelBlobs::clearTmp();

        $imageId = $this->dispatcher->getParam('image_id');
        $type = $this->dispatcher->getParam('type');

        if (!is_numeric($imageId))
        {
            dump('access denied !');
        }

        $imageName = $imageId. '.'. $type;

        /** @var ModelBlobs $image */
        $image = ModelBlobs::findFirstById($imageId);

        if (!$image)
        {
            dump('access denied !');
        }

        $imageType = strtolower(pathinfo($image->getName(), PATHINFO_EXTENSION));

        if ($imageType != $type)
        {
            dump('access denied');
        }

        $filePath = 'tmp/';

        $im = file_get_contents("tmp/". $imageName);
        header("Content-type: ". $image->getFormat());
        echo $im;
        die;
    }

    public function index2Action()
    {
        ModelBlobs::clearTmp();

        $imageId = $this->dispatcher->getParam('image_id');

        if (!is_numeric($imageId))
        {
            dump('access denied !');
        }


        /** @var ModelBlobs $image */
        $image = ModelBlobs::findFirstById($imageId);
        $imageType = strtolower(pathinfo($image->getName(), PATHINFO_EXTENSION));
        $imageName = $imageId. '.'. $imageType;

        if (!$image)
        {
            dump('access denied !');
        }

        $filePath = 'tmp/';

        $im = file_get_contents("tmp/". $imageName);
        header("Content-type: ". $image->getFormat());
        echo $im;
        die;
    }
}