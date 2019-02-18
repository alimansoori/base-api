{{ assetsCollection.addInlineCss("."~params['area']~"{grid-area: "~params['area']~";}") }}
<div class="{{ params['area'] }}">
    {{ prices_table.render() }}
</div>

