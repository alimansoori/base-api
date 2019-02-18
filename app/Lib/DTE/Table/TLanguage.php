<?php

namespace Lib\DTE\Table;


use Lib\Translate\T;

trait TLanguage
{
    protected function translate()
    {
        $this->addOption( 'language', [
            'processing'     => T::_( 'dte_s_processing' ),
            'search'         => T::_( 'dte_s_search' ),
            'lengthMenu'     => T::_( 'dte_s_length_menu' ),
            'info'           => T::_( 'dte_s_info' ),
            'infoEmpty'      => T::_( 'dte_s_info_empty' ),
            'infoFiltered'   => T::_( 'dte_s_info_empty' ),
            'infoPostFix'    => T::_( 'dte_s_info_postfix' ),
            'loadingRecords' => T::_( 'dte_s_loading_records' ),
            'zeroRecords'    => T::_( 'dte_s_zero_records' ),
            'emptyTable'     => T::_( 'dte_s_empty_table' ),
            'paginate'       => [
                'first'    => T::_( 'dte_o_paginate_s_first' ),
                'previous' => T::_( 'dte_o_paginate_s_previous' ),
                'next'     => T::_( 'dte_o_paginate_s_next' ),
                'last'     => T::_( 'dte_o_paginate_s_last' ),
            ],
            'aria'           => [
                'sortAscending'  => T::_( 'dte_o_aria_sort_s_ascending' ),
                'sortDescending' => T::_( 'dte_o_aria_sort_s_descending' ),
            ],
        ] );
    }
}