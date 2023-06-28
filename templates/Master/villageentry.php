<?php
echo $this->element("Helper/jqueryhelper");
?>
<script>
    $(document).ready(function () {
        
        $('#division_id').change(function () {
            //alert('hi');
            var division_id = $('#division_id').val();
            //alert('/gettalukadist');            
            $.postJSON('<?php
echo $this->Url->build([
    'controller' => 'Master',
    'action' => 'getdistrictlist',])
?>', {division_id: division_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {
                //alert('in post');
                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#district_id option").remove();
                $("#district_id").append(sc);
            });
        });
        
        
        $('#district_id').change(function () {
            //alert('hi');
            var district_id = $('#district_id').val();
            //alert('/gettalukadist');            
            <?php if($admlevelconfigres[0]['is_subdiv']=='Y'){ ?>
                     $.postJSON('<?php
echo $this->Url->build([
    'controller' => 'Master',
    'action' => 'getsubdivlist',])
?>', {district_id: district_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {
                //alert('in post');
                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#subdivision_id option").remove();
                $("#subdivision_id").append(sc);
            });
            
            <?php } else if($admlevelconfigres[0]['is_taluka']=='Y') { ?>          
            
            $.postJSON('<?php
echo $this->Url->build([
    'controller' => 'Master',
    'action' => 'gettalukadist',])
?>', {district_id: district_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {
                //alert('in post');
                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#taluka_id option").remove();
                $("#taluka_id").append(sc);
            });
            <?php } ?>
        });

        $('#taluka_id').change(function () {
            var district_id = $('#district_id').val();
            var taluka_id = $('#taluka_id').val();

            $.postJSON('<?php
echo $this->Url->build([
    'controller' => 'Master',
    'action' => 'getgovtbody',])
?>', {district_id: district_id, taluka_id: taluka_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {

                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#corp_id option").remove();
                $("#corp_id").append(sc);
            });
            
            <?php if($admlevelconfigres[0]['is_circle']=='Y'){ ?>
             $.postJSON('<?php
echo $this->Url->build([
    'controller' => 'Master',
    'action' => 'getcircle',])
?>', {taluka_id: taluka_id, '_csrfToken': $("input[name=_csrfToken]").val()}, function (data)
            {

                var sc = '<option value="">--select--</option>';
                $.each(data, function (index, val) {

                    sc += "<option value=" + index + ">" + val + "</option>";
                });
                $("#circle_id option").remove();
                $("#circle_id").append(sc);
            });
            <?php }?>
        });
        
        
        
    });
</script>
<div class="village form">
        <?= $this->Flash->render() ?>
    <h3>Village Entry</h3>
<?= $this->Form->create($village) ?>
    <fieldset>
         <?php  
        if($admlevelconfigres[0]['is_div']=='Y'){ ?>
        <legend><?= __('Select Division') ?></legend>
<?= $this->Form->select('division_id', $divisionlistres, ['id' => 'division_id', 'empty' => '--select--']); ?>
        <?php } ?>
        
        <legend><?= __('Select District Name') ?></legend>
<?= $this->Form->select('district_id', $districtlistdata, ['id' => 'district_id', 'empty' => '--select--']); ?>

        <?php if($admlevelconfigres[0]['is_subdiv']=='Y'){ ?>
        <legend><?= __('Select Sub Division') ?></legend>
<?= $this->Form->select('subdivision_id', $subdivisionlistres, ['id' => 'subdivision_id', 'empty' => '--select--']); ?>
        <?php } ?>
        
        <?php if($admlevelconfigres[0]['is_taluka']=='Y'){ ?>
        <legend><?= __('Select Taluka Name') ?></legend>
<?= $this->Form->select('taluka_id', $talukalistdata, ['id' => 'taluka_id', 'empty' => '--select--']); ?>
        <?php }?>
        
        <?php if($admlevelconfigres[0]['is_circle']=='Y'){ ?>
        <legend><?= __('Select Circle') ?></legend>
<?= $this->Form->select('circle_id', $circlelistres, ['id' => 'circle_id', 'empty' => '--select--']); ?>
        <?php }?>
       
        <legend><?= __('Select Area Type') ?></legend>
<?= $this->Form->select('developed_land_types_id', $areatypedata, ['id' => 'developed_land_types_id', 'empty' => '--select--']); ?>

        <legend><?= __('Select Governing Body List') ?></legend>
<?= $this->Form->select('corp_id', $corpdata, ['id' => 'corp_id', 'empty' => '--select--']); ?>

        <legend><?= __('Enter Village Name') ?></legend>
        <?= $this->Form->control('village_name_en', ['id' => 'village_name_en', 'required' => true, 'label' => false]) ?>

        <legend><?= __('Enter Village Code') ?></legend>
    <?= $this->Form->control('village_code', ['id' => 'village_code', 'required' => true, 'label' => false]) ?>        

<?= $this->Form->control('state_id', ['type' => 'hidden', 'value' => '18', 'label' => false]) ?>

    </fieldset>
<?= $this->Form->submit('Add', ['id' => 'btnadd']); ?>
</div>

<div>
<!--    <table class="table" border="1">
        <tr>
            <th>State ID</th>
            <th>District Name</th>
            <th>Taluka Name</th>
            <th>Village Name</th>
            <th></th>
        </tr>
                <?php ///foreach ($villageresult as $villageres) { ?>
            <tr>
                <td>
                    <?php // echo $villageres['state_id']; ?> 
                </td>
                <td>
                    <?php // echo $villageres['Districts']['district_name_en']; ?> 
                </td>
                <td>
                    <?php // echo $villageres['Talukas']['taluka_name_en']; ?> 
                </td>
                <td>
                <?php // echo $villageres['village_name_en']; ?> 
                </td>
                <?php
                // pr($villageres); exit;
//                $village_id = $villageres['village_id'];
//                $dist_id = $villageres['Districts']['district_id'];
//                $taluka_id = $villageres['Talukas']['taluka_id'];
//                $village_name = $villageres['village_name_en'];
                //pr($village_id); pr($dist_id); pr($taluka_id); pr($village_name); exit;
                ?>           
                <td>
    <?php // echo $this->Html->link('Update', array('controller' => 'Master', 'action' => 'villageentry', $village_id)); ?>
                    &nbsp;
            <?php // echo $this->Html->link('Delete', array('controller' => 'Master', 'action' => 'villagedelete', $village_id)); ?>
                </td>

            </tr>
            <?php
//        }

        echo $this->Form->control('updatetaukaid', ['type' => 'hidden', 'id' => 'updatetaukaid', 'value' => '', 'label' => false]);
        echo $this->Form->control('hfaction', ['type' => 'hidden', 'id' => 'hfaction', 'value' => '', 'label' => false]);
        ?>

    </table>-->

</div>