const user_update = user_update ? user_update : "";
const update_field = update_field ? update_field : "";
const update_form = update_form ? update_form : "";

debug_logs("update_form => ".update_form)
debug_logs("user_update => ".user_update)
const update = $(`#${update_field}`)

const update_params = {}
update_params["url"] = user_update
update_params["el"] = update_form
update_params['dis_el'] = update

successCall = function successCallback(){
    location.reload();
}
errCall = function errCall(d){
    debug_logs(d)
}

formSubmit(update_params,successCall, errCall)