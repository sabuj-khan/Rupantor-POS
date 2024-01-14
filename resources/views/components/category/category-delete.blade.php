<div class="modal" id="delete-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteID"/>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn shadow-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="DeleteCategory()" type="button" id="confirmDelete" class="btn shadow-sm btn-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    async function DeleteCategory(){
        let catID = document.getElementById("deleteID").value;

        document.getElementById("delete-modal-close").click();

        showLoader();
        let response = await axios.post("/category-delete", {"id":catID});
        hideLoader();

        if(response.status === 200 && response.data['status'] === 'success'){
            successToast(response.data['message']);
            await getCategoryList();
        }else{
            errorToast("Request fail to delete the category !");
        }
    }

</script>



{{-- <script>

    async function DeleteCategory(){
        let id = document.getElementById('deleteID').value;
        document.getElementById('delete-modal-close').click();

        showLoader();
        let response = await axios.post('/category-delete', {id:id});
        hideLoader();

        if(response.status == 200 && response.data['status'] == 'Success'){
            successToast(response.data['message']);
            await getCategoryList();
        }else{
            errorToast('Request Fail !');
        }
    }


</script> --}}

{{-- <script>

     async  function  itemDelete(){
            let id=document.getElementById('deleteID').value;
            document.getElementById('delete-modal-close').click();
            showLoader();
            let res=await axios.post("/delete-category",{id:id})
            hideLoader();
            if(res.data===1){
                successToast("Request completed")
                await getList();
            }
            else{
                errorToast("Request fail!")
            }
     }

</script> --}}