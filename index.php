<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order form</title>

    <!-- Vue.js -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.14.1/lodash.min.js"></script>

    <!-- Fontello icon -->
    <link rel="stylesheet" href="public/css/fontello/css/fontello.css">

    <!-- Style -->
    <link rel="stylesheet" href="public/css/style.min.css">
</head>
<body>
    <article id="App-vue" class="w-100 row py-5 m-0 justify-content-center">
        <!-- Login modal -->
        <div class="modal fade" id="login-modal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-5">
                    <p class="h4 text-custom">Zaloguj się do swojego konta!</p>
                    <p class="pb-4 m-0 text-muted">Tutaj będziesz mógł zachować wszystkie swoje zakupy!</p>

                    <form action="#" method="post" class="col-sm-12 mx-auto">
                        <p class="p-1 m-0 text-muted">Email</p>
                        <input type="text" name="username" id="username" autofocus
                            class="form-control mx-auto mb-3">

                        <p class="p-1 m-0 text-muted">Hasło</p>
                        <input type="password" name="password" id="password"
                            class="form-control mx-auto">

                        <a class="btn w-100 px-1 mb-2 text-start text-custom"
                            href="#">
                            Zapomniałeś hasła?
                        </a>
                        <input type="submit" id="submit" value="Zaloguj"
                            class="btn w-100 px-5 my-1 btn-custom">

                        <div class="w-100 px-1">
                            <span class="text-muted">Nie masz konta?</span>
                            <a href="#" class="btn text-custom px-0">Załóż</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Login modal -->
        <div class="modal fade" id="coupon-modal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5 pb-2 mb-3">
                        <label for="exampleInputEmail1" class="form-label text-custom h3">Kod rabatowy</label>
                        <input type="email" class="form-control"
                            aria-describedby="coupon_code_input" v-model="coupon_code_input">
                        <p class="form-text pb-2">
                            Wprowadź tutuj kod rabatowy, a otrzymasz do 50% tańcze zakupy
                        </p>
                        <button class="btn w-100 fw-bold btn-custom"
                            v-on:click="add_coupon_code()">
                            Zatwierdź
                        </button>
                        <p class="pt-3 text-danger small">{{coupon_error}}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User data -->
        <section class="col-12 col-md-6 col-lg-3">
            <!-- Title -->
            <h6 class="p-3 mb-3 rounded text-uppercase text-white bg-cream">
                <i class="icon-user"></i> 1. Twoje dane
            </h6>

            <!-- Login -->
            <button class="btn w-100 py-2 fw-bold btn-outline-custom"
                data-bs-toggle="modal" data-bs-target="#login-modal">
                Logowanie
            </button>
            <p class="w-100 mt-1 mb-3 text-center small">
                Masz już konto? Kliknij żeby się zalogować.
            </p>

            <!-- Create new account -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox"
                    id="create-new-account" v-model="create_new_account">
                <label class="form-check-label ms-2 small" for="create-new-account">
                    Stwórz nowe konto
                </label>
            </div>

            <!-- User data -->
            <div class="mb-3">
                <input type="text" class="form-control" aria-describedby="login"
                    placeholder="Login" v-model="login">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" aria-describedby="password"
                    placeholder="Hasło" v-model="password">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" aria-describedby="repeat_password"
                    placeholder="Potwierdź hasło" v-model="repeat_password">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" aria-describedby="name"
                    placeholder="Imię *" v-model="name">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" aria-describedby="surname"
                    placeholder="Nazwisko *" v-model="surname">
            </div>
            <div class="mb-3">
                <select class="form-select" v-model="selected_country">
                    <option value="" selected disabled hidden>Państwo</option>
                    <option v-for="country in countries" v-bind:value="country">
                        {{ country }}    
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" aria-describedby="address"
                    placeholder="Adres *" v-model="address">
            </div>
            <div class="w-100 row mx-0 mb-3">
                <div class="col-6 ps-0">
                    <input type="text" class="form-control" aria-describedby="postcode"
                        placeholder="Kod pocztowy *" v-model="postcode">
                </div>
                <div class="col-6 px-0">
                    <input type="text" class="form-control" aria-describedby="town"
                        placeholder="Miasto *" v-model="town">
                </div>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" aria-describedby="phone"
                    placeholder="Telefon *" v-model="phone">
            </div>

            <!-- Place an Order for Delivery -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value=""
                    id="another-delivery-place" v-model="another_delivery_place">
                <label class="form-check-label ms-2 small" for="another-delivery-place">
                    Dostawa pod inny adres
                </label>
            </div>

            <div class="collapse" id="additional-delivery">
                <div class="mb-3">
                    <select class="form-select" v-model="delivery_country">
                        <option value="" selected disabled hidden>Państwo</option>
                        <option v-for="country in countries" v-bind:value="country">
                            {{ country }}    
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" aria-describedby="delivery_address"
                        placeholder="Adres *" v-model="delivery_address">
                </div>
                <div class="w-100 row mx-0 mb-3">
                    <div class="col-6 ps-0">
                        <input type="text" class="form-control" aria-describedby="delivery_postcode"
                            placeholder="Kod pocztowy *" v-model="delivery_postcode">
                    </div>
                    <div class="col-6 px-0">
                        <input type="text" class="form-control" aria-describedby="emailHelp"
                            placeholder="Miasto *" v-model="delivery_town">
                    </div>
                </div>
            </div>
        </section>

        <!-- Payment and delivery -->
        <section class="col-12 col-md-6 col-lg-3">
            <!-- Delivery -->
            <h6 class="p-3 mb-3 rounded text-uppercase text-white bg-cream">
                <i class="icon-truck"></i> 2. Metoda dostawy
            </h6>

            <div v-for="(Delivery, i) in Deliveries"
                class="form-check py-2 mx-3 d-flex align-items-center"
                v-on:click="sort_payment(Delivery)">
                <input class="form-check-input" type="radio" v-model="delivery"
                    v-bind:value="Delivery" name="delivery-radio"
                    v-bind:id="'delivery-radio' + i">
                <label class="form-check-label w-100 d-flex align-items-center small"
                    v-bind:for="'delivery-radio' + i">
                    <img v-bind:src="Delivery.img"
                        alt="inpost-logo" width="60px" class="mx-2">
                    <div class="px-1">{{ Delivery.description }}</div>
                    <b class="ms-auto">{{ custom_price(Delivery.price) }}</b>
                </label>
            </div>

            <!-- Payment -->
            <h6 class="p-3 my-3 rounded text-uppercase text-white bg-cream">
                <i class="icon-credit-card"></i> 3. Metoda płatności
            </h6>

            <div v-for="(Payment, i) in Payments" v-model="payment"
                class="form-check py-2 mx-3 d-flex align-items-center">
                <input class="form-check-input" type="radio" id="radio-payment"
                    v-bind:value="Payment" name="payment-radio"
                    v-bind:id="'payment-radio' + i" v-bind:disabled="Payment.disabled">
                <label class="form-check-label w-100 d-flex align-items-center small"
                    v-bind:for="'payment-radio' + i">
                    <img v-bind:src="Payment.img"
                        alt="inpost-logo" width="50px" class="mx-2">
                    <div class="px-1">{{ Payment.description }}</div>
                </label>
            </div>

            <button class="btn w-100 py-2 mt-4 fw-bold btn-outline-disabled"
                data-bs-toggle="modal" data-bs-target="#coupon-modal">
                Dodaj kod rabatory
            </button>
        </section>

        <!-- Summary -->
        <section class="col-12 col-md-6 col-lg-3 px-0 mb-5">
            <h6 class="p-3 mb-3 rounded text-uppercase text-white bg-cream">
                <i class="icon-doc-text"></i> 4. Podsumowanie
            </h6>

            <div class="d-flex align-items-center pb-3 border-dashed-bottom">
                <img src="public/img/item.png" alt="inpost-logo" width="100px" class="me-2">
                <div class="w-100">
                    <div class="d-flex">
                        <b>Testowy produkt</b>
                        <b class="ms-auto">{{ custom_price(price_native) }}</b>
                    </div>
                    <p class="m-0">Ilość: 1</p>
                </div>
            </div>

            <div class="d-flex align-items-center py-3 border-dashed-bottom">
                <div class="w-100">
                    <div class="d-flex pb-2">
                        <span class="me-auto">Suma częściowa</span>
                        <span>
                            {{ custom_price(price_native) }}
                        </span>
                        <span v-if="active_coupons.length > 0">
                            &nbsp;-&nbsp;{{ custom_price(active_coupons[0].percent*price_native) }}
                        </span>
                        <span v-if="typeof delivery.price != 'undefined'">
                            &nbsp;+&nbsp;{{ custom_price(delivery.price) }}
                        </span>
                    </div>
                    <div class="d-flex">
                        <h4 class="m-0 fw-bold">Łącznie</h4>
                        <h4 class="my-0 ms-auto fw-bold">{{ show_price() }}</h4>
                    </div>
                </div>
            </div>

            <div class="my-4">
                <textarea class="form-control" id="exampleFormControlTextarea1"
                    rows="3" placeholder="Komentarz"></textarea>
            </div>

            <!-- Accept newsletter -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="accept-newsletter">
                <label class="form-check-label ms-2 small" for="accept-newsletter">
                    Zapisz się, aby otrzymywać newsletter
                </label>
            </div>

            <!-- Accept restriction -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="accept-restriction">
                <label class="form-check-label ms-2 small" for="accept-restriction">
                    Zapoznałam/em się z <a href="#">Regulaminem</a> zakupów
                </label>
            </div>

            <!-- Login -->
            <button class="btn w-100 py-3 fw-bold btn-custom">
                Potwierdź zakupy
            </button>
        </section>
    </article>

    <script src="resources/js/app-vue.js"></script>

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
</body>
</html>
