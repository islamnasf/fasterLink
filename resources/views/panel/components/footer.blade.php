<footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="#">Fasterlink.net</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.js')}}"></script>

@yield('scripts')

<script>
  $(document).ready(function () {
    setTimeout(() => {
      $('.alert').addClass('d-none')
    }, 3000);
  })


  function changeCountry(country) {
    var selectedCountry = $('option:selected', country).val();
      $.ajax({
      url: '/change-country?country='+selectedCountry,
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        // Handle the response data here
        location.reload();
      },
      error: function(xhr, status, error) {
        // Handle any errors that occur during the request
        console.error(error);
      }
    });

  }
</script>
</body>
</html>
