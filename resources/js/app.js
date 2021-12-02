require("./bootstrap");

import Vue from "vue";

Vue.component("qr-scanner", require("./components/QRScanner.vue").default);

window.app = new Vue({
    el: "#app",
});
