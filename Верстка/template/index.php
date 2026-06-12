<?php
require __DIR__ . '/app/cms.php';

$cms = cms_load_site_data();
$settings = $cms['settings'];
$cms_form_notice = cms_handle_request_form();
$cms_poll_notice = cms_handle_poll_form($cms);
$pageTitle = $settings['site_name'];
$homeNews = array_slice($cms['news'], 0, 3);
$newsTotal = count($cms['news']);
$aboutParts = preg_split("/\r\n|\n|\r/", trim((string) $settings['about_text']), 2);
$aboutLead = $aboutParts[0] ?? '';
$aboutRest = $aboutParts[1] ?? '';
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
<body>
	<header>
		<div class="container">
			<a class="navbar-brand" href="<?php echo e(cms_url('index.php')); ?>"><?php echo e($settings['logo']); ?></a>
			<button class="open_msg" data-toggle="modal" data-target="#myModal"><?php echo e($settings['feedback_label']); ?></button>
			<?php cms_render_language_switcher(); ?>
			<div class="info"><i class="fa fa-phone"></i><?php echo e($settings['phone_1']); ?><br><?php echo e($settings['phone_2']); ?></div>
			<div class="info"><i class="fa fa-map-marker"></i><?php echo e($settings['address']); ?></div>
		</div>
	</header>
	<div class="slider">
		<div class="caption">
			<div class="container">
				<h3><?php echo e($settings['hero_title']); ?></h3>
				<hr>
				<h3><?php echo e($settings['hero_subtitle']); ?></h3>
			</div>
		</div>
		<img src="img/slide1.jpg" alt="">
	</div>
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
	<div class="about">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<h3 class="title"><?php echo e($settings['about_title']); ?></h3>
					<hr class="bold">
				</div>
				<div class="col-md-6">
					<?php if ($aboutLead !== ''): ?><b><?php echo e($aboutLead); ?></b><?php endif; ?>
					<?php if ($aboutRest !== ''): ?><br><?php echo nl2br(e($aboutRest)); ?><?php endif; ?>
				</div>
				<div class="col-md-3">
					<h4><?php echo e($settings['director']); ?></h4>
					<div class="lvl"><?php echo e($settings['director_role']); ?></div>
					<hr class="bold">
				</div>
			</div>
		</div>
	</div>
	<div class="news">
		<div class="container">
			<h3 class="title"><?php echo e($cms['nav'][1] ?? cms_t('news_title', $cms)); ?></h3>
			<hr class="bold">
			<div class="row">
				<div class="col-md-9">
					<div class="row">
						<?php foreach ($homeNews as $item): ?>
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
					<div class="news-more">
						<a href="<?php echo e(cms_url('articles.php')); ?>"><?php echo e(cms_t('all_news', $cms)); ?> <i class="fa fa-angle-right"></i></a>
					</div>
				</div>
				<div class="col-md-3"><?php cms_render_sidebar($cms); ?></div>
			</div>
		</div>
	</div>
	<?php cms_render_gallery($cms); ?>
	<?php cms_render_home_extra($cms); ?>
	<?php cms_render_clients_links_footer($cms); ?>
	<?php cms_render_scripts_and_modal($cms); ?>
</body>
</html>
