{#<div>
    <div id="category"></div>
    <div id="search_panel"></div>
</div>
<div id="panels">
    <div id="panel_list"></div>
</div>
<script>
    $(document).ready(function () {
        searchAds("{{ config.app.baseUri }}");
    });
</script>#}

<div id="ilya-template-search">
    <div id="ilya-template-search-default-bottom">
        <editor-field name="image"></editor-field>
        <editor-field name="promotions"></editor-field>
    </div>
</div>

<div class="main-widget main-widget-1">
    <div class="main-widget-sidebar">
        <div class="sidebar-simple">
            <div id="ilya-sidebar__fixed" class="ilya-menu"></div>

            <div id="ilya-sidebar__fixed--show" ilya-show="false" class="ilya-menu" style="direction:rtl">
            </div>
        </div>
    </div>
    <div class="main-widget-content" id="main-widget-content">
        <div class="searchbar-full" id="serchbarfull">
        </div>
        <div class="box-container" id="boxcontainer"></div>
        <div class="pagination-ad" id="pagination-ad" style="direction: ltr"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        searchAds("{{ config.app.baseUri }}");
    });
</script>