require("./bootstrap");
import * as Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import SimpleTypeahead from "vue3-simple-typeahead";
import "vue3-simple-typeahead/dist/vue3-simple-typeahead.css";

axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
};

const options = {
    data() {
        return {
            searchInput: "",
            users: [],
            selectedUser: "",
            show: false,
        };
    },

    methods: {
        async search() {
            axios({
                method: "post",
                url: "get-results/",
                data: { searchInput: this.searchInput },
            }).then((response) => {
                this.users = response.data;
            });
        },

        autocomplete() {
            this.show = true;
            this.search();
        },

        pickUser(user) {
            this.selectedUser = user;
            this.searchInput = "";
            this.show = false;
        },
    },
};

const app = Vue.createApp(options);
app.use(VueAxios, axios, SimpleTypeahead);
app.mount("#app");
