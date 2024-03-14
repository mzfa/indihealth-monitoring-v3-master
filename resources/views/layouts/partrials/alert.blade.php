@if(Session::has('message_success'))
<script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
     Toast.fire({
            icon: 'success',
            title: " {{Session::get('message_success')}}"
          })
    });
    </script>
@endif
@if(Session::has('message_fail'))
<script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
     Toast.fire({
            icon: 'error',
            title: " {{Session::get('message_fail')}}"
          })
    });
    </script>
@endif
@if(Session::has('message_warning'))
<script type="text/javascript">
      $(function() {
        const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
     Toast.fire({
            icon: 'warning',
            title: " {{Session::get('message_warning')}}"
          })
    });
    </script>
@endif
