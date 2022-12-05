<div>
    <div class='msg'>
        <?php
        if (!empty($params['before'])) {
            switch ($params['before']) {
                case 'created':
                    echo '<b>Notatka utworzona</b>';
                    break;
            }
        }
        ?>
    </div>
    <?php echo $params['resultList'] ?? "" ?>
    <h3>lista notatek</h3>
</div>