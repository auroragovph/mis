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
        v1: 0,
        v2: 0,
        s1: 0,
        s2: 0,

        vacation: {
           type: '',
           details: ''
        },

        sick: {
            inh: false,
        }
    }, 
    watch: {
        v1: function(){
            return this.v1  = parseFloat(this.v1);
        },
        v2: function(){
            return this.v2  = parseFloat(this.v2);
        },
        s1: function(){
            return this.s1  = parseFloat(this.s1);
        },
        s2: function(){
            return this.s2  = parseFloat(this.s2);
        }
    }
});