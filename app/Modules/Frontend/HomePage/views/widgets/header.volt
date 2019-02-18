{#{{ assetsCollection.addCss('ilya-theme/ui/assets/css/laptop/style.css') }}#}
{{ assetsCollection.addInlineCss("#"~params['area']~"{grid-area: "~params['area']~";}") }}
{{ assetsCollection.addInlineCss("."~params['area']~"{padding: 1rem; display: grid; grid-template-columns: [start] repeat(12,minmax(0,1fr)) [end]; grid-template-rows: repeat(auto-fit, minmax(0, min-content)); align-content: start; grid-row-gap: 15px; position: relative;}") }}
<div id="{{ params['area'] }}" class="{{ params['area'] }}">
    <div id="logoimg">
        <img src="{{ static_url('img/logo.png') }}" alt="logo" class="logo-simple">
    </div>

    <div class="searchbar-simple" id="searchallsite">
        <input type="text" class="searchbar-simple__input" placeholder="جستجو در تمام سایت...">
        <a href="#" class="btn-search">
            <i class="fal fa-search searchbar-simple__icon"></i>
        </a>
    </div>

    <div id="advadd">
        {{ session_editor_ad_new.render() }}
    </div>

    <div class="navbar-simple">
        <ul class="navbar-simple__ul">
            <li class="navbar-simple__li">
                <a href="{{ static_url('ads') }}">آگهی‌ها</a>
            </li>
            <li class="navbar-simple__li">
                <a href="{{ static_url('prices') }}">قیمت‌ها</a>
            </li>
            <li class="navbar-simple__li">
                <a href="{{ static_url('fees') }}">تعرفه‌ها</a>
            </li>
        </ul>
    </div>

    <div class="navbar-fixed">
        <ul class="navbar-fixed__ul">
            <li class="navbar-fixed__li">
                {{ session_editor.render() }}
            </li>
            <li class="navbar-fixed__li">
                <a href="{{ static_url('about') }}">درباره ما</a>
            </li>
            <li class="navbar-fixed__li">
                <a href="{{ static_url('contact') }}">تماس با ما</a>
            </li>
        </ul>
    </div>
</div>