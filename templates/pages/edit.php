<div>
    <h3>Edit note</h3>
    <section class="form-section">
        <?php $note = $params['note'];  ?>
        <form class="main-form" action="?action=edit" method="post">
            <input name='id' type='hidden' value="<?php echo $note['id']?>"/>
            <ul>
                <li>
                    <label></label>
                    <input type="text" name="title" class="field-long" required placeholder="Title" value=<?php echo $note['title']?>>
                </li>
                <li>
                    <label></label>
                    <textarea name="description" id="" required placeholder="Description"><?php echo $note['description']?></textarea>
                </li>
                <li>
                    <input type="submit" value="Edit" id="sub-note"/>
                </li>
            </ul>

        </form>
    </section>
</div>