var adEditor;
var baseUri;
var MultiMenuCat;
function newAd(baseUrl) {
    baseUri = baseUrl;
    MultiMenuCat = multiMenuCat();

    MultiMenuCat.onChangeEnd = function() {
        // only children with role = end  run this code
        var id = MultiMenuCat.getId();
        editorAd();
        initEditor(id);
        editorEventsNew();
        // $('#category-select').hide();
    };

    MultiMenuCat.onChangeSelect = function() {
        adEditor.close();
    };
}

function multiMenuCat() {
    return new IlyaSeclector('selector1', '#category-select', baseUri+ 'api/ad/get/menu/category'); // const MultiMenu2 = new IlyaMenuMulti('multi22', '#sample4', link1);
}

function editorAd() {
    adEditor = new $.fn.dataTable.Editor({
        ajax: {
            url: baseUri + "api/ad/new",
            type: 'POST'
        },
        display: onPageDisplay($('#new_panel')),
        fields: [
            {
                label: 'Title',
                name: 'title',
                data: 'title',
                type: 'text'
            },
            {
                label: 'Description',
                name: 'description',
                data: 'description',
                type: 'textarea'
            },
            {
                label: 'Images',
                name: "files[].id",
                type: "uploadMany",
                display: function (fileId, counter) {
                    return '<img src="'+adEditor.file( 'files', fileId ).web_path+'"/>';
                },
                noFileText: 'No images',
                ajax: {
                    url: baseUri + 'api/ad/image/upload',
                    type: 'POST'
                }
            }
        ]
    });
}

function onPageDisplay(elm) {
    var name = 'onPage' + Math.random();
    var Editor = $.fn.dataTable.Editor;
    var emptyInfo;
    Editor.display[name] = $.extend(!0, {}, Editor.models.display, {
        init: function(editor) {
            emptyInfo = elm.html();
            return Editor.display[name]
        },
        open: function(editor, form, callback) {
            elm.children().detach();
            elm.append(form);
            if (callback) {
                callback()
            }
        },
        close: function(editor, callback) {
            elm.children().detach();
            elm.html(emptyInfo);
            if (callback) {
                callback()
            }
        }
    });
    return name
}

function initEditor(cat_id) {
    $.ajax({
        url: baseUri+ 'api/fields-editor/',
        type: 'POST',
        data: {
            category_id: cat_id,
            action: 'create'
        },
        success: function (json) {
            json.fields.forEach(function(options) {
                if (options.type === 'range'){
                    options.type = 'text';
                }

                if (options.type === 'price'){
                    options.isSearch = false;
                }

                if (options.type === 'select_range'){
                    options.type = 'select2';
                }

                if (options.type === 'select2'){
                    options.opts = {
                        placeholder: 'انتخاب کنید'
                    };
                }
                adEditor.add(options);
            });

            createEditorNew();
        },
        statusCode: {
            404: function() {
                alert('page not found')
            }
        }
    });
}

function createEditorNew() {
    adEditor.create({
        title: 'ایجاد آگهی جدید',
        buttons: [
            {
                text: 'ثبت',
                fn: function () {
                    this.submit();
                }
            }
        ]
    });
}

function editorEventsNew() {
    adEditor.on('onSubmitSuccess', function (e, json, data, action) {
        if (action === 'create') {
            window.location.replace(baseUri + "ad/preview/" + json.data.id);
        }
    });
}