<template>
    <div v-if="$store.getters.authenticatedUserFlag">
        <main>
            <form-auth v-if="!$store.getters.user"></form-auth>
            <orders-list v-if="$store.getters.user"></orders-list>
            <button @click="addNewOrder">New</button>

            <!-- Modal for form -->
            <base-modal v-if="showForm" @closeForm="toggleFormState">
                <base-form @submitClicked="submitForm">
                    <template v-slot:form-legend>
                        <legend>form legend</legend>
                    </template>

                    <template v-slot:form-body>
                        <div class="form-field">
                            <label for="team-name">team name:</label>
                            <input type="text" name="team-name" id="team-name" v-model="order.team_name">
                            <p class="form-error" v-if="formErrors.team_name">{{ formErrors.team_name[0] }}</p>
                        </div>
                        <div class="form-field">
                            <label for="typography">typography:</label>
                            <select name="typography" id="typography" v-model="order.typography">
                                <option value="MLB">MLB</option>
                                <option value="Curve">Curve</option>
                                <option value="Bounce">Bounce</option>
                            </select>
                            <p class="form-error" v-if="formErrors.typography">{{ formErrors.typography[0] }}</p>
                        </div>
                        <div class="form-field">
                            <label for="colors">colors:</label>
                            <input type="text" name="colors" id="colors" v-model="order.colors">
                            <p class="form-error" v-if="formErrors.colors">{{ formErrors.colors[0] }}</p>
                        </div>
                        <div class="form-field">
                            <label for="logo">upload a logo:</label>
                            <input type="file" name="logo" id="logo" @change="onFileSelected">
                            <p class="form-error" v-if="formErrors.logo">{{ formErrors.logo[0] }}</p>
                        </div>
                        <div class="form-field">
                            <label for="date">date:</label>
                            <input type="date" name="date" id="date" v-model="order.date">
                            <p class="form-error" v-if="formErrors.date">{{ formErrors.date[0] }}</p>
                        </div>
                        <div class="form-field">
                            <label for="state">in progress:</label>
                            <input type="checkbox" name="state" id="state" v-model="order.is_in_progress">
                            <p class="form-error" v-if="formErrors.state">{{ formErrors.state[0] }}</p>
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
            showForm: false,
            order: {
                team_name: '',
                typography: '',
                colors: '',
                logo: null,
                date: '',
                is_in_progress: false
            },
            formErrors: {}
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
        },
        onFileSelected(event) {
            this.order.logo = event.target.files[0];
            console.log(this.order.logo);
        },
        constructFormData() {
            const formdata = new FormData;
            for (const key in this.order) {
                formdata.append(key, this.order[key]);
                console.log(this.order[key])
            }
            return formdata;
        },
        async submitForm() {
            console.log('Submiting form...');
            console.log(JSON.stringify(this.order));

            try {
                const token = localStorage.getItem('token');
                const request = await fetch('/api/orders', {
                    method: 'POST',
                    body: this.constructFormData(),
                    headers: {
                        Authorization: token,
                        Accept: 'application/json'
                        // 'Content-type': 'application/json'
                    }
                });
                const response = await request.json(); 

                if (request.ok) {
                    console.log('Request ok')
                    console.log(response);
                } else {
                    console.log('Request not ok');
                    this.formErrors = response.errors;
                    console.log(this.formErrors);
                }   
            } catch(error) {
                console.log('inside error catching');
            }
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