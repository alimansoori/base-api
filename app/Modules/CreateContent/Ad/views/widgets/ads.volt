{{ assetsCollection.addInlineCss("."~params['area']~"{grid-area: "~params['area']~";}") }}
<div class="{{ params['area'] }}">
    {{ search.render() }}
    <div id="panels"></div>
</div>