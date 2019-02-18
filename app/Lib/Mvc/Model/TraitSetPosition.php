<?php
namespace Lib\Mvc\Model;

use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Text;

trait TraitSetPosition
{
    public function sortByPosition($fields = [])
    {
        if (!method_exists($this,'setPosition') && !method_exists($this,'getPosition'))
            return;

        $class = get_class($this);

        /** @var Builder $result */
        $result = $this->getModelsManager()->createBuilder();
        $result->columns(['id', 'position']);
        $result->from($class);

        foreach($fields as $field)
            if($field && method_exists($this,'get'. Text::camelize($field, '_-')))
            {
                $method = 'get'. Text::camelize($field, '_-');

                if($this->{$method}())
                {
                    $result->andWhere($field.'=:p:', ['p' => $this->{$method}()]);
                }
                else
                    $result->andWhere($field. ' IS NULL');
            }

        if(method_exists($this,'getLanguageIso'))
            $result->andWhere('language_iso=:lang:', ['lang' => $this->getLanguageIso()]);

        if(method_exists($this,'getCreated') && method_exists($this,'getModified'))
        {
            if($this->isModeCreate())
                $result->orderBy('position ASC,created DESC');
            else
                $result->orderBy('position ASC,modified DESC');
        }
        else
        {
            if($this->isModeCreate())
                $result->orderBy('position ASC');
            else
                $result->orderBy('position ASC');
        }

        $result = $result->getQuery()->execute();

        $i = 1;
        foreach($result as $res)
        {
            /** @var ModelInterface $modelInst */
            $modelInst = $class::findFirst($res->id);

            if($this->getTransaction())
            {
                $modelInst->setTransaction($this->getTransaction());
            }

            $modelInst->setPosition($i);

            if(!$modelInst->update())
            {
                if($this->getTransaction())
                    $modelInst->getTransaction()->rollback(
                        'don\'t update',
                        $modelInst
                    );

                foreach($modelInst->getMessages() as $message)
                    $this->appendMessage($message);
            }
            $i++;
        }

    }

    protected function setPositionIfEmpty()
    {
        if(
            !method_exists($this, 'getPosition') &&
            !method_exists($this, 'setPosition')
        )
            return;

        if($this->getPosition() && is_numeric($this->getPosition()))
        {
            return;
        }

        /** @var \Phalcon\Mvc\Model\Manager $modelManager */
        $modelManager = $this->getModelsManager();

        $position = $modelManager->createBuilder();

        $position->columns('MAX(position) AS max');
        $position->from(get_class($this));

        if(method_exists($this,'getParentId'))
        {
            if($this->getParentId())
                $position->where('parent_id=:p:', ['p' => $this->getParentId()]);
            else
                $position->where('parent_id IS NULL');
        }


        if(method_exists($this,'getId') && $this->getId())
            $position->andWhere('id <> :id:', ['id' => $this->getId()]);

        if(method_exists($this,'getLanguage'))
        {
            $position->andWhere('language=:lang:', ['lang' => $this->getLanguage()]);
        }

        $position = $position->getQuery()->getSingleResult();

        $this->setPosition(1);
        if($position->max)
            $this->setPosition($position->max + 1);
    }
}