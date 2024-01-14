<div class="modal" id="delete-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                
                <input class="" id="deleteID"/>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn shadow-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="DeleteInvoice()" type="button" id="confirmDelete" class="btn shadow-sm btn-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    async function DeleteInvoice(){
        let invoiceID = document.getElementById("deleteID").value;

        document.getElementById("delete-modal-close").click();

        showLoader();
        let response = await axios.post('/invoice-delete', {"invoice_id":invoiceID});
        hideLoader();

        if(response.status === 200 && response.data['status'] === 'success'){
            successToast("Invoice has been deleted successfully");
            await getInvoiceList();
        }else{
            errorToast('Request failed to delete invoice');
        }

    }

</script>