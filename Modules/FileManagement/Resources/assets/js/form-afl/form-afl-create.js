$(function () {
    //Initialize Select2 Elements
    $(".select2").select2({
        placeholder: "Select from list"
    });

    $('#datepicker').datepicker({
        multidate: true,
        clearBtn: true,
    })
});

const createCafoa = new Vue({
    el : '#app-root',
    data: {
       employee: '',
       leaveType: ''
    },
    methods: {
        updateType: function(){
            console.log('Hey!');
        }
    },

    created(){
        
    }
});