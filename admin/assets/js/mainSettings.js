/*!
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */

(function($) {

    $(function() {

        /***********************************************************************
         * Load templates options
         **********************************************************************/
        $('.dsplLayout')
                .change(
                        function() {
                            var data = {
                                action: 'loadTemplateOptions',
                                template: $(this).val(),
                                templateRoot: templateRoot
                            };
                            $(this).addClass('loadingElement');
                            jQuery
                                    .post(
                                            ajaxurl,
                                            data,
                                            function(response) {
                                                if (response == false) {
                                                    alert('Template has no options or template folder couldn\'t be found');
                                                    $('.templateSettings').fadeOut('slow', null, function() {
                                                        $('.templateSettings').html('');
                                                        $('.dsplLayout').removeClass('loadingElement');
                                                    });
                                                } else {
                                                    $('.templateSettings')
                                                            .html(
                                                                    response['content']).fadeIn('slow');
                                                    $('.dsplLayout').removeClass('loadingElement');
                                                }
                                            }, 'json');
                        });
        $('.dsplLayout').trigger('change');

        /***********************************************************************
         * Clear cache
         **********************************************************************/
        $('#clearCacheButton')
                .click(
                        function() {
                            var r = confirm("This action will flush all Easy Related Posts plugin cache."
                                    + "\nAre you sure you want to continue?");
                            if (r === false) {
                                return true;
                            }
                            $(this).addClass('loadingElement').prop('disabled', true);
                            var data = {
                                action: 'erpClearCache'
                            };
                            jQuery
                                    .post(
                                            ajaxurl,
                                            data,
                                            function(response) {
                                                if (response == true) {
                                                    alert('Cache cleared.');
                                                } else {
                                                    alert('There was an error. Action not completed.');
                                                }
                                                $('#clearCacheButton').removeClass('loadingElement').prop('disabled', false);
                                            }, 'json');
                        });
                        
        
        /***********************************************************************
         * Licence management
         **********************************************************************/
        $('#erp_license_activate')
                .click(
                        function(event) {
                            event.preventDefault();
                            
                            $(this).addClass('loadingElement').prop('disabled', true);
                            var data = {
                                action: 'erpLiveLic',
                                'erp_license_activate' : $('#licence').val(),
                                'erp_nonce': $('#erp_nonce').val()
                            };
                            jQuery
                                    .post(
                                            ajaxurl,
                                            data,
                                            function(response) {
                                                console.log(response);
                                                if (response['res'] == true) {
                                                    alert('Licence activated!');
                                                    location.reload(true);
                                                } else {
                                                    if(response['error'] != undefined){
                                                        msg = 'There was an error: ' + response['error'];
                                                    } else {
                                                        msg = 'There was an error. Please check your input';
                                                    }
                                                    alert(msg);
                                                    $('#erp_license_activate').removeClass('loadingElement').prop('disabled', false);
                                                }
                                            }, 'json');
                        });
                        
        $('#erp_license_deactivate')
                .click(
                        function(event) {
                            event.preventDefault();

                            $(this).addClass('loadingElement').prop('disabled', true);
                            var data = {
                                action: 'erpKillLic',
                                'erp_license_deactivate': $('#licence').val(),
                                'erp_nonce': $('#erp_nonce').val()
                            };
                            jQuery
                                    .post(
                                            ajaxurl,
                                            data,
                                            function(response) {
                                                console.log(response);
                                                if (response['res'] == true) {
                                                    alert('Licence deactivated');
                                                    location.reload(true);
                                                } else {
                                                    if (response['error'] != undefined) {
                                                        msg = 'There was an error: ' + response['error'];
                                                    } else {
                                                        msg = 'There was an error. Please check your input';
                                                    }
                                                    alert(msg);
                                                    $('#erp_license_deactivate').removeClass('loadingElement').prop('disabled', false);
                                                }
                                            },
                                            'json');
                        }
                );
                        
                        
        /***********************************************************************
         * Rebuild cache
         **********************************************************************/
        $('#rebuildCacheButton')
                .click(
                        function() {
                            var r = confirm("This may take a while. Are you sure you want to rebuild cache now?");
                            if (r === false) {
                                return true;
                            }
                            $(this).addClass('loadingElement').prop('disabled', true);
                            var data = {
                                action: 'erpRebuildCache'
                            };
                            jQuery
                                    .post(
                                            ajaxurl,
                                            data,
                                            function(response) {
                                                if (response == true) {
                                                    alert('Cache rebuild successfull.');
                                                } else {
                                                    alert('There was an error. Action not completed.');
                                                }
                                                $('#rebuildCacheButton').removeClass('loadingElement').prop('disabled', false);
                                            }, 'json');
                        });


        /***********************************************************************
         * Check all checkboxes
         **********************************************************************/
        $('#select-all-custom').click(function() {
            if (!$(this).is(':checked')) {
                $('.custom').attr('checked', false);
            } else {
                $('.custom').attr('checked', 'checked');
            }
        });

        $('.custom').change(function() {
            if ($('.custom:checked').length === $('.custom').length) {
                $('#select-all-custom').attr('checked', 'checked');
            } else {
                $('#select-all-custom').attr('checked', false);
            }
        });

        $('#select-all-built-in').click(function() {
            if (!$(this).is(':checked')) {
                $('.built-in').attr('checked', false);
            } else {
                $('.built-in').attr('checked', 'checked');
            }
        });

        $('.built-in').change(function() {
            if ($('.built-in:checked').length === $('.built-in').length) {
                $('#select-all-built-in').attr('checked', 'checked');
            } else {
                $('#select-all-built-in').attr('checked', false);
            }
        });

        $('#select-all-tag').click(function() {
            if (!$(this).is(':checked')) {
                $('.tag').attr('checked', false);
            } else {
                $('.tag').attr('checked', 'checked');
            }
        });

        $('.tag').change(function() {
            if ($('.tag:checked').length === $('.tag').length) {
                $('#select-all-tag').attr('checked', 'checked');
            } else {
                $('#select-all-tag').attr('checked', false);
            }
        });

        $('#select-all-cat').click(function() {
            if (!$(this).is(':checked')) {
                $('.cat').attr('checked', false);
            } else {
                $('.cat').attr('checked', 'checked');
            }
        });

        $('.cat').change(function() {
            if ($('.cat:checked').length === $('.cat').length) {
                $('#select-all-cat').attr('checked', 'checked');
            } else {
                $('#select-all-cat').attr('checked', false);
            }
        });

        /**
         * Tab definition
         */
        options.beforeActivate = function(event, ui) {
            $('#tab-spec').val(ui.newPanel.attr('id').substring(5) - 1);
        };
        $('#tabs-holder').tabs(options);
        /**
         * -----------------------------------------
         */
        $(".erpAccordion").accordion({heightStyle: "content", collapsible: true});

        jQuery('#postTitleColor').wpColorPicker();
        jQuery('#excColor').wpColorPicker();
    });

}(jQuery));