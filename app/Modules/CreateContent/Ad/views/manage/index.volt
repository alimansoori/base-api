<!-- Page-header start -->
<div class="page-header card">
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    {{ tableCategory.render() }}
                </div>
            </div>
            <div class="card" id="part_{{ tableAd.getName() }}" style="display: none;">
                <div class="card-block">
                    {{ tableAd.render() }}
                </div>
            </div>
            <div class="card" id="part_{{ tableAdImages.getName() }}" style="display: none;">
                <div class="card-block">
                    {{ tableAdImages.render() }}
                </div>
            </div>
        </div>
    </div>
</div>