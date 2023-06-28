<script type="text/javascript">
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    $(document).ready(function () {
        //$('#datalist').DataTable();
        
        $('#datalist').dataTable({
        "iDisplayLength": 5,
                "aLengthMenu": [[5, 10, 15, 20, - 1], [5, 10, 15, 20, "All"]]
        });
        /*$("#editdist").click(function () {
            var distid = $("#distid").val();
            
            alert(distid);
        });*/
        
        
        /*$('#editdoc').click(function () {
            //alert('ssss');
            $('#btnadd').val('Update');
        });*/
    });
</script>
<?= $this->Flash->render() ?>
<?= $this->Form->create($documenttitle, ['id' => 'documenttitle']); ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Document Title</b></h3>
    </div>
    <form class="form-horizontal">
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblarticlename'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->select('article_id', $articlelist, ['empty' => '----Article----', 'class' => 'form-select', 'id' => 'article_id']); ?>
                    
                    <div  class="arrow-up article_id_error"></div>
                    <div id="article_id_error" class="form-error article_id_error"></div>
                </div>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('Enter Document Title in English'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->control('articledescription_en', ['id' => 'articledescription_en', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up articledescription_en_error"></div>
                    <div id="articledescription_en_error" class="form-error articledescription_en_error"></div>
                </div>         
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('Enter Document Title in Marathi'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->control('articledescription_ll', ['id' => 'articledescription_ll', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up articledescription_ll_error"></div>
                    <div id="articledescription_ll_error" class="form-error articledescription_ll_error"></div>
                </div>     
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblbookno'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->control('book_number', ['id' => 'book_number', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up book_number_error"></div>
                    <div id="book_number_error" class="form-error book_number_error"></div>
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
                                <th>Article</th>
                                <th>Article Document Title(English)</th>
                                <th>Article Document Title(Marathi)</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   
                               $w=1;
                                foreach ($document as $document_titledata){ 
                                    //pr($document_titledata);
                                    $articledescription_id = $document_titledata['articledescription_id'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $w;$w++;?> 
                                        </td>    
                                        <td>
                                            <?php echo $document_titledata['article']['article_desc_en'];?> 
                                        </td>    
                                        <td>
                                            <?php echo $document_titledata['articledescription_en'];?> 
                                        </td> 
                                        <td>
                                            <?php echo $document_titledata['articledescription_ll'];?> 
                                        </td> 
                                        <td>
                                            <a href="<?php echo $this->Url->build('/DocumentMaster/documenttitle/'. $articledescription_id);?>" class="btn btn-info" id="editdoc">Edit</a>
                                            &nbsp;
                                            <a href="<?php echo $this->Url->build('/DocumentMaster/documenttitledelete/'. $articledescription_id);?>" class="btn btn-danger">Delete</a>
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