const params = {}
params["url"] = profile_url
params["el"] = my_profile_form
params['dis_el'] = $(`#${submit_button}`)
const successCall = function successCallback(d){
    location.reload();
}
const errCall = function errCall(d){
    debug_logs(d)
}

formSubmit(params,successCall, errCall)