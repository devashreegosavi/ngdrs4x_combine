<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-success  alert-white rounded">
        <!--<button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>-->
        <div class="icon">
            <i class="fa fa-check"></i>
        </div>
        <strong>Success!</strong> 
       <?= $message ?>
    </div>
