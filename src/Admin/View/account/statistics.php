<table class="striped responsive-table">
    <thead></thead>
    <tbody>
        <tr>
            <th width="200">Раздел</th>
            <th>Активные / Все</th>
        </tr>
        <?php if(in_array($_SESSION['admin']['role'],['admin'])):?>
            <tr>
                <td>Пользователей</td>
                <td><?=$usersActive?> / <?=$users?></td>
            </tr>
        <?php endif;?>
    </tbody>
</table>