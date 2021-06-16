<template>
    <section class="order-detail">
        <div class="order-detail__header">
            <h1>Detalle De La Orden</h1>
            <router-link to="/" class="info-link">Regresar a la lista de órdenes</router-link>
        </div>
        
        <p v-if="error.state">{{error.message}}</p>

        <div v-if="order" class="order-detail__content">
            <div class="order-detail__image">
                <img :src="`/storage/${order.logo}`" alt="logo">
            </div>
            <div class="order-detail__info">
                <h2>{{ order.team_name }}</h2>
                <p><strong>Fecha de creación: </strong>{{ order.date }}</p>
                <p><strong>Tipografía: </strong>{{ order.typography }}</p>
                <p><strong>Colores: </strong>{{ order.colors }}</p>
                <p><strong>Estatus: </strong><em>{{ order.is_in_progress === true ? 'proceso' : 'finalizada'}}</em></p>
            </div>
         </div>

        <div class="order-detail-uniforms" v-if="orderUniforms.length !== 0">
            <div class="order-detail-uniforms__header">
                <h2>Uniformes de la orden</h2>
                <button @click="addUniform">Agregar nuevo</button>
            </div>
            <table class="order-detail-uniforms__table">
                <tr>
                    <th>Número</th>
                    <th>Leyenda</th>
                    <th>Talla</th>
                    <th></th>
                </tr>

                <tr v-for="uniform in orderUniforms" :key="uniform.id">
                    <td>{{ uniform.number }}</td>
                    <td>{{ uniform.legend }}</td>
                    <td>{{ uniform.size }}</td>
                    <td>
                        <button class="btn-blue" @click="editUniform(uniform)">Editar</button>
                        <button class="btn-red">Eliminar</button>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Modal for form -->
        <base-modal v-if="showForm" @closeForm="cancelForm">
            <base-form @submitClicked="submitForm" @formCanceled="cancelForm">
                <template v-slot:form-legend>
                    <legend>{{ formLegend }}</legend>
                </template>

                <template v-slot:form-body>
                    <div class="form-field">
                        <label for="number">número:</label>
                        <input type="number" v-model="uniform.number" />
                        <p class="form-error" v-if="formErrors.number">{{ formErrors.number[0] }}</p>
                    </div>
                    <div class="form-field">
                        <label for="legend">leyenda:</label>
                        <input type="text" v-model="uniform.legend" />
                        <p class="form-error" v-if="formErrors.legend">{{ formErrors.legend[0] }}</p>
                    </div>
                    <div class="form-field">
                        <label for="size">size:</label>
                        <select name="size" id="size" v-model="uniform.size">
                            <option value="CH">CH</option>
                            <option value="M">M</option>
                            <option value="G">G</option>
                        </select>
                        <p class="form-error" v-if="formErrors.size">{{ formErrors.size[0] }}</p>
                    </div>
                </template>
            </base-form>
        </base-modal>
       
    </section>
</template>

<script>
import performApiCall from '../../apiFactory.js';

export default {
    data() {
        return {
            order: null,
            orderUniforms: [],
            uniform: {
                order_id: null,
                legend: '',
                number: '',
                size: ''
            },
            previousUniform: {},
            error: {
                state: false,
                message: ''
            },
            showForm: false,
            formMode: 'create',
            formErrors: {}
        }
    },
    created() {
        this.getOrderDetail();
    },
    computed: {
        formLegend() {
            return this.formMode === 'create' ? 'Agregar nuevos uniformes' : 'Editar uniforme existente';
        }
    },
    watch: {
        order(val) {
            this.uniform.order_id = val.id;
        }
    },
    methods: {
        async getOrderDetail() {
            const orderId = this.$route.params.id;
            const response = await fetch(`/api/orders/${orderId}`);
            const responseData = await response.json();

            if (response.ok) {
                this.order = responseData;
                this.getOrderUniforms();
            } else {
                this.error.state = true;
                this.error.message = responseData.error;
            }
        },
        async getOrderUniforms() {
            const orderId = this.$route.params.id;
            const response = await fetch(`/api/uniforms/${orderId}`);
            const responseData = await response.json();

            if (response.ok) {
                this.orderUniforms = responseData;
            } else {
                this.error.state = false;
                this.error.message = responseData.error;
            }
        },
        addUniform() {
            this.formMode = 'create';
            this.showForm = true;
        },
        editUniform(uniform) {
            this.uniform = uniform;
            this.formMode = 'edit';
            this.showForm = true;
            this.previousUniform = JSON.parse(JSON.stringify(uniform));
        },
        cancelForm() {
            this.showForm = false;
            this.resetUniformValues();
            if (this.formMode === 'edit') {
                const uniform = this.orderUniforms.find (el => el.id === this.previousUniform.id);
                uniform.legend = this.previousUniform.legend;
                uniform.number = this.previousUniform.number;
                uniform.size = this.previousUniform.size;
            }
        },
        resetUniformValues() {
            this.uniform = {
                order_id: null,
                legend: '',
                number: '',
                size: ''
            }
            this.formErrors = {};
        },
        submitForm() {
            const url = this.formMode === 'edit' ? `/api/uniforms/${this.uniform.id}` : `/api/uniforms`;
            const method = this.formMode === 'edit' ? 'PUT' : 'POST';
            const auth = true;
            const body = JSON.stringify(this.uniform);
            const contenType = 'aplication/json';

            performApiCall(url, method, auth, body, contenType)
            .then(response => {
                if (response.id) {
                    this.orderUniforms.push(this.uniform);
                    this.showForm = false;
                    this.resetUniformValues();
                } else if (response.errors) {
                    this.formErrors = response.errors;
                }
            })
        }
    }

}
</script>

<style scoped>
h1 {
    font-size: 2em;
}

.order-detail__header {
    padding: 0px 0px 50px 0px;
    text-align: center;
}

.order-detail__content {
    display: flex;
    font-size: 1.5em;
    margin-bottom: 20px;
}

.order-detail__image {
    width: 50%;
}

.order-detail__info {
    width: 50%;
    margin-left: 20px;
    line-height: 40px;
}

.order-detail__info h2 {
    padding: 10px 0px;
    margin-bottom: 10px;
    letter-spacing: 5px;
}

.order-detail-uniforms h2 {
    text-align: center;
    margin: 40px 0px;
}

.order-detail-uniforms__table {
    font-size: 1.2em;
    text-transform: capitalize;
    width: 100%;
    border-spacing: 0px;
}

th, td {
    text-align: center;
    padding: 10px 0px;
    border-bottom: 1px solid black;
}

td:last-child {
    width: 20%;
    text-align: center;
}

td:last-child button {
    margin: 0px 5px;
}


img {
    width: 100%;
}

.order-detail-uniforms__header {
    display: flex;
    align-items: center;
    justify-content: center;
}

.order-detail-uniforms__header button {
    margin-left: 10px;
}

</style>