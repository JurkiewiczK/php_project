<div>
    <?php $note = $params['note']; ?>
    <?php if ($note) : ?>
        <ul>
            <li>
                <h3><?php echo $note['title'] ?></h3>
            </li>
            <li>
                <p><?php echo $note['description'] ?></p>
            </li>
        </ul>
        <form method="POST" action="./?action=delete">
            <input name="id" type="hidden" value="<?php echo $note['id'] ?>">
            <input class="default-btn" type="submit" value="Delete">
        </form>
    <?php endif ?>
    <a href='./'>
        <button class="default-btn">Back to the list</button>
    </a>
</div>