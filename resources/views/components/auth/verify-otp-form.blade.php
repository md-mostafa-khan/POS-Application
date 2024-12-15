<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>ENTER OTP CODE</h4>
                    <br />
                    <label>6 Digit Code Here</label>
                    <input id="otp" placeholder="Code" class="form-control" type="text" />
                    <br />
                    <button onclick="VerifyOtp()" class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // async function VerifyOtp() {
    //     let otp = document.getElementById('otp').value;
    //     if (otp.length !== 6) {
    //         errorToast('Please enter 6 digit code')
    //     } else {
    //         try {
    //             showLoader();
    //             let res = await axios.post('/verify-otp', {
    //                 email: sessionStorage.getItem('email'),
    //                 otp: otp
    //             })
    //             hideLoader();

    //             successToast(res.data['message'])
    //             sessionStorage.clear();
    //             setTimeout(() => {
    //                 window.location.href = '/resetPassword'
    //             }, 1000);

    //         } catch (error) {
    //             hideLoader();
    //             errorToast(error.response.data['message'])
    //         }

    //     }
    // }

    async function VerifyOtp() {
        let otp = document.getElementById('otp').value;
        if (otp.length !== 5) {
            errorToast('Please enter a 6-digit code');
        } else {
            try {
                showLoader();
                let res = await axios.post('/user-otp-verify', {
                    email: sessionStorage.getItem('email'),
                    otp: otp
                });
                hideLoader();

                if (res.status === 200 && res.data['status'] === 'success') {
                    successToast(res.data['message']);
                    sessionStorage.clear();
                    setTimeout(() => {
                        window.location.href = '/resetPassword';
                    }, 1000);
                } else {
                    errorToast(res.data['message']);
                }
            } catch (error) {
                hideLoader();
                // Handle Axios error response
                if (error.response && error.response.status === 401) {
                    errorToast(error.response.data.message); // Display "Invalid OTP"
                } else {
                    errorToast('Something went wrong!');
                }
            }
        }
    }
</script>
