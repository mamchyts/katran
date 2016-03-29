<h5><?=(empty($row['id']))?'Добавить нового пользователя':'Редактировать профиль пользователя'?></h5>
<div class="clear" style="height: 2em;"></div>

<div class="row">
    <form class="" action="<?=$currentUrl;?>" method="post" name="view" autocomplete="off">
        <input type="hidden" name="id" value="<?=(empty($row['id']))?'new':$row['id'];?>"/>

        <div class="row">
            <div class="input-field col s6">
                <input placeholder="Имя" id="row_name" type="text" class="validate" name="data[name]" value="<?=(isset($row['name']))?$row['name']:''?>">
                <label for="row_name">Имя</label>
            </div>
            <div class="input-field col s6">&nbsp;</div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input placeholder="Login" id="row_login" type="text" class="validate" name="data[login]" value="<?=(isset($row['login']))?$row['login']:''?>">
                <label for="row_login">Login</label>
            </div>
            <div class="input-field col s6">&nbsp;</div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <select name="data[role]" class="">
                    <?=\Katran\Library\Html::createSelect(\Katran\Helper::_cfg('roles'), isset($row['role'])?$row['role']:null)?>
                </select>
                <label>Права</label>
            </div>
            <div class="input-field col s6">&nbsp;</div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <select name="data[status]" class="">
                    <?=\Katran\Library\Html::createSelect(\Katran\Helper::_cfg('statuses'), isset($row['status'])?$row['status']:'active')?>
                </select>
                <label>Статус</label>
            </div>
            <div class="input-field col s6">&nbsp;</div>
        </div>


        <?php if(in_array($_SESSION['admin']['role'], array('admin')) || $_SESSION['admin']['id'] == $row['id']):?>
            <div class="clear" style="height: 2em;"></div>
            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="Пароль" id="password" type="password" class="validate" name="data[pass]" value="">
                    <label for="password">Пароль</label>
                </div>
                <div class="input-field col s6">&nbsp;</div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="Пароль повтор" id="pass_re" type="password" class="validate" name="data[pass_re]" value="">
                    <label for="pass_re">Пароль повтор</label>
                </div>
                <div class="input-field col s6">&nbsp;</div>
            </div>
        <?php endif;?>

        <div class="clear" style="height: 2em;"></div>
        <div class="row">
            <div class="input-field col s12">
                <input type="submit" name="submit[account|save]" class="btn btn-primary" value="Сохранить">
            </div>
        </div>
    </form>
</div>