<div class="modal" id="delete-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteID"/> <br> 
                <input class="d-none" id="deleteFilePath"/>

            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn shadow-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="ProductDelete()" type="button" id="confirmDelete" class="btn shadow-sm btn-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    async function ProductDelete(){
        let id = document.getElementById("deleteID").value;
        let image = document.getElementById("deleteFilePath").value;

        document.getElementById("delete-modal-close").click();

        showLoader();
        let response = await axios.post('/product-delete', {"id":id, "file_path":image});
        hideLoader();

        if(response.status === 200 && response.data['status'] === 'success'){
            successToast(response.data['message']);
            await getProductList();

        }else{
            errorToast('Request fail to delete the product');
        }
    }    


</script>





{{-- <script>

    async function ProductDelete(){
        let id = document.getElementById('deleteID').value;
        let img = document.getElementById('deleteFilePath').value;

        document.getElementById('delete-modal-close').click();

        showLoader();
        let response = await axios.post('/product-delete', {id:id, file_path:img});
        hideLoader();

        if(response.status == 200 && response.data['status'] == 'Success'){
            successToast('The item has been deleted successfully');
            getProductList();
        }else{
            errorToast('Request Fail !');
        }
    }

</script> --}}