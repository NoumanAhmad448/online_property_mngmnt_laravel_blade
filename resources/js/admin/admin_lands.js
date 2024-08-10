const { param } = require("jquery");

const update = $(`#${update_field}`)
debug_logs(update)
let lands = $(`[name='${land_ids}[]']`)
debug_logs(lands)
let land_op = $(`#${land_ops}`).val();
debug_logs(land_op)
debug_logs(message_form)
debug_logs("land_update => ".land_update)
let land_id = ""

update.on(window.CLICK_EVENT, function () {
    // showLoader
    const loading_screen = showLoader()

    land_op = $(`#${land_ops}`).val();
    lands = $(`[name='${land_ids}[]']`)
    checked_lands = $(`[name='${land_ids}[]']:checked`)

    if (land_op !== ""){
        debug_logs(lands)
        debug_logs(isCheckboxChecked(lands))
        if (isCheckboxChecked(lands)){
            land_id = getElValues(checked_lands)
            console.log(land_id)
            debug_logs(land_id)
            $("#default-modal").toggleClass("hidden")
            $(`#${lands_ids}`).val(land_id)
            $(`#${land_ops_id}`).val(land_op)
        } else {
            popup_message("Please select atleast one Land to apply operation");
        }
    } else {
        popup_message('Please choose the Land Operation');
    }
    loading_screen.toggleClass("hidden")
});

const params = {}
params["url"] = land_update
params["el"] = message_form
params['dis_el'] = update
const successCall = function successCallback(d){
    location.reload();
}
const errCall = function errCall(d){
    debug_logs(d)
}

formSubmit(params,successCall, errCall)