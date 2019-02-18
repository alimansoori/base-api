{#<div id="menu-push-level-list" class="menu-push-level-list">#}
    {#{% for title,nav in menu_list %}#}
        {#{% if nav['res'] is not empty %}#}
            {#<div id="menu-push-{{ title }}">#}
                {#<nav>#}
                    {#<h2><i class="fa fa-reorder"></i>{{ title }}</h2>#}
                    {#{{ nav['res'] }}#}
                {#</nav>#}
            {#</div>#}
        {#{% endif %}#}
    {#{% endfor %}#}
{#</div>#}

{{ assetsCollection.addInlineCss("."~params['area']~"{grid-area: "~params['area']~";}") }}
<div class="{{ params['area'] }}">{{ 'admin menu' }}</div>