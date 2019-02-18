var adEditor;
var adTable;
function editAd(editId, baseUri) {
    editorAd(editId, baseUri);
    tableAd(editId, baseUri);

    tableEvents(editId, baseUri);

    editorEvents(editId, baseUri);
}

function editorAd(editId, baseUri) {
    adEditor = new $.fn.dataTable.Editor({
        ajax: {
            url: baseUri + "api/ad/edit/"+editId,
            type: 'POST'
        },
        display: onPageDisplay($('#new_panel')),
        table: '#ad_table',
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

function tableAd(editId, baseUri) {
    adTable = $('#ad_table').DataTable({
        dom: 't',
        ajax: {
            url: baseUri + "api/get/ad/edit/" + editId
        },
        columns: [
            {
                data: 'title',
            },
            {
                data: "files",
                render: function ( d ) {
                    return d.length ?
                        d.length+' image(s)' :
                        'No image';
                },
                title: "Image"
            }
        ],
        select: true
    });
}

function createEditor(tr) {
    adEditor.edit(
        tr,
        'Edit',
        [
            {
                "label": "Update row",
                "fn": function () {
                    adEditor.submit();
                }
            }
        ]
    );
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

function tableEvents(editId, baseUri) {
    adTable.on('init.dt', function () {
        var tr = document.getElementById(editId);

        $.ajax({
            url: baseUri+ 'api/fields-editor/' + editId,
            type: 'POST',
            data: {
                action: 'edit'
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

                createEditor(tr);
            }
        });
    });
}

function editorEvents(editId, baseUri) {
    adEditor.on('onSubmitSuccess', function (e, json, data, action) {
        if (action === 'edit') {
            window.location.replace(baseUri + "ad/preview/" + editId);
        }
    });
}