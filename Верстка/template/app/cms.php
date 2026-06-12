<?php

date_default_timezone_set('Asia/Tashkent');

function cms_data_path()
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'content.json';
}

function cms_submissions_path()
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'submissions.json';
}

function cms_poll_votes_path()
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'poll_votes.json';
}

function cms_languages()
{
    return ['ru' => 'RU', 'uz' => 'UZ', 'en' => 'EN'];
}

function cms_current_lang()
{
    static $lang = null;
    if ($lang !== null) {
        return $lang;
    }

    $requested = strtolower((string) ($_GET['lang'] ?? ($_COOKIE['site_lang'] ?? 'ru')));
    $lang = array_key_exists($requested, cms_languages()) ? $requested : 'ru';
    if (!headers_sent()) {
        setcookie('site_lang', $lang, time() + 31536000, '/');
    }

    return $lang;
}

function cms_url($path, array $params = [])
{
    return $path . '?' . http_build_query(array_merge(['lang' => cms_current_lang()], $params));
}

function cms_default_data()
{
    return [
        'settings' => [
            'site_name' => 'Uzparranda.uz',
            'logo' => 'LOGO',
            'hero_title' => 'Узпаррандасаноат',
            'hero_subtitle' => 'Ассоциация птицеводства',
            'feedback_label' => 'Обратная связь',
            'phone_1' => '+ 99871 123 45 67',
            'phone_2' => '+ 99871 123 45 67',
            'address' => 'г. Ташкент, ул. Амира Темура, 110',
            'email' => 'info@uzparranda.uz',
            'director' => 'Файзиев Мансур',
            'director_role' => 'Директор',
            'about_title' => 'Об ассоциации',
            'about_text' => "Ассоциация объединяет предприятия птицеводческой отрасли и помогает развивать производство, обучение и обмен опытом.\nМы публикуем новости отрасли, события, материалы для специалистов и полезную информацию для фермерских хозяйств.",
            'magazine_title' => 'Журнал «Птицеводство Узбекистана»',
            'magazine_image' => 'img/magazine.png',
            'poll_title' => 'Опрос',
            'poll_question' => 'Вам понравился наш сайт?',
            'footer_text' => 'Информационный портал ассоциации птицеводческой отрасли Узбекистана.',
            'footer_credit' => 'Сайт разработан MD.uz',
            'copyright' => '© 2017 Uzparranda.uz.',
            'form_title' => 'Отправить заявку',
            'form_name' => 'Ваше имя',
            'form_email' => 'Электронная почта',
            'form_phone' => 'Телефон',
            'form_company' => 'Название организации',
            'form_message' => 'Текст сообщения',
            'form_submit' => 'Отправить',
        ],
        'nav' => ['Об ассоциации', 'Новости', 'События', 'Статьи', 'Законодательство', 'Племенное дело', 'Ветеринария', 'Продукция', 'Корма'],
        'sidebar' => ['Деятельность', 'Устав', 'Услуги'],
        'poll_options' => ['Отлично', 'Хорошо', 'Удовлетворительно', 'Плохо'],
        'clients' => [
            ['image' => 'img/client.png', 'alt' => 'Client'],
            ['image' => 'img/client.png', 'alt' => 'Client'],
            ['image' => 'img/client.png', 'alt' => 'Client'],
            ['image' => 'img/client.png', 'alt' => 'Client'],
            ['image' => 'img/client.png', 'alt' => 'Client'],
            ['image' => 'img/client.png', 'alt' => 'Client'],
            ['image' => 'img/client.png', 'alt' => 'Client'],
            ['image' => 'img/client.png', 'alt' => 'Client'],
        ],
        'links' => [
            ['title' => 'press-service.uz', 'url' => '#'],
            ['title' => 'press-service.uz', 'url' => '#'],
            ['title' => 'press-service.uz', 'url' => '#'],
            ['title' => 'press-service.uz', 'url' => '#'],
            ['title' => 'press-service.uz', 'url' => '#'],
            ['title' => 'press-service.uz', 'url' => '#'],
            ['title' => 'press-service.uz', 'url' => '#'],
            ['title' => 'press-service.uz', 'url' => '#'],
            ['title' => 'press-service.uz', 'url' => '#'],
        ],
        'gallery' => [
            ['image' => 'img/mpict1.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict2.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict3.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict1.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict2.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict3.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict1.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict2.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict3.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict1.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict2.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict3.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict1.jpg', 'caption' => 'Фотогалерея птицеводства'],
            ['image' => 'img/mpict2.jpg', 'caption' => 'Фотогалерея птицеводства'],
        ],
        'social' => [
            ['icon' => 'fa-facebook-square', 'url' => '#'],
            ['icon' => 'fa-instagram', 'url' => '#'],
            ['icon' => 'fa-google-plus-square', 'url' => '#'],
            ['icon' => 'fa-linkedin-square', 'url' => '#'],
        ],
        'calendar' => [
            'month' => date('Y-m'),
            'title' => 'Календарь событий',
            'events' => [
                ['date' => date('Y-m') . '-05', 'time' => '10:00', 'title' => 'Семинар', 'description' => 'Учебный семинар', 'url' => '#', 'color' => '#e18c44'],
                ['date' => date('Y-m') . '-16', 'time' => '14:00', 'title' => 'Встреча', 'description' => 'Встреча специалистов', 'url' => '#', 'color' => '#1d6887'],
                ['date' => date('Y-m') . '-24', 'time' => '11:00', 'title' => 'Выставка', 'description' => 'Отраслевая выставка', 'url' => '#', 'color' => '#5cb85c'],
            ],
        ],
        'news' => [
            [
                'id' => 'fargona-school',
                'title' => 'В Фергане начала работу школа птицеводства',
                'category' => 'Объявление',
                'image' => 'img/pict1.jpg',
                'large_image' => 'img/bpict.jpg',
                'excerpt' => 'В рамках проекта организованы учебные семинары по правильному содержанию птицы, уходу и работе с инкубаторами.',
                'body' => "Учебная программа помогает фермерам получить практические знания по современному птицеводству.\n\nУчастники знакомятся с технологиями выращивания, кормления и профилактики заболеваний.",
            ],
            [
                'id' => 'incubator-training',
                'title' => 'Семинар по работе с инкубаторами',
                'category' => 'Новость',
                'image' => 'img/pict1.jpg',
                'large_image' => 'img/bpict.jpg',
                'excerpt' => 'Специалисты провели практические занятия для птицеводческих хозяйств.',
                'body' => "Семинар был посвящен повышению практических навыков в птицеводческой отрасли.\n\nВ мероприятии приняли участие фермеры и профильные специалисты.",
            ],
            [
                'id' => 'veterinary-support',
                'title' => 'Новое направление ветеринарной поддержки',
                'category' => 'Ветеринария',
                'image' => 'img/pict1.jpg',
                'large_image' => 'img/bpict.jpg',
                'excerpt' => 'Планируется усилить профилактические и консультационные услуги для отрасли.',
                'body' => "В ветеринарном направлении внедряются новые сервисы для хозяйств.\n\nЭти меры помогут повысить качество продукции и уровень биобезопасности.",
            ],
        ],
    ];
}

function cms_locale_overrides()
{
    return [
        'ru' => [
            'settings' => cms_default_data()['settings'],
            'nav' => cms_default_data()['nav'],
            'sidebar' => cms_default_data()['sidebar'],
            'poll_options' => cms_default_data()['poll_options'],
            'gallery_caption' => 'Фотогалерея птицеводства',
            'calendar' => [
                'title' => 'Календарь событий',
                'events' => [
                    ['title' => 'Семинар', 'description' => 'Учебный семинар'],
                    ['title' => 'Встреча', 'description' => 'Встреча специалистов'],
                    ['title' => 'Выставка', 'description' => 'Отраслевая выставка'],
                ],
            ],
            'news' => array_column(cms_default_data()['news'], null, 'id'),
            'ui' => [
                'search_placeholder' => 'Поиск',
                'search_button' => 'Найти',
                'all_news' => 'Все новости',
                'latest_news' => 'Новости',
                'articles_title' => 'Новости и статьи',
                'news_title' => 'Новости',
                'contact_title' => 'Контакты',
                'poll_ok' => 'Спасибо, ваш голос принят.',
                'poll_error' => 'Пожалуйста, выберите вариант ответа.',
                'request_ok' => 'Заявка принята. Мы свяжемся с вами.',
                'request_error' => 'Пожалуйста, заполните имя, телефон и сообщение.',
                'weekdays' => ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
            ],
        ],
        'uz' => [
            'settings' => [
                'site_name' => 'Uzparranda.uz',
                'logo' => 'LOGO',
                'hero_title' => 'O‘zparrandasanoat',
                'hero_subtitle' => 'Parrandachilik uyushmasi',
                'feedback_label' => 'Qayta aloqa',
                'phone_1' => '+ 99871 123 45 67',
                'phone_2' => '+ 99871 123 45 67',
                'address' => 'Toshkent sh., Amir Temur ko‘chasi, 110',
                'email' => 'info@uzparranda.uz',
                'director' => 'Fayziyev Mansur',
                'director_role' => 'Direktor',
                'about_title' => 'Uyushma haqida',
                'about_text' => "Uyushma parrandachilik sohasi korxonalarini birlashtiradi hamda ishlab chiqarish, ta'lim va tajriba almashinuvini rivojlantirishga ko‘maklashadi.\nSaytda soha yangiliklari, tadbirlar, mutaxassislar uchun maqolalar va fermer xo‘jaliklari uchun foydali ma'lumotlar joylanadi.",
                'magazine_title' => '«O‘zbekiston parrandachiligi» jurnali',
                'magazine_image' => 'img/magazine.png',
                'poll_title' => 'So‘rovnoma',
                'poll_question' => 'Saytimiz sizga yoqdimi?',
                'footer_text' => 'O‘zbekiston parrandachilik sohasi uyushmasining axborot portali.',
                'footer_credit' => 'Sayt MD.uz tomonidan ishlab chiqilgan',
                'copyright' => '© 2017 Uzparranda.uz.',
                'form_title' => 'Ariza yuborish',
                'form_name' => 'Ismingiz',
                'form_email' => 'Elektron pochta',
                'form_phone' => 'Telefon raqami',
                'form_company' => 'Tashkilot nomi',
                'form_message' => 'Xabar matni',
                'form_submit' => 'Yuborish',
            ],
            'nav' => ['Uyushma haqida', 'Yangiliklar', 'Voqealar', 'Maqolalar', 'Qonunchilik', 'Naslchilik', 'Veterinariya', 'Mahsulotlar', 'Ozuqalar'],
            'sidebar' => ['Faoliyat', 'Nizom', 'Xizmatlar'],
            'poll_options' => ['A’lo', 'Yaxshi', 'Qoniqarli', 'Yomon'],
            'gallery_caption' => 'Parrandachilik fotogalereyasi',
            'calendar' => [
                'title' => 'Tadbirlar taqvimi',
                'events' => [
                    ['title' => 'Seminar', 'description' => 'O‘quv seminari'],
                    ['title' => 'Uchrashuv', 'description' => 'Mutaxassislar uchrashuvi'],
                    ['title' => 'Ko‘rgazma', 'description' => 'Soha ko‘rgazmasi'],
                ],
            ],
            'news' => [
                'fargona-school' => ['title' => 'Farg‘onada parrandachilik maktabi ish boshladi', 'category' => 'E’lon', 'excerpt' => 'Loyiha doirasida parrandani to‘g‘ri parvarishlash, boqish va inkubatorlar bilan ishlash bo‘yicha seminarlar tashkil etildi.', 'body' => "O‘quv dasturi fermerlarga zamonaviy parrandachilik bo‘yicha amaliy bilim beradi.\n\nIshtirokchilar parvarish, oziqlantirish va kasalliklarning oldini olish texnologiyalari bilan tanishadi."],
                'incubator-training' => ['title' => 'Inkubatorlar bilan ishlash bo‘yicha seminar', 'category' => 'Yangilik', 'excerpt' => 'Mutaxassislar parrandachilik xo‘jaliklari uchun amaliy mashg‘ulotlar o‘tkazdi.', 'body' => "Seminar parrandachilik sohasidagi amaliy ko‘nikmalarni oshirishga bag‘ishlandi.\n\nTadbirda fermerlar va soha mutaxassislari ishtirok etdi."],
                'veterinary-support' => ['title' => 'Veterinariya yordami bo‘yicha yangi yo‘nalish', 'category' => 'Veterinariya', 'excerpt' => 'Sohada profilaktika va maslahat xizmatlarini kuchaytirish rejalashtirilmoqda.', 'body' => "Veterinariya yo‘nalishida xo‘jaliklar uchun yangi xizmatlar joriy etiladi.\n\nBu choralar mahsulot sifati va bioxavfsizlik darajasini oshirishga xizmat qiladi."],
            ],
            'ui' => [
                'search_placeholder' => 'Qidiruv',
                'search_button' => 'Izlash',
                'all_news' => 'Barcha yangiliklar',
                'latest_news' => 'Yangiliklar',
                'articles_title' => 'Yangiliklar va maqolalar',
                'news_title' => 'Yangiliklar',
                'contact_title' => 'Aloqa',
                'poll_ok' => 'Rahmat, ovozingiz qabul qilindi.',
                'poll_error' => 'Iltimos, javob variantini tanlang.',
                'request_ok' => 'Ariza qabul qilindi. Siz bilan bog‘lanamiz.',
                'request_error' => 'Iltimos, ism, telefon va xabarni to‘ldiring.',
                'weekdays' => ['Du', 'Se', 'Ch', 'Pa', 'Ju', 'Sh', 'Ya'],
            ],
        ],
        'en' => [
            'settings' => [
                'site_name' => 'Uzparranda.uz',
                'logo' => 'LOGO',
                'hero_title' => 'Uzparrandasanoat',
                'hero_subtitle' => 'Poultry Association',
                'feedback_label' => 'Feedback',
                'phone_1' => '+ 99871 123 45 67',
                'phone_2' => '+ 99871 123 45 67',
                'address' => '110 Amir Temur Street, Tashkent',
                'email' => 'info@uzparranda.uz',
                'director' => 'Mansur Fayziyev',
                'director_role' => 'Director',
                'about_title' => 'About the Association',
                'about_text' => "The association brings together poultry industry companies and supports production, training and professional knowledge exchange.\nThe website publishes industry news, events, expert materials and useful information for farms.",
                'magazine_title' => 'Poultry Farming of Uzbekistan Magazine',
                'magazine_image' => 'img/magazine.png',
                'poll_title' => 'Survey',
                'poll_question' => 'Do you like our website?',
                'footer_text' => 'Information portal of the poultry industry association of Uzbekistan.',
                'footer_credit' => 'Website developed by MD.uz',
                'copyright' => '© 2017 Uzparranda.uz.',
                'form_title' => 'Send a Request',
                'form_name' => 'Your name',
                'form_email' => 'Email',
                'form_phone' => 'Phone number',
                'form_company' => 'Organization name',
                'form_message' => 'Message',
                'form_submit' => 'Send',
            ],
            'nav' => ['About', 'News', 'Events', 'Articles', 'Legislation', 'Breeding', 'Veterinary', 'Products', 'Feed'],
            'sidebar' => ['Activities', 'Charter', 'Services'],
            'poll_options' => ['Excellent', 'Good', 'Satisfactory', 'Poor'],
            'gallery_caption' => 'Poultry photo gallery',
            'calendar' => [
                'title' => 'Events Calendar',
                'events' => [
                    ['title' => 'Seminar', 'description' => 'Training seminar'],
                    ['title' => 'Meeting', 'description' => 'Specialists meeting'],
                    ['title' => 'Exhibition', 'description' => 'Industry exhibition'],
                ],
            ],
            'news' => [
                'fargona-school' => ['title' => 'Poultry school started operating in Fergana', 'category' => 'Announcement', 'excerpt' => 'Training seminars were organized on proper poultry care, feeding and working with incubators.', 'body' => "The training program helps farmers gain practical knowledge in modern poultry farming.\n\nParticipants learn about growing, feeding and disease prevention technologies."],
                'incubator-training' => ['title' => 'Seminar on working with incubators', 'category' => 'News', 'excerpt' => 'Specialists held practical training sessions for poultry farms.', 'body' => "The seminar focused on improving practical skills in the poultry industry.\n\nFarmers and industry specialists took part in the event."],
                'veterinary-support' => ['title' => 'New direction for veterinary support', 'category' => 'Veterinary', 'excerpt' => 'Preventive and consulting services for the industry are planned to be strengthened.', 'body' => "New services for farms are being introduced in the veterinary field.\n\nThese measures will help improve product quality and biosecurity."],
            ],
            'ui' => [
                'search_placeholder' => 'Search',
                'search_button' => 'Find',
                'all_news' => 'All news',
                'latest_news' => 'News',
                'articles_title' => 'News and Articles',
                'news_title' => 'News',
                'contact_title' => 'Contacts',
                'poll_ok' => 'Thank you, your vote has been accepted.',
                'poll_error' => 'Please choose an answer option.',
                'request_ok' => 'Your request has been accepted. We will contact you.',
                'request_error' => 'Please fill in your name, phone and message.',
                'weekdays' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            ],
        ],
    ];
}

function cms_load_data()
{
    $path = cms_data_path();
    if (!is_file($path)) {
        cms_save_data(cms_default_data());
    }

    $data = json_decode(file_get_contents($path), true);
    if (!is_array($data)) {
        $data = cms_default_data();
    }

    return array_replace_recursive(cms_default_data(), $data);
}

function cms_save_data(array $data)
{
    $path = cms_data_path();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

function cms_apply_locale(array $data, $lang = null)
{
    $locales = cms_locale_overrides();
    $locale = $locales[$lang ?: cms_current_lang()] ?? $locales['ru'];

    foreach (($locale['settings'] ?? []) as $key => $value) {
        $data['settings'][$key] = $value;
    }
    foreach (['nav', 'sidebar', 'poll_options'] as $key) {
        if (isset($locale[$key])) {
            $data[$key] = $locale[$key];
        }
    }
    foreach ($data['gallery'] as $index => $item) {
        $data['gallery'][$index]['caption'] = $locale['gallery_caption'] ?? ($item['caption'] ?? '');
    }
    $data['calendar']['title'] = $locale['calendar']['title'] ?? ($data['calendar']['title'] ?? '');
    foreach (($locale['calendar']['events'] ?? []) as $index => $event) {
        if (isset($data['calendar']['events'][$index])) {
            $data['calendar']['events'][$index] = array_replace($data['calendar']['events'][$index], $event);
        }
    }
    foreach ($data['news'] as $index => $item) {
        $id = $item['id'] ?? '';
        if (isset($locale['news'][$id])) {
            $data['news'][$index] = array_replace($item, $locale['news'][$id]);
        }
    }
    $data['ui'] = $locale['ui'];
    $data['lang'] = cms_current_lang();

    return $data;
}

function cms_load_site_data()
{
    return cms_apply_locale(cms_load_data(), cms_current_lang());
}

function cms_t($key, array $data = null)
{
    $data = $data ?: cms_load_site_data();
    return $data['ui'][$key] ?? $key;
}

function cms_load_json_array($path)
{
    if (!is_file($path)) {
        return [];
    }
    $items = json_decode(file_get_contents($path), true);
    return is_array($items) ? $items : [];
}

function cms_save_json_array($path, array $items)
{
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    file_put_contents($path, json_encode(array_values($items), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

function cms_load_submissions()
{
    return cms_load_json_array(cms_submissions_path());
}

function cms_save_submissions(array $items)
{
    cms_save_json_array(cms_submissions_path(), $items);
}

function cms_load_poll_votes()
{
    return cms_load_json_array(cms_poll_votes_path());
}

function cms_save_poll_votes(array $items)
{
    cms_save_json_array(cms_poll_votes_path(), $items);
}

function cms_poll_results(array $data, array $votes)
{
    $results = [];
    foreach ($data['poll_options'] as $index => $option) {
        $results[(string) $index] = ['option' => $option, 'count' => 0];
    }
    foreach ($votes as $vote) {
        $index = (string) ($vote['option_index'] ?? '');
        if (isset($results[$index])) {
            $results[$index]['count']++;
        }
    }
    return $results;
}

function cms_handle_poll_form(array $data)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['poll_status'])) {
        return $_GET['poll_status'] === 'ok' ? cms_t('poll_ok', $data) : cms_t('poll_error', $data);
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_POST['form_type'] ?? '') !== 'poll') {
        return null;
    }

    $optionIndex = (string) ($_POST['poll_choice'] ?? '');
    if ($optionIndex === '' || !isset($data['poll_options'][(int) $optionIndex])) {
        cms_redirect_after_poll('error');
    }

    $votes = cms_load_poll_votes();
    array_unshift($votes, [
        'id' => date('YmdHis') . '-' . substr(md5(uniqid('', true)), 0, 6),
        'created_at' => date('Y-m-d H:i:s'),
        'option_index' => (int) $optionIndex,
        'option' => $data['poll_options'][(int) $optionIndex],
        'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
    ]);
    cms_save_poll_votes($votes);
    cms_redirect_after_poll('ok');
}

function cms_handle_request_form()
{
    $siteData = cms_load_site_data();
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['request_status'])) {
        return $_GET['request_status'] === 'ok' ? cms_t('request_ok', $siteData) : cms_t('request_error', $siteData);
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_POST['form_type'] ?? '') !== 'request') {
        return null;
    }

    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $company = trim((string) ($_POST['company'] ?? ''));
    $message = trim((string) ($_POST['message'] ?? ''));
    $source = trim((string) ($_POST['source'] ?? 'site'));
    if ($name === '' || $phone === '' || $message === '') {
        cms_redirect_after_request('error');
    }

    $items = cms_load_submissions();
    array_unshift($items, [
        'id' => date('YmdHis') . '-' . substr(md5(uniqid('', true)), 0, 6),
        'created_at' => date('Y-m-d H:i:s'),
        'source' => $source,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'company' => $company,
        'message' => $message,
    ]);
    cms_save_submissions($items);
    cms_redirect_after_request('ok');
}

function cms_redirect_with_status($key, $status)
{
    $uri = $_SERVER['REQUEST_URI'] ?? 'index.php';
    $parts = parse_url($uri);
    $path = $parts['path'] ?? 'index.php';
    $query = [];
    if (!empty($parts['query'])) {
        parse_str($parts['query'], $query);
    }
    $query[$key] = $status;

    header('Location: ' . $path . '?' . http_build_query($query), true, 303);
    exit;
}

function cms_redirect_after_poll($status)
{
    cms_redirect_with_status('poll_status', $status);
}

function cms_redirect_after_request($status)
{
    cms_redirect_with_status('request_status', $status);
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function cms_news_url(array $item)
{
    return cms_url('view.php', ['id' => $item['id']]);
}

function cms_find_news(array $data, $id)
{
    foreach ($data['news'] as $item) {
        if ($item['id'] === $id) {
            return $item;
        }
    }
    return $data['news'][0] ?? null;
}

function cms_paginate_items(array $items, $page, $perPage)
{
    $total = count($items);
    $perPage = max(1, (int) $perPage);
    $totalPages = max(1, (int) ceil($total / $perPage));
    $page = max(1, min((int) $page, $totalPages));
    return [
        'items' => array_slice($items, ($page - 1) * $perPage, $perPage),
        'page' => $page,
        'per_page' => $perPage,
        'total' => $total,
        'total_pages' => $totalPages,
    ];
}

function cms_render_pagination(array $pagination, $baseUrl)
{
    if (($pagination['total_pages'] ?? 1) <= 1) {
        return;
    }
    $current = (int) $pagination['page'];
    $total = (int) $pagination['total_pages'];

    echo '<ul class="navi news-pagination">' . PHP_EOL;
    if ($current > 1) {
        echo '<li><a href="' . e(cms_url($baseUrl, ['page' => $current - 1])) . '"><i class="fa fa-angle-left"></i></a></li>' . PHP_EOL;
    }
    for ($page = 1; $page <= $total; $page++) {
        $class = $page === $current ? ' class="active"' : '';
        echo '<li' . $class . '><a href="' . e(cms_url($baseUrl, ['page' => $page])) . '">' . $page . '</a></li>' . PHP_EOL;
    }
    if ($current < $total) {
        echo '<li><a href="' . e(cms_url($baseUrl, ['page' => $current + 1])) . '"><i class="fa fa-angle-right"></i></a></li>' . PHP_EOL;
    }
    echo '</ul>' . PHP_EOL;
}

function cms_paragraphs($text)
{
    $parts = preg_split("/\r\n|\n|\r/", trim((string) $text));
    foreach ($parts as $part) {
        if (trim($part) !== '') {
            echo '<p>' . e($part) . '</p>' . PHP_EOL;
        }
    }
}

function cms_calendar_events_by_day(array $data)
{
    $events = [];
    foreach ($data['calendar']['events'] as $event) {
        if (!empty($event['date'])) {
            $events[(int) substr($event['date'], -2)][] = $event;
        }
    }
    return $events;
}

function cms_render_calendar(array $data)
{
    $month = $data['calendar']['month'] ?? date('Y-m');
    $timestamp = strtotime($month . '-01') ?: time();
    $daysInMonth = (int) date('t', $timestamp);
    $firstWeekday = (int) date('N', $timestamp);
    $events = cms_calendar_events_by_day($data);
    $weekdays = $data['ui']['weekdays'] ?? ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];

    echo '<div class="site-calendar">' . PHP_EOL;
    echo '<div class="site-calendar__title">' . e($data['calendar']['title'] ?? date('F Y', $timestamp)) . '</div>' . PHP_EOL;
    echo '<div class="site-calendar__grid">' . PHP_EOL;
    foreach ($weekdays as $weekday) {
        echo '<div class="site-calendar__weekday">' . e($weekday) . '</div>' . PHP_EOL;
    }
    for ($blank = 1; $blank < $firstWeekday; $blank++) {
        echo '<div class="site-calendar__day site-calendar__day--empty"></div>' . PHP_EOL;
    }
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $classes = 'site-calendar__day';
        $title = '';
        $style = '';
        if (!empty($events[$day])) {
            $classes .= ' has-event';
            $title = implode(', ', array_map(function ($event) {
                return trim(($event['time'] ?? '') . ' ' . ($event['title'] ?? ''));
            }, $events[$day]));
            $color = $events[$day][0]['color'] ?? '#e18c44';
            $style = ' style="background:' . e($color) . ';border-color:' . e($color) . ';"';
        }
        echo '<div class="' . e($classes) . '" title="' . e($title) . '"' . $style . '><span>' . $day . '</span></div>' . PHP_EOL;
    }
    echo '</div>' . PHP_EOL;
    if (!empty($data['calendar']['events'])) {
        echo '<ul class="site-calendar__events">' . PHP_EOL;
        foreach ($data['calendar']['events'] as $event) {
            $eventText = '<strong>' . e($event['date']) . '</strong>';
            if (!empty($event['time'])) {
                $eventText .= ' <span>' . e($event['time']) . '</span>';
            }
            $eventText .= ' ' . e($event['title']);
            if (!empty($event['description'])) {
                $eventText .= '<small>' . e($event['description']) . '</small>';
            }
            if (!empty($event['url']) && $event['url'] !== '#') {
                $eventText = '<a href="' . e($event['url']) . '">' . $eventText . '</a>';
            }
            echo '<li>' . $eventText . '</li>' . PHP_EOL;
        }
        echo '</ul>' . PHP_EOL;
    }
    echo '</div>' . PHP_EOL;
}

function cms_render_sidebar(array $data)
{
    echo '<div class="widget"><ul class="ser_list">' . PHP_EOL;
    foreach ($data['sidebar'] as $sidebarItem) {
        echo '<li><a href="' . e(cms_url('categ.php')) . '"><i class="fa fa-check-square-o"></i>' . e($sidebarItem) . '</a></li>' . PHP_EOL;
    }
    echo '</ul></div>' . PHP_EOL;
    echo '<div class="widget">' . PHP_EOL;
    cms_render_calendar($data);
    echo '</div>' . PHP_EOL;
    if (count($data['news']) > 3) {
        echo '<div class="widget latest-news-widget"><div class="widget-title">' . e(cms_t('latest_news', $data)) . '</div><ul>' . PHP_EOL;
        foreach (array_slice($data['news'], 0, 3) as $item) {
            echo '<li><a href="' . e(cms_news_url($item)) . '">' . e($item['title']) . '</a></li>' . PHP_EOL;
        }
        echo '</ul><a class="all-news-link" href="' . e(cms_url('articles.php')) . '">' . e(cms_t('all_news', $data)) . '</a></div>' . PHP_EOL;
    }
}

function cms_render_language_switcher()
{
    $current = cms_current_lang();
    $page = basename($_SERVER['PHP_SELF'] ?? 'index.php') ?: 'index.php';

    echo '<div class="lang_switcher">' . PHP_EOL;
    foreach (cms_languages() as $code => $label) {
        $params = $_GET;
        $params['lang'] = $code;
        $class = $code === $current ? ' class="active"' : '';
        echo '<a' . $class . ' href="' . e($page . '?' . http_build_query($params)) . '">' . e($label) . '</a>' . PHP_EOL;
    }
    echo '</div>' . PHP_EOL;
}

function cms_render_gallery(array $data)
{
    echo '<div class="gal_slider">' . PHP_EOL;
    foreach (array_chunk($data['gallery'], 2) as $chunk) {
        echo '<div class="item">' . PHP_EOL;
        foreach ($chunk as $item) {
            echo '<a href="' . e($item['image']) . '" data-lightbox="roadtrip" data-title="' . e($item['caption']) . '"><span class="caption">' . e($item['caption']) . '</span><img src="' . e($item['image']) . '" alt=""></a>' . PHP_EOL;
        }
        echo '</div>' . PHP_EOL;
    }
    echo '</div>' . PHP_EOL;
}

function cms_render_home_extra(array $data)
{
    $settings = $data['settings'];
    $pollNotice = $GLOBALS['cms_poll_notice'] ?? null;
    echo '<div class="info_box"><div class="container"><div class="row">' . PHP_EOL;
    echo '<div class="col-md-3"><a href="#" class="magazin">' . e($settings['magazine_title']) . '<img src="' . e($settings['magazine_image']) . '" alt=""></a></div>' . PHP_EOL;
    echo '<div class="col-md-6"><div class="video"></div></div>' . PHP_EOL;
    echo '<div class="col-md-3"><div class="widget"><div class="title">' . e($settings['poll_title']) . '</div><div class="ques">' . e($settings['poll_question']) . '</div>';
    if ($pollNotice) {
        echo '<div class="poll_notice">' . e($pollNotice) . '</div>' . PHP_EOL;
    }
    echo '<form action="" method="post"><input type="hidden" name="form_type" value="poll">' . PHP_EOL;
    foreach ($data['poll_options'] as $index => $option) {
        $id = 'q' . ($index + 1);
        echo '<div class="input"><input type="radio" name="poll_choice" value="' . e($index) . '" id="' . e($id) . '" required><label for="' . e($id) . '">' . e($option) . '</label></div>' . PHP_EOL;
    }
    echo '<input type="submit" value="OK"><div class="clearfix"></div></form></div></div>' . PHP_EOL;
    echo '</div></div></div>' . PHP_EOL;
}

function cms_render_clients_links_footer(array $data)
{
    $settings = $data['settings'];
    $notice = $GLOBALS['cms_form_notice'] ?? null;
    echo '<div class="clients"><div class="container"><div class="c_list">' . PHP_EOL;
    foreach ($data['clients'] as $client) {
        echo '<div class="item"><img src="' . e($client['image']) . '" alt="' . e($client['alt'] ?? '') . '"></div>' . PHP_EOL;
    }
    echo '</div></div></div>' . PHP_EOL;
    echo '<div class="links">' . PHP_EOL;
    foreach ($data['links'] as $link) {
        echo '<div class="item"><a href="' . e($link['url']) . '">' . e($link['title']) . '</a></div>' . PHP_EOL;
    }
    echo '</div><div class="map"></div>' . PHP_EOL;
    echo '<footer><div class="container"><div class="row">' . PHP_EOL;
    echo '<div class="col-md-3"><h1>' . e($settings['logo']) . '</h1>' . e($settings['footer_text']) . '</div>' . PHP_EOL;
    echo '<div class="col-md-6"><div class="askme"><form action="" method="post"><input type="hidden" name="form_type" value="request"><input type="hidden" name="source" value="footer"><div class="title">' . e($settings['form_title']) . '</div>' . PHP_EOL;
    if ($notice) {
        echo '<div class="form_notice">' . e($notice) . '</div>' . PHP_EOL;
    }
    echo '<div class="row"><div class="col-md-6"><input type="text" name="name" required placeholder="' . e($settings['form_name']) . '"><input type="email" name="email" placeholder="' . e($settings['form_email']) . '"><input type="text" name="phone" required placeholder="' . e($settings['form_phone']) . '"><input type="text" name="company" placeholder="' . e($settings['form_company']) . '"></div><div class="col-md-6"><textarea name="message" required placeholder="' . e($settings['form_message']) . '"></textarea><input type="submit" value="' . e($settings['form_submit']) . '"></div></div></form></div></div>' . PHP_EOL;
    echo '<div class="col-md-3"><div class="info"><i class="fa fa-map-marker"></i>' . e($settings['address']) . '</div><div class="info"><i class="fa fa-phone"></i>' . e($settings['phone_1']) . '</div><div class="info"><i class="fa fa-envelope"></i>' . e($settings['email']) . '</div></div>' . PHP_EOL;
    echo '</div><div class="bottom"><div class="row"><div class="col-md-3 text-left">' . e($settings['copyright']) . '</div><div class="col-md-6"><ul class="social">' . PHP_EOL;
    foreach ($data['social'] as $social) {
        echo '<li><a href="' . e($social['url']) . '"><i class="fa ' . e($social['icon']) . '"></i></a></li>' . PHP_EOL;
    }
    echo '</ul></div><div class="col-md-3 text-right"><a href="#">' . e($settings['footer_credit']) . '</a></div></div></div></div></footer>' . PHP_EOL;
}

function cms_render_scripts_and_modal(array $data)
{
    $settings = $data['settings'];
    echo '<script src="js/jquery.js"></script><script src="js/slick.min.js"></script><script src="js/bootstrap.min.js"></script><script src="js/lightbox.js"></script><script src="js/main.js"></script>' . PHP_EOL;
    echo '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><form action="" method="post" class="support"><input type="hidden" name="form_type" value="request"><input type="hidden" name="source" value="modal"><div class="title">' . e($settings['form_title']) . '</div><div class="row"><div class="col-md-12"><input type="text" name="name" required placeholder="' . e($settings['form_name']) . '"><input type="email" name="email" placeholder="' . e($settings['form_email']) . '"><input type="text" name="phone" required placeholder="' . e($settings['form_phone']) . '"><input type="text" name="company" placeholder="' . e($settings['form_company']) . '"></div><div class="col-md-12"><textarea name="message" required placeholder="' . e($settings['form_message']) . '"></textarea><input type="submit" value="' . e($settings['form_submit']) . '"></div></div></form></div></div></div></div>' . PHP_EOL;
}
