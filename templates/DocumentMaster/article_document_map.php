<script type="text/javascript">
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    $(document).ready(function () {
        //$('#datalist').DataTable();
        
        $('#datalist').dataTable({
        "iDisplayLength": 5,
                "aLengthMenu": [[5, 10, 15, 20, - 1], [5, 10, 15, 20, "All"]]
        });
        
        $('#article_id').change(function () {
            var article_titlewise_map = $('#article_titlewise_map').val();
            //alert(article_titlewise_map);
            if(article_titlewise_map=='Y')
            {
                var article_id = $('#article_id').val();
                //  get article title
                $.postJSON('<?php
                echo $this->Url->build([
                    'controller' => 'DocumentMaster',
                    'action' => 'getarticledescdetailslist',])
                ?>', {article_id: article_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
                {
                    //alert('in post');
                    var sc = '<option value="">--select--</option>';
                    $.each(data, function (index, val) {

                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#articledescription_id option").remove();
                    $("#articledescription_id").append(sc);
                });
            }
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
<?= $this->Form->create($articledocumentmap, ['id' => 'articledocumentmap']); ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Article Document Mapping</b></h3>
    </div>
    <form class="form-horizontal">
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblarticlename'); ?></label>
                <div class="col-sm-4">
                    <?php 
                    echo $this->Form->control('article_titlewise_map', ['type'=>'hidden','id' => 'article_titlewise_map', 'value'=>$article_titlewise_map['conf_bool_value'], 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']);
                    //pr($getarticlelist);
                    echo $this->Form->select('article_id', $getarticlelist, ['empty' => '--Article--', 'class' => 'form-select', 'id' => 'article_id']); ?>
                    
                    <div  class="arrow-up article_id_error"></div>
                    <div id="article_id_error" class="form-error article_id_error"></div>
                </div>
                <?php
                if($article_titlewise_map['conf_bool_value']=='Y'){
                ?>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbldocumenttitle'); ?></label>
                <div class="col-sm-4">
                    <?php
                    echo $this->Form->select('articledescription_id', array(), ['empty' => '----Document Title----', 'class' => 'form-select', 'id' => 'articledescription_id']);
                    ?>
                    <div  class="arrow-up articledescription_id_error"></div>
                    <div id="articledescription_id_error" class="form-error articledescription_id_error"></div>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblselectdocument'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->select('document_id', $getuploaddoc, ['empty' => '--Document--', 'class' => 'form-select', 'id' => 'document_id']); ?>
                    
                    <div  class="arrow-up document_id_error"></div>
                    <div id="document_id_error" class="form-error document_id_error"></div>
                </div>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblisrequired'); ?></label>
                <div class="col-sm-4">
                    <?php 
                    //pr($getarticlelist);
                    echo $this->Form->select('is_required', $arrCategory, ['empty' => '--Select--', 'class' => 'form-select', 'id' => 'is_required']); ?>
                    
                    <div  class="arrow-up is_required_error"></div>
                    <div id="is_required_error" class="form-error is_required_error"></div>
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
                                <?php
                                if($article_titlewise_map['conf_bool_value']=='Y'){
                                ?>
                                <th><?php echo __('Article Title'); ?></th>
                                <?php
                                }
                                ?>
                                <th><?php echo __('lbdDocumentname'); ?></th>
                                <th>Is Required</th>
                                <th><?php echo __('lblaction'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   
                               $w=1;
                                foreach ($articlegrid as $articlegrid_doc){ 
                                    //pr($articlegrid_doc);
                                    $article_doc_map_id = $articlegrid_doc['article_doc_map_id'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $w;$w++;?> 
                                        </td>    
                                        <td>
                                            <?php echo $articlegrid_doc['Article']['article_desc_en'];?> 
                                        </td>
                                        <?php
                                        if($article_titlewise_map['conf_bool_value']=='Y'){
                                        ?>
                                        <td>
                                            <?php echo $articlegrid_doc['ArticleDesc']['articledescription_en'];?> 
                                        </td>
                                        <?php
                                        }
                                        ?>
                                        <td>
                                            <?php echo $articlegrid_doc['UploadDocument']['document_name_en'];?> 
                                        </td> 
                                        <td>
                                            <?php echo $articlegrid_doc['is_required'];?> 
                                        </td> 
                                        <td>
                                            <a href="<?php echo $this->Url->build('/DocumentMaster/articleDocumentMap/'. $article_doc_map_id);?>" class="btn btn-info" id="editdoc">Edit</a>
                                            &nbsp;
                                            <a href="<?php echo $this->Url->build('/DocumentMaster/articleDocumentMapDelete/'. $article_doc_map_id);?>" class="btn btn-danger">Delete</a>
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
