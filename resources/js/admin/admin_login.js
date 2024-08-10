$("#admin_login").submit(function (e) {
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
      url: login_form,
      type: 'post',
      contentType: false,
      processData: false,
      data: data,
      success: function success(d) {
        submit.prop("disabled","")
        $("#loading-screen").toggleClass("hidden")
        popup_message(d)
        changeURL(`${admin_panel}`)
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
