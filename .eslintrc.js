module.exports = {
    env: {
        node: true,
        browser: true,
        jquery: true,
        $: true,
        debug_logs: true,
        update_field: true,
        define: true,
        successCall: true,
        errCall: true
    },
    globals: {
        ajaxRequest: true,
        ajaxRequest: true,
        showLoader: true,
        e: true,
        api_message: true,
        api_is_success: true,
        show_message: true,
        text: true,
        err_msg: true,
        swal: true,
        debug: true,
        debug_logs: true,
        debug_logs: true,
    },
    extends: "eslint:recommended",
    parserOptions: {
        ecmaVersion: 2022,
        sourceType: "module"
    },
    rules: {
        "no-undef": "off",
        "no-unused-vars": "off"
    }
};
