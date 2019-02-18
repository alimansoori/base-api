<?php
namespace Modules\System\Widgets\Tables\PageWidgetsManager;


use Lib\DTE\Table\Button;
use Lib\DTE\Table\Buttons\Editor\ButtonRemove;
use Lib\Translate\T;

trait Buttons
{
    protected function btnAddRow($device = 'desktop')
    {
        $btn = new Button('btn_add_row');
        $btn->setText(T::_('add_new_row'));
        $btn->setEditor($this->getEditor('page_widgets_manager_editor'));

        if ($device == 'desktop')
        {
            $btn->setAction(/** @lang JavaScript */
                <<<TAG
    dt.row.add(
        {
            DT_RowId: dt.data().length + 1,
            1: {
                display: null,
                _: null
            },
            2: {
                display: null,
                _: null
            },
            3: {
                display: null,
                _: null
            },
            4: {
                display: null,
                _: null
            },
            5: {
                display: null,
                _: null
            },
            6: {
                display: null,
                _: null
            },
            7: {
                display: null,
                _: null
            },
            8: {
                display: null,
                _: null
            },
            9: {
                display: null,
                _: null
            },
            10: {
                display: null,
                _: null
            },
            11: {
                display: null,
                _: null
            },
            12: {
                display: null,
                _: null
            },
        }
     ).draw( false );

TAG
            );
        }
        elseif ($device == 'tablet')
        {
            $btn->setAction(/** @lang JavaScript */
                <<<TAG
    dt.row.add(
        {
            DT_RowId: dt.data().length + 1,
            1: {
                display: null,
                _: null
            },
            2: {
                display: null,
                _: null
            },
            3: {
                display: null,
                _: null
            },
            4: {
                display: null,
                _: null
            },
            5: {
                display: null,
                _: null
            },
            6: {
                display: null,
                _: null
            },
            7: {
                display: null,
                _: null
            },
            8: {
                display: null,
                _: null
            }
        }
     ).draw( false );

TAG
            );
        }
        elseif ($device == 'mobile')
        {
            $btn->setAction(/** @lang JavaScript */
                <<<TAG
    dt.row.add(
        {
            DT_RowId: dt.data().length + 1,
            1: {
                display: null,
                _: null
            },
            2: {
                display: null,
                _: null
            },
            3: {
                display: null,
                _: null
            },
            4: {
                display: null,
                _: null
            },
        }
     ).draw( false );

TAG
            );
        }

        $this->addButton($btn);
    }

    protected function btnRemove()
    {
        $btnRemove = new ButtonRemove('btn_remove');
        $btnRemove->setText(T::_('remove'));
        $btnRemove->setEditor($this->getEditor('page_widgets_manager_editor'));

        $this->addButton($btnRemove);
    }
}