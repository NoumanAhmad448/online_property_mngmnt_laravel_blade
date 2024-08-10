$("#login").submit(function (e) {
    e.preventDefault();
    debug_logs($(this).get(0))
    var data = new FormData($(this).get(0));
    debug_logs(data)
    // showLoader
    const loading_screen = showLoader()

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
        loading_screen.toggleClass("hidden")
        popup_message(d)
        changeURL(`${index}`)
      },
      error: function error(d) {
        submit.prop("disabled","")
        loading_screen.toggleClass("hidden")
        popup_message(d)
        resetCaptcha()
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'JSON'
    });
  });
