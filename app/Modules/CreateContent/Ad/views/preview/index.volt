<div class="main-widget-4 ilya-present">
    {% if detail_ad['owner'] == 1 %}
        <div class="tab-step ilya-present-tab__step">
            <div class="tl">
                <ul class="tl_btns" id="ilya-steps">
                    <li class="" id="ilya-steps--1"><span>ثبت شده</span></li>
                    <li class="" id="ilya-steps--2"><span>تأیید شماره</span></li>
                    <li class="" id="ilya-steps--3"><span> در انتظار بررسی</span></li>
                    <li class="" id="ilya-steps--4"><span>انتشار</span></li>
                </ul>
                <div class="tl_c-w" id="ilya-steps-content">
                    <div class="ilya-step-content" id="ilya-steps-content--1">
                        content1
                    </div>
                    <div class="ilya-step-content" id="ilya-steps-content--2">
                        <p>پیامک کد تأیید به شماره موبایل شما ارسال خواهد شد. لطفا کد را در اینجا وارد کنید.</p>
                        <label>کد تأیید</label>
                        <br>
                        <input>
                        <br>
                        <button class="ilya-button small">تأیید</button>
                        <br>
                        <a href="">درخواست دوباره کد تأیید</a>
                    </div>
                    <div class="ilya-step-content" id="ilya-steps-content--3">
                        content3
                    </div>
                    <div class="ilya-step-content show-content" id="ilya-steps-content--4">
                        content4
                    </div>
                </div>
            </div>
        </div>
    {% endif %}

    <div class=" tab-menu ilya-present-tab__menu">
        <div id="ilya-tab-place" class="tab-container">
            {% if detail_ad['owner'] == 1 %}
                <div class="ilya-tab-steps">
                </div>
            {% endif %}
            <div class=" ilya-present-tab-content">
                <div class="content1 bvisible" id="content1">
                    <div class="image-card ">
                        <div class="one-column">
                            <div class="image-card--header">{{ detail_ad['title'] }}</div>
                            <div class="image-card--meta">شرکت</div>
                            <div class="ilya-button">
                                <button class="ilya-button-dark ilya-button small">دریافت اطلاعات تماس</button>
                                <button class="ilya-button-light ilya-button small">نشان کردن</button>
                            </div>
                            <div class="ilya-adv-Specifications">
                                {% if detail_ad['details'] is not empty %}
                                    {% for title,value in detail_ad['details'] %}
                                        <div class="adv-row">
                                            <div class="ilya-adv-Specifications--title">{{ title }}</div>
                                            <div class="ilya-adv-Specifications--value">{{ value }}</div>
                                        </div>
                                        <hr>
                                    {% endfor %}
                                {% endif %}
                            </div>
                            <div class="image-card--description">{{ detail_ad['description'] }}</div>
                        </div>
                        <div class="tow-column">
                            <div class="image-card--image">
                                {% if detail_ad['images'] is empty %}
                                <img src="https://files.divarcdn.com/classified/classified_static_files/img/no-picture.c9f1ee9b846c.png">
                                {% else %}
                                    {% for img in detail_ad['images'] %}
                                        <img src="{{ url.get(img['web_path']) }}"/>
                                        {% break %}
                                    {% endfor %}
                                {% endif %}
                            </div>
                        </div>
                    </div>
                </div>
                {% if detail_ad['owner'] == 1 %}
                    <div class="content2" id="content2">
                        <p>آیا مایل به ویرایش آگهی هستید؟
                            <a href="{{ url.get('ad/edit/'~detail_ad['id']) }}" class="ilya-button small">ویرایش</a>
                        </p>
                    </div>
                    <div class="content3" id="content3">
                        در انتظار بررسی ناظر
                    </div>
                    <div class="content4" id="content4">
                        <p>آیا مایل به حذف آگهی هستید؟
                            <button class="ilya-button small">حذف آگهی</button>
                        </p>
                    </div>
                {% endif %}

            </div>
        </div>
    </div>
</div>


{% if detail_ad['owner'] == 1 %}
    <script>
        $(document).ready(function () {
            {% if detail_ad['status'] == 0 %}
            ilyaStep(3);
            {% elseif detail_ad['status'] == 1 %}
            ilyaStep(4);
            {% endif %}

            const input22 = [{
                id: 'step1',
                text: 'پیش نمایش',
                menuId: 'content1'
            },
                {
                    id: 'step2',
                    text: 'ویرایش',
                    menuId: 'content2'
                },
                {
                    id: 'step3',
                    text: 'ارتقاء',
                    menuId: 'content3'
                },
                {
                    id: 'step4',
                    text: 'حذف',
                    menuId: 'content4'
                }
            ];

            const tab1 = new ilyaTab('tabstep', '#ilya-tab-place', input22);
        });
    </script>
{% endif %}