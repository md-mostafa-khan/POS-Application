<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br />
                    <label>New Password</label>
                    <input id="newPassword" placeholder="New Password" class="form-control" type="password" />
                    <br />
                    <label>Confirm Password</label>
                    <input id="confirmPassword" placeholder="Confirm Password" class="form-control" type="password" />
                    <br />
                    <button onclick="ResetPassword()" class="btn w-100 bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function ResetPassword() {
        let newPassword = document.getElementById('newPassword').value;
        let confirmPassword = document.getElementById('confirmPassword').value;

        if (newPassword.length === 0) {
            errorToast('Password is required')
        }
        else if (confirmPassword.length < 6 && newPassword.length < 6) {
            errorToast('New Password and Confirm Password must be at least 6 characters')

        }
        else if (newPassword.length < 6) {
            errorToast('New Password must be at least 6 characters')
        }
        else if (confirmPassword.length === 0) {
            errorToast('Confirm Password is required')
        }
        else if (confirmPassword.length < 6) {
            errorToast('Confirm Password must be at least 6 characters')
        }
        else if (newPassword !== confirmPassword) {
            errorToast('New Password and Confirm Password must be same ')
        }
        else {
            showLoader();
            let res = await axios.post("/user-reset-password", {
                password: newPassword,
            })
            hideLoader();
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message']);
                setTimeout(() => {
                    window.location.href = '/userLogin';
                }, 1000);
            }else{
                errorToast(res.data['message']);
            }

        }

    }
</script>
