
    $(document).ready(function () {

        //Initialize tooltips
        $('.nav-tabs > li a[title]').tooltip();
        $('.skiptab > li button[title]').tooltip();
        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

            var $target = $(e.target);
            if ($target.parent().hasClass('disabled')) {
                return false;
            }
        });
        $(".next-step").click(function (e) {
            var $active = $('.wizard .formparentmenu li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
        });
        $(".prev-step").click(function (e) {
            var $active = $('.wizard .formparentmenu li.active');
            prevTab($active);
        });
        
        $('input.datewidget').datepicker({  format: 'yyyy-mm-dd'}).on('changeDate', function() {
                $('.datewidgeterror').html('');
            });

        $('.input-group input[required], .input-group input[validate], .input-group select[required]').on('keyup change ', function () {
            var $form = $(this).closest('form'),
                    $group = $(this).closest('.input-group'),
                    $addon = $group.find('.input-group-addon'),
                    $icon = $addon.find('span'),
                    state = false;
                    
            if (!$group.data('validate')) {
                state = $(this).val() ? true : false;
            } else if ($group.data('validate') == "email") {
                state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
            } else if ($group.data('validate') == "phone") {
                state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
            } else if ($group.data('validate') == "length") {
                state = $(this).val().length >= $group.data('length') ? true : false;
            } else if ($group.data('validate') == "number") {
                state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
            } else if ($group.data('validate') == "checked") {
                state = $(this).is(':checked');
            }

            if (state) {
                $addon.removeClass('danger');
                $addon.addClass('success');
                $icon.attr('class', 'glyphicon glyphicon-ok');
            } else if (($(this).val().length == 0) && (typeof ($(this).attr('required')) == 'undefined'))
            {
                $addon.removeClass('danger');
            }
            else {
                $addon.removeClass('success');
                $addon.addClass('danger');
                $icon.attr('class', 'glyphicon glyphicon-remove');               
            }

            if ($form.find('.input-group-addon.danger').length == 0) {
                $form.find('[type="submit"]').prop('disabled', false);
                $('.globalformerror').html(''); 
                $('.formsucess').html('');
                $('.formerror').html('');
            } else {
                $form.find('[type="submit"]').prop('disabled', true);
                $('.globalformerror').html('* Please fill in the required fields!');
            }
        });

        $('.input-group input[required], .input-group textarea[required], .input-group select[required]').trigger('change');

        $('button.completesubmit').prop('disabled', true);
            $('#agree').click(function() {
            if (!this.checked)
                $('button.completesubmit').prop('disabled', true);
            else
                $('button.completesubmit').prop('disabled', false);

        });
    });

    function nextTab(elem) {
         $(elem).next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
       $(elem).prev().find('a[data-toggle="tab"]').click();
    }

