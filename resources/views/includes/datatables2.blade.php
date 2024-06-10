<script>
    function loadDatatable(RouteListing, dynamicColumns) {
        var table;
        var dt;
        var filterStatus;

        var lang = document.dir = 'ar';
        dt = $("#kt_datatable").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            info: false,
            bPaginate: false,
            orientation: 'landscape',
            exportOptions: {
                orthogonal: "myExport",
            },
            pagingType: "full_numbers",
            language: {
                url: "//cdn.datatables.net/plug-ins/1.12.1/i18n/" + lang + ".json",
            },
            fnDrawCallback: function() {
                if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) <
                    1) {
                    $('.dataTables_paginate').css("display", "none");
                    $('.dataTables_length').css("display", "none");
                    $('.dataTables_info').css("display", "none");
                } else {
                    $('.dataTables_paginate').css("display", "block");
                    $('.dataTables_length').css("display", "block");
                    $('.dataTables_info').css("display", "block");
                }
            },
            iDisplayLength: 10,
            bLengthChange: true,
            stateSave: false,
            lengthMenu: [
                [1, 10, 25, 50, -1],
                [1, 10, 25, 50, "{{ __('site.all') }}"]
            ],
            order: [],
            select: {
                style: 'os',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },
            ajax: {
                url: RouteListing
            },
            columns: dynamicColumns,
            columnDefs: [{
                targets: 0,
                exportable: false,
                printable: false,
                searchable: false,
                orderable: false,
                render: function(data) {
                    return `
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input" name="ids" class="sub_chk" value="${data}" type="checkbox" />
                    </div>`;
                }
            }, {
                targets: -1,
                data: null,
                exportable: false,
                printable: false,
                searchable: false,
                orderable: false,
                className: 'text-end',
            }, ],
            createdRow: function(row, data, dataIndex) {
                // $(row).find('td:eq(2)').attr('data-filter', data.category_id);
                // $(row).find('td:eq(3)').attr('data-filter', data.status);
                // $(row).find('td:eq(4)').attr('data-filter', data.created_at);
            }
        });
        table = dt.$;
        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on('draw', function() {
          
         
            KTMenu.createInstances();
        });

        // Filter Datatable
        var handleSearchDatatable = function() {
            const filterSearch = document.querySelector('[data-kt-table-filter="search"]');
            filterSearch.addEventListener('keyup', function(e) {
                dt.search(e.target.value).draw();
            });
        }

 
 
        handleSearchDatatable();
 
    }
</script>
