<script>
    let pageNumber = 1;
    $(document).on("click", ".page-link", function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let query = url.split('?');
        pageNumber = query[1].split('=')[1];
        let type = $(this).attr('data-div');
        loadTableData(url, type);
    });

    // $(document).on('keyup', '#search_keyword', function (e) {
    //     if (e.keyCode == 13) {
    //         $('#keyword_search_btn').trigger("click");
    //     }
    // });

    $(document).on('search', '.search_universal', function (e) {
        let id = $(this).attr('id');
        $('#' + id + 'keyword_search_btn').trigger("click");
    });

    function loadDataTableDynamically(type, div) {
        loadTableData(window.location.origin + '/' + type, div);
    }

    let columns = [];

    function showHideColumns(key, url, div) {
        if (jQuery.inArray(key, columns) !== -1) {
            columns = jQuery.grep(columns, function (value) {
                return value != key;
            });
        } else {
            columns.push(key);
        }
        loadTableData(url, div);
    }

    function loadTableData(url, div) {
        let not_in_software_id = $('#not_in_software_id').val();
        let not_in_software_id_condition = '';
        if (not_in_software_id && not_in_software_id != "") {
            not_in_software_id_condition = 1;
        }
        let software_id = $('#software_id_filter').val();
        let patch_id = $('#patch_id_filter').val();
        let asset_id_filter = $('#asset_id_filter').val();
        let search_keyword = $('#ser' + div).val();
        let clause_id_filter = $('#clause_id_filter').val();
        let patch_ids = $("input[name='checked_patch[]']")
            .map(function () {
                return $(this).val();
            }).get();
        let software_ids = $("input[name='checked_software[]']")
            .map(function () {
                return $(this).val();
            }).get();

        let items_per_page = $('#per_page').val();
        if(software_id === undefined)
            software_id = "";
        if(patch_id === undefined)
            patch_id = "";
        if(clause_id_filter === undefined)
            clause_id_filter = "";
        if(asset_id_filter === undefined)
            asset_id_filter = "";
        if(search_keyword === undefined)
            search_keyword = "";
        if(patch_ids === undefined)
            patch_ids = "";

        $.ajax({
            type: "GET",
            url: url,
            data:
                $('#column_search_form').serialize() +
                "&not_in_software_id_condition=" + not_in_software_id_condition +
                "&not_in_software_id=" + not_in_software_id
                + "&software_id=" + software_id
                + "&patch_id=" + patch_id
                + "&asset_id_filter=" + asset_id_filter
                + "&clause_id_filter=" + clause_id_filter
                + "&search_keyword=" + search_keyword
                + "&items_per_page=" + items_per_page
                + "&patch_ids=" + patch_ids
                + "&software_ids=" + software_ids
                + "&columns=" + JSON.stringify(columns)
            ,
            success: function (result) {
                $('#' + div).html($(result).find('#' + div).html());
                makeDatatable('datatable-buttons' + div);
                $('.select2').select2();
            }
            ,
        })
        ;
    }

    function disableForm(target) {
        $(target + " :input").prop("disabled", true);
    }

    function showDetailPopup(url) {
        $.ajax({
            type: "get",
            url: url,
            success: function (result) {
                if (result) {
                    $('.default_modal_body').html($(result).find('.item_form').find('.row').html());
                    $('#default_modal').modal('show');
                    disableForm('#default_modal_content');
                }
            }

        });
    }

    $(document).on('change', '.select_row', function () {
        let type = $(this).attr('data-type');

        if (this.checked) {
            let id = $(this).val();
            if ($('#selected_' + type).length == 0) {
                $('body').append('<div id=' + 'selected_' + type + '></div>');
            }
            $('#selected_' + type).append('<input type="hidden" value="' + id + '" name="checked_' + type + '[]" id="' + type + id + '">');
        } else {
            let id = $(this).val();
            $('#' + type + id).remove();
        }
    });
</script>
