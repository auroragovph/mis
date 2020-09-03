$(function () {
    //Initialize Select2 Elements
    $(".select2").select2({
        placeholder: "Select from list"
    });
});


const createRequest = new Vue({
    el : '#obr-div-create',
    data: {
        itemCount: '',
    },
    methods: {
        addNewRow() {
            let rowElement =  document.getElementById('obr-create');
            rowElement.insertAdjacentHTML('beforeEnd', `

            <hr>

            <div class="row">
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>Responsibility Center</label>
                        <input type="text" name="rc[]" class="form-control">
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>FPP</label>
                        <input type="text" name="fpp[]" class="form-control">
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>Account Code</label>
                        <input type="number" name="ac[]" class="form-control">
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount[]" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="form-group">
                        <label for="">Particulars</label>
                        <textarea name="particulars[]" rows="2" class="form-control" required></textarea>
                    </div>
                </div>
            </div>
            `
            );

            this.itemCount += 1;
        },
        deleteLastRow(){

            if(this.itemCount > 1) {
                let rowElement =  document.getElementById('obr-create');
                rowElement.removeChild(rowElement.lastElementChild);
                rowElement.removeChild(rowElement.lastElementChild);
                this.itemCount -= 1;
            }

            
        },
        countRows(){
            let rows = document.querySelectorAll('#obr-create > .row');
            this.itemCount = rows.length;
        }
    },

    created(){
        this.countRows();
    }
});