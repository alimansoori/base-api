<div class="main-widget main-widget-2">
    <div class="ilya-selector ilya-menu" id="category-select">
        <div class="ilya-menu-select ">
        </div>
        <div class="ilya-menu-content">
        </div>
    </div>
</div>
<div id="new_panel"></div>
<script>
    $(document).ready(function () {
        var translate = {
            i18n: {
                create: {
                    button: "{{ t._('dte_create_button') }}",
                    title: "{{ t._('dte_create_title') }}",
                    submit: "{{ t._('dte_create_submit') }}"
                },
                edit: {
                    button: "{{ t._('dte_edit_button') }}",
                    title: "{{ t._('dte_edit_title') }}",
                    submit: "{{ t._('dte_edit_submit') }}"
                },
                remove: {
                    button: "{{ t._('dte_remove_button') }}",
                    title: "{{ t._('dte_remove_title') }}",
                    submit: "{{ t._('dte_remove_submit') }}",
                    confirm: {
                        _: "{{ t._('dte_remove_multi_confirm') }}",
                        1: "{{ t._('dte_remove_one_confirm') }}"
                    }
                },
                multi: {

                }
            }
        };
        newAd("{{ config.app.baseUri }}");
    });
</script>