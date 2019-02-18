function paginationADS(ajaxUrl, baseUri) {
    paginationRequest(baseUri, ajaxUrl, {
        action: 'create',
        data: [
            getUrlVars()
        ]
    });
}

function paginationRequest(baseUri, ajaxUrl, data) {
    $.ajax({
        url: ajaxUrl,
        dataType: 'json',
        data: data,
        success: function (json) {
            paginationInit(json);
        }
    });
}

function paginationInit(json) {
    var container = $("#pagination-ad");
    container.empty();
    container.pagination({
        dataSource: json.data,
        totalNumber: json.totalNumber,
        pageSize: json.pageSize,
        pageNumber: json.pageNumber,
        autoHidePrevious: true,
        autoHideNext: true,
        callback: function (data, pagination) {
            var html = simpleTemplating(data, baseUri);
            container.prev().html(html);
        }
    });

    paginationEvents(container);
}

function paginationEvents(container) {
    container.addHook('afterPaging', function(pageNumber) {
        var newUrl = updateURLParameter(window.location.href, 'page', pageNumber);
        history.pushState('', "", newUrl);
    });
}

function simpleTemplating(data, baseUri) {
    var html = '';

    $.each(data, function (index, item) {
        var imageUrl = baseUri + 'img/no_image.png';
        if (item['image']) {
            imageUrl = baseUri + 'static/image/' + item['image'];
        }

        html += '<a href="'+baseUri+'ad/preview/'+item["id"]+'" class="box-c2">';
        html += '<div class="box-c2__text">';
        html += '<div class="box-c2__text--header">';
        html += item.title;
        html += '</div>';
        html += '<div class="box-c2__text--des">';
        html += 'آدرس';
        html += '</div>';
        html += '<div>';
        html += '<button class=" box-c2__text--tags box-c2__text--tags-secondary ">';
        html += 'فوری';
        html += '</button>';
        html += '<button class="box-c2__text--tags box-c2__text--tags-primary">';
        html += 'چت';
        html += '</button>';
        html += '</div>';
        html += '</div>';
        html += '<img src="'+imageUrl+'" alt="advbox" class="box-c2__img" />';
        html += '</a>';
    });

    return html;
}