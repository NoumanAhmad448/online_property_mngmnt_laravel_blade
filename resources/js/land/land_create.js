$("#land_reg").submit(function (e) {
    e.preventDefault();
    var data = new FormData($(this).get(0));
    if(debug){
        console.log(data)
    }
    // disable submit btn and show loader
    $("#loading-screen").toggleClass("hidden")
    let submit = $("#submit")
    submit.prop("disabled","disabled")
    // disable submit btn and show loader
    $.ajax({
      url: land_save,
      type: 'post',
      contentType: false,
      processData: false,
      data: data,
      success: function success(d) {
        submit.prop("disabled","")
        $("#loading-screen").toggleClass("hidden")
        popup_message(d)
        setTimeout(function () {
          location.reload()
        }, default_timeout);
      },
      error: function error(d) {
        submit.prop("disabled","")
        $("#loading-screen").toggleClass("hidden")
        popup_message(d)
        resetCaptcha()
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'JSON'
    });
  });
