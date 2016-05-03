<!DOCTYPE html>
<html lang="<?=\Katran\Helper::_cfg('lang');?>">
    <head>
        <meta charset="<?=\Katran\Helper::_cfg('page_charset');?>"/>
        <meta http-equiv="Content-Type" content="text/html; charset=<?=\Katran\Helper::_cfg('page_charset');?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- favicon -->
        <link rel="icon"          href="/favicon.ico"/>
        <link rel="shortcut icon" href="/favicon.ico"/>

        <!-- meta -->
        <?php $meta = \Katran\Database\Db::getModel(new Common\Model\Pages)->getPageMetaData();?>
        <title><?=(!empty($meta['meta_title']))?$meta['meta_title']:'';?></title>
        <meta name="keywords" content="<?=(!empty($meta['meta_keywords']))?$meta['meta_keywords']:'';?>"/>
        <meta name="description" content="<?=(!empty($meta['meta_description']))?$meta['meta_description']:'';?>"/>

        <!-- include CSS files -->
        <link type="text/css" href="/js/bower_components/materialize/dist/css/materialize.min.css" rel="stylesheet"/>
        <link type="text/css" href="/js/bower_components/lightbox2/dist/css/lightbox.min.css" rel="stylesheet"/>
        <link type="text/css" href="/css/iconfont/materialIcons.css" rel="stylesheet"/>
        <link type="text/css" href="/css/common.css" rel="stylesheet"/>
        <link type="text/css" href="/css/visitor.css"  rel="stylesheet"/>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="page-wrapper">
            <header>
                <nav>
                    <div class="nav-wrapper">
                        <a href="/" class="brand-logo">
                            <span class="left clear site-title">Portfolio.Katran.By</span>
                        </a>
                    </div>
                </nav>
            </header>

            <section class="page-content">
                <div class="container">
                    <!--  START: VIEW CONTENT  -->
                    <?php echo $layoutContent?>
                    <!--  END: VIEW CONTENT  -->
                </div>
            </section>

            <footer>
                <div class="footer-links right">
                    <div class="credits">2016 © <a href="http://katran.by/">katran.by</a></div>
                </div>
            </footer>

            <?php if(\Katran\Helper::_cfg('debug')):?>
                <!--  START: DEBUG INFORMATION -->
                <div class="row debug-stat-block" style="margin-top: 50px;">
                    <div class="col s12">
                        Page rendered in <?=\Katran\Library\Timer::time('globalStart')?> seconds.<br/>
                        Page used memory in <?=\Katran\Library\Timer::memUse()?>.
                        <?=$debug?>
                    </div>
                </div>
                <!--  END: DEBUG INFORMATION -->
            <?php endif;?>

        </div>

        <!-- include CSS/JS files -->
        <script type="text/javascript" src="/js/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="/js/bower_components/jquery.nicescroll/jquery.nicescroll.min.js"></script>
        <script type="text/javascript" src="/js/bower_components/materialize/dist/js/materialize.min.js"></script>
        <script type="text/javascript" src="/js/bower_components/lightbox2/dist/js/lightbox.min.js"></script>
        <script type="text/javascript" src="/js/common.js"></script>
        <script type="text/javascript" src="/js/visitor.js"></script>
        <script type="text/javascript" src="/js/error.js"></script>

    </body>
</html>