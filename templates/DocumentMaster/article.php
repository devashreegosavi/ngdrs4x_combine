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
<?= $this->Form->create($article, ['id' => 'article']); ?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><b>Article</b></h3>
    </div>
    <form class="form-horizontal">
        <div class="card-body">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblarticlename'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->control('article_desc_en', ['id' => 'article_desc_en', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up article_desc_en_error"></div>
                    <div id="article_desc_en_error" class="form-error article_desc_en_error"></div>
                </div>
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblarticlecode'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->control('artical_code', ['id' => 'article_code', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up artical_code_error"></div>
                    <div id="artical_code_error" class="form-error artical_code_error"></div>
                </div>         
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblDisplayOrder'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->control('display_order', ['id' => 'display_order', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up display_order_error"></div>
                    <div id="display_order_error" class="form-error display_order_error"></div>
                </div>     
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblbookno'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->control('book_number', ['id' => 'book_number', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off']) ?>
                    
                    <div  class="arrow-up book_number_error"></div>
                    <div id="book_number_error" class="form-error book_number_error"></div>
                </div>     
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblonlyoneparty'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('only_one_party',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up only_one_party_error"></div>
                    <div id="only_one_party_error" class="form-error only_one_party_error"></div>
                </div>     
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblhomevisit'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('home_visit',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up home_visit_error"></div>
                    <div id="home_visit_error" class="form-error home_visit_error"></div>
                </div>     
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('dock expiry applicable'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('dock_expiry_applicable',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up dock_expiry_applicable_error"></div>
                    <div id="dock_expiry_applicable_error" class="form-error dock_expiry_applicable_error"></div>
                </div>     
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbleregistration'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('e_reg_applicable',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up e_reg_applicable_error"></div>
                    <div id="e_reg_applicable_error" class="form-error e_reg_applicable_error"></div>
                </div>     
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lble_file_applicable'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('e_file_applicable',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up e_file_applicable_error"></div>
                    <div id="e_file_applicable_error" class="form-error e_file_applicable_error"></div>
                </div>     
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('property_applicable'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('property_applicable',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up property_applicable_error"></div>
                    <div id="property_applicable_error" class="form-error property_applicable_error"></div>
                </div>     
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbltemplate_applicable_flag'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('template_applicable',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up template_applicable_error"></div>
                    <div id="template_applicable_error" class="form-error template_applicable_error"></div>
                </div>     
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblleave_licence_flag'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('leave_licence_flag',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up leave_licence_flag_error"></div>
                    <div id="leave_licence_flag_error" class="form-error leave_licence_flag_error"></div>
                </div>     
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('use common rule flag'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('use_common_rule_flag_flag',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up use_common_rule_flag_flag_error"></div>
                    <div id="use_common_rule_flag_flag_error" class="form-error use_common_rule_flag_flag_error"></div>
                </div>     
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbldisplayflag'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('display_flag_flag',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up display_flag_flag_error"></div>
                    <div id="display_flag_flag_error" class="form-error display_flag_flag_error"></div>
                </div>     
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblindex1'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('index1_flag',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up index1_flag_error"></div>
                    <div id="index1_flag_error" class="form-error index1_flag_error"></div>
                </div>     
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblindex2'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('index2_flag',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up index2_flag_error"></div>
                    <div id="index2_flag_error" class="form-error index2_flag_error"></div>
                </div>     
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblindex3'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('index3_flag',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up index3_flag_error"></div>
                    <div id="index3_flag_error" class="form-error index3_flag_error"></div>
                </div>     
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblindex4'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('index4_flag',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up index4_flag_error"></div>
                    <div id="index4_flag_error" class="form-error index4_flag_error"></div>
                </div>     
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblindexregister1'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('index_reg_flag1',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up index_reg_flag1_error"></div>
                    <div id="index_reg_flag1_error" class="form-error index_reg_flag1_error"></div>
                </div>     
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblindexregister2'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('index_reg_flag2',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up index_reg_flag2_error"></div>
                    <div id="index_reg_flag2_error" class="form-error index_reg_flag2_error"></div>
                </div>     
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblindexregister3'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('index_reg_flag3',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up index_reg_flag3_error"></div>
                    <div id="index_reg_flag3_error" class="form-error index_reg_flag3_error"></div>
                </div>     
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lblindexregister4'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('index_reg_flag4',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up index_reg_flag4_error"></div>
                    <div id="index_reg_flag4_error" class="form-error index_reg_flag4_error"></div>
                </div>     
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo __('lbltitlewisebookno'); ?></label>
                <div class="col-sm-4">
                    <?php echo $this->Form->radio('titlewise_book_number',$sizesradio, ['default' => 'N']); ?>
                    
                    <div  class="arrow-up titlewise_book_number_error"></div>
                    <div id="titlewise_book_number_error" class="form-error titlewise_book_number_error"></div>
                </div>     
                <div class="col-sm-4">
                   &nbsp;
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
                                <th>Article Code</th>
                                <th>Display Order</th>
                                <th>Book Number</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   
                               $w=1;
                                foreach ($articlelist as $articlelist_data){ 
                                    //pr($articlelist_data);
                                    $article_id = $articlelist_data['article_id'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $w;$w++;?>
                                        </td>    
                                        <td>
                                            <?php echo $articlelist_data['article_desc_en'];?> 
                                        </td>    
                                        <td>
                                            <?php echo $articlelist_data['artical_code'];?>
                                        </td> 
                                        <td>
                                            <?php echo $articlelist_data['display_order'];?>
                                        </td> 
                                        <td>
                                            <?php echo $articlelist_data['book_number'];?>
                                        </td> 
                                        <td>
                                           <a href="<?php echo $this->Url->build('/DocumentMaster/article/'. $article_id);?>" class="btn btn-info" id="editdoc">Edit</a>
                                            &nbsp;
                                            <a href="<?php echo $this->Url->build('/DocumentMaster/articledelete/'. $article_id);?>" class="btn btn-danger">Delete</a>
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
