<?php

namespace Modules\CreateContent\Currency\Controllers;

use Lib\Mvc\Controllers\AdminController;
use Modules\System\Native\Models\Language\ModelLanguage;

class CurrencyController extends AdminController
{
    public function indexAction()
    {

        $this->assetsCollection->addCss('assets/datatables.net-dt/css/jquery.dataTables.min.css');
        $this->assetsCollection->addCss('assets/datatables.net-select-dt/css/select.dataTables.min.css');
        $this->assetsCollection->addCss('assets/datatables.net-buttons-dt/css/buttons.dataTables.min.css');
        $this->assetsCollection->addCss('dt/css/editor.dataTables.min.css');
        $this->assetsCollection->addJs('assets/datatables.net/js/jquery.dataTables.min.js');
        $this->assetsCollection->addJs('assets/datatables.net-select/js/dataTables.select.min.js');
        $this->assetsCollection->addJs('assets/datatables.net-buttons/js/dataTables.buttons.min.js');
        $this->assetsCollection->addJs('dt/js/dataTables.editor.min.js');
        $this->assetsCollection->addInlineJs(/** @lang JavaScript */
            <<<TAG
var currencyCategoryTable;
var currencyTable;
var priceTable;
var currencyCategoryEditor;
var currencyEditor;
var priceEditor;

currencyCategoryEditor = new $.fn.dataTable.Editor({
    ajax: {
        create: {
            type: 'POST',
            url: '{$this->url->get(['for' => 'api_create_currency_category__'.ModelLanguage::getCurrentLanguage()])}'
        },
        edit: {
            type: 'PUT',
            url: '{$this->url->get(['for' => 'api_edit_currency_category__'.ModelLanguage::getCurrentLanguage()])}'
        },
        remove: {
            type: 'DELETE',
            url: '{$this->url->get(['for' => 'api_remove_currency_category__'.ModelLanguage::getCurrentLanguage()])}'
        }
    },
    table: managmanageields: [
        {
            label: '{$this->t->_('title')}',
            name: 'title'
        }
    ]
});

currencyCategoryTable = $(manage).DataTmanage   dom: 'Bfrtip',
    serverSide: true,
    ajax: {
        url: '{$this->url->get(['for' => 'api_get_currency_categories__'.ModelLanguage::getCurrentLanguage()])}'
    },
    columns: [
        {
            title: '{$this->t->_('title')}',
            data: 'title',
            className: 'dt-center',
            searchable: false
        }
    ],
    select: {
        style: 'single'
    },
    buttons: [
        {
            extend: 'create',
            editor: currencyCategoryEditor,
            text: '{$this->t->_('create')}'
        },
        {
            extend: 'edit',
            editor: currencyCategoryEditor,
            text: '{$this->t->_('edit')}'
        },
        {
            extend: 'remove',
            editor: currencyCategoryEditor,
            text: '{$this->t->_('remove')}'
        }
    ]
});

currencyEditor = new $.fn.dataTable.Editor({
    ajax: {
        create: {
            type: 'POST',
            url: '{$this->url->get(['for' => 'api_create_currency__'.ModelLanguage::getCurrentLanguage()])}',
            data: function(d) {
                var selected = currencyCategoryTable.row({selected:true});
                if (selected.any()) {
                    d.hierarchy_id = selected.data().id;
                } 
            }
        },
        edit: {
            type: 'PUT',
            url: '{$this->url->get(['for' => 'api_edit_currency__'.ModelLanguage::getCurrentLanguage()])}'
        },
        remove: {
            type: 'DELETE',
            url: '{$this->url->get(['for' => 'api_remove_currency__'.ModelLanguage::getCurrentLanguage()])}',
            data: function(d) {
                var selected = currencyCategoryTable.row({selected:true});
                if (selected.any()) {
                    d.hierarchy_id = selected.data().id;
                } 
            }
        },
    },
    table: '#dt-currency',
    fields: [
        {
            label: '{$this->t->_('title')}',
            name: 'title'
        }
    ]
});

currencyTable = $('#dt-currency').DataTable({
    dom: 'Blfrtip',
    serverSide: true,
    ajax: {
        url: '{$this->url->get(['for' => 'api_get_currencies__'.ModelLanguage::getCurrentLanguage()])}',
        data: function(d) {
            var selected = currencyCategoryTable.row({selected:true});
            if (selected.any()) {
                d.hierarchy_id = selected.data().id;
            } 
        }
    },
    columns: [
        {
            title: '{$this->t->_('title')}',
            data: 'title',
            className: 'dt-center'
        }
    ],
    select: {
        style: 'single'
    },
    buttons: [
        {
            extend: 'create',
            editor: currencyEditor,
            text: '{$this->t->_('create')}'
        },
        {
            extend: 'edit',
            editor: currencyEditor,
            text: '{$this->t->_('edit')}'
        },
        {
            extend: 'remove',
            editor: currencyEditor,
            text: '{$this->t->_('remove')}'
        }
    ]
});

currencyCategoryTable.on( 'select', function () {
    currencyTable.ajax.reload();

    currencyEditor
        .field( 'title' )
        .def( currencyCategoryTable.row( { selected: true } ).data().id );
} );

currencyCategoryTable.on( 'deselect', function () {
    currencyTable.ajax.reload();
} );

priceEditor = new $.fn.dataTable.Editor({
    ajax: {
        create: {
            type: 'POST',
            url: '{$this->url->get(['for' => 'api_create_price__'.ModelLanguage::getCurrentLanguage()])}',
            data: function(d) {
                var selected = currencyTable.row({selected:true});
                if (selected.any()) {
                    d.hierarchy_id = selected.data().id;
                } 
            }
        },
        edit: {
            type: 'PUT',
            url: '{$this->url->get(['for' => 'api_edit_price__'.ModelLanguage::getCurrentLanguage()])}',
            data: function(d) {
                var selected = currencyTable.row({selected:true});
                if (selected.any()) {
                    d.hierarchy_id = selected.data().id;
                } 
            }
        },
        remove: {
            type: 'DELETE',
            url: '{$this->url->get(['for' => 'api_remove_price__'.ModelLanguage::getCurrentLanguage()])}',
            data: function(d) {
                var selected = currencyTable.row({selected:true});
                if (selected.any()) {
                    d.hierarchy_id = selected.data().id;
                } 
            }
        },
    },
    table: '#dt-price',
    fields: [
        {
            label: '{$this->t->_('title')}',
            name: 'title'
        }
    ]
});

priceTable = $('#dt-price').DataTable({
    dom: 'Blfrtip',
    serverSide: true,
    ajax: {
        url: '{$this->url->get(['for' => 'api_get_prices__'.ModelLanguage::getCurrentLanguage()])}',
        data: function(d) {
            var selected = currencyTable.row({selected:true});
            if (selected.any()) {
                d.hierarchy_id = selected.data().id;
            } 
        }
    },
    columns: [
        {
            title: '{$this->t->_('title')}',
            data: 'title',
            className: 'dt-center'
        }
    ],
    select: {
        style: 'single'
    },
    buttons: [
        {
            extend: 'create',
            editor: priceEditor,
            text: '{$this->t->_('create')}'
        },
        {
            extend: 'edit',
            editor: priceEditor,
            text: '{$this->t->_('edit')}'
        },
        {
            extend: 'remove',
            editor: priceEditor,
            text: '{$this->t->_('remove')}'
        }
    ]
});

currencyTable.on( 'select', function () {
    priceTable.ajax.reload();

    priceEditor
        .field( 'title' )
        .def( currencyCategoryTable.row( { selected: true } ).data().id );
} );

currencyTable.on( 'deselect', function () {
    priceTable.ajax.reload();
} );
TAG

        );
    }

    public function getAction()
    {
        die(
        json_encode([
            'data' => [
                [
                    'id'    => 1,
                    'title' => 'cat-2'
                ]
            ]
        ])
        );
    }

    public function createAction()
    {

    }

    public function editAction()
    {

    }

    public function removeAction()
    {

    }
}