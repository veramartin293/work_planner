<template>
    <div v-if="$store.getters.authenticatedUserFlag">
        <main>
            <form-auth v-if="!$store.getters.user"></form-auth>
            <orders-list v-if="$store.getters.user"></orders-list>
            <button @click="addNewOrder">New</button>
            <base-modal v-if="showForm" @closeForm="toggleFormState">
                <base-form>
                    <template v-slot:form-legend>
                        <legend>form legend</legend>
                    </template>

                    <template v-slot:form-body>
                        <div class="form-filed">
                            <p>Form body</p>
                        </div>
                    </template>
                </base-form>
            </base-modal>
        </main>
    </div>
</template>

<script>
import FormAuth from '../components/FormAuth.vue';
import OrdersList from '../components/OrdersList.vue';

export default {
    data() {
        return {
            showForm: false
        };
    },
    components: {
        FormAuth,
        OrdersList,
    },
    methods: {
        toggleFormState() {
            this.showForm = this.showForm === false ? true : false;
        },
        addNewOrder() {
            this.toggleFormState();
        }
    }
}
</script>

<style scoped>
main {
    width: 80%;
    margin: 0 auto;
}

button {
    font-size: 1.2em;
    position: fixed;
    bottom: 0;
    right: 0;
    margin: 50px;
}
</style>