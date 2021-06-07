window.addEventListener('toastr-alert', event => {
    switch(event.detail.type){
        case "success": 
            toastr.success(event.detail.message, event.detail.title);
        break;
        case "warning": 
            toastr.warning(event.detail.message, event.detail.title);
        break;
        case "error": 
            toastr.error(event.detail.message, event.detail.title);
        break;
        default: 
            toastr.info(event.detail.message, event.detail.title);
        break;
    }
});
