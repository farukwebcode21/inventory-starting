<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4>SIGN IN</h4>
                    <br />
                    <input id="email" placeholder="User Email" class="form-control" type="email" />
                    <br />
                    <input id="password" placeholder="User Password" class="form-control" type="password" />
                    <br />
                    <button type="submit" onclick="SubmitLogin()" class="btn w-100 bg-gradient-primary">Next</button>
                    <hr />
                    <div class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{ route('user-registation') }}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{ route('user.otp') }}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<Script>
    async function SubmitLogin() {

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        

        if (email.length === 0) {
            errorToast('Email is required');
        } else if (password.length === 0) {
            errorToast('Password is required');
        } else {
            try {
                let res = await axios.post('user-login', {
                    email: email,
                    password: password
                });
                if (res.status === 200) {
                    window.location.href = '/dashboard';
                } else {
                   successToast('Successfully login')
                }

            } catch (error) {
                errorToast('An error occured during login')
            } finally {
                hideLoader();
            }
        }
    }
</Script>
