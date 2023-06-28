<script type="text/javascript">
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    $(document).ready(function () {
        //$('#datalist').DataTable();
        
        $('#datalist').dataTable({
        "iDisplayLength": 5,
                "aLengthMenu": [[5, 10, 15, 20, - 1], [5, 10, 15, 20, "All"]]
        });
 
    });
</script>
<?= $this->Flash->render() ?>
<?= $this->Form->create($articlescreenmap, ['id' => 'articlescreenmap']); ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Article And Optional Screen Mapping</b></h3>
    </div>
    <form class="form-horizontal">
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblarticlename'); ?></label>
                <div class="col-sm-4">
                    <?php 
                    //pr($getarticlelist);
                    echo $this->Form->select('article_id', $getarticlelist, ['empty' => '--Select--', 'class' => 'form-select', 'id' => 'article_id']); ?>
                    
                    <div  class="arrow-up article_id_error"></div>
                    <div id="article_id_error" class="form-error article_id_error"></div>
                </div>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblminorfunction'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->select('minor_id', $getminorfundoc, ['empty' => '--Select--', 'class' => 'form-select', 'id' => 'minor_id']); ?>
                    
                    <div  class="arrow-up minor_id_error"></div>
                    <div id="minor_id_error" class="form-error minor_id_error"></div>
                </div>         
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <?= $this->Form->submit('Add', ['id'=>'btnadd','class'=>"btn btn-success"]); ?>            
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-sm-12">
                    <table class="table" border="1" id="datalist">
                        <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th><?php echo __('lblArticle'); ?></th>
                                <th><?php echo __('lbdDocumentname'); ?></th>
                                <th><?php echo __('lblaction'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   
                               $w=1;
                                foreach ($articlegrid as $articlegrid_doc){ 
                                    $id = $articlegrid_doc['id'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $w;$w++;?> 
                                        </td>    
                                        <td>
                                            <?php echo $articlegrid_doc['Article']['article_desc_en'];?> 
                                        </td>    
                                        <td>
                                            <?php echo $articlegrid_doc['MinorFunction']['function_desc_en'];?> 
                                        </td> 
                                        <td>
                                            <a href="<?php echo $this->Url->build('/DocumentMaster/articleScreenMap/'. $id);?>" class="btn btn-info" id="editdoc">Edit</a>
                                            &nbsp;
                                            <a href="<?php echo $this->Url->build('/DocumentMaster/articleScreenMapDelete/'. $id);?>" class="btn btn-danger">Delete</a>
                                        </td> 
                                    </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->Form->end() ?>       