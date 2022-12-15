<div>
    <div class='msg'>
        <p></p>
        <?php
        if (!empty($params['before'])) {
            switch ($params['before']) {
                case 'created':
                    echo '<b>Note created</b>';
                    break;
                case 'edited':
                    echo '<b>Note updated</b>';
                    break;
                case 'deleted':
                    echo '<b>Note deleted</b>';
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
                    echo '<b>Undefined memo</b>';
                    break;
                case 'noid':
                    echo '<b>URL error</b>';
                    break;
            }
        }
        ?>
    </div>
    <?php
    $sort = $params['sort'];
    $sortby = $sort['sortby'] ?? 'title';
    $sortorder = $sort['sortorder'] ?? 'desc';
    $search = $params['search'] ?? null;
    ?>

    <div>

    </div>

    <div>
        <form class="sort-form" action="./" method="GET">
            <div>
                <label><input type="text" name="search" id="search-input" placeholder="search"/></label>
            </div>

            <div class="sort-box">Sort by:
                <label>Title:<input type="radio" name="sortby" value="title" <?php echo $sortby === 'title' ? 'checked' : '' ?> /></label>
                <label>Date:<input type="radio" name="sortby" value="created" <?php echo $sortby === 'created' ? 'checked' : '' ?> /></label>
            </div>
            <div class="sort-box">Sort direction
                <label>Ascending:<input type="radio" name="sortorder" value="asc" <?php echo $sortorder === 'asc' ? 'checked' : '' ?> /></label>
                <label>Descending:<input type="radio" name="sortorder" value="desc" <?php echo $sortorder === 'desc' ? 'checked' : '' ?> /></label>
            </div>
            <input class="default-btn" id="sort-btn" type="submit" value="search">
        </form>
    </div>

    <div class="tbl-head">
        <table cellpadding="0" cellspacing="0" border="0">
            <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>date</th>
                    <th>option</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="tbl-core">
        <table>
            <tbody>
                <?php foreach ($params['notes'] ?? [] as $note) : ?>
                    <tr>
                        <td><?php echo $note['id'] ?></td>
                        <td><?php echo $note['title'] ?></td>
                        <td><?php echo $note['created'] ?></td>
                        <td>
                            <button class="details">
                                <a href="./?action=show&id=<?php echo $note['id'] ?>" class="showLink">SHOW</a>
                            </button>
                            <button class="details">
                                <a href="./?action=delete&id=<?php echo $note['id'] ?>" class="showLink">DELETE</a>
                            </button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>