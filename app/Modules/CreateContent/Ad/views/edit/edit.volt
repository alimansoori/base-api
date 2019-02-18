<div id="new_panel">
    {#{{ newEditor.render() }}#}
    <table id="ad_table" style="display: none;"></table>
</div>

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
        editAd(23, "{{ config.app.baseUri }}");
    });
</script>