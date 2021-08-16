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
    <article id="App-vue" class="w-100 row m-0 justify-content-center">
        <!-- User data -->
        <section class="col-12 col-md-6 col-lg-3">
            <!-- Title -->
            <h6 class="p-3 mb-3 rounded text-uppercase text-white bg-cream">
                <i class="icon-user"></i> 1. Twoje dane
            </h6>

            <!-- Login -->
            <button class="btn w-100 py-2 fw-bold btn-outline-custom">Logowanie</button>
            <p class="w-100 mt-1 mb-3 text-center small">
                Masz już konto? Kliknij żeby się zalogować.
            </p>

            <!-- Create new account -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="create-new-account">
                <label class="form-check-label ms-2 small" for="create-new-account">
                    Stwórz nowe konto
                </label>
            </div>

            <!-- User data -->
            <div class="mb-3">
                <input type="text" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Login">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Hasło">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Potwierdź hasło">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Imię *">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Nazwisko *">
            </div>
            <div class="mb-3">
                <select class="form-select">
                    <option value="" selected disabled hidden>Państwo</option>
                    <option v-for="country in countries" v-bind:value="country">
                        {{ country }}    
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Adres *">
            </div>
            <div class="w-100 row mx-0 mb-3">
                <div class="col-6 ps-0">
                    <input type="text" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Kod pocztowy *">
                </div>
                <div class="col-6 px-0">
                    <input type="text" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Miasto *">
                </div>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Telefon *">
            </div>

            <!-- Place an Order for Delivery -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="another-delivery-place">
                <label class="form-check-label ms-2 small" for="another-delivery-place">
                    Dostawa pod inny adres
                </label>
            </div>

            <div class="collapse show" id="collapseExample">
                <div class="mb-3">
                    <select class="form-select">
                        <option value="" selected disabled hidden>Państwo</option>
                        <option v-for="country in countries" v-bind:value="country">
                            {{ country }}    
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Adres *">
                </div>
                <div class="w-100 row mx-0 mb-3">
                    <div class="col-6 ps-0">
                        <input type="text" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Kod pocztowy *">
                    </div>
                    <div class="col-6 px-0">
                        <input type="text" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Miasto *">
                    </div>
                </div>
            </div>
        </section>

        <!-- Payment and delivery -->
        <section class="col-12 col-md-6 col-lg-3">
            <!-- Payment -->
            <h6 class="p-3 mb-3 rounded text-uppercase text-white bg-cream">
                <i class="icon-truck"></i> 2. Metoda dostawy
            </h6>

            <div v-for="Delivery in Deliveries"
                class="form-check py-2 mx-3 d-flex align-items-center">
                <input class="form-check-input" type="radio"
                    name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label w-100 d-flex align-items-center small"
                    for="flexRadioDefault1">
                    <img v-bind:src="Delivery.img"
                        alt="inpost-logo" width="60px" class="mx-2">
                    <div class="px-1">{{ Delivery.description }}</div>
                    <b class="ms-auto">{{ Delivery.price }}</b>
                </label>
            </div>

            <!-- Delivery -->
            <h6 class="p-3 my-3 rounded text-uppercase text-white bg-cream">
                <i class="icon-credit-card"></i> 3. Metoda płatności
            </h6>

            <div v-for="Payment in Payments"
                class="form-check py-2 mx-3 d-flex align-items-center">
                <input class="form-check-input" type="radio"
                    name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label w-100 d-flex align-items-center small"
                    for="flexRadioDefault1">
                    <img v-bind:src="Payment.img"
                        alt="inpost-logo" width="50px" class="mx-2">
                    <div class="px-1">{{ Payment.description }}</div>
                </label>
            </div>

            <button class="btn w-100 py-2 mt-4 fw-bold btn-outline-disabled">
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
                        <b class="ms-auto">115.00 zł</b>
                    </div>
                    <p class="m-0">Ilość: 1</p>
                </div>
            </div>


            <div class="d-flex align-items-center py-3 border-dashed-bottom">
                <div class="w-100">
                    <div class="d-flex pb-2">
                        <span>Suma częściowa</span>
                        <span class="ms-auto">115.00 zł</span>
                    </div>
                    <div class="d-flex">
                        <h4 class="m-0 fw-bold">Łącznie</h4>
                        <h4 class="my-0 ms-auto fw-bold">115.00 zł</h4>
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