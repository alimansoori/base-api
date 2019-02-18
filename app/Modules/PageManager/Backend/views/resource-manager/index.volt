<!-- Page-header start -->
<div class="page-header card horizontal-layout-icon menu-rtl" style="text-align: right;">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title" style="float: right;">
                <i class="icofont icofont-navigation-menu bg-c-pink "></i>
                <div class="d-inline">
                    <h4>مدیریت منابع</h4>
                    <span>در این بخش شما قادر خواهید بود تمام منابع موجود در پرتال را مدیریت کنید.</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ static_url('dashboard') }}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">مدیریت منابع</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">
        <div class="col-lg-3">
            <div class="card" id="part-ilya-category-resource">
                <div class="card-header" style="text-align: right;">
                    <h5></h5>
                </div>
                <div class="card-block">
                    <table id="ilya-category-resource" class="display row-border cell-border" style="width: 100%"></table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card" id="part-ilya-resources" style="display: none">
                <div class="card-header" style="text-align: right;">
                    <h5></h5>
                </div>
                <div class="card-block">
                    <table id="ilya-resources" class="display row-border cell-border" style="width: 100%"></table>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card" id="part-ilya-resource-roles" style="display: none;">
                <div class="card-header" style="text-align: right;">
                    <h5></h5>
                </div>
                <div class="card-block">
                    <table id="ilya-resource-roles" class="display row-border cell-border" style="width: 100%"></table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="part-ilya-design-pages" style="display: none">
                <div class="card-header" style="text-align: right;">
                    <h5></h5>
                </div>
                <div class="card-block">
                    <table id="ilya-design-pages" class="display row-border cell-border" style="width: 100%"></table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        resourcesManagerInit({
            categoryTableId: 'ilya-category-resource',
            resourcesTableId: 'ilya-resources',
            rolesTableId: 'ilya-resource-roles',
            designTableId: 'ilya-design-pages',
            urlAjax: '{{ config.app.baseUri }}api/resources/categories',
            urlResourcesAjax: '{{ config.app.baseUri }}api/resources',
            urlRolesAjax: '{{ config.app.baseUri }}api/resource-roles',
            urlDesignAjax: '{{ config.app.baseUri }}api/resource-design',
            urlTreeFlatCategoryAjax: '{{ config.app.baseUri }}api/category-resources/tree-flat',
            urlOptionsWidgetsSelectAjax: '{{ config.app.baseUri }}api/resource-design/widgets'
        });
    });
</script>