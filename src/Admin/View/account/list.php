<form action="<?=$currentUrl;?>" method="post" name="search">

    <div class="row list-search-block">
        <div class="input-field col s6">
            <i class="material-icons prefix">&#xe8b6;</i>
            <input type="text" name="search" value="<?=$search?>" id="search-field" class="validate">
            <label for="search-field">Поиск</label>
        </div>
        <div class="input-field col s6">
            <input type="submit" name="searchBtn" class="waves-effect waves-light btn" value="Поиск"/>
        </div>
    </div>

    <?php if(in_array($_SESSION['admin']['role'], array('admin'))):?>
        <a href="/admin?controller=account&amp;action=view&amp;id=new" class="waves-effect waves-light btn">Добавить нового пользователя</a>
    <?php endif;?>

    <table class="striped highlight margin-list-table" cellpadding="0" cellspacing="0" border="0" width="100%">
        <thead>
            <tr>
                <th width="40" class="checkbox-td-container">
                    <input type="checkbox" class="filled-in" id="checkbox-all-in-table"/>
                    <label for="checkbox-all-in-table"></label>
                </th>
                <th width="60"><?=$sorter->getHtml('id', 'ID')?></th>
                <th><?=$sorter->getHtml('login', 'Login')?></th>
                <th><?=$sorter->getHtml('name', 'Имя')?></th>
                <th><?=$sorter->getHtml('status', 'Статус')?></th>
                <th>Права</th>
                <th width="180"><?=$sorter->getHtml('cdate', 'Дата создания')?></th>
                <th width="55">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($rows as $key=>$r):?>
                <tr>
                    <td width="40" class="checkbox-td-container">
                        <input type="checkbox" class="filled-in" name="ids[]" value="<?=$r['id']?>" id="checkbox-<?=$r['id']?>"/>
                        <label for="checkbox-<?=$r['id']?>"></label>
                    </td>
                    <td><?=$r['id']?></td>
                    <td><?=$r['login']?></td>
                    <td><?=$r['name']?></td>
                    <td><?=\Katran\Helper::_cfg('statuses', $r['status'])?></td>
                    <td><?=\Katran\Helper::_cfg('roles', $r['role'])?></td>
                    <td><?=\Katran\Helper::_date($r['cdate'], 'Y-m-d')?></td>
                    <td>
                        <a href="/admin?controller=account&amp;action=view&amp;id=<?=$r['id']?>" class="">ред.</a>
                    </td>
                </tr>
            <?php endforeach;?>

            <?php if(!sizeof($rows)):?>
                <tr>
                    <td colspan="10">
                        <div class="">Ничего не найдено...</div>
                    </td>
                </tr>
            <?php endif;?>
        </tbody>
    </table>

    <div class="row">
        <div class="col s12">
            <div class="left table-btn-action-block">
                <?php if(in_array($_SESSION['admin']['role'], array('admin'))):?>
                    <a href="javascript:void(0)" class="waves-effect waves-light btn table-btn-action-block__delete">Удалить</a>
                <?php endif;?>
            </div>

            <?=$pager->getHtml()?>
        </div>
    </div>

</form>
