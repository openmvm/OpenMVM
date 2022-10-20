<?php echo $header; ?>
<div class="container">
    <div id="content" class="content">
        <h1 class="border-bottom pb-3 mb-3"><?php echo $heading_title; ?></h1>
    </div>
    <div class="card text-bg-warning mb-3">
        <div class="card-header"><?php echo lang('Text.balance', [], $language_lib->getCurrentCode()); ?></div>
        <div class="card-body">
            <h1 class="card-title"><strong><?php echo $balance; ?></strong></h5>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header"><?php echo lang('Text.transactions', [], $language_lib->getCurrentCode()); ?></div>
        <div class="card-body">
            <?php if (!empty($wallets)) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><?php echo lang('Column.date_added', [], $language_lib->getCurrentCode()); ?></th>
                        <th scope="col"><?php echo lang('Column.amount', [], $language_lib->getCurrentCode()); ?></th>
                        <th scope="col"><?php echo lang('Column.description', [], $language_lib->getCurrentCode()); ?></th>
                        <th scope="col"><?php echo lang('Column.comment', [], $language_lib->getCurrentCode()); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($wallets as $wallet) { ?>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table> 
            <?php } else { ?>
            <div class="text-secondary"><?php echo lang('Text.no_transactions', [], $language_lib->getCurrentCode()); ?></div>           
            <?php } ?>
        </div>
    </div>
</div>
<?php echo $footer; ?>
