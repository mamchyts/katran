<!DOCTYPE html>
<html lang="<?=\Katran\Helper::_cfg('lang');?>">
    <head>
        <meta charset="<?=\Katran\Helper::_cfg('page_charset');?>"/>
        <meta http-equiv="Content-Type" content="text/html; charset=<?=\Katran\Helper::_cfg('page_charset');?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Административная часть сайта</title>

        <!-- favicon -->
        <link rel="icon"          href="/favicon.ico"/>
        <link rel="shortcut icon" href="/favicon.ico"/>

        <!-- include CSS files -->
        <link type="text/css" href="/js/bower_components/materialize/dist/css/materialize.css" rel="stylesheet"/>
        <link type="text/css" href="/css/iconfont/materialIcons.css" rel="stylesheet"/>
        <link type="text/css" href="/css/common.css" rel="stylesheet"/>
        <link type="text/css" href="/css/admin.css"  rel="stylesheet"/>

        <!-- include JS files -->
        <script type="text/javascript" src="/js/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="/js/bower_components/materialize/dist/js/materialize.js"></script>
        <script type="text/javascript" src="/js/common.js"></script>
        <script type="text/javascript" src="/js/admin.js"></script>
        <script type="text/javascript" src="/js/error.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <?php if(!empty($_SESSION['admin']['id'])):?>
            <!--  START:  MENU  -->
            <header>
                <ul id="nav-mobile" class="side-nav fixed">
                    <li class="logo">
                        <a href="/admin">Админка</a>
                    </li>
                    <li class="<?=(\Katran\Helper::_menu('stat', true))?'active':''?>">
                        <a href="/admin" class="waves-effect waves-light">Главная</a>
                    </li>
                    <?php if(in_array($_SESSION['admin']['role'], ['admin'])):?>
                        <li class="<?=(\Katran\Helper::_menu('account', true))?'active':''?>">
                            <a href="/admin?controller=account&amp;action=list" class="waves-effect waves-light">Пользователи</a>
                        </li>
                        <li class="<?=(\Katran\Helper::_menu('page', true))?'active':''?>">
                            <a href="/admin?controller=page&amp;action=list" class="waves-effect waves-light">Страницы</a>
                        </li>
                        <li class="<?=(\Katran\Helper::_menu('setting', true))?'active':''?>">
                            <a href="/admin?controller=setting&amp;action=tabs" class="waves-effect waves-light">Настройки</a>
                        </li>
                    <?php endif;?>
                    <li>
                        <a href="/admin?controller=account&amp;action=logout" class="waves-effect waves-light">Выход</a>
                    </li>
                </ul>
            </header>
            <!--  FINISH: MENU  -->
        <?php endif;?>


        <div class="main <?=!empty($_SESSION['admin']['id'])?'main-margin-left':''?>">
            <nav class="top-nav">
                <div class="container">
                    <a href="javascript:void(0)" data-activates="nav-mobile" class="top-nav waves-effect waves-light circle hide-on-large-only button-collapse">
                        <i class="mdi-navigation-menu"></i>
                    </a>
                    <div class="nav-wrapper">
                        <a class="page-title"><?=\Katran\Helper::_menu(false, true, true)?></a>
                        <?php if( !empty($_SESSION['admin']['id']) ):?>
                            <div class="right">
                                <a class="header-shop-title"><?=$_SESSION['admin']['name']?></a>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </nav>
            <div class="container">

                <!--  START: STATUS MESSAGES  -->
                <section>
                    <div class="alert-block">
                        <?php foreach(Katran\Library\Flashbag::get(Katran\Library\Flashbag::TYPE_ERROR) as $e):?>
                            <div class="alert-block__alert alert-block__alert--danger z-depth-1">
                                <?=$e?>
                                <i class="material-icons alert-block__clear">&#xe14c;</i>
                            </div>
                        <?php endforeach;?>
                        <?php foreach(Katran\Library\Flashbag::get(Katran\Library\Flashbag::TYPE_INFO) as $m):?>
                            <div class="alert-block__alert alert-block__alert--success z-depth-1">
                                <?=$m?>
                                <i class="material-icons alert-block__clear">&#xe14c;</i>
                            </div>
                        <?php endforeach;?>
                    </div>
                </section>
                <!--  END: STATUS MESSAGES  -->

                <section class="page-content">
                    <!--  START: VIEW CONTENT  -->
                    <?php echo $layoutContent?>
                    <!--  END: VIEW CONTENT  -->
                </section>
            </div>

            <?php if(\Katran\Helper::_cfg('debug')):?>
                <!--  START: DEBUG INFORMATION -->
                <div class="row" style="margin: 100px 0;">
                    <div class="col s12">
                        Page rendered in <?=\Katran\Library\Timer::time('globalStart')?> seconds.<br/>
                        Page used memory in <?=\Katran\Library\Timer::memUse()?>.
                        <?=$debug?>
                    </div>
                </div>
                <!--  END: DEBUG INFORMATION -->
            <?php endif;?>
        </div>


        <script type="text/javascript">
            window.FileAPI = {
                debug: false,   // debug mode, see Console
                cors: false,    // if used CORS, set `true`
                media: false,   // if used WebCam, set `true`
                staticPath: '/js/bower_components/fileapi/dist/', // path to '*.swf'
                postNameConcat: function (name, idx){
                    // Default: object[foo]=1&object[bar][baz]=2
                    // .NET: https://github.com/mailru/FileAPI/issues/121#issuecomment-24590395
                    return  name + (idx != null ? '['+ idx +']' : '');
                }
            };
        </script>

        <!-- delete confirmation wnd -->
        <template name="deleteConfirmation"></template>

        <!-- include other files -->
        <script type="text/javascript" src="/js/bower_components/tinymce/tinymce.js"></script>
        <script type="text/javascript" src="/js/bower_components/fileapi/dist/FileAPI.min.js"></script>

    </body>
</html>