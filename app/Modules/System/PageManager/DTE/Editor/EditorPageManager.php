<?php
namespace Modules\System\PageManager\DTE\Editor;


use Lib\DTE\Editor;
use Lib\Mvc\Model;
use Modules\System\PageManager\DTE\Editor\PageManager\TEditorPageManager;
use Modules\System\PageManager\Models\Pages\ModelPages;
use Modules\System\PageManager\Models\Routes\ModelRoutes;
use Phalcon\Mvc\Model\Transaction\Failed;

class EditorPageManager extends Editor
{
    use TEditorPageManager;
    /** @var ModelRoutes $route */
    protected $route;

    public function init()
    {
        $this->setOption('display', 'envelope');

        if($this->request->get('route_id'))
            $this->route = ModelRoutes::findFirst($this->request->get('route_id'));

        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            "
$('#{$this->getTable()->getName()} tbody').on( 'click', 'td i.editable', function (e) {
        e.stopImmediatePropagation();
 
        {$this->getName()}.bubble( $(this).parent() );
    } );
");
    }

    public function initFields()
    {
        $this->fieldTitle();
        $this->fieldParentId();
        $this->fieldTitleMenu();
        $this->fieldSlug();
        $this->fieldRoute();
        $this->fieldPosition();
        $this->fieldStatus();
        $this->fieldKeywords();
        $this->fieldDescription();
        $this->fieldContent();
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    public function createAction()
    {
        $page = null;
        foreach($this->getDataAfterValidate() as $data)
        {
            try
            {
                $page = new ModelPages();
                $page->setTransaction($this->transactions);

                if(isset($data['parent_id']) || !$data['parent_id'])
                    $data['parent_id'] = null;

                $page->setCreatorId($this->auth->getUserId());

                $page->setFieldsByData($data);

                if(!$page->save())
                {
                    $this->appendMessages($page->getMessages());
                    $page->getTransaction()->rollback('dont save module in editor createAction');
                }

                $page->getTransaction()->commit();

            }
            catch(Failed $exception)
            {
                //                $this->appendMessage(new Message($exception->getMessage()));
                return;
            }

            $this->addData(ModelPages::getPageForTable($page));
        }
    }

    public function editAction()
    {
        try
        {
            $page = null;
            foreach($this->getDataAfterValidate() as $id => $data)
            {
                /** @var ModelPages $page */
                $page = ModelPages::findFirst($id);
                if(!$page)
                    continue;

                if(isset($data['parent_id']) || !$data['parent_id'])
                    $data['parent_id'] = null;

                $page->setTransaction($this->transactions);

                $page->setFieldsByData($data);

                if(!$page->update())
                {
                    dump($page->getMessages());
                    $this->appendMessages($page->getMessages());
                    $page->getTransaction()->rollback('does not edit in editActionEditor editor name = '. $page->getTitle());
                    continue;
                }

                $this->addData(ModelPages::getPageForTable($page));
            }

            $this->transactions->commit();
        }
        catch(Failed $exception)
        {
            //                        $this->appendMessage(new Message($exception->getMessage()));
        }
    }

    public function removeAction()
    {
        try
        {
            $page = null;
            foreach($this->getDataAfterValidate() as $moduleId=>$value)
            {
                /** @var ModelPages $page */
                $page = ModelPages::findFirst($moduleId);

                if(!$page)
                    continue;

                $page->setTransaction($this->transactions);

                if(!$page->delete())
                {
                    $this->appendMessages($page->getMessages());
                    $page->getTransaction()->rollback('does not delete '. $page->getTitle());
                }
            }

            $this->transactions->commit();
        }
        catch(Failed $exception)
        {
        }
    }
}