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
    <div class='msg'>
        <?php
        if (!empty($params['error'])) {
            switch ($params['error']) {
                case 'notfound':
                    echo '<b>Nie ma notatki o takim indeksie</b>';
                    break;
                case 'noid':
                    echo '<b>Błędny parametr URL</b>';
            }
        }
        ?>
    </div>
    <div class="tbl-head">
        <table cellpadding="0" cellspacing="0" border="0">
            <thead>
                <tr>
                    <th>id</th>
                    <th>tytuł</th>
                    <th>data</th>
                    <th>Opcje</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="tbl-core">
        <table>
            <tbody>
                <?php foreach ($params['notes'] ?? [] as $note) : ?>
                    <tr>
                        <td><?php echo (int)$note['id'] ?></td>
                        <td><?php echo htmlentities($note['title']) ?></td>
                        <td><?php echo htmlentities($note['created']) ?></td>
                        <td>
                            <button id="details">
                                <a href="./?action=show&id=<?php echo $note['id'] ?>" class="showLink">SHOW</a>
                            </button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>