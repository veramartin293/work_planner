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

        <div class="order-detail__uniforms" v-if="orderUniforms.length !== 0">
            <h2>Uniformes de la orden</h2>
            <table class="order-detail__uniforms-table">
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
                        <button class="btn-blue">Editar</button>
                        <button class="btn-red">Eliminar</button>
                    </td>
                </tr>
            </table>
        </div>
       
    </section>
</template>

<script>
export default {
    data() {
        return {
            order: null,
            orderUniforms: [],
            error: {
                state: false,
                message: ''
            }
        }
    },
    created() {
        this.getOrderDetail();
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

.order-detail__uniforms h2 {
    text-align: center;
    margin: 40px 0px;
}

.order-detail__uniforms-table {
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

</style>