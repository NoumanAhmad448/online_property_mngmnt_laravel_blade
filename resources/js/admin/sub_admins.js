const update = $(`#${update_field}`)
debug_logs(update)
let users = $(`[name='${user_ids}[]']`)
debug_logs(users)

debug_logs(`del_form => ${del_form}`)
debug_logs("land_update => ".land_update)
debug_logs("update_form => ".update_form)
debug_logs("user_update => ".user_update)

let user_id = ""

$(`#${crte_admn}`).on(window.CLICK_EVENT, function () {
    debug_logs(`inside the ${crte_admn} ${window.CLICK_EVENT} event`)
    $(`#${crtr_admn_mdl}`).toggleClass("hidden")
    const update_params = {}
    update_params["url"] = crte_admin_url
    update_params["el"] = user_reg
    update_params['dis_el'] = update
    successCall = function successCallback(d){
        location.reload();
    }
    errCall = function errCall(d){
        debug_logs(d)
    }

    formSubmit(update_params,successCall, errCall)
})

update.on(window.CLICK_EVENT, function () {
    // showLoader
    const loading_screen = showLoader()

    admn_op_in = $(`#${admn_op}`).val();
    users = $(`[name='${user_ids}[]']`)
    checked_users = $(`[name='${user_ids}[]']:checked`)

    debug_logs(`before admn_op=> ${admn_op_in}`)

    if (admn_op_in !== "" && admn_op_in != undefined){
        debug_logs(users)
        debug_logs(isCheckboxChecked(users))
        if (isCheckboxChecked(users)){
            user_id = getElValues(checked_users)

            debug_logs(user_id)
            debug_logs(`admn_op => ${admn_op_in}`)

            if(admn_op_in == 1){
                debug_logs(`users_ids => ${users_ids}`)
                $(`#${del_form} #${users_ids}`).val(user_id)
                // form request
                const params = {}
                params["url"] = user_del
                params["el"] = del_form
                params['dis_el'] = update
                const successCall = function successCallback(d){
                    location.reload();
                }
                const errCall = function errCall(d){
                    debug_logs(d)
                }

                formSubmit(params,successCall, errCall)
                // form request closed
                $(`#${del_form}`).submit()

            }
            else if(admn_op_in == 2){
                $("#default-modal").toggleClass("hidden")
                $(`#${update_form} #${users_ids}`).val(user_id)
            }
        } else {
            popup_message("Please select atleast one admin to apply operation");
        }
    } else {
        popup_message('Please choose the Admin Operation');
    }
    loading_screen.toggleClass("hidden")
});


const update_params = {}
update_params["url"] = user_update
update_params["el"] = update_form
update_params['dis_el'] = update
successCall = function successCallback(d){
    location.reload();
}
errCall = function errCall(d){
    debug_logs(d)
}

formSubmit(update_params,successCall, errCall)