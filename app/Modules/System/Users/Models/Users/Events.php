<?php
namespace Modules\System\Users\Models\Users;



use Modules\System\Users\Models\ModelUserCompanyInformation;
use Modules\System\Users\Models\ModelUserEducationalInformation;
use Modules\System\Users\Models\ModelUserFurtherInformation;
use Modules\System\Users\Models\ModelUserPersonalInformation;
use Modules\System\Users\Models\ModelUserSettingInformation;
use Modules\Users\Session\Models\ModelUserIp;
use Phalcon\Http\Request;
use Phalcon\Http\RequestInterface;
use Phalcon\Mvc\Model\Transaction\Manager;

/**
 * @property Manager $transactions
 */
trait Events
{
    public function beforeSave()
    {

    }

    public function beforeCreate()
    {
        parent::beforeCreate();


        /** @var RequestInterface $request */
        $request = $this->getDI()->get('request');
        $this->setCreateIp($request->getClientAddress());

//      //  $ip = $this->getCreateIp();
//
//        $ipp = self:: findByCreateIp($ip);
//
//        $ippp = count($ipp);
//
//
//        $ip2 = new ModelUserIp();
//
//        $ip2->setCreateIp($ip);
//        $ip2->setCounter($ippp+1);
//
//
//        if($ip2->counter < 1)
//        {
//            $ip2->save();
//        }
//        elseif ($ip2->counter >= 1)
//        {
//             $ip2->update();
//          //  dump($ip2->getMessages());
//            //   dump($ip2->toArray());
//        }
    }

    public function afterCreate()
    {
        $this->createPersonalInformation();
        $this->createCompanyInformation();
        $this->createEducationalInformation();
        $this->createFurtherInformation();
        $this->createSettingInformation();
    }

    private function createPersonalInformation()
    {
        $personal = new ModelUserPersonalInformation();

        if($this->hasTransaction())
            $personal->setTransaction($this->getTransaction());

        $personal->setUserId($this->getId());

        if(!$personal->create())
        {
            if($personal->hasTransaction())
                $personal->getTransaction()->rollback('personal dont save');

            foreach($personal->getMessages() as $message)
            {
                $this->appendMessage($message);
            }
        }
    }

    private function createCompanyInformation()
    {
        $company = new ModelUserCompanyInformation();

        if($this->hasTransaction())
            $company->setTransaction($this->getTransaction());

        $company->setUserId($this->getId());

        if(!$company->create())
        {
            if($company->hasTransaction())
                $company->getTransaction()->rollback('company instance dont save');

            foreach($company->getMessages() as $message)
            {
                $this->appendMessage($message);
            }
        }
    }

    private function createEducationalInformation()
    {
        $educational = new ModelUserEducationalInformation();

        if($this->hasTransaction())
            $educational->setTransaction($this->getTransaction());

        $educational->setUserId($this->getId());

        if(!$educational->create())
        {
            if($educational->hasTransaction())
                $educational->getTransaction()->rollback('educational instance dont save');

            foreach($educational->getMessages() as $message)
            {
                $this->appendMessage($message);
            }
        }
    }

    private function createFurtherInformation()
    {
        $further = new ModelUserFurtherInformation();

        if($this->hasTransaction())
            $further->setTransaction($this->getTransaction());

        $further->setUserId($this->getId());

        if(!$further->create())
        {
            if($further->hasTransaction())
                $further->getTransaction()->rollback('Further instance dont save');

            foreach($further->getMessages() as $message)
            {
                $this->appendMessage($message);
            }
        }
    }

    private function createSettingInformation()
    {
        $setting = new ModelUserSettingInformation();

        if($this->hasTransaction())
            $setting->setTransaction($this->getTransaction());

        $setting->setUserId($this->getId());

        if(!$setting->create())
        {
            if($setting->hasTransaction())
                $setting->getTransaction()->rollback('Setting instance dont save');

            foreach($setting->getMessages() as $message)
            {
                $this->appendMessage($message);
            }
        }
    }
}