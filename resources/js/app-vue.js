var app = new Vue({
    el: '#App-vue',
    data: {
        price_native: 115,
        price:  115,

        // User data
        create_new_account: false,
        login: '',
        password: '',
        repeat_password: '',
        name: '',
        surname: '',
        selected_country: '',
        address: '',
        postcode: '',
        town: '',
        phone: '',

        // Place an Order for Delivery
        another_delivery_place: false,
        delivery_country: '',
        delivery_address: '',
        delivery_postcode: '',
        delivery_town: '',
        
        // Delivery
        delivery: '',
        // Payment
        payment: '',

        coupon_codes: [
            {
                id: 1,
                active: true,
                code: "5PLFAST",
                percent: 0.5
            }, {
                id: 1,
                active: false,
                code: "Q95FAST",
                percent: 0.25
            }
        ],
        coupon_code_input: '',

        countries: [
            'Albania',
            'Andora',
            'Austria',
            'Belgia',
            'Białoruś',
            'Bośnia i Hercegowina',
            'Bułgaria',
            'Chorwacja',
            'Cypr',
            'Czarnogóra',
            'Czechy',
            'Dania',
            'Estonia',
            'Finlandia',
            'Francja',
            'Grecja',
            'Hiszpania',
            'Holandia',
            'Irlandia',
            'Islandia',
            'Kosowo',
            'Liechtenstein',
            'Litwa',
            'Luksemburg',
            'Łotwa',
            'Macedonia',
            'Malta',
            'Mołdawia',
            'Monako',
            'Niemcy',
            'Norwegia',
            'Polska',
            'Portugalia',
            'Rosja',
            'Rumunia',
            'San Marino',
            'Serbia',
            'Słowacja',
            'Słowenia',
            'Szwajcaria',
            'Szwecja',
            'Turcja',
            'Ukraina',
            'Watykan',
            'Węgry',
            'Wielka Brytania',
            'Włochy'
        ],
        Deliveries: [
            {
                title: 'inpost',
                img: 'public/img/1280px-InPost_logo.svg',
                description: 'Paczkomaty 24/7',
                price: '10,99 zł',
            }, {
                title: 'DPD',
                img: 'public/img/DPD_logo_(2015).svg',
                description: 'Kurier DPD',
                price: '18,00 zł',
            }, {
                title: 'DPD cash on delivery',
                img: 'public/img/DPD_logo_(2015).svg',
                description: 'Kurier DPD pobranie',
                price: '22,00 zł',
            }
        ],
        Payments: [
            {
                title: 'PayU',
                img: 'public/img/800px-PayU.svg',
                description: 'PayU',
            }, {
                title: 'cash on delivery',
                img: 'public/img/d9h0q2l-3e6cbc19-e426-4570-82ea-5ac8cb60f539.jpg',
                description: 'Płatność przy odbiorze',
            }, {
                title: 'Bank transfer',
                img: 'public/img/Przelew.png',
                description: 'Przelew bankowy - zwykły',
            }
        ],
        bsCollapse: {}
    },
    mounted() {
        setTimeout(() => {
            
            this.prepare_additional_delivery_place();
        }, 0);
    },
    methods: {
        prepare_additional_delivery_place() {
            var myCollapse = document.getElementById('additional-delivery')
            this.bsCollapse = new bootstrap.Collapse(myCollapse, {
                toggle: false
            });

            document.querySelector('#another-delivery-place')
                .addEventListener('change', () => {
                if (this.another_delivery_place)
                    this.bsCollapse.show();
                else
                    this.bsCollapse.hide();
            });
        },

        check_new_price() {
            const codes = this.coupon_codes.filter(code =>
                code.active && this.coupon_code_input == code.code
            );
            // Count new price
            if (codes.length > 0)
                this.price = this.price_native * codes[0].percent;
        }
    }
});
