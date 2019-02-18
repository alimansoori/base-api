{#{{ assetsCollection.addCss('ilya-theme/ui/assets/css/com-header.css') }}#}
{{ assetsCollection.addInlineCss("#"~params['area']~"{grid-area: "~params['area']~";}") }}
{{ assetsCollection.addInlineCss("."~params['area']~"{display: grid; grid-template-columns: [start] repeat(3, minmax(0, 1fr)) [end]; grid-template-rows: repeat(auto-fit, minmax(0, min-content)); align-content: start; grid-column-gap: 1rem;}") }}
<div id="{{ params['area'] }}" class="{{ params['area'] }}">
    <form action="#" class="email-news">
        <div class="email-news__description">
            <i class="fal fa-envelope-open"></i>
            <label for="envelope">خبرنامه ایمیلی</label>
        </div>

        <label class="email-news__label" for="emailname-news"
        >ایمیل خود را وارد کنید</label
        >
        <div class="email-news-container">
            <div class="email-news-container__btnsubmit">
                <i id="envelope" class="fal fa-paper-plane"></i>
            </div>
            <input
                    class="email-news-container__input"
                    type="text"
                    id="emailname-news"
                    name="firstname"
                    placeholder="example: info@ilyaidea.ir"
            />
        </div>
    </form>
    <div class="ilya-follow">
        <div class="ilya-follow__header">
            ما را در فضای مجازی دنبال کنید.
        </div>

        <div class="ilya-follow__icons">
            <ul class="ilya-follow__icons--box">
                <li class="ilya-follow__icons--item">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </li>
                <li class="ilya-follow__icons--item">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </li>
                <li class="ilya-follow__icons--item">
                    <a href="#"><i class="fab fa-telegram"></i></a>
                </li>
                <li class="ilya-follow__icons--item">
                    <a href="#"><i class="fab fa-facebook-square"></i></a>
                </li>
                <li class="ilya-follow__icons--item">
                    <a href="#"><i class="fab fa-google-plus-g"></i></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="footer3">
        توضیحات
    </div>
</div>