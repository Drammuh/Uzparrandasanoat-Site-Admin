<?php
require __DIR__ . '/../../../Верстка/template/app/cms.php';

$data = cms_load_data();
$submissions = cms_load_submissions();
$pollVotes = cms_load_poll_votes();
$message = admin_clean_message($_GET['message'] ?? '');

function admin_value(array $source, $key)
{
    return trim((string) ($source[$key] ?? ''));
}

function admin_normalize_id($value, $fallback)
{
    $value = strtolower(trim((string) $value));
    $value = preg_replace('/[^a-z0-9_-]+/', '-', $value);
    $value = trim($value, '-');

    return $value !== '' ? $value : $fallback;
}

function admin_lines($value)
{
    $lines = preg_split("/\r\n|\n|\r/", (string) $value);
    $lines = array_map('trim', $lines);

    return array_values(array_filter($lines, function ($line) {
        return $line !== '';
    }));
}

function admin_rows(array $rows, array $fields)
{
    $result = [];

    foreach ($rows as $row) {
        if (!empty($row['_delete'])) {
            continue;
        }

        $item = [];
        $hasValue = false;
        foreach ($fields as $field => $default) {
            $item[$field] = trim((string) ($row[$field] ?? $default));
            if ($item[$field] !== '') {
                $hasValue = true;
            }
        }
        if ($hasValue) {
            $result[] = $item;
        }
    }

    return $result;
}

function admin_clean_message($message)
{
    $message = (string) $message;

    if ($message === '') {
        return '';
    }

    if (strpos($message, 'Вµ') !== false || strpos($message, 'опрос') !== false || strpos($message, 'РѕРїСЂ') !== false) {
        return 'Результаты опроса очищены.';
    }
    if (strpos($message, 'Р—Р°') !== false || strpos($message, 'Заявка') !== false) {
        return 'Заявка удалена.';
    }
    if (strpos($message, 'Т›') !== false || strpos($message, 'қўш') !== false) {
        return 'Новость добавлена.';
    }
    if (strpos($message, 'РҐР°') !== false || strpos($message, 'ўчир') !== false) {
        return 'Новость удалена.';
    }
    if (strpos($message, 'РР·') !== false || strpos($message, 'СЃРѕС…') !== false) {
        return 'Изменения сохранены.';
    }
    if (strpos($message, 'РќРµС‚') !== false || strpos($message, 'Нет данных') !== false) {
        return 'Нет данных для сохранения.';
    }

    return $message;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'save';
    $postedActiveTab = preg_replace('/[^a-z0-9_]/i', '', $_POST['active_tab'] ?? 'tab_requests');

    if ($action === 'save' && !isset($_POST['settings'])) {
        header('Location: site_content.php?message=' . rawurlencode('Нет данных для сохранения.') . '&tab=' . rawurlencode($postedActiveTab), true, 303);
        exit;
    }

    if ($action === 'clear_poll') {
        cms_save_poll_votes([]);
        $pollVotes = [];
        $message = 'Р РµР·СѓР»СЊС‚Р°С‚С‹ РѕРїСЂРѕСЃР° РѕС‡РёС‰РµРЅС‹.';
    } elseif (strpos($action, 'delete_submission:') === 0) {
        $deleteId = substr($action, 18);
        $submissions = array_values(array_filter($submissions, function ($item) use ($deleteId) {
            return ($item['id'] ?? '') !== $deleteId;
        }));
        cms_save_submissions($submissions);
        $message = 'Заявка удалена.';
    } elseif ($action === 'add') {
        $data['news'][] = [
            'id' => 'news-' . date('YmdHis'),
            'title' => 'Янги хабар',
            'category' => 'Янгилик',
            'image' => 'img/pict1.jpg',
            'large_image' => 'img/bpict.jpg',
            'excerpt' => 'Қисқа тавсиф',
            'body' => 'Матн',
        ];
        $message = 'Янги хабар қўшилди.';
    } elseif (strpos($action, 'delete:') === 0) {
        $deleteId = substr($action, 7);
        $data['news'] = array_values(array_filter($data['news'], function ($item) use ($deleteId) {
            return $item['id'] !== $deleteId;
        }));
        $message = 'Хабар ўчирилди.';
    } else {
        $settings = $_POST['settings'] ?? [];
        foreach ($data['settings'] as $key => $value) {
            $data['settings'][$key] = admin_value($settings, $key);
        }

        $data['nav'] = admin_lines($_POST['nav'] ?? '');
        $data['sidebar'] = admin_lines($_POST['sidebar'] ?? '');
        $data['poll_options'] = admin_lines($_POST['poll_options'] ?? '');
        $data['clients'] = admin_rows($_POST['clients'] ?? [], ['image' => 'img/client.png', 'alt' => 'Client']);
        $data['links'] = admin_rows($_POST['links'] ?? [], ['title' => '', 'url' => '#']);
        $data['gallery'] = admin_rows($_POST['gallery'] ?? [], ['image' => 'img/mpict1.jpg', 'caption' => '']);
        $data['social'] = admin_rows($_POST['social'] ?? [], ['icon' => 'fa-facebook-square', 'url' => '#']);
        $data['calendar'] = [
            'month' => admin_value($_POST['calendar'] ?? [], 'month') ?: date('Y-m'),
            'title' => admin_value($_POST['calendar'] ?? [], 'title') ?: 'Календарь событий',
            'events' => admin_rows($_POST['calendar_events'] ?? [], [
                'date' => '',
                'time' => '',
                'title' => '',
                'description' => '',
                'url' => '#',
                'color' => '#e18c44',
            ]),
        ];

        $news = [];
        foreach (($_POST['news'] ?? []) as $index => $item) {
            $id = admin_normalize_id($item['id'] ?? '', 'news-' . ($index + 1));
            $news[] = [
                'id' => $id,
                'title' => admin_value($item, 'title'),
                'category' => admin_value($item, 'category'),
                'image' => admin_value($item, 'image') ?: 'img/pict1.jpg',
                'large_image' => admin_value($item, 'large_image') ?: 'img/bpict.jpg',
                'excerpt' => admin_value($item, 'excerpt'),
                'body' => trim((string) ($item['body'] ?? '')),
            ];
        }
        $data['news'] = $news;
        $message = 'Изменения сохранены.';
    }

    $message = admin_clean_message($message);
    cms_save_data($data);
    header('Location: site_content.php?message=' . rawurlencode($message) . '&tab=' . rawurlencode($postedActiveTab), true, 303);
    exit;
}

$settings = $data['settings'];
$pollResults = cms_poll_results($data, $pollVotes);
$pollTotal = count($pollVotes);
$activeTab = preg_replace('/[^a-z0-9_]/i', '', $_GET['tab'] ?? 'tab_requests') ?: 'tab_requests';
$tabs = ['tab_requests', 'tab_poll', 'tab_settings', 'tab_lists', 'tab_media', 'tab_calendar', 'tab_news'];
if (!in_array($activeTab, $tabs, true)) {
    $activeTab = 'tab_requests';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title>Админка | Управление сайтом</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <style>
        .page-content { margin-left: 0; }
        .site-admin-wrap { max-width: 1180px; margin: 0 auto; }
        .site-admin-actions { display: flex; gap: 10px; justify-content: flex-end; margin-bottom: 18px; }
        .site-admin-toolbar {
            position: sticky;
            top: 46px;
            z-index: 20;
            margin: 0 0 18px;
            padding: 12px 15px;
            background: #fff;
            border: 1px solid #e7ecf1;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }
        .site-admin-toolbar .nav-tabs { border-bottom: 0; }
        .site-admin-toolbar .nav-tabs > li > a { border-radius: 3px; }
        .site-admin-toolbar .toolbar-actions { text-align: right; }
        .site-stat {
            display: block;
            margin-bottom: 18px;
            padding: 16px;
            background: #fff;
            border: 1px solid #e7ecf1;
        }
        .site-stat strong { display: block; font-size: 24px; line-height: 1; }
        .site-stat span { color: #7b8898; text-transform: uppercase; font-size: 12px; }
        .news-editor { border-top: 1px solid #e7ecf1; padding-top: 18px; margin-top: 18px; }
        .news-editor:first-child { border-top: 0; margin-top: 0; padding-top: 0; }
        .calendar-event-row {
            margin-bottom: 12px;
            padding: 12px 0 2px;
            border-top: 1px solid #eef1f5;
        }
        .compact-row { margin-bottom: 10px; }
        textarea.form-control { min-height: 120px; resize: vertical; }
    </style>
</head>
<body class="page-header-fixed page-content-white">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner">
            <div class="page-logo">
                <a href="site_content.php" style="color:#fff;font-size:18px;line-height:46px;text-decoration:none;">Site Admin</a>
            </div>
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li>
                        <a href="http://localhost:8000/index.php" target="_blank">
                            <i class="icon-globe"></i> Открыть сайт
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="page-container">
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="site-admin-wrap">
                    <h3 class="page-title">Управление сайтом <small>настройки и новости</small></h3>

                    <?php if ($message): ?>
                    <div class="alert alert-success"><?php echo e($message); ?></div>
                    <?php endif; ?>

                    <form method="post" action="site_content.php">
                        <input type="hidden" name="active_tab" id="active_tab" value="<?php echo e($_GET['tab'] ?? 'tab_requests'); ?>">
                        <div class="row">
                            <div class="col-md-3"><div class="site-stat"><strong><?php echo $pollTotal; ?></strong><span>Голоса опроса</span></div></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><div class="site-stat"><strong><?php echo count($submissions); ?></strong><span>Заявки</span></div></div>
                            <div class="col-md-3"><div class="site-stat"><strong><?php echo count($data['news']); ?></strong><span>Новости</span></div></div>
                            <div class="col-md-3"><div class="site-stat"><strong><?php echo count($data['calendar']['events'] ?? []); ?></strong><span>События</span></div></div>
                            <div class="col-md-3"><div class="site-stat"><strong><?php echo count($data['gallery']); ?></strong><span>Фото галереи</span></div></div>
                        </div>

                        <div class="site-admin-toolbar">
                            <div class="row">
                                <div class="col-md-8">
                                    <ul class="nav nav-tabs">
                                        <li class="<?php echo $activeTab === 'tab_poll' ? 'active' : ''; ?>"><a href="#tab_poll" data-toggle="tab"><i class="icon-bar-chart"></i> Опрос</a></li>
                                        <li class="<?php echo $activeTab === 'tab_requests' ? 'active' : ''; ?>"><a href="#tab_requests" data-toggle="tab"><i class="icon-envelope"></i> Заявки</a></li>
                                        <li class="<?php echo $activeTab === 'tab_settings' ? 'active' : ''; ?>"><a href="#tab_settings" data-toggle="tab"><i class="icon-settings"></i> Настройки</a></li>
                                        <li class="<?php echo $activeTab === 'tab_lists' ? 'active' : ''; ?>"><a href="#tab_lists" data-toggle="tab"><i class="icon-list"></i> Меню</a></li>
                                        <li class="<?php echo $activeTab === 'tab_media' ? 'active' : ''; ?>"><a href="#tab_media" data-toggle="tab"><i class="icon-picture"></i> Медиа</a></li>
                                        <li class="<?php echo $activeTab === 'tab_calendar' ? 'active' : ''; ?>"><a href="#tab_calendar" data-toggle="tab"><i class="icon-calendar"></i> Календарь</a></li>
                                        <li class="<?php echo $activeTab === 'tab_news' ? 'active' : ''; ?>"><a href="#tab_news" data-toggle="tab"><i class="icon-docs"></i> Новости</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-4 toolbar-actions">
                                    <button class="btn green" type="submit" name="action" value="save">
                                        <i class="fa fa-save"></i> Сохранить
                                    </button>
                                    <button class="btn blue" type="submit" name="action" value="add">
                                        <i class="fa fa-plus"></i> Добавить новость
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane <?php echo $activeTab === 'tab_requests' ? 'active' : ''; ?>" id="tab_requests">

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-envelope font-red"></i>
                                    <span class="caption-subject font-red bold uppercase">Заявки с сайта</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php if (!$submissions): ?>
                                <p class="text-muted">Заявок пока нет.</p>
                                <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Дата</th>
                                                <th>Источник</th>
                                                <th>Имя</th>
                                                <th>Контакты</th>
                                                <th>Компания</th>
                                                <th>Сообщение</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($submissions as $submission): ?>
                                            <tr>
                                                <td><?php echo e($submission['created_at'] ?? ''); ?></td>
                                                <td><?php echo e($submission['source'] ?? ''); ?></td>
                                                <td><?php echo e($submission['name'] ?? ''); ?></td>
                                                <td>
                                                    <?php echo e($submission['phone'] ?? ''); ?><br>
                                                    <small><?php echo e($submission['email'] ?? ''); ?></small>
                                                </td>
                                                <td><?php echo e($submission['company'] ?? ''); ?></td>
                                                <td><?php echo nl2br(e($submission['message'] ?? '')); ?></td>
                                                <td>
                                                    <button class="btn btn-xs red" type="submit" name="action" value="delete_submission:<?php echo e($submission['id'] ?? ''); ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                            </div>
                            <div class="tab-pane <?php echo $activeTab === 'tab_poll' ? 'active' : ''; ?>" id="tab_poll">

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-bar-chart font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">Результаты опроса</span>
                                </div>
                                <div class="actions">
                                    <button class="btn btn-sm red" type="submit" name="action" value="clear_poll">
                                        <i class="fa fa-trash"></i> Очистить
                                    </button>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <p><strong><?php echo e($settings['poll_question']); ?></strong></p>
                                <?php if (!$pollResults): ?>
                                <p class="text-muted">Варианты опроса не заданы.</p>
                                <?php else: ?>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Вариант</th>
                                            <th>Голосов</th>
                                            <th>Доля</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pollResults as $result): ?>
                                        <?php $percent = $pollTotal > 0 ? round(($result['count'] / $pollTotal) * 100) : 0; ?>
                                        <tr>
                                            <td><?php echo e($result['option']); ?></td>
                                            <td><?php echo (int) $result['count']; ?></td>
                                            <td>
                                                <div class="progress" style="margin-bottom:0;">
                                                    <div class="progress-bar progress-bar-success" style="width: <?php echo $percent; ?>%;"><?php echo $percent; ?>%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php endif; ?>

                                <h4>Последние голоса</h4>
                                <?php if (!$pollVotes): ?>
                                <p class="text-muted">Голосов пока нет.</p>
                                <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Дата</th>
                                                <th>Ответ</th>
                                                <th>IP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array_slice($pollVotes, 0, 30) as $vote): ?>
                                            <tr>
                                                <td><?php echo e($vote['created_at'] ?? ''); ?></td>
                                                <td><?php echo e($vote['option'] ?? ''); ?></td>
                                                <td><?php echo e($vote['ip'] ?? ''); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                            </div>
                            <div class="tab-pane <?php echo $activeTab === 'tab_settings' ? 'active' : ''; ?>" id="tab_settings">

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-settings font-blue"></i>
                                    <span class="caption-subject font-blue bold uppercase">Настройки сайта</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <?php
                                    $settingLabels = [
                                        'site_name' => 'Название сайта',
                                        'logo' => 'Логотип',
                                        'hero_title' => 'Заголовок слайда',
                                        'hero_subtitle' => 'Подзаголовок слайда',
                                        'feedback_label' => 'Кнопка обратной связи',
                                        'phone_1' => 'Телефон 1',
                                        'phone_2' => 'Телефон 2',
                                        'address' => 'Адрес',
                                        'email' => 'Email',
                                        'director' => 'Директор',
                                        'director_role' => 'Должность',
                                        'about_title' => 'Заголовок блока',
                                        'magazine_title' => 'Журнал',
                                        'magazine_image' => 'Картинка журнала',
                                        'poll_title' => 'Заголовок опроса',
                                        'poll_question' => 'Вопрос опроса',
                                        'footer_credit' => 'Разработчик сайта',
                                        'copyright' => 'Copyright',
                                        'form_title' => 'Заголовок формы',
                                        'form_name' => 'Поле: имя',
                                        'form_email' => 'Поле: email',
                                        'form_phone' => 'Поле: телефон',
                                        'form_company' => 'Поле: компания',
                                        'form_message' => 'Поле: сообщение',
                                        'form_submit' => 'Кнопка формы',
                                    ];
                                    ?>
                                    <?php foreach ($settingLabels as $key => $label): ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo e($label); ?></label>
                                            <input class="form-control" name="settings[<?php echo e($key); ?>]" value="<?php echo e($settings[$key] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Текст о компании</label>
                                            <textarea class="form-control" name="settings[about_text]"><?php echo e($settings['about_text']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Текст в футере</label>
                                            <textarea class="form-control" name="settings[footer_text]"><?php echo e($settings['footer_text']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            </div>
                            <div class="tab-pane <?php echo $activeTab === 'tab_lists' ? 'active' : ''; ?>" id="tab_lists">

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-list font-purple"></i>
                                    <span class="caption-subject font-purple bold uppercase">Меню и простые списки</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Главное меню, по одному пункту в строке</label>
                                            <textarea class="form-control" name="nav"><?php echo e(implode(PHP_EOL, $data['nav'])); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Боковое меню</label>
                                            <textarea class="form-control" name="sidebar"><?php echo e(implode(PHP_EOL, $data['sidebar'])); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Варианты опроса</label>
                                            <textarea class="form-control" name="poll_options"><?php echo e(implode(PHP_EOL, $data['poll_options'])); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            </div>
                            <div class="tab-pane <?php echo $activeTab === 'tab_media' ? 'active' : ''; ?>" id="tab_media">

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-picture font-yellow"></i>
                                    <span class="caption-subject font-yellow bold uppercase">Галерея, клиенты, ссылки</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <h4>Галерея</h4>
                                <?php foreach ($data['gallery'] as $index => $item): ?>
                                <div class="row">
                                    <div class="col-md-6"><input class="form-control" name="gallery[<?php echo $index; ?>][image]" value="<?php echo e($item['image']); ?>" placeholder="Путь к картинке"></div>
                                    <div class="col-md-6"><input class="form-control" name="gallery[<?php echo $index; ?>][caption]" value="<?php echo e($item['caption']); ?>" placeholder="Подпись"></div>
                                </div>
                                <br>
                                <?php endforeach; ?>
                                <h4>Клиенты</h4>
                                <?php foreach ($data['clients'] as $index => $item): ?>
                                <div class="row">
                                    <div class="col-md-6"><input class="form-control" name="clients[<?php echo $index; ?>][image]" value="<?php echo e($item['image']); ?>" placeholder="Путь к логотипу"></div>
                                    <div class="col-md-6"><input class="form-control" name="clients[<?php echo $index; ?>][alt]" value="<?php echo e($item['alt'] ?? ''); ?>" placeholder="Alt"></div>
                                </div>
                                <br>
                                <?php endforeach; ?>
                                <h4>Внешние ссылки</h4>
                                <?php foreach ($data['links'] as $index => $item): ?>
                                <div class="row">
                                    <div class="col-md-6"><input class="form-control" name="links[<?php echo $index; ?>][title]" value="<?php echo e($item['title']); ?>" placeholder="Текст ссылки"></div>
                                    <div class="col-md-6"><input class="form-control" name="links[<?php echo $index; ?>][url]" value="<?php echo e($item['url']); ?>" placeholder="URL"></div>
                                </div>
                                <br>
                                <?php endforeach; ?>
                                <h4>Соцсети</h4>
                                <?php foreach ($data['social'] as $index => $item): ?>
                                <div class="row">
                                    <div class="col-md-6"><input class="form-control" name="social[<?php echo $index; ?>][icon]" value="<?php echo e($item['icon']); ?>" placeholder="FontAwesome icon"></div>
                                    <div class="col-md-6"><input class="form-control" name="social[<?php echo $index; ?>][url]" value="<?php echo e($item['url']); ?>" placeholder="URL"></div>
                                </div>
                                <br>
                                <?php endforeach; ?>
                            </div>
                        </div>

                            </div>
                            <div class="tab-pane <?php echo $activeTab === 'tab_calendar' ? 'active' : ''; ?>" id="tab_calendar">

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-calendar font-blue"></i>
                                    <span class="caption-subject font-blue bold uppercase">Календарь событий</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Месяц календаря</label>
                                            <input class="form-control" type="month" name="calendar[month]" value="<?php echo e($data['calendar']['month'] ?? date('Y-m')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Заголовок календаря</label>
                                            <input class="form-control" name="calendar[title]" value="<?php echo e($data['calendar']['title'] ?? 'Календарь событий'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $calendarEvents = $data['calendar']['events'] ?? [];
                                $existingCalendarEvents = count($calendarEvents);
                                for ($blank = 0; $blank < 5; $blank++) {
                                    $calendarEvents[] = ['date' => '', 'time' => '', 'title' => '', 'description' => '', 'url' => '#', 'color' => '#e18c44'];
                                }
                                ?>
                                <p class="text-muted">Чтобы добавить событие, заполните пустую строку. Чтобы удалить событие, отметьте чекбокс и нажмите «Сохранить».</p>
                                <?php foreach ($calendarEvents as $index => $event): ?>
                                <div class="row calendar-event-row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Дата</label>
                                            <input class="form-control" type="date" name="calendar_events[<?php echo $index; ?>][date]" value="<?php echo e($event['date'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Время</label>
                                            <input class="form-control" type="time" name="calendar_events[<?php echo $index; ?>][time]" value="<?php echo e($event['time'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Событие</label>
                                            <input class="form-control" name="calendar_events[<?php echo $index; ?>][title]" value="<?php echo e($event['title'] ?? ''); ?>" placeholder="Название события">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Цвет</label>
                                            <input class="form-control" type="color" name="calendar_events[<?php echo $index; ?>][color]" value="<?php echo e($event['color'] ?? '#e18c44'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>Удалить</label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="calendar_events[<?php echo $index; ?>][_delete]" value="1" <?php echo $index >= $existingCalendarEvents ? 'disabled' : ''; ?>>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Описание</label>
                                            <input class="form-control" name="calendar_events[<?php echo $index; ?>][description]" value="<?php echo e($event['description'] ?? ''); ?>" placeholder="Краткое описание">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Ссылка</label>
                                            <input class="form-control" name="calendar_events[<?php echo $index; ?>][url]" value="<?php echo e($event['url'] ?? '#'); ?>" placeholder="URL или #">
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                            </div>
                            <div class="tab-pane <?php echo $activeTab === 'tab_news' ? 'active' : ''; ?>" id="tab_news">

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-docs font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">Новости сайта</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php foreach ($data['news'] as $index => $item): ?>
                                <div class="news-editor">
                                    <h4>
                                        <?php echo e($item['title']); ?>
                                        <small><?php echo e($item['category']); ?> / <?php echo e($item['id']); ?></small>
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ID</label>
                                                <input class="form-control" name="news[<?php echo $index; ?>][id]" value="<?php echo e($item['id']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Заголовок</label>
                                                <input class="form-control" name="news[<?php echo $index; ?>][title]" value="<?php echo e($item['title']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Категория</label>
                                                <input class="form-control" name="news[<?php echo $index; ?>][category]" value="<?php echo e($item['category']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Картинка карточки</label>
                                                <input class="form-control" name="news[<?php echo $index; ?>][image]" value="<?php echo e($item['image']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Картинка страницы</label>
                                                <input class="form-control" name="news[<?php echo $index; ?>][large_image]" value="<?php echo e($item['large_image']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Краткое описание</label>
                                                <textarea class="form-control" name="news[<?php echo $index; ?>][excerpt]"><?php echo e($item['excerpt']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Полный текст</label>
                                                <textarea class="form-control" name="news[<?php echo $index; ?>][body]"><?php echo e($item['body']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <a class="btn default" href="http://localhost:8000/view.php?id=<?php echo rawurlencode($item['id']); ?>" target="_blank">
                                                <i class="fa fa-eye"></i> Посмотреть
                                            </a>
                                            <button class="btn red" type="submit" name="action" value="delete:<?php echo e($item['id']); ?>">
                                                <i class="fa fa-trash"></i> Удалить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                            </div>
                        </div>

                        <div class="site-admin-actions">
                            <button class="btn green" type="submit" name="action" value="save">
                                <i class="fa fa-save"></i> Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script>
        jQuery(function ($) {
            $('.site-admin-toolbar a[data-toggle="tab"]').on('shown.bs.tab', function (event) {
                $('#active_tab').val($(event.target).attr('href').replace('#', ''));
            });
        });
    </script>
</body>
</html>
