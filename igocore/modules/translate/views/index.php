<div class="container">
<div class="row">
<div class="col-sm-12">
    <?php echo form_open(current_url(), 'class="form-inline"'); ?>
        <label for="trans_lang"><?php echo lang('translate_current_lang'); ?></label>
        <select name="trans_lang" id="trans_lang">
            <?php foreach ($languages as $lang) :
            echo '<option value="'.$lang.'" ';
            echo (isset($trans_lang) && $trans_lang == $lang ? ' selected="selected">' : '>') 
            . (ucfirst($lang)).'</option>';
             endforeach; ?>
            <option value="other"><?php echo (lang('translate_other')); ?></option>
        </select>
        <div id="new_lang_field" style="display: none;">
            <label for="new_lang"><?php echo (lang('translate_new_lang')); ?></label>
            <input type="text" name="new_lang" id="new_lang" value="<?php echo set_value('new_lang'); ?>" class="form-control">
        </div>
        <input type="submit" name="select_lang" class="btn btn-primary form-control btn-sm" value="<?php echo (lang('translate_select')); ?>">
    <?php echo form_close(); ?>
</div>
</div>
<!-- Core -->
<div class="admin-box row">
    <div class="col-sm-11">
        <h3><?php echo lang('translate_core'); ?> <span class="subhead"><?php echo count($lang_files) . ' ' . lang('translate_files'); ?></span></h3>
        <?php
        $linkUrl = site_url("/translate/edit/{$trans_lang}");
        $cnt = 1;
        $brk = 3;
        foreach ($lang_files as $file) :
            if ($cnt == 1) :
                echo '<div class="row">';
            endif;
            ++$cnt;
            echo '<div class="col-sm-4">';
            echo '<a class="" href="'.$linkUrl.'/'.str_replace('.php','',$file).'">'.$file.'</a>';
            echo '</div>';
            if ($cnt > $brk) :
                echo '</div>';
                $cnt = 1;
            endif;
        endforeach;
        if ($cnt != 1) :
        echo '</div>';
        endif; ?>
    </div>
</div>
<!-- Modules -->
<div class="admin-box row">
    <div class="col-sm-11">
        <h3><?php echo lang('translate_modules'); ?> <span class="subhead">
            <?php if (! empty($modules) && is_array($modules)) echo count($modules) . ' ' . lang('translate_files'); ?>
            </span>
        </h3>
        <?php
        if (! empty($modules) && is_array($modules)) :
        $linkUrl = site_url("/translate/edit/{$trans_lang}");
        $cnt = 1;
        $brk = 3;
        foreach ($modules as $file) :
            if ($cnt == 1) :
                echo '<div class="row">';
            endif;
            ++$cnt;
            echo '<div class="col-sm-4">';
            echo '<a class="" href="'.$linkUrl.'/'.str_replace('.php','',$file).'">'.$file.'</a>';
            echo '</div>';
            if ($cnt > $brk) :
                echo '</div>';
                $cnt = 1;
            endif;
        endforeach;
        if ($cnt != 1) :
        echo '</div>';
        endif; 
        else :
            echo lang('translate_no_modules').'</div>'; 
        endif; ?>
    </div>
</div>
