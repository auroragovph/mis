$(function () {
    //Initialize Select2 Elements
    $(".select2").select2({
        placeholder: "Select from list"
    });
});

const createCafoa = new Vue({
    el : '#app-root',
    data: {
        itemCount: '',
    },
    methods: {
        addNewRow() {
            let rowElement =  document.getElementById('cafoa-row');
            rowElement.insertAdjacentHTML('beforeEnd', `

            <hr>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Function</label>
                        <input type="text" name="func[]" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Allotment Class</label>
                        <input type="text" name="ac[]" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Expense Code</label>
                        <input type="text" name="ec[]" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="number" step="0.01" name="amount[]" class="form-control">
                    </div>
                </div>
            </div>
            `
            );

            this.itemCount += 1;
        },
        deleteLastRow(){

            if(this.itemCount > 1) {
                let rowElement =  document.getElementById('cafoa-row');
                rowElement.removeChild(rowElement.lastElementChild);
                rowElement.removeChild(rowElement.lastElementChild);
                this.itemCount -= 1;
            }

            
        },
        countRows(){
            let rows = document.querySelectorAll('#cafoa-row > .row');
            this.itemCount = rows.length;
        }
    },

    created(){
        this.countRows();
    }
});