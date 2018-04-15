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
            },

            onInit: function () {
            },
            sendAdditionalParams: function () {
                return '';
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
                $obj.find('input[name="zfTablePage"]').val(jQuery(this).data('page'));
                e.preventDefault();
                ajax($obj);
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


        function initBtnRange($obj){
            if($('#reportrange').length){
                moment.locale('pt-br');
                $('#reportrange').daterangepicker(
                    {
                        ranges   : {
                            'Hoje'       : [moment().subtract(1, 'days'), moment()],
                            'Ontem'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Ultimos 7 Dias' : [moment().subtract(6, 'days'), moment()],
                            'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                            'Este Mês'  : [moment().startOf('month'), moment().endOf('month')],
                            'Ultimo Mês'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        locale : {
                            applyLabel: 'Aplicar',
                            cancelLabel: 'Cancelar',
                            customRangeLabel: 'Perssonalizado'
                        },
                        startDate: moment().subtract(29, 'days'),
                        endDate  : moment(),
                        applyClass:'btn btn_green',
                        cancelClass:'btn btn_red'
                    },
                    function (start, end) {
                        $('#reportrange').val(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
                        $('#zfTableStartDate').val(start.format('YYYY-MM-DD'));
                        $('#zfTableEndDate').val(end.format('YYYY-MM-DD'));
                        ajax($obj);
                    }
                )
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