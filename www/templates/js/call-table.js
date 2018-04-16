(function (jQuery) {
    jQuery.fn.zfTable = function (url, options) {

        var initialized = false;

        var defaults = {


            beforeSend: function () {
                $('.daterangepicker').remove();
            },
            success: function () {
                //$('#reportrange').val($('#zfTableStartDate').val() + ' - ' + $('#zfTableEndDate').val());

            },
            error: function () {
            },
            complete: function () {

                // $('.icheck').iCheck({
                //     checkboxClass: 'icheckbox_square-blue',
                //     radioClass: 'iradio_square-blue',
                //     increaseArea: '20%' // optional
                // });
                //
                // //When unchecking the checkbox
                // $("#check-all").on('ifUnchecked', function (event) {
                //     //Uncheck all checkboxes
                //     $(".check_acao", ".table").iCheck("uncheck");
                //
                // });
                //
                // //When checking the checkbox
                // $("#check-all").on('ifChecked', function (event) {
                //     //Check all checkboxes
                //     $(".check_acao", ".table").iCheck("check");
                //
                // });
            },

            onInit: function () {
            },
            sendAdditionalParams: function () {
                return '';
            },
            dateDefault: moment().subtract(29, 'days'),
            ranges: function (current) {
                var ranger= Array();
                ranger['hoje']= moment().subtract(1, 'days');
                ranger['hntem']= moment();
                ranger['ultimos_7_dias']= moment().subtract(6, 'days');
                ranger['ultimos_30_dias']= moment().subtract(29, 'days');
                ranger['este_ms']=moment().startOf('month');
                ranger['ultimo_mes']=moment().subtract(1, 'month').startOf('month');
                this.dateDefault = ranger[current.replace(' ','_')];
            }


        };

        var options = $.extend(defaults, options);

        function strip(html) {
            var tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        }

        function init($obj) {
            options.onInit();
            ajax($obj);
        }

        function ajax($obj) {
            $obj.prepend('<div class="processing" style=""></div>');
            jQuery.ajax({
                url: url,
                data: $obj.find(':input').serialize() + options.sendAdditionalParams(),
                type: 'GET',

                beforeSend: function (e) {
                    options.beforeSend(e)
                },
                success: function (data) {
                    $obj.html('');
                    $obj.html(data);
                    initNavigation($obj);
                    initBtnRange($obj);
                    $obj.find('.processing').hide();


                    options.success();
                },

                error: function (e) {
                    options.error(e)
                },
                complete: function (e) {
                    options.complete(e)
                },

                dataType: 'html'
            });

        }

        function initNavigation($obj) {
            var _this = this;


            $obj.find('table th.sortable').on('click', function (e) {
                $obj.find('input[name="zfTableColumn"]').val(jQuery(this).data('column'));
                $obj.find('input[name="zfTableOrder"]').val(jQuery(this).data('order'));
                ajax($obj);
            });
            $obj.find('.paginator').find('a').on('click', function (e) {
                e.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $obj.find('input[name="zfTablePage"]').val(jQuery(this).data('page'));
                    ajax($obj);
                }

            });
            $obj.find('.itemPerPage').on('change', function (e) {
                $obj.find('input[name="zfTableItemPerPage"]').val(jQuery(this).val());
                ajax($obj);
            });
            $obj.find('.valuesState').on('change', function (e) {
                $obj.find('input[name="zfTableStatus"]').val(jQuery(this).val());
                ajax($obj);
            });


            $obj.find('input.filter').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    ajax($obj);
                }
            });
            $obj.find('select.filter').on('change', function (e) {
                e.preventDefault();
                ajax($obj);
            });
            $obj.find('.quick-search').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $obj.find('input[name="zfTableQuickSearch"]').val(jQuery(this).val());
                    ajax($obj);
                }
            });

            $obj.find('.j_confirm_delete').on('click', function (e) {
                $this = $(this);
                if ($this.hasClass('btn_red')) {
                    $this.removeClass('btn_red').addClass('btn_yellow').text("Confirmar");
                }
                else {
                    var DelId = $(this).data('id');
                    var Callback = $(this).data('callback');
                    var Callback_action = $(this).data('callback_action');
                    $.post('_ajax/' + Callback + '.ajax.php', {
                        callback: Callback,
                        callback_action: Callback_action,
                        del_id: DelId
                    }, function (data) {
                        if (data.trigger) {
                            Trigger(data.trigger);

                        }
                        ajax($obj);
                    }, 'json');
                }
                return false;

            });

            $obj.find('.j_confirm_status').on('click', function (e) {
                $this = $(this);
                var DelId = $(this).data('id');
                var campo = $(this).data('campo');
                var Callback = $(this).data('callback');
                var status = $(this).data('status');
                var Callback_action = $(this).data('callback_action');
                $.post('_ajax/' + Callback + '.ajax.php', {
                    status: status,
                    campo: campo,
                    'callback': Callback,
                    'callback_action': Callback_action,
                    'del_id': DelId
                }, function (data) {
                    if (data.trigger) {
                        Trigger(data.trigger);
                    }
                    ajax($obj);
                }, 'json');
                return false;

            });


            $obj.find('.export-csv').on('click', function (e) {
                exportToCSV(jQuery(this), $obj);
            });
        }

        function exportToCSV(link, $table) {
            var data = new Array();
            $table.find("tr.zf-title , tr.zf-data-row").each(function (i, el) {
                var row = new Array();
                $(this).find('th, td').each(function (j, el2) {
                    row[j] = strip($(this).html());
                });
                data[i] = row;
            });
            console.log(data);
            var csvHeader = "data:application/csv;charset=utf-8,";
            var csvData = '';
            data.forEach(function (infoArray, index) {
                dataString = infoArray.join(";");
                csvData += dataString + '\r\n';

            });
            link.attr({
                'download': 'export-table.csv',
                'href': csvHeader + encodeURIComponent(csvData),
                'target': '_blank'
            });
        }


        function initBtnRange($obj) {

            if ($('#reportrange').length) {
                moment.locale('pt-br');
                $('#reportrange').daterangepicker(
                    {
                        ranges: {
                            'Hoje': [moment().subtract(1, 'days'), moment()],
                            'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                            'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                            'Este Mês': [moment().startOf('month'), moment().endOf('month')],
                            'Ultimo Mês': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        locale: {
                            applyLabel: 'Aplicar',
                            cancelLabel: 'Cancelar',
                            customRangeLabel: 'Perssonalizado'
                        },
                        startDate: options.dateDefault,
                        endDate: moment(),
                        applyClass: 'btn btn_green',
                        cancelClass: 'btn btn_red'
                    }
                ).on('cancel.daterangepicker', function (ev, picker) {
                    //do something, like clearing an input
                    $('#label-search').text('Buscar Por Data');
                    $('#zfTableStartDate').val('');
                    $('#zfTableEndDate').val('');
                    ajax($obj);
                }).on('apply.daterangepicker', function (ev, picker) {
                     $('#reportrange').val(picker.startDate.format('D MMMM, YYYY') + ' - ' + picker.endDate.format('D MMMM, YYYY'));
                    $('#zfTableStartDate').val(picker.startDate.format('YYYY-MM-DD'));
                    $('#zfTableEndDate').val(picker.endDate.format('YYYY-MM-DD'));
                    var current=picker.chosenLabel.replace(' ',"_").toLowerCase();
                    options.ranges(current);

                    ajax($obj);
                })
            }
        }


        return this.each(function () {
            var $this = jQuery(this);
            if (!initialized) {
                init($this);
            }

        });
    };

})(jQuery);