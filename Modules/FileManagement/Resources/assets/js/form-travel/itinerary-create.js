$(function () {
    //Initialize Select2 Elements
    $(".select2").select2({
        placeholder: "Select from list"
    });
});


const createRequest = new Vue({
    el : '#itinerary-div-create',
    data: {
        itemCount: '',
    },
    methods: {
        addNewRow() {
            let rowElement =  document.getElementById('itinerary-create');
            rowElement.insertAdjacentHTML('beforeEnd', `

            <div class="itinerary-list">
            <hr>

            <div class="row">

                <div class="col-md-6">
                <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" name="list-date[]" class="form-control">
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                        <label for="">Destination</label>
                        <input type="text" name="list-destination[]" class="form-control">
                </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Departure</label>
                        <input type="text" name="list-departure[]" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Arrival</label>
                        <input type="text" name="list-arrival[]" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Means of Transportation</label>
                        <input type="text" name="list-means[]" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Transportation</label>
                        <input type="text" name="list-trans[]" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Per diem</label>
                        <input type="text" name="list-diem[]" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Others</label>
                        <input type="text" name="list-other[]" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Total Amount</label>
                        <input type="text" name="list-amount[]" class="form-control">
                    </div>
                </div>
            </div>
            </div>
            `
            );

            this.itemCount += 1;
        },
        deleteLastRow(){

            if(this.itemCount > 1) {
                let rowElement =  document.getElementById('itinerary-create');
                rowElement.removeChild(rowElement.lastElementChild);
                this.itemCount -= 1;
            }

            
        },
        countRows(){
            let rows = document.querySelectorAll('#itinerary-create > .itinerary-list');
            this.itemCount = rows.length;

            console.log(this.itemCount);
        }
    },

    created(){
        this.countRows();
    }
});