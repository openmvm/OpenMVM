<?php echo $header; ?><?php echo $column_left; ?>
<div class="container-fluid">
    <div id="content" class="content">
        <?php if ($breadcrumbs) { ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <?php if ($breadcrumb['active']) { ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
                    <?php } else { ?>
                    <li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                <?php } ?>
            </ol>
        </nav>
        <?php } ?>
        <div class="card border-0 shadow heading mb-3">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-language fa-fw"></i> <?php echo $heading_title; ?></h3>
            </div>
        </div>
        <?php if ($error_warning) { ?>
        <div class="alert alert-warning alert-dismissible border-0 shadow fade show" role="alert">
            <?php echo $error_warning; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success alert-dismissible border-0 shadow fade show" role="alert">
            <?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>
        <?php echo form_open($action, ['id' => 'form-language-editor']); ?>
        <div class="card shadow list">
            <div class="card-header clearfix"><h5 class="pt-1 float-start"><i class="fas fa-edit fa-fw"></i> <?php echo $sub_title; ?></h5> <div class="float-end"><button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-save fa-fw"></i></button> <a href="<?php echo $cancel; ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-long-arrow-alt-left fa-fw"></i></a></div></div>
            <div class="card-body">
                <div id="strings" class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="w-25"><?php echo lang('Column.string'); ?></th>
                                <?php foreach ($languages as $language) { ?>
                                <th scope="col"><img src="<?php echo base_url('assets/flags/' . $language['code'] . '.png'); ?>" /> <?php echo $language['name']; ?></th>
                                <?php } ?>
                                <th scope="col" class="text-end"><?php echo lang('Column.action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $string_row = 0; ?>
                            <?php foreach ($strings as $key => $value) { ?>
                            <tr id="string-<?php echo $string_row; ?>">
                                <td scope="row"><input type="text" name="string[<?php echo $string_row; ?>][key]" value="<?php echo $key; ?>" class="form-control" id="" /></td>
                                <?php foreach ($languages as $language) { ?>
                                <td><input type="text" name="string[<?php echo $string_row; ?>][value][<?php echo $language['code']; ?>]" value="<?php echo isset($values[$language['code']][$key]) ? htmlentities($values[$language['code']][$key]) : ''; ?>" class="form-control" id="" /></td>
                                <?php } ?>
                                <td class="text-end"><button type="button" class="btn btn-outline-danger btn-sm" onclick="$('#string-<?php echo $string_row; ?>').remove();"><i class="fas fa-trash-alt fa-fw"></i></button></td>
                            </tr>
                            <?php $string_row++; ?>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td scope="row">&nbsp;</td>
                                <?php foreach ($languages as $language) { ?>
                                <td></td>
                                <?php } ?>
                                <td class="text-end"><button type="button" class="btn btn-outline-primary btn-sm" id="button-add"><i class="fas fa-plus-circle fa-fw"></i></button></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
var string_row = '<?php echo $string_row; ?>';

$( "#button-add" ).on( "click", function() {
    html = '<tr id="string-' + string_row + '">';
    html += '    <td scope="row"><input type="text" name="string[' + string_row + '][key]" value="" class="form-control" id="" /></td>';
        <?php foreach ($languages as $language) { ?>
            html += '    <td><input type="text" name="string[' + string_row + '][value][<?php echo $language['code']; ?>]" value="" class="form-control" id="" /></td>';
        <?php } ?>
        html += '    <td class="text-end"><button type="button" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt fa-fw" onclick="$(\'#string-' + string_row + '\').remove();"></i></button></td>';
        html += '</tr>';

    $('#strings table tbody').append(html);

    string_row++;
});
//--></script> 
<?php echo $footer; ?>
