<!-- Page-header start -->
<div class="page-header card">
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">
        <div class="col-lg-4">
            <div class="card" id="part-{{ currencyTable.getName }}">
                <div class="card-header">
                </div>
                <div class="card-block">
                    {{ categoryTable.render() }}
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card" id="part-{{ currencyTable.getName }}">
                <div class="card-header">
                </div>
                <div class="card-block">
                    {{ currencyTable.render() }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="part-{{ currencyTable.getName }}">
                <div class="card-header">
                </div>
                <div class="card-block">
                    {{ priceTable.render() }}
                </div>
            </div>
        </div>
    </div>
</div>