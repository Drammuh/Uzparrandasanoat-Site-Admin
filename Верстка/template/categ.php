<?php
require __DIR__ . '/app/cms.php';

$cms = cms_load_site_data();
$settings = $cms['settings'];
$cms_form_notice = cms_handle_request_form();
$pageTitle = cms_t('news_title', $cms);
$pagination = cms_paginate_items($cms['news'], $_GET['page'] ?? 1, 3);
?>
<!DOCTYPE html>
<html lang="<?php echo e(cms_current_lang()); ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo e($pageTitle ?? 'Template'); ?></title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/slick-theme.css">
	<link rel="stylesheet" href="css/slick.css">
	<link rel="stylesheet" href="css/lightbox.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/media.css">
</head>
<body class="no-index">
	<header>
		<div class="container">
			<a class="navbar-brand" href="<?php echo e(cms_url('index.php')); ?>"><?php echo e($settings['logo']); ?></a>
			<button class="open_msg" data-toggle="modal" data-target="#myModal"><?php echo e($settings['feedback_label']); ?></button>
			<?php cms_render_language_switcher(); ?>
			<div class="info"><i class="fa fa-phone"></i><?php echo e($settings['phone_1']); ?><br><?php echo e($settings['phone_2']); ?></div>
			<div class="info"><i class="fa fa-map-marker"></i><?php echo e($settings['address']); ?></div>
		</div>
	</header>
	<nav class="navbar">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<?php foreach ($cms['nav'] as $navItem): ?>
					<li><a href="<?php echo e(cms_url('categ.php')); ?>"><?php echo e($navItem); ?></a></li>
					<?php endforeach; ?>
				</ul>
				<button class="open_search"><i class="fa fa-search"></i></button>
			</div>
		</div>
	</nav>
	<div class="search_box">
		<div class="container">
			<form action="">
				<div class="input">
					<input type="text" placeholder="<?php echo e(cms_t('search_placeholder', $cms)); ?>">
					<input type="submit" value="<?php echo e(cms_t('search_button', $cms)); ?>">
				</div>
			</form>
		</div>
	</div>
	<div class="wrapper">
		<div class="container">
			<h2 class="title"><?php echo e($pageTitle); ?></h2>
			<div class="news">
				<div class="row">
					<div class="col-md-9">
						<div class="row">
							<?php foreach ($pagination['items'] as $item): ?>
							<div class="col-md-4">
								<div class="news_box">
									<div class="img"><img src="<?php echo e($item['image']); ?>" alt=""></div>
									<div class="categ"><?php echo e($item['category']); ?></div>
									<div class="body">
										<a href="<?php echo e(cms_news_url($item)); ?>"><?php echo e($item['title']); ?></a>
										<div class="desc"><?php echo e($item['excerpt']); ?></div>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						<?php cms_render_pagination($pagination, 'categ.php'); ?>
					</div>
					<div class="col-md-3"><?php cms_render_sidebar($cms); ?></div>
				</div>
			</div>
		</div>
	</div>
	<?php cms_render_clients_links_footer($cms); ?>
	<?php cms_render_scripts_and_modal($cms); ?>
</body>
</html>
