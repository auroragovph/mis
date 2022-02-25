<x-ui.form.input label="Office" id="comboTreeOffice" required />


@once
    @push('styles')
        <link href="{{ mix('libraries/comboTree/comboTree.css') }}" rel="stylesheet" />
    @endpush

@endonce


@once
    @push('styles')
        <link href="{{ mix('libraries/tom-select/tom-select.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush
    @push('js-lib')
        <script src="{{ mix('libraries/jquery/jquery.min.js') }}"></script>
        <script src="{{ mix('libraries/comboTree/comboTree.js') }}"></script>
    @endpush

    @push('js-custom')

<script type="text/javascript">

    var SampleJSONData = [
        {
            id: 0,
            title: 'Horse'
        }, {
            id: 1,
            title: 'Birds',
            isSelectable: false,
            subs: [
                {
                    id: 10,
                    title: 'Pigeon',
                    isSelectable: false
                }, {
                    id: 11,
                    title: 'Parrot'
                }, {
                    id: 12,
                    title: 'Owl'
                }, {
                    id: 13,
                    title: 'Falcon'
                }
            ]
        }, {
            id: 2,
            title: 'Rabbit'
        }, {
            id: 3,
            title: 'Fox'
        }, {
            id: 5,
            title: 'Cats',
            subs: [
                {
                    id: 50,
                    title: 'Kitty'
                }, {
                    id: 51,
                    title: 'Bigs',
                    subs: [
                        {
                            id: 510,
                            title: 'Cheetah'
                        }, {
                            id: 511,
                            title: 'Jaguar'
                        }, {
                            id: 512,
                            title: 'Leopard'
                        }
                    ]
                }
            ]
        }, {
            id: 6,
            title: 'Fish'
        }
    ];


    var comboTree1, comboTree2;

    jQuery(document).ready(function($) {

            comboTree2 = $('#comboTreeOffice').comboTree({
                source : SampleJSONData,
                collapse:false,

                isMultiple: false
            });
    });


    </script>
    @endpush
@endonce
