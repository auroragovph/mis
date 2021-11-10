class Select2Office{

    constructor(){
        this.api = route('api.sys.office.division.index')
        this.data = null
    }

    raw_data(){
        this.data = 'changed'
    }

    init(){

        const select2 = $('#select2-office').select2({
            placeholder: 'Select from the list'
        });

        return this.raw_data()
    }
}


jQuery(document).ready(function() {

	const office_select = new Select2Office()
    console.log(office_select.data)

});