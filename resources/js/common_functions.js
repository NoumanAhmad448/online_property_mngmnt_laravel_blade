require('./bootstrap');

window.show_popup = function (message) {
    $("#modal-body").html(message)
    $("#pop-message").modal({
    keyboard: true,
    focus: true,
    show: true
    })
}

window.show_message = function(text="your message",title="Info",icon="info",button="ok"){
    if(!text){
        text = err_msg
    }
    if(debug && text == err_msg){
        console.log("no output is given")
    }

    swal({
        title: title,
        text: text,
        icon: icon,
        button: button,
    })
}

window.popup_message = function(d){

    debug_logs(d)
    debug_logs(typeof d)

    if(Array.isArray(d)){
        show_message(text=d[0])
    }
    else if (typeof d === "object"){
        try {
            var dd = JSON.parse(d.responseText);
            debug_logs(dd)

            debug_logs(api_is_success in dd)
            debug_logs(dd && "error" in dd || "errors" in dd)
            if(dd && "error" in dd){
                d = dd.error
            }
            else if("errors" in dd){
                d = dd.errors
            }
            else if(api_is_success in dd){
                debug_logs(dd)
                d = dd[api_message]
            }
            else if(api_message in dd){
                debug_logs(dd)
                d = dd[api_message]
                show_message(text=d)
            }
            else{
                d = dd
            }
        } catch (e) {

            debug_logs(api_is_success in d)
            if(api_is_success in d){
                debug_logs(d)
                d = d[api_message]

                show_message(text=d)
            }else{
                show_message(text=err_msg)
            }
        }

        if(typeof d == "string"){
              show_message(text=d)
        }else if(Array.isArray(d) && d.length > 0){
            show_message(text=d[0])
        }
        else if(typeof d == "object"){
            debug_logs(d)
            let msg = "";
            let counter = 0
            for (const key in d){
                counter+=1
                if(Array.isArray(d[key])){
                    msg += `${counter}- ${d[key][0]}\n`
                }
                else if(typeof d == "string"){
                    msg += `${counter}- ${d[key]}\n`
                }
            }
            show_message(msg)
        }else{
            show_message(text=err_msg)
        }
    }
    else if(typeof d === "string"){
        show_message(text=d)
    }
}

// Function to toggle the dropdown state
window.toggleDropdown = function(toggleEl, state=false) {
    if(debug){
        console.log(`before`)
        console.log(state)
        console.log(toggleEl)
        console.log(dash_lines)
    }
    state = !state;
    if(debug){
        console.log(`after`)
        console.log(state)
    }
    toggleEl.toggleClass('hidden')
    if(debug){
        console.log(toggleEl)
        console.log(dash_lines)
    }
}

window.searchDropDown = function(searchInput,
        dropdownMenu
) {
    let searchTerm = searchInput.val().toLowerCase();
    let items = dropdownMenu.children('p');
    console.log(items)
    if(items.length > 0){
        items.each((_,item) => {
            if(debug){
                console.log(item)
            }
            const text = $(item).text().toLowerCase();
            if (text.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }else{
        if(debug){
            console.log(`items length ${items.length}`)
        }
    }
}

window.showImage = function(input,show_images_el="show_images",validImageTypes=false) {
    let files = input.files
    if (files && files.length > 0){
        if(!validImageTypes){
            validImageTypes = img_val_rules ;
            }
        for (let file of files){
            const reader = new FileReader();
            var fileType = file["type"];

            if ($.inArray(fileType, validImageTypes) < 0) {
                popup_message(file_upload_ft)
                $(`.${show_images_el}`).text("")
                } else if (file['size'] / 1024 / 1024 == fuas) {
                popup_message(fuasm)
                $(`.${show_images_el}`).text("")
                }
            else{
            reader.fileName = file.name
            reader.onload = function (e) {
                $(`.${show_images_el}`)
                    .append(`<img
                    id='${file.lastModified}img'
                    src=${reader.result} width="150" height="150" class="pr-4 rounded-lg
                    transition-all duration-300 cursor-pointer
                    h-auto max-w-lg
                    "/>`)
                    }
                    reader.readAsDataURL(file)}
                    }
    }
}

window.changeURL = function(newUrl) {
    if(debug){
        console.log(newUrl)
    }
    document.location.href = newUrl;
}

window.dataTable = function(table, cConfig={}){
    debug_logs(cConfig)
    let config = {}
    config[LANG_KEY] = {
            searchPlaceholder: "Search records"
    }
    config[PGL_KEY] = PGL_KEY in cConfig ? cConfig[PGL_KEY] : 25
    config[ORDER_KEY] = [
        [
            DEFAULT_TBLE_COL , DESC_KEY
        ]
   ]
    if(ORDER_KEY in cConfig){
        config[ORDER_KEY] = [
            [
                COL_NO_KEY in cConfig[ORDER_KEY] ?
                cConfig[ORDER_KEY][COL_NO_KEY] : DEFAULT_TBLE_COL , DESC_KEY
            ]
       ]
    }else{
        config[ScrollX_TYPE]= true
    }

    config[InitComplete_KEY] = function(){
        $(`#${table}`).wrap("<div style='overflow:auto; width:100%;position:relative;'></div>")
    }
    debug_logs(`config => ${config}`)
    let tble = $(`#${table}`).DataTable(config)
    tble.columns.adjust().draw()
    return table;
}

window.debug_logs = function(whatever){
    if(debug){
        try{
            console.log(JSON.stringify(whatever, null, 4))
        }catch(e){
            console.log(whatever)
        }
        console.log(dash_lines)
    }
}

window.getElValues = function(whatever){
    // select an multiple elements and
    // return their values in array
    // @return array
    if(whatever.length){
        return whatever.map(function() { return this.value; }).get()
    }else{
        return []
    }
}

window.isCheckboxChecked = function(whatever){
    return whatever.is(":checked")
}

window.showLoader = function(){
    let loading_screen = $("#loading-screen")

    // disable submit btn and show loader
    debug_logs("loading_screen")
    debug_logs(loading_screen)
    loading_screen.toggleClass("hidden")
    return loading_screen
}

window.ajaxRequest = function(params, successCall, errCall=""){
    let ob = {
        contentType: false,
        processData: false,
        dataType: _JSON,
        type: POST_TYPE,
    }
    ob['url'] = params['url']
    ob['headers'] = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

    if(params['type']){
        ob['type'] = params['type']
    }
    if(params['data']){
        ob['data'] = params['data']
    }
    const success = function success(d){
        if(params['dis_el']){
            params['dis_el'].prop("disabled","")
        }
        if(params['loading_screen']){
            params['loading_screen'].toggleClass("hidden")
        }
        popup_message(d)
        debug_logs(d)
        successCall(d)
    }

    const error = function error(d){
        if(params['dis_el']){
            params['dis_el'].prop("disabled","")
        }
        if(params['loading_screen']){
            params['loading_screen'].toggleClass("hidden")
        }
        popup_message(d)
        if(errCall){
            errCall(d)
        }
    }

    ob['success'] = success
    ob['error'] = error

    debug_logs(ob)

    $.ajax(ob);

}

window.formSubmit = function(params, successCall, errCall=""){
    $(`#${params['el']}`).on(SUBMIT_EVENT, function(e){
        e.preventDefault();
        // showLoader
        const loading_screen = showLoader()
        params['loading_screen'] = loading_screen

        // disable the required element
        if(params['dis_el']){
            params['dis_el'].prop("disabled","disabled")
        }
        let form_data = $(this).get(0)

        debug_logs(form_data)
        let data = new FormData(form_data)

        debug_logs(`data => ${data}`)
        params['data'] = data

        ajaxRequest(params, successCall, errCall)

    })
}

window.IselExist = function(whatever){
    debug_logs(`IselExist method`)
    debug_logs(`before whatever=> ${whatever}`)
    let before = whatever
    whatever = $(whatever)
    if(whatever.length){
        debug_logs(`el ${before} exist`)
        debug_logs(`count before ${before} => ${whatever.length}`)
        debug_logs(`el itself ${whatever}`)
    }else{
        debug_logs(`el ${before} does not exist`)
    }
}

window.resetCaptcha = function(){
    grecaptcha.reset();
}

window.showMap = function(location, map){
    debug_logs(location)
    // showLoader
    const loading_screen = showLoader()
    $(`#${map}`).toggleClass("hidden")
    loading_screen.toggleClass("hidden")
}