var searchEditor;
var baseUri;
var searchUrl;
var configSearch = {
    page: 1
};
function searchAds(baseUrl) {
    baseUri = baseUrl;
    searchUrl = baseUri + 'api/ad/search';

    searchEditorAd();
    paginationADS(searchUrl, baseUri);

    initEditorSearch(getCategory());
    initMenu();
    //
    // createPanelAjax({
    //     action: 'create',
    //     data: [
    //         getUrlVars()
    //     ]
    // });
    //
    // BtnMoreClick();
    //
    editorEventsSearch();
}

function searchEditorAd() {
    searchEditor = new $.fn.dataTable.Editor({
        ajax: {
            url: searchUrl,
            type: 'GET'
        },
        display: onPageDisplay($('#serchbarfull')),
        template: '#ilya-template-search'
    });
}

function initEditorSearch(cat_id) {
    $.ajax({
        url: baseUri+ 'api/fields-search',
        type: 'POST',
        data: {
            category_id: cat_id,
            query: getUrlVars(),
            action: 'create'
        },
        success: function (json) {
            var newUrl = window.location.href;
            if (cat_id)
                newUrl = updateURLParameter(window.location.href, 'category_id', cat_id);
            else
                newUrl = removeURLParameter(window.location.href, 'category_id');

            history.pushState('', "", newUrl);

            searchEditor.clear();
            json.fields.forEach(function(field) {
                if (field.type === 'select2'){
                    field.opts = {
                        placeholder: 'انتخاب کنید'
                    };
                }

                if (!$("editor-field[name='"+field.name+"']").length)
                    $('#ilya-template-search').prepend('<editor-field name="'+field.name+'"></editor-field>');

                searchEditor.add(field);
            });

            searchEditor.add({
                name: 'image',
                type: 'checkbox',
                className: 'ilya-checkbox-search',
                options: [
                    {
                        label: 'عکس‌دار',
                        value: 1
                    }
                ],
                separator: '|'
            });

            var urlParams = new URLSearchParams(location.search);
            if (urlParams.get('image') && parseInt(urlParams.get('image')) === 1)
                searchEditor.field('image').def(1);
            else {
                newUrl = removeURLParameter(newUrl, 'image');
                history.pushState('', "", newUrl);
            }

            searchEditor.add({
                name: 'promotions',
                type: 'checkbox',
                className: 'ilya-checkbox-search',
                options: [
                    {
                        label: 'فوری',
                        value: 1
                    }
                ],
                separator: '|'
            });

            if (urlParams.get('promotions') && parseInt(urlParams.get('promotions')) === 1)
                searchEditor.field('promotions').def(1);
            else {
                newUrl = removeURLParameter(newUrl, 'promotions');
                history.pushState('', "", newUrl);
            }

            createEditorSearch();
        },
        statusCode: {
            404: function() {
                alert('page not found')
            }
        }
    });
}

function BtnMoreClick() {
    createBtnExtraItems();
    $('body').on('click', '#extra_items',function(e) {
        e.preventDefault();
        $('#extra_items').remove();
        createLoader();
        $.ajax( {
            url: searchUrl,
            dataType: 'json',
            data: {
                action: 'create',
                data: [
                    $.extend(
                        {page:configSearch.page + 1},
                        getUrlVars()
                    )
                ]
            },
            success: function ( json ) {
                $('div.box-c2').remove();
                for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                    createPanel( json.data[i] );
                }
                $('#post_loading').remove();

                configSearch.page = configSearch.page + 1;
                var newUrl = updateURLParameter(window.location.href, 'page', configSearch.page);
                history.pushState('', "", newUrl);
            }
        });
        createBtnExtraItems();
    } );
}

function createEditorSearch() {
    searchEditor.create({
        title: 'Search Ads',
        buttons: [
            {
                text: 'جستجو',
                className: 'btn_search',
                fn: function () {
                    var that = this;
                    var fields = this.fields();
                    that.submit();

                    var params = {};
                    $.each(fields, function (index, field) {
                        that.field(field).def(
                            that.field(field).val()
                        );
                        params[field] = that.field(field).val();
                        if (typeof that.field(field).val() === 'object'){
                            params[field] = JSON.stringify(that.field(field).val());
                        }
                    });

                    // var esc = encodeURIComponent;
                    var esc = decodeURIComponent;
                    var query = Object.keys(params)
                        .map(k => esc(k) + '=' + esc(params[k]))
                        .join('&');

                    history.pushState('', "", "?" + query);

                    initEditorSearch(getCategory());
                }
            }
        ]
    });
}

function editorEventsSearch() {
    searchEditor.on('onSubmitSuccess', function (e, json, data, action) {
        if (action === 'create') {
            paginationInit(json);
            // $('div.panel').remove();
            // for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
            //     createPanel( json.data[i] );
            // }
            configSearch.page = 1;
        }
    });

}

function createLoader() {
    if ($('#post_loading').length) {
        return
    }
    $('<div id="post_loading" class="ui active centered inline loader"></div>').appendTo('#main-widget-content')
}

function createPanelAjax(data) {
    $.ajax( {
        url: searchUrl,
        dataType: 'json',
        data: data,
        success: function ( json ) {
            for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                createPanel( json.data[i] );
            }
        }
    } );
}

function createPanel(data) {
    var imageUrl = baseUri + 'img/no_image.png';
    if (data['image']) {
        imageUrl = baseUri + 'static/image/' + data['image'];
    }
    $(
        '<a href="" class="box-c2">' +
        '<div class="box-c2__text">' +
        '<div class="box-c2__text--header">' +
        data.title +
        '</div>' +
        '<div class="box-c2__text--des">' +
        'آدرس' +
        '</div>' +
        '<div>' +
        '<button class=" box-c2__text--tags box-c2__text--tags-secondary ">' +
        'فوری' +
        '</button>' +
        '<button class="box-c2__text--tags box-c2__text--tags-primary">' +
        'چت' +
        '</button>' +
        '</div>' +
        '</div>' +
        '<img src="'+imageUrl+'" alt="advbox" class="box-c2__img" />' +
        '</a>'
    ).appendTo( '#boxcontainer' );
}

function getCategory() {
    var urlParams = new URLSearchParams(location.search);
    return parseInt(urlParams.get('category_id'));
}

function createBtnExtraItems () {
    if($('#extra_items').length){
        return;
    }
    $(
        '<button id="extra_items">دیدن موارد بیشتر</button>'
    ).appendTo( '#main-widget-content' );
}

function getUrlVars() {
    var vars = {}, hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars[hash[0]] = decodeURIComponent(hash[1]);
    }
    return vars;
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

function initMenu() {
    var url = baseUri + 'api/ad/get/menu/category';
    // var url = baseUri + 'api/input';

    var menu;
    if (getCategory()) {
        menu = new SideMenu('-menu', '#ilya-sidebar__fixed--show', 'no_header', url, getCategory(), null);
    } else {
        menu = new SideMenu('-menu', '#ilya-sidebar__fixed--show', 'no_header', url, null, null);
    }

    menu.setCallback(function() {
        var id = parseInt(menu.getId());
        initEditorSearch(id);
        $('div.box-c2').remove();

        var newUrl = window.location.href;
        newUrl = removeURLParameter(newUrl, 'page');
        if (id)
            newUrl = updateURLParameter(newUrl, 'category_id', id);
        else
            newUrl = removeURLParameter(newUrl, 'category_id');

        history.pushState('', "", newUrl);

        paginationRequest(baseUri,searchUrl, {
            action: 'create',
            data: [
                getUrlVars()
            ]
        });
    });
}

function updateURLParameter(url, param, paramVal) {
    var TheAnchor = null;
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";

    if (additionalURL)
    {
        var tmpAnchor = additionalURL.split("#");
        var TheParams = tmpAnchor[0];
        TheAnchor = tmpAnchor[1];
        if(TheAnchor)
            additionalURL = TheParams;

        tempArray = additionalURL.split("&");

        for (var i=0; i<tempArray.length; i++)
        {
            if(tempArray[i].split('=')[0] != param)
            {
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }
    else
    {
        var tmpAnchor = baseURL.split("#");
        var TheParams = tmpAnchor[0];
        TheAnchor  = tmpAnchor[1];

        if(TheParams)
            baseURL = TheParams;
    }

    if(TheAnchor)
        paramVal += "#" + TheAnchor;

    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}

function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split('?');
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }

        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
    }
    return url;
}
