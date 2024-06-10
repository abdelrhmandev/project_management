<script>
   
        // Supporter Modal
        var contract_id;
    function getRejectionReasonUrl(id) {

            $.ajax({
                type: 'GET',
                url: "{{ route('contract.get_rejection_reason') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    $("#rejection_reason").html(data.rejection_reason);
                    // alert('sadas'+data.rejection_reason);
 
                }
            });
         
        
            $("#kt_modal_view_rejection_reason").modal('show');
        };
   
</script>
