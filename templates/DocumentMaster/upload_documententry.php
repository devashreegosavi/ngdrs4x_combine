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
<?= $this->Form->create($documentupload, ['id' => 'upload_document']); ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Upload Document Entry</b></h3>
    </div>
    <form class="form-horizontal">
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('Enter Upload Document Name English'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->control('document_name_en', ['id' => 'document_name_en', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up document_name_en_error"></div>
                    <div id="document_name_en_error" class="form-error document_name_en_error"></div>
                </div>         
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbluploadedfilessize'); ?><span style="color: #ff0000">(MB)* </span></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->control('file_size', ['id' => 'file_size', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up file_size_error"></div>
                    <div id="file_size_error" class="form-error file_size_error"></div>
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
                                <th>Upload Document Name(English)</th>
                                <th>Uploaded File Size</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   
                               $w=1;
                                foreach ($getdoclist_arr as $getdoclist_arr_one){ 
                                   $document_id = $getdoclist_arr_one['document_id'];
                            ?>
                            <tr>
                                <td>
                                    <?php echo $w;$w++;?> 
                                </td>    
                                <td>
                                    <?php echo $getdoclist_arr_one['document_name_en'];?> 
                                </td>    
                                <td>
                                    <?php echo $getdoclist_arr_one['file_size'];?> 
                                </td> 
                                <td>
                                    <a href="<?php echo $this->Url->build('/DocumentMaster/uploadDocumententry/'. $document_id);?>" class="btn btn-info" id="editdoc">Edit</a>
                                    &nbsp;
                                    <a href="<?php echo $this->Url->build('/DocumentMaster/uploaddocumentdelete/'. $document_id);?>" class="btn btn-danger">Delete</a>
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