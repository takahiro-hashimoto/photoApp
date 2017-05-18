$(function(e) {

  $("#js-button-select").on("click", function(){
     $("#js-image_file").trigger("click");
  });

  $("#js-image_file").on("change", function(){

    if (!this.files.length) {
      return;
    }

    var file = this.files[0];
    var $imageView = $('#js-view');
    var fileReader = new FileReader();

    fileReader.onload = function(event) {
      console.log(event);
      $imageView.attr('src', event.target.result);
    };

    fileReader.readAsDataURL(file);

    $("#js-button-select").addClass('is-hide');
    $("#js-desc-text").addClass('is-hide');
    $("#js-description").removeClass('is-hide');
    $("#js-view-container").removeClass('is-hide');
    $("#js-button-upload").removeClass('is-hide');
  });

  $("#js-button-upload").on("click", function(){
     $("#js-send-file").submit();
  });

    navigator.geolocation.watchPosition(
      function (position) {
        try {
          var lat = position.coords.latitude;
          var lon = position.coords.longitude;
          $("#js-lat").val(lat);
          $("#js-lon").val(lon);
          console.log(position);
        } catch (error) {
          console.log("getGeolocation: " + error);
        }
      }
    );
});
