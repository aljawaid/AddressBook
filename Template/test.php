<section class="accordion-section <?= empty($task['contacts']) ? 'accordion-collapsed' : '' ?>">
    <div class="accordion-title">
        <h3><a href="#" class="fa accordion-toggle"></a> <?= t('Contacts') ?></h3>
    </div>
    <div class="accordion-content">
        <article class="markdown">
            <?= $this->text->markdown($task['contacts'], isset($is_public) && $is_public) ?>
        </article>
    </div>
</section>