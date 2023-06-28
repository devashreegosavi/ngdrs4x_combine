<script>
    $(document).ready(function () {

        $('#division_id').change(function () {
            unset_options('division_id');
            var division_id = $('#division_id').val();
            if ($.isNumeric(division_id)) {
                $.postJSON('<?php echo $this->Url->build('/Valuation/get_districts_by_division'); ?>', {division_id: division_id, _csrfToken: $("input[name=_csrfToken]").val()}, function (data)
                {
                    var sc = '<option value="">--select--</option>';
                    $.each(data.district, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#district_id option").remove();
                    $("#district_id").append(sc);
                    auto_key('division_id');
                });
            }

        });
        $('#district_id').change(function () {
            unset_options('district_id');
            var district_id = $('#district_id').val();
            if ($.isNumeric(district_id)) {
                $.postJSON('<?php echo $this->Url->build('/Valuation/get_subdivision_taluka_by_district'); ?>', {district_id: district_id, _csrfToken: $("input[name=_csrfToken]").val()}, function (data)
                {
                    var sc = '<option value="">--select--</option>';
                    $.each(data.subdivision, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#subdivision_id option").remove();
                    $("#subdivision_id").append(sc);

                    var sc = '<option value="">--select--</option>';
                    $.each(data.taluka, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#taluka_id option").remove();
                    $("#taluka_id").append(sc);
                    auto_key('district_id');

                });
            }
        });
        $('#subdivision_id').change(function () {
            unset_options('subdivision_id');
            var subdivision_id = $('#subdivision_id').val();
            if ($.isNumeric(subdivision_id)) {
                $.postJSON('<?php echo $this->Url->build('/Valuation/get_taluka_by_subdivision'); ?>', {subdivision_id: subdivision_id, _csrfToken: $("input[name=_csrfToken]").val()}, function (data)
                {
                    var sc = '<option value="">--select--</option>';
                    $.each(data.taluka, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#taluka_id option").remove();
                    $("#taluka_id").append(sc);
                    auto_key('subdivision_id');
                });
            }
        });
        $('#taluka_id').change(function () {
            unset_options('taluka_id');
            var taluka_id = $('#taluka_id').val();
            if ($.isNumeric(taluka_id)) {
                $.postJSON('<?php echo $this->Url->build('/Valuation/get_circle_village_by_taluka'); ?>', {taluka_id: taluka_id, _csrfToken: $("input[name=_csrfToken]").val()}, function (data)
                {


                    var sc = '<option value="">--select--</option>';
                    $.each(data.circle, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#circle_id option").remove();
                    $("#circle_id").append(sc);


                    var sc = '<option value="">--select--</option>';
                    $.each(data.village, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#village_id option").remove();
                    $("#village_id").append(sc);
                    auto_key('taluka_id');
                });
            }
        });
        $('#circle_id').change(function () {
            unset_options('circle_id');
            var circle_id = $('#circle_id').val();
            if ($.isNumeric(circle_id)) {
                $.postJSON('<?php echo $this->Url->build('/Valuation/get_village_by_circle'); ?>', {circle_id: circle_id, _csrfToken: $("input[name=_csrfToken]").val()}, function (data)
                {
                    var sc = '<option value="">--select--</option>';
                    $.each(data.village, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#village_id option").remove();
                    $("#village_id").append(sc);
                    auto_key('circle_id');
                });
            }
        });
        $('#village_id').change(function () {
            unset_options('village_id');
            var village_id = $('#village_id').val();
            if ($.isNumeric(village_id)) {
                $.postJSON('<?php echo $this->Url->build('/Valuation/get_level1_by_village'); ?>', {village_id: village_id, _csrfToken: $("input[name=_csrfToken]").val()}, function (data)
                {
                    var sc = '<option value="">--select--</option>';
                    $.each(data.level1, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#level_1_id option").remove();
                    $("#level_1_id").append(sc);

                    var sc = '<option value="">--select--</option>';
                    $.each(data.dtypes, function (index, val) {
                        sc += "<option value=" + index + " selected>" + val + "</option>";
                    });
                    $("#developed_land_types_id option").remove();
                    $("#developed_land_types_id").append(sc);

                    var sc = '<option value="">--select--</option>';
                    $.each(data.corp, function (index, val) {
                        sc += "<option value=" + index + " selected>" + val + "</option>";
                    });
                    $("#corp_id option").remove();
                    $("#corp_id").append(sc);
                    if (typeof after_village_change !== 'undefined' && $.isFunction(after_village_change)) {
                        after_village_change(event);
                    }
                    auto_key('village_id');
                });
            }
        });

    });
    function unset_options(fieldname) {
        var arr = ["division_id", "district_id", "subdivision_id", "taluka_id", "circle_id", "village_id", 'developed_land_types_id', 'corp_id','level_1_id', 'prop_level1_list_id'];
        var remove = 0;
        for (var i = 0; i < arr.length; i++)
        {
            if (remove) {
                $("#" + arr[i]).find('option').not(':first').remove();
            }
            if (arr[i] === fieldname) {
                remove = 1;
            }
        }

    }

    function auto_key(fieldname) {
        var arr = ["division_id", "district_id", "subdivision_id", "taluka_id", "circle_id", "village_id",'level_1_id', 'prop_level1_list_id'];
   
        for (var i = 0; i < arr.length; i++)
        {
            var match = 0;
            for (var i = 0; i < arr.length; i++)
            {
                if (match) {
                    if ($("select[name='" + arr[i] + "']").length > 0) {
                        $("select[name='" + arr[i] + "'] option:eq(1)").attr("selected", "selected").change();
                         match = 0;
                    }
                }
                if (arr[i] === fieldname) {
                    match = 1;
                }
            }
        }
    }


</script>
