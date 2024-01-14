<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>My Profile</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input readonly id="email" placeholder="User Email" class="form-control" type="email" value=""/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="phone" placeholder="Mobile" class="form-control" type="mobile"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    getUserProfileInfo();

    async function getUserProfileInfo(){
        showLoader();
        let response = await axios.get("/user-profile");
        hideLoader();

        document.getElementById("email").value = response.data['data']['email'];
        document.getElementById("firstName").value = response.data['data']['first_name'];
        document.getElementById("lastName").value = response.data['data']['last_name'];
        document.getElementById("phone").value = response.data['data']['mobile'];
        document.getElementById("password").value = response.data['data']['password'];
    }

    async function onUpdate(){
        let email = document.getElementById("email").value;
        let firstName = document.getElementById("firstName").value;
        let lastName = document.getElementById("lastName").value;
        let phone = document.getElementById("phone").value;
        let password = document.getElementById("password").value;

        if(firstName.length ==0){
            errorToast("First name is required");
        }if(lastName.length ==0){
            errorToast("Last name is required");
        }if(phone.length ==0){
            errorToast("Phone is required");
        }if(password.length ==0){
            errorToast("Password is required");
        }else{
            showLoader();
            let response = await axios.post("/user-profile-update", {
                "first_name":firstName,
                "last_name":lastName,
                "mobile":phone,
                "password":password
            });
            hideLoader();

            if(response.status === 200 && response.data['status'] === 'success'){
                successToast(response.data['message']);
                await getUserProfileInfo();
            }else{
                errorToast(response.data['message']);
            }
        }
    }

</script>



{{-- <script>

    getProfile();

    async function getProfile(){
        showLoader();
        let response = await axios.get('/reset-profile');
        hideLoader();

        if(response.status == 200 && response.data['status'] == 'Success'){
            let data = response.data['data'];

            document.getElementById('email').value = data['email'];
            document.getElementById('firstName').value = data['firstName'];
            document.getElementById('lastName').value = data['lastName'];
            document.getElementById('phone').value = data['phone'];
            document.getElementById('password').value = data['password'];
        }
    }

    async function onUpdate() {
        
        let email = document.getElementById('email').value;
        let firstName = document.getElementById('firstName').value;
        let lastName = document.getElementById('lastName').value;
        let phone = document.getElementById('phone').value;
        let password = document.getElementById('password').value;

        if(email.length == 0){
            errorToast('Email Address is required');
        }else if(firstName.length == 0){
            errorToast('First Name is required');
        }else if(lastName.length == 0){
            errorToast('Last Name is required');
        }else if(phone.length == 0){
            errorToast('Phone number is required');
        }else if(password.length == 0){
            errorToast('Password is required');
        }else{

            let URL = '/profile-update';
            let formData = {
                "firstName":firstName,
                "lastName":lastName,
                "phone":phone,
                "password":password
            }

            showLoader();
            let response = await axios.post(URL, formData);
            hideLoader();

            if(response.status == 200 && response.data['status'] == 'Success'){
                successToast(response.data['message']);
                await getProfile();

            }else{
                errorToast(response.data['message']);
            }


        }
        
      
       
    }

</script> --}}