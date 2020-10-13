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
        v1: parseFloat(document.querySelector("input[name=v1]").value),
        v2: parseFloat(document.querySelector("input[name=v2]").value),
        s1: parseFloat(document.querySelector("input[name=s1]").value),
        s2: parseFloat(document.querySelector("input[name=s2]").value),

        vacation: {
            type: '',
            details: '',
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
    },
    methods: {
        sickC: function(){
            if(document.querySelector('#sic-mut').value == 'true'){
                return this.sick.inh = true;
            }else{
                return this.sick.inh = false;
            }
            // console.log(document.querySelector('#sic-mut').value);

        }
    },
    mounted:function(){
        this.sickC()
  }
});