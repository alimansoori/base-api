<?php
namespace Modules\System\Widgets\Tables\PageWidgetsManager;


use Lib\DTE\Table\Columns\Column;

trait Columns
{
    protected function columnsDesktop()
    {
        if ($this->device != 'desktop')
        return;

        $this->column1();
        $this->column2();
        $this->column3();
        $this->column4();
        $this->column5();
        $this->column6();
        $this->column7();
        $this->column8();
        $this->column9();
        $this->column10();
        $this->column11();
        $this->column12();
    }

    protected function columnsTablet()
    {
        if ($this->device != 'tablet')
            return;

        $this->column1();
        $this->column2();
        $this->column3();
        $this->column4();
        $this->column5();
        $this->column6();
        $this->column7();
        $this->column8();
    }

    protected function columnsMobile()
    {
        if ($this->device != 'mobile')
            return;

        $this->column1();
        $this->column2();
        $this->column3();
        $this->column4();
    }

    protected function column1()
    {
        $col = new Column('1');
        $col->setTitle('1');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function column2()
    {
        $col = new Column('2');
        $col->setTitle('2');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function column3()
    {
        $col = new Column('3');
        $col->setTitle('3');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function column4()
    {
        $col = new Column('4');
        $col->setTitle('4');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function column5()
    {
        $col = new Column('5');
        $col->setTitle('5');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function column6()
    {
        $col = new Column('6');
        $col->setTitle('6');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function column7()
    {
        $col = new Column('7');
        $col->setTitle('7');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function column8()
    {
        $col = new Column('8');
        $col->setTitle('8');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function column9()
    {
        $col = new Column('9');
        $col->setTitle('9');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function column10()
    {
        $col = new Column('10');
        $col->setTitle('10');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function column11()
    {
        $col = new Column('11');
        $col->setTitle('11');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }

    protected function column12()
    {
        $col = new Column('12');
        $col->setTitle('12');
        $col->setClassName('dt-center');
        $col->setOrderable(false);
        $col->setRender( /** @lang JavaScript */
            <<<TAG
            if (type == 'display')
                return data.display + '&nbsp;&nbsp;&nbsp;<i class="fas fa-pencil-alt"></i>';
            if (type == 'sort')
                return data.display;
            if (type == 'filter')
                return data.display;
            return data._;
TAG
            , Column::RENDER_TYPE_FUNCTION);

        $this->addColumn($col);
    }
}