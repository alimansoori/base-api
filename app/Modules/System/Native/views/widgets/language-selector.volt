{#<div class="lang-select-{{ region }}-{{ place }}">#}
    {#{{ region }}#}
    {#<br>#}
    {#{{ place }}#}
{#</div>#}
{{ assetsCollection.addInlineCss("."~params['area']~"{grid-area: "~params['area']~";}") }}
<div class="{{ params['area'] }}">{{ 'lang selector' }}</div>