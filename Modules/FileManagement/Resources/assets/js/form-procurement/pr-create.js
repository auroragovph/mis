$(function () {
    //Initialize Select2 Elements
    $(".select2").select2({
        placeholder: "Select from list"
    });
});


const createRequest = new Vue({
    el : '#procurement-request-create',
    data: {
        itemCount: '',
    },
    methods: {
        addNewRow() {
            let rowElement =  document.getElementById('pr-create');
            rowElement.insertAdjacentHTML('beforeEnd', `

            <hr>

            <div class="row">
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>Stock Number</label>
                        <input type="text" name="stock[]" class="form-control">
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>Unit</label>
                        <input type="text" name="unit[]" class="form-control">
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="qty[]" class="form-control">
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>Item Cost</label>
                        <input type="number" name="cost[]" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="form-group">
                        <label for="">Item Description</label>
                        <textarea name="desc[]" rows="2" class="form-control" required></textarea>
                    </div>
                </div>
            </div>
            `
            );

            this.itemCount += 1;
        },
        deleteLastRow(){

            if(this.itemCount > 1) {
                let rowElement =  document.getElementById('pr-create');
                rowElement.removeChild(rowElement.lastElementChild);
                rowElement.removeChild(rowElement.lastElementChild);
                this.itemCount -= 1;
            }

            
        },
        countRows(){
            let rows = document.querySelectorAll('#pr-create > .row');
            this.itemCount = rows.length;
        }
    },

    created(){


        this.countRows();


    }
});