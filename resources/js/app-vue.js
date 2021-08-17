var App_vue = new Vue({
    el: '#App-vue',
    data: {
        message: [],
        message_success: [],
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
        actives_coupons: {},
        coupon_error: '',

        // Countries
        countries: [],

        delivery_collapse: {},
        coupon_modal: {},
        order_success_modal: {},
        comment: '',

        newsletter: false,
        restriction: false,
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

		show_message(messages) {
			this.message = [];
			messages.forEach(message => {
				message.style = "m-0 text-" + message.style;
				this.message.push({
					text: message.message,
					style: message.style
				});
			});

			if (this.message.length > 0)
				document.querySelector('#notification-window').classList.add('show');
			else
				document.querySelector('#notification-window').classList.remove('show');
		},

		show_message_success(messages) {
			this.message_success = [];
			messages.forEach(message => {
				message.style = "m-0 text-" + message.style;
				this.message_success.push({
					text: message.message,
					style: "m-0 text-muted"
				});
			});

			if (this.message_success.length > 0)
                this.order_success_modal.show();
			else
                this.order_success_modal.hide();
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

            this.order_success_modal = new bootstrap.Modal(
                document.querySelector('#order-success-modal'), {
                keyboard: false
            });
        },

        add_coupon_code() {
            this.coupon_error = '';
            // Search active and the same coupon code
            const codes = this.coupon_codes.filter(code =>
                code.active == '1' && this.coupon_code_input == code.code
            );

            if (codes.length > 0) {
                this.actives_coupons = codes;
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
            if (this.actives_coupons.length > 0)
                price -= price * this.actives_coupons[0].percent;

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

        valid_form() {
            let res = {};
            if (!this.restriction) {
                this.show_message([{
                    message: 'Proszę zaakceptować regulamin zakupów',
                    style: 'danger'
                }]);
                return false;
            }

            // Check name
            res = Valid_data.check_name(this.name);
            if (res.style == 'danger') {
                this.show_message([res]);
                return false;
            }

            // Check surname
            res = Valid_data.check_surname(this.surname);
            if (res.style == 'danger') {
                this.show_message([res]);
                return false;
            }

            // If create client account
            if (this.create_new_account) {
                // Check check login
                res = Valid_data.check_login(this.login);
                if (res.style == 'danger') {
                    this.show_message([res]);
                    return false;
                }

                // Check check password
                res = Valid_data.check_password(this.password, this.repeat_password);
                if (res.style == 'danger') {
                    this.show_message([res]);
                    return false;
                }
            }

            // Check country
            res = Valid_data.check_country(this.selected_country);
            if (res.style == 'danger') {
                this.show_message([res]);
                return false;
            }

            // Check address
            res = Valid_data.check_address(this.address);
            if (res.style == 'danger') {
                this.show_message([res]);
                return false;
            }

            // Check postcode
            res = Valid_data.check_postcode(this.postcode);
            if (res.style == 'danger') {
                this.show_message([res]);
                return false;
            }

            // Check town
            res = Valid_data.check_town(this.town);
            if (res.style == 'danger') {
                this.show_message([res]);
                return false;
            }

            // Check phone
            res = Valid_data.check_phone(this.phone);
            if (res.style == 'danger') {
                this.show_message([res]);
                return false;
            }

            if (this.another_delivery_place) {
                // Check delivery country
                res = Valid_data.check_country(this.delivery_country);
                if (res.style == 'danger') {
                    this.show_message([res]);
                    return false;
                }

                // Check delivery address
                res = Valid_data.check_address(this.delivery_address);
                if (res.style == 'danger') {
                    this.show_message([res]);
                    return false;
                }

                // Check delivery postcode
                res = Valid_data.check_postcode(this.delivery_postcode);
                if (res.style == 'danger') {
                    this.show_message([res]);
                    return false;
                }

                // Check delivery town
                res = Valid_data.check_town(this.delivery_town);
                if (res.style == 'danger') {
                    this.show_message([res]);
                    return false;
                }
            }

            // Check delivery method
            res = Valid_data.check_delivery_method(this.delivery.description);
            if (res.style == 'danger') {
                this.show_message([res]);
                return false;
            }

            // Check payment method
            res = Valid_data.check_payment_method(this.payment.description);
            if (res.style == 'danger') {
                this.show_message([res]);
                return false;
            }
            
            // Send request to database
            this.send_order_to_api();
            return true;
        },

        set_order() {
            this.show_message([]);
            this.show_message_success([]);
            this.valid_form();
        },

        send_order_to_api() {
            let query = `http://localhost/all/order-form.pl/Order-form/app/api/Upload.php` +
                `?t=set-order` +
                `&Order={` +
                    `"create_new_account":${this.create_new_account},` +
                    `"login":"${this.login}",` +
                    `"password":"${this.password}",` +
                    `"repeat_password":"${this.repeat_password}",` +
                    `"name":"${this.name}",` +
                    `"surname":"${this.surname}",` +
                    `"country":"${this.selected_country}",` +
                    `"address":"${this.address}",` +
                    `"postcode":"${this.postcode}",` +
                    `"town":"${this.town}",` +
                    `"phone":"${this.phone}",` +

                    `"another_delivery_place":${this.another_delivery_place},` +
                    `"delivery_country":"${this.delivery_country}",` +
                    `"delivery_address":"${this.delivery_address}",` +
                    `"delivery_postcode":"${this.delivery_postcode}",` +
                    `"delivery_town":"${this.delivery_town}",` +
                    
                    `"delivery_method":"${this.delivery.description}",` +
                    `"payment_method":"${this.payment.description}",` +
                    `"actives_coupons":"${this.actives_coupons.length > 0 ? this.actives_coupons[0].code : ''}",` +
                    `"comment":"${this.comment}",` +
                    `"newsletter":"${this.newsletter}"` +
                `}`;

            this.axios_post(query, (response) => {
console.log(response);
                if (response.length > 0 && response[0].style == 'success')
                    this.show_message_success(response);
                else
                    this.show_message(response);
            });
        }
    }
});
