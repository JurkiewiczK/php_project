<div>
    <?php $note = $params['note']; ?>
    <?php if($note): ?>
    <ul>
        <li><h3><?php echo $note['title']; ?></h3></li>
        <li><p><?php echo $note['description'] ?></p></li>
    </ul>
    <a href ='./'>
    <button id = "back">Back to the list</button>
    </a>
    
<?php endif ?>
</div>