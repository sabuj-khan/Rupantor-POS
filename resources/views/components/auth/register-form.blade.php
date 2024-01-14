<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Sign Up</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" type="email"/>
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
                            <div class="col-md-6 p-2">
                                <button onclick="onRegistration()" class="btn mt-3 w-50  btn-primary">Complete</button>
                                
                                
                            </div>
                            <div class="col-md-6 p-2 d-flex justify-content-center">
                                
                                    <span class="mt-4">
                                        {{-- <a class="text-center ms-3 h6" href="{{url('/userLogin')}}">Have an Account ? </a> --}}
                                        <p class="float-start fw-bold text-center ms-3 h6">Have an Account  ? </p>
                                        <span class="ms-3">|</span>
                                        <a class="text-center ms-3 h6" href="{{url('/userLogin')}}">Sign In</a>
                                    </span>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>


<script>

    async function onRegistration(){
        let email = document.getElementById("email").value;
        let firstName = document.getElementById("firstName").value;
        let lastName = document.getElementById("lastName").value;
        let phone = document.getElementById("phone").value;
        let password = document.getElementById("password").value;

        if(email.length == 0){
            errorToast('Email Address is required');
        }else if(firstName.length == 0){
            errorToast('First name is required');
        }else if(lastName.length == 0){
            errorToast('Last name is required');
        }else if(phone.length == 0){
            errorToast('Phone Number is required');
        }else if(password.length == 0){
            errorToast('Password is required');
        }else{
            let formData = {
                "first_name":firstName,
                "last_name":lastName,
                "email":email,
                "mobile":phone,
                "password":password
            }

            showLoader();
            let response = await axios.post('/user-register', formData);
            hideLoader();

            if(response.status === 201 && response.data['status'] === 'success'){
                successToast(response.data['message']);
                setTimeout(function (){
                    window.location.href='/userLogin'
                },2000)

            }else{
                errorToast(response.data['message']);
            }

        }
    }


</script>

{{-- <script>

    async function onRegistration() {
        
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

            let URL = '/user-register';
            let formData = {
                "firstName":firstName,
                "lastName":lastName,
                "email":email,
                "phone":phone,
                "password":password
            }

            showLoader();
            let response = await axios.post(URL, formData);
            hideLoader();

            if(response.status == 200 && response.data['status'] == 'Success'){
                successToast(response.data['message']);
                setTimeout(function (){
                    window.location.href='/userLogin'
                },2000)

            }else{
                errorToast(response.data['message']);
            }


        }
        
      
       
    }

</script> --}}