<div class="default-page-block">

    <div class="row devider-row">
        <div class="col s12">
            <div class="devider-row__title bg-color z-depth-1">
                <ol class="breadcrumb-block">
                    <li class="breadcrumb-block__item ">
                        <a href="/" class="breadcrumb-block__item__a first-breadcrumb-item-a">
                            <i class="material-icons first-breadcrumb-item-a__i">&#xe8f0;</i>Главная
                        </a>
                    </li>
                    <li class="breadcrumb-block__item ">
                        <a href="javascript:void(0)" class="breadcrumb-block__item__a--active breadcrumb-item-a">
                            <i class="material-icons breadcrumb-item-a__i">&#xe037;</i><?=$page['title']?>
                        </a>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <section class="page-<?=$page['url']?>">
        <?=$page['html']?>
    </section>
</div>
