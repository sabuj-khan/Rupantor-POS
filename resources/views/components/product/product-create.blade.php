<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategory">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="productName">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control" id="productPrice">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" id="productUnit">

                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('assets/images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label">Image</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImg">


                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="SaveProduct()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>

    fillCategoryOption();

    async function fillCategoryOption(){
        showLoader();
        let response = await axios.get('/category-list')
        hideLoader();

        response.data['data'].forEach(function(item){
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#productCategory").append(option);
        });
    }


    async function SaveProduct(){
        let p_category = document.getElementById("productCategory").value;
        let p_name = document.getElementById("productName").value;
        let p_price = document.getElementById("productPrice").value;
        let p_unit = document.getElementById("productUnit").value;
        let p_image = document.getElementById("productImg").files[0];

        if(p_category.length == 0){
            errorToast('Product category is required');
        }else if(p_name.length == 0){
            errorToast('Product name is required');
        }else if(p_price.length == 0){
            errorToast('Product price is required');
        }else if(p_unit.length == 0){
            errorToast('Product unit is required');
        }else if(!p_image){
            errorToast('Product image is required');
        }else{
            document.getElementById("modal-close").click();

            let formData=new FormData();
             formData.append('img',p_image)
             formData.append('name',p_name)
             formData.append('price',p_price)
             formData.append('unit',p_unit)
             formData.append('category_id',p_category)

             const config = {
                 headers: {
                     'content-type': 'multipart/form-data'
                 }
             }

            showLoader();
            let response = await axios.post('/product-create', formData, config);
            hideLoader();

            if(response.status === 201 && response.data['status'] === 'success'){
                successToast(response.data['message']);
                document.getElementById("save-form").reset();
                await getProductList();
            }else{
                errorToast('Request fail to create product');
            }
        }
    }

</script>


{{-- 
<script>

    fillCategoryDropdown()

    async function fillCategoryDropdown(){
        showLoader();
        let allCat =await axios.get('/category-list');
        hideLoader();

        allCat.data.forEach(function(item){
            let option = `
            <option value="${item['id']}">${item['name']}</option>
            `

            $("#productCategory").append(option);
        })

    }


    async function Save(){
        
        let productCategory = document.getElementById('productCategory').value;
        let productName = document.getElementById('productName').value;
        let productPrice = document.getElementById('productPrice').value;
        let productUnit = document.getElementById('productUnit').value;
        let productImg = document.getElementById('productImg').files[0];

        if(productCategory.length === 0){
            errorToast('Category is required');
        }
        else if(productName.length === 0){
            errorToast('Product Name is required');
        }else if(productPrice.length === 0){
            errorToast('Product Price is required');
        }else if(productUnit.length === 0){
            errorToast('Product Unit is required');
        }else if(!productImg){
            errorToast('Product Image is required');
        }
        else{

            document.getElementById('modal-close').click();

            let formData=new FormData();
            formData.append('img',productImg)
            formData.append('name',productName)
            formData.append('price',productPrice)
            formData.append('unit',productUnit)
            formData.append('category_id',productCategory)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/product-create",formData,config);
            hideLoader();

            if(res.status===201){
                successToast('New product has been created successfully');
                document.getElementById("save-form").reset();
                await getProductList();
            }
            else{
                errorToast("Request fail and not create product !")
            }
        }
    }

</script> --}}



 

 {{-- <script>
     FillCategoryDropDown();

//     async function FillCategoryDropDown(){
//         let res = await axios.get("/list-category")
//         res.data.forEach(function (item,i) {
//             let option=`<option value="${item['id']}">${item['name']}</option>`
//             $("#productCategory").append(option);
//         })
//     }


//     async function Save() {

//         let productCategory=document.getElementById('productCategory').value;
//         let productName = document.getElementById('productName').value;
//         let productPrice = document.getElementById('productPrice').value;
//         let productUnit = document.getElementById('productUnit').value;
//         let productImg = document.getElementById('productImg').files[0];

//         if (productCategory.length === 0) {
//             errorToast("Product Category Required !")
//         }
//         else if(productName.length===0){
//             errorToast("Product Name Required !")
//         }
//         else if(productPrice.length===0){
//             errorToast("Product Price Required !")
//         }
//         else if(productUnit.length===0){
//             errorToast("Product Unit Required !")
//         }
//         else if(!productImg){
//             errorToast("Product Image Required !")
//         }

//         else {

//             document.getElementById('modal-close').click();

//             let formData=new FormData();
//             formData.append('img',productImg)
//             formData.append('name',productName)
//             formData.append('price',productPrice)
//             formData.append('unit',productUnit)
//             formData.append('category_id',productCategory)

//             const config = {
//                 headers: {
//                     'content-type': 'multipart/form-data'
//                 }
//             }

//             showLoader();
//             let res = await axios.post("/create-product",formData,config)
//             hideLoader();

//             if(res.status===201){
//                 successToast('Request completed');
//                 document.getElementById("save-form").reset();
//                 await getList();
//             }
//             else{
//                 errorToast("Request fail !")
//             }
//         }
//     }
// </script>  --}}