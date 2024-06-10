<script>
$(document).ready(function() {
 toastr.options = {
  "closeButton": true,
  "debug": true,
  "newestOnTop": true,
  "progressBar": true,
  "positionClass": "toastr-top-full-width",
  "preventDuplicates": true,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
});
</script>
@if(Session::has('success'))
<script>
toastr.success("{{ session('success') }}");
</script>
@elseif(Session::has('error'))
<script>
toastr.error("{{ session('error') }}");
</script>
@elseif(Session::has('warning'))
<script>
toastr.warning("{{ session('warning') }}");
</script>
@elseif(Session::has('info'))
<script>
toastr.info("{{ session('info') }}");
</script>
@endif