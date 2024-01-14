<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="categoryNameUpdate">
                                <input class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="UpdateCategory()" id="update-btn" class="btn btn-sm  btn-success" >Update</button>
            </div>
        </div>
    </div>
</div>

<script>

    async function FillUpUpdateForm(id){
        let catId = document.getElementById("updateID").value; 

        showLoader();
        let response = await axios.post("/category-by-id", {"id":id});
        hideLoader();

        document.getElementById("categoryNameUpdate").value = response.data['data']['name'];

    }

    async function UpdateCategory(){
        let categoryName = document.getElementById("categoryNameUpdate").value;
        let categoryId = document.getElementById("updateID").value;

        if(categoryName.length == 0){
            errorToast("Category name is required !");
        }else{
            document.getElementById("update-modal-close").click();

            showLoader();
            let response = await axios.post("/category-update", {"id":categoryId, "name":categoryName});
            hideLoader();

            if(response.status === 200 && response.data['status'] === 'status'){
                document.getElementById("update-form").reset();
                successToast(response.data['message']);
                await getCategoryList();
            }else{
                errorToast("Request fail to update category");
            }
        }


    }

</script>


{{-- <script>


   async function FillUpUpdateForm(id){
        document.getElementById('updateID').value=id;
        showLoader();
        let res=await axios.post("/category-by-id",{id:id})
        hideLoader();

        document.getElementById('categoryNameUpdate').value=res.data['name'];
    }

    async function Update() {

        let categoryName = document.getElementById('categoryNameUpdate').value;
        let updateID = document.getElementById('updateID').value;

        if (categoryName.length === 0) {
            errorToast("Category Required !")
        }
        else{
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post("/category-update",{name:categoryName,id:updateID})
            hideLoader();

            if(res.status===200 ){
                document.getElementById("update-form").reset();
                successToast("Request success !")
                await getCategoryList();
            }
            else{
                errorToast("Request fail !")
            }

        }

    }



</script> --}}