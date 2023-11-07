// SweetAlert2
// Show Swal Loader When Submitting to API
function swalAlertLoader( title, timer='' ){
    Swal.fire({
        title: `${title}`, // Loading...
        heightAuto: false,
        padding: '2em',
        timer: timer, // load duration
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

// Show Swal Alert for Action Types & API Response
function swalAlert( inputField='', title='', message='', statusType='', btnTitle='', reload='', redirect='' ){
    Swal.hideLoading();
    Swal.fire({
        title: `${title}!`, // as HTML
        //titleText: `${title}!`, // as normal text
        heightAuto: false,
        html: `${message}`,
        icon: `${statusType}`, // warning; error; success; info; question
        //iconColor: '',
        confirmButtonColor: "#0061F2",
        confirmButtonText: `${btnTitle}`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        padding: '2em',
        //position: '' // top; top-start; top-end; center; center-start; center-end; bottom; bottom-start; bottom-end
    }).then(function(){
        if ( inputField != '' ){
            document.getElementById(`${inputField}`).focus(); // send focus to input field
        }
        else if ( redirect != '' ){
            window.location.href = redirect;
            //console.log( redirect );
        }
        else if ( reload == 'yes' ){
            window.location.reload();
        }
    });
}