$(document).ready(function() {
    $('#summernote').summernote({
      height: 200
    });
  });

  $(document).ready(function() {
    $('#selectAllBoxes').click(function(event) {
      if(this.checked) {
        $('.checkBox').each(function() {
          this.checked = true;
        });
      } else {
        $('.checkBox').each(function() {
          this.checked = false;
        });
      }
    });

  var div_box = "<div id='load-screen'><div id='loading'></div></div>";
  $("body").prepend(div_box);
  $('#load-screen').delay(500).fadeOut(500, function(){
    $(this).remove();
  });

  }); 