
var options;
var editor_category;
var table_category;
var editor_resources;
var table_resources;
var editor_roles;
var table_roles;

function resourcesManagerInit(opt) {
    options = opt;
    editor_category = new $.fn.dataTable.Editor({
        "i18n": i18nEditor(),
        "table": "#" + options.categoryTableId,
        "fields": [{
            data: "title",
            label: "\u0639\u0646\u0648\u0627\u0646",
            name: "title",
            type: "text",
            attr: {
                placeholder: "\u0639\u0646\u0648\u0627\u0646",
                dir: 'rtl'
            }
        }, {
            data: "position",
            label: "\u062c\u0627\u06cc\u06af\u0627\u0647",
            name: "position",
            type: "text",
            attr: {
                placeholder: "\u0644\u0637\u0641\u0627 \u06cc\u06a9 \u0645\u0642\u062f\u0627\u0631 \u0639\u062f\u062f\u06cc \u0648\u0627\u0631\u062f \u06a9\u0646\u06cc\u062f",
                type: "number",
                dir: 'rtl'
            }
        }, {
            className: "block",
            data: "description",
            label: "توضیحات",
            name: "description",
            type: 'textarea',
            attr: {
                dir: 'rtl'
            }
        }, {
            name: 'parent_id',
            data: 'parent_id',
            label: 'پدر',
            optionsPair: {
                label: 'html',
                value: 'id'
            },
            type: 'select2',
            opts: {
                placeholder: 'لطفا انتخاب کنید',
                minimumResultsForSearch: -1,
                escapeMarkup: function (m) {
                    return m;
                }
            },
        }],
        ajax: {
            remove: {
                url: options.urlAjax,
                type: "DELETE"
            },
            edit: {
                url: options.urlAjax,
                type: "PUT"
            },
            create: {
                url: options.urlAjax,
                type: "POST"
            }
        }
    });
    table_category = $('#' + options.categoryTableId).DataTable({
        paging: false,
        language: i18nTable(),
        dom: "Brtip",
        serverSide: true,
        ajax: {
            url: options.urlAjax
        },
        ordering: false,
        select: {
            style: "single",
            selector: "td.selectable"
        },
        columns: [{
            name: "details_control",
            data: null,
            className: "dt-center details-control",
            width: "10px",
            createdCell: function (td, cellData, rowData, row, col) {
                var tr = td.closest('tr');
                if (rowData.level > 0) {
                    td.className = td.className + ' child-' + rowData.count_child + ' level-' + rowData.level
                }
                if (typeof rowData.count_child !== 'undefined' && rowData.count_child > 0) {
                    $(tr).removeClass('details');
                }
                if (typeof rowData.count_child !== 'undefined' && (rowData.count_child === 0 || rowData.count_child === null)) {
                    $(tr).addClass('details');
                }
            },
            defaultContent: "",
            orderable: false
        }, {
            name: "title",
            data: "title",
            title: "\u0639\u0646\u0648\u0627\u0646",
            className: "dt-center selectable"
        }, {
            name: "parent_id",
            data: "parent_id",
            visible: false
        }],
        buttons: [{
            name: "btn_collection_main",
            extend: "collection",
            autoClose: true,
            collectionTitle: 'کنترلرهای اصلی',
            text: "کنترلرهای اصلی",
            attr: {
                title: 'کنترلرهای اصلی'
            },
            buttons: [
                {
                    name: "btn_create",
                    extend: "create",
                    text: "ایجاد",
                    editor: editor_category
                }, {
                    name: "btn_edit",
                    extend: "edit",
                    text: "ویرایش",
                    editor: editor_category
                }, {
                    name: "btn_remove",
                    extend: "remove",
                    text: "حذف",
                    editor: editor_category
                }
            ]
        }, {
            name: "btn_collection_category",
            extend: "collection",
            autoClose: true,
            collectionTitle: 'مجموعه کلیدهای دسته بندی منابع',
            text: 'کنترلرهای اضافی',
            attr: {
                title: 'مجموعه کلیدهای دسته بندی منابع'
            },
            buttons: [
                {
                    name: "btn_show_resources",
                    enabled: false,
                    text: "مشاهده منابع",
                    attr: {
                        title: 'مشاهده تمام منابع مرتبط با دسته بندی انتخاب شده'
                    },
                    action: function (e, dt, node, config) {
                        table_resources.ajax.reload();
                        if ($('#part-' + options.resourcesTableId).is(':hidden')) {
                            $('#part-' + options.resourcesTableId).show();
                            scrollToId('#part-' + options.resourcesTableId, 1000);
                        } else if ($('#part-' + options.resourcesTableId).is(':visible')) {
                            $('#part-' + options.resourcesTableId).hide();
                            $('#part-' + options.rolesTableId).hide();
                        }
                    }
                }
            ]
        }]
    });

    editor_resources = new $.fn.dataTable.Editor({
        "i18n": i18nEditor(),
        "table": "#" + options.resourcesTableId,
        "fields": [{
            name: "type",
            data: "type",
            label: "نوع منبع",
            type: "select",
            def: 'page',
            options: [
                {
                    label: 'صفحه',
                    value: 'page'
                },
                {
                    label: 'api',
                    value: 'api'
                },
                {
                    label: 'صفحه سیستمی',
                    value: 'page_api'
                }
            ]
        }, {
            data: "title",
            label: "عنوان",
            name: "title",
            type: "text",
            attr: {
                placeholder: "عنوان",
                dir: 'rtl'
            }
        }, {
            name: "title_menu",
            data: "title_menu",
            label: "عنوان در منو",
            type: "text",
            attr: {
                placeholder: "عنوان در منو",
                dir: 'rtl'
            }
        }, {
            name: "slug",
            data: "slug",
            label: "آدرس در url",
            type: "text"
        }, {
            name: "route",
            data: "route",
            label: "نام مسیر سیستمی",
            type: "text"
        }, {
            name: "keywords",
            data: "keywords",
            label: "کلیدواژه",
            fieldInfo: 'پر کردن این فیلد اجباری نیست و برای سئو و موتورهای جستجوگر مفید می‌باشد.',
            type: "textarea",
            attr: {
                dir: 'rtl'
            }
        }, {
            name: "description",
            data: "description",
            label: "توضیحات",
            fieldInfo: 'لطفا توضیحی مختصر درمورد این رکورد بنویسید. همچنین در حالت صفحه، برای سئو سایت مفید می‌باشد.',
            type: "textarea",
            attr: {
                dir: 'rtl'
            }
        }, {
            name: "status",
            data: "status",
            label: "وضعیت",
            type: "radio",
            def: 'active',
            options: [
                {
                    label: 'فعال',
                    value: 'active'
                },
                {
                    label: 'غیرفعال',
                    value: 'inactive'
                }
            ]
        }, {
            data: "position",
            label: "جایگاه",
            name: "position",
            type: "text",
            attr: {
                placeholder: "مقداری عددی",
                type: "number",
                dir: 'rtl'
            }
        }, {
            name: 'category_id',
            data: 'category_id',
            label: 'دسته بندی',
            // options: options.optionsCategoryParentSelect2,
            optionsPair: {
                label: 'html',
                value: 'id'
            },
            type: 'select2',
            opts: {
                placeholder: 'لطفا انتخاب کنید',
                minimumResultsForSearch: -1,
                escapeMarkup: function (m) {
                    return m;
                }
            },
        }, {
            name: "content",
            data: "content",
            label: "محتوای صفحه",
            fieldInfo: 'محتوای قابل نمایش برای صفحه',
            type: "ckeditor",
            className: 'block',
            attr: {
                dir: 'rtl'
            }
        }],
        ajax: {
            remove: {
                url: options.urlResourcesAjax,
                type: "DELETE",
                data: function (d) {
                    d.name = 'ad_editor';
                    var selected = table_category.row({
                        selected: true
                    });
                    if (selected.any()) {
                        d.category_id = selected.data().id
                    }
                }
            },
            edit: {
                url: options.urlResourcesAjax,
                type: "PUT",
                data: function (d) {
                    d.name = 'ad_editor';
                    var selected = table_category.row({
                        selected: true
                    });
                    if (selected.any()) {
                        d.category_id = selected.data().id
                    }
                }
            },
            create: {
                url: options.urlResourcesAjax,
                type: "POST",
                data: function (d) {
                    d.name = 'ad_editor';
                    var selected = table_category.row({
                        selected: true
                    });
                    if (selected.any()) {
                        d.category_id = selected.data().id
                    }
                }
            }
        }
    });
    table_resources = $('#' + options.resourcesTableId).DataTable({
        language: i18nTable(),
        paging: false,
        dom: "Brtip",
        serverSide: true,
        ajax: {
            url: options.urlResourcesAjax,
            type: 'GET',
            data: function (d) {
                d.name = 'ad_editor';
                var selected = table_category.row({
                    selected: true
                });
                if (selected.any()) {
                    d.category_id = selected.data().id
                }
            }
        },
        ordering: false,
        select: {
            style: "single",
            selector: "td.selectable"
        },
        columns: [{
            name: "title",
            data: "title",
            title: "عنوان",
            className: "dt-center selectable"
        }],
        buttons: [{
            name: "btn_collection_main",
            extend: "collection",
            autoClose: true,
            collectionTitle: 'کنترلرهای اصلی',
            text: "کنترلرهای اصلی",
            attr: {
                title: 'کنترلرهای اصلی'
            },
            buttons: [
                {
                    name: "btn_create",
                    extend: "create",
                    text: "ایجاد",
                    editor: editor_resources
                }, {
                    name: "btn_edit",
                    extend: "edit",
                    text: "ویرایش",
                    editor: editor_resources
                }, {
                    name: "btn_remove",
                    extend: "remove",
                    text: "حذف",
                    editor: editor_resources
                }
            ]
        },{
            name: "btn_collection_main",
            extend: "collection",
            autoClose: true,
            collectionTitle: 'کنترلرهای اضافی',
            text: "کنترلرهای اضافی",
            attr: {
                title: 'کنترلرهای اضافی'
            },
            buttons: [
                {
                    name: "btn_roles",
                    extend: "selected",
                    text: "تعیین نقش‌",
                    attr: {
                        title: 'با انتخاب هر منبع این کلید فعال می‌شود و با کلیک روی آن می‌توان تمام نقش های این منبع را مشاهده و ویرایش کنید.'
                    },
                    action: function (e, dt, node, config) {
                        table_roles.ajax.reload();
                        if ($('#part-' + options.rolesTableId).is(':hidden')) {
                            $('#part-' + options.rolesTableId).show();
                            scrollToId('#part-' + options.rolesTableId, 1000);
                        }
                    }
                }
            ]
        }, {
            name: "btn_collection_design",
            extend: "collection",
            text: "طراحی",
            attr: {
                title: 'مجموعه کلیدهای طراحی بخش های مختلف صفحات در اندازه های دسکتاپ، تبلت و موبایل'
            },
            buttons: [
                {
                    name: "btn_collection_desktop",
                    extend: "collection",
                    autoClose: true,
                    collectionTitle: 'حالت دسکتاپ',
                    text: "حالت دسکتاپ",
                    attr: {
                        title: 'مجموعه کلیدها برای طراحی حالت دسکتاپ صفحه'
                    },
                    buttons: [
                        {
                            name: 'btn_desktop_header',
                            enabled: false,
                            text: 'سربرگ',
                            attr: {title: 'طراحی بخش سربرگ، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('desktop', 'header');
                            }
                        },
                        {
                            name: 'btn_desktop_top_main',
                            enabled: false,
                            text: 'بالای محتوای اصلی',
                            attr: {title: 'طراحی بخش بالای محتوای اصلی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('desktop', 'main-content-top');
                            }
                        },
                        {
                            name: 'btn_desktop_bottom_main',
                            enabled: false,
                            text: 'پایین محتوای اصلی',
                            attr: {title: 'طراحی بخش پایین محتوای اصلی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('desktop', 'main-content-footer');
                            }
                        },
                        {
                            name: 'btn_desktop_sidebar_main',
                            enabled: false,
                            text: 'سایدبار اصلی',
                            attr: {title: 'طراحی بخش سایدبار اصلی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('desktop', 'main-sidebar');
                            }
                        },
                        {
                            name: 'btn_desktop_sidebar_aid',
                            enabled: false,
                            text: 'سایدبار کمکی',
                            attr: {title: 'طراحی بخش سایدبار کمکی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('desktop', 'main-sidebar-aid');
                            }
                        },
                        {
                            name: 'btn_desktop_bottom',
                            enabled: false,
                            text: 'پایین',
                            attr: {title: 'طراحی بخش پایین صفحه بین محتوای اصلی و پاورقی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('desktop', 'top-footer');
                            }
                        },
                        {
                            name: 'btn_desktop_footer',
                            enabled: false,
                            text: 'پاورقی',
                            attr: {title: 'طراحی بخش پاورقی صفحه، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('desktop', 'footer');
                            }
                        }
                    ]
                },
                {
                    name: "btn_collection_tablet",
                    extend: "collection",
                    autoClose: true,
                    collectionTitle: 'حالت تبلت',
                    text: "حالت تبلت",
                    attr: {
                        title: 'مجموعه کلیدها برای طراحی حالت تبلت صفحه'
                    },
                    buttons: [
                        {
                            name: 'btn_tablet_header',
                            enabled: false,
                            text: 'سربرگ',
                            attr: {title: 'طراحی بخش سربرگ، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('tablet', 'header');
                            }
                        },
                        {
                            name: 'btn_tablet_top_main',
                            enabled: false,
                            text: 'بالای محتوای اصلی',
                            attr: {title: 'طراحی بخش بالای محتوای اصلی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('tablet', 'main-content-top');
                            }
                        },
                        {
                            name: 'btn_tablet_bottom_main',
                            enabled: false,
                            text: 'پایین محتوای اصلی',
                            attr: {title: 'طراحی بخش پایین محتوای اصلی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('tablet', 'main-content-footer');
                            }
                        },
                        {
                            name: 'btn_tablet_sidebar_main',
                            enabled: false,
                            text: 'سایدبار اصلی',
                            attr: {title: 'طراحی بخش سایدبار اصلی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('tablet', 'main-sidebar');
                            }
                        },
                        {
                            name: 'btn_tablet_sidebar_aid',
                            enabled: false,
                            text: 'سایدبار کمکی',
                            attr: {title: 'طراحی بخش سایدبار کمکی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('tablet', 'main-sidebar-aid');
                            }
                        },
                        {
                            name: 'btn_tablet_bottom',
                            enabled: false,
                            text: 'پایین',
                            attr: {title: 'طراحی بخش پایین صفحه بین محتوای اصلی و پاورقی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('tablet', 'top-footer');
                            }
                        },
                        {
                            name: 'btn_tablet_footer',
                            enabled: false,
                            text: 'پاورقی',
                            attr: {title: 'طراحی بخش پاورقی صفحه، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('tablet', 'footer');
                            }
                        }
                    ]
                },
                {
                    name: "btn_collection_mobile",
                    extend: "collection",
                    autoClose: true,
                    collectionTitle: 'حالت موبایل',
                    text: "حالت موبایل",
                    attr: {
                        title: 'مجموعه کلیدها برای طراحی حالت موبایل صفحه'
                    },
                    buttons: [
                        {
                            name: 'btn_mobile_header',
                            enabled: false,
                            text: 'سربرگ',
                            attr: {title: 'طراحی بخش سربرگ، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('mobile', 'header');
                            }
                        },
                        {
                            name: 'btn_mobile_top_main',
                            enabled: false,
                            text: 'بالای محتوای اصلی',
                            attr: {title: 'طراحی بخش بالای محتوای اصلی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('mobile', 'main-content-top');
                            }
                        },
                        {
                            name: 'btn_mobile_bottom_main',
                            enabled: false,
                            text: 'پایین محتوای اصلی',
                            attr: {title: 'طراحی بخش پایین محتوای اصلی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('mobile', 'main-content-footer');
                            }
                        },
                        {
                            name: 'btn_mobile_sidebar_main',
                            enabled: false,
                            text: 'سایدبار اصلی',
                            attr: {title: 'طراحی بخش سایدبار اصلی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('mobile', 'main-sidebar');
                            }
                        },
                        {
                            name: 'btn_mobile_sidebar_aid',
                            enabled: false,
                            text: 'سایدبار کمکی',
                            attr: {title: 'طراحی بخش سایدبار کمکی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('mobile', 'main-sidebar-aid');
                            }
                        },
                        {
                            name: 'btn_mobile_bottom',
                            enabled: false,
                            text: 'پایین',
                            attr: {title: 'طراحی بخش پایین صفحه بین محتوای اصلی و پاورقی، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('mobile', 'top-footer');
                            }
                        },
                        {
                            name: 'btn_mobile_footer',
                            enabled: false,
                            text: 'پاورقی',
                            attr: {title: 'طراحی بخش پاورقی صفحه، برای فعال شدن این گزینه لطفا یک منبع از نوع صفحه را از جدول منابع انتخاب کنید.'},
                            action: function (e, dt, node, config) {
                                designDTE('mobile', 'footer');
                            }
                        }
                    ]
                }
            ]
        }]
    });

    editor_roles = new $.fn.dataTable.Editor({
        "i18n": i18nEditor(),
        "table": "#" + options.rolesTableId,
        "fields": [{
            name: "status",
            data: "status",
            type: "hidden"
        }],
        ajax: {
            edit: {
                url: options.urlRolesAjax,
                type: "PUT",
                data: function (d) {
                    d.name = 'ad_editor';
                    var selected = table_resources.row({
                        selected: true
                    });
                    if (selected.any()) {
                        d.resource_id = selected.data().id
                    }
                }
            }
        }
    });
    table_roles = $('#' + options.rolesTableId).DataTable({
        paging: false,
        language: i18nTable(),
        dom: "t",
        serverSide: true,
        ajax: {
            url: options.urlRolesAjax,
            type: 'GET',
            data: function (d) {
                d.name = 'ad_editor';
                var selected = table_resources.row({
                    selected: true
                });
                if (selected.any()) {
                    d.resource_id = selected.data().id
                }
            }
        },
        rowCallback: function (row, data) {
            // Set the checked state of the checkbox in the table
            $('input.editor-active', row).prop('checked', data.status == 1);
        },
        ordering: false,
        select: false,
        columns: [{
            "name": "status",
            "data": "status",
            "title": "status",
            "render": function (data, type, row, meta) {
                if (type === 'display') {
                    return '<input type=\"checkbox\" class=\"editor-active\">'
                }
                return data
            },
            "className": "dt-center"
        }, {
            name: "title",
            data: "title",
            title: "عنوان",
            className: "dt-center selectable"
        }]
    });

    eventsDTE();
}

function designEditor(device, place) {
    var design_editor;

    design_editor = new $.fn.dataTable.Editor({
        i18n: i18nEditor(),
        table: "#" + options.designTableId,
        fields: fieldsDevice(device),
        ajax: {
            remove: {
                url: options.urlDesignAjax,
                type: "DELETE",
                data: function (d) {
                    var selected = table_resources.row({
                        selected: true
                    });
                    if (selected.any() && typeof selected.data().type !== 'undefined' && (selected.data().type === 'page' || selected.data().type === 'page_api')) {
                        d.resource_id = selected.data().id;
                        d.device = device;
                        d.place = place;
                    }
                }
            },
            edit: {
                url: options.urlDesignAjax,
                type: "PUT",
                data: function (d) {
                    var selected = table_resources.row({
                        selected: true
                    });
                    if (selected.any() && typeof selected.data().type !== 'undefined' && (selected.data().type === 'page' || selected.data().type === 'page_api')) {
                        d.resource_id = selected.data().id;
                        d.device = device;
                        d.place = place;
                    }
                }
            }
        }
    });

    return design_editor;
}

function designTable(device, place, design_editor) {
    var design_table;

    design_table = $('#' + options.designTableId).DataTable({
        paging: false,
        scrollY: false,
        language: i18nTable(),
        dom: "Bt",
        ajax: {
            url: options.urlDesignAjax,
            type: 'GET',
            data: function (d) {
                var selected = table_resources.row({
                    selected: true
                });
                if (selected.any() && typeof selected.data().type !== 'undefined' && (selected.data().type === 'page' || selected.data().type === 'page_api')) {
                    d.resource_id = selected.data().id;
                    d.device = device;
                    d.place = place;
                }
            }
        },
        ordering: false,
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        columns: columnsDevice(device),
        buttons: [
            {
                name: "btn_add_row",
                text: "افزودن ردیف جدید",
                action: function (e, dt, node, config) {
                    var row = {
                        DT_RowId: dt.data().length + 1
                    };

                    for (var i = 1; i < columnsDevice(device).length; i++) {
                        row[i] = {
                            display: '_',
                            _: null
                        };
                    }
                    dt.row.add(row).draw(false);
                },
            }, {
                name: "remove",
                extend: "remove",
                text: "حذف ردیف",
                editor: design_editor
            }
        ]
    });

    return design_table;
}

function designDTE(device, place) {
    if ( $.fn.dataTable.isDataTable( '#' + options.designTableId ) ) {
        $('#' + options.designTableId).DataTable().destroy();
        $('#' + options.designTableId).empty();
    }

    $('#part-' + options.designTableId).show();
    scrollToId('#part-' + options.designTableId, 1000);

    var design_editor = designEditor(device, place);
    var design_table = designTable(device, place, design_editor);

    $('#'+options.designTableId+' tbody').on('click', 'td.editable', function(e) {
        var colIndex = $(this).data('column');
        var colVal = $(this).data('val');
        e.stopImmediatePropagation();
        $.ajax({
            url: options.urlOptionsWidgetsSelectAjax,
            type: 'GET',
            dataType: 'json',
            success: function (json) {
                design_editor.field(colIndex).update(json);
                design_editor.field(colIndex).val(colVal);
                // if (action === 'edit') {
                //     var selected2 = table_category.row({selected: true});
                //     if (selected2.any()) {
                //         var id_selected_row2 = selected2.data().parent_id;
                //         editor_category.field('parent_id').val(id_selected_row2);
                //     }
                // }
            }
        });
        design_editor.bubble($(this));
    });
    design_editor.on('submitSuccess', function(e, json, data, action) {
        design_table.ajax.reload();
    });
    design_editor.on('postRemove', function(e, json, ids) {
        design_table.ajax.reload();
    });
}

function i18nEditor() {
    return {
        "create": {
            "button": "\u0627\u06cc\u062c\u0627\u062f",
            "title": "\u0633\u0627\u062e\u062a \u06cc\u06a9 \u0631\u06a9\u0648\u0631\u062f \u062c\u062f\u06cc\u062f",
            "submit": "\u0633\u0627\u062e\u062a\u0646"
        },
        "edit": {
            "button": "\u0648\u06cc\u0631\u0627\u06cc\u0634",
            "title": "\u0648\u06cc\u0631\u0627\u06cc\u0634 \u0631\u06a9\u0648\u0631\u062f",
            "submit": "\u0622\u067e\u062f\u06cc\u062a \u06a9\u0631\u062f\u0646"
        },
        "remove": {
            "button": "\u062d\u0630\u0641",
            "title": "\u062d\u0630\u0641 \u06a9\u0631\u062f\u0646 \u0631\u06a9\u0648\u0631\u062f",
            "submit": "\u062d\u0630\u0641",
            "confirm": {
                "_": "\u0622\u06cc\u0627 \u0645\u0637\u0645\u0626\u0646\u06cc\u062f \u06a9\u0647 \u0645\u06cc\u062e\u0648\u0627\u0647\u06cc\u062f %d \u0631\u062f\u06cc\u0641 \u0631\u0627 \u062d\u0630\u0641 \u06a9\u0646\u06cc\u062f\u061f",
                "1": "\u0622\u06cc\u0627 \u0645\u0637\u0645\u0626\u0646\u06cc\u062f \u06a9\u0647 \u0645\u06cc\u062e\u0648\u0627\u0647\u06cc\u062f \u06cc\u06a9 \u0631\u062f\u06cc\u0641 \u0631\u0627 \u062d\u0630\u0641 \u06a9\u0646\u06cc\u062f\u061f"
            }
        },
        "multi": {
            "title": "\u0645\u0642\u0627\u062f\u06cc\u0631 \u0686\u0646\u062f\u06af\u0627\u0646\u0647",
            "info": "\u0645\u0648\u0627\u0631\u062f \u0627\u0646\u062a\u062e\u0627\u0628 \u0634\u062f\u0647 \u062f\u0627\u0631\u0627\u06cc \u0645\u0642\u0627\u062f\u06cc\u0631 \u0645\u062e\u062a\u0644\u0641 \u0628\u0631\u0627\u06cc \u0627\u06cc\u0646 \u0648\u0631\u0648\u062f\u06cc \u0627\u0633\u062a. \u0628\u0631\u0627\u06cc \u0648\u06cc\u0631\u0627\u06cc\u0634 \u0648 \u062a\u0646\u0638\u06cc\u0645 \u0647\u0645\u0647 \u0627\u0642\u0644\u0627\u0645 \u0628\u0631\u0627\u06cc \u0627\u06cc\u0646 \u0648\u0631\u0648\u062f\u06cc \u0628\u0647 \u0647\u0645\u0627\u0646 \u0645\u0642\u062f\u0627\u0631\u060c \u0631\u0648\u06cc \u0622\u0646 \u06a9\u0644\u06cc\u06a9 \u06a9\u0646\u06cc\u062f \u06cc\u0627 \u0631\u0648\u06cc \u0622\u0646 \u0636\u0631\u0628\u0647 \u0628\u0632\u0646\u06cc\u062f\u060c \u062f\u0631 \u063a\u06cc\u0631 \u0627\u06cc\u0646 \u0635\u0648\u0631\u062a \u0622\u0646\u0647\u0627 \u0627\u0631\u0632\u0634 \u0647\u0627\u06cc \u0641\u0631\u062f\u06cc \u062e\u0648\u062f \u0631\u0627 \u062d\u0641\u0638 \u062e\u0648\u0627\u0647\u0646\u062f \u06a9\u0631\u062f.",
            "restore": "\u0628\u0627\u0632\u06af\u0631\u062f\u0627\u0646\u062f\u0646 \u0645\u0642\u062f\u0627\u0631",
            "noMulti": "\u0627\u06cc\u0646 \u0648\u0631\u0648\u062f\u06cc \u0645\u06cc \u062a\u0648\u0627\u0646\u062f \u0628\u0647 \u0635\u0648\u0631\u062a \u062c\u062f\u0627\u06af\u0627\u0646\u0647 \u0648\u06cc\u0631\u0627\u06cc\u0634 \u0634\u0648\u062f\u060c \u0627\u0645\u0627 \u0628\u062e\u0634\u06cc \u0627\u0632 \u06cc\u06a9 \u06af\u0631\u0648\u0647 \u0646\u06cc\u0633\u062a."
        },
        "error": {
            "system": "\u062e\u0637\u0627\u06cc\u06cc \u0631\u062e \u062f\u0627\u062f\u0647 \u0627\u0633\u062a\u060c \u0628\u0627 \u0645\u062f\u06cc\u0631 \u0633\u06cc\u0633\u062a\u0645 \u062a\u0645\u0627\u0633 \u0628\u06af\u06cc\u0631\u06cc\u062f."
        },
        "datetime": {
            "previous": "\u0642\u0628\u0644\u06cc",
            "next": "\u0628\u0639\u062f\u06cc",
            "weekdays": ["\u06cc\u06a9 \u0634\u0646\u0628\u0647", "\u062f\u0648\u0634\u0646\u0628\u0647", "\u0633\u0647 \u0634\u0646\u0628\u0647", "\u0686\u0647\u0627\u0631\u0634\u0646\u0628\u0647", "\u067e\u0646\u062c \u0634\u0646\u0628\u0647", "\u062c\u0645\u0639\u0647", "\u0634\u0646\u0628\u0647"]
        }
    };
}

function i18nTable() {
    return {
        "processing": "\u062f\u0631 \u062d\u0627\u0644 \u067e\u0631\u062f\u0627\u0632\u0634...",
        "search": "\u062c\u0633\u062a\u062c\u0648:",
        "lengthMenu": "\u0646\u0645\u0627\u06cc\u0634 _MENU_ \u0631\u06a9\u0648\u0631\u062f",
        "info": "\u0646\u0645\u0627\u06cc\u0634 _START_ \u062a\u0627 _END_ \u0627\u0632 _TOTAL_ \u0631\u06a9\u0648\u0631\u062f",
        "infoEmpty": "\u0646\u0645\u0627\u06cc\u0634 0 \u062a\u0627 0 \u0627\u0632 0 \u0631\u06a9\u0648\u0631\u062f",
        "infoFiltered": "\u0646\u0645\u0627\u06cc\u0634 0 \u062a\u0627 0 \u0627\u0632 0 \u0631\u06a9\u0648\u0631\u062f",
        "infoPostFix": " ",
        "loadingRecords": "\u062f\u0631 \u062d\u0627\u0644 \u0628\u0627\u0631\u06af\u0632\u0627\u0631\u06cc...",
        "zeroRecords": "\u0631\u06a9\u0648\u0631\u062f\u06cc \u0628\u0627 \u0627\u06cc\u0646 \u0645\u0634\u062e\u0635\u0627\u062a \u067e\u06cc\u062f\u0627 \u0646\u0634\u062f",
        "emptyTable": "\u0647\u06cc\u0686 \u062f\u0627\u062f\u0647 \u0627\u06cc \u062f\u0631 \u062c\u062f\u0648\u0644 \u0648\u062c\u0648\u062f \u0646\u062f\u0627\u0631\u062f",
        "paginate": {
            "first": "\u0627\u0628\u062a\u062f\u0627",
            "previous": "\u0642\u0628\u0644\u06cc",
            "next": "\u0628\u0639\u062f\u06cc",
            "last": "\u0627\u0646\u062a\u0647\u0627"
        },
        "aria": {
            "sortAscending": "dte_o_aria_sort_s_ascending",
            "sortDescending": "dte_o_aria_sort_s_descending"
        }
    };
}

function eventsDTE() {
    collectionDesignResourceButtons();
    collectionCategoryButtons();
    eventShowHide();
    editor_category.on('submitSuccess', function (e, json, data, action) {
        if (typeof json.reload !== 'undefined' && json.reload === true) {
            table_category.ajax.reload();
        }
        if (typeof json.search !== 'undefined') {
            table_category.ajax.reload();
            var field_index = table_category.column(json.search.field + ':name').index();
            table_category.columns([field_index]).search(json.search.regex, true, false).draw();
        }
        table_resources.ajax.reload();
    });

    editor_category.on('preOpen', function (e, mode, action) {
        $.ajax({
            url: options.urlTreeFlatCategoryAjax,
            type: 'GET',
            dataType: 'json',
            success: function (json) {
                editor_category.field('parent_id').update(json.data);

                if (action === 'create') {
                    var selected = table_category.row({selected: true});
                    if (selected.any()) {
                        var id_selected_row = selected.data().id;
                        editor_category.field('parent_id').val(id_selected_row);
                    }
                }

                if (action === 'edit') {
                    var selected2 = table_category.row({selected: true});
                    if (selected2.any()) {
                        var id_selected_row2 = selected2.data().parent_id;
                        editor_category.field('parent_id').val(id_selected_row2);
                    }
                }
            }
        });
    });

    editor_resources.on('submitSuccess', function (e, json, data, action) {
        table_category.ajax.reload();
        table_resources.ajax.reload();
        $('#part-' + options.rolesTableId).hide()
    });

    editor_resources.on('preOpen', function (e, mode, action) {
        $.ajax({
            url: options.urlTreeFlatCategoryAjax,
            type: 'GET',
            dataType: 'json',
            success: function (json) {
                editor_resources.field('category_id').update(json.data);

                if (action === 'create') {
                    var selected = table_category.row({selected: true});
                    if (selected.any()) {
                        var id_selected_row = selected.data().id;
                        editor_resources.field('category_id').val(id_selected_row);
                    }
                }

                if (action === 'edit') {
                    var selected2 = table_resources.row({selected: true});
                    if (selected2.any()) {
                        var id_selected_row2 = selected2.data().category_id;
                        editor_resources.field('category_id').val(id_selected_row2);
                    }
                }
            }
        });
    });

    /*table_category.on('select', function(e, dt, type, indexes) {
        table_resources.ajax.reload();
        if ($('#part-' + options.resourcesTableId).is(':hidden')) {
            $('#part-' + options.resourcesTableId).show();
        }
    });*/
    table_category.on('deselect', function (e, dt, type, indexes) {
        table_resources.ajax.reload();
        if ($('#part-' + options.resourcesTableId).is(':visible')) {
            $('#part-' + options.resourcesTableId).hide();
            $('#part-' + options.rolesTableId).hide();
        }
    });

    table_resources.on('deselect', function (e, dt, type, indexes) {
        // table_roles.ajax.reload();
        if ($('#part-' + options.rolesTableId).is(':visible')) {
            $('#part-' + options.rolesTableId).hide();
        }
    });

    editor_resources.dependent('type', function (val) {
        if (val === 'api' || val === 'page_api') {
            return {
                show: ['route'],
                hide: ['title_menu', 'keywords', 'content']
            };
        } else {
            return {
                show: ['title_menu', 'keywords', 'content'],
                hide: ['route']
            };
        }
    });

    $('#' + options.rolesTableId).on('change', 'input.editor-active', function () {
        editor_roles
            .edit($(this).closest('tr'), false)
            .set('status', $(this).prop('checked') ? 1 : 0)
            .submit();
    });

    // tree init table category

    var displayed = new Set([]);
    var parent_id_index = table_category.column('parent_id:name').index();

    $('#' + options.categoryTableId + ' tbody').on('click', 'tr td:first-child', function () {
        var tr = $(this).closest('tr');
        var row = table_category.row(tr);
        var id = row.data().id;
        if (displayed.has(id)) {
            displayed.delete(id);
            tr.removeClass('details')
        } else {
            displayed.add(id);
            tr.addClass('details')
        }

        var regex = "^(0";
        displayed.forEach(function (value) {
            regex = regex + "|" + value
        });
        regex = regex + ")$";
        table_category.columns([parent_id_index]).search(regex, true, false).draw()
    });

    table_category.on('init.dt', function (e, settings, json) {
        table_category.columns([parent_id_index]).search('^(0)$', true, false).draw();
        if (json.title) {
            $('#part-' + options.categoryTableId + ' div.card-header h5').text(json.title);
        }
    });

    table_resources.on('init.dt', function (e, settings, json) {
        if (json.title) {
            $('#part-' + options.resourcesTableId + ' div.card-header h5').text(json.title);
        }
    });

    table_roles.on('init.dt', function (e, settings, json) {
        if (json.title) {
            $('#part-' + options.rolesTableId + ' div.card-header h5').text(json.title);
        }
    });
}

function collectionDesignResourceButtons() {
    table_resources.on('select', function (e, dt, type, indexes) {
        var selected = table_resources.row({
            selected: true
        });
        if (selected.any() && typeof selected.data().type !== 'undefined' && (selected.data().type === 'page' || selected.data().type === 'page_api')) {
            dt.buttons('btn_desktop_header:name').enable();
            dt.buttons('btn_desktop_top_main:name').enable();
            dt.buttons('btn_desktop_bottom_main:name').enable();
            dt.buttons('btn_desktop_sidebar_main:name').enable();
            dt.buttons('btn_desktop_sidebar_aid:name').enable();
            dt.buttons('btn_desktop_bottom:name').enable();
            dt.buttons('btn_desktop_footer:name').enable();
            dt.buttons('btn_tablet_header:name').enable();
            dt.buttons('btn_tablet_top_main:name').enable();
            dt.buttons('btn_tablet_bottom_main:name').enable();
            dt.buttons('btn_tablet_sidebar_main:name').enable();
            dt.buttons('btn_tablet_sidebar_aid:name').enable();
            dt.buttons('btn_tablet_bottom:name').enable();
            dt.buttons('btn_tablet_footer:name').enable();
            dt.buttons('btn_mobile_header:name').enable();
            dt.buttons('btn_mobile_top_main:name').enable();
            dt.buttons('btn_mobile_bottom_main:name').enable();
            dt.buttons('btn_mobile_sidebar_main:name').enable();
            dt.buttons('btn_mobile_sidebar_aid:name').enable();
            dt.buttons('btn_mobile_bottom:name').enable();
            dt.buttons('btn_mobile_footer:name').enable();
        }
    });

    table_resources.on('deselect', function (e, dt, type, indexes) {
        dt.buttons('btn_desktop_header:name').disable();
        dt.buttons('btn_desktop_top_main:name').disable();
        dt.buttons('btn_desktop_bottom_main:name').disable();
        dt.buttons('btn_desktop_sidebar_main:name').disable();
        dt.buttons('btn_desktop_sidebar_aid:name').disable();
        dt.buttons('btn_desktop_bottom:name').disable();
        dt.buttons('btn_desktop_footer:name').disable();
        dt.buttons('btn_tablet_header:name').disable();
        dt.buttons('btn_tablet_top_main:name').disable();
        dt.buttons('btn_tablet_bottom_main:name').disable();
        dt.buttons('btn_tablet_sidebar_main:name').disable();
        dt.buttons('btn_tablet_sidebar_aid:name').disable();
        dt.buttons('btn_tablet_bottom:name').disable();
        dt.buttons('btn_tablet_footer:name').disable();
        dt.buttons('btn_mobile_header:name').disable();
        dt.buttons('btn_mobile_top_main:name').disable();
        dt.buttons('btn_mobile_bottom_main:name').disable();
        dt.buttons('btn_mobile_sidebar_main:name').disable();
        dt.buttons('btn_mobile_sidebar_aid:name').disable();
        dt.buttons('btn_mobile_bottom:name').disable();
        dt.buttons('btn_mobile_footer:name').disable();
    });
}

function collectionCategoryButtons() {
    table_category.on('select', function (e, dt, type, indexes) {
        var selected = table_category.row({
            selected: true
        });
        if (selected.any()) {
            dt.buttons('btn_show_resources:name').enable();
        }
    });

    table_category.on('deselect', function (e, dt, type, indexes) {
        dt.buttons('btn_show_resources:name').disable();
    });
}

function scrollToId(target, duration) {
    $('html, body').animate(
        {
            scrollTop: $(target).offset().top
        },
        duration
    );
}

function columnsDevice(device) {
    if (device === 'desktop') {
        return [
            {
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false
            },
            {
                name: "1",
                data: "1",
                title: "1",
                render: function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                className: "dt-center editable",
                orderable: false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                name: "2",
                data: "2",
                title: "2",
                render: function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                className: "dt-center editable",
                orderable: false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "3",
                "data": "3",
                "title": "3",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "4",
                "data": "4",
                "title": "4",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "5",
                "data": "5",
                "title": "5",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "6",
                "data": "6",
                "title": "6",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "7",
                "data": "7",
                "title": "7",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "8",
                "data": "8",
                "title": "8",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "9",
                "data": "9",
                "title": "9",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "10",
                "data": "10",
                "title": "10",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "11",
                "data": "11",
                "title": "11",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "12",
                "data": "12",
                "title": "12",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            }
        ];
    }

    if (device === 'tablet') {
        return [
            {
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false
            },
            {
                "name": "1",
                "data": "1",
                "title": "1",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "2",
                "data": "2",
                "title": "2",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "3",
                "data": "3",
                "title": "3",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "4",
                "data": "4",
                "title": "4",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "5",
                "data": "5",
                "title": "5",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "6",
                "data": "6",
                "title": "6",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "7",
                "data": "7",
                "title": "7",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "8",
                "data": "8",
                "title": "8",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            }
        ];
    }

    if (device === 'mobile') {
        return [
            {
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false
            },
            {
                "name": "1",
                "data": "1",
                "title": "1",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "2",
                "data": "2",
                "title": "2",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "3",
                "data": "3",
                "title": "3",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            },
            {
                "name": "4",
                "data": "4",
                "title": "4",
                "render": function (data, type, row, meta) {
                    if (type === 'display') return data.display;
                    return data._
                },
                "className": "dt-center editable",
                "orderable": false,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).attr('data-column', col);
                    $(td).attr('data-val', cellData._);
                }
            }
        ];
    }
}

function fieldsDevice(device) {
    if (device === 'desktop') {
        return [{
            data: "1._",
            name: "1",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "2._",
            name: "2",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "3._",
            name: "3",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "4._",
            name: "4",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "5._",
            name: "5",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "6._",
            name: "6",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "7._",
            name: "7",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "8._",
            name: "8",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "9._",
            name: "9",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "10._",
            name: "10",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "11._",
            name: "11",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "12._",
            name: "12",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }];
    }

    if (device === 'tablet') {
        return [{
            data: "1._",
            name: "1",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "2._",
            name: "2",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "3._",
            name: "3",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "4._",
            name: "4",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "5._",
            name: "5",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "6._",
            name: "6",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "7._",
            name: "7",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "8._",
            name: "8",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }];
    }

    if (device === 'mobile') {
        return [{
            data: "1._",
            name: "1",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "2._",
            name: "2",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "3._",
            name: "3",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }, {
            data: "4._",
            name: "4",
            type: "select2",
            options: [],
            opts: {
                placeholder: "انتخاب کنید"
            }
        }];
    }
}

function eventShowHide() {
    $('#part-' + options.resourcesTableId).on('hide', function () {
        $('#part-' + options.rolesTableId).hide();
        $('#part-' + options.designTableId).hide();
    });

    table_resources.on('deselect', function (e, dt, type, indexes){
        $('#part-' + options.designTableId).hide();
    });
}