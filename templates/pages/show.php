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
        <a href="./?action=edit&id=<?php echo $note['id'] ?>">
            <button class="default-btn">Edit note</button>
        </a>
    <?php endif ?>
    <a href='./'>
            <button class="default-btn">Back to the list</button>
        </a>
</div>