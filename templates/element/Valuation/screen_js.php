<script>
    $(document).ready(function () {
        $('#valuation_as_on_date').datepicker({
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true,
            startDate: '-<?php echo date('Y') - 2017; ?>y',
            endDate: '+0d'
        });
        $('#level_1_id').change(function () {
            unset_options('level_1_id');
            var level_1_id = $('#level_1_id').val();
            if ($.isNumeric(level_1_id)) {
                $.postJSON('<?php echo $this->Url->build('/Valuation/get_level_1_list_by_level_1'); ?>', {level_1_id: level_1_id, _csrfToken: $("input[name=_csrfToken]").val()}, function (data)
                {
                    var sc = '<option value="">--select--</option>';
                    $.each(data.L1_List, function (index, val) {
                        sc += "<option value=" + index + ">" + val + "</option>";
                    });
                    $("#prop_level1_list_id option").remove();
                    $("#prop_level1_list_id").append(sc);
                    auto_key('level_1_id');
                });
            }

        });
        $('#rr_rate_view').on('click', function () {
            if ($.isNumeric($('#village_id').val())) {
                $.postJSON('<?php echo $this->Url->build('/Valuation/get_all_rates'); ?>',
                        {
                            division_id: $('#division_id').val(),
                            district_id: $('#district_id').val(),
                            subdivision_id: $('#subdivision_id').val(),
                            taluka_id: $('#taluka_id').val(),
                            circle_id: $('#circle_id').val(),
                            village_id: $('#village_id').val(),
                            level_1_id: $('#level_1_id').val(),
                            prop_level1_list_id: $('#prop_level1_list_id').val(),
                            construction_type_id: $('#construction_type_id').val(),
                            depreciation_id: $('#depreciation_id').val(),
                            road_vicinity_id: $('#road_vicinity_id').val(),
                            user_defined_dependency1_id: $('#user_defined_dependency1_id').val(),
                            user_defined_dependency2_id: $('#user_defined_dependency2_id').val(),
                            valuation_as_on_date: $('#valuation_as_on_date').val(),
                            rate_type: 'RRR',
                            _csrfToken: $("input[name=_csrfToken]").val()
                        },
                        function (data)
                        {
                            if (data.Error !== '') {
                                $('#rate_modal_body').html(data.Error);
                            } else {

                                var table = "<div class='table-responsive' > <table class='table table-striped' id='rate_view_table'>"

                                table += "<thead><tr>";


                                if (data.allfields.L1 === true) {
                                    table += "<th width='30%'><?php echo __('lbllocation'); ?></th>";
                                }
                                if (data.allfields.L1_List === true) {
                                    table += "<th width='30%'><?php echo __('lbllocation'); ?></th>";
                                }
                                if (data.allfields.UlbClass === true) {
                                    table += "<th width='30%'><?php echo __('lblulbclass'); ?></th>";
                                }
                                if (data.allfields.SubCatg === true) {
                                    table += "<th width='30%'><?php echo __('lblusage'); ?></th>";
                                }
                                if (data.allfields.Zone === true) {
                                    table += "<th width='30%'><?php echo __('lblzone'); ?></th>";
                                }
                                if (data.allfields.SubZone === true) {
                                    table += "<th width='30%'><?php echo __('lblsubzone'); ?></th>";
                                }

                                if (data.allfields.Ctype === true) {
                                    table += "<th width='30%'><?php echo __('lblconstuctiontye'); ?></th>";
                                }
                                if (data.allfields.Udd1 === true) {
                                    table += "<th width='30%'><?php echo __('lbluserdependency1'); ?></th>";
                                }
                                if (data.allfields.Udd2 === true) {
                                    table += "<th width='30%'><?php echo __('lbluserdependency2'); ?></th>";
                                }
                                if (data.allfields.Rate === true) {
                                    table += "<th width='30%'><?php echo __('lblrate'); ?></th>";
                                }
                                if (data.allfields.Unit === true) {
                                    table += "<th width='30%'><?php echo __('lblunit'); ?></th>";
                                }


                                table += "</tr></thead><tbody>";
                                $.each(data.allrates, function (index, value) {

                                    $.each(value, function (index1, value1) {
                                        table += "<tr>";

                                        if (data.allfields.L1 === true) {
                                            table += "<td> " + value1.L1.level_1_desc_<?php echo $lang; ?> + "</td>";
                                        }
                                        if (data.allfields.L1_List === true) {
                                            table += "<td> " + value1.L1_List.list_1_desc_<?php echo $lang; ?> + "</td>";
                                        }
                                        if (data.allfields.UlbClass === true) {
                                            table += "<td> " + value1.UlbClass.class_description_<?php echo $lang; ?> + "</td>";
                                        }
                                        if (data.allfields.SubCatg === true) {
                                            table += "<td> " + value1.SubCatg.usage_sub_catg_desc_<?php echo $lang; ?> + "</td>";
                                        }
                                        if (data.allfields.Zone === true) {
                                            table += "<td> " + value1.Zone.valuation_zone_desc_<?php echo $lang; ?> + "</td>";
                                        }
                                        if (data.allfields.SubZone === true) {
                                            table += "<td> " + value1.SubZone.from_desc_<?php echo $lang; ?> + " - " + value1.SubZone.from_desc_<?php echo $lang; ?> + "</td>";
                                        }
                                        if (data.allfields.Ctype === true) {
                                            table += "<td> " + value1.Ctype.construction_type_desc_<?php echo $lang; ?> + "</td>";
                                        }
                                        if (data.allfields.Udd1 === true) {
                                            table += "<td> " + value1.Udd1.user_defined_dependency1_desc_<?php echo $lang; ?> + "</td>";
                                        }
                                        if (data.allfields.Udd2 === true) {
                                            table += "<td> " + value1.Udd2.user_defined_dependency2_desc_<?php echo $lang; ?> + "</td>";
                                        }
                                        if (data.allfields.Rate === true) {
                                            table += "<td> " + value1.rate.prop_rate + "</td>";
                                        }
                                        if (data.allfields.Unit === true) {
                                            table += "<td> " + value1.Unit.unit_desc_<?php echo $lang; ?> + "</td>";
                                        }
                                        table += "</tr>";
                                    });
                                });
                                table += "</tbody></table></div>";
                                $('#rate_modal_body').html(table);
                                $('#rateModal').modal('show');
                                $('#rate_view_table').DataTable();

                            }
                        });
            } else {
                $('#propertyValuation').submit(); //To Check validation
            }

        });
        $("#add_attribute").click(function () {

            if ($.isNumeric($('#village_id').val())) {

                $("#add_attribute").html('<span class="fa fa-spinner"></span>');
                if ($("#attribute_id").val() && $.trim($("#attribute_value").val()) !== '') {
                    $.post("<?php echo $this->Url->build('/Valuation/add_property_attribute'); ?>", {
                        attribute_id: $("#attribute_id").val(),
                        attribute_value: $("#attribute_value").val(),
                        attribute_value1: $("#attribute_value1").val(),
                        attribute_value2: $("#attribute_value2").val(),
                        type: 'S',
                        _csrfToken: $("input[name=_csrfToken]").val()
                    }, function (data) {
                        $("#property_attribute_div").html(data);
                        $("#add_attribute").html('<span class="fa fa-plus"></span><?php echo __('lblbtnAdd'); ?>');
                        $("#attribute_value").val('');
                        $("#attribute_value1").val('');
                        $("#attribute_value2").val('');
                    }).fail(function () {
                        $("#add_attribute").html('<span class="fa fa-plus"></span><?php echo __('lblbtnAdd'); ?>');
                        alert("Error");
                    });
                } else {

                }
            } else {
                $('#propertyValuation').submit(); //To Check validation
            }

        });
        $('#attribute_id').change(function () {
            unset_options('attribute_id');
            var attribute_id = $('#attribute_id').val();
            if ($.isNumeric(attribute_id)) {
                $.postJSON('<?php echo $this->Url->build('/Valuation/get_attribute_config'); ?>', {attribute_id: attribute_id, _csrfToken: $("input[name=_csrfToken]").val()}, function (data)
                {
                    if (data.is_master_flag === true) {
                        $('#btn_view_survey_number').show();
                    } else {
                        $('#btn_view_survey_number').hide();
                    }
                    if (data.is_subpart_1_flag === true) {
                        $('#attribute_value1').show();
                        $('#attribute_value1').prop('placeholder', data.subpart_1_desc);
                    } else {
                        $('#attribute_value1').hide();
                    }
                    if (data.is_subpart_2_flag === true) {
                        $('#attribute_value2').show();
                        $('#attribute_value2').prop('placeholder', data.subpart_2_desc);
                    } else {
                        $('#attribute_value2').hide();
                    }
                    $('#attribute_value').prop('placeholder', $('#attribute_id option:selected').text());

                });
            }

        });
        $('#search_rule').keyup(function () {

            var valThis = $(this).val().toLowerCase();
            // alert(valThis);
            $('input.usage_cat_id:checkbox').each(function () {
                // alert('IN LOOP');
                var usagecatid = $(this).val();
                var label = $("label[for='usage_cat_id" + usagecatid + "']").html().toLowerCase();
                //alert(label);
                if (label.indexOf(valThis) > -1) {
                    $("label[for='usage_cat_id" + usagecatid + "']").parent('li').show();
                } else {
                    $("label[for='usage_cat_id" + usagecatid + "']").parent('li').hide();
                }
                //  alert();
            });
        });
        $('.usage_cat_id').change(function () {
            rule_change_event();
        });
    });

    function attribute_remove(attribute_index_id, flag) {
        $.post("<?php echo $this->Url->build('/Valuation/add_property_attribute'); ?>",
                {
                    attribute_index_id: attribute_index_id,
                    type: flag,
                    _csrfToken: $("input[name=_csrfToken]").val(),
                    action: 'remove'
                },
                function (data, status) {
                    $("#property_attribute_div").html(data);
                });
    }
    function usage_filter(main, sub) {
        $("#usage_rule_list").html('');
        $.postJSON("<?php echo $this->Url->build('/Valuation/usage_filter'); ?>",
                {
                    usage_main_id: main,
                    usage_sub_id: sub,
                    village_id: $('#village_id').val(),
                    _csrfToken: $("input[name=_csrfToken]").val(),
                },
                function (data, status) {
                    var cList = $('<ul>').addClass('todo-list-small');
                    $.each(data, function (index, val) {
                        var li = $('<li/>').appendTo(cList);
                        $("<input/>").attr('type', 'checkbox').addClass('usage_cat_id').val(index).prop('checked', this.checked).appendTo(li);
                        $("<label>").text(val).attr('for', 'usage_cat_id' + index).appendTo(li);

                    });
                    $("#usage_rule_list").append(cList);

                    $('.usage_cat_id').change(function () {
                        rule_change_event();
                    });


                });
    }
    function after_village_change() {
        usage_filter('', '');
    }
    function rule_change_event() {
        var usagecatid = '';
        $('input.usage_cat_id:checkbox:checked').each(function () {
            usagecatid = usagecatid + ',' + $(this).val();
        });
        if (usagecatid !== '') {
            usagecatid = usagecatid.substr(1);
        }
        $.post("<?php echo $this->Url->build('/Valuation/rule_change_event'); ?>",
                {
                    evalrule_ids: usagecatid,
                    _csrfToken: $("input[name=_csrfToken]").val()
                },
                function (data, status) {
                    $("#valuation_rule_fields").html(data);
                });


    }

</script>