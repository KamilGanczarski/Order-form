var App_vue = new Vue({
    el: '#App-vue',
    data: {
        price_native:  115,

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
        delivery: {},
        Deliveries: [
            {
                title: 'inpost',
                img: 'public/img/1280px-InPost_logo.svg',
                description: 'Paczkomaty 24/7',
                price: 10.99,
                disabled_delivery: [ false, true, false ]
            }, {
                title: 'DPD',
                img: 'public/img/DPD_logo_(2015).svg',
                description: 'Kurier DPD',
                price: 18.00,
                disabled_delivery: [ false, false, false ]
            }, {
                title: 'DPD cash on delivery',
                img: 'public/img/DPD_logo_(2015).svg',
                description: 'Kurier DPD pobranie',
                price: 22.00,
                disabled_delivery: [ true, false, true ]
            }
        ],

        // Payment
        payment: {},
        Payments: [
            {
                title: 'PayU',
                img: 'public/img/800px-PayU.svg',
                description: 'PayU',
                disabled: false
            }, {
                title: 'cash on delivery',
                img: 'public/img/d9h0q2l-3e6cbc19-e426-4570-82ea-5ac8cb60f539.jpg',
                description: 'Płatność przy odbiorze',
                disabled: false
            }, {
                title: 'Bank transfer',
                img: 'public/img/Przelew.png',
                description: 'Przelew bankowy - zwykły',
                disabled: false
            }
        ],

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

        bsCollapse: {},
        coupon_modal: {},
        active_coupons: {},
        coupon_error: ''
    },
    mounted() {
        // Load function after render all website
        setTimeout(() => {
            this.prepare_additional_delivery_place();
            this.prepare_bootstrap_modal();
        }, 0);
    },
    methods: {
        prepare_additional_delivery_place() {
            const myCollapse = document.getElementById('additional-delivery')
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

        prepare_bootstrap_modal() {
            this.coupon_modal = new bootstrap.Modal(document.querySelector('#coupon-modal'), {
                keyboard: false
            });
        },

        add_coupon_code() {
            this.coupon_error = '';
            const codes = this.coupon_codes.filter(code =>
                code.active && this.coupon_code_input == code.code
            );

            // Count new price
            if (codes.length > 0) {
                this.active_coupons = codes;
                this.coupon_modal.hide();
            } else {
                this.coupon_error = 'Nieprawidłowy, albo nieaktywny kupon';
            }
        },

        sort_payment(Delivery) {
            this.Payments.forEach((Payment, i) => {
                Payment.disabled = Delivery.disabled_delivery[i];
            });
        },

        show_price() {
            let price = this.price_native;
            // Add coupon to price
            if (this.active_coupons.length > 0)
                price *= this.active_coupons[0].percent;

            // Add delivery price
            if (Object.keys(this.delivery).length > 0)
                price += this.delivery.price;

            return this.custom_price(price);
        },

        custom_price(price) {
            if (typeof price == "undefined") return '';
            return price + [(price == Math.floor(price)) ? `.00 zł` : ` zł`];
        }
    }
});
