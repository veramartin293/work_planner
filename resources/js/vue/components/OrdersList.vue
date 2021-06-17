<template>
    <div>
        <h1>Lista De Ordenes</h1>
        <div class="order-list-container">
            <order-card v-for="order in orders" :key="order.id"
            :order="order" @editClicked="editOrder" @deleteClicked="deleteOrder"></order-card>
        </div>
        <button class="new" @click="addNewOrder">Nueva</button>

        <!-- Modal for form -->
        <base-modal v-if="showForm" @closeForm="cancelForm">
            <base-form @submitClicked="submitForm" @formCanceled="cancelForm">
                <template v-slot:form-legend>
                    <legend>{{ formLegend }}</legend>
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

                        <div class="color-selection">
                            <label class="color-selection__label" for="colors">colors:</label>

                            <div class="color-selection__qty">
                                <button @click="modifyColorQty(-1)">-</button>
                                <div>{{ colorArray.length }}</div>
                                <button @click="modifyColorQty(1)">+</button>
                            </div>
                        </div>
                        
                        <div class="color-picker-container">
                            <input type="color" 
                            v-for="(color, index) in colorArray" 
                            :key="index" 
                            v-model="colorArray[index]"
                            >
                        </div>

                        <p class="form-error" v-if="formErrors.colors">{{ formErrors.colors[0] }}</p>
                    </div>
                    <div class="form-field" v-if="formMode === 'create'">
                        <label for="logo">upload a logo:</label>
                        <input class="input-file" type="file" name="logo" id="logo" @change="onFileSelected">
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
    </div>
</template>

<script>
import OrderCard from './OrderCard';
import performApiCall from '../../apiFactory.js';

export default {
    components: {
        OrderCard
    },
    data() {
        return {
            orders: [],
            order: {
                team_name: '',
                typography: '',
                colors: '',
                logo: null,
                date: '',
                is_in_progress: false
            },
            colorArray: [],

            previousOrder: {},
            showForm: false,
            formMode: 'create',
            formErrors: {}
        }
    },
    created() {
        this.getAllOrders();
    },
    computed: {
        formLegend() {
            return this.formMode === 'create' ? 'Crear nueva orden' : 'Editar orden'
        }
    },
    watch: {
        colorArray: {
            handler() {
                this.order.colors = this.colorArray.join('/');
            },
            deep: true
        }
    },
    methods: {
        modifyColorQty(qty) {
            if (qty >= 1) {
                this.colorArray.push('#000000');
            } else {
                this.colorArray.pop();
            }

            if (this.colorArray.length > 4) {
                this.colorArray.pop();
            }
        },
        async getAllOrders() {
            const response = await fetch('/api/orders');
            const responseData = await response.json();

            if (response.ok) {
                this.orders = responseData;
            } else {
                console.log(responseData.error);
            }
        },
        onFileSelected(event) {
            this.order.logo = event.target.files[0];
        },
        constructFormData() {
            const formdata = new FormData;
            for (const key in this.order) {
                formdata.append(key, this.order[key]);
            }
            return formdata;
        },
        resetOrderValues() {
            this.order = {
                team_name: '',
                typography: '',
                colors: '',
                colors_array: [],
                logo: null,
                date: '',
                is_in_progress: false
            }
            this.formErrors = {};
            this.colorArray = [];
        },
        toggleFormState() {
            this.showForm = this.showForm === false ? true : false;
        },
        cancelForm() {
            this.toggleFormState();
            if (this.formMode === 'edit') {
                const order = this.orders.find(el => el.id === this.previousOrder.id);
                order.team_name = this.previousOrder.team_name;
                order.typography = this.previousOrder.typography;
                order.colors = this.previousOrder.colors;
                order.date = this.previousOrder.date;
                order.is_in_progress = this.previousOrder.is_in_progress;
            }
            this.resetOrderValues();
        },
        addNewOrder() {
            this.formMode = 'create';
            this.toggleFormState();
        },
        editOrder(order) {
            this.order = order;
            this.colorArray = this.order.colors.split('/');
            this.previousOrder = JSON.parse(JSON.stringify(order));
            this.formMode = 'edit';
            this.toggleFormState();
        },
        deleteOrder(order) {
            performApiCall(`/api/orders/${order.id}`, 'DELETE', true, {})
            .then(response => {
                if (response.id) {
                    const orderIndex = this.orders.findIndex(el => el.id === response.id);
                    this.orders.splice(orderIndex, 1);
                }
            })
        },
        submitForm() {
            // Verify if is a post or update
            const url = this.formMode === 'edit' ? `/api/orders/${this.order.id}` : `/api/orders`;
            const method = this.formMode === 'edit' ? 'PUT' : 'POST';
            const authNeeded = true;
            const data = this.formMode === 'edit' ? JSON.stringify(this.order) : this.constructFormData();
            const contentType = this.formMode === 'edit' ? 'application/json' : '';

            performApiCall(url, method, authNeeded, data, contentType)
            .then(response => {
                if (response.errors) {
                    this.formErrors = response.errors;
                } else if (response.error) {
                    console.log('A general error has been occured');
                } else {
                    this.toggleFormState();
                    this.resetOrderValues();
                    if (this.formMode !== 'edit') {
                        this.orders.push(response);
                    }
                }
            });
        }
    }
}
</script>

<style scoped>
h1 {
    padding: 0px 0px 50px 0px;
    text-align: center;
}
.order-list-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
}

button.new {
    font-size: 1.2em;
    position: fixed;
    bottom: 0;
    right: 0;
    margin: 50px;
}

.color-selection {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}

.color-selection__qty {
    display: flex;
    align-items: center;
    margin-left: 10px;
}

.color-selection__qty button {
    width: 20px;
    text-align: center;
}

.color-selection__qty div {
    padding: 0px 5px;
}

.color-picker-container {
    display: flex;
}

.color-picker-container input {
    width: 30px;
    height: 30px;
    margin-right: 10px;
    background-color: inherit;
    border: none;
}
</style>