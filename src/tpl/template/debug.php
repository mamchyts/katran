<div><a href="javascript:void(0)" id="debug_show" onclick="$('#main_debug_log').toggleClass('noDisplay')">Debug</a></div>
<div id="main_debug_log" class="">
    <div class="row">
        <ul class="tabs z-depth-1" style="margin-bottom: 10px;;">
            <li class="tab col s3"><a href="#debug-sql">SQL</a></li>
            <li class="tab col s3"><a href="#debug-timer">Timer</a></li>
            <li class="tab col s3"><a href="#debug-request">Request</a></li>
            <li class="tab col s3"><a href="#debug-session">Session</a></li>
            <li class="tab col s3"><a href="#debug-server">Server</a></li>
        </ul>
        <div id="debug-sql" class="col s12 z-depth-1">
            <table class="striped highlight">
                <thead>
                    <tr>
                        <th width="350">Time</th>
                        <th>SQL query</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $all = 0; ?>
                    <?php foreach($sql as $s):?>
                        <?php $all += $s['time']; ?>
                        <tr>
                            <td style="background-color:<?=($s['time'] < 0.001)?'none':(($s['time'] < 0.01)?'#ff8080':'#ea0000')?>"><?=$s['time']?></td>
                            <td><?=$s['request']?></td>
                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="2"><b>All time:</b> <?=$all?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Count SQL:</b> <?=count($sql)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="debug-timer" class="col s12 z-depth-1">
            <table class="striped highlight">
                <thead>
                    <tr>
                        <th width="350">Point 1</th>
                        <th width="350">Point 2</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($timer as $t):?>
                        <tr>
                            <td><?=$t[0]?></td>
                            <td><?=$t[1]?></td>
                            <td><?=$t[2]?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <div id="debug-request" class="col s12 z-depth-1">
            <pre><?php print_r($request)?></pre>
        </div>
        <div id="debug-session" class="col s12 z-depth-1">
            <pre><?php print_r($_SESSION)?></pre>
        </div>
        <div id="debug-server" class="col s12 z-depth-1">
            <table class="striped highlight">
                <tbody>
                    <?php foreach($_SERVER as $key=>$s):?>
                        <tr>
                            <td width="350">[<?=$key;?>]</td>
                            <td><?=htmlentities($s);?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

