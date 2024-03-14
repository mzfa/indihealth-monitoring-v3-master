const Toast = Swal.mixin({
  toast: true,
  position: 'top-center',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
  $( document ).ready(function() {
        getGeolocation();
        $('[data-toggle="tooltip"]').tooltip()
    });
  //Definition
  // window.axios  = require('axios');
  window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
    function getGeolocation() {
      if (navigator.geolocation) {
        return navigator.geolocation.getCurrentPosition(showCoordinates);
      } else {
       alert("Browser anda tidak mendukung geolocation");
      }
    }

    function showCoordinates(position) {
       console.log(position.coords)
       localStorage.setItem("lat", position.coords.latitude);
       localStorage.setItem("lng", position.coords.longitude);

    }
