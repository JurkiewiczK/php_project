<div>
    <?php $note = $params['note']; ?>
    <?php if($note): ?>
    <ul>
        <li><h3><?php echo htmlentities($note['title']) ?></h3></li>
        <li><p><?php echo htmlentities($note['description']) ?></p></li>
    </ul>
    <a href ='./'>
    <button id = "back">Back to the list</button>
    </a>
    
<?php endif ?>
</div>