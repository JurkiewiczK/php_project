<div>
    <h3>nowa notatka</h3>
    <section class="form-section">
        <?php if($params['created']): ?>
        <div>Tytuł:  <?php echo $params['title'] . "</br>"; ?></div>
        <div>Opis:  <?php echo $params['description']; ?></div>
        <?php else: ?>
        <form class="main-form" action="/?action=create" method="post">
            <ul>
                <li>
                    <label>Tytuł <span class="required">*</span></label>
                    <input type="text" name="title" class="field-long" />
                </li>
                <li>
                    <label>Opis</label>
                    <textarea name="description" id="field-text"></textarea>
                </li>
                <li>
                    <input type="submit" value="submit" />
                </li>
            </ul>

        </form>
        <?php endif ?>
    </section>
</div>