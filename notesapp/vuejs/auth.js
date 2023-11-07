var auth = new Vue({
    el: '#auth',
    data: {
        loginData: { auth_name:'', password:'' },
        registerData: { username:'', email:'', password:'', confirm_password:'' },
        updatepassData: { current_password:'', new_password:'', repeat_new_password:'' },
        resetData: { email:'', token:'', new_password:'', repeat_new_password:'', reset_time:'' },
    },

    methods: {

        // 1. Login Method
        onLogin( fData, userType ){
            fData.append('action', 'login');
            fData.append('user_type', userType); // user | admin
            fData.append('token', TOKEN);
            fData.append('csrf_token', CSRF_TOKEN);
            fData.append('csrf_token_time', CSRF_TOKEN_TIME);
        
            axios({
                url: API,
                method: 'post',
                data: fData,
                headers: {
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache',
                    'Expires': '0'
                }
            })
            .then( out => {
                if ( out.data.error==true && out.data.notice=='nonexistent' ){ // Account Does Not Exist
                    this.authAlert( '', 'NOTICE', out.data.message, 'error', 'Try Again' );
                    $("#btnLogin").prop("disabled", false); // enable button
                }
                else if ( out.data.error==true && out.data.notice=='cannotlogin' ){ // Account Deleted/Suspended
                    this.authAlert( '', 'NOTICE', out.data.message, 'info', 'Try Again' );
                    $("#btnLogin").prop("disabled", false); // enable button
                }
                else if ( out.data.error==true && out.data.notice=='wrong' ){ // Email/Username/Password Is Wrong
                    this.authAlert( '', 'NOTICE', out.data.message, 'warning', 'Try Again' );
                    $("#btnLogin").prop("disabled", false); // enable button
                }
                /*else if ( out.data.error==true && out.data.notice=='notverified' ){ // Account Not Verified
                    this.authAlert( '', 'NOTICE', out.data.message, 'info', 'Okay' );
                    $("#btnLogin").prop("disabled", false); // enable button
                }*/
                else if ( out.data.error == false && out.data.notice == 'success' ){
                    this.loginData = { auth_name:'', password:'' };

                    Swal.close(); // close Swal Loader

                    $('#loginForm').hide();
                    document.getElementById('loginLoader').style.display = 'block';
                    setTimeout(function(){
                        //$("#statusAlert").fadeOut(delay); // hide alert
                        window.location.href = out.data.url;
                    }, 4e3);
                }
                else {
                    this.authAlert( '', 'NOTICE', 'Something Went Wrong: '+ out.data.message, 'error', 'Okay' );
                    console.log( 'Last else{} statement: '+ out.data.message );
                }
            })
            .catch( error => {
                console.log( error );
            });
        },

        // 2. Regsiter Method
        onRegister( fData ){
            fData.append('action', 'register');

            axios({
                url: API,
                method: 'post',
                data: fData,
                headers: {
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache',
                    'Expires': '0'
                }
            })
            .then( out => {
                if ( out.data.error==true && out.data.notice=='exists' ){ // Email Exists
                    this.authAlert( 'email', 'NOTICE', out.data.message, 'warning', 'Try Again' );
                    //console.log( 'Email exists statement' )
                }
                else if ( out.data.error==false && out.data.notice=='success' ){ // Account Created
                    //this.authAlert( '', 'NOTICE', out.data.message, 'success', 'Great!', '', "Auth.Verify" );
                    this.registerData = { username:'', email:'', password:'', confirm_password:'' };

                    Swal.close(); // close Swal Loader

                    $('#registerForm').hide();
                    document.getElementById('loginLoader').style.display = 'block';
                    setTimeout(function(){
                        //$("#statusAlert").fadeOut(delay); // hide alert
                        window.location.href = out.data.url;
                    }, 4e3);
                }
                else if ( out.data.error==true && out.data.notice=='fail' ){ // Account Not Created
                    this.authAlert( '', 'NOTICE', out.data.message, 'error', 'Okay' );
                }
                else {
                    this.authAlert( '', 'NOTICE', 'Something Went Wrong: '+ out.data.message, 'error', 'Okay' );
                    console.log( 'Last else{} statement: '+ out.data.message )
                }
                //console.log( 'Error: '+ out.data.error +' | Notice: '+ out.data.notice +' | Message: '+ out.data.message );
            })
            .catch( error => {
                console.log( error );
            });
        },

        // 3. Update Password Method
        onUpdatePassword( fData, userType ){
            fData.append('action', 'updatepass');
            fData.append('user_type', userType); // member | admin
            if ( userType == 'member' ){
                fData.append('user_id', MEM_ID); // member
            }
            else if ( userType == 'admin' ){
                fData.append('user_id', AID_ID); // admin
            }

            axios({
                url: AUTH_API,
                method: 'post',
                data: fData
            })
            .then( out => {
                if ( out.data.error==true && out.data.notice=='wrong' ){ // Password Is Wrong
                    this.authAlert( '', 'NOTICE', out.data.message, 'warning', 'Try Again' );
                }
                else if ( out.data.error==false && out.data.notice=='success' ){ // Log In Successful
                    this.updatepassData.current_password = '';
                    this.updatepassData.new_password = '';
                    this.updatepassData.repeat_new_password = '';
                    this.authAlert( '', 'NOTICE', out.data.message, 'success', 'Great!', '', 'Auth.Logout' );
                }
                else {
                    this.authAlert( '', 'NOTICE', 'Something Went Wrong: '+ out.data.message, 'error', 'Okay' );
                    console.log( 'Last else{} statement: '+ out.data.message )
                }
            })
            .catch( error => {
                console.log( error );
            });
        },

        // Reset Password
        /*onResetPassword( fData, reset_type ){
            fData.append('action', 'resetpassword');
            fData.append('reset_type', reset_type);

            axios({
                url: API,
                method: 'post',
                data: fData
            })
            .then( out => {
                if ( out.data.error==true && out.data.notice=='nonexistent' ){ // Account Does Not Exist
                    this.authAlert( '', 'NOTICE', out.data.message, 'error', 'Try Again' );
                }
                else if ( out.data.error==false && out.data.notice=='success' ){ // Password Reset Request Sent
                    if ( reset_type == 'send_mail' ){
                        auth.resetData.reset_time = out.data.reset_time; // Reset Time
                        $( '#AuthResetPasswordModal' ).modal({
                            backdrop: 'static',
                            keyboard: false,
                        });
                        this.authAlert( '', 'NOTICE', out.data.message, 'success', 'Continue' );
                    }
                    else if ( reset_type == 'update_pass' ){
                        $( '#AuthResetPasswordModal' ).modal('hide');
                        this.authAlert( '', 'NOTICE', out.data.message, 'success', 'Great!', '', "Auth.Login" );
                    }
                }
                else if ( out.data.error==true && out.data.notice=='fail' ){ // Password Reset Request Not Sent
                    this.authAlert( '', 'NOTICE', out.data.message, 'error', 'Okay' );
                }
                else {
                    this.authAlert( '', 'NOTICE', 'Something Went Wrong: '+ out.data.message, 'error', 'Okay' );
                    console.log( 'Last else{} statement: '+ out.data.message )
                }
                //console.log( 'Error: '+ out.data.error +' | Notice: '+ out.data.notice +' | Message: '+ out.data.message );
            })
            .catch( error => {
                console.log( error );
            });
        },*/

        checkFields( formAction, dType='' ){
            // Log In
            if ( formAction == 'login' ){
                $("#btnLogin").prop("disabled", true); // disable button

                let fd = auth.toFormData(auth.loginData);

                if ( this.loginData.auth_name == '' ){
                    this.authAlert( 'auth_name', 'NOTICE', 'Username Cannot Be Empty!', 'warning', 'Try again.' );
                    $("#btnLogin").prop("disabled", false); // enable button
                }
                else if ( this.loginData.password == '' ){
                    this.authAlert( 'password', 'NOTICE', 'Password Cannot Be Empty!', 'warning', 'Try again.' );
                    $("#btnLogin").prop("disabled", false); // enable button
                }
                else {
                    this.authAlertLoader( 'Logging In...' );
                    this.onLogin( fd, dType );
                }
            }

            // Register
            if ( formAction == 'register' ){
                $("#btnRegister").prop("disabled", true); // disable button

                let fd = auth.toFormData(auth.registerData);

                if ( this.registerData.username == '' ){
                    this.authAlert( 'username', 'NOTICE', 'Username Is Required!', 'warning', 'Try again.' );
                    $("#btnRegister").prop("disabled", false); // enable button
                }
                else if ( this.registerData.email == '' ){
                    this.authAlert( 'email', 'NOTICE', 'Email Is Required!', 'warning', 'Try again.' );
                    $("#btnRegister").prop("disabled", false); // enable button
                }
                else if ( !this.validEmail(this.registerData.email) ){
                    this.authAlert( 'email', 'NOTICE', 'Email Is Invalid!', 'warning', 'Try again.' );
                    $("#btnRegister").prop("disabled", false); // enable button
                }
                else if( this.registerData.password == '' ){
                    this.authAlert( 'password', 'NOTICE', 'Password Is Required!', 'warning', 'Try again.' );
                    $("#btnRegister").prop("disabled", false); // enable button
                }
                else if ( this.registerData.confirm_password == '' ){
                    this.authAlert( 'confirm_password', 'NOTICE', 'Confirm Password Is Required!', 'warning', 'Try again.' );
                    $("#btnRegister").prop("disabled", false); // enable button
                }
                /* password length method */
                else if ( this.registerData.password != this.registerData.confirm_password ){
                    this.authAlert( 'password', 'NOTICE', 'Password & Confirm Password Must Match!', 'warning', 'Try again.' );
                    $("#btnRegister").prop("disabled", false); // enable button
                }
                else {
                    this.authAlertLoader( 'Creating Account...' );
                    this.onRegister( fd );
                }
            }

            // Update Password
            if ( formAction == 'updatepass' ){
                $("#btnUpdatePass").prop("disabled", true); // disable button

                let fd = auth.toFormData(auth.updatepassData);

                if ( this.updatepassData.current_password == '' ){
                    this.authAlert( 'current_password', 'NOTICE', 'Current Password Is Required!', 'warning', 'Try again.' );
                    $("#btnUpdatePass").prop("disabled", false); // enable button
                }
                else if ( this.updatepassData.new_password == '' ){
                    this.authAlert( 'new_password', 'NOTICE', 'New Password Is Required!', 'warning', 'Try again.' );
                    $("#btnUpdatePass").prop("disabled", false); // enable button
                }
                else if ( this.updatepassData.repeat_new_password == '' ){
                    this.authAlert( 'repeat_new_password', 'NOTICE', 'Retype New Password Is Required!', 'warning', 'Try again.' );
                    $("#btnUpdatePass").prop("disabled", false); // enable button
                }
                else if ( this.updatepassData.new_password != this.updatepassData.repeat_new_password ){
                    this.authAlert( 'new_password', 'NOTICE', 'New Password & Retype New Password Must Match!', 'warning', 'Try again.' );
                    $("#btnUpdatePass").prop("disabled", false); // enable button
                }
                else {
                    this.authAlertLoader('Updating Your Password...');
                    this.onUpdatePassword( fd, dType );
                }
            }

            // Reset Password
            /*if ( form_type == 'resetpassword' ){
                let fd = auth.toFormData(auth.resetData);

                if ( dType == 'send_mail' ){
                    if ( this.resetData.email == '' ){
                        this.authAlert( 'email', 'NOTICE', 'Email Is Required!', 'warning', 'Try again.' );
                    }
                    else if ( !this.validEmail(this.resetData.email) ){
                        this.authAlert( 'email', 'NOTICE', 'Email Is Invalid!', 'warning', 'Try again.' );
                    }
                    else {
                        this.authAlertLoader('Generating Password Reset Request...');
                        this.onResetPassword( fd, dType );
                    }
                }
                else if ( dType == 'update_pass' ){
                    if ( this.resetData.token == '' ){
                        this.authAlert( 'token', 'NOTICE', 'Token Is Required!', 'warning', 'Try again.' );
                    }
                    else if ( this.resetData.new_password == '' ){
                        this.authAlert( 'new_password', 'NOTICE', 'New Password Is Required!', 'warning', 'Try again.' );
                    }
                    else if ( this.resetData.repeat_new_password == '' ){
                        this.authAlert( 'repeat_new_password', 'NOTICE', 'Retype New Password Is Required!', 'warning', 'Try again.' );
                    }
                    else if ( this.resetData.new_password != this.resetData.repeat_new_password ){
                        this.authAlert( 'new_password', 'NOTICE', 'New Password & Retype New Password Must Match!', 'warning', 'Try again.' );
                    }
                    else {
                        this.authAlertLoader('Updating Your Password...');
                        this.onResetPassword( fd, dType );
                    }
                }
            }*/
        },

        


        //----------
        // SweetAlert2
        // Show Swal Loader When Submitting to API
        authAlertLoader: function ( title, timer='' ){
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
        },

        // Show Swal Alert for Action Types & API Response
        authAlert: function ( inputField='', title='', message='', statusType='', btnTitle='', reload='', redirect='' ){
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
        },

        // Filter Email to Make Valid
		validEmail: function (email){ // Validate Email
			var re = RegExp(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
			return re.test(email);
		},

        // Check Password Length
        checkPassLength: function(){ //Check password length
            var passlength = document.getElementById("password").value;
            if ( (passlength < 6) || 0 == passlength ){
                document.getElementById("msg12345").innerHTML = "*Please enter atleast six characters";
                return false ;
            } else {
                document.getElementById("msg12345").innerHTML = "";
                return true;
            }
        },

        // Unhide & Show Password
		showPass: function(){
			var pass = document.getElementById("password");
			if ( pass.type === "password" ){
				pass.type = "text";
			} else {
				pass.type = "password";
			}
		},

        // Initial Method Placement
        toFormData: function(obj){
			var form_data = new FormData();
			for(var key in obj){
				form_data.append(key, obj[key]);
			}
			return form_data;
		},
    },
})