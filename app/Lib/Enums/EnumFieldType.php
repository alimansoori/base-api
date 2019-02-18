<?php
namespace Lib\Enums;


class EnumFieldType extends BasicEnum
{
    const FIELD_TYPE_CHECKBOX     = 'checkbox';
    const FIELD_TYPE_DATE         = 'data';
    const FIELD_TYPE_DATETIME     = 'datetime';
    const FIELD_TYPE_HIDDEN       = 'hidden';
    const FIELD_TYPE_PASSWORD     = 'password';
    const FIELD_TYPE_RADIO        = 'radio';
    const FIELD_TYPE_READONLY     = 'readonly';
    const FIELD_TYPE_SELECT       = 'select';
    const FIELD_TYPE_TEXT         = 'text';
    const FIELD_TYPE_TEXTAREA     = 'textarea';
    const FIELD_TYPE_UPLOAD       = 'upload';
    const FIELD_TYPE_UPLOADMANY   = 'uploadMany';
    const FIELD_TYPE_SELECT2      = 'select2';
    const FIELD_TYPE_DATEPICKER   = 'datePicker';
    const FIELD_TYPE_CKEDITOR     = 'ckeditor';
    const FIELD_TYPE_CKEDITOR5    = 'ckeditorClassic';
    const FIELD_TYPE_CHOSEN       = 'chosen';
    const FIELD_TYPE_TITLE        = 'title';
    const FIELD_TYPE_AUTOCOMPLETE = 'autoComplete';
    const FIELD_TYPE_MASK         = 'mask';
    const FIELD_TYPE_QUILL        = 'quill';
    const FIELD_TYPE_DISPLAY      = 'display';
    const FIELD_TYPE_SELECTIZE    = 'selectize';
    const FIELD_TYPE_TINYMCE      = 'tinymce';
}