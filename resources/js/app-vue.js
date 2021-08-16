var App_vue = new Vue({
    el: '#App-vue',
    data: {
        price_native:  115,

        // User data inputs
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

        // Counpon codes
        coupon_codes: [],
        coupon_code_input: '',
        active_coupons: {},
        coupon_error: '',

        // Countries
        countries: [],

        delivery_collapse: {},
        coupon_modal: {}
        
    },
    mounted() {
        this.fetch_order();
        // Load function after render all website
        setTimeout(() => {
            this.prepare_additional_delivery_place();
            this.prepare_bootstrap_modal();
        }, 0);
    },
    methods: {
        axios_fetch(url, callback) {
			axios.get(url)
				.then(response => (
					callback(response.data)
					// console.log(url, response.data)
				))
				.catch(error => {
					callback(error)
				});
		},

		axios_post(url, callback) {
			axios.post(url)
				.then(response => {
					callback(response.data)
				})
				.catch(error => {
					callback(error)
				});
		},

        fetch_order() {
            let query = "http://localhost/all/order-form.pl/Order-form/app/api/Fetch.php?t=set-order";
            this.axios_fetch(query, (response) => {
                if (response.status === 400) {
                    this.countries = response.countries;
                    this.coupon_codes = response.coupon_codes;
                }
            });
        },

        prepare_additional_delivery_place() {
            const myCollapse = document.getElementById('additional-delivery')
            this.delivery_collapse = new bootstrap.Collapse(myCollapse, {
                toggle: false
            });

            document.querySelector('#another-delivery-place')
                .addEventListener('change', () => {
                if (this.another_delivery_place)
                    this.delivery_collapse.show();
                else
                    this.delivery_collapse.hide();
            });
        },

        prepare_bootstrap_modal() {
            this.coupon_modal = new bootstrap.Modal(
                document.querySelector('#coupon-modal'), {
                keyboard: false
            });
        },

        add_coupon_code() {
            this.coupon_error = '';
            // Search active and the same coupon code
            const codes = this.coupon_codes.filter(code =>
                code.active && this.coupon_code_input == code.code
            );

            if (codes.length > 0) {
                this.active_coupons = codes;
                this.coupon_modal.hide();
            } else {
                this.coupon_error = 'Nieprawidłowy, albo nieaktywny kupon';
            }
        },

        // Rewite from disabled_delivery array to Payments disable or active it
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
            // If price is undefined
            if (typeof price == "undefined") return '';
            // Else
            return price + [(price == Math.floor(price)) ? `.00 zł` : ` zł`];
        },

        check_data() {

        },
    }
});
